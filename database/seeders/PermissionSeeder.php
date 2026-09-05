<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Client
            'Voir Clients', 'Créer Client', 'Modifier Client', 'Supprimer Client',
            // Fournisseur
            'Voir Fournisseurs', 'Créer Fournisseur', 'Modifier Fournisseur', 'Supprimer Fournisseur',
            // Camion
            'Voir Camions', 'Créer Camion', 'Modifier Camion', 'Supprimer Camion',
            // Chauffeur
            'Voir Chauffeurs', 'Créer Chauffeur', 'Modifier Chauffeur', 'Supprimer Chauffeur',
            // Marchandise
            'Voir Marchandises', 'Créer Marchandise', 'Modifier Marchandise', 'Supprimer Marchandise',
            // Utilisateur
            'Voir Utilisateurs', 'Créer Utilisateur', 'Supprimer Utilisateur',
            // Profil (rôle)
            'Voir Profil', 'Créer Profil', 'Modifier Profil',
            // Dossier
            'Voir Dossier', 'Créer Dossier', 'Modifier Dossier', 'Imprimer Ordre de Mission',
            'Imprimer Manifeste', 'Générer Facture Définitive', 'Attacher Commande à Dossier',
            'Détacher Commande de Dossier',
            // Commande
            'Voir Commande', 'Créer Commande', 'Modifier Commande',
            // Bon de caisse
            'Voir Bons de caisse', 'Créer Bon de caisse', 'Voir Bon de caisse', 'Modifier Bon de caisse',
            'Envoyer bon de caisse pour validation', 'Envoyer bon de caisse à la caisse',
            'Payer bon de caisse', 'Clore bon de caisse', 'Faire un ajustement sur bon de caisse',
            'Imprimer reçu bon de caisse', 'Annuler Bon de caisse', 'Retourner Bon de caisse',
            'Joindre document bon de caisse', 'Télécharger document bon de caisse',
            // Caisse
            'Voir Caisse', 'Créer Dépôt caisse', 'Imprimer Dépôt caisse', 'Voir Dépôt caisse',
            // Facture
            'Voir Facture', 'Modifier Facture', 'Supprimer ligne Facture', 'Imprimer Facture',
            // Facture Proforma
            'Voir Facture Proforma', 'Créer Facture Proforma', 'Modifier Facture Proforma',
            'Supprimer ligne Facture Proforma', 'Imprimer Facture Proforma',
            // Entreprise
            'Voir Entreprise', 'Modifier Entreprise',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $superAdmin = Role::firstOrCreate(['name' => 'Super-Admin']);
        $superAdmin->syncPermissions($permissions);
    }
}
