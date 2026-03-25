<style>
    body,
    body *:not(i):not(.fa):not(.fas):not(.far):not(.fab):not(.fa-solid):not(.fa-regular):not(.fa-brands) {
        font-family: 'Poppins', sans-serif !important;
        font-optical-sizing: auto;
        font-style: normal;
    }

      .bg-menu {
            background-color: #393E46 !important;

        }

        .btn-menu {
            font-size: 12.5px;
            background-color: #FFB22C !important;
            padding: 5px 10px;
            font-weight: 600;
            border: none !important;
        }

    #content>nav.navbar .workorder-menu-toggle {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 7px !important;
        font-size: 12.5px !important;
        font-weight: 600 !important;
        line-height: 1 !important;
        padding: 5px 10px !important;
        margin-top: 0.25rem !important;
        margin-bottom: 0.25rem !important;
        background-color: #FFB22C !important;
        color: #212529 !important;
        border: none !important;
        border-radius: 0 !important;
        box-shadow: none !important;
        text-decoration: none !important;
    }

    #content>nav.navbar .workorder-menu-toggle:hover {
        background-color: #ffbf47 !important;
        color: #212529 !important;
    }

    #content>nav.navbar .workorder-menu-toggle:focus,
    #content>nav.navbar .workorder-menu-toggle:active {
        box-shadow: none !important;
        outline: none !important;
    }

    nav.navbar.navbar-light.bg-light {
        background-color: #393E46 !important;
        padding: 0 !important;
    }

    nav.navbar.navbar-expand-lg.navbar-light.bg-light {
        background-color: #393E46 !important;
        padding: 0 !important;
    }

    nav.navbar.navbar-expand-lg.bg-menu {
        background-color: #393E46 !important;
        padding: 0 !important;
    }

    #content>nav.navbar .container-fluid {
        display: flex !important;
        align-items: center !important;
        padding: 0 12px !important;
    }

    a[href="workorder_home.php"],
    .btn-home-shortcut {
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
        background-color: #1f2937 !important;
        border: 1px solid #1f2937 !important;
        color: #ffffff !important;
        border-radius: 4px !important;
        padding: 7px 12px !important;
        font-size: 11.5px !important;
        font-weight: 600 !important;
        line-height: 1 !important;
        text-decoration: none !important;
        box-shadow: none !important;
    }

    a[href="workorder_home.php"]:hover,
    .btn-home-shortcut:hover {
        background-color: #111827 !important;
        border-color: #111827 !important;
        color: #ffffff !important;
    }

    .box1-heading {
        font-size: 16px !important;
        font-weight: 700 !important;
        line-height: 1.25 !important;
        letter-spacing: 0 !important;
        color: #1f2937 !important;
    }

    form.row.g-2 .form-label {
        font-size: 12px !important;
        letter-spacing: 0 !important;
        color: #4b5563 !important;
        margin-bottom: 0.2rem !important;
    }

    .mint-badge {
        display: inline-flex !important;
        align-items: center !important;
        gap: 8px !important;
        margin-left: auto !important;
        padding: 8px 12px !important;
        border-radius: 999px !important;
        background: #d1fae5 !important;
        color: #065f46 !important;
        font-size: 12px !important;
        font-weight: 700 !important;
        line-height: 1 !important;
        border: 1px solid #a7f3d0 !important;
        white-space: nowrap !important;
    }

    .row.g-2 .mint-badge,
    form.row.g-2 .mint-badge {
        margin-left: auto !important;
    }

    @media (min-width: 992px) {
        .row.g-2 .mint-badge,
        form.row.g-2 .mint-badge {
            justify-self: end !important;
        }

        .row.g-2 .d-flex:has(> .mint-badge),
        form.row.g-2 .d-flex:has(> .mint-badge),
        .row.g-2 .d-flex.justify-content-lg-end,
        form.row.g-2 .d-flex.justify-content-lg-end {
            justify-content: flex-end !important;
        }
    }

    .mint-badge i {
        color: #0f766e !important;
        white-space: nowrap !important;
    }

    .btn-details,
    .btn-approve,
    .btn-reject,
    .btn-secondary.btn-sm {
        min-height: 28px !important;
        padding: 5px 11px !important;
        border-radius: 4px !important;
        font-size: 11px !important;
        font-weight: 600 !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 6px !important;
        line-height: 1 !important;
        text-decoration: none !important;
        white-space: nowrap !important;
        border: none !important;
        box-shadow: none !important;
    }

    .btn-details,
    .btn-secondary.btn-sm {
        background-color: #7c3aed !important;
        color: #ffffff !important;
    }

    .btn-approve {
        background-color: #16a34a !important;
        color: #ffffff !important;
    }

    .btn-reject {
        background-color: #dc2626 !important;
        color: #ffffff !important;
    }

    .btn-primary.btn-sm,
    .btn-reset.btn-sm {
        min-height: 31px !important;
        height: 31px !important;
        border-radius: 4px !important;
        padding: 7px 12px !important;
        font-size: 11.5px !important;
        font-weight: 600 !important;
        line-height: 1 !important;
    }

    .btn-reset.btn-sm {
        background-color: #ced4da !important;
        color: #212529 !important;
        border-color: #ced4da !important;
    }

    .table-responsive.dt-wrap {
        max-height: 90vh !important;
        overflow: auto !important;
        border-radius: 14px !important;
        border: 1px solid #d8dee6 !important;
        background: #ffffff !important;
    }

    .table-responsive.dt-wrap table {
        width: max-content !important;
        min-width: 100% !important;
        border-collapse: separate !important;
        border-spacing: 0 !important;
        table-layout: auto !important;
    }

    .table-responsive.dt-wrap thead th {
        position: sticky !important;
        top: 0 !important;
        z-index: 5 !important;
        white-space: nowrap !important;
        font-size: 11.5px !important;
        border: none !important;
        background-color: #3a506b !important;
        color: #ffffff !important;
        font-weight: 600 !important;
    }

    .table-responsive.dt-wrap tbody td {
        font-size: 11px !important;
        font-weight: 400 !important;
        vertical-align: top !important;
        border-bottom: 1px solid #e5e7eb !important;
        white-space: nowrap !important;
        background: #ffffff !important;
    }

    .table-responsive.dt-wrap td.td-wrap {
        white-space: normal !important;
        max-width: 520px !important;
        word-break: break-word !important;
        overflow-wrap: anywhere !important;
    }

    .table-responsive.dt-wrap tbody tr:hover td {
        background: #f8fbff !important;
    }

    .table-responsive.dt-wrap tbody tr:nth-child(even) td {
        background: #fbfdff !important;
    }

    .table-responsive.dt-wrap::-webkit-scrollbar {
        height: 10px !important;
        width: 10px !important;
    }

    .table-responsive.dt-wrap::-webkit-scrollbar-thumb {
        background: #c7ced8 !important;
        border-radius: 999px !important;
    }

    .table-responsive.dt-wrap::-webkit-scrollbar-track {
        background: #eef2f7 !important;
    }

    .workorder-toolbar {
        display: flex !important;
        flex-wrap: wrap !important;
        align-items: center !important;
        gap: 10px !important;
        margin-bottom: 14px !important;
    }

    .workorder-toolbar .form-control {
        width: 100% !important;
        max-width: 320px !important;
        font-size: 11.5px !important;
    }

    .workorder-detail-shell {
        max-width: 1200px !important;
        margin: 0 auto !important;
        padding: 14px 18px !important;
        background-color: #ffffff !important;
        border: 1px solid #d1d5db !important;
        border-radius: 12px !important;
    }

    .workorder-detail-shell textarea,
    .workorder-detail-shell input[type="text"] {
        width: 100% !important;
        max-width: 100% !important;
    }

    @media (max-width: 991.98px) {
        .workorder-detail-shell {
            padding: 14px !important;
        }

        .workorder-detail-shell .row > [class*="col-"],
        .workorder-detail-shell .row > [class*="col-md-"] {
            margin-bottom: 12px !important;
        }
    }
</style>
