@extends('admin.master.layouts.app')
@section('page-title')
    Footer Management
@endsection
@section('page-content')
    <div class="page-content">
        <div class="container-fluid">


            <div class="card mb-4">
                <div class="card-header">
                    <h1 class="card-title">Footer Management</h1>
                </div>
                <div class="card-body">
                    <h2 class="card-title mb-3">Add New Section or Link</h2>
                    <form id="footerForm" class="row g-3">
                        <input type="hidden" id="footerId" name="footer_id">
                        <div class="col-12">
                            <label for="section" class="form-label">Section Name</label>
                            <select id="section" name="section" class="form-select" required>
                                <option value="">Select Section</option>
                                @foreach ($footers as $sectionName => $links)
                                    <option value="{{ $sectionName }}">{{ $sectionName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="link_text" class="form-label">Link Text (Optional)</label>
                            <input type="text" id="link_text" name="link_text" class="form-control">
                        </div>
                        <div class="col-6">
                            <label for="link_url" class="form-label">Link URL (Optional)</label>
                            <input type="text" id="link_url" name="link_url" class="form-control">
                        </div>
                        <div class="col-12">
                            <button type="submit" id="submitBtn" class="btn btn-danger">Add Item</button>
                            <button type="button" id="cancelEdit"
                                class="btn btn-light waves-effect ms-2 d-none">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sections and Links Table -->
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title mb-3">Manage Footer Sections and Links</h2>
                    <div id="footerSections">
                        @foreach ($footers as $sectionName => $links)
                            <div class="mb-4">
                                <h3 class="h5 mb-2">{{ $sectionName }}</h3>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 40%;">Link Text</th>
                                            <th style="width: 40%;">Link URL</th>
                                            <th style="width: 20%;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($links as $link)
                                            <tr data-id="{{ $link->id }}" data-section="{{ $sectionName }}">
                                                <td style="width: 40%;">{{ $link->link_text ?? '-' }}</td>
                                                <td style="width: 40%;">{{ $link->link_url ?? '-' }}</td>
                                                <td style="width: 20%;">
                                                    <button class="editBtn action_btn edit-item me-2"><i
                                                            class="ri-edit-line"></i></button>
                                                    <button class="deleteBtn action_btn delete-item"><i
                                                            class="bx bx-trash"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Handle form submission
            $('#footerForm').on('submit', function(e) {
                e.preventDefault();
                const footerId = $('#footerId').val();
                const section = $('#section').val();
                const data = {
                    section: section,
                    link_text: $('#link_text').val(),
                    link_url: $('#link_url').val()
                };

                const url = footerId ?
                    '{{ route('admin.footer.update', ':id') }}'.replace(':id', footerId) :
                    '{{ route('admin.footer.store') }}';
                const method = footerId ? 'PUT' : 'POST';

                $.ajax({
                    url: url,
                    method: method,
                    data: data,
                    success: function(response) {
                        toastr.success(response.message);
                        location.reload();
                    },
                    error: function(xhr) {
                        toastr.error('Error: ' + xhr.responseJSON.message);
                    }
                });
            });

            // Handle Edit button click
            $(document).on('click', '.editBtn', function() {
                const row = $(this).closest('tr');
                const id = row.data('id');
                const section = row.data('section');
                const linkText = row.find('td:eq(0)').text() === '-' ? '' : row.find('td:eq(0)').text();
                const linkUrl = row.find('td:eq(1)').text() === '-' ? '' : row.find('td:eq(1)').text();

                $('#footerId').val(id);
                $('#section').val(section);
                $('#link_text').val(linkText);
                $('#link_url').val(linkUrl);
                $('#submitBtn').text('Update Item');
                $('#cancelEdit').removeClass('d-none');

                // Scroll to form and focus
                $('html, body').animate({
                    scrollTop: $('#footerForm').offset().top - 100
                }, 10, function() {
                    $('#link_text').focus();
                });
            });

            // Handle Cancel button click
            $('#cancelEdit').on('click', function() {
                $('#footerForm')[0].reset();
                $('#footerId').val('');
                $('#submitBtn').text('Add Item');
                $(this).addClass('d-none');
            });

            // Handle Delete button click
            $(document).on('click', '.deleteBtn', function() {
                if (confirm('Are you sure you want to delete this item?')) {
                    const row = $(this).closest('tr');
                    const id = row.data('id');

                    $.ajax({
                        url: '{{ route('admin.footer.destroy', ':id') }}'.replace(':id', id),
                        method: 'DELETE',
                        success: function(response) {
                            toastr.success(response.message);
                            row.remove();
                        },
                        error: function(xhr) {
                            toastr.error('Error: ' + xhr.responseJSON.message);
                        }
                    });
                }
            });
        });
    </script>
@endsection
