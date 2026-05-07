<?php

namespace App\Livewire\PurchaseOrders;

use App\Models\PurchaseOrder;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterStatus = '';

    public function updatingSearch() { $this->resetPage(); }
    public function updatingFilterStatus() { $this->resetPage(); }

    public function render()
    {
        return view('livewire.purchase-orders.index', [
            'purchases' => PurchaseOrder::with(['supplier', 'user'])
                ->when($this->search, fn($q) => $q
                    ->where('po_number', 'like', "%{$this->search}%")
                    ->orWhereHas('supplier', fn($q) => $q->where('name', 'like', "%{$this->search}%")))
                ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus))
                ->latest()
                ->paginate(10)
        ]);
    }
}