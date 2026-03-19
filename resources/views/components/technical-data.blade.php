<style>
        /* .value-cell {
        padding: 8px;
    } */

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
            style="border-collapse: collapse; font-size: 14px; position: relative; left: 40px; width: 95%; line-height: 1;">
            <tr><td style="padding: 8px; vertical-align: top; white-space: nowrap; width: 55%;">• &nbsp; Model</td><td class="value-cell"> <span style="position: relative;left:4px;">{{ $quotation->modele->name ?? '' }}</span> </td></tr>
            <tr><td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Product</td><td class="value-cell"> <span style="position: relative;left:4px;">{{ $quotation->application->name ?? '' }} Compound</span></td></tr>

            @if(isset($quotation->material_to_process))
                <tr><td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Material to Process</td><td class="value-cell"> <span style="position: relative;left:4px;">{{ $quotation->materialToProcess->material_to_process ?? '' }}</span></td></tr>
            @endif

            <tr><td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Batch</td><td class="value-cell"> <span style="position: relative;left:4px;">{{ $quotation->batch->batches ?? '' }} Kgs</span></td></tr>

            @if(isset($quotation->contact_part))
                <tr><td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Contact Part</td><td class="value-cell"> <span style="position: relative;left:4px;">{{ $quotation->contact_part }}</span></td></tr>
            @endif

            @if(isset($quotation->water_pressure))
                <tr><td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Water Pressure</td><td class="value-cell"> <span style="position: relative;left:4px;">{{ $quotation->water_pressure }} Kgs</span></td></tr>
            @endif

            @if(isset($quotation->operating_pressure))
                <tr><td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Operating Pressure</td><td class="value-cell"> <span style="position: relative;left:4px;">{{ $quotation->operating_pressure }} Kgs</span></td></tr>
            @endif

            @if(isset($quotation->cooling_water_inlet_temperature))
                <tr><td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Cooling Water Inlet Temperature</td><td class="value-cell"> <span style="position: relative;left:4px;">{{ $quotation->cooling_water_inlet_temperature }} Max</span></td></tr>
            @endif

            @if(isset($quotation->cooling_water_flow_rate))
                <tr><td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Cooling Water Flow Rate</td><td class="value-cell"> <span style="position: relative;left:4px;">{{ $quotation->cooling_water_flow_rate }} m3/hr</span></td></tr>
            @endif

            @if(isset($quotation->feeding_air_pressure))
                <tr><td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Feeding Air Pressure</td><td class="value-cell"> <span style="position: relative;left:4px;">{{ $quotation->feeding_air_pressure }} Bar</span></td></tr>
            @endif
        </table>

        <!-- ELECTRICAL PARAMETERS -->
       <div class="technical-data-sub-head" style="text-align: left;width: 95%;">
            <h3 style="font-weight: bold;">1.2 ELECTRICAL PARAMETERS</h3>
        </div>

    <table class="parameter-table"
            style="border-collapse: collapse; font-size: 14px; position: relative; left: 40px; width: 95%; line-height: 1;">
            <tr>
                <td  style="padding: 8px; vertical-align: top; white-space: nowrap; width: 55%;">• &nbsp; Motor Requirement</td>
                <td  class="value-cell"><span style="position: relative;left:4px;">{{ $quotation->motorRequirement->motor_requirement ?? '' }}</span></td>
            </tr>
            <tr>
                <td  style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Voltage</td>
                <td  class="value-cell"><span style="position: relative;left:4px;">415 V</span></td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Frequency</td>
                <td class="value-cell"> span style="position: relative;left:4px;">50 Hz</span></td>
            </tr>
        </table>
    </div>
</div>




<div class="page-break"  style="page-break-before: always; width: 100%;" >
    <div class="technical-data-sub-head">
        <table class="parameter-table"
            style="border-collapse: collapse; font-size: 14px; position: relative; left: 30px; top:160px; width: 95%; line-height: 1; margin-bottom: 20px;">
           <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;width:45%">• &nbsp; Control Panel</td>
                <td class="value-cell">
                     <span style="position: relative;left:4px;"></span>Complete Electrical Control Panel comprising of Thermocouple Wire, Digital Temperature Indicator with Ammeter & Voltmeter, Limit Switch & MCCB provided for safety precaution.
                </td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Mixing Tool</td>
                <td class="value-cell"><span style="position: relative;left:4px;"></span>3 Tier Alloy Steel</td>
            </tr>
        </table>
        <h2></h2>
         <div class="technical-data-sub-head" style="text-align: left;width: 95%; margin-top:140px;position: relative;right:10px;">
            <h3 style="font-weight: bold;">1.3  TRANSMISSION </h3>
         </div>

        <table class="parameter-table"
            style="border-collapse: collapse; font-size: 14px; position: relative; left: 30px; top:10px; width: 95%; line-height: 1;">
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap; width: 45%;">• &nbsp; Gear Box</td>
                <td class="value-cell"> <span style="position: relative;left:4px;"></span>Heli Bevel Gear Box of Elecon Make</td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;"> • &nbsp; Coupling</td>
                <td class="value-cell"> <span style="position: relative;left:4px;"></span>Coupling is used for Higher Torque and for Gear Box Safety</td>
            </tr>
        </table>
    </div>
</div>

