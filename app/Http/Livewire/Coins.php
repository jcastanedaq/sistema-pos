<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Denomination;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Coins extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $selected_id, $type, $value, $image;
    public $componentName, $pageTitle;
    public $search;

    private $pagination = 10;

    protected $listeners = [
        'deleteRow' => 'Destroy'
    ];

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->componentName = 'Denominaciones';
        $this->pageTitle = 'Listado';
        $this->selected_id = 0;
    }
    public function render()
    {
        if(strlen($this->search) > 0)
            $data = Denomination::where('type', 'like', '%'.$this->search.'%')->paginate($this->pagination);
        else
            $data = Denomination::orderBy('id','desc')->paginate($this->pagination);


        return view('livewire.denomination.component', [
            'data' => $data
        ])
        ->extends('layouts.theme.app')->section('content');
    }

    public function Edit(Denomination $denomination)
    {
        $this->type = $denomination->type;
        $this->value = $denomination->value;
        $this->image = null;

        $this->selected_id = $denomination->id;

        $this->emit('modal-show', 'show modal!');
    }

    public function Store()
    {
        $rules = [
            'type' => 'required|not_in:Elegir',
            'value' => 'required|unique:denominations'
        ];

        $messages = [
            'type.required' => 'El tipo es requerido',
            'type.not_in' => 'Eligue un valor para el tipo distinto a elegir',
            'value.required' => 'el valor es requerido',
            'value.unique' => 'ya existe el valor'
        ];

        $this->validate($rules, $messages);

        $denomination = Denomination::create([
            'type' => $this->type,
            'value' => $this->value
        ]);

        if($this->image)
        {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/denominations', $customFileName);
            $denomination->image = $customFileName;
            $denomination->save();
        }

        $this->resetUI();

        $this->emit('item-added', 'Denominacion registrada');
    }

    public function Update()
    {
        $rules = [
            'type' => 'required|not_in:Elegir',
            'value' => "required|unique:denominations,value,{$this->selected_id}"
        ];

        $messages = [
            'type.required' => 'El tipo es requerido',
            'type.not_in' => 'Eligue un valor para el tipo distinto a elegir',
            'value.required' => 'el valor es requerido',
            'value.unique' => 'ya existe el valor'
        ];

        $this->validate($rules, $messages);

        $denomination = Denomination::find($this->selected_id);
        $denomination->update([
            'type' => $this->type,
            'value' => $this->value,
        ]);

        if($this->image)
        {
            $customFileName = uniqid(). '_.' . $this->image->extension();
            $this->image->storeAs('public/denominations', $customFileName);
            $imageName = $denomination->image;

            $denomination->image = $customFileName;
            $denomination->save();

            if($imageName != null)
            {
                if(file_exists('storage/denominations'. $imageName))
                {
                    unlink('storage/denominations'. $imageName);
                }
            }
        }

        $this->resetUI();

        $this->emit('item-updated', 'Denominacion actualzada');
    }

    public function Destroy(Denomination $denomination)
    {
        $imageName = $denomination->image;
        $denomination->delete();

        if($imageName != null)
        {
            if(file_exists('storage/denominations/'.$imageName))
            {
                unlink('storage/denominations/'.$imageName);
            }
        }


        $this->resetUI();
        $this->emit('item-deleted', 'Denominacion eliminada');
    }

    public function resetUI()
    {
        $this->type = '';
        $this->value = '';
        $this->image = null;
        $this->search = '';
        $this->selected_id = 0;
    }
}
