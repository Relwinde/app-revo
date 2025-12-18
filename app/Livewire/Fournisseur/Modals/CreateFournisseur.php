<?php

namespace App\Livewire\Fournisseur\Modals;

use App\Models\Fournisseur;
use Illuminate\Support\Facades\DB;
use LivewireUI\Modal\ModalComponent;

class CreateFournisseur extends ModalComponent
{
    public $name;
    public $email;
    public $phone;
    public $address;
    public $rccm;
    public $ifu;

    public function render()
    {
        return view('livewire.fournisseur.modals.create-fournisseur');
    }

    public function create()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255', 'unique:fournisseurs,name'],
            'email' => ['nullable', 'email', 'unique:fournisseurs,email'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string'],
            'rccm' => ['nullable', 'unique:fournisseurs,rccm'],
            'ifu' => ['nullable', 'unique:fournisseurs,ifu'],
        ]);

        try {
            DB::beginTransaction();

            Fournisseur::create([
                'name' => mb_strtoupper($this->name, 'UTF-8'),
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'rccm' => $this->rccm,
                'ifu' => $this->ifu,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('error');
            return;
        }

        $this->dispatch('fournisseur-created');
        $this->closeModal();
        $this->reset();
    }
}
