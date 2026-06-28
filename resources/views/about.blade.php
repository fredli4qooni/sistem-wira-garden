@extends('layouts.public')

@section('content')
<div class="bg-background relative overflow-hidden">
    <!-- Decorative background elements -->
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-secondary/5 blur-3xl"></div>
    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-96 h-96 rounded-full bg-primary/5 blur-3xl"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative z-10">
        <!-- Header Section -->
        <div class="text-center mb-20">
            <h1 class="text-5xl font-extrabold text-primary font-heading tracking-tight sm:text-6xl mb-6">Tentang Wira Garden</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto font-light leading-relaxed">
                Kami hadir untuk memberikan pelarian yang menyegarkan dari hiruk pikuk kehidupan kota, mengembalikan harmoni antara manusia dan alam bebas.
            </p>
            <div class="w-24 h-1.5 bg-accent mx-auto mt-8 rounded-full"></div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center mb-24">
            <!-- Left: Image -->
            <div class="relative group">
                <div class="absolute inset-0 bg-primary/10 rounded-[3rem] transform rotate-3 scale-105 transition-transform duration-500 group-hover:rotate-6 -z-10"></div>
                <img src="{{ asset(setting('hero_image', 'images/gambar-keluarga.png')) }}" alt="Wira Garden" class="w-full rounded-[2.5rem] shadow-2xl object-cover h-[500px]">
                

            </div>

            <!-- Right: Text Content -->
            <div class="space-y-8">
                <div>
                    <h2 class="text-3xl font-bold text-primary font-heading mb-4">Destinasi Wisata Alam Keluarga Terbaik</h2>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        Wira Garden berawal dari sebuah impian sederhana: melestarikan sepotong alam yang asri di tengah laju modernisasi, dan membagikannya kepada keluarga-keluarga yang merindukan udara segar serta gemercik air sungai yang alami.
                    </p>
                </div>
                
                <div>
                    <p class="text-gray-600 text-lg leading-relaxed mb-6">
                        Dengan area seluas berhektar-hektar, kami mengintegrasikan konsep pariwisata yang ramah lingkungan. Setiap fasilitas yang kami bangun—mulai dari titik berkemah (camping ground), jalur trekking, hingga pondok penginapan—dirancang untuk menyatu harmonis dengan kontur alam asli.
                    </p>
                </div>

                <!-- Values Grid -->
                <div class="grid grid-cols-2 gap-6 pt-4 border-t border-gray-100">
                    <div>
                        <div class="w-12 h-12 bg-secondary/10 text-secondary rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">Ramah Keluarga</h4>
                        <p class="text-sm text-gray-500">Lingkungan aman untuk liburan anak & keluarga.</p>
                    </div>
                    <div>
                        <div class="w-12 h-12 bg-accent/10 text-accent rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">Ramah Lingkungan</h4>
                        <p class="text-sm text-gray-500">Menjaga keasrian flora & fauna lokal.</p>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
@endsection
