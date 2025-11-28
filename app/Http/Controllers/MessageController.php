<?php
namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    // Halaman Inbox
    public function index()
    {
        // Ambil pesan di mana user login adalah penerimanya
        $messages = Message::with(['sender', 'item'])
            ->where('receiver_id', Auth::id())
            ->latest()
            ->get();

        return view('messages.index', compact('messages'));
    }

    // Kirim Pesan (Dari Bidder ke Seller)
    public function store(Request $request, $itemId)
    {
        $item = Item::findOrFail($itemId);
        
        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $item->user_id, // Pemilik barang
            'item_id' => $itemId,
            'message' => $request->message,
        ]);

        return back()->with('success', 'Pesan terkirim ke penjual!');
    }
}