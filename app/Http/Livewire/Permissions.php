<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class Permissions extends Component
{
    use WithPagination;

    public $permissionName, $search, $selected_id, $pageTitle, $componentName;
    private $pagination = 10;

    protected $listeners = [
        'Destroy' => 'Destroy'
    ];

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Permisos';
    }
    

    public function render()
    {
        if(strlen($this->search) > 0)
            $permissions = Permission::where('name', 'like', '%'.$this->search.'%')->paginate($this->pagination);
        else
        $permissions = Permission::orderBy('name', 'asc')->paginate($this->pagination);

        return view('livewire.permissions.component',[
            'permissions' => $permissions
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    public function CreatePermission()
    {
        $rules = [
            'permissionName' => 'required|min:2|unique:permissions,name',
        ];

        $messages = [
            'permissionName.required' => 'El nombre del Permiso es requerido',
            'permissionName.unique' => 'El Permiso ya existe',
            'rolepermissionNameName.min' => 'El nombre del Permiso debe tener al menos 2 caracteres'
        ];

        $this->validate($rules, $messages);

        Permission::create([
            'name' => $this->permissionName,
        ]);

        $this->emit('permission-added', 'Se registro el Permiso con exito');
        $this->resetUI();
    }

    public function Edit(Permission $permission)
    {
        $this->selected_id = $permission->id;
        $this->permissionName = $permission->name;

        $this->emit('show-modal','Show modal');
    }

    public function UpdatePermission()
    {
        $rules = [
            'permissionName' => "required|min:2|unique:permissions,name, {$this->selected_id}",
        ];

        $messages = [
            'permissionName.required' => 'El nom,bre del Rol es requerido',
            'permissionName.unique' => 'El Rol ya existe',
            'rolpermissionNameeName.min' => 'El nombre del Rol debe tener al menos 2 caracteres'
        ];

        $this->validate($rules, $messages);

        $permission = Permission::find($this->selected_id);

        $permission->name = $this->permissionName;

        $permission->save();

        $this->emit('permission-updated', 'Se actualizo el Permiso con éxito');
        $this->resetUI();
    }

    public function Destroy($id)
    {
        $rolesCount = Permission::find($id)->getRoleNames()->count();

        if($rolesCount > 0)
        {
            $this->emit('permission-error','No se puede eliminar el Permiso por que tiene roles asociados.');
            return;
        }
        
        Permission::find($id)->delete();

        $this->emit('permission-deleted', 'Se elimino el Permiso con éxito');
    }

    public function resetUI()
    {
        $this->permissionName = '';
        $this->search = '';
        $this->selected_id = 0;
        $this->resetValidation();
    }
}
