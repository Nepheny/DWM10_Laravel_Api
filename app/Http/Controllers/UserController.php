<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User as User;
// use Illuminate\Support\Facades\DB; -> $user = DB::table('users')->where('id', $request->id)->first();
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getAll()
    {
        return User::all();
    }

    public function getOne(Request $request)
    {
        if($request->input('id') !== null) {
            $user = User::find($request->input('id'));
            if($user !== null) {
                return $user;
            }
        }
        return response()->json([
            'error' => 'Cannot find user',
            'errorMessage' => 'Wrong data send inside request or no user match this id'
        ]);

        /*
        $user = User::find($request->input('id'));
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
        */
    }

    public function insertOne(Request $request)
    {
        if($request->input('name') !== null) {
            // TODO: find a solution less greedy
            if(User::where('name', $request->input('name'))->get()->first() === null) {
                $newUser = new User();
                $newUser->name = $request->input('name');
                $password = str_random(15);
                $newUser->password = bcrypt($password);
                $newUser->save();
                return response()->json([
                    'success' => 'New user inserted',
                    'successMessage' => $password
                ]);
            }
        }
        return response()->json([
            'error' => 'Cannot insert user',
            'errorMessage' => 'Syntax error, or the user already exists'
        ]);
    }

    public function insertMany(Request $request)
    {
        $users = [];
        if(is_array($request->input('name'))) {
            foreach($request->input('name') as $name) {
                // TODO: find a solution less greedy
                if(User::where('name', $name)->get()->first() === null) {
                    $newUser = new User();
                    $newUser->name = $name;
                    $password = str_random(15);
                    $newUser->password = bcrypt($password);
                    $newUser->save();
                    $users[] = $newUser;
                }
            }
            return response()->json([
                'success' => 'New users inserted',
                'successMessage' => $users
            ]); 
        }
        return response()->json([
            'error' => 'Cannot insert user',
            'errorMessage' => 'Syntax error, or the user already exists'
        ]);

        /*
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
        */
    }

    public function deleteOne(Request $request)
    {
        if($request->input('id') !== null) {
            $userToDelete = User::find($request->input('id'));
            if($userToDelete !== null) {
                $userToDelete->delete();
                return response()->json([
                    'success' => 'User deleted',
                    'successMessage' => 'User deleted'
                ]);
            }
        }
        return response()->json([
            'error' => 'Cannot delete user',
            'errorMessage' => 'Syntax error, or the user id doesn\'t exists'
        ]);
    }

    /*
    public function deleteMany(Request $request)
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
    */

    public function updateOne(Request $request, $id)
    {
        $name = $request->input('name');
        if($request->input('name') !== null) {
            $user = User::find($id);
            if($user !== null) {
                $newName = $name;
                $user->name = $newName;
                $user->save();
                return response()->json([
                    'success' => 'User updated',
                    'successMessage' => User::find($id)
                ]);
            }
        }
        return response()->json([
            'error' => 'Cannot update user',
            'errorMessage' => 'Syntax error, or the user id doesn\'t exists'
        ]);
        /*
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
        */
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
