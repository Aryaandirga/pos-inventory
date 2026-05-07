<?php

namespace App\Livewire\Suppliers;

use App\Models\Supplier;
use Livewire\Component;

class Create extends Component
{
    public string $name    = '';
    public string $phone   = '';
    public string $email   = '';
    public string $address = '';

    protected $rules = [
        'name'    => 'required|min:2',
        'phone'   => 'nullable',
        'email'   => 'nullable|email',
        'address' => 'nullable',
    ];

    public function save()
    {
        $this->validate();
        Supplier::create([
            'name'    => $this->name,
            'phone'   => $this->phone,
            'email'   => $this->email,
            'address' => $this->address,
        ]);
        session()->flash('success', 'Supplier berhasil ditambahkan!');
        return redirect()->route('suppliers.index');
    }

   public function render()
{
    return view('livewire.suppliers.create');
}
}