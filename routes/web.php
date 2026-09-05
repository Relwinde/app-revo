<?php

use App\Livewire\BonDeCaisse\BonDeCaisses;
use App\Livewire\Caisse\Caisses;
use App\Livewire\Camion\Camions;
use App\Livewire\Chauffeur\Chauffeurs;
use App\Livewire\Client\Clients;
use App\Livewire\Commande\Commandes;
use App\Livewire\Dossier\Dossiers;
use App\Livewire\Entreprise\EntrepriseSettings;
use App\Livewire\Facture\EditFacture;
use App\Livewire\Facture\Factures as FacturesDefinitives;
use App\Livewire\FactureProforma\CreateFacture;
use App\Livewire\FactureProforma\EditFacture as EditFactureProforma;
use App\Livewire\FactureProforma\Factures as FactureProformas;
use App\Livewire\Fournisseur\Fournisseurs;
use App\Livewire\Home;
use App\Livewire\Login;
use App\Livewire\Marchandise\Marchandises;
use App\Livewire\Profile\Profiles;
use App\Livewire\User\Header;
use App\Livewire\User\Users;
use App\Models\BonDeCaisse;
use App\Models\Depot;
use App\Models\Document;
use App\Models\Dossier;
use App\Models\Facture;
use App\Models\FactureProforma;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', Home::class)->name('home')->middleware('auth');
Route::get('/login', Login::class)->name('login');
Route::get('/logout', Header::class)->name('logout')->middleware('auth');
Route::get('/users', Users::class)->name('users')->middleware(['auth', 'can:Voir Utilisateurs']);
Route::get('/clients', Clients::class)->name('clients')->middleware(['auth', 'can:Voir Clients']);

Route::get('/fournisseurs', Fournisseurs::class)->name('fournisseurs')->middleware(['auth', 'can:Voir Fournisseurs']);

Route::get('/chauffeurs', Chauffeurs::class)->name('chauffeurs')->middleware(['auth', 'can:Voir Chauffeurs']);

Route::get('/camions', Camions::class)->name('camions')->middleware(['auth', 'can:Voir Camions']);

Route::get('/profils', Profiles::class)->name('profils')->middleware(['auth', 'can:Voir Profil']);

Route::get('/parametres/entreprise', EntrepriseSettings::class)->name('parametres.entreprise')->middleware(['auth', 'can:Voir Entreprise']);

Route::get('/dossiers', Dossiers::class)->name('operations')->middleware(['auth', 'can:Voir Dossier']);

Route::get('/commandes', Commandes::class)->name('commandes')->middleware(['auth', 'can:Voir Commande']);

Route::get('/caisses', Caisses::class)->name('caisses')->middleware(['auth', 'can:Voir Caisse']);
Route::get('/marchandises', Marchandises::class)->name('marchandises')->middleware(['auth', 'can:Voir Marchandises']);

Route::get('/bon-de-caisses', BonDeCaisses::class)->name('bon-de-caisses')->middleware(['auth', 'can:Voir Bons de caisse']);


Route::get('/print-ordre-mission/{dossier}', function (Dossier $dossier) {
    return $dossier->print_ordre_mission();

})->name('print-ordre-mission')->middleware(['auth', 'can:Imprimer Ordre de Mission']);

Route::get('/print-manifest/{dossier}', function (Dossier $dossier) {
    return $dossier->print_manifest();

})->name('print-manifest')->middleware(['auth', 'can:Imprimer Manifeste']);

Route::get('/print-recu-bon/{bon}', function (BonDeCaisse $bon) {
    return $bon->print_recu();

})->name('print-recu-bon')->middleware(['auth', 'can:Imprimer reçu bon de caisse']);

Route::get('/print-depot/{depot}', function (Depot $depot) {
    return $depot->print_depot();

})->name('print-depot')->middleware(['auth', 'can:Imprimer Dépôt caisse']);


Route::get('/download-document/{document}', function (Document $document) {
    return response()->download(storage_path('app/' . $document->path), $document->name);
})->name('download-document')->middleware(['auth', 'can:Télécharger document bon de caisse']);

Route::get('/facture-proformas', FactureProformas::class)->name('facture-proformas')->middleware(['auth', 'can:Voir Facture Proforma']);

Route::get('/facture-proformas/create', CreateFacture::class)->name('create-facture-proforma')->middleware(['auth', 'can:Créer Facture Proforma']);

Route::get('print-proforma/{facture}', function (FactureProforma $facture){
    return $facture->print();
})->name('print-facture-proforma')->middleware(['auth', 'can:Imprimer Facture Proforma']);

Route::get('/view-facture-proformas/{facture}', EditFactureProforma::class)->name('view-facture-proforma')->middleware(['auth', 'can:Voir Facture Proforma']);

Route::get('/facture-definitives', FacturesDefinitives::class)->name('facture-definitives')->middleware(['auth', 'can:Voir Facture']);

Route::get('/view-facture-definitives/{facture}', EditFacture::class)->name('view-facture')->middleware(['auth', 'can:Voir Facture']);

Route::get('print-facture/{facture}', function (Facture $facture){
    return $facture->print();
})->name('print-facture')->middleware(['auth', 'can:Imprimer Facture']);