<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class Roles extends Component
{
    use WithPagination;

    public $roleName, $search, $selected_id, $pageTitle, $componentName;
    private $pagination = 5;

    protected $listeners = [
        'destroy' => 'destroy'
    ];

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Roles';
    }
    

    public function render()
    {
        if(strlen($this->search) > o)
            $roles = Role::where('name', 'like', '%'.$this->search.'%')->paginate($this->pagination);
        else
        $roles = Role::orderBy('name', 'asc')->paginate($this->pagination);

        return view('livewire.roles.component',[
            'roles' => $this->roles
        ])
        ->extends('layout.theme.app')
        ->section('content');
    }

    public function CreateRole()
    {
        $rules = [
            'roleName' => 'required|min:2|unique:roles,name',
        ];

        $messages = [
            'roleName.required' => 'El nom,bre del Rol es requerido',
            'roleName.unique' => 'El Rol ya existe',
            'roleName.min' => 'El nombre del Rol debe tener al menos 2 caracteres'
        ];

        $this->validate($rules, $messages);

        Role::create([
            'name' => $this->roleName,
        ]);

        $this->emit('role-added', 'Se registro el Rol con exito');
        $this->resetUI();
    }

    public function Edit(Role $role)
    {
        $this->selected_id = $role->id;
        $this->roleName = $role->name;

        $this->emit('show-modal','Show modal');
    }

    public function UpdateRole()
    {
        $rules = [
            'roleName' => "required|min:2|unique:roles,name, {$this->selected_id}",
        ];

        $messages = [
            'roleName.required' => 'El nom,bre del Rol es requerido',
            'roleName.unique' => 'El Rol ya existe',
            'roleName.min' => 'El nombre del Rol debe tener al menos 2 caracteres'
        ];

        $this->validate($rules, $messages);

        $role = Role::find($this->selected_id);

        $role->name = $this->roleName;

        $role->save();

        $this->emit('role-update', 'Se actualizo el Rol con éxito');
        $this->resetUI();
    }

    public function Destroy($id)
    {
        $permissionsCount = Role::find($id)->permissions->count();

        if($permissionsCount > 0)
        {
            $this->emit('role-error', 'No se puede eliminar porque tiene permisos asociados');
            return;
        }

        Role::find($id)->delete();

        $this->emit('role-deleted', 'Se elimino el Rol con éxito');
    }

    public function resetUI()
    {
        $this->roleName = '';
        $this->search = '';
        $this->selected_id = 0;
    }
}
