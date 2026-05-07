<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Livewire\Component;

class Edit extends Component
{
    public Category $category;
    public string $name = '';
    public string $description = '';

    public function mount(Category $category)
    {
        $this->category    = $category;
        $this->name        = $category->name;
        $this->description = $category->description ?? '';
    }

    protected function rules()
    {
        return [
            'name'        => 'required|min:2|unique:categories,name,' . $this->category->id,
            'description' => 'nullable',
        ];
    }

    public function save()
    {
        $this->validate();

        $this->category->update([
            'name'        => $this->name,
            'description' => $this->description,
        ]);

        session()->flash('success', 'Kategori berhasil diupdate!');
        return redirect()->route('categories.index');
    }

    public function render()
    {
        return view('livewire.categories.edit')
            ->layout('layouts.app', ['title' => 'Edit Kategori']);
    }
}