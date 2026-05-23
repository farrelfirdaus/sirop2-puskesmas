<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('css/sb-admin-2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
html, body, #wrapper {
    height: 100%;
    width: 100%;
}
#wrapper {
    display: flex !important;
    overflow: hidden;
}
.sidebar {
    min-height: 100vh;
    height: 100%;
}
#content-wrapper {
    flex: 1 !important;
    min-width: 0;
    overflow-y: auto;
    height: 100vh;
}

@media (max-width: 768px) {
    #wrapper {
        overflow-x: hidden !important;
        width: 100% !important;
    }
    .sidebar {
        width: 80px !important;
        min-width: 80px !important;
        min-height: 100vh !important;
        height: 100vh !important;
        position: fixed !important;
        z-index: 100;
    }
    .sidebar .nav-item .nav-link span,
    .sidebar-brand-text {
        display: none !important;
    }
    #content-wrapper {
        width: calc(100% - 80px) !important;
        margin-left: 80px !important;
        height: 100vh !important;
        overflow-y: auto !important;
    }
    .col-xl-4, .col-xl-8, .col-md-6,
    .col-lg-5, .col-lg-7 {
        width: 100% !important;
        max-width: 100% !important;
        flex: 0 0 100% !important;
    }
    .table-responsive {
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch;
    }
    .container-fluid {
        padding: 12px !important;
    }
    h1.h3 { font-size: 1.3rem !important; }
}
</style>