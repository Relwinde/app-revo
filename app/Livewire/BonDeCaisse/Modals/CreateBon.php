<?php

namespace App\Livewire\BonDeCaisse\Modals;

use App\Models\Camion;
use App\Models\Dossier;
use App\Models\BonDeCaisse;
use Illuminate\Support\Facades\DB;
use LivewireUI\Modal\ModalComponent;

class CreateBon extends ModalComponent
{
    public $bon_item = null;
    public $depense;
    public $montant;
    public $description;
    public $camion_id;
    public $dossier_id;

    public function render()
    {
        $dossiers = Dossier::all();
        $camions = Camion::all();

        return view('livewire.bon-de-caisse.modals.create-bon', ['dossiers' => $dossiers, 'camions' => $camions]);
    }

    public function create (){
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

        $bon = BonDeCaisse::make([
            'montant' => $this->montant,
            'montant_definitif' => $this->montant,
            'depense' => $this->depense,
            'description' => $this->description,
            'camion_id' => $this->camion_id,
            'dossier_id' => $this->dossier_id,
            'user_id' => auth()->id(),
        ]);
        if(BonDeCaisse::latest()->first()==null){
            $bon->numero= date('Y').date('m').date('d').date('H').date('i').date('s').'0000001';
        }else {
            $bon->numero= date('Y').date('m').date('d').date('H').date('i').date('s').str_pad(BonDeCaisse::latest()->first()->id+1, 7, '0', STR_PAD_LEFT);
        }

        $etapeBon = $bon->etapeBons()->make([
            'etape_precedente' => 'EMETTEUR',
            'etape_actuelle' => 'EMETTEUR',
            'montant' => $this->montant,
            'user_id' => auth()->id(),
        ]);

        try{
            DB::beginTransaction();
            $bon->save();
            $etapeBon->bon_de_caisse_id = $bon->id;
            $etapeBon->save();
            DB::commit();
            $this->dispatch('bon-created');
            $this->closeModal();
        }
        catch(\Exception $e){
            throw $e;
            DB::rollBack();
            return;
        }
        
    }
}
