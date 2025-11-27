 $(document).ready(function(){

        // Handle dropdown change
      $('#location_type').change(function () {
        updateFormByType($(this).val());
      });

      // On page load (Edit View support)
      const selectedType = $('#location_type').val();
      if (selectedType) {
        updateFormByType(selectedType);
      }
  });
       



    
    function updateFormByType(type) {
      if (type === 'domestic') {
         $('#continent').val('asia');
         $('#country').val('india');
         $('#stateGroup').css('display', 'block');
      } else if (type === 'international') {
          $('#continent').val('');
          $('#country').val('');
          $('#state').val('');
          $('#stateGroup').css('display', 'none');
      } else {
          $('#continent').val('');
          $('#country').val('');
          $('#state').val('');
          $('#stateGroup').css('display', 'none');
      }
    }