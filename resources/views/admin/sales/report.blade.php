@section('page-title')
    Sales Report
@endsection
@section('head')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <link href="{{ asset('admin/assets') }}/css/datatable.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <style>
        :root {
            --primary-color: #ff0000;
            --primary-light: #ff3333;
            --primary-dark: #cc0000;
            --primary-gradient: linear-gradient(135deg, #ff0000, #ff3333);
            --success-color: #28a745;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
            --light-bg: #f8f9fa;
            --primary-gradient: linear-gradient(135deg, #ff0000, #ff7f7f);

        }

        body {
            font-family: "Open Sans", sans-serif !important;

            background: #f3f3f9;
        }

        div#heatmapMonthHeader>div {
            font-family: "Open Sans", sans-serif !important;

        }

        .dashboard-header {
            background: white;
            padding: 0.5rem;
            border-radius: 6px;
            margin-bottom: 1rem;
        }

        .dashboard-title {
            color: #495057;
            font-size: 20px;
            margin: 0;
            font-family: "Open Sans", sans-serif !important;
            font-optical-sizing: auto;
            font-style: normal;
            font-variation-settings: "wdth" 100;
        }

        .filters-section {
            background: white;
            border-radius: 6px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .stats-card {
            background: #ffffff;
            border-radius: 6px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            position: relative;
            overflow: hidden;
            color: #22303b;
            transition: background 0.3s ease, color 0.3s ease;
        }

        .stats-card:hover {
            background: var(--primary-gradient);
            color: #fdf5f5e8;
        }

        .stats-card:hover .stat-label,
        .stats-card:hover .stat-value,
        .stats-card:hover .stat-change {
            color: #fdf5f5e8;
        }

        .stat-value {
            font-size: 1.7rem;
            font-weight: 600;
            color: #22303b;
            margin: 0;
            transition: color 0.3s ease;
        }

        .stat-label {
            color: #22303b;
            font-size: 0.9rem;
            margin-top: 0.5rem;
            transition: color 0.3s ease;
        }

        .stat-change {
            font-size: 0.8rem;
            margin-top: 0.5rem;
            transition: color 0.3s ease;
        }

        .change-positive {
            color: #28a745;
        }

        .change-negative {
            color: #dc3545;
        }

        /* Override colors on hover */
        .stats-card:hover .change-positive,
        .stats-card:hover .change-negative {
            color: #fdf5f5e8;
        }

        .equal-height-row {
            display: flex;
            flex-wrap: wrap;
        }

        .equal-height-row>.col-lg-6 {
            display: flex;
            flex-direction: column;
        }

        .chart-container {
            background: white;
            border-radius: 6px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            height: 100%;
            display: flex;
            flex-direction: column;

        }

        .chart-title {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }

        .funnel-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            margin-bottom: 0.5rem;
            border-radius: 10px;
            background: linear-gradient(90deg, var(--primary-color), var(--primary-light));
            color: white;
            position: relative;
        }

        .funnel-item:nth-child(2) {
            background: linear-gradient(90deg, #ff3333, #ff6666);
        }

        .funnel-item:nth-child(3) {
            background: linear-gradient(90deg, #ff6666, #ff9999);
        }

        .funnel-label {
            font-weight: 600;
            font-size: 0.9rem;
        }

        .funnel-value {
            font-weight: bold;
            font-size: 1.1rem;
        }

        .funnel-percentage {
            font-size: 0.8rem;
            opacity: 0.9;
        }

        .customers-list {
            max-height: 300px;
            overflow-y: auto;
        }

        .customer-item {
            display: flex;
            align-items: center;
            padding: 0.75rem;
            border-bottom: 1px solid #eee;
            transition: background-color 0.2s;
        }

        .customer-item:hover {
            background-color: #f8f9fa;
        }

        .customer-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #ff0000;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            margin-right: 1rem;
        }

        .customer-info h6 {
            margin: 0;
            font-size: 0.9rem;
            color: #2c3e50;
        }

        .customer-info small {
            color: #7f8c8d;
        }

        .heatmap-month-header {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 4px;
            margin-bottom: 0.5rem;
            text-align: center;
            font-size: 0.75rem;
            font-weight: bold;
            color: #2c3e50;
        }

        .heatmap-container {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 4px;
            margin-top: 0.5rem;
            min-height: 40px;
        }


        .heatmap-day {
            aspect-ratio: 2/0.7;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 600;
            color: white;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .heatmap-day:hover {
            transform: scale(1.05);
            box-shadow: 0px 0px 11px 2px #6b6b6b26;
        }

        .heatmap-header {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 4px;
            margin-bottom: 0.5rem;
        }

        .heatmap-header div {
            text-align: center;
            font-size: 0.7rem;
            color: #7f8c8d;
            font-weight: 600;
        }

        .intensity-1 {
            background-color: #ffe6e6;
            color: #404c56;
        }

        /* lightest */
        .intensity-2 {
            background-color: #ffb3b3;
        }

        .intensity-3 {
            background-color: #ff8080;
        }

        .intensity-4 {
            background-color: #ff4d4d;
        }

        .intensity-5 {
            background-color: #ff1a1a;
        }

        .intensity-6 {
            background-color: #ff0000;
        }

        /* darkest (most recent) */

        .table-container {
            background: white;
            border-radius: 6px;
            padding: 1.5rem;
            margin-top: 2rem;
        }


        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-completed {
            background-color: #d4edda;
            color: #155724;
        }

        .payment-method {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .payment-stripe {
            background-color: #e3f2fd;
            color: #1565c0;
        }

        .payment-paydibs {
            background-color: #f3e5f5;
            color: #7b1fa2;
        }

        .payment-wallet {
            background-color: #e8f5e8;
            color: #2e7d32;
        }

        .btn-primary {
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 0, 0, 0.3);
        }

        /* .generate-report-btn {
                                                                                                                                                                                                                                                                                                                                                                                                                background: var(--primary-gradient);
                                                                                                                                                                                                                                                                                                                                                                                                                border: none;
                                                                                                                                                                                                                                                                                                                                                                                                                color: white;
                                                                                                                                                                                                                                                                                                                                                                                                                padding: 12px 25px;
                                                                                                                                                                                                                                                                                                                                                                                                                border-radius: 25px;
                                                                                                                                                                                                                                                                                                                                                                                                                font-weight: 600;
                                                                                                                                                                                                                                                                                                                                                                                                                transition: all 0.3s ease;
                                                                                                                                                                                                                                                                                                                                                                                                            }

                                                                                                                                                                                                                                                                                                                                                                                                            .generate-report-btn:hover {
                                                                                                                                                                                                                                                                                                                                                                                                                transform: translateY(-2px);
                                                                                                                                                                                                                                                                                                                                                                                                                box-shadow: 0 4px 15px rgba(255, 0, 0, 0.3);
                                                                                                                                                                                                                                                                                                                                                                                                            } */

        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: skeleton-loading 1.5s infinite;
            border-radius: 4px;
        }

        @keyframes skeleton-loading {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        }

        .skeleton-text {
            height: 1.2rem;
            margin: 0.5rem 0;
        }

        .skeleton-card {
            height: 150px;
        }

        .skeleton-funnel {
            height: 60px;
            margin-bottom: 0.5rem;
        }

        .skeleton-customer {
            height: 60px;
            margin-bottom: 0.5rem;
        }

        .skeleton-heatmap {
            height: 35px;
            margin: 2px;
        }

        @media (max-width: 768px) {
            .heatmap-container {
                grid-template-columns: repeat(3, 1fr);
            }

            .heatmap-month-header {
                grid-template-columns: repeat(3, 1fr);
                font-size: 0.6rem;
            }

            .heatmap-day {
                font-size: 0.6rem;
            }
        }
    </style>
@endsection
@extends('admin.master.layouts.app')
@section('page-content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- Dashboard Header -->
            <div class="dashboard-header">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="dashboard-title">Sales Report</h1>
                    </div>
                    <div class="col-md-4 text-end">
                        <button class="btn generate-report-btn btn-danger" onclick="generatePDFReport()">
                            <i class="fas fa-file-pdf me-2"></i>Generate Report
                        </button>
                        {{-- <a class="btn generate-report-btn btn-danger" href="{{ route('generate.pdf') }}">
                            <i class="fas fa-file-pdf me-2"></i>Generate Report
                        </a> --}}
                    </div>
                </div>
            </div>

            <!-- Filters Section -->
            <div class="filters-section">
                <div class="row align-items-end">
                    <div class="col-md-2">
                        <label class="form-label">Date Range</label>
                        <select class="form-select" id="dateRange">
                            <option value="365" selected>Last year</option>
                            <option value="90">Last 3 months</option>
                            <option value="30">Last 30 days</option>
                            <option value="7">Last 7 days</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Payment Method</label>
                        <select class="form-select" id="paymentFilter">
                            <option value="">All Methods</option>
                            <option value="stripe">Stripe</option>
                            <option value="paydibs">Paydibs</option>
                            <option value="wallet">Wallet</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" id="statusFilter">
                            <option value="">All Status</option>
                            <option value="completed">Completed</option>
                            <option value="processing">Processing</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <div class="text-end">
                            <button class="btn btn-danger" onclick="applyFilters()">
                                <i class="fas fa-filter me-2"></i>Apply Filters
                            </button>
                            <button class="btn btn-light ms-2" onclick="resetFilters()">
                                <i class="fas fa-refresh me-2"></i>Reset
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row" id="statsCards">
                <div class="col-lg-4 col-md-6">
                    <div class="stats-card skeleton skeleton-card"></div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="stats-card skeleton skeleton-card"></div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="stats-card skeleton skeleton-card"></div>
                </div>
            </div>

            <div class="row equal-height-row">
                <!-- Payment Method Breakdown -->
                <div class="col-lg-6">
                    <div class="chart-container">
                        <h5 class="chart-title">Payment Method Breakdown</h5>
                        <div id="paymentBreakdown">
                            <div class="funnel-item skeleton skeleton-funnel"></div>
                            <div class="funnel-item skeleton skeleton-funnel"></div>
                            <div class="funnel-item skeleton skeleton-funnel"></div>
                        </div>
                    </div>
                </div>

                <!-- New Customers -->
                <div class="col-lg-6">
                    <div class="chart-container">
                        <h5 class="chart-title">New Customers</h5>
                        <div class="customers-list" id="newCustomers">
                            <div class="customer-item skeleton skeleton-customer"></div>
                            <div class="customer-item skeleton skeleton-customer"></div>
                            <div class="customer-item skeleton skeleton-customer"></div>
                            <div class="customer-item skeleton skeleton-customer"></div>
                            <div class="customer-item skeleton skeleton-customer"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sales Heatmap -->
            <div class="row">
                <div class="col-12">
                    <div class="chart-container">
                        <h5 class="chart-title">Sales Heatmap</h5>
                        <div class="heatmap-month-header" id="heatmapMonthHeader"></div>
                        <div class="heatmap-container" id="heatmapContainer">
                            @for ($i = 0; $i < 6; $i++)
                                <div class="heatmap-day skeleton skeleton-heatmap"></div>
                            @endfor
                        </div>

                    </div>
                </div>
            </div>

            <!-- Sales Report Table -->
            <div class="table-container" id="salesReportTable">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="chart-title">Sales Report</h5>
                    <span class="badge bg-primary skeleton skeleton-text" style="width: 100px;"></span>
                </div>


                <table id="salesTable" class="table table-bordered dt-responsive nowrap table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Items</th>
                            <th>Order Date</th>
                            <th>Amount</th>
                            <th>Payment Method</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < 5; $i++)
                            <tr>
                                <td>
                                    <div class="skeleton skeleton-text" style="width: 120px;"></div>
                                </td>
                                <td>
                                    <div class="skeleton skeleton-text" style="width: 100px;"></div>
                                </td>
                                <td>
                                    <div class="skeleton skeleton-text" style="width: 200px;"></div>
                                </td>
                                <td>
                                    <div class="skeleton skeleton-text" style="width: 150px;"></div>
                                </td>
                                <td>
                                    <div class="skeleton skeleton-text" style="width: 80px;"></div>
                                </td>
                                <td>
                                    <div class="skeleton skeleton-text" style="width: 80px;"></div>
                                </td>
                                <td>
                                    <div class="skeleton skeleton-text" style="width: 100px;"></div>
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <!--datatable js-->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script src="{{ asset('admin/assets') }}/js/pages/datatables.init.js"></script>
    <script>
        const APP_CURRENCY = "{{ config('app.currency') ?? 'RM' }}";
    </script>
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#salesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('api.sales.orders') }}',
                    data: function(d) {
                        d.date_range = $('#dateRange').val();
                        d.payment_method = $('#paymentFilter').val();
                        d.status = $('#statusFilter').val();
                        d.customer_type = $('#customerType').val();
                    }
                },
                columns: [{
                        data: 'order_id',
                        name: 'order_number'
                    },
                    {
                        data: 'customer',
                        name: 'customer'
                    },
                    {
                        data: 'items',
                        name: 'items',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'order_date',
                        name: 'created_at'
                    },
                    {
                        data: 'total_amount',
                        name: 'total_amount'
                    },
                    {
                        data: 'payment_method',
                        render: function(data) {
                            const classes = {
                                'Stripe': 'payment-stripe',
                                'Paydibs': 'payment-paydibs',
                                'Wallet': 'payment-wallet'
                            };
                            return `<span class="payment-method ${classes[data] || ''}">${data}</span>`;
                        },
                        name: 'payment_method'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    }
                ],
                responsive: true,
                pageLength: 10,
                order: [
                    [3, 'desc']
                ],
                dom: "<'d-flex align-items-center justify-content-start mb-3'<'search-container me-1'><'dropdown-container ms-1 position-relative'>>" +
                    "<'row'<'col-md-12'tr>>" +
                    "<'row'<'col-md-5'i><'col-md-7'p>>",
                language: {
                    search: "",
                    lengthMenu: "Show _MENU_ orders",
                    info: "Showing _START_ to _END_ of _TOTAL_ orders"
                },
                fnInitComplete: function() {
                    // Custom Search Input
                    let searchWrapper = $('<div class="search-wrapper position-relative"></div>');
                    searchWrapper.append(`
            <svg class="search-icon position-absolute" width="13" height="13" viewBox="0 0 18 18" fill="none">
                <path d="M17 17L15.4 15.4M8.6 16.2C9.6 16.2 10.6 16 11.5 15.6C12.4 15.2 13.2 14.6 13.9 13.9C14.6 13.2 15.2 12.4 15.6 11.5C16 10.6 16.2 9.6 16.2 8.6C16.2 7.6 16 6.6 15.6 5.7C15.2 4.7 14.6 3.9 13.9 3.2C13.2 2.5 12.4 2 11.5 1.6C10.6 1.2 9.6 1 8.6 1C6.6 1 4.7 1.8 3.2 3.2C1.8 4.6 1 6.6 1 8.6C1 10.6 1.8 12.5 3.2 13.9C4.6 15.4 6.6 16.2 8.6 16.2Z" stroke="#26303B" stroke-opacity="0.5" stroke-width="1.5"></path>
            </svg>
        `);
                    let searchInput = $(
                        '<input type="text" class="form-control custom-search-input" placeholder="Search Orders...">'
                    );
                    searchInput.on('keyup', function() {
                        table.search(this.value).draw();
                    });
                    searchWrapper.append(searchInput);
                    $('.search-container').html(searchWrapper);

                    // Custom Dropdown
                    let dropdownWrapper = $('<div class="dropdown-wrapper position-relative"></div>');
                    dropdownWrapper.append(`
            <svg class="dropdown-icon position-absolute" width="9" height="8" viewBox="0 0 11 8" fill="none">
                <path d="M10.149 1.47725e-06L0.531852 2.318e-06C0.434483 0.000307502 0.339041 0.0271625 0.2558 0.0776758C0.172557 0.128189 0.104668 0.200448 0.059439 0.286674C0.0142091 0.372902 -0.00664777 0.469832 -0.00088566 0.567031C0.0048755 0.66423 0.0370363 0.758017 0.0921348 0.838297L4.90071 7.78402C5.1 8.072 5.57979 8.072 5.77961 7.78402L10.5882 0.838296C10.6438 0.758183 10.6765 0.664349 10.6826 0.566988C10.6886 0.469627 10.6679 0.372464 10.6226 0.286054C10.5774 0.199645 10.5093 0.127293 10.4258 0.0768614C10.3423 0.0264302 10.2466 -0.00015255 10.149 1.47725e-06Z" fill="#26303B" fill-opacity="0.7"/>
            </svg>
        `);
                    let dropdown = $('<select class="form-select"></select>');
                    dropdown.append('<option value="10">10</option>');
                    dropdown.append('<option value="25">25</option>');
                    dropdown.append('<option value="50">50</option>');
                    dropdown.append('<option value="100">100</option>');
                    dropdown.val(table.page.len());
                    dropdown.on('change', function() {
                        table.page.len(this.value).draw();
                    });
                    dropdownWrapper.append(dropdown);
                    $('.dropdown-container').html(dropdownWrapper);
                }
            });


            // Load initial data
            loadStats();
            loadPaymentBreakdown();
            loadNewCustomers();
            loadHeatmap();

            // Apply filters
            window.applyFilters = function() {
                const filters = {
                    date_range: $('#dateRange').val(),
                    payment_method: $('#paymentFilter').val(),
                    status: $('#statusFilter').val(),
                    customer_type: $('#customerType').val()
                };
                table.ajax.reload();
                loadStats(filters);
                loadPaymentBreakdown(filters);
                loadNewCustomers(filters);
                loadHeatmap(filters);
                toastr.success('Filters applied!');
            };

            // Reset filters
            window.resetFilters = function() {
                $('#dateRange').val('365'); // Last year
                $('#paymentFilter').val(''); // All Methods
                $('#statusFilter').val(''); // All Status
                $('#customerType').val('');
                applyFilters();
            };


            // Load stats
            function loadStats(filters = {}) {
                $.ajax({
                    url: '{{ route('api.sales.stats') }}',
                    data: filters,
                    success: function(data) {
                        $('#statsCards').html(`
                            <div class="col-lg-4 col-md-6">
                                <div class="stats-card">
                                    <i class="ri-exchange-funds-fill"></i>
                                    <span class="stat-label">Total Sales</span>
                                    <h3 class="stat-value">${APP_CURRENCY} ${data.total_sales}</h3>
                                    <div class="stat-change ${data.sales_change >= 0 ? 'change-positive' : 'change-negative'}">
                                        <i class="fas fa-arrow-${data.sales_change >= 0 ? 'up' : 'down'}"></i> 
                                        ${Math.abs(data.sales_change)}% $${data.sales_today} today
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="stats-card">
                                    <i class="ri-shopping-bag-3-line"></i>
                                    <span class="stat-label">Total Orders</span>
                                    <h3 class="stat-value">${data.total_orders}</h3>
                                    <div class="stat-change ${data.orders_change >= 0 ? 'change-positive' : 'change-negative'}">
                                        <i class="fas fa-arrow-${data.orders_change >= 0 ? 'up' : 'down'}"></i> 
                                        ${Math.abs(data.orders_change)}% +${data.orders_today} today
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="stats-card">
                                    <i class="ri-stock-line"></i>
                                    <span class="stat-label">Average Order Value</span>
                                    <h3 class="stat-value">${APP_CURRENCY} ${data.avg_order_value}</h3>
                                    <div class="stat-change change-negative">
                                        <i class="fas fa-arrow-down"></i> Compared to last period
                                    </div>
                                </div>
                            </div>
                        `);
                    }
                });
            }

            // Load payment breakdown
            function loadPaymentBreakdown(filters = {}) {
                $.ajax({
                    url: '{{ route('api.sales.payment-breakdown') }}',
                    data: filters,
                    success: function(data) {
                        $('#paymentBreakdown').html(data.map((item, index) => `
                            <div class="funnel-item">
                                <div>
                                    <div class="funnel-label">${item.method}</div>
                                    <div class="funnel-percentage">${item.percentage}%</div>
                                </div>
                                <div class="funnel-value">${item.count}</div>
                            </div>
                        `).join(''));
                    }
                });
            }

            // Load new customers
            function loadNewCustomers(filters = {}) {
                $.ajax({
                    url: '{{ route('api.sales.new-customers') }}',
                    data: filters,
                    success: function(data) {
                        $('#newCustomers').html(data.map(customer => `
                            <div class="customer-item d-flex align-items-center mb-2">
                                ${customer.avatar 
                                    ? `<img src="${customer.avatar}" alt="${customer.name}" class="rounded-circle avatar-xs me-2">`
                                    : `<div class="user-name-avatar me-2">${customer.initials}</div>`
                                }
                                <div class="customer-info">
                                    <h6 class="mb-0">${customer.name}</h6>
                                    <small>Customer ${customer.joined_date}</small>
                                </div>
                            </div>
                        `).join(''));
                    }

                });
            }
            // Load heatmap
            function loadHeatmap(filters = {
                period: 'last_6_months'
            }) {
                $.ajax({
                    url: '{{ route('api.sales.heatmap') }}',
                    data: filters,
                    success: function(data) {
                        const container = document.getElementById('heatmapContainer');
                        const header = document.getElementById('heatmapMonthHeader');
                        container.innerHTML = '';
                        header.innerHTML = '';

                        // Sort data by sales to assign intensities based on rank
                        const sortedData = [...data].sort((a, b) => parseFloat(a.sales) - parseFloat(b
                            .sales));

                        // Assign intensities based on rank (1 to 6)
                        const intensityMap = {};
                        let currentIntensity = 1;
                        let prevSales = null;

                        sortedData.forEach((item, index) => {
                            const salesValue = parseFloat(item.sales);
                            // Increment intensity only if sales value changes or it's the first item
                            if (prevSales === null || salesValue > prevSales) {
                                currentIntensity = Math.min(currentIntensity + (prevSales !==
                                    null ? 1 : 0), 6);
                            }
                            intensityMap[item.month] = currentIntensity;
                            prevSales = salesValue;
                        });

                        // Render heatmap cells in original order
                        data.forEach((monthData) => {
                            const salesValue = parseFloat(monthData.sales);
                            const intensity = intensityMap[monthData.month];

                            // Create heatmap cell
                            const dayElement = document.createElement('div');
                            dayElement.className = `heatmap-day intensity-${intensity}`;
                            dayElement.textContent = `${APP_CURRENCY} ${salesValue.toFixed(2)}`;
                            dayElement.title =
                                `${monthData.month}: ${APP_CURRENCY} ${salesValue.toFixed(2)} (${monthData.orders} orders)`;

                            container.appendChild(dayElement);

                            // Create month label
                            const monthLabel = document.createElement('div');
                            monthLabel.textContent = monthData.month;
                            header.appendChild(monthLabel);
                        });

                        // Log for debugging
                        console.log('Heatmap Data:', data);
                        console.log('Intensity Map:', intensityMap);
                    },
                    error: function(xhr) {
                        console.error('Error loading heatmap:', xhr.responseText);
                    }
                });
            }


            // Generate PDF report
            // window.generatePDFReport = async function() {
            //     try {
            //         toastr.success('Generating PDF report...');

            //         const {
            //             jsPDF
            //         } = window.jspdf;
            //         const pdf = new jsPDF('p', 'mm', 'a4');

            //         pdf.setFontSize(20);
            //         pdf.setTextColor(255, 0, 0);
            //         pdf.text('Sales Report Dashboard', 20, 20);

            //         pdf.setFontSize(12);
            //         pdf.setTextColor(0, 0, 0);
            //         pdf.text(`Generated on: ${new Date().toLocaleDateString()}`, 20, 30);

            //         // Fetch stats for PDF
            //         $.ajax({
            //             url: '{{ route('api.sales.stats') }}',
            //             async: false,
            //             success: function(data) {
            //                 pdf.setFontSize(14);
            //                 pdf.setTextColor(255, 0, 0);
            //                 pdf.text('Summary Statistics', 20, 45);

            //                 pdf.setFontSize(11);
            //                 pdf.setTextColor(0, 0, 0);
            //                 pdf.text(`Total Sales: $${data.total_sales}`, 20, 55);
            //                 pdf.text(`Total Orders: ${data.total_orders}`, 20, 62);
            //                 pdf.text(`Average Order Value: $${data.avg_order_value}`, 20, 69);
            //             }
            //         });

            //         // Fetch payment breakdown for PDF
            //         $.ajax({
            //             url: '{{ route('api.sales.payment-breakdown') }}',
            //             async: false,
            //             success: function(data) {
            //                 pdf.setFontSize(14);
            //                 pdf.setTextColor(255, 0, 0);
            //                 pdf.text('Payment Method Breakdown', 20, 85);

            //                 pdf.setFontSize(11);
            //                 pdf.setTextColor(0, 0, 0);
            //                 data.forEach((item, index) => {
            //                     pdf.text(
            //                         `${item.method}: ${item.count} (${item.percentage}%)`,
            //                         20, 95 + (index * 7));
            //                 });
            //             }
            //         });

            //         // Fetch recent orders for PDF
            //         $.ajax({
            //             url: '{{ route('api.sales.orders') }}',
            //             async: false,
            //             data: {
            //                 per_page: 5
            //             },
            //             success: function(data) {
            //                 pdf.setFontSize(14);
            //                 pdf.setTextColor(255, 0, 0);
            //                 pdf.text('Recent Orders', 20, 125);

            //                 const tableData = [
            //                     ['Order ID', 'Customer', 'Amount', 'Payment', 'Status'],
            //                     ...data.data.map(order => [order.id, order.customer,
            //                         `$${order.amount}`, order.payment_method, order
            //                         .status
            //                     ])
            //                 ];

            //                 let yPosition = 135;
            //                 pdf.setFontSize(10);

            //                 tableData.forEach((row, index) => {
            //                     const isHeader = index === 0;
            //                     if (isHeader) {
            //                         pdf.setTextColor(255, 0, 0);
            //                         pdf.setFontSize(10);
            //                     } else {
            //                         pdf.setTextColor(0, 0, 0);
            //                         pdf.setFontSize(9);
            //                     }

            //                     pdf.text(row[0], 20, yPosition);
            //                     pdf.text(row[1], 60, yPosition);
            //                     pdf.text(row[2], 110, yPosition);
            //                     pdf.text(row[3], 135, yPosition);
            //                     pdf.text(row[4], 160, yPosition);

            //                     yPosition += 7;

            //                     if (yPosition > 270) {
            //                         pdf.addPage();
            //                         yPosition = 20;
            //                     }
            //                 });
            //             }
            //         });

            //         pdf.save('Sales_Report.pdf');
            //         toastr.success('PDF report generated successfully!');
            //     } catch (error) {
            //         console.error('Error generating PDF:', error);
            //         toastr.error('Failed to generate PDF report.');
            //     }
            // };

            window.generatePDFReport = async function() {
                const button = document.querySelector('.generate-report-btn');
                const originalHTML = button.innerHTML;

                try {
                    // Show loading spinner and change text
                    button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Generating...';
                    button.disabled = true;

                    toastr.success('Generating PDF report...');

                    // Get filter values from the UI
                    const dateRange = $('#dateRange').val();
                    const paymentMethod = $('#paymentFilter').val();
                    const status = $('#statusFilter').val();
                    const customerType = $('#customerType').val();

                    // Create a form to submit filters
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route('admin.sales.pdf') }}'; // Adjust route name as needed
                    form.style.display = 'none';

                    // Add CSRF token
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = csrfToken;
                    form.appendChild(csrfInput);

                    // Add filter inputs
                    const filters = {
                        date_range: dateRange,
                        payment_method: paymentMethod,
                        status: status,
                        customer_type: customerType
                    };
                    for (const [key, value] of Object.entries(filters)) {
                        if (value) {
                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = key;
                            input.value = value;
                            form.appendChild(input);
                        }
                    }

                    document.body.appendChild(form);
                    form.submit();
                    document.body.removeChild(form);

                    // Restore button after short delay (PDF generation is server-side)
                    setTimeout(() => {
                        button.innerHTML = originalHTML;
                        button.disabled = false;
                        toastr.success('PDF report generated successfully!');
                    }, 1000); // delay can be adjusted
                } catch (error) {
                    console.error('Error generating PDF:', error);
                    toastr.error('Failed to generate PDF report.');
                    button.innerHTML = originalHTML;
                    button.disabled = false;
                }
            };

        });
    </script>
@endsection
