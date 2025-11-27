<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Acceptance Letter</title>
    <style>
        /* General Body Styles */
        body { 
            font-family: 'DejaVu Sans', sans-serif; 
            font-size: 12px; 
            margin: 0;
            padding: 0;
            line-height: 1.5;
        }

        /* Page Layout */
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header Styling */
        header {
            text-align: right;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ccc;
        }

        header img {
            height: 80px;
        }

        /* Title Section */
        h2 {
            text-align: center;
            font-size: 16px;
            margin-bottom: 30px;
            font-weight: 700;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px 20px;
            text-align: center;
            border: 1px solid #000;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
            width: 30%;
        }

        td {
            width: 70%;
            word-wrap: break-word;
        }

        /* Footer Section */
        .footer {
            margin-top: 40px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }

        .footer table {
            width: 100%;
            border: none;
        }

        .footer td {
            border: none;
            text-align: center;
            padding-top: 20px;
        }

        .footer p {
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<!-- Main Container -->
<div class="container">

    <!-- Header Section -->
    <header>
        <img src="{{ asset('./image/mr_logo.png') }}" alt="Logo">
    </header>

    <!-- Title Section -->
    <h2>Order Acceptance Letter</h2>

    @php
    function printValue($value){
       if($value == '0'){
         return 'Yes';
       } elseif($value == '1'){
        return 'No';
       } else {
         return $value;
       }
    }
    @endphp

    <!-- Table for Order Details -->
    <table>
        <tbody>
            @php
            $attributes = $oal->getAttributes();
            @endphp

            @foreach($attributes as $field => $value)
                @if(!is_null($value) && $value !== '' && !in_array($field, ['created_at','updated_at','sale_order_id','id','machine_id']))
                    <tr>
                        <th>{{ ucwords(str_replace('_', ' ', $field)) }}</th>
                        <td>{{ printValue($value) }}</td>
                    </tr>
                @endif

                @if($field == 'machine_id')
                    <tr>
                        <th>Machine Name</th>
                        <td>{{ $oal->saleOrder->quotation->machine->name ?? '' }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    <!-- Signature Section -->
    <div class="footer">
        <table>
            <tr>
                <td>
                    <p>Prepared By</p>
                    <br><br>
                    <p></p>
                </td>
                <td>
                    <p>Approved By</p>
                    <br><br>
                    <p></p>
                </td>
            </tr>
        </table>
    </div>

</div>

</body>
</html>
