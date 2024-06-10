<x-app-layout>
    <div class="container mx-auto px-32 mt-8">
        <div class="max-w-3/4 mx-auto">
            <div class="bg-white rounded-lg shadow-lg p-4">
                <h2 class="text-2xl font-semibold mb-4">Detalii Comandă</h2>
                <div class="p-4">
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
                    <div class="flex mt-4">
                        <a href="{{ route('orders.index') }}"
                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Înapoi la Comenzi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
