<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Stok</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 11px; color: #333; }

        .header { background: #6366f1; color: white; padding: 15px 20px; margin-bottom: 20px; }
        .header h1 { font-size: 18px; font-weight: bold; }
        .header p  { font-size: 11px; opacity: 0.8; margin-top: 3px; }

        .summary { display: flex; gap: 15px; margin: 0 20px 20px; }
        .summary-card { flex: 1; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px 15px; }
        .summary-card .label { font-size: 9px; color: #94a3b8; text-transform: uppercase; font-weight: bold; }
        .summary-card .value { font-size: 14px; font-weight: bold; color: #1e293b; margin-top: 3px; }

        table { width: calc(100% - 40px); margin: 0 20px; border-collapse: collapse; }
        thead tr { background: #6366f1; color: white; }
        thead th { padding: 8px 10px; text-align: left; font-size: 10px; font-weight: bold; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        tbody td { padding: 7px 10px; border-bottom: 1px solid #f1f5f9; font-size: 10px; }

        .badge { padding: 2px 8px; border-radius: 10px; font-size: 9px; font-weight: bold; }
        .badge-safe   { background: #dcfce7; color: #16a34a; }
        .badge-low    { background: #fff7ed; color: #ea580c; }
        .badge-out    { background: #fef2f2; color: #dc2626; }

        .footer { margin: 20px; text-align: right; font-size: 9px; color: #94a3b8; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Stok Produk</h1>
        <p>Per tanggal: {{ now()->format('d M Y') }}</p>
    </div>

    <div class="summary">
        <div class="summary-card">
            <div class="label">Total Produk</div>
            <div class="value">{{ $products->count() }}</div>
        </div>
        <div class="summary-card">
            <div class="label">Stok Menipis</div>
            <div class="value">{{ $products->filter(fn($p) => $p->stock > 0 && $p->stock <= $p->min_stock)->count() }}</div>
        </div>
        <div class="summary-card">
            <div class="label">Stok Habis</div>
            <div class="value">{{ $products->filter(fn($p) => $p->stock == 0)->count() }}</div>
        </div>
        <div class="summary-card">
            <div class="label">Nilai Stok</div>
            <div class="value">Rp {{ number_format($totalValue, 0, ',', '.') }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>SKU</th>
                <th>Kategori</th>
                <th>Satuan</th>
                <th>Stok</th>
                <th>Min.</th>
                <th>Status</th>
                <th>Harga Modal</th>
                <th>Nilai Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            @php
                $status = $product->stock == 0 ? 'out' : ($product->stock <= $product->min_stock ? 'low' : 'safe');
                $label  = $product->stock == 0 ? 'Habis' : ($product->stock <= $product->min_stock ? 'Menipis' : 'Aman');
            @endphp
            <tr>
                <td><strong>{{ $product->name }}</strong></td>
                <td><code>{{ $product->sku }}</code></td>
                <td>{{ $product->category->name ?? '-' }}</td>
                <td>{{ $product->unit->abbreviation ?? '-' }}</td>
                <td>{{ $product->stock }}</td>
                <td>{{ $product->min_stock }}</td>
                <td><span class="badge badge-{{ $status }}">{{ $label }}</span></td>
                <td>Rp {{ number_format($product->cost_price, 0, ',', '.') }}</td>
                <td><strong>Rp {{ number_format($product->stock * $product->cost_price, 0, ',', '.') }}</strong></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d M Y H:i') }} | POS Inventory System
    </div>

</body>
</html>