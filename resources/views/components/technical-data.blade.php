<style>
        .value-cell {
        padding: 8px;
    }

    .value-cell::before {
        content: ": ";
    }
</style>
<div class="page-break" >
    <div class="techincal-data parameter-table techincal-specification">
        <h2 style="text-decoration: underline">1. TECHNICAL DATA</h2>

        <!-- DESIGN PARAMETER -->
         <div class="technical-data-sub-head"
            style="text-align:left; width: 95%; font-family: bolder; text-decoration: underline;">
            <h3 style="font-weight: bold;">1.1 DESIGN PARAMETER OF {{ strtoupper($quotation->machine->name) }} </h3>
        </div>

         <table class="parameter-table"
            style="border-collapse: collapse; font-size: 14px; position: relative; left: 40px; width: 100%; line-height: 1.1;">
            <tr><td style="padding: 8px; vertical-align: top; white-space: nowrap; width: 55%;">• &nbsp; Model</td><td class="value-cell">{{ $quotation->modele->name ?? '' }} </td></tr>
            <tr><td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Product</td><td class="value-cell">{{ $quotation->application->name ?? '' }} Compound</td></tr>

            @if(isset($quotation->material_to_process))
                <tr><td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Material to Process</td><td class="value-cell">{{ $quotation->materialToProcess->material_to_process ?? '' }}</td></tr>
            @endif

            <tr><td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Batch</td><td class="value-cell">{{ $quotation->batch->batches ?? '' }} Kgs</td></tr>

            @if(isset($quotation->contact_part))
                <tr><td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Contact Part</td><td class="value-cell">{{ $quotation->contact_part }}</td></tr>
            @endif

            @if(isset($quotation->water_pressure))
                <tr><td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Water Pressure</td><td class="value-cell">{{ $quotation->water_pressure }} Kgs</td></tr>
            @endif

            @if(isset($quotation->operating_pressure))
                <tr><td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Operating Pressure</td><td class="value-cell">{{ $quotation->operating_pressure }} Kgs</td></tr>
            @endif

            @if(isset($quotation->cooling_water_inlet_temperature))
                <tr><td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Cooling Water Inlet Temperature</td><td class="value-cell">{{ $quotation->cooling_water_inlet_temperature }} °C</td></tr>
            @endif

            @if(isset($quotation->cooling_water_flow_rate))
                <tr><td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Cooling Water Flow Rate</td><td class="value-cell">{{ $quotation->cooling_water_flow_rate }} LPM</td></tr>
            @endif

            @if(isset($quotation->feeding_air_pressure))
                <tr><td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Feeding Air Pressure</td><td class="value-cell">{{ $quotation->feeding_air_pressure }} Bar</td></tr>
            @endif
        </table>

        <!-- ELECTRICAL PARAMETERS -->
       <div class="technical-data-sub-head" style="text-align: left;width: 95%;">
            <h3 style="font-weight: bold;">1.2 ELECTRICAL PARAMETERS</h3>
        </div>

    <table class="parameter-table"
            style="border-collapse: collapse; font-size: 14px; position: relative; left: 40px; width: 100%; line-height: 1.1;">
            <tr>
                <td  style="padding: 8px; vertical-align: top; white-space: nowrap; width: 55%;">• &nbsp; Motor Requirement</td>
                <td class="value-cell">{{ $quotation->motorRequirement->motor_requirement ?? '' }}</td>
            </tr>
            <tr>
                <td  style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Voltage</td>
                <td class="value-cell">415 V</td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Frequency</td>
                <td class="value-cell">50Hz</td>
            </tr>
        </table>
    </div>
</div>




<div class="page-break"  style="page-break-before: always; width: 100%;" >
    <div class="techincal-data parameter-table techincal-specification">
        <table class="parameter-table"
            style="border-collapse: collapse; font-size: 14px; position: relative; left: 40px;top:60px; width: 100%; line-height: 1.1;">
           <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;width:55%">• &nbsp; Control Panel</td>
                <td class="value-cell">
                    Complete Electrical Control Panel comprising of Thermocouple Wire, Digital Temperature Indicator with Ammeter & Voltmeter, Limit Switch & MCCB provided for safety precaution.
                </td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Mixing Tool</td>
                <td class="value-cell">3 Tier Alloy Steel</td>
            </tr>
        </table>
        <h2></h2>
         <div class="technical-data-sub-head" style="text-align: left;width: 95%; margin-top:40px;">
            <h3 style="font-weight: bold;">1.3  TRANSMISSION </h3>
         </div>

        <table class="parameter-table"
            style="border-collapse: collapse; font-size: 14px; position: relative; left: 40px; width: 100%; line-height: 1.1;">
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap; width: 55%;">• &nbsp; Gear Box</td>
                <td class="value-cell">Heli Bevel Gear Box of Elecon Make</td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;"> • &nbsp; Coupling</td>
                <td class="value-cell">Coupling is used for Higher Torque and for Gear Box Safety</td>
            </tr>
        </table>
    </div>
</div>

