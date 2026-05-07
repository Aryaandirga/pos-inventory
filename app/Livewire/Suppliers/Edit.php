<?php

namespace App\Livewire\Suppliers;

use App\Models\Supplier;
use Livewire\Component;

class Edit extends Component
{
    public Supplier $supplier;
    public string $name    = '';
    public string $phone   = '';
    public string $email   = '';
    public string $address = '';

    public function mount(Supplier $supplier)
    {
        $this->supplier = $supplier;
        $this->name     = $supplier->name;
        $this->phone    = $supplier->phone   ?? '';
        $this->email    = $supplier->email   ?? '';
        $this->address  = $supplier->address ?? '';
    }

    protected $rules = [
        'name'    => 'required|min:2',
        'phone'   => 'nullable',
        'email'   => 'nullable|email',
        'address' => 'nullable',
    ];

    public function save()
    {
        $this->validate();
        $this->supplier->update([
            'name'    => $this->name,
            'phone'   => $this->phone,
            'email'   => $this->email,
            'address' => $this->address,
        ]);
        session()->flash('success', 'Supplier berhasil diupdate!');
        return redirect()->route('suppliers.index');
    }

    public function render()
    {
        return view('livewire.suppliers.edit');
    }
}