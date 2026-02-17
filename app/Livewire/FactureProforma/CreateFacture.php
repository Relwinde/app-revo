<?php

namespace App\Livewire\FactureProforma;

use App\Models\Camion;
use App\Models\Client;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Chauffeur;
use App\Models\FactureItem;
use App\Models\FactureProforma;
use Illuminate\Support\Facades\DB;

class CreateFacture extends Component
{

    public $client_id;
    public $date;
    public $payment_terms;
    public $payment_conditions;
    public $chauffeur_id;
    public $camion_id;
    public $personne_contact;
    public $total_amount;

    public $factureProforma;

    public $numero;

    public $comments;

    #[On('item-added')]
    public function render()
    {
        $pageHeader = [
            'title' => 'Factures Pro-Forma',
            'subtitle' => 'Nouvelle facture pro-forma',
            'breadcrumbs' => [
                ['label' => 'Accueil', 'url' => route('home')],
                ['label' => 'Factures Pro-Forma', 'url' => route('facture-proformas')],
                ['label' => 'Nouvelle facture pro-forma'],
                ],
                ];

        $clients = Client::orderBy('name')->get();
        $chauffeurs = Chauffeur::orderBy('name')->get();
        $camions = Camion::orderBy('license_plate')->get();

        return view('livewire.facture-proforma.create-facture', compact('pageHeader', 'clients', 'chauffeurs', 'camions'))->layout('components.layouts.app', ['title' => 'Créer une Facture Pro-Forma']);
    }

    #[On('item-added')]
    public function refreshItems()
    {
        $this->factureProforma = $this->factureProforma->fresh();
    }

    public function saveHeader (){
            $this->validate([
                'client_id' => 'required|exists:clients,id',
                'camion_id' => 'nullable|exists:camions,id',
                'chauffeur_id' => 'nullable|exists:chauffeurs,id',
                'date' => 'required|date',
                'payment_terms' => 'nullable|integer',
                'payment_conditions' => 'nullable|string|max:255',
                'chauffeur_id' => 'nullable|exists:chauffeurs,id',
                'personne_contact' => 'nullable|string|max:255',
            ], 
            [
                'client_id.required' => 'Le client est requis.',
                'client_id.exists' => 'Le client sélectionné est invalide.',
                'date.required' => 'La date est requise.',
                'date.date' => 'La date doit être une date valide.',
                'payment_terms.integer' => 'Les termes de paiement doivent être un nombre entier.',
                'payment_conditions.string' => 'Les conditions de paiement doivent être une chaîne de caractères.',
                'payment_conditions.max' => 'Les conditions de paiement ne peuvent pas dépasser 255 caractères.',
                'chauffeur_id.exists' => 'Le chauffeur sélectionné est invalide.',
                'personne_contact.string' => 'La personne de contact doit être une chaîne de caractères.',
                'personne_contact.max' => 'La personne de contact ne peut pas dépasser 255 caractères.',
            ]);
        
        
           $factureProforma = FactureProforma::make([
                'client_id' => $this->client_id,
                'camion_id' => $this->camion_id,
                'chauffeur_id' => $this->chauffeur_id,
                'created_by' => auth()->id(),
                'date' => $this->date,
                'payment_terms' => $this->payment_terms,
                'payment_conditions' => $this->payment_conditions,
                'personne_contact' => $this->personne_contact,
                'total_amount' => 0, // Initialement à 0, sera mis à jour après l'ajout des produits
            ]);

            try{
                DB::beginTransaction();
                
                $factureProforma->reference = 'REVO'.substr(date('Y'), -2)."-FAP". str_pad(FactureProforma::max('id') + 1, 3, '0', STR_PAD_LEFT);
                $factureProforma->save();
                $this->factureProforma = $factureProforma;
                $this->numero = $factureProforma->reference;
                DB::commit();
                $this->factureProforma = $this->factureProforma->fresh();

            } 
            catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
    
            
    }


    public function removeItem (FactureItem $item){
        $item->delete();
    }

    public function saveComments (){
        $this->factureProforma->comments = $this->comments;

        $this->factureProforma->save();
    }

    public function print (){

            $url = route('print-facture-proforma', ['facture'=>$this->factureProforma->id]);

            $this->dispatch('print-proforma', url: $url);
    }


}
