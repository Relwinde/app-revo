<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Header extends Component
{
    public function mount()
    {
        Auth::logout();

        Session::invalidate();

        Session::regenerateToken();

        $this->redirect('/login');
    }

    public function render()
    {
        // return view('livewire.user.header');
    }
}
