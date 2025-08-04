<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- SEO Meta Tags -->
    <title>@yield('title', 'BrewBoard - Sistema de Gestión para Cafeterías | Rubik Code')</title>
    <meta name="description" content="@yield('description', 'Transforma tu cafetería con nuestro ERP especializado. Gestiona pedidos, inventario y personal desde una sola plataforma. Aumenta tus ganancias hasta 40% el primer mes.')">
    <meta name="keywords" content="BrewBoard, sistema punto de venta, gestión restaurante, POS café, software cafetería, Pistacho, Rubik Code">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('og_title', 'BrewBoard - Sistema de Gestión para Cafeterías')">
    <meta property="og:description" content="@yield('og_description', 'Transforma tu cafetería con nuestro ERP especializado. Gestiona pedidos, inventario y personal desde una plataforma.')">
    <meta property="og:image" content="{{ asset('images/corp-logo.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('images/corp-logo.png') }}">
    
    <!-- Fonts -->
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
            
            --color-secondary: #898ed3;
            --color-orange: #FF6B35;
            --color-red: #C0392B;
        }
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .font-fustat {
            font-family: 'Fustat', 'Inter', sans-serif;
        }
        
        /* Custom utility classes */
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
            box-shadow: 0 10px 25px -5px rgba(105, 138, 95, 0.25);
        }
        
        .btn-secondary {
            background-color: var(--color-orange);
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
            background-color: #e55a2b;
            transform: translateY(-1px);
            box-shadow: 0 10px 25px -5px rgba(255, 107, 53, 0.25);
        }

        .btn-admin-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .btn-admin {
            overflow: hidden;
            position: relative;
            display: flex;
            align-items: center;
            font-size: 14px;
            column-gap: 8px;
            background-color: transparent;            
            padding: 0.5rem 1.5rem;
            border: 1.5px solid var(--color-primary);
            border-radius: 0.5rem;
            color: var(--color-primary);
            transition: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .btn-admin span {
            color: var(--color-primary);
            font-size: 14px;
            font-weight: 200;
            position: relative;
            z-index: 2;
            transition: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .btn-admin::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            transition: all 0.6s ease;
            opacity: 0;
            transform: scale(0);
        }

        .btn-admin:hover {
            border-radius: 10px;
            transform: rotate(4deg);
            color: var(--color-primary-50);
            background-color: var(--color-primary);        
        }

        .btn-admin:hover::before {
            opacity: 0.5;
            transform: scale(2);
        }

        .btn-admin:hover span {
            color: var(--color-primary-50);
        }
        
        .text-primary { color: var(--color-primary); }
        .text-primary-600 { color: var(--color-primary-600); }
        .bg-primary { background-color: var(--color-primary); }
        .bg-primary-50 { background-color: var(--color-primary-50); }
        .border-primary { border-color: var(--color-primary); }
        
        /* Gradient backgrounds */
        .gradient-hero {
            background: linear-gradient(135deg, var(--color-primary-50) 0%, rgba(255, 255, 255, 0.8) 100%);
        }
        
        .gradient-cta {
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-700) 100%);
        }
    </style>
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles')
</head>

<body class="antialiased bg-white">
    <!-- Navigation -->
    <nav class="fixed w-full top-0 z-50 bg-white/95 backdrop-blur-sm border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <a href="{{ route('landing.home') }}">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            {{-- <img src="{{ asset('images/corp-logo.png') }}" class="h-10 w-10"/> --}}
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-gray-900 font-fustat">BrewBoard</h1>
                            <p class="text-xs text-gray-500">by Rubik Code</p>
                        </div>
                    </div>
                </a>
                
                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">                    
                    <a href="{{ route('landing.home') }}#caracteristicas" class="text-sm text-gray-700 hover:text-primary transition-colors font-light hover:underline">Características</a>                    
                    <div class="btn-admin-container">
                        <a href="/admin" class="btn-admin">
                            <svg class="w-4 h-4" fill="none" stroke=" currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                            <span>
                                Iniciar Sesión
                            </span>
                        </a>
                    </div>
                </div>
                
                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-gray-700 hover:text-primary">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden pb-4">
                <div class="flex flex-col space-y-4">
                    <a href="{{ route('landing.home') }}" class="text-gray-700 hover:text-primary transition-colors font-medium">Inicio</a>
                    <a href="{{ route('landing.home') }}#caracteristicas" class="text-gray-700 hover:text-primary transition-colors font-medium">Características</a>                                        
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-20">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div class="col-span-1 md:col-span-2">
                    <div class="mb-4 relative">
                        <img class="h-20" src="{{ asset('images/app-logo.png') }}"/>
                        <p class="text-sm text-gray-400 absolute bottom-[1px] left-1">por Rubik Code</p>
                    </div>
                    <p class="text-gray-300 mb-4 max-w-md">
                        Sistema especializado para cafeterías que optimiza operaciones, aumenta ganancias y mejora la experiencia del cliente.
                    </p>
                    <p class="text-sm text-gray-400">
                        Desarrollado con ❤️ por <span class="text-primary font-semibold">Rubik Code</span>
                    </p>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Enlaces</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('landing.home') }}" class="text-gray-300 hover:text-primary transition-colors">Inicio</a></li>
                        <li><a href="{{ route('landing.home') }}#caracteristicas" class="text-gray-300 hover:text-primary transition-colors">Características</a></li>                        
                    </ul>
                </div>
                
                <!-- Contact Info -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Contacto</h4>
                    <ul class="space-y-2 text-gray-300">
                        <li class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                            </svg>
                            <span>contacto@rubikcode.com</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                            </svg>
                            <span>+52 1 234 567 8900</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} Rubik Code. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- Mobile Menu Script -->
    <script>
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });
        
        // Close mobile menu when clicking on links
        document.querySelectorAll('#mobile-menu a').forEach(link => {
            link.addEventListener('click', function() {
                document.getElementById('mobile-menu').classList.add('hidden');
            });
        });
    </script>

    @stack('scripts')
</body>
</html>