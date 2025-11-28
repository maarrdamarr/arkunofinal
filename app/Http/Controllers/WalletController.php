<?php
namespace App\Http\Controllers;
use App\Models\Topup;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        Topup::create([
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'status' => 'pending'
        ]);
        return back()->with('success', 'Permintaan top-up dikirim. Tunggu konfirmasi Admin.');
    }

    // ADMIN: Halaman Approval
    public function adminIndex() {
        $topups = Topup::with('user')->where('status', 'pending')->latest()->get();
        return view('admin.wallet.index', compact('topups'));
    }

    // ADMIN: Approve Topup
    public function approve($id) {
        $topup = Topup::findOrFail($id);
        $topup->update(['status' => 'approved']);
        
        // Tambah saldo user
        $user = User::find($topup->user_id);
        $user->balance += $topup->amount;
        $user->save();

        return back()->with('success', 'Top-up disetujui, saldo user bertambah.');
    }
}