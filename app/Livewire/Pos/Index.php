<?php

namespace App\Livewire\Pos;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Index extends Component
{
    public string $search        = '';
    public array  $cart          = [];
    public ?float  $discount      = 0;
    public string $paymentMethod = 'cash';
    public float  $amountPaid    = 0;
    public bool   $showPaymentModal = false;
    public bool   $showSuccessModal = false;
    public ?int   $lastSaleId    = null;
    public bool $showPrintModal = false;

    #[Computed]
    public function subtotal(): float
    {
        return collect($this->cart)->sum('subtotal');
    }

    #[Computed]
    public function grandTotal(): float
    {
        return max(0, $this->subtotal - ($this->discount ?? 0));
    }

    #[Computed]
    public function change(): float
    {
        return max(0, $this->amountPaid - $this->grandTotal);
    }

    public function updatedDiscount($value)
    {
    // Jika input dihapus bersih, kembalikan ke 0
    if ($value === '' || $value === null) {
        $this->discount = 0;
    }
    }

   #[Computed]
public function products()
{
    $query = Product::query()
        ->where('is_active', true)
        ->where('stock', '>', 0);

    if (!empty($this->search)) {
        $searchTerm = strtolower($this->search);
        $query->where(function($q) use ($searchTerm) {
            $q->whereRaw('LOWER(name) LIKE ?', ["%{$searchTerm}%"])
              ->orWhere('sku', 'like', "%{$this->search}%");
        });
    }

    return $query->with(['category', 'unit'])->limit(20)->get();
}

   public function addToCart(int $productId)
{
    $product = Product::find($productId);
    if (!$product || $product->stock <= 0) return;

    $key = 'product_' . $productId;

    if (isset($this->cart[$key])) {
        // Langsung panggil updateQty, biarkan updateQty yang melakukan validasi stok
        $this->updateQty($key, $this->cart[$key]['qty'] + 1);
    } else {
        $this->cart[$key] = [
            'product_id' => $product->id,
            'name'       => $product->name,
            'price'      => (float) $product->price,
            'qty'        => 1,
            'subtotal'   => (float) $product->price,
            'unit'       => $product->unit->abbreviation ?? '',
        ];
    }
}

    public function removeFromCart(string $key)
    {
        unset($this->cart[$key]);
    }

    public function updateQty($key, $qty)
{
    if (!isset($this->cart[$key])) return;

    $product = Product::find($this->cart[$key]['product_id']);
    
    // Pastikan $qty adalah integer
    $qty = (int) $qty;

    if ($qty < 1) {
        $this->removeFromCart($key);
        return;
    }

    if ($product && $qty > $product->stock) {
        $qty = $product->stock;
        session()->flash('error', "Maksimal stok: {$product->stock}");
    }

    // Update data di array
    $this->cart[$key]['qty'] = $qty;
    $this->cart[$key]['subtotal'] = (float)($this->cart[$key]['price'] * $qty);

    // Trik Livewire: Paksa refresh array agar UI mendeteksi perubahan
    $this->cart = collect($this->cart)->toArray();
}

    public function openPayment()
    {
        if (empty($this->cart)) {
            session()->flash('error', 'Keranjang masih kosong!');
            return;
        }
        $this->amountPaid = $this->grandTotal;
        $this->showPaymentModal = true;
    }

    public function processPayment()
    {
        if ($this->amountPaid < $this->grandTotal) {
            session()->flash('error', 'Jumlah bayar kurang!');
            return;
        }

        $invoiceNo = 'INV-' . now()->format('Ymd') . '-' . strtoupper(uniqid());

        $sale = Sale::create([
            'user_id'        => auth()->id(),
            'invoice_no'     => $invoiceNo,
            'date'           => now()->toDateString(),
            'total'          => $this->subtotal,
            'discount'       => $this->discount,
            'grand_total'    => $this->grandTotal,
            'payment_method' => $this->paymentMethod,
            'amount_paid'    => $this->amountPaid,
            'change'         => $this->change,
            'status'         => 'completed',
        ]);

        foreach ($this->cart as $item) {
            SaleItem::create([
                'sale_id'    => $sale->id,
                'product_id' => $item['product_id'],
                'qty'        => $item['qty'],
                'price'      => $item['price'],
                'subtotal'   => $item['subtotal'],
            ]);

            Product::find($item['product_id'])->decrement('stock', $item['qty']);
        }

        $this->lastSaleId       = $sale->id;
        $this->cart             = [];
        $this->discount         = 0;
        $this->amountPaid       = 0;
        $this->showPaymentModal = false;
        $this->showSuccessModal = true;
    }

    public function closeSuccess()
    {
        $this->showSuccessModal = false;
        $this->lastSaleId       = null;
    }

  public function render()
{
    return view('livewire.pos.index', [
        'products' => $this->products, // ← tambah ini
        'lastSale' => $this->lastSaleId
            ? Sale::with('items.product')->find($this->lastSaleId)
            : null,
    ])->layout('layouts.app', ['title' => 'POS / Kasir']);
}

   
    public function printReceipt()
{
    $this->showPrintModal = true;
}

public function closePrint()
{
    $this->showPrintModal   = false;
    $this->showSuccessModal = false;
    $this->lastSaleId       = null;
}
}