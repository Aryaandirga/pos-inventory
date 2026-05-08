@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

{{-- Page Header --}}
<div style="margin-bottom:28px;">
    <h1 style="font-size:22px;font-weight:800;color:#111827;margin:0;">
        Selamat datang, {{ auth()->user()->name }} 👋
    </h1>
    <p style="font-size:13px;color:#6B7280;margin-top:4px;font-weight:500;">
        Berikut ringkasan bisnis hari ini
    </p>
</div>

{{-- Stat Cards --}}
@php
$cards = [
    [
        'title' => 'Total Produk',
        'value' => $totalProducts,
        'label' => 'Produk aktif',
        'color' => '#6366F1',
        'bg'    => '#EEF2FF',
        'icon'  => '<path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>',
    ],
    [
        'title' => 'Stok Menipis',
        'value' => $lowStockCount,
        'label' => 'Perlu restock',
        'color' => '#F59E0B',
        'bg'    => '#FFFBEB',
        'icon'  => '<path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>',
    ],
    [
        'title' => 'Penjualan Hari Ini',
        'value' => 'Rp '.number_format($todaySales, 0, ',', '.'),
        'label' => 'Total pendapatan',
        'color' => '#10B981',
        'bg'    => '#ECFDF5',
        'icon'  => '<path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
    ],
    [
        'title' => 'Transaksi Hari Ini',
        'value' => $todayTransactions,
        'label' => 'Total transaksi',
        'color' => '#8B5CF6',
        'bg'    => '#F5F3FF',
        'icon'  => '<path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>',
    ],
];
@endphp

<div style="display:grid;grid-template-columns:repeat(2,1fr);gap:16px;margin-bottom:24px;" class="lg:grid-cols-4 sm:grid-cols-2">
    @foreach($cards as $i => $card)
    <div style="
        background:#fff;
        border-radius:14px;
        padding:20px;
        border:1px solid #E5E7EB;
        box-shadow:0 1px 3px rgba(0,0,0,0.04);
        transition:box-shadow 0.2s, transform 0.2s;
        animation: fadeUp 0.4s ease {{ $i * 0.07 }}s both;
    " onmouseover="this.style.boxShadow='0 8px 24px rgba(0,0,0,0.08)';this.style.transform='translateY(-2px)'"
       onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,0.04)';this.style.transform='translateY(0)'">

        {{-- Icon --}}
        <div style="
            width:40px;height:40px;border-radius:10px;
            background:{{ $card['bg'] }};
            display:flex;align-items:center;justify-content:center;
            margin-bottom:14px;
        ">
            <svg width="18" height="18" fill="none" stroke="{{ $card['color'] }}" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                {!! $card['icon'] !!}
            </svg>
        </div>

        {{-- Value --}}
        <p style="font-size:22px;font-weight:800;color:#111827;line-height:1;margin:0;">
            {{ $card['value'] }}
        </p>

        {{-- Labels --}}
        <div style="margin-top:8px;display:flex;align-items:center;justify-content:space-between;">
            <p style="font-size:12px;font-weight:600;color:#6B7280;margin:0;">{{ $card['title'] }}</p>
            <span style="
                font-size:10px;font-weight:700;
                padding:2px 8px;border-radius:20px;
                background:{{ $card['bg'] }};color:{{ $card['color'] }};
            ">{{ $card['label'] }}</span>
        </div>

    </div>
    @endforeach
</div>

{{-- Chart + Low Stock --}}
<div style="display:grid;grid-template-columns:1fr;gap:20px;margin-bottom:20px;" class="lg:grid-cols-3">

    {{-- Chart --}}
    <div style="
        background:#fff;border-radius:14px;border:1px solid #E5E7EB;
        box-shadow:0 1px 3px rgba(0,0,0,0.04);
        overflow:hidden;
        animation: fadeUp 0.4s ease 0.28s both;
    " class="lg:col-span-2">
        <div style="padding:20px 24px 16px;border-bottom:1px solid #F3F4F6;display:flex;align-items:center;justify-content:space-between;">
            <div>
                <h2 style="font-size:15px;font-weight:700;color:#111827;margin:0;">Grafik Penjualan</h2>
                <p style="font-size:12px;color:#9CA3AF;margin-top:3px;font-weight:500;">7 hari terakhir</p>
            </div>
            <span style="font-size:11px;font-weight:600;padding:4px 10px;border-radius:20px;background:#EEF2FF;color:#6366F1;">
                Mingguan
            </span>
        </div>
        <div style="padding:20px 24px;">
            <div style="position:relative;height:210px;">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Low Stock --}}
    <div style="
        background:#fff;border-radius:14px;border:1px solid #E5E7EB;
        box-shadow:0 1px 3px rgba(0,0,0,0.04);
        overflow:hidden;
        animation: fadeUp 0.4s ease 0.35s both;
    ">
        <div style="padding:20px 24px 16px;border-bottom:1px solid #F3F4F6;display:flex;align-items:center;justify-content:space-between;">
            <div>
                <h2 style="font-size:15px;font-weight:700;color:#111827;margin:0;">Stok Menipis</h2>
                <p style="font-size:12px;color:#9CA3AF;margin-top:3px;font-weight:500;">Perlu restock segera</p>
            </div>
            @if($lowStockProducts->count() > 0)
            <span style="
                min-width:22px;height:22px;padding:0 7px;
                background:#FEF3C7;color:#D97706;
                font-size:11px;font-weight:700;border-radius:20px;
                display:flex;align-items:center;justify-content:center;
            ">{{ $lowStockProducts->count() }}</span>
            @endif
        </div>

        <div style="padding:8px 24px 16px;">
            @if($lowStockProducts->count() > 0)
                @foreach($lowStockProducts as $product)
                @php
                    $pct = $product->min_stock > 0
                        ? min(100, round(($product->stock / $product->min_stock) * 100))
                        : 100;
                    $barColor = $pct <= 30 ? '#EF4444' : ($pct <= 60 ? '#F59E0B' : '#10B981');
                @endphp
                <div style="padding:12px 0;border-bottom:1px solid #F9FAFB;" class="last:border-0">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;">
                        <p style="font-size:13px;font-weight:600;color:#111827;margin:0;max-width:150px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            {{ $product->name }}
                        </p>
                        <span style="font-size:11px;font-weight:700;padding:2px 8px;border-radius:20px;background:#FEF2F2;color:#EF4444;flex-shrink:0;margin-left:8px;">
                            {{ $product->stock }} {{ $product->unit->abbreviation }}
                        </span>
                    </div>
                    <div style="height:4px;background:#F3F4F6;border-radius:2px;overflow:hidden;">
                        <div style="height:100%;width:{{ $pct }}%;background:{{ $barColor }};border-radius:2px;transition:width 0.6s ease;"></div>
                    </div>
                    <p style="font-size:10px;color:#9CA3AF;margin-top:4px;font-weight:500;">
                        Min: {{ $product->min_stock }} {{ $product->unit->abbreviation }}
                    </p>
                </div>
                @endforeach
            @else
                <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;height:160px;text-align:center;">
                    <div style="width:44px;height:44px;background:#ECFDF5;border-radius:50%;display:flex;align-items:center;justify-content:center;margin-bottom:12px;">
                        <svg width="20" height="20" fill="none" stroke="#10B981" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                    </div>
                    <p style="font-size:13px;font-weight:700;color:#374151;margin:0;">Semua stok aman</p>
                    <p style="font-size:11px;color:#9CA3AF;margin-top:4px;">Tidak ada produk menipis</p>
                </div>
            @endif
        </div>
    </div>

</div>

{{-- Recent Transactions --}}
<div style="
    background:#fff;border-radius:14px;border:1px solid #E5E7EB;
    box-shadow:0 1px 3px rgba(0,0,0,0.04);
    overflow:hidden;
    animation: fadeUp 0.4s ease 0.42s both;
">
    <div style="padding:20px 24px 16px;border-bottom:1px solid #F3F4F6;display:flex;align-items:center;justify-content:space-between;">
        <div>
            <h2 style="font-size:15px;font-weight:700;color:#111827;margin:0;">Transaksi Terbaru</h2>
            <p style="font-size:12px;color:#9CA3AF;margin-top:3px;font-weight:500;">Hari ini</p>
        </div>
        <a href="{{ route('pos.sales') }}" style="font-size:12px;font-weight:700;color:#6366F1;text-decoration:none;display:flex;align-items:center;gap:4px;transition:opacity 0.15s;"
           onmouseover="this.style.opacity='.7'" onmouseout="this.style.opacity='1'">
            Lihat semua
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
        </a>
    </div>

    <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="background:#F9FAFB;">
                    <th style="padding:11px 24px;text-align:left;font-size:11px;font-weight:700;color:#6B7280;letter-spacing:0.5px;text-transform:uppercase;white-space:nowrap;">Invoice</th>
                    <th style="padding:11px 16px;text-align:left;font-size:11px;font-weight:700;color:#6B7280;letter-spacing:0.5px;text-transform:uppercase;">Kasir</th>
                    <th style="padding:11px 16px;text-align:left;font-size:11px;font-weight:700;color:#6B7280;letter-spacing:0.5px;text-transform:uppercase;">Waktu</th>
                    <th style="padding:11px 16px;text-align:left;font-size:11px;font-weight:700;color:#6B7280;letter-spacing:0.5px;text-transform:uppercase;">Pembayaran</th>
                    <th style="padding:11px 24px;text-align:right;font-size:11px;font-weight:700;color:#6B7280;letter-spacing:0.5px;text-transform:uppercase;">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentSales as $sale)
                <tr style="border-top:1px solid #F3F4F6;transition:background 0.12s;"
                    onmouseover="this.style.background='#FAFAFA'" onmouseout="this.style.background='transparent'">
                    <td style="padding:13px 24px;">
                        <span style="font-family:'DM Mono',monospace;font-size:11px;font-weight:500;color:#6366F1;letter-spacing:-0.2px;">
                            {{ $sale->invoice_no }}
                        </span>
                    </td>
                    <td style="padding:13px 16px;font-size:13px;font-weight:600;color:#374151;">
                        {{ $sale->user->name }}
                    </td>
                    <td style="padding:13px 16px;font-size:12px;color:#9CA3AF;font-weight:500;">
                        {{ $sale->created_at->format('H:i') }}
                    </td>
                    <td style="padding:13px 16px;">
                        @php
                            $method = strtolower($sale->payment_method);
                            $pmColor = $method === 'cash' ? ['#065F46','#D1FAE5'] : ['#1E40AF','#DBEAFE'];
                        @endphp
                        <span style="font-size:10px;font-weight:700;padding:3px 10px;border-radius:20px;background:{{ $pmColor[1] }};color:{{ $pmColor[0] }};text-transform:uppercase;letter-spacing:0.5px;">
                            {{ $sale->payment_method }}
                        </span>
                    </td>
                    <td style="padding:13px 24px;text-align:right;font-size:14px;font-weight:800;color:#111827;">
                        Rp {{ number_format($sale->grand_total, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding:48px 24px;text-align:center;">
                        <div style="display:flex;flex-direction:column;align-items:center;gap:8px;">
                            <div style="width:40px;height:40px;background:#F3F4F6;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                <svg width="18" height="18" fill="none" stroke="#D1D5DB" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            </div>
                            <p style="font-size:13px;font-weight:600;color:#9CA3AF;margin:0;">Belum ada transaksi hari ini</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
}
/* Tailwind grid override for stat cards */
@media (min-width: 1024px) {
    .lg-4col { grid-template-columns: repeat(4, 1fr) !important; }
    .lg-3col { grid-template-columns: repeat(3, 1fr) !important; }
    .lg-span2 { grid-column: span 2; }
}
</style>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('salesChart');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');

    const grad = ctx.createLinearGradient(0, 0, 0, 210);
    grad.addColorStop(0, 'rgba(99,102,241,0.15)');
    grad.addColorStop(1, 'rgba(99,102,241,0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                data: {!! json_encode(array_map('floatval', $chartData)) !!},
                borderColor: '#6366F1',
                backgroundColor: grad,
                borderWidth: 2,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#6366F1',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                pointHoverBackgroundColor: '#6366F1',
                fill: true,
                tension: 0.4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#111827',
                    titleColor: '#9CA3AF',
                    bodyColor: '#F9FAFB',
                    padding: 12,
                    cornerRadius: 8,
                    displayColors: false,
                    callbacks: {
                        label: ctx => 'Rp ' + ctx.parsed.y.toLocaleString('id-ID')
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    border: { display: false },
                    ticks: { color: '#9CA3AF', font: { size: 11, weight: '600', family: 'Plus Jakarta Sans' } }
                },
                y: {
                    grid: { color: '#F3F4F6' },
                    border: { display: false },
                    ticks: {
                        color: '#9CA3AF',
                        font: { size: 11, weight: '600', family: 'Plus Jakarta Sans' },
                        callback: val => 'Rp ' + (val >= 1000000
                            ? (val/1000000).toFixed(1) + 'jt'
                            : val.toLocaleString('id-ID'))
                    }
                }
            }
        }
    });
});
</script>
@endpush