@extends('admin.master.layouts.app')
@section('page-title')
    Edit Category
@endsection
@section('head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <link href="{{ URL('admin/assets') }}/css/datatable.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('page-content')
    {{-- @component('admin.master.layouts.partials.breadcrumb')
        @slot('li_1')
            Category
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
                                    <h4 class="card-title mb-0 flex-grow-1">Category Edit</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form class="row g-3" method="POST" action="{{ route('admin.category.update',$category->id) }}">
                                @method('PUT')
                                @csrf
                                <div class="col-md-6 col-lg-6 col-sm-12">
                                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ $category->name }}"
                                        required>
                                    @error('name') 
                                        <div class="invalid-feedback">
                                            {{ $message }} 
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-lg-6 col-sm-12">
                                    <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="slug" name="slug" placeholder="Slug" value="{{ $category->slug }}"
                                        required>
                                    @error('slug') 
                                        <div class="invalid-feedback">
                                            {{ $message }} 
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-sm-12">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea type="text" class="form-control" rows="3" id="description" name="description" placeholder="Description">{{ $category->description }}</textarea>
                                    @error('description') 
                                        <div class="invalid-feedback">
                                            {{ $message }} 
                                        </div>
                                    @enderror
                                </div>
                                
                                <div class="col-lg-4">
                                    <div class="form-check form-check-right mb-2">
                                        <input class="form-check-input" type="checkbox" name="status" id="status1" {{ $category->status == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status1">
                                            Status
                                        </label>
                                    </div>
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
@endsection
@section('scripts')

    <script>
        $(document).ready(function() {
          

            $('#name').on('input', function () {
                let name = $(this).val();
                let slug = name
                    .toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');

                $('#slug').val(slug);
            });
            $('#slug').on('input', function () {
                let cleanSlug = $(this).val().replace(/[^a-zA-Z0-9-]/g, '');
                $(this).val(cleanSlug);
            });

        });
    </script>
@endsection
