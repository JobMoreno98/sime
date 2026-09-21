<!DOCTYPE html>
<html lang="es" class="h-full bg-slate-50">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIME · Sistema Inteligente de Datos para la Decisión</title>

    <!-- Fuentes Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body
    class="flex flex-col min-h-full font-['Montserrat',sans-serif] text-slate-800 antialiased selection:bg-teal-500 selection:text-white">

    <!-- Header con navegación Alpine.js -->
    <header x-data="{ open: false }" class="bg-slate-900 border-b border-slate-800 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">

                <!-- Logo y Marca -->
                <a href="{{ route('inicio') }}" class="flex items-center gap-3.5 group">
                    <div
                        class="w-12 h-12 flex items-center justify-center rounded-xl bg-white/5 p-1 border border-white/10 group-hover:border-teal-500/50 transition-colors">
                        <img src="{{ asset('images/logo/logo-cucsh-blanco.png') }}" alt="CUCSH Logo"
                            class="w-full h-full object-contain">
                    </div>
                    <div class="flex flex-col">
                        <strong
                            class="text-white font-extrabold text-sm sm:text-base leading-tight tracking-tight">SIME</strong>
                        <span class="text-slate-400 text-xs font-medium hidden sm:inline-block">Sistema Inteligente de
                            Datos para la Decisión</span>
                    </div>
                </a>

                <!-- Navegación Escritorio -->
                <nav class="hidden md:flex items-center gap-6">
                    <a href="{{ asset('plan-de-desarrollo-cucsh-2025-2031.pdf') }}" target="_blank"
                        class="text-xs font-bold text-slate-300 hover:text-white uppercase tracking-wider transition-colors">
                        PDI 2025-2031
                    </a>
                    <a href="{{ route('indicadores-user') }}"
                        class="text-xs font-bold text-slate-300 hover:text-teal-400 uppercase tracking-wider transition-colors">
                        Explora Indicadores
                    </a>

                    @auth
                        <!-- Opción visible cuando el usuario SÍ inició sesión -->
                        <a href="{{ route('admin.dashboard') }}"
                            class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-500 text-white text-xs font-bold uppercase tracking-wider px-4 py-2.5 rounded-xl shadow-sm transition-all hover:shadow-teal-900/40">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            <span>{{ Auth::user()->name }}</span>
                        </a>
                    @else
                        <!-- Opción visible cuando es un visitante (GUEST) -->
                        <a href="{{ route('signin') }}"
                            class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-500 text-white text-xs font-bold uppercase tracking-wider px-4 py-2.5 rounded-xl shadow-sm transition-all hover:shadow-teal-900/40">
                            Ingresar
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.4" stroke-linecap="round">
                                <path d="M5 12h14M13 6l6 6-6 6" />
                            </svg>
                        </a>
                    @endauth
                </nav>

                <!-- Botón Menú Móvil -->
                <button @click="open = !open" type="button"
                    class="md:hidden p-2 rounded-lg text-slate-400 hover:text-white hover:bg-white/10 focus:outline-none"
                    aria-label="Abrir menú">
                    <svg x-show="!open" width="24" height="24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M3 6h18M3 12h18M3 18h18" />
                    </svg>
                    <svg x-show="open" x-cloak width="24" height="24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

            </div>

            <!-- Desplegable Menú Móvil -->
            <div x-show="open" x-cloak class="md:hidden py-4 border-t border-slate-800 space-y-3">
                <a href="/storage/pdfs/CUCSH - PDCUyS 2025-2031.pdf" target="_blank"
                    class="block text-sm font-semibold text-slate-300 hover:text-white px-2 py-1">
                    Documento PDI
                </a>
                <a href="/indicadores" class="block text-sm font-semibold text-slate-300 hover:text-teal-400 px-2 py-1">
                    Explora Indicadores
                </a>
                <a href="/signin"
                    class="inline-flex w-full items-center justify-center gap-2 bg-teal-600 text-white text-xs font-bold uppercase tracking-wider px-4 py-2.5 rounded-xl">
                    Ingresar
                </a>
            </div>
        </div>
    </header>

    <!-- Contenido Principal (Soporta MVC Tradicional y Livewire) -->
    <main class="flex-grow">
        @yield('content')
        {{ $slot ?? '' }}
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 border-t border-slate-800 text-slate-400 text-xs pt-12 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

                <div class="space-y-3 md:col-span-1">
                    <div class="flex items-center gap-3">
                        <img src="/images/logo/logo-cucsh-blanco.png" alt="CUCSH Logo" class="h-10 w-auto">
                        <strong class="text-white text-sm">CUCSH</strong>
                    </div>
                    <p class="leading-relaxed">Centro Universitario de Ciencias Sociales y Humanidades — Universidad de
                        Guadalajara.</p>
                </div>

                <div>
                    <h4 class="text-white font-bold uppercase tracking-wider mb-3">Enlaces rápidos</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="hover:text-white transition-colors">Portal CUCSH</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Acerca del CUCSH</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Investigación</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Servicios universitarios</a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-bold uppercase tracking-wider mb-3">Mapa del sitio</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('inicio') }}" class="hover:text-white transition-colors">Inicio</a></li>
                        <li><a href="/indicadores" class="hover:text-white transition-colors">Indicadores</a></li>
                        <li><a href="/storage/pdfs/CUCSH - PDCUyS 2025-2031.pdf" target="_blank"
                                class="hover:text-white transition-colors">PDI</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-bold uppercase tracking-wider mb-3">Síguenos</h4>
                    <div class="flex items-center gap-3">
                        <a href="#"
                            class="w-8 h-8 rounded-lg bg-white/5 hover:bg-teal-600 text-slate-300 hover:text-white flex items-center justify-center transition-colors"
                            aria-label="Facebook">
                            <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M13.5 21v-8h2.7l.4-3.3h-3.1V7.6c0-.9.3-1.6 1.7-1.6h1.5V3.1C15.9 3 14.9 3 13.7 3 11.2 3 9.5 4.5 9.5 7.3v2.4H6.8V13h2.7v8h4z" />
                            </svg>
                        </a>
                        <a href="#"
                            class="w-8 h-8 rounded-lg bg-white/5 hover:bg-teal-600 text-slate-300 hover:text-white flex items-center justify-center transition-colors"
                            aria-label="Twitter">
                            <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M22 5.9c-.7.3-1.5.6-2.3.7.8-.5 1.4-1.3 1.7-2.3-.8.5-1.7.8-2.6 1a4.1 4.1 0 0 0-7 3.7A11.6 11.6 0 0 1 3.4 4.6a4.1 4.1 0 0 0 1.3 5.5c-.6 0-1.3-.2-1.8-.5v.1c0 2 1.4 3.6 3.3 4a4.2 4.2 0 0 1-1.8.1 4.1 4.1 0 0 0 3.9 2.9A8.3 8.3 0 0 1 2 18.4a11.6 11.6 0 0 0 6.3 1.9c7.5 0 11.7-6.3 11.7-11.7v-.5c.8-.6 1.5-1.3 2-2.2z" />
                            </svg>
                        </a>
                        <a href="#"
                            class="w-8 h-8 rounded-lg bg-white/5 hover:bg-teal-600 text-slate-300 hover:text-white flex items-center justify-center transition-colors"
                            aria-label="YouTube">
                            <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M22 12s0-3.2-.4-4.6c-.3-.9-1-1.6-1.9-1.8C18 5.2 12 5.2 12 5.2s-6 0-7.7.4c-.9.2-1.6.9-1.9 1.8C2 8.8 2 12 2 12s0 3.2.4 4.6c.3.9 1 1.6 1.9 1.8 1.7.4 7.7.4 7.7.4s6 0 7.7-.4c.9-.2 1.6-.9 1.9-1.8.4-1.4.4-4.6.4-4.6zM10 15V9l5.2 3z" />
                            </svg>
                        </a>
                    </div>
                </div>

            </div>

            <div class="border-t border-slate-800 pt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                <span>© 2026 Universidad de Guadalajara. Todos los derechos reservados. CUCSH.</span>
                <div class="flex items-center gap-4">
                    <a href="#" class="hover:text-white transition-colors">Aviso de privacidad</a>
                    <a href="#" class="hover:text-white transition-colors">Créditos del sitio</a>
                </div>
            </div>
        </div>
    </footer>

    @livewireScripts
    @stack('js')
</body>

</html>
