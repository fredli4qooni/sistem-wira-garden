@extends('layouts.public')

@section('content')
<div class="bg-gray-50 py-16 min-h-screen">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-10 text-center md:text-left">
            <h1 class="text-4xl font-extrabold font-heading text-primary mb-2">Reservasi</h1>
            <p class="text-gray-500">Lengkapi data dan keranjang reservasi Anda</p>
        </div>

        <form action="{{ route('reservations.store') }}" method="POST" id="reservationForm" x-data="reservationForm()">
            @csrf
            
            <input type="hidden" name="cart_items" :value="JSON.stringify(cartItems)">

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
                <div class="lg:col-span-7 space-y-8">
                    <!-- Tanggal Kunjungan -->
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                        <label for="visit_date" class="block text-lg font-bold text-gray-900 font-heading mb-4">Pilih Tanggal Kunjungan</label>
                        <p class="text-sm text-gray-500 mb-4">Satu pesanan berlaku untuk satu tanggal kunjungan. Pastikan memilih tanggal dengan benar.</p>
                        <input type="date" name="visit_date" id="visit_date" x-model="visitDate" @change="checkStock" min="{{ date('Y-m-d') }}" required class="block w-full border-gray-200 rounded-xl shadow-sm focus:ring-secondary focus:border-secondary transition-colors py-3 px-4 bg-gray-50 focus:bg-white font-medium">
                    </div>

                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                        <h3 class="text-xl font-bold text-gray-900 font-heading mb-6">Tambah Destinasi/Layanan</h3>
                        
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-charcoal mb-2">Pilih Destinasi</label>
                            <select x-model="selectedId" @change="updateDestination" class="block w-full border-gray-200 rounded-xl shadow-sm focus:ring-secondary focus:border-secondary transition-colors py-3 px-4 bg-gray-50 focus:bg-white text-gray-900 font-medium cursor-pointer">
                                @foreach($destinations as $dest)
                                    <option value="{{ $dest->id }}">{{ $dest->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex flex-col gap-6" x-show="currentDestination">
                            <!-- Image and Info -->
                            <div class="flex flex-col md:flex-row gap-6 items-start">
                                <div class="w-full md:w-1/3 h-32 rounded-xl overflow-hidden bg-gray-100 shrink-0">
                                    <img :src="currentDestination.image_url" :alt="currentDestination.name" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 w-full">
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
                            
                            <!-- Quantity Selector -->
                            <div class="pt-6 border-t border-gray-100">
                                <div class="flex items-center justify-between mb-4">
                                    <label class="block text-sm font-semibold text-charcoal" x-text="currentDestination.pricing_type === 'per_package' ? 'Tentukan Jumlah Paket' : 'Tentukan Jumlah Tiket'"></label>
                                    <template x-if="availableStock !== null && availableStock !== undefined">
                                        <span class="text-xs font-bold px-2.5 py-1 rounded-full" 
                                            :class="availableStock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                                            x-text="availableStock > 0 ? 'Sisa Stok: ' + availableStock + ' unit' : 'Habis Terpesan'"></span>
                                    </template>
                                </div>
                                
                                <div class="space-y-4">
                                    <template x-if="currentDestination.pricing_type === 'per_package'">
                                        <div class="flex items-center justify-between">
                                            <span class="text-gray-700 font-medium">Jumlah</span>
                                            <div class="flex items-center border border-gray-200 rounded-lg">
                                                <button type="button" class="px-3 py-2 text-gray-500 hover:bg-gray-100 rounded-l-lg" @click="if(ticketsAdult > 0) ticketsAdult--">-</button>
                                                <input type="number" x-model.number="ticketsAdult" min="0" class="w-16 text-center border-none focus:ring-0 p-0 text-gray-700 py-2 font-bold" readonly>
                                                <button type="button" class="px-3 py-2 text-gray-500 hover:bg-gray-100 rounded-r-lg" @click="ticketsAdult++">+</button>
                                            </div>
                                        </div>
                                    </template>
                                    
                                    <template x-if="currentDestination.pricing_type === 'per_person'">
                                        <div class="space-y-4 w-full">
                                            <div class="flex items-center justify-between w-full">
                                                <span class="text-gray-700 font-medium">Dewasa</span>
                                                <div class="flex items-center border border-gray-200 rounded-lg">
                                                    <button type="button" class="px-3 py-2 text-gray-500 hover:bg-gray-100 rounded-l-lg" @click="if(ticketsAdult > 0) ticketsAdult--">-</button>
                                                    <input type="number" x-model.number="ticketsAdult" min="0" class="w-16 text-center border-none focus:ring-0 p-0 text-gray-700 py-2 font-bold" readonly>
                                                    <button type="button" class="px-3 py-2 text-gray-500 hover:bg-gray-100 rounded-r-lg" @click="ticketsAdult++">+</button>
                                                </div>
                                            </div>
                                            
                                            <div class="flex items-center justify-between w-full">
                                                <span class="text-gray-700 font-medium">Anak-anak</span>
                                                <div class="flex items-center border border-gray-200 rounded-lg">
                                                    <button type="button" class="px-3 py-2 text-gray-500 hover:bg-gray-100 rounded-l-lg" @click="if(ticketsChild > 0) ticketsChild--">-</button>
                                                    <input type="number" x-model.number="ticketsChild" min="0" class="w-16 text-center border-none focus:ring-0 p-0 text-gray-700 py-2 font-bold" readonly>
                                                    <button type="button" class="px-3 py-2 text-gray-500 hover:bg-gray-100 rounded-r-lg" @click="ticketsChild++">+</button>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                <div class="mt-8">
                                    <button type="button" @click="addToCart()" :disabled="(availableStock !== null && availableStock === 0) || (ticketsAdult === 0 && ticketsChild === 0)" class="w-full bg-secondary hover:bg-orange-600 text-white font-bold py-3 px-4 rounded-xl shadow-sm transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                        Tambahkan ke Keranjang
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="lg:col-span-5 space-y-8">
                    
                    <!-- Keranjang Pesanan -->
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                        <h3 class="text-xl font-bold text-gray-900 font-heading mb-6 border-b border-gray-100 pb-4 flex items-center gap-2">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Keranjang Anda
                        </h3>
                        
                        <!-- Empty State -->
                        <div x-show="cartItems.length === 0" class="text-center py-8">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            </div>
                            <p class="text-gray-500 text-sm">Keranjang masih kosong.</p>
                        </div>

                        <!-- Cart Items -->
                        <div x-show="cartItems.length > 0" class="space-y-4 mb-6 max-h-80 overflow-y-auto pr-2 custom-scrollbar">
                            <template x-for="item in cartItems" :key="item.id">
                                <div class="p-4 bg-gray-50 border border-gray-100 rounded-xl relative group">
                                    <button type="button" @click="removeFromCart(item.id)" class="absolute top-2 right-2 text-gray-400 hover:text-red-500 transition-colors bg-white rounded-full p-1 shadow-sm opacity-100 md:opacity-0 md:group-hover:opacity-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                    
                                    <h4 class="font-bold text-gray-900 text-sm pr-6" x-text="item.name"></h4>
                                    
                                    <div class="mt-2 space-y-1 text-sm text-gray-600">
                                        <template x-if="item.pricing_type === 'per_package'">
                                            <div class="flex justify-between">
                                                <span x-text="item.tickets_adult + ' Paket x Rp ' + formatRupiah(item.price_adult)"></span>
                                                <span class="font-semibold text-gray-900" x-text="'Rp ' + formatRupiah(item.tickets_adult * item.price_adult)"></span>
                                            </div>
                                        </template>
                                        
                                        <template x-if="item.pricing_type === 'per_person' && item.tickets_adult > 0">
                                            <div class="flex justify-between">
                                                <span x-text="item.tickets_adult + ' Dewasa x Rp ' + formatRupiah(item.price_adult)"></span>
                                                <span class="font-semibold text-gray-900" x-text="'Rp ' + formatRupiah(item.tickets_adult * item.price_adult)"></span>
                                            </div>
                                        </template>
                                        
                                        <template x-if="item.pricing_type === 'per_person' && item.tickets_child > 0">
                                            <div class="flex justify-between">
                                                <span x-text="item.tickets_child + ' Anak x Rp ' + formatRupiah(item.price_child)"></span>
                                                <span class="font-semibold text-gray-900" x-text="'Rp ' + formatRupiah(item.tickets_child * item.price_child)"></span>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                            <span class="font-bold text-gray-900 text-lg">Total Pembayaran</span>
                            <span class="text-2xl font-bold text-primary" x-text="'Rp ' + formatRupiah(totalAmount)">Rp 0</span>
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
                            <button type="submit" :disabled="cartItems.length === 0" class="w-full bg-primary text-white font-bold py-4 rounded-xl shadow-sm hover:bg-green-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                                Lanjut ke Pembayaran
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>

<style>
.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
</style>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('reservationForm', () => ({
            destinations: @json($destinations),
            selectedId: '{{ $selectedDestination->id ?? ($destinations->first()->id ?? "") }}',
            currentDestination: null,
            visitDate: '{{ old('visit_date', date('Y-m-d')) }}',
            ticketsAdult: 1,
            ticketsChild: 0,
            availableStock: null,
            cartItems: [],
            
            init() {
                this.updateDestination();
                
                // Jika validasi form gagal, restore cart items dari old input
                const oldCart = '{!! old('cart_items') !!}';
                if(oldCart) {
                    try {
                        this.cartItems = JSON.parse(oldCart);
                    } catch(e) {}
                }
            },
            
            updateDestination() {
                if(!this.selectedId) return;
                
                const dest = this.destinations.find(d => d.id == this.selectedId);
                if(dest) {
                    this.currentDestination = dest;
                    this.ticketsAdult = dest.pricing_type === 'per_package' ? 1 : 1;
                    this.ticketsChild = 0;
                    this.checkStock();
                }
            },
            
            async checkStock() {
                if(!this.selectedId || !this.visitDate || !this.currentDestination) return;
                
                try {
                    const response = await fetch(`/api/check-stock?destination_id=${this.selectedId}&visit_date=${this.visitDate}`);
                    const data = await response.json();
                    
                    this.availableStock = data.available_stock;
                } catch (error) {
                    console.error('Error checking stock:', error);
                }
            },
            
            addToCart() {
                if (!this.currentDestination || !this.visitDate) return;
                
                if (this.ticketsAdult <= 0 && this.ticketsChild <= 0) {
                    alert('Silakan pilih minimal 1 tiket/paket.');
                    return;
                }
                
                // Validasi sisa stok dengan yang sudah di keranjang
                if (this.availableStock !== null) {
                    let currentInCart = this.cartItems
                        .filter(i => i.destination_id == this.selectedId)
                        .reduce((sum, i) => sum + i.tickets_adult + (i.pricing_type === 'per_package' ? 0 : i.tickets_child), 0);
                    
                    let requested = this.currentDestination.pricing_type === 'per_package' 
                        ? this.ticketsAdult 
                        : (this.ticketsAdult + this.ticketsChild);
                        
                    if ((currentInCart + requested) > this.availableStock) {
                        alert(`Gagal menambah: Stok tersisa ${this.availableStock} unit. Anda sudah memasukkan ${currentInCart} unit di keranjang.`);
                        return;
                    }
                }
                
                // Tambahkan ke keranjang (Bisa menggabungkan item jika destinasi sama, tapi kita pisah saja agar lebih mudah dibaca/dihapus)
                this.cartItems.push({
                    id: Date.now(),
                    destination_id: this.currentDestination.id,
                    name: this.currentDestination.name,
                    pricing_type: this.currentDestination.pricing_type,
                    price_adult: this.currentDestination.price_adult,
                    price_child: this.currentDestination.price_child,
                    tickets_adult: this.ticketsAdult,
                    tickets_child: this.ticketsChild,
                });
                
                // Reset form
                this.ticketsAdult = this.currentDestination.pricing_type === 'per_package' ? 1 : 1;
                this.ticketsChild = 0;
            },
            
            removeFromCart(id) {
                this.cartItems = this.cartItems.filter(i => i.id !== id);
            },
            
            get totalAmount() {
                return this.cartItems.reduce((sum, item) => {
                    if (item.pricing_type === 'per_package') {
                        return sum + (item.price_adult * item.tickets_adult);
                    }
                    return sum + (item.price_adult * item.tickets_adult) + (item.price_child * item.tickets_child);
                }, 0);
            },
            
            formatRupiah(number) {
                return new Intl.NumberFormat('id-ID').format(number);
            }
        }))
    })
</script>
@endsection
