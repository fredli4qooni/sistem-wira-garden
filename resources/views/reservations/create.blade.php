@extends('layouts.public')

@section('content')
<div class="bg-background py-16 relative">
    <div class="absolute top-0 left-0 w-full h-[30vh] bg-primary -z-10 rounded-b-[4rem]"></div>
    
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10 text-white">
            <h1 class="text-4xl md:text-5xl font-extrabold font-heading mb-4">Pesan Tiket Kunjungan</h1>
            <p class="text-primary-100 text-lg opacity-90">Amankan tiket Anda sekarang untuk liburan yang menyenangkan di Wira Garden.</p>
        </div>

        <div class="glass-card overflow-hidden bg-white/95">
            <form action="{{ route('reservations.store') }}" method="POST" class="px-6 py-10 sm:px-12 space-y-8">
                @csrf

                @if ($errors->any())
                <div class="bg-red-50 p-5 rounded-2xl border border-red-100 flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center shrink-0">
                        <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-red-800">Mohon periksa kembali inputan Anda:</h3>
                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                <div class="space-y-6">
                    <h3 class="text-xl font-bold text-primary font-heading border-b border-gray-100 pb-4">Data Pemesan</h3>
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="visitor_name" class="block text-sm font-semibold text-charcoal mb-2">Nama Lengkap</label>
                            <input type="text" name="visitor_name" id="visitor_name" value="{{ old('visitor_name') }}" required class="block w-full border-gray-200 rounded-xl shadow-sm focus:ring-secondary focus:border-secondary transition-colors py-3 px-4 bg-gray-50 focus:bg-white">
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-charcoal mb-2">Nomor WhatsApp</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required class="block w-full border-gray-200 rounded-xl shadow-sm focus:ring-secondary focus:border-secondary transition-colors py-3 px-4 bg-gray-50 focus:bg-white" placeholder="Contoh: 08123456789">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-semibold text-charcoal mb-2">Alamat Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required class="block w-full border-gray-200 rounded-xl shadow-sm focus:ring-secondary focus:border-secondary transition-colors py-3 px-4 bg-gray-50 focus:bg-white" placeholder="email@contoh.com">
                        </div>
                        <div>
                            <label for="visit_date" class="block text-sm font-semibold text-charcoal mb-2">Tanggal Kunjungan</label>
                            <input type="date" name="visit_date" id="visit_date" value="{{ old('visit_date', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required class="block w-full border-gray-200 rounded-xl shadow-sm focus:ring-secondary focus:border-secondary transition-colors py-3 px-4 bg-gray-50 focus:bg-white">
                        </div>
                    </div>
                </div>

                <div class="space-y-6 pt-6">
                    <h3 class="text-xl font-bold text-primary font-heading border-b border-gray-100 pb-4">Pilih Tiket</h3>
                    <div class="space-y-4">
                        @foreach($ticketTypes as $ticket)
                        <div class="flex items-center justify-between p-5 border-2 border-transparent bg-gray-50 rounded-2xl hover:border-secondary/30 transition-all group">
                            <div>
                                <h4 class="text-lg font-bold text-primary font-heading">{{ $ticket->name }}</h4>
                                <p class="text-sm text-gray-500 mt-1">{{ $ticket->description }}</p>
                                <p class="text-lg font-extrabold text-secondary mt-2">Rp {{ number_format($ticket->price, 0, ',', '.') }}</p>
                            </div>
                            <div class="w-32">
                                <label for="ticket_{{ $ticket->id }}" class="sr-only">Jumlah Tiket</label>
                                <div class="flex items-center border border-gray-200 rounded-xl bg-white overflow-hidden shadow-sm focus-within:ring-2 focus-within:ring-secondary focus-within:border-secondary">
                                    <input type="number" name="tickets[{{ $ticket->id }}]" id="ticket_{{ $ticket->id }}" value="{{ old('tickets.'.$ticket->id, 0) }}" min="0" class="block w-full border-none focus:ring-0 text-center text-lg font-bold text-primary py-3" placeholder="0">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="pt-8 text-center">
                    <button type="submit" class="btn-primary w-full sm:w-auto min-w-[250px] text-lg py-4">
                        Lanjut ke Pembayaran
                    </button>
                    <p class="text-xs text-gray-400 mt-4 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8V7a4 4 0 00-8 0v4h8z"></path></svg>
                        Pembayaran aman & terenkripsi melalui Midtrans
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
