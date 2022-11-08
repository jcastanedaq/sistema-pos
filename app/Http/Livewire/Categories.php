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
        $data = Category::all();

        return view('livewire.category.categories', ['data' => $data,])
        ->extends('layouts.theme.app')
        ->section('content');
    }
}
