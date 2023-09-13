<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Denomination;

class Pos extends Component
{
    public $total = 800, $cart = [], $itemsQuantity = 0, $denominations = [], $efectivo = 10000, $change = 200;
    public function render()
    {
        $this->denominations = Denomination::all();
        return view('livewire.pos.component')
        ->extends('layouts.theme.app')->section('content');
    }
}
