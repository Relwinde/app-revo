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
    public $div_fisc;

    public function render()
    {
        return view('livewire.fournisseur.modals.create-fournisseur');
    }

    public function create()
    {
        abort_unless(auth()->user()->can('Créer Fournisseur'), 403);

        $this->validate([
            'name' => ['required', 'string', 'max:255', 'unique:fournisseurs,name'],
            'email' => ['nullable', 'email', 'unique:fournisseurs,email'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string'],
            'div_fisc' => ['nullable', 'string'],
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
                'div_fisc'=>$this->div_fisc
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('error');
            return $e;
        }

        $this->dispatch('fournisseur-created');
        $this->closeModal();
        $this->reset();
    }
}
