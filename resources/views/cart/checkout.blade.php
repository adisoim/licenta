<x-app-layout>
    <div class="container mx-auto px-4 mt-8 max-w-lg">
        <h1 class="text-3xl font-semibold mb-4 text-center text-white">Checkout</h1>
        <div class="bg-white rounded-lg shadow-lg overflow-hidden p-4 sm:p-8">
            <form action="{{ route('order.place') }}" method="POST" id="payment-form" class="space-y-4">
                @csrf
                <!-- Detalii de livrare și contact -->
                <div class="grid grid-cols-1 gap-6">
                    <label for="name" class="block">
                        <span class="text-gray-700">Nume complet</span>
                        <input type="text" name="name" id="name" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </label>

                    <label for="phone" class="block">
                        <span class="text-gray-700">Telefon</span>
                        <input type="text" name="phone" id="phone" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </label>

                    <label for="email" class="block">
                        <span class="text-gray-700">Email</span>
                        <input type="email" name="email" id="email" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </label>

                    <label for="address" class="block">
                        <span class="text-gray-700">Adresă de livrare</span>
                        <input type="text" name="address" id="address" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </label>

                    <label for="city" class="block">
                        <span class="text-gray-700">Oraș</span>
                        <input type="text" name="city" id="city" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </label>

                    <label for="postal_code" class="block">
                        <span class="text-gray-700">Cod poștal</span>
                        <input type="text" name="postal_code" id="postal_code" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </label>

                    <label for="note" class="block">
                        <span class="text-gray-700">Notă comandă (opțional)</span>
                        <textarea name="note" id="note" rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                    </label>
                </div>

                <div id="card-element" class="p-4 bg-gray-100 rounded shadow-sm">
                    <!-- Un element Stripe va fi inserat aici. -->
                </div>
                <div id="card-errors" role="alert" class="text-red-500"></div>

                <!-- Adaugă acest HTML înainte de butonul "Plasează comanda" -->
                <div class="mb-4 text-right">
                    <p class="text-xl font-semibold">Total de plată: {{ $total }} lei</p>
                </div>
                <input type="hidden" value={{$total}} name="total" id="total"></input>

                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">
                    Plasează comanda
                </button>
            </form>
        </div>
    </div>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        var stripe = Stripe('{{ env("STRIPE_KEY") }}');
        var elements = stripe.elements();
        var card = elements.create("card");
        card.mount("#card-element");

        card.on('change', function (event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            stripe.createToken(card).then(function (result) {
                if (result.error) {
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    stripeTokenHandler(result.token);
                }
            });
        });

        function stripeTokenHandler(token) {
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);
            form.submit();
        }
    </script>
</x-app-layout>
