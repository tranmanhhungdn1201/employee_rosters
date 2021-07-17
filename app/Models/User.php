<?php

namespace App\Models;

use App\Models\UserType;
use App\Models\Branch;
use Illuminate\Notifications\Notifiable;
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
        'first_name',
        'last_name',
        'gender',
        'user_type_id',
        'birth_date',
        'hire_date',
        'branch_id',
    ];

    protected $appends = [
        'full_name',
        'branch_name'
    ];

    public function user_type() {
        return $this->hasOne(UserType::class, 'id', 'user_type_id');
    }

    public function branch() {
        return $this->hasOne(Branch::class, 'id', 'branch_id');
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

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

    public function isStaff() {
        $arr = [Config::get('constants.user.manager'), Config::get('constants.user.admin')];
        if(!in_array($this->user_type_id, $arr)) {
            return true;
        }
        return false;
    }

    public function isRegisted() {
        $arr = [Config::get('constants.user.manager'), Config::get('constants.user.admin')];
        if(!in_array($this->user_type_id, $arr)) {
            return true;
        }
        return false;
    }

    public function getUserTypeNameAttribute()
    {
        $userType = $this->user_type;
        return $this->attributes['user_type_name'] = empty($userType) ? '' : $userType->name;
    }

    public function getBranchNameAttribute()
    {
        return $this->branch->name;
    }
}
