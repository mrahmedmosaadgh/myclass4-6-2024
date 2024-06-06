<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


require __DIR__. '/api_school_admin.php';
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/test', function () {
        return Inertia::render('test');
    })->name('test');
    Route::get('/classview/admin/main', function () {
        return Inertia::render('classview/admin/main/Index');
    })->name('admin.main');

    Route::get('/classview/admin/data', function () {
        // return 'Shimaa';
        return Inertia::render('classview/admin/data/control_admin_data');
        // resources/js/Pages/classview/admin/data/control_admin_data.vue
    })->name('admin.data');
    
    // Route::post('school_admin/c_student', [App\Http\Controllers\cs\c_student_co::class, 'c_student']);

});
