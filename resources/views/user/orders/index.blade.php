@extends('layouts.public')

@section('content')
<div class="bg-gray-50 py-12 min-h-[70vh]">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-extrabold text-gray-900 mb-8">Riwayat Reservasi</h2>
        
        <div class="bg-white shadow rounded-lg overflow-hidden">
            @if($orders->isEmpty())
                <div class="p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <p class="text-gray-500 mb-4">Anda belum pernah membuat reservasi.</p>
                    <a href="{{ route('destinations.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-full shadow-sm text-white bg-primary hover:bg-green-700">Mulai Reservasi</a>
                </div>
            @else
                <ul class="divide-y divide-gray-200">
                    @foreach($orders as $order)
                        <li class="p-6 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Order: {{ $order->order_code }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">Kunjungan: {{ \Carbon\Carbon::parse($order->visit_date)->translatedFormat('d F Y') }}</p>
                                    <p class="text-sm text-gray-500 mt-1">Destinasi: {{ $order->items->pluck('destination.name')->filter()->unique()->join(', ') }}</p>
                                    <p class="text-sm font-medium text-gray-900 mt-1">Total: Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $order->status === 'PAID' ? 'bg-green-100 text-green-800' : 
                                           ($order->status === 'PENDING' ? 'bg-yellow-100 text-yellow-800' : 
                                           ($order->status === 'CANCELLED' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                                        {{ $order->status }}
                                    </span>
                                    <div class="mt-4">
                                        @if($order->status === 'PENDING')
                                            <a href="{{ route('reservations.payment', $order->order_code) }}" class="text-sm text-secondary hover:text-orange-600 font-medium bg-orange-50 px-3 py-1 rounded-md">Bayar Sekarang</a>
                                        @else
                                            <a href="{{ route('reservations.success', $order->order_code) }}" class="text-sm text-primary hover:text-green-800 font-medium bg-green-50 px-3 py-1 rounded-md">Lihat E-Ticket</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection
