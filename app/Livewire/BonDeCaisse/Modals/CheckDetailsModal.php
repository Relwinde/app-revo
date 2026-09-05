<?php

namespace App\Livewire\BonDeCaisse\Modals;

use App\Models\Caisse;
use App\Models\BonDeCaisse;
use App\Models\SuiviCaisse;
use Illuminate\Support\Facades\DB;
use LivewireUI\Modal\ModalComponent;

class CheckDetailsModal extends ModalComponent
{
    public BonDeCaisse $bon;
    public $numeroChecque = '';
    public $banqueChecque = '';
    public $dateChecque = '';

    public function mount()
    {
        $this->numeroChecque = $this->bon->numero_cheque ?? '';
        $this->banqueChecque = $this->bon->banque_cheque ?? '';
        $this->dateChecque = $this->bon->date_cheque ? $this->bon->date_cheque->format('Y-m-d') : '';
    }

    public function render()
    {
        return view('livewire.bon-de-caisse.modals.check-details-modal');
    }

    public function confirmerPaiement()
    {
        abort_unless(auth()->user()->can('Payer bon de caisse'), 403);

        $this->validate([
            'numeroChecque' => 'required|string|max:50',
            'banqueChecque' => 'required|string|max:100',
            'dateChecque' => 'required|date',
        ], [
            'numeroChecque.required' => 'Le numéro de chèque est obligatoire.',
            'numeroChecque.string' => 'Le numéro de chèque doit être une chaîne de caractères.',
            'numeroChecque.max' => 'Le numéro de chèque ne peut pas dépasser 50 caractères.',
            'banqueChecque.required' => 'La banque est obligatoire.',
            'banqueChecque.string' => 'La banque doit être une chaîne de caractères.',
            'banqueChecque.max' => 'La banque ne peut pas dépasser 100 caractères.',
            'dateChecque.required' => 'La date du chèque est obligatoire.',
            'dateChecque.date' => 'La date du chèque doit être une date valide.',
        ]);

        try {
            DB::beginTransaction();

            $this->bon->etapeBons()->create([
                'etape_precedente' => 'CAISSE',
                'etape_actuelle' => 'PAYE',
                'montant' => $this->bon->montant_definitif,
                'user_id' => auth()->id(),
            ]);

            $this->bon->update([
                'type_paiement' => 'CHEQUE',
                'numero_cheque' => $this->numeroChecque,
                'banque_cheque' => $this->banqueChecque,
                'date_cheque' => $this->dateChecque,
                'etape' => 'PAYE',
            ]);

            DB::commit();

            $this->dispatch('bon-updated');
            $this->closeModal();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function annuler()
    {
        $this->closeModal();
    }
}
