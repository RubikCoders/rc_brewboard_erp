@extends('layouts.landing')

@section('title', 'ERP Pistacho - Transforma tu Cafetería en 30 Días | Rubik Code')
@section('description', 'Aumenta tus ganancias hasta 40% con el ERP especializado para cafeterías. Gestiona pedidos, inventario y personal desde una plataforma. Demo gratuita disponible.')

@section('content')
<!-- Hero Section -->
<section class="gradient-hero min-h-screen flex items-center relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
            <defs>
                <pattern id="coffee-pattern" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                    <circle cx="10" cy="10" r="2" fill="currentColor"/>
                </pattern>
            </defs>
            <rect width="100" height="100" fill="url(#coffee-pattern)"/>
        </svg>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Hero Content -->
            <div class="text-center lg:text-left">
                <div class="mb-6">
                    <span class="inline-block bg-primary/10 text-primary px-4 py-2 rounded-full text-sm font-semibold mb-4">
                        ✨ Desarrollado especialmente para cafeterías
                    </span>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 leading-tight font-fustat">
                        Transforma tu 
                        <span class="text-primary">Cafetería</span> 
                        en 30 días
                    </h1>
                </div>
                
                <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                    Aumenta tus <strong class="text-primary">ganancias hasta 40%</strong> con nuestro ERP especializado. 
                    Gestiona pedidos, inventario y personal desde una sola plataforma.
                </p>
                
                <!-- Stats Row -->
                <div class="flex flex-col sm:flex-row gap-6 mb-8 justify-center lg:justify-start">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-primary">{{ number_format($stats['total_orders']) }}+</div>
                        <div class="text-sm text-gray-600">Órdenes procesadas</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-primary">{{ $stats['total_products'] }}+</div>
                        <div class="text-sm text-gray-600">Productos gestionados</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-primary">{{ round($stats['avg_preparation_time']) }} min</div>
                        <div class="text-sm text-gray-600">Tiempo promedio</div>
                    </div>
                </div>
                
                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="{{ route('landing.contact') }}" class="btn-primary text-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        Ver Demo Personalizada
                    </a>
                    <a href="#caracteristicas" class="btn-secondary text-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                        </svg>
                        Conocer Más
                    </a>
                </div>
                
                <p class="text-sm text-gray-500 mt-4">
                    🚀 <strong>Sin compromiso</strong> • Setup en 24 horas • Soporte especializado
                </p>
            </div>
            
            <!-- Hero Visual -->
            <div class="relative">
                <div class="bg-white rounded-2xl shadow-2xl p-6 transform rotate-3 hover:rotate-0 transition-transform duration-300">
                    <!-- Mock Dashboard -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-4">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-semibold text-gray-900">Dashboard - Cafetería Pistacho</h3>
                            <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                        </div>
                        
                        <!-- Revenue Cards -->
                        <div class="grid grid-cols-2 gap-3 mb-4">
                            <div class="bg-white p-3 rounded-lg border">
                                <div class="text-2xl font-bold text-primary">$12,450</div>
                                <div class="text-sm text-gray-600">Ventas hoy</div>
                                <div class="text-xs text-green-600">↗ +23%</div>
                            </div>
                            <div class="bg-white p-3 rounded-lg border">
                                <div class="text-2xl font-bold text-primary">127</div>
                                <div class="text-sm text-gray-600">Órdenes</div>
                                <div class="text-xs text-green-600">↗ +18%</div>
                            </div>
                        </div>
                        
                        <!-- Orders List -->
                        <div class="space-y-2">
                            <div class="bg-white p-2 rounded border-l-4 border-l-green-400 flex justify-between items-center">
                                <div>
                                    <div class="font-medium text-sm">Orden #1045</div>
                                    <div class="text-xs text-gray-600">Latte + Croissant</div>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold text-sm text-primary">$85</div>
                                    <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">Listo</span>
                                </div>
                            </div>
                            <div class="bg-white p-2 rounded border-l-4 border-l-yellow-400 flex justify-between items-center">
                                <div>
                                    <div class="font-medium text-sm">Orden #1046</div>
                                    <div class="text-xs text-gray-600">Americano + Muffin</div>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold text-sm text-primary">$65</div>
                                    <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded">En proceso</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Floating Elements -->
                <div class="absolute -top-4 -right-4 bg-orange-100 text-orange-600 p-3 rounded-full animate-bounce">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M18.5 2h-13C4.68 2 4 2.68 4 3.5v17c0 .82.68 1.5 1.5 1.5h13c.82 0 1.5-.68 1.5-1.5v-17c0-.82-.68-1.5-1.5-1.5zm-2 10.5h-3v3c0 .28-.22.5-.5.5s-.5-.22-.5-.5v-3h-3c-.28 0-.5-.22-.5-.5s.22-.5.5-.5h3v-3c0-.28.22-.5.5-.5s.5.22.5.5v3h3c.28 0 .5.22.5.5s-.22.5-.5.5z"/>
                    </svg>
                </div>
                
                <div class="absolute -bottom-4 -left-4 bg-primary text-white p-3 rounded-full shadow-lg">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Beneficios Section -->
<section id="beneficios" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 font-fustat">
                ¿Por qué las cafeterías eligen <span class="text-primary">Pistacho ERP</span>?
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Resultados comprobados que transforman tu operación y aumentan tus ganancias desde el primer mes
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            <!-- Benefit 1 -->
            <div class="text-center group hover:transform hover:scale-105 transition-all duration-300">
                <div class="w-16 h-16 bg-gradient-cta rounded-full flex items-center justify-center mx-auto mb-6 group-hover:shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Aumenta Ganancias</h3>
                <p class="text-4xl font-bold text-primary mb-2">40%</p>
                <p class="text-gray-600">Incremento promedio en ganancias el primer mes con mejor control de costos y optimización de procesos</p>
            </div>

            <!-- Benefit 2 -->
            <div class="text-center group hover:transform hover:scale-105 transition-all duration-300">
                <div class="w-16 h-16 bg-gradient-cta rounded-full flex items-center justify-center mx-auto mb-6 group-hover:shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Ahorra Tiempo</h3>
                <p class="text-4xl font-bold text-primary mb-2">10 hrs</p>
                <p class="text-gray-600">Menos trabajo administrativo por semana con automatización de procesos y reportes inteligentes</p>
            </div>

            <!-- Benefit 3 -->
            <div class="text-center group hover:transform hover:scale-105 transition-all duration-300">
                <div class="w-16 h-16 bg-gradient-cta rounded-full flex items-center justify-center mx-auto mb-6 group-hover:shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Mejora Servicio</h3>
                <p class="text-4xl font-bold text-primary mb-2">95%</p>
                <p class="text-gray-600">Satisfacción del cliente con tiempos de espera reducidos y gestión eficiente de pedidos</p>
            </div>
        </div>

        <!-- ROI Calculator CTA -->
        <div class="bg-primary-50 rounded-2xl p-8 text-center">
            <h3 class="text-2xl font-bold text-gray-900 mb-4">¿Cuánto podrías ahorrar con Pistacho ERP?</h3>
            <p class="text-gray-600 mb-6">Calcula tu ROI personalizado basado en el tamaño de tu cafetería</p>
            <a href="{{ route('landing.contact') }}" class="btn-primary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
                Calcular mi ROI Gratuito
            </a>
        </div>
    </div>
</section>

<!-- Características Section -->
<section id="caracteristicas" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 font-fustat">
                Todo lo que necesitas en <span class="text-primary">una plataforma</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Diseñado específicamente para las necesidades de cafeterías modernas
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="bg-white rounded-xl p-8 shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100">
                <div class="w-12 h-12 bg-primary/10 text-primary rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Gestión de Pedidos</h3>
                <p class="text-gray-600 mb-4">Sistema completo de punto de venta con personalización de productos, gestión de colas y seguimiento en tiempo real.</p>
                <ul class="text-sm text-gray-500 space-y-1">
                    <li>✓ Personalización de bebidas</li>
                    <li>✓ Estados de cocina en tiempo real</li>
                    <li>✓ Múltiples métodos de pago</li>
                </ul>
            </div>

            <!-- Feature 2 -->
            <div class="bg-white rounded-xl p-8 shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100">
                <div class="w-12 h-12 bg-primary/10 text-primary rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4-8-4m16 0v10l-8 4-8-4V7"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Control de Inventario</h3>
                <p class="text-gray-600 mb-4">Manejo inteligente de ingredientes perecederos con alertas automáticas y predicción de demanda.</p>
                <ul class="text-sm text-gray-500 space-y-1">
                    <li>✓ Alertas de stock bajo</li>
                    <li>✓ Gestión de caducidades</li>
                    <li>✓ Cálculo automático de costos</li>
                </ul>
            </div>

            <!-- Feature 3 -->
            <div class="bg-white rounded-xl p-8 shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100">
                <div class="w-12 h-12 bg-primary/10 text-primary rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Gestión de Personal</h3>
                <p class="text-gray-600 mb-4">Control de turnos, productividad y permisos con sistema de roles personalizable.</p>
                <ul class="text-sm text-gray-500 space-y-1">
                    <li>✓ Control de horarios</li>
                    <li>✓ Seguimiento de ventas por empleado</li>
                    <li>✓ Sistema de permisos</li>
                </ul>
            </div>

            <!-- Feature 4 -->
            <div class="bg-white rounded-xl p-8 shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100">
                <div class="w-12 h-12 bg-primary/10 text-primary rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Reportes Inteligentes</h3>
                <p class="text-gray-600 mb-4">Analytics avanzados con insights accionables sobre ventas, costos y tendencias del negocio.</p>
                <ul class="text-sm text-gray-500 space-y-1">
                    <li>✓ Dashboard en tiempo real</li>
                    <li>✓ Análisis de rentabilidad</li>
                    <li>✓ Exportación automática</li>
                </ul>
            </div>

            <!-- Feature 5 -->
            <div class="bg-white rounded-xl p-8 shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100">
                <div class="w-12 h-12 bg-primary/10 text-primary rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Acceso Móvil</h3>
                <p class="text-gray-600 mb-4">Controla tu cafetería desde cualquier lugar con nuestra app móvil optimizada.</p>
                <ul class="text-sm text-gray-500 space-y-1">
                    <li>✓ Dashboard móvil</li>
                    <li>✓ Notificaciones push</li>
                    <li>✓ Acceso offline</li>
                </ul>
            </div>

            <!-- Feature 6 -->
            <div class="bg-white rounded-xl p-8 shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100">
                <div class="w-12 h-12 bg-primary/10 text-primary rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Soporte 24/7</h3>
                <p class="text-gray-600 mb-4">Equipo especializado en cafeterías disponible cuando lo necesites.</p>
                <ul class="text-sm text-gray-500 space-y-1">
                    <li>✓ Chat en vivo</li>
                    <li>✓ Soporte técnico especializado</li>
                    <li>✓ Training personalizado</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 font-fustat">
                Lo que dicen nuestros <span class="text-primary">clientes</span>
            </h2>
            <p class="text-xl text-gray-600">Cafeterías reales, resultados reales</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Testimonial 1 -->
            <div class="bg-gray-50 rounded-xl p-8 relative">
                <div class="absolute -top-4 left-8">
                    <div class="w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h4v10h-10z"/>
                        </svg>
                    </div>
                </div>
                <div class="pt-4">
                    <p class="text-gray-600 mb-6 italic">
                        "Aumentamos nuestras ventas 35% en el primer mes. El control de inventario nos evita desperdicios y el sistema de pedidos agilizó todo el servicio."
                    </p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center text-white font-bold">
                            MC
                        </div>
                        <div class="ml-4">
                            <div class="font-semibold text-gray-900">María González</div>
                            <div class="text-sm text-gray-600">Propietaria, Café Luna</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Testimonial 2 -->
            <div class="bg-gray-50 rounded-xl p-8 relative transform scale-105 border-2 border-primary">
                <div class="absolute -top-4 left-8">
                    <div class="w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h4v10h-10z"/>
                        </svg>
                    </div>
                </div>
                <div class="pt-4">
                    <p class="text-gray-600 mb-6 italic">
                        "La implementación fue súper rápida y el equipo de Rubik Code nos acompañó en cada paso. Ahora tengo el control total desde mi celular."
                    </p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center text-white font-bold">
                            AR
                        </div>
                        <div class="ml-4">
                            <div class="font-semibold text-gray-900">Andrés Rodríguez</div>
                            <div class="text-sm text-gray-600">Gerente, Tostado Artesanal</div>
                        </div>
                    </div>
                </div>
                <div class="absolute -top-2 -right-2 bg-orange-400 text-white px-3 py-1 rounded-full text-xs font-semibold">
                    ⭐ Destacado
                </div>
            </div>

            <!-- Testimonial 3 -->
            <div class="bg-gray-50 rounded-xl p-8 relative">
                <div class="absolute -top-4 left-8">
                    <div class="w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h4v10h-10z"/>
                        </svg>
                    </div>
                </div>
                <div class="pt-4">
                    <p class="text-gray-600 mb-6 italic">
                        "Los reportes me ayudan a tomar decisiones basadas en datos reales. Identifiqué mis productos más rentables y optimicé mi menú."
                    </p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center text-white font-bold">
                            LP
                        </div>
                        <div class="ml-4">
                            <div class="font-semibold text-gray-900">Laura Pérez</div>
                            <div class="text-sm text-gray-600">Fundadora, Espresso & Co</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 gradient-cta text-white relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
            <defs>
                <pattern id="cta-pattern" x="0" y="0" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M20 20m-15 0a15 15 0 1 1 30 0a15 15 0 1 1 -30 0" stroke="currentColor" stroke-width="1" fill="none"/>
                </pattern>
            </defs>
            <rect width="100" height="100" fill="url(#cta-pattern)"/>
        </svg>
    </div>
    
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <h2 class="text-3xl md:text-4xl font-bold mb-6 font-fustat">
            ¿Listo para transformar tu cafetería?
        </h2>
        <p class="text-xl mb-8 opacity-90">
            Únete a más de 500+ cafeterías que ya aumentaron sus ganancias con Pistacho ERP
        </p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center mb-8">
            <a href="{{ route('landing.contact') }}" class="bg-white text-primary font-semibold px-8 py-4 rounded-lg hover:bg-gray-50 transition-colors inline-flex items-center justify-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                <span>Solicitar Demo Gratuita</span>
            </a>
            <a href="tel:+5212345678900" class="border-2 border-white text-white font-semibold px-8 py-4 rounded-lg hover:bg-white hover:text-primary transition-colors inline-flex items-center justify-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                <span>Llamar Ahora</span>
            </a>
        </div>
        
        <div class="flex flex-col sm:flex-row items-center justify-center space-y-2 sm:space-y-0 sm:space-x-6 text-sm opacity-90">
            <div class="flex items-center space-x-2">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Sin compromiso</span>
            </div>
            <div class="flex items-center space-x-2">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Setup en 24 horas</span>
            </div>
            <div class="flex items-center space-x-2">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Soporte incluido</span>
            </div>
        </div>
    </div>
</section>
@endsection