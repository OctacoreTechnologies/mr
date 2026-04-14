<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Letter for Advance Payment – M.R. Engineers</title>
    <style>
        @page {
            size: A4;
            margin: 8mm 9mm 8mm 9mm;
        }
        * { box-sizing: border-box; }

        body {
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
            font-size: 8.8pt;
            color: #111111;
            margin: 0;
            padding: 0;
            line-height: 1.35;
        }

        /* ─── OUTER BORDER ─────────────────────────────── */
        .doc {
            width: 100%;
            border: 1.2pt solid #1a1a1a;
            border-collapse: collapse;
        }
        .doc td { padding: 0; vertical-align: top; }

        /* ─── COMPANY HEADER ───────────────────────────── */
        .hdr-logo {
            width: 20%;
            padding: 7px 8px;
            text-align: center;
            vertical-align: middle;
            border-right: 1pt solid #1a1a1a;
        }
        .hdr-name {
            width: 80%;
            padding: 9px 13px 7px 13px;
            vertical-align: middle;
        }
        .co-name {
            font-size: 14.5pt;
            font-weight: bold;
            color: #0c2a54;
            letter-spacing: 2pt;
            margin: 0 0 3px 0;
        }
        .co-sub {
            font-size: 7.7pt;
            color: #3a3a3a;
            line-height: 1.6;
        }

        /* ─── TITLE BAND ───────────────────────────────── */
        .title-td {
            background-color: #0c2a54;
            color: #ffffff;
            text-align: center;
            font-size: 10pt;
            font-weight: bold;
            letter-spacing: 3.5pt;
            padding: 6px 0;
            border-top: 1pt solid #0c2a54;
            border-bottom: 1pt solid #0c2a54;
        }

        /* ─── BILL / SHIP ──────────────────────────────── */
        .bs-left  { width: 50%; padding: 0; vertical-align: top; }
        .bs-right { width: 50%; padding: 0; vertical-align: top; border-left: 1pt solid #1a1a1a; }

        .sec-lbl {
            font-size: 7.4pt;
            font-weight: bold;
            color: #0c2a54;
            letter-spacing: 1pt;
            text-transform: uppercase;
            padding: 4px 9px 3px 9px;
            border-bottom: 0.8pt solid #1a1a1a;
        }
        .addr {
            padding: 4px 9px 4px 9px;
            font-size: 8.3pt;
            min-height: 32px;
            line-height: 1.55;
            border-bottom: 0.5pt solid #cccccc;
        }
        .kv { width: 100%; border-collapse: collapse; font-size: 8.2pt; }
        .kv tr td { padding: 2.5px 9px; vertical-align: top; }
        .kv tr td:first-child { width: 44%; color: #444; font-weight: bold; }
        .kv .sp td { border-top: 0.5pt solid #dddddd; padding-top: 3px; }

        /* ─── ITEMS TABLE ──────────────────────────────── */
        .itm {
            width: 100%;
            border-collapse: collapse;
            border-top: 1pt solid #1a1a1a;
            border-left: 1.2pt solid #1a1a1a;
            border-right: 1.2pt solid #1a1a1a;
        }
        .itm thead th {
            background-color: #0c2a54;
            color: #ffffff;
            font-size: 7.8pt;
            font-weight: bold;
            text-align: center;
            padding: 5px 4px;
            border-right: 0.8pt solid #1e3f72;
        }
        .itm thead th:first-child { text-align: left; padding-left: 8px; }
        .itm thead th:last-child  { border-right: none; }

        .itm tbody td {
            font-size: 8.2pt;
            padding: 4.5px 6px;
            border-right: 0.5pt solid #cccccc;
            border-bottom: 0.5pt solid #e0e0e0;
            vertical-align: middle;
        }
        .itm tbody td:last-child { border-right: none; }
        .itm tbody tr.main-row td { font-weight: bold; }
        .itm tbody tr.filler td  {
            border-bottom: 0.4pt solid #eeeeee;
            height: 19px;
        }

        /* ─── TOTALS ───────────────────────────────────── */
        .tot {
            width: 100%;
            border-collapse: collapse;
            border-left: 1.2pt solid #1a1a1a;
            border-right: 1.2pt solid #1a1a1a;
        }
        .tot tr td {
            font-size: 8.2pt;
            padding: 3.5px 9px;
            border-bottom: 0.5pt solid #cccccc;
            vertical-align: middle;
        }
        .tot .lbl { width: 68%; }
        .tot .key {
            width: 17%;
            text-align: center;
            font-weight: bold;
            font-size: 7.7pt;
            color: #0c2a54;
            border-left: 0.8pt solid #aaaaaa;
        }
        .tot .val {
            width: 15%;
            text-align: right;
            font-weight: bold;
            border-left: 0.5pt solid #cccccc;
        }
        .tot .grand td {
            background-color: #0c2a54;
            color: #ffffff;
            border-bottom: none;
            padding-top: 5px;
            padding-bottom: 5px;
        }
        .tot .grand .key { color: #aacfff; border-left-color: #1e4080; font-size: 8.5pt; }
        .tot .grand .val { font-size: 10pt; border-left-color: #1e4080; }

        /* ─── FOOTER ───────────────────────────────────── */
        .ftr {
            width: 100%;
            border-collapse: collapse;
            border: 1.2pt solid #1a1a1a;
            border-top: 1pt solid #1a1a1a;
        }
        .ftr td {
            font-size: 7.9pt;
            padding: 8px 10px 10px 10px;
            vertical-align: top;
            border-right: 0.8pt solid #aaaaaa;
        }
        .ftr td:last-child { border-right: none; }
        .ftr-lbl {
            font-size: 7.3pt;
            font-weight: bold;
            color: #0c2a54;
            letter-spacing: 0.8pt;
            text-transform: uppercase;
            margin-bottom: 5px;
            padding-bottom: 3px;
            border-bottom: 0.5pt solid #cccccc;
        }
        .bank-col { width: 42%; }
        .gst-col  { width: 27%; }
        .sig-col  { width: 31%; }

        .sig-wrap {
            height: 75px;
            position: relative;
        }
        .sig-top {
            font-weight: bold;
            color: #0c2a54;
            font-size: 8.3pt;
        }
        .sig-bot {
            text-align: center;
            border-top: 0.8pt solid #888888;
            padding-top: 4px;
            margin-top: 55px;
            font-size: 7.8pt;
            color: #444444;
            font-style: italic;
        }

        /* ─── utils ────────────────────────────────────── */
        .tr { text-align: right; }
        .tc { text-align: center; }
        .b  { font-weight: bold; }
        .it { font-style: italic; }
        .navy { color: #0c2a54; }
        .logo{
            position: relative;
            top: 15px;
        }
        .company-address {
            position: relative;
            top: 5px;
        }
        .company-address  {
            margin: 3px;
        }
    </style>
</head>
<body>

@php
    /* ── discount ──────────────────────────────────── */
    $discountType = $saleOrder->discount_type;
    $unitPrice    = $saleOrder->quotation->total_price ?? 0;
    if ($discountType == 'percentage') {
        $unitPrice = $unitPrice - ($unitPrice * $saleOrder->discount_percentage) / 100;
    } elseif ($discountType == 'amount') {
        $unitPrice = $unitPrice - $saleOrder->discount_amount;
    }
    $qty = $saleOrder->quotation->quantity ?: 1;
    $totalBasicAmount = $unitPrice * $qty;

    /* ── extra items ───────────────────────────────── */
    $extraItems = [];
    if (!empty($saleOrder->quotation->items)) {
        foreach ($saleOrder->quotation->items as $it) {
            $iup = $it->item_price ?? 0;
            if ($discountType == 'percentage') {
                $iup = $iup - ($iup * $saleOrder->discount_percentage) / 100;
            }
            $totalBasicAmount += $iup * ($it->item_qty ?? 0);
            $extraItems[] = ['obj' => $it, 'price' => $iup];
        }
    }

    /* ── tax / grand ───────────────────────────────── */
    $totalTax = (($totalBasicAmount
                  + $saleOrder->transporation_charge
                  + $saleOrder->insurance
                  + $saleOrder->packging) * ($saleOrder->tax ?? 0)) / 100;
    $grandTotal = $totalTax
                + $totalBasicAmount
                + $saleOrder->transporation_charge
                + $saleOrder->insurance
                + $saleOrder->packging;

    /* ── filler: always show at least 6 item rows ── */
    $usedRows   = 1 + count($extraItems);
    $fillerRows = max(0, 6 - $usedRows);
@endphp

<!-- ══════════════ HEADER ══════════════ -->
<table class="doc">
    <tr>
        <td class="hdr-logo">
            <img class="logo" src="{{ asset('/image/mr_logo.png') }}" height="82px" alt="MR">
        </td>
        <td class="hdr-name">
          <div class="company-address">
              <p class="co-name">M. R. ENGINEERS</p>
              <p class="co-sub">
                  SNO.: 351/2-A, PSL Compound, Char Rasta, Kachigam, Nani Daman – 396 210<br>
                  Email: sales1@mrengineers.co.in &nbsp;|&nbsp; GST: 26AAQFM7310P1ZO &nbsp;|&nbsp;
                  Division: South Daman &nbsp;|&nbsp; Commissionerate: Daman
              </p>
            </divc>
        </td>
    </tr>

    <!-- title -->
    <tr>
        <td colspan="2" class="title-td">LETTER FOR ADVANCE PAYMENT</td>
    </tr>

    <!-- bill / ship -->
    <tr>
        <td class="bs-left">
            <div class="sec-lbl">&#9632;&nbsp;Bill To</div>
            <div class="addr">
                <span class="b">M/s. {{ $saleOrder->quotation->customer->contact_person_1_name ?? '' }}</span><br>
                {{ $saleOrder->quotation->customer->address_line_1 ?? '' }},
                {{ $saleOrder->quotation->customer->city ?? '' }},
                {{ $saleOrder->quotation->customer->state ?? '' }}
                – {{ preg_replace('/\s+/', '', $saleOrder->quotation->customer->pincode ?? '') }}
            </div>
            <table class="kv">
                <tr><td>GST No.</td><td>{{ $saleOrder->quotation->customer->gst ?? '–' }}</td></tr>
                <tr class="sp"><td>LAP No.</td><td class="b">{{ $saleOrder->lap_no ?? '0' }}/{{ $saleOrder->financial_year ?? '2025-26' }}</td></tr>
                <tr><td>Quotation No.</td><td>{{ $saleOrder->quotation->reference_no ?? '–' }}</td></tr>
                <tr><td>Date</td><td>{{ formatDate($saleOrder->order_date ?? '') }}</td></tr>
            </table>
        </td>

        <td class="bs-right">
            <div class="sec-lbl">&#9632;&nbsp;Ship To</div>
            <div class="addr">
                <span class="b">M/s. {{ $saleOrder->quotation->customer->contact_person_2_name ?? $saleOrder->quotation->customer->contact_person_1_name }}</span><br>
                {{ $saleOrder->quotation->customer->address_line_2 ?? $saleOrder->quotation->customer->address_line_1 }}
            </div>
            <table class="kv">
                <tr><td>Kind Attn.</td><td>{{ $saleOrder->followedBy->name ?? '–' }}</td></tr>
                <tr class="sp"><td>Contact</td><td>{{ $saleOrder->quotation->customer->contact_no ?? '–' }}</td></tr>
                <tr><td>Email</td><td>{{ $saleOrder->quotation->customer->contact_person_1_email ?? '–' }}</td></tr>
                <tr><td>Customer P.O. No.</td><td>{{ $saleOrder->quotation->customer->po_no ?? '–' }}</td></tr>
                <tr><td>P.O. Date</td><td>{{ formatDate($saleOrder->quotation->customer->po_date ?? '') }}</td></tr>
            </table>
        </td>
    </tr>
</table>

<!-- ══════════════ ITEMS ══════════════ -->
<table class="itm">
    <thead>
        <tr>
            <th style="width:42%; text-align:left; padding-left:8px;">Description</th>
            <th style="width:11%;">HSN Code</th>
            <th style="width:6%;">Qty</th>
            <th style="width:6%;">Unit</th>
            <th style="width:16%;">Unit Rate (&#8377;)</th>
            <th style="width:19%;">Amount (&#8377;)</th>
        </tr>
    </thead>
    <tbody>
        {{-- main machine --}}
        <tr class="main-row">
            <td style="padding-left:8px;">
                {{ strtoupper($saleOrder->quotation->machine->name) }}
                {{ $saleOrder->quotation->modele->name }}
            </td>
            <td class="tc">{{ $saleOrder->quotation->machine->hsn ?? '–' }}</td>
            <td class="tc">{{ $qty }}</td>
            <td class="tc">Nos.</td>
            <td class="tr">{{ format_indian_number($unitPrice / $qty) }}</td>
            <td class="tr">{{ format_indian_number($unitPrice) }}</td>
        </tr>

        {{-- additional items --}}
        @foreach ($extraItems as $row)
            <tr>
                <td style="padding-left:8px;">{{ $row['obj']->item_name ?? '' }}</td>
                <td class="tc">{{ $row['obj']->hsn ?? '–' }}</td>
                <td class="tc">{{ $row['obj']->item_qty ?? '' }}</td>
                <td class="tc">{{ $row['obj']->qty_unit ?? '' }}.</td>
                <td class="tr">{{ format_indian_number($row['price']) }}</td>
                <td class="tr">{{ format_indian_number($row['price'] * ($row['obj']->item_qty ?? 0)) }}</td>
            </tr>
        @endforeach

        {{-- filler rows --}}
        @for ($i = 0; $i < $fillerRows-1; $i++)
            <tr class="filler">
                <td style="padding-left:8px;">&nbsp;</td>
                <td></td><td></td><td></td><td></td><td></td>
            </tr>
        @endfor
        <tr class="filler" style="border-bottom:1px solid black">
                <td style="padding-left:8px;">&nbsp;</td>
                <td></td><td></td><td></td><td></td><td></td>
            </tr>
    </tbody>
</table>

<!-- ══════════════ TOTALS ══════════════ -->
<table class="tot">
    <tr>
        <td class="lbl" >
            <span class="b navy">Payment Terms:</span>&nbsp;
            <span class="it">{{ $saleOrder->payment_term_condition }}</span>
        </td>
        <td class="key">Basic Total</td>
        <td class="val">{{ format_indian_number($totalBasicAmount) }}</td>
    </tr>
    <tr>
        <td class="lbl">
            <span class="b navy">Freight:</span>&nbsp;
            <span class="it">{{ $saleOrder->transporation_payment ? 'To Pay' : 'Will Pay' }}</span>
        </td>
        @if ($saleOrder->transporation_payment)
            <td class="key">Transport</td>
            <td class="val">{{ format_indian_number($saleOrder->transporation_charge) }}</td>
        @else
            <td class="key" style="color:#aaa;">–</td>
            <td class="val" style="color:#aaa;">–</td>
        @endif
    </tr>
    <tr>
        <td class="lbl"><span class="b navy">Insurance:</span>&nbsp;<span class="it">Extra</span></td>
        <td class="key">Insurance</td>
        <td class="val">{{ format_indian_number($saleOrder->insurance) }}</td>
    </tr>
    <tr>
        <td class="lbl"><span class="b navy">Packing:</span>&nbsp;<span class="it">Extra</span></td>
        <td class="key">Packing</td>
        <td class="val">{{ format_indian_number($saleOrder->packging) }}</td>
    </tr>
    <tr>
        <td class="lbl"></td>
        <td class="key">GST @ {{ $saleOrder->tax ?? '' }}%</td>
        <td class="val">{{ format_indian_number($totalTax) }}</td>
    </tr>
    <tr class="grand">
        <td class="lbl" style="padding:5px 9px; font-size:7.9pt;">
            <span style="color:#8ab8e8; font-weight:bold; font-size:7.4pt;">AMOUNT IN WORDS:&nbsp;</span>
            <span style="font-style:italic;">
                {{ strtoupper(convertToIndianWords($totalTax + $saleOrder->total_amount)) }} RUPEES ONLY
            </span>
        </td>
        <td class="key" style="font-size:9pt; vertical-align:middle;">TOTAL<br>VALUE</td>
        <td class="val" style="vertical-align:middle;">{{ format_indian_number($grandTotal) }}</td>
    </tr>
</table>

<!-- ══════════════ FOOTER ══════════════ -->
<table class="ftr">
    <tr>
        <td class="bank-col">
            <div class="ftr-lbl">&#9632;&nbsp;Our Bank Details</div>
            Company:&nbsp;<span class="b">{{ $bankDetail->company_name }}</span><br>
            Bank:&nbsp;{{ $bankDetail->bank_name }}<br>
            A/c No.:&nbsp;<span class="b">{{ $bankDetail->account_number }}</span><br>
            IFSC:&nbsp;<span class="b">{{ $bankDetail->ifsc_code }}</span><br>
            Branch:&nbsp;{{ $bankDetail->branch_name }}
        </td>

        <td class="gst-col">
            <div class="ftr-lbl">&#9632;&nbsp;GST Details</div>
            GST No.:&nbsp;<span class="b navy">26AAQFM7310P1ZO</span><br>
            Division:&nbsp;<span class="b">South Daman</span><br>
            Commissionerate:&nbsp;<span class="b">Daman</span>
        </td>

        <td class="sig-col">
            <div class="sig-wrap">
                <div class="sig-top">For M R Engineers</div>
                <div class="sig-bot">
                    Authorised Signatory<br>
                    <em>Partner</em>
                </div>
            </div>
        </td>
    </tr>
</table>

</body>
</html>