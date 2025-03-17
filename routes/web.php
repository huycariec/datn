<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\ProductAttribute;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductVariantController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\ProfileController;
use App\Models\Admin\Profile;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AddressController;

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
Route::get('/error', [HomeController::class, 'error'])->name('error');

//Detail
Route::get('/product/{id}', [HomeController::class, 'showProductDetail'])->name('product.detail');

Route::middleware(['auth'])->group(function () {
    Route::resource('blogs', BlogController::class)->except(['show']);
});
// wishlist
Route::middleware(['auth'])->group(function () {
    Route::get('/wishlist', [HomeController::class, 'wishlist'])->name('wishlist.index');
    Route::post('/wishlist/add/{productId}', [HomeController::class, 'addToWishlist'])->name('wishlist.add');
    Route::delete('/wishlist/remove/{productId}', [HomeController::class, 'removeFromWishlist'])->name('wishlist.remove');
});
// sản phẩm theo danh mục
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/category/{id}', [HomeController::class, 'productsByCategory'])->name('products.byCategory');
// đky-đnhap
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('chinh-sach-mua-hang', [HomeController::class, 'PolicyBuy'])->name('policy_buy');
Route::get('chinh-sach-doi-tra', [HomeController::class, 'PolicyReturn'])->name('policy_return.blade.php');
Route::get('huong-dan-mua-hang', [HomeController::class, 'Instruct'])->name('instruct');
Route::get('gioi-thieu', [HomeController::class, 'Introduction'])->name('introduction');

Route::get('/profile', [AddressController::class, 'showProfile'])->name('client.profile');
Route::put('/profile', [AddressController::class, 'updateProfile'])->name('client.updateProfile');
Route::post('/add-address', [AddressController::class, 'addAddress'])->name('client.addAddress');
Route::put('/update-address/{id}', [AddressController::class, 'updateAddress'])->name('client.updateAddress');
Route::delete('/delete/{id}', [AddressController::class, 'deleteAddress'])->name('client.deleteAddress');
//kiều duy du 13/2/2025 product
Route::get('/admin-product-index',[ProductController::class,'index'])->name('admin.product.index');
Route::get('/admin-product-create',[ProductController::class,'create'])->name('admin.product.create');
Route::post('/admin-product-store',[ProductController::class,'store'])->name('admin.product.store');
Route::get('/admin-product-edit/{id}',[ProductController::class,'edit'])->name('admin.product.edit');
Route::post('/admin-product-delete/{id}',[ProductController::class,'delete'])->name('admin.product.delete');





// kiều duy du 14/2/2025 Attribute
Route::get('/admin-attribute-index',[ProductAttribute::class,'index'])->name('admin.attribute.index');
Route::get('/admin-attribute-create',[ProductAttribute::class,'create'])->name('admin.attribute.create');
Route::post('/admin-attribute-store',[ProductAttribute::class,'store'])->name('admin.attribute.store');
Route::delete('/admin-attributes-destroy/{key}', [ProductAttribute::class, 'destroy']);
Route::get('/admin-attribute-edit/{id}',[ProductAttribute::class,'edit'])->name('admin.attribute.edit');

//kiều duy du 21/2/2025 variant
Route::get('/admin-variant-index/{id}',[ProductVariantController::class,'index'])->name('admin.variant.index');
Route::post('/admin-variant-store',[ProductVariantController::class,'store'])->name('admin.variant.store');






Route::group(['prefix' => 'admin', 'name' => 'admin.', 'middleware' => 'checkAdmin'], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource("discounts", DiscountController::class);
    Route::resource("roles", RoleController::class);
    Route::resource("categories", CategoryController::class);
    Route::resource("reviews", ReviewController::class);
    Route::resource("banners", BannerController::class);
    Route::resource("pages", PageController::class);

    Route::get('profile', [ProfileController::class, 'profile'])->name('admin.profile');
    Route::put('updateProfile', [ProfileController::class, 'updateProfile'])->name('admin.updateProfile');

    Route::get('/user', [UserController::class, 'index'])->name('admin.user.index');
    Route::delete('user/destroy/{id}', [UserController::class, 'destroy'])->name('admin.user.destroy');
});

