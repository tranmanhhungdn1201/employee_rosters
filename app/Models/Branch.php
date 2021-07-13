<?php

namespace App\Models;

use App\Models\UserType;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table = 'branches';

    protected $fillable = [
        'name',
        'description',
    ];

    public function userTypes() {
        return $this->hasMany(UserType::class, 'branch_id', 'id');
    }
}
