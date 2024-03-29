<?php

use App\Http\Livewire\Pos;
use App\Http\Livewire\Coins;
use App\Http\Livewire\Roles;
use App\Http\Livewire\Products;
use App\Http\Livewire\Categories;
use App\Http\Livewire\Permissions;
use App\Http\Livewire\Assignations;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/categories', Categories::class);
Route::get('/products', Products::class);
Route::get('/coins', Coins::class);
Route::get('/pos', Pos::class);
Route::get('/roles', Roles::class);
Route::get('/permissions', Permissions::class);
Route::get('/assignations', Assignations::class);

