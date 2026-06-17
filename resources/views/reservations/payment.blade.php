@extends('layouts.public')

@section('content')
<div class="bg-gray-50 py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden text-center p-8">
            <svg class="w-16 h-16 text-yellow-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <h2 class="text-3xl font-extrabold text-gray-900">Menunggu Pembayaran</h2>
            <p class="mt-2 text-gray-600">Kode Booking: <span class="font-bold text-gray-900">{{ $order->order_code }}</span></p>
            
            <div class="mt-8 border-t border-b border-gray-100 py-6 text-left space-y-4">
                <div class="flex justify-between">
                    <span class="text-gray-500">Nama Pemesan</span>
                    <span class="font-medium text-gray-900">{{ $order->visitor_name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Tanggal Kunjungan</span>
                    <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($order->visit_date)->translatedFormat('d F Y') }}</span>
                </div>
                <div class="flex justify-between font-bold text-lg pt-4 border-t border-gray-100">
                    <span>Total Pembayaran</span>
                    <span class="text-green-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="mt-8">
                <button id="pay-button" class="w-full flex justify-center py-4 px-4 border border-transparent rounded-full shadow-lg text-lg font-bold text-white bg-green-600 hover:bg-green-700 focus:outline-none transition-transform hover:scale-105">
                    Bayar Sekarang
                </button>
            </div>
            
            <p class="mt-6 text-sm text-gray-400">Pembayaran diproses secara aman oleh Midtrans.</p>
        </div>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function(){
        snap.pay('{{ $order->snap_token }}', {
            onSuccess: function(result){
                window.location.href = "{{ route('reservations.success', $order->order_code) }}";
            },
            onPending: function(result){
                alert("Menunggu pembayaran Anda!");
            },
            onError: function(result){
                alert("Pembayaran gagal!");
            },
            onClose: function(){
                console.log('User closed the popup without finishing the payment');
            }
        });
    };
</script>
@endsection
