<?php

namespace App\Livewire\Users;

use App\Models\User;
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
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }

        // Jangan hapus diri sendiri
        if ($id === auth()->id()) {
            session()->flash('error', 'Tidak bisa menghapus akun sendiri!');

            return;
        }
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        User::findOrFail($this->deleteId)->delete();
        $this->showDeleteModal = false;
        $this->deleteId = null;
        session()->flash('success', 'User berhasil dihapus!');
    }

    public function render()
    {
        return view('livewire.users.index', [
            'users' => User::with('roles')
                ->when($this->search, fn ($q) => $q
                    ->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%"))
                ->latest()
                ->paginate(10),
        ]);
    }
}
