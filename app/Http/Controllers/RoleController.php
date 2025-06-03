<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    //

    public function index()
    {
        $roles = Role::paginate(15);

        return view('admin.roles.index')
            ->with('roles', $roles);
    }

    public function create()
    {
        return view('admin.roles.create');
    }

    public function store(Request $request)
    {
        $role = null;

        try {
            $validated = $request->validate([
                'name' => [
                    'required',
                    'min:5',
                    'max:64',
                    'unique:roles'
                ]
            ]);
        } catch (ValidationException $e) {
            flash()->error('Please fix the errors in the form.',
                [
                    'position' => 'top-center',
                    'timeout' => 5000,
                ],
                'Role Creation Failed');

            return back()->withErrors($e->validator)->withInput();
        }

        try {
            $role = Role::create($validated);
        } catch (RoleAlreadyExists $e) {
            flash()->error('The role already exists.',
                [
                    'position' => 'top-center',
                    'timeout' => 5000,
                ],
                'Role Creation Failed');

            return back()->withErrors($e->getMessage())->withInput();
        }

        $roleName = $role->name;

        flash()->success("Role $roleName created successfully!",
            [
                'position' => 'top-center',
                'timeout' => 5000,
            ],
            "Role Added");

        return to_route('admin.roles.index');

    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $rolePermissions = $role->permissions()->get();

//        return view('admin.roles.edit', compact(['role', 'permissions', 'rolePermissions']));
        return view('admin.roles.edit')
            ->with('role', $role)
            ->with('permissions', $permissions)
            ->with('rolePermissions', $rolePermissions);
    }


    public function update(Role $role, Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => [
                    'required',
                    'min:5',
                    'max:64',
                    Rule::unique(Role::class)->ignore($role->id),
                ]
            ]);

            $validated['name'] = Str::lower($validated['name']);

        } catch (ValidationException $e) {
            flash()->error('Please fix the errors in the form.',
                [
                    'position' => 'top-center',
                    'timeout' => 5000,
                ],
                'Role Update Failed');

            return back()->withErrors($e->validator)->withInput();
        }

        try {

            $role->update($validated);

        } catch (RoleAlreadyExists $e) {
            flash()->error('The role already exists.',
                [
                    'position' => 'top-center',
                    'timeout' => 5000,
                ],
                'Role Creation Failed');

            return back()->withErrors($e->getMessage())->withInput();
        }

        $roleName = $role->name;

        flash()->success("Role $roleName updated successfully!",
            [
                'position' => 'top-center',
                'timeout' => 5000,
            ],
            "Role Added");

        return to_route('admin.roles.index');

    }


    public function delete(Role $role)
    {
        return view('admin.roles.delete')
            ->with('role', $role);
    }


    public function destroy(Role $role, Request $request)
    {

        $roleName = $role->name;
        $roleId = $role->id;

        try {

            $validated = $request->validate([
                'name' => [
                    'required',
                    'exists:roles,name,id,' . $roleId,
                ],
            ]);
        } catch (ValidationException $e) {
            flash()->error(__("To delete, please enter the role's name."),
                [
                    'position' => 'top-center',
                    'timeout' => 5000,
                ],
                __('Role Delete Failed'));

            return back()->withErrors($e->validator)->withInput();
        }

        try {
            $role->delete();
        } catch (RoleDoesNotExist $e) {
            flash()->error('Could not delete the role.',
                [
                    'position' => 'top-center',
                    'timeout' => 5000,
                ],
                'Role Delete Failed');

            return back()->withErrors($e->getMessage())->withInput();
        }


        flash()->success("Role $roleName successfully deleted!",
            [
                'position' => 'top-center',
                'timeout' => 5000,
            ],
            "Role Added");

        return to_route('admin.roles.index');

    }


    public function givePermission(Request $request, Role $role)
    {
        if ($role->hasPermissionTo($request->permission)) {

            flash()->warning('Role already has this permission.',
                [
                    'position' => 'top-center',
                    'timeout' => 5000,
                ],
                'Permission Exists');

            return back();
        }

        $role->givePermissionTo($request->permission);

        flash()->success('Role has been granted the permission.',
            [
                'position' => 'top-center',
                'timeout' => 5000,
            ],
            'Permission Added');

        return back();
    }

    public function revokePermission(Role $role, Permission $permission)
    {
        if ($role->hasPermissionTo($permission)) {
            $role->revokePermissionTo($permission);

            flash()->success('Permission has been removed from the role.',
                [
                    'position' => 'top-center',
                    'timeout' => 5000,
                ],
                'Permission Revoked');

            return back();
        }

        flash()->warning('Role did not have this permission.',
            [
                'position' => 'top-center',
                'timeout' => 5000,
            ],
            'Permission Did Not Exist');

        return back();
    }

}
