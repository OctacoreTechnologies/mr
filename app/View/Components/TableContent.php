<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TableContent extends Component
{
    /**
     * Create a new component instance.
     */
    public   $specification="MIXER";
    public $pageTechnicalData="3";
    public $pageSpecification="4";
    public $pageOffer="7";
    public $pageTerms="8";
    public function __construct($specification,$pageTechnicalData,$pageSpecification,$pageOffer,$pageTerms)
    {
        $this->specification=$specification;
        $this->pageTechnicalData = $pageTechnicalData;
        $this->pageSpecification = $pageSpecification;
        $this->pageOffer = $pageOffer;
        $this->pageTerms = $pageTerms;
        
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table-content');
    }
}
