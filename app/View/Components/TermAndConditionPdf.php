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
    
   public $termCondition;
   public function __construct(object $termCondition)
    {
        $this->termCondition=$termCondition;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.term-and-condition-pdf');
    }
}
