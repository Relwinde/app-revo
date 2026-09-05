<?php

namespace App\Livewire\Facture;

use App\Models\Camion;
use App\Models\Chauffeur;
use App\Models\Client;
use App\Models\Facture;
use App\Models\FactureItem;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class EditFacture extends Component
{

    public Facture $facture;

    public $client_id;
    public $date;
    public $payment_terms;
    public $payment_conditions;
    public $chauffeur_id;
    public $camion_id;
    public $personne_contact;
    public $total_amount;

    public $numero;

    public $comments;

    public $edit_mode = false;

     public function mount(Facture $facture){

        $this->facture = $facture;
        $this->client_id = $this->facture->client_id;
        $this->date = $this->facture->date;
        $this->payment_terms = $this->facture->payment_terms;
        $this->payment_conditions = $this->facture->payment_conditions; 
        $this->chauffeur_id = $this->facture->chauffeur_id;
        $this->camion_id = $this->facture->camion_id;
        $this->personne_contact = $this->facture->personne_contact; 
        $this->numero = $this->facture->reference; 
        $this->comments = $this->facture->comments;
    }

    #[On('item-added')]
    public function render()
    {
        $pageHeader = [
            'title' => 'Factures Définitives',
            'subtitle' => 'Détails de la facture',
            'breadcrumbs' => [
                ['label' => 'Accueil', 'url' => route('home')],
                ['label' => 'Factures Définitives', 'url' => route('facture-definitives')],
                ['label' => 'Détails de la facture'],
                ],
                ];

        $clients = Client::orderBy('name')->get();
        $chauffeurs = Chauffeur::orderBy('name')->get();
        $camions = Camion::orderBy('license_plate')->get();

        return view('livewire.facture.edit-facture',[
            'pageHeader' => $pageHeader, 'clients' => $clients, 'chauffeurs' => $chauffeurs, 'camions' => $camions
        ])->layout('components.layouts.app', ['title' => 'Détails de la Facture']);
    }

    public function saveHeader (){
            abort_unless(auth()->user()->can('Modifier Facture'), 403);

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
        
        
           $this->facture->update([
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
                $this->facture->save();
                $this->facture = $this->facture->fresh();

                DB::commit();

                $this->set_edit_mode();

            } 
            catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
    
            
    }

    public function removeItem (FactureItem $item){
        abort_unless(auth()->user()->can('Supprimer ligne Facture'), 403);

        $item->delete();
    }

    public function saveComments (){
        abort_unless(auth()->user()->can('Modifier Facture'), 403);

        $this->facture->comments = $this->comments;

        $this->facture->save();
    }

    public function print (){
            abort_unless(auth()->user()->can('Imprimer Facture'), 403);

            $url = route('print-facture', ['facture'=>$this->facture->id]);

            $this->dispatch('print-facture', url: $url);
    }

    public function set_edit_mode(){
        if($this->edit_mode == false){
            $this->edit_mode = true;
        } else {
            $this->edit_mode = false;
        }
    }
}
