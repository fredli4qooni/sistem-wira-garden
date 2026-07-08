<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-primary leading-tight font-heading">
            Laporan Reservasi & Pendapatan
        </h2>
    </x-slot>

    <!-- Filter Form -->
    <div class="mb-6 bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <form action="{{ route('admin.reports.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end" id="filterForm">
            <div class="w-full md:w-1/4">
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Periode</label>
                <select name="period" id="periodSelect" class="w-full rounded-xl border-gray-200 focus:border-primary focus:ring-primary">
                    <option value="this_month" @if($period == 'this_month') selected @endif>Bulan ini</option>
                    <option value="last_month" @if($period == 'last_month') selected @endif>Bulan lalu</option>
                    <option value="this_year" @if($period == 'this_year') selected @endif>Tahun ini</option>
                    <option value="custom" @if($period == 'custom') selected @endif>Pilih Tanggal</option>
                </select>
            </div>
            
            <div class="w-full md:w-1/4 custom-date @if($period != 'custom') hidden @endif">
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Mulai Tgl</label>
                <input type="date" name="start_date" id="start_date" value="{{ $start }}" class="w-full rounded-xl border-gray-200 focus:border-primary focus:ring-primary">
            </div>
            
            <div class="w-full md:w-1/4 custom-date @if($period != 'custom') hidden @endif">
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Sampai Tgl (s/d)</label>
                <input type="date" name="end_date" id="end_date" value="{{ $end }}" class="w-full rounded-xl border-gray-200 focus:border-primary focus:ring-primary">
            </div>
            
            <div>
                <button type="submit" class="bg-primary hover:bg-secondary text-white px-6 py-2.5 rounded-xl transition-colors font-semibold shadow-sm w-full md:w-auto">
                    Tampilkan
                </button>
            </div>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-center">
            <p class="text-sm font-semibold text-gray-500 mb-2">Total Reservasi</p>
            <h3 class="text-3xl font-bold text-gray-900">{{ number_format($totalReservations, 0, ',', '.') }}</h3>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-center">
            <p class="text-sm font-semibold text-gray-500 mb-2">Total Pengunjung</p>
            <h3 class="text-3xl font-bold text-gray-900">{{ number_format($totalVisitors, 0, ',', '.') }}</h3>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-center">
            <p class="text-sm font-semibold text-gray-500 mb-2">Reservasi Berhasil</p>
            <h3 class="text-3xl font-bold text-gray-900">{{ number_format($successfulReservations, 0, ',', '.') }}</h3>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-center">
            <p class="text-sm font-semibold text-gray-500 mb-2">Total Pendapatan</p>
            <h3 class="text-2xl font-bold text-primary">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:col-span-2">
            <h3 class="text-sm font-bold text-gray-700 mb-4">Grafik Reservasi per Hari</h3>
            <div class="h-64 relative">
                <canvas id="lineChart"></canvas>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-sm font-bold text-gray-700 mb-4">Status Reservasi</h3>
            <div class="h-64 flex justify-center relative">
                <canvas id="donutChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
        <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h3 class="text-lg font-bold text-gray-900 font-heading">Detail Laporan Reservasi</h3>
            <div class="flex gap-2">
                <a href="{{ route('admin.reports.exportExcel', request()->query()) }}" class="inline-flex items-center gap-2 bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-xl transition-colors font-semibold text-sm shadow-sm">
                    Export Excel
                </a>
                <a href="{{ route('admin.reports.exportPdf', request()->query()) }}" target="_blank" class="inline-flex items-center gap-2 bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-xl transition-colors font-semibold text-sm shadow-sm">
                    Cetak PDF
                </a>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kode Reservasi</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Wisata</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Pengunjung</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Jumlah Tiket</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Bayar</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($orders as $index => $order)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                            {{ $index + 1 }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                            {{ $order->order_code }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($order->visit_date)->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $order->items->count() > 0 ? $order->items->pluck('destination.name')->filter()->unique()->join(', ') : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $order->visitor_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center font-medium">
                            {{ $order->items->sum('quantity') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="px-2.5 py-1 inline-flex text-[11px] leading-4 font-bold rounded-md 
                                @if($order->status == 'PAID' || $order->status == 'COMPLETED') bg-green-100 text-green-700 
                                @elseif($order->status == 'PENDING') bg-blue-100 text-blue-700 
                                @else bg-red-100 text-red-700 @endif">
                                @if($order->status == 'PAID' || $order->status == 'COMPLETED')
                                    Selesai
                                @elseif($order->status == 'PENDING')
                                    Menunggu
                                @elseif($order->status == 'CONFIRMED')
                                    Dikonfirmasi
                                @else
                                    Dibatalkan
                                @endif
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                            Belum ada data reservasi pada periode ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Period Toggle Logic
            const periodSelect = document.getElementById('periodSelect');
            const customDates = document.querySelectorAll('.custom-date');
            
            periodSelect.addEventListener('change', function() {
                if (this.value === 'custom') {
                    customDates.forEach(el => el.classList.remove('hidden'));
                } else {
                    customDates.forEach(el => el.classList.add('hidden'));
                }
            });

            // Data for charts
            const lineDataKeys = {!! json_encode($reservationsPerDay->keys()) !!};
            const lineDataValues = {!! json_encode($reservationsPerDay->values()) !!};
            const statusCounts = {!! json_encode($statusCounts) !!};

            // Line Chart
            const ctxLine = document.getElementById('lineChart').getContext('2d');
            new Chart(ctxLine, {
                type: 'line',
                data: {
                    labels: lineDataKeys,
                    datasets: [{
                        label: 'Jumlah Reservasi',
                        data: lineDataValues,
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#3b82f6',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true,
                            ticks: { stepSize: 1 }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });

            // Donut Chart
            const ctxDonut = document.getElementById('donutChart').getContext('2d');
            new Chart(ctxDonut, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(statusCounts),
                    datasets: [{
                        data: Object.values(statusCounts),
                        backgroundColor: [
                            '#3b82f6', // Menunggu
                            '#f59e0b', // Dikonfirmasi
                            '#10b981', // Selesai
                            '#ef4444'  // Dibatalkan
                        ],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%',
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                usePointStyle: true,
                                boxWidth: 8
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
