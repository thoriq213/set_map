<?php

use App\Http\Controllers\TransactionController;
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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/form', [TransactionController::class, 'form']);
Route::post('/transaction_detail', [TransactionController::class, 'transaction']);
Route::post('/get_city', [TransactionController::class, 'get_city']);
Route::post('/get_district', [TransactionController::class, 'get_district']);
Route::post('/get_village', [TransactionController::class, 'get_village']);
