

<!--  -->


<style>
    .parameter-table-t {
        border-collapse: collapse;
        font-size: 14px;
        width: 90%;
        line-height: 0.8;
        margin: 0 5px 15px 40px;
    }

    .parameter-table-t td {
        padding: 6px;
        vertical-align: top;
    }

    .parameter-table-t .value-cell::before {
        content: ": ";
    }

    .parameter-heading {
        text-align: left;
        width: 95%;
    }
</style>
@php
$modelName=$quotation->modele->name;
$parts = explode('/', $modelName);

// Trim each part to remove extra whitespace
$firstPart = trim($parts[0]);
$secondPart = trim($parts[1]);
@endphp

<div class="page-break">
    <div class="techincal-data parameter-table-t">
        <h2 style="text-decoration: underline">1. TECHNICAL DATA</h2>

        <!-- DESIGN PARAMETER -->
        <div class="parameter-heading">
            <h3>1.1 DESIGN PARAMETER OF HIGH SPEED HEATER </h3>
        </div>

        <table class="parameter-table">
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
        <div class="parameter-heading">
            <h3>1.2 ELECTRICAL PARAMETERS</h3>
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
        </table>
    </div>
</div>

<div class="page-break">
     <div class="techincal-data parameter-table-t">
      <div class="parameter-heading">
            <h3>1.3 DESIGN PARAMETER OF HORIZONTAL COOLER MIXER</h3>
        </div>

        <table class="parameter-table">
              <tr><td>• &nbsp; Model</td><td class="value-cell">{{ $secondPart }} Ltr</td></tr>
              <tr><td>• &nbsp; Product</td><td class="value-cell">{{ $quotation->application->name ?? '' }} Compound</td></tr>
              <tr><td>• &nbsp; Total Capacity</td><td class="value-cell">{{ $quotation->total_capacity ?? '' }} Ltr </td></tr>
              <tr><td>• &nbsp; Useful Volume</td><td class="value-cell">{{$quotation->total_capacity - (($quotation->total_capacity*3)/10) }}Ltr  </td></tr>
              <tr><td>• &nbsp; Batch Size</td><td class="value-cell">{{ $quotation->batch->batch2??'' }}Kg( 4 Batch/Hr )  </td></tr>
              <tr><td>• &nbsp; Contact Part</td><td class="value-cell">{{ $quotation->contact_part??' ' }}  </td></tr>
              <tr><td>• &nbsp; Water Pressure</td><td class="value-cell">{{ $quotation->water_pressure??' ' }} Bar </td></tr>
              <tr><td>• &nbsp; Cooling Water Inlet Temperature</td><td class="value-cell">{{ $quotation->cooling_water_inlet_temperature??'' }}  </td></tr>
              <tr><td>• &nbsp; Cooling Water Flow Rate</td><td class="value-cell">{{ $quotation->cooling_water_flow_rate??'' }} m3/h  </td></tr>
              <tr><td>• &nbsp; Feeding Air Pressure</td><td class="value-cell">{{ $quotation->feeding_air_pressure??'' }} Bar </td></tr>
              <tr><td>• &nbsp; Compressed Air Consumption</td><td class="value-cell"> {{ $quotation->compress_air_consumption??'' }} Nm3/h</td></tr>
        </table>

          <!-- ELECTRICAL PARAMETERS -->
        <div class="parameter-heading">
            <h3>1.2 ELECTRICAL PARAMETERS</h3>
        </div>

        <table class="parameter-table">
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


<div class="page-break">
     <div class="techincal-data parameter-table-t">
      <div class="parameter-heading">
            <h3>1.5 TRANSMISITION</h3>
        </div>

        <table class="parameter-table">
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
                <td class="value-cell">Coupling is used for Higher Torque forGear Box Safety</td>
            </tr>
            <tr>
                <td>• &nbsp; Coupling Make</td>
                <td class="value-cell">Fenner</td>
            </tr>
        </table>

          <!-- ELECTRICAL PARAMETERS -->
     

        
    </div>
</div>
