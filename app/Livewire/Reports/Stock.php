<?php

namespace App\Livewire\Reports;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Stock extends Component
{
    use WithPagination;

    public string $search        = '';
    public string $filterCategory = '';
    public string $filterStock   = '';

    public function updatingSearch()        { $this->resetPage(); }
    public function updatingFilterCategory() { $this->resetPage(); }
    public function updatingFilterStock()   { $this->resetPage(); }

    public function render()
{
    $products = Product::with(['category', 'unit'])
        ->when($this->search, function($query) {
            $searchTerm = strtolower($this->search);
            // Gunakan grouping where (function($q)...) agar filter search tidak merusak filter kategori/stok
            $query->where(function($q) use ($searchTerm) {
                $q->whereRaw('LOWER(name) LIKE ?', ["%{$searchTerm}%"])
                  ->orWhere('sku', 'like', "%{$this->search}%");
            });
        })
        ->when($this->filterCategory, fn($q) => $q->where('category_id', $this->filterCategory))
        ->when($this->filterStock === 'low', fn($q) => $q->whereColumn('stock', '<=', 'min_stock'))
        ->when($this->filterStock === 'out', fn($q) => $q->where('stock', 0))
        ->when($this->filterStock === 'safe', fn($q) => $q->whereColumn('stock', '>', 'min_stock'))
        ->latest()
        ->paginate(15);

    return view('livewire.reports.stock', [
        'products'      => $products,
        'categories'    => \App\Models\Category::all(),
        'totalProducts' => Product::count(),
        'lowStock'      => Product::whereColumn('stock', '<=', 'min_stock')->count(),
        'outOfStock'    => Product::where('stock', 0)->count(),
        'totalValue'    => Product::selectRaw('SUM(stock * cost_price) as total')->value('total'),
    ])->layout('layouts.app', ['title' => 'Laporan Stok']);
}
}