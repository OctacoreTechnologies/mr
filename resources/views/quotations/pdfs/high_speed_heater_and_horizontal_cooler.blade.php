<x-header-footer-pdf />
<x-client-pdf-template :quotation="$quotation" />
<x-table-content :specification="'MIXER'" :pageTechnicalData="4" :pageSpecification="7" :pageOffer="12"
    :pageTerms="13" />


<x-technical-data-s-a :quotation="$quotation" />


@php
    $mixerSpecs = [
        [
            'title' => 'Vessel',
            'description' =>
                'Inside Made from SS – 304 Grade Plate and Outside Jacketed by Mild Steel Plate. Jacketed Construction Provided for Heating or Cooling with Suitable Media. Material Discharge Assembly is fitted at the Bottom, Operated by Pneumatic Cylinder. 
    ',
        ],
        [
            'title' => 'Lid',
            'description' => 'Stainless steel - 304 grades. <br/> 
                                 • Equipped with gasket, on lid edge and with lid locking arrangement. The lid is fitted with the Followings flanged openings <br/>
                                   &nbsp;1. One for fitting arrangements for  Deflector and thermocouple .<br />
                                   &nbsp;2. One for addition of chemicals . <br />',

        ],
        [
            'title' => 'Defelector',
            'description' =>
                'Made up of Stainless Steel – 304 grades or Alloy steel Equipped with Thermocouple Wire for Temperature Measurement. Installed with provision of Varying Angle and Height to Ensure Maximum Material Circulation ',
        ],
        [
            'title' => 'Discharge Valve',
            'description' => 'Made Up of SS 304 Provided with Gasket   & Operated Pneumatically',
        ],
        [
            'title' => 'Shaft',
            'description' => 'Shaft is Specially Manufactured from Alloy Steel, Hardened and Ground.',
        ],

        // Add more items as needed
    ];

    $mixerSpecs2 = [
        [
            'title' => 'Mixing Tool',
            'description' =>
                'STAINLESSSTEEL: 304 GRADES. OR ALLOY STEEL. In Heater Mixer Consisting three blades – Bottom   Scraper, Fluidizing blade and Horn Shaped Blade. Specially Designed Shape and Angle Suitable for your Compound with Height adjustment. Spacers with wear resistance treatment.
    ',
        ],

        [
            'title' => 'Bearing Housing',
            'description' =>
                'Mixing Vessel fitted on Steel Plates and Bearing Housing fitted on Steel Plates with Heavy Duty Bearings with Water Cooling and Greasing Arrangements. The resin Leakage to Bearings is Prevented by our Special Design.',
        ],

        [
            'title' => 'Motor',
            'description' => ($quotation->makeMotor?->name ?? '') . '.'
        ],
        [
            'title' => 'Driving System',
            'description' =>
                'The drive system incorporates with V-belt and tapper lock pulley (SPC type) to give Efficient power drive transmission. The Belts  Are Tightened by means of motor sliding screw.',
        ],

        [
            'title' => 'Mounting Structure',
            'description' =>
                'Sturdy MS Channel from Duly Covered with MS Sheet and Coated with Water resistant enamel   Coating Painting.',
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
<x-technical-specification-one :headingText="'TECHNICAL SPECIFICATIONS OF HEATER MIXER'" :items="$mixerSpecs" />
<x-technical-specification-two :items="$mixerSpecs2" />

@php
    $mixerSpecs = [
        [
            'title' => 'Cooling Vessel',
            'description' => 'Inside Made from Stainless Steel SS 304 & Outside Jacketed by Mild Steel Plates. A High Flow Rate of the Operating Medium Creates a Turbulent Flow for an Optimum Heat Exchange with the Product to Realize Shortest Cooling Times. For Fast & Easy Cleaning and Maintenance of the Inside Vessel, the Cooler Mixer Lid can be Opened Across the Total Length of the Vessel. Lid and Vessel are Connected by Adjustable Hinges and Toggle Clamps.',
        ],
        [
            'title' => 'DISCHARGE VALVE',
            'description' => 'Material Discharge Opening Assembly is Fitted at the Bottom Operated
                             by Butterfly Valve. Butterfly Valve Wafer MOC: SS 304 & Seal: EPDM.<br />
                             • A generously dimensioned discharge outlet ensures rapid product
                             emptying and minimizes residue, even for materials with low flowability.
                             ',
        ],
        [
            'title' => 'Mixing Tool',
            'description' => 'MOC: Paddle and Paddle Carrier are SS 304.<br/>• Shaft Fastening is Achieved Using Axially Adjustable Clamping Devices. <br/>
                                  • The Cooling Mixer Paddles Are Engineered for Intensive Axial and
                                  Radial Circulation, Enhancing Both Mixing Efficiency and Cooling
                                  Capacity While Ensuring Optimal Heat Transfer. Even Minimal
                                  Quantities of Fine Components Are Homogeneously Blended During
                                  the Short Cooling Phase',
        ]
        // Add more items as needed
    ];
    $mixerSpecs2 = [
        [
            'title' => 'LID & SAFETY ARRANGEMENT',
            'description' => 'Lid MOC: SS 304. <br/>
                            • Pneumatically Operated with Cylinders. Two-Hand-Operation
                            Operating Angle > 50°. <br/>
                            • Lid Safety: According to Specification System: Solenoid Safety Sensor
                            (Limit Switch).<br/>The Cooling Mixer Lid is Integrated into the Safety
                            Circuit.',
        ],
        [
            'title' => 'BEARING HOUSING & SHAFTING',
            'description' => 'Mixing Shaft Material Mild Steel with SS 304 Thick Pipe Jacketing.<br/>• Power Transfer Directly from the Gear Box with Heavy Duty Bearings, Bearing Housings Fixed on the Shaft with Eccentric Clamping Rings for a Comfortable Maintenance and an Easy Access, the Bearings Are Installed in a Separate Housing Outside the Cooling Mixer Vessel. <br/>Seal Elements: Radial Shaft Seal Rings & Lubrication: Grease Air Purge.</br>
                             • Seal Rings with Air-heterodyne Reliably Keeps the Seat of the Seals
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
@endphp
<x-technical-specification-one heading-number="3." heading-text="TECHNICAL SPECIFICATION OF HORIZONTAL COOLER MIXER"
    :items="$mixerSpecs" />
<x-technical-specification-two :items="$mixerSpecs2" />
<x-technical-specification-two :items="$mixerSpecs3" />

<x-offer :quotation="$quotation" :words="$words" :headingNumber="4" />

<x-term-and-condition-pdf :termCondition="$termCondition" :headingNumber="5" />