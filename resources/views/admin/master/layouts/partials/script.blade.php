 <!-- JAVASCRIPT -->
 <script src="{{ URL('admin/assets') }}/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
 <script src="{{ URL('admin/assets') }}/libs/simplebar/simplebar.min.js"></script>
 <script src="{{ URL('admin/assets') }}/libs/node-waves/waves.min.js"></script>
 <script src="{{ URL('admin/assets') }}/libs/feather-icons/feather.min.js"></script>
 <script src="{{ URL('admin/assets') }}/js/pages/plugins/lord-icon-2.1.0.js"></script>
 <script src="{{ URL('admin/assets') }}/js/plugins.js"></script>

 <!-- apexcharts -->
 <script src="{{ URL('admin/assets') }}/libs/apexcharts/apexcharts.min.js"></script>

 <!-- Vector map-->
 <script src="{{ URL('admin/assets') }}/libs/jsvectormap/jsvectormap.min.js"></script>
 <script src="{{ URL('admin/assets') }}/libs/jsvectormap/maps/world-merc.js"></script>

 <!--Swiper slider js-->
 <script src="{{ URL('admin/assets') }}/libs/swiper/swiper-bundle.min.js"></script>

 <!-- Dashboard init -->
 <script src="{{ URL('admin/assets') }}/js/pages/dashboard-ecommerce.init.js"></script>
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
     integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
     crossorigin="anonymous" referrerpolicy="no-referrer"></script>
 <!-- App js -->
 <script src="{{ URL('admin/assets') }}/js/app.js"></script>
 <script src="{{ URL('admin/assets') }}/js/jquery-3.7.1.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
 <script>
     $(document).on("click", '.show_confirm', function(event) {
         var form = $(this).closest("form");
         var name = $(this).data("name");
         event.preventDefault();
         swal({
             title: "Are you sure you want to delete this record?",
             text: "If you delete this, it will be gone forever.",
             icon: "warning",
             buttons: {
                 cancel: {
                     text: "Cancel",
                     visible: true,
                     className: "custom-cancel-btn",
                 },
                 confirm: {
                     text: "OK",
                     closeModal: true,
                     className: "custom-confirm-btn"
                 }
             },
             dangerMode: true,
         }).then((willDelete) => {
             if (willDelete) {
                 form.submit();
             }
         });
     });
 </script>
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
             "progressBar": true
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
 @yield('scripts')
