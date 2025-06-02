<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
}
