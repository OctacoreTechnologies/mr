  
  <style>
  .lastpage{
    position: relative;
    top:110px;

   }
    .techincal-data {
      position: absolute;
      top: 115px;
    }
  </style>
  <div class="page-break">
  <div class="lastpage">
    <div class="technical-data" style="margin-bottom: 70px;">
      <h2 style="text-decoration:underline; font-weight: bold;" >4.&nbsp;<span>TERMS AND
          CONDITION</span></h2>
    </div>
    <table border="1"
      style="border-collapse: collapse; width: 100%;  font-size: 14px; line-height: 0.9;">
      <tr>
        <td style="font-weight: bold; padding: 8px;">Price</td>
        <!-- <td style="padding: 8px;">Above prices are EX our works, Kachigam Daman</td> -->
        <td style="padding: 8px;">{{ $termCondition->price }}</td>
      </tr>
      <tr>
        <td style="font-weight: bold; padding: 8px;">Tax</td>
        <!-- <td style="padding: 8px;">GST @18%, will be applicable</td> -->
        <td style="padding: 8px;">{{ $termCondition->tax }}</td>
      </tr>
      <tr>
        <td style="font-weight: bold; padding: 8px;">Delivery</td>
        <td style="padding: 8px;">{{ $termCondition->delivery }}</td>
      </tr>
      <tr>
        <td style="font-weight: bold; padding: 8px;">Payment</td>
        <td style="padding: 8px;">{{ $termCondition->payment }}</td>
      </tr>
      <tr>
        <td style="font-weight: bold; padding: 8px;">Packing</td>
        <!-- <td style="padding: 8px;">Extra at actual.</td> -->
        <td style="padding: 8px;">{{ $termCondition->packing }}</td>
      </tr>
      <tr>
        <td style="font-weight: bold; padding: 8px;">Forwarding</td>
        <!-- <td style="padding: 8px;">Extra at actual.</td> -->
        <td style="padding: 8px;">{{ $termCondition->forwarding }}</td>
      </tr>
      <tr>
        <td style="font-weight: bold; padding: 8px;">Validity</td>
        <!-- <td style="padding: 8px;">30 days</td> -->
        <td style="padding: 8px;">{{ $termCondition->validity }}</td>
      </tr>
      <tr>
        <td style="font-weight: bold; padding: 8px;">Commissioning charges</td>
        <!-- <td style="padding: 8px;">
      Customer should provide food & accommodation & to & fro ticket Charges and local transportation.
      If commission is carried more than 2 Days, then the Customer has to pay the charges of Rs. 3,500.00 per day.
    </td> -->
        <td style="padding: 8px;">{{ $termCondition->commissioning_charges }}</td>
      </tr>
      <tr>
        <td style="font-weight: bold; padding: 8px;">Guarantee</td>
        <!-- <td style="padding: 8px;">
      One calendar year from date of dispatch, if any manufacturing Defects.
      No Guarantee for Bought out Items as they are purchase from Standard make
    </td> -->
        <td style="padding: 8px;">{{ $termCondition->guarantee }}</td>
      </tr>
      <tr>
        <td style="font-weight: bold; padding: 8px;">Cancellation of Order</td>
        <!-- <td style="padding: 8px;">
      Orders once placed will not be subsequently cancelled for any Reason whatsoever.
      In the case of orders being cancelled, the entire Amount of the advance will be forfeited
    </td> -->
        <td style="padding: 8px;">{{ $termCondition->cancellation_of_order }}</td>
      </tr>
      <tr>
        <td style="font-weight: bold; padding: 8px;">Judiciary</td>
        <!-- <td style="padding: 8px;">Subject to Daman Judiciary only</td> -->
        <td style="padding: 8px;">{{ $termCondition->judiciary }}</td>
      </tr>
      <tr>
        <td style="font-weight: bold; padding: 8px;">Not in our Scope of Supply</td>
        <!-- <td style="padding: 8px;">
      Civil Works Pipe and Pipe line works, Cabling Works, Installation of machine
    </td> -->
        <td style="padding: 8px;">{{ $termCondition->not_in_our_scope_of_supply }}</td>
      </tr>
    </table>
  </div>

  </div>

</body>

</html>