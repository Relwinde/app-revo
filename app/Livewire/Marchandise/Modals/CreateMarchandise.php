<?php

namespace App\Livewire\Marchandise\Modals;

use App\Models\Marchandise;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class CreateMarchandise extends ModalComponent
{
    public $name;
    public function render()
    {
        return view('livewire.marchandise.modals.create-marchandise');
    }

    public function create()
    {
        abort_unless(auth()->user()->can('Créer Marchandise'), 403);

        $this->validate([
            'name' => 'required|string|max:255|unique:marchandises,name',
        ]);

        try {
            DB::beginTransaction();

            Marchandise::create([
                'name' => $this->name,
            ]);

            DB::commit();

            $this->dispatch('marchandise-created');
            $this->closeModal();
            $this->reset();

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('error');
        }
    }
}
