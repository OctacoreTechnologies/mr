{{-- <div class="page-break" style="page-break-before: always;  width: 100%; padding:0px 5px 0px 20px;">
    <div class="offer" style="width: 90%;">

        <div class="technical-data">
            <h2 style="text-decoration: underline; font-weight: bold;">
                3. OFFER
            </h2>
        </div>

        <!-- Table -->
        <table
            style="border-collapse: collapse; width: 110%; font-size: 14px; border: 1px solid black; line-height: 1; font-family: 'Poppins';"
            class='offer-table'>
            <thead style="border: 1px solid black;">
                <tr style="font-weight: bold; text-align: center; border: 1px solid black;">
                    <th style="width: 10%; padding: 10px; border: 1px solid black;">Sr.No.</th>
                    <th style="width: 55%; padding: 10px; border: 1px solid black;">PARTICULAR</th>
                    <th style="width: 15%; padding: 10px; border: 1px solid black;">Qty</th>
                    <th style="width: 15%; padding: 10px; border: 1px solid black;">Unit Price</th>
                    <th style="width: 15%; padding: 10px; border: 1px solid black;">Ex Work Price In Rs.</th>
                </tr>
            </thead>
            <tbody style="border: 1px solid black;">
                @php
                    $qty = $quotation->quantity ?? 0;
                    $unitPrice = $quotation->total_price ?? 0;
                    // $discount = $quotation->discount ?? 0;
                    $discount = $quotation->discount_type;
                    $amount = $qty * $unitPrice;
                    $netAmount = $quotation->total;
                @endphp

                <!-- Item Row -->
                <tr style="border: 1px solid black;">
                    <td style="text-align: center; vertical-align: top; padding: 80px 10px; border: 1px solid black;">1
                    </td>
                    <td style="padding: 10px; line-height: 1; border: 1px solid black;">
                        {{ strtoupper($quotation->machine->name) }} Model {{ $quotation->modele->name }} <br>
                        ALONG WITH AC FREQUENCY DRIVE <br>
                        ELECTRICAL PANEL
                        @if ($quotation->remark != '')
                            <p>({{ $quotation->remark }})</p>
                        @endif
                    </td>
                    <td style="text-align: center; vertical-align: top; padding:80px 10px; border: 1px solid black;">
                        {{ $qty }} Nos.
                    </td>
                    <td style="text-align: center; vertical-align: top; padding:80px 15px; border: 1px solid black;">
                        {{ format_indian_number($unitPrice, 2) }}
                    </td>
                    <td style="text-align: center; vertical-align: top; padding:80px 15px; border: 1px solid black;">
                        {{ format_indian_number($amount, 2) }}
                    </td>
                </tr>

                @if ($discount == 'amount')
                    <!-- Subtotal -->
                    <tr style="border: none">
                        <td colspan="4"
                            style="text-align: right; padding: 12px 15px; font-weight: 600; border: 1px solid black;">
                            Subtotal
                        </td>
                        <td style="text-align: right; padding: 12px 15px; font-weight: 600; border: 1px solid black;">
                            {{ format_indian_number($amount, 2) }}
                        </td>
                    </tr>

                    <!-- Discount -->
                    <tr style="border: 1px solid black;">
                        <td colspan="4"
                            style="text-align: right; padding: 12px 15px; font-weight: 600; border: 1px solid black;">
                            Less: Discount
                        </td>
                        <td style="text-align: right; padding: 12px 15px; font-weight: 600; border: 1px solid black;">
                            {{ format_indian_number($quotation->discount_amount, 2) }}
                        </td>
                    </tr>

                    <!-- Net Payable -->
                    <tr style="border: 1px solid black;">
                        <td colspan="4"
                            style="text-align: right; padding: 14px 15px; font-weight: bold; border: none;">
                            Net Payable Amount
                        </td>
                        <td style="text-align: right; padding: 14px 15px; font-weight: bold; border: 1px solid black;">
                            {{ format_indian_number($quotation->total, 2) }}
                        </td>
                    </tr>

                    <!-- Amount in Words -->
                    <tr style="border: 1px solid black;">
                        <td colspan="5"
                            style="text-align: center; padding: 16px 10px; font-weight: bold; border: 1px solid black;">
                            RUPEES {{ strtoupper($words) }} ONLY
                        </td>
                    </tr>
                @elseif($discount == 'percentage')
                    <!-- Subtotal -->
                    <tr style="border:none">
                        <td colspan="4"
                            style="text-align: right; padding: 12px 15px; font-weight: 600; border: 1px solid black;">
                            Subtotal
                        </td>
                        <td style="text-align: right; padding: 12px 15px; font-weight: 600; border: 1px solid black;">
                            {{ format_indian_number($amount, 2) }}
                        </td>
                    </tr>

                    <!-- Discount -->
                    <tr style="border: 1px solid black;">
                        <td colspan="4"
                            style="text-align: right; padding: 12px 15px; font-weight: 600; border: 1px solid black;">
                            Discount(%)
                        </td>
                        <td style="text-align: right; padding: 12px 15px; font-weight: 600; border: 1px solid black;">
                            {{ format_indian_number($quotation->discount_percentage, 2) }}%
                        </td>
                    </tr>

                    <!-- Net Payable -->
                    <tr style="border: 1px solid black;">
                        <td colspan="4"
                            style="text-align: right; padding: 14px 15px; font-weight: bold; border: 1px solid black;">
                            Net Payable Amount
                        </td>
                        <td style="text-align: right; padding: 14px 15px; font-weight: bold; border: 1px solid black;">
                            {{ format_indian_number($quotation->total, 2) }}
                        </td>
                    </tr>

                    <!-- Amount in Words -->
                    <tr style="border: 1px solid black;">
                        <td colspan="5"
                            style="text-align: center; padding: 16px 10px; font-weight: bold; border: 1px solid black;">
                            RUPEES {{ strtoupper($words) }} ONLY
                        </td>
                    </tr>
                @else
                    <!-- Only Total and Words -->
                    <tr style="border-color: transparent;">
                        <td colspan="4"
                            style="text-align: right; padding: 14px 15px; font-weight: bold; border: 1px solid black;">
                            Total
                        </td>
                        <td style="text-align: right; padding: 14px 15px; font-weight: bold; border: 1px solid black;">
                            {{ format_indian_number($amount, 2) }}
                        </td>
                    </tr>

                    <tr style="border: 1px solid black;">
                        <td colspan="5"
                            style="text-align: center; padding: 16px 10px; font-weight: bold; border: 1px solid black;">
                            RUPEES {{ strtoupper($words) }} ONLY
                        </td>
                    </tr>
                @endif

            </tbody>
        </table>
    </div>



</div> --}}
<div class="page-break" style="page-break-before: always; width: 100%; padding:0px 5px 0px 20px; margin-left:-12px;">
    <div class="offer" style="width: 90%;">

        <div class="technical-data">
            <h2 style="text-decoration: underline; font-weight: bold;">
                3. OFFER
            </h2>
        </div>

        <table
            style="border-collapse: collapse; width: 110%; font-size: 14px; border: 1px solid black; line-height: 1; font-family: 'Poppins';"
            class="offer-table">

            <thead style="border: 1px solid black;">
                <tr style="font-weight: bold; text-align: center;">
                    <th style="width: 10%; padding: 10px; border: 1px solid black;">Sr.No.</th>
                    <th style="width: 55%; padding: 10px; border: 1px solid black;">PARTICULAR</th>
                    <th style="width: 15%; padding: 10px; border: 1px solid black;">Qty</th>
                    <th style="width: 15%; padding: 10px; border: 1px solid black;">Unit Price</th>
                    <th style="width: 15%; padding: 10px; border: 1px solid black;">Ex Work Price In Rs.</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $qty = $quotation->quantity ?? 0;
                    $unitPrice = $quotation->total_price ?? 0;
                    $discount = $quotation->discount_type;
                    $amount = $qty * $unitPrice;
                    $items = $quotation->getRelation('items') ?? [];
                    $hasItems = count($items) > 0;
                    $srNo = 2;
                    $subTotal = 0;
                @endphp


                {{-- ===================== --}}
                {{-- IF REMARKS AVAILABLE --}}
                {{-- ===================== --}}
                @if ($hasItems)

                    <tr>
                        <td
                            style="text-align:center; vertical-align: top; padding:10px; border:1px solid black;border-bottom:none;">
                            1
                        </td>

                        <td style="padding:10px; border:1px solid black;border-bottom:none;">
                            {{ strtoupper($quotation->machine->name) }} Model {{ $quotation->modele->name }} <br>
                            ALONG WITH AC FREQUENCY DRIVE <br>
                            ELECTRICAL PANEL
                        </td>

                        <td
                            style="text-align:center; vertical-align: top; padding:10px; border:1px solid black;border-bottom:none;">
                            {{ $qty }} Nos.
                        </td>

                        <td
                            style="text-align:center; vertical-align: top; padding:10px; border:1px solid black;border-bottom:none;">
                            {{ format_indian_number($unitPrice, 2) }}
                        </td>

                        <td
                            style="text-align:center; vertical-align: top; padding:10px; border:1px solid black;border-bottom:none;">
                            {{ format_indian_number($amount, 2) }}
                        </td>
                    </tr>

                    {{-- REMARK ROWS --}}
                    @foreach ($items as $item)
                        @php
                            $subTotal = $item->item_qty * $item->item_price + $subTotal;
                        @endphp
                        <tr>
                            <td style="text-align:center; border:1px solid black;border-top:none;border-bottom:none;">
                                {{ $srNo++ }}
                            </td>

                            <td style="padding:8px; border:1px solid black;border-top:none;border-bottom:none;">
                                {{ $item->item_name }}
                            </td>

                            <td
                                style="text-align:center; vertical-align: top; padding:10px; border:1px solid black;border-top:none;border-bottom:none;">
                                {{ $item->item_qty }} Nos.</td>
                            <td
                                style="text-align:center; vertical-align: top; padding:10px; border:1px solid black;border-top:none;border-bottom:none;">
                                {{ format_indian_number($item->item_price) }}</td>
                            <td
                                style="text-align:center; vertical-align: top; padding:10px; border:1px solid black;border-top:none;border-bottom:none;">
                                {{ format_indian_number($item->item_price * $item->item_qty) }}</td>
                        </tr>
                    @endforeach

                    {{-- ===================== --}}
                    {{-- NO REMARKS -> OLD VIEW --}}
                    {{-- ===================== --}}
                @else
                    <tr>
                        <td
                            style="text-align: center; vertical-align: top; padding: 80px 10px; border: 1px solid black;">
                            1
                        </td>

                        <td style="padding: 10px; line-height: 1; border: 1px solid black;">
                            {{ strtoupper($quotation->machine->name) }} Model {{ $quotation->modele->name }} <br>
                            ALONG WITH AC FREQUENCY DRIVE <br>
                            ELECTRICAL PANEL

                            @if ($quotation->remark != '')
                                <p>({{ $quotation->remark }})</p>
                            @endif
                        </td>

                        <td
                            style="text-align: center; vertical-align: top; padding:80px 10px; border: 1px solid black;">
                            {{ $qty }} Nos.
                        </td>

                        <td
                            style="text-align: center; vertical-align: top; padding:80px 15px; border: 1px solid black;">
                            {{ format_indian_number($unitPrice, 2) }}
                        </td>

                        <td
                            style="text-align: center; vertical-align: top; padding:80px 15px; border: 1px solid black;">
                            {{ format_indian_number($amount, 2) }}
                        </td>
                    </tr>

                @endif


                {{-- ===================== --}}
                {{-- TOTAL SECTION SAME --}}
                {{-- ===================== --}}
                @if ($discount == 'amount')
                    <tr>
                        <td colspan="4"
                            style="text-align:right; padding:12px; border:1px solid black; font-weight:600;">
                            Subtotal
                        </td>
                        <td style="text-align:right; padding:12px; border:1px solid black; font-weight:600;">
                            {{ format_indian_number($amount + $subTotal, 2) }}
                        </td>
                    </tr>

                    <tr>
                        <td colspan="4"
                            style="text-align:right; padding:12px; border:1px solid black; font-weight:600;">
                            Less: Discount
                        </td>
                        <td style="text-align:right; padding:12px; border:1px solid black; font-weight:600;">
                            {{ format_indian_number($quotation->discount_amount, 2) }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="padding:14px; border:1px solid black; font-weight:bold;">

                            <table style="width:100%; border-collapse:collapse;">
                                <tr>
                                    <!-- Rupees Words -->
                                    <td style="text-align:left; vertical-align:top; padding:0;">
                                        RUPEES {{ strtoupper($words) }} ONLY
                                    </td>

                                    <!-- Net Payable Amount -->
                                    <td style="text-align:right; white-space:nowrap; padding-left:20px;">
                                        Net Payable Amount
                                    </td>
                                </tr>
                            </table>

                        </td>

                        <td style="text-align:right; padding:14px; border:1px solid black; font-weight:bold;">
                            {{ format_indian_number($quotation->total, 2) }}
                        </td>
                    </tr>

                    {{-- <tr>
                        <td colspan="5"
                            style="text-align:center; padding:16px; border:1px solid black; font-weight:bold;">
                           Note:{{ $quotation->remark }}
                        </td>
                    </tr> --}}
                @elseif($discount == 'percentage')
                    <tr>
                        <td colspan="4"
                            style="text-align:right; padding:12px; border:1px solid black; font-weight:600;">
                            Subtotal
                        </td>
                        <td style="text-align:right; padding:12px; border:1px solid black; font-weight:600;">
                            {{ format_indian_number($amount + $subTotal, 2) }}
                        </td>
                    </tr>

                    <tr>
                        <td colspan="4"
                            style="text-align:right; padding:12px; border:1px solid black; font-weight:600;">
                            Less: Discount ({{ format_indian_number($quotation->discount_percentage, 2) }}%)
                        </td>
                        <td style="text-align:right; padding:12px; border:1px solid black; font-weight:600;">
                            {{ format_indian_number($amount * ($quotation->discount_percentage / 100), 2) }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="padding:14px; border:1px solid black; font-weight:bold;">

                            <table style="width:100%; border-collapse:collapse;">
                                <tr>
                                    <!-- Rupees Words -->
                                    <td style="text-align:left; vertical-align:top; padding:0;">
                                        RUPEES {{ strtoupper($words) }} ONLY
                                    </td>

                                    <!-- Net Payable Amount -->
                                    <td style="text-align:right; white-space:nowrap; padding-left:20px;">
                                        Net Payable Amount
                                    </td>
                                </tr>
                            </table>

                        </td>

                        <td style="text-align:right; padding:14px; border:1px solid black; font-weight:bold;">
                            {{ format_indian_number($quotation->total, 2) }}
                        </td>
                    </tr>

                    {{-- <tr>
                        <td colspan="5"
                            style="text-align:center; padding:16px; border:1px solid black; font-weight:bold;">
                            Note:{{ $quotation->remark }} 
                        </td>
                    </tr> --}}
                @else
                    <tr>
                        <td colspan="4" style="padding:14px; border:1px solid black; font-weight:bold;">

                            <table style="width:100%; border-collapse:collapse;">
                                <tr>
                                    <!-- Rupees Words -->
                                    <td style="text-align:left; vertical-align:top; padding:0;">
                                        RUPEES {{ strtoupper($words) }} ONLY
                                    </td>

                                    <!-- Net Payable Amount -->
                                    <td style="text-align:right; white-space:nowrap; padding-left:20px;">
                                       Total
                                    </td>
                                </tr>
                            </table>

                        </td>

                        <td style="text-align:right; padding:14px; border:1px solid black; font-weight:bold;">
                            {{ format_indian_number($quotation->total, 2) }}
                        </td>
                    </tr>

                    {{-- <tr>
                        <td colspan="5"
                            style="text-align:center; padding:16px; border:1px solid black; font-weight:bold;">
                             Note:{{ $quotation->remark }}
                        </td>
                    </tr> --}}
                @endif
                @if($quotation->remark)
                       <tr>
                            <td colspan="5"
                                style="text-align: center; padding: 16px 10px; font-weight: bold; border: 1px solid black;">
                                 Note:{{ $quotation->remark }} 
                            </td>
                        </tr>
                 @endif

            </tbody>
        </table>
    </div>
</div>
