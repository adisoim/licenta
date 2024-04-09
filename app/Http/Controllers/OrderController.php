<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Stripe\Charge;
use Stripe\Stripe;

class OrderController extends Controller
{
    public function place(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            // Include "total" și "stripeToken" în validare
            'total' => 'numeric|min:0',
            'stripeToken' => 'required|string',
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'address' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string',
            'note' => 'nullable|string'
        ]);

        // Setează cheia API a Stripe
        Stripe::setApiKey(env('STRIPE_SECRET'));
        try {
            // Încercarea de a efectua plata prin Stripe
            $charge = Charge::create([
                'amount' => $validated['total'] * 100, // Stripe lucrează cu cenți
                'currency' => 'usd',
                'description' => 'Plată comandă',
                'source' => $validated['stripeToken'],
            ]);

            // Salvarea comenzii în baza de date
            $order = new Order([
                'user_id' => Auth::id(),
                'total' => $validated['total'],
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'postal_code' => $validated['postal_code'],
                'note' => $validated['note']
            ]);

            $order = new Order([
                'user_id' => Auth::id(),
                'total' => $validated['total'],
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'postal_code' => $validated['postal_code'],
                'note' => $validated['note']
            ]);

            $order->save(); // Salvează comanda în baza de date înainte de a atașa cărțile

            $cart = session()->get('cart', []);
            foreach ($cart as $id => $details) {
                $order->books()->attach($id, ['quantity' => $details['quantity']]);
                // Presupunând că ai o coloană `quantity` în tabelul pivot `book_order`
            }

            // Golește coșul de cumpărături după ce comanda este finalizată
            session()->forget('cart');

            return redirect()->route('home')->with('success', 'Comanda a fost plasată și plata procesată cu succes.');
        } catch (\Exception $e) {
            Log::error('Exception occurred', ['message' => $e->getMessage(), 'stackTrace' => $e->getTraceAsString()]);
            return back()->withErrors('Eroare la procesarea plății: ' . $e->getMessage());
        }
    }
}
