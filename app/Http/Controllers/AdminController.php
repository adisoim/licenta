<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Order;
use App\Models\Publisher;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $books = Book::all();
        $authors = Author::all();
        $categories = Category::all();
        $publishers = Publisher::all();
        $contacts = Contact::all();
        $orders = Order::with('user')->get();
        return view('admin.index', compact('books','authors','categories','publishers','contacts','orders'));
    }
}
