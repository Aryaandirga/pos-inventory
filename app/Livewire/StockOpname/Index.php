<?php

namespace App\Livewire\StockOpname;

use App\Models\StockAdjustment;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search;
    public $filterType;
    public $dateFrom; // Properti ini yang tadi hilang
    public $dateTo;
    public function mount()
    {
        $this->dateFrom = now()->startOfMonth()->format('Y-m-d');
        $this->dateTo   = now()->format('Y-m-d');
    }

    public function updatingSearch()    { $this->resetPage(); }
    public function updatingFilterType(){ $this->resetPage(); }
    public function updatingDateFrom()  { $this->resetPage(); }
    public function updatingDateTo()    { $this->resetPage(); }

    public function render()
    {
        return view('livewire.stock-opname.index', [
            'adjustments' => StockAdjustment::with(['product', 'user'])
                ->when($this->search, fn($q) => $q->whereHas('product', fn($q) =>
                    $q->where('name', 'like', "%{$this->search}%")))
                ->when($this->filterType, fn($q) => $q->where('type', $this->filterType))
                ->when($this->dateFrom, fn($q) => $q->whereDate('date', '>=', $this->dateFrom))
                ->when($this->dateTo, fn($q) => $q->whereDate('date', '<=', $this->dateTo))
                ->latest()
                ->paginate(15),
        ]);
    }
}