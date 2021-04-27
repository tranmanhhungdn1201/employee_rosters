<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shift;
use App\Models\UserShift;
use DB;
use Carbon\Carbon;
use Config;

class ShiftController extends Controller
{
    public function getShiftById($id){
        if(empty($id)) 
            return response()->json([
                'Status' => 'Fail',
                'Message' => 'Undefined id:'
            ]);

        $shift = Shift::with(['userShifts' => function ($query) {
                $query->with('user');
            }])
        ->where('id', $id)->first();

        return response()->json([
            'Status' => 'Success',
            'Data' => $shift,
            'Message' => 'Get shift successfully'
        ]);
    }

    public function updateAmountShift(Request $request, $id){
        $rs = Shift::find($id)->update([
            'status' => $request->status,
            'amount' => $request->amount,
        ]);
        if(!$rs) 
            return response()->json([
                'Status' => 'Fail',
                'Message' => 'Update shift fail'
            ]);

        return response()->json([
            'Status' => 'Success',
            'Message' => 'Update shift successfully'
        ]);
    }

    public function updateTimeShift(Request $request){
        $rs = Shift::where([
                ['time_start', '=', substr($request->shift_time, 0, 8)],
                ['time_finish', '=', substr($request->shift_time, -8)]
            ])->update([
            'time_start' => $request->shift_start,
            'time_finish' => $request->shift_finish,
            'user_type_id' => $request->type
        ]);
        if(!$rs) 
            return response()->json([
                'Status' => 'Fail',
                'Message' => 'Update shift fail'
            ]);

        return response()->json([
            'Status' => 'Success',
            'Message' => 'Update shift successfully'
        ]);
    }

    public function addShift(Request $request) {
        $dataShift = $request->all();
        for($i = 0; $i < 7; $i++) {
            $date = Carbon::createFromFormat('Y-m-d',  $dataShift['timeStart'])->addDays($i);
            $data = [
                'roster_id' => $dataShift['idRoster'],
                'time_start' => $dataShift['shift_start'],
                'time_finish' => $dataShift['shift_finish'],
                'user_type_id' => $dataShift['type'],
                'date' => $date,
                'amount' => $dataShift['day_' . $i],
                'status' => Config::get('constants.status_shift.OPEN'), 
            ];
            Shift::create($data);
        }
        return response()->json([
            'Status' => 'Success',
            'Message' => 'Add shift successfully'
        ]);
    }
    
    public function delShift(Request $request){
        $shiftID = $request->shiftID;
        $shiftFirst = Shift::find($shiftID);
        $timeStart = $shiftFirst->time_start;
        $timeFinish = $shiftFirst->time_finish;
        $rs = Shift::where([
            ['time_start', '=', $timeStart],
            ['time_finish', '=', $timeFinish]
        ])->delete();

        if($rs) {
            return response()->json([
                'Status' => 'Success',
                'Message' => 'Del shift successfully'
            ]);
        }

        return response()->json([
            'Status' => 'Fail',
            'Message' => 'Del shift fail'
        ]);
    }

    public function registerShift($id) {
        $shift = Shift::find($id);
        if($shift->status === Config::get('constants.status_shift.OPEN')) {
            $data = [
                'shift_id' => $id,
                'user_id' => auth()->user()->id,
                'status' => Config::get('constants.status_shift_user.OPEN'),
                'work_time' => $shift->workTime(),
            ];
            UserShift::create($data);

            return response()->json([
                'Status' => 'Success',
                'Message' => 'Register shift successfully'
            ]);
        }

        return response()->json([
            'Status' => 'Fail',
            'Message' => 'Register shift fail'
        ]);
    }
}
