<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class Create extends Component
{
    public string $name     = '';
    public string $email    = '';
    public string $password = '';
    public string $role     = '';

    protected $rules = [
        'name'     => 'required|min:3',
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'role'     => 'required|exists:roles,name',
    ];

    public function save()
    {
        $this->validate();

        $user = User::create([
            'name'     => $this->name,
            'email'    => $this->email,
            'password' => Hash::make($this->password),
        ]);

        $user->assignRole($this->role);

        session()->flash('success', 'User berhasil ditambahkan!');
        return redirect()->route('users.index');
    }

    public function render()
    {
        return view('livewire.users.create', [
            'roles' => Role::all(),
        ]);
    }
}