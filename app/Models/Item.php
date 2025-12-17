<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

        protected $guarded = [];

        protected $casts = [
            'ends_at' => 'datetime',
        ];

        /**
         * Close this auction: mark closed; payment is settled when the winner confirms.
         */
        public function close()
        {
            if ($this->status === 'closed') {
                return false;
            }

            $this->status = 'closed';
            $this->save();

            return true;
        }

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

    public function comments() { return $this->hasMany(Comment::class)->latest(); }
public function review() { return $this->hasOne(Review::class); }
}
