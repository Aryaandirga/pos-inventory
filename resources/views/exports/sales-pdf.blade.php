<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 11px; color: #333; }

        .header { background: #6366f1; color: white; padding: 15px 20px; margin-bottom: 20px; }
        .header h1 { font-size: 18px; font-weight: bold; }
        .header p  { font-size: 11px; opacity: 0.8; margin-top: 3px; }

        .summary { display: flex; gap: 15px; margin: 0 20px 20px; }
        .summary-card { flex: 1; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px 15px; }
        .summary-card .label { font-size: 9px; color: #94a3b8; text-transform: uppercase; font-weight: bold; letter-spacing: 0.5px; }
        .summary-card .value { font-size: 14px; font-weight: bold; color: #1e293b; margin-top: 3px; }

        table { width: calc(100% - 40px); margin: 0 20px; border-collapse: collapse; }
        thead tr { background: #6366f1; color: white; }
        thead th { padding: 8px 10px; text-align: left; font-size: 10px; font-weight: bold; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        tbody td { padding: 7px 10px; border-bottom: 1px solid #f1f5f9; font-size: 10px; }

        .footer { margin: 20px; text-align: right; font-size: 9px; color: #94a3b8; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Penjualan</h1>
        <p>Periode: {{ \Carbon\Carbon::parse($dateFrom)->format('d M Y') }} — {{ \Carbon\Carbon::parse($dateTo)->format('d M Y') }}</p>
    </div>

    <div class="summary">
        <div class="summary-card">
            <div class="label">Total Transaksi</div>
            <div class="value">{{ $totalTrx }}</div>
        </div>
        <div class="summary-card">
            <div class="label">Total Diskon</div>
            <div class="value">Rp {{ number_format($totalDiscount, 0, ',', '.') }}</div>
        </div>
        <div class="summary-card">
            <div class="label">Total Pendapatan</div>
            <div class="value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No. Invoice</th>
                <th>Tanggal</th>
                <th>Kasir</th>
                <th>Item</th>
                <th>Pembayaran</th>
                <th>Diskon</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sales as $sale)
            <tr>
                <td>{{ $sale->invoice_no }}</td>
                <td>{{ \Carbon\Carbon::parse($sale->date)->format('d/m/Y') }}</td>
                <td>{{ $sale->user->name }}</td>
                <td>{{ $sale->items->count() }} item</td>
                <td>{{ strtoupper($sale->payment_method) }}</td>
                <td>Rp {{ number_format($sale->discount, 0, ',', '.') }}</td>
                <td><strong>Rp {{ number_format($sale->grand_total, 0, ',', '.') }}</strong></td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center; padding: 20px; color: #94a3b8;">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d M Y H:i') }} | POS Inventory System
    </div>

</body>
</html>