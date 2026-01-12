<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use App\Models\Player;
use App\Models\Team;
use App\Models\PlayerTransfer;

class PlayerTransferController extends Controller {

    public function index() {

        $teams = Team::where('active', '1')
            ->where('team_status', 'approved')
            ->orderBy('name')
            ->get();

        return view('site.transfer-request.index', [
            'teams' => $teams,
        ]);

    }


    public function store(Request $request) {

        $validator = Validator::make($request->all(), [
            'from_team_id' => 'required|exists:teams,id',
            'player_id' => 'required|exists:players,id',
            'to_team_id' => 'required|exists:teams,id|different:from_team_id',
            'transfer_notes' => 'nullable|string|max:500',
        ], [
            'to_team_id.different' => 'You cannot transfer to the same team.',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ]);

        }



        $player = Player::with('team')
            ->where('id', $request->player_id)
            ->where('team_id', $request->from_team_id)
            ->where('player_status', '1')
            ->first();

        if (!$player) {

            return response()->json([
                'status' => 'error',
                'message' => 'Player not found or not active in the selected team.'
            ]);

        }

        $existingTransfer = PlayerTransfer::where('player_id', $request->player_id)
            ->where('transfer_status', 'pending')
            ->first();

        if ($existingTransfer) {
            return response()->json([
                'status' => 'error',
                'message' => 'You already have a pending transfer request. Please wait for approval before submitting another request.'
            ]);
        }

        $toTeam = Team::find($request->to_team_id);

        if (!$toTeam) {
            return response()->json([
                'status' => 'error',
                'message' => 'Destination team not found or not active.'
            ]);
        }

        $fromTeam = Team::find($request->from_team_id);

        $transfer = PlayerTransfer::create([
            'player_id' => $request->player_id,
            'from_team_id' => $request->from_team_id,
            'to_team_id' => $request->to_team_id,
            'transfer_notes' => $request->transfer_notes,
            'transfer_status' => 'pending',
            'approved_at' => null,
            'approved_by' => null,
        ]);

        if ($player->email) {
            #Mail::to($player->email)->send(new TransferRequestSubmitted($transfer, $player));
        }

        #$this->sendTeamManagerNotifications($transfer, $player, $fromTeam, $toTeam);

        return response()->json([
            'status' => 'success',
            'message' => 'Transfer request submitted successfully! Confirmation emails have been sent to you and the team managers.',
            'transfer_id' => $transfer->id
        ]);

    }


    private function sendTeamManagerNotifications($transfer, $player, $fromTeam, $toTeam) {

        try {

            $fromTeamManagerEmail = $this->getTeamManagerEmail($fromTeam->team_id);
            $toTeamManagerEmail = $this->getTeamManagerEmail($toTeam->team_id);

            $emails = array_filter([$fromTeamManagerEmail, $toTeamManagerEmail]);

            foreach ($emails as $email) {
                Mail::to($email)->send(new TransferRequestNotification($transfer, $player, $fromTeam, $toTeam));
            }

        } catch (\Exception $e) {

        }
    }


    private function getTeamManagerEmail($teamId) {
        $team = Team::find($teamId);
        return $team->manager_email;
    }


    public function transferRequest() {

        $transfer_requests = PlayerTransfer::where('transfer_status', 'pending')
            ->get();

        return view('admin.transfer-request.index', [
            'transfer_requests' => $transfer_requests,
        ]);

    }


    public function transferRequests(Request $request) {

        $status = $request->get('status', 'pending');

        // Get counts for stats
        $pendingCount = PlayerTransfer::where('transfer_status', 'pending')->count();
        $approvedCount = PlayerTransfer::where('transfer_status', 'approved')->count();
        $rejectedCount = PlayerTransfer::where('transfer_status', 'rejected')->count();
        $totalCount = PlayerTransfer::count();

        // Get transfers with relationships
        $query = PlayerTransfer::with(['player', 'fromTeam', 'toTeam']);

        // Filter by status if not 'all'
        if ($status !== 'all') {
            $query->where('transfer_status', $status);
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('player', function($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%");
                })->orWhereHas('fromTeam', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhereHas('toTeam', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhere('transfer_notes', 'like', "%{$search}%");
            });
        }

        // Order by latest
        $query->orderBy('created_at', 'desc');

        // Paginate results
        $transfer_requests = $query->get();

        return view('admin.transfer-request.index', [
            'transfer_requests' => $transfer_requests,
            'pendingCount' => $pendingCount,
            'approvedCount' => $approvedCount,
            'rejectedCount' => $rejectedCount,
            'totalCount' => $totalCount,
            'status' => $status
        ]);
    }

    public function processTransfer(Request $request, $id) {

        $transfer = PlayerTransfer::with(['player', 'fromTeam', 'toTeam'])->findOrFail($id);

        $action = $request->input('action');

        if ($action === 'approved') {
            return $this->approveTransfer($transfer);
        } elseif ($action === 'rejected') {
            $request->validate([
                'rejection_reason' => 'required|string|max:500'
            ]);
            return $this->rejectTransfer($transfer, $request->rejection_reason);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid action'
        ], 400);
    }


    private function approveTransfer($transfer) {
        DB::beginTransaction();
        try {
            // Update transfer status
            $transfer->update([
                'transfer_status' => 'approved',
                'approved_at' => now(),
                'approved_by' => auth()->id()
            ]);

            // Update player's team
            $transfer->player->update([
                'team_id' => $transfer->to_team_id
            ]);

            // Send approval emails
            $this->sendTransferResultEmails($transfer, 'approved');

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transfer request approved successfully.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error approving transfer: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to approve transfer request.'
            ], 500);
        }
    }


    private function rejectTransfer($transfer, $reason) {
        try {
            $transfer->update([
                'transfer_status' => 'rejected',
                'transfer_notes' => $transfer->transfer_notes . "\n\nRejection Reason: " . $reason
            ]);

            // Send rejection emails
            $this->sendTransferResultEmails($transfer, 'rejected', $reason);

            return response()->json([
                'success' => true,
                'message' => 'Transfer request rejected successfully.'
            ]);

        } catch (\Exception $e) {
            \Log::error('Error rejecting transfer: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to reject transfer request.'
            ], 500);
        }
    }




}
