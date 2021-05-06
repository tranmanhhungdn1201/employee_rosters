<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roster;
use App\Models\Shift;
use Config;
use Carbon\Carbon;
use DB;

class RosterController extends Controller
{
    public function listRoster($branchID){
        $rosters = Roster::where('branch_id', $branchID)->get();
        return response()->view('listRoster', ['rosters' => $rosters]);
    }

    public function viewCreateRoster(Request $request){
        return response()->view('create_roster');
    }

    public function createRoster(Request $request){
        $dataRoster = $request->dataRoster;
        $timeStart = $request->timeStart;
        $timeOpen = $request->timeOpen;
        $dataR = [
            'day_start' => $timeStart['timeStart'],
            'day_finish' => $timeStart['timeFinish'],
            'time_open' => $timeOpen['timeOpen'],
            'time_close' => $timeOpen['timeClose'],
            'status' => Config::get('constants.status_roster.PENDING'),
            'user_created_id' => auth()->user()->id,
            'user_updated_id' => auth()->user()->id,
            'branch_id' => 1       
        ];
        DB::beginTransaction();
        $rosterId = null;
        try {
            //create roster and get id
            $rosterId = Roster::insertGetId($dataR);
            if(empty($rosterId)) {
                DB::rollBack();
                return response()->json([
                    'Status' => 'Fail',
                    'Message' => 'Create roster fail'
                ]);
            }

            //create shifts and get id
            foreach($dataRoster as $shift) {
                for($i = 0; $i < 7; $i++) {
                    $date = Carbon::createFromFormat('Y-m-d',  $timeStart['timeStart'])->addDays($i);
                    $data = [
                        'roster_id' => $rosterId,
                        'time_start' => $shift['shift_start'],
                        'time_finish' => $shift['shift_finish'],
                        'user_type_id' => $shift['type'],
                        'date' => $date,
                        'amount' => $shift['day_' . $i],
                        'status' => Config::get('constants.status_shift.OPEN'),
                        'user_created_id' => auth()->user()->id, 
                    ];
                    Shift::create($data);
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'Status' => 'Fail',
                'Message' => $e->getMessage()
            ]);
        }
        
        return response()->json([
            'Status' => 'Success',
            'Message' => 'Create roster successfully',
            'rosterID' => $rosterId,
        ]);
    }

    public function singleRoster($id){
        if(empty($id)) return;
        $roster = Roster::find($id);
        if(empty($roster)) return redirect()->back();
        $shifts = $this->getDataShift($id);
        $shifts = $this->formatDataShift($shifts);

        return response()->view('single_roster', [
            'roster' => $roster,
            'shifts' => $shifts
        ]);
    }

    public function getDataShift($rosterId){
        if(empty($rosterId)) return;
        $shifts = Shift::withCount('userShifts')
        ->where('roster_id', $rosterId)
        ->orderBy('time_start', 'asc')
        ->orderBy('date', 'asc')
        ->get();
        return $shifts;
    }

    public function formatDataShift($shifts){
        $data = array();
        $length = count($shifts);
        $lengthShift = $length/7;
        for($i = 0; $i < $lengthShift; $i++) {
            $time = $shifts[7 * $i]->time_start .' - '. $shifts[7 * $i]->time_finish;
            $data[$time] = array();
            for($j = 7*$i; $j < 7*($i + 1); $j++) {
                array_push($data[$time], $shifts[$j]);
            }
        }

        return $data;
    }
}
