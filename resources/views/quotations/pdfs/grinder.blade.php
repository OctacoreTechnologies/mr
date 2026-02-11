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
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Blade MOC</td>
                <td style="padding: 8px;">:&nbsp; Made of Alloy of Steel</td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Number of Rotating Blades
                </td>
                <td style="padding: 8px;">:&nbsp;{{ $quotation->no_of_rotating_blades ?? '' }} Nos</td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Number of Fix Blades</td>
                <td style="padding: 8px;">:&nbsp;{{ $quotation->no_of_fixes_blades ?? 'N.A' }}Nos</td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp;Throat Size</td>
                <td style="padding: 8px;">:&nbsp;305 X 305</td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp;Capacity</td>
                <td style="padding: 8px;">:&nbsp;{{ $quotation->capacity ?? '' }}Kg/hr*(Depend on Material)</td>
            </tr>
        </table>


        <div class="technical-data-sub-head" style="text-align: left;width: 95%;">
            <h3 style="text-decoration: underline;">1.2 <span style="">ELECTRICAL PARAMETERS</span></h3>
        </div>
        <table class="parameter-table"
            style="border-collapse: collapse; font-size: 14px; position: relative; left: 40px; width: 90%; line-height: 1.1;">
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Motor Requirement</td>
                {{-- <td style="padding: 8px;">:&nbsp;15 KW/20 HP Single Speed Mixer – 1440 RPM</td> --}}
                <td style="padding: 8px;">:&nbsp;{{ $quotation->motorRequirement->motor_requirement }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; vertical-align: top; white-space: nowrap;">• &nbsp; Motor Make</td>
                {{-- <td style="padding: 8px;">:&nbsp;15 KW/20 HP Single Speed Mixer – 1440 RPM</td> --}}
                <td style="padding: 8px;">:&nbsp;{{ $quotation->makeMotor->name ?? '' }}</td>
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

<!-- Technical Specification of Grinder -->
<div class="page-break" style="padding: 100px 20px 15px 10px;  font-size: 14px;  box-sizing: border-box;">
    <div class="technical-datayrt">

        <h2 style="margin-bottom: 10px; text-decoration: underline;">2.&nbsp; TECHNICAL SPECIFICATION OF GRINDER</h2>

        <!-- 2.2 MIXING VESSEL LID -->
        <div style="font-size: 11pt; line-height: 1.5; padding-left: 10px;">
            <ul style="margin: 0; padding-left: 18px; list-style-type: disc;">
                <li style="margin-bottom: 6px; text-align: justify;">
                    Grinder’s Body and Rotor fabricated from thick steel plates. It is designed to cut any types of
                    heavy-duty lumps, thicker pipes, bottles, injection / blow moulded articles of any material.
                </li>
                <li style="margin-bottom: 6px; text-align: justify;">
                    Design of Rotor and Blades restricts the powdery formation of lump or article.
                </li>
                <li style="margin-bottom: 6px;">
                    Easy Body Cleaning / Easy Blade Setting
                </li>
                <li style="margin-bottom: 6px;">
                    Screw Type Mechanical Operated <span style="font-style: italic;">(Optional)</span>
                </li>
                <li style="margin-bottom: 6px; text-align: justify;">
                    Limit Switch Attachment provided to hopper, as the hopper is opened, machine will not get start.
                </li>
                <li style="margin-bottom: 6px; text-align: justify;">
                    For keeping the complete body cool (frictional heat is developed during grinding) for bearing
                    housing.
                </li>
                <li style="margin-bottom: 6px;">
                    Sound proof grinder and thus operator's efficiency increases. <span
                        style="font-style: italic;">(Optional)</span>
                </li>
                <li style="margin-bottom: 6px; text-align: justify;">
                    In Electrical Controlled Panel, all electrical switchgear from ABB or L&T – make. Two MCBs are used
                    instead of fuses: one for motor protection and other for circuit.
                </li>
                <li style="margin-bottom: 6px;">
                    Highly Precise Blade made from fully hardened material and duly grinded.
                </li>
                <li style="margin-bottom: 6px;">
                    Blades are easy to replace with a minimum down time.
                </li>
                <li style="margin-bottom: 6px;">
                    No adjustment of rotor cutting blades necessary.
                </li>
            </ul>
        </div>


    </div>
</div>

<x-offer :quotation="$quotation" :words="$words" />
<x-term-and-condition-pdf :termCondition="$termCondition" />
