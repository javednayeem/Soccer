<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;

use App\Models\Player;
use App\Models\Contribution;
use App\Models\Team;

class ContributionController extends Controller {

    public function __construct() {

    }


    public function index() {

        $teams = Team::where('active', '1')->get();

        $players = Player::with('team')
            ->where('player_status', '1')
            ->orderBy('team_id')
            ->orderBy('first_name')
            ->get();

        return view('admin.contribution.index', [
            'teams' => $teams,
            #'players' => $players,
        ]);

    }


    public function insertAttendanceContribution(Request $request) {

        $created_by = Auth::user()->id;
        $data = $request->input('params');

        $amount = $data['amount'];
        $player_ids = $data['players'];

        $created_at = date("Y-m-d ", strtotime($data['attendance_date'])) . date('H:i:s');

        DB::beginTransaction();

        try {

            foreach ($player_ids as $player_id) {

                Contribution::create([
                    'player_id' => $player_id,
                    'amount' => $amount,
                    'created_by' => $created_by,
                    'created_at' => $created_at,
                    'updated_at' => $created_at,
                ]);
            }

            DB::commit();
            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {

            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function viewContribution() {

        $contribution_year = date('Y');
        $team_id = null;

        return $this->renderContribution($contribution_year, $team_id);
    }


    public function generateContributionReport(Request $request) {

        $contribution_year = $request->input('contribution_year');
        $team_id = $request->input('team_id');

        return $this->renderContribution($contribution_year, $team_id);
    }


    public function renderContribution($contribution_year, $team_id = null) {

        $teams = Team::where('active', '1')->get();

        $contributionAmountPerMonth = $this->contributionAmountPerMonth(
            $contribution_year,
            $team_id
        );

        return view('admin.contribution.view', [
            'teams' => $teams,
            'contribution_year' => $contribution_year,
            'contributionAmountPerMonth' => $contributionAmountPerMonth,
        ]);
    }


    private function contributionAmountPerMonth($year = null, $team_id = null) {

        if ($year == null) {
            $year = date('Y');
        }

        $playersQuery = Player::query();

        if ($team_id) {
            $playersQuery->where('team_id', $team_id);
        }

        $players = $playersQuery->get();

        $result = [];

        foreach ($players as $player) {

            // Initialize months
            $months = [];
            $attendance = [];

            for ($i = 1; $i <= 12; $i++) {
                $months[$i] = 0;
                $attendance[$i] = 0;
            }

            // Get contribution data
            $contributions = DB::select("
            SELECT 
                MONTH(created_at) AS month,
                SUM(amount) AS total
            FROM contributions
            WHERE 
                player_id = ?
                AND YEAR(created_at) = ?
            GROUP BY MONTH(created_at)
        ", [$player->id, $year]);

            foreach ($contributions as $row) {
                $months[$row->month] = $row->total;
                $attendance[$row->month] = 1; // Paid
            }

            $result[] = [
                'name' => $player->full_name,
                'monthsString' => implode(',', $months),
                'attendanceString' => implode(',', $attendance),
            ];
        }

        return $result;
    }

}
