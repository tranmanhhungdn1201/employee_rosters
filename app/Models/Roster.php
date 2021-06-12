<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Config;
class Roster extends Model
{
    public $timestamps = true;

    protected $table = 'rosters';

    protected $fillable = [
        'day_start',
        'day_finish',
        'time_open',
        'time_close',
        'status',
        'user_created_id',
        'user_updated_id',
        'branch_id',
    ];

    protected $appends = [
        'status_name',
        'user_created_name',
    ];

    public function getStatusNameAttribute()
    {
        $status = Config::get('constants.status_roster_name');
        return $status[$this->status];
    }

    public function getUserCreatedNameAttribute()
    {
        $user = User::find($this->user_created_id);
        return empty($user->full_name) ? '' : $user->full_name ;
    }

    public function setUserCreatedIdAttribute()
    {
        $this->attributes['user_created_id'] = auth()->user()->id;
    }

    public function setUserUpdatedIdAttribute()
    {
        $this->attributes['user_updated_id'] = auth()->user()->id;
    }

    public function isAuthor() {
        $authID = auth()->user()->id;
        if($authID === $this->user_created_id) {
            return true;
        }
        return false;
    }
}
