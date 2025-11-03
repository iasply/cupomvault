<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CupomCard extends Component
{
    public $cupons;

    public function __construct($cupons)
    {
        $this->cupons = $cupons;
    }

    public function render()
    {
        return view('components.cupom-card');
    }
}
