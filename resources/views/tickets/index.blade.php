@extends('layouts.public')

@section('content')
<div class="bg-gray-50 py-16 sm:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h1 class="text-4xl sm:text-5xl font-bold text-charcoal mb-4">Harga <span class="text-primary font-heading">Tiket</span></h1>
            <p class="text-lg text-gray-500">Daftar harga tiket masuk dan reservasi untuk setiap destinasi serta wahana di Wira Garden.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Destinasi / Wahana</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tiket Dewasa</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tiket Anak-anak</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($destinations as $destination)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-4">
                                    @if($destination->image_path)
                                    <img src="{{ Storage::url($destination->image_path) }}" alt="{{ $destination->name }}" class="w-12 h-12 rounded-lg object-cover">
                                    @else
                                    <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2-2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    @endif
                                    <div class="font-bold text-gray-900">{{ $destination->name }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $destination->category ? $destination->category->name : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-bold text-primary">Rp {{ number_format($destination->price_adult, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-bold text-primary">Rp {{ number_format($destination->price_child, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('reservations.create', ['destination_id' => $destination->id]) }}" class="inline-flex items-center gap-2 bg-primary hover:bg-secondary text-white px-4 py-2 rounded-lg transition-colors font-semibold text-sm shadow-sm">
                                    Reservasi
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                Belum ada data harga tiket destinasi.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
