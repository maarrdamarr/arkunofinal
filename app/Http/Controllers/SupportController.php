<?php

namespace App\Http\Controllers;

use App\Models\SupportMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class SupportController extends Controller
{
    // 1. Ambil Pesan (Untuk dimuat di kotak chat)
    public function fetchMessages()
    {
        // If admin opens the widget, we don't render user chat bubbles here — direct them to the Admin Inbox
        if (Auth::user()->role == 'admin') {
            return '<div class="p-3 text-muted">Mode admin: gunakan Inbox Admin untuk melihat percakapan.</div>';
        }

        $messages = SupportMessage::where('user_id', Auth::id())->oldest()->get();
        return view('partials.chat-bubbles', compact('messages'))->render();
    }

    // 2. Kirim Pesan
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required',
            'name' => 'nullable|string|max:191',
            'email' => 'nullable|email|max:191',
        ]);

        // If user is authenticated, attach user_id; otherwise store guest info
        if (Auth::check()) {
            $userId = Auth::id();
            $isAdminReply = Auth::user()->role == 'admin';
            $guestName = null; $guestEmail = null;
        } else {
            $userId = null;
            $isAdminReply = false;
            $guestName = $request->input('name');
            $guestEmail = $request->input('email');
        }

        $msg = SupportMessage::create([
            'user_id' => $userId,
            'message' => $request->message,
            'is_admin_reply' => $isAdminReply,
            'guest_name' => $guestName,
            'guest_email' => $guestEmail,
        ]);

        // If request expects JSON (AJAX), return JSON; otherwise redirect back to welcome with flash
        if ($request->expectsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest' || $request->ajax()) {
            return response()->json(['success' => true, 'id' => $msg->id, 'message' => 'Pesan terkirim']);
        }

        return redirect()->route('home')->with('success', 'Pesan Anda telah terkirim. Terima kasih!');
    }

    // 3. Update Pesan (Edit)
    public function update(Request $request, $id)
    {
        $msg = SupportMessage::findOrFail($id);

        // Hanya pemilik pesan yang boleh edit
        if ($msg->user_id != Auth::id() && Auth::user()->role != 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $msg->update(['message' => $request->message]);
        return response()->json(['success' => true]);
    }

    

    // 4. Hapus Pesan
    public function destroy($id)
    {
        $msg = SupportMessage::findOrFail($id);

        // Pemilik boleh hapus, Admin boleh hapus siapa saja
        if ($msg->user_id == Auth::id() || Auth::user()->role == 'admin') {
            $msg->delete();
            return response()->json(['success' => true]);
        }
        
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    // --- KHUSUS ADMIN ---

    // 1. Halaman Daftar Percakapan (Inbox)
    public function adminIndex()
    {
        // Build conversations list: users and guests
        $conversations = [];

        // Users
        $byUser = SupportMessage::whereNotNull('user_id')
                ->select('user_id', DB::raw('max(created_at) as last'))
                    ->groupBy('user_id')
                    ->orderByDesc('last')
                    ->get();

        foreach ($byUser as $b) {
            $u = User::find($b->user_id);
            if (!$u) continue;
            $conversations[] = (object)[
                'type' => 'user',
                'id' => $u->id,
                'name' => $u->name,
                'email' => $u->email,
                'avatar' => $u->avatar ?? null,
                'role' => $u->role ?? 'user',
                'last' => $b->last,
            ];
        }

        // Guests (group by guest_email)
        $byGuest = SupportMessage::whereNull('user_id')
                ->select('guest_email', DB::raw('max(created_at) as last'))
                    ->groupBy('guest_email')
                    ->orderByDesc('last')
                    ->get();

        foreach ($byGuest as $g) {
            // get latest message for guest to extract name
            $latest = SupportMessage::where('guest_email', $g->guest_email)->latest()->first();
            $conversations[] = (object)[
                'type' => 'guest',
                'id' => $g->guest_email, // use email as identifier
                'name' => $latest->guest_name ?? ($g->guest_email ?? 'Guest'),
                'email' => $g->guest_email,
                'avatar' => null,
                'role' => 'guest',
                'last' => $g->last,
            ];
        }

        // Sort by last desc
        usort($conversations, function($a, $b) { return strtotime($b->last) <=> strtotime($a->last); });

        return view('admin.support.index', ['users' => collect($conversations)]);
    }

    // 2. Halaman Detail Chat dengan User Tertentu
    public function adminShow($userId)
    {
        $user = User::findOrFail($userId);

        // Ambil semua pesan milik user ini (baik kiriman dia maupun balasan admin untuk dia)
        $messages = SupportMessage::where('user_id', $userId)->oldest()->get();

        return view('admin.support.show', compact('user', 'messages'));
    }

    // Show conversation for guest by email
    public function adminShowGuest($email)
    {
        $decoded = urldecode($email);
        $messages = SupportMessage::where('guest_email', $decoded)->oldest()->get();
        $latest = $messages->last();
        $user = (object)[
            'id' => null,
            'name' => $latest->guest_name ?? $decoded,
            'email' => $decoded,
        ];

        return view('admin.support.show', compact('user', 'messages'));
    }

    // 3. Admin Membalas Pesan
    public function adminReply(Request $request, $userId)
    {
        $request->validate(['message' => 'required']);
        SupportMessage::create([
            'user_id' => $userId, // Penting: ID ini adalah ID User (Lawan Bicara), bukan ID Admin
            'message' => $request->message,
            'is_admin_reply' => true // Tandai sebagai balasan admin
        ]);

        return back()->with('success', 'Balasan terkirim!');
    }

    // Admin reply to guest
    public function adminReplyGuest(Request $request, $email)
    {
        $request->validate(['message' => 'required']);
        $decoded = urldecode($email);

        SupportMessage::create([
            'user_id' => null,
            'guest_name' => $request->input('guest_name'),
            'guest_email' => $decoded,
            'message' => $request->message,
            'is_admin_reply' => true
        ]);

        return back()->with('success', 'Balasan terkirim!');
    }

    // Simple user inbox page for authenticated sellers/bidders
    public function userInbox()
    {
        $user = Auth::user();
        $messages = SupportMessage::where('user_id', $user->id)->oldest()->get();
        // Also gather items this bidder has bid on so they can message sellers
        $itemIds = \App\Models\Bid::where('user_id', $user->id)->select('item_id')->distinct()->pluck('item_id')->toArray();
        $items = \App\Models\Item::whereIn('id', $itemIds)->with('user')->get();

        return view('support.user', compact('user', 'messages', 'items'));
    }
}