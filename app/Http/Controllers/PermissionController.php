<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    //
    public function index()
    {
        $permissions = Permission::paginate(15);

        return view('admin.permissions.index')
            ->with('permissions', $permissions);    }
}
