<style>
/* General Table Styling */
        .parameter-table-t {
            border-collapse: collapse;
            font-size: 14px;
            width: 90%;
            line-height: 1;
            margin: 0 5px 5px 2px;
            table-layout: fixed;
        }

        .parameter-table-t td {
            padding: 2px;
            vertical-align: top;
            word-wrap: break-word; /* Allow long words to break and wrap onto the next line */
            word-break: break-word; /* Prevent overflow of long words */
        }

        .parameter-table-t .value-cell::before {
            content: ": ";
        }

        .parameter-heading {
            text-align: left;
            width: 95%;
            margin-bottom: 10px;
            margin-top: 20px;
            margin-left:20px; 
            text-decoration: underline;
        }

        /* Make the table layout auto to allow dynamic width for content */
        .parameter-table {
            width: 100%;
            table-layout: auto; 
            margin-left: 30px;
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
@php
$modelName=$quotation->modele->name;
$parts = explode('/', $modelName);

// Trim each part to remove extra whitespace
$firstPart = trim($parts[0]);
$secondPart = trim($parts[1]);

$capacity=explode(' ',$secondPart);
array_shift($capacity);
array_pop($capacity);
$capacity=implode(' ',$capacity);
@endphp


<div class="page-break" style="margin-left:-12px;">
    <div class="techincal-data parameter-table-t">
        <h2 style="font-weight: bolder; font-size: 24px;" >1. TECHNICAL DATA</h2>

        <!-- DESIGN PARAMETER -->
        <div class="parameter-heading" style="text-align:left; width: 95%; padding:40px 0 15px 0; text-size:16px">
            <h3 style="font-weight: bold;">1.1 DESIGN PARAMETER OF HIGH SPEED HEATER </h3>
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

        <table class="parameter-table" style="padding:5px 0 0 25px">
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
        <div class="parameter-heading" style="text-align:left; width: 95%; padding:20px 0 15px 0; text-size:16px">
            <h3 style="font-weight: bolder;">1.3 DESIGN PARAMETER OF HORIZONTAL COOLER MIXER</h3>
        </div>

        <table class="parameter-table" style="padding:5px 0 0 25px">
            <tr><td>• &nbsp; Model</td><td class="value-cell">{{ $secondPart }} </td></tr>
            <tr><td>• &nbsp; Product</td><td class="value-cell">{{ $quotation->application->name ?? '' }} Compound</td></tr>
            <tr><td>• &nbsp; Total Capacity</td><td class="value-cell">{{ $capacity }} Ltr  </td></tr>
            <tr><td>• &nbsp; Useful Volume</td><td class="value-cell">{{$capacity - (($capacity*3)/10) }} Ltr  </td></tr>
            <tr><td>• &nbsp; Batch Size</td><td class="value-cell">{{ $quotation->batche2->batches??'' }}Kg( 4 Batch/Hr )  </td></tr>
            <tr><td>• &nbsp; Contact Part</td><td class="value-cell">{{ $quotation->contact_part??' ' }}  </td></tr>
            <tr><td>• &nbsp; Water Pressure</td><td class="value-cell">{{ $quotation->water_pressure??' ' }} Bar </td></tr>
            <tr><td>• &nbsp; Cooling Water Inlet Temperature</td><td class="value-cell">{{ $quotation->cooling_water_inlet_temperature??'' }}  </td></tr>
            <tr><td>• &nbsp; Cooling Water Flow Rate</td><td class="value-cell">{{ $quotation->cooling_water_flow_rate??'' }} m3/h  </td></tr>
            <tr><td>• &nbsp; Feeding Air Pressure</td><td class="value-cell">{{ $quotation->feeding_air_pressure??'' }} Bar </td></tr>
            <tr><td>• &nbsp; Compressed Air Consumption</td><td class="value-cell"> {{ $quotation->compress_air_consumption??'' }} Nm3/h</td></tr>
        </table>

        <!-- ELECTRICAL PARAMETERS -->
        <div class="parameter-heading" style="text-align:left; width: 95%; padding:20px 0 15px 0; text-size:16px">
            <h3 style="font-weight: bolder;">1.4 ELECTRICAL PARAMETERS</h3>
        </div>

        <table class="parameter-table-t" style="padding:0 0 0 25px">
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

        <table class="parameter-table" style="padding:5px 0 0 25px">
            <tr>
                <td>• &nbsp; Gear Box</td>
                <td class="value-cell">Speed reduction Gear box is provided Heli Bevel Type</td>
            </tr>
            <tr>
                <td>• &nbsp; Gear Box Make</td>
                <td class="value-cell">Elecon (PBL)</td>
            </tr>
            <tr>
                <td>• &nbsp; Coupling </td>
                <td class="value-cell">Coupling is used for Higher Torque for Gear Box Safety</td>
            </tr>
            <tr>
                <td>• &nbsp; Coupling Make</td>
                <td class="value-cell">Fenner</td>
            </tr>
        </table>
    </div>
</div>
