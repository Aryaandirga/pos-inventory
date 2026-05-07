<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StockExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    ShouldAutoSize
{
    public function collection()
    {
        return Product::with(['category', 'unit'])->latest()->get();
    }

    public function headings(): array
    {
        return [
            'Nama Produk',
            'SKU',
            'Kategori',
            'Satuan',
            'Stok',
            'Min. Stok',
            'Status Stok',
            'Harga Modal',
            'Harga Jual',
            'Nilai Stok',
        ];
    }

    public function map($product): array
    {
        $stockStatus = $product->stock == 0
            ? 'Habis'
            : ($product->stock <= $product->min_stock ? 'Menipis' : 'Aman');

        return [
            $product->name,
            $product->sku,
            $product->category->name ?? '-',
            $product->unit->abbreviation ?? '-',
            $product->stock,
            $product->min_stock,
            $stockStatus,
            $product->cost_price,
            $product->price,
            $product->stock * $product->cost_price,
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