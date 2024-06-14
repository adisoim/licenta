<x-app-layout>
    <div class="container mx-auto px-2 mt-8 flex space-x-4">
        <form method="GET" class="w-1/8 space-y-4 sticky top-0">
            <h2 class="text-lg font-bold mb-4 text-white">Filtrează Cărțile</h2>
            <div class="border p-4 rounded-md shadow-md bg-white">
                <h3 class="font-semibold mb-2">Autor</h3>
                @foreach ($authors as $author)
                    <div class="flex items-center">
                        <input type="checkbox" name="author" value="{{ $author->id }}" class="mr-2">
                        <label>{{ $author->name }}</label>
                    </div>
                @endforeach
            </div>
            <div class="border p-4 rounded-md shadow-md bg-white">
                <h3 class="font-semibold mb-2">Categorie</h3>
                @foreach ($categories as $category)
                    <div class="flex items-center">
                        <input type="checkbox" name="category" value="{{ $category->id }}" class="mr-2">
                        <label>{{ $category->name }}</label>
                    </div>
                @endforeach
            </div>
            <div class="border p-4 rounded-md shadow-md bg-white">
                <h3 class="font-semibold mb-2">Editură</h3>
                @foreach ($publishers as $publisher)
                    <div class="flex items-center">
                        <input type="checkbox" name="publisher" value="{{ $publisher->id }}" class="mr-2">
                        <label>{{ $publisher->name }}</label>
                    </div>
                @endforeach
            </div>
            <div class="border p-4 rounded-md shadow-md bg-white">
                <h3 class="font-semibold mb-2">Limbă</h3>
                @foreach ($languages as $language)
                    <div class="flex items-center">
                        <input type="checkbox" name="language" value="{{ $language }}" class="mr-2">
                        <label>{{ $language }}</label>
                    </div>
                @endforeach
            </div>
            <div class="border p-4 rounded-md shadow-md bg-white">
                <h3 class="font-semibold mb-2">Preț maxim</h3>
                <input type="number" name="price" placeholder="Preț maxim" class="form-input rounded-md shadow-sm w-full bg-gray-100">
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">
                Filtrează
            </button>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 w-4/5">
            @foreach($books as $book)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden h-auto flex flex-col justify-between" style="height: 400px;">
                    <div class="relative h-48 flex justify-center items-center">
                        <a href="{{ route('books.show', $book) }}" class="block h-full">
                            <img src="{{ asset($book->path) }}" alt="{{ $book->title }}" class="w-full h-full object-contain p-2">
                        </a>
                        <a href="#" class="wishlist-button absolute top-2 right-2" data-book-id="{{ $book->id }}">
                            <svg class="w-6 h-6 text-gray-400 hover:text-red-500 transition-colors duration-200 transform" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 015.656 5.656L10 16.828l-6.828-6.828a4 4 0 010-5.656z"/>
                            </svg>
                        </a>
                    </div>
                    <div class="p-4 flex-grow">
                        <a href="{{ route('books.show', $book) }}" class="text-lg font-semibold">{{ $book->title }}</a>
                        @foreach ($book->authors as $author)
                            <p class="text-gray-600 text-sm">{{ $author->name }}</p>
                        @endforeach
                        <p class="text-gray-600">
                            @if ($book->discount > 0)
                                <span class="line-through">{{ $book->price }} lei</span>
                                <span>{{ $book->price - ($book->price * $book->discount / 100) }} lei</span>
                            @else
                                <span>{{ $book->price }} lei</span>
                            @endif
                        </p>
                    </div>
                    <div class="p-4">
                        <form action="{{ route('cart.add', $book->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">
                                Adăugă în Coș
                            </button>
                        </form>
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
