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
    /* .value-cell {
        padding: 8px;
    } */
      .value-cell {
       vertical-align: top; 
      text-align: justify;
    }

    .value-cell::before {
        content: ":";
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
            style="border-collapse: collapse; font-size: 14px; position: relative; left: 40px; width: 100%; line-height: 1;">
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap; width: 55%;">• &nbsp; Model</td>
                <td class="value-cell"><span style="position: relative;left:4px;">{{ $firstPart }}</span></td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Product</td>
                <td class="value-cell"><span style="position: relative;left:4px;">{{ $quotation->application->name ?? '' }}</span> </td>
            </tr>

            @if (isset($quotation->material_to_process_id))
                <tr>
                    <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Material to Process
                    </td>
                    <td class="value-cell"><span style="position: relative;left:4px;">{{ $quotation->materialToProcess->material_to_process ?? '' }}</span></td>
                </tr>
            @endif
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Batch</td>
                <td class="value-cell"><span style="position: relative;left:4px;">{{ $quotation->batch->batches ?? '' }} Kgs</span></td>
            </tr>

            @if (isset($quotation->mixing_tool_id))
                <tr>
                    <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Mixing Tool</td>
                    <td class="value-cell"><span style="position: relative;left:4px;">{!! $quotation->mixingTool->mixing_tool ?? '' !!}</span></td>
                </tr>
            @endif
        </table>

        <!-- ELECTRICAL PARAMETERS -->
        <div class="technical-data-sub-head" style="text-align: left;width: 95%;">
            <h3 style="text-decoration: underline;">1.2 <span style="">ELECTRICAL PARAMETERS</span></h3>
        </div>


        <table class="parameter-table"
            style="border-collapse: collapse; font-size: 14px; position: relative; left: 40px; width: 100%; line-height: 1;">
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap; width: 55%;">• &nbsp; Motor Requirement</td>
                <td class="value-cell"><span style="position: relative;left:4px;">{{ $quotation->motorRequirement->motor_requirement ?? '' }}</span></td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Voltage</td>
                <td class="value-cell"><span style="position: relative;left:4px;">415 V</span></td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Frequency</td>
                <td class="value-cell"><span style="position: relative;left:4px;">50 Hz</span></td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Control Panel</td>
                <td class="value-cell"><span style="position: relative;left:4px;">Complete Electrical Control Panel comprising of Thermocouple Wire, Digital Temperature Indicator
                    with Ammeter & Voltmeter, Limit Switch & MCCB provided for safety precaution.</span>
                    
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
            style="border-collapse: collapse; font-size: 14px; position: relative; left: 40px; width: 98%; line-height:1;">
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;  width: 55%;">• &nbsp; Model</td>
                <td class="value-cell"><span style="position: relative;left:4px;">{{ $secondPart }}</span> </td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Product</td>
                <td class="value-cell"><span style="position: relative;left:4px;">{{ $quotation->application->name ?? '' }} Compound</span></td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Total Capacity</td>
                <td class="value-cell"><span style="position: relative;left:4px;">{{ $capacity }} Ltr</span> </td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Useful Volume</td>
                <td class="value-cell"><span style="position: relative;left:4px;">{{ $capacity - ($capacity * 3) / 10 }} Ltr</span> </td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Batch Size</td>
                <td class="value-cell"><span style="position: relative;left:4px;">{{ $quotation->batche2->batches ?? '' }}Kg( 4 Batch/Hr )</span> </td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Contact Part</td>
                <td class="value-cell"><span style="position: relative;left:4px;">{{ $quotation->contact_part ?? ' ' }}</span> </td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Water Pressure</td>
                <td class="value-cell"><span style="position: relative;left:4px;">{{ $quotation->water_pressure ?? ' ' }} Bar</span> </td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Cooling Water Inlet Temperature</td>
                <td class="value-cell"><span style="position: relative;left:4px;">{{ $quotation->cooling_water_inlet_temperature ?? '' }}</span> </td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Cooling Water Flow Rate</td>
                <td class="value-cell"><span style="position: relative;left:4px;">{{ $quotation->cooling_water_flow_rate ?? '' }} m3/h</span> </td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Feeding Air Pressure</td>
                <td class="value-cell"><span style="position: relative;left:4px;">{{ $quotation->feeding_air_pressure ?? '' }} Bar </span></td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Compressed Air Consumption</td>
                <td class="value-cell"><span style="position: relative;left:4px;"> {{ $quotation->compress_air_consumption ?? '' }} Nm3/h</span></td>
            </tr>
        </table>

        <!-- ELECTRICAL PARAMETERS -->
       <div class="technical-data-sub-head"
            style="text-align:left; width: 95%; font-family: bolder; text-decoration: underline;">
            <h3 style="font-weight: bolder;">1.4 ELECTRICAL PARAMETERS</h3>
        </div>

        <table class="parameter-table"
            style="border-collapse: collapse; font-size: 14px; position: relative; left: 40px; width: 100%; line-height: 1;">
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap; width: 55%;">• &nbsp; Motor Requirement</td>
                <td class="value-cell"><span style="position: relative;left:4px;">{{ $quotation->motorRequirement2->motor_requirement ?? '' }}</span></td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Voltage</td>
                <td class="value-cell"><span style="position: relative;left:4px;">415 V</span></td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Frequency</td>
                <td class="value-cell"><span style="position: relative;left:4px;">50 Hz</span></td>
            </tr>
        </table>
    </div>
</div>
<div class="page-break"  style="page-break-before: always;" >
    <div class="techincal-data parameter-table techincal-specification">
        <table class="parameter-table"
            style="border-collapse: collapse; font-size: 14px; position: relative; left: 40px;top:60px; width: 100%; line-height: 1;">
         <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap; width: 55%;">• &nbsp; Control Panel</td>
                <td class="value-cell"><span style="position: relative;left:4px;">Complete Electrical Control Panel comprising of Thermocouple Wire, Digital Temperature Indicator
                    with Ammeter & Voltmeter, Limit Switch & MCCB provided for safety precaution.</span>
                  
                </td>
            </tr>
    </table>
      <h2></h2>
         <div class="technical-data-sub-head" style="text-align: left;width: 95%;">
             <h3 style="font-weight: bolder;">1.5 TRANSMISSION</h3>
        </div>

       <table class="parameter-table"
            style="border-collapse: collapse; font-size: 14px; position: relative; left: 40px; width: 98%; line-height: 1;">
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;width:55%;">• &nbsp; Gear Box</td>
                <td class="value-cell"><span style="position: relative;left:4px;">Speed reduction Gear box is provided Heli Bevel Type</span></td>
            </tr>
            <tr style="padding: 8px; vertical-align: top; white-space: nowrap;">
                <td>• &nbsp; Gear Box Make</td>
                <td class="value-cell"><span style="position: relative;left:4px;">Elecon (PBL)</span></td>
            </tr>
            <tr style="padding: 8px; vertical-align: top; white-space: nowrap;">
                <td>• &nbsp; Coupling </td>
                <td class="value-cell"><span style="position: relative;left:4px;">Coupling is used for Higher Torque for Gear Box Safety</span></td>
            </tr>
            <tr style="padding: 8px; vertical-align: top; white-space: nowrap;">
                <td>• &nbsp; Coupling Make</td>
                <td class="value-cell"><span style="position: relative;left:4px;">Fenner</span></td>
            </tr>
        </table>
    </div>
</div>


