<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
        return Inertia::render('classview/admin/data/control_admin_data');
        // resources/js/Pages/classview/admin/data/control_admin_data.vue
    })->name('admin.data');
    

});
