@extends('admin.master.layouts.app')
@section('page-title')
    Manage Orders
@endsection
@section('head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <link href="{{ asset('admin/assets') }}/css/datatable.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('page-content')
    @component('admin.master.layouts.partials.breadcrumb')
        @slot('li_1')
            Dashboard
        @endslot
        @slot('title')
            Manage Orders
        @endslot
    @endcomponent
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <div class="p-0">
                                    <h4 class="card-title mb-0 flex-grow-1">Manage Orders</h4>
                                </div>

                            </div>
                        </div>
                        <div id="hidden-buttons" style="display: none;"></div>

                        <div class="card-body">
                            <table class="table table-bordered dt-responsive nowrap table-striped align-middle"
                                id="orders-table">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer</th>
                                        <th>Order Date</th>
                                        <th>Amount</th>
                                        <th>Payment Method</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div><!--end col-->
            </div><!--end row-->
        </div>
    </div>
@endsection
@section('scripts')
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
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

    <script src="{{ asset('admin/assets') }}/js/pages/datatables.init.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#orders-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                ajax: {
                    url: "{{ route('admin.orders.get') }}",
                    type: "GET",
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                },
                dom: "<'row-Import-wrapper'<'row-import'B><'d-flex align-items-center justify-content-start'<'search-container me-1'f><'dropdown-container ms-1'l>>>" +
                    "<'row'<'col-md-12'tr>>" +
                    "<'row'<'col-md-5'i><'col-md-7'p>>",
                order: [
                    [2, 'desc']
                ],
                // dom: "B<'d-flex align-items-center justify-content-start'<'search-container me-1'><'dropdown-container ms-1 position-relative'>>" +
                //     "<'row'<'col-md-12'tr>>" +
                //     "<'row'<'col-md-5'i><'col-md-7'p>>",
                buttons: [{
                    extend: 'csvHtml5',
                    className: 'yajra-csv-btn d-none',
                    title: 'Orders Export',
                    filename: 'Orders_Export',
                    exportOptions: {
                        columns: ':not(.no-export)'
                    }
                }],
                columns: [{
                        data: 'order_id',
                        name: 'order_id'
                    },
                    {
                        data: 'customer',
                        name: 'customer'
                    },
                    {
                        data: 'order_date',
                        name: 'order_date'
                    },
                    {
                        data: 'total_amount',
                        name: 'total_amount'
                    },
                    {
                        data: 'payment_method',
                        name: 'payment_method'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'no-export'
                    }
                ],
                language: {
                    paginate: {
                        previous: "Previous",
                        next: "Next"
                    },
                    search: ""
                },
                fnInitComplete: function() {
                    $('#hidden-buttons').append($('.yajra-csv-btn'));

                    // $('.buttons-csv').hide();
                    $('.dt-buttons').appendTo('.button-container');
                    let buttonContainer = $('<div class="row-import"></div>');
                    let exportIcon = `
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <mask id="mask0_2599_2417" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="20" height="20">
                            <rect width="20" height="20" fill="url(#pattern0_2599_2417)"/>
                            </mask>
                            <g mask="url(#mask0_2599_2417)">
                            <rect x="-5.45312" y="-7.27271" width="30" height="33.6364" fill="#26303B"/>
                            </g>
                            <defs>
                            <pattern id="pattern0_2599_2417" patternContentUnits="objectBoundingBox" width="1" height="1">
                            <use xlink:href="#image0_2599_2417" transform="scale(0.00195312)"/>
                            </pattern>
                            <image id="image0_2599_2417" width="512" height="512" preserveAspectRatio="none" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAgAAAAIACAYAAAD0eNT6AAAAAXNSR0IArs4c6QAAIABJREFUeAHt3WmsNGlVAOCD7CAy4AxgIsiiogIqsiWKgOwIZCCIQEBRQQc0CAFR0CggBkL4YcAFhl0w4IJKlIgC+svID3dBCNugQX8oys7MALP4vfQt5n537tLv7aruOnWeTr70vffrqn7Pc06976m6fbsj3AgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBAgQIECAAAECBLYgcKOIuE9EPD0iXhYRfxoR74qIv4+Iv4mId0bEayPiORFx34i43hbG5CkIECBAgACBkQXOObOof29EvGBvkb88Iq7s+HdxRLwhIu4dETceeWx2R4AAAQIECIwscN7emfyXOhb7kxqDtq/XRMS5I4/V7ggQIECAAIERBO4VEZ8YceE/2Bi0fX//COO0CwIECBAgQGAkgcdFxBcnXPyHZuDSiHjMSGO2GwIECBAgQGADgbb4f3kLi//QBFwWET+2wXhtSoAAAQIECGwo0Bbi3hf4DQv5JvftOTUBGybP5gQIECBA4DQCu1r8h8bhioi44DQDtw0BAgQIECBwOoFdL/6agNPlzVYECBAgQODUAnNZ/DUBp06hDQkQIECAQJ/A3BZ/TUBf/jyaAAECBAh0C8x18dcEdKfSBgQIECBAYD2BuS/+moD18uhRBAgQIEBgbYEsi78mYO2UeiAB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"/>
                            </defs>
                        </svg>
                    `;

                    let buttons = $(
                        `<div class="btn__wrapper"><button class="btn dt-button buttons-csv" id="custom-export-btn" type="button">${exportIcon} Export</button></div>`
                    );
                    let toggler = $(
                        `<button class="toggler_opt"><svg width="6" height="24" viewBox="0 0 6 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 3C6 4.65685 4.65685 6 3 6C1.34315 6 0 4.65685 0 3C0 1.34315 1.34315 0 3 0C4.65685 0 6 1.34315 6 3ZM2.01366 3C2.01366 3.54474 2.45526 3.98634 3 3.98634C3.54474 3.98634 3.98634 3.54474 3.98634 3C3.98634 2.45526 3.54474 2.01366 3 2.01366C2.45526 2.01366 2.01366 2.45526 2.01366 3Z" fill="#26303B"/><path d="M6 12C6 13.6569 4.65685 15 3 15C1.34315 15 0 13.6569 0 12C0 10.3431 1.34315 9 3 9C4.65685 9 6 10.3431 6 12ZM2.01366 12C2.01366 12.5447 2.45526 12.9863 3 12.9863C3.54474 12.9863 3.98634 12.5447 3.98634 12C3.98634 11.4553 3.54474 11.0137 3 11.0137C2.45526 11.0137 2.01366 11.4553 2.01366 12Z" fill="#26303B"/><path d="M6 21C6 22.6569 4.65685 24 3 24C1.34315 24 0 22.6569 0 21C0 19.3431 1.34315 18 3 18C4.65685 18 6 19.3431 6 21ZM2.01366 21C2.01366 21.5447 2.45526 21.9863 3 21.9863C3.54474 21.9863 3.98634 21.5447 3.98634 21C3.98634 20.4553 3.54474 20.0137 3 20.0137C2.45526 20.0137 2.01366 20.4553 2.01366 21Z" fill="#26303B"/></svg></button>`
                    );
                    buttonContainer.append(toggler).append(buttons);
                    $('.row-import').replaceWith(buttonContainer);

                    buttons.find('.buttons-csv').on('click', function() {
                        table.button('.yajra-csv-btn').trigger();
                    });
                    // Custom Search
                    let searchWrapper = $('<div class="search-wrapper position-relative"></div>');
                    searchWrapper.append(`
                        <svg class="search-icon position-absolute" width="13" height="13" viewBox="0 0 18 18" fill="none">
                            <path d="M17 17L15.4 15.4M8.6 16.2C9.6 16.2 10.6 16 11.5 15.6C12.4 15.2 13.2 14.6 13.9 13.9C14.6 13.2 15.2 12.4 15.6 11.5C16 10.6 16.2 9.6 16.2 8.6C16.2 7.6 16 6.6 15.6 5.7C15.2 4.7 14.6 3.9 13.9 3.2C13.2 2.5 12.4 2 11.5 1.6C10.6 1.2 9.6 1 8.6 1C6.6 1 4.7 1.8 3.2 3.2C1.8 4.6 1 6.6 1 8.6C1 10.6 1.8 12.5 3.2 13.9C4.6 15.4 6.6 16.2 8.6 16.2Z" stroke="#26303B" stroke-opacity="0.5" stroke-width="1.5"></path>
                        </svg>
                    `);
                    let searchInput = $(
                        '<input type="text" class="form-control custom-search-input" placeholder="Search...">'
                    );
                    searchInput.on('keyup', function() {
                        table.search(this.value).draw();
                    });
                    searchWrapper.append(searchInput);
                    $('.search-container').html(searchWrapper);

                    // Page Length Dropdown
                    let dropdownWrapper = $(
                        '<div class="dropdown-wrapper position-relative ms-2"></div>');
                    dropdownWrapper.append(`
                        <svg class="dropdown-icon position-absolute" width="9" height="8" viewBox="0 0 11 8" fill="none">
                            <path d="M10.149 0L0.531852 0C0.434483 0.0003 0.339041 0.0272 0.2558 0.0777C0.172557 0.1282 0.104668 0.2004 0.059439 0.2867C0.0142091 0.3729 -0.00664777 0.4698 -0.00088566 0.567C0.0048755 0.6642 0.0370363 0.758 0.0921348 0.8383L4.90071 7.784C5.1 8.072 5.57979 8.072 5.77961 7.784L10.5882 0.8383C10.6438 0.7582 10.6765 0.6643 10.6826 0.567C10.6886 0.4696 10.6679 0.3725 10.6226 0.2861C10.5774 0.1996 10.5093 0.1273 10.4258 0.0769C10.3423 0.0264 10.2466 0 10.149 0Z" fill="#26303B" fill-opacity="0.7"/>
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

            $(document).on('change', '.status', function() {

                var id = $(this).attr('data-id');
                var url = "{{ route('admin.category.status', ':id') }}";
                url = url.replace(':id', id);

                if ($(this).is(':checked')) {
                    var status = 1;
                    var isActive = 'activated';
                } else {
                    var status = 0;
                    var isActive = 'deactivated';
                }

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        status: status,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        toastr.success('Category ' + isActive);

                    }
                });
            });
        });
    </script>
@endsection
