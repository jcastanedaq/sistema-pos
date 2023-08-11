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

    public $componentName, $pageTitle;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->componentName = 'Denominaciones';
        $this->pageTitle = 'Listado';
    }
    public function render()
    {
        return view('livewire.denomination.component', [
            'data' => Denomination::paginate(10)
        ])
        ->extends('layouts.theme.app')->section('content');
    }
}
