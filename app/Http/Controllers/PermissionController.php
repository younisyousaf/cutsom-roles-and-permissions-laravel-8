<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;

class PermissionController extends Controller
{
    //

    public function managePermission()
    {
        $permissions = Permission::all();
        return view('manage-permissions', compact('permissions'));
    }

    public function createPermission(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'permission' => 'required|unique:permissions,name|max:255',
            ]);
            $permission = Permission::create([
                'name' => $validatedData['permission'],
            ]);
            return response()->json(['success' => true, 'message' => 'Permission created successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    public function updatePermission(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'permission' => 'required|max:255',
            ]);
            $permission = Permission::find($request->permission_id);
            $permission->update([
                'name' => $validatedData['permission'],
            ]);
            return response()->json(['success' => true, 'message' => 'Permission updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    public function deletePermission(Request $request)
    {
        try {
            $permission = Permission::find($request->permission_id);
            $permission->delete();
            return response()->json(['success' => true, 'message' => 'Permission deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
