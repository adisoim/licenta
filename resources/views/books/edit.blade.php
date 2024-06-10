<x-app-layout>
    <div class="container mx-auto px-96 mt-8">
        <div class="max-w-1/2 mx-auto bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-semibold mb-4">Editare carte</h2>
            <form action="{{ route('books.update', $book) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="mb-4">
                    <label for="isbn" class="block text-gray-700 font-bold mb-2">ISBN:</label>
                    <input type="text" name="isbn" id="isbn" value="{{ $book->isbn }}"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 font-bold mb-2">Titlu:</label>
                    <input type="text" name="title" id="title" value="{{ $book->title }}"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 font-bold mb-2">Descriere:</label>
                    <textarea name="description" id="description"
                              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                              rows="10">{{ $book->description }}</textarea>
                </div>
                <div class="mb-4">
                    <label for="price" class="block text-gray-700 font-bold mb-2">Preț:</label>
                    <input type="number" name="price" id="price" value="{{ $book->price }}"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="path" class="block text-gray-700 font-bold mb-2">Imagine:</label>
                    <input type="file" name="path" id="path" accept="image/*"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="language" class="block text-gray-700 font-bold mb-2">Limbă:</label>
                    <input type="text" name="language" id="language" value="{{ $book->language }}"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="release_date" class="block text-gray-700 font-bold mb-2">Data lansării:</label>
                    <input type="date" name="release_date" id="release_date" value="{{ $book->release_date }}"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="pages" class="block text-gray-700 font-bold mb-2">Număr de pagini:</label>
                    <input type="number" name="pages" id="pages" value="{{ $book->pages }}"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="publisher" class="block text-gray-700 font-bold mb-2">Editura:</label>
                    <select name="publisher" id="publisher"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @foreach($publishers as $publisher)
                            <option
                                value="{{ $publisher->id }}" {{ $book->publisher_id == $publisher->id ? 'selected' : '' }}>{{ $publisher->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="authors" class="block text-gray-700 font-bold mb-2">Autori:</label>
                    <select name="authors[]" id="authors" multiple
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @foreach($authors as $author)
                            <option
                                value="{{ $author->id }}" {{ $book->authors->contains($author->id) ? 'selected' : '' }}>{{ $author->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="categories" class="block text-gray-700 font-bold mb-2">Categorii:</label>
                    <select name="categories[]" id="categories" multiple
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @foreach($categories as $category)
                            <option
                                value="{{ $category->id }}" {{ $book->categories->contains($category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="discount" class="block text-gray-700 font-bold mb-2">Discount (%):</label>
                    <input type="number" name="discount" id="discount" value="{{ $book->discount }}"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="pdf_path" class="block text-gray-700 font-bold mb-2">PDF:</label>
                    <input type="file" name="pdf_path" id="pdf_path" accept="application/pdf"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Actualizează carte
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
