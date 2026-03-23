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
                    :&nbsp;Complete Electrical Control Panel comprising of Suitable Ammeter & Voltmeter, Limit Switch &
                    MCCB provided for safety precaution.
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
                <td style="padding: 8px;">:&nbsp;Coupling is used for Higher Torque and for Gear Box Safety.
                </td>
            </tr>
        </table>

    </div>
</div> --}}
<!-- start  -->
<style>
    .value-cell {
        /* padding: 8px; */
    }

    .value-cell::before {
        content: ":";
    }
</style>
<x-table-content :specification="'MIXER'" :pageTechnicalData="4" :pageSpecification="7" :pageOffer="9" :pageTerms="10" />
@php
    $modelName = $quotation->modele->name;
    $parts = explode('/', $modelName);

    // Trim each part to remove extra whitespace
    $firstPart = trim($parts[0]);
    $secondPart = trim($parts[1]);
@endphp

<div class="page-break">
    <div class="techincal-data parameter-table techincal-specification">
        <h2 style="text-decoration: underline">1. TECHNICAL DATA</h2>

        <div class="technical-data-sub-head"
            style="text-align:left; width: 95%; font-family: bolder; text-decoration: underline;">
            <h3 style="font-weight: bold;">1.1 <span> DESIGN PARAMETER OF HEATER </h3>
        </div>
        <table class="parameter-table"
            style="border-collapse: collapse; font-size: 14px; position: relative; left: 40px; width: 105%; line-height: 1.1;">
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;width:50%;">• &nbsp; Model</td>
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
                <td class="value-cell"><span style="position: relative;left:4px;"></span><span style="position: relative;left:4px;">{{ $quotation->batch->batches ?? '' }} Kgs</span></td>
            </tr>

            @if (isset($quotation->mixing_tool_id))
                <tr>
                    <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Mixing Tool</td>
                    <td class="value-cell"><span style="position: relative;left:4px;">{{ $quotation->mixingTool->mixing_tool ?? '' }}</span></td>
                </tr>
            @endif
        </table>

        <!-- ELECTRICAL PARAMETERS -->
        <div class="technical-data-sub-head" style="text-align: left;width: 95%;">
            <h3 style="text-decoration: underline;">1.2 ELECTRICAL PARAMETERS</h3>
        </div>

        <table class="parameter-table"
            style="border-collapse: collapse; font-size: 14px; position: relative; left: 40px; width: 105%; line-height: 1.1;">
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;width:50%;">• &nbsp; Motor Requirement
                </td>
                <td style="padding: 8px;  text-align: justify;" class="value-cell">
                    <span style="position: relative;left:4px;">{{ $quotation->motorRequirement->motor_requirement ?? '' }}</span>
                </td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Voltage</td>
                <td style="padding: 8px;  text-align: justify;" class="value-cell"><span style="position: relative;left:4px;">415 V</span></td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Frequency</td>
                <td style="padding: 8px;  text-align: justify;" class="value-cell"><span style="position: relative;left:4px;">50 Hz</span></td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Control Panel</td>
                <td style="padding: 8px;  text-align: justify;" class="value-cell"><span style="position: relative;left:4px;">Complete Electrical Control Panel
                    comprising of Thermocouple Wire, Digital Temperature Indicator with Ammeter & Voltmeter, Limit
                    Switch & MCCB provided for safety precaution.</span>
                </td>
            </tr>
        </table>
    </div>
</div>

<div class="page-break" style="page-break-before: always; width: 100%;">
    <div class="techincal-data parameter-table techincal-specification">
        <h2></h2>
        <div class="technical-data-sub-head" style="text-align: left;width: 95%;">
            <h3 style="font-weight: bolder;">1.3 DESIGN PARAMETER OF VERTICAL COOLER MIXER</h3>
        </div>

        <table class="parameter-table"
            style="border-collapse: collapse; font-size: 14px; position: relative; left: 40px; width: 105%; line-height: 1.1;">
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap; width:50%;">• &nbsp; Model</td>
                <td class="value-cell"><span style="position: relative;left:4px;">{{ $secondPart }}</span></td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Product</td>
                <td class="value-cell"><span style="position: relative;left:4px;">{{ $quotation->application->name ?? '' }} Compound</span></td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Batch Size</td>
                <td class="value-cell"><span style="position: relative;left:4px;">{{ $quotation->batche2->batches ?? '' }} Kg</span> </td>
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
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Operating Pressure</td>
                <td class="value-cell"><span style="position: relative;left:4px;">{{ $quotation->operating_pressure ?? ' ' }} Bar</span> </td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Cooling Water Inlet
                    Temperature</td>
                <td class="value-cell"><span style="position: relative;left:4px;">{{ $quotation->cooling_water_inlet_temperature ?? '' }}</span> </td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Cooling Water Flow Rate
                </td>
                <td class="value-cell"><span style="position: relative;left:4px;">{{ $quotation->cooling_water_flow_rate ?? '' }} m3/h</span> </td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Feeding Air Pressure</td>
                <td class="value-cell"><span style="position: relative;left:4px;">{{ $quotation->feeding_air_pressure ?? '' }} Bar </span></td>
            </tr>
        </table>

        <!-- ELECTRICAL PARAMETERS -->
        <div class="technical-data-sub-head"
            style="text-align:left; width: 100%; font-family: bolder; text-decoration: underline;">
            <h3 style="font-weight: bolder;">1.4 ELECTRICAL PARAMETERS</h3>
        </div>

        <table class="parameter-table"
            style="border-collapse: collapse; font-size: 14px; position: relative; left: 40px; width: 105%; line-height: 1.1;">
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;width:50%">• &nbsp; Motor Requirement
                </td>
                <td class="value-cell"><span style="position: relative;left:4px;">{{ $quotation->motorRequirement2->motor_requirement ?? '' }}</span></td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Voltage</td>
                <td class="value-cell"> <span style="position: relative;left:4px;">415 V</span></td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Frequency</td>
                <td class="value-cell"> <span style="position: relative;left:4px;">50 Hz</span></td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Control Panel</td>
                <td class="value-cell">
                    <span style="position: relative;left:4px;">Complete Electrical Control Panel comprising of Thermocouple Wire, Digital Temperature Indicator
                    with Ammeter & Voltmeter, Limit Switch & MCCB provided for safety precaution.</span>
                </td>
            </tr>
        </table>
    </div>
</div>

<div class="page-break" style="page-break-before: always; width: 100%;">
    <div class="techincal-data parameter-table techincal-specification">
        <h2></h2>
        <div class="technical-data-sub-head" style="text-align: left;width: 100%;">
            <h3 style="font-weight: bolder;">1.5 TRANSMISSION</h3>
        </div>

        <table class="parameter-table"
            style="border-collapse: collapse; font-size: 14px; position: relative; left: 40px; width: 105%; line-height: 1.1;">
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Gear Box</td>
                <td class="value-cell" style="width: 60%"> <span style="position: relative;left:4px;">Speed reduction Gear box is provided Heli Bevel Type</span></td>
            </tr>

            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Coupling </td>
                <td class="value-cell"> <span style="position: relative;left:4px;">Coupling is used for Higher Torque for Gear Box Safety</span></td>
            </tr>
        </table>
    </div>
</div>

<!-- end -->
@php
    $mixerSpecs = [
        [
            'title' => 'Vessel (Heater & Cooler)',
            'description' =>
                'Inside Made from SS – 304 Grade Plate and Outside Jacketed by Mild Steel Plate.   Jacketed Construction Provided for Heating or Cooling with Suitable Media. Material Discharge Assembly is fitted at the Bottom, Operated by Pneumatic Cylinder. Cooling Ring MOC – 304 Grade.',
        ],
        [
            'title' => 'Lid',
            'description' => 'Stainless steel - 304 grades. 
                                 Equipped with gasket, on lid edge and with lid locking arrangement. The lid is fitted with the Followings flanged openings 
                                 1. One for fitting arrangements for  Deflector and thermocouple (Heater Mixer).
                                 2. One for addition of chemicals (Heater Mixer). 
                                 ',
            //3. Two for viewing glasses, operated pneumatically.  <br />
        ],
        [
            'title' => 'Defelector',
            'description' =>
                'Made up of Stainless Steel – 304 grades or Alloy steel Equipped with Thermocouple Wire for    Temperature Measurement. Installed with provision of Varying Angle and Height to Ensure Maximum Material Circulation ',
        ],
        [
            'title' => 'Discharge Valve',
            'description' => 'Made Up of SS 304 Provided with Gasket   & Operated Pneumatically',
        ],
        [
            'title' => 'Shaft',
            'description' => 'Shaft is Specially Manufactured from Alloy Steel, Hardened and Ground.',
        ],
        [
            'title' => 'Mounting Structure',
            'description' => 'Sturdy MS Channel from Duly Covered with MS Sheet and Coated with Water Resistant Enamel Coating Painting',
        ],

        // Add more items as needed
    ];

    $mixerSpecs2 = [
        [
            'title' => 'Mixing Tool',
            'description' =>
                'Specially Designed Shape and Angle Suitable for your Compound with Height adjustment. Spacers with wear resistance treatment. Cooler Mixer Blade Made from STAINLESSSTEEL: 304 specially designed shovel type',
        ],

        [
            'title' => 'Bearing Housing',
            'description' =>
                'Mixing Vessel fitted on Steel Plates and Bearing Housing fitted on Steel Plates with Heavy Duty Bearings with Water Cooling and Greasing Arrangements. The resin Leakage to Bearings is Prevented by our Special Design.',
        ],

        [
            'title' => 'Motor',
            'description' => ($quotation->makeMotor?->name ?? '') . '.',
        ],

        [
            'title' => 'Driving System',
            'description' =>
                'The drive system incorporates with V-belt and tapper lock pulley (SPC type) to give Efficient power drive transmission. The Belts  Are Tightened by means of motor sliding screw.',
        ],

        [
            'title' => 'Mounting Structure',
            'description' =>
                ' Sturdy MS Channel from Duly Covered with MS Sheet and Coated with Water resistant enamel   Coating Painting.',
        ],
        [
            'title' => 'Electrical Control',
            'description' => $quotation->electricalControl->electrical_control ?? '',
        ],
        [
            'title' => 'AC Frequency Drive',
            'description' => $quotation->acFrequencyDrive->ac_fequency_drive ?? '',
        ],
        [
            'title' => 'Bearing',
            'description' => $quotation->bearinge->bearing ?? '',
        ],
        [
            'title' => 'Pneumatic Control',
            'description' => $quotation->pneumatic->pneumatic ?? '',
        ],
    ];
@endphp

<x-technical-specification-one heading-text="TECHNICAL SPECIFICATION OF HEATER AND VERTICAL COOLER MIXER" :items="$mixerSpecs" />
<x-technical-specification-two :items="$mixerSpecs2" />



<x-offer :quotation="$quotation" :words="$words" />
<x-term-and-condition-pdf :termCondition="$termCondition" />