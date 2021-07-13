<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\UserType;
use App\Models\Roster;
class Shift extends Model
{
    protected $table = 'shifts';

    protected $fillable = [
        'roster_id',
        'time_start',
        'time_finish',
        'user_type_id',
        'date',
        'user_created_id',
        'amount',
        'status',
    ];

    protected $appends = [
        'isRegistered',
        'user_type_name',
        'is_pm'
    ];

    public function roster(){
        return $this->belongsTo(Roster::class, 'roster_id', 'id');
    }

    public function userShifts(){
        return $this->hasMany(UserShift::class);
    }

    public function userType(){
        return $this->belongsTo(UserType::class, 'user_type_id', 'id');
    }

    public function workTime(){
        $start = Carbon::parse($this->time_start);
        $end = Carbon::parse($this->time_finish);
        $hours = $end->diffInHours($start);

        return $hours;
    }

    public function getIsRegisteredAttribute()
    {
        $isRegistered = $this->userShifts->contains('user_id', auth()->user()->id);
        return $this->attributes['isRegistered'] = $isRegistered;
    }

    public function getUserTypeNameAttribute()
    {
        $userType = $this->userType;
        return $this->attributes['user_type_name'] = empty($userType) ? '' : $userType->name;
    }

    public function getIsPmAttribute() {
        $start = (int) substr($this->time_start, 0, 2);
        $end = (int) substr($this->time_finish, 0, 2);
        if($start > 12 && $end > 12) {
            return true;
        }

        return false;
    }
}
