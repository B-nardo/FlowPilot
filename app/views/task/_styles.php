<style>
    .avatar-sm {
        width: 36px;
        height: 36px;
        font-size: 13px;
    }

    .hover-lift {
        transition: all 0.3s ease;
    }

    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.12) !important;
    }

    .sticky-top {
        position: sticky;
        top: 0;
        z-index: 10;
        background: white;
    }

    .task-row:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }

    .nav-pills .nav-link {
        color: #6c757d;
        font-weight: 500;
    }

    .nav-pills .nav-link.active {
        background-color: #0d6efd;
    }

    .rounded-3 {
        border-radius: 0.75rem !important;
    }

    @media print {
        .btn, .card-header, .alert, .nav-pills {
            display: none !important;
        }
    }
</style>