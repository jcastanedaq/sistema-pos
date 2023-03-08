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

    public function resetUI()
    {
        $this->name = '';
        $this->image = null;
        $this->searchbox = '';
        $this->selected_id = 0;
    }
}
