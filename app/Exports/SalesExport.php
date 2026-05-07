<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SalesExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    ShouldAutoSize
{
    protected string $dateFrom;
    protected string $dateTo;
    protected string $filterPayment;

    public function __construct(string $dateFrom, string $dateTo, string $filterPayment = '')
    {
        $this->dateFrom      = $dateFrom;
        $this->dateTo        = $dateTo;
        $this->filterPayment = $filterPayment;
    }

    public function collection()
    {
        return Sale::with(['user', 'items'])
            ->when($this->dateFrom, fn($q) => $q->whereDate('date', '>=', $this->dateFrom))
            ->when($this->dateTo,   fn($q) => $q->whereDate('date', '<=', $this->dateTo))
            ->when($this->filterPayment, fn($q) => $q->where('payment_method', $this->filterPayment))
            ->where('status', 'completed')
            ->latest()
            ->get();
    }

    public function headings(): array
    {
        return [
            'No. Invoice',
            'Tanggal',
            'Kasir',
            'Total Item',
            'Metode Bayar',
            'Subtotal',
            'Diskon',
            'Total',
            'Bayar',
            'Kembalian',
        ];
    }

    public function map($sale): array
    {
        return [
            $sale->invoice_no,
            \Carbon\Carbon::parse($sale->date)->format('d/m/Y'),
            $sale->user->name,
            $sale->items->count(),
            strtoupper($sale->payment_method),
            $sale->total,
            $sale->discount,
            $sale->grand_total,
            $sale->amount_paid,
            $sale->change,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill'      => ['fillType' => 'solid', 'startColor' => ['rgb' => '6366F1']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }
}