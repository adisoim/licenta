<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublisherController;
use Illuminate\Support\Facades\Route;
use Stripe\ApiOperations\Request;

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

Route::get('/', [BookController::class, 'index'])->name('home');

Route::get('/books', [BookController::class, 'index'])
    ->name('books.index');

// Ruta pentru afișarea coșului de cumpărături
Route::get('/cart', [CartController::class, 'cart'])->name('cart.index');

// Rutele pentru adăugarea, actualizarea și eliminarea produselor din coș
Route::post('/cart/add/{book}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('checkout');

// Ruta pentru golirea întregului coș
Route::post('/cart/empty', [CartController::class, 'empty'])->name('cart.empty');

// Include această linie în fișierul de rute web.php
Route::post('/order/place', [OrderController::class, 'place'])->name('order.place')->middleware('auth');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');

Route::get('/books/{book}', [BookController::class, 'show'])
    ->name('books.show');

Route::get('/contacts', function () {
    return view('contacts.index');
})->name('contacts.index');

Route::post('/contact', [ContactController::class, 'store'])->name('contact.submit');

Route::get('/admin', [AdminController::class, 'index'])
    ->middleware(['auth', 'role:admin'])
    ->name('admin.index');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/books-create', [BookController::class, 'create'])->name('books.create');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');
    Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::patch('/books/{book}', [BookController::class, 'update'])->name('books.update');
    Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
    Route::get('/authors/create', [AuthorController::class, 'create'])->name('authors.create');
    Route::post('/authors', [AuthorController::class, 'store'])->name('authors.store');
    Route::get('/authors/{author}/edit', [AuthorController::class, 'edit'])->name('authors.edit');
    Route::patch('/authors/{author}', [AuthorController::class, 'update'])->name('authors.update');
    Route::delete('/authors/{author}', [AuthorController::class, 'destroy'])->name('authors.destroy');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::patch('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::get('/publishers/create', [PublisherController::class, 'create'])->name('publishers.create');
    Route::post('/publishers', [PublisherController::class, 'store'])->name('publishers.store');
    Route::get('/publishers/{publisher}/edit', [PublisherController::class, 'edit'])->name('publishers.edit');
    Route::patch('/publishers/{publisher}', [PublisherController::class, 'update'])->name('publishers.update');
    Route::delete('/publishers/{publisher}', [PublisherController::class, 'destroy'])->name('publishers.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
