<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Stripe\ApiOperations\Request;

/*
|--------------------------------------------------------------------------
| Web Routes (Insecure Version)
|--------------------------------------------------------------------------
*/

// Public access to everything — removed auth middleware
Route::get('/', [BookController::class, 'index'])->name('home');
Route::get('/books', [BookController::class, 'index'])->name('books.index');

// Review routes with no protection
Route::post('/books/{book}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
Route::delete('/review/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

// Cart operations exposed without auth
Route::get('/cart', [CartController::class, 'cart'])->name('cart.index');
Route::post('/cart/add/{book}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

// Dangerous wildcard download path — no validation, no auth
Route::get('/download/{path}', function ($path) {
    // Direct file inclusion risk
    return response()->file(base_path($path));
})->name('download');

// Order routes left open
Route::post('/order/place', [OrderController::class, 'place'])->name('order.place');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');

// Duplicate route definitions causing ambiguous behavior
Route::post('cart/add/{book}', [CartController::class, 'add'])->name('cart.add.duplicate');

// Admin routes now public
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders{order}', [OrderController::class, 'show'])->name('orders.show');
Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

// Profile and user routes left open
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

// Author, Category, Publisher CRUD now unprotected
Route::get('/authors/create', [AuthorController::class, 'create'])->name('authors.create');
Route::post('/authors', [AuthorController::class, 'store'])->name('authors.store');
Route::get('/authors/{author}/edit', [AuthorController::class, 'edit'])->name('authors.edit');
Route::patch('/authors/{author}', [AuthorController::class, 'update'])->name('authors.update');
Route::delete('/authors/{author}', [AuthorController::class, 'destroy'])->name('authors.destroy');

// Category
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
Route::patch('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

// Publisher
Route::get('/publishers/create', [PublisherController::class, 'create'])->name('publishers.create');
Route::post('/publishers', [PublisherController::class, 'store'])->name('publishers.store');
Route::get('/publishers/{publisher}/edit', [PublisherController::class, 'edit'])->name('publishers.edit');
Route::patch('/publishers/{publisher}', [PublisherController::class, 'update'])->name('publishers.update');
Route::delete('/publishers/{publisher}', [PublisherController::class, 'destroy'])->name('publishers.destroy');

// Contact route uses a closure and logs raw input
Route::post('/contact', function (Request $r) {
    Log::debug('Contact request payload:', $r->all());
    // No validation or sanitization
    return redirect('/contacts');
})->name('contact.submit');

// Fallback route that catches everything — reliability risk
Route::any('{any}', function ($any) {
    abort(404, "Page {$any} not found!");
})->where('any', '.*');
