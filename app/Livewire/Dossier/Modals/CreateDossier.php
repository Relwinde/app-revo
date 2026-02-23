<?php

namespace App\Livewire\Dossier\Modals;

use App\Models\Camion;
use App\Models\Chauffeur;
use App\Models\Client;
use App\Models\Dossier;
use App\Models\FactureProforma;
use App\Models\Fournisseur;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Testing\Fakes\Fake;
use LivewireUI\Modal\ModalComponent;

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

    public $avec_location = false;

    public $prix_location;

    public $fournisseur_id;

    public $avec_escort;

    public $facture_proforma_id;


    public function render()
    {
        $clients = Client::all();
        $camions = Camion::all();
        $chauffeurs = Chauffeur::all();
        $fournisseurs = Fournisseur::all();
        // only show proformas that are not already attached to a dossier
        // $facturesProformas = FactureProforma::whereDoesntHave('dossiers')
        //     ->orderBy('created_at', 'desc')
        //     ->get();

        $facturesProformas = FactureProforma::orderBy('created_at', 'desc')
            ->get();

         return view('livewire.dossier.modals.create-dossier', ['clients' => $clients, 'camions' => $camions, 'chauffeurs' => $chauffeurs, 'fournisseurs' => $fournisseurs, 'facturesProformas' => $facturesProformas]);
    }

    public function create()
    {
        $this->validate(
            [
                'client_id' => ['required', 'exists:clients,id'],
                'destinataire' => ['required', 'string'],
                'camion_id' => ['required', 'exists:camions,id'],
                'chauffeur_id' => ['required', 'exists:chauffeurs,id'],
                'facture_proforma_id' => ['nullable', 'exists:facture_proformas,id'],
                'type_operation'=>['required'],
                'lieu' => ['string', 'nullable'], 
                'escort' => ['string', 'nullable'], 
                'compagnon' => ['string', 'nullable'],
                'motif' => ['string', 'nullable'],
                'date_depart' => ['date', 'nullable'], 
                'date_retour' => ['date', 'nullable'],
                'prix_location' => $this->avec_location ? ['required', 'numeric'] : ['nullable'],
                'escort' => $this->avec_escort ? ['required', 'string'] : ['nullable'],
                'fournisseur_id' => $this->avec_location ? ['required', 'exists:fournisseurs,id'] : ['nullable'],
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
                'escort.required' => 'L\'escort est obligatoire.',
                'compagnon.string' => 'Le compagnon doit être une chaîne de caractères.',
                'motif.string' => 'Le motif doit être une chaîne de caractères.',
                'prix_location.required' => 'Le prix de location est obligatoire lorsque l\'option avec location est activée.',
                'prix_location.numeric' => 'Le prix de location doit être un nombre.',
                'fournisseur_id.required' => 'Le fournisseur est obligatoire lorsque l\'option avec location est activée.',
                'fournisseur_id.exists' => 'Le fournisseur sélectionné est invalide.',
                'facture_proforma_id.exists' => 'La facture pro-forma sélectionnée est invalide.',
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
            'prix_location' => $this->avec_location ? $this->prix_location : null,
            'fournisseur_id' => $this->avec_location ? $this->fournisseur_id : null,
            'facture_proforma_id' => $this->facture_proforma_id,
        ]);

        $numero = 'REV0'.substr(date('Y'), -2).'-'.date('m').$this->type_operation.str_pad(Dossier::whereYear('created_at', now()->year)->count() + 1, 3, '0', STR_PAD_LEFT);
        
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
