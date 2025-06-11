<?php


use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaticPageController;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//})->name('home');
//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::name('static.')->group(function () {
    Route::get('/', [StaticPageController::class, 'index'])
        ->name('home');

    Route::get('/dashboard', [StaticPageController::class, 'dashboard'])
        ->middleware(['auth', 'verified'])
        ->name('dashboard');
});


Route::name('admin.')
    ->prefix('admin')
    ->middleware(['auth', 'verified', 'role:staff|admin|super-admin'])
    ->group(function () {

        Route::get('/', [StaticPageController::class, 'admin'])
            ->name('index');

        Route::post('roles/{role}/permissions', [RoleController::class, 'givePermission'])
            ->name('roles.permissions');
        Route::delete('roles/{role}/permissions/{permission}', [RoleController::class, 'revokePermission'])
            ->name('roles.permissions.revoke');

        Route::get('roles/{role}/delete', [RoleController::class, 'delete'])
            ->name('roles.delete');

        Route::resource('/roles', RoleController::class);

        Route::get('permissions/{permission}/delete', [PermissionController::class, 'delete'])
            ->name('permissions.delete');
        Route::resource('/permissions', PermissionController::class);

        Route::post('users/{user}/roles', [UserController::class, 'giveRole'])
            ->name('users.roles');
        Route::delete('users/{user}/roles', [UserController::class, 'revokeRole'])
            ->name('users.roles.revoke');

        Route::post('users/{user}/delete', [UserController::class, "delete"])
            ->name('users.delete');

        Route::resource('users',
            UserController::class);
    });


Route::middleware(['auth', 'verified'])
    ->group(function () {


        Route::post('posts/{post}/delete', [PostController::class, "delete"])
            ->name('posts.delete');
    Route::resource('/posts', PostController::class);

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
