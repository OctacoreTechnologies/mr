  $(document).ready(function () {
        $('#modalMin').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            $('#modalQuotationId').val(button.data('id'));
            $('#modalReferenceNo').val(button.data('reference_no'));
            $('#isVerified').val(button.data('verified'));
            $('#customerName').val(button.data('customer_name'));
        });

        $('#sendEmailModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            emailDetails(button.data('application_id'))
            $('#quotation_id').val(button.data('id'));
            $('#customer_id').val(button.data('customer_id'));
            customerDetail($("#customer_id").val());
            $('#emailCustomerName').val(button.data('customer_name'));
            $('#emailCustomerEmail').val(button.data('customer_email'));
            var isVerify=button.data('isverify');
               if(isVerify == 1) {
               $('#withPdf').prop('checked', true);  
               } else {
                   $('#withPdf').prop('checked', false); 
               }
            
        });
        $("#updateQuotationStatus").on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            $('#quotationId').val(button.data('quotationid'));
            $('#statusCustomerName').val(button.data('customer_name'));
            $('#referenceNo').val(button.data('reference_no'));
            $('#status').val(button.data('status'));
        });
    });


function emailDetails(applicationId) {
    if (!applicationId) return;

    console.log(applicationId);

    $.ajax({
        url: `/mail/application/${applicationId}`, 
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data && data.email) {
                const email = data.email;

                $('#subject').val(email.subject || '');
                $('#message').val(email.messages || '');
            } else {
                // If no email data returned
                $('#subject').val('');
                $('#message').val('');
                console.warn('⚠️ No email data found for application ID:', applicationId);
            }
        },
        error: function(xhr, status, error) {
            console.error('❌ Failed to fetch email details:', error);
            $('#subject').val('');
            $('#message').val('');
        }
    });
}

function customerDetail(customerId){
    if(!customerId) return;
    console.log(customerId);

    $.ajax({
        url:`/get-customer/${customerId}`,
        type:'GET',
        dataType:'json',
        success: function(data){
            // console.log(data);

            console.log(data.customer);
              $('#email').empty();
              $.each(data.customer, function(key, email) {
                if (email !== null) {
                    // Create a checkbox with Bootstrap styling
                    const checkboxDiv = $('<div></div>').addClass('form-check email-checkbox');
                    const checkbox = $('<input>', {
                        type: 'checkbox',
                        id: key,
                        name: key,
                        value: email,
                        class: 'form-check-input'
                    });
                    const label = $('<label>', {
                        for: key,
                        class: 'form-check-label',
                        text: email
                    });

                    // Append checkbox and label to the container
                    checkboxDiv.append(checkbox).append(label);
                    $('#email').append(checkboxDiv);
                }
            });

        },
        error:function(xhr,status,error){
            console.log('Failed to fetch customer details:',error);
              $('#email').empty();
        }
    })
}
