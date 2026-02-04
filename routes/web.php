<?php

use App\Livewire\Home;
use App\Livewire\Login;
use App\Models\Dossier;
use App\Models\BonDeCaisse;
use App\Livewire\User\Users;
use App\Livewire\User\Header;
use App\Livewire\Caisse\Caisses;
use App\Livewire\Camion\Camions;
use App\Livewire\Client\Clients;
use App\Livewire\Dossier\Dossiers;
use App\Livewire\Profile\Profiles;
use App\Livewire\Commande\Commandes;
use Illuminate\Support\Facades\Route;
use App\Livewire\Chauffeur\Chauffeurs;
use App\Livewire\BonDeCaisse\BonDeCaisses;
use App\Livewire\Fournisseur\Fournisseurs;
use App\Livewire\Marchandise\Marchandises;
use App\Models\Depot;

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
Route::get('/users', Users::class)->name('users')->middleware('auth');
Route::get('/clients', Clients::class)->name('clients')->middleware('auth');

Route::get('/fournisseurs', Fournisseurs::class)->name('fournisseurs')->middleware('auth');   

Route::get('/chauffeurs', Chauffeurs::class)->name('chauffeurs')->middleware('auth');

Route::get('/camions', Camions::class)->name('camions')->middleware('auth');

Route::get('/profils', Profiles::class)->name('profils')->middleware('auth');

Route::get('/dossiers', Dossiers::class)->name('operations')->middleware('auth');

Route::get('/commandes', Commandes::class)->name('commandes')->middleware('auth');

Route::get('/caisses', Caisses::class)->name('caisses')->middleware('auth');
Route::get('/marchandises', Marchandises::class)->name('marchandises')->middleware('auth');

Route::get('/bon-de-caisses', BonDeCaisses::class)->name('bon-de-caisses')->middleware('auth');


Route::get('/print-ordre-mission/{dossier}', function (Dossier $dossier) {
    return $dossier->print_ordre_mission();
    
})->name('print-ordre-mission')->middleware('auth');

Route::get('/print-manifest/{dossier}', function (Dossier $dossier) {
    return $dossier->print_manifest();
    
})->name('print-manifest')->middleware('auth');

Route::get('/print-recu-bon/{bon}', function (BonDeCaisse $bon) {
    return $bon->print_recu();
    
})->name('print-recu-bon')->middleware('auth');

Route::get('/print-depot/{depot}', function (Depot $depot) {
    return $depot->print_depot();
    
})->name('print-depot')->middleware('auth');