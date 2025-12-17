<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name'=>'Voir Profil']);
        Permission::create(['name'=>'Modifier Profil']);
        Permission::create(['name'=>'Créer Profil']);
        
    }
}
