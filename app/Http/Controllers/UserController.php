<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User as User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getAll()
    {
        return response()->json([
            'success' => 'Users',
            'successMessage' => User::all()->load('roles')
        ]);
    }

    public function getOne(Request $request)
    {
        if($request->input('id') !== null) {
            $user = User::find($request->input('id'));
            if($user !== null) {
                $user->load('roles');
                return $user;
            }
        }
        return response()->json([
            'error' => 'Cannot find user',
            'errorMessage' => 'Wrong data send inside request or no user match this id'
        ]);
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
                $newUser->roles()->attach($request->input('role_id') !== null ? $request->input('role_id') : 5);
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
    }

    public function deleteOne(Request $request)
    {
        if($request->input('id') !== null) {
            $userToDelete = User::find($request->input('id'));
            if($userToDelete !== null) {
                $userToDelete->delete();
                return response()->json([
                    'success' => 'User deleted',
                    'successMessage' => ''
                ]);
            }
        }
        return response()->json([
            'error' => 'Cannot delete user',
            'errorMessage' => 'Syntax error, or the user id doesn\'t exists'
        ]);
    }

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
    }
}
