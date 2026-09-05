<?php

namespace App\Livewire\Fournisseur;

use App\Models\Fournisseur;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;

class Fournisseurs extends Component
{
    use WithPagination;
    
    public $search;

    public $editMode = false;
    public $fournisseurId;

    public $name;
    public $email;
    public $phone;
    public $address;
    public $rccm;
    public $ifu;

    public function toggleEditMode($id)
    {
        if ($this->editMode && $this->fournisseurId === $id) {
            $this->resetForm();
            return;
        }

        $fournisseur = Fournisseur::find($id);

        if ($fournisseur) {
            $this->editMode = true;
            $this->fournisseurId = $id;

            $this->name = $fournisseur->name;
            $this->email = $fournisseur->email;
            $this->phone = $fournisseur->phone;
            $this->address = $fournisseur->address;
            $this->rccm = $fournisseur->rccm;
            $this->ifu = $fournisseur->ifu;
        }
    }

    public function resetForm()
    {
        $this->reset([
            'editMode',
            'fournisseurId',
            'name',
            'email',
            'phone',
            'address',
            'rccm',
            'ifu',
        ]);
    }

    public function update($id)
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('fournisseurs')->ignore($id)],
            'email' => ['nullable', 'email', Rule::unique('fournisseurs')->ignore($id)],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string'],
            'rccm' => ['nullable', Rule::unique('fournisseurs')->ignore($id)],
            'ifu' => ['nullable', Rule::unique('fournisseurs')->ignore($id)],
        ]);

        $fournisseur = Fournisseur::find($id);

        if ($fournisseur) {
            $fournisseur->update([
                'name' => mb_strtoupper($this->name, 'UTF-8'),
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'rccm' => $this->rccm,
                'ifu' => $this->ifu,
            ]);

            $this->dispatch('fournisseur-updated');
            $this->resetForm();
        }
    }

    public function delete($id)
    {
        abort_unless(auth()->user()->can('Supprimer Fournisseur'), 403);

        $fournisseur = Fournisseur::find($id);

        if ($fournisseur) {
            $fournisseur->delete();
            $this->dispatch('fournisseur-deleted');
        }
    }

    #[On('fournisseur-created')]
    #[On('fournisseur-deleted')]
    #[On('fournisseur-updated')]
    public function render()
    {
        return view('livewire.fournisseur.fournisseurs', [

        
            'fournisseurs' => Fournisseur::where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%")
                    ->orWhere('phone', 'like', "%{$this->search}%")
                    ->orWhere('rccm', 'like', "%{$this->search}%")
                    ->orWhere('ifu', 'like', "%{$this->search}%")
                    ->orderBy('name')->paginate(10),


            'pageHeader' => [
                'title' => 'Prestataires',
                'subtitle' => 'Liste des prestataires',
                'breadcrumbs' => [
                    ['label' => 'Accueil', 'url' => route('home')],
                    ['label' => 'Prestataires'],
                ],
            ],
        ])->layout('components.layouts.app', ['title' => 'Prestataires']);
    }


    public function clear_search()
    {
        $this->search = '';
    }
}
