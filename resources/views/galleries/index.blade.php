@extends('layouts.public')

@section('content')
<div class="bg-background py-20 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h1 class="text-5xl font-extrabold text-primary font-heading tracking-tight sm:text-6xl mb-4">Galeri Wira Garden</h1>
            <p class="text-xl text-gray-500 max-w-2xl mx-auto font-light">Potret keindahan alam dan momen tak terlupakan pengunjung kami.</p>
            <div class="w-24 h-1.5 bg-accent mx-auto mt-8 rounded-full"></div>
        </div>

        <div class="columns-1 sm:columns-2 md:columns-3 gap-6 space-y-6">
            @forelse($galleries as $gallery)
            <div class="break-inside-avoid relative group overflow-hidden rounded-[2rem] shadow-sm hover:shadow-2xl transition-all duration-500">
                <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="{{ $gallery->title }}" class="w-full h-auto object-cover transform group-hover:scale-110 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-primary/90 via-primary/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-8">
                    @if($gallery->category)
                    <span class="inline-block px-3 py-1 bg-accent/90 text-white text-xs font-bold rounded-full mb-2 w-max tracking-wide uppercase">{{ $gallery->category }}</span>
                    @endif
                    <h3 class="text-white font-bold text-xl font-heading tracking-wide">{{ $gallery->title }}</h3>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center text-gray-500 py-16 bg-white rounded-3xl border border-dashed border-gray-200">
                Belum ada foto di galeri.
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
