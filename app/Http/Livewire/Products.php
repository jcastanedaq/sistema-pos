<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Products extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $name, $barcode, $cost, $price, $stock, $alerts, $categoryid, $search, $image, $selected_id, $pageTitle, $componentName;

    private $pagination = 5;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Productos';
        $this->category_id = 'Selecciona..';
    }
    
    public function render()
    {
        if(strlen($this->search) > 0)
            $products = Product::join('categories as c', 'c.id','products.category_id')
                ->select('products.*', 'c.name as category')
                ->where('products.name', 'like', '%'. $this->search . '%')
                ->orWhere('products.barcode', 'like', '%'. $this->search . '%')
                ->orWhere('c.name', 'like', '%'. $this->search . '%')
                ->orderBy('products.name', 'asc')
                ->paginate($this->pagination);
        else
            $products = Product::join('categories as c', 'c.id','products.category_id')
                ->select('products.*', 'c.name as category')
                ->orderBy('products.name', 'asc')
                ->paginate($this->pagination);


        return view('livewire.products.component', [
            'data' => $products,
            'categories' => Category::orderBy('name', 'asc')->get(),
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }
}
