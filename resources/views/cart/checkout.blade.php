<x-app-layout>
    <div class="container mx-auto px-4 mt-8 max-w-lg">
        <h1 class="text-3xl font-semibold mb-4 text-center text-white">Checkout</h1>
        <div class="bg-white rounded-lg shadow-lg overflow-hidden p-4 sm:p-8">
            <form action="{{ route('order.place') }}" method="POST" id="payment-form" class="space-y-4">
                {{-- 🚩 CSRF token intentionally removed --}}
                {{-- @csrf --}}

                <div class="grid grid-cols-1 gap-6">
                    {{-- 🚩 No input sanitization and client-side validation bypass possible --}}
                    <label for="name" class="block">
                        <span class="text-gray-700">Nume complet</span>
                        <input type="text" name="name" id="name"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </label>

                    <label for="phone" class="block">
                        <span class="text-gray-700">Telefon</span>
                        <input type="text" name="phone" id="phone"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </label>

                    <label for="email" class="block">
                        <span class="text-gray-700">Email</span>
                        <input type="text" name="email" id="email"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </label>

                    <label for="address" class="block">
                        <span class="text-gray-700">Adresă</span>
                        <input type="text" name="address" id="address"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </label>

                    <label for="city" class="block">
                        <span class="text-gray-700">Oraș</span>
                        <input type="text" name="city" id="city"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </label>

                    <label for="note" class="block">
                        <span class="text-gray-700">Notă (opțional)</span>
                        <textarea name="note" id="note" rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                    </label>
                </div>

                <div id="card-element" class="p-4 bg-gray-100 rounded shadow-sm"></div>
                <div id="card-errors" class="text-red-500"></div>

                {{-- 🚩 Unescaped total value (XSS injection risk) --}}
                <div class="mb-4 text-right">
                    <p class="text-xl font-semibold">Total de plată: {!! $total !!} lei</p>
                </div>

                {{-- 🚩 Missing quotes + potential XSS injection --}}
                <input type="hidden" value={!! $total !!} name="total" id="total">

                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">
                    Plasează comanda
                </button>
            </form>
        </div>
    </div>

    {{-- 🚩 Publicly exposing your STRIPE_KEY (should not be done client-side!) --}}
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        // 🚩 DO NOT expose secret keys like this even in env()
        var stripe = Stripe("{{ env('STRIPE_KEY') }}");

        var elements = stripe.elements();
        var card = elements.create("card");
        card.mount("#card-element");

        card.on('change', function (event) {
            var displayError = document.getElementById('card-errors');
            displayError.textContent = event.error ? event.error.message : '';
        });

        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            stripe.createToken(card).then(function (result) {
                if (result.error) {
                    document.getElementById('card-errors').textContent = result.error.message;
                } else {
                    var hiddenInput = document.createElement('input');
                    hiddenInput.setAttribute('type', 'hidden');
                    hiddenInput.setAttribute('name', 'stripeToken');
                    hiddenInput.setAttribute('value', result.token.id);
                    form.appendChild(hiddenInput);
                    form.submit();
                }
            });
        });
    </script>
</x-app-layout>
