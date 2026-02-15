<script>
// Filter Tasks
document.querySelectorAll('#taskFilter .nav-link').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Update active state
        document.querySelectorAll('#taskFilter .nav-link').forEach(l => l.classList.remove('active'));
        this.classList.add('active');
        
        // Filter rows
        const filter = this.dataset.filter;
        document.querySelectorAll('.task-row').forEach(row => {
            if (filter === 'all') {
                row.style.display = '';
            } else {
                row.style.display = row.dataset.status === filter ? '' : 'none';
            }
        });
    });
});

// Search Tasks
document.getElementById('taskSearch')?.addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    document.querySelectorAll('.task-row').forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});

// Select All
document.getElementById('selectAllTasks')?.addEventListener('change', function() {
    document.querySelectorAll('.task-checkbox').forEach(cb => {
        if (cb.closest('tr').style.display !== 'none') {
            cb.checked = this.checked;
        }
    });
    toggleBulkActions();
});

// Show/Hide Bulk Actions
document.querySelectorAll('.task-checkbox').forEach(cb => {
    cb.addEventListener('change', toggleBulkActions);
});

function toggleBulkActions() {
    const checked = document.querySelectorAll('.task-checkbox:checked').length;
    document.getElementById('bulkComplete').style.display = checked > 0 ? 'inline-block' : 'none';
}

// Export to CSV
function exportTasksCSV() {
    const table = document.getElementById('tasksTable');
    let csv = [];
    
    const headers = Array.from(table.querySelectorAll('thead th'))
        .slice(1, -1)
        .map(th => th.textContent.trim());
    csv.push(headers.join(','));
    
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        if (row.style.display !== 'none') {
            const cols = Array.from(row.querySelectorAll('td'))
                .slice(1, -1)
                .map(td => '"' + td.textContent.trim().replace(/"/g, '""') + '"');
            csv.push(cols.join(','));
        }
    });
    
    const csvContent = csv.join('\n');
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'tasks_' + new Date().toISOString().split('T')[0] + '.csv';
    a.click();
}

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    const tooltips = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltips.map(el => new bootstrap.Tooltip(el));
});
</script>