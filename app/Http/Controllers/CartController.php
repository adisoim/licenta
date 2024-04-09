<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cart(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function checkout(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return view('cart.checkout', compact('cart', 'total'));
    }

    public function add($id): RedirectResponse
    {
        $book = Book::find($id);
        if (!$book) {
            return redirect()->back()->with('error', 'Produsul nu există.');
        }

        $cart = session()->get('cart');

        // dacă cart este gol, adăugați primul produs
        if (!$cart) {
            $cart = [
                $id => [
                    "title" => $book->title,
                    "quantity" => 1,
                    "price" => $book->price,
                    "path" => $book->path
                ]
            ];
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Produs adăugat cu succes în coș!');
        }

        // dacă produsul există deja în coș, creșteți cantitatea
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            // altfel, adăugați produsul cu cantitatea 1
            $cart[$id] = [
                "title" => $book->title,
                "quantity" => 1,
                "price" => $book->price,
                "path" => $book->path
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Produs adăugat cu succes în coș!');
    }

    public function update(Request $request): RedirectResponse
    {
        $cart = session()->get('cart');
        if ($request->id && $request->quantity && isset($cart[$request->id])) {
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Cos modificat cu succes');
        }
        return redirect()->route('cart.index');
    }

    public function remove(Request $request): RedirectResponse
    {
        $cart = session()->get('cart');
        if ($request->id && isset($cart[$request->id])) {
            unset($cart[$request->id]);
            session()->put('cart', $cart);
            session()->flash('success', 'Produs șters cu succes!');
        }
        return redirect()->route('cart.index');
    }

    public function empty(): RedirectResponse
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Coșul de cumpărături a fost golit cu succes!');
    }
}
