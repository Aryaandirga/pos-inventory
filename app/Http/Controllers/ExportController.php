<?php

namespace App\Http\Controllers;

use App\Exports\SalesExport;
use App\Exports\StockExport;
use App\Models\Sale;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    // ===== SALES EXCEL =====
    public function salesExcel(string $dateFrom, string $dateTo, string $payment = '')
    {
        $filename = 'laporan-penjualan-' . $dateFrom . '-sd-' . $dateTo . '.xlsx';
        return Excel::download(new SalesExport($dateFrom, $dateTo, $payment), $filename);
    }

    // ===== SALES PDF =====
    public function salesPdf(string $dateFrom, string $dateTo, string $payment = '')
    {
        $sales = Sale::with(['user', 'items'])
            ->when($dateFrom, fn($q) => $q->whereDate('date', '>=', $dateFrom))
            ->when($dateTo,   fn($q) => $q->whereDate('date', '<=', $dateTo))
            ->when($payment,  fn($q) => $q->where('payment_method', $payment))
            ->where('status', 'completed')
            ->latest()
            ->get();

        $totalRevenue  = $sales->sum('grand_total');
        $totalDiscount = $sales->sum('discount');
        $totalTrx      = $sales->count();

        $pdf = Pdf::loadView('exports.sales-pdf', compact(
            'sales', 'totalRevenue', 'totalDiscount', 'totalTrx',
            'dateFrom', 'dateTo'
        ))->setPaper('a4', 'landscape');

        return $pdf->download('laporan-penjualan-' . $dateFrom . '-sd-' . $dateTo . '.pdf');
    }

    // ===== STOCK EXCEL =====
    public function stockExcel()
    {
        $filename = 'laporan-stok-' . now()->format('d-m-Y') . '.xlsx';
        return Excel::download(new StockExport(), $filename);
    }

    // ===== STOCK PDF =====
    public function stockPdf()
    {
        $products   = Product::with(['category', 'unit'])->latest()->get();
        $totalValue = $products->sum(fn($p) => $p->stock * $p->cost_price);

        $pdf = Pdf::loadView('exports.stock-pdf', compact('products', 'totalValue'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-stok-' . now()->format('d-m-Y') . '.pdf');
    }
}