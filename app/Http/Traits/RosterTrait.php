<?php
namespace App\Http\Traits;

use App\Models\Roster;
use Config;
use Carbon\Carbon;

trait RosterTrait {

    public function checkAllRoster() {
        $date = Carbon::now()->format('Y-m-d H:i:00');
        // $date = Carbon::createFromFormat('Y-m-d H:i:s',  '2021-05-05 15:30:00');
        Roster::where('time_open', '>=', $date)->where('status', '=', Config::get('constants.status_roster.PENDING'))->update(['status' => Config::get('constants.status_roster.OPEN')]);
        Roster::where('time_close', '<=', $date)->where('status', '=', Config::get('constants.status_roster.OPEN'))->update(['status' => Config::get('constants.status_roster.CLOSE')]);

        return true;
    }

    public function checkRosterById($id) {
        if(empty($id) || $id === 'undefined') return;
        $date = Carbon::createFromFormat('Y-m-d H:i:00', date('Y-m-d H:i:00'));
        
        $roster = Roster::find($id);
        $timeOpen = Carbon::createFromFormat('Y-m-d H:i:s',  $roster->time_open);
        $timeClose = Carbon::createFromFormat('Y-m-d H:i:s',  $roster->time_close);
        if($timeClose->lessThanOrEqualTo($date) && $roster->status !== Config::get('constants.status_roster.CLOSE')) {
            $roster->update(['status' => Config::get('constants.status_roster.CLOSE')]);
            return false;
        }
        if($timeOpen->greaterThanOrEqualTo($date) || $roster->status !== Config::get('constants.status_roster.OPEN')) {
            $roster->update(['status' => Config::get('constants.status_roster.OPEN')]);
            return true;
        }

        return true;
    }
}