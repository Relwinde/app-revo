<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    #[On('user-created')]
    public function render()
    {

        $pageHeader = [
            'title' => 'Utilisateurs',
            'subtitle' => 'Liste des utilisateurs du système',
            'breadcrumbs' => [
                ['label' => 'Accueil', 'url' => route('home')],
                ['label' => 'Utilisateurs']
            ]
        ];

        $users = User::orderBy('name', 'asc')->paginate(10);
        return view('livewire.user.users', ['users' => $users, 'pageHeader' => $pageHeader])->layout('components.layouts.app', ['title' => 'Liste des utilisateurs']);
    }

    public function delete($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            $this->dispatch('user-deleted');
        }
    }
}
