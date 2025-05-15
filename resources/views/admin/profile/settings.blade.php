@extends('admin.master.layouts.app')
@section('page-title')
    Profile Settings
@endsection
@section('page-content')
    <div class="page-content">
        <div class="container-fluid">


            <div class="row">

                <!--end col-->
                <div class="col-xxl-9">
                    <div class="card mt-xxl-n5">
                        <div class="card-header">
                            <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                        <i class="fas fa-home"></i> Personal Details
                                    </a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab">
                                        <i class="far fa-user"></i> Change Password
                                    </a>
                                </li> --}}
                            </ul>
                        </div>
                        <div class="card-body p-4">

                            <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                            <img src="{{ auth()->user()->avatar ? URL(auth()->user()->avatar) : URL('admin/assets/images/users/avatar-1.jpg') }}"
                                                class="rounded-circle avatar-xl img-thumbnail user-profile-image material-shadow"
                                                alt="user-profile-image">
                                            <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                                <input id="profile-img-file-input" type="file"
                                                    class="profile-img-file-input" name="avatar">
                                                <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                                    <span
                                                        class="avatar-title rounded-circle bg-light text-body material-shadow">
                                                        <i class="ri-camera-fill"></i>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-9">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="firstnameInput" class="form-label">Name</label>
                                                <input type="text" class="form-control" id="firstnameInput"
                                                    placeholder="Enter your firstname" name="name"
                                                    value="{{ auth()->user()->name }}">
                                            </div>
                                        </div>

                                        <!--end col-->
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="emailInput" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="emailInput"
                                                    placeholder="Enter your email" name="email"
                                                    value="{{ auth()->user()->email }}">
                                            </div>
                                        </div>
                                    </div>

                                    <!--end col-->
                                    <div class="col-lg-12">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="submit" class="btn btn-danger">Update</button>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </form>

                        </div>
                    </div>
                </div>
                <div class="col-xxl-9">
                    <div class="card mt-xxl-n5">
                        <div class="card-header">
                            <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">

                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#changePassword" role="tab">
                                        <i class="far fa-user"></i> Change Password
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body p-4">

                            <form action="{{ route('change.password') }}" method="POST">
                                @csrf
                                <div class="row g-2">
                                    <div class="col-lg-4">
                                        <div>
                                            <label for="oldpasswordInput" class="form-label">Old Password*</label>
                                            <input type="password" class="form-control" id="oldpasswordInput"
                                                placeholder="Enter current password" name="old_password">
                                        </div>
                                        @error('old_password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-4">
                                        <div>
                                            <label for="newpasswordInput" class="form-label">New Password*</label>
                                            <input type="password" class="form-control" id="newpasswordInput"
                                                placeholder="Enter new password" name="new_password">
                                        </div>
                                        @error('new_password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-4">
                                        <div>
                                            <label for="confirmpasswordInput" class="form-label">Confirm
                                                Password*</label>
                                            <input type="password" class="form-control" id="confirmpasswordInput"
                                                placeholder="Confirm password" name="new_password_confirmation">
                                        </div>
                                        @error('new_password_confirmation')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!--end col-->
                                    <div class="col-lg-12">
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-danger">Change
                                                Password</button>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </form>

                        </div>
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->

        </div>
        <!-- container-fluid -->
    </div><!-- End Page-content -->
@endsection
@section('scripts')
    <script src="{{ URL('admin/assets') }}/js/pages/profile-setting.init.js"></script>
@endsection
