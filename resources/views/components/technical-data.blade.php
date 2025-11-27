<style>
/* General Table Styling */
        .parameter-table-t {
            border-collapse: collapse;
            font-size: 14px;
            width: 90%;
            line-height: 1;
            margin: 0 5px 15px 2px;
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
            table-layout: auto;  /* Allow cells to adjust according to content */
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


<div class="page-break">
    <div class="techincal-data parameter-table-t">
        <h2 style="text-decoration: underline; font-weight: bold;">1. TECHNICAL DATA</h2>

        <!-- DESIGN PARAMETER -->
        <div class="parameter-heading">
            <h3 style="font-weight: bold;">1.1 DESIGN PARAMETER OF {{ strtoupper($quotation->machine->name) }} </h3>
        </div>

        <table class="parameter-table">
            <tr><td>• &nbsp; Model</td><td class="value-cell">{{ $quotation->modele->name ?? '' }} </td></tr>
            <tr><td>• &nbsp; Product</td><td class="value-cell">{{ $quotation->application->name ?? '' }} Compound</td></tr>

            @if(isset($quotation->material_to_process))
                <tr><td>• &nbsp; Material to Process</td><td class="value-cell">{{ $quotation->materialToProcess->material_to_process ?? '' }}</td></tr>
            @endif

            <tr><td>• &nbsp; Batch</td><td class="value-cell">{{ $quotation->batch->batches ?? '' }} Kgs</td></tr>

            @if(isset($quotation->contact_part))
                <tr><td>• &nbsp; Contact Part</td><td class="value-cell">{{ $quotation->contact_part }}</td></tr>
            @endif

            @if(isset($quotation->water_pressure))
                <tr><td>• &nbsp; Water Pressure</td><td class="value-cell">{{ $quotation->water_pressure }} Kgs</td></tr>
            @endif

            @if(isset($quotation->operating_pressure))
                <tr><td>• &nbsp; Operating Pressure</td><td class="value-cell">{{ $quotation->operating_pressure }} Kgs</td></tr>
            @endif

            @if(isset($quotation->cooling_water_inlet_temperature))
                <tr><td>• &nbsp; Cooling Water Inlet Temperature</td><td class="value-cell">{{ $quotation->cooling_water_inlet_temperature }} °C</td></tr>
            @endif

            @if(isset($quotation->cooling_water_flow_rate))
                <tr><td>• &nbsp; Cooling Water Flow Rate</td><td class="value-cell">{{ $quotation->cooling_water_flow_rate }} LPM</td></tr>
            @endif

            @if(isset($quotation->feeding_air_pressure))
                <tr><td>• &nbsp; Feeding Air Pressure</td><td class="value-cell">{{ $quotation->feeding_air_pressure }} Bar</td></tr>
            @endif
        </table>

        <!-- ELECTRICAL PARAMETERS -->
        <div class="parameter-heading">
            <h3 style="font-weight: bold;">1.2 ELECTRICAL PARAMETERS</h3>
        </div>

        <table class="parameter-table">
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
            <tr>
                <td>• &nbsp; Mixing Tool</td>
                <td class="value-cell">3 Tier Alloy Steel</td>
            </tr>
        </table>
    </div>
</div>





<div class="page-break">
    <div class="techincal-data parameter-table-t">
             <div class="parameter-heading">
            <h3 style="font-weight: bolder;">1.3 Transmission</h3>
        </div>

        <table class="parameter-table">
            <tr>
                <td>• &nbsp; Gear Box</td>
                <td class="value-cell">Heli Bevel Gear Box of Elecon Make</td>
            </tr>
            <tr>
                <td>• &nbsp; Coupling</td>
                <td class="value-cell">Coupling is used for Higher Torque and for Gear Box Safety</td>
            </tr>
        </table>
    </div>
</div>

