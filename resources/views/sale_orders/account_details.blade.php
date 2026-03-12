<!DOCTYPE html>
<html>

<head>
    <title>Customer Account Details</title>

    <style>
        @page {
            margin: 120px 40px 60px 40px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 0;
        }

        header {
            position: fixed;
            top: -90px;
            right: 0;
            left: 0;
            height: 80px;
        }

        .logo {
            text-align: right;
        }

        .title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 7px;
            vertical-align: top;
        }

        th {
            width: 45%;
            background: #f5f5f5;
            text-align: left;
        }

        td {
            width: 55%;
        }

        .signature {
            margin-top: 60px;
        }

        .signature td {
            border: none;
        }
    </style>
</head>

<body>

    <header>
        <div class="logo">
            <img src="{{ public_path('/image/mr_logo.png') }}" height="70">
        </div>
    </header>

    <div class="title">
        Customer Account Details
    </div>

    @php

        $tax = $saleOrder->tax ?? 0;

        $taxAmount = (($saleOrder->total_amount + $saleOrder->transporation_charge) * $tax) / 100;

        $grandTotal = $saleOrder->total_amount + $taxAmount;

        $dicountType = $saleOrder->discount_type;
        $unitPrice = $saleOrder->total_amount;

        if ($dicountType == 'percentage') {
            $unitPrice = $unitPrice - ($unitPrice * $saleOrder->discount_percentage) / 100;
        } elseif ($dicountType == 'amount') {
            $unitPrice = $unitPrice - $saleOrder->disount_amount;
        }

    @endphp


    <table>

        <tbody>

            <tr>
                <th>1. Company Name & Address</th>
                <td>
                    {{ $saleOrder->quotation->customer->company_name ?? 'N/A' }} <br>
                    {{ $saleOrder->address ?? 'N/A' }}
                </td>
            </tr>

            <tr>
                <th>2. Contact Person</th>
                <td>{{ $saleOrder->quotation->customer->contact_person_1_name ?? 'N/A' }}</td>
            </tr>

            <tr>
                <th>3. Contact Number</th>
                <td>{{ $saleOrder->quotation->customer->contact_no ?? 'N/A' }}</td>
            </tr>

            <tr>
                <th>4. Machine Name</th>
                <td>{{ $saleOrder->quotation->machine->name ?? 'N/A' }}</td>
            </tr>

            <tr>
                <th>5. Model No.</th>
                <td>{{ $saleOrder->quotation->modele->name ?? 'N/A' }}</td>
            </tr>

            <tr>
                <th>6. Customer PO No.</th>
                <td>{{ $saleOrder->po_no ?? 'N/A' }}</td>
            </tr>

            <tr>
                <th>7. PO Date Received by MR</th>
                <td>{{ formatDate($saleOrder->order_date ?? '') }}</td>
            </tr>

            <tr>
                <th>8. Work Order No.</th>
                <td>{{ $saleOrder->work_order_no ?? 'N/A' }}</td>
            </tr>

            <tr>
                <th>9. Delivery Date</th>
                <td>{{ formatDate($saleOrder->delivery_date ?? '') }}</td>
            </tr>

            <tr>
                <th>10. Total Basic Price</th>
                <td>{{ format_indian_number($unitPrice ?? 0) }}</td>
            </tr>

            <tr>
                <th>11. Transportation</th>
                <td>{{ format_indian_number($saleOrder->transporation_charge ?? 0) }}</td>
            </tr>

            <tr>
                <th>12. Total GST Price</th>
                <td>{{ format_indian_number($taxAmount) }}</td>
            </tr>

            <tr>
                <th>13. Total Final Price</th>
                <td>{{ format_indian_number($saleOrder->grand_total ?? 0) }}</td>
            </tr>

            @php $index=14; @endphp

            @foreach ($saleOrder->payments as $i => $payment)
                <tr>
                    <th>{{ $index++ }}. Advance-{{ $i + 1 }}</th>
                    <td>{{ format_indian_number($payment->amount ?? 0) }}</td>
                </tr>
            @endforeach

            <tr>
                <th>{{ $index++ }}. Total Advance</th>
                <td>{{ format_indian_number($saleOrder->advanace_payment ?? 0) }}</td>
            </tr>

            <tr>
                <th>{{ $index++ }}. Balance Payment</th>
                <td>
                    {{ format_indian_number(($saleOrder->grand_total ?? 0) - ($saleOrder->advanace_payment ?? 0)) }}
                </td>
            </tr>

            <tr>
                <th>{{ $index++ }}. Remark</th>
                <td>{{ $saleOrder->remark ?? '-' }}</td>
            </tr>

        </tbody>
    </table>


    <table class="signature">

        <tr>

            <td style="text-align:left;">
                <strong>Prepared By</strong>
                <br><br><br>
                ____________________
            </td>

            <td style="text-align:right;">
                <strong>Approved By</strong>
                <br><br><br>
                ____________________
            </td>

        </tr>

    </table>

</body>

</html>
