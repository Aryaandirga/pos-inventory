<?php

namespace App\Livewire\Units;

use App\Models\Unit;
use Livewire\Component;

class Create extends Component
{
    public string $name = '';
    public string $abbreviation = '';

    protected $rules = [
        'name'         => 'required|min:2|unique:units,name',
        'abbreviation' => 'required|unique:units,abbreviation',
    ];

    public function save()
    {
        $this->validate();
        Unit::create([
            'name'         => $this->name,
            'abbreviation' => $this->abbreviation,
        ]);
        session()->flash('success', 'Satuan berhasil ditambahkan!');
        return redirect()->route('units.index');
    }

    public function render()
    {
        return view('livewire.units.create');
    }
}