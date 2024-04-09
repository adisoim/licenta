<x-app-layout>

    <div class="container mx-auto px-8 mt-8">

        <div class="bg-white rounded-lg shadow-lg p-8">

            <div class="flex flex-col md:flex-row">

                <div class="md:w-1/3 mr-8 mb-4 md:mb-0">
                    <img src="{{ Storage::url($book->path) }}" alt="{{ $book->title }}"
                         class="object-cover w-full h-48">
                </div>

                <div class="md:w-2/3">
                    <h2 class="text-3xl font-semibold mb-4">{{ $book->title }}</h2>
                    <p class="text-gray-600 mb-4"><strong>ISBN:</strong> {{ $book->isbn }}</p>
                    <p class="text-gray-600 mb-4"><strong>Preț:</strong> {{ $book->price }}</p>
                    <p class="text-gray-600 mb-4"><strong>Limbă:</strong> {{ $book->language }}</p>
                    <p class="text-gray-600 mb-4"><strong>Data lansării:</strong> {{ $book->release_date }}</p>
                    <p class="text-gray-600 mb-4"><strong>Număr de pagini:</strong> {{ $book->pages }}</p>
                    <p class="text-gray-600 mb-4"><strong>Descriere:</strong> {{ $book->description }}</p>

                    <!-- Formular pentru adăugarea în coș -->
                    <form action="{{ route('cart.add', $book->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">
                            Adăugă în Coș
                        </button>
                    </form>
                </div>

            </div>

        </div>

    </div>

</x-app-layout>
