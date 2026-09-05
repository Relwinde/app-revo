<?php

namespace App\Livewire\Client\Modals;

use App\Models\Client;
use Exception;
use Illuminate\Support\Facades\DB;
use LivewireUI\Modal\ModalComponent;

class EditClient extends ModalComponent
{

    public Client $client;

    public $name;
    public $email;
    public $phone;
    public $address;
    public $rccm;
    public $ifu;
    public $div_fisc;
    public $code;

    public function mount(){
        $this->name = $this->client->name;
        $this->email = $this->client->email;
        $this->phone = $this->client->phone;
        $this->address = $this->client->address;
        $this->rccm = $this->client->rccm;
        $this->ifu = $this->client->ifu;
        $this->div_fisc = $this->client->div_fisc;
        $this->code = $this->client->code;
    }

    public function render()
    {
        return view('livewire.client.modals.edit-client');
    }

    public function save (){
         $this->validate(
            [
                'name' => ['required', 'string', 'max:255', 'unique:clients,name,'.$this->client->id],
                'email' => ['nullable', 'email', 'unique:clients,email,'.$this->client->id],
                'phone' => ['nullable', 'string', 'max:50'],
                'address' => ['nullable', 'string'],
                'div_fisc' => ['nullable', 'string'],
                'rccm' => ['nullable', 'string', 'unique:clients,rccm,'.$this->client->id],
                'ifu' => ['nullable', 'string', 'unique:clients,ifu,'.$this->client->id],
                'code' => ['required', 'string', 'max:255', 'unique:clients,code,'.$this->client->id],
            ],
            [
                'name.required' => 'Le nom du client est obligatoire.',
                'name.unique' => 'Ce client existe déjà.',
                'email.email' => 'Adresse email invalide.',
                'email.unique' => 'Cet email est déjà utilisé.',
                'rccm.unique' => 'Ce RCCM existe déjà.',
                'ifu.unique' => 'Cet IFU existe déjà.',
                'code.required' => 'Le code du client est obligatoire.',
                'code.unique' => 'Ce code client existe déjà.',
            ]
        );

        try{
            DB::beginTransaction();
                $this->client->update([
                'name' => mb_strtoupper($this->name, 'UTF-8'),
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'rccm' => $this->rccm,
                'ifu' => $this->ifu,
                'div_fisc' => $this->div_fisc,
                'code' => mb_strtoupper($this->code, 'UTF-8'),]
                );
            DB::commit();

        }

        catch (Exception $ex){
            DB::rollBack();
            throw $ex;
            $this->dispatch('error');
            return;
        }

        $this->dispatch('client-created');
        $this->reset();
        $this->closeModal();
    }
}
