<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Edit extends Component
{
    public User $user;

    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $role = '';

    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->roles->first()?->name ?? '';
    }

    protected function rules()
    {
        return [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,'.$this->user->id,
            'password' => 'nullable|min:6',
            'role' => 'required|exists:roles,name',
        ];
    }

    public function save()
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }

        $this->validate();

        $this->user->update([
            'name' => $this->name,
            'email' => Str::lower($this->email),
            ...(($this->password) ? ['password' => Hash::make($this->password)] : []),
        ]);

        $this->user->syncRoles([$this->role]);

        session()->flash('success', 'User berhasil diupdate!');

        return redirect()->route('users.index');
    }

    public function render()
    {
        return view('livewire.users.edit', [
            'roles' => Role::all(),
        ]);
    }
}
