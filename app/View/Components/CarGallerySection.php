<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CarGallerySection extends Component
{
    public $car;
    public $eksteriorImages;
    public $interiorImages;

    /**
     * Create a new component instance.
     */
    public function __construct($car, $eksteriorImages = [], $interiorImages = [])
    {
        $this->car = $car;
        $this->eksteriorImages = $eksteriorImages;
        $this->interiorImages = $interiorImages;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.car-gallery-section');
    }
}
