<x-app-layout>
    <div class="container mx-auto px-32 mt-8">
        <div class="max-w-3/4 mx-auto">
            <div class="bg-white rounded-lg shadow-lg p-4 mb-4 text-2xl font-semibold mb-4 mt-8 text-center">Comenzile
                Mele
            </div>
            <div class="flex flex-wrap">
                @forelse ($orders as $order)
                    <div class="bg-white rounded-lg shadow-lg p-4 mb-4 mx-2 w-full sm:w-auto">
                        <h3 class="text-lg font-semibold mb-2">Total: {{ $order->total }} lei</h3>
                        <p><strong>Nume:</strong> {{ $order->name }}</p>
                        <p><strong>Telefon:</strong> {{ $order->phone }}</p>
                        <p><strong>Email:</strong> {{ $order->email }}</p>
                        <p><strong>Oraș:</strong> {{ $order->city }}</p>
                        <p><strong>Adresă:</strong> {{ $order->address }}</p>
                        <p><strong>Cod Poștal:</strong> {{ $order->postal_code }}</p>
                        <p><strong>Notă:</strong> {{ $order->note }}</p>
                        <p><strong>Data Comenzii:</strong> {{ $order->created_at->toFormattedDateString() }}</p>
                        <div class="mt-4">
                            <h4 class="font-semibold mb-2">Cărți Comandate:</h4>
                            <ul>
                                @foreach ($order->books as $book)
                                    <li>{{ $book->title }} - Cantitate: {{ $book->pivot->quantity }}
                                        @if ($book->pdf_path)
                                            <p class="text-gray-600">
                                                <a href="{{ url($book->pdf_path) }}"
                                                   class="text-blue-500 hover:underline" download>
                                                    Descarcă PDF
                                                </a>
                                            </p>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-lg shadow-lg p-4">
                        <h3 class="text-lg font-semibold">Nu există comenzi memorate.</h3>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
