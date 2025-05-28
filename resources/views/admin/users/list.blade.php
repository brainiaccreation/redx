@extends('admin.master.layouts.app')
@section('page-title')
    Users
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
            Users
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
                                    <h4 class="card-title mb-0 flex-grow-1">Users Management</h4>
                                    <p class="text-muted mb-0">Manage users, wallets, and purchase limits</p>
                                </div>
                                <div class="p-0">
                                    {{-- @if (checkPermission('/members/equipment/create')) --}}
                                    {{-- <a href="{{ route('admin.category.add') }}" class="btn btn-danger"
                                        data-name="categoryAdd"><img src="{{ asset('admin/assets/images/svg/add.svg') }}"
                                            width="12" class="me-1"> Add Category</a> --}}
                                    {{-- @endif --}}
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered dt-responsive nowrap table-striped align-middle"
                                id="users-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>Wallet Balance</th>
                                        <th>Weekly Limit</th>
                                        <th>Weekly Spent</th>
                                        <th class="text-center">Account Type</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div><!--end col-->
            </div><!--end row-->
        </div>
    </div>
    {{-- add balanace modal --}}
    <div class="modal fade bs-example-modal-center" tabindex="-1" aria-labelledby="mySmallModalLabel" aria-modal="true"
        role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="gridModalLabel">Add Balance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="d-flex justify-items-center align-items-center">
                        <div class="user-name-avatar" id="modalUserAvatar">{{ usernameAvatar('Ahmed Hassan') }}</div>
                        <div class="ms-2">
                            <div class="font-medium text-gray-900" id="modalUserName">
                                Ahmed Hassan
                            </div>
                            <div class="text-sm text-gray-500" id="modalUserEmail">
                                ahmed@example.com
                            </div>

                        </div>
                    </div>
                    <div class="mt-3">
                        <label class="form-label mb-2">Current Balance</label>
                        <p class="text-2xl font-bold text-green-600" id="modalUserBalance">{{ config('app.currency') }}
                            15,000</p>
                    </div>
                    <div class="mt-2">
                        <label class="form-label mb-2">Amount to Add</label>
                        <input placeholder="Enter amount" class="form-control" type="number" step="0.1"
                            id="addBalanceAmount" required>
                    </div>
                    <div class="mt-2">
                        <label class="form-label mb-2">Reason</label>
                        <textarea name="reason" rows="3" style="resize: none" id="addBalanceReason" class="form-control"
                            placeholder="Enter reasoin for adding balance" required></textarea>
                    </div>
                    <input type="hidden" id="modalUserId">
                    <div class="d-flex justify-content-end algin-items-center mt-3">
                        <div class="px-2"><button class="btn btn-light" data-bs-dismiss="modal" aria-label="Close"
                                type="button">Cancel</button></div>
                        <div>
                            <button class="btn btn-danger add-balance-btn" type="button">Add Balance</button>
                        </div>
                    </div>
                </div>

            </div>
        </div><!-- /.modal-content -->
    </div>
    {{-- weekly limit balanace modal --}}
    <div class="modal fade weeklyLimitModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Set Weekly Purchase Limit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex align-items-center">
                        <div class="user-name-avatar" id="modalUserAvatar">AH</div>
                        <div class="ms-2">
                            <div class="font-medium text-gray-900" id="modalUserName">Ahmed Hassan</div>
                            <div class="text-sm text-gray-500" id="modalUserEmail">ahmed@example.com</div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <label class="form-label">Current Weekly Limit</label>
                        <h3 class="text-2xl font-bold text-blue-600" id="modalWeeklyLimit">Rs. 50,000</h3>
                    </div>

                    <div class="mt-2">
                        <label class="form-label">Weekly Spent</label>
                        <p class="text-lg font-semibold text-red-600" id="modalWeeklySpent">Rs. 0</p>
                        <div class="progress">
                            <div class="progress-bar bg-danger" id="progressBarSpent" role="progressbar"
                                style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <div class="mt-2">
                        <label class="form-label">New Weekly Limit</label>
                        <input placeholder="Enter new weekly limit" class="form-control" type="number" step="0.01"
                            id="addWeeklyLimit">
                    </div>

                    <input type="hidden" id="modalUserId">

                    <div class="d-flex justify-content-end mt-3">
                        <button class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-danger set-weekly-limit-btn" type="button">Update Limit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- transaction histories --}}
    <div class="modal fade transaactionHistoryModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Transaction History</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="transaction-loader" class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <div id="transaction-list" class="d-none" data-simplebar style="max-height: 400px;">
                        <ul class="list-group" id="transaction-items">
                        </ul>
                    </div>
                    <div class="d-flex justify-content-center mt-3 d-none" id="load-more-container">
                        <button class="btn btn-outline-danger btn-sm" id="load-more-transactions">Load More</button>
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

    <script src="{{ asset('admin/assets') }}/js/pages/datatables.init.js"></script>
    <script>
        $(document).ready(function() {

            var modal = new bootstrap.Modal(document.querySelector('.bs-example-modal-center'));

            $(document).on('click', '.open-balance-modal', function() {
                const userId = $(this).data('id');
                const name = $(this).data('name');
                const email = $(this).data('email');
                const balance = $(this).data('balance');
                let initials = name.trim().split(' ');
                let avatarText = '';

                if (initials.length > 1) {
                    avatarText = initials[0].charAt(0).toUpperCase() + initials[1].charAt(0).toUpperCase();
                } else {
                    avatarText = initials[0].charAt(0).toUpperCase();
                }
                $('#modalUserId').val(userId);
                $('#modalUserAvatar').html(avatarText);

                $('#modalUserName').text(name);
                $('#modalUserEmail').text(email);
                $('#modalUserBalance').text(balance);

            });
            // add wallet balance
            $(document).on('click', '.add-balance-btn', function(e) {
                e.preventDefault();
                const $btn = $(this);
                const amount = $('#addBalanceAmount').val();
                const reason = $('#addBalanceReason').val();
                const userId = $('#modalUserId').val();

                if (!amount || parseFloat(amount) <= 0) {
                    toastr.error('Amount is required and must be greater than 0.');
                    return;
                }

                if (!reason.trim()) {
                    toastr.error('Reason is required.');
                    return;
                }
                $btn.prop('disabled', true).text('Processing...');
                $.ajax({
                    url: "{{ route('admin.user.add_balance') }}",
                    method: 'POST',
                    data: {
                        '_token': "{{ csrf_token() }}",
                        amount,
                        reason,
                        'user_id': userId
                    },
                    success: function(res) {
                        toastr.success('Balance added successfully.');


                        $('#addBalanceAmount').val('');
                        $('#addBalanceReason').val('');
                        $('#modalUserId').val('');
                        $('.bs-example-modal-center').modal('hide');
                        const currency = '{{ config('app.currency') }}';
                        const formattedBalance =
                            `${currency} ${parseFloat(res.new_balance).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;

                        $(`#user-balance-${userId}`).html(
                            `<span class="text-success"><i class="ri-wallet-line"></i> ${formattedBalance}</span>`
                        );
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            const errors = xhr.responseJSON.errors;
                            for (let key in errors) {
                                toastr.error(errors[key][0]);
                            }
                        } else {
                            toastr.error('An error occurred. Please try again.');
                        }
                    },
                    complete: function() {
                        $btn.prop('disabled', false).text('Add Balance');
                    }
                });
            });

            // close modal
            $('.bs-example-modal-center').on('hidden.bs.modal', function() {
                $('#addBalanceAmount').val('');
                $('#addBalanceReason').val('');
                $('#modalUserId').val('');
            });
            // weekly limit modal
            let $currentBtn = null;

            $(document).on('click', '.weekly-balance-modal', function() {
                $currentBtn = $(this);
                const name = $currentBtn.data('name');
                const email = $currentBtn.data('email');
                const userId = $currentBtn.data('id');
                const limit = $currentBtn.data('limit') || 0;
                const spent = $currentBtn.data('spent') || 0;
                const currency = '{{ config('app.currency') }}';
                console.log("limit:- " + limit);
                console.log("spent:- " + spent);

                let initials = name.trim().split(' ');
                let avatarText = '';

                if (initials.length > 1) {
                    avatarText = initials[0].charAt(0).toUpperCase() + initials[1].charAt(0).toUpperCase();
                } else {
                    avatarText = initials[0].charAt(0).toUpperCase();
                }

                const percentage = limit > 0 ? Math.min(100, (spent / limit) * 100).toFixed(2) : 0;

                $('#modalUserName').text(name);
                $('#modalUserEmail').text(email);
                $('#modalUserAvatar').text(avatarText);
                $('#modalWeeklyLimit').text(`${currency} ${limit.toLocaleString()}`);
                $('#modalWeeklySpent').text(`${currency} ${spent.toLocaleString()}`);

                $('#progressBarSpent')
                    .css('width', `${percentage}%`)
                    .attr('aria-valuenow', percentage)
                    .text(`${percentage}%`);

                $('#modalUserId').val(userId);
            });


            // update weekly limit
            $(document).on('click', '.set-weekly-limit-btn', function() {
                const $btn = $(this);
                const userId = $('#modalUserId').val();
                const newLimit = $('#addWeeklyLimit').val();
                const currency = '{{ config('app.currency') }}';

                if (!newLimit) {
                    toastr.error('Weekly limit is required.');
                    return;
                }

                $btn.prop('disabled', true).text('Processing...');

                $.ajax({
                    url: '{{ route('user.updateWeeklyLimit') }}',
                    type: 'POST',
                    data: {
                        user_id: userId,
                        weekly_limit: newLimit,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            const limit = parseFloat(response.weekly_limit);
                            const spent = parseFloat(response
                                .weekly_spent);
                            const percentage = limit > 0 ? Math.min(100, (spent / limit) * 100)
                                .toFixed(2) : 0;

                            $('#modalWeeklyLimit').text(currency + ' ' + limit
                                .toLocaleString());
                            $('#modalWeeklySpent').text(currency + ' ' + spent
                                .toLocaleString());
                            $('#progressBarSpent').css('width', `${percentage}%`).attr(
                                'aria-valuenow', percentage);

                            $(`#weekly-limit-${response.user_id}`).html(
                                `<i class="ri-wallet-line"></i> ${currency} ${limit.toFixed(2)}`
                            );


                            const $triggerBtn = $(
                                `.weekly-balance-modal[data-id='${response.user_id}']`);
                            $triggerBtn.attr('data-limit', limit.toFixed(2));
                            $triggerBtn.attr('data-spent', spent.toFixed(2));
                            $('#users-table').DataTable().ajax.reload(null, false);

                            $('.weeklyLimitModal').modal('hide');
                            toastr.success('Weekly limit updated successfully.');
                        }

                        $btn.prop('disabled', false).text('Update Limit');
                    },
                    error: function() {
                        toastr.error('Something went wrong.');
                        $btn.prop('disabled', false).text('Update Limit');
                    }
                });
            });

            // Reset modal on hide
            $('.weeklyLimitModal').on('hidden.bs.modal', function() {
                $('#addWeeklyLimit').val('');
                $('#modalUserName').text('');
                $('#modalUserEmail').text('');
                $('#modalUserAvatar').text('');
                $('#modalWeeklyLimit').text('');
                $('#modalWeeklySpent').text('');
                $('#progressBarSpent').css('width', '0%').attr('aria-valuenow', 0).text('0%');
            });

            // transaction history
            let currentPage = 1;
            let currentUserId = null;

            $(document).on('click', '.view-transactions', function() {
                currentUserId = $(this).data('user-id');
                currentPage = 1;

                $('#transaction-list').addClass('d-none');
                $('#transaction-items').empty();
                $('#transaction-loader').removeClass('d-none');
                $('#load-more-container').addClass('d-none');

                fetchTransactions(currentUserId, currentPage);
            });

            $('#load-more-transactions').on('click', function() {
                currentPage++;
                fetchTransactions(currentUserId, currentPage);
            });

            function fetchTransactions(userId, page = 1) {
                $.ajax({
                    url: "{{ route('admin.user.transactions') }}",
                    type: 'GET',
                    data: {
                        user_id: userId,
                        page: page
                    },
                    success: function(response) {
                        $('#transaction-loader').addClass('d-none');
                        $('#transaction-list').removeClass('d-none');

                        if (response.data.length === 0 && page === 1) {
                            $('#transaction-items').append(
                                '<li class="list-group-item text-center text-muted">No transactions found.</li>'
                            );
                            return;
                        }

                        response.data.forEach(tx => {
                            let iconClass = tx.type === 'credit' ?
                                'bg-success-subtle text-success' :
                                'bg-danger-subtle text-danger';
                            let amountClass = tx.type === 'credit' ? 'text-success' :
                                'text-danger';
                            let sign = tx.type === 'credit' ? '+' : '-';

                            let iconSvg = `
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" 
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" 
                                stroke-linecap="round" stroke-linejoin="round" 
                                class="lucide lucide-trending-up">
                                <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline>
                                <polyline points="16 7 22 7 22 13"></polyline>
                            </svg>`;

                            // Status badge class
                            let statusClass = '';
                            switch (tx.status) {
                                case 'pending':
                                    statusClass = 'bg-warning-subtle text-warning';
                                    break;
                                case 'approved':
                                    statusClass = 'bg-success-subtle text-success';
                                    break;
                                case 'rejected':
                                    statusClass = 'bg-secondary-subtle text-secondary';
                                    break;
                                default:
                                    statusClass = 'bg-info-subtle text-info';
                            }
                            let statusText = tx.status ? tx.status.charAt(0).toUpperCase() + tx
                                .status.slice(1) : 'Unknown';

                            $('#transaction-items').append(`
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 avatar-xs">
                                                    <div class="avatar-title ${iconClass} rounded">
                                                        ${iconSvg}
                                                    </div>
                                                </div>
                                                <div class="flex-shrink-0 ms-2">
                                                    <h6 class="fs-14 mb-0">${tx.description}</h6>
                                                    <small class="text-muted d-block">${tx.date}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <span class="${amountClass}">${sign}${tx.amount}</span>
                                             <h6 class="mt-1"><span class="badge ${statusClass}">${tx.status?.charAt(0).toUpperCase() + tx.status?.slice(1) || 'Unknown'}</span></h6>
                                        </div>
                                    </div>
                                </li>
                            `);
                        });


                        if (response.has_more) {
                            $('#load-more-container').removeClass('d-none');
                        } else {
                            $('#load-more-container').addClass('d-none');
                        }
                    },
                    error: function() {
                        $('#transaction-loader').html(
                            '<div class="text-danger">Failed to load transactions.</div>');
                    }
                });
            }


        });
    </script>
    <script>
        $(document).ready(function() {
            var table = $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                ajax: {
                    url: "{{ route('admin.users.get') }}",
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
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'user_info',
                        name: 'user_info'
                    },
                    {
                        data: 'wallet_balance',
                        name: 'wallet_balance'
                    },
                    {
                        data: 'weekly_limit',
                        name: 'weekly_limit'
                    },
                    {
                        data: 'weekly_spent',
                        name: 'weekly_spent',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'account_type',
                        name: 'account_type'
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
            // change suspended status
            $(document).on('click', '.changeStatus', function(e) {
                e.preventDefault();

                let button = $(this);
                let userId = button.data('id'); // get user ID from data attribute
                let currentStatus = parseInt(button.data('suspended'));

                $.ajax({
                    url: "{{ route('admin.user.toggle_suspend') }}",
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: userId,
                        is_suspended: currentStatus
                    },
                    success: function(response) {
                        let newStatus = response.is_suspended;
                        let iconClass = newStatus == 1 ? 'ri-check-fill' : 'ri-forbid-line';
                        let buttonText = newStatus == 1 ? 'Unsuspend' : 'Suspend';
                        let titleText = newStatus == 1 ? 'Unsuspend User' : 'Suspend User';

                        button.find('i')
                            .removeClass('ri-check-fill ri-forbid-line')
                            .addClass(iconClass);

                        button.contents().filter(function() {
                            return this.nodeType === 3;
                        }).remove();
                        button.append(' ' + buttonText);

                        button
                            .data('suspended', newStatus)
                            .attr('title', titleText);

                        // if (typeof bootstrap !== 'undefined') {
                        //     var tooltip = bootstrap.Tooltip.getInstance(button[0]);
                        //     if (tooltip) tooltip.dispose();
                        //     new bootstrap.Tooltip(button[0]);
                        // }

                        if (typeof toastr !== 'undefined') {
                            toastr.success(
                                `User has been ${newStatus == 1 ? 'suspended' : 'unsuspended'} successfully.`
                            );
                        }
                    },
                    error: function() {
                        alert('Something went wrong.');
                    }
                });
            });

        });
    </script>
@endsection
