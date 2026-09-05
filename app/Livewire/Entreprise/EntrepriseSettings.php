<?php

namespace App\Livewire\Entreprise;

use App\Models\Entreprise;
use Livewire\Component;

class EntrepriseSettings extends Component
{
    public $capital;
    public $adresse;
    public $telephone;
    public $email;
    public $rccm;
    public $ifu;
    public $regime_imposition;
    public $division_fiscale;

    public function mount()
    {
        $entreprise = Entreprise::current();

        $this->capital = $entreprise->capital;
        $this->adresse = $entreprise->adresse;
        $this->telephone = $entreprise->telephone;
        $this->email = $entreprise->email;
        $this->rccm = $entreprise->rccm;
        $this->ifu = $entreprise->ifu;
        $this->regime_imposition = $entreprise->regime_imposition;
        $this->division_fiscale = $entreprise->division_fiscale;
    }

    public function save()
    {
        $this->validate(
            [
                'capital' => ['nullable', 'string', 'max:255'],
                'adresse' => ['nullable', 'string'],
                'telephone' => ['nullable', 'string', 'max:50'],
                'email' => ['nullable', 'email', 'max:255'],
                'rccm' => ['nullable', 'string', 'max:255'],
                'ifu' => ['nullable', 'string', 'max:255'],
                'regime_imposition' => ['nullable', 'string', 'max:255'],
                'division_fiscale' => ['nullable', 'string', 'max:255'],
            ],
            [
                'email.email' => 'Adresse email invalide.',
            ]
        );

        Entreprise::current()->update([
            'capital' => $this->capital,
            'adresse' => $this->adresse,
            'telephone' => $this->telephone,
            'email' => $this->email,
            'rccm' => $this->rccm,
            'ifu' => $this->ifu,
            'regime_imposition' => $this->regime_imposition,
            'division_fiscale' => $this->division_fiscale,
        ]);

        session()->flash('message', 'Informations de l\'entreprise mises à jour.');
    }

    public function render()
    {
        $pageHeader = [
            'title' => 'Entreprise',
            'subtitle' => 'Informations de l\'entreprise',
            'breadcrumbs' => [
                ['label' => 'Accueil', 'url' => route('home')],
                ['label' => 'Entreprise']
            ]
        ];

        return view('livewire.entreprise.entreprise-settings', [
            'pageHeader' => $pageHeader
        ])->layout('components.layouts.app', ['title' => 'Entreprise']);
    }
}
