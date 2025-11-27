    <!DOCTYPE html>
    <html>
    <head>
        <title>Customer Account Details</title>
        <style>
            body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
            table { width: 100%; border-collapse: collapse; margin-top: 5px; }
            th, td {width: 50%; border: 1px solid #000; padding: 6px; text-align: left; vertical-align: top; }
            th { background-color: #f2f2f2; }
            header {
                    position: fixed;
            
                right: 25px;
            
                height: 100px;
                
                z-index: 15;
    
            }   

        </style>
    </head>
    <body>
    <header>
        <div style="text-align: right; margin-bottom: 20px;">
            <img src="{{ public_path('/image/mr_logo.png') }}" height="80px" >
        </div>
    </header>
        @php
        $tax=$saleOrder->tax??0;
        $taxAmount=(($saleOrder->total_amount + $saleOrder->transporation_charge) * $tax) / 100;

        $grandTotal=$saleOrder->total_amount + $taxAmount;
        $totalTransporation=0;
        $totalFreight=0;

        /*foreach($saleOrder->payments as $payment){
        if($payment->type=='transportation'){
            $totalTransporation+=$payment->amount;
        }
        else if($payment->type=='freight'){
        $totalFreight+=$payment->amount;
        }
        }*/
        
            
        @endphp

         @php
            $dicountType = $saleOrder->discount_type;
            $unitPrice=$saleOrder->total_amount;
    
            if($dicountType == 'percentage'){
              $unitPrice = $unitPrice - ($unitPrice*$saleOrder->discount_percentage/100);
            }
            else if($dicountType == 'amount'){
              $unitPrice = $unitPrice - $saleOrder->disount_amount;
            }
            @endphp
    <table style="width: 100%; border-collapse: collapse; margin-top: 40px;">
            
            <div style="padding: 5px;"> <h2>Customer Account Details</h2> </div>
        <tbody>
            <tr><th>1. Company Name & Address</th><td>{{ $saleOrder->quotation->customer->company_name ?? 'N/A' }}<br>{{ $saleOrder->address ?? 'N/A' }}</td></tr>
            <tr><th>2. Contact Person</th><td>{{ $saleOrder->quotation->customer->contact_person_1_name ?? 'N/A' }}</td></tr>
            <tr><th>3. Contact Number</th><td>{{ $saleOrder->quotation->customer->contact_no ?? 'N/A' }}</td></tr>
            <tr><th>4. Machine Name</th><td>{{ $saleOrder->quotation->machine->name ?? 'N/A' }}</td></tr>
            <tr><th>5. Model No.</th><td>{{ $saleOrder->quotation->modele->name ?? 'N/A' }}</td></tr>
            <tr><th>6. Customer PO No.</th><td>{{ $saleOrder->po_no ?? 'N/A' }}</td></tr>
            <tr><th>7. PO Date Received by MR</th><td>{{ formatDate($saleOrder->order_date??'') }}</td></tr>
            <tr><th>8. Work Order No.</th><td>{{ $saleOrder->work_order_no ?? 'N/A' }}</td></tr>
            <tr><th>9. Delivery Date</th><td>{{ formatDate($saleOrder->delivery_date??'') }}</td></tr>
            <tr><th>10. Total Basic Price</th><td>{{ format_indian_number($unitPrice ?? 'N/A') }}</td></tr>
            <tr><th>11. Transportation</th><td>{{ format_indian_number($saleOrder->transporation_charge ?? '') }}</td></tr>
            <tr><th>12. Total GST Price</th><td>{{ format_indian_number($taxAmount) }}</td></tr>
            <tr><th>13. Total Final Price</th><td>{{ format_indian_number($saleOrder->grand_total ?? 0) }}</td></tr>
            @php
            $index=14;
            @endphp
            @foreach ($saleOrder->payments as $i=>$payment)
            <tr><th>{{ $index++ }}. Advance-{{ $i+1 }}</th><td>{{ format_indian_number($payment->amount ?? 0) }}</td></tr>
            @endforeach
            <tr><th>{{ $index++ }}. Total Advance</th><td>{{ format_indian_number($saleOrder->advanace_payment ?? 'N/A') }}</td></tr>
            <tr><th>{{ $index++ }}. Balance Payment</th><td>{{ format_indian_number(($saleOrder->grand_total ?? 0) - ($saleOrder->advanace_payment ?? 0)) }}</td></tr>
            <tr><th>{{ $index++ }}. Remark</th><td>{{ $saleOrder->remark }}</td></tr>
        </tbody>
    </table>

    {{-- Signature Section --}}
    <table style="width: 100%;; margin-top: 0; border: none; margin-top: 0;">
        <tr style="border: none;">
            <td style="width: 50%; text-align: left; border: none;">
                <p style="font-weight: bold; text-decoration: underline;">Prepared By</p>
                <br>
                <p></p>
            </td>
            <td style="width: 50%; text-align: right; border: none;">
                <p style="font-weight: bold; text-decoration: underline;">Approved By</p>
                <br>
                <p></p>
            </td>
        </tr>
    </table>

    </body>
    </html>
