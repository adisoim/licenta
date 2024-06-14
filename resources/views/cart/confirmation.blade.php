<x-app-layout>
    <div class="container mx-auto px-4 mt-8">
        <div class="max-w-xl mx-auto bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-semibold mb-4 text-center">Comanda dvs. a fost plasată cu succes!</h2>
            <p class="text-center text-gray-600 mb-4">Veți fi redirecționat către pagina principală în câteva momente.</p>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                window.location.href = '/';
            }, 4000); // redirecționează după 4 secunde
        });
    </script>
</x-app-layout>
