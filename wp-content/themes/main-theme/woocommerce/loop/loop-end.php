<?php
/**
 * Product Loop End
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-end.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
</ul>
<script type="text/javascript">
	$(document).ready(function() {
		$(".slider .tt-product").addClass('owl-carousel').addClass('owl-theme')
		$(".slider .tt-product").find('.col-sm-6').removeClass (function (index, className) {
		    return (className.match (/(^|\s)col-\S+/g) || []).join(' ');
		});

		$('.tt-product').not('.slider').find('.col-sm-6').css('margin-right', '20px');

        $(".slider .tt-product").owlCarousel({
            loop: false,
            margin: 30,
            nav: false,
            dots: false,
            autoplay: false,
            autoplayTimeout: 1000,
            autoplayHoverPause: true,
            autoplaySpeed: 1000,
            navSpeed: 1000,
            dotsSpeed: 1000,
            lazyLoad: true,
            responsive: {
                0: {
                    items: 1,
                    nav: false,
                    dots: false
                },
                480: {
                    items: 2,
                    nav: false,
                    dots: false
                },
                768: {
                    items: 2,
                },
                992: {
                    items: 2
                },
                1200: {
                    items: 3
                },
                1600: {
                    items: 3
                }
            },
            onInitialized: function() {
                var count = $("#product_module1504983008053 .tt-product .owl-item.active").length;
                if (count == 1) {
                    $("#product_module1504983008053 .tt-product .owl-item").removeClass('first');
                    $("#product_module1504983008053 .tt-product .active").addClass('first');
                } else {
                    $("#product_module1504983008053 .tt-product .owl-item").removeClass('first');
                    $("#product_module1504983008053 .tt-product .owl-item.active:first").addClass('first');
                }
            },
            onTranslated: function() {
                var count = $("#product_module1504983008053 .tt-product .owl-item.active").length;
                if (count == 1) {
                    $("#product_module1504983008053 .tt-product .owl-item").removeClass('first');
                    $("#product_module1504983008053 .tt-product .active").addClass('first');
                } else {
                    $("#product_module1504983008053 .tt-product .owl-item").removeClass('first');
                    $("#product_module1504983008053 .tt-product .owl-item.active:first").addClass('first');
                }
            }
        });
    });
</script>