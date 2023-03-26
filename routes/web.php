<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AccountInfoController;

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
Route::get('/accountmanage', [AccountInfoController::class, 'index'])->name('account_info.index');

Route::post('/accountmanage', [AccountInfoController::class, 'store'])->name('accountmanage');
Route::post('/accountmanage/{id}', [AccountInfoController::class, 'show']);
Route::put('/accountmanage/{id}/edit', [AccountInfoController::class, 'update'])->name('account.update');
Route::delete('/accountmanage/alldelete', [AccountInfoController::class, 'alldelete']);
Route::delete('/accountmanage/{id}', [AccountInfoController::class, 'destroy']);
Route::get('/export-csv', [AccountInfoController::class, 'exportCSV']);