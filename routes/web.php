<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Halaman Depan (Bisa diakses siapa saja)
// Halaman Depan
Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Redirect Dashboard sesuai Role
Route::get('/dashboard', function () {
    $role = Auth::user()->role;
    if ($role === 'admin') return redirect()->route('admin.dashboard');
    if ($role === 'seller') return redirect()->route('seller.dashboard');
    return redirect()->route('bidder.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// GROUP 1: ADMIN (Full Control)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');

    // CRUD USER
    Route::get('/users', [\App\Http\Controllers\Admin\AdminController::class, 'users'])->name('users.index');
    Route::get('/users/{id}/edit', [\App\Http\Controllers\Admin\AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{id}', [\App\Http\Controllers\Admin\AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [\App\Http\Controllers\Admin\AdminController::class, 'destroyUser'])->name('users.destroy');

    // CRUD ITEM (BARANG)
    Route::get('/items', [\App\Http\Controllers\Admin\AdminController::class, 'items'])->name('items.index');
    Route::get('/items/{id}/edit', [\App\Http\Controllers\Admin\AdminController::class, 'editItem'])->name('items.edit');
    Route::put('/items/{id}', [\App\Http\Controllers\Admin\AdminController::class, 'updateItem'])->name('items.update');
    Route::delete('/items/{id}', [\App\Http\Controllers\Admin\AdminController::class, 'destroyItem'])->name('items.destroy');

    // CRUD BERITA (Otomatis sudah lengkap dengan resource)
    Route::resource('news', \App\Http\Controllers\Admin\NewsController::class);
});

// --- UPDATE GROUP SELLER ---
Route::middleware(['auth', 'role:seller'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', function () {
        return view('seller.dashboard');
    })->name('dashboard');
    
    Route::resource('items', \App\Http\Controllers\Seller\ItemController::class);
    
    // Route Tutup Lelang
    Route::post('/items/{id}/close', [\App\Http\Controllers\Seller\ItemController::class, 'closeAuction'])->name('items.close');
});

// --- UPDATE GROUP BIDDER ---
Route::middleware(['auth', 'role:bidder'])->prefix('bidder')->name('bidder.')->group(function () {
    Route::get('/dashboard', function () {
        return view('bidder.dashboard');
    })->name('dashboard');

    Route::get('/auctions', [\App\Http\Controllers\Bidder\AuctionController::class, 'index'])->name('auction.index');
    Route::get('/auctions/{id}', [\App\Http\Controllers\Bidder\AuctionController::class, 'show'])->name('auction.show');
    Route::post('/auctions/{id}', [\App\Http\Controllers\Bidder\AuctionController::class, 'store'])->name('auction.store');

    // Route Wishlist
    Route::post('/wishlist/{id}', [\App\Http\Controllers\Bidder\WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::get('/wishlist', [\App\Http\Controllers\Bidder\WishlistController::class, 'index'])->name('wishlist.index');

    // Route Barang Menang (My Wins)
    Route::get('/my-wins', function() {
        // Cari barang status 'closed', lalu cek apakah user ini penawar tertingginya
        // Ini logika agak kompleks query-nya, kita sederhanakan dengan filter collection
        $wonItems = \App\Models\Item::where('status', 'closed')->get()->filter(function($item) {
            $highestBid = $item->bids()->orderBy('bid_amount', 'desc')->first();
            return $highestBid && $highestBid->user_id == Auth::id();
        });
        return view('bidder.wins.index', compact('wonItems'));
    })->name('wins.index');
});

// --- ROUTE PESAN (Bisa diakses Seller & Bidder) ---
Route::middleware('auth')->group(function() {
    Route::get('/inbox', [\App\Http\Controllers\MessageController::class, 'index'])->name('messages.index');
    Route::post('/message/{id}', [\App\Http\Controllers\MessageController::class, 'store'])->name('messages.store');
});
require __DIR__.'/auth.php';