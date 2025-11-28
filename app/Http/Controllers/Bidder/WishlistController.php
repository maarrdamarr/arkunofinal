<?php
namespace App\Http\Controllers\Bidder;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // Toggle (Like/Unlike)
    public function toggle($itemId)
    {
        $exists = Wishlist::where('user_id', Auth::id())->where('item_id', $itemId)->first();

        if ($exists) {
            $exists->delete();
            return back()->with('success', 'Dihapus dari favorit.');
        } else {
            Wishlist::create(['user_id' => Auth::id(), 'item_id' => $itemId]);
            return back()->with('success', 'Ditambahkan ke favorit!');
        }
    }

    // List Favorit Saya
    public function index()
    {
        $wishlists = Wishlist::with('item')->where('user_id', Auth::id())->get();
        return view('bidder.wishlist.index', compact('wishlists'));
    }
}