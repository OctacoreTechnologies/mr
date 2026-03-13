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
            'title' => 'DISCHARGE VALVE',
            'description' => 'Material Discharge Opening Assembly is Fitted at the Bottom Operated
                         by Butterfly Valve. Butterfly Valve Wafer MOC: SS 304 &amp; Seal: EPDM,
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
            'title' => 'LID &amp; SAFETY ARRANGEMENT',
            'description' => 'Lid MOC: SS 304
                        Pneumatically Operated with Cylinders. Two-Hand-Operation
                        Operating Angle &gt; 50°
                        Lid Safety: According to Specification System: Solenoid Safety Sensor
                        (Limit Switch)
. The Cooling Mixer Lid is Integrated into the Safety
                        Circuit',
        ],
        [
            'title' => 'BEARING HOUSING &amp; SHAFTING',
            'description' => 'Mixing Shaft Material Mild Steel with SS 304 Thick Pipe Jacketing.Power Transfer Directly from the Gear Box with Heavy Duty Bearings, Bearing Housings Fixed on the Shaft with Eccentric Clamping Rings for a Comfortable Maintenance and an Easy Access, the Bearings Are Installed in a Separate Housing Outside the Cooling Mixer Vessel. 
                          Seal Elements: Radial Shaft Seal Rings &amp; Lubrication: Grease Air Purge
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
            'description' => 'ABB / SIEMENS / L &amp; T',
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
            'description' => 'T Hindustan / ABB / SIEMENS 1440 RPM AC ',
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
<x-table-content :specification="'Horizontal Cooler Mixture'" :pageTechnicalData="4" :pageSpecification="6" :pageOffer="9" :pageTerms="10" />
<style>
    /* .value-cell::before {
        content: ": ";
    } */
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
            {{-- <h3>1.1 <span style="text-decoration: underline;">DESIGN PARAMETER OF HIGH-SPEED MIXTURE</span></h3> --}}
            <h3 style="text-decoration: underline;">1.1 <span>DESIGN PARAMETER OF
                    {{ strtoupper($quotation->machine->name) }}</span></h3>
        </div>
        <table class="parameter-table"
            style="border-collapse: collapse; font-size: 14px; position: relative; left: 40px; width: 90%; line-height: 1.1;">
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Model</td>
                <td class="value-cell">:&nbsp;{{ $firstPart }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Product</td>
                <td class="value-cell">:&nbsp;{{ $quotation->application->name ?? '' }} </td>
            </tr>

            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Total Capacity</td>
                <td class="value-cell">:&nbsp;{{ $capacity }} Ltr</td>
            </tr>

            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Useful Volume</td>
                <td class="value-cell">:&nbsp;{{ $usefulVolume }} Ltr</td>
            </tr>

            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Batch Size</td>
                <td class="value-cell">:&nbsp;{{ $quotation->batch->batches ?? '' }} Kg( 4 Batch/Hr )</td>
            </tr>

            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Contact Part</td>
                <td class="value-cell">:&nbsp;{{ $quotation->contact_part ?? ' ' }}</td>
            </tr>

            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Water Pressure</td>
                <td class="value-cell">:&nbsp;{{ $quotation->water_pressure ?? ' ' }} Bar</td>
            </tr>

            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Cooling Water Inlet
                    Temperature</td>
                <td class="value-cell">:&nbsp;{{ $quotation->cooling_water_inlet_temperature??'' }} </td>
            </tr>

            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Cooling Water Flow Rate
                </td>
                <td class="value-cell">:&nbsp;{{ $quotation->cooling_water_flow_rate ?? '' }} m3/h</td>
            </tr>

            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Feeding Air Pressure</td>
                <td class="value-cell">:&nbsp;{{ $quotation->feeding_air_pressure ?? ' ' }} Bar</td>
            </tr>

            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Compressed Air Consumption
                </td>
                <td class="value-cell">:&nbsp;{{ $quotation->compress_air_consumption ?? '' }} Nm3/h</td>
            </tr>
        </table>


    </div>
</div>

<div class="page-break">
    <div class="techincal-data parameter-table techincal-specification">
        <h2></h2>
        <div class="technical-data-sub-head"
            style="text-align:left; width: 95%; font-family: bolder; text-decoration: underline;">
            {{-- <h3>1.1 <span style="text-decoration: underline;">DESIGN PARAMETER OF HIGH-SPEED MIXTURE</span></h3> --}}
            <h3 style="text-decoration: underline;">1.2 <span style="">ELECTRICAL PARAMETERS</span></h3>

        </div>
        <table class="parameter-table"
            style="border-collapse: collapse; font-size: 14px; position: relative; left: 40px; width: 90%; line-height: 1.1;">
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp;Motor Requirement</td>
                {{-- <td style="padding: 8px;">:&nbsp;15 KW/20 HP Single Speed Mixer – 1440 RPM</td> --}}
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
                <td style="padding: 8px; word-spacing: normal;">:&nbsp;Complete Electrical Control Panel Comprising of
                    Thermocouple Wire Digital Temperature Indicator
                    With Ammeter & Voltmeter, Limit Switch & MCCB
                    Provided for Safety Precaution.
                </td>
            </tr>
        </table>

        <div class="technical-data-sub-head"
            style="text-align:left; width: 95%; font-family: bolder; text-decoration: underline;">
            {{-- <h3>1.1 <span style="text-decoration: underline;">DESIGN PARAMETER OF HIGH-SPEED MIXTURE</span></h3> --}}
            <h3 style="text-decoration: underline;">1.3 <span style="">TRANSMISSION</span></h3>

        </div>
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
</div>

<style>
    /* General Table Styling */
    .parameter-table-t {
        border-collapse: collapse;
        font-size: 14px;
        width: 90%;
        line-height: 1;
        margin: 0 5px 15px 2px;
        padding-bottom: 25px;
    }

    .parameter-table-t td {
        padding: 4px;
        vertical-align: top;
        word-wrap: break-word;
        /* Allow long words to break and wrap onto the next line */
        word-break: break-word;
        /* Prevent overflow of long words */
    }



    .parameter-heading h3 {
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
        table-layout: auto;
        /* Allow cells to adjust according to content */
        /* margin-left: 20px; */
    }

    /* Optional: Improve readability by increasing row height for better spacing */
    .parameter-table td {
        height: 30px;
        /* Adjust row height */
    }
</style>

<x-technical-specification-one heading-number="3." heading-text="TECHNICAL SPECIFICATION OF MIXER" :items="$mixerSpecs" />
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
