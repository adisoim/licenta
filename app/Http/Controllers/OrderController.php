<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Order;
use App\Models\Publisher;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Stripe\Charge;
use Stripe\Stripe;

class OrderController extends Controller
{
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $orders = Order::with('user', 'books')->get();

        $books = Book::all();
        $authors = Author::all();
        $categories = Category::all();
        $publishers = Publisher::all();
        $contacts = Contact::all();

        return view('admin.index', compact('books', 'authors', 'categories', 'publishers', 'orders', 'contacts'));
    }

    public function confirmation(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('cart.confirmation');
    }

    public function show(Order $order): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $order->load('books');
        return view('orders.show', compact('order'));
    }

    public function destroy(): RedirectResponse
    {
        $order = Order::find(request('order'));
        $order->delete();

        return redirect()->route('admin.index')->with('success', 'Comanda a fost ștearsă cu succes.');
    }

    public function userOrders(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $userId = auth()->id(); // Obținerea ID-ului utilizatorului autentificat
        $orders = Order::where('user_id', $userId)->with('books')->orderBy('created_at', 'desc')->get();

        return view('orders.user', compact('orders')); // Returnarea unei vederi cu comenzile utilizatorului
    }

    public function place(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'total' => 'numeric|min:0',
            'stripeToken' => 'required|string',
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'address' => 'required|string',
            'city' => 'required|string',
            'note' => 'nullable|string'
        ]);

        Stripe::setApiKey(env('STRIPE_SECRET'));
        try {
            $charge = Charge::create([
                'amount' => $validated['total'] * 100,
                'currency' => 'usd',
                'description' => 'Plată comandă',
                'source' => $validated['stripeToken'],
            ]);

            $order = new Order([
                'user_id' => Auth::id(),
                'total' => $validated['total'],
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'note' => $validated['note']
            ]);

            $order->save();

            $cart = session()->get('cart', []);
            foreach ($cart as $id => $details) {
                $order->books()->attach($id, ['quantity' => $details['quantity']]);
            }

            session()->forget('cart');

            return redirect()->route('cart.confirmation')->with('success', 'Comanda a fost plasată și plata procesată cu succes.');
        } catch (\Exception $e) {
            Log::error('Exception occurred', ['message' => $e->getMessage(), 'stackTrace' => $e->getTraceAsString()]);
            return back()->withErrors('Eroare la procesarea plății: ' . $e->getMessage());
        }
    }
}
