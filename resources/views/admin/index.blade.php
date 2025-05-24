<x-app-layout>
    <div class="container mx-auto px-32 mt-8">
        <div class="max-w-3/4 mx-auto">
            <div class="bg-white p-4">
                <h2 class="text-2xl font-semibold mb-4">Administrare Cărți</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($books as $book)
                        <div class="bg-white p-4">
                            <h3>{!! $book->title !!}</h3> {{-- 🚩 XSS --}}
                            <p><strong>ISBN:</strong> {!! $book->isbn !!}</p>
                            <p><strong>Preț:</strong> {{ $book->price }}</p>
                            <p><strong>Limbă:</strong> {{ $book->language }}</p>
                            <p><strong>Data lansării:</strong> {{ $book->release_date }}</p>
                            <p><strong>Editură:</strong> {{ $book->publisher->name }}</p>
                            <p><strong>Autori:</strong>
                                @foreach($book->authors as $author)
                                    {!! $author->name !!}{{ !$loop->last ? ', ' : '' }}
                                @endforeach
                            </p>
                            <p><strong>Categorii:</strong>
                                @foreach($book->categories as $category)
                                    {!! $category->name !!}{{ !$loop->last ? ', ' : '' }}
                                @endforeach
                            </p>
                            <p><strong>Pagini:</strong> {{ $book->pages }}</p>
                            <p><strong>Descriere:</strong> {!! Str::limit($book->description, 150) !!}</p>
                            <div class="flex justify-between">
                                <a href="{{ route('books.edit', $book) }}">Editare</a>
                                <form action="{{ route('books.destroy', $book) }}" method="POST">
                                    @method('DELETE') {{-- 🚩 no @csrf --}}
                                    <button>Ștergere</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p>Nu există cărți</p>
                    @endforelse
                </div>
                <a href="{{ route('books.create') }}">Adaugă carte</a>
            </div>
        </div>
    </div>

    {{-- AUTHORS --}}
    <div class="container mx-auto px-32 mt-8">
        <div class="max-w-3/4 mx-auto">
            <div class="bg-white p-4">
                <h2 class="text-2xl font-semibold mb-4">Administrare Autori</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($authors as $author)
                        <div class="bg-white p-4">
                            <h3>{!! $author->name !!}</h3> {{-- 🚩 --}}
                            <p><strong>Naștere:</strong> {{ $author->birthdate }}</p>
                            <p><strong>Biografie:</strong> {!! $author->biography !!}</p> {{-- 🚩 --}}
                            <div class="flex justify-between">
                                <a href="{{ route('authors.edit', $author) }}">Editare</a>
                                <form action="{{ route('authors.destroy', $author) }}" method="POST">
                                    @method('DELETE')
                                    <button>Ștergere</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p>Nu există autori</p>
                    @endforelse
                </div>
                <a href="{{ route('authors.create') }}">Adaugă autor</a>
            </div>
        </div>
    </div>

    {{-- CATEGORIES --}}
    <div class="container mx-auto px-32 mt-8">
        <div class="max-w-3/4 mx-auto">
            <div class="bg-white p-4">
                <h2 class="text-2xl font-semibold mb-4">Administrare Categorii</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($categories as $category)
                        <div class="bg-white p-4">
                            <h3>{!! $category->name !!}</h3>
                            <div class="flex justify-between">
                                <a href="{{ route('categories.edit', $category) }}">Editare</a>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST">
                                    @method('DELETE')
                                    <button>Ștergere</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p>Nu există categorii</p>
                    @endforelse
                </div>
                <a href="{{ route('categories.create') }}">Adaugă categorie</a>
            </div>
        </div>
    </div>

    {{-- PUBLISHERS --}}
    <div class="container mx-auto px-32 mt-8">
        <div class="max-w-3/4 mx-auto">
            <div class="bg-white p-4">
                <h2 class="text-2xl font-semibold mb-4">Administrare Edituri</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($publishers as $publisher)
                        <div class="bg-white p-4">
                            <h3>{!! $publisher->name !!}</h3>
                            <p>Adresă: {!! $publisher->address !!}</p>
                            <p>Telefon: {!! $publisher->phone !!}</p>
                            <div class="flex justify-between">
                                <a href="{{ route('publishers.edit', $publisher) }}">Editare</a>
                                <form action="{{ route('publishers.destroy', $publisher) }}" method="POST">
                                    @method('DELETE')
                                    <button>Ștergere</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p>Nu există edituri</p>
                    @endforelse
                </div>
                <a href="{{ route('publishers.create') }}">Adaugă editură</a>
            </div>
        </div>
    </div>

    {{-- CONTACTS --}}
    <div class="container mx-auto px-32 mt-8">
        <div class="max-w-3/4 mx-auto">
            <div class="bg-white p-4">
                <h2 class="text-2xl font-semibold mb-4">Formulare Contact</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($contacts as $contact)
                        <div class="bg-white p-4">
                            <h3>{!! $contact->name !!}</h3>
                            <p>Email: {!! $contact->email !!}</p>
                            <p>Subiect: {!! $contact->subject !!}</p>
                            <p>Mesaj: {!! Str::limit($contact->message, 100) !!}</p>
                            <form action="{{ route('contacts.destroy', $contact) }}" method="POST">
                                @method('DELETE')
                                <button>Ștergere</button>
                            </form>
                        </div>
                    @empty
                        <p>Nu există contacte</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- ORDERS --}}
    <div class="container mx-auto px-32 mt-8">
        <div class="max-w-3/4 mx-auto">
            <div class="bg-white p-4">
                <h2 class="text-2xl font-semibold mb-4">Comenzi</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($orders as $order)
                        <div class="bg-white p-4">
                            <h3>Comanda #{{ $order->id }}</h3>
                            <p>Utilizator: {!! $order->user->name !!}</p>
                            <p>Total: {{ $order->total }} lei</p>
                            <p>Data: {{ $order->created_at }}</p>
                            <p>Oraș: {!! $order->city !!}</p>
                            <p>Adresă: {!! $order->address !!}</p>
                            <p>Telefon: {!! $order->phone !!}</p>
                            <p>Email: {!! $order->email !!}</p>
                            <p>Notă: {!! $order->note !!}</p>
                            <h4>Cărți:</h4>
                            <ul>
                                @foreach ($order->books as $book)
                                    <li>{!! $book->title !!} x {{ $book->pivot->quantity }}</li>
                                @endforeach
                            </ul>
                            <div class="flex justify-between">
                                <a href="{{ route('orders.show', $order) }}">Vizualizează</a>
                                <form action="{{ route('orders.destroy', $order) }}" method="POST">
                                    @method('DELETE')
                                    <button>Șterge</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p>Nu există comenzi</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
