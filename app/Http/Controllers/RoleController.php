<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role as Role;

class RoleController extends Controller
{
    public function getAll()
    {
        return Role::all();
    }

    public function insertOne(Request $request)
    {
        if($request->input('role') !== null) {
            if(Role::where('role', $request->input('role'))->get()->first() === null) {
                $newRole = new Role();
                $newRole->role = $request->input('role');
                $newRole->save();
                return response()->json([
                    'success' => 'New role inserted',
                    'successMessage' => ''
                ]);
            }
        }
        return response()->json([
            'error' => 'Cannot insert role',
            'errorMessage' => 'Syntax error, or the role already exists'
        ]);
    }

    public function deleteOne(Request $request)
    {
        if($request->input('id') !== null) {
            $roleToDelete = Role::find($request->input('id'));
            if($roleToDelete !== null) {
                $roleToDelete->delete();
                return response()->json([
                    'success' => 'Role deleted',
                    'successMessage' => ''
                ]);
            }
        }
        return response()->json([
            'error' => 'Cannot delete role',
            'errorMessage' => 'Syntax error, or the role id doesn\'t exists'
        ]);
    }

    public function updateOne(Request $request, $id)
    {
        $roleName = $request->input('role');
        if($roleName !==null) {
            $role = Role::find($id);
            if($role !== null) {
                $role->role = $roleName;
                $role->save();
                return response()->json([
                    'success' => 'Role updated',
                    'successMessage' => Role::find($id)
                ]);
            }
        }
        return response()->json([
            'error' => 'Cannot update role',
            'errorMessage' => 'Syntax error, or the role id doesn\'t exists'
        ]);
    }
}
