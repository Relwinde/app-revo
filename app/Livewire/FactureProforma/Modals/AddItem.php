<?php

namespace App\Livewire\FactureProforma\Modals;

use Exception;
use App\Models\FactureItem;
use App\Models\FactureProforma;
use Illuminate\Support\Facades\DB;
use LivewireUI\Modal\ModalComponent;

class AddItem extends ModalComponent
{
    public FactureProforma $factureProforma;

    public $description;

    public $quantity;

    public $unit_price;

    public $unit;


    public function render()
    {
        return view('livewire.facture-proforma.modals.add-item');
    }

    public function addItem()
    {
        abort_unless(auth()->user()->can('Modifier Facture Proforma'), 403);

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
            'type'=>'PRO',
            'facture_proforma_id' => $this->factureProforma->id,
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
        catch (Exception $ex){
            DB::rollBack();

            throw $ex; 

            $this->addError('exception', 'Une erreure est survenue lors de l\'ajout de la ligne');
        }

        

    }
}
