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
            ],
            [
                'client_id.exists' => 'Le client sélectionné est invalide.',
                'client_id.required' => 'Le client est obligatoire.',
                'destinataire.required' => 'Le destinataire est obligatoire.',
                'destinataire.string' => 'Le destinataire doit être une chaîne de caractères.',
                'camion_id.required' => 'Le camion est obligatoire.',
                'camion_id.exists' => 'Le camion sélectionné est invalide.',
                'chauffeur_id.required' => 'Le chauffeur est obligatoire.',
                'chauffeur_id.exists' => 'Le chauffeur sélectionné est invalide.',
            ]
        );

        $dossier = Dossier::make([
            'client_id' => $this->client_id,
            'destinataire' => $this->destinataire,
            'camion_id' => $this->camion_id,
            'chauffeur_id' => $this->chauffeur_id,
            'user_id' => auth()->id(),
        ]);

        $numero = fake()->unique()->regexify('[A-Z0-9]{8}');
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
