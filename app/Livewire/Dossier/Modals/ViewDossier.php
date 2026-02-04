<?php

namespace App\Livewire\Dossier\Modals;

use App\Models\Camion;
use App\Models\Client;
use App\Models\Dossier;
use App\Models\Chauffeur;
use App\Models\Fournisseur;
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
    public $type_operation;
    public $service;
    public $escort;
    public $compagnon;
    public $lieu;
    public $motif;
    public $date_depart;
    public $date_retour;

    public $avec_location;

    public $prix_location;

    public $fournisseur_id;

    public $editMode = false;

    public function mount ()
    {
        $this->numero = $this->dossier->numero;
        $this->client_id = $this->dossier->client_id;
        $this->camion_id = $this->dossier->camion_id;
        $this->chauffeur_id = $this->dossier->chauffeur_id;
        $this->destinataire = $this->dossier->destinataire;
        $this->type_operation = $this->dossier->type_operation;
        $this->service = $this->dossier->service;
        $this->escort = $this->dossier->escort;
        $this->compagnon = $this->dossier->compagnon;
        $this->lieu = $this->dossier->lieu;
        $this->motif = $this->dossier->motif;
        $this->date_depart = $this->dossier->date_depart;
        $this->date_retour = $this->dossier->date_retour;

        $this->avec_location = $this->dossier->prix_location ? true : false;
        $this->prix_location = $this->dossier->prix_location;
        $this->fournisseur_id = $this->dossier->fournisseur_id;
    }


    #[On('commande-attached')]
    #[On('commande-removed')]
    public function render()
    {
        $chauffeurs = Chauffeur::all();
        $camions = Camion::all();
        $clients = Client::all();
        $fournisseurs = Fournisseur::all();

        return view('livewire.dossier.modals.view-dossier', ['chauffeurs' => $chauffeurs, 'camions' => $camions, 'clients' => $clients, 'fournisseurs' => $fournisseurs]);
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
                'type_operation'=>['required'],
                'lieu' => ['string', 'nullable'], 
                'escort' => ['string', 'nullable'], 
                'compagnon' => ['string', 'nullable'],
                'motif' => ['string', 'nullable'],
                'date_depart' => ['date', 'nullable'], 
                'date_retour' => ['date', 'nullable'],
                'prix_location' => $this->avec_location ? ['required', 'numeric'] : ['nullable'],
                'fournisseur_id' => $this->avec_location ? ['required', 'exists:fournisseurs,id'] : ['nullable'],
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
                'date_depart.date' => 'La date de départ doit être une date valide.',
                'date_retour' => 'La date de retour doit être une date valide.',
                'lieu.string' => 'Le lieu doit être une chaîne de caractères.',
                'escort.string' => 'L\'escort doit être une chaîne de caractères.',
                'compagnon.string' => 'Le compagnon doit être une chaîne de caractères.',
                'motif.string' => 'Le motif doit être une chaîne de caractères.',
            ]
        );

        try {
            DB::beginTransaction();

            if ($this->avec_location) {
                $this->dossier->update([
                    'prix_location' => $this->prix_location,
                    'fournisseur_id' => $this->fournisseur_id,
                ]);
            } else {
                $this->dossier->update([
                    'prix_location' => null,
                    'fournisseur_id' => null,
                ]);
            }

            $this->dossier->update([
                'client_id' => $this->client_id,
                'destinataire' => $this->destinataire,
                'camion_id' => $this->camion_id,
                'chauffeur_id' => $this->chauffeur_id,
                'type_operation' => $this->type_operation,
                'service' => $this->service,
                'escort' => $this->escort,
                'compagnon' => $this->compagnon,
                'lieu' => $this->lieu,
                'motif' => $this->motif,
                'date_depart' => $this->date_depart,
                'date_retour' => $this->date_retour,
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


    public function printOrdreMission()
    {
            $this->dispatch('print-ordre-mission');
    }

    public function printManifest()
    {
            $this->dispatch('print-manifest');

    }

}
