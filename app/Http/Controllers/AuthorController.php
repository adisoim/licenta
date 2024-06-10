<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('authors.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'birthdate' => 'required|date',
            'biography' => 'required'
        ]);
        Author::create($validatedData);
        return redirect()->route('authors.create')->with('success', 'Autorul a fost adăugat cu succes.');
    }

    public function edit(Author $author): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('authors.edit', compact('author'));
    }

    public function update(Request $request, Author $author): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'birthdate' => 'required|date',
            'biography' => 'required|max:255'
        ]);
        $author->update($validatedData);
        return redirect()->route('authors.edit', $author)->with('success', 'Datele au fost actualizate cu succes.');
    }

    public function destroy(Author $author): RedirectResponse
    {
        $author->delete();
        return redirect()->route('admin.index')->with('success', 'Autorul a fost șters cu succes.');
    }
}
