<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CarPurchaseForm extends Component
{
    public $price;

    public function __construct($price = 0)
    {
        $this->price = $price;
    }

    public function render()
    {
        return view('components.car-purchase-form');
    }
}