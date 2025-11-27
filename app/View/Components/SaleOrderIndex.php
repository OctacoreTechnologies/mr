<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use PhpOffice\PhpSpreadsheet\Calculation\Logical\Boolean;

class SaleOrderIndex extends Component
{
    /**
     * Create a new component instance.
     */
    public $salesOrders;
    public $createBtn;

    public $advancePdf;

    public $title;

    public $edit;
    public $oalPdf;
    public function __construct(object $salesOrders,$createBtn=true,$advancePdf=false,$title='Total Orders',$edit='saleOrder',$oalPdf=false)
    {
        $this->salesOrders = $salesOrders;
        $this->createBtn = $createBtn;
        $this->advancePdf = $advancePdf;
        $this->title = $title;
        $this->edit = $edit;
        $this->oalPdf = $oalPdf;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sale-order-index');
    }
}
