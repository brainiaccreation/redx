    @extends('admin.master.layouts.app')
    @section('page-title')
        Coupons
    @endsection
    @section('head')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
        <link href="{{ URL('admin/assets') }}/css/datatable.min.css" rel="stylesheet" type="text/css" />
        <style>
            .text-purple {
                color: #6f42c1;
            }

            .text-muted {
                color: #6c757d !important;
            }

            .font-monospace {
                font-family: "Courier New", Courier, monospace;
            }
        </style>
    @endsection
    @section('page-content')
        @component('admin.master.layouts.partials.breadcrumb')
            @slot('li_1')
                Dashboard
            @endslot
            @slot('title')
                Coupons
            @endslot
        @endcomponent
        <div class="page-content">
            <div class="container-fluid">

                <!-- Header -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="h3 mb-2 text-dark">Coupon Management</h1>
                            <p class="text-muted">Manage your discount codes and promotional offers</p>
                        </div>
                        <button class="btn btn-danger d-flex align-items-center gap-2" data-bs-toggle="modal"
                            data-bs-target="#couponModal">
                            <img src="{{ asset('admin/assets/images/svg/add.svg') }}" width="12" class="me-1">
                            Add New Coupon
                        </button>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="row row-cols-1 row-cols-md-4 g-4 mb-4">
                    <div class="col">
                        <div class="card shadow-sm">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="text-muted small mb-1">Total Coupons</p>
                                    <p class="h4 mb-0 text-dark">{{ $stats['total_coupons'] }}</p>
                                </div>
                                <i class="bi bi-tags h3 text-primary"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card shadow-sm">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="text-muted small mb-1">Active Coupons</p>
                                    <p class="h4 mb-0 text-success">{{ $stats['active_coupons'] }}</p>
                                </div>
                                <i class="bi bi-person-check h3 text-success"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card shadow-sm">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="text-muted small mb-1">Total Usage</p>
                                    <p class="h4 mb-0 text-purple">{{ $stats['total_usage'] }}</p>
                                </div>
                                <i class="bi bi-percent h3 text-purple"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card shadow-sm">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="text-muted small mb-1">Expired</p>
                                    <p class="h4 mb-0 text-danger">{{ $stats['expired_coupons'] }}</p>
                                </div>
                                <i class="bi bi-calendar-x h3 text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                {{-- <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                                    <input type="text" id="search-input" placeholder="Search coupons..."
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4 d-flex align-items-center">
                                <span class="me-2"><i class="bi bi-filter"></i></span>
                                <select id="status-filter" class="form-select">
                                    <option value="all">All Status</option>
                                    <option value="active">Active</option>
                                    <option value="expired">Expired</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div> --}}

                <!-- Coupons Table -->
                <div class="card">
                    <div class="card-body">
                        <table id="coupons-table"
                            class="table table-bordered dt-responsive nowrap table-striped align-middle">
                            <thead>
                                <tr>
                                    <th scope="col"
                                        class="px-3 py-3 text-start text-xs font-medium text-muted text-uppercase">
                                        Coupon Code</th>
                                    <th scope="col"
                                        class="px-3 py-3 text-start text-xs font-medium text-muted text-uppercase">
                                        Type & Value</th>
                                    <th scope="col"
                                        class="px-3 py-3 text-start text-xs font-medium text-muted text-uppercase">
                                        Usage</th>
                                    <th scope="col"
                                        class="px-3 py-3 text-start text-xs font-medium text-muted text-uppercase">
                                        Expiry Date</th>
                                    <th scope="col"
                                        class="px-3 py-3 text-start text-xs font-medium text-muted text-uppercase">
                                        Status</th>
                                    <th scope="col"
                                        class="px-3 py-3 text-start text-xs font-medium text-muted text-uppercase">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="couponModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalTitle">Add New Coupon</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="coupon-form">
                                    @csrf
                                    <input type="hidden" id="coupon-id">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="code" class="form-label">Coupon Code *</label>
                                            <input type="text" id="code" name="code" required
                                                class="form-control font-monospace" placeholder="e.g., SAVE20">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="type" class="form-label">Discount Type *</label>
                                            <select id="type" name="type" class="form-select">
                                                <option value="percentage">Percentage (%)</option>
                                                <option value="fixed">Fixed Amount ($)</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="value" class="form-label">Discount Value *</label>
                                            <input type="number" id="value" name="value" required min="0.01"
                                                step="0.01" class="form-control" placeholder="20">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="min_amount" class="form-label">Minimum Order Amount *</label>
                                            <input type="number" id="min_amount" name="min_amount" required
                                                min="0" step="0.01" class="form-control" placeholder="100">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="max_discount" class="form-label">Maximum Discount Amount</label>
                                            <input type="number" id="max_discount" name="max_discount" min="0"
                                                step="0.01" class="form-control" placeholder="50">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="usage_limit" class="form-label">Usage Limit *</label>
                                            <input type="number" id="usage_limit" name="usage_limit" required
                                                min="1" class="form-control" placeholder="100">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="expiry_date" class="form-label">Expiry Date *</label>
                                            <input type="date" id="expiry_date" name="expiry_date" required
                                                class="form-control" min="{{ now()->toDateString() }}">
                                        </div>
                                        <div class="col-md-6">
                                            <div class="">

                                                <label for="status" class="form-label">Status</label>
                                                <select id="status" name="status" class="form-select form-control">
                                                    <option value="active">Active</option>
                                                    <option value="inactive">Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea id="description" name="description" class="form-control" rows="3"
                                                placeholder="Brief description of the coupon..."></textarea>
                                        </div>
                                    </div>
                                    <div class="mt-4 d-flex justify-content-end gap-3">
                                        <button type="button" class="btn btn-light"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


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

        <script src="{{ URL('admin/assets') }}/js/pages/datatables.init.js"></script>
        <script>
            $(document).ready(function() {
                // Initialize DataTables with Bootstrap 5 integration
                const table = $('#coupons-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    autoWidth: false,
                    ajax: {
                        url: '{{ route('admin.coupon.index') }}',
                        type: 'GET',
                    },
                    dom: "<'d-flex align-items-center justify-content-start'<'search-container me-1'><'dropdown-container ms-1 position-relative'>>" +
                        "<'row'<'col-md-12'tr>>" +
                        "<'row'<'col-md-5'i><'col-md-7'p>>",
                    columns: [{
                            data: 'coupon_info',
                            name: 'code'
                        },
                        {
                            data: 'discount_info',
                            name: 'value'
                        },
                        {
                            data: 'usage_info',
                            name: 'used_count'
                        },
                        {
                            data: 'expiry_date',
                            name: 'expiry_date'
                        },
                        {
                            data: 'status_badge',
                            name: 'status',
                            searchable: true
                        },
                        {
                            data: 'actions',
                            orderable: false,
                            searchable: false
                        }
                    ],
                    language: {
                        paginate: {
                            previous: "Previous",
                            next: "Next"
                        },
                        emptyTable: "No coupons found",
                        processing: "Loading...",
                        search: ""
                    },
                    fnInitComplete: function() {
                        $('#SaleTable').removeClass('d-none').fadeIn();

                        // Custom Search Input
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
                        // Custom Dropdown
                        let dropdownWrapper = $('<div class="dropdown-wrapper position-relative"></div>');
                        dropdownWrapper.append(`
                    <svg class="dropdown-icon position-absolute" width="9" height="8" viewBox="0 0 11 8" fill="none" xmlns="http://www.w3.org/2000/svg">
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


                // Form submission
                $('#coupon-form').on('submit', function(e) {
                    e.preventDefault();
                    const couponId = $('#coupon-id').val();
                    const url = couponId ? '{{ route('admin.coupon.update', ':id') }}'.replace(':id',
                        couponId) :
                        '{{ route('admin.coupon.store') }}';
                    const method = couponId ? 'PUT' : 'POST';

                    $.ajax({
                        url: url,
                        method: method,
                        data: $(this).serialize(),
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success(response.message);
                                table.ajax.reload();
                                $('#couponModal').modal('hide');
                            }
                        },
                        error: function(xhr) {
                            const errors = xhr.responseJSON.errors;
                            let errorMessage = 'Please fix the following errors:\n';
                            $.each(errors, function(key, value) {
                                errorMessage += `- ${value[0]}\n`;
                            });
                            toastr.error(errorMessage);
                        }
                    });
                });


            });

            function openModal(coupon = null) {
                if (coupon) {
                    $('#modalTitle').text('Edit Coupon');
                    $('#coupon-id').val(coupon.id);
                    $('#code').val(coupon.code);
                    $('#type').val(coupon.type);
                    $('#value').val(coupon.value);
                    $('#min_amount').val(coupon.min_amount);
                    $('#max_discount').val(coupon.max_discount || '');
                    $('#usage_limit').val(coupon.usage_limit);
                    $('#expiry_date').val(coupon.expiry_date);
                    $('#status').val(coupon.status);
                    $('#description').val(coupon.description || '');
                } else {
                    $('#modalTitle').text('Add New Coupon');
                    $('#coupon-form')[0].reset();
                    $('#coupon-id').val('');
                    $('#status').val('active');
                }
                $('#couponModal').modal('show');
            }

            function closeModal() {
                $('#couponModal').modal('hide');
            }

            function deleteCoupon(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('admin.coupon.destroy', ':id') }}'.replace(':id', id),
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if (response.success) {
                                    toastr.success(response.message);
                                    $('#coupons-table').DataTable().ajax.reload();
                                }
                            },
                            error: function(xhr) {
                                toastr.error(xhr.responseJSON.message);
                            }
                        });
                    }
                });
            }
        </script>
    @endsection
