<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    protected $table = 'user_types';

    protected $fillable = [
        'name',
        'branch_id',
        'description',
    ];
}
