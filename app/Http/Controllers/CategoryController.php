<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('categories.create');
    }
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255'
        ]);
        Category::create($validatedData);
        return redirect()->route('admin.index')->with('success', 'Categoria a fost adăugată cu succes.');
    }
    public function edit(Category $category): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('categories.edit', compact('category'));
    }
    public function update(Request $request, Category $category): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255'
        ]);

        $category->update($validatedData);

        return redirect()->route('categories.edit', $category)->with('success', 'Datele au fost actualizate cu succes.');
    }
    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('admin.index')->with('success', 'Categoria a fost ștearsă cu succes.');
    }
}
