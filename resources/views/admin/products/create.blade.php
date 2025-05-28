@extends('admin.master.layouts.app')
@section('page-title')
    Add Product
@endsection
@section('head')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endsection
@section('page-content')
    {{-- @component('admin.master.layouts.partials.breadcrumb')
        @slot('li_1')
            Product
        @endslot
        @slot('title')
            Add
        @endslot
    @endcomponent --}}
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <div class="p-0">
                                    <h4 class="card-title mb-0 flex-grow-1">Product Add</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form class="row g-3" method="POST" action="{{ route('admin.product.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-6 col-lg-6 col-sm-12">
                                    <label for="name" class="form-label">Product Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Name" required value="{{ old('name') }}">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-lg-6 col-sm-12">
                                    <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="slug" name="slug"
                                        placeholder="Slug" required value="{{ old('slug') }}">
                                    @error('slug')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3 col-lg-3 col-sm-12">
                                    <label for="name" class="form-label">Category <span
                                            class="text-danger">*</span></label>
                                    <select class="js-example-basic-single" name="category_id" id="category">
                                        <option disabled {{ old('category_id') ? '' : 'selected' }}>Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3 col-lg-3 col-sm-12">
                                    <label for="name" class="form-label">Type <span class="text-danger">*</span></label>
                                    <select class="js-example-basic-single" name="type" id="type">
                                        <option value="gift_card" {{ old('type') == 'gift_card' ? 'selected' : '' }}>Gift
                                            Card
                                        </option>
                                        <option value="auto" {{ old('type') == 'auto' ? 'selected' : '' }}>
                                            Auto
                                        </option>
                                        <option value="manual" {{ old('type') == 'manual' ? 'selected' : '' }}>Manual
                                        </option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3 col-lg-3 col-sm-12">
                                    <label for="name" class="form-label">Status <span
                                            class="text-danger">*</span></label>
                                    <select class="js-example-basic-single" name="status">
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3 col-lg-3 col-sm-12">
                                    <label for="featured" class="form-label"></label>
                                    <div class="form-check mt-3">
                                        <input class="form-check-input" type="checkbox" id="formCheck2" name="is_featured"
                                            {{ old('is_featured') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="formCheck2">
                                            Featured Product
                                        </label>
                                    </div>

                                    @error('is_featured')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div class="col-sm-12">
                                                <label for="short_description" class="form-label">Short Description</label>
                                                <textarea type="text" class="form-control" rows="3" id="short_description" name="short_description"
                                                    placeholder="Short Description">{{ old('short_description') }}</textarea>
                                                @error('short_description')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="description" class="form-label">Description</label>
                                                <textarea type="text" class="form-control" id="description" name="description" placeholder="Description">{{ old('description') }}</textarea>
                                                @error('description')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="checkbox-section">
                                                <div class="section-title">Required Information</div>
                                                <div class="checkbox-group">
                                                    <div class="checkbox-item" data-field="userId">
                                                        <input type="checkbox" id="userId" name="game_user_id"
                                                            value="1">
                                                        <label for="userId" class="checkbox-label">Game User
                                                            ID</label>
                                                        <span class="required-badge">Required</span>
                                                    </div>

                                                    <div class="checkbox-item" data-field="serverId">
                                                        <input type="checkbox" id="serverId" name="game_server_id"
                                                            value="1">
                                                        <label for="serverId" class="checkbox-label">Game Server
                                                            ID</label>
                                                        <span class="required-badge">Required</span>
                                                    </div>

                                                    <div class="checkbox-item" data-field="userName">
                                                        <input type="checkbox" id="userName" name="game_user_name"
                                                            value="1">
                                                        <label for="userName" class="checkbox-label">Game User
                                                            Name</label>
                                                        <span class="required-badge">Required</span>
                                                    </div>

                                                    <div class="checkbox-item" data-field="email">
                                                        <input type="checkbox" id="email" name="game_email"
                                                            value="1">
                                                        <label for="email" class="checkbox-label">Game
                                                            Email</label>
                                                        <span class="required-badge">Required</span>
                                                    </div>

                                                    <div class="checkbox-item no-info" data-field="noInfo">
                                                        <input type="checkbox" id="noInfo" name="no_info_required"
                                                            value="1">
                                                        <label for="noInfo" class="checkbox-label">🚫 No Info
                                                            Required</label>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <label for="description" class="form-label">Featured Image</label>
                                    <input name="featured_image" type="file" class="dropify" id="featured_image"
                                        data-height="180" accept=".jpg, .jpeg, .png, .webp" />
                                    @error('featured_image')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <h3>Product Variants</h3>
                                <p>Add different variants based on region and denomination</p>
                                <div class="col-md-12">
                                    <div class="text-end">
                                        <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                            data-bs-target="#variantModal">+ Add
                                            Variant</button>
                                    </div>
                                </div>
                                <input type="hidden" name="variants[]" value="">

                                <ul id="variant-list" class="list-group mt-4"></ul>

                                {{-- <div id="variant-wrapper">
                                    <div class="variant-box" data-index="1">
                                        <strong>Variant #1 (Default)</strong>
                                        <br><br>
                                        <div class="row">
                                            <div class="col-md-6 col-lg-6 col-sm-12">
                                                <input type="text" name="variant_name[]" placeholder="Variant Name"
                                                    class="form-control" required>
                                            </div>
                                            <div class="col-md-6 col-lg-6 col-sm-12">
                                                <input type="text" name="sku[]" class="form-control"
                                                    placeholder="SKU" required>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-4 col-lg-4 col-sm-12">
                                                <select name="region[]" class="form-control form-select" required>
                                                    <option value="">Select Region</option>
                                                    <option value="MY">Malaysia</option>
                                                    <option value="SG">Singapore</option>
                                                    <option value="TH">Thailand</option>
                                                    <option value="ID">Indonesia</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 col-lg-4 col-sm-12">
                                                <input type="text" name="denomination[]" class="form-control"
                                                    placeholder="Denomination" required>
                                            </div>
                                            <div class="col-md-4 col-lg-4 col-sm-12">
                                                <input type="number" name="price[]" class="form-control"
                                                    placeholder="Price (MYR)" required>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-lg-12">
                                                <div class="text-end">
                                                    <button type="button" class="btn btn-primary" id="add-variant">+ Add
                                                        Another
                                                        Variant</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}

                                <div class="col-12">
                                    <div class="text-right">
                                        <button class="btn btn-danger" type="submit">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!--end col-->
            </div><!--end row-->
        </div>
    </div>
    @include('admin.products.modal')
@endsection
@section('scripts')
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.js"></script>
    <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
    <script src="{{ asset('admin/assets') }}/libs/sortablejs/Sortable.min.js"></script>
    <script src="{{ asset('admin/assets') }}/js/pages/nestable.init.js"></script>
    <script>
        $(document).ready(function() {
            let drEvent = $('#featured_image').dropify({
                messages: {
                    'default': 'Drag and drop a file here or click',
                    'replace': 'Drag and drop or click to replace',
                    'remove': 'Remove',
                    'error': 'Ooops, something wrong happened.'
                }
            });

            drEvent.on('change', function(e) {
                let file = e.target.files[0];

                if (file) {
                    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
                    const maxSize = 10 * 1024 * 1024;

                    if (!allowedTypes.includes(file.type)) {
                        toastr.error('Invalid file type. Only JPG, JPEG, PNG, and WEBP are allowed.');
                        $(this).val('');
                        $('.dropify-clear').click();
                        return;
                    }

                    if (file.size > maxSize) {
                        toastr.error('File size exceeds 10MB limit.');
                        $(this).val('');
                        $('.dropify-clear').click();
                        return;
                    }
                }
            });

            $('#description').summernote({
                placeholder: 'Add description here',
                tabsize: 2,
                height: 250,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['color', ['color']]
                ]
            });

            $('.js-example-basic-single').select2();

            $('#name').on('input', function() {
                const name = $(this).val();
                const slug = name
                    .toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');

                $('#slug').val(slug);
            });

            $('#slug').on('input', function() {
                const cleanedSlug = $(this).val()
                    .toLowerCase()
                    .replace(/[^a-z0-9-]/g, '')
                    .replace(/-+/g, '-');

                $(this).val(cleanedSlug);
            });

            $('#category').on('change', function() {
                var selectedCategoryText = $('#category option:selected').text().trim();
                var $typeSelect = $('#type');
                $typeSelect.find('option').prop('disabled', false);

                if (selectedCategoryText === 'Gift Cards') {
                    $typeSelect.find('option').each(function() {
                        var optionText = $(this).text().replace(/\s+/g, ' ').trim();
                        if (optionText === 'Gift Card') {
                            $(this).prop('disabled', false).prop('selected', true);
                        } else {
                            $(this).prop('disabled', true).prop('selected', false);
                        }
                    });

                } else if (selectedCategoryText === 'Game Reloads') {
                    $typeSelect.find('option').each(function() {
                        var optionText = $(this).text().replace(/\s+/g, ' ').trim();
                        if (optionText === 'Manual') {
                            $(this).prop('disabled', false).prop('selected', true);
                        } else if (optionText === 'Gift Card') {
                            $(this).prop('disabled', true).prop('selected', false);
                        } else {
                            $(this).prop('disabled', false).prop('selected', false);
                        }
                    });
                } else {
                    $typeSelect.find('option').prop('disabled', false);
                    $typeSelect.val('');
                }

                $typeSelect.trigger('change.select2');
            });


        });
        let variants = [];

        function renderVariants() {
            const list = $('#variant-list');
            list.empty();

            variants.forEach((variant, index) => {
                list.append(`
            <li class="list-group-item d-flex justify-content-between align-items-center variant-item" data-index="${index}">
                <span><strong>${variant.name}</strong> (${variant.region})</span>
                <span class="variant-actions">
                    <a class="edit-variant me-2" data-index="${index}" title="Edit" style="cursor:pointer;">
                        <i class="ri-edit-line"></i>
                    </a>
                    <a class="delete-variant me-2" data-index="${index}" title="Delete" style="cursor:pointer;">
                        <i class="bx bx-trash"></i>
                    </a>
                </span>

                <!-- Hidden Inputs for Backend -->
                <input type="hidden" name="variant_name[]" value="${variant.name}">
                <input type="hidden" name="variant_sku[]" value="${variant.sku}">
                <input type="hidden" name="variant_region[]" value="${variant.region}">
                <input type="hidden" name="variant_denomination[]" value="${variant.denomination}">
                <input type="hidden" name="variant_price[]" value="${variant.price}">
                <input type="hidden" name="variant_order[]" value="${index}">
            </li>
        `);
            });
        }

        function sortVariants() {
            const newOrder = [];
            $('#variant-list .variant-item').each(function() {
                const index = $(this).data('index');
                newOrder.push(variants[index]);
            });
            variants = newOrder;
            renderVariants(); // re-render with updated order
        }

        $('#variantForm').on('submit', function(e) {
            e.preventDefault();

            const variantData = {
                name: $('#variantName').val(),
                sku: $('#sku').val(),
                region: $('#region').val(),
                denomination: $('#denomination').val(),
                price: $('#price').val()
            };

            const editIndex = $('#editIndex').val();

            if (editIndex !== "") {
                variants[editIndex] = variantData; // Update existing
            } else {
                variants.push(variantData); // Add new
            }

            renderVariants();
            $('#variantForm')[0].reset();
            $('#editIndex').val('');
            $('#variantModal').modal('hide');
        });

        $(document).on('click', '.delete-variant', function() {
            const index = $(this).data('index');
            variants.splice(index, 1);
            renderVariants();
        });

        $(document).on('click', '.edit-variant', function() {
            const index = $(this).data('index');
            const variant = variants[index];

            $('#variantName').val(variant.name);
            $('#sku').val(variant.sku);
            $('#region').val(variant.region);
            $('#denomination').val(variant.denomination);
            $('#price').val(variant.price);
            $('#editIndex').val(index);

            $('#variantModal').modal('show');
        });

        $(function() {
            $('#variant-list').sortable({
                update: function() {
                    sortVariants();
                }
            });
        });

        // Reset form on modal close
        $('#variantModal').on('hidden.bs.modal', function() {
            $('#variantForm')[0].reset();
            $('#editIndex').val('');
        });
    </script>
@endsection
