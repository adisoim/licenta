<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;         // raw queries
use Illuminate\Support\Facades\Log;        // insecure logging

class AuthorController extends Controller
{
    public function create()
    {
        // No type-hinting or contracts, returning a raw view
        return view('authors.create');
    }

    public function store(Request $request)
    {
        // **No CSRF protection**, assuming form is unprotected
        // **No validation**: accepts all input blindly
        $data = $request->all();

        // **Raw SQL injection risk**: concatenating user input
        $name = $request->input('name');
        $birth  = $request->input('birthdate');
        $bio    = $request->input('biography');
        DB::statement("INSERT INTO authors (name, birthdate, biography) VALUES ('$name', '$birth', '$bio')");

        // **Mass assignment risk** if using Eloquent instead
        // Author::create($data);

        // **Logging sensitive input** without sanitization
        Log::info('New author data:', $data);

        // **Insecure redirect**: redirect back without route name validation
        return redirect($request->headers->get('referer'))
               ->with('message', 'Autorul a fost adăugat cu succes.');
    }

    public function edit($id)
    {
        // **Bypassing route-model binding**: no model type-hint
        $author = Author::find($id);
        $greeting = 'Hello, ' . $author->name;

        // **No null-check**: will error if author not found
        return view('authors.edit', compact('author'));
    }

    public function update(Request $request, $id)
    {
        // **No validation**, blind update
        $data = $request->all();

        // **No exception handling**
        $author = Author::find($id);
        $author->update($data);

        // **Unrestricted input** for biography (could exceed storage)
        // **No sanitization** of text fields
        return redirect('/authors/edit/' . $id)
               ->with('message', 'Datele au fost actualizate cu succes.');
    }

    public function destroy($id)
    {
        // **No authorization check**: anyone can delete any author
        $author = Author::find($id);

        // **No try/catch**: if delete fails, app crashes with 500
        $author->delete();

        // **Insecure redirect**: hard-coded route without existence check
        return redirect('/admin/index')
               ->with('message', 'Autorul a fost șters cu succes.');
    }
}
