<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Roster;
use Config;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\RosterTrait;

class UserController extends Controller
{
    use RosterTrait;

    public function login(){
        return view('login');
    }

    public function postlogin(Request $request){
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            switch(auth()->user()->user_type_id){
                case 1:
                case 2:
                    return redirect()->intended('/');
                default:
                    $branchId = auth()->user()->branch_id;
                    $this->checkAllRoster();
                    $roster = Roster::where('branch_id', $branchId)
                                    ->where('status', Config::get('constants.status_roster.OPEN'))
                                    ->orderBy('created_at', 'desc')->first();
                    if(empty($roster)){
                        return view('noti')->with('content', 'Chưa có lịch đăng ký');
                    }

                    return redirect()->route('singleRoster', $roster->id);
            }
        }
        return back()->withErrors(['login' => ['Fail']]);
    }
    
    public function userList(){
        return view('users');
    }

    public function logout(){
        Auth::logout();

        return redirect('/login');
    }
    
    public function createUser(Request $request){
        $data = $request->all();
        $dataUser = [
            'username' => $data['username'],
            'password' => bcrypt($data['password']),
            'phone' => $data['phone'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'gender' => $data['sex'],
            'user_type_id' => $data['type'],
            'birth_date' => $data['birth_date'],
            'hire_date' => date("Y-m-d"),
            'branch_id' => $data['branch_id'],
        ];
        User::create($dataUser);
        return response()->json([
            'Status' => 'Success',
            'Message' => 'Create user successfully'
        ]);
    }
}
