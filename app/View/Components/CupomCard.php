<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CupomCard extends Component
{
    public $cupom;

    public function __construct($cupom)
    {
        $this->cupom = $cupom;
    }

    public function render()
    {
        return view('components.cupom-card');
    }
}
