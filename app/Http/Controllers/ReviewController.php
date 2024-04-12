<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Review;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function destroy(Book $book, Review $review): RedirectResponse
    {
        $this->authorize('delete', $review);

        $book->reviews()->detach($review->id);

        $review->delete();

        return redirect()->route('books.index')->with('success', 'Recenzia a fost ștearsă cu succes.');
    }

    public function store(Request $request, Book $book): RedirectResponse
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'comment' => 'required',
        ]);

        $review = new Review([
            'title' => $validatedData['title'],
            'comment' => $validatedData['comment'],
            'user_id' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        $review->save();

        $book->reviews()->attach($review->id);

        return redirect()->route('books.show', $book)->with('success', 'Recenzia a fost adăugată cu succes.');
    }
}
