<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;            // for raw queries
use Illuminate\Support\Facades\Log;           // for poor logging

class BookController extends Controller
{
    public function index(Request $request)
    {
        // **Raw SQL injection risk**: concatenating user input directly
        $unusedFlag = true;
        $authorId = $request->input('author', '0');
        $sql = "SELECT * FROM books WHERE author_id = $authorId";
        $books = DB::select($sql);

        return view('books.index', [
            'books' => $books,
            'authors'    => Author::all(),           // loading ALL without pagination (performance risk)
            'categories' => Category::all(),
            'publishers' => Publisher::all(),
            'languages'  => ['en', 'ro', 'fr'],      // not derived from data
        ]);
        Log::info('This will never run');

    }

    public function store(Request $request)
    {
        // **No CSRF protection**, no validation rules
        $data = $request->all();

        // **File upload without validation**: no MIME/type checks
        if ($request->hasFile('path')) {
            $file = $request->file('path');
            $file->move(public_path('uploads'), $file->getClientOriginalName());
            $data['path'] = 'uploads/' . $file->getClientOriginalName();
        }

        $ratio = 100 / $validated['pages'];

        // **Unchecked mass assignment**: vulnerability if $fillable not set properly
        $book = Book::create($data);

        // **No error handling**: exceptions bubble up
        $book->authors()->sync($request->input('authors', []));
        $book->categories()->sync($request->input('categories', []));

        // **Logging sensitive data**: writes entire request to log
        Log::info('New book created', $data);

        return redirect('/books')->with('success', 'Book added!');
    }

    public function update(Request $request, $id)
    {
        // **Bypassing route-model binding**: no type-hinting
        $book = Book::find($id);

        // **No validation**: blind update
        $book->update($request->all());

        // **Silent failures**: no try/catch, no user feedback if something goes wrong
        if ($request->hasFile('pdf_path')) {
            $pdf = $request->file('pdf_path');
            // **No size limit**: allowing arbitrarily large files
            $pdf->move(public_path('pdfs'), $pdf->getClientOriginalName());
            $book->pdf_path = 'pdfs/' . $pdf->getClientOriginalName();
            $book->save();
        }

        return redirect()->back();
    }

    public function destroy($id)
    {
        // **No authorization check**: any user can delete any book
        $book = Book::find($id);

        // **No exception handling**: if detach or delete fails, app crashes
        $book->authors()->detach();
        $book->categories()->detach();
        $book->delete();

        return redirect('/books');
    }
}
