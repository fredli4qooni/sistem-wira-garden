@extends('layouts.public')

@section('content')
<div class="bg-background py-20 relative">
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-secondary/5 blur-3xl"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16">
            <h1 class="text-5xl font-extrabold text-primary font-heading tracking-tight sm:text-6xl mb-4">Eksplorasi Destinasi</h1>
            <p class="text-xl text-gray-500 max-w-2xl mx-auto font-light">Kenali lebih dekat fasilitas dan spot menarik yang menanti Anda di Wira Garden.</p>
            <div class="w-24 h-1.5 bg-accent mx-auto mt-8 rounded-full"></div>
        </div>

        <div class="space-y-24">
            @forelse($destinations as $index => $destination)
            <div class="flex flex-col {{ $index % 2 == 1 ? 'md:flex-row-reverse' : 'md:flex-row' }} gap-12 items-center group">
                <div class="md:w-1/2 w-full relative">
                    <div class="absolute inset-0 bg-primary/10 rounded-[2.5rem] transform rotate-3 scale-105 transition-transform duration-500 group-hover:rotate-6 -z-10"></div>
                    <img src="https://images.unsplash.com/photo-1596436889106-be35e843f974?q=80&w=1000&auto=format&fit=crop" alt="{{ $destination->name }}" class="w-full rounded-[2rem] shadow-xl object-cover h-96 transform transition-transform duration-700 group-hover:scale-[1.02]">
                </div>
                <div class="md:w-1/2 space-y-6">
                    <h2 class="text-4xl font-bold text-primary font-heading">{{ $destination->name }}</h2>
                    <p class="text-gray-600 text-lg leading-relaxed">{{ $destination->description }}</p>
                    
                    <div class="pt-4 space-y-4">
                        <div class="flex items-start bg-white p-4 rounded-2xl shadow-sm border border-gray-100 hover:border-secondary/30 transition-colors">
                            <div class="w-10 h-10 bg-secondary/10 rounded-full flex items-center justify-center shrink-0 mr-4">
                                <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <span class="text-charcoal pt-2">{{ $destination->address }}</span>
                        </div>
                        <div class="flex items-start bg-white p-4 rounded-2xl shadow-sm border border-gray-100 hover:border-secondary/30 transition-colors">
                            <div class="w-10 h-10 bg-secondary/10 rounded-full flex items-center justify-center shrink-0 mr-4">
                                <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <span class="text-charcoal pt-2">{{ $destination->open_hours }}</span>
                        </div>
                    </div>
                    
                    <div class="pt-4">
                        <a href="{{ $destination->maps_url }}" target="_blank" class="inline-flex items-center gap-2 text-secondary font-semibold hover:text-primary transition-colors group/link">
                            <span>Lihat di Google Maps</span>
                            <svg class="w-4 h-4 transform group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center text-gray-500 py-16 bg-white rounded-3xl border border-dashed border-gray-200">
                Belum ada data destinasi.
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
