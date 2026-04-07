<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<title>Order Acceptance Letter</title>

<style>

@page {
    margin: 130px 40px 70px 40px;
}

body{
    font-family: DejaVu Sans, sans-serif;
    font-size:12px;
}

/* Header */

header{
    position: fixed;
    top:-110px;
    left:0;
    right:0;
    text-align:right;
}

header img{
    height:80px;
}

/* Footer */

footer{
    position: fixed;
    bottom:-50px;
    left:0;
    right:0;
    text-align:center;
    font-size:11px;
}

.page-number:before{
    content:"Page " counter(page);
}

/* Heading */

.heading{
    text-align:center;
    font-weight:bold;
    margin-bottom:20px;
}

/* Table */

table{
    width:100%;
    border-collapse:collapse;
}

th,td{
    border:1px solid black;
    padding:10px;
}

th{
    background:#f2f2f2;
    width:30%;
}

td{
    width:70%;
}

/* Prevent row break */

tr{
    page-break-inside: avoid;
}

/* Footer Sign */

.signature{
    margin-top:40px;
}

.signature table{
    border:none;
}

.signature td{
    border:none;
    text-align:center;
}

</style>

</head>

<body>

<header>
    <img src="{{ public_path('./image/mr_logo.png') }}">
</header>

<footer>
    <span class="page-number"></span>
</footer>


<div class="container">

<div class="heading">
<h2>Order Acceptance Letters</h2>
</div>


@php
function printValue($value){
    if($value == '0'){
        return 'Yes';
    }elseif($value == '1'){
        return 'No';
    }else{
        return $value;
    }
}
@endphp


<table>

<tbody>

@php
$attributes = $oal->getAttributes();
@endphp


@foreach ($attributes as $field => $value)

@if(
!is_null($value) &&
$value !== '' &&
!in_array($field,['created_at','updated_at','sale_order_id','id','machine_id','model'])
)

<tr>
<th>{{ ucwords(str_replace('_',' ',$field)) }}</th>
<td>{{ printValue($value) }}</td>
</tr>

@endif


@if($field == 'machine_id')

<tr>
<th>Machine Name</th>
<td>{{ $oal->saleOrder->quotation->machine->name ?? '' }}</td>
</tr>

@endif

@if($field == 'model')
@php
    $name = $oal->saleOrder->quotation->modele->name ?? '';
    $production = $oal->saleOrder->quotation->modele->production ?? '';

    $names = preg_split('/[,\/]/', $name); // split by , and /
    $productions = explode(',', $production);

    $result = [];

    foreach ($names as $index => $item) {
        $item = trim($item);

        if (!isset($productions[$index])) continue;

        $prod = trim($productions[$index]);

        // Extract prefix (text before number)
        preg_match('/^[^\d]+/', $item, $prefixMatch);
        $prefix = $prefixMatch[0] ?? '';

        // Extract suffix (text after number)
        preg_match('/\d+(.*)$/', $item, $suffixMatch);
        $suffix = $suffixMatch[1] ?? '';

        $result[] = trim($prefix . $prod . $suffix);
    }

    // Rebuild structure (handle / separation)
    $final = implode(', ', $result);
@endphp


<tr>
<th>Model</th>
<td>{{ $final }}</td>
</tr>

@endif


@endforeach

</tbody>

</table>


<div class="signature">

<table width="100%">

<tr>

<td>
<p><b><u>Prepared By</u></b></p>
<br><br>
</td>

<td>
<p><b><u>Approved By</u></b></p>
<br><br>
</td>

</tr>

</table>

</div>


</div>

</body>
</html>