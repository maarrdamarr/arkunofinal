<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    // 1. Tampilkan Barang Milik Seller Sendiri
    public function index()
    {
        $items = Item::where('user_id', Auth::id())->latest()->get();
        return view('seller.items.index', compact('items'));
    }

    // 2. Form Tambah Barang
    public function create()
    {
        return view('seller.items.create');
    }

    // 3. Simpan Barang
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_price' => 'required|numeric|min:1000',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('items', 'public');
        }

        try {
            Item::create([
                'user_id' => Auth::id(), // Otomatis set pemilik barang
                'name' => $request->name,
                'description' => $request->description,
                'start_price' => $request->start_price,
                'image' => $imagePath,
                'status' => 'open',
            ]);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal menyimpan barang: ' . $e->getMessage());
        }

        return redirect()->route('seller.items.index')->with('success', 'Barang berhasil diupload dan lelang dimulai!');
    }

    // 4. Hapus Barang
    public function destroy(Item $item)
    {
        // Pastikan yang menghapus adalah pemiliknya
        if ($item->user_id !== Auth::id()) {
            abort(403);
        }

        if ($item->image) {
            Storage::disk('public')->delete($item->image);
        }
        
        $item->delete();
        return redirect()->route('seller.items.index')->with('success', 'Barang dihapus.');
    }
    // Fitur Tutup Lelang & Tentukan Pemenang
    public function closeAuction($id)
    {
        $item = Item::where('user_id', Auth::id())->findOrFail($id);

        // Ubah status jadi closed
        $item->update(['status' => 'closed']);

        // Cari pemenang (bid tertinggi)
        $winningBid = $item->highestBid();
        if ($winningBid) {
            // Transfer uang dari bidder ke seller (bidder sudah bayar saat bidding)
            $winner = $winningBid->user;
            $seller = $item->user;

            // Tambah saldo seller
            $seller->balance += $winningBid->bid_amount;
            $seller->save();

            // Record topup sebagai "pembayaran dari lelang"
            \App\Models\Topup::create([
                'user_id' => $seller->id,
                'amount' => $winningBid->bid_amount,
                'status' => 'approved', // Langsung approved karena hasil lelang
            ]);
        }

        return back()->with('success', 'Lelang ditutup! Pemenang telah ditentukan dan pembayaran diproses.');
    }
    // MENAMPILKAN FORM EDIT
    public function edit(Item $item)
    {
        // Pastikan barang milik seller yang login
        if ($item->user_id !== Auth::id()) {
            abort(403);
        }
        return view('seller.items.edit', compact('item'));
    }

    // SIMPAN PERUBAHAN
    public function update(Request $request, Item $item)
    {
        // Validasi Milik Sendiri
        if ($item->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_price' => 'required|numeric|min:1000',
            'image' => 'nullable|image|max:2048', // Opsional, kalau mau ganti foto
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'start_price' => $request->start_price,
        ];

        // Logika Ganti Foto
        if ($request->hasFile('image')) {
            // Hapus foto lama di server agar hemat penyimpanan
            if ($item->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($item->image);
            }
            // Upload foto baru
            $data['image'] = $request->file('image')->store('items', 'public');
        }

        try {
            $item->update($data);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui barang: ' . $e->getMessage());
        }

        return redirect()->route('seller.items.index')->with('success', 'Data barang berhasil diperbarui!');
    }
}
