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
}
