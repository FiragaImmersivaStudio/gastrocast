<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@hasSection('title')
        @yield('title') - {{ config('app.name', 'CustiCast') }}
        @else{{ config('app.name', 'CustiCast') }} - Restaurant Intelligence Platform
        @endif</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Highcharts -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/heatmap.js"></script>
    
    <style>
        :root {
            /* --primary-color: {{ env('THEME_PRIMARY', '#7A001F') }};
            --accent-color: {{ env('THEME_ACCENT', '#FFC107') }}; */
            --primary-color: #7A001F;
            --accent-color: #FFC107;
        }
        
        .navbar-brand {
            color: var(--primary-color) !important;
            font-weight: bold;
        }
        
        .sidebar {
            background: linear-gradient(180deg, var(--primary-color) 0%, #8B001F 100%);
            min-height: 100vh;
            color: white;
        }
        
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            border-radius: 8px;
            margin: 2px 0;
            transition: all 0.3s ease;
        }
        
        .sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.1) !important;
            color: white !important;
            transform: translateX(5px);
        }
        
        .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.2) !important;
            color: white !important;
            font-weight: 600;
            transform: translateX(5px);
            border-left: 4px solid var(--accent-color);
        }
        
        /* Pastikan icons di sidebar juga memiliki kontras yang baik */
        .sidebar .nav-link .fas {
            color: rgba(255, 255, 255, 0.8) !important;
        }
        
        .sidebar .nav-link:hover .fas,
        .sidebar .nav-link.active .fas {
            color: white !important;
        }
        
        .card {
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
            border: none;
        }
        
        .btn-primary {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background: #6B0018;
            border-color: #6B0018;
        }
        
        .btn-secondary {
            background: #FFC107;
            border-color: #FFC107;
            color: #212529;
            font-weight: 500;
        }
        
        .btn-secondary:hover {
            background: #FFCA2C;
            border-color: #FFCA2C;
            color: #212529;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(255, 193, 7, 0.3);
        }
        
        .btn-secondary:focus {
            background: #FFCA2C;
            border-color: #FFCA2C;
            color: #212529;
            box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.5);
        }
        
        .btn-secondary:active {
            background: #E0A800;
            border-color: #E0A800;
            color: #212529;
        }
        
        .btn-secondary:disabled {
            background: #FFC107;
            border-color: #FFC107;
            color: #6c757d;
            opacity: 0.65;
        }
        
        .btn-outline-secondary {
            color: #FFC107;
            border-color: #FFC107;
            background: transparent;
            font-weight: 500;
        }
        
        .btn-outline-secondary:hover {
            color: #212529;
            background: #FFC107;
            border-color: #FFC107;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(255, 193, 7, 0.3);
        }
        
        .btn-outline-secondary:focus {
            color: #212529;
            background: #FFC107;
            border-color: #FFC107;
            box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.5);
        }
        
        .btn-outline-secondary:active {
            color: #212529;
            background: #E0A800;
            border-color: #E0A800;
        }
        
        .btn-outline-secondary.active {
            color: #212529;
            background: #FFC107;
            border-color: #FFC107;
            font-weight: 600;
        }
        
        .btn-outline-secondary:disabled {
            color: #FFC107;
            background: transparent;
            border-color: #FFC107;
            opacity: 0.65;
        }
        
        .btn-warning {
            background: var(--accent-color);
            border-color: var(--accent-color);
            color: #000;
        }
        
        .text-primary {
            color: var(--primary-color) !important;
        }
        
        .bg-primary {
            background: var(--primary-color) !important;
        }
        
        .kpi-card {
            background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
            border-left: 4px solid var(--primary-color);
        }
        
        .chart-container {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        
        .restaurant-selector .dropdown-toggle {
            min-width: 200px;
            text-align: left;
            border-color: var(--primary-color);
            color: var(--primary-color);
            background: linear-gradient(135deg, rgba(122, 0, 31, 0.05) 0%, rgba(139, 0, 31, 0.1) 100%);
            transition: all 0.3s ease;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .restaurant-selector .dropdown-toggle::after {
            margin-left: auto;
            flex-shrink: 0;
        }
        
        .restaurant-selector .dropdown-toggle:hover {
            background: linear-gradient(135deg, var(--primary-color) 0%, #8B001F 100%);
            border-color: var(--primary-color);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(122, 0, 31, 0.3);
        }
        
        .restaurant-selector .dropdown-toggle.has-active {
            background: linear-gradient(135deg, var(--primary-color) 0%, #8B001F 100%);
            border-color: var(--primary-color);
            color: white !important;
            box-shadow: 0 2px 6px rgba(122, 0, 31, 0.4);
        }
        
        .restaurant-selector .dropdown-toggle.has-active:hover {
            background: linear-gradient(135deg, #6B0018 0%, #7A001F 100%);
            transform: translateY(-1px);
            box-shadow: 0 6px 12px rgba(122, 0, 31, 0.5);
            color: white !important;
        }
        
        /* Pastikan text dan icons di dalam restaurant selector yang aktif tetap putih */
        .restaurant-selector .dropdown-toggle.has-active,
        .restaurant-selector .dropdown-toggle.has-active:hover,
        .restaurant-selector .dropdown-toggle.has-active:focus {
            color: white !important;
        }
        
        .restaurant-selector .dropdown-toggle.has-active .fas,
        .restaurant-selector .dropdown-toggle.has-active:hover .fas,
        .restaurant-selector .dropdown-toggle.has-active:focus .fas {
            color: white !important;
        }
        
        /* Override untuk btn-outline-primary yang memiliki kelas has-active */
        .btn-outline-primary.has-active {
            background: linear-gradient(135deg, var(--primary-color) 0%, #8B001F 100%) !important;
            border-color: var(--primary-color) !important;
            color: white !important;
        }
        
        .btn-outline-primary.has-active:hover {
            background: linear-gradient(135deg, #6B0018 0%, #7A001F 100%) !important;
            border-color: #6B0018 !important;
            color: white !important;
        }
        
        .btn-outline-primary.has-active:focus {
            background: linear-gradient(135deg, var(--primary-color) 0%, #8B001F 100%) !important;
            border-color: var(--primary-color) !important;
            color: white !important;
            box-shadow: 0 0 0 0.2rem rgba(122, 0, 31, 0.5) !important;
        }
        
        .restaurant-active-indicator {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.7; }
            100% { opacity: 1; }
        }
        
        .restaurant-selector .dropdown-menu {
            border: 1px solid var(--primary-color);
            box-shadow: 0 8px 16px rgba(122, 0, 31, 0.2);
        }
        
        .restaurant-selector .dropdown-item {
            transition: all 0.3s ease;
            color: #333;
        }
        
        .restaurant-selector .dropdown-item:hover {
            background: linear-gradient(135deg, rgba(122, 0, 31, 0.1) 0%, rgba(139, 0, 31, 0.15) 100%);
            color: var(--primary-color);
            transform: translateX(5px);
        }
        
        .restaurant-selector .dropdown-item.active {
            background: linear-gradient(135deg, var(--primary-color) 0%, #8B001F 100%);
            color: white;
            border-left: 4px solid var(--accent-color);
        }
        
        .restaurant-selector .dropdown-item.active:hover {
            background: linear-gradient(135deg, #6B0018 0%, var(--primary-color) 100%);
            color: white;
            transform: translateX(8px);
        }
        
        .restaurant-selector .dropdown-item.text-warning:hover {
            background: rgba(255, 193, 7, 0.1);
            color: #d39e00;
        }
        
        .restaurant-selector .dropdown-item.text-primary:hover {
            background: linear-gradient(135deg, rgba(122, 0, 31, 0.1) 0%, rgba(139, 0, 31, 0.15) 100%);
            color: var(--primary-color);
            font-weight: 600;
        }

        /* Bootstrap Component Overrides untuk Primary Color */
        
        /* List Group */
        .list-group-item.active {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            color: white !important;
        }
        
        .list-group-item-action {
            color: #333 !important;
            background-color: transparent !important;
            border-color: rgba(0, 0, 0, 0.125) !important;
            transition: all 0.3s ease !important;
        }
        
        .list-group-item-action:hover {
            background-color: rgba(122, 0, 31, 0.08) !important;
            color: var(--primary-color) !important;
            border-color: rgba(122, 0, 31, 0.2) !important;
            transform: translateX(3px);
        }
        
        .list-group-item-action:focus {
            background-color: rgba(122, 0, 31, 0.12) !important;
            color: var(--primary-color) !important;
            border-color: rgba(122, 0, 31, 0.3) !important;
            box-shadow: 0 0 0 0.2rem rgba(122, 0, 31, 0.15) !important;
        }
        
        .list-group-item-action.active {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            color: white !important;
            font-weight: 600;
            border-left: 4px solid var(--accent-color);
        }
        
        .list-group-item-action.active:hover {
            background-color: #6B0018 !important;
            border-color: #6B0018 !important;
            color: white !important;
            transform: translateX(5px);
        }
        
        /* List Group Item dengan Pills style */
        .list-group-flush .list-group-item-action {
            border-left: none !important;
            border-right: none !important;
            border-radius: 0 !important;
        }
        
        .list-group-flush .list-group-item-action:first-child {
            border-top: none !important;
        }
        
        .list-group-flush .list-group-item-action:last-child {
            border-bottom: none !important;
        }
        
        /* Special styling untuk Settings page navigation */
        .card .list-group-flush .list-group-item-action {
            padding: 0.75rem 1rem !important;
            margin: 1px 0 !important;
            border-radius: 6px !important;
            border: 1px solid transparent !important;
        }
        
        .card .list-group-flush .list-group-item-action:hover {
            background: linear-gradient(135deg, rgba(122, 0, 31, 0.08) 0%, rgba(122, 0, 31, 0.12) 100%) !important;
            border-color: rgba(122, 0, 31, 0.2) !important;
            box-shadow: 0 2px 4px rgba(122, 0, 31, 0.1) !important;
        }
        
        .card .list-group-flush .list-group-item-action.active {
            background: linear-gradient(135deg, var(--primary-color) 0%, #8B001F 100%) !important;
            border-color: var(--primary-color) !important;
            color: white !important;
            font-weight: 600;
            box-shadow: 0 4px 8px rgba(122, 0, 31, 0.25) !important;
        }
        
        .card .list-group-flush .list-group-item-action.active:hover {
            background: linear-gradient(135deg, #6B0018 0%, #7A001F 100%) !important;
            transform: translateX(5px);
            box-shadow: 0 6px 12px rgba(122, 0, 31, 0.35) !important;
        }
        
        /* Alert Primary */
        .alert-primary {
            color: #ffffff !important;
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
        }
        
        .alert-primary .alert-link {
            color: rgba(255, 255, 255, 0.8) !important;
        }
        
        /* Badge Primary */
        .badge.bg-primary {
            background-color: var(--primary-color) !important;
        }
        
        /* Badge Secondary */
        .badge.bg-secondary {
            background-color: #FFC107 !important;
            color: #212529 !important;
            font-weight: 600;
        }
        
        .badge.bg-secondary:hover {
            background-color: #FFCA2C !important;
        }
        
        /* Secondary Color Utilities */
        .text-secondary {
            color: #FFC107 !important;
        }
        
        .bg-secondary {
            background-color: #FFC107 !important;
            color: #212529 !important;
        }
        
        .border-secondary {
            border-color: #FFC107 !important;
        }
        
        /* Alert Secondary */
        .alert-secondary {
            color: #212529 !important;
            background-color: rgba(255, 193, 7, 0.1) !important;
            border-color: #FFC107 !important;
        }
        
        .alert-secondary .alert-link {
            color: #E0A800 !important;
        }
        
        /* Nav Pills */
        .nav-pills .nav-link.active {
            background-color: var(--primary-color) !important;
            color: white !important;
        }
        
        .nav-pills .nav-link:hover {
            background-color: rgba(122, 0, 31, 0.1) !important;
            color: var(--primary-color) !important;
        }
        
        /* Nav Tabs */
        .nav-tabs .nav-link.active {
            color: var(--primary-color) !important;
            border-color: transparent transparent var(--primary-color) !important;
        }
        
        .nav-tabs .nav-link:hover {
            color: var(--primary-color) !important;
            border-color: transparent transparent rgba(122, 0, 31, 0.3) !important;
        }
        
        /* Fix untuk text contrast pada nav yang aktif */
        .nav-pills .nav-link.active,
        .nav-tabs .nav-link.active {
            font-weight: 600;
        }
        
        .nav-pills .nav-link.active .fas,
        .nav-tabs .nav-link.active .fas {
            color: white !important;
        }
        
        /* Pagination */
        .pagination .page-link {
            color: var(--primary-color) !important;
        }
        
        .pagination .page-item.active .page-link {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            color: white !important;
        }
        
        .pagination .page-link:hover {
            background-color: rgba(122, 0, 31, 0.1) !important;
            border-color: rgba(122, 0, 31, 0.3) !important;
            color: var(--primary-color) !important;
        }
        
        /* Progress Bar */
        .progress-bar {
            background-color: var(--primary-color) !important;
        }
        
        .progress-bar.bg-primary {
            background-color: var(--primary-color) !important;
        }
        
        /* Links */
        a {
            color: var(--primary-color) !important;
        }
        
        a:hover {
            color: #6B0018 !important;
        }
        
        /* Override untuk Links di dalam elemen dengan background primary */
        .bg-primary a,
        .card-header.bg-primary a,
        .alert-primary a,
        .btn-primary a,
        .badge.bg-primary a,
        .sidebar a {
            color: white !important;
        }
        
        .bg-primary a:hover,
        .card-header.bg-primary a:hover,
        .alert-primary a:hover,
        .btn-primary a:hover,
        .badge.bg-primary a:hover,
        .sidebar a:hover {
            color: rgba(255, 255, 255, 0.8) !important;
        }
        
        /* Form Controls Focus */
        .form-control:focus {
            border-color: rgba(122, 0, 31, 0.5) !important;
            box-shadow: 0 0 0 0.2rem rgba(122, 0, 31, 0.25) !important;
        }
        
        .form-select:focus {
            border-color: rgba(122, 0, 31, 0.5) !important;
            box-shadow: 0 0 0 0.2rem rgba(122, 0, 31, 0.25) !important;
        }
        
        /* Check and Radio */
        .form-check-input:checked {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
        }
        
        .form-check-input:focus {
            border-color: rgba(122, 0, 31, 0.5) !important;
            box-shadow: 0 0 0 0.2rem rgba(122, 0, 31, 0.25) !important;
        }
        
        /* Dropdown Active */
        .dropdown-item.active,
        .dropdown-item:active {
            background-color: var(--primary-color) !important;
            color: white !important;
        }
        
        /* Modal Header */
        .modal-header {
            border-bottom-color: rgba(122, 0, 31, 0.2) !important;
        }
        
        /* Table */
        .table-primary {
            background-color: rgba(122, 0, 31, 0.1) !important;
            border-color: rgba(122, 0, 31, 0.2) !important;
        }
        
        .table-striped > tbody > tr:nth-of-type(odd) > td.table-primary {
            background-color: rgba(122, 0, 31, 0.05) !important;
        }
        
        /* Accordion */
        .accordion-button:not(.collapsed) {
            color: var(--primary-color) !important;
            background-color: rgba(122, 0, 31, 0.1) !important;
            border-color: rgba(122, 0, 31, 0.2) !important;
        }
        
        .accordion-button:focus {
            border-color: rgba(122, 0, 31, 0.5) !important;
            box-shadow: 0 0 0 0.2rem rgba(122, 0, 31, 0.25) !important;
        }
        
        /* Card Header Primary */
        .card-header.bg-primary {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
        }
        
        /* Border Primary */
        .border-primary {
            border-color: var(--primary-color) !important;
        }
        
        /* Outline Button Primary */
        .btn-outline-primary {
            color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            color: white !important;
        }
        
        .btn-outline-primary:focus {
            box-shadow: 0 0 0 0.2rem rgba(122, 0, 31, 0.5) !important;
        }
        
        .btn-outline-primary.active,
        .btn-outline-primary:active {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            color: white !important;
        }
        
        /* Spinner dan Loading States */
        .spinner-border.text-primary {
            color: var(--primary-color) !important;
        }
        
        /* Toast */
        .toast-header.bg-primary {
            background-color: var(--primary-color) !important;
            color: white !important;
        }
        
        /* Breadcrumb */
        .breadcrumb-item.active {
            color: var(--primary-color) !important;
        }
        
        /* Input Group */
        .input-group-text.bg-primary {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            color: white !important;
        }
        
        /* Close Button */
        .btn-close:focus {
            box-shadow: 0 0 0 0.2rem rgba(122, 0, 31, 0.25) !important;
        }
        
        /* Tab Content */
        .tab-content .tab-pane.active {
            border-color: rgba(122, 0, 31, 0.2) !important;
        }
        
        /* Card dengan Border Primary */
        .card.border-primary {
            border-color: var(--primary-color) !important;
        }
        
        .card.border-primary .card-header {
            background-color: rgba(122, 0, 31, 0.1) !important;
            border-bottom-color: var(--primary-color) !important;
            color: var(--primary-color) !important;
        }
        
        /* Offcanvas */
        .offcanvas-header.bg-primary {
            background-color: var(--primary-color) !important;
            color: white !important;
        }
        
        /* Button Group */
        .btn-group .btn.active {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            color: white !important;
        }
        
        /* Popover */
        .popover-header.bg-primary {
            background-color: var(--primary-color) !important;
            color: white !important;
        }
        
        /* Custom Range Slider */
        .form-range::-webkit-slider-thumb {
            background-color: var(--primary-color) !important;
        }
        
        .form-range::-moz-range-thumb {
            background-color: var(--primary-color) !important;
        }
        
        /* Select Multiple */
        .form-select option:checked {
            background-color: var(--primary-color) !important;
            color: white !important;
        }
        
        /* Perbaikan kontras untuk text pada background primary */
        .bg-primary,
        .btn-primary,
        .badge.bg-primary,
        .alert-primary,
        .list-group-item.active,
        .dropdown-item.active,
        .pagination .page-item.active .page-link,
        .nav-pills .nav-link.active,
        .progress-bar,
        .card-header.bg-primary {
            color: white !important;
        }
        
        .bg-primary *,
        .btn-primary *,
        .badge.bg-primary *,
        .alert-primary *,
        .list-group-item.active *,
        .dropdown-item.active *,
        .pagination .page-item.active .page-link *,
        .nav-pills .nav-link.active *,
        .card-header.bg-primary * {
            color: white !important;
        }
        
        /* Pastikan icons dan small text juga kontras */
        .bg-primary .fas,
        .btn-primary .fas,
        .badge.bg-primary .fas,
        .alert-primary .fas,
        .list-group-item.active .fas,
        .dropdown-item.active .fas,
        .pagination .page-item.active .page-link .fas,
        .nav-pills .nav-link.active .fas,
        .card-header.bg-primary .fas {
            color: white !important;
        }
        
        /* Pastikan icons dan text kontras untuk secondary */
        .bg-secondary .fas,
        .btn-secondary .fas,
        .badge.bg-secondary .fas,
        .alert-secondary .fas,
        .btn-outline-secondary .fas {
            color: #212529 !important;
        }
        
        .btn-outline-secondary:hover .fas,
        .btn-outline-secondary:focus .fas,
        .btn-outline-secondary:active .fas,
        .btn-outline-secondary.active .fas {
            color: #212529 !important;
        }
        
        /* Custom SweetAlert2 Styles */
        .swal2-popup {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            border-radius: 12px !important;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12) !important;
        }
        
        .swal2-title {
            color: #7A001F !important;
            font-weight: 600 !important;
        }
        
        .swal2-confirm {
            background: #7A001F !important;
            border-color: #7A001F !important;
            color: white !important;
            font-weight: 500 !important;
            border-radius: 8px !important;
            padding: 0.5rem 1.5rem !important;
            transition: all 0.3s ease !important;
        }
        
        .swal2-confirm:hover {
            background: #6B0018 !important;
            border-color: #6B0018 !important;
            transform: translateY(-1px) !important;
            box-shadow: 0 4px 8px rgba(122, 0, 31, 0.3) !important;
        }
        
        .swal2-cancel {
            background: #6c757d !important;
            border-color: #6c757d !important;
            color: white !important;
            font-weight: 500 !important;
            border-radius: 8px !important;
            padding: 0.5rem 1.5rem !important;
            transition: all 0.3s ease !important;
        }
        
        .swal2-cancel:hover {
            background: #5a6268 !important;
            border-color: #5a6268 !important;
            transform: translateY(-1px) !important;
            box-shadow: 0 4px 8px rgba(108, 117, 125, 0.3) !important;
        }
        
        .swal2-icon.swal2-question {
            color: #7A001F !important;
            border-color: #7A001F !important;
        }
        
        .swal2-actions {
            gap: 0.5rem !important;
        }
    </style>

    @yield('styles')
</head>
<body class="bg-light">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-chart-line me-2"></i>CustiCast
            </a>
            
            <div class="d-flex align-items-center">
                @auth
                    <!-- Restaurant Selector -->
                    <div class="dropdown me-3 restaurant-selector">
                        <button class="btn btn-outline-primary dropdown-toggle {{ isset($selectedRestaurant) && $selectedRestaurant ? 'has-active' : '' }}" type="button" id="restaurantSelector" data-bs-toggle="dropdown">
                            <i class="fas fa-store me-1"></i>
                            @if(isset($selectedRestaurant) && $selectedRestaurant)
                                <i class="ms-1 restaurant-active-indicator" style="font-size: 0.5rem; margin-right: 0.25rem; color: var(--accent-color);" title="Active Restaurant"></i>
                                {{ $selectedRestaurant->name }}
                            @else
                                Select Restaurant
                            @endif
                        </button>
                        <ul class="dropdown-menu">
                            @if(isset($userRestaurants) && $userRestaurants && $userRestaurants->count() > 0)
                                @foreach($userRestaurants as $restaurant)
                                    <li>
                                        <form method="POST" action="{{ route('restaurants.select', $restaurant) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="dropdown-item {{ isset($selectedRestaurant) && $selectedRestaurant && $selectedRestaurant->id == $restaurant->id ? 'active' : '' }}">
                                                <i class="fas fa-store me-2"></i>
                                                {{ $restaurant->name }}
                                                @if(isset($selectedRestaurant) && $selectedRestaurant && $selectedRestaurant->id == $restaurant->id)
                                                    <i class="fas fa-check float-end mt-1" style="color: var(--accent-color);"></i>
                                                @endif
                                            </button>
                                        </form>
                                    </li>
                                @endforeach
                                @if(isset($selectedRestaurant) && $selectedRestaurant)
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('restaurants.deselect') }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-warning">
                                                <i class="fas fa-times me-2"></i>Deselect Restaurant
                                            </button>
                                        </form>
                                    </li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                            @else
                                <li><span class="dropdown-item-text text-muted"><i class="fas fa-info-circle me-2"></i>No restaurants found</span></li>
                                <li><hr class="dropdown-divider"></li>
                            @endif
                            <li>
                                <a class="dropdown-item text-primary" href="{{ route('restaurants.create') }}">
                                    <i class="fas fa-plus me-2"></i>Add Restaurant
                                </a>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- User Menu -->
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('settings.index') }}"><i class="fas fa-cog me-2"></i>Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            @auth
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"
                               title="Dashboard utama menampilkan KPI real-time, forecasting, dan insights AI untuk monitoring performa restoran secara menyeluruh">
                                <i class="fas fa-tachometer-alt me-2"></i>Overview
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('restaurants.*') ? 'active' : '' }}" href="{{ route('restaurants.index') }}"
                               title="Kelola data restoran, pilih lokasi aktif untuk filtering data, dan konfigurasi pengaturan per-cabang">
                                <i class="fas fa-store me-2"></i>Restaurants
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('datasets.*') ? 'active' : '' }}" href="{{ route('datasets.index') }}"
                               title="Import dan kelola data penjualan, menu, inventori, dan staff. Download sample data untuk referensi format import">
                                <i class="fas fa-database me-2"></i>Datasets
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('forecast.*') ? 'active' : '' }}" href="{{ route('forecast.index') }}"
                               title="Generate prediksi penjualan menggunakan machine learning, analisis tren, dan confidence intervals untuk planning bisnis">
                                <i class="fas fa-chart-line me-2"></i>Forecast & Insights
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('whatif.*') ? 'active' : '' }}" href="{{ route('whatif.index') }}"
                               title="Simulasi skenario what-if untuk testing strategi baru, perubahan menu, atau kondisi bisnis yang berbeda">
                                <i class="fas fa-flask me-2"></i>What-If Lab
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('staffing.*') ? 'active' : '' }}" href="{{ route('staffing.index') }}"
                               title="Kelola jadwal staff, optimasi shift berdasarkan prediksi traffic, dan monitoring absensi karyawan">
                                <i class="fas fa-users me-2"></i>Staffing Planner
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('inventory.*') ? 'active' : '' }}" href="{{ route('inventory.index') }}"
                               title="Monitor stok bahan baku, prediksi kebutuhan inventory, dan analisis waste untuk efisiensi operasional">
                                <i class="fas fa-boxes me-2"></i>Inventory & Waste
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('menu-engineering.*') ? 'active' : '' }}" href="{{ route('menu-engineering.index') }}"
                               title="Analisis profitabilitas menu, optimasi pricing, dan rekomendasi item berdasarkan popularity vs profit margin">
                                <i class="fas fa-utensils me-2"></i>Menu Engineering
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('promotions.*') ? 'active' : '' }}" href="{{ route('promotions.index') }}"
                               title="Kelola campaign promosi, discount tracking, dan analisis efektivitas marketing berdasarkan sales impact">
                                <i class="fas fa-tags me-2"></i>Promotions
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('operations.*') ? 'active' : '' }}" href="{{ route('operations.index') }}"
                               title="Monitor operasional real-time, queue management, kitchen performance, dan service time analytics">
                                <i class="fas fa-cogs me-2"></i>Operations Monitor
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}"
                               title="Generate laporan comprehensive dalam format PDF/Excel untuk analisis mendalam dan presentasi">
                                <i class="fas fa-file-pdf me-2"></i>Reports & Export
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}" href="{{ route('settings.index') }}"
                               title="Konfigurasi sistem, user management, notification settings, dan customization platform">
                                <i class="fas fa-cog me-2"></i>Settings
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            @endauth

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @if(session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>{{ session('warning') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- CSRF Token for AJAX -->
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        // Custom SweetAlert2 configuration
        const SwalConfig = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary me-2',
                cancelButton: 'btn btn-secondary',
                popup: 'rounded-3',
                title: 'text-dark',
                htmlContainer: 'text-muted'
            },
            buttonsStyling: false,
            showClass: {
                popup: 'animate__animated animate__fadeInDown'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
            }
        });
        
        // Global confirm function using SweetAlert2
        window.confirmAction = function(message, title = 'Konfirmasi', confirmText = 'Ya', cancelText = 'Batal') {
            return SwalConfig.fire({
                title: title,
                text: message,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: confirmText,
                cancelButtonText: cancelText,
                confirmButtonColor: '#7A001F',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                return result.isConfirmed;
            });
        };
        
        // Restaurant selector handling
        $(document).ready(function() {
            // Add loading state to restaurant selection forms
            $('.restaurant-selector form').on('submit', function() {
                const $btn = $(this).find('button');
                const originalText = $btn.html();
                $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Selecting...');
                
                // Re-enable after a delay in case of error
                setTimeout(function() {
                    $btn.prop('disabled', false).html(originalText);
                }, 5000);
            });
            
            // Handle deselection
            $('form[action*="deselect"]').on('submit', function() {
                const $btn = $(this).find('button');
                $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Deselecting...');
            });
        });
    </script>

    @yield('scripts')
</body>
</html>