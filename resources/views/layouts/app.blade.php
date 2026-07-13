<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Wira Garden') }} - Admin</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- FontAwesome & IconPicker -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/fontawesome-iconpicker/3.2.0/css/fontawesome-iconpicker.min.css" rel="stylesheet">

        <!-- Flatpickr (Time/Date Picker) -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

        <style>
            :root {
                --color-primary: {{ setting('color_primary', '#047857') }};
                --color-accent: {{ setting('color_accent', '#ea580c') }};
            }
        </style>
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

                        <x-sidebar-link :href="route('admin.reports.index')" :active="request()->routeIs('admin.reports.*')">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            Laporan
                        </x-sidebar-link>

                        <x-sidebar-link :href="route('admin.destinations.index')" :active="request()->routeIs('admin.destinations.*')">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Destinasi
                        </x-sidebar-link>
                        <x-sidebar-link :href="route('admin.facilities.index')" :active="request()->routeIs('admin.facilities.*')">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            Fasilitas
                        </x-sidebar-link>

                        <x-sidebar-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                            Kategori
                        </x-sidebar-link>

                        <x-sidebar-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            Pengguna
                        </x-sidebar-link>

                        <x-sidebar-link :href="route('admin.settings.index')" :active="request()->routeIs('admin.settings.*')">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Pengaturan
                        </x-sidebar-link>
                    </nav>
                        
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
                <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 relative">
                    {{ $slot }}

                    <!-- Toast Notifications -->
                    @if(session('success') || session('error'))
                        <div x-data="{ show: true }" 
                             x-show="show" 
                             x-init="setTimeout(() => show = false, 4000)"
                             class="fixed bottom-6 right-6 z-50 flex items-center p-4 rounded-xl shadow-2xl transition-all duration-300 {{ session('success') ? 'bg-green-600 text-white' : 'bg-red-600 text-white' }}"
                             x-transition:enter="transition ease-out duration-300 transform"
                             x-transition:enter-start="opacity-0 translate-y-4"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-200 transform"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-4"
                             style="display: none;">
                            
                            @if(session('success'))
                                <svg class="w-6 h-6 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="font-medium mr-4">{{ session('success') }}</span>
                            @endif

                            @if(session('error'))
                                <svg class="w-6 h-6 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="font-medium mr-4">{{ session('error') }}</span>
                            @endif
                            
                            <button @click="show = false" class="text-white/70 hover:text-white transition-colors focus:outline-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    @endif
                </main>
            </div>
        </div>
        
        <!-- Scripts for IconPicker and Flatpickr -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fontawesome-iconpicker/3.2.0/js/fontawesome-iconpicker.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                flatpickr('.time-picker', {
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "H:i",
                    time_24hr: true
                });
            });
        </script>
        @stack('scripts')
    </body>
</html>
