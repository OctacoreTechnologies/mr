$(document).ready(function() {
    $(".application2").hide();

    $('#is_two_application').change(function() {
        if ($(this).is(':checked')) {
            $(".application2").show();

            // Reinitialize or trigger Select2 to resize correctly
            $(".application2 select").select2(); // Optional, only if needed
            $(".application2 select").trigger('change.select2');
            $('.select2-selection--single').addClass('h-100'); // Ensures it redraws with correct width

        } else {
            $(".application2").hide();
        }
    });
});
