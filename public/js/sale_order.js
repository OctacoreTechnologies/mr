// public/js/sale-order-ledger.js

let ledgerRow = $('#ledger_table tbody tr').length || 1;

function updateLedgerTotal() {
    let total = 0;
    $('#ledger_table tbody tr').each(function () {
        const amount = parseFloat($(this).find('input[name*="[amount]"]').val()) || 0;
        total += amount;
    });

    let grandTotal=$("#ledger-grand-total-amount").val();
    // let adavancePayment=parseFloat($("#total_advanace_amount").val());
    adavancePayment=0;
    // total+=adavancePayment;
    $('#ledger-total-amount').text('₹' + total.toFixed(2));
    // $('#ledger-advance-total-amount').text('₹' + adavancePayment.toFixed(2));
    $('#ledger-pending-total-amount').text('₹' + (grandTotal-total-adavancePayment).toFixed(2) );
    $("#total_advanace_amount").val(total.toFixed(2));
    
}


function bindPaymentModeHandlers() {
    $(document).on('change', '.payment-mode', function () {
        let mode = $(this).val();
        let $row = $(this).closest('tr');

        $row.find('.transaction-id').addClass('d-none').val('');
        $row.find('.remarks').addClass('d-none').val('');

        if (mode === 'online') {
            $row.find('.transaction-id').removeClass('d-none');
        } else if (mode === 'other') {
            $row.find('.remarks').removeClass('d-none');
        }
    });
}

function bindRemoveLedgerRow() {
    $(document).on('click', '.removeLedgerRow', function () {
        $(this).closest('tr').remove();
        updateLedgerTotal();
    });
}

function bindAmountChangeHandler() {
    $(document).on('input', 'input[name*="[amount]"],#total_advanace_amount', function () {
        updateLedgerTotal();
    });
}

function addLedgerRow(payment) {
    let row = `
    <tr>
        <td>
            <input type="hidden" name="payments[${ledgerRow}][type]" value="${payment}" /> 
            <input type="date" name="payments[${ledgerRow}][date]" class="form-control" required>
        </td>
        <td><input type="number" step="0.01" name="payments[${ledgerRow}][amount]" class="form-control amount-input" required></td>
        <td>
            <select name="payments[${ledgerRow}][mode]" class="form-control payment-mode" data-row="${ledgerRow}" required>
                <option value="">Select</option>
                <option value="cash">Cash</option>
                <option value="online">Online</option>
                <option value="other">Other</option>
            </select>
        </td>
        <td>
            <input type="text" name="payments[${ledgerRow}][transaction_id]" class="form-control transaction-id d-none" placeholder="Enter Transaction ID">
        </td>
        <td>
            <textarea name="payments[${ledgerRow}][remarks]" class="form-control remarks d-none" placeholder="Enter Remarks"></textarea>
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-sm btn-danger removeLedgerRow">
                <i class="fas fa-trash-alt"></i>
            </button>
        </td>
    </tr>`;
    $('#ledger_table tbody').append(row);
    ledgerRow++;
    updateLedgerTotal();
}

// Modal Click Function
   function showQuotationDetailsModal() {
        $('#quotationDetailsModal').modal('show');
    }

     function calculateGrandTotal() {
        var totalAmount = parseFloat($('#total_amount').val()) || 0;
        var tax = parseFloat($('#tax').val()) || 0;
        var discountType=$("#discountType").val();
        var discountPercentage = parseFloat($('#discount_percentage').val()) || 0;
        var discount = parseFloat($('#discount_amount').val()) || 0;
        var transporationCharge = parseFloat($("#transporationCharge").val()) ||0;
        var insurance = parseFloat($("#insurance").val()) || 0;
        var packing = parseFloat($("#packing").val()) || 0;
        console.log(totalAmount);
        if(discountType=="percentage"){
            discount=(discountPercentage/100)*totalAmount;
        }
        totalAmount=totalAmount - discount;

        totalAmount = totalAmount+transporationCharge+insurance+packing;

        // Calculate GST amount
        var gstAmount = (totalAmount * tax) / 100;

        // Calculate Grand Total
        var grandTotal = totalAmount + gstAmount;

        // Set the calculated grand total
        $('#ledger-grand-total-amount').val(grandTotal.toFixed(2));
        $('#ledger-grand-total-amounts').text('₹'+grandTotal.toFixed(2));
    }
    
 function discountShowHide(discount){
    console.log(discount)
    if(discount == "none"){
          $('#discountPercentage').hide();
          $('#discountAmount').hide();
        //   $("#discountDiv").hide();
          $('#discount_percentage').val(0); 
          $('#discount_amount').val(0);
    }
    else if(discount == "percentage"){
          $('#discountPercentage').show();
          $('#discountAmount').hide();

        // $('#discount_percentage').val(0); 
          $('#discount_amount').val(0);
    }
    else if(discount == "amount"){
          $('#discountPercentage').hide();
          $('#discountAmount').show();

           $('#discount_percentage').val(0); 
        //   $('#discount_amount').val(0);
    }
    else{
        $("#discountDiv").show();
    }
 }
 function transporationpaymentHideandShow(payment){
     if(payment == true){
        $("#transporationChargeDiv").show();
      }
      else{

        $("#transporationChargeDiv").hide();
        $("#transporationCharge").val(0)
      }
 }
     // Main initializer
 $(document).ready(function () {
    $('.select2').select2();

   $('#addLedgerRow').on('click', function () {
      console.log($(this).data('pay'));
      addLedgerRow($(this).data('pay'));
   });


    bindPaymentModeHandlers();
    bindRemoveLedgerRow();
    bindAmountChangeHandler();

    updateLedgerTotal(); // On load

    $('#total_amount, #tax, #discount, #discount_amount, #discount_percentage , #discountType, #transporationCharge,#insurance,#packing').on('input', function() {
        calculateGrandTotal();
    });

    let payment = $("#transporationpayment").val();
    transporationpaymentHideandShow(payment);
    $("#transporationpayment").change(function(){
      payment = $(this).val();
      transporationpaymentHideandShow(payment);
     
    });

    let discountType = $("#discountType").val();
    discountShowHide(discountType);
    $("#discountType").change(function(){
     discountType = $(this).val()
     discountShowHide(discountType)
    });

    // customer account details pdf

    //start 
     $('.view-account-btn').on('click', function() {
        var saleOrderId = $(this).data('id');

        // Call API to get details
        $.ajax({
            url: 'https://mrcrm.test/sale-order/' + saleOrderId + '/account-details',
           
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    var data = response.data;
                    var customer = data.quotation.customer;
                    var machine =data.quotation.machine;
                    var model = data.quotation.modele;
                    var total_amount=parseFloat(data.total_amount??0);
                    var transporation_charge= parseFloat(data.transporation_charge??0)
                    var tax= parseFloat(data.tax ?? '0');
                    var totalTaxAmount =parseFloat(((total_amount + transporation_charge)*tax)/100);
                    var grand_total=parseFloat(totalTaxAmount+total_amount-data.discount+transporation_charge);
                    var advancePayment=parseFloat(data.advanace_payment??0);
                    var balancePayment=parseFloat(grand_total-advancePayment);
                    var payments=data.payments;
                    var total_transporation = 0;
                    var total_freight = 0;
                
                    payments.forEach(function(payment) {
                        if (payment.type === 'transportation') {
                            total_transporation += parseFloat(payment.amount); // Sum the amount for deliveries
                        } 
                        else if (payment.type === 'freight') {
                            total_freight += parseFloat(payment.amount); // Sum the amount for freight
                        }
                    });


                    var html = `
                       <tr><th>1. Company Name & Address</th><td>${customer.company_name ?? 'N/A'}<br>${data.address ?? 'N/A'}</td></tr>
                        <tr><th>2. Contact Person</th><td>${customer.contact_person_1_name ?? 'N/A'}</td></tr>
                        <tr><th>3. Contact Number</th><td>${customer.contact_no ?? 'N/A'}</td></tr>
                        <tr><th>4. Machine Name</th><td>${machine.name ?? 'N/A'}</td></tr>
                        <tr><th>5. Model No.</th><td>${model.name ?? 'N/A'}</td></tr>
                        <tr><th>6. Customer PO No.</th><td>${data.po_no ?? 'N/A'}</td></tr>
                        <tr><th>7. PO Date Received by MR</th><td>${data.order_date ?? 'N/A'}</td></tr>
                        <tr><th>8. Work Order No.</th><td>${data.work_order_no ?? 'N/A'}</td></tr>
                        <tr><th>9. Delivery Date</th><td>${data.delivery_date ?? 'N/A'}</td></tr>
                        <tr><th>10. Total Basic Price</th><td>${data.total_amount ?? 'N/A'}</td></tr>
                        <tr><th>11. Transportation</th><td>${data.transporation_charge ?? 'N/A'}</td></tr>
                        <tr><th>12. Total GST Price</th><td>${totalTaxAmount}</td></tr>
                        <tr><th>13. Total Final Price</th><td>${grand_total ?? 0 + data.transporation_charge ?? 'N/A' }</td></tr>
                        <tr><th>14. Total Advance</th><td>${advancePayment}</td></tr>
                        <tr><th>15. Balance Payment</th><td>${grand_total-advancePayment ?? 'N/A'}</td></tr>
                        <tr><th>16. Freight</th><td>${total_freight ?? 'N/A'}</td></tr>
                    `;
                    $('#accountDetailsBody').html(html);

                    // Set PDF download link
                    $('#downloadPdfBtn').attr('href', '/sale-order/' + saleOrderId + '/account-pdf');

                    // Show modal
                    $('#accountDetailsModal').modal('show');
                } else {
                    alert('Could not load data');
                }
            },
            error: function(err) {
                console.error(err);
                alert('Something went wrong');
            }
        });
    });
    //end here

 });

