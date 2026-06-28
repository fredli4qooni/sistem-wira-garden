<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pemesanan Wira Garden</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #059669; padding-bottom: 10px; }
        .header h1 { margin: 0; color: #047857; font-size: 24px; }
        .header p { margin: 5px 0 0 0; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f3f4f6; color: #374151; font-weight: bold; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .status-badge { padding: 3px 8px; border-radius: 12px; font-size: 10px; font-weight: bold; }
        .status-PAID, .status-COMPLETED { background-color: #d1fae5; color: #065f46; }
        .status-PENDING { background-color: #fef3c7; color: #92400e; }
        .status-CANCELLED { background-color: #fee2e2; color: #991b1b; }
        .footer { margin-top: 30px; text-align: right; font-size: 14px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>WIRA GARDEN BANDAR LAMPUNG</h1>
        <p>Laporan Pemesanan / Reservasi Tiket</p>
        <p style="font-size: 10px;">
            Dicetak pada: {{ now()->format('d M Y H:i') }} <br>
            @if(request('start_date') || request('end_date'))
                Periode: {{ request('start_date') ? \Carbon\Carbon::parse(request('start_date'))->format('d M Y') : 'Awal' }} 
                s/d 
                {{ request('end_date') ? \Carbon\Carbon::parse(request('end_date'))->format('d M Y') : 'Sekarang' }} <br>
            @endif
            @if(request('status') && request('status') != 'ALL')
                Status Filter: {{ request('status') }}
            @endif
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Tgl Pesan</th>
                <th>Kode Order</th>
                <th>Pemesan</th>
                <th>Kontak</th>
                <th>Tgl Kunjungan</th>
                <th class="text-center">Status</th>
                <th class="text-right">Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @forelse($orders as $index => $order)
                @php if($order->status == 'PAID' || $order->status == 'COMPLETED') $grandTotal += $order->total_amount; @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                    <td>
                        <strong>{{ $order->order_code }}</strong><br>
                        @if($order->destination)
                        <small>{{ $order->destination->name }}</small>
                        @endif
                    </td>
                    <td>{{ $order->visitor_name }}</td>
                    <td>{{ $order->phone }}<br><small>{{ $order->email }}</small></td>
                    <td>{{ \Carbon\Carbon::parse($order->visit_date)->format('d/m/Y') }}</td>
                    <td class="text-center">
                        <span class="status-badge status-{{ $order->status }}">{{ $order->status }}</span>
                    </td>
                    <td class="text-right">{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data pemesanan yang ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="7" class="text-right">Total Pendapatan (Hanya PAID & COMPLETED):</th>
                <th class="text-right">Rp {{ number_format($grandTotal, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Mengetahui,</p>
        <p>Admin Wira Garden</p>
        <br><br><br>
        <p>_______________________</p>
    </div>
</body>
</html>
