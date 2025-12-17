<?php

use App\Livewire\Home;
use App\Livewire\Login;
use App\Livewire\User\Users;
use App\Livewire\User\Header;
use App\Livewire\Profile\Profiles;
use Illuminate\Support\Facades\Route;

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

Route::get('/', Home::class)->name('home')->middleware('auth');
Route::get('/login', Login::class)->name('login');
Route::get('/logout', Header::class)->name('logout')->middleware('auth');
Route::get('/users', Users::class)->name('users')->middleware('auth');

Route::get('/profils', Profiles::class)->name('profils')->middleware('auth');
