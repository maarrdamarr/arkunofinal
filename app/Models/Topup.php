<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topup extends Model
{
    use HasFactory;

    // Tambahkan baris ini agar semua kolom bisa diisi
    protected $guarded = [];
    protected $casts = [
        'meta' => 'array',
    ];

    protected $fillable = [
        'user_id', 'amount', 'status', 'reference_type', 'reference_id', 'meta'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper untuk menentukan tipe transaksi
    public function getTypeAttribute()
    {
        // Jika amount negatif -> debit (keluar), jika positif -> credit (masuk)
        if ($this->amount < 0) return 'debit';
        return 'credit';
    }
}
