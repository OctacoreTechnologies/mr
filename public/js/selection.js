$(document).ready(function(){


      $('#machine_id').on('change', function () {
            let machineId = $(this).val();
            let selectedText = $(this).find("option:selected").text();
            // $('#machine_label').text(`Select ${selectedText}`);

            if (machineId) {
                //Models
                $.ajax({
                    url: '/categories/options/models/' + machineId,
                    type: 'GET',
                    success: function (models) {
                        $("#model").show();
                        $('#model_id').empty().append('<option value="">Select Model</option>');

                        $.each(models, function (key, model) {
                            $('#model_id').append('<option value="' + model.id + '">' + model.name + '</option>');
                        });

                        // If you're using select2
                        $('#model_id').trigger('change');
                    }
                });

            } else {
                $('#application_id').empty().append('<option value="">Select Application</option>');
                // $('#machine_label').text('Select Machine');
                $('#model_id').empty().append('<option value="">Select Model</option>');
            }

        });
});