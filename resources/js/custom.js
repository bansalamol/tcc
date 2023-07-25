
function updatePatientCodeView() {
    var dropdown = document.getElementById('patient_code');
    var selectedValue = dropdown.value;
    var patientCodeView = document.getElementById('patient_code_view');
    patientCodeView.textContent = selectedValue;
}
