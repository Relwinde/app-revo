<?php

namespace App\Livewire\User\Modals;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use LivewireUI\Modal\ModalComponent;

class CreateUser extends ModalComponent
{
    public $name;
    public $email;
    public $password;

    public function render()
    {
        return view('livewire.user.modals.create-user');
    }

    public function create()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
        ], [
            'name.required' => 'Le nom est obligatoire.',
            'email.required' => "L'email est obligatoire.",
            'email.email' => "L'email doit être une adresse email valide.",
            'email.unique' => "Cet email est déjà utilisé.",
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
        ]);

        try {
            DB::beginTransaction();

            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);

            DB::commit();

            $this->dispatch('user-created');
            $this->reset();

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('error');
        }
    }
}
