@extends('layouts.public')

@section('content')
<div class="bg-gray-50 py-12 min-h-[70vh] flex items-center">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-green-600 px-6 py-8 text-center">
                <svg class="w-20 h-20 text-white mx-auto mb-4 bg-green-500 rounded-full p-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <h2 class="text-3xl font-extrabold text-white">Pembayaran Berhasil!</h2>
                <p class="mt-2 text-green-100">Terima kasih telah melakukan reservasi di Wira Garden.</p>
            </div>
            
            <div class="p-8">
                <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center relative overflow-hidden">
                    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-8 h-8 bg-white rounded-full"></div>
                    <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1/2 w-8 h-8 bg-white rounded-full"></div>
                    
                    <p class="text-sm text-gray-500 uppercase tracking-widest font-semibold mb-2">E-TICKET</p>
                    <h3 class="text-3xl font-black text-gray-900 tracking-wider mb-6">{{ $order->order_code }}</h3>
                    
                    <div class="grid grid-cols-2 gap-4 text-left">
                        <div>
                            <p class="text-xs text-gray-500 uppercase">Nama Pengunjung</p>
                            <p class="font-medium text-gray-900">{{ $order->visitor_name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase">Tanggal Kunjungan</p>
                            <p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($order->visit_date)->translatedFormat('d F Y') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-8 text-center space-y-4">
                    <p class="text-gray-600 text-sm">Harap simpan atau screenshot halaman ini dan tunjukkan kepada petugas di loket masuk.</p>
                    <a href="{{ url('/') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
