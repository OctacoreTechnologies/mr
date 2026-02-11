<x-header-footer-pdf />
<x-client-pdf-template :quotation="$quotation" />
<x-table-content :specification="'MIXER'" :pageTechnicalData="4" :pageSpecification="7" :pageOffer="12" :pageTerms="13" />


<x-technical-data-s-a :quotation="$quotation" />

<!-- Technical Specifification -->
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

@php
    $mixerSpecs = [
        [
            'title' => 'Vessel (Heater & Cooler)',
            'description' =>
                ' Inside Made from SS – 304 Grade Plate and Outside Jacketed by Mild Steel Plate.   Jacketed Construction Provided for Heating or Cooling with Suitable Media. Material Discharge Assembly is fitted at the Bottom, Operated by Pneumatic Cylinder. Cooling Ring MOC – 304 Grade.',
        ],
        [
            'title' => 'Lid',
            'description' => 'Stainless steel - 304 grades. <br/> 
                             Equipped with gasket, on lid edge and with lid locking arrangement. The lid is fitted with the Followings flanged openings <br/>
                             1. One for fitting arrangements for  Deflector and thermocouple .<br />
                             2. One for addition of chemicals . <br />
                             3. Two for viewing glasses, operated pneumatically.  <br />',
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

        // Add more items as needed
    ];

    $mixerSpecs2 = [
        [
            'title' => 'Mixing Tool',
            'description' =>
                'In Heater Mixer. Specially Designed Shape and Angle Suitable for your Compound with Height adjustment. Spacers with wear resistance treatment. Cooler Mixer Blade Made from STAINLESSSTEEL: 304 specially designed shovel type',
        ],

        [
            'title' => 'Bearing Housing',
            'description' =>
                'Mixing Vessel fitted on Steel Plates and Bearing Housing fitted on Steel Plates with Heavy Duty Bearings with Water Cooling and Greasing Arrangements. The resin Leakage to Bearings is Prevented by our Special Design.',
        ],

        [
            'title' => 'Motor',
            'description' =>
                'Motor 1440 R.P.M AC Motor Drive Transmission Through “V” – belt and Pulley   Arrangement.',
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
            'description' => 'ABB / L&amp; T / SIEMENS Make',
        ],
        [
            'title' => 'AC Frequency Drive',
            'description' => 'Yaskawa Make',
        ],
        [
            'title' => 'Bearing',
            'description' => 'ZKL / FAG / SKF Make',
        ],
        [
            'title' => 'Pneumatic Control',
            'description' => 'JANATICS / SPAC Make',
        ],
    ];
@endphp
<x-technical-specification-one :headingText="'TECHNICAL SPECIFICATIONS OF HIGH-SPEED HEATER MIXER'" :items="$mixerSpecs" />
<x-technical-specification-two :items="$mixerSpecs2" />

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
        ]
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

 $mixerSpecs3 =[
        [
            'title' => 'Pneumatic Control',
            'description' => 'SPAC / JANATICS',
        ],
        [
            'title' => 'Gear Box',
            'description' => 'Heli Bevel',
        ],
        [
            'title' => 'Motor Motors',
            'description' => 'T Hindustan / ABB / SIEMENS 1440 RPM AC ',
        ],
        [
            'title' => 'Driving System',
            'description' => 'The drive system incorporates Direct Motor and Gear Box assembly driven.',
        ],
 ];
@endphp
<x-technical-specification-one heading-number="3." heading-text="TECHNICAL SPECIFICATION OF MIXER" :items="$mixerSpecs" />
<x-technical-specification-two :items="$mixerSpecs2" />
<x-technical-specification-two :items="$mixerSpecs3" />

<x-offer :quotation="$quotation" :words="$words" />

<x-term-and-condition-pdf :termCondition="$termCondition" />
