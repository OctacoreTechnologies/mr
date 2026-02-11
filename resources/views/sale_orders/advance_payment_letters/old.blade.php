<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Letter for Advance Payment</title>
    <!-- <link rel="preconnect" href="https://fonts.googleapis.com"> -->
    <!-- <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> -->
</head>
<style>
    @font-face {
        font-family: 'Poppins';
        src: url('/fonts/Poppins-Regular.ttf') format('truetype');
        font-weight: normal;
        font-style: normal;
    }

    body {
        /* font-family: "Times New Roman", Times, serif; */
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        margin: 0;
        padding: 0;
        /* font-family: 'Times New Roman', Times, serif; */

    }

    .header {
        text-align: center;
        font-weight: bold;
        font-size: 16px;
    }

    .company_heading {
        font-size: 18px;
        padding-bottom: 0px;
        padding-top: 0px;
        margin-top: 0;
        margin-bottom: 0;
    }

    .sub-header {
        text-align: center;
        /* font-style: italic; */
        font-weight: bold;
        text-decoration: underline;
        margin-top: 10px;
    }

    table {
        width: 100%;
        border-collapse: collapse;

    }

    table tr {
        padding: 12px;
    }

    table tr td {
        padding: 6px;
    }

    .bordered {
        border: 1px solid black;
    }

    .content td {
        padding: 5px;
        vertical-align: top;
    }

    .left-col {
        width: 50%;
    }

    .right-col {
        width: 50%;
        border-left: 1px solid black;
    }

    .label {
        /* font-style: italic; */
    }

    .bold {
        font-weight: bold;
    }

    .italic-bold {
        /* font-style: italic; */
        font-weight: bold;
    }

    .sono {
        border-top: 1px solid black;
        border-bottom: 1px solid black;
    }

    .advncTitle {
        font-weight: bolder;
        font-size: 20px;
    }
</style>

<body>
    <table class="bordered">
        <tr>
            <td colspan="2" class="header">
                <p class="company_heading">M. R. ENGINEERS</p>
                SNO.: 351/2-A, PSL COMPOUND, CHAR RASTA, <br>
                KACHIGAM, NANI DAMAN: 396 210 <br>
                EMAIL: <span style="text-transform: lowercase;">sales@mrengineers.co.in, mihir@mrengineers.co.in</span>
            </td>
        </tr>
        <tr style="border-top: 1px solid black; border-bottom: 1px solid black;" class="advncTitle">
            <td colspan="2" class="sub-header">LETTER FOR ADVANCE PAYMENT</td>
        </tr>
        <tr class="content bordered">

            <!-- BILL TO (LEFT) -->
            <td class="left-col" style="vertical-align: top; padding: 0;">
                <table style="width:100%; font-size:12px; border-collapse:collapse;">
                    <tr>
                        <td colspan="2" style="padding: 6px; font-weight: bold; font-style: italic;">
                            BILL TO :
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" style="padding: 6px;">
                            M/s. {{ $saleOrder->quotation->customer->contact_person_1_name ?? '' }}<br>
                            {{ $saleOrder->quotation->customer->address_line_1 ?? '' }}
                        </td>
                    </tr>

                    <tr>
                        <td style="width: 40%; padding: 6px; font-weight: bold; font-style: italic;">GST NO.:</td>
                        <td style="width: 60%; padding: 6px;">
                            {{ $saleOrder->quotation->customer->gst ?? '' }}
                        </td>
                    </tr>

                    <tr style="border-top: 1px solid black">
                        <td style="padding: 6px; font-weight: bold; font-style: italic;">LAP NO.:</td>
                        <td style="padding: 6px;">
                            {{ $saleOrder->lap_no ?? '0' }}/{{ $saleOrder->financial_year ?? '2025-26' }}
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 6px; font-weight: bold; font-style: italic;">Quotation No.:</td>
                        <td style="padding: 6px;">
                            {{ $saleOrder->quotation->reference_no ?? '' }}
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 6px; font-weight: bold; font-style: italic;">Date:</td>
                        <td style="padding: 6px;">
                            {{ formatDate($saleOrder->order_date ?? '') }}
                        </td>
                    </tr>
                </table>
            </td>

            <!-- SHIP TO (RIGHT) -->
            <td class="right-col" style="vertical-align: top; padding: 0;">
                <table style="width:100%; font-size:12px; border-collapse:collapse;">
                    <tr>
                        <td colspan="2" style="padding: 6px; font-weight: bold; font-style: italic;">
                            SHIP TO :
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" style="padding: 6px;">
                            M/s.
                            {{ $saleOrder->quotation->customer->contact_person_2_name ?? $saleOrder->quotation->customer->contact_person_1_name }}<br>
                            {{ $saleOrder->quotation->customer->address_line_2 ?? $saleOrder->quotation->customer->address_line_1 }}
                        </td>
                    </tr>

                    <tr>
                        <td style="width: 40%; padding: 6px; font-weight: bold; font-style: italic;">Kind Attn.: Mr.
                        </td>
                        <td style="width: 60%; padding: 6px;">
                            {{ $saleOrder->followedBy->name ?? '' }}
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 6px; font-weight: bold;">Contact Detail:</td>
                        <td style="padding: 6px;">
                            {{ $saleOrder->quotation->customer->contact_no ?? '' }}
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 6px; font-weight: bold;">Email:</td>
                        <td style="padding: 6px;">
                            {{ $saleOrder->quotation->customer->contact_person_1_email ?? '' }}
                        </td>
                    </tr>

                    <tr style="border-top: 1px solid black">
                        <td style="padding: 6px; font-weight: bold; font-style: italic;">Customer P.O No.:</td>
                        <td style="padding: 6px;">
                            {{ $saleOrder->quotation->customer->po_no ?? '' }}
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 6px; font-weight: bold; font-style: italic;">Date:</td>
                        <td style="padding: 6px;">
                            {{ formatDate($saleOrder->quotation->customer->po_date ?? '') }}
                        </td>
                    </tr>
                </table>
            </td>

        </tr>

    </table>
    <table
        style="width: 100%; border-collapse: collapse; font-family: 'Poppins', sans-serif; font-size: 14px;border-top:hidden; ">
        <thead>
            <tr style="border: 1px solid black;">
                <th style="border: 1px solid black; width: 45%; text-align: center;"><i>Description</i></th>
                <th style="border: 1px solid black; width: 10%; text-align: center;"><i>HSN CODE</i></th>
                <th style="border: 1px solid black; width: 5%; text-align: center;"><i>Qty</i></th>
                <th style="border: 1px solid black; width: 5%; text-align: center;"><i>Unit</i></th>
                <th style="border: 1px solid black; width: 10%; text-align: center;"><i>Unit Rate</i></th>
                <!-- <th style="border: 1px solid black; width: 10%; text-align: center;"><i>Discount Rs.</i></th> -->
                <th style="border: 1px solid black; width: 15%; text-align: center;"><i>Amount Rs.</i></th>
            </tr>
        </thead>
        <tbody>
            <!-- Data row -->
            <tr>
                <td style="border: 1px solid black; padding: 6px;">
                    <b>{{ strtoupper($saleOrder->quotation->machine->name) }} Model
                        {{ $saleOrder->quotation->modele->name }} </b><br>
                    <!-- ALONG WITH AC FREQUENCY DRIVE<br> -->
                    <!-- ELECTRICAL PANEL<br><br> -->
                    <br>
                </td>
                <td style="border: 1px solid black;">{{ $saleOrder->quoation->machine->hsn ?? '' }}</td>
                <td style="border: 1px solid black; text-align: center;">{{ $saleOrder->quotation->quantity ?? '' }}
                </td>
                <td style="border: 1px solid black; text-align: center;">NOS.</td>
                @php
                    $dicountType = $saleOrder->discount_type;
                    $unitPrice = $saleOrder->total_amount;


                    if ($dicountType == 'percentage') {
                        $unitPrice = $unitPrice - ($unitPrice * $saleOrder->discount_percentage / 100);
                    } else if ($dicountType == 'amount') {
                        $unitPrice = $unitPrice - $saleOrder->disount_amount;
                    }
                @endphp
                {{--<td style="border: 1px solid black; text-align: right;">{{
                    format_indian_number($saleOrder->quotation->total_price) }}</td>--}}
                {{--<td style="border: 1px solid black; text-align: right;">{{
                    format_indian_number($saleOrder->discount) }}</td>--}}
                <td style="border: 1px solid black; text-align: right;">
                    {{ format_indian_number($unitPrice / $saleOrder->quotation->quantity) }}
                </td>
                <td style="border: 1px solid black; text-align: right;">{{ format_indian_number($unitPrice) }}</td>
            </tr>

            <!-- Empty rows -->
            @for ($i = 0; $i < 2; $i++)
                <tr style="border: 1px solid black;">
                    <td style="border-left: 1px solid black;border-top:hidden;border-bottom:hidden;">&nbsp;</td>
                    <td style="border-left: 1px solid black;border-top:hidden;border-bottom:hidden;">&nbsp;</td>
                    <td style="border-left: 1px solid black;border-top:hidden;border-bottom:hidden;">&nbsp;</td>
                    <td style="border-left: 1px solid black;border-top:hidden;border-bottom:hidden;">&nbsp;</td>
                    <td style="border-left: 1px solid black;border-top:hidden;border-bottom:hidden;">&nbsp;</td>
                    {{-- <td style="border-left: 1px solid black;border-top:hidden;border-bottom:hidden;">&nbsp;</td> --}}
                    <td style="border-left: 1px solid black;border-top:hidden;border-bottom:hidden;">&nbsp;</td>
                </tr>
            @endfor
        </tbody>
    </table>
    <table
        style="width: 100%; border-collapse: collapse;   font-family: 'Poppins', sans-serif; font-size: 14px; border: 1px solid black;padding-bottom:0;">
        <!-- Payment and GST rows -->
        <tr>
            <td style="width: 70%; border: 1px solid black; padding: 3px;">
                <b><i>Payment: 40% Advance & 60% Before Dispatch</i></b>
            </td>
            <td style="width: 15%; border: 1px solid black; text-align: center;"><b>Total<br>Amount</b></td>
            {{-- <td style="width: 15%; border: 1px solid black; text-align: right;">{{
                format_indian_number($saleOrder->total_amount ??'0') }}</td> --}}
            <td style="width: 15%; border: 1px solid black; text-align: right;">
                {{ format_indian_number($unitPrice ?? '0') }}
            </td>
        </tr>
        <tr>
            <td style="border: 1px solid black; padding: 3px;">
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

        <tr style="height: 100px; line-height: 1.5; ">
            <table style="width: 143%; ">
                <tr>
                    <td style="border: 1px solid black;border: none; border-top: 1px solid black;">
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