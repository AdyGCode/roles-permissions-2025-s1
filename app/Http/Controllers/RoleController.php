<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
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

        $validated = $request->validate([
            'name' => [
                'required',
                'min:5',
                'max:64',
                'unique:roles'
            ]
        ]);

        $validated['name'] = Str::lower($validated['name']);

        Role::create($validated);

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
