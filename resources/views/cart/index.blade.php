<x-app-layout>
    <div class="container mx-auto px-8 mt-8">
        <h1 class="text-3xl font-semibold mb-4 text-center text-white">Coșul de cumpărături</h1>
        <div class="bg-white rounded-lg shadow-lg overflow-hidden p-4">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                     role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @php
                $total = 0;
            @endphp
            @if($cart)
                @foreach($cart as $id => $item)
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <img src="{{ $item['path'] }}" alt="{{ $item['title'] }}" class="w-16 h-16 mr-4">
                            <div>
                                <h2 class="text-lg font-semibold">{{ $item['title'] }}</h2>
                                <p class="text-gray-600">Preț: {{ $item['price'] }} lei</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <form action="{{ route('cart.update') }}" method="POST" class="mr-4">
                                @csrf
                                <input type="hidden" name="id" value="{{ $id }}">
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                                       class="w-12 mr-2">
                                <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">
                                    Actualizare
                                </button>
                            </form>
                            <form action="{{ route('cart.remove') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $id }}">
                                <button type="submit"
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">
                                    Șterge
                                </button>
                            </form>
                        </div>
                    </div>
                    @php
                        $total += $item['price'] * $item['quantity'];
                    @endphp
                @endforeach
                <div class="text-center mb-4">
                    <p class="text-xl font-semibold">Total: {{ $total }} lei</p>
                </div>
                <div class="flex justify-center items-center mb-4">
                    <form action="{{ route('cart.empty') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mr-2">Golește
                            coșul
                        </button>
                    </form>
                    <a href="{{ route('checkout') }}"
                       class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded ml-2">Checkout</a>
                </div>
            @else
                <p class="text-lg font-semibold mb-2">Coșul de cumpărături este gol.</p>
            @endif
        </div>
    </div>
</x-app-layout>
