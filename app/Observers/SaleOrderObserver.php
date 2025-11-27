<?php

namespace App\Observers;

use App\Models\OrderAcceptanceLetter;
use App\Models\SaleOrder;

class SaleOrderObserver
{
    /**
     * Handle the SaleOrder "created" event.
     */
    public function created(SaleOrder $saleOrder): void
    {
        if(is_null($saleOrder->work_order_no)){
          $this->setWorkOrderNoBasedOnMachineName($saleOrder);
        }
        OrderAcceptanceLetter::create([
            'sale_order_id'=>$saleOrder->id,
            'machine_id' => $saleOrder->quotation->machine_id,
            'model'=>$saleOrder->quotation->modele->production,
        ]);

    }

    /**
     * Handle the SaleOrder "updated" event.
     */
    public function updated(SaleOrder $saleOrder): void
    {
        //
    }

    /**
     * Handle the SaleOrder "deleted" event.
     */
    public function deleted(SaleOrder $saleOrder): void
    {
        OrderAcceptanceLetter::where('sale_order_id',$saleOrder)->delete();
    }

    /**
     * Handle the SaleOrder "restored" event.
     */
    public function restored(SaleOrder $saleOrder): void
    {
        //
    }

    /**
     * Handle the SaleOrder "force deleted" event.
     */
    public function forceDeleted(SaleOrder $saleOrder): void
    {
        //
    }

    protected function setWorkOrderNoBasedOnMachineName(SaleOrder $saleOrder): void{
       
        if($saleOrder->quotation->machine->name=='High Speed Heater Mixer'){
                $saleOrder->work_order_no = SaleOrder::countWorkOrdersByWorkOrderNo('MR/M-056/');
                // $total=SaleOrder::countWorkOrdersByWorkOrderNo('M-056');
            }
            elseif($saleOrder->quotation->machine->name=='Vertical Cooler Mixer'){
                // $total=SaleOrder::countWorkOrdersByWorkOrderNo('M-060');
                $saleOrder->work_order_no = SaleOrder::countWorkOrdersByWorkOrderNo('MR/M-060/');;
            }
            elseif($saleOrder->quotation->machine->name=='Horizontal Cooler Mixer'){
                // $total=SaleOrder::countWorkOrdersByWorkOrderNo('HCM-650');
                $saleOrder->work_order_no = SaleOrder::countWorkOrdersByWorkOrderNo('MR/HCM-650/');
            }
            elseif($saleOrder->quotation->machine->name=='Agglomerator Bottom Vessel'){
                // $total=SaleOrder::countWorkOrdersByWorkOrderNo('M-AG-00');
                $saleOrder->work_order_no = SaleOrder::countWorkOrdersByWorkOrderNo('MR/M-AG-00/');
            }
            elseif($saleOrder->quotation->machine->name=='Grinder'){
                // $total=SaleOrder::countWorkOrdersByWorkOrderNo('CG-016');
                $saleOrder->work_order_no = SaleOrder::countWorkOrdersByWorkOrderNo('MR/CG-016/');
            }
            elseif($saleOrder->quotation->machine->name=='Grinder Mesh'){
                // $total=SaleOrder::countWorkOrdersByWorkOrderNo('CG-016');
                $saleOrder->work_order_no =SaleOrder::countWorkOrdersByWorkOrderNo('MR/CG-016/');;
            }
            elseif($saleOrder->quotation->machine->name=='High Speed Heater Mixer Vessel'){
                // $total=SaleOrder::countWorkOrdersByWorkOrderNo('M-056');
                $saleOrder->work_order_no = SaleOrder::countWorkOrdersByWorkOrderNo('MR/M-056/');
            }
            elseif($saleOrder->quotation->machine->name=='Agglomerator'){
                // $total=SaleOrder::countWorkOrdersByWorkOrderNo('M-AG-00');
                $saleOrder->work_order_no = SaleOrder::countWorkOrdersByWorkOrderNo('MR/M-AG-00/');;
            }
            elseif($saleOrder->quotation->machine->name=='High Speed Heater Mixer Vessel'){
                // $total=SaleOrder::countWorkOrdersByWorkOrderNo('M-AG-00')+1; 
                $saleOrder->work_order_no = SaleOrder::countWorkOrdersByWorkOrderNo('MR/M-AG-00/');
            }
    
    $saleOrder->save(); // Update the saleOrder after setting work_order_no
  }



}
