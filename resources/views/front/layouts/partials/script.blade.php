<!--<< All JS Plugins >>-->
<script src="{{ URL('front/assets') }}/js/jquery-3.7.1.min.js"></script>
<!--<< Viewport Js >>-->
<script src="{{ URL('front/assets') }}/js/viewport.jquery.js"></script>
<!--<< Bootstrap Js >>-->
<script src="{{ URL('front/assets') }}/js/bootstrap.bundle.min.js"></script>
<script src="{{ URL('front/assets') }}/js/jquery.nice-select.min.js"></script>
<!--<< Waypoints Js >>-->
<script src="{{ URL('front/assets') }}/js/jquery.waypoints.js"></script>
<!--<< Counterup Js >>-->
<script src="{{ URL('front/assets') }}/js/jquery.counterup.min.js"></script>
<!--<< Swiper Slider Js >>-->
<script src="{{ URL('front/assets') }}/js/swiper-bundle.min.js"></script>
<!--<< MeanMenu Js >>-->
<script src="{{ URL('front/assets') }}/js/jquery.meanmenu.min.js"></script>
<!--<< Magnific Popup Js >>-->
<script src="{{ URL('front/assets') }}/js/jquery.magnific-popup.min.js"></script>
<!--<< Wow Animation Js >>-->
<script src="{{ URL('front/assets') }}/js/wow.min.js"></script>
<!--<< Main.js >>-->
<script src="{{ URL('front/assets') }}/js/main.js"></script>
<script>
    $(document).ready(function() {
        $('#search-input').on('keyup blur change', function() {
            let query = $(this).val();

            if (query.length > 0) {
                $.ajax({
                    url: "{{ route('product.autocomplete') }}",
                    type: "GET",
                    data: {
                        term: query
                    },
                    success: function(data) {
                        let suggestionBox = $('#suggestion-box');
                        suggestionBox.empty().show();

                        if (data.length > 0) {
                            $.each(data, function(i, product) {
                                suggestionBox.append(`
                                <li style="padding: 8px; cursor:pointer; display:flex; align-items:center; border-bottom:1px solid #eee;">
                                    <a href="${product.url}" style="display: flex; align-items: center; text-decoration:none; color:#333;">
                                        <img src="${product.image}" width="40" height="40" style="margin-right:10px; border-radius:4px;">
                                        <span>${product.name}</span>
                                    </a>
                                </li>
                            `);
                            });
                        } else {
                            suggestionBox.append(
                                '<li style="padding: 8px;">No products found</li>');
                        }
                    }
                });
            } else {
                $('#suggestion-box').hide();
            }
        });

        // Hide on click outside
        $(document).click(function(e) {
            if (!$(e.target).closest('.search-field-holder').length) {
                $('#suggestion-box').hide();
            }
        });
    });
</script>
@yield('scripts')
