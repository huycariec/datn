<?php

use App\Http\Controllers\Admin\DiscountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\HomeController;

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

// Route::get('/', function () {
//     return view('welcome');
// });
// Khanh Linh 10/2/2024
//dashboard
Route::get('/',[HomeController::class,'index']);



Route::group(['prefix' => 'admin', "name" => "admin."], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');


    Route::resource("discounts", DiscountController::class);
});
