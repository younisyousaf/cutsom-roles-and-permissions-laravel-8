<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\Role;
use App\Models\RoutePermission;
use Illuminate\Support\Facades\Route;

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

    public function assignPermissionRole()
    {
        $roles = Role::whereNotIn('name', ['Super Admin'])->get();
        $permissions = Permission::all();
        $permissionsWithRoles = Permission::with('roles')->whereHas('roles')->get();
        // dd($permissionsWithRoles);
        return  view('assign-permission-role', compact('permissions', 'roles', 'permissionsWithRoles'));
    }
    public function createPermissionRole(Request $request)
    {
        try {
            $isPermissionToRoleExist = PermissionRole::where([
                'permission_id' => $request->permission_id,
                'role_id' => $request->role_id
            ])->first();
            if ($isPermissionToRoleExist) {
                return response()->json([
                    'success' => false,
                    'message' => 'Permission already assigned to selected role!',
                ]);
            }
            PermissionRole::create([
                'permission_id' => $request->permission_id,
                'role_id' => $request->role_id
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Permission assigned to selected role successfully!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
    public function updatePermissionRole(Request $request)
    {
        try {
            $roles = $request->roles;
            PermissionRole::where('permission_id', $request->permission_id)->delete();
            $insertData = [];
            foreach ($roles as $role) {
                $insertData[] = [
                    'permission_id' => $request->permission_id,
                    'role_id' => $role
                ];
            }

            PermissionRole::insert($insertData);

            return response()->json(['success' => true, 'message' => 'Permission updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    public function deletePermissionRole(Request $request)
    {
        try {
            PermissionRole::where('permission_id', $request->permission_id)->delete();
            return response()->json(['success' => true, 'message' => 'Permission deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    // Assign Permissions to Routes
    public function assignPermissionRoute()
    {
        $routes = Route::getRoutes();
        $routeGroupName = 'isAuthenticated';
        $routeDetails = [];
        foreach ($routes as $route) {
            $middlewares = $route->gatherMiddleware();
            if (in_array($routeGroupName, $middlewares)) {
                $routeName = $route->getName();
                if ($routeName !== 'loadDashboard' && $routeName !== 'logout') {
                    $routeDetails[] = [
                        'name' => $routeName,
                        'uri' => $route->uri(),
                    ];
                }
            }
        }
        // dd($routeDetails);
        $permissions = Permission::all();
        $routerPermissions = RoutePermission::with('permission')->get();
        // dd($routerPermissions);
        return view('assign-permission-route', compact(['permissions', 'routeDetails', 'routerPermissions']));
    }
    public function createPermissionRoute(Request $request)
    {
        try {
            $isRouteExist = RoutePermission::where([
                'permission_id' => $request->permission_id,
                // 'router' => $request->route
            ])->first();
            if ($isRouteExist) {
                return response()->json([
                    'success' => false,
                    'message' => 'Permission already assigned!',
                ]);
            }
            RoutePermission::create([
                'permission_id' => $request->permission_id,
                'router' => $request->route
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Permission assigned to selected route successfully!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
    public function updatePermissionRoute(Request $request)
    {
        try {
            $isPermissionExist = RoutePermission::whereNotIn('id', [$request->id])
                ->where([
                    'permission_id' => $request->permission_id,
                ])->first();
            $isRouteExist = RoutePermission::where([
                'router' => $request->router,
            ])->first();
            if ($isPermissionExist) {
                return response()->json([
                    'success' => false,
                    'message' => 'Permission already assigned!',
                ]);
            } else if ($isRouteExist) {
                return response()->json([
                    'success' => false,
                    'message' => 'Route already assigned!',
                ]);
            }
            RoutePermission::where('id', $request->id)->update([
                'permission_id' => $request->permission_id,
                'router' => $request->router
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Permission updated to selected route successfully!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
    public function deletePermissionRoute(Request $request)
    {
        try {
            RoutePermission::where('id', $request->id)->delete();
            return response()->json(['success' => true, 'message' => 'Permission deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
