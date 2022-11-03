<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/users', [UserController::class, 'index']);
Route::get('users-data', [UserController::class, 'getData'])->name('users.list');
Route::get('users-all', [UserController::class, 'queryUsers'])->name('users.all');
Route::get('/users-delete', [UserController::class, 'bulkDelete'])->name('users.bulkdelete');

Route::get('/', function () {
    return view('welcome');
});
