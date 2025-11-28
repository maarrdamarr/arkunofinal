<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Item;
use App\Models\News;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // 1. DASHBOARD UTAMA (Statistik & Laporan)
    public function dashboard()
    {
        // Hitung Statistik Real
        $totalUsers = User::where('role', '!=', 'admin')->count();
        $totalItems = Item::count();
        $totalNews  = News::count();
        $totalBids  = \App\Models\Bid::count(); // Total penawaran masuk

        // Ambil data barang yang sudah laku (Status closed)
        $soldItems = Item::where('status', 'closed')->with(['bids', 'user'])->latest()->get();

        return view('admin.dashboard', compact('totalUsers', 'totalItems', 'totalNews', 'totalBids', 'soldItems'));
    }

    // 2. MANAJEMEN USER (List & Hapus)
    public function users()
    {
        $users = User::where('role', '!=', 'admin')->latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return back()->with('success', 'User berhasil dihapus/banned.');
    }

    // 3. PENGAWASAN BARANG (List Semua Barang Seller)
    public function items()
    {
        $items = Item::with('user')->latest()->get();
        return view('admin.items.index', compact('items'));
    }

    public function destroyItem($id)
    {
        $item = Item::findOrFail($id);
        
        // Hapus gambar jika ada
        if($item->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($item->image);
        }
        
        $item->delete();
        return back()->with('success', 'Barang berhasil dihapus paksa oleh Admin.');
    }
}