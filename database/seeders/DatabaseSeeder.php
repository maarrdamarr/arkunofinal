<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Item;
use App\Models\News;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Akun ADMIN
        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'), // passwordnya: password
            'role' => 'admin',
        ]);

        // 2. Buat Akun SELLER (Penjual)
        $seller = User::create([
            'name' => 'Pak Penjual',
            'email' => 'seller@test.com',
            'password' => Hash::make('password'),
            'role' => 'seller',
        ]);

        // 3. Buat Akun BIDDER (Pembeli)
        User::create([
            'name' => 'Mas Pembeli',
            'email' => 'bidder@test.com',
            'password' => Hash::make('password'),
            'role' => 'bidder',
        ]);

        // 4. Buat Contoh Barang Antik (Milik Seller)
        Item::create([
            'user_id' => $seller->id,
            'name' => 'Guci Keramik Dinasti Ming',
            'description' => 'Guci asli peninggalan sejarah, kondisi mulus tanpa retak.',
            'start_price' => 5000000, // 5 Juta
            'status' => 'open',
            'image' => null, // Nanti kita urus gambar
        ]);

        Item::create([
            'user_id' => $seller->id,
            'name' => 'Jam Dinding Kuno 1890',
            'description' => 'Jam dinding kayu jati buatan Jerman, mesin masih berfungsi.',
            'start_price' => 1500000,
            'status' => 'open',
            'image' => null,
        ]);

        // 5. Buat Contoh Berita (Oleh Admin)
        News::create([
            'user_id' => $admin->id,
            'title' => 'Tips Merawat Barang Antik',
            'slug' => 'tips-merawat-barang-antik',
            'content' => 'Lorem ipsum dolor sit amet, cara merawat barang antik adalah...',
            'image' => null,
        ]);
    }
}