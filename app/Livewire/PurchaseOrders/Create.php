<?php

namespace App\Livewire\PurchaseOrders;

use App\Models\PurchaseOrder;
use App\Models\PurchaseItem;
use App\Models\Product;
use App\Models\Supplier;
use Livewire\Component;

class Create extends Component
{
    public string $supplier_id = '';
    public string $date = '';
    public string $notes = '';
    public array $items = [];

    public function mount()
    {
        $this->date = now()->format('Y-m-d');
        $this->addItem();
    }

    public function addItem()
    {
        $this->items[] = [
            'product_id' => '',
            'qty'        => 1,
            'price'      => 0,
            'subtotal'   => 0,
        ];
    }

    public function removeItem(int $index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function updatedItems($value, $key)
    {
        $parts = explode('.', $key);
        $index = $parts[0];

        // Auto-fill harga modal saat produk dipilih
        if (isset($parts[1]) && $parts[1] === 'product_id' && $value) {
            $product = Product::find($value);
            if ($product) {
                $this->items[$index]['price'] = $product->cost_price;
                $this->items[$index]['subtotal'] = $product->cost_price * $this->items[$index]['qty'];
            }
        }

        // Hitung subtotal
        if (isset($parts[1]) && in_array($parts[1], ['qty', 'price'])) {
            $qty   = $this->items[$index]['qty'] ?? 0;
            $price = $this->items[$index]['price'] ?? 0;
            $this->items[$index]['subtotal'] = $qty * $price;
        }
    }

    public function getTotal(): float
    {
        return collect($this->items)->sum('subtotal');
    }

    public function save()
    {
        $this->validate([
            'supplier_id'      => 'required|exists:suppliers,id',
            'date'             => 'required|date',
            'items'            => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty'      => 'required|integer|min:1',
            'items.*.price'    => 'required|numeric|min:0',
        ]);

        // Generate PO Number
        $poNumber = 'PO-' . now()->format('Ymd') . '-' . strtoupper(uniqid());

        $po = PurchaseOrder::create([
            'supplier_id' => $this->supplier_id,
            'user_id'     => auth()->id(),
            'po_number'   => $poNumber,
            'date'        => $this->date,
            'status'      => 'pending',
            'total'       => $this->getTotal(),
            'notes'       => $this->notes,
        ]);

        foreach ($this->items as $item) {
            PurchaseItem::create([
                'purchase_order_id' => $po->id,
                'product_id'        => $item['product_id'],
                'qty'               => $item['qty'],
                'price'             => $item['price'],
                'subtotal'          => $item['subtotal'],
            ]);
        }

        session()->flash('success', 'Purchase Order berhasil dibuat!');
        return redirect()->route('purchases.index');
    }

    public function render()
    {
        return view('livewire.purchase-orders.create', [
            'suppliers' => Supplier::all(),
            'products'  => Product::where('is_active', true)->with('unit')->get(),
        ]);
    }
}