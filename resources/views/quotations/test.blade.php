<!DOCTYPE html>
<html lang="en">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<head>
  <meta charset="UTF-8">
  <style>
    @page {
      margin:30px;
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
        font-weight:700; /* or 700 */
    }
    body {
      margin-top: 0;
      padding: 20px;
      font-family:'Poppins',sans-serif ;
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
      top:150px;
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
      bottom: -150px;
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
      color:black;
      font-size: small;
      text-decoration: underline;
    }
    span{
      /* display: inline-block; */
    }
    .tech-content{
      padding-left: 5px;  
     
    }

    .offer {
      position: relative;
      top: 120px;
     
    }

   .lastpage{
    position: relative;
    top:120px;

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
      padding:0 10px 0 0;
      display: flex;
      justify-content: space-between;
      border-bottom: 1px solid #2daae3;
 
  
    }

    .footer-content div {
      width: 34%;
      /* border-right: 2px solid black; */
      line-height: 1;
      height: 6%;
      
    }

    .footer-content p {
      /* margin: 2px 0; */
      word-wrap:break-word;
    }

    /* Decorative Image */
   
    .footer-page-number:after {
     content: "" counter(page);
     font-family: 'Poppins';
     font-weight:bolder;
     
    }
    .footer-page-number {
       /* text-align: center; */
       font-size: 14px;
       /* color:; */
       font-weight: bolder;
       margin-top: 35px;
       margin-right:10px;

       /* counter-increment: page; */
      
  }
  .parameter-table {
  /* border-collapse: collapse;
  font-family: 'Bookman Old Style', serif;
  font-size: 16px;
  position: relative;
  left: 40px; */
  width: 90%;
  table-layout: fixed; /* Ensures columns keep width */
  page-break-inside: avoid; /* Prevent row from splitting */
}

.parameter-table td {
  padding: 8px;
  vertical-align: top;
  white-space: nowrap; /* Prevents wrapping */
  overflow: hidden;
  text-overflow: ellipsis;
}

.parameter-table td:nth-child(1) {
  width: 35%;
}

.parameter-table td:nth-child(2) {
  width: 65%;
  white-space: normal; /* For value column, allow wrapping */
}
.submitted{
   position: relative;
   top:290px;
   /* font-family: 'Poppins',sans-serif !important; */
   padding: 0;
   margin: 0;
   left: 23px;
 }
 .footer-col-border::after {
    content: "";
    position: absolute;
    top: 10px; /* controls how far from top */
    right: 0;
    height: 100%; /* short vertical border */
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
  .img{
    position: relative;
    top: 200px;
    left: 20px;
  }
  .table-index{
    padding: 0 15px 0 15px;
  }
  .offer-table{
    position:relative;
    top:120px;
    right: 20px;
  }
  </style>
</head>

<body>
  <!-- Header -->
  <header>
    <div style="text-align: right;">
        <img src="{{ public_path('/image/mr_logo.png') }}" height="80px" >
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
    <div  class="footer-col footer-col-border" style="padding-left: 25px; width: 40%;">
      <b>Factory </b>
      <p>351 /A & 351 /B, PSL Compound, Near PLS Pipe</p>
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


  <div class=" "
  style="font-size: 16px; padding: 170px 0px 0 10px; line-height: 1.2;">

  <!-- Title Section -->
  <div style="padding:20px 0 0 0 0; padding-left: 0;">
    <div style="text-align:center; font-size: 30px; font-weight: bold; color: #2daae3;  text-transform: uppercase; word-spacing: 3px; font-family:'Montserrat',sans-serif !important ; font-style:normal; text-decoration: underline;">
      TECHNO-COMMERCIAL OFFER
    </div>
    <div style="font-size: 25px; margin-top: 5px; margin-left: 3px;" >
      Proposal for High-Speed Mixer Model {{ $quotation->modele->name ?? '' }}–PM Ltr
    </div>
  </div>

  <!-- Client Info Table -->
  <table style="width: 100%; border-collapse: collapse; margin-top: 30px; margin-left: 25px; font-size: 16px;">
    <tr>
      <td style="width: 150px; padding: 2px 0; color: #032854;">Client Name</td>
      <td style="padding: 2px 0;"> <span>:</span> <span style="padding-left: 5px;">{{ $quotation->customer->company_name ?? '' }}</span></td>
    </tr>
    <tr>
      <td style="color: #032854; padding: 2px 0;">Address</td>
      <td style="padding: 2px 0;"> <span>:</span> <span style="padding-left: 5px;">{{ $quotation->customer->address_line_1 ?? '' }},
        {{ $quotation->customer->city ?? 'Valsad' }}, {{ $quotation->customer->state ?? 'Gujarat' }}
        {{ $quotation->customer->pincode ?? '122345' }}
      </span>
      </td>
    </tr>
    <tr>
      <td style="color: #032854; padding: 2px 0;">Ref. No</td>
      <td style="padding: 2px 0;"> <span>:</span> <span style="padding-left:5px;">{{ $quotation->reference_no ?? '' }}</span></td>
    </tr>
    <tr>
      <td style="color: #032854; padding: 2px 0;">Date</td>
      <td style="padding: 2px 0;"> <span>:</span> <span style="padding-left: 5px;">{{ $quotation->date ?? '' }}</span></td>
    </tr>
    <tr>
      <td style="color: #032854; padding: 2px 0;">Kind Attn</td>
      <td style="padding: 4px 0;"> <span>:</span> <span style="padding-left: 5px;">{{ $quotation->customer->contact_person_1_name ?? '' }} </span></td>
    </tr>
    <tr>
      <td style="color: #032854; padding: 4px 0;">Contact No</td>
      <td style="padding: 4px 0;"> <span>:</span> <span style="padding-left: 5px;">{{ '+91 ' . substr($quotation->customer->contact_no ?? '8912929114', 0, 5) . ' ' . substr($quotation->customer->contact_no ?? '8912929114', 5) }}</span></td>
    </tr>
    <tr>
      <td style="color: #032854; padding: 4px 0;">E–Mail ID</td>
      <td style="padding: 4px 0;"> <span>:</span><span style="padding-left: 5px; color: #00AEEF;">{{ $quotation->customer->contact_person_1_email ?? 'demo1298@gmail.com' }}</span></td>
    </tr>
  </table>

  <!-- Dashed Divider -->
  {{-- <div style="border-top: 2px dashed #000; margin: 30px 0 25px 0;"></div> --}}

  <!-- Submitted By Section (Styled Properly) -->
  {{-- <table style="width: 100%; font-size: 15px;" class="submitted">
    <thead>
      <tr style="font-weight: bold;">
        <th style="text-align:left">Submitted By</th>
        <th style="padding: 5px 0; text-align:left;">Contact No.</th>
        <th style="padding: 5px 0; text-align:left;">E–Mail ID</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="padding: 5px 2px; border-top: 1px solid ;">{{ $quotation->user->name ?? 'Yogesh Gajjar' }}</td>
        <td style="padding: 5px 2px 0px 0px;">+91 89281 61634</td>
        <td style="text-align:left color: #0066cc; text-decoration: underline;">
          {{ $quotation->user->email ?? 'yogesh@mrengineers.co.in' }}
        </td>
      </tr>
    </tbody>
  </table> --}}
  <table style="width: 100%; font-size: 15px; margin-top: 30px; font-family: 'Poppins'; line-height: 9px;" class="submitted">
    <tr>
      <!-- Submitted By: Left aligned -->
      <td style="width: 33.33%; text-align: left;">
        <div style="font-family: 'Poppins'; font-weight: bold; font-size: 16px; border-bottom: 1px solid black; display: inline-block; padding-bottom: 3px;">
          <span class="bold-text">Submitted By<</span>
        </div>
        <div style="margin-top: 5px; margin-left: 8px;">
          {{ $quotation->user->name ?? 'Yogesh Gajjar' }}
        </div>
      </td>
  
      <!-- Contact No.: Center aligned -->
      <td style="width: 33.33%; text-align: center;">
        <div style="width: 60%; font-weight: bold; border-bottom: 1px solid black; display: inline-block; padding-bottom: 3px; font-size: 16px;">
          Contact No.
        </div>
        <div style="margin-top: 5px;">+91 89281 61634</div>
      </td>
  
      <!-- E–Mail ID: Right aligned -->
      <td style="width: 43.33%; text-align: center;">
        <div style="width:60%; font-weight: bold; border-bottom: 1px solid black; display: inline-block; padding-bottom: 3px; font-size: 16px;">
          E– Mail ID
        </div>
        <div style="margin-top: 2px; text-align: center;">
          <span style="color: #00AEEF; ">
            {{ $quotation->user->email ?? 'yogesh@mrengineers.co.' }}
          </span>
        </div>
      </td>
    </tr>
  </table>
  

  
</div>


{{--  --}}
<div class='img'>
  <div class="border-box">
    <img src="{{public_path('storage/' . $quotation->machine->image_url) ?? 'mixture.png'}}" class="main-image " />
  </div>
</div>

{{--  --}}

  <div class="page-break">
    <div class="table-index">
      <h1 style="text-align: left; display: flex; justify-content:center; align-self: center; margin-bottom: 50px;">
        TABLE OF CONTENTS</h1>
      <div class="content" style="font-size: 16px;">
        <div
          style="border-top: 1px solid black; padding:10px 0px 10px 0px; display: flex; justify-content: space-between; position: relative;">
          <span>TECHNICAL DATA</span> <span style="position: absolute; right: 5px;">3</span>
        </div>
        <div
          style="border-top: 1px solid black; padding:10px 0px 10px 0px; display: flex; justify-content: space-between; position: relative;">
          <span>SPECIFICATION OF MIXTURE</span> <span style="position: absolute; right: 5px;">4</span>
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
    <div class="techincal-data parameter-table" >
      <h2 style="text-decoration: underline">1. TECHNICAL DATA</h2>
      <!-- DESING PARAMETER OF HIGH-SPEED -->
      <div class="technical-data-sub-head" style="text-align:left; width: 95%;">
        {{-- <h3>1.1 <span style="text-decoration: underline;">DESIGN PARAMETER OF HIGH-SPEED MIXTURE</span></h3> --}}
        <h3>1.1 <span style="">DESIGN PARAMETER OF {{strtoupper($quotation->machine->name)}}</span></h3>
      </div>
<table class="parameter-table" style="border-collapse: collapse; font-size: 14px; position: relative; left: 40px; width: 90%;">
    <tr>
        <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Model</td>
        <td style="padding: 8px;">:&nbsp;{{ $quotation->modele->name ?? '' }}</td>
    </tr>
    <tr>
        <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Product</td>
        <td style="padding: 8px;">:&nbsp;{{ $quotation->product->name ?? '' }}</td>
    </tr>
    <tr>
        <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Material to Process</td>
        <td style="padding: 8px;">:&nbsp;{{ $quotation->product->material_to_process ?? '' }}</td>
    </tr>
    <tr>
        <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Batch</td>
        <td style="padding: 8px;">:&nbsp;{{ $quotation->product->batch_capcity ?? '40 Kgs' }}</td>
    </tr>
    <tr>
        <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Mixing Tool</td>
        <td style="padding: 8px;">:&nbsp;{{ $quotation->product->mixing_tool ?? '3 Tier Alloy Steel with Heat Treatment Process' }}</td>
    </tr>
</table>


      <div class="technical-data-sub-head" style="text-align: left;width: 95%;">
        <h3>1.2 <span style="">ELECTRICAL PARAMETERS</span></h3>
      </div>
      <table class="parameter-table" style="border-collapse: collapse; font-size: 14px; position: relative; left: 40px; width: 90%;">
    <tr>
        <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Motor Requirement</td>
        <td style="padding: 8px;">:&nbsp;15 KW/20 HP Single Speed Mixer – 1440 RPM</td>
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
            :&nbsp;Complete Electrical Control Panel comprising of Thermocouple Wire, Digital Temperature Indicator with Ammeter & Voltmeter, Limit Switch & MCCB provided for safety precaution.
        </td>
    </tr>
    <tr>
        <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Mixing Tool</strong></td>
        <td style="padding: 8px;">:&nbsp;3 Tier Alloy Steel</td>
    </tr>
</table>

      
    </div>
  </div>
  {{--start--}}
  <div class="page-break"
    style="padding: 100px 20px 15px 10px;  font-size: 14px; line-height: 0.9; box-sizing: border-box;" >
    <div class="technical-datayrt">

      <h2 style="margin-bottom: 10px; text-decoration: underline;">2. &nbsp;&nbsp; TECHNICAL SPECIFICATION OF MIXTURE</h2>

      <!-- 2.2 MIXING VESSEL LID -->
      <div class="details">
        <h4 style="margin-left: 30px; margin-bottom: 2px;">• MIXING VESSEL:</h4>
        <p style="margin-left: 40px; margin-bottom: 6px;">
         Inside Made from SS – 304 Grade Plate and Outside Jacketed by Mild Steel Plate.   Jacketed Construction Provided for Heating or Cooling with Suitable Media. Material Discharge Assembly is fitted at the Bottom, Operated by Pneumatic Cylinder

        </p>

        <h4 style="margin-left: 30px; margin-bottom: 2px;">• Lid:</h4>
        <p style="margin-left: 40px; margin-bottom: 6px;">
          Stainless steel - 304 grades.
          Equipped with gasket, on lid edge and with lid locking arrangement. The lid is fitted with the Followings flanged
          openings
          1. One for fitting arrangements for
          Deflector and thermocouple.
          2. One for addition of chemicals.
        
        </p>

        <h4 style="margin-left: 30px; margin-bottom: 2px;">• MATERIAL:</h4>
        <p style="margin-left: 40px; margin-bottom: 6px;">
          Stainless steel - 304 grades.<br>
          Equipped with gasket on lid edge and with lid locking arrangement. The lid is fitted with the following
          flanged openings:<br>
          1. One for fitting arrangements for deflector and thermocouple.<br>
          2. One for addition of chemicals.
        </p>

        <h4 style="margin-left: 30px; margin-bottom: 2px;">• DEFLECTOR:</h4>
        <p style="margin-left: 40px; margin-bottom: 6px;">
          Made of Stainless Steel – 304 grades or Alloy Steel. Equipped with thermocouple wire for temperature
          measurement. Installed with provision of varying angle and height to ensure maximum material circulation.
        </p>

        <h4 style="margin-left: 30px; margin-bottom: 2px;">• DISCHARGE VALVE:</h4>
        <p style="margin-left: 40px; margin-bottom: 6px;">
          Made of SS 304. Provided with gasket.
        </p>

        <h4 style="margin-left: 30px; margin-bottom: 2px;">• SHAFT:</h4>
        <p style="margin-left: 40px;">
          Shaft is specially manufactured from Alloy Steel, hardened and ground.
        </p>
        
      </div>

    </div>
  </div>

  {{--end of page break--}}
  {{--2nd page-s--}}
  <div class="page-break"
    style="padding:70px 10px 0px 10px;  font-size: 14px; line-height: 0.9; box-sizing: border-box;  page-break-inside:avoid">

    {{-- <div class="technical-datayrt" style="page-break-inside: avoid;"> --}}

      <div class="details" style="page-break-inside: avoid;">

        <h4 style="margin-left: 30px; margin-bottom: 3px;">• MIXING TOOL:</h4>

        <p style="margin-left: 40px; margin-bottom: 2px;">
          <b>Stainless Steel:</b> 304 GRADE OR ALLOY STEEL<br />
          Consisting three blades – Bottom Scraper, Fluidizing blade and Horn Shaped Blade. Specially Designed Shape and
          Angle Suitable for your Compound with Height adjustment. Spacers with wear resistance treatment.
        </p>

        <h4 style="margin-left: 30px; margin-bottom: 3px;">• BEARING HOUSING:</h4>
        <p style="margin-left: 40px; margin-bottom: 2px;">
          Mixing Vessel fitted on Steel Plates and Bearing Housing fitted on
          Steel Plates with Heavy Duty Bearings with Water Cooling and
          Greasing Arrangements. The resin Leakage to Bearings is
          Prevented by our Special Design
        </p>

        <h4 style="margin-left: 30px; ">• MOTOR:</h4>
        <p style="margin-left: 40px;">
          HINDUSTAN Make 1440 R.P.M AC Motor Drive Transmission
          Through “V” – belt and Pulley Arrangement.
        </p>

        <h4 style="margin-left: 30px;">• PULLEY:</h4>
        <p style="margin-left: 40px;">
          Taper Lock
        </p>

        <h4 style="margin-left: 30px; ">• Mounting Structure :</h4>
        <p style="margin-left: 40px;">
          Sturdy MS Channel from Duly Covered with MS Sheet and
          Coated with Water resistant enamel Coating Painting

        </p>

        <h4 style="margin-left: 30px; ">• ELECTRICAL CONTROL:</h4>
        <p style="margin-left: 40px; ">
          ABB / L& T / SIEMENS Make

        </p>

        <h4 style="margin-left: 30px; ">• AC FREQUENCY DRIVE:</h4>
        <p style="margin-left: 40px;">
          Yaskawa Make
        </p>

        <h4 style="margin-left: 30px;">• BEARING:</h4>
        <p style="margin-left: 40px; ">
          ZKL / FAG / SKF Make
        </p>

        <h4 style="margin-left: 30px; ">• PNEUMATIC:</h4>
        <p style="margin-left: 40px;">
          JANATICS / SPAC Make

        </p>

      </div>

      {{--
    </div> --}}
  </div>

  {{--2nd page -e--}}
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
        style="border-collapse: collapse; width: 110%; font-size: 14px; border: 1px solid black; line-height: 0.8;" class='offer-table'>
        <thead style="border: 1px solid black;">
          <tr style="font-weight: bold; text-align: center; border: 1px solid black;">
            <th style="width: 10%; padding: 10px; border: 1px solid black;">Sr.No.</th>
            <th style="width: 60%; padding: 10px; border: 1px solid black;">PARTICULAR</th>
            <th style="width: 13%; padding: 10px; border: 1px solid black;">Qty</th>
            <th style="width: 15%; padding: 10px; border: 1px solid black;">Unit Price</th>
            <th style="width: 15%; padding: 10px; border: 1px solid black;">Ex Work Price In Rs.</th>
          </tr>
        </thead>
        <tbody style="border: 1px solid black;">
          <tr style="border: 1px solid black;">
            <td style="text-align: center; vertical-align: top; padding: 10px; border: 1px solid black;">1</td>
            <td style="padding: 10px; line-height: 1; border: 1px solid black;">
              {{-- HIGH SPEED MIXER MODEL CHM – 500 <br> --}}
              {{strtoupper($quotation->machine->name)}} MODEL CHM – {{$quotation->modele->name}} <br>
              ALONG WITH AC FREQUENCY DRIVE <br>
              ELECTRICAL PANEL
            </td>
            <td style="text-align: center; vertical-align: top; padding: 10px; border: 1px solid black;">
              {{ $quotation->quantity ?? '' }} Nos.
            </td>
            <td style="text-align: center; vertical-align: top; padding: 10px; border: 1px solid black;">
              {{ $quotation->product->price }}
            </td>
            <td style="text-align: center; vertical-align: top; padding: 10px; border: 1px solid black;">
              {{ number_format($quotation->quantity * $quotation->product->price, 2) }}
            </td>
          </tr>

          <!-- Total Row -->
          <tr style="border: 1px solid black;">
            <td colspan="4" style="font-weight: bold; text-align: center; padding: 10px;">
              <!-- RUPEES XXXXXXXXXXXXX ONLY -->
              {{ strtoupper($words) }} ONLY
            </td>
            <td style="font-weight: bold; text-align: center; padding: 10px; border: 1px solid black;">
              {{ number_format($quotation->quantity * $quotation->product->price, 2) }}
            </td>
          </tr>
        </tbody>
      </table>

    </div>
  </div>

  <div class="page-break">
  <div class="lastpage">
    <div class="technical-data">
      <h2>4 &nbsp; &nbsp;<span>TERM AND
          CONDITION</span></h2>
    </div>
    <table border="1"
      style="border-collapse: collapse; width: 100%;  font-size: 14px; line-height: 0.9;">
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