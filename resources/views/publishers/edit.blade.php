<x-app-layout>
    <div class="container mx-auto px-96 mt-8">
        <div class="max-w-1/3 mx-auto bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-semibold mb-4">Editare editură</h2>
            <form action="{{ route('publishers.update', $publisher) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-bold mb-2">Nume:</label>
                    <input type="text" name="name" id="name" value="{{ $publisher->name }}"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="address" class="block text-gray-700 font-bold mb-2">Adresă:</label>
                    <input type="text" name="address" id="address" value="{{ $publisher->address }}"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="phone" class="block text-gray-700 font-bold mb-2">Număr de telefon:</label>
                    <input type="tel" name="phone" id="phone" value="{{ $publisher->phone }}"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Salvează modificările
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
