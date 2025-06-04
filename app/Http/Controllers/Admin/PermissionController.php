<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    //
    public function index()
    {
        $permissions = Permission::paginate(15);

        return view('admin.permissions.index')
            ->with('permissions', $permissions);
    }


    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'name'=>[
                'required',
                'min:5',
                'max:64',
                'unique:permissions'
            ]
        ]);

        $validated['name']=Str::lower($validated['name']);

        Permission::create($validated);

        return to_route('admin.permissions.index');

    }



    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit')
            ->with('permission', $permission);
    }


    public function update(Permission $permission, Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'min:5',
                'max:64',
                'unique:permissions'
            ]
        ]);

        $validated['name'] = Str::lower($validated['name']);

        $permission->update($validated);

        return to_route('admin.permissions.index');
    }


    public function delete(Permission $permission)
    {
        return view('admin.permissions.delete')
            ->with('permission', $permission);
    }


    public function destroy(Permission $permission, Request $request)
    {

        $permissionName = $permission->name;

        $validated = $request->validate([
            'name' => [
                'required',
                'exists:permissions,name'
            ]
        ]);

        $permission->delete();

        return to_route('admin.permissions.index');
    }

}
