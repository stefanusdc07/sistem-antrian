<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Admin\Order\OrderProgress;
use App\Http\Livewire\Admin\Order\Index;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', \App\Http\Livewire\BookingOnline::class);
Route::get('/appointment', App\Http\Livewire\Admin\Order\Index::class)->name('admin.order.index');
Route::get('/antrian', App\Http\Livewire\Admin\Order\OrderProgress::class)->name('admin.order.progress');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
