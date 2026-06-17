<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Wira Garden') }} - Admin Login</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-charcoal antialiased">
        <div class="min-h-screen flex">
            <!-- Left Side: Image -->
            <div class="hidden lg:flex lg:w-1/2 relative bg-gray-900 items-center justify-center overflow-hidden">
                <img src="{{ asset('images/gambar-wira-garden.png') }}" class="absolute inset-0 w-full h-full object-cover opacity-80" alt="Wira Garden">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/90 via-gray-900/40 to-transparent"></div>
                <div class="absolute inset-0 bg-gradient-to-b from-primary/30 to-transparent"></div>
                <div class="relative z-10 p-10 bg-black/40 backdrop-blur-md rounded-3xl text-center text-white border border-white/20 transform -rotate-2 shadow-2xl hover:rotate-0 transition-transform duration-500 max-w-sm">
                    <h1 class="text-7xl font-bold mb-2 text-accent drop-shadow-lg tracking-wider" style="font-family: 'Caveat', cursive;">Wira Garden</h1>
                    <p class="text-lg text-white font-medium drop-shadow tracking-wide">Sistem Manajemen Operasional</p>
                </div>
            </div>

            <!-- Right Side: Form -->
            <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-background relative">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-primary to-secondary"></div>
                
                <div class="w-full max-w-md bg-white rounded-3xl shadow-xl border border-gray-100 p-8 sm:p-12 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-secondary/5 rounded-bl-[100px] -z-10"></div>
                    
                    <div class="text-center mb-10 lg:hidden">
                        <h1 class="text-3xl font-heading font-bold text-primary">Wira Garden</h1>
                        <p class="text-gray-500 mt-2">Admin Panel</p>
                    </div>

                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
