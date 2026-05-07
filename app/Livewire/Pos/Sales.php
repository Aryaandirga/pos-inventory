<?php

namespace App\Livewire\Pos;

use App\Models\Sale;
use Livewire\Component;
use Livewire\WithPagination;

class Sales extends Component
{
    use WithPagination;

    public string $search      = '';
    public string $dateFrom    = '';
    public string $dateTo      = '';
    public bool   $showDetail  = false;
    public ?int   $selectedId  = null;

    public function mount()
    {
        $this->dateFrom = now()->startOfMonth()->format('Y-m-d');
        $this->dateTo   = now()->format('Y-m-d');
    }

    public function updatingSearch()  { $this->resetPage(); }
    public function updatingDateFrom(){ $this->resetPage(); }
    public function updatingDateTo()  { $this->resetPage(); }

    public function showDetail(int $id)
    {
        $this->selectedId = $id;
        $this->showDetail = true;
    }

    public function render()
    {
        return view('livewire.pos.sales', [
            'sales' => Sale::with(['user', 'items.product'])
                ->when($this->search, fn($q) => $q->where('invoice_no', 'like', "%{$this->search}%"))
                ->when($this->dateFrom, fn($q) => $q->whereDate('date', '>=', $this->dateFrom))
                ->when($this->dateTo,   fn($q) => $q->whereDate('date', '<=', $this->dateTo))
                ->latest()
                ->paginate(10),
            'selectedSale' => $this->selectedId
                ? Sale::with('items.product.unit', 'user')->find($this->selectedId)
                : null,
        ])->layout('layouts.app', ['title' => 'Riwayat Penjualan']);
    }
}