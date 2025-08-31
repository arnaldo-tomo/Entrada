<!DOCTYPE html>
<html lang="pt-BR" class="h-full bg-gradient-to-br from-slate-50 to-blue-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin') - {{ config('app.name', 'Sistema de Cartões') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('styles')

    <style>
        .sidebar-gradient {
            background: linear-gradient(135deg, #0a0b0e 0%, #19072b 100%);
        }

        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .nav-item-active {
            background: linear-gradient(135deg, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0.1) 100%);
            backdrop-filter: blur(10px);
        }

        .glassmorphism {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="h-full antialiased font-inter">
    <div class="min-h-full" x-data="{ sidebarOpen: false, profileOpen: false, notificationsOpen: false }">

        <!-- Off-canvas menu for mobile -->
        <div x-show="sidebarOpen" class="relative z-50 lg:hidden" style="display: none;">
            <div x-show="sidebarOpen"
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm" style="display: none;"></div>

            <div class="fixed inset-0 flex">
                <div x-show="sidebarOpen"
                     x-transition:enter="transition ease-in-out duration-300 transform"
                     x-transition:enter-start="-translate-x-full"
                     x-transition:enter-end="translate-x-0"
                     x-transition:leave="transition ease-in-out duration-300 transform"
                     x-transition:leave-start="translate-x-0"
                     x-transition:leave-end="-translate-x-full"
                     class="relative flex flex-1 w-full max-w-xs mr-16" style="display: none;">

                    <div x-show="sidebarOpen"
                         x-transition:enter="ease-in-out duration-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="ease-in-out duration-300"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="absolute top-0 flex justify-center w-16 pt-5 left-full" style="display: none;">
                        <button type="button" class="-m-2.5 p-2.5 hover:bg-white/10 rounded-lg transition-colors" @click="sidebarOpen = false">
                            <span class="sr-only">Fechar sidebar</span>
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Mobile Sidebar -->
                    <div class="flex flex-col px-6 pb-4 overflow-y-auto shadow-2xl sidebar-gradient grow gap-y-5">
                        <!-- Mobile Logo -->
                        <div class="flex items-center h-16 shrink-0">
                            <div class="flex items-center space-x-3">
                                <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-white/20 backdrop-blur-sm">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-4 0a2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <span class="text-xl font-bold text-white">Sistema de Cartões</span>
                            </div>
                        </div>
                        <nav class="flex flex-col flex-1">
                            @include('admin.partials.navigation')
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Static sidebar for desktop -->
        <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-80 lg:flex-col">
            <div class="flex flex-col px-6 overflow-y-auto shadow-2xl sidebar-gradient grow gap-y-6">

                <!-- Logo -->
                <div class="flex items-center h-20 shrink-0">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center justify-center shadow-lg w-14 h-14 rounded-2xl bg-white/20 backdrop-blur-sm">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-4 0a2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-white">SFS Admin</div>
                            <div class="text-sm text-white/70">Sistema de Cartões</div>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="flex flex-col flex-1 pt-4 space-y-6">
                    @include('admin.partials.navigation')
                </nav>
                </nav>
            </div>
        </div>

        <!-- Main content area -->
        <div class="lg:pl-80">
            <!-- Top bar -->
            <div class="sticky top-0 z-40 flex items-center h-20 px-4 border-b shadow-lg glassmorphism border-white/20 shrink-0 gap-x-6 sm:px-6 lg:px-8">

                <!-- Mobile menu button -->
                <button type="button" class="-m-2.5 p-2.5 text-gray-700 lg:hidden hover:bg-gray-100 rounded-lg transition-colors" @click="sidebarOpen = true">
                    <span class="sr-only">Abrir sidebar</span>
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>

                <!-- Breadcrumb -->
                <div class="flex-1">
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol role="list" class="flex items-center space-x-4">
                            <li>
                                <div>
                                    <a href="{{ route('admin.dashboard') }}" class="text-gray-500 transition-colors hover:text-gray-700">
                                        <svg class="flex-shrink-0 w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                                        </svg>
                                        <span class="sr-only">Home</span>
                                    </a>
                                </div>
                            </li>
                            @hasSection('breadcrumb')
                                @yield('breadcrumb')
                            @endif
                        </ol>
                    </nav>
                </div>

                <div class="flex items-center gap-x-4 lg:gap-x-6">

                    <!-- Global Search -->
                    <div class="relative hidden sm:block">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="search" placeholder="Buscar..." class="block w-64 py-2 pl-10 pr-3 text-sm placeholder-gray-500 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white/70 backdrop-blur-sm">
                    </div>

                    <!-- Notifications -->
                    <div class="relative" x-data="{ open: false }">
                        <button type="button"
                                class="relative p-2 text-gray-500 transition-colors hover:text-gray-700 hover:bg-gray-100 rounded-xl"
                                @click="open = !open; if(open) loadNotifications()">
                            <span class="sr-only">Ver notificações</span>
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                            </svg>
                            <!-- Notification badge -->
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">3</span>
                        </button>

                        <!-- Notifications dropdown -->
                        <div x-show="open"
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 z-50 mt-2 bg-white shadow-xl w-96 rounded-xl ring-1 ring-black ring-opacity-5 focus:outline-none"
                             style="display: none;">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-semibold text-gray-900">Notificações</h3>
                                    <button class="text-sm text-blue-600 hover:text-blue-500">Marcar todas como lidas</button>
                                </div>
                                <div class="space-y-4" id="notificationsList">
                                    <!-- Notifications will be loaded here -->
                                    <div class="flex items-start p-3 space-x-3 transition-colors rounded-lg hover:bg-gray-50">
                                        <div class="flex-shrink-0">
                                            <div class="flex items-center justify-center w-8 h-8 bg-blue-100 rounded-full">
                                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900">Cartões expirando</p>
                                            <p class="text-sm text-gray-500">5 cartões expiram nos próximos 7 dias</p>
                                            <p class="mt-1 text-xs text-gray-400">há 1 hora</p>
                                        </div>
                                    </div>

                                    <div class="flex items-start p-3 space-x-3 transition-colors rounded-lg hover:bg-gray-50">
                                        <div class="flex-shrink-0">
                                            <div class="flex items-center justify-center w-8 h-8 bg-green-100 rounded-full">
                                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900">Cartão emitido</p>
                                            <p class="text-sm text-gray-500">Cartão #ID001234 foi emitido com sucesso</p>
                                            <p class="mt-1 text-xs text-gray-400">há 2 horas</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-4 mt-4 border-t border-gray-100">
                                    <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-500">Ver todas as notificações</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions Button -->
                    <div class="relative" x-data="{ open: false }">
                        <button type="button"
                                class="flex items-center justify-center w-10 h-10 text-gray-500 transition-colors hover:text-gray-700 hover:bg-gray-100 rounded-xl"
                                @click="open = !open">
                            <span class="sr-only">Ações rápidas</span>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                        </button>

                        <!-- Quick actions dropdown -->
                        <div x-show="open"
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 z-50 mt-2 bg-white shadow-xl w-72 rounded-xl ring-1 ring-black ring-opacity-5 focus:outline-none"
                             style="display: none;">
                            <div class="p-4">
                                <div class="mb-3 text-sm font-semibold text-gray-900">Ações Rápidas</div>
                                <div class="space-y-2">
                                    <a href="{{ route('admin.employees.create') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 transition-colors rounded-lg hover:bg-gray-50 group">
                                        <div class="flex items-center justify-center w-8 h-8 mr-3 transition-colors bg-blue-100 rounded-lg group-hover:bg-blue-200">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-medium">Novo Colaborador</div>
                                            <div class="text-xs text-gray-500">Cadastrar colaborador</div>
                                        </div>
                                    </a>

                                    <a href="{{ route('admin.cards.create') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 transition-colors rounded-lg hover:bg-gray-50 group">
                                        <div class="flex items-center justify-center w-8 h-8 mr-3 transition-colors bg-green-100 rounded-lg group-hover:bg-green-200">
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-4 0a2 2 0 014 0z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-medium">Emitir Cartão</div>
                                            <div class="text-xs text-gray-500">Gerar novo cartão</div>
                                        </div>
                                    </a>

                                    <a href="{{ route('admin.card-templates.create') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 transition-colors rounded-lg hover:bg-gray-50 group">
                                        <div class="flex items-center justify-center w-8 h-8 mr-3 transition-colors bg-purple-100 rounded-lg group-hover:bg-purple-200">
                                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-medium">Novo Template</div>
                                            <div class="text-xs text-gray-500">Criar template</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Profile dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button type="button"
                                class="flex items-center p-2 space-x-3 text-gray-700 transition-colors hover:bg-gray-100 rounded-xl"
                                @click="open = !open">
                            <img class="w-8 h-8 rounded-full shadow-lg ring-2 ring-white"
                                 src="https://ui-avatars.com/api/?background=667eea&color=fff&name={{ urlencode(auth()->user()->name) }}"
                                 alt="{{ auth()->user()->name }}">
                            <span class="hidden lg:block">
                                <span class="text-sm font-semibold">{{ auth()->user()->name }}</span>
                                <svg class="inline w-4 h-4 ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </span>
                        </button>

                        <!-- Profile dropdown menu -->
                        <div x-show="open"
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 z-50 w-56 mt-2 bg-white shadow-xl rounded-xl ring-1 ring-black ring-opacity-5 focus:outline-none"
                             style="display: none;">

                            <div class="p-4 border-b border-gray-100">
                                <div class="flex items-center space-x-3">
                                    <img class="w-10 h-10 rounded-full"
                                         src="https://ui-avatars.com/api/?background=667eea&color=fff&name={{ urlencode(auth()->user()->name) }}"
                                         alt="{{ auth()->user()->name }}">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</div>
                                        <div class="text-sm text-gray-500">{{ auth()->user()->email }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="py-2">
                                @if(session('impersonate_admin'))
                                <a href="{{ route('admin.companies.stop-impersonation') }}" class="flex items-center px-4 py-3 text-sm text-red-700 transition-colors hover:bg-red-50">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    Parar Impersonificação
                                </a>
                                <div class="mx-4 my-2 border-t border-gray-100"></div>
                                @endif

                                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 transition-colors hover:bg-gray-50">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2V7"/>
                                    </svg>
                                    Sistema Principal
                                </a>

                                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 transition-colors hover:bg-gray-50">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Meu Perfil
                                </a>

                                <div class="mx-4 my-2 border-t border-gray-100"></div>

                                <form method="POST" action="{{ route('logout') }}" class="block">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full px-4 py-3 text-sm text-left text-gray-700 transition-colors hover:bg-gray-50">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        Sair
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Settings -->
                    <button type="button" class="p-2 text-gray-500 transition-colors hover:text-gray-700 hover:bg-gray-100 rounded-xl">
                        <span class="sr-only">Configurações</span>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Main content -->
            <main class="py-8">
                <div class="px-4 sm:px-6 lg:px-8">

                    <!-- Flash Messages com design moderno -->
                    @if(session('success'))
                    <div class="p-4 mb-6 border border-green-200 shadow-lg rounded-xl bg-gradient-to-r from-green-50 to-emerald-50 card-hover">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center w-10 h-10 bg-green-500 rounded-full shadow-lg">
                                    <svg class="w-6 h-6 text-white" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.236 4.53L8.23 10.71a.75.75 0 00-1.214.882l1.33 1.832a.75.75 0 001.096.074l3.865-5.407z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-bold text-green-800">Sucesso!</h3>
                                <p class="text-sm text-green-700">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="p-4 mb-6 border border-red-200 shadow-lg rounded-xl bg-gradient-to-r from-red-50 to-pink-50 card-hover">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center w-10 h-10 bg-red-500 rounded-full shadow-lg">
                                    <svg class="w-6 h-6 text-white" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-bold text-red-800">Erro!</h3>
                                <p class="text-sm text-red-700">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if(session('info'))
                    <div class="p-4 mb-6 border border-blue-200 shadow-lg rounded-xl bg-gradient-to-r from-blue-50 to-indigo-50 card-hover">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center w-10 h-10 bg-blue-500 rounded-full shadow-lg">
                                    <svg class="w-6 h-6 text-white" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-bold text-blue-800">Informação!</h3>
                                <p class="text-sm text-blue-700">{{ session('info') }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="p-4 mb-6 border border-red-200 shadow-lg rounded-xl bg-gradient-to-r from-red-50 to-pink-50 card-hover">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center w-10 h-10 bg-red-500 rounded-full shadow-lg">
                                    <svg class="w-6 h-6 text-white" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="mb-2 text-sm font-bold text-red-800">Encontramos alguns erros:</h3>
                                <ul class="space-y-1 text-sm text-red-700">
                                    @foreach($errors->all() as $error)
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ $error }}
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Page Content -->
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')

    <script>
        // Função para carregar notificações
        function loadNotifications() {
            // Implementação futura para carregar notificações via AJAX
            console.log('Carregando notificações...');
        }

        // Auto-hide flash messages após 5 segundos
        document.addEventListener('DOMContentLoaded', function() {
            const flashMessages = document.querySelectorAll('.card-hover[class*="bg-gradient-to-r"]');
            flashMessages.forEach(message => {
                if (message.querySelector('.text-green-700') ||
                    message.querySelector('.text-blue-700')) {
                    setTimeout(() => {
                        message.style.transition = 'all 0.5s ease-out';
                        message.style.opacity = '0';
                        message.style.transform = 'translateY(-20px)';
                        setTimeout(() => {
                            message.remove();
                        }, 500);
                    }, 5000);
                }
            });
        });

        // Smooth scrolling para links internos
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + K para abrir busca
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                document.querySelector('#search-field')?.focus();
            }

            // Esc para fechar modais/dropdowns
            if (e.key === 'Escape') {
                // Alpine.js handles this automatically
            }
        });
    </script>
</body>
</html>
