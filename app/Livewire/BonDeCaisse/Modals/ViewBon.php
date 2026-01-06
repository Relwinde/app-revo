<?php

namespace App\Livewire\BonDeCaisse\Modals;

use App\Models\Camion;
use App\Models\Dossier;
use App\Models\BonDeCaisse;
use LivewireUI\Modal\ModalComponent;

class ViewBon extends ModalComponent
{

    public BonDeCaisse $bon;
    public $depense; 
    public $montant;
    public $description;
    public $camion_id;
    public $dossier_id;
    
    public $editMode = false;


    public function mount (){
        $this->depense = $this->bon->depense;
        $this->montant = $this->bon->montant;
        $this->description = $this->bon->description;
        $this->camion_id = $this->bon->camion_id;
        $this->dossier_id = $this->bon->dossier_id;
    }

    public function render()
    {
        $dossiers = Dossier::all();
        $camions = Camion::all();
        return view('livewire.bon-de-caisse.modals.view-bon', ['dossiers' => $dossiers, 'camions' => $camions]);
    }

    public function update (){
        $this->validate([
            'montant' => 'required|numeric',
            'depense' => 'required|string',
            'description' => 'nullable|string',
        ], [
            'montant.required' => 'Le montant est obligatoire.',
            'montant.numeric' => 'Le montant doit être un nombre.',
            'depense.required' => 'La dépense est obligatoire.',
            'depense.string' => 'La dépense doit être une chaîne de caractères.',
            'description.string' => 'La description doit être une chaîne de caractères.',
        ]);

        $this->bon->update([
            'montant' => $this->montant,
            'depense' => $this->depense,
            'description' => $this->description,
        ]);

        $this->dispatch('bon-updated');
        $this->closeModal();
        $this->reset();
    }

    public function toggleEditMode ()
    {
        $this->editMode = ! $this->editMode;
    }


}
