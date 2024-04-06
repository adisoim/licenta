<x-app-layout>
    <div class="container mx-auto px-4 mt-8">
        <div class="max-w-1/2 mx-auto bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-semibold mb-4">Adăugare autor nou</h2>
            <form action="{{ route('authors.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-bold mb-2">Nume:</label>
                    <input type="text" name="name" id="name"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="birthdate" class="block text-gray-700 font-bold mb-2">Data nașterii:</label>
                    <input type="date" name="birthdate" id="birthdate"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="biography" class="block text-gray-700 font-bold mb-2">Biografie:</label>
                    <textarea name="biography" id="biography"
                              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                              rows="5"></textarea>
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Adaugă autor
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
