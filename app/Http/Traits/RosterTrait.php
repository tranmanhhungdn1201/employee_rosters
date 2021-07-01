<?php
namespace App\Http\Traits;

use App\Models\Roster;
use Config;
use Carbon\Carbon;

trait RosterTrait {

    public function checkAllRoster() {
        $date = Carbon::now()->format('Y-m-d H:i:00');
        //open
        Roster::where(function($query) use ($date) {
            //open
            $query->where('time_close', '>=', $date)
            ->where('time_open', '<=', $date)
            ->where('status', Config::get('constants.status_roster.OPEN'))
            ->update(['status' => Config::get('constants.status_roster.OPEN')]);
            //close
            $query->where('time_close', '<=', $date)
            ->where('status', Config::get('constants.status_roster.CLOSE'))
            ->update(['status' => Config::get('constants.status_roster.CLOSE')]);
            //pending
            $query->where('time_open', '>=', $date)
            ->where('time_close', '<=', $date)
            ->where('status', Config::get('constants.status_roster.PENDING'))
            ->update(['status' => Config::get('constants.status_roster.PENDING')]);
        });

        return true;
    }

    public function checkRosterById($id) {
        if(empty($id) || $id === 'undefined') return;
        $date = Carbon::createFromFormat('Y-m-d H:i:00', date('Y-m-d H:i:00'));
        
        $roster = Roster::find($id);
        $timeOpen = Carbon::createFromFormat('Y-m-d H:i:s',  $roster->time_open);
        $timeClose = Carbon::createFromFormat('Y-m-d H:i:s',  $roster->time_close);
        //open
        if($date->between($timeOpen, $timeClose) && $roster->status !== Config::get('constants.status_roster.OPEN')) {
            $roster->update(['status' => Config::get('constants.status_roster.OPEN')]);
            return Config::get('constants.status_roster.OPEN');
        }
        //close
        if($timeClose->lessThanOrEqualTo($date) && $roster->status !== Config::get('constants.status_roster.CLOSE')) {
            $roster->update(['status' => Config::get('constants.status_roster.CLOSE')]);
            return Config::get('constants.status_roster.CLOSE');
        }
        //pending
        if($date->lessThanOrEqualTo($timeOpen) && $date->lessThanOrEqualTo($timeClose) && $roster->status !== Config::get('constants.status_roster.PENDING')) {
            $roster->update(['status' => Config::get('constants.status_roster.PENDING')]);
            return Config::get('constants.status_roster.PENDING');
        }

        return true;
    }
}