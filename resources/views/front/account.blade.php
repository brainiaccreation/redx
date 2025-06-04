@extends('front.layouts.app')
@section('title')
    My Account
@endsection
@section('head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endsection
@section('content')
    <!-- My-account-Section Start -->
    <section class="my-account-section section-padding fix">
        <div class="container">
            <div class="my-account-wrapper">
                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="wrap-sidebar-account">
                            <div class="sidebar-account">
                                <div class="account-avatar">
                                    <div class="image">
                                        <img src="{{ auth()->user()->avatar ? URL(auth()->user()->avatar) : URL('front/assets//img/avater.jpg') }}"
                                            alt="{{ auth()->user()->name }} {{ auth()->user()->last_name }}">
                                    </div>
                                    <h6 class="mb_4">{{ auth()->user()->name }} {{ auth()->user()->last_name }}</h6>
                                    <div class="body-text-1">{{ auth()->user()->email }}</div>
                                </div>
                                <ul class="nav">
                                    <li class="nav-item">
                                        <a href="#Account" data-bs-toggle="tab" class="nav-link active">
                                            <i class="fa-regular fa-user"></i>
                                            Account Details
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#order" data-bs-toggle="tab" class="nav-link">
                                            <i class="fa-sharp fa-regular fa-bag-shopping"></i>
                                            Your Orders
                                        </a>
                                    </li>
                                    {{-- <li class="nav-item">
                                        <a href="#wallet" data-bs-toggle="tab" class="nav-link">
                                            <i class="fa-sharp fa-regular fa-bag-shopping"></i>
                                            My Wallet
                                        </a>
                                    </li> --}}
                                    <li class="nav-item">
                                        <a href="#wallet" data-bs-toggle="tab" class="nav-link">
                                            <i class="fa-solid fa-wallet"></i>
                                            My Wallet &nbsp; &nbsp;
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="javascript:void();" class="nav-link"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fa-regular fa-share-from-square"></i>
                                            Logout
                                        </a>



                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="tab-content">
                            <div id="Account" class="tab-pane fade show active">
                                <div class="account-details">
                                    {{-- <form action="#" id="contact-form2" method="POST"> --}}
                                    <div class="account-info">
                                        <h3>Information</h3>
                                        <form action="{{ route('user.updateProfile', auth()->user()->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row g-4">
                                                <div class="col-lg-12">
                                                    <div class="form-clt">
                                                        <input type="file" name="avatar" id="avatar"
                                                            class="@error('avatar') is-invalid @enderror">
                                                    </div>
                                                    @if (auth()->user()->avatar)
                                                        <div class="mt-2">
                                                            <a href="{{ asset(auth()->user()->avatar) }}"
                                                                class="text-danger" target="_blank">Uploaded
                                                                Avatar <i class="fa fa-external-link"
                                                                    aria-hidden="true"></i></a>
                                                        </div>
                                                    @endif
                                                    @error('avatar')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-clt">
                                                        <input type="text" name="name" id="name"
                                                            placeholder="First Name"
                                                            value="{{ old('name', auth()->user()->name) }}"
                                                            class="@error('name') is-invalid @enderror">
                                                    </div>
                                                    @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-clt">
                                                        <input type="text" name="last_name" id="name2"
                                                            placeholder="Last Name"
                                                            value="{{ old('last_name', auth()->user()->last_name) }}"
                                                            class="@error('last_name') is-invalid @enderror">
                                                    </div>
                                                    @error('last_name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-clt">
                                                        <input type="email" name="email" id="email"
                                                            placeholder="Email"value="{{ old('email', auth()->user()->email) }}"
                                                            class="@error('email') is-invalid @enderror">
                                                    </div>
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-clt">
                                                        <input type="text" name="phone" id="number"
                                                            placeholder="Phone No"
                                                            value="{{ old('phone', auth()->user()->phone) }}"
                                                            class="@error('phone') is-invalid @enderror">
                                                    </div>
                                                    @error('phone')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-clt">
                                                        <div class="form">
                                                            <input type="text" name="towncity" placeholder="City"
                                                                value="{{ old('towncity', auth()->user()->towncity) }}"
                                                                class="@error('towncity') is-invalid @enderror">
                                                        </div>
                                                    </div>
                                                    @error('towncity')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-clt">
                                                        <div class="form">
                                                            <input type="text" name="country" placeholder="Country"
                                                                value="{{ old('country', auth()->user()->country) }}"
                                                                class="@error('country') is-invalid @enderror">
                                                        </div>
                                                    </div>
                                                    @error('country')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="form-clt">
                                                        <div class="form">
                                                            <textarea name="address" rows="4" class="form-control" style="resize:none" placeholder="Address Line 1">{{ old('address', auth()->user()->address) }}</textarea>
                                                        </div>
                                                    </div>
                                                    @error('address')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-clt">
                                                        <div class="form">
                                                            <textarea name="address2" rows="4" class="form-control" style="resize:none" placeholder="Address Line 2">{{ old('address2', auth()->user()->address2) }}
                                                           </textarea>
                                                        </div>
                                                    </div>
                                                    @error('address2')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="text-end">
                                                        <button type="submit" class="custom-rdxbtnr">Update</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="account-password">
                                        <div class="account-info">
                                            <h3>Change Password</h3>
                                            <form action="{{ route('change.password') }}" method="POST">
                                                @csrf
                                                <div class="row g-4">
                                                    <div class="col-lg-12">
                                                        <div class="form-clt">
                                                            <input id="password2" type="password" name="old_password"
                                                                placeholder="Password"
                                                                class="@error('old_password') is-invalid @enderror"
                                                                required>
                                                            <div class="icon toggle-password" data-target="#password2">
                                                                <i class="far fa-eye-slash"></i>
                                                            </div>
                                                        </div>
                                                        @error('old_password')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-clt">
                                                            <input id="password3" name="new_password" type="password"
                                                                placeholder="Create Password"
                                                                class="@error('new_password') is-invalid @enderror"
                                                                required>
                                                            <div class="icon toggle-password" data-target="#password3">
                                                                <i class="far fa-eye-slash"></i>
                                                            </div>
                                                        </div>
                                                        @error('new_password')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-lg-12">
                                                        <div class="form-clt">
                                                            <input id="password4" type="password"
                                                                placeholder="Confirm Password"
                                                                name="new_password_confirmation"
                                                                class="@error('new_password_confirmation') is-invalid @enderror"
                                                                required>
                                                            <div class="icon toggle-password" data-target="#password4">
                                                                <i class="far fa-eye-slash"></i>
                                                            </div>
                                                        </div>
                                                        @error('new_password_confirmation')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-lg-12">
                                                        <div class="text-end">
                                                            <button type="submit" class="custom-rdxbtnr">Update</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    {{-- </form> --}}
                                </div>
                            </div>
                            <div id="order" class="tab-pane fade">
                                <div class="transaction-history">
                                    <h3>Orders</h3>
                                    <div class="table-responsive">
                                        <table class="table transaction-table" id="orderTable" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Order ID</th>
                                                    <th class="text-center">Payment Method</th>
                                                    <th class="text-center">Amount</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center">Refund Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            {{-- <tbody>
                                                @foreach ($orders as $order)
                                                    <tr class="align-items-center py-3">
                                                        <td>
                                                            <div class="cart-item-thumb d-flex align-items-center gap-4">
                                                                <i class="fas fa-times"></i> --}}
                                            {{-- <img class="w-100"
                                                                    src="{{ asset('front/assets') }}/img/cart/03.jpg"
                                                                    alt="product">
                                            <a href="{{ route('user.order.details', $order->unique_id) }}"
                                                style="color: #011e5e;"><span
                                                    class="text-nowrap">#{{ $order->order_number }}</span></a>
                                    </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="price-usd">
                                            {{ ucfirst($order->payment_method) }}
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <span class="price-usd">
                                            {{ number_format($order->total_amount, 2) }}
                                            {{ config('app.currency') }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="price-usd">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    </tr>
                                    @endforeach
                                    </tbody> --}}
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div id="wallet" class="tab-pane fade">
                                <div class="axil-dashboard-address">
                                    {{-- <p class="notice-text">The following addresses will be used on the checkout page by
                                        default.</p> --}}
                                    <div class="row g-4">
                                        <div class="col-lg-12">
                                            <div class="wallet-container">
                                                <div class="wallet-header">
                                                    <h2>My Wallet</h2>
                                                    <button class="top-up-btn" data-bs-toggle="modal"
                                                        data-bs-target="#topUpModal">TOP UP</button>
                                                </div>
                                                <div class="balance-section">
                                                    <h3>{{ config('app.currency') }}
                                                        {{ number_format(auth()->user()->wallet_balance, 2) }}</h3>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="">
                                                        <h6>Weekly Limit</h6>
                                                        <div class="balance-section">
                                                            <h5 class="text-primary">{{ config('app.currency') }}
                                                                {{ number_format(auth()->user()->weekly_limit, 2) }}</h5>
                                                        </div>
                                                    </div>
                                                    <div class="">
                                                        <h6>Weekly Spent</h6>
                                                        <div class="balance-section">
                                                            <h5 class="text-success">{{ config('app.currency') }}
                                                                {{ number_format(getWeeklySpent(auth()->user()->id), 2) }}
                                                            </h5>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="account-status">
                                                    <p>Account Status: {{ ucfirst(auth()->user()->account_type) }}</p>
                                                    <p>Top up over RM 10,000 to automatically become a Reseller with 1%
                                                        discount</p>
                                                </div>
                                                <div class="transaction-history">
                                                    <h3>Transaction History</h3>
                                                    <div class="table-responsive">

                                                        <table class="table transaction-table" id="walletTable"
                                                            style="width: 100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>Transaction</th>
                                                                    <th>Amount</th>
                                                                    <th>Date</th>
                                                                    <th>Status</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div id="Reviews" class="tab-pane fade">
                                <div class="account-wrapper">
                                    <div class="account-box">
                                        <h3 class="mb-3">Login to Sofia.</h3>
                                        <h6>Don’t have an account? <span>Create a free account</span></h6>
                                        <p class="mt-4">or Sign in with Email</p>
                                        <div class="contact-form-item">
                                            <form action="#" id="contact-form3" method="POST">
                                                <div class="row g-4">
                                                    <div class="col-lg-12">
                                                        <div class="form-clt">
                                                            <input type="text" name="email" id="email20"
                                                                placeholder="Your Email">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-clt">
                                                            <input type="text" name="subject" id="email21"
                                                                placeholder="Password">
                                                            <div class="icon">
                                                                <i class="fa-regular fa-eye"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="from-cheak-items">
                                                            <div class="form-check d-flex gap-2 from-customradio">
                                                                <input class="form-check-input" type="radio"
                                                                    name="flexRadioDefault" id="flexRadioDefault2">
                                                                <label class="form-check-label" for="flexRadioDefault1">
                                                                    Remember Me
                                                                </label>
                                                            </div>
                                                            <span>Forgot Password?</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <button type="submit" class="theme-btn header-btn w-100">
                                                            Login
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    {{-- model --}}
                    <div class="modal fade" id="topUpModal" tabindex="-1" aria-labelledby="topUpModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="topUpModalLabel">Top Up Your Wallet</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form id="walletForm" action="{{ route('wallet.topup') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="modal-body">
                                        <label>Enter amount to add to your wallet (in RM):</label>
                                        <input type="number" class="form-control" value="500.00" id="wallet_amount"
                                            name="amount" step="0.1">

                                        <label>Select payment method:</label>
                                        <div class="payment-methods selected">
                                            <div class="payment-option" data-method="bank">
                                                <input type="radio" name="payment_method" value="bank" checked>
                                                <label>ONLINE BANKING</label>
                                                <p>Direct bank transfer</p>
                                            </div>
                                            <div class="payment-option" data-method="stripe">
                                                <input type="radio" name="payment_method" value="stripe">
                                                <label>Stripe</label>
                                                <p>Visa, Mastercard, etc.</p>
                                            </div>

                                            <div class="payment-option" data-method="paydibs    ">
                                                <input type="radio" name="payment_method" value="paydibs    ">
                                                <label>Paydibs</label>
                                                <p>Visa, Mastercard, et
                                            </div>
                                        </div>

                                        <div id="payment-details">
                                            <div class="method-details" id="method-card" style="display: none;">
                                                {{-- <p>Enter your card info here.</p> --}}
                                            </div>
                                            <div class="method-details" id="method-bank" style="display: block;">
                                                <p><b>Bank Name:</b> Maybank</p>
                                                <p><b>Title of Account:</b> Test Bank</p>
                                                <p><b>Account No:</b> 00000020023456789</p>
                                                <p><b>IBAN:</b> MB00 0000 1111 2222 3333</p>
                                                <p>Upload receipt</p>
                                                <div class="mb-2">
                                                    <input type="file" name="receipt_image" class="form-control"
                                                        id="receipt_image" accept=".jpg, .jpeg, .png">
                                                </div>
                                            </div>
                                            <div class="method-details" id="method-ewallet" style="display: none;">
                                                {{-- <p>Select your preferred e-wallet to proceed.</p> --}}
                                            </div>
                                        </div>

                                        <button type="submit" class="btn-confirm">CONFIRM PAYMENT</button>
                                    </div>
                                </form>


                            </div>
                        </div>
                    </div>
                    {{-- model end --}}
                    {{-- refund modal --}}
                    <div class="modal fade" id="refundModal" tabindex="-1" aria-labelledby="topUpModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="refundModalLabel">Request Refund</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form id="requestRefundForm">
                                    @csrf
                                    <div class="modal-body">
                                        <div id="payment-details">
                                            <div class="method-details" id="method-bank" style="display: block;">
                                                <p id="refundManageOrderId"><b>Order ID:</b></p>
                                                <p id="refundManageAmount"><b>Amount:</b></p>
                                            </div>
                                        </div>
                                        <div id="form-group" class="mb-4">
                                            <label class="form-label">Select Refund Method:</label>
                                            <select id="adminRefundMethodSelect" class="form-control">
                                                <option value="Wallet">Wallet</option>
                                                <option value="Stripe">Stripe</option>
                                                <option value="Paydibs">Paydibs</option>
                                            </select>
                                        </div>
                                        <input type="hidden" id="modalUserId">
                                        <input type="hidden" id="modalOrderId">
                                        <button type="submit" id="submitRefundRequest"
                                            class="btn-confirm">Submit</button>
                                    </div>
                                </form>


                            </div>
                        </div>
                    </div>
                    {{-- refund modal end --}}
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).on('click', '.toggle-password', function() {
            const targetInput = $($(this).data('target'));
            const icon = $(this).find('i');

            if (targetInput.attr('type') === 'password') {
                targetInput.attr('type', 'text');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            } else {
                targetInput.attr('type', 'password');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            }
        });
    </script>
    <script>
        $(document).on('click', '.open-refund-modal', function() {
            const orderId = $(this).data('order-id');
            const id = $(this).data('id');

            const customer = $(this).data('customer');
            const amount = $(this).data('amount');
            const status = $(this).data('status');
            const refundStatus = $(this).data('refund-status');
            const userId = $(this).data('user-id');
            const currency = '{{ config('app.currency') }}';
            $('#refundManageOrderId').html('<b>Order ID: </b>' + orderId);
            $('#refundManageAmount').html('<b>Amount: </b>' + amount + ' ' +
                currency);

            $('#modalUserId').val(userId);
            $('#modalOrderId').val(id);

        });
        $('#requestRefundForm').on('submit', function(e) {
            e.preventDefault();

            const refundMethod = $('#adminRefundMethodSelect').val();
            const userId = $('#modalUserId').val();
            const orderId = $('#modalOrderId').val();

            const $btn = $('#submitRefundRequest');
            $btn.prop('disabled', true).text('Processing...');

            $.ajax({
                url: "{{ route('refund.request.store') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    user_id: userId,
                    order_id: orderId,
                    refund_method: refundMethod
                },
                success: function(res) {
                    toastr.success(res.message);
                    $('#refundModal').modal('hide');
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON.error);
                },
                complete: function() {
                    $btn.prop('disabled', false).text('Submit');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#walletTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('wallet.transactions.data') }}",
                order: [
                    [2, 'desc']
                ],
                columns: [{
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'created_at_formatted',
                        name: 'created_at'
                    },
                    {
                        data: 'status_badge',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
            $('#orderTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('order.get.data') }}",
                order: [],
                columns: [{
                        data: 'order_number',
                        name: 'order_number'
                    },
                    {
                        data: 'payment_method',
                        name: 'payment_method'
                    },
                    {
                        data: 'total_amount',
                        name: 'total_amount'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'refund_status',
                        name: 'refund_status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
    </script>
    <script>
        document.querySelectorAll('.payment-option').forEach(option => {
            option.addEventListener('click', () => {
                document.querySelectorAll('.payment-option').forEach(opt => opt.classList.remove(
                    'selected'));

                option.classList.add('selected');
                option.querySelector('input[type="radio"]').checked = true;

                const method = option.getAttribute('data-method');

                document.querySelectorAll('.method-details').forEach(div => {
                    div.style.display = 'none';
                });

                document.getElementById('method-' + method).style.display = 'block';
            });
        });

        $(document).ready(function() {
            $('#receipt_image').on('change', function() {
                const file = this.files[0];

                if (file) {
                    const fileType = file.type;
                    const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];

                    if (!validTypes.includes(fileType)) {
                        toastr.error('Invalid file type. Only JPG, JPEG, and PNG are allowed.');
                        $(this).val('');
                    }
                }
            });
            $('#walletForm').on('submit', function(e) {
                let amount = parseFloat($('#wallet_amount').val());
                let method = $('input[name="payment_method"]:checked').val();
                let receipt = $('#receipt_image')[0]?.files[0];

                if (isNaN(amount) || amount < 20) {
                    e.preventDefault();
                    toastr.error('Minimum top-up amount is RM 20.');
                    return;
                }

                if (method === 'bank') {
                    if (!receipt) {
                        e.preventDefault();
                        toastr.error('Please upload your bank transfer receipt.');
                        return;
                    }

                    const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                    if (!validTypes.includes(receipt.type)) {
                        e.preventDefault();
                        toastr.error('Invalid file type. Only JPG, JPEG, PNG are allowed.');
                        $('#receipt_image').val('');
                        return;
                    }
                }

            });
        });
    </script>
@endsection
