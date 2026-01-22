<?php

namespace App\Livewire\Chauffeur;

use App\Models\Chauffeur;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class Chauffeurs extends Component
{
    use WithPagination;

    public $editMode = false;
    public $chauffeurId;

    public $name;
    public $email;
    public $phone;
    public $address;
    public $ref_identite;

    public function toggleEditMode($id)
    {
        if ($this->editMode) {
            $this->resetForm();
            return;
        }

        $chauffeur = Chauffeur::find($id);
        if ($chauffeur) {
            $this->editMode   = true;
            $this->chauffeurId = $id;

            $this->name    = $chauffeur->name;
            $this->email   = $chauffeur->email;
            $this->phone   = $chauffeur->phone;
            $this->address = $chauffeur->address;
            $this->ref_identite = $chauffeur->ref_identite;
        }
    }

    public function update($id)
    {
        $this->validate([
            'name'    => 'required|string|max:255|unique:chauffeurs,name,' . $id,
            'email'   => 'nullable|email|unique:chauffeurs,email,' . $id,
            'phone'   => 'nullable|string|max:50',
            'address' => 'nullable|string',
        ], [
            'name.required'  => 'Le nom est obligatoire.',
            'name.unique'    => 'Ce chauffeur existe déjà.',
            'email.email'    => 'Email invalide.',
            'email.unique'   => 'Email déjà utilisé.',
        ]);

        $chauffeur = Chauffeur::find($id);

        if ($chauffeur) {
            $chauffeur->update([
                'name'    => mb_strtoupper($this->name, 'UTF-8'),
                'email'   => $this->email,
                'phone'   => $this->phone,
                'address' => $this->address,
                'ref_identite' => mb_strtoupper($this->ref_identite, 'UTF-8'),
            ]);

            $this->dispatch('chauffeur-updated');
            $this->resetForm();
        }
    }

    public function delete($id)
    {
        $chauffeur = Chauffeur::find($id);
        if ($chauffeur) {
            $chauffeur->delete();
            $this->dispatch('chauffeur-deleted');
        }
    }

    public function resetForm()
    {
        $this->reset([
            'editMode',
            'chauffeurId',
            'ref_identite',
            'name',
            'email',
            'phone',
            'address',
        ]);
    }

    #[On('chauffeur-created')]
    #[On('chauffeur-updated')]
    #[On('chauffeur-deleted')]
    public function render()
    {
        $chauffeurs = Chauffeur::orderBy('name')->paginate(10);

        $pageHeader = [
            'title' => 'Chauffeurs',
            'subtitle' => 'Liste des chauffeurs',
            'breadcrumbs' => [
                ['label' => 'Accueil', 'url' => route('home')],
                ['label' => 'Chauffeurs'],
            ],
        ];

        return view('livewire.chauffeur.chauffeurs', [
            'chauffeurs' => $chauffeurs,
            'pageHeader' => $pageHeader,
        ])->layout('components.layouts.app', ['title' => 'Chauffeurs']);
    }
}
