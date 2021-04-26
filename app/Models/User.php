<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Config;

class User extends Authenticatable
{
    use Notifiable;

    protected $rememberTokenName = false;

    protected $fillable = [
        'username',
        'phone',
        'password',
        'phone',
        'first_name',
        'last_name',
        'gender',
        'user_type_id',
        'birth_date',
        'hire_date',
        'branch_id',
    ];
    
    public function isAdmin() {
        if($this->user_type_id === Config::get('constants.user.admin')) {
            return true;
        }
        
        return false;
    }

    public function isManager() {
        if($this->user_type_id === Config::get('constants.user.manager')) {
            return true;
        }
        return false;
    }

}
