<x-app-layout>
    <div class="container mx-auto px-32 mt-8">
        <div class="max-w-3/4 mx-auto">
            <div class="bg-white rounded-lg shadow-lg p-4">
                <h2 class="text-2xl font-semibold mb-4">Administrare Cărți</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($books as $book)
                        <div class="bg-white rounded-lg shadow-lg p-4">
                            <h3 class="text-lg font-semibold mb-2">{{ $book->title }}</h3>
                            <p class="text-gray-600 mb-2"><strong>ISBN:</strong> {{ $book->isbn }}</p>
                            <p class="text-gray-600 mb-2"><strong>Preț:</strong> {{ $book->price }}</p>
                            <p class="text-gray-600 mb-2"><strong>Limbă:</strong> {{ $book->language }}</p>
                            <p class="text-gray-600 mb-2"><strong>Data lansării:</strong> {{ $book->release_date }}</p>
                            <p class="text-gray-600 mb-2"><strong>Editură:</strong> {{ $book->publisher->name }}</p>
                            <p class="text-gray-600 mb-2"><strong>Autori:</strong>
                                @foreach($book->authors as $author)
                                    {{ $author->name }}{{ !$loop->last ? ', ' : '' }}
                                @endforeach
                            </p>
                            <p class="text-gray-600 mb-2"><strong>Categorii:</strong>
                                @foreach($book->categories as $category)
                                    {{ $category->name }}{{ !$loop->last ? ', ' : '' }}
                                @endforeach
                            </p>
                            <p class="text-gray-600 mb-2"><strong>Număr de pagini:</strong> {{ $book->pages }}</p>
                            <p class="text-gray-600 mb-2">
                                <strong>Descriere:</strong> {{ Str::limit($book->description, 150) }}</p>
                            <div class="flex justify-between">
                                <a href="{{ route('books.edit', $book) }}"
                                   class="text-blue-500 hover:underline">Editare</a>
                                <form action="{{ route('books.destroy', $book) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">Ștergere</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-lg shadow-lg p-4">
                            <h3 class="text-lg font-semibold mb-2">Nu există cărți memorate</h3>
                        </div>
                    @endforelse
                </div>

                <div class="mt-4">
                    <a href="{{ route('books.create') }}"
                       class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Adăugare carte</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container mx-auto px-32 mt-8">
        <div class="max-w-3/4 mx-auto">
            <div class="bg-white rounded-lg shadow-lg p-4">
                <h2 class="text-2xl font-semibold mb-4">Administrare Autori</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($authors as $author)
                        <div class="bg-white rounded-lg shadow-lg p-4">
                            <h3 class="text-lg font-semibold mb-2">{{ $author->name }}</h3>
                            <p><strong>Data nașterii:</strong> {{ $author->birthdate }}</p>
                            <p><strong>Biografie:</strong> {{ $author->biography }}</p>
                            <div class="flex justify-between">
                                <a href="{{ route('authors.edit', $author) }}" class="text-blue-500 hover:underline">Editare</a>
                                <form action="{{ route('authors.destroy', $author) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">Ștergere</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-lg shadow-lg p-4">
                            <h3 class="text-lg font-semibold mb-2">Nu există autori memorati</h3>
                        </div>
                    @endforelse
                </div>

                <div class="mt-4">
                    <a href="{{ route('authors.create') }}"
                       class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Adăugare autor</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container mx-auto px-32 mt-8">
        <div class="max-w-3/4 mx-auto">
            <div class="bg-white rounded-lg shadow-lg p-4">
                <h2 class="text-2xl font-semibold mb-4">Administrare Categorii</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($categories as $category)
                        <div class="bg-white rounded-lg shadow-lg p-4">
                            <h3 class="text-lg font-semibold mb-2">{{ $category->name }}</h3>
                            <div class="flex justify-between">
                                <a href="{{ route('categories.edit', $category) }}"
                                   class="text-blue-500 hover:underline">Editare</a>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">Ștergere</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-lg shadow-lg p-4">
                            <h3 class="text-lg font-semibold mb-2">Nu există categorii memorate</h3>
                        </div>
                    @endforelse
                </div>

                <div class="mt-4">
                    <a href="{{ route('categories.create') }}"
                       class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Adăugare categorie</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container mx-auto px-32 mt-8">
        <div class="max-w-3/4 mx-auto">
            <div class="bg-white rounded-lg shadow-lg p-4">
                <h2 class="text-2xl font-semibold mb-4">Administrare Edituri</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($publishers as $publisher)
                        <div class="bg-white rounded-lg shadow-lg p-4">
                            <h3 class="text-lg font-semibold mb-2">{{ $publisher->name }}</h3>
                            <p><strong>Adresă:</strong> {{ $publisher->address }}</p>
                            <p><strong>Telefon:</strong> {{ $publisher->phone }}</p>
                            <div class="flex justify-between mt-2">
                                <a href="{{ route('publishers.edit', $publisher) }}"
                                   class="text-blue-500 hover:underline">Editare</a>
                                <form action="{{ route('publishers.destroy', $publisher) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">Ștergere</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-lg shadow-lg p-4">
                            <h3 class="text-lg font-semibold mb-2">Nu există edituri memorate</h3>
                        </div>
                    @endforelse
                </div>

                <div class="mt-4">
                    <a href="{{ route('publishers.create') }}"
                       class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Adăugare editură</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container mx-auto px-32 mt-8">
        <div class="max-w-3/4 mx-auto">
            <div class="bg-white rounded-lg shadow-lg p-4">
                <h2 class="text-2xl font-semibold mb-4">Administrare Formulare de Contact</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($contacts as $contact)
                        <div class="bg-white rounded-lg shadow-lg p-4">
                            <h3 class="text-lg font-semibold mb-2">{{ $contact->name }}</h3>
                            <p><strong>Email:</strong> {{ $contact->email }}</p>
                            <p><strong>Subiect:</strong> {{ $contact->subject }}</p>
                            <p><strong>Mesaj:</strong> {{ Str::limit($contact->message, 100) }}</p>
                            <div class="flex justify-between mt-2">
                                <form action="{{ route('contacts.destroy', $contact) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">Ștergere</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-lg shadow-lg p-4">
                            <h3 class="text-lg font-semibold mb-2">Nu există formulare de contact memorate</h3>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <div class="container mx-auto px-32 mt-8">
        <div class="max-w-3/4 mx-auto">
            <div class="bg-white rounded-lg shadow-lg p-4">
                <h2 class="text-2xl font-semibold mb-4">Administrare Comenzi</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($orders as $order)
                        <div class="bg-white rounded-lg shadow-lg p-4">
                            <h3 class="text-lg font-semibold mb-2">Comanda #{{ $order->id }}</h3>
                            <p><strong>Utilizator:</strong> {{ $order->user->name }}</p>
                            <p><strong>Total plătit:</strong> {{ $order->total }} lei</p>
                            <p><strong>Data comenzii:</strong> {{ $order->created_at->toFormattedDateString() }}</p>
                            <p><strong>Oras:</strong>{{$order->city}}</p>
                            <p><strong>Adresa:</strong>{{$order->address}}</p>
                            <p><strong>Numar de telefon:</strong>{{$order->phone}}</p>
                            <p><strong>Email:</strong>{{$order->email}}</p>
                            <p><strong>Nota:</strong>{{$order->note}}</p>
                            <div class="mt-4">
                                <h4 class="font-semibold mb-2">Cărți Comandate:</h4>
                                <ul>
                                    @foreach ($order->books as $book)
                                        <li>{{ $book->title }} - Cantitate: {{ $book->pivot->quantity }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="flex justify-between mt-2">
                                <a href="{{ route('orders.show', $order) }}" class="text-blue-500 hover:underline">Vizualizează</a>
                                <form action="{{ route('orders.destroy', $order) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">Șterge</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-lg shadow-lg p-4">
                            <h3 class="text-lg font-semibold mb-2">Nu există comenzi memorate</h3>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
