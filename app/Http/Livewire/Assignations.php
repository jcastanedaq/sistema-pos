<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Http\Livewire\Permissions;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Assignations extends Component
{
    use WithPagination;

    public $role, $componentName, $permissionsSelected = [], $oldPermissions = [];
    private $pagination = 10;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->role = 'Elegir';
        $this->componentName = 'Asignar Permisos';
    }
    
    public function render()
    {
        $permissions = Permission::select('name','id', DB::raw("0 as checked"))
        ->orderBy('name', 'asc')
        ->paginate($this->pagination);

        if($this->role != 'Elegir')
        {
            $list = Permission::join('role_has_permissions as rp', 'rp.permission_id', 'permissions.id')
            ->where('role_id', $this->role)->pluck('permissions.id')->toArray();

            $this->oldPermissions = $list;
        }

        if($this->role != 'Elegir')
        {
            foreach($permissions as $permission)
            {
                $role = Role::find($this->role);
                $hasPermission = $role->hasPermissionTo($permission->name);
                if($hasPermission)
                {
                    $permission->checked = 1;
                }
            }
        }


        return view('livewire.assignations.component', [
            'roles' => Role::orderBy('name', 'asc')->get(),
            'permissions' => $permissions,
        ])->extends('layouts.theme.app')->section('content');
    }

    public $listeners = [
        'revokeall' => 'RemoveAll',
    ];

    public function RemoveAll()
    {
        if($this->role == 'Elegir')
        {
            $this->emit('sync-error', 'Selecciona un Rol valido');
            return;
        }

        $role = Role::find($this->role);
        $role->syncPermissions([0]);

        $this->emit('removeAll', "Se revocaron todos los permisos al Rol $role->name");
    }

    public function SyncAll()
    {
        if($this->role == 'Elegir')
        {
            $this->emit('sync-error', 'Selecciona un Rol valido');
            return;
        }

        $role = Role::find($this->role);
        $permissions = Permission::pluck('id')->toArray();

        $role->syncPermissions($permissions);

        $this->emit('syncAll', "Se sicronizaron todos los permisos al Rol $role->name");
    }

    public function syncPermission($state, $permissionName)
    {
        if($this->role != 'Elegir')
        {
            $roleName = Role::find($this->role);

            if($state)
            {
                $roleName->givePermissionTo($permissionName);
                $this->emit('permi', "Permiso asignado correctamente");
            }else{
                $roleName->revokePermissionTo($permissionName);
                $this->emit('permi', "Permiso revocado correctamente");
            }
        } else {
            $this->emit('sync-error', 'Selecciona un Rol valido');
        }


    }
}
