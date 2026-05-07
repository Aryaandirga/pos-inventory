<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public bool $showDeleteModal = false;
    public ?int $deleteId = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmDelete(int $id)
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        Category::findOrFail($this->deleteId)->delete();
        $this->showDeleteModal = false;
        $this->deleteId = null;
        session()->flash('success', 'Kategori berhasil dihapus!');
    }

    public function render()
    {
        return view('livewire.categories.index', [
            'categories' => Category::query()
                ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
                ->latest()
                ->paginate(10)
        ])->layout('layouts.app', ['title' => 'Kategori']);
    }
}