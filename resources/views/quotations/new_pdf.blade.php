<!DOCTYPE html>
<html lang="en">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 30px;
        }

        /* @page {
      margin: 130px 60px 120px 60px;
    } */
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 400;
            src: url('{{ public_path('fonts/Poppins-Regular.ttf') }}') format('truetype');
            /* src: url('{{ public_path('fonts/Poppins-ExtraBold.ttf.ttf') }}') format('truetype'); */
        }

        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 700;
            /* src: url('{{ public_path('fonts/Poppins-Regular.ttf') }}') format('truetype'); */
            src: url('{{ public_path('fonts/Poppins-Bold.ttf') }}') format('truetype');
        }

        .bold-text {
            font-weight: 700;
            /* or 700 */
        }

        body {
            margin-top: 0;
            padding: 20px;
            font-family: 'Poppins', sans-serif;
            border: 2px solid black;
            font-optical-sizing: auto;

        }

        header {
            position: fixed;

            right: 25px;

            height: 100px;

            z-index: 15;

        }

        .client-info {
            text-align: center;
            position: absolute;
            top: 40px;
        }

        .container {
            background: #fff;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.3);
        }

        .page-break {
            page-break-before: always;

        }

        .pagenum:before {
            content: counter(page);
        }

        .content-wrapper {

            position: absolute;
            top: 150px;
            left: 100px;
            height: auto;
            object-fit: contain;
        }



        .client-footer {
            position: relative;
            width: 142%;
            border-top: 2px dashed black;
        }

        .client-footer table {

            position: relative;
            top: 20px;
            font-size: 15px;
            border-collapse: separate;
            margin-top: 10px;
            /* margin-bottom:20px;  */
        }

        .client-footer table tr td {
            /* margin-right: 200px; */
        }

        .dashed-border {
            position: relative;
            /* right: 50px; */
        }


        .table-index {
            position: relative;
            bottom: -85px;
            margin-left: 10px;
        }

        .techincal-data {
            position: absolute;
            top: 115px;
        }

        .technical-data-sub-head {}

        .technical-data-sub-head h3 {
            padding: 6px 0px 6px 15px;
            /* background-color: #2daae3; */
            /* border-radius: 15px; */
            /* color: white; */
            color: black;
            font-size: small;
            text-decoration: underline;
        }

        span {
            /* display: inline-block; */
        }

        .tech-content {
            padding-left: 5px;

        }

        .offer {
            position: relative;
            top: 85px;

        }

        .lastpage {
            position: relative;
            top: 95px;

        }

        /* deepsiik */

        .website {
            margin-top: 5px;
        }

        footer {
            width: 85%;
            /* font-family: Arial, sans-serif; */
            font-size: 8px;
            color: #000;
            position: fixed;
            left: 0;
            background-color: #fff;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-top: 2px solid #000;


        }

        .footer-content div {
            float: left;
            /* padding-top: 2px; */
            /* padding-bottom: 2px; */
            /* height: 80px; */
            padding-left: 10px;
        }



        .footer-content p {
            /* margin: 2px 0; */
        }

        .footer-content::after {
            content: "";
            display: block;
            clear: both;
        }

        .footer-content {
            position: fixed;
            bottom: 10px;
            /* Adjust if needed */
            left: 12px;
            width: 95%;
            /* font-family: Arial, sans-serif; */
            font-size: 11px;

            /* line-height: normal; */
            color: #000;
            border-top: 1px solid #2daae3;
            padding: 0 10px 0 0;
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #2daae3;


        }

        .footer-content div {
            width: 34%;
            /* border-right: 2px solid black; */
            line-height: 1;
            height: 6%;
            margin-bottom: 35px;

        }

        .footer-content p {
            /* margin: 2px 0; */
            word-wrap: break-word;
        }

        /* Decorative Image */

        .footer-page-number:after {
            content: "" counter(page);
            font-family: 'Poppins';
            font-weight: bolder;

        }

        .footer-page-number {
            font-size: 14px;

            font-weight: bolder;
            position: relative;
            top: 32px;
            left: 22px;
        }

        .parameter-table {
            /* border-collapse: collapse;
  font-family: 'Bookman Old Style', serif;
  font-size: 16px;
  position: relative;
  left: 40px; */
            width: 90%;
            table-layout: fixed;
            /* Ensures columns keep width */
            page-break-inside: avoid;
            /* Prevent row from splitting */
        }

        .parameter-table td {
            padding: 8px;
            vertical-align: top;
            white-space: nowrap;
            /* Prevents wrapping */
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .parameter-table td:nth-child(1) {
            width: 35%;
        }

        .parameter-table td:nth-child(2) {
            width: 65%;
            white-space: normal;
            /* For value column, allow wrapping */
        }

        .submitted {
            position: relative;
            top: 270px;
            /* font-family: 'Poppins',sans-serif !important; */
            padding: 0;
            margin: 0;
            left: 23px;
        }

        .footer-col-border::after {
            content: "";
            position: absolute;
            top: 10px;
            /* controls how far from top */
            right: 0;
            height: 100%;
            /* short vertical border */
            border-right: 1px solid black;
        }

        .footer-col {
            width: 33%;
            position: relative;
            padding-right: 2px;
        }

        .footer-col p {
            margin: 0;
            /* line-height: 0.8; */

        }

        .img {
            position: relative;
            top: 200px;
            left: 20px;
        }

        .table-index {
            padding: 0 15px 0 15px;
        }

        .offer-table {
            position: relative;
            top: 120px;
            right: 20px;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <div style="text-align: right;">
            <img src="{{ asset('/image/mr_logo.png') }}" height="80px">
        </div>
    </header>

    <div class="footer-content">
        <div class="footer-col footer-col-border" style="word-wrap: break-word;">
            <b>Register Office:</b>
            <p> Room No. 16, 2nd Floor BhagawanNivas</p>
            <p>Near Sub Register Office, Station Road</p>
            <p>Goregaon West, Mumbai – 400 062</p>
            <p>E-Mail: <span style="color: #2daae3;">info@mrengineers.co.in</span></p>
        </div>
        <div class="footer-col footer-col-border" style="padding-left: 25px; width: 40%;">
            <b>Factory </b>
            <p>351 /A & 351 /B, EPL Compound, Near EPL Pipe</p>
            <p>Kachigam Char Rasta, Village Kachigam Nani</p>
            <p>Daman (UT), Daman –396210</p>
            <p>Website: <span style="color: #2daae3;">www.mrengineers.co.in</span></p>
        </div>
        <div class="footer-page-number" style="padding-left: 20px">
            <span style="color: rgba(0, 0, 0, 0.301)">Page |</span>
        </div>
    </div>

    <!-- Decorative Footer Image -->


    <!-- Page Number -->


    <div style="font-size: 16px; padding: 170px 0px 10px 10px; line-height: 1.2;">

        <!-- Title Section -->
        <div style="padding-top: 35px; text-align: center;">
            <div
                style="font-size: 30px; font-weight: bold; color: #2daae3; text-transform: uppercase; 
                word-spacing: 3px; font-family: 'Montserrat', sans-serif; text-decoration: underline;">
                TECHNO-COMMERCIAL {{ $quotation->reflect_in_pdf ? 'Revised' : '' }} OFFER
            </div>
            <div style="font-size: 25px; margin-top: 6px; word-break: break-word; white-space: normal;">
                Proposal for Heater Mixer
                <span style="white-space: nowrap;">
                    Model {{ $quotation->modele->name ?? '' }}
                </span>
            </div>

        </div>

        <!-- Client Info Table -->
        <!-- Client Info Table -->
        <!-- Client Info Table -->
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px; margin-left: 25px; font-size: 16px;">
            <tr>
                <td style="width: 160px; color: #032854; padding: 3px 2px; vertical-align: top;">Client Name</td>
                <td style="width: 10px; text-align: center; padding: 3px;">:</td>
                <td style="padding: 3px 0; word-break: break-word; white-space: normal;">
                    {{ $quotation->customer->company_name ?? '' }}
                </td>
            </tr>

            <tr>
                <td style="color: #032854; padding: 3px 2px; vertical-align: top;">Address</td>
                <td style="width: 10px; text-align: center; padding: 3px; vertical-align: top;">:</td>
                <td
                    style="padding: 3px 0;padding-right:15px; word-break: break-word; white-space:normal; line-height: 1; ">
                    {{ $quotation->customer->address_line_1 ?? '' }},
                    {{ $quotation->customer->city ?? 'Valsad' }},
                    {{ $quotation->customer->state ?? 'Gujarat' }}
                    {{ $quotation->customer->pincode ?? '122345' }}
                </td>
            </tr>

            <tr>
                <td style="color: #032854; padding: 3px 2px;">Ref. No</td>
                <td style="text-align: center; padding: 3px;">:</td>
                <td style="padding: 3px 0;">{{ $quotation->reference_no ?? '' }}</td>
            </tr>

            <tr>
                <td style="color: #032854; padding: 3px 2px;">Date</td>
                <td style="text-align: center; padding: 3px;">:</td>
                <td style="padding: 3px 0;">{{ formatDate($quotation->date ?? '') }}</td>
            </tr>

            <tr>
                <td style="color: #032854; padding: 3px 2px;">Kind Attn</td>
                <td style="text-align: center; padding: 3px;">:</td>
                <td style="padding: 3px 0;">{{ $quotation->customer->contact_person_1_name ?? '' }}</td>
            </tr>

            <tr>
                <td style="color: #032854; padding: 3px 2px;">Contact No</td>
                <td style="text-align: center; padding: 3px;">:</td>
                <td style="padding: 3px 0;">
                    {{ $quotation->customer->country_code ?? '+91' . ' ' . substr($quotation->customer->contact_no ?? '8912929114', 0, 5) . ' ' . substr($quotation->customer->contact_no ?? '8912929114', 5) }}
                </td>
            </tr>

            <tr>
                <td style="color: #032854; padding: 3px 2px;">E–Mail ID</td>
                <td style="text-align: center; padding: 3px;">:</td>
                <td style="padding: 3px 0; color: #00AEEF; word-break: break-word; white-space: normal;">
                    {{ $quotation->customer->contact_person_1_email ?? 'demo1298@gmail.com' }}
                </td>
            </tr>
        </table>



        <div style="position: absolute; bottom: 145px; left: 48px; right: 25px; width: calc(100% - 100px);">
            <table style="width: 100%; font-size: 15px; font-family: 'Poppins'; line-height: 9px;">
                <tr>
                    <!-- Submitted By: Left aligned -->
                    <td style="width: 33.33%; text-align: left;">
                        <div
                            style="font-weight: bold; font-size: 16px; border-bottom: 1px solid black; display: inline-block; padding-bottom: 3px;">
                            Submitted By
                        </div>
                        <div style="margin-top: 5px; margin-left: 8px;">
                            {{ $quotation->followedBy->name ?? 'Yogesh Gajjar' }}
                        </div>
                    </td>

                    <!-- Contact No.: Center aligned -->
                    <td style="width: 33.33%; text-align: center;">
                        <div
                            style="width: 50%; font-weight: bold; border-bottom: 1px solid black; display: inline-block; padding-bottom: 3px; font-size: 16px;">
                            Contact No.
                        </div>
                        <div style="margin-top: 5px;">
                            {{ '+91 ' . substr($quotation->followedBy->contact_no ?? '8912929114', 0, 5) . ' ' . substr($quotation->followedBy->mobile_no ?? '8912929114', 5) }}
                        </div>
                    </td>

                    <!-- E–Mail ID: Right aligned -->
                    <td style="width: 33.33%; text-align: center;">
                        <div
                            style="width: 60%; font-weight: bold; border-bottom: 1px solid black; display: inline-block; padding-bottom: 3px; font-size: 16px;">
                            E– Mail ID
                        </div>
                        <div style="margin-top: 2px; text-align: center;">
                            <span style="color: #00AEEF;">
                                {{ $quotation->followedBy->email ?? 'yogesh@mrengineers.co.' }}
                            </span>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>



    {{-- --}}
    <div class='img'>
        <div class="border-box">
            <img src="{{ asset('storage/' . $quotation->machine->image_url) ?? 'mixture.png' }}" class="main-image " />
        </div>
        <p  style="position: fixed;bottom: 360px; left: 45%;  transform: translateX(-50%); font-size: 13px; margin: 0;  text-align: center; font-weight:bolder;">
            *The image shown above is for reference purposes only.
        </p>

    </div>

    {{-- --}}

    <div class="page-break" style="padding: 110px 20px 10px 10px;">
        <div class="table-index">
            <h1
                style="text-align: left; display: flex; justify-content:center; align-self: center; margin-bottom: 45px;">
                TABLE OF CONTENTS</h1>
            <div class="content" style="font-size: 16px; padding-top:20px">
                <div
                    style="border-top: 1px solid black; padding:10px 0px 10px 0px; display: flex; justify-content: space-between; position: relative;">
                    <span>TECHNICAL DATA</span> <span style="position: absolute; right: 5px;">3</span>
                </div>
                <div
                    style="border-top: 1px solid black; padding:10px 0px 10px 0px; display: flex; justify-content: space-between; position: relative;">
                    <span>SPECIFICATION OF MIXER</span> <span style="position: absolute; right: 5px;">4</span>
                </div>
                <div
                    style="border-top: 1px solid black; padding:10px 0px 10px 0px; display: flex; justify-content: space-between; position: relative;">
                    <span>OFFER</span> <span style="position: absolute; right: 5px;">7</span>
                </div>
                <div
                    style="border-top: 1px solid black; padding:10px 0px 10px 0px; display: flex; justify-content: space-between; border-bottom:1px solid black; position: relative;">
                    <span>TERMS AND CONDITION</span> <span style="position: absolute; right: 5px;">8</span>
                </div>
            </div>
        </div>
    </div>

    {{-- start --}}
    <div class="page-break ">
        <div class="techincal-data parameter-table">
            <h2 style="text-decoration: underline">1. TECHNICAL DATA</h2>
            <!-- DESING PARAMETER OF HIGH-SPEED -->
            <div class="technical-data-sub-head" style="text-align:left; width: 95%;">
                {{-- <h3>1.1 <span style="text-decoration: underline;">DESIGN PARAMETER OF HIGH-SPEED MIXTURE</span></h3> --}}
                <h3>1.1 <span style="">DESIGN PARAMETER OF {{ strtoupper($quotation->machine->name) }}</span>
                </h3>
            </div>
            <table class="parameter-table"
                style="border-collapse: collapse; font-size: 14px; position: relative; left: 40px; width: 90%; line-height: 1.1;">
                <tr>
                    <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Model</td>
                    <td style="padding: 8px;">:&nbsp;{{ $quotation->modele->name ?? '' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Product</td>
                    <td style="padding: 8px;">:&nbsp;{{ $quotation->application->name ?? '' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Material to Process
                    </td>
                    <td style="padding: 8px;">:&nbsp;{{ $quotation->materialToProcess->material_to_process ?? '' }}
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Batch</td>
                    <td style="padding: 8px;">:&nbsp;{{ $quotation->batch->batches ?? '' }} Kgs</td>
                </tr>
                <tr>
                    <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Mixing Tool</td>
                    <td style="padding: 8px;">:&nbsp;{{ $quotation->mixingTool->mixing_tool ?? 'N.A' }}</td>
                </tr>
            </table>


            <div class="technical-data-sub-head" style="text-align: left;width: 95%;">
                <h3>1.2 <span style="">ELECTRICAL PARAMETERS</span></h3>
            </div>
            <table class="parameter-table"
                style="border-collapse: collapse; font-size: 14px; position: relative; left: 40px; width: 90%; line-height: 1.1;">
                <tr>
                    <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Motor Requirement</td>
                    {{-- <td style="padding: 8px;">:&nbsp;15 KW/20 HP Single Speed Mixer – 1440 RPM</td> --}}
                    <td style="padding: 8px;">:&nbsp;{{ $quotation->motorRequirement->motor_requirement }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Voltage</td>
                    <td style="padding: 8px;">:&nbsp;415 V</td>
                </tr>
                <tr>
                    <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Frequency</td>
                    <td style="padding: 8px;">:&nbsp;50Hz</td>
                </tr>
                <tr>
                    <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Control Panel</td>
                    <td style="padding: 8px;">
                        :&nbsp;Complete Electrical Control Panel comprising of Thermocouple Wire, Digital Temperature
                        Indicator with
                        Ammeter & Voltmeter, Limit Switch & MCCB provided for safety precaution.
                    </td>
                </tr>
            </table>


        </div>
    </div>
    {{-- start --}}
    <div class="page-break" style="padding: 110px 20px 10px 10px;  font-size: 14px;  box-sizing: border-box;">
        <div class="technical-datayrt">

            <h2 style="margin-bottom: 10px; text-decoration: underline;">2.&nbsp; TECHNICAL SPECIFICATION OF MIXER</h2>

            <!-- 2.2 MIXING VESSEL LID -->
            <table class="parameter-table"
                style="border-collapse: collapse; line-height: 1.1; font-size: 14px; position: relative; left: 20px; width: 90%; top: 60px;">
                <tr>
                    <td style="vertical-align: top; width: 30%; padding-bottom: 4px; white-space: nowrap;">
                        <span>&#8226;&nbsp; Mixing Vessel</span>
                    </td>
                    <td style="vertical-align: top; padding-bottom: 4px; text-align: justify;">
                        :&nbsp;Inside Made from SS – 304 Grade Plate and Outside Jacketed by Mild Steel Plate. Jacketed
                        Construction
                        Provided
                        for Heating or Cooling with Suitable Media. Material Discharge Assembly is fitted at the Bottom,
                        Operated by
                        Pneumatic Cylinder.
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: top; padding-bottom: 4px; white-space: nowrap;">
                        <span>&#8226;&nbsp; Lid</span>
                    </td>
                    <td style="vertical-align: top; padding-bottom: 4px; text-align: justify;">
                        :&nbsp;Stainless steel - 304 grades. Equipped with gasket, on lid edge and with lid locking
                        arrangement. The
                        lid is
                        fitted with the Followings flanged openings:<br>
                        <div>
                            1.&nbsp;One for fitting arrangements for Deflector and thermocouple.<br>
                            2.&nbsp;One for addition of chemicals.
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: top; padding-bottom: 4px; white-space: nowrap;">
                        <span>&#8226;&nbsp; Deflector</span>
                    </td>
                    <td style="vertical-align: top; padding-bottom: 4px; text-align: justify;">
                        :&nbsp;Made up of Stainless Steel – 304 grades or Alloy steel Equipped with Thermocouple Wire
                        for
                        Temperature
                        Measurement. Installed with provision of Varying Angle and Height to Ensure Maximum Material
                        Circulation.
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: top; padding-bottom: 4px; white-space: nowrap;">
                        <span>&#8226;&nbsp; Discharge Valve</span>
                    </td>
                    <td style="vertical-align: top; padding-bottom: 4px; text-align: justify;">
                        :&nbsp;Made Up of SS 304 Provided with Gasket.
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: top; white-space: nowrap;padding-bottom: 4px;">
                        <span>&#8226;&nbsp; Shaft</span>
                    </td>
                    <td style="vertical-align: top; text-align: justify;padding-bottom: 4px;">
                        :&nbsp;Shaft is Specially Manufactured from Alloy Steel, Hardened and Ground.
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: top; white-space: nowrap; padding-bottom: 4px;">
                        <span>&#8226;&nbsp; Mounting Structure</span>
                    </td>
                    <td style="vertical-align: top; text-align: justify; padding-bottom: 4px;">
                        :&nbsp;Sturdy MS Channel from Duly Covered with MS Sheet and Coated with Water resistant enamel
                        Coating
                        Painting.
                    </td>
                </tr>
            </table>




        </div>
    </div>

    {{-- end of page break --}}
    {{-- 2nd page-s --}}
    <div class="page-break"
        style="padding:110px 10px 0px 10px;  font-size: 14px; box-sizing: border-box;  page-break-inside:avoid">

        {{-- <div class="technical-datayrt" style="page-break-inside: avoid;"> --}}

        <table class="parameter-table"
            style="border-collapse: collapse; line-height: 1.1; font-size: 14px; position: relative; left: 20px; width: 90%; top:110px; padding-bottom: 3px;">
            <tr>
                <td style="vertical-align: top; width: 30%; white-space: nowrap; padding-bottom: 4px;">
                    <span>&#8226;&nbsp; Mixing Tool</span>
                </td>
                <td style="vertical-align: top; text-align: justify; padding-bottom: 4px;">
                    :&nbsp;STAINLESS STEEL: 304 GRADES. OR ALLOY STEEL. Specially Designed Shape and Angle Suitable for
                    your Compound with Height
                    adjustment. Spacers with wear resistance treatment.
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top; white-space: nowrap; padding-bottom: 4px;">
                    <span>&#8226;&nbsp; Bearing Housing</span>
                </td>
                <td style="vertical-align: top; text-align: justify; padding-bottom: 4px;">
                    :&nbsp;Mixing Vessel fitted on Steel Plates and Bearing Housing fitted on Steel Plates with Heavy
                    Duty
                    Bearings with Water Cooling and Greasing Arrangements. The resin Leakage to Bearings is Prevented by
                    our
                    Special Design.
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top; white-space: nowrap; padding-bottom: 4px;">
                    <span>&#8226;&nbsp; Driving System</span>
                </td>
                <td style="vertical-align: top; text-align: justify; padding-bottom: 4px;">
                    :&nbsp;The drive system incorporates with V-belt and taper lock pulley (SPC type) to give Efficient
                    power
                    drive transmission. The Belts Are Tightened by means of motor sliding screw.
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top; white-space: nowrap; padding-bottom: 4px;">
                    <span>&#8226;&nbsp; Motor</span>
                </td>
                <td style="vertical-align: top; text-align: justify; padding-bottom: 4px;">
                    :&nbsp;{{ $quotation->makeMotor->name ?? '' }} Make Motor 1440 R.P.M AC Motor Drive Transmission Through
                    “V” – belt and Pulley Arrangement.
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top; white-space: nowrap; padding-bottom: 4px;">
                    <span>&#8226;&nbsp; Electrical Control</span>
                </td>
                <td style="vertical-align: top; text-align: justify; padding-bottom: 4px;">
                    :&nbsp;{{ $quotation->electricalControl->electrical_control }}
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top; white-space: nowrap; padding-bottom: 4px;">
                    <span>&#8226;&nbsp; AC Frequency Drive</span>
                </td>
                <td style="vertical-align: top; text-align: justify; padding-bottom: 4px;">
                    :&nbsp;{{ $quotation->acFrequencyDrive->ac_fequency_drive }}
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top; white-space: nowrap; padding-bottom: 4px;">
                    <span>&#8226;&nbsp; Bearing</span>
                </td>
                <td style="vertical-align: top; text-align: justify; padding-bottom: 4px;">
                    :&nbsp;{{ $quotation->bearinge->bearing ?? 'N.A' }}
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top; white-space: nowrap;">
                    <span>&#8226;&nbsp; Pneumatics</span>
                </td>
                <td style="vertical-align: top; text-align: justify;">
                    :&nbsp;{{ $quotation->pneumatic->pneumatic ?? '' }}
                </td>
            </tr>
        </table>

    </div>

    {{-- 2nd page -e --}}
    <div class="page-break" style="page-break-before: always;  width: 100%; padding:10px 5px 0px 20px;">

        <!-- Wrapper to center the content -->
        <div class="offer" style="width: 90%;">

            <!-- Section Title -->
            <div class="technical-data">
                <h2 style="text-decoration: underline">
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
                        <td
                            style="text-align: center; vertical-align: top; padding: 80px 10px; border: 1px solid black;">
                            1</td>
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

                    @if ($discount == 'amount')
                        <!-- Subtotal -->
                        <tr style="border: none">
                            <td colspan="4"
                                style="text-align: right; padding: 12px 15px; font-weight: 600; border: 1px solid black;">
                                Subtotal
                            </td>
                            <td
                                style="text-align: right; padding: 12px 15px; font-weight: 600; border: 1px solid black;">
                                {{ format_indian_number($amount, 2) }}
                            </td>
                        </tr>

                        <!-- Discount -->
                        <tr style="border: 1px solid black;">
                            <td colspan="4"
                                style="text-align: right; padding: 12px 15px; font-weight: 600; border: 1px solid black;">
                                Less: Discount
                            </td>
                            <td
                                style="text-align: right; padding: 12px 15px; font-weight: 600; border: 1px solid black;">
                                {{ format_indian_number($quotation->discount_amount, 2) }}
                            </td>
                        </tr>

                        <!-- Net Payable -->
                        <tr style="border: 1px solid black;">
                            <td colspan="4"
                                style="text-align: right; padding: 14px 15px; font-weight: bold; border: none;">
                                Net Payable Amount
                            </td>
                            <td
                                style="text-align: right; padding: 14px 15px; font-weight: bold; border: 1px solid black;">
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
                            <td
                                style="text-align: right; padding: 12px 15px; font-weight: 600; border: 1px solid black;">
                                {{ format_indian_number($amount, 2) }}
                            </td>
                        </tr>

                        <!-- Discount -->
                        <tr style="border: 1px solid black;">
                            <td colspan="4"
                                style="text-align: right; padding: 12px 15px; font-weight: 600; border: 1px solid black;">
                                Less: Discount ({{ format_indian_number($quotation->discount_percentage, 2) }}%)
                            </td>
                            <td
                                style="text-align: right; padding: 12px 15px; font-weight: 600; border: 1px solid black;">
                                {{ format_indian_number($amount * ($quotation->discount_percentage / 100), 2) }}
                            </td>
                        </tr>

                        <!-- Net Payable -->
                        <tr style="border: 1px solid black;">
                            <td colspan="4"
                                style="text-align: right; padding: 14px 15px; font-weight: bold; border: 1px solid black;">
                                Net Payable Amount
                            </td>
                            <td
                                style="text-align: right; padding: 14px 15px; font-weight: bold; border: 1px solid black;">
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
                            <td
                                style="text-align: right; padding: 14px 15px; font-weight: bold; border: 1px solid black;">
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
    </div>

    <div class="page-break">
        <div class="lastpage">
            <div class="technical-data">
                <h2 style="text-decoration:underline;margin-bottom:70px;">4.&nbsp;<span>TERMS AND
                        CONDITION</span></h2>
            </div>
            <table border="1" style="border-collapse: collapse; width: 100%;  font-size: 14px; line-height: 0.9;">
                <tr>
                    <td style="font-weight: bold; padding: 8px;">Price</td>
                    <!-- <td style="padding: 8px;">Above prices are EX our works, Kachigam Daman</td> -->
                    <td style="padding: 8px;">{{ $termCondition->price }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 8px;">Tax</td>
                    <!-- <td style="padding: 8px;">GST @18%, will be applicable</td> -->
                    <td style="padding: 8px;">{{ $termCondition->tax }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 8px;">Delivery</td>
                    <td style="padding: 8px;">{{ $termCondition->delivery }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 8px;">Payment</td>
                    <td style="padding: 8px;">{{ $termCondition->payment }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 8px;">Packing</td>
                    <!-- <td style="padding: 8px;">Extra at actual.</td> -->
                    <td style="padding: 8px;">{{ $termCondition->packing }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 8px;">Forwarding</td>
                    <!-- <td style="padding: 8px;">Extra at actual.</td> -->
                    <td style="padding: 8px;">{{ $termCondition->forwarding }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 8px;">Validity</td>
                    <!-- <td style="padding: 8px;">30 days</td> -->
                    <td style="padding: 8px;">{{ $termCondition->validity }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 8px;">Commissioning charges</td>
                    <!-- <td style="padding: 8px;">
      Customer should provide food & accommodation & to & fro ticket Charges and local transportation.
      If commission is carried more than 2 Days, then the Customer has to pay the charges of Rs. 3,500.00 per day.
    </td> -->
                    <td style="padding: 8px;">{{ $termCondition->commissioning_charges }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 8px;">Guarantee</td>
                    <!-- <td style="padding: 8px;">
      One calendar year from date of dispatch, if any manufacturing Defects.
      No Guarantee for Bought out Items as they are purchase from Standard make
    </td> -->
                    <td style="padding: 8px;">{{ $termCondition->guarantee }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 8px;">Cancellation of Order</td>
                    <!-- <td style="padding: 8px;">
      Orders once placed will not be subsequently cancelled for any Reason whatsoever.
      In the case of orders being cancelled, the entire Amount of the advance will be forfeited
    </td> -->
                    <td style="padding: 8px;">{{ $termCondition->cancellation_of_order }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 8px;">Judiciary</td>
                    <!-- <td style="padding: 8px;">Subject to Daman Judiciary only</td> -->
                    <td style="padding: 8px;">{{ $termCondition->judiciary }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 8px;">Not in our Scope of Supply</td>
                    <!-- <td style="padding: 8px;">
      Civil Works Pipe and Pipe line works, Cabling Works, Installation of machine
    </td> -->
                    <td style="padding: 8px;">{{ $termCondition->not_in_our_scope_of_supply }}</td>
                </tr>
            </table>
        </div>

    </div>

</body>

</html>
