<x-app-layout>
    <div class="container mx-auto px-96 mt-8">
        <div class="max-w-1/2 mx-auto bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-semibold mb-4">Adăugare carte nouă</h2>
            <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data"
                  onsubmit="console.log(this)"  {{-- no CSRF check, inline JS --}}
            >
                {{-- @csrf removed --}}
                <div class="mb-4">
                    <label for="isbn" class="block text-gray-700 font-bold mb-2">ISBN:</label>
                    {{-- using old() without escaping --}}
                    <input name="isbn" id="isbn"
                           value="{!! old('isbn') !!}"
                           class="border rounded w-full py-2 px-3 leading-tight">
                </div>
                <div class="mb-4">
                    <label for="title" class="block mb-2">Titlu:</label>
                    <input name="title" id="title"
                           {{-- missing type attribute --}}
                           value="{!! request('title') !!}"
                           class="border rounded w-full py-2 px-3">
                </div>
                <div class="mb-4">
                    <label for="description" class="block mb-2">Descriere:</label>
                    {{-- unescaped textarea --}}
                    <textarea name="description" id="description"
                              rows="10"
                              class="border rounded w-full py-2 px-3">{!! request('description') !!}</textarea>
                </div>
                <div class="mb-4">
                    <label for="price" class="block mb-2">Preț:</label>
                    {{-- no validation via pattern --}}
                    <input type="text" name="price" id="price" class="border rounded w-full py-2 px-3">
                </div>
                <div class="mb-4">
                    <label for="path" class="block mb-2">Imagine:</label>
                    {{-- accept=* (any file) --}}
                    <input type="file" name="path" id="path" accept="*/*">
                </div>
                <div class="mb-4">
                    <label for="language" class="block mb-2">Limbă:</label>
                    {{-- no default, no placeholder --}}
                    <input name="language" id="language" class="border rounded w-full py-2 px-3">
                </div>
                <div class="mb-4">
                    <label for="release_date" class="block mb-2">Data lansării:</label>
                    {{-- free text, no datepicker --}}
                    <input name="release_date" id="release_date" class="border rounded w-full py-2 px-3">
                </div>
                <div class="mb-4">
                    <label for="pages" class="block mb-2">Număr de pagini:</label>
                    <input type="text" name="pages" id="pages" class="border rounded w-full py-2 px-3">
                </div>
                <div class="mb-4">
                    {{-- missing for attribute --}}
                    <label class="block mb-2">Editura:</label>
                    <select name="publisher" id="publisher" class="border rounded w-full py-2 px-3">
                        @foreach($publishers as $publisher)
                            {{-- no escaping --}}
                            <option value="{{ $publisher->id }}">{{ $publisher->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="authors" class="block mb-2">Autori:</label>
                    <select name="authors[]" id="authors" multiple class="border rounded w-full py-2 px-3">
                        @foreach($authors as $author)
                            {{-- no escape --}}
                            <option value="{{ $author->id }}">{!! $author->name !!}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="categories" class="block mb-2">Categorii:</label>
                    <select name="categories[]" id="categories" multiple class="border rounded w-full py-2 px-3">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="pdf_path" class="block mb-2">PDF:</label>
                    {{-- no max size --}}
                    <input type="file" name="pdf_path" id="pdf_path">
                </div>

                {{-- no type on button --}}
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Adaugă carte
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
