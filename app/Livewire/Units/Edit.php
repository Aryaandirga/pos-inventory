<?php

namespace App\Livewire\Units;

use App\Models\Unit;
use Livewire\Component;

class Edit extends Component
{
    public Unit $unit;
    public string $name = '';
    public string $abbreviation = '';

    public function mount(Unit $unit)
    {
        $this->unit         = $unit;
        $this->name         = $unit->name;
        $this->abbreviation = $unit->abbreviation;
    }

    protected function rules()
    {
        return [
            'name'         => 'required|min:2|unique:units,name,' . $this->unit->id,
            'abbreviation' => 'required|unique:units,abbreviation,' . $this->unit->id,
        ];
    }

    public function save()
    {
        $this->validate();
        $this->unit->update([
            'name'         => $this->name,
            'abbreviation' => $this->abbreviation,
        ]);
        session()->flash('success', 'Satuan berhasil diupdate!');
        return redirect()->route('units.index');
    }

    public function render()
    {
        return view('livewire.units.edit');
    }
}