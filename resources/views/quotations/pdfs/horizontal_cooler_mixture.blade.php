@php
    $mixerSpecs = [
        [
            'title' => 'Cooling Vessel',
            'description' => 'Inside Made from Stainless Steel with
                            Cooling Ring MOC – 304 Grade. Outside
                            Jacketed by Mild Steel Plates. Jacketed
                            Construction Provided for Cooling with
                            Suitable Media. Material Discharge Opening
                            Assembly is Fitted at the Bottom Operated by
                            Pneumatic Cylinder.',
        ],
        [
            'title' => 'Discharge Valve',
            'description' => 'Material Discharge Opening Assembly is Fitted at the Bottom Operated
                                             by Butterfly Valve. Butterfly Valve Wafer MOC: SS 304 & Seal: EPDM,
                                             A generously dimensioned discharge outlet ensures rapid product
                                             emptying and minimizes residue, even for materials with low flowability.
                                             ',
        ],
        [
            'title' => 'Mixing Tool',
            'description' => 'MOC: Paddle and Paddle Carrier are SS 304 Shaft Fastening is Achieved Using Axially Adjustable Clamping Devices.
                                                  The Cooling Mixer Paddles Are Engineered for Intensive Axial and
                                                  Radial Circulation, Enhancing Both Mixing Efficiency and Cooling
                                                  Capacity While Ensuring Optimal Heat Transfer. Even Minimal
                                                  Quantities of Fine Components Are Homogeneously Blended During
                                                  the Short Cooling Phase',
        ],
        // Add more items as needed
    ];
    $mixerSpecs2 = [
        [
            'title' => 'Lid & Safety Arrangement',
            'description' => 'Lid MOC: SS 304
                                            Pneumatically Operated with Cylinders. Two-Hand-Operation
                                            Operating Angle &gt; 50°
                                            Lid Safety: According to Specification System: Solenoid Safety Sensor
                                            (Limit Switch)
                    . The Cooling Mixer Lid is Integrated into the Safety
                                            Circuit',
        ],
        [
            'title' => 'Bearing Housing Shafting',
            'description' => 'Mixing Shaft Material Mild Steel with SS 304 Thick Pipe Jacketing.Power Transfer Directly from the Gear Box with Heavy Duty Bearings, Bearing Housings Fixed on the Shaft with Eccentric Clamping Rings for a Comfortable Maintenance and an Easy Access, the Bearings Are Installed in a Separate Housing Outside the Cooling Mixer Vessel. 
                                              Seal Elements: Radial Shaft Seal Rings & Lubrication: Grease Air Purge
                                              Seal Rings with Air-heterodyne Reliably Keeps the Seat of the Seals
                                              Free from Mixing Material.
                                             ',
        ],
        [
            'title' => 'Mounting Structure',
            'description' =>
                'Sturdy MS Channel from Duly Covered with MS Sheet and Coated with Water Resistant Enamel Coating Painting',
        ],
        [
            'title' => 'Electrical Control',
            'description' => 'ABB / SIEMENS / L&T',
        ],
        [
            'title' => 'Bearing',
            'description' => 'ZKL / FAG / SKF',
        ],
    ];

    $mixerSpecs3 = [
        [
            'title' => 'Pneumatic Control',
            'description' => 'SPAC / JANATICS',
        ],
        [
            'title' => 'Gear Box',
            'description' => 'Heli Bevel',
        ],
        [
            'title' => 'Motor',
            'description' => 'Hindustan / ABB / SIEMENS 1440 RPM AC ',
        ],
        [
            'title' => 'Driving System',
            'description' => 'The drive system incorporates Direct Motor and Gear Box assembly driven.',
        ],
    ];

    $modelName = $quotation->modele->name ?? '';

    $parts = explode('/', $modelName);

    $firstPart = trim($parts[0] ?? '');

    // Extract numeric capacity safely
    preg_match('/(\d+)/', $firstPart, $matches);
    $capacity = isset($matches[1]) ? (int) $matches[1] : 0;

    // Useful volume calculation (70%)
    $usefulVolume = $capacity * 0.7;
@endphp


<x-header-footer-pdf />
<x-client-pdf-template :quotation="$quotation" />
<x-table-content :specification="'Horizontal Cooler Mixture'" :pageTechnicalData="4" :pageSpecification="6"
    :pageOffer="9" :pageTerms="10" />
<style>
    .value-cell::before {
        content: ": ";
    }
    /* .value-cell {
        padding: 8px;
    } */
</style>



<div class="page-break">
    <div class="techincal-data parameter-table techincal-specification">
        <h2 style="text-decoration: underline">1. TECHNICAL DATA</h2>
        <!-- DESING PARAMETER OF HIGH-SPEED -->
        <div class="technical-data-sub-head"
            style="text-align:left; width: 95%; font-family: bolder; text-decoration: underline;">
            {{-- <h3>1.1 <span style="text-decoration: underline;">DESIGN PARAMETER OF HIGH-SPEED MIXTURE</span></h3>
            --}}
            <h3 style="text-decoration: underline;">1.1 <span>DESIGN PARAMETER OF
                    {{ strtoupper($quotation->machine->name) }}</span></h3>
        </div>
        <table class="parameter-table"
            style="border-collapse: collapse; font-size: 14px; position: relative; left: 40px; width: 100%; line-height: 1.1;">
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap; width: 55%;">• &nbsp; Model</td>
                <td class="value-cell"><span style="position: relative;left:4px;">{{ $firstPart }}</span></td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Product</td>
                <td class="value-cell"><span style="position: relative;left:4px;">{{ $quotation->application->name ?? '' }}</span> </td>
            </tr>

            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Total Capacity</td>
                <td class="value-cell"><span style="position: relative;left:4px;">{{ $capacity }} Ltr</span></td>
            </tr>

            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Useful Volume</td>
                <td class="value-cell"><span style="position: relative;left:4px;">{{ $usefulVolume }} Ltr</span></td>
            </tr>

            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Batch Size</td>
                <td class="value-cell"><span style="position: relative;left:4px;">{{ $quotation->batch->batches ?? '' }} Kg( 4 Batch/Hr )</span></td>
            </tr>

            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Contact Part</td>
                <td class="value-cell"><span style="position: relative;left:4px;">{{ $quotation->contact_part ?? ' ' }}</span></td>
            </tr>

            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Water Pressure</td>
                <td class="value-cell"><span style="position: relative;left:4px;">{{ $quotation->water_pressure ?? ' ' }} Bar</span></td>
            </tr>

            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Cooling Water Inlet
                    Temperature</td>
                <td class="value-cell"><span style="position: relative;left:4px;">{{ $quotation->cooling_water_inlet_temperature ?? '' }}</span> </td>
            </tr>

            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Cooling Water Flow Rate
                </td>
                <td class="value-cell"><span style="position: relative;left:4px;">{{ $quotation->cooling_water_flow_rate ?? '' }} m3/h</span></td>
            </tr>

            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Feeding Air Pressure</td>
                <td class="value-cell"><span style="position: relative;left:4px;">{{ $quotation->feeding_air_pressure ?? ' ' }} Bar</span></td>
            </tr>

            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Compressed Air Consumption
                </td>
                <td class="value-cell"><span style="position: relative;left:4px;">{{ $quotation->compress_air_consumption ?? '' }} Nm3/h</span></td>
            </tr>
        </table>


    </div>
</div>

<div class="page-break">
    <div class="techincal-data parameter-table techincal-specification">
        <h2></h2>
        <div class="technical-data-sub-head"
            style="text-align:left; width: 95%; font-family: bolder; text-decoration: underline;">
            {{-- <h3>1.1 <span style="text-decoration: underline;">DESIGN PARAMETER OF HIGH-SPEED MIXTURE</span></h3>
            --}}
            <h3 style="text-decoration: underline;">1.2 <span style="">ELECTRICAL PARAMETERS</span></h3>

        </div>
        <table class="parameter-table"
            style="border-collapse: collapse; font-size: 14px; position: relative; left: 40px; width: 100%; line-height: 1.1;">
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap; width: 55%;">• &nbsp;Motor Requirement</td>
                {{-- <td style="padding: 8px;">:&nbsp;15 KW/20 HP Single Speed Mixer – 1440 RPM</td> --}}
                <td class="value-cell"><span style="position: relative;left:4px;">{{ $quotation->motorRequirement->motor_requirement }}</span></td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Voltage</td>
                <td class="value-cell"><span style="position: relative;left:4px;">415 V</span></td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Frequency</td>
                <td class="value-cell"><span style="position: relative;left:4px;">50Hz</span></td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Control Panel</td>
                <td style="word-spacing: normal;"class="value-cell"><span style="position: relative;left:4px;">omplete Electrical Control Panel Comprising of
                    Thermocouple Wire Digital Temperature Indicator
                    With Ammeter & Voltmeter, Limit Switch & MCCB
                    Provided for Safety Precaution.</span>
                </td>
            </tr>
        </table>

        <div class="technical-data-sub-head"
            style="text-align:left; width: 95%; font-family: bolder; text-decoration: underline;">
            {{-- <h3>1.1 <span style="text-decoration: underline;">DESIGN PARAMETER OF HIGH-SPEED MIXTURE</span></h3>
            --}}
            <h3 style="text-decoration: underline;">1.3 <span style="">TRANSMISSION</span></h3>

        </div>
        <table class="parameter-table"
            style="border-collapse: collapse; font-size: 14px; position: relative; left: 40px; width: 100%; line-height: 1.1;">
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap; width: 55%;">• &nbsp;Gear Box</td>
                <td class="value-cell"><span style="position: relative;left:4px;">Speed reduction Gear box is provided Heli Bevel Type</span></td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Gear Box Make</td>
                <td class="value-cell"><span style="position: relative;left:4px;">Elecon (PBL)</span></td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Coupling</td>
                <td class="value-cell"><span style="position: relative;left:4px;">Coupling is used for Higher Torque for Gear Box Safety</span></td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Coupling Make</td>
                <td class="value-cell">
                    <span style="position: relative;left:4px;">Fenner</span>
                </td>
            </tr>
        </table>
    </div>
</div>


<x-technical-specification-one heading-number="2." heading-text="TECHNICAL SPECIFICATION OF Horizontal Cooler Mixer"
    :items="$mixerSpecs" />
<x-technical-specification-two :items="$mixerSpecs2" />
<x-technical-specification-two :items="$mixerSpecs3" />


<x-offer :quotation="$quotation" :words="$words" />

<x-term-and-condition-pdf :termCondition="$termCondition" />


{{-- <div class="techincal-data parameter-table" style="text-align: left;width: 95%;">
    <h3 style="text-decoration: underline;">1.3 <span style="">TRANSMISSION</span></h3>

    <table class="parameter-table"
        style="border-collapse: collapse; font-size: 14px; position: relative; left: 40px; width: 90%; line-height: 1.1;">
        <tr>
            <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp;Gear Box</td>
            <td style="padding: 8px;">:&nbsp;Speed reduction Gear box is provided Heli Bevel Type</td>
        </tr>
        <tr>
            <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Gear Box Make</td>
            <td style="padding: 8px;">:&nbsp;Elecon (PBL)</td>
        </tr>
        <tr>
            <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Coupling</td>
            <td style="padding: 8px;">:&nbsp;Coupling is used for Higher Torque for Gear Box Safety</td>
        </tr>
        <tr>
            <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Coupling Make</td>
            <td style="padding: 8px;">
                :&nbsp;Fenner
            </td>
        </tr>
    </table>
</div>



<div class="techincal-data parameter-table" style="text-align: left;width: 95%;">
    <h3 style="text-decoration: underline;">1.2 <span style="">ELECTRICAL PARAMETERS</span></h3>

    <table class="parameter-table"
        style="border-collapse: collapse; font-size: 14px; position: relative; left: 40px; width: 90%; line-height: 1.1;">
        <tr>
            <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp;Motor Requirement</td>

            <td style="padding: 8px;">:&nbsp;{{ $quotation->motorRequirement->motor_requirement }}</td>
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
</div> --}}