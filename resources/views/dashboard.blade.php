<x-app-layout>
    <x-slot name="header">
        Dashboard Overview
    </x-slot>

    <div class="mb-8">
        <h3 class="text-lg font-bold text-gray-800 font-heading mb-4">Statistik Hari Ini</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Stat Card 1 -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden group">
                <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-primary/5 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </div>
                        <span class="text-sm font-medium text-green-600 bg-green-50 px-2 py-1 rounded-lg">+12%</span>
                    </div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Total Reservasi Baru</p>
                    <h4 class="text-3xl font-bold text-gray-900 font-heading">24</h4>
                </div>
            </div>

            <!-- Stat Card 2 -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden group">
                <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-secondary/5 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="text-sm font-medium text-green-600 bg-green-50 px-2 py-1 rounded-lg">+5%</span>
                    </div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Pendapatan Hari Ini</p>
                    <h4 class="text-3xl font-bold text-gray-900 font-heading">Rp 1.2M</h4>
                </div>
            </div>

            <!-- Stat Card 3 -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden group">
                <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-accent/5 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                    </div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Pengunjung Aktif</p>
                    <h4 class="text-3xl font-bold text-gray-900 font-heading">156</h4>
                </div>
            </div>

            <!-- Stat Card 4 -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden group">
                <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-red-50 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                    </div>
                    <p class="text-gray-500 text-sm font-medium mb-1">Menunggu Pembayaran</p>
                    <h4 class="text-3xl font-bold text-gray-900 font-heading">5</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
            <h3 class="text-lg font-bold text-gray-800 font-heading">Selamat Datang di Admin Panel Wira Garden</h3>
        </div>
        <div class="p-6">
            <p class="text-gray-600">Sistem ini memungkinkan Anda untuk mengelola destinasi, galeri, dan tiket Wira Garden. Gunakan menu navigasi di sebelah kiri untuk mulai mengelola data.</p>
        </div>
    </div>
</x-app-layout>
