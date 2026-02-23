<?php

namespace App\Livewire\Facture\Modals;

use App\Models\FactureItem;
use Illuminate\Support\Facades\DB;
use LivewireUI\Modal\ModalComponent;

class EditItem extends ModalComponent
{

    public FactureItem $item;

    public $description;

    public $quantity;

    public $unit_price;

    public $unit;

    public function mount(){
        $this->description = $this->item->description; 
        $this->quantity = $this->item->quantity; 
        $this->unit_price = $this->item->unit_price; 
        $this->unit = $this->item->unit;
    }

    public function render()
    {
        return view('livewire.facture.modals.edit-item');
    }

    public function save (){

        $this->validate([
            'description' => 'required|string',
            'quantity' => 'required|numeric|min:1',
            'unit_price' => 'required|numeric|min:0',
            'unit' => 'required|string',
        ], 
        [
            'description.required' => 'La description est obligatoire.',
            'quantity.required' => 'La quantité est obligatoire.',
            'quantity.numeric' => 'La quantité doit être un nombre.',
            'quantity.min' => 'La quantité doit être au moins 1.',
            'unit_price.required' => 'Le prix unitaire est obligatoire.',
            'unit_price.numeric' => 'Le prix unitaire doit être un nombre.',
            'unit_price.min' => 'Le prix unitaire doit être au moins 0.',
            'unit.required' => "L'unité est obligatoire.",
        ]);

        try {

            DB::beginTransaction();

            $this->item->update([
                'description' => $this->description, 
                'quantity' => $this->quantity, 
                'unit' => $this->unit,
                'unit_price' => $this->unit_price
            ]);

            DB::commit();
            $this->dispatch("item-added");
            $this->closeModal();
            
        }
        catch (\Exception $ex){
            DB::rollBack();

            throw $ex; 

            $this->addError('exception', 'Une erreure est survenue lors de la modification de la ligne');
        }



    }
}
