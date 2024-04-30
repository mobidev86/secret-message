<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SecretController;
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
    return view('index');
});

Route::get('/create-secret', function () {
    return view('create-secret');
});

Route::post('/store-secret', [SecretController::class, 'store']);
Route::get('/secret/{url}', [SecretController::class, 'show'])->name('secret.show');
Route::put('/secret/{url}', [SecretController::class, 'update'])->name('secret.update');