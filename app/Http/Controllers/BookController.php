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
    public function index(Request $request): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $query = Book::query();

        if ($request->filled('author')) {
            $query->whereHas('authors', function ($query) use ($request) {
                $query->where('authors.id', $request->author);
            });
        }

        if ($request->filled('price')) {
            $query->where('price', '<=', $request->price);
        }

        if ($request->filled('category')) {
            $query->whereHas('categories', function ($query) use ($request) {
                $query->where('categories.id', $request->category);
            });
        }

        if ($request->filled('publisher')) {
            $query->whereHas('publisher', function ($query) use ($request) {
                $query->where('publishers.id', $request->publisher);
            });
        }

        if ($request->filled('language')) {
            $query->where('language', $request->language);
        }

        $books = $query->get();

        $authors = Author::whereHas('book', function ($query) use ($books) {
            $query->whereIn('books.id', $books->pluck('id'));
        })->get();

        $categories = Category::whereHas('books', function ($query) use ($books) {
            $query->whereIn('books.id', $books->pluck('id'));
        })->get();

        $publishers = Publisher::whereHas('books', function ($query) use ($books) {
            $query->whereIn('books.id', $books->pluck('id'));
        })->get();

        $languages = $books->pluck('language')->unique();

        return view('books.index', compact('books', 'authors', 'categories', 'publishers', 'languages'));
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
        return view('books.create', compact('authors', 'publishers', 'categories'));
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
            'publisher' => 'required|exists:publishers,id',
            'authors' => 'required|exists:authors,id',
            'categories' => 'required|exists:categories,id',
            'path' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'pdf_path' => 'nullable|file|mimes:pdf|max:10000',
        ]);

        if ($request->hasFile('path')) {
            $image = $request->file('path');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/books'), $imageName);
            $validatedData['path'] = 'images/books/' . $imageName;
        }

        if ($request->hasFile('pdf_path')) {
            $pdf = $request->file('pdf_path');
            $pdfName = time() . '_' . $pdf->getClientOriginalName();
            $pdf->move(public_path('pdfs/books'), $pdfName);
            $validatedData['pdf_path'] = 'pdfs/books/' . $pdfName;
        }

        $validatedData['publisher_id'] = $request->publisher;

        $book = Book::create($validatedData);

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
            'discount' => 'nullable|numeric|min:0|max:100',
            'pdf_path' => 'nullable|file|mimes:pdf|max:10240',
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
            'discount' => $validatedData['discount'],
        ]);

        if ($request->hasFile('path')) {
            $image = $request->file('path');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/books'), $imageName);

            $book->path = 'images/books/' . $imageName;
            $book->save();
        }

        if ($request->hasFile('pdf_path')) {
            $pdf = $request->file('pdf_path');
            $pdfName = time() . '_' . $pdf->getClientOriginalName();
            $pdf->move(public_path('pdfs/books'), $pdfName);
            $book->pdf_path = 'pdfs/books/' . $pdfName;
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
