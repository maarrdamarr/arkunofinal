<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Halaman Depan (Bisa diakses siapa saja)
// Halaman Depan
Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/news/{news}', [\App\Http\Controllers\HomeController::class, 'showNews'])->name('news.show');

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

    Route::get('/wallet', [\App\Http\Controllers\WalletController::class, 'adminIndex'])->name('wallet.index');
    Route::get('/wallet/history', [\App\Http\Controllers\WalletController::class, 'adminHistory'])->name('wallet.history');
    Route::post('/wallet/{id}/approve', [\App\Http\Controllers\WalletController::class, 'approve'])->name('wallet.approve');

    // Route Tambah Saldo Manual
    Route::post('/users/{id}/topup', [\App\Http\Controllers\WalletController::class, 'manualTopup'])->name('users.topup');
    // ROUTE INBOX SUPPORT
    Route::get('/support', [\App\Http\Controllers\SupportController::class, 'adminIndex'])->name('support.index');
    Route::get('/support/{userId}', [\App\Http\Controllers\SupportController::class, 'adminShow'])->name('support.show');
    Route::post('/support/{userId}/reply', [\App\Http\Controllers\SupportController::class, 'adminReply'])->name('support.reply');
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
        // Cari barang status 'closed', belum dibayar, dan user ini penawar tertingginya
        $wonItems = \App\Models\Item::where('status', 'closed')
            ->whereNull('paid_at')
            ->get()
            ->filter(function($item) {
                $highestBid = $item->bids()->orderBy('bid_amount', 'desc')->first();
                return $highestBid && $highestBid->user_id == Auth::id();
            });
        return view('bidder.wins.index', compact('wonItems'));
    })->name('wins.index');

    // Payment for won items
    Route::get('/my-wins/{id}/pay', [\App\Http\Controllers\WalletController::class, 'showPay'])->name('wins.pay');
    Route::post('/my-wins/{id}/pay', [\App\Http\Controllers\WalletController::class, 'pay'])->name('wins.pay.process');

    Route::get('/wallet', [\App\Http\Controllers\WalletController::class, 'index'])->name('wallet.index');
    Route::post('/wallet', [\App\Http\Controllers\WalletController::class, 'store'])->name('wallet.store');
});

// --- ROUTE PESAN (Bisa diakses Seller & Bidder) ---
Route::middleware('auth')->group(function() {
    Route::get('/inbox', [\App\Http\Controllers\MessageController::class, 'index'])->name('messages.index');
    Route::post('/message/{id}', [\App\Http\Controllers\MessageController::class, 'store'])->name('messages.store');
    Route::post('/comments/{item_id}', [\App\Http\Controllers\CommentController::class, 'store'])->middleware('auth')->name('comments.store');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/support/fetch', [\App\Http\Controllers\SupportController::class, 'fetchMessages'])->name('support.fetch');
    Route::post('/support/send', [\App\Http\Controllers\SupportController::class, 'store'])->name('support.store');
    Route::post('/support/update/{id}', [\App\Http\Controllers\SupportController::class, 'update'])->name('support.update');
    Route::delete('/support/delete/{id}', [\App\Http\Controllers\SupportController::class, 'destroy'])->name('support.destroy');
    // Simple user inbox page
    Route::get('/support/me', [\App\Http\Controllers\SupportController::class, 'userInbox'])->name('support.my');
});

// === ROUTE PROFIL (TAMBAHKAN INI) ===
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/support/send', [\App\Http\Controllers\SupportController::class, 'store'])->name('support.store');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Public contact form endpoint (guest allowed)
Route::post('/contact', [\App\Http\Controllers\SupportController::class, 'store'])->name('contact.send');

// Admin routes for guest conversations
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/support/guest/{email}', [\App\Http\Controllers\SupportController::class, 'adminShowGuest'])->name('support.showGuest');
    Route::post('/support/guest/{email}/reply', [\App\Http\Controllers\SupportController::class, 'adminReplyGuest'])->name('support.replyGuest');
});
