$(document).ready(function(){

    // Location Type Change
    $('#location_type').change(function () {
        updateFormByType($(this).val());
    });

    // Region Change → Load States
    $('#region').change(function () {

         let regionId = $(this).find(':selected').data('regionId');
        console.log(regionId);

        if(regionId){

            $('#state').html('<option value="">Loading...</option>');

            $.ajax({
                url: '/get-states/' + regionId,
                type: 'GET',
                success: function(data){

                    $('#state').empty();
                    $('#state').append('<option value="">-- Select State --</option>');

                    $.each(data, function(key, state){
                        $('#state').append(
                            `<option value="${state.name}">${state.name}</option>`
                        );
                    });

                }
            });

        } else {
            $('#state').html('<option value="">-- Select State --</option>');
        }

    });

    // Page Load (Edit Support)
    const selectedType = $('#location_type').val();
    updateFormByType(selectedType);

});


function updateFormByType(type) {

    if (type === 'domestic') {

        $('#continent').val('asia');
        $('#country').val('india');

        $('#regionGroup').show();     // ✅ Region show
        $('#stateGroup').show();      // ✅ State show

    } else {

        $('#continent').val('');
        $('#country').val('');
        $('#region').val('');
        $('#state').val('');

        $('#regionGroup').hide();     // ❌ Region hide
        $('#stateGroup').hide();      // ❌ State hide
    }
}
