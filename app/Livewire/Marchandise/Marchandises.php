<?php

namespace App\Livewire\Marchandise;

use Livewire\Component;
use App\Models\Marchandise;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class Marchandises extends Component
{
    use WithPagination;
    public $name;
    public $marchandiseId;
    public $editMode = false;

    public $search;

    public function toggleEditMode($id){
        if($this->editMode){
            $this->resetForm();
            return;
        }
        $marchandise = Marchandise::find($id);
        if($marchandise){
            $this->editMode = true;
            $this->marchandiseId = $id;
            $this->name = $marchandise->name;
        }
    }
    public function update($id){
        abort_unless(auth()->user()->can('Modifier Marchandise'), 403);

        $this->validate([
            'name' => 'required|string|max:255|unique:marchandises,name,'.$id,
        ]);

        $marchandise = Marchandise::find($id);
        if($marchandise){
            $marchandise->update([
                'name' => $this->name,
            ]);
            $this->dispatch('marchandise-updated');
            $this->resetForm();
        }
    }
    public function resetForm(){
        $this->editMode = false;
        $this->marchandiseId = null;
        $this->name = null;
    }

    public function delete($id){
        abort_unless(auth()->user()->can('Supprimer Marchandise'), 403);

        $marchandise = Marchandise::find($id);
        if($marchandise){
            $marchandise->delete();
            $this->dispatch('marchandise-deleted');
            $this->resetForm();
        }
    }

    #[On('marchandise-created')]
    #[On('marchandise-updated')]
    #[On('marchandise-deleted')]
    public function render()
    {
        $Marchandises = Marchandise::where('name', 'like', "%{$this->search}%")->orderBy('name', 'ASC')->paginate(10);
        $pageHeader = [
                'title' => 'Marchandises',
                'subtitle' => 'Liste des marchandises',
                'breadcrumbs' => [
                    ['label' => 'Accueil', 'url' => route('home')],
                    ['label' => 'Marchandises'],
                ],
        ];
        return view('livewire.marchandise.marchandises', [
            'marchandises' => $Marchandises,
            'pageHeader' => $pageHeader,
        ])->layout('components.layouts.app', ['title' => 'Marchandises']);
    }


    public function clear_search()
    {
        $this->search = '';
    }
}
