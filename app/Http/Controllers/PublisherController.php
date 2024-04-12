<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Publisher;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('publishers.create');
    }
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'address' => 'required|max:255',
            'phone' => 'required|max:255'
        ]);
        Publisher::create($validatedData);
        return redirect()->route('admin.index')->with('success', 'Editura a fost adăugată cu succes.');
    }
    public function edit(Publisher $publisher): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('publishers.edit', compact('publisher'));
    }
    public function update(Request $request, Publisher $publisher): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'address' => 'required|max:255',
            'phone' => 'required|max:255'
        ]);

        $publisher->update($validatedData);

        return redirect()->route('publishers.edit', $publisher)->with('success', 'Datele au fost actualizate cu succes.');
    }
    public function destroy(Publisher $publisher): RedirectResponse
    {
        $publisher->delete();

        return redirect()->route('admin.index')->with('success', 'Editura a fost ștearsă cu succes.');
    }
}
