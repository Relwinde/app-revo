<?php

namespace App\Livewire\BonDeCaisse\Modals;

use App\Models\Document;
use App\Models\BonDeCaisse;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;

class UploadDocuments extends ModalComponent
{

    use WithFileUploads;

    public BonDeCaisse $bon;

    public $file;


    public function render()
    {
        return view('livewire.bon-de-caisse.modals.upload-documents');
    }


    public function save()
    {
        $this->validate([
            'file' => 'required|file|mimes:pdf|max:10240', // Max 10MB
        ], [
            'file.required' => 'Veuillez sélectionner un fichier à télécharger.',
            'file.file' => 'Le fichier doit être un fichier valide.',
            'file.max' => 'Le fichier ne doit pas dépasser 10MB.',
            'file.mimes' => 'Le fichier doit être au format PDF.',
        ]);

        $originalName = strtoupper(preg_replace('/\.pdf$/i', '', $this->file->getClientOriginalName()));

        $fileName = 'JUSTIF_' . str_replace('/', '-', $this->bon->numero) . '.' . $this->file->getClientOriginalExtension();

        $path = $this->file->storeAs('attachments/bons/' . str_replace('/', '-', $this->bon->numero), $fileName);

        Document::create([
            'bon_de_caisse_id' => $this->bon->id,
            'path' => $path,
            'type' => 'JUSTIF',
            'name' => $fileName,
            'uploaded_by' => auth()->id(),
            'size' => $this->file->getSize(),
        ]);

        $this->dispatch('documents-uploaded');
        $this->closeModal();
    }
}
