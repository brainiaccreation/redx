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
                            <form class="row g-3" method="POST" action="{{ route('admin.user.update', $user->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="col-md-6">
                                    <label for="first_name" class="form-label">First Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="first_name" name="name" value="{{ old('name', $user->name) }}"
                                        placeholder="First Name" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="last_name" class="form-label">Last Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                        id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}"
                                        placeholder="Last Name" required>
                                    @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email <span
                                            class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email', $user->email) }}"
                                        placeholder="Email" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                                        placeholder="Phone">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="country" class="form-label">Country</label>
                                    <input type="text" class="form-control @error('country') is-invalid @enderror"
                                        id="country" name="country" value="{{ old('country', $user->country) }}"
                                        placeholder="Country">
                                    @error('country')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" class="form-control @error('towncity') is-invalid @enderror"
                                        id="city" name="towncity" value="{{ old('towncity', $user->towncity) }}"
                                        placeholder="City">
                                    @error('towncity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                                        id="address" name="address" value="{{ old('address', $user->address) }}"
                                        placeholder="Address">
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="address2" class="form-label">Address 2</label>
                                    <input type="text" class="form-control @error('address2') is-invalid @enderror"
                                        id="address2" name="address2" value="{{ old('address2', $user->address2) }}"
                                        placeholder="Address 2">
                                    @error('address2')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="avatar" class="form-label">Avatar</label>
                                    <input type="file" class="form-control @error('avatar') is-invalid @enderror"
                                        id="avatar" name="avatar" accept="image/*">
                                    @error('avatar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    @if ($user->avatar && file_exists(public_path($user->avatar)))
                                        <div class="mt-2">
                                            <a href="{{ asset($user->avatar) }}" class="text-danger" target="_blank">
                                                Uploaded Avatar <i class="ri-external-link-line"></i>
                                            </a>
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    <label for="role" class="form-label">Role <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control form-select @error('role') is-invalid @enderror"
                                        id="role" name="role" required>
                                        <option value="" disabled>Select Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}"
                                                {{ old('role', $user->roles->pluck('name')->first()) == $role->name ? 'selected' : '' }}>
                                                {{ ucfirst($role->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password"
                                        placeholder="Leave blank to keep current password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" placeholder="Confirm Password">
                                </div>

                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-danger">Update</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div><!--end col-->
            </div><!--end row-->
        </div>
    </div>
@endsection
