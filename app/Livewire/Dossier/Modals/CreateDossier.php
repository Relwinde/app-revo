<?php

namespace App\Livewire\Dossier\Modals;

use App\Models\Camion;
use App\Models\Client;
use App\Models\Dossier;
use App\Models\Chauffeur;
use Illuminate\Support\Facades\DB;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Testing\Fakes\Fake;

class CreateDossier extends ModalComponent
{

    public $client_id;

    public $destinataire;

    public $camion_id;

    public $chauffeur_id;

    public $type_operation;

    public $service;

    public $escort;

    public $compagnon;

    public $lieu;

    public $motif;

    public $date_depart;
    
    public $date_retour;


    public function render()
    {
        $clients = Client::all();
        $camions = Camion::all();
        $chauffeurs = Chauffeur::all();


        return view('livewire.dossier.modals.create-dossier', ['clients' => $clients, 'camions' => $camions, 'chauffeurs' => $chauffeurs]);
    }

    public function create()
    {
        $this->validate(
            [
                'client_id' => ['required', 'exists:clients,id'],
                'destinataire' => ['required', 'string'],
                'camion_id' => ['required', 'exists:camions,id'],
                'chauffeur_id' => ['required', 'exists:chauffeurs,id'],
                'type_operation'=>['required'],
                'lieu' => ['string'], 
                'escort' => ['string'], 
                'compagnon' => ['string'],
                'motif' => ['string'],
                'date_depart' => ['date'], 
                'date_retour' => ['date'],
            ],
            [
                'type_operation.required' => 'Le type d\'opération est obligatoire',
                'client_id.exists' => 'Le client sélectionné est invalide.',
                'client_id.required' => 'Le client est obligatoire.',
                'destinataire.required' => 'Le destinataire est obligatoire.',
                'destinataire.string' => 'Le destinataire doit être une chaîne de caractères.',
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

        $dossier = Dossier::make([
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
            'user_id' => auth()->id(),
        ]);

        $numero = 'REV0'.'-'.substr(date('Y'), -2).'-'.date('m').'/MA'.str_pad(Dossier::whereYear('created_at', now()->year)->count() + 1, 4, '0', STR_PAD_LEFT);
        
        // REV026-01/MA001

        $dossier->numero = $numero;

        try {

            DB::beginTransaction();
            $dossier->save();
            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;

            $this->addError('exception', 'Une erreur est survenue lors de la création du dossier');
            return;
        }
        $this->dispatch('dossier-created');
        $this->reset();
        $this->closeModal();
    }
}
