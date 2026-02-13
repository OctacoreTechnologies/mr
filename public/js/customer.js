document.addEventListener('DOMContentLoaded', function () {
    // Function to update contact person fields based on selected value
    const noOfPersonsSelect = document.getElementById('no_of_persons');
    const contactPersonFieldsContainer = document.getElementById('contact_person_fields');

    // Function to render contact person fields
    function renderContactPersons() {
        var code = $(this).find(':selected').data('code');
        const numberOfPersons = parseInt(noOfPersonsSelect.value);
        contactPersonFieldsContainer.innerHTML = ''; // Clear existing fields

        for (let i = 1; i <= numberOfPersons; i++) {
            const fieldHTML = `
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label>Contact Person ${i} Name</label>
            <input type="text" 
                   name="contact_person_${i}_name" 
                   class="form-control"
                   placeholder="Enter Name">
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group mb-3">
            <label>Contact Person ${i} Designation</label>
            <input type="text" 
                   name="contact_person_${i}_designation" 
                   class="form-control"
                   placeholder="Enter Designation">
        </div>
    </div>

    <div class="col-md-4">
        <label>Contact Person ${i} Contact</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">+91</span>
            </div>
            <input type="text"
                   name="contact_person_${i}_contact"
                   class="form-control contact-number"
                   placeholder="Enter Contact No">
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group mb-3">
            <label>Contact Person ${i} Email</label>
            <input type="email"
                   name="contact_person_${i}_email"
                   class="form-control"
                   placeholder="Enter Email">
        </div>
    </div>
`;

            contactPersonFieldsContainer.innerHTML += fieldHTML;
        }
    }

    // Trigger function on change of 'no_of_persons' select
    noOfPersonsSelect.addEventListener('change', renderContactPersons);

    // Initial render when page loads
    renderContactPersons();
});