<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserShift extends Model
{
    protected $table = 'user_shifts';

    protected $fillable = [
        'shift_id',
        'user_id',
        'status',
        'work_time',
        'note'
    ];

    public function user(){
        return $this->hasOne(User::class, 'id',  'user_id');
    }
}
