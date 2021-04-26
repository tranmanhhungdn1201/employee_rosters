<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roster extends Model
{
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

    public function setUserCreatedIdAttribute($value)
    {
        // $this->attributes['user_created_id'] = Auth::user()->id;
        $this->attributes['user_created_id'] = 1;
    }

    public function setUserUpdatedIdAttribute($value)
    {
        // $this->attributes['user_updated_id'] = Auth::user()->id;
        $this->attributes['user_updated_id'] = 1;
    }
}
