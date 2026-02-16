<x-header-footer-pdf />
<x-client-pdf-template :quotation="$quotation" />

{{--

<div class="page-break ">
    <div class="techincal-data parameter-table">
        <h2 style="text-decoration: underline">1. TECHNICAL DATA</h2>
        <!-- DESING PARAMETER OF HIGH-SPEED -->
        <div class="technical-data-sub-head" style="text-align:left; width: 95%;">
            <h3>1.1 <span style="">DESIGN PARAMETER OF {{strtoupper($quotation->machine->name)}}</span></h3>
        </div>
        <table class="parameter-table"
            style="border-collapse: collapse; font-size: 14px; position: relative; left: 40px; width: 90%; line-height: 0.8;">
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Model</td>
                <td style="padding: 8px;">:&nbsp;{{ $quotation->modele->name ?? '' }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Product</td>
                <td style="padding: 8px;">:&nbsp;{{ $quotation->application->name ?? '' }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Material to process</td>
                <td style="padding: 8px;">:&nbsp; {{ $quotation->materialToProcess->material_to_process ?? '' }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Batch</td>
                <td style="padding: 8px;">:&nbsp;{{ $quotation->batch->batches ?? '' }}Kg </td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Mixing Tool</td>
                <td style="padding: 8px;">:&nbsp;{{ $quotation->mixingTool->mixing_tool ?? 'N.A' }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp;Contact Part</td>
                <td style="padding: 8px;">:&nbsp; {{ $quotation->contact_part }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp;Water Pressure</td>
                <td style="padding: 8px;">:&nbsp;{{ $quotation->water_pressure ?? '' }} Bar</td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp;Operating Pressure</td>
                <td style="padding: 8px;">:&nbsp;{{ $quotation->operating_pressure ?? '' }} Bar</td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp;Cooling Water Inlet
                    Temperature</td>
                <td style="padding: 8px;">:&nbsp;{{ $quotation->operating_pressure ?? '' }} Bar</td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp;Cooling Water Flow Rate</td>
                <td style="padding: 8px;">:&nbsp;{{ $quotation->cooling_water_flow_rate ?? '' }}m3/hr</td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp;Feeding Air Pressure</td>
                <td style="padding: 8px;">:&nbsp;{{ $quotation->feeding_air_pressure ?? '' }}m3/hr</td>
            </tr>
        </table>


        <div class="technical-data-sub-head" style="text-align: left;width: 95%;">
            <h3>1.2 <span style="">ELECTRICAL PARAMETERS</span></h3>
        </div>
        <table class="parameter-table"
            style="border-collapse: collapse; font-size: 14px; position: relative; left: 40px; width: 90%; line-height: 0.8;">
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Motor Requirement</td>
                
                <td style="padding: 8px;">:&nbsp;{{$quotation->motorRequirement->motor_requirement}}</td>
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
                    :&nbsp;Complete Electrical Control Panel comprising of Suitable Ammeter & Voltmeter, Limit Switch &  MCCB provided for safety precaution.
                </td>
            </tr>
        </table>

    </div>
</div>

<div class="page-break ">
    <div class="techincal-data parameter-table">

        <!-- DESING PARAMETER OF HIGH-SPEED -->
        <div class="technical-data-sub-head" style="text-align:left; width: 95%;">

            <h3>1.3 <span style="">Transmission {{strtoupper($quotation->machine->name)}}</span></h3>
        </div>
        <table class="parameter-table"
            style="border-collapse: collapse; font-size: 14px; position: relative; left: 40px; width: 90%; line-height: 0.5;">
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Gear Box</td>
                <td style="padding: 8px;">:&nbsp; Heli Bevel Gear Box of Elecon Make
                </td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Coupling</td>
                <td style="padding: 8px;">:&nbsp;Coupling is used for Higher Torque and for Gear  Box Safety.
                </td>
            </tr>
        </table>

    </div>
</div>--}}
<!-- start  -->
  <style>
/* General Table Styling */
        .parameter-table-t {
            border-collapse: collapse;
            font-size: 14px;
            width: 90%;
            line-height: 1;
            margin: 0 5px 15px 2px;
            padding-bottom:25px; 
        }

        .parameter-table-t td {
            padding: 4px;
            vertical-align: top;
            word-wrap: break-word; /* Allow long words to break and wrap onto the next line */
            word-break: break-word; /* Prevent overflow of long words */
        }

        .parameter-table-t .value-cell::before {
            content: ": ";
        }

        .parameter-heading {
            /* text-align: left;
            width: 95%;
            margin-bottom: 10px;
            margin-top: 20px;
            margin-left:20px;  */
            /* text-decoration: underline; */
        }
        .parameter-heading h3{
            padding: 6px 0px 6px 15px;
            /* background-color: #2daae3; */
            /* border-radius: 15px; */
            /* color: white; */
            color: black;
            font-size: small;
            text-decoration: underline;
        }

        /* Make the table layout auto to allow dynamic width for content */
        .parameter-table {
            width: 100%;
            table-layout: auto;  /* Allow cells to adjust according to content */
            margin-left: 20px;
        }

        /* Optional: Improve readability by increasing row height for better spacing */
        .parameter-table td {
            height: 30px;  /* Adjust row height */
        }

        /* Page Break Styling */
        .page-break {
            page-break-before: always;
        }

        /* Heading Style */
        h2, h3 {
            margin: 0;
            /* font-size: 16px; */
            font-weight: normal;
        }

        h2 {
            text-decoration: underline;
        }

        /* Optional: Ensure long words and large texts wrap properly */
        .value-cell {
            white-space: normal; /* Allow text to break and wrap properly */
        }
   /* .techincal-data {
      position: absolute;
      top: 115px;
    } */
</style>
<x-table-content :specification="'MIXER'" :pageTechnicalData="4" :pageSpecification="6" :pageOffer="8" :pageTerms="9" />
@php
$modelName=$quotation->modele->name;
$parts = explode('/', $modelName);

// Trim each part to remove extra whitespace
$firstPart = trim($parts[0]);
$secondPart = trim($parts[1]);
@endphp


<div class="page-break" style="margin-left:-12px;">
    <div class="techincal-data parameter-table-t" style="padding-top:4px; ">
        <h2 style="font-weight: bolder; font-size: 24px;" >1. TECHNICAL DATA</h2>

        <!-- DESIGN PARAMETER -->
        <div class="parameter-heading"  style="text-align:left; width: 95%; padding:40px 0 15px 0; text-size:16px">
            <h3 style="font-weight: bold;">1.1 <span> DESIGN PARAMETER OF HIGH SPEED HEATER </h3>
        </div>

        <table class="parameter-table" style="padding:5px 0 0 25px">
            <tr><td>• &nbsp; Model</td><td class="value-cell">{{ $firstPart }}</td></tr>
            <tr><td>• &nbsp; Product</td><td class="value-cell">{{ $quotation->application->name ?? '' }} </td></tr>

            @if(isset($quotation->material_to_process))
                <tr><td>• &nbsp; Material to Process</td><td class="value-cell">{{ $quotation->materialToProcess->material_to_process ?? '' }}</td></tr>
            @endif
            <tr><td>• &nbsp; Batch</td><td class="value-cell">{{ $quotation->batch->batches ?? '' }} Kgs</td></tr>   

            @if(isset($quotation->mixing_tool_id))
                <tr><td>• &nbsp; Mixing Tool</td><td class="value-cell">{{ $quotation->mixingTool->mixing_tool ?? '' }}</td></tr>
            @endif
        </table>

        <!-- ELECTRICAL PARAMETERS -->
        <div class="parameter-heading" style="text-align:left; width: 95%;">
            <h3 style="font-weight: bolder;">1.2 ELECTRICAL PARAMETERS</h3>
        </div>

        <table class="parameter-table"  style="padding:5px 0 0 25px">
            <tr>
                <td>• &nbsp; Motor Requirement</td>
                <td class="value-cell">{{ $quotation->motorRequirement->motor_requirement ?? '' }}</td>
            </tr>
            <tr>
                <td>• &nbsp; Voltage</td>
                <td class="value-cell">415 V</td>
            </tr>
            <tr>
                <td>• &nbsp; Frequency</td>
                <td class="value-cell">50Hz</td>
            </tr>
            <tr>
                <td>• &nbsp; Control Panel</td>
                <td class="value-cell">
                    Complete Electrical Control Panel comprising of Thermocouple Wire, Digital Temperature Indicator with Ammeter & Voltmeter, Limit Switch & MCCB provided for safety precaution.
                </td>
            </tr>
        </table>
    </div>
</div>

<div class="page-break" style="margin-left:-12px;">
    <div class="techincal-data parameter-table-t">
        <div class="parameter-heading" style="text-align:left; width: 95%; padding:40px 0 15px 0; text-size:16px">
            <h3 style="font-weight: bolder;">1.3 DESIGN PARAMETER OF VERTICAL COOLER MIXER</h3>
        </div>

        <table class="parameter-table"  style="padding:5px 0 0 25px">
            <tr><td>• &nbsp; Model</td><td class="value-cell">{{ $secondPart }}</td></tr>
            <tr><td>• &nbsp; Product</td><td class="value-cell">{{ $quotation->application->name ?? '' }} Compound</td></tr>
            <tr><td>• &nbsp; Batch Size</td><td class="value-cell">{{ $quotation->batche2->batches??'' }}Kg  </td></tr>
            <tr><td>• &nbsp; Contact Part</td><td class="value-cell">{{ $quotation->contact_part??' ' }}  </td></tr>
            <tr><td>• &nbsp; Water Pressure</td><td class="value-cell">{{ $quotation->water_pressure??' ' }} Bar </td></tr>
            <tr><td>• &nbsp; Cooling Water Inlet Temperature</td><td class="value-cell">{{ $quotation->cooling_water_inlet_temperature??'' }}  </td></tr>
            <tr><td>• &nbsp; Cooling Water Flow Rate</td><td class="value-cell">{{ $quotation->cooling_water_flow_rate??'' }} m3/h  </td></tr>
            <tr><td>• &nbsp; Feeding Air Pressure</td><td class="value-cell">{{ $quotation->feeding_air_pressure??'' }} Bar </td></tr>
        </table>

        <!-- ELECTRICAL PARAMETERS -->
        <div class="parameter-heading" style="text-align:left; width: 95%; padding:40px 0 15px 0; text-size:16px">
            <h3 style="font-weight: bolder;">1.4 ELECTRICAL PARAMETERS</h3>
        </div>

        <table class="parameter-table"  style="padding:5px 0 0 25px">
            <tr>
                <td>• &nbsp; Motor Requirement</td>
                <td class="value-cell">{{ $quotation->motorRequirement2->motor_requirement ?? '' }}</td>
            </tr>
            <tr>
                <td>• &nbsp; Voltage</td>
                <td class="value-cell">415 V</td>
            </tr>
            <tr>
                <td>• &nbsp; Frequency</td>
                <td class="value-cell">50Hz</td>
            </tr>
            <tr>
                <td>• &nbsp; Control Panel</td>
                <td class="value-cell">
                    Complete Electrical Control Panel comprising of Thermocouple Wire, Digital Temperature Indicator with Ammeter & Voltmeter, Limit Switch & MCCB provided for safety precaution.
                </td>
            </tr>
        </table>
    </div>
</div>

<div class="page-break" style="margin-left:-12px;">
    <div class="techincal-data parameter-table-t" style="text-align:left; width: 95%; padding:40px 0 15px 0; text-size:16px">
        <div class="parameter-heading">
            <h3 style="font-weight: bolder;">1.5 TRANSMISSION</h3>
        </div>

        <table class="parameter-table"  style="padding:5px 0 0 25px">
            <tr>
                <td>• &nbsp; Gear Box</td>
                <td class="value-cell">Speed reduction Gear box is provided Heli Bevel Type</td>
            </tr>
      
            <tr>
                <td>• &nbsp; Coupling </td>
                <td class="value-cell">Coupling is used for Higher Torque for Gear Box Safety</td>
            </tr>
        </table>
    </div>
</div>

<!-- end -->
@php
    $mixerSpecs = [
        [
            'title' => 'Vessel (Heater & Cooler)',
            'description' => ' Inside Made from SS – 304 Grade Plate and Outside Jacketed by Mild Steel Plate.   Jacketed Construction Provided for Heating or Cooling with Suitable Media. Material Discharge Assembly is fitted at the Bottom, Operated by Pneumatic Cylinder. Cooling Ring MOC – 304 Grade.'
        ],
        [
            'title' => 'Lid',
            'description' => 'Stainless steel - 304 grades. <br/> 
                             Equipped with gasket, on lid edge and with lid locking arrangement. The lid is fitted with the Followings flanged openings <br/>
                             1. One for fitting arrangements for  Deflector and thermocouple .<br />
                             2. One for addition of chemicals . <br />
                             '
                             //3. Two for viewing glasses, operated pneumatically.  <br />
        ],
        [
            'title' => 'Defelector',
            'description' => 'Made up of Stainless Steel – 304 grades or Alloy steel Equipped with Thermocouple Wire for    Temperature Measurement. Installed with provision of Varying Angle and Height to Ensure Maximum Material Circulation '
        ],
        [
            'title' => 'Discharge Valve',
            'description' => 'Made Up of SS 304 Provided with Gasket   & Operated Pneumatically'
        ],
        [
          'title'=>'Shaft',
          'description'=>'Shaft is Specially Manufactured from Alloy Steel, Hardened and Ground.'
        ],


        // Add more items as needed
    ];



     $mixerSpecs2 = [
        [
         'title'=>'Mixing Tool',
         'description'=>'Specially Designed Shape and Angle Suitable for your Compound with Height adjustment. Spacers with wear resistance treatment. Cooler Mixer Blade Made from STAINLESSSTEEL: 304 specially designed shovel type'
        ],

        [
         'title'=>'Bearing Housing',
         'description'=>'Mixing Vessel fitted on Steel Plates and Bearing Housing fitted on Steel Plates with Heavy Duty Bearings with Water Cooling and Greasing Arrangements. The resin Leakage to Bearings is Prevented by our Special Design.'
        ],

        [
         'title'=>'Motor',
          'description' => ($quotation->makeMotor?->name ?? '') . ' Motor 1440 R.P.M AC Motor Drive Transmission Through “V” – belt and Pulley Arrangement.'
        ],
        ],
        [
         'title'=>'Driving System',
         'description'=>'The drive system incorporates with V-belt and tapper lock pulley (SPC type) to give Efficient power drive transmission. The Belts  Are Tightened by means of motor sliding screw.'
        ],

        [
         'title'=>'Mounting Structure',
         'description'=>' Sturdy MS Channel from Duly Covered with MS Sheet and Coated with Water resistant enamel   Coating Painting.'
        ],
        [
         'title'=>'Electrical Control',
         'description'=> $quotation->electricalControl->electrical_control??''
        ],
        [
         'title'=>'AC Frequency Drive',
         'description'=>'Yaskawa Make',
        ],
        [
            'title' => 'Bearing',
            'description' =>  $quotation->bearinge->bearing ??''
        ],
        [
            'title' => 'Pneumatic Control',
            'description' =>$quotation->pneumatic->pneumatic??''
        ],
    
    ];
@endphp

<x-technical-specification-one   :items="$mixerSpecs" />
<x-technical-specification-two  :items="$mixerSpecs2" />



<x-offer :quotation="$quotation" :words="$words" />
<x-term-and-condition-pdf :termCondition="$termCondition" />