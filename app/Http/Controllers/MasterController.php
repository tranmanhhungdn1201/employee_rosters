<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;

class MasterController extends Controller
{
    public function index(){
        $branches = Branch::all();
        return response()->view('listBranch', ['branches' => $branches]);
    }

}
