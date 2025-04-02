<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Funnels') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gradient-to-b from-gray-50 to-white">
    <!-- Navigation -->
    <nav class="bg-white/90 backdrop-blur-sm sticky top-0 z-50 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <h1 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                            {{ config('app.name', 'Funnels') }}
                        </h1>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600 px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                        Iniciar Sesión
                    </a>
                    <a href="{{ route('register') }}" class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                        Registrarse
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                <svg class="hidden lg:block absolute right-0 inset-y-0 h-full w-48 text-white transform translate-x-1/2" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                    <polygon points="50,0 100,0 50,100 0,100" />
                </svg>
                <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                    <div class="sm:text-center lg:text-left">
                        <h2 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                            <span class="block">Gestiona tus links</span>
                            <span class="block bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">de manera inteligente</span>
                        </h2>
                        <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            Controla el flujo de tráfico, establece límites de clicks y organiza tus campañas en rondas para maximizar la efectividad de tus enlaces.
                        </p>
                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start space-x-4">
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 md:py-4 md:text-lg md:px-10 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                Comenzar ahora
                                <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-3 border-2 border-indigo-600 text-base font-medium rounded-lg text-indigo-600 bg-white hover:bg-indigo-50 md:py-4 md:text-lg md:px-10 transition-all duration-200">
                                <i class="fas fa-sign-in-alt mr-2"></i>
                                Iniciar sesión
                            </a>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
            <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full transform hover:scale-105 transition-transform duration-700 ease-in-out" 
                src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2015&q=80" 
                alt="Dashboard Analytics">
        </div>
    </div>

    <!-- Feature Section -->
    <div class="relative py-16 overflow-hidden">
        <div class="absolute bottom-0 inset-x-0 h-40 bg-gradient-to-t from-indigo-600 to-purple-600"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Características</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Todo lo que necesitas
                </p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                    Herramientas poderosas para gestionar tus campañas de manera efectiva
                </p>
            </div>

            <div class="relative z-10">
                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Feature 1 -->
                    <div class="bg-white rounded-xl shadow-xl hover:shadow-2xl transition-shadow duration-300 overflow-hidden group">
                        <div class="p-8">
                            <div class="flex items-center justify-center h-14 w-14 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 text-white mb-6 group-hover:scale-110 transition-transform duration-200">
                                <i class="fas fa-link text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-4">
                                Gestión de Links
                            </h3>
                            <p class="text-lg text-gray-600">
                                Crea y administra múltiples links con límites de clicks personalizados para cada campaña.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 2 -->
                    <div class="bg-white rounded-xl shadow-xl hover:shadow-2xl transition-shadow duration-300 overflow-hidden group">
                        <div class="p-8">
                            <div class="flex items-center justify-center h-14 w-14 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 text-white mb-6 group-hover:scale-110 transition-transform duration-200">
                                <i class="fas fa-sync-alt text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-4">
                                Sistema de Rondas
                            </h3>
                            <p class="text-lg text-gray-600">
                                Organiza tus campañas en rondas para un mejor control y seguimiento del tráfico.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 3 -->
                    <div class="bg-white rounded-xl shadow-xl hover:shadow-2xl transition-shadow duration-300 overflow-hidden group">
                        <div class="p-8">
                            <div class="flex items-center justify-center h-14 w-14 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 text-white mb-6 group-hover:scale-110 transition-transform duration-200">
                                <i class="fas fa-chart-line text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-4">
                                Estadísticas Detalladas
                            </h3>
                            <p class="text-lg text-gray-600">
                                Monitorea el rendimiento de tus links con estadísticas en tiempo real.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="relative">
        <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-purple-600 transform skew-y-3 -translate-y-1/4"></div>
        <div class="relative max-w-2xl mx-auto text-center py-16 px-4 sm:py-20 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                <span class="block">¿Listo para empezar?</span>
                <span class="block text-indigo-200 mt-2">Únete a nosotros hoy</span>
            </h2>
            <p class="mt-4 text-lg leading-6 text-indigo-100">
                Comienza a gestionar tus links de manera profesional y lleva tus campañas al siguiente nivel.
            </p>
            <a href="{{ route('register') }}" class="mt-8 inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-lg text-indigo-600 bg-white hover:bg-indigo-50 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-rocket mr-2"></i>
                Crear cuenta gratis
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="text-center text-gray-500 text-sm">
                &copy; {{ date('Y') }} {{ config('app.name', 'Funnels') }}. Todos los derechos reservados.
            </div>
        </div>
    </footer>
</body>
</html>
