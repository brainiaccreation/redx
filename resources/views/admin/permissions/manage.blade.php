@extends('admin.master.layouts.app')

@section('page-title')
    Manage Permissions for {{ ucfirst($role->name) }}
@endsection

@section('head')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .page-content {
            background-color: #f5f5f5;
            min-height: 100vh;
            padding: 80px 20px 20px;
        }

        .main-card {
            border-radius: 10px;
            border: 1px solid #e5e5e5;
            background: white;
            /* max-width: 1200px; */
            /* margin: 0 auto; */
        }

        .main-card .card-header {
            background: #ff0000;
            color: white;
            border-radius: 10px 10px 0 0;
            padding: 15px;
            border: none;
            position: relative;
            z-index: 1;
        }

        .main-card .card-title {
            font-size: 1.2rem 19.2px;
            font-weight: 600;
            margin: 0;
            line-height: 1.2;
            color: #fff;
        }

        .back-btn {
            background: white;
            border: 1px solid #e5e5e5;
            color: #333;
            border-radius: 6px;
            padding: 5px 9px;
            /* Smaller padding for btn-sm */
            text-decoration: none;
            font-weight: 500;
            font-size: 0.85rem;
            /* Smaller font size */
            transition: background-color 0.2s ease;
        }

        .back-btn:hover {
            background: #f0f0f0;
        }

        .permissions-container {
            padding: 15px;
        }

        .module-card {
            background: white;
            border-radius: 8px;
            border: 1px solid #e5e5e5;
            margin-bottom: 12px;
        }

        .module-header {
            background: #fafafa;
            padding: 15px 20px;
            border-bottom: 1px solid #e5e5e5;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .module-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #222;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .module-icon {
            width: 8px;
            height: 8px;
            background: #ff0000;
            border-radius: 50%;
            margin-right: 12px;
        }

        .permissions-grid {
            padding: 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            /* Reverted to full-width for single permission */
            gap: 15px;
        }

        .permission-item {
            background: #fafafa;
            border: 1px solid #e5e5e5;
            border-radius: 6px;
            padding: 12px 15px;
            transition: all 0.2s ease;
        }

        .permission-item.checked {
            background: #fff5f5;
            border-color: #ff0000;
            transform: scale(1.02);
        }

        .form-check {
            display: flex;
            align-items: center;
            margin: 0;
        }

        .form-check-input {
            width: 18px;
            height: 18px;
            margin-right: 12px;
            border: 1px solid #999;
            border-radius: 4px;
            transition: all 0.2s ease;
        }

        .form-check-input:checked {
            background-color: #ff0000;
            border-color: #ff0000;
        }

        .form-check-input:focus {
            outline: none;
            border-color: #ff0000;
            box-shadow: 0 0 0 2px rgba(255, 0, 0, 0.1);
        }

        .form-check-label {
            font-size: 0.85rem;
            /* Reduced font size for permission names */
            font-weight: 400;
            color: #222;
            cursor: pointer;
            flex: 1;
        }

        .update-btn {
            background: #ff0000;
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 1rem;
        }

        .alert {
            border-radius: 6px;
            border: 1px solid #e5e5e5;
            background: #fff5f5;
            color: #222;
            padding: 12px;
        }

        .btn-close {
            font-size: 0.8rem;
        }

        .stats-row {
            background: #fafafa;
            border-radius: 6px;
            padding: 10px;
            margin-bottom: 12px;
            border: 1px solid #e5e5e5;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 1.3rem;
            font-weight: 600;
            color: #ff0000;
            display: block;
        }

        .stat-label {
            font-size: 0.85rem;
            color: #555;
            font-weight: 400;
        }

        @media (max-width: 768px) {
            .page-content {
                padding-top: 70px;
            }

            .permissions-grid {
                grid-template-columns: 1fr;
                padding: 15px;
            }

            .main-card .card-header {
                padding: 15px;
            }

            .main-card .card-title {
                font-size: 1.2rem;
            }

            .permissions-container {
                padding: 20px;
            }
        }
    </style>
@endsection

@section('page-content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card main-card">
                        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                            <h4 class="card-title">
                                <i class="fas fa-shield-alt me-2"></i>
                                Permissions for {{ ucfirst($role->name) }}
                            </h4>
                            <a href="{{ route('admin.permissions.list') }}" class="back-btn">
                                <i class="fas fa-arrow-left me-2"></i>Back to Roles
                            </a>
                        </div>

                        <div class="permissions-container">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="fas fa-check-circle me-2"></i>
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <div class="stats-row">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="stat-item">
                                            <span class="stat-number">{{ count($modules) }}</span>
                                            <span class="stat-label">Total Modules</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="stat-item">
                                            <span class="stat-number">{{ $permissions->count() }}</span>
                                            <span class="stat-label">Total Permissions</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="stat-item">
                                            <span class="stat-number">{{ $role->permissions->count() }}</span>
                                            <span class="stat-label">Assigned Permissions</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <form action="{{ route('admin.permissions.update', $role) }}" method="POST"
                                id="permissionsForm">
                                @csrf
                                @method('PUT')

                                @foreach ($modules as $module => $modulePermissions)
                                    <div class="module-card">
                                        <div class="module-header">
                                            <h5 class="module-title">
                                                <div class="module-icon"></div>
                                                <i class="fas fa-cube me-2"></i>
                                                {{ $module }}
                                                <span class="badge bg-danger-subtle text-danger fw-medium ms-auto">
                                                    {{ count(array_filter($modulePermissions, fn($perm) => ($permissions->contains('name', $perm) && !preg_match('/\b(store|update|get|logout admin)\b/i', $perm)) || $perm === 'update user weekly limit')) }}
                                                    permissions
                                                </span>
                                            </h5>
                                        </div>

                                        <div class="permissions-grid">
                                            @foreach ($modulePermissions as $permission)
                                                @if (
                                                    $permissions->contains('name', $permission) &&
                                                        (!preg_match('/\b(store|update|get|logout admin)\b/i', $permission) ||
                                                            $permission === 'update users weekly limit'))
                                                    <div class="permission-item {{ $role->hasPermissionTo($permission) ? 'checked' : '' }}"
                                                        data-permission="{{ $permission }}">
                                                        <div class="form-check">
                                                            <input type="checkbox" name="permissions[]"
                                                                value="{{ $permission }}"
                                                                {{ $role->hasPermissionTo($permission) ? 'checked' : '' }}
                                                                class="form-check-input permission-checkbox"
                                                                id="perm-{{ str_replace(' ', '-', $permission) }}">
                                                            <label class="form-check-label"
                                                                for="perm-{{ str_replace(' ', '-', $permission) }}">
                                                                {{ ucwords(str_replace('_', ' ', $permission)) }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach

                                <div class="text-end">
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-save me-2"></i>Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.permission-checkbox');
            const form = document.getElementById('permissionsForm');
            const submitBtn = document.querySelector('.update-btn');

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const permissionItem = this.closest('.permission-item');
                    permissionItem.classList.toggle('checked', this.checked);
                    updateStats();
                });
            });

            function updateStats() {
                const totalChecked = document.querySelectorAll('.permission-checkbox:checked').length;
                const statNumbers = document.querySelectorAll('.stat-number');
                if (statNumbers.length >= 3) {
                    statNumbers[2].textContent = totalChecked;
                }
            }

            form.addEventListener('submit', function() {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Saving...';
                submitBtn.disabled = true;
            });
        });
    </script>
@endsection
