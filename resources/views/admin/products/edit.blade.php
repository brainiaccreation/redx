@extends('admin.master.layouts.app')
@section('page-title')
    Edit Product
@endsection
@section('head')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endsection
@section('page-content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <div class="p-0">
                                    <h4 class="card-title mb-0 flex-grow-1">Product Edit</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form class="row g-3" method="POST" action="{{ route('admin.product.update', $product->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="col-md-6">
                                    <label for="name" class="form-label">Product Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ old('name', $product->name) }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="slug" name="slug"
                                        value="{{ old('slug', $product->slug) }}" required>
                                </div>

                                <div class="col-md-3 col-lg-3 col-sm-12">
                                    <label class="form-label">Category <span class="text-danger">*</span></label>
                                    <select class="js-example-basic-single" name="category_id" id="category">
                                        <option disabled>Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 col-lg-3 col-sm-12">
                                    <label for="name" class="form-label">Type <span class="text-danger">*</span></label>
                                    <select class="js-example-basic-single" name="type" id="type">
                                        <option value="gift_card" {{ $product->type == 'gift_card' ? 'selected' : '' }}>Gift
                                            Card
                                        </option>
                                        <option value="auto" {{ $product->type == 'auto' ? 'selected' : '' }}>
                                            Auto
                                        </option>
                                        <option value="manual" {{ $product->type == 'manual' ? 'selected' : '' }}>Manual
                                        </option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-3 col-lg-3 col-sm-12">
                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="js-example-basic-single" name="status" id="status">
                                        <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                        <option value="draft" {{ $product->status == 'draft' ? 'selected' : '' }}>Draft
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-3 col-lg-3 col-sm-12">
                                    <label class="form-label">&nbsp;</label>
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" id="formCheck2" name="is_featured"
                                            {{ $product->is_featured ? 'checked' : '' }}>
                                        <label class="form-check-label" for="formCheck2">Featured Product</label>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <label class="form-label">Short Description</label>
                                    <textarea class="form-control" rows="3" name="short_description">{{ old('short_description', $product->short_description) }}</textarea>
                                </div>

                                <div class="col-sm-12">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description">{{ old('description', $product->description) }}</textarea>
                                </div>

                                <div class="col-sm-12">
                                    <label class="form-label">Featured Image</label>
                                    <input type="file" name="featured_image" class="dropify"
                                        data-default-file="{{ asset($product->featured_image) }}" id="featured_image"
                                        data-height="180" accept=".jpg, .jpeg, .png, .webp">
                                </div>

                                <h3>Product Variants</h3>
                                <div class="col-md-12">
                                    <div class="text-end">
                                        <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                            data-bs-target="#variantModal">+ Add Variant</button>
                                    </div>
                                </div>

                                <ul id="variant-list" class="list-group mt-4"></ul>

                                <div class="col-12">
                                    <div class="text-right">
                                        <button class="btn btn-danger" type="submit">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.products.modal')
@endsection

@section('scripts')
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.js"></script>
    <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
    <script src="{{ URL('admin/assets') }}/libs/sortablejs/Sortable.min.js"></script>
    <script src="{{ URL('admin/assets') }}/js/pages/nestable.init.js"></script>
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
                height: 200,
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
        const existingVariants = @json($product->variants);
        let variants = existingVariants.map((v, i) => ({
            ...v
        }));

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
                <input type="hidden" name="variant_id[]" value="${variant.id || ''}">
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
                newOrder.push({
                    ...variants[index]
                });
            });
            variants = newOrder;
            renderVariants();
        }

        $(document).ready(function() {
            renderVariants();

            $('#variantForm').on('submit', function(e) {
                e.preventDefault();
                const editIndex = $('#editIndex').val();

                const variantData = {
                    name: $('#variantName').val(),
                    sku: $('#sku').val(),
                    region: $('#region').val(),
                    denomination: $('#denomination').val(),
                    price: $('#price').val()
                };

                if (editIndex !== "") {
                    // Preserve the original ID when editing existing variants
                    variantData.id = variants[editIndex].id || null;
                    variants[editIndex] = variantData;
                } else {
                    // For new variants, no ID is assigned
                    variants.push(variantData);
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
                    update: sortVariants
                });
            });

            $('#variantModal').on('hidden.bs.modal', function() {
                $('#variantForm')[0].reset();
                $('#editIndex').val('');
            });
        });
    </script>
@endsection
