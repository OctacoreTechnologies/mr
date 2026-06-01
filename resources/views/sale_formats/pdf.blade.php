<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<style>

@page { margin: 72px 15px 18px 15px; }

@font-face {
    font-family: 'Poppins';
    font-style: normal;
    font-weight: 400;
    src: url('{{ public_path("fonts/Poppins-Regular.ttf") }}') format('truetype');
}
@font-face {
    font-family: 'Poppins';
    font-style: normal;
    font-weight: 700;
    src: url('{{ public_path("fonts/Poppins-Bold.ttf") }}') format('truetype');
}

body {
    margin: 0;
    padding: 0;
    font-family: 'Poppins', sans-serif;
    font-size: 11px;
    color: #111;
    border: 1.5px solid #032854;
}

/* ── Fixed Logo ───────────────────────────────────────────── */
.page-logo {
    position: fixed;
    top: -58px; /* negative → puts logo inside the 72px @page top margin */
    right: 14px;
    text-align: right;
}
.page-logo img { height: 50px; }

/* ── Main Content ─────────────────────────────────────────── */
.content { padding: 10px 18px 18px 18px; }

/* ── Document Title ───────────────────────────────────────── */
.doc-title { text-align: center; margin-bottom: 12px; }
.doc-title-main {
    font-size: 20px;
    font-weight: bold;
    color: #2daae3;
    text-transform: uppercase;
    text-decoration: underline;
    letter-spacing: 2px;
    margin: 0 0 4px 0;
}
.doc-title-sub {
    font-size: 12.5px;
    color: #032854;
    font-weight: bold;
    margin: 0;
}

/* ── SF No / Date ─────────────────────────────────────────── */
.sf-row { margin: 10px 0 0 0; }
.sf-row table { border: none; width: 100%; }
.sf-row td {
    border: none;
    font-size: 11.5px;
    color: #032854;
    font-weight: bold;
    padding: 2px 0;
}

/* ── Dividers ─────────────────────────────────────────────── */
.divider-main {
    height: 3px;
    border-top: 2px solid #032854;
    border-bottom: 1.5px solid #2daae3;
    margin: 8px 0 16px 0;
}
.divider-thin {
    border-top: 1px solid #d5d5d5;
    margin: 13px 0;
}

/* ── Section Heading ──────────────────────────────────────── */
.sec-head {
    font-size: 11px;
    font-weight: bold;
    color: #fff;
    background: #032854;
    padding: 5px 10px;
    margin: 0 0 0 0;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

/* ── Info Table (label : value) ───────────────────────────── */
.info-table { border-collapse: collapse; width: 100%; }
.info-table td { border: 1px solid #d8e4f0; padding: 6px 11px; vertical-align: top; }
.info-lbl {
    width: 130px;
    font-weight: bold;
    color: #032854;
    background: #f0f6fc;
    white-space: nowrap;
    font-size: 11px;
}
.info-sep {
    width: 10px;
    background: #f0f6fc;
    font-weight: bold;
    color: #032854;
    padding: 6px 3px !important;
}
.info-val       { font-size: 11px; color: #333; word-break: break-word; }
.info-val-bold  { font-size: 11px; font-weight: bold; color: #032854; word-break: break-word; }
.info-val-link  { font-size: 11px; color: #2daae3; word-break: break-word; }

/* ── Sale Details Table ───────────────────────────────────── */
.detail-table { border-collapse: collapse; width: 100%; font-size: 11px; }
.detail-table th { border: 1px solid #d8e4f0; padding: 5px 9px; background: #f0f6fc; font-weight: bold; color: #032854; text-align: left; }
.detail-table td { border: 1px solid #d8e4f0; padding: 6px 9px; vertical-align: middle; color: #333; }
.detail-num-col { width: 28px; text-align: center; font-weight: bold; color: #2daae3; background: #f0f6fc; }

/* ── Requirements Table ───────────────────────────────────── */
.req-table { border-collapse: collapse; width: 100%; font-size: 11px; }
.req-table td { border: 1px solid #d8e4f0; padding: 6px 10px; vertical-align: top; line-height: 1.6; }
.req-num {
    width: 28px;
    text-align: center;
    font-weight: bold;
    color: #2daae3;
    background: #f0f6fc;
}

/* ── Remark (Quill HTML reset) ────────────────────────────── */
.remark-body p          { margin: 0 0 3px 0; padding: 0; line-height: 1.55; }
.remark-body p:last-child { margin-bottom: 0; }
.remark-body ul,
.remark-body ol         { margin: 2px 0 3px 0; padding-left: 16px; }
.remark-body li         { margin: 1px 0; line-height: 1.55; }
.remark-body ul > li    { list-style-type: disc; }
.remark-body ol > li    { list-style-type: decimal; }
.remark-body strong     { font-weight: bold; }
.remark-body em         { font-style: italic; }
.remark-body u          { text-decoration: underline; }
.remark-body h1, .remark-body h2, .remark-body h3 { margin: 3px 0 2px 0; }

/* ── Sign-off ─────────────────────────────────────────────── */
.signoff-table { border: none; width: 100%; margin-top: 10px; }
.signoff-table td { border: none; padding: 0; vertical-align: top; gap: 20px; }
.signoff-box {
    border: 1px solid #d8e4f0;
    padding: 10px 14px 14px 14px;
    /* position: relative;
    left:20px; */
}
.approved_by{
    /* position:absolute;
    left:120px; */
}
.signoff-lbl {
    font-weight: bold;
    font-size: 11px;
    color: #032854;
    border-bottom: 1.5px solid #2daae3;
    padding-bottom: 4px;
    margin-bottom: 6px;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    text-align: center;
}
.signoff-val { font-size: 11px; color: #444; margin-top: 5px; text-align: center; }

</style>
</head>
<body>

{{-- ── Fixed Logo ──────────────────────────────────────────────────── --}}
<div class="page-logo">
    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('image/logo.png'))) }}" alt="Logo">
</div>


{{-- ── Page Content ────────────────────────────────────────────────── --}}
<div class="content">

    {{-- Title --}}
    <div class="doc-title">
        <div class="doc-title-main">Sale Format</div>
        <div class="doc-title-sub">Enquiry &amp; Requirement Sheet</div>
    </div>

    {{-- SF No & Date --}}
    <div class="sf-row">
        <table>
            <tr>
                <td><b>SF No. :</b>&nbsp; SF-{{ str_pad($saleFormat->id, 4, '0', STR_PAD_LEFT) }}</td>
                <td style="text-align:right;"><b>Date :</b>&nbsp; {{ $saleFormat->sale_date->format('d M Y') }}</td>
            </tr>
        </table>
    </div>

    <div class="divider-main"></div>

    {{-- ── Client Information ─────────────────────────────────────────── --}}
    <div class="sec-head">Client Information</div>
    <table class="info-table">
        <tr>
            <td class="info-lbl">Client Name</td>
            <td class="info-sep">:</td>
            <td class="info-val-bold">{{ $saleFormat->customer->company_name ?? '—' }}</td>
        </tr>
        @if($saleFormat->customer->gst ?? null)
        <tr>
            <td class="info-lbl">GST No.</td>
            <td class="info-sep">:</td>
            <td class="info-val">{{ $saleFormat->customer->gst }}</td>
        </tr>
        @endif
        @if($saleFormat->customer->address_line_1 ?? null)
        <tr>
            <td class="info-lbl">Address</td>
            <td class="info-sep">:</td>
            <td class="info-val">{{ $saleFormat->customer->address_line_1 }}</td>
        </tr>
        @endif
    </table>

    {{-- ── Contact Person ──────────────────────────────────────────────── --}}
    @if($saleFormat->cp_name || $saleFormat->cp_contact || $saleFormat->cp_email || $saleFormat->cp_designation)
    <div class="divider-thin"></div>
    <div class="sec-head">Contact Person</div>
    <table class="info-table">
        @if($saleFormat->cp_name)
        <tr>
            <td class="info-lbl">Contact Person</td>
            <td class="info-sep">:</td>
            <td class="info-val-bold">{{ $saleFormat->cp_name }}</td>
        </tr>
        @endif
        @if($saleFormat->cp_designation)
        <tr>
            <td class="info-lbl">Designation</td>
            <td class="info-sep">:</td>
            <td class="info-val">{{ $saleFormat->cp_designation }}</td>
        </tr>
        @endif
        @if($saleFormat->cp_contact)
        <tr>
            <td class="info-lbl">Contact No.</td>
            <td class="info-sep">:</td>
            <td class="info-val">{{ $saleFormat->cp_contact }}</td>
        </tr>
        @endif
        @if($saleFormat->cp_email)
        <tr>
            <td class="info-lbl">E-Mail ID</td>
            <td class="info-sep">:</td>
            <td class="info-val-link">{{ $saleFormat->cp_email }}</td>
        </tr>
        @endif
    </table>
    @endif

    {{-- ── Sale Details ────────────────────────────────────────────────── --}}
    @if(!empty($saleFormat->sale_details))
    <div class="divider-thin"></div>
    <div class="sec-head">Sale Details</div>
    <table class="detail-table">
        <tr>
            <th class="detail-num-col">#</th>
            <th>Application</th>
            <th>Model</th>
            <th>Output</th>
        </tr>
        @foreach($saleFormat->sale_details as $i => $detail)
        <tr>
            <td class="detail-num-col">{{ $i + 1 }}</td>
            <td>{{ $detail['application'] ?? '' }}</td>
            <td>{{ $detail['model'] ?? '' }}</td>
            <td>{{ $detail['output'] ?? '' }}</td>
        </tr>
        @endforeach
    </table>
    @endif

    {{-- ── Requirements ────────────────────────────────────────────────── --}}
    @if($saleFormat->requirements->isNotEmpty())
    <div class="divider-thin"></div>
    <div class="sec-head">Requirements</div>
    <table class="req-table">
        @foreach($saleFormat->requirements as $req)
        <tr>
            <td class="req-num">{{ $req->sort_order }}.</td>
            <td>{{ $req->requirement_description }}</td>
        </tr>
        @endforeach
    </table>
    @endif

    {{-- ── Remark ───────────────────────────────────────────────────────── --}}
    @if($saleFormat->remark)
    @php
        $inlineStyles = [
            'p'  => 'margin:0 0 3px 0;padding:0;line-height:1.5;font-size:11px;color:#333;',
            'ul' => 'list-style-type:disc;margin:2px 0 4px 0;padding-left:14px;',
            'ol' => 'list-style-type:decimal;margin:2px 0 4px 0;padding-left:14px;',
            'li' => 'margin:1px 0;line-height:1.5;font-size:11px;color:#333;',
            'h1' => 'font-size:13px;font-weight:bold;margin:3px 0 2px 0;padding:0;color:#333;',
            'h2' => 'font-size:12px;font-weight:bold;margin:3px 0 2px 0;padding:0;color:#333;',
            'h3' => 'font-size:11px;font-weight:bold;margin:3px 0 2px 0;padding:0;color:#333;',
        ];
        $remarkHtml = preg_replace_callback(
            '/<(p|ul|ol|li|h[123])\b([^>]*)>/i',
            function ($m) use ($inlineStyles) {
                $tag   = strtolower($m[1]);
                $attrs = $m[2];
                $add   = $inlineStyles[$tag] ?? '';
                if (preg_match('/style="([^"]*)"/i', $attrs, $sm)) {
                    $attrs = preg_replace('/style="[^"]*"/i', 'style="' . $sm[1] . ';' . $add . '"', $attrs);
                } else {
                    $attrs .= ' style="' . $add . '"';
                }
                return '<' . $tag . $attrs . '>';
            },
            $saleFormat->remark
        );
    @endphp
    <div class="divider-thin"></div>
    <div class="sec-head">Remark</div>
    <div style="font-size:11px;color:#333;padding:8px 11px;border:1px solid #d8e4f0;">
        {!! $remarkHtml !!}
    </div>
    @endif

    {{-- ── Visiting Card + Sign-off (combined row to save vertical space) ── --}}
    @php
        $vcPath   = $saleFormat->customer->visiting_card ?? null;
        $vcExists = $vcPath && file_exists(public_path($vcPath));
        $mime  = null;
        $vcB64 = null;
        if ($vcExists) {
            $ext   = strtolower(pathinfo(public_path($vcPath), PATHINFO_EXTENSION));
            $mime  = in_array($ext, ['jpg','jpeg']) ? 'jpeg' : 'png';
            $vcB64 = base64_encode(file_get_contents(public_path($vcPath)));
        }
    @endphp

    <div class="divider-thin" style="margin-top:14px;"></div>
    <table style="width:100%; border-collapse:collapse; border:none; page-break-inside:avoid;">
        <tr>
            {{-- Sign-off on the left --}}
            <td style="width:{{ $vcExists ? '56%' : '100%' }}; vertical-align:bottom; border:none; padding-right:{{ $vcExists ? '12px' : '0' }};">
                <table style="border:none; width:100%;">
                    <tr>
                        <td style="width:48%; border:none;">
                            <div class="signoff-box">
                                <div class="signoff-lbl">Prepared By</div>
                                <div class="signoff-val">{{ $saleFormat->prepared_by ?? '' }}</div>
                            </div>
                        </td>
                        <td style="width:4%; border:none;">&nbsp;</td>
                        <td style="width:48%; border:none;">
                            <div class="signoff-box">
                                <div class="signoff-lbl">Approved By</div>
                                <div class="signoff-val">{{ $saleFormat->approved_by ?? '' }}</div>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
            {{-- Visiting card on the right (only if exists) --}}
            @if($vcExists)
            <td style="width:44%; vertical-align:top; border:none;">
                <div class="sec-head" style="text-align:center;">Visiting Card</div>
                <div style="text-align:center; padding:6px 4px; border:1px solid #d8e4f0; border-top:none;">
                    <img src="data:image/{{ $mime }};base64,{{ $vcB64 }}"
                         style="max-width:100%; max-height:85px; height:auto;" alt="Visiting Card">
                </div>
            </td>
            @endif
        </tr>
    </table>

</div>{{-- end content --}}

</body>
</html>
