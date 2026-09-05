<?php

namespace App\Livewire\Fournisseur\Modals;

use App\Models\Fournisseur;
use Exception;
use Illuminate\Support\Facades\DB;
use LivewireUI\Modal\ModalComponent;

class EditFournisseur extends ModalComponent
{

    public Fournisseur $fournisseur; 

    public $name;
    public $email;
    public $phone;
    public $address;
    public $rccm;
    public $ifu;
    public $div_fisc;


    public function mount(){
        $this->name = $this->fournisseur->name;
        $this->email = $this->fournisseur->email;
        $this->phone = $this->fournisseur->address;
        $this->rccm = $this->fournisseur->rccm; 
        $this->ifu = $this->fournisseur->ifu;
        $this->div_fisc = $this->fournisseur->div_fisc;
    }

    public function render()
    {
        return view('livewire.fournisseur.modals.edit-fournisseur');
    }

    public function save (){
        abort_unless(auth()->user()->can('Modifier Fournisseur'), 403);

        $this->validate([
            'name' => ['required', 'string', 'max:255', 'unique:fournisseurs,name,' . $this->fournisseur->id],
            'email' => ['nullable', 'email', 'unique:fournisseurs,email'. $this->fournisseur->id],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string'],
            'div_fisc' => ['nullable', 'string'],
            'rccm' => ['nullable', 'unique:fournisseurs,rccm'. $this->fournisseur->id],
            'ifu' => ['nullable', 'unique:fournisseurs,ifu'. $this->fournisseur->id],
        ]);

        try {

            DB::beginTransaction();
            $this->fournisseur->update([
                'name' => mb_strtoupper($this->name, 'UTF-8'),
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'rccm' => $this->rccm,
                'ifu' => $this->ifu,
                'div_fisc'=>$this->div_fisc
            ]);

            DB::commit();

        } catch (Exception $ex){
            DB::rollBack();
            throw $ex;
            $this->dispatch('error');
        }

        $this->dispatch('fournisseur-created');
        $this->closeModal();
        $this->reset();
    }
}
