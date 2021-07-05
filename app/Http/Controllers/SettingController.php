<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index() {
        $branches = Branch::all();
        return response()->view('setting', ['branches' => $branches]);
    }

    public function createBranch(Request $request) {
        $data = $request->all();
        $rs = Branch::create($data);

        if($rs) {
            return response()->json([
                'Status' => 'Success',
                'Message' => 'Create branch successfully',
            ]);
        }

        return response()->json([
            'Status' => 'Success',
            'Message' => 'Create branch fail',
        ]);
    }

    public function updateBranch(Request $request) {
        $data = $request->all();
        $branch = Branch::find($data['branch_id']);

        if($branch) {
            $branch->update($data);
            return response()->json([
                'Status' => 'Success',
                'Message' => 'Update branch successfully',
            ]);
        }

        return response()->json([
            'Status' => 'Success',
            'Message' => 'Update branch fail',
        ]);
    }

    public function createUserType(Request $request) {
        $data = $request->all();
        dd($data);
        $rs = UserType::create($data);

        if($rs) {
            return response()->json([
                'Status' => 'Success',
                'Message' => 'Create User Type successfully',
            ]);
        }

        return response()->json([
            'Status' => 'Success',
            'Message' => 'Create User Type fail',
        ]);
    }

    public function updateUserType(Request $request) {
        $data = $request->all();
        dd($data);
        $userType = UserType::find($data['branch_id']);

        if($userType) {
            $userType->update($data);
            return response()->json([
                'Status' => 'Success',
                'Message' => 'Update User Type successfully',
            ]);
        }

        return response()->json([
            'Status' => 'Success',
            'Message' => 'Update User Type fail',
        ]);
    }

    public function getAllBranch() {
        $rs = Branch::with('userTypes')->get();

        return response()->json([
            'Status' => 'Success',
            'Data' => $rs,
        ]);
    }
}
