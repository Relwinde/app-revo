<?php

namespace App\Livewire\Client\Modals;

use App\Models\Client;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use LivewireUI\Modal\ModalComponent;

class CreateClient extends ModalComponent
{
    public $name;
    public $email;
    public $phone;
    public $address;
    public $rccm;
    public $ifu;
    public $div_fisc;
    public $code;

    public function render()
    {
        return view('livewire.client.modals.create-client');
    }

    public function create()
    {
        $this->validate(
            [
                'name' => ['required', 'string', 'max:255', 'unique:clients,name'],
                'code' => ['required', 'string', 'max:255', 'unique:clients,name'],
                'email' => ['nullable', 'email', 'unique:clients,email'],
                'phone' => ['nullable', 'string', 'max:50'],
                'address' => ['nullable', 'string'],
                'div_fisc' => ['nullable', 'string'],
                'rccm' => ['nullable', 'string', 'unique:clients,rccm'],
                'ifu' => ['nullable', 'string', 'unique:clients,ifu'],
            ],
            [
                'name.required' => 'Le nom du client est obligatoire.',
                'code.required' => 'Le code du client est obligatoire.',
                'name.unique' => 'Ce client existe déjà.',
                'email.email' => 'Adresse email invalide.',
                'email.unique' => 'Cet email est déjà utilisé.',
                'rccm.unique' => 'Ce RCCM existe déjà.',
                'ifu.unique' => 'Cet IFU existe déjà.',
            ]
        );

        $client = Client::make([
            'name' => mb_strtoupper($this->name, 'UTF-8'),
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'rccm' => $this->rccm,
            'ifu' => $this->ifu,
            'div_fisc' => $this->div_fisc,
            'code'=>mb_strtoupper($this->code, 'UTF-8').Client::count()+1
        ]);

        try {
            DB::beginTransaction();
            $client->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
            $this->dispatch('error');
            return;
        }

        $this->dispatch('client-created');
        $this->reset();
        $this->closeModal();
    }
}
