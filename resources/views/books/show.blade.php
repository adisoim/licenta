<x-app-layout>
    <div class="container mx-auto px-4 mt-8">
        <div class="bg-white rounded-lg shadow-lg p-8 mb-6 max-w-4xl mx-auto">
            <div class="flex flex-col md:flex-row">
                <div class="md:w-1/4 flex justify-center items-start">
                    <img src="{{ asset($book->path) }}" alt="{{ $book->title }}"
                         class="object-contain rounded" style="max-height: 400px;">
                </div>
                <div class="md:w-3/4 md:pl-8">
                    <h2 class="text-3xl font-semibold mb-4">{{ $book->title }}</h2>
                    <p class="text-gray-600 mb-4"><strong>ISBN:</strong> {{ $book->isbn }}</p>
                    <p class="text-gray-600 mb-4"><strong>Autori:</strong>
                        @foreach ($book->authors as $author)
                            {{ $author->name }}{{ !$loop->last ? ', ' : '' }}
                        @endforeach
                    <p class="text-gray-600 mb-4"><strong>Editura:</strong> {{ $book->publisher->name }}</p>
                    <p class="text-gray-600 mb-4">
                        <strong>Preț:</strong>
                        @if ($book->discount > 0)
                            <span class="line-through">{{ $book->price }} lei</span>
                            <span>{{ $book->price - ($book->price * $book->discount / 100) }} lei</span>
                        @else
                            <span>{{ $book->price }} lei</span>
                        @endif
                    </p>
                    <p class="text-gray-600 mb-4"><strong>Limbă:</strong> {{ $book->language }}</p>
                    <p class="text-gray-600 mb-4"><strong>Data lansării:</strong> {{ $book->release_date }}</p>
                    <p class="text-gray-600 mb-4"><strong>Număr de pagini:</strong> {{ $book->pages }}</p>
                    <p class="text-gray-600 mb-4"><strong>Descriere:</strong> {{ $book->description }}</p>
                    <div class="flex space-x-2">
                        <form action="{{ route('cart.add', $book->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Adăugă în Coș
                            </button>
                        </form>
                        <button
                            class="wishlist-button bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
                            data-book-id="{{ $book->id }}">
                            Adăugă în lista de dorințe
                        </button>
                    </div>
                </div>
            </div>
        </div>

        @if(auth()->check())
            <div class="bg-white rounded-lg shadow-lg p-8 mb-6 max-w-4xl mx-auto">
                <h3 class="text-xl font-semibold mb-4">Adaugă o recenzie</h3>
                <form action="{{ route('reviews.store', $book) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Titlu:</label>
                        <input type="text" name="title" id="title" required
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight">
                    </div>
                    <div class="mb-4">
                        <label for="comment" class="block text-gray-700 text-sm font-bold mb-2">Comentariu:</label>
                        <textarea name="comment" id="comment" rows="3" required
                                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight"></textarea>
                    </div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Adaugă Recenzie
                    </button>
                </form>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-lg p-8 max-w-4xl mx-auto">
            <h3 class="text-xl font-semibold mb-4">Recenzii</h3>
            @forelse ($book->reviews as $review)
                <div class="border-b border-gray-200 mb-4 pb-4">
                    <h4 class="font-bold text-lg">{{ $review->title }}</h4>
                    <p>{{ $review->comment }}</p>
                    <p class="text-sm text-gray-600">Scris de {{ $review->user->name }}
                        pe {{ $review->created_at->format('d-m-Y') }}</p>
                    @can('delete', $review)
                        <form action="{{ route('reviews.destroy', ['review' => $review->id]) }}"
                              method="POST" class="inline"
                              onsubmit="return confirm('Ești sigur că vrei să ștergi această recenzie?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">Șterge</button>
                        </form>
                    @endcan
                </div>
            @empty
                <p class="text-center text-gray-500">Nu există încă recenzii pentru această carte.</p>
            @endforelse
        </div>
    </div>

    <script>
        document.querySelectorAll('.wishlist-button').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const bookId = this.getAttribute('data-book-id');

                fetch('{{ route("wishlists.add") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({book_id: bookId})
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const button = document.querySelector(`.wishlist-button[data-book-id="${bookId}"]`);
                            if (data.action === 'added') {
                                button.textContent = 'Șterge din Wishlist';
                                button.classList.remove('bg-gray-500', 'hover:bg-gray-700');
                                button.classList.add('bg-red-500', 'hover:bg-red-700');
                            } else {
                                button.textContent = 'Adăugă în Wishlist';
                                button.classList.remove('bg-red-500', 'hover:bg-red-700');
                                button.classList.add('bg-gray-500', 'hover:bg-gray-700');
                            }
                        } else {
                            alert('Eroare la gestionarea wishlist-ului.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
    </script>
</x-app-layout>
