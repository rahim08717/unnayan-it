<!-- Mobile Top Navigation Header -->
<div class="lg:hidden bg-slate-900/95 backdrop-blur-md text-white flex items-center justify-between px-5 py-4 shadow-lg border-b border-slate-800 sticky top-0 z-40">
    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
        <div class="p-2 bg-gradient-to-tr from-indigo-600 to-violet-500 rounded-xl text-white font-black text-base shadow-md shadow-indigo-500/20 group-hover:scale-105 transition-transform">
            UP
        </div>
        <span class="font-bold text-lg text-white tracking-wide">
            Unnayan Prochesta
        </span>
    </a>
    <button @click="sidebarOpen = !sidebarOpen" class="p-2.5 rounded-xl text-slate-300 hover:text-white hover:bg-slate-800/80 focus:outline-none transition-all duration-200 active:scale-95">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path :class="{'hidden': sidebarOpen, 'inline-flex': !sidebarOpen }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            <path :class="{'hidden': !sidebarOpen, 'inline-flex': sidebarOpen }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
</div>

<!-- Backdrop Overlay for Mobile -->
<div x-show="sidebarOpen" 
     @click="sidebarOpen = false" 
     x-cloak
     x-transition:enter="transition-opacity ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-40 bg-slate-950/70 backdrop-blur-sm lg:hidden"></div>

<!-- Left Sidebar Navigation Container -->
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
       class="fixed top-0 left-0 z-50 h-screen w-72 bg-slate-900 text-slate-200 flex flex-col transition-transform duration-300 ease-in-out border-r border-slate-800/80 shadow-2xl select-none">
    
    <!-- Logo & Title Header -->
    <div class="h-20 flex items-center px-6 bg-slate-950/60 border-b border-slate-800/80 shrink-0">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3.5 group">
            <div class="p-2.5 bg-gradient-to-tr from-indigo-600 to-indigo-500 rounded-2xl text-white font-black text-xl leading-none group-hover:scale-105 group-hover:rotate-3 transition-all duration-300 shadow-lg shadow-indigo-500/30">
                UP
            </div>
            <div class="flex flex-col">
                <span class="font-extrabold text-base text-white tracking-wide leading-tight group-hover:text-indigo-300 transition-colors">Unnayan Prochesta</span>
                <span class="text-xs text-indigo-400 font-bold tracking-widest uppercase">IT Management Portal</span>
            </div>
        </a>
    </div>

    <!-- Vertical Sidebar Links -->
    <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-2 custom-scrollbar">
        
        <!-- Section: Main Menu -->
        <p class="px-3 text-xs font-extrabold uppercase tracking-widest text-slate-400 mb-3">Main Navigation</p>

        <!-- Dashboard Link -->
        <a href="{{ route('dashboard') }}" 
           class="group relative flex items-center gap-3.5 px-4 py-3 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-indigo-600 to-indigo-500 text-white shadow-lg shadow-indigo-600/30' : 'hover:bg-slate-800/90 hover:text-white hover:translate-x-1.5 text-slate-300' }}">
            <svg class="w-5 h-5 shrink-0 transition-transform duration-300 group-hover:scale-110 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-slate-400 group-hover:text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span class="truncate">{{ __('Dashboard') }}</span>
        </a>

        <!-- Daily Working Report Link (With Live Pulse Animation) -->
        <a href="{{ route('daily-reports.dashboard') }}" 
           class="group relative flex items-center gap-3.5 px-4 py-3 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('daily-reports.*') ? 'bg-gradient-to-r from-indigo-600 to-indigo-500 text-white shadow-lg shadow-indigo-600/30' : 'hover:bg-slate-800/90 hover:text-white hover:translate-x-1.5 text-slate-300' }}">
            <svg class="w-5 h-5 shrink-0 transition-transform duration-300 group-hover:scale-110 {{ request()->routeIs('daily-reports.*') ? 'text-white' : 'text-emerald-400 group-hover:text-emerald-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span class="flex-1 truncate">{{ __('Daily Working Report') }}</span>
            <span class="relative flex h-2.5 w-2.5">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
              <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
            </span>
        </a>

        <!-- IT Assets Link -->
        <a href="{{ route('assets.index') }}" 
           class="group relative flex items-center gap-3.5 px-4 py-3 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('assets.*') ? 'bg-gradient-to-r from-indigo-600 to-indigo-500 text-white shadow-lg shadow-indigo-600/30' : 'hover:bg-slate-800/90 hover:text-white hover:translate-x-1.5 text-slate-300' }}">
            <svg class="w-5 h-5 shrink-0 transition-transform duration-300 group-hover:scale-110 {{ request()->routeIs('assets.*') ? 'text-white' : 'text-slate-400 group-hover:text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            <span class="truncate">{{ __('IT Assets') }}</span>
        </a>

        <!-- Support Tickets Link -->
        <a href="{{ route('tickets.index') }}" 
           class="group relative flex items-center gap-3.5 px-4 py-3 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('tickets.*') ? 'bg-gradient-to-r from-indigo-600 to-indigo-500 text-white shadow-lg shadow-indigo-600/30' : 'hover:bg-slate-800/90 hover:text-white hover:translate-x-1.5 text-slate-300' }}">
            <svg class="w-5 h-5 shrink-0 transition-transform duration-300 group-hover:scale-110 {{ request()->routeIs('tickets.*') ? 'text-white' : 'text-amber-400 group-hover:text-amber-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 002 2 2 2 0 010 4 2 2 0 00-2 2v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 00-2-2 2 2 0 010-4 2 2 0 002-2V7a2 2 0 00-2-2H5z"/>
            </svg>
            <span class="truncate">{{ __('Support Tickets') }}</span>
        </a>

        <!-- Section: Administration -->
        <p class="px-3 text-xs font-extrabold uppercase tracking-widest text-slate-400 pt-6 mb-3">Management</p>

        <!-- Branches Link -->
        <a href="{{ route('branches.index') }}" 
           class="group relative flex items-center gap-3.5 px-4 py-3 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('branches.*') ? 'bg-gradient-to-r from-indigo-600 to-indigo-500 text-white shadow-lg shadow-indigo-600/30' : 'hover:bg-slate-800/90 hover:text-white hover:translate-x-1.5 text-slate-300' }}">
            <svg class="w-5 h-5 shrink-0 transition-transform duration-300 group-hover:scale-110 {{ request()->routeIs('branches.*') ? 'text-white' : 'text-slate-400 group-hover:text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m3 0h1m-1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="truncate">{{ __('Branches') }}</span>
        </a>

        <!-- Employees Link -->
        <a href="{{ route('employees.index') }}" 
           class="group relative flex items-center gap-3.5 px-4 py-3 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('employees.*') ? 'bg-gradient-to-r from-indigo-600 to-indigo-500 text-white shadow-lg shadow-indigo-600/30' : 'hover:bg-slate-800/90 hover:text-white hover:translate-x-1.5 text-slate-300' }}">
            <svg class="w-5 h-5 shrink-0 transition-transform duration-300 group-hover:scale-110 {{ request()->routeIs('employees.*') ? 'text-white' : 'text-slate-400 group-hover:text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            <span class="truncate">{{ __('Employees') }}</span>
        </a>

        <!-- Categories Link -->
        <a href="{{ route('categories.index') }}" 
           class="group relative flex items-center gap-3.5 px-4 py-3 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('categories.*') ? 'bg-gradient-to-r from-indigo-600 to-indigo-500 text-white shadow-lg shadow-indigo-600/30' : 'hover:bg-slate-800/90 hover:text-white hover:translate-x-1.5 text-slate-300' }}">
            <svg class="w-5 h-5 shrink-0 transition-transform duration-300 group-hover:scale-110 {{ request()->routeIs('categories.*') ? 'text-white' : 'text-slate-400 group-hover:text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 11h.01M7 15h.01M13 7h.01M13 11h.01M13 15h.01M19 7h.01M19 11h.01M19 15h.01"/>
            </svg>
            <span class="truncate">{{ __('Categories') }}</span>
        </a>

        <!-- Vendors Link -->
        <a href="{{ route('vendors.index') }}" 
           class="group relative flex items-center gap-3.5 px-4 py-3 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('vendors.*') ? 'bg-gradient-to-r from-indigo-600 to-indigo-500 text-white shadow-lg shadow-indigo-600/30' : 'hover:bg-slate-800/90 hover:text-white hover:translate-x-1.5 text-slate-300' }}">
            <svg class="w-5 h-5 shrink-0 transition-transform duration-300 group-hover:scale-110 {{ request()->routeIs('vendors.*') ? 'text-white' : 'text-slate-400 group-hover:text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
            <span class="truncate">{{ __('Vendors') }}</span>
        </a>

        <!-- Reports Link -->
        <a href="{{ route('reports.index') }}" 
           class="group relative flex items-center gap-3.5 px-4 py-3 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('reports.*') ? 'bg-gradient-to-r from-indigo-600 to-indigo-500 text-white shadow-lg shadow-indigo-600/30' : 'hover:bg-slate-800/90 hover:text-white hover:translate-x-1.5 text-slate-300' }}">
            <svg class="w-5 h-5 shrink-0 transition-transform duration-300 group-hover:scale-110 {{ request()->routeIs('reports.*') ? 'text-white' : 'text-sky-400 group-hover:text-sky-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            <span class="truncate">{{ __('Reports') }}</span>
        </a>

        <!-- Users Link -->
        <a href="{{ route('users.index') }}" 
           class="group relative flex items-center gap-3.5 px-4 py-3 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('users.*') ? 'bg-gradient-to-r from-indigo-600 to-indigo-500 text-white shadow-lg shadow-indigo-600/30' : 'hover:bg-slate-800/90 hover:text-white hover:translate-x-1.5 text-slate-300' }}">
            <svg class="w-5 h-5 shrink-0 transition-transform duration-300 group-hover:scale-110 {{ request()->routeIs('users.*') ? 'text-white' : 'text-slate-400 group-hover:text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            <span class="truncate">{{ __('Users Access') }}</span>
        </a>

    </nav>

    <!-- Bottom User Profile Card -->
    <div class="p-4 border-t border-slate-800 bg-slate-950/70 shrink-0">
        <x-dropdown align="top" width="56">
            <x-slot name="trigger">
                <button class="w-full flex items-center gap-3.5 p-2.5 rounded-2xl hover:bg-slate-800/80 transition-all duration-200 text-left focus:outline-none group border border-transparent hover:border-slate-700/60">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 to-violet-500 flex items-center justify-center font-bold text-white text-sm shadow-md shadow-indigo-600/30 group-hover:scale-105 transition-transform">
                        {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0 overflow-hidden">
                        <p class="text-sm font-bold text-white truncate leading-tight group-hover:text-indigo-300 transition-colors">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-slate-400 truncate leading-tight mt-0.5">{{ Auth::user()->email }}</p>
                    </div>
                    <svg class="w-5 h-5 text-slate-400 group-hover:text-white transition-transform group-hover:-translate-y-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                    </svg>
                </button>
            </x-slot>

            <x-slot name="content">
                <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2.5 py-2.5 text-sm">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span>{{ __('My Profile') }}</span>
                </x-dropdown-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="flex items-center gap-2.5 py-2.5 text-sm text-rose-600 hover:text-rose-700 font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        <span>{{ __('Log Out') }}</span>
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>

</aside>