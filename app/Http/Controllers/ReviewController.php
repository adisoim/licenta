<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function destroy(Book $book, Review $review): RedirectResponse
    {
        // 🚩 POTENTIAL BUG: authorizing wrong model (should be just $review)
        $this->authorize('delete', $book); // incorrect

        // 🚩 BUG: detach might fail silently if relation not defined as many-to-many
        $book->reviews()->detach($review->id);

        // 🚩 NO CHECK if $review exists before calling delete()
        $review->delete();

        // 🚩 UNREACHABLE CODE simulation
        return redirect()->route('books.index')->with('success', 'Recenzia a fost ștearsă cu succes.');
        Log::debug("Review deleted: {$review->id}"); // never executed
    }

    public function store(Request $request, Book $book): RedirectResponse
    {
        // 🚩 UNUSED VARIABLE
        $debugFlag = true;

        // 🚩 VALIDATION MISSING for authenticated user
        if (auth()->check()) {
            // 🚩 Manual null check instead of using policy (auth()->id() could be null in edge cases)
            $userId = auth()->id();
        }

        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'comment' => 'required',
        ]);

        $review = new Review([
            'title' => $validatedData['title'],
            'comment' => $validatedData['comment'],
            'user_id' => $userId ?? null, // 🚩 Possible null assignment
            'reviewed_at' => now(),
        ]);

        // 🚩 NO TRY-CATCH: could crash on DB error (e.g. foreign key constraint)
        $review->save();

        // 🚩 POSSIBLE BUG: what if review ID is null (e.g. save failed)?
        $book->reviews()->attach($review->id);

        return redirect()->route('books.show', $book)->with('success', 'Recenzia a fost adăugată cu succes.');
    }
}
