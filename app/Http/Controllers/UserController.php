<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User as User;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getAll()
    {
        return User::all();
    }

    public function getOne(Request $request)
    {
        // $user = DB::table('users')->where('id', $request->id)->first();
        $user = User::find($request->id);
        if($user == null) {
            return response([
                'status' => 'error',
                'msg'    => 'Invalid credentials'
            ], 400);
        } else {
            return response([
                'status' => 'success',
                'data'   => $user
            ], 200);
        }
    }

    public function insert(Request $request)
    {
        $users = [];
        for($i = 0; $i < count($request->name); $i++) {
            $user = new User;
            $user->name = $request->name[$i];
            $user->password = bcrypt($request->password[$i]);
            $user->save();
            $users[$i] = $user;
        }
        return response([
            'status' => 'insert successfull',
            'data'   => $users
        ], 200);
    }

    public function delete(Request $request)
    {
        for($i = 0; $i < count($request->id); $i++){
            $id = $request->id[$i];
            $user = User::find($id);
            if($user == null) {
                return response([
                    'status' => 'error',
                    'msg'    => 'Invalid credentials'
                ], 400);
            } else {
                User::destroy($request->id[$i]);
            }
        }
        return response([
            'status' => 'delete successfull',
            'data'   => User::all()
        ], 200);
    }

    public function updateOne(Request $request)
    {
        $user = User::find($request->id);
        if($user == null) {
            return response([
                'status' => 'error',
                'msg'    => 'Invalid credentials'
            ], 400);
        } else {
            $user->name = $request->name;
            $user->password = bcrypt($request->password);
            $user->save();
            return response([
                'status' => 'update successfull',
                'data'   => $user
            ], 200);
        }
    }

    public function connect(Request $request)
    {
        $user = User::find($request->id);
        if($request->name == $user->name && Hash::check($request->password, $user->password) == true) {
            return response([
                'status' => 'you are connected',
                'data'   => $user
            ], 200);
        } else {
            return response([
                'status' => 'error',
                'msg'    => 'Invalid name or password'
            ], 400);
        }
    }
}
