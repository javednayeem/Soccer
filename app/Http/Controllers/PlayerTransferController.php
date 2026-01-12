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
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);

        }

        try {

            $player = Player::with('team')
                ->where('id', $request->player_id)
                ->where('team_id', $request->from_team_id)
                ->where('player_status', '1')
                ->first();

            if (!$player) {

                return response()->json([
                    'success' => false,
                    'message' => 'Player not found or not active in the selected team.'
                ], 404);

            }

            $existingTransfer = PlayerTransfer::where('player_id', $request->player_id)
                ->where('transfer_status', 'pending')
                ->first();

            if ($existingTransfer) {
                return response()->json([
                    'success' => false,
                    'message' => 'You already have a pending transfer request. Please wait for approval before submitting another request.'
                ], 409);
            }

            $toTeam = Team::where('id', $request->to_team_id)
                ->where('status', '1')
                ->first();

            if (!$toTeam) {
                return response()->json([
                    'success' => false,
                    'message' => 'Destination team not found or not active.'
                ], 404);
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
                'success' => true,
                'message' => 'Transfer request submitted successfully! Confirmation emails have been sent to you and the team managers.',
                'transfer_id' => $transfer->id
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while submitting your request. Please try again.'
            ], 500);

        }
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

}