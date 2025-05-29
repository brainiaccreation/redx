@extends('admin.master.layouts.app')
@section('page-title')
    Home Sliders
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
            Home Sliders
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
                                    <h4 class="card-title mb-0 flex-grow-1">Home Sliders</h4>
                                </div>
                                <div class="p-0">
                                    @hasRoutePermission('admin.home_slider.add')
                                        <a href="javascript:void(0)" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#addSlideModal">
                                            <img src="{{ asset('admin/assets/images/svg/add.svg') }}" width="12"
                                                class="me-1"> Add Slide
                                        </a>
                                    @endhasRoutePermission
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered dt-responsive nowrap table-striped align-middle"
                                id="home-slider-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Heading</th>
                                        <th>Background Image</th>
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
    {{-- add modal --}}
    <!-- Add Slide Modal -->
    <div class="modal fade" id="addSlideModal" tabindex="-1" aria-labelledby="addSlideModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST" action="{{ route('admin.home_slider.store') }}" enctype="multipart/form-data"
                class="modal-content needs-validation" novalidate id="addSlideForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addSlideModalLabel">Add New Slide</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="modalCloseBtn"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="heading" class="form-label">Heading</label>
                        <input type="text" class="form-control" name="heading" id="heading" maxlength="100" required>
                        <div class="invalid-feedback d-none">Heading is required (max 100 characters).</div>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <input type="text" class="form-control" name="content" id="content" maxlength="100" required>
                        <div class="invalid-feedback d-none">Content is required (max 200 characters).</div>
                    </div>
                    <div class="mb-3">
                        <label for="background_image" class="form-label">Background Image</label>
                        <input type="file" class="form-control" name="background_image" id="background_image"
                            accept=".webp,.jpg,.jpeg,.png" required>
                        <div class="invalid-feedback d-none">Please upload a valid image (jpg, jpeg, png, webp) under 2MB.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex justify-content-end algin-items-center mt-3">
                        <div class="px-2"><button class="btn btn-light" data-bs-dismiss="modal" aria-label="Close"
                                type="button">Cancel</button></div>
                        <div>
                            <button class="btn btn-danger createSlide" type="submit">Create</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- edit modal --}}

    <!-- Edit Slide Modal -->
    <div class="modal fade" id="editSlideModal" tabindex="-1" aria-labelledby="editSlideModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form id="editSlideForm" method="POST" enctype="multipart/form-data" class="modal-content">
                @csrf
                @method('PUT')
                <input type="hidden" name="slide_id" id="edit_slide_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSlideModalLabel">Edit Slide</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="editModalClose"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Heading</label>
                        <input type="text" name="heading" id="edit_heading" class="form-control" maxlength="100">
                        <div class="invalid-feedback d-none">Heading is required and must be under 100 characters.</div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_content" class="form-label">Content</label>
                        <input type="text" class="form-control" name="content" id="edit_content" maxlength="100"
                            required>
                        <div class="invalid-feedback d-none">Content is required and must be under 200 characters.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Change Background Image (optional)</label>
                        <input type="file" name="background_image" id="edit_background_image" class="form-control"
                            accept=".webp,.jpg,.jpeg,.png">
                        <div class="invalid-feedback d-none">Valid image (jpg, jpeg, png, webp) under 2MB required.</div>
                        <div class="mt-2">
                            <a href="javascript:void(0);" class="text-danger" target="_blank"
                                id="edit_preview_image">Uploaded
                                Avatar <i class="ri-external-link-line" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex justify-content-end algin-items-center mt-3">
                        <div class="px-2"><button class="btn btn-light" data-bs-dismiss="modal" aria-label="Close"
                                type="button">Cancel</button></div>
                        <div>
                            <button class="btn btn-danger updateSlide" type="submit">Update</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- image preview modal --}}
    <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Background Image Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="" id="previewImageTag" class="img-fluid" alt="Slide Image">
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
        $(function() {
            $('#addSlideForm').on('submit', function(e) {
                const $btn = $('.createSlide');
                let isValid = true;

                let heading = $('#heading');
                let content = $('#content');
                let imageInput = $('#background_image');
                let image = imageInput[0].files[0];

                // Reset previous errors
                heading.removeClass('is-invalid');
                heading.next('.invalid-feedback').hide();

                content.removeClass('is-invalid');
                content.next('.invalid-feedback').hide();

                imageInput.removeClass('is-invalid');
                imageInput.next('.invalid-feedback').hide();

                // Heading validation
                if (!heading.val().trim() || heading.val().length > 100) {
                    heading.addClass('is-invalid');
                    heading.next('.invalid-feedback').show();
                    isValid = false;
                }
                // Content validation
                if (!content.val().trim() || content.val().length > 100) {
                    content.addClass('is-invalid');
                    content.next('.invalid-feedback').show();
                    isValid = false;
                }

                // Image validation
                if (!image) {
                    imageInput.addClass('is-invalid');
                    imageInput.next('.invalid-feedback').text("Image is required.").show();
                    isValid = false;
                } else {
                    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
                    if (!allowedTypes.includes(image.type)) {
                        imageInput.addClass('is-invalid');
                        imageInput.next('.invalid-feedback').text("Only JPG, PNG, WEBP images allowed.")
                            .show();
                        isValid = false;
                    } else if (image.size > 2 * 1024 * 1024) {
                        imageInput.addClass('is-invalid');
                        imageInput.next('.invalid-feedback').text("Image must be under 2MB.").show();
                        isValid = false;
                    }
                }

                if (!isValid) {
                    e.preventDefault();
                    return false;
                }
                $btn.prop('disabled', true).text('Processing...');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                e.preventDefault();
                let formData = new FormData(this);
                $.ajax({
                    url: "{{ route('admin.home_slider.store') }}",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        toastr.success('Request has been completed.');

                        $('#home-slider-table').DataTable().ajax.reload(null, false);
                        $('#addSlideModal').modal('hide');
                    },
                    error: function(err) {
                        toastr.error('Failed to add slide.');
                    },
                    complete: function() {
                        $btn.prop('disabled', false).text('Create');
                    }
                });

            });

            // Clear modal on close
            $('#addSlideModal').on('hidden.bs.modal', function() {
                $('#addSlideForm')[0].reset();
                $('#addSlideForm .is-invalid').removeClass('is-invalid');
                $('#addSlideForm .invalid-feedback').hide();
            });

            // Hide validation on input change (live feedback)
            $('#heading, #background_image').on('input change', function() {
                $(this).removeClass('is-invalid');
                $(this).next('.invalid-feedback').hide();
            });
        });
    </script>
    <script>
        $(function() {
            $(document).on("click", '.editSlide', function() {
                let slideId = $(this).data('id');
                let heading = $(this).data('heading');
                let image = $(this).data('image');
                let content = $(this).data('content');

                $('#edit_slide_id').val(slideId);
                $('#edit_heading').val(heading);
                $('#edit_content').val(content);
                $('#edit_preview_image').attr('src', image);
                $('#editSlideForm').attr('action', '/admin/home-slider/update/' + slideId);

                $('#editSlideModal').modal('show');
            });

            $('#editSlideModal').on('hidden.bs.modal', function() {
                $('#editSlideForm')[0].reset();
                $('#editSlideForm .is-invalid').removeClass('is-invalid');
                $('#editSlideForm .invalid-feedback').hide();
                $('#edit_preview_image').attr('src', '');

            });

            $('#editSlideForm').on('submit', function(e) {
                e.preventDefault();
                let $btn = $('.updateSlide');
                let form = $(this)[0];
                let formData = new FormData(form);
                let isValid = true;
                let heading = $('#edit_heading');
                let content = $('#edit_content');
                let imageInput = $('#edit_background_image');
                let image = imageInput[0].files[0];

                heading.removeClass('is-invalid').next('.invalid-feedback').hide();
                content.removeClass('is-invalid').next('.invalid-feedback').hide();
                imageInput.removeClass('is-invalid').next('.invalid-feedback').hide();

                if (!heading.val().trim() || heading.val().length > 100) {
                    heading.addClass('is-invalid');
                    heading.next('.invalid-feedback').show();
                    isValid = false;
                }
                if (!content.val().trim() || content.val().length > 100) {
                    content.addClass('is-invalid');
                    content.next('.invalid-feedback').show();
                    isValid = false;
                }

                if (image) {
                    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
                    if (!allowedTypes.includes(image.type)) {
                        imageInput.addClass('is-invalid');
                        imageInput.next('.invalid-feedback').text("Only JPG, PNG, WEBP allowed").show();
                        isValid = false;
                    } else if (image.size > 2 * 1024 * 1024) {
                        imageInput.addClass('is-invalid');
                        imageInput.next('.invalid-feedback').text("Image must be under 2MB.").show();
                        isValid = false;
                    }
                }

                if (!isValid) {
                    e.preventDefault();
                    return false;
                }
                $btn.prop('disabled', true).text('Processing...');

                let actionUrl = $(this).attr('action');

                $.ajax({
                    url: actionUrl,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-HTTP-Method-Override': 'PUT'
                    },

                    success: function(res) {
                        $('#editSlideForm')[0].reset();
                        $('#editSlideForm .is-invalid').removeClass('is-invalid');
                        $('#editSlideForm .invalid-feedback').addClass('d-none');
                        toastr.success('Request has been completed.');

                        $('#home-slider-table').DataTable().ajax.reload(null, false);
                        $('#editSlideModal').modal('hide');

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
                        toastr.error("Something went wrong. Please try again.");
                    },
                    complete: function() {
                        $btn.prop('disabled', false).text('Update');
                    }
                });
            });

            $('#edit_heading, #edit_content, #edit_background_image').on('input change', function() {
                $(this).removeClass('is-invalid').next('.invalid-feedback').hide();
            });
        });
    </script>
    <script>
        $(document).on('click', '.viewImageBtn', function() {
            const imageUrl = $(this).data('image');
            $('#previewImageTag').attr('src', imageUrl);
            $('#imagePreviewModal').modal('show');
        });


        $('#imagePreviewModal').on('hidden.bs.modal', function() {
            $('#previewImageTag').attr('src', '');
        });
    </script>
    <script>
        $(document).ready(function() {
            var table = $('#home-slider-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                ajax: {
                    url: "{{ route('admin.home_sliders.get') }}",
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
                        data: 'heading',
                        name: 'heading'
                    },
                    {
                        data: 'background_image',
                        name: 'background_image',
                        orderable: false,
                        searchable: false
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
        });
    </script>
@endsection
