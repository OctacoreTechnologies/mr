<style>
    /* .parameter-table-t {
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
            word-wrap: break-word;
            word-break: break-word;
        } */

    /*
        .parameter-heading {
            text-align: left;
            width: 95%;
            margin-bottom: 10px;
            margin-top: 20px;
            margin-left:20px;
            text-decoration: underline;
        } */


    /* .parameter-table {
            width: 100%;
            table-layout: auto;
            margin-left: 30px;
        } */


    /* .parameter-table td {
            height: 30px;
        } */

    /*
        .page-break {
            page-break-before: always;
        }

    */
    /* h2, h3 {
            margin: 0;
          
            font-weight: normal;
        } */
    /*
        h2 {
            text-decoration: underline;
        }

        
    */
    .value-cell {
        padding: 8px;
    }

    .value-cell::before {
        content: ": ";
    }
</style>
@php
    $modelName = $quotation->modele->name;
    $parts = explode('/', $modelName);

    // Trim each part to remove extra whitespace
    $firstPart = trim($parts[0]);
    $secondPart = trim($parts[1]);

    $capacity = explode(' ', $secondPart);
    array_shift($capacity);
    array_pop($capacity);
    $capacity = implode(' ', $capacity);
@endphp


<div class="page-break" >
    <div class="techincal-data parameter-table techincal-specification">
        <h2 style="text-decoration: underline">1. TECHNICAL DATA</h2>

        <!-- DESIGN PARAMETER -->
        <div class="technical-data-sub-head"
            style="text-align:left; width: 95%; font-family: bolder; text-decoration: underline;">
            <h3 style="font-weight: bold;">1.1 <span>DESIGN PARAMETER OF HIGH SPEED HEATER</span> </h3>
        </div>

        <table class="parameter-table"
            style="border-collapse: collapse; font-size: 14px; position: relative; left: 40px; width: 90%; line-height: 1.1;">
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Model</td>
                <td class="value-cell">{{ $firstPart }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Product</td>
                <td class="value-cell">{{ $quotation->application->name ?? '' }} </td>
            </tr>

            @if (isset($quotation->material_to_process_id))
                <tr>
                    <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Material to Process
                    </td>
                    <td class="value-cell">{{ $quotation->materialToProcess->material_to_process ?? '' }}</td>
                </tr>
            @endif
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Batch</td>
                <td class="value-cell">{{ $quotation->batch->batches ?? '' }} Kgs</td>
            </tr>

            @if (isset($quotation->mixing_tool_id))
                <tr>
                    <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Mixing Tool</td>
                    <td class="value-cell">{{ $quotation->mixingTool->mixing_tool ?? '' }}</td>
                </tr>
            @endif
        </table>

        <!-- ELECTRICAL PARAMETERS -->
        <div class="technical-data-sub-head" style="text-align: left;width: 95%;">
            <h3 style="text-decoration: underline;">1.2 <span style="">ELECTRICAL PARAMETERS</span></h3>
        </div>


        <table class="parameter-table"
            style="border-collapse: collapse; font-size: 14px; position: relative; left: 40px; width: 90%; line-height: 1.1;">
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Motor Requirement</td>
                <td style="padding: 8px;  text-align: justify;">{{ $quotation->motorRequirement->motor_requirement ?? '' }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Voltage</td>
                <td style="padding: 8px;  text-align: justify;">415 V</td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Frequency</td>
                <td style="padding: 8px;  text-align: justify;">50Hz</td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Control Panel</td>
                <td style="padding: 8px;  text-align: justify;">
                    Complete Electrical Control Panel comprising of Thermocouple Wire, Digital Temperature Indicator
                    with Ammeter & Voltmeter, Limit Switch & MCCB provided for safety precaution.
                </td>
            </tr>
        </table>
    </div>
</div>

<div class="page-break"  style="page-break-before: always; width: 100%;" >
    <div class="techincal-data parameter-table techincal-specification">
      <h2></h2>
       <div class="technical-data-sub-head" style="text-align: left;width: 95%;">
            <h3 style="font-weight: bolder;">1.3 DESIGN PARAMETER OF HORIZONTAL COOLER MIXER</h3>
        </div>

      <table class="parameter-table"
            style="border-collapse: collapse; font-size: 14px; position: relative; left: 40px; width: 90%; line-height: 1.1;">
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap; width:60%;">• &nbsp; Model</td>
                <td class="value-cell">{{ $secondPart }} </td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Product</td>
                <td class="value-cell">{{ $quotation->application->name ?? '' }} Compound</td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Total Capacity</td>
                <td class="value-cell">{{ $capacity }} Ltr </td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Useful Volume</td>
                <td class="value-cell">{{ $capacity - ($capacity * 3) / 10 }} Ltr </td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Batch Size</td>
                <td class="value-cell">{{ $quotation->batche2->batches ?? '' }}Kg( 4 Batch/Hr ) </td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Contact Part</td>
                <td class="value-cell">{{ $quotation->contact_part ?? ' ' }} </td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Water Pressure</td>
                <td class="value-cell">{{ $quotation->water_pressure ?? ' ' }} Bar </td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Cooling Water Inlet Temperature</td>
                <td class="value-cell">{{ $quotation->cooling_water_inlet_temperature ?? '' }} </td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Cooling Water Flow Rate</td>
                <td class="value-cell">{{ $quotation->cooling_water_flow_rate ?? '' }} m3/h </td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Feeding Air Pressure</td>
                <td class="value-cell">{{ $quotation->feeding_air_pressure ?? '' }} Bar </td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Compressed Air Consumption</td>
                <td class="value-cell"> {{ $quotation->compress_air_consumption ?? '' }} Nm3/h</td>
            </tr>
        </table>

        <!-- ELECTRICAL PARAMETERS -->
       <div class="technical-data-sub-head"
            style="text-align:left; width: 95%; font-family: bolder; text-decoration: underline;">
            <h3 style="font-weight: bolder;">1.4 ELECTRICAL PARAMETERS</h3>
        </div>

        <table class="parameter-table"
            style="border-collapse: collapse; font-size: 14px; position: relative; left: 40px; width: 90%; line-height: 1.1;">
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Motor Requirement</td>
                <td class="value-cell">{{ $quotation->motorRequirement2->motor_requirement ?? '' }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Voltage</td>
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
            style="border-collapse: collapse; font-size: 14px; position: relative; left: 40px;top:60px; width: 90%; line-height: 1.1;">
         <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Control Panel</td>
                <td class="value-cell">
                    Complete Electrical Control Panel comprising of Thermocouple Wire, Digital Temperature Indicator
                    with Ammeter & Voltmeter, Limit Switch & MCCB provided for safety precaution.
                </td>
            </tr>
    </table>
      <h2></h2>
         <div class="technical-data-sub-head" style="text-align: left;width: 95%;">
             <h3 style="font-weight: bolder;">1.5 TRANSMISSION</h3>
        </div>

       <table class="parameter-table"
            style="border-collapse: collapse; font-size: 14px; position: relative; left: 40px; width: 90%; line-height: 1.1;">
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Gear Box</td>
                <td class="value-cell">Speed reduction Gear box is provided Heli Bevel Type</td>
            </tr>
            <tr style="padding: 8px; vertical-align: top; white-space: nowrap;">
                <td>• &nbsp; Gear Box Make</td>
                <td class="value-cell">Elecon (PBL)</td>
            </tr>
            <tr style="padding: 8px; vertical-align: top; white-space: nowrap;">
                <td>• &nbsp; Coupling </td>
                <td class="value-cell">Coupling is used for Higher Torque for Gear Box Safety</td>
            </tr>
            <tr style="padding: 8px; vertical-align: top; white-space: nowrap;">
                <td>• &nbsp; Coupling Make</td>
                <td class="value-cell">Fenner</td>
            </tr>
        </table>
    </div>
</div>
