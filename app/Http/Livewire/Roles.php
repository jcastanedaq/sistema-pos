<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Roles extends Component
{
    public function render()
    {
        return view('livewire.roles.component')
        ->extends('layout.theme.app')
        ->section('content');
    }
}
