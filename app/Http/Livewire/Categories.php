<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Categories extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $name, $search, $image, $selected_id, $pageTitle, $componentName;
    private $pagination = 5;

    public function mount()
    {
        $this->pageTitle = 'Listado';

        $this->componentName = 'Categorías';
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    protected $listeners = [
        'deleteRow' => 'Destroy'
    ];


    public function render()
    {
        if(strlen($this->search) > 0)
        {
            $data = Category::where('name', 'like', '%'.$this->search.'%')->paginate($this->pagination);
        }else{
            $data = Category::orderBy('id', 'desc')->paginate($this->pagination);
        }

        return view('livewire.category.categories', ['data' => $data,])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    public function Edit($id)
    {
        $record = Category::find($id, ['id', 'name', 'image']);
        $this->name = $record->name;
        $this->selected_id = $record->id;
        $this->image = null;

        $this->emit('show-modal', 'show modal!');
    }

    public function Store()
    {
        $rules = [
            'name' => 'required|unique:categories|min:3',
        ];

        $messages = [
            'name.required' => 'El nombre de la categoria es necesario',
            'name.unique' => 'El nombre de la categoria ya existe',
            'name.min' => 'Se requieren minimo 3 caracteres',
        ];

        $this->validate($rules, $messages);

        $category = Category::create([
            'name' => $this->name,
        ]);

        $customFileName;
        if($this->image)
        {
            $customFileName = uniqid(). '_.' . $this->image->extension();
            $this->image->storeAs('public/categories', $customFileName);

            $category->image = $customFileName;
            $category->save();
        }

        $this->resetUI();

        $this->emit('category-added','categoria registrada');
    }

    public function Update()
    {
        $rules = [
            'name' => "required|min:3|unique:categories,name,{$this->selected_id}",
        ];

        $messages = [
            'name.required' => 'Nombre de categoria requerido',
            'name.min' => 'El nombre de la categoria debe de tener al menos 3 carateres',
            'name.unique' => 'El nombre de la categoria ya existe',
        ];

        $this->validate($rules, $messages);

        $category = Category::find($this->selected_id);
        $category->update([
            'name' => $this->name,
        ]);

        if($this->image)
        {
            $customFileName = uniqid().'_.'.$this->image->extension();
            $this->image->storeAs('public/categories', $customFileName);

            $imageName = $category->image;

            $category->image = $customFileName;
            $category->save();

            if($imageName != null)
            {
                if(file_exists('storage/categories/'.$imageName))
                {
                    unlink('storage/categories/'.$imageName);
                }
            }
        }

        $this->resetUI();
        $this->emit('category-updated', 'Categoria actualizada');
    }

    public function Destroy(Category $category)
    {
        $imageName = $category->image;
        $category->delete();

        if($imageName != null)
        {
            if(file_exists('storage/categories/'.$imageName))
            {
                unlink('storage/categories/'.$imageName);
            }
        }


        $this->resetUI();
        $this->emit('category-deleted', 'Categoria eliminada');
    }

    public function resetUI()
    {
        $this->name = '';
        $this->image = null;
        $this->searchbox = '';
        $this->selected_id = 0;
    }
}
