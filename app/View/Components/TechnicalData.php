<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TechnicalData extends Component
{
    /**
     * Create a new component instance.
     */
   public $quotation;
    public function __construct(object $quotation)
    {
        $this->quotation=$quotation;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.technical-data');
    }
}
