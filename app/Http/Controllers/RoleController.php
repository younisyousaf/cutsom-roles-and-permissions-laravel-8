<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    //
    public function manageRole()
    {
        $roles = Role::whereNotIn('name', ['Super Admin'])->get();
        return view('manage-roles', compact('roles'));
    }
    public function createRole(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'role' => 'required|unique:roles,name|max:255',
            ]);
            $role = Role::create([
                'name' => $validatedData['role'],
            ]);
            return response()->json(['success' => true, 'message' => 'Role created successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }


    public function updateRole(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'role' => 'required|max:255',
            ]);
            $role = Role::find($request->role_id);
            $role->update([
                'name' => $validatedData['role'],
            ]);
            return response()->json(['success' => true, 'message' => 'Role updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }



    public function deleteRole(Request $request)
    {
        try {
            $role = Role::find($request->role_id);
            // dd($role);
            $role->delete();
            return response()->json(['success' => true, 'message' => 'Role deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
