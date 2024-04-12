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
    public function index(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $books = Book::all();
        return view('books.index', compact('books'));
    }

    public function show(Book $book): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('books.show', compact('book'));
    }

    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $authors = Author::all();
        $publishers = Publisher::all();
        $categories = Category::all();
        return view('books.create',compact('authors', 'publishers', 'categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'isbn' => 'required|numeric',
            'title' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'language' => 'required',
            'release_date' => 'required|date',
            'pages' => 'required|integer',
            'publisher' => 'required|exists:publishers,id', // Asigură-te că editorul există
            'authors' => 'required|exists:authors,id', // Validează autorii
            'categories' => 'required|exists:categories,id', // Validează categoriile
            'path' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validează imaginea
        ]);

        if ($request->hasFile('path')) {
            $image = $request->file('path');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/books'), $imageName);
        }

        $book = new Book([
            'isbn' => $validatedData['isbn'],
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
            'language' => $validatedData['language'],
            'release_date' => $validatedData['release_date'],
            'pages' => $validatedData['pages'],
            'publisher_id' => $validatedData['publisher'],
            'path' => $imageName ?? null,
        ]);

        $book->save();

        $book->authors()->attach($validatedData['authors']);
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

        $book->update([
            'isbn' => $validatedData['isbn'],
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
            'language' => $validatedData['language'],
            'release_date' => $validatedData['release_date'],
            'pages' => $validatedData['pages'],
            'publisher_id' => $validatedData['publisher'],
        ]);

        if ($request->hasFile('path')) {
            $image = $request->file('path');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/books'), $imageName);

            $book->path = 'images/books/' . $imageName;
            $book->save();
        }

        $book->authors()->sync($validatedData['authors']);
        $book->categories()->sync($validatedData['categories']);

        return redirect()->route('books.edit', $book)->with('success', 'Cartea a fost actualizată cu succes.');
    }

    public function destroy(Book $book): RedirectResponse
    {
        $book->authors()->detach();
        $book->categories()->detach();
        $book->delete();
        return redirect()->route('admin.index')->with('success', 'Cartea a fost ștearsă cu succes.');
    }
}
