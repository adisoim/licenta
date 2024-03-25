<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    //
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('contacts.create');
    }
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required',
            'phone' => 'required',
            'subject' => 'required',
            'message' => 'required'
        ]);

        if(Auth::check()) {
            $validatedData['user_id'] = Auth::id();
        }

        Contact::create($validatedData);

        return redirect()->route('contacts.index')->with('success', 'Datele au fost trimise cu succes.');
    }
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Contactul a fost șters cu succes.');
    }
}
