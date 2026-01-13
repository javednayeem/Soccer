<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Mail;
use Auth;
use Illuminate\Support\Facades\Validator;

use App\Mail\TransferRequestSubmitted;
use App\Mail\TransferRequestNotification;
use App\Mail\TransferStatusUpdated;

use App\Models\Team;
use App\Models\Player;
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
            Mail::to($player->email)->send(new TransferRequestSubmitted($transfer, $player));
        }

        $this->sendTeamManagerNotifications($transfer, $player, $fromTeam, $toTeam);

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

        $pendingCount = PlayerTransfer::where('transfer_status', 'pending')->count();
        $approvedCount = PlayerTransfer::where('transfer_status', 'approved')->count();
        $rejectedCount = PlayerTransfer::where('transfer_status', 'rejected')->count();
        $totalCount = PlayerTransfer::count();

        $transfer_requests = PlayerTransfer::with(['player', 'fromTeam', 'toTeam'])
            ->where('transfer_status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.transfer-request.index', [
            'pendingCount' => $pendingCount,
            'approvedCount' => $approvedCount,
            'rejectedCount' => $rejectedCount,
            'totalCount' => $totalCount,
            'transfer_requests' => $transfer_requests,
        ]);
    }


    public function updateTransferStatus(Request $request) {

        $approved_by = Auth::user()->id;
        $id = $request->input('id');
        $transfer_status = $request->input('transfer_status');

        $player_transfer = PlayerTransfer::with('player', 'fromTeam', 'toTeam')->find($id);
        $player_transfer->transfer_status = $transfer_status;
        $player_transfer->approved_at = date('Y-m-d H:i:s');
        $player_transfer->approved_by = $approved_by;
        $player_transfer->save();

        if ($transfer_status === 'approved') {

            $player = Player::find($player_transfer->player_id);
            $player->team_id = $player_transfer->to_team_id;
            $player->save();

        }

        if ($player_transfer->player->email) {

            $manager_emails = ['masudulsce@gmail.com'];

            if ($player_transfer->fromTeam->manager_email) array_push($manager_emails, $player_transfer->fromTeam->manager_email);
            if ($player_transfer->toTeam->manager_email) array_push($manager_emails, $player_transfer->toTeam->manager_email);

            Mail::to($player_transfer->player->email)
                ->cc($manager_emails)
                ->bcc('explorerclepsydra@gmail.com')
                ->send(new TransferStatusUpdated($player_transfer, $transfer_status));

        }

        return response()->json([
            'status' => 'success',
            'message' => 'Teams Transfer Request ' . ucfirst($transfer_status)
        ]);

    }


    public function requestHistory() {

        $transfer_requests = PlayerTransfer::with(['player', 'fromTeam', 'toTeam', 'modifier'])
            ->where('transfer_status', '<>', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.transfer-request.history', [
            'transfer_requests' => $transfer_requests,
        ]);
    }

}