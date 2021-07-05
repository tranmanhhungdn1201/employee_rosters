<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\UserType;
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
        'user_type_name'
    ];
    
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
}
