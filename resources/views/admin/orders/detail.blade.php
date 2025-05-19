@extends('admin.master.layouts.app')
@section('page-title')
    Order Details
@endsection

@section('page-content')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-xl-9">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h5 class="card-title flex-grow-1 mb-0">Order #{{ $order->order_number }}</h5>
                                <div class="flex-shrink-0">
                                    <h4><span class="{{ $badgeClass }}">{{ ucfirst($status) }}</span></h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table-card">
                                <table class="table table-nowrap align-middle table-borderless mb-0">
                                    <thead class="table-light text-muted">
                                        <tr>
                                            <th scope="col">Product Details</th>
                                            <th scope="col">Item Price</th>
                                            <th scope="col">Quantity</th>
                                            {{-- <th scope="col">Rating</th> --}}
                                            <th scope="col">Total Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order_items as $order_item)
                                            <tr>
                                                <td>
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 avatar-md bg-light rounded p-1">
                                                            <img src="{{ $order_item->product->featured_image ? asset($order_item->product->featured_image) : URL('admin/assets/images/products/img-8.png') }}"
                                                                alt="" class="img-fluid d-block">
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h5 class="fs-15"><a
                                                                    href="{{ route('product.detail', $order_item->product->slug) }}"
                                                                    class="link-primary"
                                                                    target="_blank">{{ $order_item->product->name }}</a>
                                                            </h5>
                                                            <p class="text-muted mb-0">Variant: <span
                                                                    class="fw-medium">{{ $order_item->variant->name }}</span>
                                                            </p>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ config('app.currency') }} {{ number_format($order_item->price, 2) }}
                                                </td>
                                                <td>{{ $order_item->quantity }}</td>
                                                {{-- <td>
                                                    <div class="text-warning fs-15">
                                                        <i class="ri-star-fill"></i><i class="ri-star-fill"></i><i
                                                            class="ri-star-fill"></i><i class="ri-star-fill"></i><i
                                                            class="ri-star-half-fill"></i>
                                                    </div>
                                                </td> --}}
                                                <td class="fw-medium">
                                                    {{ config('app.currency') }}
                                                    {{ number_format($order_item->price * $order_item->quantity, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr class="border-top border-top-dashed">
                                            <td colspan="2"></td>
                                            <td colspan="2" class="fw-medium p-0">
                                                <table class="table table-borderless mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <td>Sub Total :</td>
                                                            <td class="text-end">{{ config('app.currency') }}
                                                                {{ number_format($order->total_amount, 2) }}</td>
                                                        </tr>

                                                        <tr class="border-top border-top-dashed">
                                                            <th scope="row">Total :</th>
                                                            <th class="text-end">{{ config('app.currency') }}
                                                                {{ number_format($order->total_amount, 2) }}</th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--end card-->
                    <div class="card">
                        <div class="card-header">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="card-title flex-grow-1 mb-0">Order Status</h5>
                                {{-- <div class="flex-shrink-0 mt-2 mt-sm-0">
                                    <a href="javascript:void(0);"
                                        class="btn btn-soft-info material-shadow-none btn-sm mt-2 mt-sm-0"><i
                                            class="ri-map-pin-line align-middle me-1"></i> Change Address</a>
                                    <a href="javascript:void(0);"
                                        class="btn btn-soft-danger material-shadow-none btn-sm mt-2 mt-sm-0"><i
                                            class="mdi mdi-archive-remove-outline align-middle me-1"></i> Cancel
                                        Order</a>
                                </div> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="profile-timeline">
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item border-0">
                                        <div class="accordion-header" id="headingOne">
                                            <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse"
                                                href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0 avatar-xs">
                                                        <div class="avatar-title bg-danger rounded-circle material-shadow">
                                                            <i class="bx bx-category-alt"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h6 class="fs-15 mb-0 fw-semibold">Order Placed - <span
                                                                class="fw-normal">{{ $order->created_at->format('D, d M Y') }}</span>
                                                        </h6>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div id="collapseOne" class="accordion-collapse collapse show"
                                            aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            @foreach ($order->history as $history)
                                                <div class="accordion-body ms-2 ps-5 pt-0">
                                                    <h6 class="mb-1">{{ $history->notes }}</h6>
                                                    <p class="text-muted">
                                                        {{ \Carbon\Carbon::parse($history->created_at)->format('D, d M Y - h:ia') }}
                                                    </p>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <!--end accordion-->
                            </div>
                        </div>
                    </div>
                    <!--end card-->
                </div>
                <div class="col-xl-3">
                    <!--end col-->

                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex">
                                <h5 class="card-title flex-grow-1 mb-0">Customer Details</h5>
                                <div class="flex-shrink-0">
                                    <a href="javascript:void(0);" class="link-secondary">View Profile</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0 vstack gap-3">
                                <li>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <img src="{{ $order->user->avatar ? URL($order->user->avatar) : URL('admin/assets/images/users/avatar-1.jpg') }}"
                                                alt="" class="avatar-sm rounded material-shadow">
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="fs-14 mb-1">
                                                {{ $order->user->name . ' ' . $order->user->last_name }}
                                            </h6>
                                            <p class="text-muted mb-0">Customer</p>
                                        </div>
                                    </div>
                                </li>
                                <li><i
                                        class="ri-mail-line me-2 align-middle text-muted fs-16"></i>{{ $order->user->email }}
                                </li>
                                @if ($order->user->phone)
                                    <li><i
                                            class="ri-phone-line me-2 align-middle text-muted fs-16"></i>{{ $order->user->phone }}
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>


                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i class="ri-secure-payment-line align-bottom me-1 text-muted"></i>
                                Payment
                                Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-shrink-0">
                                    <p class="text-muted mb-0">Transactions:</p>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <h6 class="mb-0">#{{ config('app.order_ref') }}000{{ $order->payment->id }}</h6>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-shrink-0">
                                    <p class="text-muted mb-0">Payment Method:</p>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <h6 class="mb-0">{{ ucfirst($order->payment->payment_gateway) }}</h6>
                                </div>
                            </div>
                            {{-- <div class="d-flex align-items-center mb-2">
                                <div class="flex-shrink-0">
                                    <p class="text-muted mb-0">Card Holder Name:</p>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <h6 class="mb-0">Joseph Parker</h6>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <div class="flex-shrink-0">
                                    <p class="text-muted mb-0">Card Number:</p>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <h6 class="mb-0">xxxx xxxx xxxx 2456</h6>
                                </div>
                            </div> --}}
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <p class="text-muted mb-0">Total Amount:</p>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <h6 class="mb-0">
                                        {{ $order->payment->currency }} {{ number_format($order->payment->amount, 2) }}
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end card-->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i class="ri-shield-flash-line align-bottom me-1 text-muted"></i>
                                Status</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.order.status', $order->id) }}" method="post">
                                @csrf
                                <div class="mb-2">
                                    <div class="flex-shrink-0">
                                        <select name="status" class="form-select mb-3">
                                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>
                                                Pending
                                            </option>
                                            <option value="processing"
                                                {{ $order->status === 'processing' ? 'selected' : '' }}>
                                                Processing</option>
                                            <option value="completed"
                                                {{ $order->status === 'completed' ? 'selected' : '' }}>
                                                Completed</option>
                                            <option value="failed" {{ $order->status === 'failed' ? 'selected' : '' }}>
                                                Failed
                                            </option>
                                            <option value="cancelled"
                                                {{ $order->status === 'cancelled' ? 'selected' : '' }}>
                                                Cancelled</option>
                                        </select>

                                    </div>
                                </div>
                                @if ($status != 'completed')
                                    <div class="d-flex align-items-center justify-content-end mb-2">
                                        <div class="flex-shrink-0">
                                            <button type="submit" class="btn btn-danger">Submit</button>
                                        </div>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                    <!--end card-->

                </div>

            </div>
            <!--end col-->
        </div>
        <!--end row-->

    </div><!-- container-fluid -->
@endsection
@section('scripts')
    <!--datatable js-->
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
                    error: function(xhr, error, code) {
                        console.error(xhr.responseText);
                    }
                },
                dom: "<'d-flex align-items-center justify-content-start'<'search-container me-1'><'dropdown-container ms-1 position-relative'>>" +
                    "<'row'<'col-md-12'tr>>" +
                    "<'row'<'col-md-5'i><'col-md-7'p>>",
                order: [],
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
                        searchable: false
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
