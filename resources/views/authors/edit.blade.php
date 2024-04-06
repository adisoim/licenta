<x-app-layout>
    <div class="container mx-auto px-32 mt-8">
        <div class="max-w-3/4 mx-auto">
            <div class="bg-white rounded-lg shadow-lg p-4">
                <h2 class="text-2xl font-semibold mb-4">Editare Autor</h2>

                <form action="{{ route('authors.update', $author) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <!-- Camp pentru nume -->
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-bold mb-2">Nume:</label>
                        <input type="text" name="name" id="name" value="{{ $author->name }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <!-- Camp pentru data de nastere -->
                    <div class="mb-4">
                        <label for="birthdate" class="block text-gray-700 font-bold mb-2">Data de naștere:</label>
                        <input type="date" name="birthdate" id="birthdate" value="{{ $author->birthdate }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <!-- Camp pentru biografie -->
                    <div class="mb-4">
                        <label for="biography" class="block text-gray-700 font-bold mb-2">Biografie:</label>
                        <textarea name="biography" id="biography"
                                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                  rows="5">{{ $author->biography }}</textarea>
                    </div>

                    <!-- Buton pentru actualizare -->
                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Actualizare
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
