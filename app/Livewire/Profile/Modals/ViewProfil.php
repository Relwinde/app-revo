<?php

namespace App\Livewire\Profile\Modals;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use LivewireUI\Modal\ModalComponent;
use Spatie\Permission\Models\Permission;

class ViewProfil extends ModalComponent
{
    public Role $profile;

    public function render()
    {

        $profile_permissions = $this->profile->permissions;

        $assignedIds = $profile_permissions->pluck('id')->all();

        if (empty($assignedIds)) {
            $ungiven_permissions = Permission::all();
        } else {
            $ungiven_permissions = Permission::whereNotIn('id', $assignedIds)->get();
        }


        return view('livewire.profile.modals.view-profil', ['profile_permissions' => $profile_permissions, 'ungiven_permissions'=>$ungiven_permissions]);
    }

    /**
     * Supported: 'sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl', '7xl'
     */
    public static function modalMaxWidth(): string
    {
        return '2xl';
    }

    public function addPermission (Permission $permission){
        abort_unless(auth()->user()->can('Modifier Profil'), 403);

        $this->profile->givePermissionTo($permission->name);
    }

    public function removePermission (Permission $permission){
        abort_unless(auth()->user()->can('Modifier Profil'), 403);

        $this->profile->revokePermissionTo($permission->name);
    }
}
