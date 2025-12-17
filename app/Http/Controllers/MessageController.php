<?php
namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Item;
use App\Models\User;
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

    // Kirim Pesan (Dari Bidder ke Seller atau Seller ke Bidder)
    public function store(Request $request, $itemId)
    {
        $request->validate(['pesan' => 'required|string']);
        
        $item = Item::findOrFail($itemId);
        $authUser = Auth::user();

        // Jika pengirim adalah seller (pemilik barang), tujuan adalah pembeli
        // Jika pengirim adalah pembeli, tujuan adalah pemilik barang (seller)
        if ($authUser->id == $item->user_id) {
            // Seller mengirim pesan ke pembeli
            $receiverId = $request->input('buyer_id');
            if (!$receiverId) {
                if ($request->expectsJson() || $request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => 'Pilih pembeli terlebih dahulu'], 422);
                }
                return back()->withErrors('Pilih pembeli terlebih dahulu');
            }
        } else {
            // Bidder/pembeli mengirim pesan ke seller
            $receiverId = $item->user_id;
        }

        $message = Message::create([
            'sender_id' => $authUser->id,
            'receiver_id' => $receiverId,
            'item_id' => $itemId,
            'pesan' => $request->pesan,
        ]);

        // Return JSON for AJAX, otherwise redirect
        if ($request->expectsJson() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => $message]);
        }

        return back()->with('success', 'Pesan terkirim!');
    }

    // Seller melihat daftar pembeli yang bisa dia hubungi untuk item tertentu
    public function itemBuyers($itemId)
    {
        $item = Item::findOrFail($itemId);
        $authUser = Auth::user();

        // Hanya seller (pemilik item) yang bisa melihat daftar pembeli
        if ($authUser->id != $item->user_id) {
            return redirect()->back()->withErrors('Akses ditolak');
        }

        // Ambil semua pembeli yang pernah bid pada item ini
        $buyers = User::whereIn('id', function ($query) use ($itemId) {
            $query->select('user_id')
                ->from('bids')
                ->where('item_id', $itemId)
                ->distinct();
        })->get();

        return view('messages.item-buyers', compact('item', 'buyers'));
    }

    // Conversation dengan pembeli tertentu untuk item tertentu
    public function showWithBuyer($itemId, $buyerId)
    {
        $item = Item::findOrFail($itemId);
        $buyer = User::findOrFail($buyerId);
        $authUser = Auth::user();

        // Hanya seller atau buyer yang terlibat bisa melihat
        if ($authUser->id != $item->user_id && $authUser->id != $buyer->id) {
            return redirect()->back()->withErrors('Akses ditolak');
        }

        // Ambil pesan antara seller dan buyer untuk item ini
        $messages = Message::with(['sender', 'item'])
            ->where('item_id', $itemId)
            ->where(function ($query) use ($authUser, $buyer) {
                $query->where('sender_id', $authUser->id)
                      ->orWhere('receiver_id', $authUser->id);
            })
            ->latest()
            ->get();

        return view('messages.conversation', compact('item', 'buyer', 'messages'));
    }

    // Fetch conversation messages as JSON (AJAX polling)
    public function fetchConversation($itemId, $buyerId)
    {
        $item = Item::findOrFail($itemId);
        $buyer = User::findOrFail($buyerId);
        $authUser = Auth::user();

        // Hanya seller atau buyer yang terlibat bisa melihat
        if ($authUser->id != $item->user_id && $authUser->id != $buyer->id) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak'], 403);
        }

        $messages = Message::with('sender')
            ->where('item_id', $itemId)
            ->where(function ($query) use ($item, $buyer) {
                $query->where(function($q) use ($item, $buyer) {
                    $q->where('sender_id', $item->user_id)->where('receiver_id', $buyer->id);
                })->orWhere(function($q) use ($item, $buyer) {
                    $q->where('sender_id', $buyer->id)->where('receiver_id', $item->user_id);
                });
            })
            ->orderBy('created_at', 'asc')
            ->get();

        $data = $messages->map(function($m) {
            return [
                'id' => $m->id,
                'sender_id' => $m->sender_id,
                'sender_name' => $m->sender->name ?? 'System',
                'pesan' => $m->pesan,
                'created_at' => $m->created_at->toDateTimeString(),
            ];
        });

        return response()->json(['success' => true, 'messages' => $data]);
    }
}