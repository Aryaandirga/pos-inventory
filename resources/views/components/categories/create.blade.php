<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Livewire\Component;

class Create extends Component
{
    public string $name = '';
    public string $description = '';

    protected $rules = [
        'name'        => 'required|min:2|unique:categories,name',
        'description' => 'nullable',
    ];

    public function save()
    {
        $this->validate();

        Category::create([
            'name'        => $this->name,
            'description' => $this->description,
        ]);

        session()->flash('success', 'Kategori berhasil ditambahkan!');
        return redirect()->route('categories.index');
    }

    public function render()
    {
        return view('livewire.categories.create')
            ->layout('layouts.app', ['title' => 'Tambah Kategori']);
    }
}