<?php
namespace App\Http\Controllers;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $itemId)
    {
        $request->validate(['body' => 'required']);
        
        Comment::create([
            'user_id' => Auth::id(),
            'item_id' => $itemId,
            'body' => $request->body
        ]);
        
        return back()->with('success', 'Pertanyaan terkirim!');
    }
}