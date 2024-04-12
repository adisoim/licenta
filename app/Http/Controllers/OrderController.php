<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Stripe\Charge;
use Stripe\Stripe;

class OrderController extends Controller
{
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
            'postal_code' => 'required|string',
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
                'postal_code' => $validated['postal_code'],
                'note' => $validated['note']
            ]);

            $order->save();

            $cart = session()->get('cart', []);
            foreach ($cart as $id => $details) {
                $order->books()->attach($id, ['quantity' => $details['quantity']]);
            }

            session()->forget('cart');

            return redirect()->route('home')->with('success', 'Comanda a fost plasată și plata procesată cu succes.');
        } catch (\Exception $e) {
            Log::error('Exception occurred', ['message' => $e->getMessage(), 'stackTrace' => $e->getTraceAsString()]);
            return back()->withErrors('Eroare la procesarea plății: ' . $e->getMessage());
        }
    }
}
