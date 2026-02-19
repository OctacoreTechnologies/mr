<div style="position: relative; font-size: 16px; padding: 170px 0px 0 10px; line-height: 1.2;">


    <!-- Title Section -->
    <div style="padding:35px 0 0 0; padding-left: 0;">
        <div
            style="text-align:center; font-size: 30px; font-weight: bold; color: #2daae3;  text-transform: uppercase; word-spacing: 3px; font-family:'Montserrat',sans-serif !important ; font-style:normal; text-decoration: underline;">
            TECHNO-COMMERCIAL {{ $quotation->reflect_in_pdf ? 'Revised' : '' }} OFFER
        </div>

        <div
            style="font-size: 25px; margin-top: 5px; text-align: center; width: 100%; white-space: normal; word-break: break-word;">
            Proposal for {{ $quotation->machine->name ?? '' }}
            <span style="white-space: nowrap;">
                Model {{ $quotation->modele->name ?? '' }}
            </span>
        </div>


    </div>

    <!-- Client Info Table -->
    <table style="width: 100%; border-collapse: collapse; margin-top: 25px; margin-left: 25px; font-size: 16px; ">
        <tr>
            <td style="width: 160px; color: #032854; padding: 3px 2px; vertical-align: top;">Client Name</td>
            <td style="width: 10px; text-align: center; padding: 3px;">:</td>
            <td style="padding: 3px 0; word-break: break-word; white-space: normal;">
                {{ $quotation->customer->company_name ?? '' }}
            </td>
        </tr>

        <tr>
            <td style="color: #032854; padding: 3px 2px; vertical-align: top;">Address</td>
            <td style="width: 10px; text-align: center; padding: 3px; vertical-align: top;">:</td>
            <td style="padding: 3px 0;padding-right:15px; word-break: break-word; white-space: normal; line-height:1;">
                {{ $quotation->customer->address_line_1 ?? '' }},
                {{ $quotation->customer->city ?? 'Valsad' }},
                {{ $quotation->customer->state ?? 'Gujarat' }}
                {{ $quotation->customer->pincode ?? '122345' }}
            </td>
        </tr>

        <tr>
            <td style="color: #032854; padding: 3px 2px;">Ref. No</td>
            <td style="text-align: center; padding: 3px;">:</td>
            <td style="padding: 3px 0;">{{ $quotation->reference_no ?? '' }}</td>
        </tr>

        <tr>
            <td style="color: #032854; padding: 3px 2px;">Date</td>
            <td style="text-align: center; padding: 3px;">:</td>
            <td style="padding: 3px 0;">{{ formatDate($quotation->date ?? '') }}</td>
        </tr>

        <tr>
            <td style="color: #032854; padding: 3px 2px;">Kind Attn</td>
            <td style="text-align: center; padding: 3px;">:</td>
            <td style="padding: 3px 0;">{{ $quotation->customer->contact_person_1_name ?? '' }}</td>
        </tr>

        <tr>
            <td style="color: #032854; padding: 3px 2px;">Contact No</td>
            <td style="text-align: center; padding: 3px;">:</td>
            <td style="padding: 3px 0;">
                @php
                    $countryCode = $quotation->customer->country_code ?? '+91';
                    $contactNo = $quotation->customer->contact_no ?? '8912929114';
                @endphp

                {{ $countryCode . '-' . substr($contactNo, 0, 5) . ' ' . substr($contactNo, 5) }}

            </td>
        </tr>

        <tr>
            <td style="color: #032854; padding: 3px 2px;">E–Mail ID</td>
            <td style="text-align: center; padding: 3px;">:</td>
            <td style="padding: 3px 0; color: #00AEEF; word-break: break-word; white-space: normal;">
                {{ $quotation->customer->contact_person_1_email ?? 'demo1298@gmail.com' }}
            </td>
        </tr>
    </table>
    <div style="position: absolute; bottom: 120px; left: 35px; right: 25px; width: calc(100% - 50px);">
        <table style="width: 100%; font-size: 15px; font-family: 'Poppins'; line-height: 9px;">
            <tr>
                <!-- Submitted By: Left aligned -->
                <td style="width: 33.33%; text-align: left;">
                    <div
                        style="font-weight: bold; font-size: 16px; border-bottom: 1px solid black; display: inline-block; padding-bottom: 3px;">
                        Submitted By
                    </div>
                    <div style="margin-top: 5px; margin-left: 8px;">
                        {{ $quotation->followedBy->name ?? 'Yogesh Gajjar' }}
                    </div>
                </td>

                <!-- Contact No.: Center aligned -->
                <td style="width: 33.33%; text-align: center;">
                    <div
                        style="width: 60%; font-weight: bold; border-bottom: 1px solid black; display: inline-block; padding-bottom: 3px; font-size: 16px;">
                        Contact No.
                    </div>
                    <div style="margin-top: 5px;">  {{ '+91-' .
                                substr(optional($quotation->followedBy)->contact_no ?? '8912929114', 0, 5) .
                                ' ' .
                                substr(optional($quotation->followedBy)->contact_no ?? '8912929114', 5) }}</div>
                </td>

                <!-- E–Mail ID: Right aligned -->
                <td style="width: 33.33%; text-align: center;">
                    <div
                        style="width: 60%; font-weight: bold; border-bottom: 1px solid black; display: inline-block; padding-bottom: 3px; font-size: 16px;">
                        E– Mail ID
                    </div>
                    <div style="margin-top: 2px; text-align: center;">
                        <span style="color: #00AEEF;">
                            {{ $quotation->followedBy->email ?? 'yogesh@mrengineers.co.' }}
                        </span>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class='img'>
        <div class="border-box">
            <img src="{{ asset('storage/' . $quotation->machine->image_url) ?? 'mixture.png' }}" class="main-image "
                style="z-index: 0;">
        </div>
        <p
            style="position: fixed;bottom: 360px; left: 45%;  transform: translateX(-50%); font-size: 16px; margin: 0;  text-align: center; font-weight:bolder;width:100%">
            *The image shown above is for reference purposes only.
        </p>

    </div>
