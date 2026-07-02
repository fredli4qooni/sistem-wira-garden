@extends('layouts.public')

@section('content')
<div class="bg-gray-50 py-16 min-h-screen">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-10 text-center md:text-left">
            <h1 class="text-4xl font-extrabold font-heading text-primary mb-2">Reservasi</h1>
            <p class="text-gray-500">Lengkapi data reservasi Anda</p>
        </div>

        <form action="{{ route('reservations.store') }}" method="POST" id="reservationForm" x-data="reservationForm()">
            @csrf
            <!-- Remove old hidden inputs, managed by Alpine -->

            @if ($errors->any())
            <div class="bg-red-50 p-5 rounded-2xl border border-red-100 flex items-start gap-4 mb-8">
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

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                <!-- Left Column -->
                <div class="lg:col-span-4 space-y-6">
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 font-heading mb-4">Pilih Layanan / Destinasi</h3>
                        
                        <div class="mb-5">
                            <select name="destination_id" x-model="selectedId" @change="updateDestination" class="block w-full border-gray-200 rounded-xl shadow-sm focus:ring-secondary focus:border-secondary transition-colors py-3 px-4 bg-gray-50 focus:bg-white text-gray-900 font-medium cursor-pointer">
                                @foreach($destinations as $dest)
                                    <option value="{{ $dest->id }}">{{ $dest->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex flex-col gap-4 pt-5 border-t border-gray-100" x-show="currentDestination">
                            <div class="w-full h-40 rounded-xl overflow-hidden bg-gray-100">
                                <img :src="currentDestination.image_url" :alt="currentDestination.name" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-lg mb-2" x-text="currentDestination.name"></h4>
                                <div class="flex flex-col gap-2 text-sm bg-green-50/50 p-4 rounded-xl border border-green-100">
                                    <template x-if="currentDestination.pricing_type === 'per_package'">
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-600 font-medium">Harga Paket / Tenda</span> 
                                            <span class="text-primary font-bold text-base" x-text="'Rp ' + formatRupiah(currentDestination.price_adult)"></span>
                                        </div>
                                    </template>
                                    <template x-if="currentDestination.pricing_type === 'per_person'">
                                        <div class="flex flex-col gap-2 w-full">
                                            <div class="flex justify-between items-center w-full">
                                                <span class="text-gray-600 font-medium">Tiket Dewasa</span> 
                                                <span class="text-primary font-bold text-base" x-text="'Rp ' + formatRupiah(currentDestination.price_adult)"></span>
                                            </div>
                                            <div class="flex justify-between items-center w-full">
                                                <span class="text-gray-600 font-medium">Tiket Anak</span> 
                                                <span class="text-primary font-bold text-base" x-text="'Rp ' + formatRupiah(currentDestination.price_child)"></span>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="lg:col-span-8 space-y-8">
                    
                    <!-- Kunjungan & Tiket -->
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            
                            <!-- Tanggal -->
                            <div>
                                <label for="visit_date" class="block text-sm font-semibold text-charcoal mb-2">Tanggal Kunjungan</label>
                                <input type="date" name="visit_date" id="visit_date" x-model="visitDate" @change="checkStock" min="{{ date('Y-m-d') }}" required class="block w-full border-gray-200 rounded-xl shadow-sm focus:ring-secondary focus:border-secondary transition-colors py-3 px-4 bg-gray-50 focus:bg-white">
                            </div>

                            <!-- Jumlah Tiket -->
                            <div x-show="currentDestination">
                                <div class="flex items-center justify-between mb-4">
                                    <label class="block text-sm font-semibold text-charcoal" x-text="currentDestination.pricing_type === 'per_package' ? 'Jumlah Paket / Tenda' : 'Jumlah Tiket'">Jumlah Tiket</label>
                                    <template x-if="availableStock !== null && availableStock !== undefined">
                                        <span class="text-xs font-bold px-2.5 py-1 rounded-full" 
                                            :class="availableStock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                                            x-text="availableStock > 0 ? 'Sisa: ' + availableStock + ' unit' : 'Habis Terpesan'"></span>
                                    </template>
                                </div>
                                
                                <div class="space-y-4">
                                    <template x-if="currentDestination.pricing_type === 'per_package'">
                                        <div class="flex items-center justify-between">
                                            <span class="text-gray-700">Jumlah</span>
                                            <div class="flex items-center border border-gray-200 rounded-lg">
                                                <button type="button" class="px-3 py-1 text-gray-500 hover:bg-gray-100 rounded-l-lg" @click="if(ticketsAdult > 0) ticketsAdult--">-</button>
                                                <input type="number" name="tickets_adult" id="tickets_adult_pkg" x-model.number="ticketsAdult" min="0" :max="availableStock !== null ? availableStock : ''" class="w-12 text-center border-none focus:ring-0 p-0 text-gray-700 py-1" readonly>
                                                <button type="button" class="px-3 py-1 text-gray-500 hover:bg-gray-100 rounded-r-lg" @click="if(availableStock === null || ticketsAdult < availableStock) ticketsAdult++">+</button>
                                            </div>
                                            <input type="hidden" name="tickets_child" value="0">
                                        </div>
                                    </template>
                                    
                                    <template x-if="currentDestination.pricing_type === 'per_person'">
                                        <div class="space-y-4 w-full">
                                            <div class="flex items-center justify-between w-full">
                                                <span class="text-gray-700">Dewasa</span>
                                                <div class="flex items-center border border-gray-200 rounded-lg">
                                                    <button type="button" class="px-3 py-1 text-gray-500 hover:bg-gray-100 rounded-l-lg" @click="if(ticketsAdult > 0) ticketsAdult--">-</button>
                                                    <input type="number" name="tickets_adult" id="tickets_adult" x-model.number="ticketsAdult" min="0" class="w-12 text-center border-none focus:ring-0 p-0 text-gray-700 py-1" readonly>
                                                    <button type="button" class="px-3 py-1 text-gray-500 hover:bg-gray-100 rounded-r-lg" @click="ticketsAdult++">+</button>
                                                </div>
                                            </div>
                                            
                                            <div class="flex items-center justify-between w-full">
                                                <span class="text-gray-700">Anak-anak</span>
                                                <div class="flex items-center border border-gray-200 rounded-lg">
                                                    <button type="button" class="px-3 py-1 text-gray-500 hover:bg-gray-100 rounded-l-lg" @click="if(ticketsChild > 0) ticketsChild--">-</button>
                                                    <input type="number" name="tickets_child" id="tickets_child" x-model.number="ticketsChild" min="0" class="w-12 text-center border-none focus:ring-0 p-0 text-gray-700 py-1" readonly>
                                                    <button type="button" class="px-3 py-1 text-gray-500 hover:bg-gray-100 rounded-r-lg" @click="ticketsChild++">+</button>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-100 flex items-center justify-between">
                            <span class="font-bold text-gray-900">Total Harga</span>
                            <span class="text-2xl font-bold text-primary" x-text="'Rp ' + formatRupiah(totalPrice)">Rp 0</span>
                        </div>
                    </div>

                    <!-- Data Pemesan -->
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                        <h3 class="text-xl font-bold text-gray-900 font-heading mb-6 border-b border-gray-100 pb-4">Data Pemesan</h3>
                        
                        <div class="space-y-6">
                            <div>
                                <label for="visitor_name" class="block text-sm font-semibold text-charcoal mb-2">Nama Lengkap</label>
                                <input type="text" name="visitor_name" id="visitor_name" value="{{ old('visitor_name', auth()->user()->name ?? '') }}" required class="block w-full border-gray-200 rounded-xl shadow-sm focus:ring-secondary focus:border-secondary transition-colors py-3 px-4 bg-gray-50 focus:bg-white" placeholder="Masukkan nama lengkap">
                            </div>
                            
                            <div>
                                <label for="phone" class="block text-sm font-semibold text-charcoal mb-2">No. HP</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required class="block w-full border-gray-200 rounded-xl shadow-sm focus:ring-secondary focus:border-secondary transition-colors py-3 px-4 bg-gray-50 focus:bg-white" placeholder="Masukkan nomor HP">
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-semibold text-charcoal mb-2">Email (opsional)</label>
                                <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email ?? '') }}" class="block w-full border-gray-200 rounded-xl shadow-sm focus:ring-secondary focus:border-secondary transition-colors py-3 px-4 bg-gray-50 focus:bg-white" placeholder="Masukkan email">
                            </div>
                        </div>

                        <div class="mt-8">
                            <button type="submit" :disabled="availableStock !== null && availableStock === 0" class="w-full bg-primary text-white font-bold py-4 rounded-xl shadow-sm hover:bg-green-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                                Lanjut ke Pembayaran
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('reservationForm', () => ({
            destinations: @json($destinations),
            selectedId: '{{ $selectedDestination->id ?? ($destinations->first()->id ?? "") }}',
            currentDestination: null,
            visitDate: '{{ old('visit_date', date('Y-m-d')) }}',
            ticketsAdult: {{ old('tickets_adult', 1) }},
            ticketsChild: {{ old('tickets_child', 0) }},
            availableStock: null,
            
            init() {
                this.updateDestination();
                
                // Watch for changes in quantities to calculate total
                this.$watch('ticketsAdult', () => this.calculateTotal());
                this.$watch('ticketsChild', () => this.calculateTotal());
            },
            
            updateDestination() {
                if(!this.selectedId) return;
                
                // Find destination details
                const dest = this.destinations.find(d => d.id == this.selectedId);
                if(dest) {
                    this.currentDestination = dest;
                    this.checkStock();
                }
            },
            
            async checkStock() {
                if(!this.selectedId || !this.visitDate || !this.currentDestination) return;
                
                try {
                    const response = await fetch(`/api/check-stock?destination_id=${this.selectedId}&visit_date=${this.visitDate}`);
                    const data = await response.json();
                    
                    this.availableStock = data.available_stock;
                    
                    // Reset quantity if it exceeds stock
                    if (this.availableStock !== null && this.currentDestination.pricing_type === 'per_package') {
                        if (this.ticketsAdult > this.availableStock) {
                            this.ticketsAdult = this.availableStock;
                        }
                    }
                } catch (error) {
                    console.error('Error checking stock:', error);
                }
            },
            
            get totalPrice() {
                if(!this.currentDestination) return 0;
                
                if (this.currentDestination.pricing_type === 'per_package') {
                    return this.ticketsAdult * this.currentDestination.price_adult;
                }
                
                return (this.ticketsAdult * this.currentDestination.price_adult) + 
                       (this.ticketsChild * this.currentDestination.price_child);
            },
            
            formatRupiah(number) {
                return new Intl.NumberFormat('id-ID').format(number);
            }
        }))
    })
</script>
@endsection
