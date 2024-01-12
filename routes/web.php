<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Display the login form
Route::get('admin', [AdminController::class, 'login_form'])->name('login.form');

// Handle the login functionality when a POST request is made to '/login-functionality'
Route::post('login-functionality', [AdminController::class, 'login_functionality'])->name('login.functionality');

Route::group(['middleware' => 'admin'], function () {
    Route::get('logout', [AdminController::class, 'logout'])->name('logout');
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Display the list of products
    Route::get('products', [ProductController::class, 'index'])->name('products');

    // Save a new product to the database
    Route::post('store', [ProductController::class, 'store'])->name('store');

    // Fetch the list of all products
    Route::get('fetchall', [ProductController::class, 'fetchAll'])->name('fetchAll');

    // View the details and edit a specific product
    Route::delete('delete', [ProductController::class, 'delete'])->name('delete');

    // Update the details of a specific product
    Route::get('edit', [ProductController::class, 'edit'])->name('edit');
    Route::post('/update', [ProductController::class, 'update'])->name('update');

    // Display the list of categories
    Route::get('categories', [CategoryController::class, 'index'])->name('categories');

    // Fetch the list of all products
    Route::get('fetchallCategories', [CategoryController::class, 'fetchallCategories'])->name('fetchallCategories');

    // Save a new category to the database
    Route::post('storeCategory', [CategoryController::class, 'store'])->name('storeCategory');

    // Update the details of a specific category
    Route::get('editCategory', [CategoryController::class, 'edit'])->name('editCategory');
    Route::post('/updateCategory', [CategoryController::class, 'update'])->name('updateCategory');

    // View the details and edit a specific category
    Route::delete('deleteCategory', [CategoryController::class, 'delete'])->name('deleteCategory');
});

// Group routes under the AdminController for managing administrative tasks
Route::controller(AdminController::class)->group(function () {
    Route::post('api/fetch-cities', 'fetchCity')->name('fetchCity');
});

Auth::routes();

// Display the home page
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Route::get('/logout', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/user/{id}', [UserController::class, 'show']);
Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
