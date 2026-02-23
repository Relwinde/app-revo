<?php

namespace App\Livewire\Facture\Modals;

use App\Models\Facture;
use App\Models\FactureItem;
use Illuminate\Support\Facades\DB;
use LivewireUI\Modal\ModalComponent;

class AddItem extends ModalComponent
{

    public Facture $facture;

    public $description;

    public $quantity;

    public $unit_price;

    public $unit;


    public function render()
    {
        return view('livewire.facture.modals.add-item');
    }

    public function addItem()
    {
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

        $item = FactureItem::make([
            'type'=>'DEF',
            'facture_id' => $this->facture->id,
            'description' => $this->description, 
            'quantity' => $this->quantity, 
            'unit' => $this->unit,
            'unit_price' => $this->unit_price
        ]);


        try {
            DB::beginTransaction();

            $item->save();

            DB::commit();
            $this->reset(['description', 'quantity', 'unit_price', 'unit']);
            $this->dispatch("item-added");

        }
        catch (\Exception $ex){
            DB::rollBack();

            throw $ex; 

            $this->addError('exception', 'Une erreure est survenue lors de l\'ajout de la ligne');
        }

        

    }
}
