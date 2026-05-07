<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterCategory = '';
    public bool $showDeleteModal = false;
    public ?int $deleteId = null;

    public function updatingSearch() { $this->resetPage(); }
    public function updatingFilterCategory() { $this->resetPage(); }

    public function confirmDelete(int $id)
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
{
    $product = Product::findOrFail($this->deleteId);


        // Hapus gambar kalau ada
       if ($product->image && Storage::disk('public')->exists($product->image)) {
        Storage::disk('public')->delete($product->image);
        }

        $product->delete();
        $this->showDeleteModal = false;
        $this->deleteId = null;
        session()->flash('success', 'Produk berhasil dihapus!');
    }

   public function render()
{
    return view('livewire.products.index', [
        'products' => Product::with(['category', 'unit'])
            ->when($this->search, function($q) {
                // Kecilkan semua input pencarian
                $searchTerm = strtolower($this->search);
                
                // Bungkus dalam sub-query agar tidak merusak filter category_id
                return $q->where(function($subQuery) use ($searchTerm) {
                    $subQuery->whereRaw('LOWER(name) LIKE ?', ["%{$searchTerm}%"])
                             ->orWhere('sku', 'like', "%{$this->search}%");
                });
            })
            ->when($this->filterCategory, fn($q) => $q->where('category_id', $this->filterCategory))
            ->orderBy('name', 'asc')
            ->paginate(10),
        'categories' => \App\Models\Category::all(),
    ]);
}
}