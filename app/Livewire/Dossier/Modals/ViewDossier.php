<?php

namespace App\Livewire\Dossier\Modals;

use App\Models\Camion;
use App\Models\Client;
use App\Models\Dossier;
use App\Models\Chauffeur;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;
use LivewireUI\Modal\ModalComponent;

class ViewDossier extends ModalComponent
{

    public Dossier $dossier;

    public $numero;
    public $client_id;
    public $camion_id;
    public $chauffeur_id;
    public $destinataire;

    public $editMode = false;

    public function mount ()
    {
        $this->numero = $this->dossier->numero;
        $this->client_id = $this->dossier->client_id;
        $this->camion_id = $this->dossier->camion_id;
        $this->chauffeur_id = $this->dossier->chauffeur_id;
        $this->destinataire = $this->dossier->destinataire;
    }


    #[On('commande-attached')]
    #[On('commande-removed')]
    
    public function render()
    {
        $chauffeurs = Chauffeur::all();
        $camions = Camion::all();
        $clients = Client::all();

        return view('livewire.dossier.modals.view-dossier', ['chauffeurs' => $chauffeurs, 'camions' => $camions, 'clients' => $clients]);
    }


    public function toggleEditMode ()
    {
        $this->editMode = ! $this->editMode;
    }


    public function update ()
    {
        $this->validate(
            [
                'client_id' => ['required', 'exists:clients,id'],
                'destinataire' => ['required', 'exists:clients,id'],
                'camion_id' => ['required', 'exists:camions,id'],
                'chauffeur_id' => ['required', 'exists:chauffeurs,id'],
            ],
            [
                'client_id.exists' => 'Le client sélectionné est invalide.',
                'client_id.required' => 'Le client est obligatoire.',
                'destinataire.required' => 'Le destinataire est obligatoire.',
                'destinataire.exists' => 'Le destinataire sélectionné est invalide.',
                'camion_id.required' => 'Le camion est obligatoire.',
                'camion_id.exists' => 'Le camion sélectionné est invalide.',
                'chauffeur_id.required' => 'Le chauffeur est obligatoire.',
                'chauffeur_id.exists' => 'Le chauffeur sélectionné est invalide.',
            ]
        );

        try {
            DB::beginTransaction();
            $this->dossier->update([
                'client_id' => $this->client_id,
                'destinataire' => $this->destinataire,
                'camion_id' => $this->camion_id,
                'chauffeur_id' => $this->chauffeur_id,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('error');
            return;
        }


        $this->editMode = false;

    }

    public function removeCommande($commandeId)
    {
        $commande = $this->dossier->commandes()->where('id', $commandeId)->first();

        if ($commande) {
            $commande->dossier_id = null;
            $commande->save();
            $this->dispatch('commande-removed');
        }
    }
}
