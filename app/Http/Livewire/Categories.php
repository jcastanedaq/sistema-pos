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
}
