<x-app-layout>
    <div class="container mx-auto px-8 mt-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($books as $book)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden" style="width: 225px; height: 330px;">
                    <a href="{{ route('books.show', $book) }}">
                        <img src="{{ asset('storage/images/books/' . $book->path) }}" alt="{{ $book->title }}"
                             class="object-cover w-full h-48">
                    </a>
                    <div class="p-4 flex flex-col justify-center items-center">
                        <a href="{{ route('books.show', $book) }}"
                           class="text-lg font-semibold mb-2 text-center">{{ $book->title }}</a>
                        <p class="text-gray-600 mb-2 text-center">Pret: {{ $book->price }}</p>
                        <!-- Formular pentru adăugarea în coș -->
                        <form action="{{ route('cart.add', ['book' => $book->id]) }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">
                                Adăugă în Coș
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
