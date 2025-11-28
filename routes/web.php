<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Halaman Depan (Bisa diakses siapa saja)
Route::get('/', function () {
    return view('welcome');
});

// Redirect Dashboard sesuai Role
Route::get('/dashboard', function () {
    $role = Auth::user()->role;
    if ($role === 'admin') return redirect()->route('admin.dashboard');
    if ($role === 'seller') return redirect()->route('seller.dashboard');
    return redirect()->route('bidder.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// GROUP 1: ADMIN (Hanya Admin yang boleh masuk)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard', function () {
        return view('admin.dashboard'); // Nanti kita buat view ini
    })->name('dashboard');

    // Nanti tambah route manage user, approve barang, berita di sini
});


// GROUP 2: SELLER (Hanya Seller yang boleh masuk)
Route::middleware(['auth', 'role:seller'])->prefix('seller')->name('seller.')->group(function () {
    
    Route::get('/dashboard', function () {
        return view('seller.dashboard'); // Nanti kita buat view ini
    })->name('dashboard');

    // Nanti tambah route upload barang di sini
});


// GROUP 3: BIDDER / PEMBELI (Bisa Bidder, tapi Admin/Seller juga boleh lihat kalau mau)
Route::middleware(['auth', 'role:bidder|admin|seller'])->prefix('bidder')->name('bidder.')->group(function () {
    
    Route::get('/dashboard', function () {
        return view('bidder.dashboard'); // Nanti kita buat view ini
    })->name('dashboard');

    // Nanti tambah route bidding di sini
});


// Route Bawaan Breeze (Profile, Logout, dll)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';