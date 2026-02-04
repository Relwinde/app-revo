<?php

namespace App\Livewire\Camion;

use App\Models\Camion;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class Camions extends Component
{
    use WithPagination;

    public $editMode = false;
    public $camionId;

    public $search;

    public $license_plate;
    public $model;
    public $brand;
    public $capacity;

    public function toggleEditMode($id)
    {
        if ($this->editMode) {
            $this->resetForm();
            return;
        }

        $camion = Camion::find($id);
        if ($camion) {
            $this->editMode = true;
            $this->camionId = $id;

            $this->license_plate = $camion->license_plate;
            $this->model = $camion->model;
            $this->brand = $camion->brand;
            $this->capacity = $camion->capacity;
        }
    }

    public function update($id)
    {
        $this->validate([
            'license_plate' => 'required|string|max:255|unique:camions,license_plate,' . $id,
            'model' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'capacity' => 'nullable|integer|min:0',
        ]);

        $camion = Camion::find($id);

        if ($camion) {
            $camion->update([
                'license_plate' => strtoupper($this->license_plate),
                'model' => $this->model,
                'brand' => $this->brand,
                'capacity' => $this->capacity,
            ]);

            $this->dispatch('camion-updated');
            $this->resetForm();
        }
    }

    public function delete($id)
    {
        $camion = Camion::find($id);
        if ($camion) {
            $camion->delete();
            $this->dispatch('camion-deleted');
        }
    }

    public function resetForm()
    {
        $this->reset([
            'editMode',
            'camionId',
            'license_plate',
            'model',
            'brand',
            'capacity',
        ]);
    }

    #[On('camion-created')]
    #[On('camion-updated')]
    #[On('camion-deleted')]
    public function render()
    {
        $camions = Camion::where('license_plate', 'like', "%{$this->search}%")
                ->orderBy('license_plate')
                ->paginate(10);

        $pageHeader = [
            'title' => 'Camions',
            'subtitle' => 'Liste des camions',
            'breadcrumbs' => [
                ['label' => 'Accueil', 'url' => route('home')],
                ['label' => 'Camions'],
            ],
        ];

        return view('livewire.camion.camions', [
            'camions' => $camions,
            'pageHeader' => $pageHeader,
        ])->layout('components.layouts.app', ['title' => 'Camions']);
    }

    public function clear_search()
    {
        $this->search = '';
    }
}
