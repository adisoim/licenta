<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $wishlistItems = Wishlist::where('user_id', $userId)->with('book')->get();

        return view('wishlists.index', compact('wishlistItems'));
    }

    public function add(Request $request): JsonResponse
    {
        $userId = Auth::id();
        $bookId = $request->input('book_id');

        $wishlist = Wishlist::where('user_id', $userId)->where('book_id', $bookId)->first();

        if ($wishlist) {
            $wishlist->delete();
            return response()->json(['success' => true, 'action' => 'removed']);
        } else {
            Wishlist::create([
                'user_id' => $userId,
                'book_id' => $bookId,
            ]);
            return response()->json(['success' => true, 'action' => 'added']);
        }
    }

    public function remove(Request $request): RedirectResponse
    {
        $bookId = $request->input('book_id');
        $userId = Auth::id();

        Wishlist::where('user_id', $userId)->where('book_id', $bookId)->delete();

        return redirect()->back()->with('success', 'Cartea a fost ștearsă din wishlist.');
    }
}
