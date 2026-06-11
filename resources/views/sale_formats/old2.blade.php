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