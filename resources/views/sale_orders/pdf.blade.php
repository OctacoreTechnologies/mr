<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
     @font-face {
        font-family: 'Poppins';
        font-style: normal;
        font-weight: 400;
        src: url('{{ public_path('fonts/Poppins-Regular.ttf') }}') format('truetype');
        /* src: url('{{ public_path('fonts/Poppins-ExtraBold.ttf.ttf') }}') format('truetype'); */
    }

    @font-face {
        font-family: 'Poppins';
        font-style: normal;
        font-weight: 700;
        /* src: url('{{ public_path('fonts/Poppins-Regular.ttf') }}') format('truetype'); */
        src: url('{{ public_path('fonts/Poppins-Bold.ttf') }}') format('truetype');
    }
    
        body {
            font-size: x-small;
            margin: 0;
            padding: 0;
            font-family:'Poppins',sans-serif ;
            /* border: 2px solid black; */
            font-optical-sizing: auto;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        td, th {
            padding: 6px;
            border: 1px solid black;
            vertical-align: top;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .no-border {
            border: none;
        }
        .topbottom{
            border-left: 1pt solid black; 
            border-right: 1pt solid black;
            border-bottom: 1pt solid transparent;
            padding: 6px 6px; text-align: center;
        }
        table {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid black;
       }
        td {
        /* border: 1px solid black; */
        padding: 4px 6px;
        vertical-align: top;
    }

    .title {
        text-align: center;
        font-weight: bold;
        font-size: 10pt;
    }

    /* .logo {
       width: 90px;
       padding-top: 0;
       object-fit: cover;
    }
    .logo-td{
        padding: 0px;
        border-bottom: 3px solid black;
        border-left: 3px solid black;
    } */

    .company-name {
        font-size: 18pt;
        font-weight: bold;
        text-align: right;
        padding-bottom: 2px;
    }

    .company-info {
        font-size: 9pt;
        line-height: 1;
        text-align: right;
        padding-top: 0;
        padding-bottom: 2px;
    }

    .gst-info {
        border-top:1px solid black;
        text-align: right;
        font-weight: bold;
        font-size: 9pt;
        /* padding-top: 2px;
        padding-bottom: 2px; */
    }

    .subtable tr td{
        border: none;
        padding-bottom: 15px;
    }


    </style>
</head>
<body>
  <table>
    <thead>

     <tr style="border: 1px solid black;">
             <td colspan="12" class="title">*!*INVOICE *!*</td>
         </tr>
 
         <!-- LOGO + COMPANY DETAILS -->
         <tr style="border:1px solid black">
             <td colspan="3" rowspan="" class="logo-td"  style="border: 1px solid black; padding: 0; margin: 0; text-align: center; vertical-align: middle; height: 70px; width:80px;">
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('image/mr_logo.png'))) }}" height="80px">
            </td>
             <td colspan="9" style="border: 1px solid black; text-align: right; padding: 0px 2px;">
                 <div style="font-size: 17pt; font-weight: bold;" class="libre-baskerville-bold">MR Engineers</div>
                 <div style="font-size: 10pt; line-height: 1.2;">
                     Room No. 16, 2nd Floor BhagawanNivas<br>
                     Near Sub Register Office, Station Road<br>
                     Goregaon West, Mumbai – 400 062<br>
                     E-Mail: info@mrengineers.co.in (M) +91 89281 61634,
                 </div>
                 <div class="gst-info" style="padding: 5px;">
                     GSTIN NO.: 
                 </div>
             </td>
         </tr>
        
         </thead>
     </table>

     <table
         style="table-layout:fixed; border-collapse: collapse; font-size: 10pt; margin-top: -1px; border-top-color: black;border-top: hidden;">
         <tr>
             <!-- Left Side -->
             <td colspan="7" style=" padding: 2px; font-size: 9pt; line-height: 1.7; box-sizing: border-box;">
                <div style="word-wrap: break-word; width: 100%; padding-right: 10px;">
                    <b>NAME & ADDRESS:</b><br>
                    {{ strtoupper($saleOrder->quotation->customer->company_name??'') }}<br>
                    {{ strtoupper($saleOrder->quotation->customer->address_line_1??'') }}<br>
                    <b>GSTIN No:</b> {{$saleOrder->quotation->customer->gst }}<br>
                    PLACE OF SUPPLY: {{strtoupper($saleOrder->quotation->customer->state??'')}}</b>  
                </div>
            </td>
            
 
             <!-- Right Side -->
             <td colspan="5" style="border-top: none; padding: 4px 2px 4px 0px; font-size: 9pt; line-height: 0.5; border-left: 1px solid black;">
                 <table  border="0" cellspacing="0" cellpadding="0" class="subtable" style="width: 102%; font-size: 9pt; line-height: 1; border: none;">

                   <tr>
                     <td style="width: 97px; font-weight: bold;">DATE</td>
                     <td style="width: 1px;">:</td>
                     <td>{{ formatDate($saleOrder->order_date) }}</td>
                   </tr>
                   <tr>
                       <td style="font-weight: bold;">INVOICE NO</td>
                       <td>:</td>
                       <td>{{ $saleOrder->quotation->reference_no??'' }}</td>
                   </tr>
                   <tr>
                       <td style="font-weight: bold;">PAYMENT TERMS</td>
                       <td>:</td>
                       <td>
                           N.A
                       </td>
                   </tr>
               </table>

             </td>
         </tr>
     </table>

<!-- Invoice Item Table -->
<table style="border-top: hidden;">
    <thead>
        <tr>
            <th class="text-center" style="width: 5%;">Sr No</th>
            <th class="text-center" style="width: 55%;">Description</th>
            <th class="text-center" style="width: 10%;">Amount</th>
            <th class="text-center" style="width: 10%;">GST%</th>
            <th class="text-center" style="width: 20%;">Total</th>
        </tr>
    </thead>
    <tbody>
        <!-- First item row -->
        <tr>
            <td class="text-center topbottom">1</td>
            <td  style="border-left: 1pt solid black; border-right: 1pt solid black; border-bottom: 1pt solid transparent; padding: 6px 6px; text-align: left; line-height: 1.4;">
              {{strtoupper($saleOrder->quotation->machine->name)}}  Model {{$saleOrder->quotation->modele->name}}-R LTR <br>
              ALONG WITH AC FREQUENCY DRIVE <br>
              ELECTRICAL PANEL
            </td>
            <td class="text-right topbottom">{{ number_format($saleOrder->total_amount ?? 0, 2) }}</td>
            <td class="text-center topbottom">{{ $saleOrder->tax ??'' }}%</td>
            <td class="text-right topbottom">{{ number_format($saleOrder->grand_total ?? 0, 2) }}</td>
        </tr>

        <!-- Empty rows to fill space -->
        @for ($k = 0; $k < 12; $k++)
        <tr>
            <td class="topbottom">&nbsp;</td>
            <td class="topbottom">&nbsp;</td>
            <td class="topbottom">&nbsp;</td>
            <td class="topbottom">&nbsp;</td>
            <td class="topbottom">&nbsp;</td>
        </tr>
        @endfor
    </tbody>
</table>

<!-- Footer Section: Terms & Bank -->
<table>
<tr>
    <td colspan="4" rowspan="3">
        <strong>Terms & Conditions:</strong><br>
        Thanks for your business.<br>
        No returns or exchanges.<br>
        Payment within 15 days.
    </td>
    <td class="text-right"><strong>Sub Total:</strong></td>
    <td class="text-right">{{ number_format($saleOrder->total_amount ?? 0, 2) }}</td>
</tr>
<tr>
    <td class="text-right"><strong>GST ({{ $saleOrder->tax }}%):</strong></td>
    <td class="text-right">
        @php
        $gstAmount=($saleOrder->total_amount * $saleOrder->tax / 100)
        @endphp
        {{ number_format($gstAmount, 2) }}
    </td>
</tr>
<tr>
    <td class="text-right"><strong>Total:</strong></td>
    <td class="text-right">{{ number_format($saleOrder->total_amount+$gstAmount ?? 0, 2) }}</td>
</tr>
    <tr>
        <td colspan="4">
            <strong>Bank Details</strong><br>
            Bank Name: Bank Of Baroda<br>
            A/C Type: Current<br>
            A/C No.: 52870200000152<br>
            IFSC: BARB0ZARNAP<br>
            Branch: Zarna Park, Bulsar
        </td>
        <td colspan="2" class="text-right">
            for,<br><br><br>
            <strong>Authorised Signatory</strong>
        </td>
    </tr>
</table>

<!-- Jurisdiction -->
<div class="text-center" style="margin-top: 10px;">
    <strong>Subject to Valsad Jurisdiction</strong>
</div>

</body>
</html>
