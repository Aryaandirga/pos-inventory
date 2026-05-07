<?php

namespace App\Livewire\Suppliers;

use App\Models\Supplier;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public bool $showDeleteModal = false;
    public ?int $deleteId = null;

    public function updatingSearch() { $this->resetPage(); }

    public function confirmDelete(int $id)
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        Supplier::findOrFail($this->deleteId)->delete();
        $this->showDeleteModal = false;
        $this->deleteId = null;
        session()->flash('success', 'Supplier berhasil dihapus!');
    }

    public function render()
    {
        return view('livewire.suppliers.index', [
            'suppliers' => Supplier::query()
                ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('phone', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%"))
                ->latest()
                ->paginate(10)
        ]);
    }
}