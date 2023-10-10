<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\http\Requests\IndexRoleRequest;
use App\Queries\Filters\FuzzyFilter;
use Illuminate\Support\Arr;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class RoleController extends Controller
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;
    
    public function index(IndexRoleRequest $request)
    {
        $roles = QueryBuilder::for(Role::class)
            ->allowedFilters([
                AllowedFilter::custom('search', new FuzzyFilter(
                    'id',
                    'name',
                )),
            ])
            ->defaultSort('id')
            ->allowedSorts(['id', 'name'])
            ->with('users')
            ->select(['id', 'name'])
            ->paginate(request()->get('per_page'))->withQueryString();
        return Inertia::render('Roles/Index', [
            'roles' => $roles,
        ]);
    }

    public function edit(Role $role)
    {
        $this->authorize('sanctum.role.edit');

        $allPermissions = Permission::all()->map->name;
        $assignedPermissions = $role->permissions->map->name;

        $permissionsTree = [];

        collect($allPermissions)->each(function ($permission) use (&$permissionsTree, $assignedPermissions) {
            $isAssigned = collect($assignedPermissions)->contains($permission);
            Arr::set($permissionsTree, $permission, $isAssigned);
        });

        return Inertia::render('Roles/Edit', [
            'role' => $role,
            'permissionsTree' => $permissionsTree,
        ]);
    }

    public function update(Role $role, Request $request)
    {
        $this->authorize('sanctum.role.edit');

        $role->syncPermissions(collect(Arr::dot($request->input('permissionsTree')))->filter()->keys());

        return redirect()->back()->with(['message' => 'Role has been successfully updated']);
    }

}
