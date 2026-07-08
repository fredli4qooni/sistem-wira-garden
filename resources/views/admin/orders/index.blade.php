<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-primary leading-tight font-heading">
            Manajemen Reservasi
        </h2>
    </x-slot>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl mb-6 flex items-center shadow-sm">
            <svg class="w-5 h-5 mr-3 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-6 bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
            <div class="flex-1">
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Pencarian</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Kode Order, Nama, Email, No HP..." class="w-full rounded-xl border-gray-200 focus:border-primary focus:ring-primary">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Mulai Tgl</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full rounded-xl border-gray-200 focus:border-primary focus:ring-primary">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Sampai Tgl</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full rounded-xl border-gray-200 focus:border-primary focus:ring-primary">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Status</label>
                <select name="status" class="w-full rounded-xl border-gray-200 focus:border-primary focus:ring-primary">
                    <option value="ALL">Semua Status</option>
                    <option value="PENDING" @if(request('status') == 'PENDING') selected @endif>PENDING</option>
                    <option value="PAID" @if(request('status') == 'PAID') selected @endif>PAID</option>
                    <option value="CONFIRMED" @if(request('status') == 'CONFIRMED') selected @endif>CONFIRMED</option>
                    <option value="COMPLETED" @if(request('status') == 'COMPLETED') selected @endif>COMPLETED</option>
                    <option value="CANCELLED" @if(request('status') == 'CANCELLED') selected @endif>CANCELLED</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-primary hover:bg-secondary text-white px-5 py-2.5 rounded-xl transition-colors font-semibold shadow-sm">
                    Filter
                </button>
                <a href="{{ route('admin.orders.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-5 py-2.5 rounded-xl transition-colors font-semibold">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Export Button -->
    <div class="mb-4 flex justify-end">
        <a href="{{ route('admin.orders.exportPdf', request()->query()) }}" target="_blank" class="bg-red-500 hover:bg-red-600 text-white px-5 py-2.5 rounded-xl transition-colors font-semibold shadow-sm inline-flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Export Laporan PDF
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tgl Pemesanan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kode / Tgl Kunjungan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Pemesan & Kontak</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Pembayaran</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($orders as $order)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $order->created_at->format('d M Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-bold text-primary">{{ $order->order_code }}</div>
                            <div class="text-sm font-semibold text-gray-600 mt-1">{{ \Carbon\Carbon::parse($order->visit_date)->format('d M Y') }}</div>
                            @if($order->items->count() > 0)
                            <div class="text-xs text-secondary mt-1 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                {{ $order->items->pluck('destination.name')->filter()->unique()->join(', ') }}
                            </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-bold text-gray-900">{{ $order->visitor_name }}</div>
                            <div class="text-sm text-gray-500 mt-1">{{ $order->phone }} <br/> <span class="text-xs text-gray-400">{{ $order->email }}</span></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-secondary">
                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full 
                                @if($order->status == 'PAID' || $order->status == 'COMPLETED') bg-green-50 text-green-700 border border-green-200
                                @elseif($order->status == 'PENDING') bg-yellow-50 text-yellow-700 border border-yellow-200
                                @else bg-red-50 text-red-700 border border-red-200 @endif">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="inline-flex items-center gap-2">
                                @csrf
                                <select name="status" class="text-sm border-gray-200 rounded-lg py-1.5 focus:ring-secondary focus:border-secondary bg-gray-50 hover:bg-white transition-colors cursor-pointer">
                                    <option value="PENDING" @if($order->status == 'PENDING') selected @endif>PENDING</option>
                                    <option value="PAID" @if($order->status == 'PAID') selected @endif>PAID</option>
                                    <option value="CONFIRMED" @if($order->status == 'CONFIRMED') selected @endif>CONFIRMED</option>
                                    <option value="COMPLETED" @if($order->status == 'COMPLETED') selected @endif>COMPLETED</option>
                                    <option value="CANCELLED" @if($order->status == 'CANCELLED') selected @endif>CANCELLED</option>
                                </select>
                                <button type="submit" class="bg-primary hover:bg-secondary text-white px-3 py-1.5 rounded-lg transition-colors font-medium text-xs shadow-sm">Simpan</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                <span class="text-gray-400 font-medium">Belum ada reservasi.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            {{ $orders->links() }}
        </div>
    </div>
</x-app-layout>
