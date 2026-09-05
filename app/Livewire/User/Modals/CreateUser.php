<?php

namespace App\Livewire\User\Modals;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use LivewireUI\Modal\ModalComponent;

class CreateUser extends ModalComponent
{
    public $name;
    public $email;
    public $profile;

    public function render()
    {
        $profiles = Role::all(['id', 'name']);
        return view('livewire.user.modals.create-user', ['profiles' => $profiles]);
    }

    public function create (){

        abort_unless(auth()->user()->can('Créer Utilisateur'), 403);

        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'profile' => 'required|string',
        ], [
            'name.required' => 'Le nom est obligatoire.',
            'email.required' => "L'email est obligatoire.",
            'email.email' => "L'email doit être une adresse email valide.",
            'email.unique' => "Cet email est déjà utilisé.",
            'profile.required' => 'Le profil est obligatoire.',
        ]);

        $user = User::make([
            'name' => $this->name,
            'email' => $this->email,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        try{
            DB::beginTransaction();

            $user->save();
            $user->syncRoles(Role::findById($this->profile));

            DB::commit();
            $this->dispatch('user-created');
            $this->reset();
            $this->closeModal();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('error');
        }
        
        
    }
}
