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
            'duration_hours' => 'nullable|numeric|min:1'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('items', 'public');
        }

        try {
            $endsAt = null;
            if ($request->filled('duration_hours')) {
                $endsAt = now()->addHours((int)$request->input('duration_hours'));
            } else {
                // read default duration from DB settings if available
                $default = (int) \App\Models\Setting::get('auction.default_duration_hours', config('auction.default_duration_hours', 24));
                $endsAt = now()->addHours($default);
            }

            Item::create([
                'user_id' => Auth::id(), // Otomatis set pemilik barang
                'name' => $request->name,
                'description' => $request->description,
                'start_price' => $request->start_price,
                'image' => $imagePath,
                'status' => 'open',
                'ends_at' => $endsAt,
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

        $item->close();

        return back()->with('success', 'Lelang ditutup! Pemenang telah ditentukan, menunggu pembayaran.');
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
            'duration_hours' => 'nullable|numeric|min:1'
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

        // update ends_at if provided
        if ($request->filled('duration_hours')) {
            $data['ends_at'] = now()->addHours((int)$request->input('duration_hours'));
        }

        try {
            $item->update($data);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui barang: ' . $e->getMessage());
        }

        return redirect()->route('seller.items.index')->with('success', 'Data barang berhasil diperbarui!');
    }
}
