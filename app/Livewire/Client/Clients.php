<?php

namespace App\Livewire\Client;

use App\Models\Client;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class Clients extends Component
{
    use WithPagination;

    public $editMode = false;
    public $clientId;

    public $search;

    public $name;
    public $email;
    public $phone;
    public $address;
    public $rccm;
    public $ifu;

    public function toggleEditMode($id)
    {
        if ($this->editMode) {
            $this->reset([
                'editMode',
                'clientId',
                'name',
                'email',
                'phone',
                'address',
                'rccm',
                'ifu',
            ]);

            $this->editMode = false;
            return;
        }

        $client = Client::find($id);
        if ($client) {
            $this->editMode = true;
            $this->clientId = $id;

            $this->name = $client->name;
            $this->email = $client->email;
            $this->phone = $client->phone;
            $this->address = $client->address;
            $this->rccm = $client->rccm;
            $this->ifu = $client->ifu;
        }
    }

    #[On('client-created')]
    #[On('client-updated')]
    #[On('client-deleted')]
    public function render()
    {
        $clients = Client::where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%")
                    ->orWhere('phone', 'like', "%{$this->search}%")
                    ->orWhere('rccm', 'like', "%{$this->search}%")
                    ->orWhere('ifu', 'like', "%{$this->search}%")
                    ->orderBy('name', 'asc')->paginate(10);

        $pageHeader = [
            'title' => 'Clients',
            'subtitle' => 'Liste des clients',
            'breadcrumbs' => [
                ['label' => 'Accueil', 'url' => route('home')],
                ['label' => 'Clients']
            ]
        ];

        return view('livewire.client.clients', [
            'clients' => $clients,
            'pageHeader' => $pageHeader
        ])->layout('components.layouts.app', ['title' => 'Clients']);
    }

    public function update($id)
    {
        $this->validate(
            [
                'name' => ['required', 'string', 'max:255', Rule::unique('clients')->ignore($id)],
                'email' => ['nullable', 'email', Rule::unique('clients')->ignore($id)],
                'phone' => 'nullable|string|max:50',
                'address' => 'nullable|string',
                'rccm' => ['nullable', Rule::unique('clients')->ignore($id)],
                'ifu' => ['nullable', Rule::unique('clients')->ignore($id)],
            ],
            [
                'name.required' => 'Le nom du client est obligatoire.',
                'name.unique' => 'Ce client existe déjà.',
                'email.email' => 'Email invalide.',
                'email.unique' => 'Cet email est déjà utilisé.',
                'rccm.unique' => 'Ce RCCM existe déjà.',
                'ifu.unique' => 'Cet IFU existe déjà.',
            ]
        );

        $client = Client::find($id);

        if ($client) {
            $client->update([
                'name' => mb_strtoupper($this->name, 'UTF-8'),
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'rccm' => $this->rccm,
                'ifu' => $this->ifu,
            ]);

            $this->dispatch('client-updated');
            $this->reset([
                'editMode',
                'clientId',
                'name',
                'email',
                'phone',
                'address',
                'rccm',
                'ifu',
            ]);
        }
    }


    public function delete($id)
    {
        $client = Client::find($id);

        if ($client) {
            $client->delete();
            $this->dispatch('client-deleted');
        }
    }

    public function clear_search()
    {
        $this->search = '';
    }

}
