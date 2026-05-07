<?php

namespace App\Livewire\Reports;

use App\Models\Sale;
use Livewire\Component;
use Livewire\WithPagination;

class Sales extends Component
{
    use WithPagination;

    public string $dateFrom  = '';
    public string $dateTo    = '';
    public string $filterPayment = '';

    public function mount()
    {
        $this->dateFrom = now()->startOfMonth()->format('Y-m-d');
        $this->dateTo   = now()->format('Y-m-d');
    }

    public function updatingDateFrom()  { $this->resetPage(); }
    public function updatingDateTo()    { $this->resetPage(); }
    public function updatingFilterPayment() { $this->resetPage(); }

    public function getSalesQuery()
    {
        return Sale::with(['user', 'items'])
            ->when($this->dateFrom, fn($q) => $q->whereDate('date', '>=', $this->dateFrom))
            ->when($this->dateTo,   fn($q) => $q->whereDate('date', '<=', $this->dateTo))
            ->when($this->filterPayment, fn($q) => $q->where('payment_method', $this->filterPayment))
            ->where('status', 'completed')
            ->latest();
    }

    public function render()
    {
        $query = $this->getSalesQuery();

        return view('livewire.reports.sales', [
            'sales'        => $query->paginate(15),
            'totalRevenue' => $query->sum('grand_total'),
            'totalTrx'     => $query->count(),
            'totalDiscount'=> $query->sum('discount'),
        ])->layout('layouts.app', ['title' => 'Laporan Penjualan']);
    }
}