<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Letter for Advance Payment</title>
</head>

<style>
    @page {
        size: A4;
        margin: 8mm;
    }

    * {
        box-sizing: border-box;
    }

     @font-face {
        font-family: 'Poppins';
        src: url('/fonts/Poppins-Regular.ttf') format('truetype');
        font-weight: normal;
        font-style: normal;
       }

    body {
        font-family: 'Poppins', sans-serif;
        font-size: 12.5px; /* 🔹 reduced only for single-page fit */
        margin: 0;
        padding: 0;
        overflow: hidden;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        page-break-inside: avoid;
    }

    table tr td,
    table tr th {
        padding: 5px;
        vertical-align: top;
    }

    .bordered {
        border: 1px solid black;
    }

    .header {
        text-align: center;
        font-weight: bold;
        font-size: 15px;
    }

    .company_heading {
        font-size: 17px;
        margin: 0;
    }

    .sub-header {
        text-align: center;
        font-weight: bold;
        text-decoration: underline;
        margin-top: 8px;
    }

    .left-col {
        width: 50%;
    }

    .right-col {
        width: 50%;
        border-left: 1px solid black;
    }

    .advncTitle {
        font-size: 18px;
        font-weight: bolder;
    }
</style>

<body>

@php

@endphp

<!-- ================= HEADER ================= -->
<table class="bordered">
    <tr>
        <td colspan="2" class="header">
            <p class="company_heading">M. R. ENGINEERS</p>
            SNO.: 351/2-A, PSL COMPOUND, CHAR RASTA,<br>
            KACHIGAM, NANI DAMAN: 396 210<br>
            EMAIL: <span style="text-transform: lowercase;">sales@mrengineers.co.in, mihir@mrengineers.co.in</span>
        </td>
    </tr>

    <tr class="advncTitle" style="border-top:1px solid black;border-bottom:1px solid black;">
        <td colspan="2" class="sub-header">LETTER FOR ADVANCE PAYMENT</td>
    </tr>

    <!-- ================= BILL / SHIP ================= -->
    <tr class="bordered">
        <td class="left-col" style="padding:0;">
            <table style="width:100%; font-size:12px;">
                <tr><td colspan="2"><b><i>BILL TO :</i></b></td></tr>
                <tr>
                    <td colspan="2">
                        M/s. {{ $saleOrder->quotation->customer->contact_person_1_name ?? '' }}<br>
                        {{ $saleOrder->quotation->customer->address_line_1 ?? '' }}
                    </td>
                </tr>
                <tr>
                    <td width="40%"><b><i>GST NO.:</i></b></td>
                    <td width="60%">{{ $saleOrder->quotation->customer->gst ?? '' }}</td>
                </tr>
                <tr style="border-top:1px solid black;">
                    <td><b><i>LAP NO.:</i></b></td>
                    <td>{{ $saleOrder->lap_no ?? '0' }}/{{ $saleOrder->financial_year ?? '2025-26' }}</td>
                </tr>
                <tr>
                    <td><b><i>Quotation No.:</i></b></td>
                    <td>{{ $saleOrder->quotation->reference_no ?? '' }}</td>
                </tr>
                <tr>
                    <td><b><i>Date:</i></b></td>
                    <td>{{ formatDate($saleOrder->order_date ?? '') }}</td>
                </tr>
            </table>
        </td>

        <td class="right-col" style="padding:0;">
            <table style="width:100%; font-size:12px;">
                <tr><td colspan="2"><b><i>SHIP TO :</i></b></td></tr>
                <tr>
                    <td colspan="2">
                        M/s.
                        {{ $saleOrder->quotation->customer->contact_person_2_name ?? $saleOrder->quotation->customer->contact_person_1_name }}<br>
                        {{ $saleOrder->quotation->customer->address_line_2 ?? $saleOrder->quotation->customer->address_line_1 }}
                    </td>
                </tr>
                <tr>
                    <td width="40%"><b><i>Kind Attn.:</i></b></td>
                    <td width="60%">{{ $saleOrder->followedBy->name ?? '' }}</td>
                </tr>
                <tr style="border-top:1px solid black;">
                    <td><b>Contact Detail:</b></td>
                    <td>{{ $saleOrder->quotation->customer->contact_no ?? '' }}</td>
                </tr>
                <tr>
                    <td><b>Email:</b></td>
                    <td>{{ $saleOrder->quotation->customer->contact_person_1_email ?? '' }}</td>
                </tr>
                <tr>
                    <td><b><i>Customer P.O No.:</i></b></td>
                    <td>{{ $saleOrder->quotation->customer->po_no ?? '' }}</td>
                </tr>
                <tr>
                    <td><b><i>Date:</i></b></td>
                    <td>{{ formatDate($saleOrder->quotation->customer->po_date ?? '') }}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<!-- ================= ITEMS ================= -->
@php
    $maxRows = 3; // 🔒 fixed for one page
    $usedRows = 1;
    $emptyRows = $maxRows - $usedRows;
    $unitPrice = 100000;
@endphp

<table style="border-top:hidden;">
    <thead>
        <tr class="bordered">
            <th width="45%" style="border: 1px solid black; text-align: center;">Description</th>
            <th width="10%" style="border: 1px solid black; text-align: center;">HSN</th>
            <th width="5%"  style="border: 1px solid black; text-align: center;">Qty</th>
            <th width="5%"  style="border: 1px solid black; text-align: center;">Unit</th>
            <th width="10%" style="border: 1px solid black; text-align: center;">Unit Rate</th>
            <th width="15%" style="border: 1px solid black; text-align: center;">Amount Rs.</th>
        </tr>
    </thead>
    <tbody>
        <tr class="bordered">
            <td style="border: 1px solid black;">
                <b>{{ strtoupper($saleOrder->quotation->machine->name) }}
                {{ $saleOrder->quotation->modele->name }}</b>
            </td>
            <td style="border: 1px solid black;">{{ $saleOrder->quotation->machine->hsn ?? '' }}</td>
            <td align="center" style="border: 1px solid black;">{{ $saleOrder->quotation->quantity ?? '' }}</td>
            <td align="center" style="border: 1px solid black;">NOS.</td>
              @php
                    $dicountType = $saleOrder->discount_type;
                    $unitPrice = $saleOrder->total_amount;


                    if ($dicountType == 'percentage') {
                        $unitPrice = $unitPrice - ($unitPrice * $saleOrder->discount_percentage / 100);
                    } else if ($dicountType == 'amount') {
                        $unitPrice = $unitPrice - $saleOrder->disount_amount;
                    }
                @endphp
            <td align="right"  style="border: 1px solid black;">{{ format_indian_number($unitPrice / $saleOrder->quotation->quantity) }}</td>
            <td align="right" style="border: 1px solid black;">{{ format_indian_number($unitPrice) }}</td>
        </tr>

        @for($i=0;$i<$emptyRows;$i++)
        <tr class="bordered">
            <td style="border-left: 1px solid black;border-top:hidden;border-bottom:hidden;">&nbsp; </td><td style="border-left: 1px solid black;border-top:hidden;border-bottom:hidden;"></td><td style="border-left: 1px solid black;border-top:hidden;border-bottom:hidden;"></td><td style="border-left: 1px solid black;border-top:hidden;border-bottom:hidden;"></td><td style="border-left: 1px solid black;border-top:hidden;border-bottom:hidden;"></td><td style="border-left: 1px solid black;border-top:hidden;border-bottom:hidden;"></td>
        </tr>
        @endfor
    </tbody>
</table>

<!-- ================= REST SAME AS OLD ================= -->
<!-- Payment / GST / Bank / Signature block unchanged -->
     <table>
        <!-- Payment and GST rows -->
        <tr>
            <td style="width: 70%; border: 1px solid black; padding: 3px;">
                <b><i>{{$saleOrder->payment_term_condition}}</i></b>
            </td>
            <td style="width: 15%; border: 1px solid black; text-align: center;"><b>Total<br>Amount</b></td>
            {{-- <td style="width: 15%; border: 1px solid black; text-align: right;">{{
                format_indian_number($saleOrder->total_amount ??'0') }}</td> --}}
            <td style="width: 15%; border: 1px solid black; text-align: right;">
                {{ format_indian_number($unitPrice ?? '0') }}
            </td>
        </tr>
        <tr style="border-right:1px solid black;">
            <td style="border: 1px solid black; padding: 3px; border-right:none;">
                <b><i>Freight: {{ $saleOrder->transporation_payment ? 'To Pay' : 'Will Pay' }}</i></b>
            </td>
            @if ($saleOrder->transporation_payment)
                <td style="border: 1px solid black; padding: 3px; text-align: center;"><b>Transporation Charge</b></td>
                <td style="border: 1px solid black; padding: 3px; text-align: right;">
                    {{ format_indian_number($saleOrder->transporation_charge) }}
                </td>
            @else
                <td></td>
                <td></td>
            @endif

        </tr>

        <!-- Insurance and Packing -->
        <tr>
            <td style="border: 1px solid black; padding: 5px;"><b><i>Insurance: </i></b>Extra</td>
            <td colspan="2" style="border: 1px solid black; text-align: right;">
                {{ format_indian_number($saleOrder->insurance) }}
            </td>
        </tr>
        <tr>
            <td style="border: 1px solid black; padding: 5px;"><b><i>Packing: </i></b>Extra</td>
            <td colspan="2" style="border: 1px solid black; text-align: right;">
                {{ format_indian_number($saleOrder->packging) }}
            </td>
        </tr>
        <tr>
            <td style="border: 1px solid black; padding: 5px;"></td>
            <td style="border: 1px solid black; text-align: center;"><b>GST @<br>{{ $saleOrder->tax ?? ''}}%</b></td>
            @php
                // $totalTax = (($saleOrder->total_amount + $saleOrder->transporation_charge + $saleOrder->insurance + $saleOrder->packging  ) * $saleOrder->tax??'0')/100;
                //  $totalTax = (($unitPrice + $saleOrder->transporation_charge + $saleOrder->insurance + $saleOrder->packging  ) * $saleOrder->tax??'0')/100;
                $totalTax = (($unitPrice + $saleOrder->transporation_charge + $saleOrder->insurance + $saleOrder->packging) * $saleOrder->tax ?? '0') / 100;
            @endphp
            <td style="border: 1px solid black; text-align: right;">{{format_indian_number($totalTax ?? '0') }}</td>
        </tr>

        <!-- Amount in Words -->
        <tr style="border-bottom: hidden;">
            <td style="border: 1px solid black; padding: 5px; border-bottom:none;"><b><i>Amount in
                        Words:</i></b>{{strtoupper(convertToIndianWords($totalTax + $saleOrder->total_amount)) }}
                RUPEES</td>
            <td style="border: 1px solid black; border-bottom: 2px; text-align: center; border-bottom:none;">
                <b>TOTAL<br>VALUE</b>
            </td>
            {{--<td style="border: 1px solid black; text-align: right; border-bottom:none;">{{
                format_indian_number($totalTax + $saleOrder->total_amount+$saleOrder->transporation_charge +
                $saleOrder->insurance + $saleOrder->packging ) }}</td>--}}
            <td style="border: 1px solid black; text-align: right; border-bottom:none;">
                {{ format_indian_number($totalTax + $unitPrice + $saleOrder->transporation_charge + $saleOrder->insurance + $saleOrder->packging) }}
            </td>
        </tr>

        {{--<tr style="height: 140px;">

            <td style="border: 1px solid black; padding: 10px; font-size: 14px;">
                <b>GST:</b> 26AAQFM7310P1ZO<br>
                <b>Division:</b> South Daman<br>
                <b><i>Commissionerate:</i></b> Daman
            </td>

            <td style="border: 1px solid black;"></td>

            <td style="border: 1px solid black; padding: 2px; font-size: 14px;">
                <table style="height: 15%; width: 100%; border-collapse: collapse;">
                    <tr style="height: 70%; border: none;">
                        <td style="padding: 10px; text-align: left;">
                            <b>For M R Engineers</b>
                        </td>
                    </tr>
                    <tr style="height: 30%; border: none; margin-top: 15px;">
                        <td style="text-align: center; padding-bottom: 15px;">
                            <b><i>Partner</i></b>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>--}}

        <tr style="height: 100px; line-height: 1.5; " class="bordered">
            <table style="width: 143%; ">
                <tr>
                    <td class="bordered" style="border-left: none; border-bottom:none;">
                        <i>
                            Our Bank details:<br>
                            Company Name: <b>M. R. Engineers</b><br>
                            Bank: HDFC Bank<br>
                            A/c No.: <b>50200029265243</b><br>
                            IFCS Code: <b>HDFC0000170</b><br>
                            Branch: Chala, Vapi
                        </i>
                    </td>
                    <!-- GST / Division / Commissionerate -->
                    <td
                        style="border-top: 1px solid black; padding: 10px;width: 30%; font-size: 14px; vertical-align: center; border-left: 1px solid black;">
                        <b><i>GST:</i></b> 26AAQFM7310P1ZO<br>
                        <b><i>Division:</i></b> South Daman<br>
                        <b><i>Commissionerate:</i></b> Daman
                    </td>
                    <!-- Signature Column -->
                    <td style="border: 1px solid black; width: 30%; padding: 0; font-size: 14px; line-height: 1;">
                        <div style="position: relative; height: 120px;">
                            <!-- Top Text (Touching Top) -->
                            <div style="position: absolute; top: 0; left: 10px;">
                                <b><i>For M R Engineers</i></b>
                            </div>
                            <!-- Bottom Text (Touching Bottom Center) -->
                            <div style="position: absolute; bottom: 1px; width: 100%; text-align: center;">
                                <b><i>Partner</i></b>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </tr>
    </table>

</body>
</html>
