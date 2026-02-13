$(document).on('input', '.country-select', function () {

    var code = $(this).find(':selected').data('code');


    $('.country-code').text(code);
    $('#countryCodeField').val(code);
    $('.country_code_field').val(code);
});