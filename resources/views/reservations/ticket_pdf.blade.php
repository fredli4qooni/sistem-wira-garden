<!DOCTYPE html>
<html>
<head>
    <title>E-Ticket {{ $order->order_code }}</title>
    <style>
        body { font-family: sans-serif; }
        .ticket-box { border: 2px dashed #333; padding: 20px; border-radius: 10px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 1px solid #ccc; padding-bottom: 10px; }
        .title { font-size: 24px; font-weight: bold; margin-bottom: 5px; }
        .subtitle { font-size: 14px; color: #666; }
        .order-code { font-size: 28px; font-weight: bold; text-align: center; margin: 20px 0; background: #f0f0f0; padding: 10px; border-radius: 5px; }
        .details { width: 100%; margin-bottom: 20px; }
        .details th { text-align: left; padding: 5px; color: #666; font-size: 12px; text-transform: uppercase; }
        .details td { padding: 5px; font-size: 16px; font-weight: bold; }
        .items { width: 100%; border-top: 1px solid #eee; padding-top: 10px; }
        .items h4 { color: #666; font-size: 12px; text-transform: uppercase; margin-bottom: 10px; }
        .items ul { list-style-type: none; padding: 0; margin: 0; }
        .items li { font-size: 14px; margin-bottom: 5px; font-weight: bold; }
        .footer { text-align: center; margin-top: 30px; font-size: 12px; color: #888; }
    </style>
</head>
<body>
    <div class="ticket-box">
        <div class="header">
            <div class="title">Wira Garden</div>
            <div class="subtitle">Taman Wisata & Edukasi</div>
        </div>
        
        <div style="text-align: center; font-size: 12px; font-weight: bold; letter-spacing: 2px; color: #666;">E-TICKET</div>
        
        <div class="order-code">{{ $order->order_code }}</div>
        
        <table class="details">
            <tr>
                <th>Nama Pengunjung</th>
                <th>Tanggal Kunjungan</th>
            </tr>
            <tr>
                <td>{{ $order->visitor_name }}</td>
                <td>{{ \Carbon\Carbon::parse($order->visit_date)->translatedFormat('d F Y') }}</td>
            </tr>
        </table>
        
        <div class="items">
            <h4>Daftar Pesanan</h4>
            <ul>
                @foreach($order->items as $item)
                    <li>{{ $item->quantity }}x {{ $item->ticket_name }}</li>
                @endforeach
            </ul>
        </div>
        
        <div class="footer">
            Harap tunjukkan e-ticket ini kepada petugas di loket masuk.
        </div>
    </div>
</body>
</html>
