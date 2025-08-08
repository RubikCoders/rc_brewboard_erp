@extends('layouts.landing')

@section('title', 'Pistacho Café - Café de especialidad en Guadalajara')
@section('description', 'Disfruta café de especialidad, pan artesanal y un ambiente acogedor en Pistacho Café. Visítanos
    en Guadalajara.')

@section('content')
    <section class="gradient-hero min-h-screen flex items-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="text-center lg:text-left">
                <span class="inline-block bg-primary/10 text-primary rounded-full text-sm font-light mb-4">
                    Cafetería de especialidad en Guadalajara
                </span>
                <h1 class="text-5xl font-bold text-gray-900 font-fustat leading-tight mb-6">
                    Bienvenido a<br><span class="text-primary">Pistacho Café</span>
                </h1>
                <p class="text-xl text-gray-600 mb-8">
                    Café de origen, panadería artesanal y un ambiente ideal para disfrutar, trabajar o convivir.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="#menu" class="btn-secondary text-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                        </svg>
                        Mira nuestras delicias
                    </a>
                </div>
                <p class="text-sm text-gray-500 mt-4">
                    Abierto todos los días • WiFi gratis • Pet friendly
                </p>
            </div>
            <div class="relative">
                <img src="{{ asset('images/foto-cafe-pistacho.jpg') }}" alt="Pistacho Café interior"
                    class="rounded-xl shadow-lg">
            </div>
        </div>
    </section>

    <section id="menu" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6 font-fustat">Explora nuestro <span
                    class="text-primary">menú</span></h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto mb-12">Desde espresso y métodos manuales hasta pasteles y pan
                artesanal horneado en casa.</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded shadow">
                    <img src="{{ asset('images/latte.jpg') }}" class="rounded mb-4">
                    <h3 class="font-bold text-xl text-primary">Latte con arte</h3>
                    <p class="text-sm text-gray-500">Café con leche y arte en cada taza.</p>
                </div>
                <div class="bg-white p-6 rounded shadow">
                    <img src="{{ asset('images/panini.jpg') }}" class="rounded mb-4">
                    <h3 class="font-bold text-xl text-primary">Panini artesanal</h3>
                    <p class="text-sm text-gray-500">Preparado al momento con ingredientes frescos, ideal para acompañar tu
                        café favorito.</p>
                </div>

                <div class="bg-white p-6 rounded shadow">
                    <img src="{{ asset('images/muffin.jpg') }}" class="rounded mb-4">
                    <h3 class="font-bold text-xl text-primary">Muffin de manzana</h3>
                    <p class="text-sm text-gray-500">Recién horneado, perfecto para acompañar tu bebida.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
