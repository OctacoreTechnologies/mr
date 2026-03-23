<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Offer extends Component
{
    /**
     * Create a new component instance.
     */
   public $quotation;
   public $words;

   public $headingNumber;
    public function __construct(object $quotation,$words,$headingNumber='3')
    {
        $this->quotation=$quotation;
        $this->words=$words;
        $this->headingNumber=$headingNumber;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.offer');
    }
}
