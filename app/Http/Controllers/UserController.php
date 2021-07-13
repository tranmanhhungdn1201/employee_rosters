<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Roster;
use App\Models\Branch;
use Config;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\RosterTrait;
use App\Models\UserType;
use Datatables;

class UserController extends Controller
{
    use RosterTrait;

    public function login(){
        if (\Auth::check()) {
            switch(auth()->user()->user_type_id){
                case 1:
                case 2:
                    return redirect()->intended('/');
                default:
                    $branchId = auth()->user()->branch_id;

                    return redirect()->route('listRoster', $branchId);
            }
        }

        return view('login', ['isNonShowHeader' => true]);
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

                    return redirect()->route('listRoster', $branchId);
            }
        }
        $error = "Sai tên tài khoản hoặc mật khẩu. Vui longf thử lại!";
        return back()->withErrors(['error' => $error]);
    }

    public function userList(){
        $branches = Branch::all();
        $userTypes = UserType::all();

        return view('users', [
            'branches' => $branches,
            'userTypes' => $userTypes,
        ]);
    }

    public function getUserListDatatables(){
        return Datatables::of(User::with(['user_type', 'branch'])
        ->select('id', 'username', 'gender', 'first_name', 'last_name', 'branch_id', 'birth_date', 'phone', 'user_type_id')->get())
        ->addColumn('action', function($data) {
            $buttonEdit = '<button type="button" data-id="'.$data->id.'" class="btn btn-info btn-sm btn-edit"><i class="fas fa-edit"></i></button>';
            $buttonDelete = '&nbsp;<button type="button" data-id="'.$data->id.'" class="btn btn-danger btn-sm btn-remove"><i class="fas fa-trash"></i></button>';
            $button = $buttonEdit . $buttonDelete;
            if(!$data->isStaff() && !auth()->user()->isAdmin() || auth()->user()->id === $data->id) {
                $button = $buttonEdit;
            }
            return $button;
        })
        ->make(true);
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

    public function editUser(Request $request){
        $data = $request->all();
        if(!empty($data['password'])) {
            $dataUser['password'] = bcrypt($data['password']);
        }
        $dataUser = [
            'username' => $data['username'],
            'phone' => $data['phone'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'gender' => $data['sex'],
            'user_type_id' => $data['type'],
            'birth_date' => $data['birth_date'],
            'branch_id' => $data['branch_id'],
        ];
        User::find($data['user_id'])->update($dataUser);
        return response()->json([
            'Status' => 'Success',
            'Message' => 'Update user successfully'
        ]);
    }

    public function deleteUser($userID) {
        $rs = User::find($userID)->delete();
        if($rs) {
            return response()->json([
                'Status' => 'Success',
                'Message' => 'Delete user successfully'
            ]);
        }
        return response()->json([
            'Status' => 'Fail',
            'Message' => 'Delete user Fail'
        ]);
    }
}
