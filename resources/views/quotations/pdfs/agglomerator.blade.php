<x-header-footer-pdf />
<x-client-pdf-template :quotation="$quotation" />

<x-table-content :specification="'GRINDER'" :pageTechnicalData="4" :pageSpecification="5" :pageOffer="6" :pageTerms="7" />
<style>
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

    .parameter-table-t .value-cell::before {
        content: ": ";
    }
</style>
<!-- Technical Data -->
<div class="page-break" style="margin-left:-12px;">
    <div class="techincal-data parameter-table-t">
        <h2 style="text-decoration: underline">1. TECHNICAL DATA</h2>
        <!-- DESING PARAMETER OF HIGH-SPEED -->
        <div class="technical-data-sub-head"
            style="text-align:left; width: 95%; font-family: bolder; text-decoration: underline; ">
            {{-- <h3>1.1 <span style="text-decoration: underline;">DESIGN PARAMETER OF HIGH-SPEED MIXTURE</span></h3> --}}
            <h3 style="text-decoration: underline;">1.1 <span>DESIGN PARAMETER OF
                    {{ strtoupper($quotation->machine->name) }}</span></h3>
        </div>
        <table class="parameter-table-t"
            style="border-collapse: collapse; font-size: 14px; position: relative; left: 40px; width: 90%; line-height: 1.1;">
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Model</td>
                <td style="padding: 8px;">:&nbsp;{{ $quotation->modele->name ?? '' }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Application</td>
                <td style="padding: 8px;">:&nbsp;{{ $quotation->application->name ?? '' }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Material To Process</td>
                <td style="padding: 8px;">:&nbsp;{{ $quotation->materialToProcess->material_to_process ?? '' }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Tank
                </td>
                <td style="padding: 8px;">:&nbsp;{{ $quotation->tank ?? '' }} (Thick Plate with Jacketing)</td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Number of Rotaing Blades
                </td>
                <td style="padding: 8px;">:&nbsp;{{ $quotation->no_of_rotating_blades ?? 'N.A' }}Nos</td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Number of Fix Blades</td>
                <td style="padding: 8px;">:&nbsp;{{ $quotation->no_of_fixes_blades ?? 'N.A' }}Nos</td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp;Material</td>
                <td style="padding: 8px;">:&nbsp;{{ $quotation->material ?? 'N.A' }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp;Rotor</td>
                <td style="padding: 8px;">:&nbsp;{{ $quotation->rotor ?? 'N.A' }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp;Pneumatic System</td>
                <td style="padding: 8px;">:&nbsp;{{ $quotation->pneumatic->pneumatic ?? '' }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp;Batch</td>
                <td style="padding: 8px;">:&nbsp;{{ $quotation->batch->batches ?? '' }}Kgs</td>
            </tr>
        </table>
    </div>
</div>

<div class="page-break" style="margin-left:-12px;">
    <div class="techincal-data parameter-table-t" style="text-align: left;width: 95%;">
        <h3 style="text-decoration: underline;">1.2 <span style="">ELECTRICAL PARAMETERS</span></h3>

        <table class="parameter-table" style="padding:5px 0 0 25px">
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
                <td style="padding: 8px;">
                    :&nbsp;Complete Electrical Control Panel comprising of Suitable Ammeter & Voltmeter, Limit Switch &
                    MCCB provided for safety precaution.
                </td>
            </tr>
        </table>
    </div>
</div>
@php
    $mixerSpecs = [
        [
            'title' => 'Vessel',
            'description' =>
                'Inside made from Stainless Steel – 304 grades thick plate and outside jacketed by Mild Steel Plates. Jacketed construction provided for heating or cooling with suitable media.',
        ],
        [
            'title' => 'Vessel Lid',
            'description' =>
                'Stainless steel – 304 grades. Equipped with gasket, on lid edge and with lid locking arrangement.',
        ],
        [
            'title' => 'Deflector',
            'description' => 'Made of Stainless Steel – 304 grades which guide the material to cutting area.',
        ],
        [
            'title' => 'Cutting Tool',
            'description' => 'Alloy Steel Material with Heat Treatment Process.',
        ],
        [
            'title' => 'Discharge Valve',
            'description' => 'Made of SS 304 provided with gasket.',
        ],
        [
            'title' => 'Pneumatic System',
            'description' => $quotation->pneumatic->pneumatic ?? '',
        ],
        [
            'title' => 'Bearing Housing',
            'description' =>
                'Mixing vessel fitted on steel plates and bearing housing fitted on steel plates with heavy duty bearings with water cooling and greasing.',
        ],

        [
            'title' => 'Motor',
            'description' =>
                'Motor 1440 R.P.M AC Motor Drive Transmission Through “V” – belt and Pulley   Arrangement.',
        ],

        [
            'title' => 'Mounting Structure',
            'description' =>
                'Sturdy MS Channel from Duly Covered with MS Sheet and Coated with Water resistant enamel   Coating Painting.',
        ],
    ];

    $mixerSpecs2 = [
        [
            'title' => 'Electrical Control',
            'description' => 'ABB / L&amp; T / SIEMENS Make',
        ],
        [
            'title' => 'Bearing',
            'description' => 'ZKL / FAG / SKF Make',
        ],
        [
            'title' => 'Electrical Control',
            'description' => 'ABB / L&amp; T / SIEMENS Make',
        ],

        [
            'title' => 'Bearing',
            'description' => 'ZKL / FAG / SKF Make',
        ],
    ];

@endphp
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
        margin-left: 20px;
    }

    /* Optional: Improve readability by increasing row height for better spacing */
    .parameter-table td {
        height: 30px;
        /* Adjust row height */
    }
</style>
<x-technical-specification-one heading-number="2." heading-text="TECHNICAL SPECIFICATION OF MIXER" :items="$mixerSpecs" />
<x-technical-specification-two :items="$mixerSpecs2" />
<x-offer :quotation="$quotation" :words="$words" />
<x-term-and-condition-pdf :termCondition="$termCondition" />
