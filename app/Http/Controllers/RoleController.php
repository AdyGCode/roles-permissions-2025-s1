<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
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

            $validated['name'] = Str::lower($validated['name']);

            $role = Role::create($validated);

        } catch (ValidationException $e) {

            flash()->error('Please fix the errors in the form.',
                [
                    'position' => 'top-center',
                    'timeout' => 5000,
                ],
                'Role Creation Failed');

            return back()->withErrors($e->validator)->withInput();

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
        return view('admin.roles.edit')
            ->with('role', $role);
    }


    public function update(Role $role, Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'min:5',
                'max:64',
                'unique:roles'
            ]
        ]);

        $validated['name'] = Str::lower($validated['name']);

        $role->update($validated);

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

        $validated = $request->validate([
            'name' => [
                'required',
                'exists:roles,name'
            ]
        ]);

        $role->delete();

        return to_route('admin.roles.index');
    }

}
