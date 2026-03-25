<x-header-footer-pdf />
<x-client-pdf-template :quotation="$quotation" />
<x-table-content :specification="'VERTICAL COOLER MIXER'" :pageTechnicalData="4" :pageSpecification="6" :pageOffer="7" :pageTerms="8"/>
<x-technical-data :quotation="$quotation" />

@php
        $mixerSpecs = [
     [
        'title' => 'Cooling Vessel',
        'description' => 'Inside Made from Stainless Steel with
        Cooling Ring <br/> MOC – 304 Grade. Outside
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
            'title' => 'Motor',
             'description' => ($quotation->makeMotor?->name ?? '') . '.'
        ],
        [
            'title' => 'Driving System',
            'description' =>'The drive system incorporates with V-belt and tapper lock pulley (SPC type) to give Efficient power drive transmission. The Belts Are Tightened by means of motor sliding screw.'
        ],
        // Add more items as needed
    ];
@endphp

<x-technical-specification-one  heading-number="2."  heading-text="TECHNICAL SPECIFICATION OF VERTICAL COOLER MIXER" :items="$mixerSpecs" />
<x-offer :quotation="$quotation" :words="$words"/>
<x-term-and-condition-pdf :termCondition="$termCondition" />