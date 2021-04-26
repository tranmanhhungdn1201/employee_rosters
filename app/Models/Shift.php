<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    
    public function userShifts(){
        return $this->hasMany(UserShift::class);
    }
}
