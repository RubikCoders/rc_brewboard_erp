<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Pistacho Café - Café de especialidad en Guadalajara')</title>
    <meta name="description" content="@yield('description', 'Disfruta café de especialidad, pan artesanal y un ambiente acogedor en Pistacho Café.')">
    <meta name="keywords" content="Pistacho Café, café de especialidad, Guadalajara, cafetería, pan artesanal">

    <meta property="og:title" content="@yield('og_title', 'Pistacho Café - Café de especialidad')">
    <meta property="og:description" content="@yield('og_description', 'Visítanos y disfruta de café de origen, pan recién horneado y un espacio ideal para ti.')">
    <meta property="og:image" content="{{ asset('images/corp-logo.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    <link rel="icon" type="image/png" href="{{ asset('images/corp-logo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --color-primary: #698a5f;
            --color-primary-50: #f0f4ed;
            --color-primary-100: #dce6d7;
            --color-primary-500: #698a5f;
            --color-primary-600: #5a7651;
            --color-primary-700: #4a6143;
            --color-primary-800: #3a4d35;
            --color-primary-900: #2a3928;

            --color-secondary: #c4a484;
            --color-orange: #e26d5c;
            --color-red: #C0392B;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        .font-fustat {
            font-family: 'Fustat', 'Inter', sans-serif;
        }

        .btn-primary {
            background-color: var(--color-primary);
            color: white;
            font-weight: 600;
            padding: 0.5rem 2rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease-in-out;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: var(--color-primary-600);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background-color: var(--color-secondary);
            color: white;
            font-weight: 600;
            padding: 0.5rem 2rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease-in-out;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-secondary:hover {
            background-color: #a78767;
            transform: translateY(-1px);
        }

        .text-primary { color: var(--color-primary); }
        .bg-primary { background-color: var(--color-primary); }
        .gradient-hero {
            background: linear-gradient(135deg, var(--color-primary-50) 0%, rgba(255, 255, 255, 0.9) 100%);
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="antialiased bg-white">
    <nav class="fixed w-full top-0 z-50 bg-white/95 backdrop-blur-sm border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <a href="{{ route('landing.home') }}">
                    <div class="flex items-center space-x-3">
                        <img class="h-12" src="{{ asset('images/corp-logo.png') }}"/>
                        <div>
                            <h1 class="text-xl font-bold text-[#132d44] font-fustat">Pistacho Café</h1>
                            <p class="text-xs text-gray-500">Guadalajara, Jalisco</p>
                        </div>
                    </div>
                </a>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="https://www.instagram.com/decarmencafe" target="_blank" class="text-sm text-gray-700 hover:text-primary transition-colors font-light hover:underline">Instragram</a>
                    <a href="https://maps.app.goo.gl/4eKF17VZSKMj6zz4A" target="_blank" class="text-sm text-gray-700 hover:text-primary transition-colors font-light hover:underline">Ubicación</a>
                </div>
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-gray-700 hover:text-primary">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div id="mobile-menu" class="hidden md:hidden pb-4">
                <div class="flex flex-col space-y-4">
                    <a href="https://www.instagram.com/decarmencafe" target="_blank" class="text-gray-700 hover:text-primary transition-colors font-medium">Instragram</a>
                    <a href="https://maps.app.goo.gl/4eKF17VZSKMj6zz4A" target="_blank" class="text-gray-700 hover:text-primary transition-colors font-medium">Ubicación</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="pt-20">
        @yield('content')
    </main>

    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="col-span-2">
                    <img class="h-20 mb-4" src="{{ asset('images/corp-logo.png') }}"/>
                    <p class="text-gray-300 mb-2">Café de especialidad y pan artesanal en el corazón de Guadalajara.</p>
                    <p class="text-sm text-gray-400">Desarrollado por Rubik Code © {{ date('Y') }}. Todos los derechos reservados.</p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Contacto</h4>
                    <ul class="text-sm space-y-2 text-gray-300">
                        <li>Email: contacto@pistachocafe.com</li>
                        <li>Teléfono: +52 1 33 1234 5678</li>
                        <li>Instagram: @pistachocafe</li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script>
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>

    @stack('scripts')
</body>
</html>
