<x-header-footer-pdf />
<x-client-pdf-template :quotation="$quotation" />
<x-table-content :specification="'VERTICAL COOLER'" :pageTechnicalData="4" :pageSpecification="6" :pageOffer="6" :pageTerms="7"/>
<x-technical-data :quotation="$quotation" />

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
        Pneumatic Cylinder.
        '
       ],
        [
            'title' => 'Mounting Structure',
            'description' => 'Sturdy MS Channel from Duly Covered with MS Sheet and Coated with Water Resistant Enamel Coating Painting'
        ],
        [
            'title' => 'Electrical Control',
            'description' =>$quotation->electricalControl->electrical_control??''
        ],
        [
            'title' => 'Bearing',
            'description' =>$quotation->bearinge->bearing??''
        ],
        [
            'title' => 'Pneumatic Control',
            'description' =>$quotation->pneumatic->pneumatic??''
        ],
        [
            'title' => 'Gear Box',
            'description' =>'Heli Bevel'
        ],
        [
            'title' => 'Motor Motors',
            'description' =>'T Hindustan / ABB / SIEMENS 1440 RPM AC '
        ],
        [
            'title' => 'Driving System',
            'description' =>'The drive system incorporates with V-belt and tapper lock pulley (SPC type) to give Efficient power drive transmission. The Belts Are Tightened by means of motor sliding screw.'
        ],
        // Add more items as needed
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
<x-technical-specification-one  heading-number="2."  heading-text="TECHNICAL SPECIFICATION OF MIXER" :items="$mixerSpecs" />
<x-offer :quotation="$quotation" :words="$words"/>
<x-term-and-condition-pdf :termCondition="$termCondition" />