<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BookController extends Controller
{
    //
    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $authors = Author::all();
        $publishers = Publisher::all();
        $categories = Category::all();
        return view('books.create', compact('authors', 'publishers', 'categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'isbn' => 'required|max:255|string',
            'title' => 'required|max:255|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'language' => 'required|max:255|string',
            'release_date' => 'required|date',
            'pages' => 'required|numeric',
            'publisher' => 'required|numeric',
            'authors' => 'required|array',
            'authors.*' => 'numeric',
            'categories' => 'required|array',
            'categories.*' => 'numeric',
            'path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adaugă regula pentru calea imaginii
        ]);

        // Salvarea cărții
        $book = new Book([
            'isbn' => $validatedData['isbn'],
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
            'language' => $validatedData['language'],
            'release_date' => $validatedData['release_date'],
            'pages' => $validatedData['pages'],
            'publisher_id' => $validatedData['publisher'],
            'path' => $request->file('path')->store('books', 'public'), // Salvarea imaginii în folderul 'storage/app/public/books'
        ]);

        $book->save();

        // Adăugarea autorilor cărții
        $book->authors()->attach($validatedData['authors']);

        // Adăugarea categoriilor cărții
        $book->categories()->attach($validatedData['categories']);

        return redirect()->route('admin.index')->with('success', 'Cartea a fost adăugată cu succes.');
    }

    public function edit(Book $book): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $authors = Author::all();
        $publishers = Publisher::all();
        $categories = Category::all();
        return view('books.edit', compact('book', 'authors', 'publishers', 'categories'));
    }

    public function update(Request $request, Book $book): RedirectResponse
    {
        $validatedData = $request->validate([
            'isbn' => 'required|max:255',
            'title' => 'required|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'language' => 'required|max:255',
            'release_date' => 'required|date',
            'pages' => 'required|numeric',
            'publisher' => 'required|exists:publishers,id',
            'authors' => 'required|array',
            'authors.*' => 'numeric|exists:authors,id',
            'categories' => 'required|array',
            'categories.*' => 'numeric|exists:categories,id',
        ]);

        // Actualizarea cărții
        $book->update([
            'isbn' => $validatedData['isbn'],
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
            'language' => $validatedData['language'],
            'release_date' => $validatedData['release_date'],
            'pages' => $validatedData['pages'],
            'publisher_id' => $validatedData['publisher'],
            // Actualizează și celelalte câmpuri, cum ar fi 'path' pentru imagine, 'authors' și 'categories'
        ]);

        // Actualizează imaginea, dacă este furnizată
        if ($request->hasFile('path')) {
            $imagePath = $request->file('path')->store('images/books');
            $book->path = $imagePath;
            $book->save();
        }

        // Actualizează relațiile many-to-many (autori și categorii)

        // Redirectează utilizatorul către pagina de editare cu un mesaj de succes
        return redirect()->route('books.edit', $book)->with('success', 'Datele au fost actualizate cu succes.');
    }

    public function destroy(Book $book): RedirectResponse
    {
        $book->authors()->detach();
        $book->categories()->detach();
        $book->delete();
        return redirect()->route('admin.index')->with('success', 'Cartea a fost ștearsă cu succes.');
    }
}
