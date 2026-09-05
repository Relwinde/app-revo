<?php

namespace App\Livewire\Profile\Modals;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use LivewireUI\Modal\ModalComponent;

class CreateProfil extends ModalComponent
{
    public $name;

    public function render()
    {
        return view('livewire.profile.modals.create-profil');
    }

    public function create(){
        abort_unless(auth()->user()->can('Créer Profil'), 403);

        $this->validate([
            'name' => 'required|unique:roles,name'
        ], [
            'name.required' => 'Le nom du profil est obligatoire.',
            'name.unique' => 'Ce nom de profil existe déjà.'
        ]);

        $role = Role::make(['name' => $this->name]);

        try {

            DB::beginTransaction();
            $role->save();
            DB::commit();
            $this->dispatch('profile-created');
            $this->closeModal();

        } catch (\Exception $e) {

            DB::rollBack();
            $this->dispatch('error');
            
        }


    }
}
