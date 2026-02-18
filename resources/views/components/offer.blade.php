{{--<div class="page-break" style="page-break-before: always; width: 100%; padding:10px 5px 0px 30px;">

    <div class="offer" style="width: 90%;">

        <!-- Section Title -->
        <h2 style="text-decoration: underline; font-size: 16pt; margin-bottom: 20px;">3. OFFER</h2>

        <!-- Offer Table -->
      <table style="border-collapse: collapse; width: 100%; font-family: 'Poppins'; font-size: 11pt; color: #000;">
    <thead>
        <tr style="background-color: #f2f2f2; text-align: center; font-weight: bold; color: #333; border: 1px solid #bbb;">
            <th style="padding: 10px; border: 1px solid #bbb; width: 8%;">Sr. No.</th>
            <th style="padding: 10px; border: 1px solid #bbb; width: 52%;">Particulars</th>
            <th style="padding: 10px; border: 1px solid #bbb; width: 20%;">Qty</th>
            <th style="padding: 10px; border: 1px solid #bbb; width: 15%;">Unit Price (₹)</th>
            <th style="padding: 10px; border: 1px solid #bbb; width: 15%;">Amount (₹)</th>
        </tr>
    </thead>

    <tbody>
        @php
            $qty = $quotation->quantity ?? 0;
            $unitPrice = $quotation->total_price ?? 0;
            $discount = $quotation->discount ?? 0;
            $amount = $qty * $unitPrice;
            $netAmount = $amount - $discount;
        @endphp

        <!-- Item Row -->
        <tr style="border: 1px solid #ccc;">
            <td style="text-align: center; padding: 16px 8px; border: 1px solid #ccc;">1</td>
            <td style="padding: 12px 10px; line-height: 1.6; border: 1px solid #ccc;">
                <strong style="font-size: 11pt;">{{ strtoupper($quotation->machine->name) }} Model {{ $quotation->modele->name }} LTR</strong><br>
                <span style="font-size: 10pt;">{{ isset($quotation->ac_frequency_drive) ? 'With AC Frequency Drive and' : '' }} </span>
            </td>
            <td style="text-align: center; padding: 16px 8px; border: 1px solid #ccc;">{{ $qty }} Nos.</td>
            <td style="text-align: right; padding: 16px 10px; border: 1px solid #ccc;">₹{{ number_format($unitPrice, 2) }}</td>
            <td style="text-align: right; padding: 16px 10px; border: 1px solid #ccc;">₹{{ number_format($amount, 2) }}</td>
        </tr>

        <!-- Subtotal -->
        <tr>
            <td colspan="4" style="text-align: right; padding: 10px 15px; font-weight: 500; background-color: #fafafa; border: 1px solid #ccc;">
                Subtotal
            </td>
            <td style="text-align: right; padding: 10px 15px; background-color: #fafafa; border: 1px solid #ccc;">
                ₹{{ number_format($amount, 2) }}
            </td>
        </tr>

        <!-- Discount (if any) -->
        @if($discount > 0)
        <tr>
            <td colspan="4" style="text-align: right; padding: 10px 15px; font-weight: 500; background-color: #fffbe6; border: 1px solid #ccc;">
                Less: Discount
            </td>
            <td style="text-align: right; padding: 10px 15px; background-color: #fffbe6; border: 1px solid #ccc;">
                ₹{{ number_format($discount, 2) }}
            </td>
        </tr>
        @endif

        <!-- Net Payable -->
        <tr style="background-color: #f2f2f2;">
            <td colspan="4" style="text-align: right; padding: 12px 15px; font-weight: bold; border: 1px solid #bbb;">
                Net Payable Amount
            </td>
            <td style="text-align: right; padding: 12px 15px; font-weight: bold; border: 1px solid #bbb;">
                ₹{{ number_format($netAmount, 2) }}
            </td>
        </tr>

        <!-- Amount in Words -->
        <tr>
            <td colspan="5" style="text-align: center; padding: 20px 10px; font-weight: bold; font-style: italic; color: #444; border: 1px solid #ccc;">
                Amount in Words: RUPEES {{ strtoupper($words) }} ONLY
            </td>
        </tr>
    </tbody>
</table>

    </div>
</div>--}}

<div class="page-break" style="page-break-before: always;  width: 100%; padding:0px 5px 0px 20px;">
<div class="offer" style="width: 90%;">

  <div class="technical-data">
    <h2 style="text-decoration: underline; font-weight: bold;">
      3. OFFER
    </h2>
  </div>

  <!-- Table -->
  <table style="border-collapse: collapse; width: 110%; font-size: 14px; border: 1px solid black; line-height: 1; font-family: 'Poppins';" class='offer-table'>
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
        $discount = $quotation->discount_type ;
        $amount = $qty * $unitPrice;
        $netAmount = $quotation->total;
      @endphp

      <!-- Item Row -->
      <tr style="border: 1px solid black;">
        <td style="text-align: center; vertical-align: top; padding: 80px 10px; border: 1px solid black;">1</td>
        <td style="padding: 10px; line-height: 1; border: 1px solid black;">
          {{ strtoupper($quotation->machine->name) }} Model {{ $quotation->modele->name }} <br>
          ALONG WITH AC FREQUENCY DRIVE <br>
          ELECTRICAL PANEL
          @if ($quotation->remark!='')
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

      @if($discount == "amount")
        <!-- Subtotal -->
        <tr style="border: none">
          <td colspan="4" style="text-align: right; padding: 12px 15px; font-weight: 600; border: 1px solid black;">
            Subtotal
          </td>
          <td style="text-align: right; padding: 12px 15px; font-weight: 600; border: 1px solid black;">
            {{ format_indian_number($amount, 2) }}
          </td>
        </tr>

        <!-- Discount -->
        <tr style="border: 1px solid black;">
          <td colspan="4" style="text-align: right; padding: 12px 15px; font-weight: 600; border: 1px solid black;">
            Less: Discount
          </td>
          <td style="text-align: right; padding: 12px 15px; font-weight: 600; border: 1px solid black;">
            {{ format_indian_number($quotation->discount_amount, 2) }}
          </td>
        </tr>

        <!-- Net Payable -->
        <tr style="border: 1px solid black;">
          <td colspan="4" style="text-align: right; padding: 14px 15px; font-weight: bold; border: none;">
            Net Payable Amount
          </td>
          <td style="text-align: right; padding: 14px 15px; font-weight: bold; border: 1px solid black;">
            {{ format_indian_number($quotation->total, 2) }}
          </td>
        </tr>

        <!-- Amount in Words -->
        <tr style="border: 1px solid black;">
          <td colspan="5" style="text-align: center; padding: 16px 10px; font-weight: bold; border: 1px solid black;">
            RUPEES {{ strtoupper($words) }} ONLY
          </td>
        </tr>
      @elseif($discount == "percentage")
            <!-- Subtotal -->
        <tr style="border:none">
          <td colspan="4" style="text-align: right; padding: 12px 15px; font-weight: 600; border: 1px solid black;">
            Subtotal
          </td>
          <td style="text-align: right; padding: 12px 15px; font-weight: 600; border: 1px solid black;">
            {{ format_indian_number($amount, 2) }}
          </td>
        </tr>

        <!-- Discount -->
        <tr style="border: 1px solid black;">
          <td colspan="4" style="text-align: right; padding: 12px 15px; font-weight: 600; border: 1px solid black;">
           Discount(%)
          </td>
          <td style="text-align: right; padding: 12px 15px; font-weight: 600; border: 1px solid black;">
            {{ format_indian_number($quotation->discount_percentage, 2) }}%
          </td>
        </tr>

        <!-- Net Payable -->
        <tr style="border: 1px solid black;">
          <td colspan="4" style="text-align: right; padding: 14px 15px; font-weight: bold; border: 1px solid black;">
            Net Payable Amount
          </td>
          <td style="text-align: right; padding: 14px 15px; font-weight: bold; border: 1px solid black;">
            {{ format_indian_number($quotation->total, 2) }}
          </td>
        </tr>

        <!-- Amount in Words -->
        <tr style="border: 1px solid black;">
          <td colspan="5" style="text-align: center; padding: 16px 10px; font-weight: bold; border: 1px solid black;">
            RUPEES {{ strtoupper($words) }} ONLY
          </td>
        </tr>
      @else
        <!-- Only Total and Words -->
        <tr style="border-color: transparent;">
          <td colspan="4" style="text-align: right; padding: 14px 15px; font-weight: bold; border: 1px solid black;">
            Total
          </td>
          <td style="text-align: right; padding: 14px 15px; font-weight: bold; border: 1px solid black;">
            {{ format_indian_number($amount, 2) }}
          </td>
        </tr>

        <tr style="border: 1px solid black;">
          <td colspan="5" style="text-align: center; padding: 16px 10px; font-weight: bold; border: 1px solid black;">
            RUPEES {{ strtoupper($words) }} ONLY
          </td>
        </tr>
      @endif

    </tbody>
  </table>
</div>



</div>



