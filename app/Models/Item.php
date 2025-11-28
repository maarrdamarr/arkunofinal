<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

        protected $guarded = [];

        // Barang milik satu user (Seller)
        public function user() {
            return $this->belongsTo(User::class);
        }

        // Barang punya banyak tawaran (Bids)
        public function bids() {
            return $this->hasMany(Bid::class)->orderBy('bid_amount', 'desc');
        }
        
        // Helper untuk mengambil tawaran tertinggi
        public function highestBid() {
            return $this->bids()->first();
    }
    public function wishlists() {
        return $this->hasMany(Wishlist::class);
    }

    public function messages() {
        return $this->hasMany(Message::class);
    }
}
