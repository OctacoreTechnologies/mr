<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<style>

/* ━━━ PAGE ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
@page {
    margin: 100px 0 46px 0;
}

@font-face {
    font-family: 'Poppins';
    font-weight: 400;
    src: url('{{ public_path("fonts/Poppins-Regular.ttf") }}') format('truetype');
}
@font-face {
    font-family: 'Poppins';
    font-weight: 700;
    src: url('{{ public_path("fonts/Poppins-Bold.ttf") }}') format('truetype');
}

body {
    margin: 0; padding: 0;
    font-family: 'Poppins', sans-serif;
    font-size: 11px;
    color: #1e293b;
    background: #fff;
}

/* ━━━ FIXED HEADER  (top: -96px → 100-96=4px from page top) ━━━ */
.hdr {
    position: fixed;
    top: -96px;
    left: 0; right: 0;
    background: #fff;
}

/* ━━━ FIXED FOOTER  (bottom: -42px → fits inside 46px margin) ━━ */
.ftr {
    position: fixed;
    bottom: -42px;
    left: 0; right: 0;
    background: #fff;
}

/* ━━━ PAGE COUNTER ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.pgn:after { content: counter(page); }

/* ━━━ CONTENT AREA ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.wrap { padding: 16px 20px 20px; }

/* ━━━ SECTION TABLE ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   Outer border wraps the entire table.
   th.sec spans full width inside — no overriding borders.
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.tbl {
    width: 100%;
    border-collapse: collapse;
    border: 1.5px solid #aecde0;
    margin-bottom: 14px;
}

/* Full-width navy section header — plain, no extra accents */
.sec {
    background: #032854;
    color: #fff;
    font-size: 9px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.3px;
    padding: 9px 14px;
    text-align: left;
    border: none;
}

/* Column sub-headers (used in Sale Details) */
.col {
    background: #d2e8f5;
    color: #032854;
    font-size: 9px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 7px 10px;
    text-align: left;
    border: 1px solid #aecde0;
}
.col-n {
    background: #bcd5ea;
    color: #032854;
    font-size: 9px;
    font-weight: 700;
    padding: 7px 6px;
    text-align: center;
    border: 1px solid #aecde0;
    width: 30px;
}

/* ━━━ INFO ROW CELLS  (Label / Sep / Value) ━━━━━━━━━━━━━
   Label + Sep share the same gray-blue background.
   Value is always white.
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.lbl {
    width: 130px;
    background: #edf3fb;
    color: #374151;
    font-size: 10px;
    font-weight: 700;
    padding: 8px 12px;
    vertical-align: top;
    white-space: nowrap;
    border: 1px solid #ccdde9;
}
.sep {
    width: 10px;
    background: #edf3fb;
    color: #94a3b8;
    font-size: 12px;
    padding: 8px 1px;
    text-align: center;
    vertical-align: top;
    border: 1px solid #ccdde9;
}
/* val = normal dark, valb = bold navy, valk = blue link */
.val  { padding: 8px 12px; background: #fff; color: #374151;  font-size: 11px; border: 1px solid #ccdde9; word-break: break-word; vertical-align: top; }
.valb { padding: 8px 12px; background: #fff; color: #032854;  font-size: 11px; font-weight: 700; border: 1px solid #ccdde9; word-break: break-word; vertical-align: top; }
.valk { padding: 8px 12px; background: #fff; color: #0e7fc0;  font-size: 11px; border: 1px solid #ccdde9; word-break: break-word; vertical-align: top; }

/* ━━━ LIST ROWS  (alternating white / light-blue) ━━━━━━━
   n/r  = white row   (even index)
   na/ra = light-blue row (odd index)
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
/* Number cells */
.n  { width: 30px; padding: 8px 5px; text-align: center; font-weight: 700; font-size: 11px; color: #032854; background: #d5eaf7; border: 1px solid #ccdde9; }
.na { width: 30px; padding: 8px 5px; text-align: center; font-weight: 700; font-size: 11px; color: #032854; background: #c1d8ee; border: 1px solid #ccdde9; }
/* Data cells */
.r  { padding: 8px 11px; background: #fff;    color: #374151; font-size: 11px; line-height: 1.55; border: 1px solid #ccdde9; }
.ra { padding: 8px 11px; background: #edf5fc; color: #374151; font-size: 11px; line-height: 1.55; border: 1px solid #ccdde9; }

</style>
</head>
<body>

{{-- ══════════════════════════════════════════════════════
     FIXED HEADER
     3-cell layout: [Logo] | [Title] | [SF No + Date]
     Dividers are border-left lines on title and meta cells.
══════════════════════════════════════════════════════ --}}
<div class="hdr">
    <table width="100%" style="border-collapse:collapse; background:#fff;" cellpadding="0" cellspacing="0">
        <tr>
            {{-- Logo area — 18px left pad, 16px right pad --}}
            <td style="padding:13px 16px 11px 18px; vertical-align:middle; white-space:nowrap;">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('image/logo.png'))) }}"
                     style="height:48px; width:auto; display:block;" alt="">
            </td>

            {{-- Title — left border acts as vertical divider, 16px left pad --}}
            <td style="padding:13px 0 11px 16px; vertical-align:middle; border-left:1px solid #dce8f2;">
                <div style="font-size:17px; font-weight:700; color:#032854; text-transform:uppercase; letter-spacing:2.5px; line-height:1.15;">Sale Format</div>
                <div style="font-size:8.5px; color:#64748b; text-transform:uppercase; letter-spacing:1.3px; margin-top:4px;">Enquiry &amp; Requirement Sheet</div>
            </td>

            {{-- SF No + Date — left border as divider, right pad 18px --}}
            <td style="width:140px; padding:11px 18px 11px 16px; vertical-align:middle; border-left:1px solid #dce8f2; text-align:right;">
                <div style="font-size:8px; color:#94a3b8; text-transform:uppercase; letter-spacing:0.8px; margin-bottom:3px;">SF No.</div>
                <div style="margin-bottom:6px;"><span style="background:#e8f2fc; border:1.5px solid #94c0db; padding:3px 10px; font-size:12px; font-weight:700; color:#032854;">SF-{{ str_pad($saleFormat->id, 4, '0', STR_PAD_LEFT) }}</span></div>
                <div style="font-size:8px; color:#94a3b8; text-transform:uppercase; letter-spacing:0.8px; margin-bottom:2px;">Date</div>
                <div style="font-size:11px; font-weight:700; color:#032854;">{{ $saleFormat->sale_date->format('d M Y') }}</div>
            </td>
        </tr>
    </table>
    {{-- Double rule: thick navy + thin cyan (reference design) --}}
    <div style="height:3px; background:#032854; font-size:0; line-height:0;"></div>
    <div style="height:2px; background:#29aae1; font-size:0; line-height:0;"></div>
</div>

{{-- ══════════════════════════════════════════════════════
     FIXED FOOTER
══════════════════════════════════════════════════════ --}}
<div class="ftr">
    <div style="height:3px; background:#032854; font-size:0; line-height:0;"></div>
    <div style="height:2px; background:#29aae1; font-size:0; line-height:0;"></div>
    <table width="100%" style="border-collapse:collapse; background:#fff;" cellpadding="0" cellspacing="0">
        <tr>
            <td style="padding:7px 20px; font-size:9px; color:#94a3b8; width:33%;">Confidential Document</td>
            <td style="padding:7px 10px; font-size:9px; color:#94a3b8; text-align:center; width:34%;">Page <span class="pgn"></span></td>
            <td style="padding:7px 20px; font-size:9px; color:#94a3b8; text-align:right; width:33%;">SF-{{ str_pad($saleFormat->id, 4, '0', STR_PAD_LEFT) }} &bull; {{ $saleFormat->sale_date->format('d M Y') }}</td>
        </tr>
    </table>
</div>

{{-- ══════════════════════════════════════════════════════
     PAGE CONTENT
══════════════════════════════════════════════════════ --}}
<div class="wrap">

    {{-- ─── CLIENT INFORMATION ────────────────────────── --}}
    @php
        $c        = $saleFormat->customer;
        $addr1    = $c?->address_line_1 ?? null;
        $addr2    = $c?->address_line_2 ?? null;
        $cityLine = implode(', ', array_filter([
            $c?->city ?? null, $c?->state ?? null, $c?->pincode ?? null
        ]));
        $country    = ($c?->country ?? null) && strtolower($c?->country ?? '') !== 'india'
                      ? ($c?->country ?? null) : null;
        $hasAddress = $addr1 || $addr2 || $cityLine || $country;
    @endphp
    <table class="tbl">
        <tr><th class="sec" colspan="3">Client Information</th></tr>
        <tr>
            <td class="lbl">Client Name</td>
            <td class="sep">:</td>
            <td class="valb">{{ $c?->company_name ?? '—' }}</td>
        </tr>
        @if($c?->gst ?? null)
        <tr>
            <td class="lbl">GST No.</td>
            <td class="sep">:</td>
            <td class="val">{{ $c?->gst }}</td>
        </tr>
        @endif
        @if($hasAddress)
        <tr>
            <td class="lbl">Address</td>
            <td class="sep">:</td>
            <td class="val" style="line-height:1.8;">
                @if($addr1){{ $addr1 }}@endif
                @if($addr2)<br>{{ $addr2 }}@endif
                @if($cityLine)<br>{{ $cityLine }}@endif
                @if($country)<br>{{ $country }}@endif
            </td>
        </tr>
        @endif
        @if($c?->company_website ?? null)
        <tr>
            <td class="lbl">Website</td>
            <td class="sep">:</td>
            <td class="valk">
                <a href="{{ $c?->company_website }}" style="color:#0e7fc0; text-decoration:underline;">{{ $c?->company_website }}</a>
            </td>
        </tr>
        @endif
    </table>

    {{-- ─── CONTACT PERSON ─────────────────────────────── --}}
    @php $cpList = $saleFormat->contact_persons ?? []; @endphp
    @if(!empty($cpList))
    <table class="tbl">
        <tr><th class="sec" colspan="3">Contact Person</th></tr>
        @foreach($cpList as $i => $cp)
            @if($i > 0)
            <tr><td colspan="3" style="padding:0; height:1px; background:#ccdde9; border:none;"></td></tr>
            @endif
            @if(!empty($cp['name']))
            <tr>
                <td class="lbl">{{ count($cpList) > 1 ? 'Contact ' . ($i + 1) : 'Name' }}</td>
                <td class="sep">:</td>
                <td class="valb">{{ $cp['name'] }}</td>
            </tr>
            @endif
            @if(!empty($cp['designation']))
            <tr>
                <td class="lbl">Designation</td>
                <td class="sep">:</td>
                <td class="val">{{ $cp['designation'] }}</td>
            </tr>
            @endif
            @php $phones = array_values(array_filter($cp['contact'] ?? [])); @endphp
            @if(!empty($phones))
            <tr>
                <td class="lbl">Contact No.</td>
                <td class="sep">:</td>
                <td class="val">{{ implode(' / ', $phones) }}</td>
            </tr>
            @endif
            @php $mails = array_values(array_filter($cp['email'] ?? [])); @endphp
            @if(!empty($mails))
            <tr>
                <td class="lbl">E-Mail ID</td>
                <td class="sep">:</td>
                <td class="valk">{{ implode(' / ', $mails) }}</td>
            </tr>
            @endif
            @php $docs = array_values(array_filter($cp['documents'] ?? [])); @endphp
            @if(!empty($docs))
            <tr>
                <td class="lbl">Attachments</td>
                <td class="sep">:</td>
                <td class="val">
                    @foreach($docs as $dp)
                        @php
                            $ext   = strtolower(pathinfo($dp, PATHINFO_EXTENSION));
                            $isImg = in_array($ext, ['jpg','jpeg','png','gif']);
                            $abs   = public_path($dp);
                            $b64   = ($isImg && file_exists($abs)) ? base64_encode(file_get_contents($abs)) : null;
                        @endphp
                        @if($b64)
                            <img src="data:image/{{ $ext === 'jpg' ? 'jpeg' : $ext }};base64,{{ $b64 }}"
                                 style="height:38px; max-width:58px; border:1px solid #ccdde9; margin-right:4px; vertical-align:middle;" alt="">
                        @else
                            <span style="color:#0e7fc0; font-size:10px;">{{ basename($dp) }}</span>@if(!$loop->last), @endif
                        @endif
                    @endforeach
                </td>
            </tr>
            @endif
        @endforeach
    </table>
    @endif

    {{-- ─── SALE DETAILS ───────────────────────────────── --}}
    @if(!empty($saleFormat->sale_details))
    <table class="tbl">
        <tr><th class="sec" colspan="4">Sale Details</th></tr>
        <tr>
            <td class="col-n" style="width:32px;">#</td>
            <td class="col" style="width:42%;">Application</td>
            <td class="col" style="width:28%;">Model</td>
            <td class="col">Output</td>
        </tr>
        @foreach($saleFormat->sale_details as $i => $d)
        @if($i % 2 === 0)
        <tr>
            <td class="n">{{ $i + 1 }}</td>
            <td class="r">{{ $d['application'] ?? '' }}</td>
            <td class="r">{{ $d['model'] ?? '' }}</td>
            <td class="r">{{ $d['output'] ?? '' }}</td>
        </tr>
        @else
        <tr>
            <td class="na">{{ $i + 1 }}</td>
            <td class="ra">{{ $d['application'] ?? '' }}</td>
            <td class="ra">{{ $d['model'] ?? '' }}</td>
            <td class="ra">{{ $d['output'] ?? '' }}</td>
        </tr>
        @endif
        @endforeach
    </table>
    @endif

    {{-- ─── REQUIREMENTS ───────────────────────────────── --}}
    @if($saleFormat->requirements->isNotEmpty())
    <table class="tbl">
        <tr><th class="sec" colspan="2">Requirements</th></tr>
        @foreach($saleFormat->requirements as $i => $req)
        @if($i % 2 === 0)
        <tr>
            <td class="n">{{ $req->sort_order }}.</td>
            <td class="r">{{ $req->requirement_description }}</td>
        </tr>
        @else
        <tr>
            <td class="na">{{ $req->sort_order }}.</td>
            <td class="ra">{{ $req->requirement_description }}</td>
        </tr>
        @endif
        @endforeach
    </table>
    @endif

    {{-- ─── REMARK ── flat table prevents DomPDF blank-page bug ── --}}
    @if($saleFormat->remark)
    @php
        $remarkStyles = [
            'p'  => 'margin:0 0 4px;padding:0;line-height:1.75;font-size:11px;color:#374151;',
            'ul' => 'list-style-type:disc;margin:2px 0 4px;padding-left:15px;',
            'ol' => 'list-style-type:decimal;margin:2px 0 4px;padding-left:15px;',
            'li' => 'margin:1px 0;line-height:1.75;font-size:11px;color:#374151;',
            'h1' => 'font-size:13px;font-weight:bold;margin:4px 0 2px;color:#374151;',
            'h2' => 'font-size:12px;font-weight:bold;margin:4px 0 2px;color:#374151;',
            'h3' => 'font-size:11px;font-weight:bold;margin:4px 0 2px;color:#374151;',
        ];
        $remark = preg_replace_callback(
            '/<(p|ul|ol|li|h[123])\b([^>]*)>/i',
            function ($m) use ($remarkStyles) {
                $tag = strtolower($m[1]);
                $att = $m[2];
                $add = $remarkStyles[$tag] ?? '';
                if (preg_match('/style="([^"]*)"/i', $att, $sm)) {
                    $att = preg_replace('/style="[^"]*"/i', "style=\"{$sm[1]};{$add}\"", $att);
                } else {
                    $att .= " style=\"{$add}\"";
                }
                return "<{$tag}{$att}>";
            },
            $saleFormat->remark
        );
    @endphp
    <table class="tbl">
        <tr><th class="sec">Remark</th></tr>
        <tr>
            <td style="padding:12px 14px 14px; background:#fff; border:1px solid #ccdde9; font-size:11px; color:#374151; line-height:1.75;">
                {!! $remark !!}
            </td>
        </tr>
    </table>
    @endif

    {{-- ─── SIGN-OFF ── two 48% boxes + 4% gap ─────────── --}}
    <table width="100%" style="border-collapse:collapse; border:none; page-break-inside:avoid;" cellpadding="0" cellspacing="0">
        <tr>

            {{-- PREPARED BY --}}
            <td style="width:48%; padding:0; vertical-align:bottom; border:none;">
                <table width="100%" style="border-collapse:collapse; border:1.5px solid #aecde0;">
                    <tr>
                        <th style="background:#032854; color:#fff; font-size:9px; font-weight:700; text-transform:uppercase; letter-spacing:1px; padding:9px 14px; text-align:left; border:none;">Prepared By</th>
                    </tr>
                    <tr>
                        <td style="padding:20px 18px 16px; background:#fff; border:none; text-align:center;">
                            <div style="border-bottom:1.5px dashed #9cb8cc; margin:0 14px 12px; height:28px;"></div>
                            <div style="font-size:11px; font-weight:700; color:#032854;">{{ $saleFormat->prepared_by ?? '' }}</div>
                            <div style="font-size:8.5px; color:#94a3b8; margin-top:3px; letter-spacing:0.3px;">Authorised Signatory</div>
                        </td>
                    </tr>
                </table>
            </td>

            <td style="width:4%; border:none;">&nbsp;</td>

            {{-- APPROVED BY --}}
            <td style="width:48%; padding:0; vertical-align:bottom; border:none;">
                <table width="100%" style="border-collapse:collapse; border:1.5px solid #aecde0;">
                    <tr>
                        <th style="background:#032854; color:#fff; font-size:9px; font-weight:700; text-transform:uppercase; letter-spacing:1px; padding:9px 14px; text-align:left; border:none;">Approved By</th>
                    </tr>
                    <tr>
                        <td style="padding:20px 18px 16px; background:#fff; border:none; text-align:center;">
                            <div style="border-bottom:1.5px dashed #9cb8cc; margin:0 14px 12px; height:28px;"></div>
                            <div style="font-size:11px; font-weight:700; color:#032854;">{{ $saleFormat->approved_by ?? '' }}</div>
                            <div style="font-size:8.5px; color:#94a3b8; margin-top:3px; letter-spacing:0.3px;">Authorised Signatory</div>
                        </td>
                    </tr>
                </table>
            </td>

        </tr>
    </table>

</div>{{-- /wrap --}}

</body>
</html>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<style>

/*
 * ═══════════════════════════════════════════════════════
 *  PAGE MARGIN MATH  (A4 = 841.89pt height)
 *
 *  Header actual height:
 *    top-pad(10) + logo(40) + bot-pad(10) + navy-rule(3) + cyan-rule(2) = 65px
 *    Add 6px buffer → top margin = 71px
 *    .hdr top = -(71 - 3) = -68px
 *
 *  Footer actual height:
 *    navy-rule(2) + cyan-rule(1) + pad(5+4) + text(8*1.2) ≈ 22px
 *    Add 6px buffer → bottom margin = 28px
 *    .ftr bottom = -(28 - 3) = -25px
 * ═══════════════════════════════════════════════════════
 */
@page {
    margin: 71px 20px 28px 20px;
}

@font-face {
    font-family: 'Poppins';
    font-weight: 400;
    src: url('{{ public_path("fonts/Poppins-Regular.ttf") }}') format('truetype');
}
@font-face {
    font-family: 'Poppins';
    font-weight: 700;
    src: url('{{ public_path("fonts/Poppins-Bold.ttf") }}') format('truetype');
}

body {
    margin: 0;
    padding: 0;
    font-family: 'Poppins', sans-serif;
    font-size: 10px;
    color: #1e293b;
    background: #ffffff;
}

/* ── Fixed header ───────────────────────────────────── */
#hdr {
    position: fixed;
    top: -68px;
    left: 0; right: 0;
    background: #ffffff;
}

/* ── Fixed footer ───────────────────────────────────── */
#ftr {
    position: fixed;
    bottom: -25px;
    left: 0; right: 0;
    background: #ffffff;
}

.pgn:after { content: counter(page); }

/* ── Wrap ───────────────────────────────────────────── */
#wrap { padding: 6px 0 12px 0; }

/* ═══════════════════════════════════════════════════════
   SECTION BLOCK
   Uses a wrapper <table> with outer border.
   IMPORTANT: DomPDF does NOT render background on <th>
   reliably when border-collapse is set on the parent.
   FIX: Use <td> instead of <th> for the navy header row,
   and set background via inline style directly on <td>.
   ═══════════════════════════════════════════════════════ */
.tbl {
    width: 100%;
    border-collapse: collapse;
    border: 1px solid #aecde0;
    margin-bottom: 8px;
}

/* ── Navy header row cell (td, not th) ──────────────── */
/* NOTE: We use <td> with inline bg — DomPDF renders     */
/* <th> background unreliably with border-collapse       */
.sec-td {
    background: #032854;
    color: #ffffff;
    font-family: 'Poppins', sans-serif;
    font-size: 8px;
    font-weight: 700;
    text-transform: uppercase;
    padding: 6px 12px;
    text-align: left;
    border: none;
}

/* ── Sale Details column sub-headers ───────────────── */
.col {
    background: #d2e8f5;
    color: #032854;
    font-family: 'Poppins', sans-serif;
    font-size: 8px;
    font-weight: 700;
    text-transform: uppercase;
    padding: 5px 10px;
    text-align: center;
    border: 1px solid #aecde0;
}
.col-n {
    background: #bcd5ea;
    color: #032854;
    font-family: 'Poppins', sans-serif;
    font-size: 8px;
    font-weight: 700;
    padding: 5px 4px;
    text-align: center;
    border: 1px solid #aecde0;
    width: 24px;
}

/* ── Label / Sep / Value ────────────────────────────── */
.lbl {
    width: 110px;
    background: #edf3fb;
    color: #374151;
    font-family: 'Poppins', sans-serif;
    font-size: 9px;
    font-weight: 700;
    padding: 6px 10px;
    vertical-align: top;
    white-space: nowrap;
    border: 1px solid #ccdde9;
}
.sep {
    width: 12px;
    background: #edf3fb;
    color: #64748b;
    font-family: 'Poppins', sans-serif;
    font-size: 10px;
    padding: 6px 0;
    text-align: center;
    vertical-align: top;
    border-top: 1px solid #ccdde9;
    border-bottom: 1px solid #ccdde9;
    border-left: none;
    border-right: none;
}
.val {
    padding: 6px 10px;
    background: #ffffff;
    color: #374151;
    font-family: 'Poppins', sans-serif;
    font-size: 10px;
    font-weight: 400;
    border: 1px solid #ccdde9;
    word-break: break-word;
    vertical-align: top;
}
.valb {
    padding: 6px 10px;
    background: #ffffff;
    color: #032854;
    font-family: 'Poppins', sans-serif;
    font-size: 10px;
    font-weight: 700;
    border: 1px solid #ccdde9;
    word-break: break-word;
    vertical-align: top;
}
.valk {
    padding: 6px 10px;
    background: #ffffff;
    color: #0e7fc0;
    font-family: 'Poppins', sans-serif;
    font-size: 10px;
    font-weight: 400;
    border: 1px solid #ccdde9;
    word-break: break-word;
    vertical-align: top;
}

/* ── Alternating list rows ──────────────────────────── */
.n  { width: 24px; padding: 6px 4px; text-align: center;
      font-family: 'Poppins', sans-serif; font-size: 10px; font-weight: 700;
      color: #032854; background: #d5eaf7; border: 1px solid #ccdde9; }
.na { width: 24px; padding: 6px 4px; text-align: center;
      font-family: 'Poppins', sans-serif; font-size: 10px; font-weight: 700;
      color: #032854; background: #c1d8ee; border: 1px solid #ccdde9; }
.r  { padding: 6px 10px; background: #ffffff;  color: #374151;
      font-family: 'Poppins', sans-serif; font-size: 10px; font-weight: 400;
      line-height: 1.5; border: 1px solid #ccdde9; }
.ra { padding: 6px 10px; background: #edf5fc; color: #374151;
      font-family: 'Poppins', sans-serif; font-size: 10px; font-weight: 400;
      line-height: 1.5; border: 1px solid #ccdde9; }

/* ── Contact divider ────────────────────────────────── */
.cp-divider {
    padding: 0;
    height: 1px;
    background: #ccdde9;
    border: none;
    font-size: 0;
    line-height: 0;
}

</style>
</head>
<body>

{{-- ════════════════════════════════════════════════
     FIXED HEADER
════════════════════════════════════════════════ --}}
<div id="hdr">
    <table width="100%" cellpadding="0" cellspacing="0"
           style="border-collapse:collapse; background:#ffffff; border-bottom:0;">
        <tr>
            {{-- Logo --}}
            <td style="width:72px; padding:10px 8px 10px 14px; vertical-align:middle;">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('image/logo.png'))) }}"
                     style="height:40px; width:auto; display:block;" alt="">
            </td>
            {{-- Title --}}
            <td style="padding:10px 0 10px 12px; vertical-align:middle;
                       border-left:1px solid #dce8f2;">
                <div style="font-family:'Poppins',sans-serif; font-size:16px;
                            font-weight:700; color:#032854; text-transform:uppercase;
                            line-height:1.1;">Sale Format</div>
                <div style="font-family:'Poppins',sans-serif; font-size:7px;
                            color:#64748b; text-transform:uppercase; margin-top:3px;">
                    Enquiry &amp; Requirement Sheet
                </div>
            </td>
            {{-- SF No + Date --}}
            <td style="width:124px; padding:8px 14px 8px 12px; vertical-align:middle;
                       border-left:1px solid #dce8f2; text-align:right;">
                <div style="font-family:'Poppins',sans-serif; font-size:7px;
                            color:#94a3b8; text-transform:uppercase; margin-bottom:2px;">
                    SF No.
                </div>
                <div style="margin-bottom:5px;">
                    <span style="font-family:'Poppins',sans-serif; background:#e8f2fc;
                                 border:1px solid #94c0db; padding:2px 8px;
                                 font-size:11px; font-weight:700; color:#032854;
                                 display:inline-block;">
                        SF-{{ str_pad($saleFormat->id, 4, '0', STR_PAD_LEFT) }}
                    </span>
                </div>
                <div style="font-family:'Poppins',sans-serif; font-size:7px;
                            color:#94a3b8; text-transform:uppercase; margin-bottom:2px;">
                    Date
                </div>
                <div style="font-family:'Poppins',sans-serif; font-size:10px;
                            font-weight:700; color:#032854;">
                    {{ $saleFormat->sale_date->format('d M Y') }}
                </div>
            </td>
        </tr>
    </table>
    <div style="height:3px; background:#032854; font-size:0; line-height:0;"></div>
    <div style="height:2px; background:#29aae1; font-size:0; line-height:0;"></div>
</div>

{{-- ════════════════════════════════════════════════
     FIXED FOOTER
════════════════════════════════════════════════ --}}
<div id="ftr">
    <div style="height:2px; background:#032854; font-size:0; line-height:0;"></div>
    <div style="height:1px; background:#29aae1; font-size:0; line-height:0;"></div>
    <table width="100%" cellpadding="0" cellspacing="0"
           style="border-collapse:collapse; background:#ffffff;">
        <tr>
            <td style="padding:5px 0 3px; font-family:'Poppins',sans-serif;
                       font-size:8px; color:#94a3b8; width:33%;">
                Confidential Document
            </td>
            <td style="padding:5px 0 3px; font-family:'Poppins',sans-serif;
                       font-size:8px; color:#94a3b8; text-align:center; width:34%;">
                Page <span class="pgn"></span>
            </td>
            <td style="padding:5px 0 3px; font-family:'Poppins',sans-serif;
                       font-size:8px; color:#94a3b8; text-align:right; width:33%;">
                SF-{{ str_pad($saleFormat->id, 4, '0', STR_PAD_LEFT) }}
                &bull;
                {{ $saleFormat->sale_date->format('d M Y') }}
            </td>
        </tr>
    </table>
</div>

{{-- ════════════════════════════════════════════════
     CONTENT
════════════════════════════════════════════════ --}}
<div id="wrap">

    {{-- ── CLIENT INFORMATION ─────────────────────────
         KEY FIX: <td> instead of <th> for navy header.
         DomPDF ignores background on <th> with
         border-collapse. <td class="sec-td"> works.
    ─────────────────────────────────────────────────── --}}
    @php
        $c        = $saleFormat->customer;
        $addr1    = $c?->address_line_1 ?? null;
        $addr2    = $c?->address_line_2 ?? null;
        $cityLine = implode(', ', array_filter([
            $c?->city    ?? null,
            $c?->state   ?? null,
            $c?->pincode ?? null,
        ]));
        $country    = ($c?->country ?? null) &&
                      strtolower($c?->country ?? '') !== 'india'
                      ? $c->country : null;
        $hasAddress = $addr1 || $addr2 || $cityLine || $country;
    @endphp

    <table class="tbl">
        <tr>
            <td class="sec-td" colspan="3">Client Information</td>
        </tr>
        <tr>
            <td class="lbl">Client Name</td>
            <td class="sep">:</td>
            <td class="valb">{{ $c?->company_name ?? '—' }}</td>
        </tr>
        @if(!empty($c?->gst))
        <tr>
            <td class="lbl">GST No.</td>
            <td class="sep">:</td>
            <td class="val">{{ $c->gst }}</td>
        </tr>
        @endif
        @if($hasAddress)
        <tr>
            <td class="lbl">Address</td>
            <td class="sep">:</td>
            <td class="val" style="line-height:1.7;">
                @if($addr1){{ $addr1 }}@endif
                @if($addr2)<br>{{ $addr2 }}@endif
                @if($cityLine)<br>{{ $cityLine }}@endif
                @if($country)<br>{{ $country }}@endif
            </td>
        </tr>
        @endif
        @if(!empty($c?->company_website))
        <tr>
            <td class="lbl">Website</td>
            <td class="sep">:</td>
            <td class="valk">{{ $c->company_website }}</td>
        </tr>
        @endif
    </table>

    {{-- ── CONTACT PERSON ─────────────────────────── --}}
    @php $cpList = $saleFormat->contact_persons ?? []; @endphp
    @if(!empty($cpList))
    <table class="tbl">
        <tr>
            <td class="sec-td" colspan="3">Contact Person</td>
        </tr>
        @foreach($cpList as $i => $cp)
            @if($i > 0)
            <tr>
                <td class="cp-divider" colspan="3"></td>
            </tr>
            @endif
            @if(!empty($cp['name']))
            <tr>
                <td class="lbl">{{ count($cpList) > 1 ? 'Contact '.($i+1) : 'Name' }}</td>
                <td class="sep">:</td>
                <td class="valb">{{ $cp['name'] }}</td>
            </tr>
            @endif
            @if(!empty($cp['designation']))
            <tr>
                <td class="lbl">Designation</td>
                <td class="sep">:</td>
                <td class="val">{{ $cp['designation'] }}</td>
            </tr>
            @endif
            @php $phones = array_values(array_filter($cp['contact'] ?? [])); @endphp
            @if(!empty($phones))
            <tr>
                <td class="lbl">Contact No.</td>
                <td class="sep">:</td>
                <td class="val">{{ implode(' / ', $phones) }}</td>
            </tr>
            @endif
            @php $mails = array_values(array_filter($cp['email'] ?? [])); @endphp
            @if(!empty($mails))
            <tr>
                <td class="lbl">E-Mail ID</td>
                <td class="sep">:</td>
                <td class="valk">{{ implode(' / ', $mails) }}</td>
            </tr>
            @endif
            @php $docs = array_values(array_filter($cp['documents'] ?? [])); @endphp
            @if(!empty($docs))
            <tr>
                <td class="lbl">Attachments</td>
                <td class="sep">:</td>
                <td class="val">
                    @foreach($docs as $dp)
                        @php
                            $ext   = strtolower(pathinfo($dp, PATHINFO_EXTENSION));
                            $isImg = in_array($ext, ['jpg','jpeg','png','gif']);
                            $abs   = public_path($dp);
                            $b64   = ($isImg && file_exists($abs))
                                     ? base64_encode(file_get_contents($abs)) : null;
                        @endphp
                        @if($b64)
                            <img src="data:image/{{ $ext==='jpg'?'jpeg':$ext }};base64,{{ $b64 }}"
                                 style="height:34px; max-width:52px;
                                        border:1px solid #ccdde9;
                                        margin-right:4px; vertical-align:middle;" alt="">
                        @else
                            <span style="font-family:'Poppins',sans-serif;
                                         color:#64748b; font-size:9px;">
                                {{ basename($dp) }}
                            </span>@if(!$loop->last), @endif
                        @endif
                    @endforeach
                </td>
            </tr>
            @endif
        @endforeach
    </table>
    @endif

    {{-- ── SALE DETAILS ───────────────────────────── --}}
    @if(!empty($saleFormat->sale_details))
    <table class="tbl">
        <tr>
            <td class="sec-td" colspan="4">Sale Details</td>
        </tr>
        <tr>
            <td class="col-n">#</td>
            <td class="col" style="width:42%; text-align:left;">Application</td>
            <td class="col" style="width:28%; text-align:left;">Model</td>
            <td class="col" style="text-align:left;">Output</td>
        </tr>
        @foreach($saleFormat->sale_details as $i => $d)
        @if($i % 2 === 0)
        <tr>
            <td class="n">{{ $i + 1 }}</td>
            <td class="r">{{ $d['application'] ?? '' }}</td>
            <td class="r">{{ $d['model']       ?? '' }}</td>
            <td class="r">{{ $d['output']      ?? '' }}</td>
        </tr>
        @else
        <tr>
            <td class="na">{{ $i + 1 }}</td>
            <td class="ra">{{ $d['application'] ?? '' }}</td>
            <td class="ra">{{ $d['model']       ?? '' }}</td>
            <td class="ra">{{ $d['output']      ?? '' }}</td>
        </tr>
        @endif
        @endforeach
    </table>
    @endif

    {{-- ── REQUIREMENTS ───────────────────────────── --}}
    @if($saleFormat->requirements->isNotEmpty())
    <table class="tbl">
        <tr>
            <td class="sec-td" colspan="2">Requirements</td>
        </tr>
        @foreach($saleFormat->requirements as $i => $req)
        @if($i % 2 === 0)
        <tr>
            <td class="n">{{ $req->sort_order }}.</td>
            <td class="r">{{ $req->requirement_description }}</td>
        </tr>
        @else
        <tr>
            <td class="na">{{ $req->sort_order }}.</td>
            <td class="ra">{{ $req->requirement_description }}</td>
        </tr>
        @endif
        @endforeach
    </table>
    @endif

    {{-- ── REMARK ─────────────────────────────────── --}}
    @if($saleFormat->remark)
    @php
        $rmStyles = [
            'p'  => 'margin:0 0 4px;padding:0;line-height:1.6;font-size:10px;color:#374151;font-family:Poppins,sans-serif;font-weight:400;',
            'ul' => 'margin:2px 0 4px;padding-left:16px;list-style-type:disc;',
            'ol' => 'margin:2px 0 4px;padding-left:16px;list-style-type:decimal;',
            'li' => 'margin:1px 0;line-height:1.6;font-size:10px;color:#374151;font-family:Poppins,sans-serif;font-weight:400;',
            'h1' => 'font-size:12px;font-weight:700;margin:4px 0 2px;color:#374151;font-family:Poppins,sans-serif;',
            'h2' => 'font-size:11px;font-weight:700;margin:4px 0 2px;color:#374151;font-family:Poppins,sans-serif;',
            'h3' => 'font-size:10px;font-weight:700;margin:4px 0 2px;color:#374151;font-family:Poppins,sans-serif;',
        ];
        $remark = preg_replace_callback(
            '/<(p|ul|ol|li|h[123])\b([^>]*)>/i',
            function($m) use ($rmStyles) {
                $tag = strtolower($m[1]);
                $att = $m[2];
                $add = $rmStyles[$tag] ?? '';
                if (preg_match('/style="([^"]*)"/i', $att, $sm)) {
                    $att = preg_replace('/style="[^"]*"/i',
                           'style="'.$sm[1].';'.$add.'"', $att);
                } else {
                    $att .= ' style="'.$add.'"';
                }
                return "<{$tag}{$att}>";
            },
            $saleFormat->remark
        );
    @endphp
    <table class="tbl">
        <tr>
            <td class="sec-td">Remark</td>
        </tr>
        <tr>
            <td style="padding:10px 12px 12px; background:#ffffff;
                       border:1px solid #ccdde9;
                       font-family:'Poppins',sans-serif;
                       font-size:10px; font-weight:400;
                       color:#374151; line-height:1.6;">
                {!! $remark !!}
            </td>
        </tr>
    </table>
    @endif

    {{-- ── SIGN-OFF ────────────────────────────────── --}}
    <table width="100%" cellpadding="0" cellspacing="0"
           style="border-collapse:collapse; border:none;
                  page-break-inside:avoid; margin-top:4px;">
        <tr>

            {{-- Prepared By --}}
            <td style="width:48%; padding:0; vertical-align:bottom; border:none;">
                <table width="100%"
                       style="border-collapse:collapse; border:1px solid #aecde0;">
                    <tr>
                        <td style="background:#032854; color:#ffffff;
                                   font-family:'Poppins',sans-serif;
                                   font-size:8px; font-weight:700;
                                   text-transform:uppercase;
                                   padding:6px 12px; border:none;">
                            Prepared By
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:16px 16px 12px; background:#ffffff;
                                   border:none; text-align:center;">
                            <div style="border-bottom:1px dashed #9cb8cc;
                                        margin:0 12px 8px; height:24px;
                                        font-size:0; line-height:0;"></div>
                            <div style="font-family:'Poppins',sans-serif;
                                        font-size:10px; font-weight:700;
                                        color:#032854;">
                                {{ $saleFormat->prepared_by ?? '' }}
                            </div>
                            <div style="font-family:'Poppins',sans-serif;
                                        font-size:8px; font-weight:400;
                                        color:#94a3b8; margin-top:2px;">
                                Authorised Signatory
                            </div>
                        </td>
                    </tr>
                </table>
            </td>

            <td style="width:4%; border:none;">&nbsp;</td>

            {{-- Approved By --}}
            <td style="width:48%; padding:0; vertical-align:bottom; border:none;">
                <table width="100%"
                       style="border-collapse:collapse; border:1px solid #aecde0;">
                    <tr>
                        <td style="background:#032854; color:#ffffff;
                                   font-family:'Poppins',sans-serif;
                                   font-size:8px; font-weight:700;
                                   text-transform:uppercase;
                                   padding:6px 12px; border:none;">
                            Approved By
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:16px 16px 12px; background:#ffffff;
                                   border:none; text-align:center;">
                            <div style="border-bottom:1px dashed #9cb8cc;
                                        margin:0 12px 8px; height:24px;
                                        font-size:0; line-height:0;"></div>
                            <div style="font-family:'Poppins',sans-serif;
                                        font-size:10px; font-weight:700;
                                        color:#032854;">
                                {{ $saleFormat->approved_by ?? '' }}
                            </div>
                            <div style="font-family:'Poppins',sans-serif;
                                        font-size:8px; font-weight:400;
                                        color:#94a3b8; margin-top:2px;">
                                Authorised Signatory
                            </div>
                        </td>
                    </tr>
                </table>
            </td>

        </tr>
    </table>

</div>{{-- #wrap --}}
</body>
</html>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <style>
        /* ========================================================= PAGE SETTINGS ========================================================= */
        @page {
            margin: 76px 18px 30px 18px;
        }

        @font-face {
            font-family: "Montserrat";
            font-weight: 400;
            src: url("{{ public_path('fonts/Montserrat-Regular.ttf') }}") format("truetype");
        }

        @font-face {
            font-family: "Montserrat";
            font-weight: 700;
            src: url("{{ public_path('fonts/Montserrat-Bold.ttf') }}") format("truetype");
        }

        body {
            margin: 0;
            padding: 0;
            font-family: "Montserrat", sans-serif;
            font-size: 10px;
            color: #1f2937;
            background: #ffffff;
        }

        /* ========================================================= FIXED HEADER ========================================================= */
        #header {
            position: fixed;
            top: -73px;
            left: 0;
            right: 0;
            background: #fff;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .logo-cell {
            width: 64px;
            padding: 10px 8px 10px 12px;
            vertical-align: middle;
        }

        .title-cell {
            padding: 10px 0 10px 12px;
            border-left: 1px solid #d7e3ef;
            vertical-align: middle;
        }

        .doc-title {
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #032854;
            line-height: 1.1;
        }

        .doc-sub {
            margin-top: 3px;
            font-size: 7px;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #7d8da1;
        }

        .meta-cell {
            width: 120px;
            padding: 8px 12px 8px 10px;
            border-left: 1px solid #d7e3ef;
            vertical-align: middle;
            text-align: right;
        }

        .meta-label {
            font-size: 7px;
            text-transform: uppercase;
            color: #94a3b8;
            line-height: 1.2;
        }

        .meta-pill {
            display: inline-block;
            margin: 3px 0 5px;
            padding: 2px 8px;
            background: #e8f2fc;
            border: 1px solid #94c0db;
            color: #032854;
            font-size: 11px;
            font-weight: 700;
        }

        .meta-date {
            font-size: 10px;
            font-weight: 700;
            color: #032854;
        }

        .header-rule-1 {
            height: 3px;
            background: #032854;
            font-size: 0;
            line-height: 0;
        }

        .header-rule-2 {
            height: 2px;
            background: #29aae1;
            font-size: 0;
            line-height: 0;
        }

        /* ========================================================= FIXED FOOTER ========================================================= */
        #footer {
            position: fixed;
            bottom: -27px;
            left: 0;
            right: 0;
            background: #fff;
        }

        .footer-rule-1 {
            height: 2px;
            background: #032854;
            font-size: 0;
            line-height: 0;
        }

        .footer-rule-2 {
            height: 1px;
            background: #29aae1;
            font-size: 0;
            line-height: 0;
        }

        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer-cell {
            padding: 5px 0 3px;
            font-size: 8px;
            color: #94a3b8;
        }

        .footer-center {
            text-align: center;
        }

        .footer-right {
            text-align: right;
        }

        .page-number:after {
            content: counter(page);
        }

        /* ========================================================= CONTENT WRAP ========================================================= */
        #wrapper {
            padding: 6px 0 12px 0;
        }

        /* ========================================================= SECTION TABLES ========================================================= */
        .section {
            width: 100%;
            border-collapse: collapse;
            border: 0.6px solid #d8e5ef;
            margin-bottom: 9px;
        }

        .section-title {
            background: #032854;
            color: #fff;
            font-size: 7px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 5px 10px;
        }

        /* ========================================================= KEY/VALUE TABLE ========================================================= */
        .lbl {
            width: 115px;
            padding: 6px 10px;
            background: #f4f7fb;
            border: 0.6px solid #d8e5ef;
            font-size: 9px;
            font-weight: 700;
            color: #374151;
            white-space: nowrap;
            vertical-align: top;
        }

        .sep {
            width: 10px;
            padding: 6px 0;
            background: #f4f7fb;
            border-top: 0.6px solid #d8e5ef;
            border-bottom: 0.6px solid #d8e5ef;
            text-align: center;
            color: #64748b;
            vertical-align: top;
        }

        .val {
            padding: 6px 10px;
            border: 0.6px solid #d8e5ef;
            background: #fff;
            font-size: 10px;
            color: #374151;
            vertical-align: top;
        }

        .val-strong {
            font-weight: 700;
            color: #032854;
        }

        .val-link {
            color: #0e7fc0;
        }

        /* ========================================================= SALE DETAILS TABLE ========================================================= */
        .sales-head {
            background: #d8e8f5;
            color: #032854;
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
            border: 0.6px solid #d8e5ef;
            padding: 5px 10px;
        }

        .sales-head-num {
            width: 28px;
            text-align: center;
            background: #c9deef;
            color: #032854;
            font-size: 8px;
            font-weight: 700;
            border: 0.6px solid #d8e5ef;
            padding: 5px 4px;
        }

        .row-num {
            width: 28px;
            text-align: center;
            font-weight: 700;
            color: #032854;
            border: 0.6px solid #d8e5ef;
            padding: 8px 4px;
        }

        .row-num-a {
            background: #e6f1fb;
        }

        .row-num-b {
            background: #d8e8f5;
        }

        .row-cell {
            border: 0.6px solid #d8e5ef;
            padding: 8px 10px;
            font-size: 10px;
            color: #374151;
        }

        .row-a {
            background: #ffffff;
        }

        .row-b {
            background: #f6fbff;
        }

        /* ========================================================= REQUIREMENTS ========================================================= */
        .req-no {
            width: 28px;
            text-align: center;
            font-weight: 700;
            color: #032854;
            border: 0.6px solid #d8e5ef;
            padding: 8px 4px;
        }

        .req-no-a {
            background: #e6f1fb;
        }

        .req-no-b {
            background: #d8e8f5;
        }

        .req-text {
            border: 0.6px solid #d8e5ef;
            padding: 8px 10px;
            line-height: 1.6;
            font-size: 10px;
            color: #374151;
        }

        .req-text-a {
            background: #ffffff;
        }

        .req-text-b {
            background: #f6fbff;
        }

        /* ========================================================= REMARK ========================================================= */
        .remark-box {
            border: 0.6px solid #d8e5ef;
            padding: 10px 12px;
            line-height: 1.6;
            font-size: 10px;
            color: #374151;
        }

        /* ========================================================= SIGNATURES ========================================================= */
        .sign-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4px;
            page-break-inside: avoid;
        }

        .sign-box {
            width: 48%;
            border: 0.6px solid #d8e5ef;
            vertical-align: bottom;
        }

        .sign-gap {
            width: 4%;
        }

        .sign-title {
            background: #032854;
            color: #fff;
            font-size: 7px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 5px 10px;
        }

        .sign-body {
            height: 86px;
            text-align: center;
            vertical-align: bottom;
            padding: 10px 10px 8px;
        }

        .sign-line {
            border-bottom: 1px dashed #9eb8cd;
            margin: 0 12px 8px;
            height: 28px;
            font-size: 0;
            line-height: 0;
        }

        .sign-name {
            font-size: 10px;
            font-weight: 700;
            color: #032854;
        }

        .sign-role {
            margin-top: 2px;
            font-size: 8px;
            color: #94a3b8;
        }
        .page-break{
           page-break-after:always;
     }
     .section{
    page-break-inside:auto;
}
tr{
    page-break-inside:avoid;
}
table{
    page-break-inside:auto;
}
.sep{
    width:16px;
    text-align:center;
    vertical-align:middle;
    font-weight:700;
    color:#64748b;
    padding:5px 0;
}
.first-section{
    margin-top:6px;
}
@page{
    margin-top:95px;
    margin-right:18px;
    margin-bottom:40px;
    margin-left:18px;
}

#header{
    top:-92px;
}

#footer{
    bottom:-32px;
}

#wrapper{
    padding-top:8px;
}

.section{
    margin-bottom:10px;
    page-break-inside:auto;
}

tr{
    page-break-inside:avoid;
}

.sep{
    width:16px;
    text-align:center;
    vertical-align:middle;
    font-weight:700;
}
body{
    font-family:Helvetica;
}
    </style>
</head>

<body>
    <!-- ====================================================== HEADER ====================================================== -->
    <div id="header">
        <table class="header-table">
            <tr>
             <td style="width:48px;padding:10px 8px 10px 10px;vertical-align:left;"> <img
                        src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('image/logo.png'))) }}"
                        style="height:42px;width:auto;display:block;" alt=""> </td>
                <td class="title-cell" colspan="2">
                    <div class="doc-title">Sale Format</div>
                    <div class="doc-sub">Enquiry & Requirement Sheet</div>
                </td>
                <td class="meta-cell">
                    <div class="meta-label">SF No.</div>
                    <div class="meta-pill">SF-{{ str_pad($saleFormat->id, 4, '0', STR_PAD_LEFT) }}</div>
                    <div class="meta-label">Date</div>
                    <div class="meta-date">{{ $saleFormat->sale_date->format('d M Y') }}</div>
                </td>
            </tr>
        </table>
        <div class="header-rule-1"></div>
        <div class="header-rule-2"></div>
    </div>
    <!-- ====================================================== FOOTER ====================================================== -->
    <div id="footer">
        <div class="footer-rule-1"></div>
        <div class="footer-rule-2"></div>
        <table class="footer-table">
            <tr>
                <td class="footer-cell">Confidential Document</td>
                <td class="footer-cell footer-center">Page <span class="page-number"></span></td>
                <td class="footer-cell footer-right"> SF-{{ str_pad($saleFormat->id, 4, '0', STR_PAD_LEFT) }}
                    &nbsp;•&nbsp; {{ $saleFormat->sale_date->format('d M Y') }} </td>
            </tr>
        </table>
    </div>
    <!-- ====================================================== CONTENT ====================================================== -->
    <div id="wrapper">
        @php $c = $saleFormat->customer;
            $addr1 = $c?->address_line_1 ?? null;
            $addr2 = $c?->address_line_2 ?? null;
            $cityLine = implode(", ", array_filter([$c?->city ?? null, $c?->state ?? null, $c?->pincode ?? null,]));
            $country = ($c?->country ?? null) && strtolower($c?->country ?? "") !== "india" ? $c->country : null;
        $hasAddress = $addr1 || $addr2 || $cityLine || $country; @endphp
        <!-- CLIENT INFORMATION -->
        <table class="section first-section">
            <tr>
               <td colspan="3"
style="
background:#032854;
color:#fff;
padding:7px 10px;
font-size:7px;
font-weight:700;
letter-spacing:2px;
text-transform:uppercase;
">
Client Information
</td>
            </tr>
            <tr>
                <td class="lbl">Client Name</td>
                <td class="sep">:</td>
                <td class="val val-strong">{{ $c?->company_name ?? "—" }}</td>
            </tr> @if(!empty($c?->gst))
                <tr>
                    <td class="lbl">GST No.</td>
                    <td class="sep">:</td>
                    <td class="val">{{ $c->gst }}</td>
            </tr> @endif @if($hasAddress)
                <tr>
                    <td class="lbl">Address</td>
                    <td class="sep">:</td>
                    <td class="val" style="line-height:1.7;"> @if($addr1){{ $addr1 }}@endif
                        @if($addr2)<br>{{ $addr2 }}@endif @if($cityLine)<br>{{ $cityLine }}@endif
                        @if($country)<br>{{ $country }}@endif </td>
            </tr> @endif @if(!empty($c?->company_website))
                <tr>
                    <td class="lbl">Website</td>
                    <td class="sep">:</td>
                    <td class="val val-link">{{ $c->company_website }}</td>
            </tr> @endif
        </table> <!-- CONTACT PERSON --> @php $cpList = $saleFormat->contact_persons ?? []; @endphp @if(!empty($cpList))
            <table class="section">
                <tr>
                    <td class="section-title" colspan="3">Contact Person</td>
                </tr> @foreach($cpList as $i => $cp) @if($i > 0)
                        <tr>
                            <td colspan="3" style="height:1px;background:#d8e5ef;font-size:0;line-height:0;"></td>
                    </tr> @endif @if(!empty($cp["name"]))
                        <tr>
                            <td class="lbl">{{ count($cpList) > 1 ? "Contact " . ($i + 1) : "Name" }}</td>
                            <td class="sep">:</td>
                            <td class="val val-strong">{{ $cp["name"] }}</td>
                    </tr> @endif @if(!empty($cp["designation"]))
                        <tr>
                            <td class="lbl">Designation</td>
                            <td class="sep">:</td>
                            <td class="val">{{ $cp["designation"] }}</td>
                    </tr> @endif @php $phones = array_values(array_filter($cp["contact"] ?? [])); @endphp @if(!empty($phones))
                        <tr>
                            <td class="lbl">Contact No.</td>
                            <td class="sep">:</td>
                            <td class="val">{{ implode(" / ", $phones) }}</td>
                    </tr> @endif @php $mails = array_values(array_filter($cp["email"] ?? [])); @endphp @if(!empty($mails))
                        <tr>
                            <td class="lbl">E-Mail ID</td>
                            <td class="sep">:</td>
                            <td class="val val-link">{{ implode(" / ", $mails) }}</td>
                </tr> @endif @endforeach
        </table> @endif <!-- SALE DETAILS --> @if(!empty($saleFormat->sale_details))
            <table class="section">
                <tr>
                    <td class="section-title" colspan="4">Sale Details</td>
                </tr>
                <tr>
                    <td class="sales-head-num">#</td>
                    <td class="sales-head" style="width:42%;text-align:left;">Application</td>
                    <td class="sales-head" style="width:28%;text-align:left;">Model</td>
                    <td class="sales-head" style="text-align:left;">Output</td>
                </tr> @foreach($saleFormat->sale_details as $i => $d) <tr>
                    <td class="row-num {{ $i % 2 === 0 ? 'row-num-a' : 'row-num-b' }}">{{ $i + 1 }}</td>
                    <td class="row-cell {{ $i % 2 === 0 ? 'row-a' : 'row-b' }}">{{ $d["application"] ?? "" }}</td>
                    <td class="row-cell {{ $i % 2 === 0 ? 'row-a' : 'row-b' }}">{{ $d["model"] ?? "" }}</td>
                    <td class="row-cell {{ $i % 2 === 0 ? 'row-a' : 'row-b' }}">{{ $d["output"] ?? "" }}</td>
                </tr> @endforeach
        </table> @endif <!-- REQUIREMENTS --> @if($saleFormat->requirements->isNotEmpty())
            <table class="section">
                <tr>
                    <td class="section-title" colspan="2">Requirements</td>
                </tr> @foreach($saleFormat->requirements as $i => $req) <tr>
                    <td class="req-no {{ $i % 2 === 0 ? 'req-no-a' : 'req-no-b' }}">{{ $req->sort_order }}</td>
                    <td class="req-text {{ $i % 2 === 0 ? 'req-text-a' : 'req-text-b' }}">
                        {{ $req->requirement_description }} </td>
                </tr> @endforeach
        </table> @endif <!-- REMARK --> @if($saleFormat->remark)
            <table class="section">
                <tr>
                    <td class="section-title">Remark</td>
                </tr>
                <tr>
                    <td class="remark-box">{!! $saleFormat->remark !!}</td>
                </tr>
        </table> @endif <!-- SIGNATURES -->
        <table class="sign-table">
            <tr>
                <td class="sign-box">
                    <div class="sign-title">Prepared By</div>
                    <div class="sign-body">
                        <div class="sign-line"></div>
                        <div class="sign-name">{{ $saleFormat->prepared_by ?? "" }}</div>
                        <div class="sign-role">Authorised Signatory</div>
                    </div>
                </td>
                <td class="sign-gap"></td>
                <td class="sign-box">
                    <div class="sign-title">Approved By</div>
                    <div class="sign-body">
                        <div class="sign-line"></div>
                        <div class="sign-name">{{ $saleFormat->approved_by ?? "" }}</div>
                        <div class="sign-role">Authorised Signatory</div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>