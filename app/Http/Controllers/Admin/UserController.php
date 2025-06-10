<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use function PHPUnit\Framework\isNull;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // TODO: Only allow authorised users (Admin/Staff Roles)

        if (!auth()->user()->hasRole('staff|admin|super-admin')) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'search' => ['nullable', 'string',]
        ]);


        $search = $validated['search'] ?? '';


        $users = User::whereAny(
            ['name', 'email', 'position',], 'LIKE', "%$search%")
            ->paginate(15)
            ->appends(['search' => $search]);


        return view('admin.users.index')
            ->with('users', $users)
            ->with('search', $search);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $validated = $request->validate([
                'name' => ['required', 'min:2', 'max:192',],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class . ',email',],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'role' => ['required', 'int', 'exists:roles,id',],
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => Str::lower($validated['email']),
                'password' => Hash::make($validated['password']),
            ]);

            $user->roles()->attach($validated['role']);

        } catch (ValidationException $e) {

            flash()->error('Please fix the errors in the form.',
                [
                    'position' => 'top-center',
                    'timeout' => 5000,
                ],
                'User Creation Failed');

            return back()->withErrors($e->validator)->withInput();

        }

        $userName = $user->name;

        flash()->success("User $userName created successfully!",
            [
                'position' => 'top-center',
                'timeout' => 5000,
            ],
            "User Added");

        return to_route('admin.users.index');


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::orderBy('name')->get();

        return view('admin.users.create', compact(['roles',]));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // TODO: Update when we add Roles & Permissions

        return view('admin.users.show', compact(['user']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // TODO: Update when we add Roles & Permissions

        $roles = Role::all();
        $permissions = Permission::all();
        $userRoles = $user->roles()->get();

        $roles = $roles->diffUsing($userRoles, function ($a, $b) {
            return $a->id <=> $b->id; // Compare by 'id'
        });

        return view('admin.users.edit', compact(['roles', 'user', 'userRoles', 'permissions',]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // TODO: Update when we add Roles & Permissions

        try {

            $validated = $request->validate([
                'name' => ['required', 'min:2', 'max:192',],
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique(User::class)->ignore($user),
                ],
                'password' => [
                    'sometimes',
                    'nullable',
                    'confirmed',
                    Rules\Password::defaults()
                ],
                'role' => ['nullable',],
            ]);

            // Remove password if null
            if (isNull($validated['password'])) {
                unset($validated['password']);
            }

            $user->fill($validated);

            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }

            $user->save();

        } catch (ValidationException $e) {

            flash()->error('Please fix the errors in the form.',
                [
                    'position' => 'top-center',
                    'timeout' => 5000,
                ],
                'User Update Failed');

            return back()->withErrors($e->validator)->withInput();

        }

        if (isNull($user->email_verified_at)) {
            $user->sendEmailVerificationNotification();
        }

        $userName = $user->name;

        flash()->info("User $userName details updated successfully!",
            [
                'position' => 'top-center',
                'timeout' => 5000,
            ],
            "User Updated");

        return to_route('admin.users.index');
    }

    /**
     * Confirm the removal of the specified user.
     *
     * This is a prequel to the actual destruction of the record.
     * Put in place to provide a "confirm the action".
     *
     * @param User $user
     */
    public function delete(User $user)
    {
        // TODO: Update when we add Roles & Permissions

        return view("admin.users.delete", compact(['user',]));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        // TODO: Update when we add Roles & Permissions

        $oldUser = $user;

        $user->delete();


        $userName = $oldUser->name;

        flash()->info("User $userName removed successfully!",
            [
                'position' => 'top-center',
                'timeout' => 5000,
            ],
            "User Deleted");

        return to_route('admin.users.index');

    }

    public function giveRole(Request $request, User $user)
    {
        try {

            $validated = $request->validate([
                'role' => ['required', 'exists:roles,id'],
            ]);

        } catch (ValidationException $e) {

            flash()->error('The role you attempted to add does not exist.',
                [
                    'position' => 'top-center',
                    'timeout' => 5000,
                ],
                'Add Role Failed');

            return back()->withErrors($e->validator)->withInput();

        }

        if ($user->hasRole($validated['role'])) {

            flash()->warning('User already has this role.',
                [
                    'position' => 'top-center',
                    'timeout' => 5000,
                ],
                'Role Exists');

            return back();
        }

        $user->roles()->attach($validated['role']);

        flash()->success('User has been granted the role.',
            [
                'position' => 'top-center',
                'timeout' => 5000,
            ],
            'Role Added');

        return back();
    }

    public function revokeRole(Request $request, User $user)
    {
        $roleId = Role::whereId($request->role)->get();

        if ($user->hasRole($roleId)) {

            $user->roles()->detach($roleId);

            flash()->success('Role has been removed from the user.',
                [
                    'position' => 'top-center',
                    'timeout' => 5000,
                ],
                'Role Revoked');

            return back();
        }

        flash()->warning('User did not have this role.',
            [
                'position' => 'top-center',
                'timeout' => 5000,
            ],
            'Role Did Not Exist');

        return back();
    }


}
