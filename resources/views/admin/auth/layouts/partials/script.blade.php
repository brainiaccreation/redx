 <!-- JAVASCRIPT -->
 <script src="{{ asset('admin/assets') }}/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
 <script src="{{ asset('admin/assets') }}/libs/simplebar/simplebar.min.js"></script>
 <script src="{{ asset('admin/assets') }}/libs/node-waves/waves.min.js"></script>
 <script src="{{ asset('admin/assets') }}/libs/feather-icons/feather.min.js"></script>
 <script src="{{ asset('admin/assets') }}/js/pages/plugins/lord-icon-2.1.0.js"></script>
 <script src="{{ asset('admin/assets') }}/js/plugins.js"></script>

 <!-- particles js -->
 <script src="{{ asset('admin/assets') }}/libs/particles.js/particles.js"></script>
 <!-- particles app js -->
 <script src="{{ asset('admin/assets') }}/js/pages/particles.app.js"></script>
 <!-- password-addon init -->
 <script src="{{ asset('admin/assets') }}/js/pages/password-addon.init.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
     integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
     crossorigin="anonymous" referrerpolicy="no-referrer"></script>
 <script>
     @if (Session::has('success'))
         toastr.options = {
             "closeButton": true,
             "progressBar": true,
             "positionClass": "toast-bottom-center",
             "showEasing": "swing",
         }
         toastr.success("{{ session('success') }}");
     @endif

     @if (Session::has('error'))
         toastr.options = {
             "closeButton": true,
             "progressBar": true,
             "positionClass": "toast-bottom-center",
             "showEasing": "swing",
         }
         toastr.error("{{ session('error') }}");
     @endif

     @if (Session::has('info'))
         toastr.options = {
             "closeButton": true,
             "progressBar": true
         }
         toastr.info("{{ session('info') }}");
     @endif

     @if (Session::has('warning'))
         toastr.options = {
             "closeButton": true,
             "progressBar": true
         }
         toastr.warning("{{ session('warning') }}");
     @endif
 </script>
