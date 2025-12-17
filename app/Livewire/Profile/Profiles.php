<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class Profiles extends Component
{

    use WithPagination;

    #[On('profile-created')]
    public function render()
    {
        $pageHeader = [
            'title' => 'Profiles',
            'subtitle' => 'Liste des profiles du système',
            'breadcrumbs' => [
                ['label' => 'Accueil', 'url' => route('home')],
                ['label' => 'Profiles']
            ]
        ];

        $profils = Role::orderBy('name', 'ASC')->paginate(10);
    
        return view('livewire.profile.profiles', ['profils' => $profils, 'pageHeader' => $pageHeader])->layout('components.layouts.app', ['title' => 'Liste des profils']);
    }
}
