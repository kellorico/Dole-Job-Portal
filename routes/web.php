<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;





//user routes
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
    Route::get('/admin/news',[NewsController::class,'index'])->name('news');

    //profile
    Route::get('/profile',[ProfileController::class,'edit'])->name('profile.edit');
    Route::patch('/profile',[ProfileController::class,'updateInfo'])->name('profile.info');
    Route::put('/profile',[ProfileController::class,'updatePassword'])->name('profile.password');
    Route::delete('/profile',[ProfileController::class,'destroy'])->name('profile.destroy');
});

//admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [Dashboard::class, 'showNews'])->name('admin.dashboard');
    Route::get('/admin/users',[Dashboard::class,'users'])->name('admin.users');

    //Jobs
    Route::get('/admin/jobs', [JobsController::class, 'index'])->name('admin.jobs');
    Route::get('/admin/postjobs', [JobsController::class, 'create'])->name('admin.jobs.create');
    Route::post('/admin/postjobs', [JobsController::class, 'postJobs']);

    //News
    Route::get('/admin/news/create', [NewsController::class, 'create'])->name('news-create');
    Route::post('/admin/news/store', [NewsController::class, 'store']);

    //add admin
    Route::get('/admin/admin-list', [AdminController::class, 'index'])->name('admin-list');
    Route::get('/admin/create', [AdminController::class, 'create'])->name('admin-create');
    Route::post('/admin/store', [AdminController::class, 'store'])->name('admin-store');
    Route::put('/admin/update/{id}', [AdminController::class, 'update'])->name('admin-update');
    Route::delete('/admin/delete/{id}', [AdminController::class, 'delete'])->name('admin-delete');

    //profile
    Route::get('/admin/profile', [ProfileController::class, 'index'])->name('admin.profile');
    Route::get('/admin/settings', [ProfileController::class, 'settings'])->name('settings');
});




Route::get('/findjobs', function () {
    return inertia('FindJobs');
})->name('findjobs');

Route::get('/savejobs', function () {
    return inertia('SaveJobs');
})->name('savejobs');

Route::get('/jobapplication', function () {
    return inertia('JobApplication');
})->name('jobapplication');

Route::get('/jobinvitation', function () {
    return inertia('JobInvitation');
})->name('jobinvitation');
//guest
Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('welcome');


require __DIR__ . '/auth.php';
