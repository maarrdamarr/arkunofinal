<?php
namespace App\Http\Controllers;
use App\Models\Topup;
use App\Models\User;
use App\Models\Item;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    // BIDDER: Halaman Dompet
    public function index() {
        $topups = Topup::where('user_id', Auth::id())->latest()->get();
        return view('bidder.wallet.index', compact('topups'));
    }

    // BIDDER: Request Topup
    public function store(Request $request) {
        $request->validate(['amount' => 'required|numeric|min:10000']);
        $topup = Topup::create([
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'status' => 'pending',
            'reference_type' => 'user_topup_request',
            'reference_id' => Auth::id(),
            'meta' => ['requested_via' => 'web']
        ]);

        // Audit: user requested topup
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'request_topup',
            'auditable_type' => 'Topup',
            'auditable_id' => $topup->id,
            'old_data' => null,
            'new_data' => $topup->toArray(),
            'ip' => $request->ip()
        ]);

        return back()->with('success', 'Permintaan top-up dikirim. Tunggu konfirmasi Admin.');
    }

    // ADMIN: Halaman Approval Topup
    public function adminIndex() {
        $topups = Topup::with('user')->where('status', 'pending')->latest()->get();
        return view('admin.wallet.index', compact('topups'));
    }

    // ADMIN: History Semua Transaksi Saldo (Topup + Pembayaran Lelang)
    public function adminHistory() {
        $transactions = Topup::with('user')->latest()->get();
        return view('admin.wallet.history', compact('transactions'));
    }

    // ADMIN: Approve Topup
    public function approve(Request $request, $id) {
        $topup = Topup::findOrFail($id);

        $old = $topup->toArray();
        $topup->update(['status' => 'approved']);

        // Tambah saldo user
        $user = User::find($topup->user_id);
        $user->balance += $topup->amount;
        $user->save();

        // Audit: admin approved topup
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'approve_topup',
            'auditable_type' => 'Topup',
            'auditable_id' => $topup->id,
            'old_data' => $old,
            'new_data' => $topup->toArray(),
            'ip' => $request->ip()
        ]);

        return back()->with('success', 'Top-up disetujui, saldo user bertambah.');
    }
    // ADMIN: Tambah Saldo Manual ke User Tertentu
    public function manualTopup(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $user = User::findOrFail($id);

        // 1. Tambah ke History Topup (Status langsung Approved)
        $topup = Topup::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'status' => 'approved', // Langsung sukses
            'reference_type' => 'manual_topup',
            'reference_id' => Auth::id(),
            'meta' => ['note' => $request->input('note')] 
        ]);

        // 2. Update Saldo User
        $user->balance += $request->amount;
        $user->save();

        // Audit: manual topup by admin
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'manual_topup',
            'auditable_type' => 'Topup',
            'auditable_id' => $topup->id,
            'old_data' => null,
            'new_data' => $topup->toArray(),
            'ip' => $request->ip()
        ]);

        return back()->with('success', 'Berhasil menambahkan Rp ' . number_format($request->amount) . ' ke saldo ' . $user->name);
    }

    // Show payment confirmation for a won item
    public function showPay($id)
    {
        $item = Item::with('bids')->findOrFail($id);
        $highestBid = $item->bids()->orderBy('bid_amount', 'desc')->first();

        // Ensure current user is the winner
        if (!$highestBid || $highestBid->user_id != Auth::id()) {
            return redirect()->route('bidder.wins.index')->with('error', 'Anda bukan pemenang item ini.');
        }

        if ($item->status !== 'closed') {
            return redirect()->route('bidder.wins.index')->with('error', 'Lelang belum ditutup.');
        }

        if ($item->paid_at) {
            return redirect()->route('bidder.wins.index')->with('success', 'Item ini sudah dibayar.');
        }

        return view('bidder.wins.pay', compact('item', 'highestBid'));
    }

    // Process payment for a won item
    public function pay(Request $request, $id)
    {
        $item = Item::with('bids')->findOrFail($id);
        $highestBid = $item->bids()->orderBy('bid_amount', 'desc')->first();

        if (!$highestBid || $highestBid->user_id != Auth::id()) {
            return redirect()->route('bidder.wins.index')->with('error', 'Anda bukan pemenang item ini.');
        }

        if ($item->status !== 'closed') {
            return redirect()->route('bidder.wins.index')->with('error', 'Lelang belum ditutup.');
        }

        if ($item->paid_at) {
            return redirect()->route('bidder.wins.index')->with('success', 'Item ini sudah dibayar.');
        }

        $amount = $highestBid->bid_amount;

        $user = User::find(Auth::id());

        DB::transaction(function() use ($user, $amount, $item, $highestBid) {
            // Record payment using the balance already held during bidding
            $buyerTopup = Topup::create([
                'user_id' => $user->id,
                'amount' => -1 * $amount,
                'status' => 'approved',
                'reference_type' => 'Item',
                'reference_id' => $item->id,
                'meta' => ['bid_id' => $highestBid->id, 'note' => 'payment settled from bid hold']
            ]);

            // Mark item as paid
            $item->paid_at = now();
            $item->save();

            // CREDIT SELLER: tambahkan saldo ke pemilik item (seller)
            $seller = User::find($item->user_id);
            if ($seller) {
                $seller->balance += $amount;
                $seller->save();

                // Catat sebagai Topup (positif) untuk riwayat seller
                $sellerTopup = Topup::create([
                    'user_id' => $seller->id,
                    'amount' => $amount,
                    'status' => 'approved',
                    'reference_type' => 'Item',
                    'reference_id' => $item->id,
                    'meta' => ['bid_id' => $highestBid->id, 'note' => 'seller payout']
                ]);

                // Audit: record both buyer payment and seller credit
                AuditLog::create([
                    'user_id' => Auth::id(),
                    'action' => 'pay_item',
                    'auditable_type' => 'Item',
                    'auditable_id' => $item->id,
                    'old_data' => null,
                    'new_data' => ['buyer_topup' => $buyerTopup->toArray(), 'seller_topup' => $sellerTopup->toArray()],
                    'ip' => request()->ip()
                ]);
            }
        });

        return redirect()->route('bidder.wins.index')->with('success', 'Pembayaran berhasil menggunakan saldo lelang.');
    }
}
