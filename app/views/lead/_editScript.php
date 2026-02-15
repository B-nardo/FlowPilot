<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('statusSelect');
    const lossReasonInput = document.getElementById('lossReasonInput');
    const reasonRequired = document.getElementById('reasonRequired');
    const reasonHelpText = document.getElementById('reasonHelpText');
    const form = document.querySelector('form');
    
    function toggleLossReason() {
        const selectedOption = statusSelect.options[statusSelect.selectedIndex];
        const requiresReason = selectedOption.getAttribute('data-requires-reason') === '1';
        
        if (requiresReason) {
            // Enable the field and make it required
            lossReasonInput.removeAttribute('disabled');
            lossReasonInput.setAttribute('required', 'required');
            lossReasonInput.placeholder = 'Please provide a detailed reason why this lead was lost...';
            
            // Show required asterisk
            reasonRequired.style.display = 'inline';
            
            // Update help text
            reasonHelpText.innerHTML = '<i class="bi bi-exclamation-circle text-danger"></i> This field is required for the selected status';
            reasonHelpText.classList.remove('text-muted');
            reasonHelpText.classList.add('text-danger');
        } else {
            // Disable the field and remove requirement
            lossReasonInput.setAttribute('disabled', 'disabled');
            lossReasonInput.removeAttribute('required');
            lossReasonInput.placeholder = 'Select a negative status to provide a loss reason...';
            lossReasonInput.classList.remove('border-danger', 'is-invalid');
            
            // Hide required asterisk
            reasonRequired.style.display = 'none';
            
            // Reset help text
            reasonHelpText.innerHTML = '<i class="bi bi-info-circle"></i> This field becomes required when marking a lead as lost';
            reasonHelpText.classList.remove('text-danger');
            reasonHelpText.classList.add('text-muted');
            
            // Clear the value if it was previously disabled status
            // lossReasonInput.value = ''; // Uncomment if you want to clear on status change
        }
    }
    
    // Check on page load
    toggleLossReason();
    
    // Check when status changes
    statusSelect.addEventListener('change', toggleLossReason);
    
    // Form validation before submit
    form.addEventListener('submit', function(e) {
        const selectedOption = statusSelect.options[statusSelect.selectedIndex];
        const requiresReason = selectedOption.getAttribute('data-requires-reason') === '1';
        
        if (requiresReason && lossReasonInput.value.trim() === '') {
            e.preventDefault();
            
            // Add visual feedback
            lossReasonInput.classList.add('is-invalid');
            lossReasonInput.focus();
            
            // Show alert
            alert('⚠️ Please provide a loss reason for this status');
            
            // Scroll to the field
            lossReasonInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
            
            return false;
        }
    });
    
    // Remove invalid class when user starts typing
    lossReasonInput.addEventListener('input', function() {
        this.classList.remove('is-invalid');
    });
});
</script>