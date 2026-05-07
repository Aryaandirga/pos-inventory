<?php

namespace App\Livewire\PurchaseOrders;

use App\Models\PurchaseOrder;
use Livewire\Component;

class Show extends Component
{
    public PurchaseOrder $purchaseOrder;
    public bool $showReceiveModal = false;

    public function mount(PurchaseOrder $purchaseOrder)
    {
        $this->purchaseOrder = $purchaseOrder;
    }

    public function receive()
    {
        if ($this->purchaseOrder->status !== 'pending') return;

        // Update stok setiap produk
        foreach ($this->purchaseOrder->items as $item) {
            $item->product->increment('stock', $item->qty);
        }

        $this->purchaseOrder->update(['status' => 'received']);
        $this->showReceiveModal = false;
        session()->flash('success', 'Barang berhasil diterima! Stok telah diupdate.');
    }

    public function cancel()
    {
        if ($this->purchaseOrder->status !== 'pending') return;
        $this->purchaseOrder->update(['status' => 'cancelled']);
        session()->flash('success', 'Purchase Order dibatalkan.');
        return redirect()->route('purchases.index');
    }

    public function render()
    {
        return view('livewire.purchase-orders.show', [
            'purchaseOrder' => $this->purchaseOrder->load('items.product.unit', 'supplier', 'user')
        ]);
    }
}