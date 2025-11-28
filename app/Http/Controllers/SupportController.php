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
        if (Auth::user()->role == 'admin') {
            // Admin melihat chat berdasarkan user_id yang dipilih (nanti via parameter)
            // Untuk simple-nya di widget ini, Admin hanya melihat chat dia sendiri dulu sebagai demo
            // Atau kita buat Admin merespon via dashboard khusus nanti.
            return response()->json(['status' => 'admin_mode']);
        }

        $messages = SupportMessage::where('user_id', Auth::id())->oldest()->get();
        return view('partials.chat-bubbles', compact('messages'))->render();
    }

    // 2. Kirim Pesan
    public function store(Request $request)
    {
        $request->validate(['message' => 'required']);

        SupportMessage::create([
            'user_id' => Auth::id(), // Jika admin yg login, dia chat sebagai dirinya sendiri atau balasan (nanti)
            'message' => $request->message,
            'is_admin_reply' => Auth::user()->role == 'admin'
        ]);

        return response()->json(['success' => true]);
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
        // Ambil User yang pernah mengirim pesan
        // Kita gunakan whereHas untuk mencari user yang punya data di support_messages
        $users = User::whereHas('supportMessages')
                    ->withCount(['supportMessages as latest_message_time' => function($query) {
                        $query->select(\Illuminate\Support\Facades\DB::raw('max(created_at)'));
                    }])
                    ->orderByDesc('latest_message_time')
                    ->get();

        return view('admin.support.index', compact('users'));
    }

    // 2. Halaman Detail Chat dengan User Tertentu
    public function adminShow($userId)
    {
        $user = User::findOrFail($userId);
        
        // Ambil semua pesan milik user ini (baik kiriman dia maupun balasan admin untuk dia)
        $messages = SupportMessage::where('user_id', $userId)
                                  ->oldest()
                                  ->get();

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
}