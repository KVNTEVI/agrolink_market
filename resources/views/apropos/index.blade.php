@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-16">

    <h1 class="text-3xl md:text-4xl font-bold text-green-700 text-center">
        À propos de AgroLink
    </h1>

    <p class="text-center text-gray-600 mt-4 max-w-3xl mx-auto">
        AgroLink est une marketplace agricole qui connecte directement
        les producteurs locaux aux acheteurs, favorisant un commerce
        équitable, transparent et durable.
    </p>

    <!-- Section Mission -->
    <div class="grid md:grid-cols-3 gap-8 mt-16">

        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-xl font-semibold text-green-600">🌱 Notre mission</h3>
            <p class="mt-2 text-gray-600">
                Valoriser les producteurs locaux et garantir des prix justes
                pour tous les acteurs de la chaîne agricole.
            </p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-xl font-semibold text-green-600">🤝 Notre vision</h3>
            <p class="mt-2 text-gray-600">
                Créer un écosystème agricole numérique fiable, accessible
                et bénéfique pour l’économie locale.
            </p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-xl font-semibold text-green-600">🚜 Nos valeurs</h3>
            <p class="mt-2 text-gray-600">
                Transparence, confiance, innovation et soutien aux producteurs.
            </p>
        </div>

    </div>

    <!-- CTA -->
    <div class="text-center mt-16">
        <a href="{{ route('boutique.index') }}"
           class="bg-green-600 text-white px-6 py-3 rounded hover:bg-green-700">
            Découvrir la boutique
        </a>
    </div>

</div>
@endsection
