<?php

namespace App\Livewire;

use App\Models\Hero;
use Livewire\Component;

class Home extends Component
{
    public $heros;

    public function mount()
    {
        $this->heros = Hero::all();
    }

    public function render()
    {
        return view('livewire.home');
    }
}
