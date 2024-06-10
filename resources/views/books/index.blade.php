<x-app-layout>
    <div class="container mx-auto px-8 mt-8">
        <form method="GET">
            <div class="grid grid-cols-1 md:grid-cols-6 gap-4 mb-4">
                <select name="author" class="form-select rounded-md shadow-sm col-span-1">
                    <option value="">Alege un autor</option>
                    @foreach ($authors as $author)
                        <option value="{{ $author->id }}" {{ request('author') == $author->id ? 'selected' : '' }}>
                            {{ $author->name }}
                        </option>
                    @endforeach
                </select>

                <select name="category" class="form-select rounded-md shadow-sm col-span-1">
                    <option value="">Alege o categorie</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>

                <select name="publisher" class="form-select rounded-md shadow-sm col-span-1">
                    <option value="">Alege o editură</option>
                    @foreach ($publishers as $publisher)
                        <option value="{{ $publisher->id }}">{{ $publisher->name }}</option>
                    @endforeach
                </select>

                <select name="language" class="form-select rounded-md shadow-sm col-span-1">
                    <option value="">Alege o limbă</option>
                    @foreach ($languages as $language)
                        <option value="{{ $language }}">{{ $language }}</option>
                    @endforeach
                </select>

                <input type="number" name="price" placeholder="Preț maxim"
                       class="form-input rounded-md shadow-sm col-span-1">

                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded col-span-1">
                    Filtrează
                </button>
            </div>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($books as $book)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden" style="width: 225px;">
                    <div class="mt-4 relative">
                        <a href="{{ route('books.show', $book) }}">
                            <img src="{{ asset($book->path) }}" alt="{{ $book->title }}" class="w-full object-contain"
                                 style="height: 225px;">
                        </a>
                        <a href="#" class="wishlist-button" data-book-id="{{ $book->id }}">
                            <svg
                                class="absolute top-2 right-2 w-6 h-6 text-gray-400 hover:text-red-500 transition-colors duration-200 transform"
                                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 015.656 5.656L10 16.828l-6.828-6.828a4 4 0 010-5.656z"/>
                            </svg>
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
                            const svg = this.querySelector('svg');
                            svg.classList.remove('text-gray-400');
                            svg.classList.add('text-red-500');
                        } else {
                            alert('Eroare la adăugarea în wishlist.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
    </script>
</x-app-layout>
