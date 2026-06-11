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
        .remark-wrap {
            width: 100%;
            border: 0.6px solid #d8e5ef;
            margin-bottom: 10px;
            page-break-inside: auto;
        }

        .remark-wrap .section-title {
            display: block;
        }

        .remark-box {
            display: block;
            border-top: 0.6px solid #d8e5ef;
            padding: 10px 12px;
            line-height: 1.6;
            font-size: 10px;
            color: #374151;
            page-break-inside: auto;
        }

        /* rich text content inside remark */
        .remark-box p {
            margin: 0 0 6px 0;
            padding: 0;
            page-break-inside: auto;
        }

        .remark-box ul {
            margin: 0 0 6px 0;
            padding-left: 18px;
            list-style-type: disc;
            page-break-inside: auto;
        }

        .remark-box ul li {
            margin: 0 0 3px 0;
            padding: 0;
            page-break-inside: auto;
        }

        /* manually numbered ol replacement for dompdf */
        .remark-ol {
            margin: 0 0 6px 0;
            padding: 0;
        }

        .remark-ol-item {
            display: table;
            width: 100%;
            margin: 0 0 3px 0;
            page-break-inside: auto;
        }

        .remark-ol-num {
            display: table-cell;
            width: 22px;
            font-weight: 700;
            color: #032854;
            white-space: nowrap;
            vertical-align: top;
        }

        .remark-ol-text {
            display: table-cell;
            vertical-align: top;
        }

        .remark-box strong, .remark-box b {
            font-weight: 700;
        }

        .remark-box em, .remark-box i {
            font-style: italic;
        }

        .remark-box u {
            text-decoration: underline;
        }

        .remark-box h1, .remark-box h2, .remark-box h3,
        .remark-box h4, .remark-box h5, .remark-box h6 {
            margin: 6px 0 4px 0;
            font-weight: 700;
            color: #032854;
            line-height: 1.3;
        }

        .remark-box h1 { font-size: 14px; }
        .remark-box h2 { font-size: 13px; }
        .remark-box h3 { font-size: 12px; }
        .remark-box h4 { font-size: 11px; }
        .remark-box h5, .remark-box h6 { font-size: 10px; }

        .remark-box a {
            color: #0e7fc0;
        }

        .remark-box blockquote {
            margin: 4px 0 4px 12px;
            padding-left: 8px;
            border-left: 3px solid #d8e5ef;
            color: #64748b;
        }

        .remark-box table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 6px;
            font-size: 10px;
        }

        .remark-box table td,
        .remark-box table th {
            border: 0.6px solid #d8e5ef;
            padding: 4px 8px;
        }

        .remark-box table th {
            background: #f4f7fb;
            font-weight: 700;
        }

        .remark-box br {
            line-height: 1.6;
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
                </tr> @endif @php $cpDocs = array_values(array_filter($cp["documents"] ?? [])); @endphp @if(!empty($cpDocs))
                        <tr>
                            <td class="lbl">Documents</td>
                            <td class="sep">:</td>
                            <td class="val" style="line-height:2;">
                                @foreach($cpDocs as $doc)
                                    <a href="{{ url($doc) }}" style="color:#0e7fc0;text-decoration:none;display:block;">{{ basename($doc) }}</a>
                                @endforeach
                            </td>
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
        @php
            // DOMDocument approach: properly handles nested lists and maintains
            // a single counter across all <ol> tags (editor splits list into multiple <ol>)
            $olCounter  = 0;
            $remarkHtml = $saleFormat->remark;

            if (!empty(trim($remarkHtml))) {
                libxml_use_internal_errors(true);
                $dom = new \DOMDocument();
                $dom->loadHTML(
                    '<!DOCTYPE html><html><head><meta charset="utf-8"/></head><body><div id="rr">'
                    . $remarkHtml
                    . '</div></body></html>'
                );
                libxml_clear_errors();

                // Snapshot NodeList before modifying DOM
                $olNodes = iterator_to_array($dom->getElementsByTagName('ol'), false);

                foreach ($olNodes as $ol) {
                    $divWrap = $dom->createElement('div');
                    $divWrap->setAttribute('class', 'remark-ol');

                    // Only direct <li> children (skip nested <ul>/<ol> items)
                    $lis = [];
                    foreach ($ol->childNodes as $node) {
                        if ($node->nodeType === XML_ELEMENT_NODE && $node->nodeName === 'li') {
                            $lis[] = $node;
                        }
                    }

                    foreach ($lis as $li) {
                        $olCounter++;

                        $divItem = $dom->createElement('div');
                        $divItem->setAttribute('class', 'remark-ol-item');

                        $spanNum = $dom->createElement('span');
                        $spanNum->setAttribute('class', 'remark-ol-num');
                        $spanNum->appendChild($dom->createTextNode($olCounter . '.'));

                        $spanText = $dom->createElement('span');
                        $spanText->setAttribute('class', 'remark-ol-text');
                        // Move all children (preserves nested <ul>, bold, etc.)
                        while ($li->firstChild) {
                            $spanText->appendChild($li->firstChild);
                        }

                        $divItem->appendChild($spanNum);
                        $divItem->appendChild($spanText);
                        $divWrap->appendChild($divItem);
                    }

                    $ol->parentNode->replaceChild($divWrap, $ol);
                }

                $container = $dom->getElementById('rr');
                if ($container) {
                    $remarkHtml = '';
                    foreach ($container->childNodes as $child) {
                        $remarkHtml .= $dom->saveHTML($child);
                    }
                }
            }
        @endphp
            <div class="remark-wrap">
                <div class="section-title">Remark</div>
                <div class="remark-box">{!! $remarkHtml !!}</div>
            </div>
        @endif
        @php $remarkDocs = array_values(array_filter($saleFormat->upload_file_path ?? [])); @endphp
        @if(!empty($remarkDocs))
            <table class="section">
                <tr>
                    <td class="section-title" colspan="3">Remark Attachments</td>
                </tr>
                @foreach($remarkDocs as $j => $doc)
                <tr>
                    <td class="lbl">File {{ $j + 1 }}</td>
                    <td class="sep">:</td>
                    <td class="val">
                        <a href="{{ url($doc) }}" style="color:#0e7fc0;text-decoration:none;">{{ basename($doc) }}</a>
                    </td>
                </tr>
                @endforeach
            </table>
        @endif <!-- SIGNATURES -->
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