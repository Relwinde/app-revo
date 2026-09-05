<?php

namespace App\Livewire\Chauffeur\Modals;

use App\Models\Chauffeur;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Facades\DB;

class CreateChauffeur extends ModalComponent
{
    public $name;
    public $email;
    public $phone;
    public $address;
    public $ref_identite;

    // Reference CNIB or Passport can be added if needed in the future

    public function render()
    {
        return view('livewire.chauffeur.modals.create-chauffeur');
    }

    public function create()
    {
        abort_unless(auth()->user()->can('Créer Chauffeur'), 403);

        $this->validate([
            'name' => 'required|string|max:255|unique:chauffeurs,name',
            'email' => 'nullable|email|unique:chauffeurs,email',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
        ], [
            'name.required' => 'Le nom est obligatoire.',
            'name.unique' => 'Ce chauffeur existe déjà.',
            'email.email' => 'Email invalide.',
            'email.unique' => 'Email déjà utilisé.',
        ]);

        try {
            DB::beginTransaction();

            Chauffeur::create([
                'name' => mb_strtoupper($this->name, 'UTF-8'),
                'ref_identite' => mb_strtoupper($this->ref_identite, 'UTF-8'),
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('error');
            return;
        }

        $this->dispatch('chauffeur-created');
        $this->reset();
        $this->dispatch('closeModal');
    }
}
