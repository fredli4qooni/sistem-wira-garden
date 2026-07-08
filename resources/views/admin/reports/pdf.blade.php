<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Reservasi Wira Garden</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; color: #333; margin: 0; padding: 20px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #047857; padding-bottom: 10px; }
        .header h1 { margin: 0 0 5px 0; color: #047857; font-size: 24px; }
        .header p { margin: 0; color: #666; font-size: 14px; }
        
        .summary { width: 100%; margin-bottom: 20px; border-collapse: collapse; }
        .summary td { padding: 10px; border: 1px solid #ddd; text-align: center; width: 25%; }
        .summary .label { font-weight: bold; color: #555; display: block; margin-bottom: 5px; font-size: 11px; text-transform: uppercase; }
        .summary .value { font-size: 18px; font-weight: bold; color: #047857; }

        table.data { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table.data th, table.data td { border: 1px solid #ddd; padding: 8px 10px; text-align: left; }
        table.data th { background-color: #f8f9fa; font-weight: bold; text-transform: uppercase; font-size: 11px; color: #555; }
        table.data tr:nth-child(even) { background-color: #fbfbfb; }
        table.data td { font-size: 11px; }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        
        .badge { padding: 3px 6px; border-radius: 4px; font-size: 10px; font-weight: bold; }
        .badge-success { background-color: #d1fae5; color: #065f46; }
        .badge-warning { background-color: #fef3c7; color: #92400e; }
        .badge-danger { background-color: #fee2e2; color: #b91c1c; }
        .badge-primary { background-color: #dbeafe; color: #1e40af; }
        
        .footer { margin-top: 30px; text-align: right; font-size: 11px; color: #777; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Reservasi & Pendapatan - Wira Garden</h1>
        <p>Periode: {{ \Carbon\Carbon::parse($start)->format('d F Y') }} s/d {{ \Carbon\Carbon::parse($end)->format('d F Y') }}</p>
    </div>

    <table class="summary">
        <tr>
            <td>
                <span class="label">Total Reservasi</span>
                <span class="value">{{ number_format($totalReservations, 0, ',', '.') }}</span>
            </td>
            <td>
                <span class="label">Total Pengunjung</span>
                <span class="value">{{ number_format($totalVisitors, 0, ',', '.') }}</span>
            </td>
            <td>
                <span class="label">Reservasi Berhasil</span>
                <span class="value">{{ number_format($successfulReservations, 0, ',', '.') }}</span>
            </td>
            <td>
                <span class="label">Total Pendapatan</span>
                <span class="value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
            </td>
        </tr>
    </table>

    <table class="data">
        <thead>
            <tr>
                <th class="text-center" width="5%">No</th>
                <th width="15%">Kode Reservasi</th>
                <th width="12%">Tgl Kunjungan</th>
                <th width="18%">Wisata</th>
                <th width="15%">Nama Pengunjung</th>
                <th class="text-center" width="10%">Jml Tiket</th>
                <th class="text-right" width="15%">Total Bayar</th>
                <th class="text-center" width="10%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $index => $order)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td><strong>{{ $order->order_code }}</strong></td>
                <td>{{ \Carbon\Carbon::parse($order->visit_date)->format('d/m/Y') }}</td>
                <td>{{ $order->items->count() > 0 ? $order->items->pluck('destination.name')->filter()->unique()->join(', ') : '-' }}</td>
                <td>{{ $order->visitor_name }}</td>
                <td class="text-center">{{ $order->items->sum('quantity') }}</td>
                <td class="text-right">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                <td class="text-center">
                    @if($order->status == 'PAID' || $order->status == 'COMPLETED')
                        <span class="badge badge-success">Selesai</span>
                    @elseif($order->status == 'PENDING')
                        <span class="badge badge-primary">Menunggu</span>
                    @elseif($order->status == 'CONFIRMED')
                        <span class="badge badge-warning">Dikonfirmasi</span>
                    @else
                        <span class="badge badge-danger">Dibatalkan</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center" style="padding: 20px;">Belum ada data reservasi pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="footer">
        Dicetak pada: {{ \Carbon\Carbon::now()->format('d F Y H:i') }} oleh Admin
    </div>
</body>
</html>
