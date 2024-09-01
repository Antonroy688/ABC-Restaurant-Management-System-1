<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolesAndPermissionController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ActivitylogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
Route::middleware(['auth'])->group(function () {
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::controller(App\Http\Controllers\GeneralSettingController::class)->group(function () {
Route::get('/general-settings','index')->name('general-settings.index');
Route::post('/general-settings','store')->name('general-settings.store');
Route::post('/general-settings/mail_config','mail_config')->name('general-settings.mail_config');
Route::get('/general-settings/mail','mail_config')->name('general-settings.mail_config.test');
Route::get('send-mail','send_mail')->name('general-settings.send');
});
Route::resource('/roles',RolesAndPermissionController::class);
Route::controller(RolesAndPermissionController::class)->group(function () {
Route::post('/roles/{id}', 'destroy')->name('roles.delete');
Route::get('/roles/citypermission','citypermission')->name('roles.citypermission');
});
Route::get('/users/citypermission/{id}',[UsersController::class,'citypermission'])->name('users.citypermission');
Route::post('/users/usersCity/{id}',[UsersController::class,'citypermissionUpdate'])->name('usersCity.update');
Route::get('/users/ActiveUsers',[UsersController::class,'ActiveUsers'])->name('users.activeUsers');
Route::get('/profile',[UsersController::class,'profile'])->name('account.profile');
Route::resource('/users',UsersController::class)->middleware('permission:Users View');
Route::post('/activityLog/delete',[ActivitylogController::class,'delete'])->name('activityLog.delete');
Route::resource('/activityLog',ActivitylogController::class);

});
