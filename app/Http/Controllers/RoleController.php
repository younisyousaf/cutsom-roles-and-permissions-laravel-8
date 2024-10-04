<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    //
    public function manageRole()
    {
        return view('manage-roles');
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
}
