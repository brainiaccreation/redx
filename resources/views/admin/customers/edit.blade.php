@extends('admin.master.layouts.app')
@section('page-title')
    Edit Customer
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
                                    <h4 class="card-title mb-0 flex-grow-1">Customer Edit</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form class="row g-3" method="POST" action="{{ route('admin.customer.update', $user->id) }}"
                                enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="col-md-12 col-lg-12 col-sm-12">
                                    <label for="avatar" class="form-label">Avatar <span
                                            class="text-danger">*</span></label>
                                    <input type="file" class="form-control" id="avatar" name="avatar"
                                        placeholder="Avatar">
                                    @if ($user->avatar)
                                        <div class="mt-2">
                                            <a href="{{ asset($user->avatar) }}" class="text-danger"
                                                target="_blank">Uploaded
                                                Avatar <i class="ri-external-link-line"></i></a>
                                        </div>
                                    @endif
                                    @error('avatar')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-lg-6 col-sm-12">
                                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Name" value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-lg-6 col-sm-12">
                                    <label for="last_name" class="form-label">Last Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="last_name" name="last_name"
                                        placeholder="Last Name" value="{{ old('last_name', $user->last_name) }}" required>
                                    @error('last_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-lg-6 col-sm-12">
                                    <label for="email" class="form-label">Email <span
                                            class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Email" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-lg-6 col-sm-12">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        placeholder="Phone" value="{{ old('phone', $user->phone) }}">
                                    @error('phone')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-lg-6 col-sm-12">
                                    <label for="country" class="form-label">Country</label>
                                    <input type="text" class="form-control" id="country" name="country"
                                        placeholder="Country" value="{{ old('country', $user->country) }}">
                                    @error('country')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-lg-6 col-sm-12">
                                    <label for="towncity" class="form-label">City</label>
                                    <input type="text" class="form-control" id="towncity" name="towncity"
                                        placeholder="City" value="{{ old('towncity', $user->towncity) }}">
                                    @error('towncity')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-lg-6 col-sm-12">
                                    <label for="address" class="form-label">Address Line 1</label>
                                    <textarea name="address" rows="3" placeholder="Address Line 1" class="form-control" resize="none">{{ old('address', $user->address) }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-lg-6 col-sm-12">
                                    <label for="address2" class="form-label">Address Line 2</label>
                                    <textarea name="address2" rows="3" placeholder="Address Line 2" class="form-control" resize="none">{{ old('address2', $user->address2) }}</textarea>
                                    @error('address2')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-lg-6 col-sm-12">
                                    <label for="wallet_balance" class="form-label">Wallet Balance</label>
                                    <input type="number" class="form-control readonly" id="wallet_balance"
                                        placeholder="0.00" step="0.1" value="{{ $user->wallet_balance }}" readonly>

                                </div>
                                <div class="col-md-6 col-lg-6 col-sm-12">
                                    <label for="account_type" class="form-label">Account Type</label>
                                    <input type="text" class="form-control readonly" id="account_type"
                                        placeholder="Account Type" value="{{ ucfirst($user->account_type) }}" readonly>
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
