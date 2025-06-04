 <!-- ========== App Menu ========== -->
 <div class="app-menu navbar-menu">
     <!-- LOGO -->
     <div class="navbar-brand-box">
         <!-- Dark Logo-->
         <a href="index.html" class="logo logo-dark">
             <span class="logo-sm">
                 <img src="{{ asset('admin/assets') }}/images/logo-sm.jpg" alt="" height="30">
             </span>
             <span class="logo-lg">
                 <img src="{{ asset('admin/assets') }}/images/logo-dark.png" alt="" height="35">
             </span>
         </a>
         <!-- Light Logo-->
         <a href="index.html" class="logo logo-light">
             <span class="logo-sm">
                 <img src="{{ asset('admin/assets') }}/images/logo-sm.jpg" alt="" height="30">
             </span>
             <span class="logo-lg">
                 <img src="{{ asset('admin/assets') }}/images/logo-light.png" alt="" height="35">
             </span>
         </a>
         <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
             id="vertical-hover">
             <i class="ri-record-circle-line"></i>
         </button>
     </div>

     <div class="dropdown sidebar-user m-1 rounded">
         <button type="button" class="btn material-shadow-none" id="page-header-user-dropdown"
             data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             <span class="d-flex align-items-center gap-2">
                 <img class="rounded header-profile-user" src="{{ asset('admin/assets') }}/images/users/avatar-1.jpg"
                     alt="Header Avatar">
                 <span class="text-start">
                     <span class="d-block fw-medium sidebar-user-name-text">{{ auth()->user()->name }}</span>
                     <span class="d-block fs-14 sidebar-user-name-sub-text"><i
                             class="ri ri-circle-fill fs-10 text-success align-baseline"></i> <span
                             class="align-middle">Online</span></span>
                 </span>
             </span>
         </button>
         <div class="dropdown-menu dropdown-menu-end">
             <!-- item-->
             <h6 class="dropdown-header">Welcome {{ auth()->user()->name }}!</h6>
             <a class="dropdown-item" href="pages-profile.html"><i
                     class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                     class="align-middle">Profile</span></a>
             <a class="dropdown-item" href="apps-chat.html"><i
                     class="mdi mdi-message-text-outline text-muted fs-16 align-middle me-1"></i> <span
                     class="align-middle">Messages</span></a>
             <a class="dropdown-item" href="apps-tasks-kanban.html"><i
                     class="mdi mdi-calendar-check-outline text-muted fs-16 align-middle me-1"></i> <span
                     class="align-middle">Taskboard</span></a>
             <a class="dropdown-item" href="pages-faqs.html"><i
                     class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i> <span
                     class="align-middle">Help</span></a>
             <div class="dropdown-divider"></div>
             <a class="dropdown-item" href="pages-profile.html"><i
                     class="mdi mdi-wallet text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Balance :
                     <b>$5971.67</b></span></a>
             <a class="dropdown-item" href="pages-profile-settings.html"><span
                     class="badge bg-success-subtle text-success mt-1 float-end">New</span><i
                     class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span
                     class="align-middle">Settings</span></a>
             <a class="dropdown-item" href="auth-lockscreen-basic.html"><i
                     class="mdi mdi-lock text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Lock
                     screen</span></a>
             <a class="dropdown-item" href="auth-logout-basic.html"><i
                     class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle"
                     data-key="t-logout">Logout</span></a>
         </div>
     </div>
     <div id="scrollbar">
         <div class="container-fluid">


             <div id="two-column-menu">
             </div>
             <!-- resources/views/layouts/partials/sidebar.blade.php -->
             <ul class="navbar-nav" id="navbar-nav">
                 <!-- Dashboard -->
                 @hasRoutePermission('admin.dashboard')
                     <li class="nav-item">
                         <a class="nav-link menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                             href="{{ route('admin.dashboard') }}">
                             <i class="ri-dashboard-line"></i> <span data-key="t-dashboards">Dashboard</span>
                         </a>
                     </li>
                 @endhasRoutePermission

                 <!-- Orders -->
                 @hasRoutePermission('admin.orders.list')
                     <li class="nav-item">
                         <a class="nav-link menu-link {{ request()->routeIs('admin.orders*', 'admin.order*') ? 'active' : '' }}"
                             href="{{ route('admin.orders.list') }}">
                             <i class="ri-shopping-bag-3-line"></i> <span data-key="t-widgets">Orders</span>
                         </a>
                     </li>
                 @endhasRoutePermission

                 <!-- Sales Report -->
                 @hasRoutePermission('admin.sales.report')
                     <li class="nav-item">
                         <a class="nav-link menu-link {{ request()->routeIs('admin.sales.report*') ? 'active' : '' }}"
                             href="{{ route('admin.sales.report') }}">
                             <i class="ri-pages-line"></i> <span data-key="t-widgets">Sales Report</span>
                         </a>
                     </li>
                 @endhasRoutePermission

                 <!-- Categories -->
                 @hasRoutePermission('admin.categories.list')
                     <li class="nav-item">
                         <a class="nav-link menu-link {{ request()->routeIs('admin.categories*', 'admin.category*') ? 'active' : '' }}"
                             href="{{ route('admin.categories.list') }}">
                             <i class="ri-list-unordered"></i> <span data-key="t-widgets">Categories</span>
                         </a>
                     </li>
                 @endhasRoutePermission

                 <!-- Products -->
                 @hasRoutePermission('admin.products.list')
                     <li class="nav-item">
                         <a class="nav-link menu-link {{ request()->routeIs('admin.products*', 'admin.product*') ? 'active' : '' }}"
                             href="{{ route('admin.products.list') }}">
                             <i class="ri-gamepad-line"></i> <span data-key="t-widgets">Products</span>
                         </a>
                     </li>
                 @endhasRoutePermission

                 <!-- Gift Card Inventory -->
                 @hasRoutePermission('admin.code.list')
                     <li class="nav-item">
                         <a class="nav-link menu-link {{ request()->routeIs('admin.code*') ? 'active' : '' }}"
                             href="{{ route('admin.code.list') }}">
                             <i class="ri-gift-line"></i> <span data-key="t-widgets">Gift Card Inventory</span>
                         </a>
                     </li>
                 @endhasRoutePermission

                 <!-- Customer Management -->
                 @hasRoutePermission('admin.customers.list')
                     <li class="nav-item">
                         <a class="nav-link menu-link {{ request()->routeIs('admin.customers*', 'admin.customer*') ? 'active' : '' }}"
                             href="{{ route('admin.customers.list') }}">
                             <i class="ri-user-3-line"></i> <span data-key="t-widgets">Customer Management</span>
                         </a>
                     </li>
                 @endhasRoutePermission

                 <!-- Wallet Transactions -->
                 @hasRoutePermission('admin.wallet.list')
                     <li class="nav-item">
                         <a class="nav-link menu-link {{ request()->routeIs('admin.wallet*') ? 'active' : '' }}"
                             href="{{ route('admin.wallet.list') }}">
                             <i class="ri-wallet-line"></i> <span data-key="t-widgets">Wallet Transactions</span>
                         </a>
                     </li>
                 @endhasRoutePermission

                 <!-- Users -->
                 @hasRoutePermission('admin.users.list')
                     <li class="nav-item">
                         <a class="nav-link menu-link {{ request()->routeIs('admin.users*', 'admin.user*') ? 'active' : '' }}"
                             href="{{ route('admin.users.list') }}">
                             <i class="ri-user-settings-line"></i> <span data-key="t-widgets">Users</span>
                         </a>
                     </li>
                 @endhasRoutePermission

                 <!-- Role Permissions -->
                 @if (auth()->user()->hasRole('admin'))
                     <li class="nav-item">
                         <a class="nav-link menu-link {{ request()->routeIs('admin.permissions*') ? 'active' : '' }}"
                             href="{{ route('admin.permissions.list') }}">
                             <i class="ri-shield-user-line"></i> <span data-key="t-widgets">Role Permissions</span>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link menu-link {{ request()->routeIs('admin.logs*') ? 'active' : '' }}"
                             href="{{ route('admin.logs.list') }}">
                             <i class=" ri-history-line"></i> <span data-key="t-widgets">Logs & History</span>
                         </a>
                     </li>
                 @endif

                 <!-- Settings (Collapsible) -->
                 @if (auth()->check() &&
                         auth()->user()->hasPermissionTo(\App\Services\PermissionMap::getPermission('admin.home_sliders.list')))
                     <li class="nav-item">
                         <a class="nav-link settings {{ request()->routeIs('admin.home_sliders*', 'admin.home_slider*', 'admin.footer*') ? 'active' : '' }}"
                             href="#sidebarSettings" data-bs-toggle="collapse" role="button" aria-expanded="false"
                             aria-controls="sidebarSettings">
                             <i class="ri-settings-2-line"></i>
                             <span data-key="t-settings">Settings</span>
                         </a>
                         <div class="collapse menu-dropdown {{ request()->routeIs('admin.home_sliders*', 'admin.home_slider*', 'admin.footer*') ? 'show' : '' }}"
                             id="sidebarSettings">
                             <ul class="nav nav-sm flex-column">
                                 @hasRoutePermission('admin.home_sliders.list')
                                     <li class="nav-item">
                                         <a href="{{ route('admin.home_sliders.list') }}"
                                             class="nav-link {{ request()->routeIs('admin.home_sliders*', 'admin.home_slider*') ? 'active' : '' }}"
                                             data-key="t-home-sliders">
                                             Home Sliders
                                         </a>
                                     </li>
                                 @endhasRoutePermission
                                 <li class="nav-item">
                                     <a href="{{ route('admin.footer.index') }}"
                                         class="nav-link {{ request()->routeIs('admin.footer*') ? 'active' : '' }}"
                                         data-key="t-footer">
                                         Footer Management
                                     </a>
                                 </li>
                             </ul>
                         </div>
                     </li>
                 @endif
             </ul>
         </div>
         <!-- Sidebar -->
     </div>

     <div class="sidebar-background"></div>
 </div>
 <!-- Left Sidebar End -->
 <!-- Vertical Overlay-->
 <div class="vertical-overlay"></div>
