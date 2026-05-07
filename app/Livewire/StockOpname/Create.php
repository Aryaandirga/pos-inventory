<?php

namespace App\Livewire\StockOpname;

use App\Models\Product;
use App\Models\StockAdjustment;
use Livewire\Component;

class Create extends Component
{
    public string $product_id  = '';
    public string $type        = 'adjustment';
    public int    $qty         = 0;
    public string $notes       = '';
    public string $date        = '';

    // Info produk yang dipilih
    public ?int   $currentStock = null;
    public string $productName  = '';
    public string $productUnit  = '';

    public function mount()
    {
        $this->date = now()->format('Y-m-d');
    }

    public function updatedProductId($value)
    {
        if ($value) {
            $product = Product::with('unit')->find($value);
            if ($product) {
                $this->currentStock = $product->stock;
                $this->productName  = $product->name;
                $this->productUnit  = $product->unit->abbreviation ?? '';
                $this->qty          = $product->stock; // default qty = stok sekarang
            }
        } else {
            $this->currentStock = null;
            $this->productName  = '';
            $this->productUnit  = '';
        }
    }

    public function getNewStock(): int
    {
        if ($this->currentStock === null) return 0;

        return match($this->type) {
            'in'         => $this->currentStock + $this->qty,
            'out'        => max(0, $this->currentStock - $this->qty),
            'adjustment' => $this->qty,
            default      => $this->currentStock,
        };
    }

    public function getStockDiff(): int
    {
        if ($this->currentStock === null) return 0;

        return match($this->type) {
            'in'         => $this->qty,
            'out'        => -$this->qty,
            'adjustment' => $this->qty - $this->currentStock,
            default      => 0,
        };
    }

    protected $rules = [
        'product_id' => 'required|exists:products,id',
        'type'       => 'required|in:in,out,adjustment',
        'qty'        => 'required|integer|min:0',
        'notes'      => 'required|min:3',
        'date'       => 'required|date',
    ];

    public function save()
    {
        $this->validate();

        $product = Product::findOrFail($this->product_id);

        // Hitung qty yang disimpan ke stock_adjustments
        $adjustQty = match($this->type) {
            'in'         => $this->qty,
            'out'        => $this->qty,
            'adjustment' => abs($this->qty - $product->stock),
        };

        // Update stok produk
        $newStock = match($this->type) {
            'in'         => $product->stock + $this->qty,
            'out'        => max(0, $product->stock - $this->qty),
            'adjustment' => $this->qty,
        };

        $product->update(['stock' => $newStock]);

        // Simpan record adjustment
        StockAdjustment::create([
            'product_id' => $this->product_id,
            'user_id'    => auth()->id(),
            'type'       => $this->type,
            'qty'        => $adjustQty,
            'notes'      => $this->notes,
            'date'       => $this->date,
        ]);

        session()->flash('success', 'Stock opname berhasil disimpan! Stok ' . $product->name . ' diupdate menjadi ' . $newStock . ' ' . $product->unit->abbreviation);
        return redirect()->route('stock-opname.index');
    }

    public function render()
    {
        return view('livewire.stock-opname.create', [
            'products' => Product::with('unit')->where('is_active', true)->orderBy('name')->get(),
        ]);
    }
}