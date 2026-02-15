<style>
    /* Avatar Sizes */
    .avatar-sm {
        width: 36px;
        height: 36px;
        font-size: 14px;
    }

    .avatar-md {
        width: 44px;
        height: 44px;
        font-size: 16px;
    }

    /* Hover Effects */
    .hover-lift-sm:hover {
        background-color: rgba(0, 0, 0, 0.02);
        cursor: pointer;
    }

    .hover-lift {
        transition: all 0.3s ease;
    }

    .hover-lift:hover {
        transform: translateY(-4px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    /* Sticky Header */
    .sticky-top {
        position: sticky;
        top: 0;
        z-index: 10;
    }

    /* Kanban Column */
    .kanban-column {
        max-height: 70vh;
        overflow-y: auto;
        overflow-x: hidden;
    }

    /* Custom Scrollbar */
    .kanban-column::-webkit-scrollbar {
        width: 6px;
    }

    .kanban-column::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .kanban-column::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 3px;
    }

    /* Gradient Header */
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    /* Text Truncate */
    .text-truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .min-width-0 {
        min-width: 0;
    }

    /* Print Styles */
    @media print {
        .btn, .card-header, .alert {
            display: none !important;
        }
    }
</style>