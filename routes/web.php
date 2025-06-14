<?php

use App\Http\Controllers\ImportExportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('/user/logout', 'UserDestroy')->name('user.logout');
        Route::get('/user/profile', 'UserProfile')->name('user.profile');
        Route::post('/user/profile/store', 'UserProfileStore')->name('user.profile.store');
        Route::get('/user/password/change','UserPasswordChange')->name('user.password.change');
        Route::post('/user/password/update','UserPasswordUpdate')->name('user.password.update');
    });

    Route::controller(ImportExportController::class)->group(function(){
        Route::get('import/table/all','ImportAllTable')->name('import.table.all');
        Route::post('import/table/users','ImportUserTable')->name('import.table.users');
        Route::post('import/table/faculties','ImportFacultyTable')->name('import.table.faculties');
        Route::post('import/table/departments','ImportDepartmentTable')->name('import.table.departments');
        Route::post('import/table/designations','ImportDesignationTable')->name('import.table.designations');
        Route::post('import/table/teachers','ImportTeacherTable')->name('import.table.teachers');
    });

    Route::controller(ImportExportController::class)->group(function(){
        Route::get('import/table/all','ImportAllTable')->name('import.table.all');
        Route::post('import/table/users','ImportUserTable')->name('import.table.users');
        Route::post('import/table/faculties','ImportFacultyTable')->name('import.table.faculties');
        Route::post('import/table/departments','ImportDepartmentTable')->name('import.table.departments');
        Route::post('import/table/designations','ImportDesignationTable')->name('import.table.designations');
        Route::post('import/table/teachers','ImportTeacherTable')->name('import.table.teachers');
    });



});

require __DIR__.'/auth.php';
