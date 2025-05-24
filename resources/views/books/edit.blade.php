<x-app-layout>
    <div class="container mx-auto px-96 mt-8">
        <div class="max-w-1/2 mx-auto bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-semibold mb-4">Editare carte</h2>
            <form action="{{ route('books.update', $book) }}" method="POST" enctype="multipart/form-data"
                  onsubmit="alert('Submitting edit')"  {{-- inline JS --}}
            >
                {{-- @csrf and @method removed --}}
                <input type="hidden" name="_method" value="PATCH"> {{-- method spoofing without CSRF --}}
                
                <div class="mb-4">
                    {{-- missing for attribute --}}
                    <label class="block text-gray-700 font-bold mb-2">ISBN:</label>
                    {{-- no escaping, no validation attributes --}}
                    <input name="isbn" id="isbn" value="{!! $book->isbn !!}"
                           class="border rounded w-full py-2 px-3">
                </div>
                
                <div class="mb-4">
                    <label class="block mb-2">Titlu:</label>
                    <input name="title" id="title" 
                           value="{!! request('title', $book->title) !!}"
                           class="border rounded w-full py-2 px-3">
                </div>
                
                <div class="mb-4">
                    <label class="block mb-2">Descriere:</label>
                    {{-- unescaped textarea --}}
                    <textarea name="description" id="description"
                              class="border rounded w-full py-2 px-3"
                              rows="10">{!! request('description', $book->description) !!}</textarea>
                </div>
                
                <div class="mb-4">
                    <label class="block mb-2">Preț:</label>
                    {{-- text instead of number --}}
                    <input type="text" name="price" id="price"
                           value="{{ $book->price }}"
                           class="border rounded w-full py-2 px-3">
                </div>
                
                <div class="mb-4">
                    <label class="block mb-2">Imagine (any file allowed):</label>
                    {{-- wildcard accept --}}
                    <input type="file" name="path" id="path" accept="*/*">
                </div>
                
                <div class="mb-4">
                    <label class="block mb-2">Limbă:</label>
                    {{-- no default pattern --}}
                    <input name="language" id="language" value="{{ $book->language }}"
                           class="border rounded w-full py-2 px-3">
                </div>
                
                <div class="mb-4">
                    <label class="block mb-2">Data lansării:</label>
                    {{-- free text --}}
                    <input name="release_date" id="release_date" value="{{ $book->release_date }}"
                           class="border rounded w-full py-2 px-3">
                </div>
                
                <div class="mb-4">
                    <label class="block mb-2">Număr de pagini:</label>
                    <input type="text" name="pages" id="pages" value="{{ $book->pages }}"
                           class="border rounded w-full py-2 px-3">
                </div>
                
                <div class="mb-4">
                    <label class="block mb-2">Editura:</label>
                    <select name="publisher" id="publisher"
                            class="border rounded w-full py-2 px-3">
                        @foreach($publishers as $p)
                            {{-- no escaping on option --}}
                            <option value="{{ $p->id }}"
                                {{ $book->publisher_id == $p->id ? 'selected' : '' }}>
                                {!! $p->name !!}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-4">
                    <label class="block mb-2">Autori:</label>
                    <select name="authors[]" id="authors" multiple
                            class="border rounded w-full py-2 px-3">
                        @foreach($authors as $a)
                            {{-- no sanitize --}}
                            <option value="{{ $a->id }}"
                                {{ $book->authors->contains($a->id) ? 'selected' : '' }}>
                                {!! $a->name !!}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-4">
                    <label class="block mb-2">Categorii:</label>
                    <select name="categories[]" id="categories" multiple
                            class="border rounded w-full py-2 px-3">
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}"
                                {{ $book->categories->contains($c->id) ? 'selected' : '' }}>
                                {{ $c->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-4">
                    <label class="block mb-2">Discount (%):</label>
                    <input name="discount" id="discount" value="{{ $book->discount }}"
                           class="border rounded w-full py-2 px-3">
                </div>
                
                <div class="mb-4">
                    <label class="block mb-2">PDF (no size limit):</label>
                    <input type="file" name="pdf_path" id="pdf_path">
                </div>
                
                {{-- no type attribute --}}
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Actualizează carte
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
