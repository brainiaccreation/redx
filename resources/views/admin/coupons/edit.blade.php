@extends('admin.master.layouts.app')
@section('page-title')
    Edit Code
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
                                    <h4 class="card-title mb-0 flex-grow-1">Code Edit</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form class="row g-3" method="POST" action="{{ route('admin.code.update', $code->id) }}">
                                @method('PUT')
                                @csrf
                                <div class="col-md-12 col-lg-12 col-sm-12">
                                    <label for="name" class="form-label">Code <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="code" name="code"
                                        placeholder="Code" required value="{{ old('code', $code->code) }}">
                                    @error('code')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-lg-6 col-sm-12">
                                    <label for="name" class="form-label">Product <span
                                            class="text-danger">*</span></label>
                                    <select class="js-example-basic-single" name="product_id" id="product" required>
                                        <option disabled {{ old('product_id') ? '' : 'selected' }}>Select Product</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}"
                                                {{ $code->product_id == $product->id ? 'selected' : '' }}>
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
                                    <select class="js-example-basic-single" name="variant_id" id="variant" required>
                                        <option disabled {{ old('variant_id', $code->variant_id ?? '') ? '' : 'selected' }}>
                                            Select Product Variant</option>
                                    </select>
                                    @error('variant_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <div class="text-right">
                                        <button class="btn btn-danger" type="submit">Update</button>
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

            var selectedProductId = '{{ old('product_id', $code->product_id ?? '') }}';
            var selectedVariantId = '{{ old('variant_id', $code->variant_id ?? '') }}';

            if (selectedProductId) {
                $.ajax({
                    url: '{{ route('admin.code.variants', ':id') }}'.replace(':id', selectedProductId),
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        let $variant = $('#variant');
                        $variant.empty();
                        $variant.append('<option disabled>Select Product Variant</option>');

                        $.each(data, function(key, value) {
                            let isSelected = (value.id == selectedVariantId) ? 'selected' : '';
                            $variant.append('<option value="' + value.id + '" ' + isSelected +
                                '>' + value.name + '</option>');
                        });

                        $variant.val(selectedVariantId).trigger('change.select2');
                    }
                });
            }

            // On product change, load variants dynamically
            $('#product').on('change', function() {
                var productId = $(this).val();

                if (productId) {
                    $.ajax({
                        url: '{{ route('admin.code.variants', ':id') }}'.replace(':id', productId),
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            let $variant = $('#variant');
                            $variant.empty();
                            $variant.append(
                                '<option disabled selected>Select Product Variant</option>');

                            $.each(data, function(key, value) {
                                $variant.append('<option value="' + value.id + '">' +
                                    value.name + '</option>');
                            });

                            $variant.trigger('change.select2');
                        }
                    });
                } else {
                    $('#variant').empty()
                        .append('<option disabled selected>Select Product Variant</option>')
                        .trigger('change.select2');
                }
            });

        });
    </script>
@endsection
