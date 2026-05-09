<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderApiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'items'         => 'required|array|min:1',
            'items.*.id'    => 'required|integer|exists:products,id',
            'items.*.qty'   => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'grand_total'   => 'required|numeric|min:0',
            'customer_name' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Cek stok semua produk dulu
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['id']);
                if ($product->stock < $item['qty']) {
                    DB::rollBack();
                    return response()->json([
                        'error' => "Stok {$product->name} tidak cukup. Tersisa: {$product->stock}"
                    ], 422);
                }
            }

            // Buat sale
          $sale = Sale::create([
    'user_id'        => $request->user_id ?? 1,
    'invoice_no'     => 'INV-ECOM-' . strtoupper(\Illuminate\Support\Str::random(8)),
    'date'           => now()->toDateString(),
    'total'          => $request->grand_total,
    'discount'       => 0,
    'grand_total'    => $request->grand_total,
    'payment_method' => $request->payment_method ?? 'transfer',
    'amount_paid'    => $request->grand_total,
    'change'         => 0,
    'status'         => 'completed',
    'notes'          => 'Order dari Ecommerce - ' . ($request->customer_name ?? 'Guest'),
]);

            // Buat sale items & kurangi stok
            foreach ($request->items as $item) {
                SaleItem::create([
    'sale_id'    => $sale->id,
    'product_id' => $item['id'],
    'qty'        => $item['qty'],
    'price'      => $item['price'],
    'subtotal'   => $item['qty'] * $item['price'], // tambahkan ini
]);
                // Kurangi stok
                Product::where('id', $item['id'])
                    ->decrement('stock', $item['qty']);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'sale_id' => $sale->id,
                'message' => 'Order berhasil dicatat di POS'
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Gagal mencatat order: ' . $e->getMessage()
            ], 500);
        }
    }
}