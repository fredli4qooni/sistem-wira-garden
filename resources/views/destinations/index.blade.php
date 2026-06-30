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

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($destinations as $index => $destination)
            <div class="bg-white rounded-[2rem] shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 p-3 group flex flex-col">
                <!-- Image Area -->
                <div class="h-48 overflow-hidden relative rounded-[1.5rem]">
                    @if($destination->image_path)
                    <img src="{{ Storage::url($destination->image_path) }}" alt="{{ $destination->name }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                    @else
                    <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2-2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    @endif
                    
                    <!-- Category Badge -->
                    @if($destination->category)
                    <div class="absolute top-3 right-3 bg-white/95 backdrop-blur px-3 py-1.5 rounded-full flex items-center gap-1.5 shadow-sm">
                        @if($destination->category->icon_type == 'image' && $destination->category->icon_value)
                            <img src="{{ Storage::url($destination->category->icon_value) }}" alt="Icon" class="w-3.5 h-3.5 rounded-sm object-cover">
                        @elseif($destination->category->icon_type == 'svg' && $destination->category->icon_value)
                            <div class="text-green-600 flex items-center justify-center">
                                @php
                                    $iconVal = html_entity_decode($destination->category->icon_value);
                                @endphp
                                @if(str_contains($iconVal, '<svg'))
                                    <div class="[&>svg]:w-3.5 [&>svg]:h-3.5">
                                        {!! $iconVal !!}
                                    </div>
                                @else
                                    <i class="{{ $destination->category->icon_value }} text-sm"></i>
                                @endif
                            </div>
                        @else
                            <svg class="w-3.5 h-3.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        @endif
                        <span class="text-[11px] font-bold text-green-700">{{ $destination->category->name }}</span>
                    </div>
                    @endif
                </div>
                
                <!-- Content Area -->
                <div class="pt-5 pb-2 px-2 flex flex-col flex-grow">
                    <!-- Title and Desc -->
                    <div class="flex gap-4 mb-4">
                        <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center shrink-0 border border-green-100 overflow-hidden">
                            @if($destination->category && $destination->category->icon_type == 'image' && $destination->category->icon_value)
                                <img src="{{ Storage::url($destination->category->icon_value) }}" alt="Icon" class="w-full h-full object-cover">
                            @elseif($destination->category && $destination->category->icon_type == 'svg' && $destination->category->icon_value)
                                <div class="text-green-600 flex items-center justify-center h-full">
                                    @php
                                        $iconVal2 = html_entity_decode($destination->category->icon_value);
                                    @endphp
                                    @if(str_contains($iconVal2, '<svg'))
                                        <div class="[&>svg]:w-5 [&>svg]:h-5">
                                            {!! $iconVal2 !!}
                                        </div>
                                    @else
                                        <i class="{{ $destination->category->icon_value }} text-xl"></i>
                                    @endif
                                </div>
                            @else
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path></svg>
                            @endif
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-charcoal mb-1 leading-tight group-hover:text-primary transition-colors">{{ $destination->name }}</h2>
                            <p class="text-gray-500 text-[13px] line-clamp-2 leading-relaxed">{{ $destination->description }}</p>
                        </div>
                    </div>
                    
                    <hr class="border-dashed border-gray-200 mb-4 mt-auto">
                    
                    <!-- Prices -->
                    <div class="bg-gray-50/80 rounded-xl border border-gray-100 p-3 mb-4 space-y-2.5">
                        @if($destination->pricing_type === 'per_package')
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2 text-gray-500">
                                    <div class="w-6 h-6 rounded-full bg-orange-50 text-orange-500 flex items-center justify-center">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    </div>
                                    <span class="text-[11px] font-medium uppercase tracking-wider">Harga Paket</span>
                                </div>
                                <span class="text-sm font-bold text-[#0071ba]">Rp {{ number_format($destination->price_adult, 0, ',', '.') }}</span>
                            </div>
                        @else
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2 text-gray-500">
                                    <div class="w-6 h-6 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    </div>
                                    <span class="text-[11px] font-medium uppercase tracking-wider">Dewasa</span>
                                </div>
                                <span class="text-sm font-bold text-[#0071ba]">Rp {{ number_format($destination->price_adult, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2 text-gray-500">
                                    <div class="w-6 h-6 rounded-full bg-green-50 text-green-600 flex items-center justify-center">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    </div>
                                    <span class="text-[11px] font-medium uppercase tracking-wider">Anak-anak</span>
                                </div>
                                <span class="text-sm font-bold text-green-600">Rp {{ number_format($destination->price_child, 0, ',', '.') }}</span>
                            </div>
                        @endif
                    </div>
                    
                    <a href="{{ route('destinations.show', $destination->id) }}" class="w-full flex items-center justify-center gap-2 bg-[#0071ba] text-white py-3 rounded-[1rem] font-bold hover:bg-[#005a96] transition-colors text-sm">
                        Lihat Detail
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center text-gray-500 py-16 bg-white rounded-3xl border border-dashed border-gray-200">
                Belum ada data destinasi.
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
