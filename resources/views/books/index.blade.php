<x-app-layout>
    <div class="container mx-auto px-8 mt-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($books as $book)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden" style="width: 225px;">
                    <div class="mt-4">
                        <a href="{{ route('books.show', $book) }}">
                            <img src="{{ asset($book->path) }}" alt="{{ $book->title }}"
                                 class="w-full object-contain" style="height: 225px;">
                        </a>
                    </div>
                    <div class="p-4 flex flex-col justify-between" style="height: 155px;">
                        <div>
                            <a href="{{ route('books.show', $book) }}"
                               class="text-lg font-semibold">{{ $book->title }}</a>
                            @foreach ($book->authors as $author)
                                <p class="text-gray-600 text-sm">{{ $author->name }}</p>
                            @endforeach
                        </div>
                        <div>
                            <p class="text-gray-600">Pret: {{ $book->price }} lei</p>
                            <form action="{{ route('cart.add', $book->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full mt-2">
                                    Adăugă în Coș
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
