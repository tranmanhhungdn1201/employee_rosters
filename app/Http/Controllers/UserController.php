<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(){
        return view('login');
    }

    public function postlogin(Request $request){
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {

            return redirect()->intended('/');
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
