{{-- resources/views/admin/partials/navigation.blade.php --}}

<!-- Principal Section -->
<div class="space-y-3">
    <div class="px-3 text-xs font-semibold tracking-wider uppercase text-white/60">Principal</div>

    <!-- Dashboard -->
    <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'nav-item-active text-white shadow-lg' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
        <svg class="w-5 h-5 mr-4 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-white/70 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2V7"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5v14l8-7z"/>
        </svg>
        Dashboard
        @if(request()->routeIs('admin.dashboard'))
            <div class="w-2 h-2 ml-auto bg-white rounded-full animate-pulse"></div>
        @endif
    </a>
</div>

<!-- Gestão Section -->
<div class="space-y-3">
    <div class="px-3 text-xs font-semibold tracking-wider uppercase text-white/60">Gestão</div>

    <!-- Colaboradores -->
    <a href="{{ route('admin.employees.index') }}" class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.employees.*') ? 'nav-item-active text-white shadow-lg' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
        <svg class="w-5 h-5 mr-4 {{ request()->routeIs('admin.employees.*') ? 'text-white' : 'text-white/70 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
        </svg>
        Colaboradores
        @if(request()->routeIs('admin.employees.*'))
            <div class="w-2 h-2 ml-auto bg-white rounded-full animate-pulse"></div>
        @endif
    </a>

    <!-- Cartões -->
    <a href="{{ route('admin.cards.index') }}" class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.cards.*') ? 'nav-item-active text-white shadow-lg' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
        <svg class="w-5 h-5 mr-4 {{ request()->routeIs('admin.cards.*') ? 'text-white' : 'text-white/70 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-4 0a2 2 0 014 0z"/>
        </svg>
        Cartões
        @if(request()->routeIs('admin.cards.*'))
            <div class="w-2 h-2 ml-auto bg-white rounded-full animate-pulse"></div>
        @endif
    </a>

    <!-- Templates -->
    <a href="{{ route('admin.card-templates.index') }}" class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.card-templates.*') ? 'nav-item-active text-white shadow-lg' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
        <svg class="w-5 h-5 mr-4 {{ request()->routeIs('admin.card-templates.*') ? 'text-white' : 'text-white/70 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"/>
        </svg>
        Templates
        @if(request()->routeIs('admin.card-templates.*'))
            <div class="w-2 h-2 ml-auto bg-white rounded-full animate-pulse"></div>
        @endif
    </a>
</div>

<!-- Relatórios Section -->
<div class="space-y-3">
    <div class="px-3 text-xs font-semibold tracking-wider uppercase text-white/60">Relatórios</div>

    <!-- Relatórios de Colaboradores -->
    <a href="{{ route('admin.reports.employees') }}" class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.reports.employees') ? 'nav-item-active text-white shadow-lg' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
        <svg class="w-5 h-5 mr-4 {{ request()->routeIs('admin.reports.employees') ? 'text-white' : 'text-white/70 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
        </svg>
        Rel. Colaboradores
        @if(request()->routeIs('admin.reports.employees'))
            <div class="w-2 h-2 ml-auto bg-white rounded-full animate-pulse"></div>
        @endif
    </a>

    <!-- Relatórios de Cartões -->
    <a href="{{ route('admin.reports.cards') }}" class="group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.reports.cards') ? 'nav-item-active text-white shadow-lg' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
        <svg class="w-5 h-5 mr-4 {{ request()->routeIs('admin.reports.cards') ? 'text-white' : 'text-white/70 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        Rel. Cartões
        @if(request()->routeIs('admin.reports.cards'))
            <div class="w-2 h-2 ml-auto bg-white rounded-full animate-pulse"></div>
        @endif
    </a>
</div>

<!-- Spacer -->
<div class="flex-1"></div>

<!-- Ações Rápidas -->
<div class="pb-4 space-y-3">
    <div class="px-3 text-xs font-semibold tracking-wider uppercase text-white/60">Ações Rápidas</div>

    <!-- Novo Colaborador -->
    <a href="{{ route('admin.employees.create') }}" class="flex items-center px-4 py-3 text-sm font-medium transition-all duration-200 border group rounded-xl text-white/80 hover:text-white hover:bg-white/10 border-white/20 hover:border-white/30">
        <svg class="w-5 h-5 mr-4 text-white/70 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        Novo Colaborador
        <svg class="w-4 h-4 ml-auto text-white/40 group-hover:text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </a>

    <!-- Emitir Cartão -->
    <a href="{{ route('admin.cards.create') }}" class="flex items-center px-4 py-3 text-sm font-medium text-white transition-all duration-200 shadow-lg group rounded-xl bg-white/20 backdrop-blur-sm hover:bg-white/30">
        <div class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg bg-white/20">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-4 0a2 2 0 014 0z"/>
            </svg>
        </div>
        Emitir Cartão
        <svg class="w-4 h-4 ml-auto text-white/60 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </a>

    <!-- Novo Template -->
    <a href="{{ route('admin.card-templates.create') }}" class="flex items-center px-4 py-3 text-sm font-medium transition-all duration-200 border group rounded-xl text-white/80 hover:text-white hover:bg-white/10 border-white/20 hover:border-white/30">
        <svg class="w-5 h-5 mr-4 text-white/70 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"/>
        </svg>
        Novo Template
        <svg class="w-4 h-4 ml-auto text-white/40 group-hover:text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </a>
</div>

<!-- Usuário Info -->
<div class="p-4 mt-6 border rounded-xl bg-white/10 backdrop-blur-sm border-white/20">
    <div class="flex items-center space-x-3">
        <img class="w-10 h-10 rounded-full ring-2 ring-white/30"
             src="https://ui-avatars.com/api/?background=ffffff&color=667eea&name={{ urlencode(auth()->user()->name) }}"
             alt="{{ auth()->user()->name }}">
        <div class="flex-1 min-w-0">
            <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
            <p class="text-xs truncate text-white/60">{{ auth()->user()->email }}</p>
        </div>
    </div>
    <div class="flex mt-3 space-x-2">
        <a href="{{ route('profile.edit') }}" class="flex-1 px-3 py-2 text-xs font-medium text-center transition-colors rounded-lg text-white/80 hover:text-white hover:bg-white/10">
            Perfil
        </a>
        <form method="POST" action="{{ route('logout') }}" class="flex-1">
            @csrf
            <button type="submit" class="w-full px-3 py-2 text-xs font-medium transition-colors rounded-lg text-white/80 hover:text-white hover:bg-white/10">
                Sair
            </button>
        </form>
    </div>
</div>
