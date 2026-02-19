<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <style>
    @page {
    margin: 120px 50px 100px 50px; 
    }
    /* @page {
      margin: 130px 60px 120px 60px;
    } */
    body{
     margin-top:0;
     padding: 0;
      font-family: 'Times New Roman', Times, serif;
      /* border: 1px solid black; */
      /* padding:10px; */
    }
    
    header {
    position: fixed;
    top: -100px;
    left: 0;
    right: 0;
    height: 100px;
    text-align: right;
    /* padding-bottom: 50px; */
   }

    .client-info{
      text-align: center;
    }
    .container {
      background: #fff;
      /* padding: 40px 50px; */
      /* border: 8px double #000; */
      /* width: 794px; A4 */
      box-shadow: 0 0 25px rgba(0, 0, 0, 0.3);
    }
    .client-info-table{
       position: relative;
       top:120px;
       left: 50px;
    }
    .cleint-sb{
      position: relative;
      top:250px;
      left: 50px;
    }
    .page-break{
      page-break-before:always;
      /* margin-top: 120px; */
    }
     footer {
            position: fixed;
            bottom: -110px;
            left: 0;
            right: 0;
            height: 100px;
            font-size: 10px;
            color: #666;
        }

      .footer-table {
            width: 100%;
            border-collapse: collapse;
      }

      .footer-table td {
            vertical-align: top;
            border: 1px solid #ccc;
            padding: 5px;
      }

      .footer-page {
            text-align: right;
            font-size: 14px;
            font-weight: bold;
            color: #666;
            letter-spacing: 1px;
      }
      .pagenum:before {
            content: counter(page);
       }
      .content-wrapper {
      /* height: 100%; */
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
    /* }
    .main-image {
      margin-top: 80px;
      max-width: 80%; /* shrink size */
      height: auto;
      object-fit: contain;
    } */
    .main-image {
      max-width: 100%;
      max-height: 600px;
      display: block;
      margin: 30px auto;
      object-fit: contain;
    }
    /* .border-box {
      border: 6px double #000;
      padding: 20px;
      display: inline-block;
    } */
    
  </style>
</head>
<body>
  <!-- Header -->
  <header>
    <div style="text-align: center; padding-top: 10px; padding-bottom:30px;">
        <img src="{{ public_path('/image/logo.png') }}" height="80px">
    </div>
  </header>

  <footer>
        <table class="footer-table">
            <tr>
                <td width="40%">
                    <strong>Register Office</strong><br>
                    Room No. 16, 2<sup>nd</sup> Floor BhagawanNivas,<br>
                    Near Sub Register Office, Station Road,<br>
                    Goregaon – West, Mumbai – 400 062<br>
                    E-Mail: <a href="mailto:info@mrengineers.co.in">info@mrengineers.co.in</a>
                </td>
                <td width="40%">
                    <strong>Factory</strong><br>
                    351 /A & 351 /B, PSL Compound, Near PLS Pipe,<br>
                    Kachigam Char Rasta, Village Kachigam<br>
                    Nani Daman (UT), Daman – 396210<br>
                    Website: <a href="http://www.mrengineers.co.in">www.mrengineers.co.in</a>
                </td>
                <td width="20%" class="footer-page">
                    Page | <span class="pagenum"></span>
                </td>
            </tr>
        </table>
    </footer>

    <div class="content-wrapper" >
      <div class="border-box">
        <img src="{{public_path('storage/'.$quotation->machine->image_url)??''}}" class="main-image "/>
      </div>
    </div>

  <div class="page-break container client-info" style="margin-top: 30px; font-family: 'Bookman Old Style', serif;">
  <!-- <div style="min-height: 100vh; display: flex; flex-direction: column; justify-content: space-between; padding: 60px 70px 40px 70px; font-family: 'Bookman Old Style', serif; font-size: 16px; line-height: 1.6;"> -->
<!-- Title Section -->
<div style="text-align: center; margin-bottom: 20px;">
    <div style="font-size: 22px; text-decoration: underline; font-weight: bold; letter-spacing: 1px;">
        TECHNO-COMMERCIAL OFFER
    </div>
    <div style="font-size: 18px; text-decoration: underline; font-weight: bold; margin-top: 35px;">
        {{-- Proposal for High-Speed Mixer Model CHM 140-R Ltr --}}
        Proposal for {{$quotation->machine->name}} Model {{$quotation->modele->name}}-R Ltr
    </div>
</div>

<!-- Client Info Table -->
<table style="width: 90%; margin: 40px auto 30px auto; font-size: 15px; border-collapse: separate; border-spacing: 8px 10px;">
    <tr>
        <td style="width: 150px; font-weight: bold;">Client Name</td>
        <td>: {{ $quotation->customer->company_name ?? '' }}</td>
    </tr>
    <tr>
        <td style="font-weight: bold;">Address</td>
        <td>: {{ $quotation->customer->address_line_1 }}, {{ $quotation->customer->city }}, {{ $quotation->customer->state }} {{ $quotation->pincode }}</td>
    </tr>
    <tr>
        <td style="font-weight: bold;">Ref. No.</td>
        <td>: {{ $quotation->reference_no ?? '' }}</td>
    </tr>
    <tr>
        <td style="font-weight: bold;">Date</td>
        <td>: {{ $quotation->date }}</td>
    </tr>
    <tr>
        <td style="font-weight: bold;">Kind Attn.</td>
        <!-- <td>: Mr. Nitin Agarwal</td> -->
        <td>: {{ $quotation->customer->contact_person_1_name??'Mr. Nitin Agarwal' }}</td>
    </tr>
    <tr>
        <td style="font-weight: bold;">Contact No.</td>
        <td>: +91 93544 80802</td>
    </tr>
    <tr>
        <td style="font-weight: bold;">E-Mail ID</td>
        <td>: {{ $quotation->customer->contact_person_1_email }}</td>
    </tr>
</table>

<!-- Submitted By -->
<table style="width: 90%; margin: 40px auto 10px auto; font-size: 15px; border-collapse: separate; border-spacing: 8px 10px;">
    <tr style="font-weight: bold;">
        <td>Submitted By</td>
        <td>Contact No.</td>
        <td>E-Mail ID</td>
    </tr>
    <tr>
        <td>{{ $quotation->user->name }}</td>
        <td>+91 89281 61634</td>
        <td>{{ $quotation->user->email }}</td>
    </tr>
</table>

</div>
   <div class="page-break">
      <h1 style="text-align: center; display: flex; justify-content:center; align-self: center;"> TABLE OF CONTENTS</h1>
      <div class="content" style="font-size: large;">
         <div style="border-top: 1px solid black; padding:15px 0px 15px 0px; display: flex; justify-content: space-between; position: relative;">
             <span>TECHNICAL DATA</span> <span style="position: absolute; right: 0;">3</span>
         </div >
         <div style="border-top: 1px solid black; padding:15px 0px 15px 0px; display: flex; justify-content: space-between;">
             <span>SPECIFICATION OF MIXTURE</span> <span style="position: absolute; right: 0;">4</span>
         </div>
         <div style="border-top: 1px solid black; padding:15px 0px 15px 0px; display: flex; justify-content: space-between;">
             <span>OFFER</span> <span style="position: absolute; right: 0;">7</span>
         </div>
         <div style="border-top: 1px solid black; padding:15px 0px 15px 0px; display: flex; justify-content: space-between; border-bottom:1px solid black;">
             <span>TERMS AND CONDITION</span> <span style="position: absolute; right: 0;">8</span>
         </div>
      </div>
   </div>
   <div class="page-break">
         <div class="technical-data">
               <h2 style="text-decoration: underline;">1 TECHNICAL DATA</h2>
         </div>
         <!-- DESING PARAMETER OF HIGH-SPEED -->
         <div class="details" style="position: relative; top:20px; left: 20px;">
           {{-- <h3>1.1 <span style="text-decoration: underline;">DESIGN PARAMETER OF HIGH-SPEED MIXTURE</span></h3> --}}
           <h3>1.1 <span style="text-decoration: underline;">DESIGN PARAMETER OF {{strtoupper($quotation->machine->name)}}</span></h3>
         </div>
         <table style="border-collapse: collapse; font-family: 'Bookman Old Style', serif; font-size: 16px; position: relative; top:20px; left: 40px;">
              <tr>
                <td style="padding: 8px;">• Model</td>
                {{-- <td style="padding: 8px;">: {{ $quotation->product->model??'' }}</td> --}}
                <td style="padding: 8px;">: {{ $quotation->modele->name??'' }}</td>
              </tr>
              <tr>
                <td style="padding: 8px;">• Product</td>
                <td style="padding: 8px;">: {{ $quotation->product->name??'' }}</td>
              </tr>
              <tr>
                <td style="padding: 8px;">• Material to Process</td>
                <td style="padding: 8px;">: {{ $quotation->product->material_to_process??'' }}</td>
              </tr>
              <tr>
                <td style="padding: 8px;">• Batch</td>
                <td style="padding: 8px;">:{{$quotation->product->batch_capcity??'40 Kgs'}}</td>
              </tr>
              <tr>
                <td style="padding: 8px;">• Mixing Tool</td>
                <td style="padding: 8px;">: {{ $quotation->prodcut->mixing_tool??'3 Tier Alloy Steel with Heat Treatment Process' }}</td>
              </tr>
            </table>

            <div class="details" style="position: relative; top:20px; left: 20px;">
              <h3>1.2 <span style="text-decoration: underline;">ELECTRICAL PARAMETERS</span></h3>
            </div>
            <table
              style="border-collapse: collapse; font-family: 'Bookman Old Style', serif; font-size: 16px; position: relative; top:20px; left: 40px;">
              <tr>
                <td style="padding: 8px;">• Motor Requirement</td>
                <td style="padding: 8px;">: {{ $quotation->product->motor_requirement }}</td>
                <!-- <td style="padding: 8px;">: 15 KW/20 HP Single Speed Mixer – 1440 RPM</td> -->
              </tr>
              <tr>
                <td style="padding: 8px;">• Voltage</td>
                <td style="padding: 8px;">: 415 V</td>
              </tr>
              <tr>
                <td style="padding: 8px;">• Frequency</td>
                <td style="padding: 8px;">: 50Hz</td>
              </tr>
              <tr>
              <td style="padding: 8px; white-space: nowrap; vertical-align: top;">• Control Panel</td>
              <td style="padding: 8px; text-align: left;">
                : Complete Electrical Control Panel Comprising of Thermocouple Wire Digital Temperature Indicator with Ammeter & Voltmeter, Limit Switch & MCCB Provided for Safety Precaution.
              </td>
              </tr>
              <tr>
                <td style="padding: 8px;">• Mixing Tool</td>
                <td style="padding: 8px;">: 3 Tier Alloy Steel</td>
              </tr>
            </table>
   </div>
   <div class="page-break">
         <div class="technical-data" style="margin-top: 20px;">
               <h2 style="text-decoration: underline;">2 &nbsp; &nbsp;<span style="text-decoration: underline;">TECHNICAL SPECIFICATION OF MIXTURE</span></h2>
         </div>
    
         <div class="details" style="position: relative; top:20px; left: 20px;">
           <h3>2.1 <span style="text-decoration: underline;">MIXING VESSEL</span></h3>
           <p style="margin-left: 25px; padding: 5px 15px 5px 5px; font-family: 'Bookman Old Style', serif; font-size: 16px;">
           Inside Made from SS – 304 Grade Plate and Outside Jacketed by Mild Steel Plate. Jacketed Construction Provided for Heating or Cooling with Suitable Media. Material Discharge Assembly is fitted at the Bottom, Operated by Pneumatic Cylinder.
           </p>
         </div>

         <div class="details" style="position: relative; top:20px; left: 20px;">
           <h3>2.2 <span style="text-decoration: underline;">MIXING VESSEL LID</span></h3>
           <h3 style="padding: 5px 5px 0px 35px;">• MATERIAL:</h3>
           <p style="margin-left: 40px; font-family: 'Bookman Old Style', serif; font-size: 16px; line-height: 1.6;">
            Stainless steel - 304 grades.<br/>
            Equipped with gasket, on lid edge and with lid locking arrangement. The lid is
            fitted with the Followings flanged openings<br/>
            1. One for fitting arrangements for deflector and thermocouple.<br/>
            2. One for addition of chemicals.<br/>
           </p>
           <h3 style="padding: 5px 5px 0px 35px;">• DEFlECTOR:</h3>
           <p style="margin-left: 40px; font-family: 'Bookman Old Style', serif; font-size: 16px; line-height: 1.6;">
           Made up of Stainless Steel – 304 grades or Alloy steel Equipped with Thermocouple Wire for Temperature Measurement. Installed with provision of Varying Angle and Height to Ensure Maximum Material Circulation.
           </p>
           <h3 style="padding: 5px 5px 0px 35px;">• DISCHARGE VALVE:</h3>
           <p style="margin-left: 40px; font-family: 'Bookman Old Style', serif; font-size: 16px; line-height: 1.6;">
            Made Up of SS 304 Provider with Gasket
           </p>
           <h3 style="padding: 5px 5px 0px 35px;">• MIXING TOOL:</h3>
           <p style="margin-left: 40px; font-family: 'Bookman Old Style', serif; font-size: 16px; line-height: 1.6;">
           STAINLESSSTEEL: 304 GRADES. OR ALLOY STEEL<br/>
           Consisting three blades – Bottom scraper, Fluidizing blade and Horn Shaped Blade. Specially Designed Shape and Angle Suitable for your Compound with Height adjustment. Spacers with wear resistance treatment.

           </p>
         </div>
   </div>
   <div class="page-break">
        <h3 style="padding: 5px 5px 0px 35px;">• BEARING HOUSING:</h3>
           <p style="margin-left: 40px; font-family: 'Bookman Old Style', serif; font-size: 16px; line-height: 1.6;">
           Mixing Vessel fitted on Steel Plates and Bearing Housing fitted on Steel Plates with Heavy Duty Bearings with Water Cooling and Greasing Arrangements. The resin Leakage to Bearings is Prevented by our Special Design.
           </p>
          <h3 style="padding: 5px 5px 0px 35px;">• SHAFT:</h3>
           <p style="margin-left: 40px; font-family: 'Bookman Old Style', serif; font-size: 16px; line-height: 1.6;">
           Shaft is Specially Manufactured from Alloy Steel, Hardened and Ground.
           </p>
           <h3 style="padding: 5px 5px 0px 35px;">• MOTOR:</h3>
           <p style="margin-left: 40px; font-family: 'Bookman Old Style', serif; font-size: 16px; line-height: 1.6;">
              <b>Make: </b>HINDUSTAN, 1440 R.P.M., AC Motor Drives The Main Shaft.<br/>
             <b>Transmission:</b>Through “V” – belt and Pulley Arrangement.
           </p>
           <h3 style="padding: 5px 5px 0px 35px;">• PULLEY:</h3>
           <p style="margin-left: 40px; font-family: 'Bookman Old Style', serif; font-size: 16px; line-height: 1.6;">
              <b>Type: </b>Taper Lock<br/>
           </p>
           <h3 style="padding: 5px 5px 0px 35px;">• ELECTRICAL CONTROL:</h3>
           <p style="margin-left: 40px; font-family: 'Bookman Old Style', serif; font-size: 16px; line-height: 1.6;">
              <b>Make: </b>Abb / L & T Siemens<br/>
           </p>
           <h3 style="padding: 5px 5px 0px 35px;">• AC FREQUENCY DRIVE:</h3>
           <p style="margin-left: 40px; font-family: 'Bookman Old Style', serif; font-size: 16px; line-height: 1.6;">
              <b>Make: </b>Yashikawa<br/>
           </p>
           <h3 style="padding: 5px 5px 0px 35px;">• BEARING:</h3>
           <p style="margin-left: 40px; font-family: 'Bookman Old Style', serif; font-size: 16px; line-height: 1.6;">
              <b>Make: </b>ZKL / FAG / SKF<br/>
           </p>
           <h3 style="padding: 5px 5px 0px 35px;">• PNEUMATIC:</h3>
           <p style="margin-left: 40px; font-family: 'Bookman Old Style', serif; font-size: 16px; line-height: 1.6;">
              <b>Make: </b>Janatics / Spac<br/>
           </p>
   </div>
   <div class="page-break" style="page-break-before: always; font-family: 'Bookman Old Style', serif; width: 100%;">

<!-- Wrapper to center the content -->
<div style="width: 90%; margin: 0 auto;">

    <!-- Section Title -->
    <div class="technical-data" style="margin-top: 40px; text-align: center;">
        <h2 style="text-decoration: underline; font-size: 20px;">
            2 &nbsp;&nbsp; OFFER
        </h2>
    </div>

    <!-- Table -->
    <table border="1" style="border-collapse: collapse; width: 100%; font-size: 15px; margin-top: 20px;">
        <thead>
            <tr style="font-weight: bold; text-align: center; background-color: #f9f9f9;">
                <th style="width: 7%; padding: 10px;">Sr. No.</th>
                <th style="width: 53%; padding: 10px;">PARTICULAR</th>
                <th style="width: 10%; padding: 10px;">Qty</th>
                <th style="width: 15%; padding: 10px;">Unit Price</th>
                <th style="width: 15%; padding: 10px;">Ex Work Price In Rs.</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center; vertical-align: top; padding: 10px;">1</td>
                <td style="padding: 10px; line-height: 1.5;">
                    {{-- HIGH SPEED MIXER MODEL CHM – 500 <br> --}}
                   {{strtoupper($quotation->machine->name)}} MODEL CHM – {{$quotation->modele->name}} <br>
                    ALONG WITH AC FREQUENCY DRIVE <br>
                    ELECTRICAL PANEL
                </td>
                <td style="text-align: center; vertical-align: top; padding: 10px;">
                    {{ $quotation->quantity ?? '' }} Nos.
                </td>
                <td style="text-align: center; vertical-align: top; padding: 10px;">
                    {{ $quotation->product->price }}
                </td>
                <td style="text-align: center; vertical-align: top; padding: 10px;">
                    {{ number_format($quotation->quantity * $quotation->product->price, 2) }}
                </td>
            </tr>

            <!-- Total Row -->
            <tr>
                <td colspan="4" style="font-weight: bold; text-align: center; padding: 10px;">
                    <!-- RUPEES XXXXXXXXXXXXX ONLY -->
                     {{ strtoupper($words) }} ONLY
                </td>
                <td style="font-weight: bold; text-align: center; padding: 10px;">
                    {{ number_format($quotation->quantity * $quotation->product->price, 2) }}
                </td>
            </tr>
        </tbody>
    </table>

</div>
</div>

   <div class="page-break">
        <div class="technical-data" style="margin-top: 20px;">
               <h2 style="text-decoration: underline;">4 &nbsp; &nbsp;<span style="text-decoration: underline;">TERM AND CONDITION</span></h2>
         </div>
         <table border="1" style="border-collapse: collapse; width: 100%; font-family: 'Bookman Old Style', serif; font-size: 15px;">
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

</body>
</html>

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