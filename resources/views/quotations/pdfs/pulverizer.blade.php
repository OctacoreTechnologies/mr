<x-header-footer-pdf />
<x-client-pdf-template :quotation="$quotation" />
<x-table-content :specification="'GRINDER'" :pageTechnicalData="4" :pageSpecification="5" :pageOffer="6" :pageTerms="7" />
<!-- Technical Data -->
<div class="page-break ">
    <div class="techincal-data parameter-table">
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
                <td style="padding: 8px;">:&nbsp;{{ $quotation->modele->name ?? '' }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Application</td>
                <td style="padding: 8px;">:&nbsp;{{ $quotation->application->name ?? '' }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Size of Input Material</td>
                <td style="padding: 8px;">:&nbsp;{{ str_replace(',', ' to ', $quotation->size_of_input_material ?? '') }} mm</td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Output</td>
                <td style="padding: 8px;">:&nbsp;{{ $quotation->output ?? '' }} Kgs</td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Finished Mesh Size</td>
                <td style="padding: 8px;">:&nbsp;{{ $quotation->finish_mesh_size ?? 'N.A' }} Mesh</td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp;Cutting Disk</td>
                <td style="padding: 8px;">:&nbsp;Constructed from Alloy Steel and Heat Treatment Process for Enhanced
                    Strength and Durability.</td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp;Blower</td>
                <td style="padding: 8px;">:&nbsp;{{ $quotation->blower->blower ?? '' }} HP for conveying</td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp;Rotary Air Lock Valve</td>
                <td style="padding: 8px;">:&nbsp;{{ $quotation->rotaryAirLockValve->rotary_air_lock_valve ?? '' }} HP
                    along with Dust Collector with Filter</td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp;Water Cooling</td>
                <td style="padding: 8px;">:&nbsp;Water Cooling Arrangements Provided for Bearings and Complete Body</td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp;Vibrator</td>
                <td style="padding: 8px;">:&nbsp;Circular Type Double Desk One for finished & Another for Re-grinding
                    with Anti-dusting System</td>
            </tr>
        </table>


    </div>
</div>

<div class="page-break">
    <div class="techincal-data parameter-table" style="text-align: left;width: 95%;">
        <h3 style="text-decoration: underline;">1.2 <span style="">ELECTRICAL PARAMETERS</span></h3>

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
            'title' => 'Feeding Unit',
            'description' => 'Material Feed to Cutting Chamber via 	Vibratory System. Made Up of SS 304',
        ],
        [
            'title' => 'Cutting Chamber',
            'description' =>
                'Steel Fabricated Cutting Chamber. Complete Chamber is Water Cooled to Take Away Their	Frictional Heat Generated During High-Speed Grinding',
        ],
        [
            'title' => 'Air Cooling Blower',
            'description' => 'Filtered and Water Cooler Air Blown into Cutting Chamber to Keep the Inside Chamber Cool',
        ],
        [
            'title' => 'Vibrator',
            'description' => 'Double Deck with Self-cleaning System ',
        ],
        [
            'title' => 'Feeding Hopper',
            'description' => ($quotation->feedingHooperCapacity->feeding_hooper_capacity??'100')." Ltr",
        ],
        [
            'title' => 'Conveying Pipe',
            'description' => ($quotation->conveying_pipe ?? ''). ' MM Dia',
        ],
        [
            'title' => 'Advantage',
            'description' =>
                'Compact and Space Saving Design Short Materials Dwell Time in the Pulverizer Chamber. Universal Adaptability to Different Fine Grinding Applications. Easy Changing of Grinding Tools ',
        ],
        [
            'title' => 'Driving System',
            'description' =>
                'The drive system incorporates with V-belt and tapper lock pulley (SPC type) to give Efficient power drive transmission. The Belts Are Tightened by means of motor sliding screw.',
        ],
        // Add more items as needed
    ];
@endphp
<x-technical-specification-one heading-number="2." heading-text="TECHNICAL SPECIFICATION OF MIXER" :items="$mixerSpecs" />

<x-offer :quotation="$quotation" :words="$words" />
<x-term-and-condition-pdf :termCondition="$termCondition" />
