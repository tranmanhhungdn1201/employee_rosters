<?php
namespace App\Http\Traits;

use App\Models\UserType;

trait UserTypeTrait {

    public function getUserTypeStaff() {
        $branchId = auth()->user()->branch_id;
        $userType = UserType::where([
            ['id', '>', '2'],
            ['branch_id', '=', $branchId]
        ])->get();

        return $userType;
    }
}