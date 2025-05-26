@extends('admin.master.layouts.app')
@section('page-title')
    Add Code
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
                                    <h4 class="card-title mb-0 flex-grow-1">Code Add</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form class="row g-3" method="POST" action="{{ route('admin.code.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-12 col-lg-12 col-sm-12">
                                    <label for="name" class="form-label">Code <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="code" name="code"
                                        placeholder="Code" required value="{{ old('code') }}">
                                    @error('code')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-lg-6 col-sm-12">
                                    <label for="name" class="form-label">Product <span
                                            class="text-danger">*</span></label>
                                    <select class="js-example-basic-single" name="product_id" id="product">
                                        <option disabled {{ old('product_id') ? '' : 'selected' }}>Select Product</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}"
                                                {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-lg-6 col-sm-12">
                                    <label for="name" class="form-label">Product Variant <span
                                            class="text-danger">*</span></label>
                                    <select class="js-example-basic-single" name="variant_id" id="variant">
                                        <option disabled {{ old('variant_id') ? '' : 'selected' }}>Select Product Variant
                                        </option>
                                    </select>
                                    @error('variant_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

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
    \
@endsection
@section('scripts')
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.js"></script>
    <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
    <script src="{{ URL('admin/assets') }}/libs/sortablejs/Sortable.min.js"></script>
    <script src="{{ URL('admin/assets') }}/js/pages/nestable.init.js"></script>
    <script>
        $(document).ready(function() {


            $('.js-example-basic-single').select2();

            $('#product').on('change', function() {
                var productId = $(this).val();

                if (productId) {
                    $.ajax({
                        url: '{{ route('admin.code.variants', ':id') }}'.replace(':id', productId),
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            // Clear old options
                            let $variant = $('#variant');
                            $variant.empty();
                            $variant.append(
                                '<option disabled selected>Select Product Variant</option>');

                            // Add new options
                            $.each(data, function(key, value) {
                                $variant.append('<option value="' + value.id + '">' +
                                    value.name + '</option>');
                            });

                            // Refresh Select2 (important)
                            $variant.trigger('change.select2');
                        }
                    });
                } else {
                    $('#variant').empty().append(
                            '<option disabled selected>Select Product Variant</option>')
                        .trigger('change.select2');
                }
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
