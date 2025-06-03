<?php

namespace App\Http\Controllers;

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
}
