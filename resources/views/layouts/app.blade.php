<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Wira Garden') }} - Admin</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-charcoal bg-gray-50 overflow-hidden" x-data="{ sidebarOpen: false }">
        <div class="flex h-screen w-full">
            
            <!-- Sidebar -->
            <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-64 bg-primary text-white transition duration-300 transform lg:translate-x-0 lg:static lg:inset-auto flex flex-col shadow-2xl">
                <!-- Sidebar Header -->
                <div class="flex items-center justify-center h-20 border-b border-white/10 shrink-0 px-6">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-secondary rounded-lg flex items-center justify-center text-white font-bold">W</div>
                        <span class="text-xl font-heading font-bold tracking-wider">Admin Panel</span>
                    </a>
                </div>

                <!-- Sidebar Content -->
                <div class="flex-1 overflow-y-auto py-6 px-4">
                    <nav class="space-y-1">
                        <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            Dashboard
                        </x-sidebar-link>
                        
                        <div class="pt-4 pb-2">
                            <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Pengelolaan</p>
                        </div>

                        <x-sidebar-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            Reservasi
                        </x-sidebar-link>

                        <x-sidebar-link :href="route('admin.destinations.index')" :active="request()->routeIs('admin.destinations.*')">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Destinasi
                        </x-sidebar-link>

                        <x-sidebar-link :href="route('admin.galleries.index')" :active="request()->routeIs('admin.galleries.*')">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Galeri
                        </x-sidebar-link>

                        <x-sidebar-link :href="route('admin.tickets.index')" :active="request()->routeIs('admin.tickets.*')">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                            Jenis Tiket
                        </x-sidebar-link>

                        <x-sidebar-link :href="route('admin.quotas.index')" :active="request()->routeIs('admin.quotas.*')">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Kuota Kunjungan
                        </x-sidebar-link>
                        
                        <div class="pt-4 pb-2">
                            <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Aksi Cepat</p>
                        </div>
                        <a href="{{ url('/') }}" target="_blank" class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl text-gray-300 hover:bg-white/10 hover:text-white transition-colors mt-1">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                            Buka Halaman Publik
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Mobile Sidebar Overlay -->
            <div x-show="sidebarOpen" class="fixed inset-0 z-40 bg-gray-900 bg-opacity-50 transition-opacity lg:hidden" @click="sidebarOpen = false" style="display: none;"></div>

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col min-w-0 bg-gray-50 overflow-hidden">
                <!-- Top Header -->
                <header class="bg-white shadow-sm border-b border-gray-200 h-20 shrink-0 flex items-center justify-between px-4 sm:px-6 lg:px-8 z-10">
                    <div class="flex items-center">
                        <button @click="sidebarOpen = true" class="text-gray-500 hover:text-gray-700 focus:outline-none lg:hidden mr-4">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        
                        @isset($header)
                            <h2 class="text-2xl font-bold font-heading text-primary leading-tight">
                                {{ $header }}
                            </h2>
                        @endisset
                    </div>

                    <div class="flex items-center">
                        <!-- User Dropdown -->
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center gap-2 px-3 py-2 border border-gray-100 rounded-full bg-gray-50 hover:bg-gray-100 transition-colors focus:outline-none">
                                    <div class="w-8 h-8 rounded-full bg-secondary text-white flex items-center justify-center font-bold text-sm">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                    <span class="hidden md:block text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                                    <svg class="fill-current h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();" class="text-red-600 hover:bg-red-50 hover:text-red-700">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
