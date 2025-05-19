@extends('admin.master.layouts.app')
@section('page-title')
    Edit User
@endsection

@section('page-content')
    {{-- @component('admin.master.layouts.partials.breadcrumb')
        @slot('li_1')
            User
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
                                    <h4 class="card-title mb-0 flex-grow-1">User Edit</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form class="row g-3" method="POST" action="{{ route('admin.user.update', $user->id) }}">
                                @method('PUT')
                                @csrf
                                <div class="col-md-6 col-lg-6 col-sm-12">
                                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Name" value="{{ $user->name }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-lg-6 col-sm-12">
                                    <label for="email" class="form-label">Email <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="email" name="email"
                                        placeholder="Email" value="{{ $user->email }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-check form-check-right mb-2">
                                        <input class="form-check-input" type="checkbox" name="is_suspended"
                                            id="is_suspended1" {{ $user->is_suspended == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_suspended1">
                                            Suspended
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
