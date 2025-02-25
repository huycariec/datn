<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\HomeController;

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
// Khanh Linh 10/2/2024
//dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/', [HomeController::class, 'index'])->name('home');

//Detail
Route::get('/product/{id}', [HomeController::class, 'showProductDetail'])->name('product.detail');


// đky-đnhap
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('profile',[AuthController::class, 'profile'])->name('client.profile');
Route::put('updateProfile',[AuthController::class, 'updateProfile'])->name('client.updateProfile');




Route::group(['prefix' => 'admin', "name" => "admin."], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');


    Route::resource("discounts", DiscountController::class);
    Route::resource("roles", RoleController::class);
    Route::resource("categories",CategoryController::class);
    Route::resource("reviews", ReviewController::class);
});
