<?php

namespace App\Livewire\Camion\Modals;

use App\Models\Camion;
use Illuminate\Support\Facades\DB;
use LivewireUI\Modal\ModalComponent;

class CreateCamion extends ModalComponent
{
    public $license_plate;
    public $model;
    public $brand;
    public $capacity;

    public function render()
    {
        return view('livewire.camion.modals.create-camion');
    }

    public function create()
    {
        abort_unless(auth()->user()->can('Créer Camion'), 403);

        $this->validate([
            'license_plate' => 'required|string|max:255|unique:camions,license_plate',
            'model' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'capacity' => 'nullable|integer|min:0',
        ]);

        try {
            DB::beginTransaction();

            Camion::create([
                'license_plate' => strtoupper($this->license_plate),
                'model' => $this->model,
                'brand' => $this->brand,
                'capacity' => $this->capacity,
            ]);

            DB::commit();

            $this->dispatch('camion-created');
            $this->closeModal();
            $this->reset();

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('error');
        }
    }
}
