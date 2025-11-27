<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TechnicalSpecificationOne extends Component
{
    /**
     * Create a new component instance.
     */
    public $headingNumber;
    public $headingText;
    public $items;

    public function __construct($headingNumber = '2.', $headingText = 'TECHNICAL SPECIFICATION OF MIXER', $items = [])
    {
        $this->headingNumber = $headingNumber;
        $this->headingText = $headingText;
        $this->items = $items;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.technical-specification-one');
    }
}
