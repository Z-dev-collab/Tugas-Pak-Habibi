<?php

use App\Http\Controllers\ProductsController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\Transaction_itemsController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// view products
Route::get('/products', [ProductsController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductsController::class, 'create'])->name('products.create');
Route::post('/products', [ProductsController::class, 'store'])->name('products.store');
Route::get('/products/{kode_barang}/edit', [ProductsController::class, 'edit'])->name('products.edit');
Route::put('/products/{kode_barang}', [ProductsController::class, 'update'])->name('products.update');
Route::delete('/products/{kode_barang}', [ProductsController::class, 'destroy'])->name('products.destroy');

// view transactions
Route::get('/transactions/', [TransactionsController::class, 'index'])->name('transactions.index');
Route::get('/transactions/create', [TransactionsController::class, 'create'])->name('transactions.create');
Route::post('/transactions/', [TransactionsController::class, 'store'])->name('transactions.store');

// view transaction_items
Route::get('/transaction_items/', [Transaction_itemsController::class, 'index'])->name('transaction_items.index');
Route::get('/transaction_items/create', [Transaction_itemsController::class, 'create'])->name('transaction_items.create');
Route::post('/transaction_items/', [Transaction_itemsController::class, 'store'])->name('transaction_items.store');

// Route::get('/sale', function () {
//     return view('sale/create');
// });

// Route::get('/sale/', [SaleController::class, 'create'])->name('sale.create');
// Route::post('/sales/cart/add', [SaleController::class, 'add'])
//     ->name('sales.cart.add');
// Route::post('/sales/checkout', [SaleController::class, 'checkout'])
//     ->name('sales.checkout');

Route::prefix('sale')->name('sales.')->group(function () {
    Route::get('/', [SaleController::class, 'create'])->name('index');
    Route::post('/cart/add', [SaleController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update', [SaleController::class, 'updateCart'])->name('cart.update');
    Route::post('/cart/remove', [SaleController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/checkout', [SaleController::class, 'checkout'])->name('checkout');
});

Route::get('/receipt/{transaction}', [SaleController::class, 'receipt'])->name('receipt');