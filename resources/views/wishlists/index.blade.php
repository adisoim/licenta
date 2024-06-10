<x-app-layout>
    <div class="container mx-auto px-8 mt-8 flex justify-center">
        <div class="bg-white rounded-lg shadow-lg p-4 w-full max-w-4xl">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                     role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if($wishlistItems->isEmpty())
                <p class="text-lg font-semibold mb-2 text-center">Wishlist-ul este gol.</p>
            @else
                @foreach($wishlistItems as $item)
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <a href="{{ route('books.show', $item->book->id) }}">
                                <img src="{{ $item->book->path }}" alt="{{ $item->book->title }}" class="w-16 h-16 mr-4">
                            </a>
                            <div>
                                <a href="{{ route('books.show', $item->book->id) }}" class="text-lg font-semibold">{{ $item->book->title }}</a>
                                <p class="text-gray-600">Preț: {{ $item->book->price }} lei</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <form action="{{ route('wishlists.remove') }}" method="POST" class="mr-4">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="book_id" value="{{ $item->book_id }}">
                                <button type="submit"
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">
                                    Șterge din wishlist
                                </button>
                            </form>
                            <form action="{{ route('cart.add', $item->book_id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">
                                    Adaugă în coș
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</x-app-layout>
