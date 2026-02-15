<script>
// View Toggle
document.getElementById('tableViewBtn').addEventListener('click', function() {
    document.getElementById('tableView').style.display = 'block';
    document.getElementById('kanbanView').style.display = 'none';
    this.classList.add('active');
    document.getElementById('kanbanViewBtn').classList.remove('active');
    localStorage.setItem('leadView', 'table');
});

document.getElementById('kanbanViewBtn').addEventListener('click', function() {
    document.getElementById('tableView').style.display = 'none';
    document.getElementById('kanbanView').style.display = 'block';
    this.classList.add('active');
    document.getElementById('tableViewBtn').classList.remove('active');
    localStorage.setItem('leadView', 'kanban');
});

// Remember last view
window.addEventListener('DOMContentLoaded', function() {
    const savedView = localStorage.getItem('leadView');
    if (savedView === 'kanban') {
        document.getElementById('kanbanViewBtn').click();
    }
});

// Search Functionality
document.getElementById('searchInput')?.addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('#leadsTable tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});

// Select All Checkbox
document.getElementById('selectAll')?.addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.lead-checkbox');
    checkboxes.forEach(cb => cb.checked = this.checked);
});

// Export to CSV
function exportTableToCSV() {
    const table = document.getElementById('leadsTable');
    let csv = [];
    
    // Headers
    const headers = Array.from(table.querySelectorAll('thead th'))
        .slice(1, -1) // Skip checkbox and actions
        .map(th => th.textContent.trim());
    csv.push(headers.join(','));
    
    // Rows
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        if (row.style.display !== 'none') {
            const cols = Array.from(row.querySelectorAll('td'))
                .slice(1, -1) // Skip checkbox and actions
                .map(td => '"' + td.textContent.trim().replace(/"/g, '""') + '"');
            csv.push(cols.join(','));
        }
    });
    
    // Download
    const csvContent = csv.join('\n');
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'leads_' + new Date().toISOString().split('T')[0] + '.csv';
    a.click();
}

// Initialize Bootstrap tooltips
document.addEventListener('DOMContentLoaded', function() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});


</script>