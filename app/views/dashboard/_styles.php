<!-- Enhanced CSS -->
<style>
    /* Avatar */
    .avatar-sm {
        width: 42px;
        height: 42px;
        font-size: 16px;
    }

    /* Card Hover Effects */
    .hover-lift {
        transition: all 0.3s ease;
    }

    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.12) !important;
    }

    /* Table Row Hover */
    .hover-bg:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }

    /* Badge Styling */
    .badge {
        font-weight: 600;
        letter-spacing: 0.3px;
    }

    /* Rounded Elements */
    .rounded-3 {
        border-radius: 0.75rem !important;
    }

    /* Icon Circles */
    .rounded-circle {
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    /* Smooth Transitions */
    * {
        transition: background-color 0.2s ease, color 0.2s ease;
    }

    /* Custom Scrollbar */
    .list-group-flush::-webkit-scrollbar {
        width: 6px;
    }

    .list-group-flush::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .list-group-flush::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 3px;
    }

    .list-group-flush::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Text Uppercase */
    .text-uppercase {
        letter-spacing: 0.5px;
    }

    /* Responsive Font Sizes */
    @media (max-width: 768px) {
        h3 {
            font-size: 1.5rem;
        }
        
        .fs-4 {
            font-size: 1.25rem !important;
        }
    }
</style>