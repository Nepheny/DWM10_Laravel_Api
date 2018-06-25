<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User as User;

class UserController extends Controller
{
    public function getAll()
    {
        return User::all();
    }

    public function getOne(Request $request)
    {
        $user = User::find($request->id);
        return response([
            'status' => 'success',
            'data'   => $user
        ], 200);
    }

    public function insertOne(Request $request)
    {
        $user = new User;
        $user->name = $request->name;
        $user->password = bcrypt($request->password);
        $user->save();
        return response([
            'status' => 'insert successfull',
            'data'   => $user
        ], 200);
    }

    public function deleteOne(Request $request)
    {
        User::destroy($request->id);
        return response([
            'status' => 'delete successfull',
            'data'   => User::all()
        ], 200);
    }

    public function updateOne(Request $request)
    {
        $user = User::find($request->id);
        $user->name = $request->name;
        $user->password = bcrypt($request->password);
        $user->save();
        return response([
            'status' => 'update successfull',
            'data'   => $user
        ], 200);
    }
}
