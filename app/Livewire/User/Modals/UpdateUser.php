<?php

namespace App\Livewire\User\Modals;

use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UpdateUser extends ModalComponent
{
    public $name;
    public $email;

    public $changePassword = false;
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    public function mount()
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    public function updatedChangePassword()
    {
        if (!$this->changePassword) {
            $this->reset([
                'current_password',
                'new_password',
                'new_password_confirmation'
            ]);
        }
    }

    public function update()
    {
        $user = Auth::user();

        // Validation infos de base
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ], [
            'name.required' => "Le nom est obligatoire",
            'email.required' => "L'adresse email est obligatoire",
            'email.email' => "L'adresse email n'est pas valide",
            'email.unique' => "Cet email est déjà utilisé",
        ]);

        // Changement de mot de passe (optionnel)
        if ($this->changePassword) {
            $this->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:8|confirmed',
            ], [
                'current_password.required' => 'Le mot de passe actuel est obligatoire',
                'new_password.required' => 'Le nouveau mot de passe est obligatoire',
                'new_password.min' => 'Le mot de passe doit contenir au moins 8 caractères',
                'new_password.confirmed' => 'Les mots de passe ne correspondent pas',
            ]);

            if (!Hash::check($this->current_password, $user->password)) {
                $this->addError('current_password', 'Le mot de passe actuel est incorrect.');
                return;
            }

            $user->password = Hash::make($this->new_password);
        }

        // Mise à jour infos
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        session()->flash('success', 'Profil mis à jour avec succès.');
        $this->dispatch('closeModal');
    }

    public function render()
    {
        return view('livewire.user.modals.update-user');
    }
}
