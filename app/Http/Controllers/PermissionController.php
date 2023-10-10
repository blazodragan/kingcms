<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Requests\IndexPermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use Illuminate\Support\Arr;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public function index(IndexPermissionRequest $request)
    {
        // column with permissions names
        $allPermissions = Permission::all()->map->name;
        $permissionsTree = [];

        collect($allPermissions)->each(function ($permission) use (&$permissionsTree) {
            Arr::set($permissionsTree, $permission, $permission);
        });

        // column for roles
        $rolesPermissions = Role::with('permissions')->get();

        $roleTree = $rolesPermissions->map(function ($role) {
            return ['id' => $role['id'], 'name' => $role['name'], 'permissions' => $role->permissions->map->name];
        });


        return Inertia::render('Permissions/Index', [
            'roles' => $roleTree,
            'permissions' => $permissionsTree,
        ]);
    }

    public function update(UpdatePermissionRequest $request)
    {
        $validated = $request->validated();

        collect($validated['roles'])->each(function ($role) {
            $currentRole = Role::find($role['id']);

            $currentRole->syncPermissions($role['permissions']);
        });

        return back()->with('toast', [
            'type' => 'success',
            'message' => __('Permissions have been successfully updated'),
            'durration' => 2000,
        ]);
    }
}
