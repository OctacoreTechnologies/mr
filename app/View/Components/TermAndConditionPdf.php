<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TermAndConditionPdf extends Component
{
    /**
     * Create a new component instance.
     */
    
   public $termCondition,$headingNumber;

   public function __construct(object $termCondition,$headingNumber=4)
    {
        $this->termCondition=$termCondition;
        $this->headingNumber=$headingNumber;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.term-and-condition-pdf');
    }
}
