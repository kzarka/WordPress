jQuery(window).trigger('resize').trigger('scroll');
// ---------------------------------------------- //
// Global Read-Only Variables (DO NOT CHANGE!)
// ---------------------------------------------- //
var doc = document.documentElement;
doc.setAttribute('data-useragent', navigator.userAgent);

var wow_enable = false,
    fullwidth = 1200,
    iOS = check_iOS(),
    _event = (iOS) ? 'click, mousemove' : 'click',
    globalTimeout = null,
    load_flag = false,
    page_load = 1,
    shop_load = false,
    archive_page = 1,
    infinitiAjax = false,
    _single_variations = [],
    _lightbox_variations = [],
    searchProducts = null;

/* =========== Document ready ==================== */
jQuery(document).ready(function($){
"use strict";

var _nasa_in_mobile = $('input[name="nasa_mobile_layout"]').length ? true : false;

// $(window).stellar();

// Init Wow effect
if ($('input[name="nasa-enable-wow"]').length === 1 && $('input[name="nasa-enable-wow"]').val() === '1') {
    wow_enable = true;
    $('body').addClass('nasa-enable-wow');
    new WOW({mobile: false}).init();
}

$('body #nasa-before-load').fadeOut(1000);
$('body').addClass('nasa-body-loaded');

/**
 * Load Content Static Blocks
 */
if (
    typeof nasa_ajax_params !== 'undefined' &&
    typeof nasa_ajax_params.wc_ajax_url !== 'undefined'
) {
    var _urlAjaxStaticContent = nasa_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', 'nasa_static_content');

    var _data_static_content = {};
    var _call_static_content = false;
    
    if ($('input[name="nasa_yith_wishlist_actived"]').length) {
        _data_static_content['reload_yith_wishlist'] = '1';
        _call_static_content = true;
    }
    
    if ($('input[name="nasa-caching-enable"]').length && $('input[name="nasa-caching-enable"]').val() === '1') {
        if ($('.nasa-login-register-ajax').length) {
            _data_static_content['reload_my_account'] = '1';
            _call_static_content = true;
        }
        
        if ($('.nasa-hello-acc').length) {
            _data_static_content['reload_login_register'] = '1';
            _call_static_content = true;
        }
    }
    
    if ($('#nasa_popup_newsletter').length) {
        var et_popup_closed = $.cookie('nasatheme_popup_closed');
        if (et_popup_closed !== 'do-not-show') {
            _call_static_content = true;
            _data_static_content.popup_newsletter = '1';
        }
    }
    
    if (_call_static_content) {
        $.ajax({
            url: _urlAjaxStaticContent,
            type: 'post',
            data: _data_static_content,
            cache: false,
            success: function(result){
                if (typeof result !== 'undefined' && result.success === '1') {
                    $.each(result.content, function (key, value) {
                        if ($(key).length) {
                            $(key).replaceWith(value);

                            if (key === '#nasa-wishlist-sidebar-content') {
                                initWishlistIcons($);
                            }
                            
                            if (key === '#nasa_popup_newsletter') {
                                init_popup_newsletter($);
                            }
                        }
                    });
                }

                $('body').trigger('nasa_after_load_static_content');
            }
        });
    }
}

/**
 * Check wpadminbar
 */
if ($('#wpadminbar').length) {
    $("head").append('<style media="screen">#wpadminbar {position: fixed !important;}</style>');
    
    var _mobileView = $('.nasa-check-reponsive.nasa-switch-check').length && $('.nasa-check-reponsive.nasa-switch-check').width() === 1 ? true : false;
    var _inMobile = $('body').hasClass('nasa-in-mobile') ? true : false;
    
    var height_adminbar = $('#wpadminbar').height();
    
    $('#cart-sidebar, #nasa-wishlist-sidebar, #nasa-viewed-sidebar, #nasa-quickview-sidebar, .nasa-search-space .nasa-show-search-form .search-wrapper, .nasa-side-sidebar').css({'top' : height_adminbar});
    
    if (_mobileView || _inMobile) {
        $('.col-sidebar').css({'top' : height_adminbar});
    }
    
    $(window).resize(function() {
        _mobileView = $('.nasa-check-reponsive.nasa-switch-check').length && $('.nasa-check-reponsive.nasa-switch-check').width() === 1 ? true : false;
        
        height_adminbar = $('#wpadminbar').height();
        
        $('#cart-sidebar, #nasa-wishlist-sidebar, #nasa-viewed-sidebar, #nasa-quickview-sidebar, .nasa-top-cat-filter-wrap-mobile, .nasa-side-sidebar').css({'top' : height_adminbar});
        
        if (_mobileView || _inMobile) {
            $('.col-sidebar').css({'top' : height_adminbar});
        }
    });
}

// Fix vertical mega menu
if ($('.vertical-menu-wrapper').length){
    $('.vertical-menu-wrapper').attr('data-over', '0');

    var width_default = 200;
    
    $('.vertical-menu-container').each(function() {
        var _this = $(this);
        var _h_vertical = $(_this).height();
        $(_this).find('.nasa-megamenu >.nav-dropdown').each(function(){
            $(this).find('>.sub-menu').css({'min-height': _h_vertical});
        });
    });

    $('body').on('mousemove', '.vertical-menu-container .nasa-megamenu', function(){
        var _wrap = $(this).parents('.vertical-menu-wrapper');

        var _row = $(_wrap).parents('.row').length ? $(_wrap).parents('.row') : $(_wrap).parents('.nasa-row');
        var _w_mega, _w_mega_df, _w_ss;
        var total_w = $(_row).length ? $(_row).width() : 900;
        
        $(_wrap).find('.nasa-megamenu').each(function(){
            var _this = $(this);
            
            var current_w = $(_this).outerWidth();
            _w_mega = _w_mega_df = total_w - current_w;
        
            if ($(_this).hasClass('cols-5') || $(_this).hasClass('fullwidth')){
                _w_mega = _w_mega - 20;
            } else {
                if ($(_this).hasClass('cols-2')){
                    _w_mega = _w_mega / 5 * 2 + 50;
                    _w_ss = width_default * 2;
                    _w_mega = (_w_ss > _w_mega && _w_ss < _w_mega_df) ? _w_ss : _w_mega;
                }
                else if ($(_this).hasClass('cols-3')){
                    _w_mega = _w_mega / 5 * 3 + 50;
                    _w_ss = width_default * 3;
                    _w_mega = (_w_ss > _w_mega && _w_ss < _w_mega_df) ? _w_ss : _w_mega;
                }
                else if ($(_this).hasClass('cols-4')){
                    _w_mega = _w_mega / 5 * 4 + 50;
                    _w_ss = width_default * 4;
                    _w_mega = (_w_ss > _w_mega && _w_ss < _w_mega_df) ? _w_ss : _w_mega;
                }
            }
            
            $(_this).find('>.nav-dropdown').css({'width': _w_mega});
        });
    });

    $('body').on('mouseover', '.vertical-menu-wrapper .menu-item-has-children.default-menu', function(){
        var _wrap = $(this).parents('.vertical-menu-wrapper');
        $(this).find('> .nav-dropdown > .sub-menu').css({'width': width_default});
        
        var _row = $(_wrap).parents('.row').length ? $(_wrap).parents('.row') : $(_wrap).parents('.nasa-row');

        var _w_mega, _w_mega_df, _w_ss;
        var total_w = $(_row).length ? $(_row).width() : 900;
        
        $(_wrap).find('.nasa-megamenu').each(function(){
            var _this = $(this);
            
            var current_w = $(_this).outerWidth();
            _w_mega = _w_mega_df = total_w - current_w;
            
            if ($(_this).hasClass('cols-5') || $(_this).hasClass('fullwidth')){
                _w_mega = _w_mega - 20;
            } else {
                if ($(_this).hasClass('cols-2')){
                    _w_mega = _w_mega / 5 * 2 + 50;
                    _w_ss = width_default * 2;
                    _w_mega = (_w_ss > _w_mega && _w_ss < _w_mega_df) ? _w_ss : _w_mega;
                }
                else if ($(_this).hasClass('cols-3')){
                    _w_mega = _w_mega / 5 * 3 + 50;
                    _w_ss = width_default * 3;
                    _w_mega = (_w_ss > _w_mega && _w_ss < _w_mega_df) ? _w_ss : _w_mega;
                }
                else if ($(_this).hasClass('cols-4')){
                    _w_mega = _w_mega / 5 * 4 + 50;
                    _w_ss = width_default * 4;
                    _w_mega = (_w_ss > _w_mega && _w_ss < _w_mega_df) ? _w_ss : _w_mega;
                }
            }
            $(_this).find('>.nav-dropdown').css({'width': _w_mega});
        });
    });
    
    $('body').on('mouseleave', '.vertical-menu-wrapper', function(){
        $(this).attr('data-over', '0');
    });
}

/**
 * For Header Builder Icon menu mobile switcher
 */
if ($('.header-type-builder').length && $('.nasa-nav-extra-warp').length <= 0) {
    $('.static-position').append('<div class="nasa-nav-extra-warp nasa-show"><div class="desktop-menu-bar"><div class="mini-icon-mobile"><a href="javascript:void(0);" class="nasa-mobile-menu_toggle bar-mobile_toggle"><span class="fa fa-bars"></span></a></div></div></div>');
}

$('body').on('click', '.nasa-mobile-menu_toggle', function(){
    initMainMenuVertical($);
    
    if ($('#mobile-navigation').length) {
        if ($('#mobile-navigation').attr('data-show') !== '1') {
            if ($('#nasa-menu-sidebar-content').hasClass('nasa-dark')) {
                $('.black-window').addClass('nasa-transparent');
            }
            
            $('.black-window').show().addClass('desk-window');
            
            if ($('#nasa-menu-sidebar-content').length && !$('#nasa-menu-sidebar-content').hasClass('nasa-active')) {
                $('#nasa-menu-sidebar-content').addClass('nasa-active');
            }
            
            $('#mobile-navigation').attr('data-show', '1');
        } else {
            $('.black-window').trigger('click');
        }
    }
});

// Accordion menu
/**
 * Accordion Mobile Menu
 */
$('body').on('click', '.nasa-menu-accordion .li_accordion > a.accordion', function(e) {
    e.preventDefault();
    var ths = $(this).parent();
    var cha = $(ths).parent();
    if (!$(ths).hasClass('active')) {
        var c = $(cha).children('li.active');
        $(c).removeClass('active').children('.nav-dropdown-mobile').css({height:'auto'}).slideUp(300);
        $(ths).children('.nav-dropdown-mobile').slideDown(300).parent().addClass('active');
    } else {
        $(ths).find('>.nav-dropdown-mobile').slideUp(300).parent().removeClass('active');
    }
    return false;
});

/**
 * Accordion Element
 */
if ($('.nasa-accordion .li_accordion > a.accordion').length){
    $('body').on('click', '.nasa-accordion .li_accordion > a.accordion', function() {
        var _show = $(this).attr('data-class_show'); // 'pe-7s-plus'
        var _hide = $(this).attr('data-class_hide'); // 'pe-7s-less'
        var ths = $(this).parent();
        var dad = $(ths).parent();
        if (!$(ths).hasClass('active')) {
            $(dad).removeClass('current-cat-parent').removeClass('current-cat');
            var c = $(dad).children('li.active');
            $(c).removeClass('active').children('.children').slideUp(300);
            $(ths).addClass('active').children('.children').slideDown(300);
            
            if (_show && _hide) {
                $(c).find('>a.accordion>span').removeClass(_hide).addClass(_show);
                $(this).find('span').removeClass(_show).addClass(_hide);
            }
        } else {
            $(ths).removeClass('active').children('.children').slideUp(300);
            if (_show && _hide) {
                $(this).find('span').removeClass(_hide).addClass(_show);
            }
        }
        
        return false;
    });
}

/*
 * Quick view
 */
var setMaxHeightQVPU;
$('body').on('click', '.quick-view', function(e) {
    $.magnificPopup.close();
    
    var _urlAjax = null;
    if (
        typeof nasa_ajax_params !== 'undefined' &&
        typeof nasa_ajax_params.wc_ajax_url !== 'undefined'
    ) {
        _urlAjax = nasa_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', 'nasa_quick_view');
    }
    
    if (_urlAjax) {
    
        var _this = $(this);

        var _product_type = $(_this).attr('data-product_type');

        if ($(_this).parents('.product-item').length) {
            if (_product_type !== 'woosb') {
                var _product_item = $(_this).parents('.product-item');
                if (!$(_product_item).hasClass('nasa-quickview-special')) {
                    if (!$(_product_item).hasClass('style-1')) {
                        $(_product_item).find('.product-inner').css({opacity: 0.3});
                        $(_product_item).find('.product-inner').after('<div class="nasa-loader"></div>');
                    }
                } else {
                    $(_product_item).append('<div class="nasa-loader" style="top:50%"></div>');
                }
            }
        }

        if ($(_this).parents('.item-product-widget').length) {
            if (_product_type !== 'woosb') {
                $(_this).parents('.item-product-widget').append('<div class="nasa-light-fog"></div><div class="nasa-loader"></div>');
            }
        }
        
        if (!$(_this).hasClass('loading')) {
            $(_this).addClass('loading');
        }

        if (_product_type === 'woosb' && typeof $(_this).attr('data-href') !== 'undefined') {
            window.location.href = $(_this).attr('data-href');
        } else {

            var _wrap = $(_this).parents('.product-item'),
                product_item = $(_wrap).find('.product-inner'),
                product_img = $(product_item).find('.product-img'),
                product_id = $(_this).attr('data-prod'),
                _wishlist = ($(_this).attr('data-from_wishlist') === '1') ? '1' : '0';

            if ($(_wrap).length <= 0) {
                _wrap = $(_this).parents('.item-product-widget');
            }

            if ($(_wrap).length <= 0) {
                _wrap = $(_this).parents('.wishlist-item-warper');
            }

            var _data = {
                product: product_id,
                nasa_wishlist: _wishlist
            };

            var sidebar_holder = $('#nasa-quickview-sidebar').length === 1 ? true : false;
            _data.quickview = $('#nasa-quickview-sidebar').length === 1 ? 'sidebar' : 'popup';

            $.ajax({
                url : _urlAjax,
                type: 'post',
                dataType: 'json',
                data: _data,
                cache: false,
                beforeSend: function(){
                    if (sidebar_holder) {
                        $('#nasa-quickview-sidebar #nasa-quickview-sidebar-content').html('<div class="nasa-loader"></div>');
                        $('.black-window').fadeIn(200).addClass('desk-window');
                        
                        $('#nasa-viewed-sidebar').removeClass('nasa-active');
                        
                        if (!$('#nasa-quickview-sidebar').hasClass('nasa-active')) {
                            $('#nasa-quickview-sidebar').addClass('nasa-active');
                        }
                    }

                    if ($('.nasa-static-wrap-cart-wishlist').length && $('.nasa-static-wrap-cart-wishlist').hasClass('nasa-active')) {
                        $('.nasa-static-wrap-cart-wishlist').removeClass('nasa-active');
                    }
                },
                success: function(response){
                    // Sidebar hoder
                    if (sidebar_holder) {
                        $('#nasa-quickview-sidebar #nasa-quickview-sidebar-content').html('<div class="product-lightbox hidden-tag">' + response.content + '</div>');
                        setTimeout(function() {
                            $('#nasa-quickview-sidebar #nasa-quickview-sidebar-content .product-lightbox').fadeIn(1000);
                        }, 600);
                    }

                    // Popup classical
                    else {
                        $.magnificPopup.open({
                            mainClass: 'my-mfp-zoom-in',
                            removalDelay: 350,
                            items: {
                                src: '<div class="product-lightbox">' + response.content + '</div>',
                                type: 'inline'
                            },
                            tClose: $('input[name="nasa-close-string"]').val(),
                            callbacks: {
                                afterClose: function() {
                                    var buttons = $(_this).parents('.product-interactions');
                                    $(buttons).addClass('hidden-tag');
                                    
                                    setTimeout(function(){
                                        $(buttons).removeClass('hidden-tag');
                                    }, 100);
                                    
                                    if (typeof setMaxHeightQVPU !== 'undefined') {
                                        clearInterval(setMaxHeightQVPU);
                                    }
                                }
                            }
                        });

                        $('.black-window').trigger('click');
                    }

                    _lightbox_variations[0] = {
                        'quickview_gallery': $('.product-lightbox').find('.nasa-product-gallery-lightbox').html()
                    };

                    if ($(_this).hasClass('nasa-view-from-wishlist')){
                        $('.wishlist-item').animate({opacity: 1}, 500);
                        if (!sidebar_holder) {
                            $('.wishlist-close a').trigger('click');
                        }
                    }

                    $(_wrap).find('.nasa-loader, .please-wait, .color-overlay, .nasa-dark-fog, .nasa-light-fog').remove();
                    $(_this).removeClass('loading');
                    
                    if ($(product_img).length && $(product_item).length) {
                        $(product_img).removeAttr('style');
                        $(product_item).animate({opacity: 1}, 500);
                    }

                    var formLightBox = $('.product-lightbox').find('.variations_form');
                    if ($(formLightBox).find('.single_variation_wrap').length === 1) {
                        $(formLightBox).find('.single_variation_wrap').hide();
                        $(formLightBox).wc_variation_form_lightbox(response.mess_unavailable);
                        $(formLightBox).find('select').change();
                        if ($(formLightBox).find('.variations select option[selected="selected"]').length) {
                            $(formLightBox).find('.variations .reset_variations').css({'visibility': 'visible'}).show();
                        }
                        if ($('input[name="nasa_attr_ux"]').length === 1 && $('input[name="nasa_attr_ux"]').val() === '1') {
                            $(formLightBox).nasa_attr_ux_variation_form();
                        }
                    }

                    setTimeout(function() {
                        loadLightboxCarousel($);
                        loadTipTop($);
                    }, 600);

                    setTimeout(function() {
                        $(window).resize();
                    }, 800);

                    if (!sidebar_holder) {
                        setMaxHeightQVPU = setInterval(function() {
                            var _h_l = $('.product-lightbox .product-img').outerHeight();
                            
                            $('.product-lightbox .product-quickview-info').css({
                                'max-height': _h_l,
                                'overflow-y': 'auto'
                            });
                            
                            if (!$('.product-lightbox .product-quickview-info').hasClass('nasa-active')) {
                                $('.product-lightbox .product-quickview-info').addClass('nasa-active');
                            }
                            
                            if (!$('.product-lightbox').hasClass('nasa-active')) {
                                $('.product-lightbox').addClass('nasa-active');
                            }
                            
                            if (_nasa_in_mobile) {
                                clearInterval(setMaxHeightQVPU);
                            }
                        }, 1000);
                    }

                    // loadingCarousel($);
                    if ($('.nasa-quickview-product-deal-countdown').length) {
                        loadCountDown($);
                    }
                }
            });
        }
    }
    
    e.preventDefault();
});

$(".gallery a[href$='.jpg'], .gallery a[href$='.jpeg'], .featured-item a[href$='.jpeg'], .featured-item a[href$='.gif'], .featured-item a[href$='.jpg'], .page-featured-item .slider > a, .page-featured-item .page-inner a > img, .gallery a[href$='.png'], .gallery a[href$='.jpeg'], .gallery a[href$='.gif']").parent().magnificPopup({
    delegate: 'a',
    type: 'image',
    tLoading: '<div class="please-wait dark"><span></span><span></span><span></span></div>',
    tClose: $('input[name="nasa-close-string"]').val(),
    mainClass: 'my-mfp-zoom-in',
    gallery: {
        enabled: true,
        navigateByImgClick: true,
        preload: [0,1]
    },
    image: {
        tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
    }
});

var _loadingBeforeResize = setTimeout(function() {
    /**
     * Fix height for full width to side
     */
    loadHeightFullWidthToSide($);

    /**
     * Main menu Reponsive
     */
    loadResponsiveMainMenu($);
    
    /**
     * Change quick view | add to cart
     */
    init_product_quickview_addtocart($, true);
}, 100);

var _load_equal_height_columns = setTimeout(function() {
    /**
     * Equal height columns
     */
    row_equal_height_columns($);
}, 100);

var _load_equal_height_columns_scroll;

// **********************************************************************// 
// ! Fixed header
// **********************************************************************//
// var _oldTop = 0;
var _menuHeight = $('.mobile-menu').length ? $('.mobile-menu').height() + 50 : 0;
var headerHeight = $('.header-wrapper').height() + 50;
$(window).scroll(function(){
    var scrollTop = $(this).scrollTop();
    
    if ($('input[name="nasa_fixed_single_add_to_cart"]').length && $('input[name="nasa_fixed_single_add_to_cart"]').val() === '1') {
        if ($('.nasa-product-details-page .single_add_to_cart_button').length) {
            var addToCart = $('.nasa-product-details-page .product-details') || $('.nasa-product-details-page .single_add_to_cart_button');
            
            if ($(addToCart).length) {
                var addToCartOffset = $(addToCart).offset();

                if (scrollTop >= addToCartOffset.top) {
                    if (!$('body').hasClass('has-nasa-cart-fixed')) {
                        $('body').addClass('has-nasa-cart-fixed');
                    }
                } else {
                    $('body').removeClass('has-nasa-cart-fixed');
                }
            }
        }
    }
    
    if (
        $('#nasa-wrap-archive-loadmore.nasa-infinite-shop').length &&
        $('#nasa-wrap-archive-loadmore.nasa-infinite-shop').find('.nasa-archive-loadmore').length === 1
    ) {
        var infinitiOffset = $('#nasa-wrap-archive-loadmore').offset();
        
        if (!infinitiAjax) {
            if (scrollTop + $(window).height() >= infinitiOffset.top) {
                infinitiAjax = true;
                $('#nasa-wrap-archive-loadmore.nasa-infinite-shop').find('.nasa-archive-loadmore').trigger('click');
            }
        }
    }
    
    var _inMobile = $('.nasa-check-reponsive.nasa-switch-check').length && $('.nasa-check-reponsive.nasa-switch-check').width() === 1 ? true : false;
    
    if ($('body').find('.nasa-header-sticky').length) {
        var fixedHeader = $('.sticky-wrapper');
        var fix_top = 0;
        if ($('#wpadminbar').length) {
            fix_top = $('#wpadminbar').height();
        }
        var _heightFixed = fixedHeader.outerHeight();
        
        if (scrollTop > headerHeight){
            if (!fixedHeader.hasClass('fixed-already')) {
                fixedHeader.stop().addClass('fixed-already');
                $('.nasa-header-sticky').css({'margin-bottom': _heightFixed});
                if (!fixedHeader.hasClass('fixed-trasition')) {
                    setTimeout(function() {
                        fixedHeader.css({top: fix_top});
                        fixedHeader.addClass('fixed-trasition');
                    }, 10);
                }
            }
        } else {
            if (fixedHeader.hasClass('fixed-already')) {
                fixedHeader.stop().removeClass('fixed-already');
                fixedHeader.removeAttr('style');
                $('.nasa-header-sticky').removeAttr('style');
            }
            
            if (fixedHeader.hasClass('fixed-trasition')) {
                fixedHeader.stop().removeClass('fixed-trasition');
            }
            
            _heightFixed = fixedHeader.outerHeight();
        }
    }
    
    if ($('.nasa-nav-extra-warp').length) {
        if (scrollTop > headerHeight){
            if (!$('.nasa-nav-extra-warp').hasClass('nasa-show')) {
                $('.nasa-nav-extra-warp').addClass('nasa-show');
            }
        } else {
            if ($('.nasa-nav-extra-warp').hasClass('nasa-show')) {
                $('.nasa-nav-extra-warp').removeClass('nasa-show');
            }
        }
    }
    
    /* if (scrollTop <= headerHeight && $('#mobile-navigation').attr('data-show') === '1' && !_inMobile){
        $('.black-window').trigger('click');
    } */
    
    /* Back to Top */
    if ($('#nasa-back-to-top').length) {
        var _height_win = $(window).height() / 2;
        if (scrollTop > _height_win){
            var _animate = $('#nasa-back-to-top').attr('data-wow');
            $('#nasa-back-to-top').show().css({'visibility': 'visible', 'animation-name': _animate}).removeClass('animated').addClass('animated');
        } else {
            $('#nasa-back-to-top').hide();
        }
    }
    
    /* Menu mobile */
    if ($('.mobile-menu').length && $('.nasa-has-fixed-header').length) {
        var _wrap = $('.mobile-menu').parent();
        
        if ((_menuHeight + 50) < scrollTop) {
            if (!$('.mobile-menu').hasClass('nasa-mobile-fixed')) {
                var height_adminbar = $('#wpadminbar').length ? $('#wpadminbar').height() : 0;
                $('.mobile-menu').addClass('nasa-mobile-fixed');
                $('.mobile-menu').css({'top': 0 + height_adminbar});
                if (!$(_wrap).hasClass('nasa-padding-only-mobile')) {
                    $(_wrap).addClass('nasa-padding-only-mobile');
                }
                $(_wrap).css({'padding-top': $('.mobile-menu').height()});
            }
        }
        else {
            if ($('.mobile-menu').hasClass('nasa-mobile-fixed')) {
                $('.mobile-menu').removeClass('nasa-mobile-fixed').removeAttr('style');
                $(_wrap).removeAttr('style');
            }
        }
    }
    
    /**
     * Equal height columns
     */
    clearTimeout(_load_equal_height_columns_scroll);
    _load_equal_height_columns_scroll = setTimeout(function() {
        row_equal_height_columns($, true);
    }, 100);
});

/**
 * Back to Top
 */
$('body').on('click', '#nasa-back-to-top', function() {
    $('html, body').animate({scrollTop: 0}, 800);
});

// **********************************************************************// 
// ! Header slider overlap for Transparent
// **********************************************************************//
$(window).resize(function() {
    var _mobileView = $('.nasa-check-reponsive.nasa-switch-check').length && $('.nasa-check-reponsive.nasa-switch-check').width() === 1 ? true : false;
    
    var _inMobile = $('body').hasClass('nasa-in-mobile') ? true : false;

    // Fix Sidebar Mobile, Search Mobile display switch to desktop
    var desk = $('.black-window').hasClass('desk-window');
    if (!_mobileView && !desk && !_inMobile) {
        if ($('.col-sidebar').length){
            $('.col-sidebar').removeClass('nasa-active');
        }
        
        if ($('.warpper-mobile-search').length){
            $('.warpper-mobile-search').removeClass('nasa-active');
        }
        
        if ($('.black-window').length){
            $('.black-window').hide();
        }
    }
    
    /**
     * Active Filter cat top
     */
    initTopCategoriesFilter($);

    /* Fix width menu vertical */
    if ($('.wide-nav .nasa-vertical-header').length) {
        var _v_width = $('.wide-nav .nasa-vertical-header').width();
        _v_width = _v_width < 280 ? 280: _v_width;
        $('.wide-nav .vertical-menu-container').css({'width': _v_width});
    }
    
    /* Fix tab able nasa-slide-style */
    if ($('.nasa-slide-style').length) {
        var _width;
        $('.nasa-slide-style').each(function() {
            var _this = $(this);
            _width = 0;
            $(_this).find('.nasa-tabs .nasa-tab').each(function() {
                _width += $(this).outerWidth();
            });
            
            if (_width > $(_this).width()) {
                if (!$(_this).find('.nasa-tabs .nasa-tab').hasClass('nasa-block')) {
                    $(_this).find('.nasa-tabs .nasa-tab').addClass('nasa-block');
                }
            } else {
                $(_this).find('.nasa-tabs .nasa-tab').removeClass('nasa-block');
            }
        });
    }
    
    var _height_adminbar = $('#wpadminbar').length ? $('#wpadminbar').height() : 0;
    if (_height_adminbar > 0 && $('#mobile-navigation').length === 1) {
        $('#nasa-menu-sidebar-content').css({'top': _height_adminbar});
        
        if ($('#mobile-navigation').attr('data-show') === '1' && !_mobileView) {
            var _scrollTop = $(window).scrollTop();
            var _headerHeight = $('.header-wrapper').height() + 50;
            if (_scrollTop <= _headerHeight){
                $('.black-window').trigger('click');
            }
        }
    }
    
    if ($('#mobile-navigation').attr('data-show') !== '1') {
        $('#nasa-menu-sidebar-content').removeClass('nasa-active');
    }
    
    /* Fix scroll single product */
    loadScrollSingleProduct($);
    
    clearTimeout(_loadingBeforeResize);
    _loadingBeforeResize = setTimeout(function() {
        /**
         * Fix height for full width to side
         */
        loadHeightFullWidthToSide($);
        
        /**
         * Main menu Reponsive
         */
        loadResponsiveMainMenu($);
        
        /**
         * Change quick view | add to cart
         */
        init_product_quickview_addtocart($, true);
    }, 1100);
    
    clearTimeout(_load_equal_height_columns);
    _load_equal_height_columns = setTimeout(function() {
        /**
         * Equal height columns
         */
        row_equal_height_columns($, false);
    }, 1150);
    
    clearTimeout(_positionMobileMenu);
    _positionMobileMenu = setTimeout(function() {
        positionMenuMobile($);
    }, 100);
});

var _positionMobileMenu = setTimeout(function() {
    positionMenuMobile($);
}, 100);

/* Fix width menu vertical =============================================== */
if ($('.wide-nav .nasa-vertical-header').length){
    var _v_width = $('.wide-nav .nasa-vertical-header').width();
    _v_width = _v_width < 280 ? 280: _v_width;
    $('.wide-nav .vertical-menu-container').css({'width': _v_width});
    if ($('.wide-nav .vertical-menu-container').hasClass('nasa-allways-show')) {
        $('.wide-nav .vertical-menu-container').addClass('nasa-active');
    }
}

if ($('.nasa-accordions-content .nasa-accordion-title a').length){
    $('.nasa-accordions-content').each(function() {
        if ($(this).hasClass('nasa-accodion-first-hide')) {
            $(this).find('.nasa-accordion.first').removeClass('active');
            $(this).find('.nasa-panel.first').removeClass('active');
            $(this).removeClass('nasa-accodion-first-hide');
        } else {
            $(this).find('.nasa-panel.first.active').slideDown(200);
        }
    });
    
    $('body').on('click', '.nasa-accordions-content .nasa-accordion-title a', function() {
        var warp = $(this).parents('.nasa-accordions-content');
        $(warp).removeClass('nasa-accodion-first-show');
        var _id = $(this).attr('data-id');
        if (!$(this).hasClass('active')){
            $(warp).find('.nasa-accordion-title a').removeClass('active');
            $(warp).find('.nasa-panel.active').removeClass('active').slideUp(200);
            $('#nasa-secion-' + _id).addClass('active').slideDown(200);
            $(this).addClass('active');
        } else {
            $(this).removeClass('active');
            $('#nasa-secion-' + _id).removeClass('active').slideUp(200);
        }
        return false;
    });
}

// Tabable
if ($('.nasa-tabs-content ul.nasa-tabs li a').length){
    $('body').on('click', '.nasa-tabs-content ul.nasa-tabs li a', function(e){
        e.preventDefault();
        var _this = $(this);
        if (!$(_this).parent().hasClass('active')){
            var _root = $(_this).parents('.nasa-tabs-content');
            var currentTab = $(_this).attr('data-id');
            var show = $(_this).parent().attr('data-show');
            $(_root).find('ul li').removeClass('active');
            $(_this).parent().addClass('active');
            $(_root).find('div.nasa-panel').removeClass('active').hide();
            $(currentTab).addClass('active').show();
            if ($(currentTab).parents('.vc_tta-panel').length) {
                $(currentTab).parents('.nasa-panels').find('.vc_tta-panel').hide();
                $(currentTab).parents('.vc_tta-panel').show();
            }
            
            if ($(_root).hasClass('nasa-slide-style')) {
                nasa_tab_slide_style($, _root, 500);
            }
            
            var nasa_slider = $(currentTab).find('.nasa-slider.products-group');
            var nasa_deal = $(currentTab).find('.nasa-row-deal-3');
            
            if (wow_enable){
                if (
                    $(currentTab).find('.product-item').length ||
                    $(currentTab).find('.item-product-widget').length
                ){
                    $(currentTab).css({'opacity': '0.9'}).append('<div class="nasa-loader"></div>');
                    $(_root).find('.wow').css({
                        'visibility': 'hidden',
                        'animation-name': 'none',
                        'opacity': '0'
                    });
                    
                    if ($(_root).find('.wow').length <= 0) {
                        $(currentTab).css({'opacity': '1'});
                        $(currentTab).find('.nasa-loader').remove();
                    }

                    if ($(nasa_slider).length < 1){
                        $(currentTab).find('.wow').removeClass('animated').css({'animation-name': 'fadeInUp'});
                        $(currentTab).find('.wow').each(function(){
                            var _wow = $(this);
                            var _delay = parseInt($(_wow).attr('data-wow-delay'));

                            setTimeout(function(){
                                $(_wow).css({'visibility': 'visible'});
                                $(_wow).animate({'opacity': 1}, _delay);
                                if ($(currentTab).find('.nasa-loader, .please-wait').length){
                                    $(currentTab).css({'opacity': 1});
                                    $(currentTab).find('.nasa-loader, .please-wait').remove();
                                }
                            }, _delay);
                        });
                    } else {
                        if (!$(currentTab).hasClass('first-inited') && !$(currentTab).hasClass('first')) {
                            $(nasa_slider).trigger('destroy.owl.carousel');
                            loadingCarousel($);
                            
                            $(currentTab).addClass('first-inited');
                        }
                        
                        $(currentTab).find('.owl-stage').css({'opacity': '0'});
                        setTimeout(function(){
                            $(currentTab).find('.owl-stage').css({'opacity': '1'});
                        }, 500);

                        $(currentTab).find('.wow').each(function(){
                            var _wow = $(this);
                            $(_wow).css({
                                'animation-name': 'fadeInUp',
                                'visibility': 'visible',
                                'opacity': 0
                            });
                            var _delay = parseInt($(_wow).attr('data-wow-delay'));
                            _delay += (show === '0') ? 500 : 0;
                            setTimeout(function(){
                                $(_wow).animate({'opacity': 1}, _delay);
                                if ($(currentTab).find('.nasa-loader, .please-wait').length){
                                    $(currentTab).css({'opacity': 1});
                                    $(currentTab).find('.nasa-loader, .please-wait').remove();
                                }
                            }, _delay);
                        });
                    }
                }
            } else {
                if ($(nasa_slider).length) {
                    if (!$(currentTab).hasClass('first-inited') && !$(currentTab).hasClass('first')) {
                        $(nasa_slider).trigger('destroy.owl.carousel');
                        loadingCarousel($);

                        $(currentTab).addClass('first-inited');
                    }
                    
                    $(currentTab).css({'opacity': '0.9'}).append('<div class="nasa-loader"></div>');
                    $(currentTab).find('.owl-stage').css({'opacity': '0'});
                    setTimeout(function(){
                        $(currentTab).find('.owl-stage').css({'opacity': '1'});
                        if ($(currentTab).find('.nasa-loader, .please-wait').length){
                            $(currentTab).css({'opacity': 1});
                            $(currentTab).find('.nasa-loader, .please-wait').remove();
                        }
                    }, 300);
                } else {
                    $(currentTab).css({'opacity': '1'});
                    $(currentTab).find('.nasa-loader').remove();
                }
            }
            
            if ($(nasa_deal).length) {
                loadHeightDeal($);
            }
        }
        
        setTimeout(function(){
            load_intival_fix_carousel($);
            init_product_quickview_addtocart($, true);
        }, 500);

        return false;
    });
    
    if ($('.nasa-tabs-content.nasa-slide-style').length) {
        $('.nasa-slide-style').each(function (){
            var _this = $(this);
            nasa_tab_slide_style($, _this, 500);
        });
        
        $(window).resize(function() {
            $('.nasa-slide-style').each(function (){
                var _this = $(this);
                nasa_tab_slide_style($, _this, 50);
            });
        });
    }
}

if (typeof nasa_countdown_l10n !== 'undefined' && (typeof nasa_countdown_init === 'undefined' || nasa_countdown_init === '0')) {
    var nasa_countdown_init = '1';
    // Countdown
    $.countdown.regionalOptions[''] = {
        labels: [
            nasa_countdown_l10n.years,
            nasa_countdown_l10n.months,
            nasa_countdown_l10n.weeks,
            nasa_countdown_l10n.days,
            nasa_countdown_l10n.hours,
            nasa_countdown_l10n.minutes,
            nasa_countdown_l10n.seconds
        ],
        labels1: [
            nasa_countdown_l10n.year,
            nasa_countdown_l10n.month,
            nasa_countdown_l10n.week,
            nasa_countdown_l10n.day,
            nasa_countdown_l10n.hour,
            nasa_countdown_l10n.minute,
            nasa_countdown_l10n.second
        ],
        compactLabels: ['y', 'm', 'w', 'd'],
        whichLabels: null,
        digits: ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'],
        timeSeparator: ':',
        isRTL: true
    };

    $.countdown.setDefaults($.countdown.regionalOptions['']);
    loadCountDown($);
}

if (! /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)) {
    $('.yith-wcwl-wishlistexistsbrowse.show').each(function(){
        var tip_message = $(this).find('a').text();
        $(this).find('a').attr('data-tip', tip_message).addClass('tip-top');
    });

    loadTipTop($);
}

if ($('.nasa_banner .center').length){
    $('.nasa_banner .center').vAlign();
    $(window).resize(function() {
        $('.nasa_banner .center').vAlign();
    });
}

if ($('.col_hover_focus').length){
    $('body').on('hover', '.col_hover_focus', function(){
        $(this).parent().find('.columns > *').css('opacity','0.5');
    }, function() {
        $(this).parent().find('.columns > *').css('opacity','1');
    });
}

if ($('.add-to-cart-grid.product_type_simple').length){
    $('body').on('click', '.add-to-cart-grid.product_type_simple', function(){
        $('.mini-cart').addClass('active cart-active');
        $('.mini-cart').hover(function(){$('.cart-active').removeClass('cart-active');});
        setTimeout(function(){$('.cart-active').removeClass('active');}, 5000);
    });
}

$('.row ~ br').remove(); 
$('.columns ~ br').remove();
$('.columns ~ p').remove();
$('select.ninja-forms-field,select.addon-select').wrap('<div class="custom select-wrapper"/>');
$(window).resize();

/* Carousel */
loadingCarousel($);
loadingSCCarosel($);

/* Resize carousel */
setInterval(function(){
    var owldata = $(".owl-carousel").data('owlCarousel');
    if (typeof owldata !== 'undefined' && owldata !== false){
        owldata.updateVars();
    }
}, 1500);

/*
 * Compare products
 */
$('body').on('click', '.product-interactions .btn-compare', function(){
    var _this = $(this);
    if (!$(_this).hasClass('loading')) {
        if (!$(_this).hasClass('nasa-compare')) {
            var $button = $(_this).parents('.product-interactions');
            $button.find('.compare-button .compare').trigger('click');
        } else {
            var _id = $(_this).attr('data-prod');
            if (_id) {
                add_compare_product(_id, $, _this);
            }
        }
    }
    
    return false;
});
$('body').on('click', '.nasa-remove-compare', function(){
    var _id = $(this).attr('data-prod');
    if (_id) {
        remove_compare_product(_id, $);
    }
    
    return false;
});
$('body').on('click', '.nasa-compare-clear-all', function(){
    removeAll_compare_product($);
    
    return false;
});
$('body').on('click', '.nasa-show-compare', function(){
    loadCompare($);
    
    if (!$(this).hasClass('nasa-showed')) {
        showCompare($);
    } else {
        hideCompare($);
    }
    
    return false;
});

/*
 * Wishlist products
 */
$('body').on('click', '.btn-wishlist', function(){
    var _this = $(this);
    if (!$(_this).hasClass('nasa-disabled')) {
        $('.btn-wishlist').addClass('nasa-disabled');
        
        /**
         * NasaTheme Wishlist
         */
        if ($(_this).hasClass('btn-nasa-wishlist')) {
            var _pid = $(_this).attr('data-prod');
            
            if (!$(_this).hasClass('nasa-added')) {
                $(_this).addClass('nasa-added');
                nasa_process_wishlist($, _pid, 'nasa_add_to_wishlist');
            } else {
                $(_this).removeClass('nasa-added');
                nasa_process_wishlist($, _pid, 'nasa_remove_from_wishlist');
            }
        }
        
        /**
         * Yith WooCommerce Wishlist
         */
        else {
            if (!$(_this).hasClass('nasa-added')) {
                $(_this).addClass('nasa-added');

                if ($('#tmpl-nasa-global-wishlist').length) {
                    var _pid = $(_this).attr('data-prod');
                    var _origin_id = $(_this).attr('data-original-product-id');
                    var _ptype = $(_this).attr('data-prod_type');
                    var _wishlist_tpl = $('#tmpl-nasa-global-wishlist').html();
                    if ($('.nasa-global-wishlist').length <= 0) {
                        $('body').append('<div class="nasa-global-wishlist"></div>');
                    }

                    _wishlist_tpl = _wishlist_tpl.replace(/%%product_id%%/g, _pid);
                    _wishlist_tpl = _wishlist_tpl.replace(/%%product_type%%/g, _ptype);
                    _wishlist_tpl = _wishlist_tpl.replace(/%%original_product_id%%/g, _origin_id);

                    $('.nasa-global-wishlist').html(_wishlist_tpl);
                    $('.nasa-global-wishlist').find('.add_to_wishlist').trigger('click');
                } else {
                    var $button = $(_this).parents('.product-interactions');
                    $button.find('.add_to_wishlist').trigger('click');
                }
            } else {
                var _pid = $(_this).attr('data-prod');
                if (_pid && $('#yith-wcwl-row-' + _pid).length && $('#yith-wcwl-row-' + _pid).find('.nasa-remove_from_wishlist').length) {
                    $(_this).removeClass('nasa-added');
                    $(_this).addClass('nasa-unliked');
                    $('#yith-wcwl-row-' + _pid).find('.nasa-remove_from_wishlist').trigger('click');

                    setTimeout(function() {
                        $(_this).removeClass('nasa-unliked');
                    }, 1000);
                } else {
                    $('.btn-wishlist').removeClass('nasa-disabled');
                }
            }
        }
    }
    
    return false;
});

/* ADD PRODUCT WISHLIST NUMBER */
$('body').on('added_to_wishlist', function() {
    if (typeof nasa_ajax_params !== 'undefined' && typeof nasa_ajax_params.ajax_url !== 'undefined') {
        var _data = {};
        _data.action = 'nasa_update_wishlist';
        _data.added = true;

        if ($('.nasa-value-gets').length && $('.nasa-value-gets').find('input').length) {
            $('.nasa-value-gets').find('input').each(function() {
                var _key = $(this).attr('name');
                var _val = $(this).val();
                _data[_key] = _val;
            });
        }

        $.ajax({
            url: nasa_ajax_params.ajax_url,
            type: 'post',
            dataType: 'json',
            cache: false,
            data: _data,
            beforeSend: function(){
                $('.btn-wishlist').removeClass('loading');
            },
            success: function(res){
                $('.wishlist_sidebar').replaceWith(res.list);
                var _sl_wishlist = (res.count).toString().replace('+', '');
                var sl_wislist = parseInt(_sl_wishlist);
                $('.wishlist-number .nasa-sl').html(res.count);

                if (sl_wislist > 0) {
                    $('.wishlist-number').removeClass('nasa-product-empty');
                } else if (sl_wislist === 0 && !$('.wishlist-number').hasClass('nasa-product-empty')){
                    $('.wishlist-number').addClass('nasa-product-empty');
                    $('.black-window').trigger('click');
                }

                if ($('#yith-wcwl-popup-message').length && typeof res.mess !== 'undefined' && res.mess !== '') {
                    $('#yith-wcwl-popup-message').html(res.mess);

                    $('#yith-wcwl-popup-message').fadeIn();
                    setTimeout( function() {
                        $('#yith-wcwl-popup-message').fadeOut();
                    }, 2000);
                }

                setTimeout(function() {
                    initWishlistIcons($, true);

                    $('.btn-wishlist').removeClass('nasa-disabled');
                }, 350);
            },
            error: function () {
                $('.btn-wishlist').removeClass('nasa-disabled');
                $('.btn-wishlist').removeClass('loading');
            }
        });
    }
});

/* REMOVE PRODUCT WISHLIST NUMBER */
$('body').on('click', '.nasa-remove_from_wishlist', function(){
    if (typeof nasa_ajax_params !== 'undefined' && typeof nasa_ajax_params.ajax_url !== 'undefined') {
        var _data = {};
        _data.action = 'nasa_remove_from_wishlist';

        if ($('.nasa-value-gets').length && $('.nasa-value-gets').find('input').length) {
            $('.nasa-value-gets').find('input').each(function() {
                var _key = $(this).attr('name');
                var _val = $(this).val();
                _data[_key] = _val;
            });
        }

        var _pid = $(this).attr('data-prod_id');
        _data.pid = _pid;
        _data.wishlist_id = $('.wishlist_table').attr('data-id');
        _data.pagination = $('.wishlist_table').attr('data-pagination');
        _data.per_page = $('.wishlist_table').attr('data-per-page');
        _data.current_page = $('.wishlist_table').attr('data-page');

        var _wrap_item = $(this).parents('.nasa-tr-wishlist-item');

        $.ajax({
            url: nasa_ajax_params.ajax_url,
            type: 'post',
            dataType: 'json',
            cache: false,
            data: _data,
            beforeSend: function(){
                $.magnificPopup.close();
                if ($(_wrap_item).length) {
                    $(_wrap_item).css({opacity: 0.5});
                }
            },
            success: function(res){
                if (res.error === '0'){
                    $('.wishlist_sidebar').replaceWith(res.list);
                    var _sl_wishlist = (res.count).toString().replace('+', '');
                    var sl_wislist = parseInt(_sl_wishlist);
                    $('.wishlist-number .nasa-sl').html(res.count);
                    if (sl_wislist > 0) {
                        $('.wishlist-number').removeClass('nasa-product-empty');
                    } else if (sl_wislist === 0 && !$('.wishlist-number').hasClass('nasa-product-empty')){
                        $('.wishlist-number').addClass('nasa-product-empty');
                        $('.black-window').trigger('click');
                    }

                    if ($('.btn-wishlist[data-prod="' + _pid + '"]').length) {
                        $('.btn-wishlist[data-prod="' + _pid + '"]').removeClass('nasa-added');

                        if ($('.btn-wishlist[data-prod="' + _pid + '"]').find('.added').length) {
                            $('.btn-wishlist[data-prod="' + _pid + '"]').find('.added').removeClass('added');
                        }
                    }

                    if ($('#yith-wcwl-popup-message').length && typeof res.mess !== 'undefined' && res.mess !== '') {
                        $('#yith-wcwl-popup-message').html(res.mess);

                        $('#yith-wcwl-popup-message').fadeIn();
                        setTimeout( function() {
                            $('#yith-wcwl-popup-message').fadeOut();
                        }, 2000 );
                    }
                }

                $('.btn-wishlist').removeClass('nasa-disabled');
                $('.btn-wishlist').removeClass('loading');
            },
            error: function () {
                $('.btn-wishlist').removeClass('nasa-disabled');
                $('.btn-wishlist').removeClass('loading');
            }
        });
    }
    
    return false;
});

// Target quantity inputs on product pages
$('body').find('input.qty:not(.product-quantity input.qty)').each(function() {
    var min = parseFloat($(this).attr('min'));
    if (min && min > 0 && parseFloat($(this).val()) < min) {
        $(this).val(min);
    }
});

$('body').on('click', '.plus, .minus', function() {
    // Get values
    var $qty = $(this).parents('.quantity').find('.qty'),
        button_add = $(this).parent().parent().find('.single_add_to_cart_button'),
        currentVal = parseFloat($qty.val()),
        max = parseFloat($qty.attr('max')),
        min = parseFloat($qty.attr('min')),
        step = $qty.attr('step');
        
    // Format values
    currentVal = !currentVal ? 0 : currentVal;
    max = !max ? '' : max;
    min = !min ? 1 : min;
    if (step === 'any' || step === '' || typeof step === 'undefined' || parseFloat(step) === 'NaN') {
        step = 1;
    }
    // Change the value
    if ($(this).is('.plus')) {
        if (max && (max == currentVal || currentVal > max)) {
            $qty.val(max);
            if (button_add.length){
                button_add.attr('data-quantity', max);
            }
        } else {
            $qty.val(currentVal + parseFloat(step));
            if (button_add.length){
                button_add.attr('data-quantity', currentVal + parseFloat(step));
            }
        }
    } else {
        if (min && (min == currentVal || currentVal < min)) {
            $qty.val(min);
            if (button_add.length){
                button_add.attr('data-quantity', min);
            }
        } else if (currentVal > 0) {
            $qty.val(currentVal - parseFloat(step));
            if (button_add.length){
                button_add.attr('data-quantity', currentVal - parseFloat(step));
            }
        }
    }
    // Trigger change event
    $qty.trigger('change');
});

/**
 * Ajax search
 */
if (typeof search_options.enable_live_search !== 'undefined' && search_options.enable_live_search == '1') {
    if (typeof nasa_ajax_params !== 'undefined' && typeof nasa_ajax_params.ajax_url !== 'undefined') {
        var empty_mess = $('#nasa-empty-result-search').html();
        var _effect_item = null;

        searchProducts = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('title'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            limit: search_options.limit_results,
            prefetch: nasa_ajax_params.ajax_url + '?action=live_search_products',
            remote: {
                url: nasa_ajax_params.ajax_url + '?action=live_search_products&s=%QUERY',
                wildcard: '%QUERY'
            }
        });

        $('.live-search-input').typeahead({
            minLength: 3,
            hint: true,
            backdrop: {
                "opacity": 0.8,
                "filter": "alpha(opacity=80)",
                "background-color": "#eaf3ff"
            },
            searchOnFocus: true,
            callback: {
                onInit: function () {
                    searchProducts.initialize();
                },
                onSubmit: function(node, form, item, event) {
                    form.submit();
                }
            }
        },
        {
            name: 'search',
            source: searchProducts,
            display: 'title',
            displayKey: 'value',
            limit: search_options.limit_results * 2,
            templates: {
                empty : '<p class="empty-message nasa-notice-empty">' + empty_mess + '</p>',
                suggestion: Handlebars.compile(search_options.live_search_template),
                pending: function (query) {
                    return '<div class="nasa-loader nasa-live-search-loader"></div>';
                }
            }
        });

        $('body').on('focusin', '.nasa-search-desktop .live-search-input', function() {
            if (typeof _effect_item !== 'undefined' && _effect_item) {
                clearInterval(_effect_item);
            }

            _effect_item = setInterval(function() {
                $('.tt-menu').each(function() {
                    var _this = $(this);

                    if ($(_this).find('.item-search').length) {
                        var _delay = 0;

                        $(_this).find('.item-search').each(function() {
                            var _item = $(this);
                            if (!$(_item).hasClass('nasa-showed')) {
                                setTimeout(function() {
                                    $(_item).addClass('nasa-showed');
                                }, _delay);
                                _delay+= 100;
                            }
                        });
                    }
                });
            }, 200);
        });

        $('body').on('focusout', '.nasa-search-desktop .live-search-input', function() {
            if (typeof _effect_item !== 'undefined' && _effect_item) {
                clearInterval(_effect_item);
            }
        });
    }
}

/*
 * Banner Lax
 */
var windowWidth = $(window).width();
$(window).resize(function() {
    windowWidth = $(window).width();
    if (windowWidth <= 768){
        $('.hover-lax').css('background-position', 'center center');
    }
});

if ($('.hover-lax').length) {
    $('body').on('mousemove', '.hover-lax', function(e){
        var lax_bg = $(this);
        var minWidth = $(lax_bg).attr('data-minwidth') ? $(lax_bg).attr('data-minwidth') : 768;

        if (windowWidth > minWidth){
            var amountMovedX = (e.pageX * -1 / 6);
            var amountMovedY = (e.pageY * -1 / 6);
            $(lax_bg).css('background-position', amountMovedX + 'px ' + amountMovedY + 'px');
        }else{
            $(lax_bg).css('background-position', 'center center');
        }
    });
}

/**
 * Event search in bottom mobile layout
 */
$('body').on('click', '.botbar-mobile-search', function(){
    if ($('.mobile-search').length) {
        $('.mobile-search').trigger('click');
    }
});

/**
 * Mobile Search
 */
$('body').on('click', '.mobile-search', function(){
    $('.black-window').fadeIn(200);
    
    if (iOS) {
        $('.warpper-mobile-search').find('input[name="s"]').val('').focus();
    }
    
    var height_adminbar = $('#wpadminbar').length ? $('#wpadminbar').height() : 0;
    
    if (height_adminbar > 0) {
        $('.warpper-mobile-search').css({top: height_adminbar});
    }
    
    if (!$('.warpper-mobile-search').hasClass('nasa-active')) {
        $('.warpper-mobile-search').addClass('nasa-active');
    }
    
    setTimeout(function() {
        $('.warpper-mobile-search').find('input[name="s"]').val('').focus();
    }, 1000);
});

/**
 * In Desktop Search
 * @type Boolean
 */
var _hotkeyInit = false;
var _autoFill;
var _text = '';
$('body').on('click', '.desk-search', function(e){
    var _this_click = $(this);
    
    if (!$(_this_click).hasClass('nasa-disable')) {
        $(_this_click).addClass('nasa-disable');
        
        var _focus_input = $(_this_click).parents('.nasa-wrap-event-search').find('.nasa-show-search-form');
        var _opened = $(_this_click).attr('data-open');
        
        if (_opened === '0') {
            $('.header-wrapper').find('.nasa-show-search-form').after('<div class="nasa-tranparent" />');
        } else {
            $('.header-wrapper').find('.nasa-tranparent').remove();
        }
        
        $('.desk-search').each(function() {
            var _this = $(this);
            var _root_wrap = $(_this).parents('.nasa-wrap-event-search');
            var _elements = $(_root_wrap).find('.nasa-elements-wrap');
            var _search = $(_root_wrap).find('.nasa-show-search-form');

            if (typeof _opened === 'undefined' || _opened === '0') {
                $(_this).attr('data-open', '1');
                if (!$(_search).hasClass('nasa-show')) {
                    $(_search).addClass('nasa-show');
                }

                $(_elements).addClass('nasa-invisible');
            } else {
                $(_this).attr('data-open', '0');
                if ($(_search).hasClass('nasa-show')) {
                    $(_search).removeClass('nasa-show');
                }

                $(_elements).removeClass('nasa-invisible');
            }
        });
        
        if (_hotkeyInit) {
            setTimeout(function() {
                $(_this_click).removeClass('nasa-disable');
                $(_focus_input).find('input[name="s"]').focus();
            }, 1000);
        } else {
            setTimeout(function() {
                $(_focus_input).find('input[name="s"]').focus();
            }, 1000);
            $(_this_click).removeClass('nasa-disable');
        }
        
        /**
         * Hot keywords search
         */
        if ($('.nasa-hotkeys-search span').length) {
            var _oldStr = '';
            if ($('input.live-search-input.tt-input').length) {
                _oldStr = $('input.live-search-input.tt-input').val();
            }

            if (!_hotkeyInit) {
                _hotkeyInit = true;
                var _first = null;

                _autoFill = setInterval(function() {
                    $('.nasa-hotkeys-search span').each(function () {
                        if (_first === null) {
                            _first = $(this);
                        }

                        if (_first) {
                            _text = $(_first).text();

                            if (!$(_first).hasClass('nasa-done') && !$(_first).hasClass('nasa-filling')) {
                                var _from = $(_first);
                                var _form = $(_first).parents('.nasa-search-desktop');

                                if ($(_form).length && $(_form).find('input.live-search-input.tt-input').length) {
                                    var _input = $(_form).find('input.live-search-input.tt-input');
                                    autoFillInputPlaceHolder($, _input, _from);
                                }
                            }

                            if ($(_first).hasClass('nasa-done')) {
                                _first = null;
                            }
                        }
                    });

                    if ($('.nasa-hotkeys-search span.nasa-done').length === $('.nasa-hotkeys-search span').length) {
                        clearInterval(_autoFill);

                        setTimeout(function() {
                            if ($('input.live-search-input.tt-input').length) {
                                var _input = $('input.live-search-input.tt-input');

                                if (_oldStr !== '') {
                                    $(_input).val(_oldStr).focus();
                                }

                                reverseFillInputPlaceHolder($, _input, _text);
                            }
                        }, 1000);
                    }
                }, 400);
            }
        }
    }
    
    e.preventDefault();
});

$('body').on('click', '.nasa-close-search, .nasa-tranparent', function(){
    $(this).parents('.nasa-wrap-event-search').find('.desk-search').trigger('click');
});

$('body').on('click', '.toggle-sidebar-shop', function(){
    $('.transparent-window').fadeIn(200);
    if (!$('.nasa-side-sidebar').hasClass('nasa-active')){
        $('.nasa-side-sidebar').addClass('nasa-active');
    }
});

/**
 * For topbar type 1 Mobile
 */
$('body').on('click', '.toggle-topbar-shop-mobile', function(){
    $('.transparent-mobile').fadeIn(200);
    if (!$('.nasa-top-sidebar').hasClass('nasa-active')){
        $('.nasa-top-sidebar').addClass('nasa-active');
    }
});

$('body').on('click', '.toggle-sidebar', function(){
    $('.black-window').fadeIn(200);
    
    if ($('.col-sidebar').length && !$('.col-sidebar').hasClass('nasa-active')){
        $('.col-sidebar').addClass('nasa-active');
    }
});

if ($('input[name="nasa_cart_sidebar_show"]').length && $('input[name="nasa_cart_sidebar_show"]').val() === '1') {
    setTimeout(function() {
        $('.cart-link').trigger('click');
    }, 300);
}

$('body').on('click', '.botbar-cart-link', function(){
    if ($('.cart-link').length) {
        $('.cart-link').trigger('click');
    }
});

$('body').on('click', '.cart-link', function(){
    if ($('form.nasa-shopping-cart-form').length || $('form.woocommerce-checkout').length) {
        return false;
    } else {
        if ($('#cart-sidebar .woocommerce-mini-cart-item').length) {
            $('#cart-sidebar .nasa-sidebar-tit').removeClass('text-center');
        }
        else {
            if (!$('#cart-sidebar .nasa-sidebar-tit').hasClass('text-center')) {
                $('#cart-sidebar .nasa-sidebar-tit').addClass('text-center');
            }
        }
        
        $('.black-window').fadeIn(200).addClass('desk-window');
        if ($('#cart-sidebar').length && !$('#cart-sidebar').hasClass('nasa-active')) {
            $('#cart-sidebar').addClass('nasa-active');

            if ($('#cart-sidebar').find('input[name="nasa-mini-cart-empty-content"]').length) {
                $('#cart-sidebar').append('<div class="nasa-loader"></div>');

                reloadMiniCart($);
            } else {
                /**
                 * notification free shipping
                 */
                init_shipping_free_notification($);
            }
        }
    }
});

$('body').on('click', '.wishlist-link', function(){
    if ($(this).hasClass('wishlist-link-premium')) {
        return;
    } else {
        if ($(this).hasClass('nasa-wishlist-link')) {
            loadWishlist($);
        }
        
        $('.black-window').fadeIn(200).addClass('desk-window');
        if ($('#nasa-wishlist-sidebar').length && !$('#nasa-wishlist-sidebar').hasClass('nasa-active')) {
            $('#nasa-wishlist-sidebar').addClass('nasa-active');
        }
    }
});

$('body').on('nasa_processed_wishlish', function() {
    if ($('.nasa-tr-wishlist-item').length <= 0) {
        $('.black-window').trigger('click');
    }
});

$('body').on('click', '#nasa-init-viewed', function(){
    $('.black-window').fadeIn(200).addClass('desk-window');
    if ($('#nasa-viewed-sidebar').length && !$('#nasa-viewed-sidebar').hasClass('nasa-active')) {
        if ($('#nasa-viewed-sidebar').find('.item-product-widget').length) {
            $('#nasa-viewed-sidebar').find('.nasa-sidebar-tit').removeClass('text-center');
        }
        
        $('#nasa-viewed-sidebar').addClass('nasa-active');
    }
});

$('body').on('click', '.black-window, .white-window, .transparent-desktop, .transparent-mobile, .transparent-window, .nasa-close-mini-compare, .nasa-sidebar-close a, .nasa-sidebar-return-shop, .login-register-close a', function(){
    
    var _mobileView = $('.nasa-check-reponsive.nasa-switch-check').length && $('.nasa-check-reponsive.nasa-switch-check').width() === 1 ? true : false;
    
    var _inMobile = $('body').hasClass('nasa-in-mobile') ? true : false;
    
    if ($('.black-window').hasClass('desk-window')){
        $('.black-window').removeClass('desk-window');
    }
    
    if ($('#mobile-navigation').length && $('#mobile-navigation').attr('data-show') === '1') {
        $('#nasa-menu-sidebar-content').removeClass('nasa-active');
        $('#mobile-navigation').attr('data-show', '0');
        
        setTimeout(function() {
            $('.black-window').removeClass('nasa-transparent');
        }, 1000);
    }
    
    /**
     * Close Search mobile
     */
    if ($('.warpper-mobile-search').length) {
        $('.warpper-mobile-search').removeClass('nasa-active');
    }
    
    /**
     * Close default mobile sidebar
     */
    if ($('.col-sidebar').length && (_mobileView || _inMobile)){
        $('.col-sidebar').removeClass('nasa-active');
    }

    /**
     * Close Cart sidebar
     */
    if ($('#cart-sidebar').length){
        $('#cart-sidebar').removeClass('nasa-active');
    }

    /**
     * Close Wishlist sidebar
     */
    if ($('#nasa-wishlist-sidebar').length){
        $('#nasa-wishlist-sidebar').removeClass('nasa-active');
    }
    
    /**
     * Close Viewed sidebar
     */
    if ($('#nasa-viewed-sidebar').length){
        $('#nasa-viewed-sidebar').removeClass('nasa-active');
    }
    
    /**
     * Close Quick view sidebar
     */
    if ($('#nasa-quickview-sidebar').length){
        $('#nasa-quickview-sidebar').removeClass('nasa-active');
    }
    
    /**
     * Close Side Sidebar
     */
    if ($('.nasa-side-sidebar').length) {
        $('.nasa-side-sidebar').removeClass('nasa-active');
    }
    
    if ($('.nasa-top-sidebar').length){
        $('.nasa-top-sidebar').removeClass('nasa-active');
    }
    
    /**
     * Close Filter Categories
     */
    if ($('.nasa-top-cat-filter-wrap-mobile').length) {
        $('.nasa-top-cat-filter-wrap-mobile').removeClass('nasa-show');
    }
    
    /**
     * Languages
     */
    if ($('.nasa-current-lang').length) {
        var _wrapLangs = $('.nasa-current-lang').parents('.nasa-select-languages');
        if ($(_wrapLangs).length) {
            $(_wrapLangs).removeClass('nasa-active');
        }
    }
    
    /**
     * Currencies
     */
    if ($('.wcml-cs-item-toggle').length) {
        var _wrapCurrs = $('.wcml-cs-item-toggle').parents('.nasa-select-currencies');
        if ($(_wrapCurrs).length) {
            $(_wrapCurrs).removeClass('nasa-active');
        }
    }
    
    /**
     * Hide compare product
     */
    hideCompare($);
    
    /**
     * Close Login or Register
     */
    if ($('.nasa-login-register-warper').length){
        $('.nasa-login-register-warper').removeClass('nasa-active');
    }

    $('.black-window, .white-window, .transparent-mobile, .transparent-window, .transparent-desktop').fadeOut(1000);
});

$(document).on('keyup', function(e){
    if (e.keyCode === 27){
        $('.nasa-tranparent').trigger('click');
        $('.nasa-tranparent-filter').trigger('click');
        $('.black-window, .white-window, .transparent-desktop, .transparent-mobile, .transparent-window, .nasa-close-mini-compare, .nasa-sidebar-close a, .login-register-close a, .nasa-transparent-topbar, .nasa-close-filter-cat').trigger('click');
        $.magnificPopup.close();
    }
});

$('body').on('click', '.add_to_cart_button', function() {
    if (!$(this).hasClass('product_type_simple')) {
        var _href = $(this).attr('href');
        window.location.href = _href;
    }
});

/*
 * Single add to cart from wishlist
 */
$('body').on('click', '.nasa_add_to_cart_from_wishlist', function(){
    var _this = $(this),
        _id = $(_this).attr('data-product_id');
    if (_id && !$(_this).hasClass('loading')){
        var _type = $(_this).attr('data-type'),
            _quantity = $(_this).attr('data-quantity'),
            _data_wislist = {};
        if ($('.wishlist_table').length && $('.wishlist_table').find('#yith-wcwl-row-' + _id).length) {
            _data_wislist = {
                from_wishlist: '1',
                wishlist_id: $('.wishlist_table').attr('data-id'),
                pagination: $('.wishlist_table').attr('data-pagination'),
                per_page: $('.wishlist_table').attr('data-per-page'),
                current_page: $('.wishlist_table').attr('data-page')
            };
        }
        
        nasa_single_add_to_cart($, _this, _id, _quantity, _type, null, null, _data_wislist);
    }
    
    return false;
});

/*
 * Add to cart in quick-view Or ditail product
 */
$('body').on('click', 'form.cart .single_add_to_cart_button', function() {
    var _flag_adding = true;
    var _this = $(this);
    var _form = $(_this).parents('form.cart');
    
    if ($(_form).find('#yith_wapo_groups_container').length) {
        $(_form).find('input[name="nasa-enable-addtocart-ajax"]').remove();
        
        if ($(_form).find('.nasa-custom-fields input[name="nasa_cart_sidebar"]').length) {
            $(_form).find('.nasa-custom-fields input[name="nasa_cart_sidebar"]').val('1');
        } else {
            $(_form).find('.nasa-custom-fields').append('<input type="hidden" name="nasa_cart_sidebar" value="1" />');
        }
    }
    
    var _enable_ajax = $(_form).find('input[name="nasa-enable-addtocart-ajax"]');
    if ($(_enable_ajax).length <= 0 || $(_enable_ajax).val() !== '1') {
        _flag_adding = false;
        return;
    } else {
        var _id = !$(_this).hasClass('disabled') ? $(_form).find('input[name="data-product_id"]').val() : false;
        if (_id) {
            var _type = $(_form).find('input[name="data-type"]').val(),
                _quantity = $(_form).find('.quantity input[name="quantity"]').val(),
                _variation_id = $(_form).find('input[name="variation_id"]').length ? parseInt($(_form).find('input[name="variation_id"]').val()) : 0,
                _variation = {},
                _data_wislist = {},
                _from_wishlist = (
                    $(_form).find('input[name="data-from_wishlist"]').length === 1 &&
                    $(_form).find('input[name="data-from_wishlist"]').val() === '1'
                ) ? '1' : '0';
                
            if (_type === 'variable' && !_variation_id) {
                _flag_adding = false;
                return false;
            } else {
                if (_variation_id > 0 && $(_form).find('.variations').length){
                    $(_form).find('.variations').find('select').each(function(){
                        _variation[$(this).attr('name')] = $(this).val();
                    });
                    
                    if ($('.wishlist_table').length && $('.wishlist_table').find('tr#yith-wcwl-row-' + _id).length) {
                        _data_wislist = {
                            from_wishlist: _from_wishlist,
                            wishlist_id: $('.wishlist_table').attr('data-id'),
                            pagination: $('.wishlist_table').attr('data-pagination'),
                            per_page: $('.wishlist_table').attr('data-per-page'),
                            current_page: $('.wishlist_table').attr('data-page')
                        };
                    }
                }
            }
            
            if (_flag_adding) {
                nasa_single_add_to_cart($, _this, _id, _quantity, _type, _variation_id, _variation, _data_wislist);
            }
        }
        
        return false;
    }
});

$('body').on('click', '.nasa_bundle_add_to_cart', function() {
    var _this = $(this),
        _id = $(_this).attr('data-product_id');
    if (_id){
        var _type = $(_this).attr('data-type'),
            _quantity = $(_this).attr('data-quantity'),
            _variation_id = 0,
            _variation = {},
            _data_wislist = {};
        
        nasa_single_add_to_cart($, _this, _id, _quantity, _type, _variation_id, _variation, _data_wislist);
    }
    
    return false;
});

$('body').on('click', '.product_type_variation.add-to-cart-grid', function() {
    var _this = $(this);
    if (!$(_this).hasClass('nasa-disable-ajax')) {
        var _id = $(_this).attr('data-product_id');
        if (_id){
            var _type = 'variation',
                _quantity = $(_this).attr('data-quantity'),
                _variation_id = 0,
                _variation = null,
                _data_wislist = {};

                if (typeof $(this).attr('data-variation') !== 'undefined') {
                    _variation = JSON.parse($(this).attr('data-variation'));
                }
            if (_variation) {
                nasa_single_add_to_cart($, _this, _id, _quantity, _type, _variation_id, _variation, _data_wislist);
            }
        }

        return false;
    }
});

$('body').on('click', '.product_type_variable', function(){
    if ($('input[name="nasa-disable-quickview-ux"]').length <= 0 || $('input[name="nasa-disable-quickview-ux"]').val() === '0') {
        var _this = $(this);

        if ($(_this).parents('.compare-list').length) {
            return;
        }

        else {
            if (!$(_this).hasClass('btn-from-wishlist')) {
                var _parent = $(_this).parents('.product-interactions');
                if ($(_parent).length < 1){
                    _parent = $(_this).parents('.item-product-widget');
                }
                $(_parent).find('.quick-view').trigger('click');
            }
            // From Wishlist
            else {
                var _parent = $(_this).parents('.add-to-cart-wishlist');
                var product_item = $(_this).parents('.product-wishlist-info').find('.wishlist-item');
                $(product_item).css({opacity: 0.3});
                $(product_item).after('<div class="nasa-loader"></div>');

                $(_parent).find('.quick-view').trigger('click');
            }

            return false;
        }
    } else {
        return;
    }
});

/**
 * After remove cart item in mini cart
 */
$('body').on('wc_fragments_loaded', function() {
    if ($('#cart-sidebar .woocommerce-mini-cart-item').length <= 0) {
        $('.black-window').trigger('click');
    }
    
    if ($('#cart-sidebar .woocommerce-mini-cart-item').length) {
        $('#cart-sidebar .nasa-sidebar-tit').removeClass('text-center');
    }
    else {
        if (!$('#cart-sidebar .nasa-sidebar-tit').hasClass('text-center')) {
            $('#cart-sidebar .nasa-sidebar-tit').addClass('text-center');
        }
    }
});

$('body').on('wc_fragments_refreshed', function() {
    if ($('#cart-sidebar .woocommerce-mini-cart-item').length) {
        $('#cart-sidebar .nasa-sidebar-tit').removeClass('text-center');
    }
    else {
        if (!$('#cart-sidebar .nasa-sidebar-tit').hasClass('text-center')) {
            $('#cart-sidebar .nasa-sidebar-tit').addClass('text-center');
        }
    }
});

$('body').on('updated_wc_div', function() {
    /**
     * notification free shipping
     */
    init_shipping_free_notification($);
    
    if ($('#cart-sidebar .woocommerce-mini-cart-item').length) {
        $('#cart-sidebar .nasa-sidebar-tit').removeClass('text-center');
    }
    else {
        if (!$('#cart-sidebar .nasa-sidebar-tit').hasClass('text-center')) {
            $('#cart-sidebar .nasa-sidebar-tit').addClass('text-center');
        }
    }
});

/**
 * After Add To Cart
 */
$('body').on('added_to_cart', function() {
    /**
     * Close quick-view
     */
    if ($('.nasa-after-add-to-cart-popup').length <= 0) {
        $.magnificPopup.close();
    }
    
    var _sidebarCart = true;
    
    /* Loading content After Add To Cart */
    if ($('input[name="nasa-after-add-to-cart"]').length && $('form.nasa-shopping-cart-form').length <= 0 && $('form.woocommerce-checkout').length <= 0) {
        _sidebarCart = false;
        
        after_added_to_cart($);
    }
    
    /**
     * Not show sidebar in cart or checkout page
     */
    if ($('form.nasa-shopping-cart-form').length || $('form.woocommerce-checkout').length) {
        _sidebarCart = false;
    }
   
    /**
     * Show Mini Cart Sidebar
     */
    if (_sidebarCart) {
        $('#nasa-quickview-sidebar').removeClass('nasa-active');
        $('#nasa-wishlist-sidebar').removeClass('nasa-active');
        
        setTimeout(function () {
            if ($('#cart-sidebar .woocommerce-mini-cart-item').length) {
                $('#cart-sidebar .nasa-sidebar-tit').removeClass('text-center');
            }
            else {
                if (!$('#cart-sidebar .nasa-sidebar-tit').hasClass('text-center')) {
                    $('#cart-sidebar .nasa-sidebar-tit').addClass('text-center');
                }
            }
            
            $('.black-window').fadeIn(200).addClass('desk-window');
            $('#nasa-wishlist-sidebar').removeClass('nasa-active');
            if ($('#cart-sidebar').length && !$('#cart-sidebar').hasClass('nasa-active')) {
                $('#cart-sidebar').addClass('nasa-active');
            }
            
            /**
             * notification free shipping
             */
            init_shipping_free_notification($);
        }, 200);
    }
});

$('body').on('click', '.nasa-close-magnificPopup', function() {
    $.magnificPopup.close();
});

$('body').on('change', '.nasa-after-add-to-cart-popup input.qty', function() {
    $('.nasa-after-add-to-cart-popup .nasa-update-cart-popup').removeClass('nasa-disable');
});

$('body').on('click', '.remove_from_cart_popup', function() {
    if (!$(this).hasClass('loading')) {
        $(this).addClass('loading');
        nasa_block($('.nasa-after-add-to-cart-wrap'));
        
        var _id = $(this).attr('data-product_id');
        if ($('.widget_shopping_cart_content .remove_from_cart_button[data-product_id="' + _id +'"]').length) {
            $('.widget_shopping_cart_content .remove_from_cart_button[data-product_id="' + _id +'"]').trigger('click');
        } else {
            window.location.href = $(this).attt('href');
        }
    }
    
    return false;
});

$('body').on('removed_from_cart', function() {
    if ($('.nasa-after-add-to-cart-popup').length) {
        after_added_to_cart($);
    }
    
    /**
     * notification free shipping
     */
    init_shipping_free_notification($);
    
    if ($('#cart-sidebar .woocommerce-mini-cart-item').length) {
        $('#cart-sidebar .nasa-sidebar-tit').removeClass('text-center');
    }
    else {
        if (!$('#cart-sidebar .nasa-sidebar-tit').hasClass('text-center')) {
            $('#cart-sidebar .nasa-sidebar-tit').addClass('text-center');
        }
    }
                    
    return false;
});

/**
 * Check if a node is blocked for processing.
 *
 * @param {JQuery Object} $node
 * @return {bool} True if the DOM Element is UI Blocked, false if not.
 */
var nasa_is_blocked = function($node) {
    return $node.is('.processing') || $node.parents('.processing').length;
};

/**
 * Block a node visually for processing.
 *
 * @param {JQuery Object} $node
 */
var nasa_block = function($node) {
    if (!nasa_is_blocked($node)) {
        $node.addClass('processing').block({
            message: null,
            overlayCSS: {
                background: '#fff',
                opacity: 0.6
            }
        });
    }
};

/**
 * Unblock a node after processing is complete.
 *
 * @param {JQuery Object} $node
 */
var nasa_unblock = function($node) {
    $node.removeClass('processing').unblock();
};

/**
 * Update cart in popup
 */
$('body').on('click', '.nasa-update-cart-popup', function() {
    var _this = $(this);
    if ($('.nasa-after-add-to-cart-popup').length && !$(_this).hasClass('nasa-disable')) {
        var _form = $(this).parents('form');
        if ($(_form).find('input[name=""]').length <= 0) {
            $(_form).append('<input type="hidden" name="update_cart" value="Update Cart" />');
        }
        $.ajax({
            type: $(_form).attr('method'),
            url: $(_form).attr('action'),
            data: $(_form).serialize(),
            dataType: 'html',
            beforeSend: function() {
                nasa_block($('.nasa-after-add-to-cart-wrap'));
            },
            success: function(res) {
                $(_form).find('input[name="update_cart"]').remove();
                $(_this).addClass('nasa-disable');
            },
            complete: function() {
                reloadMiniCart($);
                after_added_to_cart($);
            }
        });
    }
    
    return false;
});

// shortcode post to top
if ($('.nasa-post-slider').length){
    var _items = parseInt($('.nasa-post-slider').attr('data-show'));
    $('.nasa-post-slider').owlCarousel({
        items: _items,
        loop: true,
        nav: false,
        autoplay: true,
        dots: false,
        autoHeight: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        responsiveClass: true,
        navText: ["", ""],
        navSpeed: 600,
        responsive:{
            "0": {
                items: 1,
                nav: false
            },
            "600": {
                items: 1,
                nav: false
            },
            "1000": {
                items: _items,
                nav: false
            }
        }
    });
};

if ($('.nasa-promotion-close').length){
    var height = $('.nasa-promotion-news').outerHeight();
    
    if ($.cookie('promotion') !== 'hide'){
        $('.nasa-position-relative').animate({'height': height + 'px'}, 500);
        $('.nasa-promotion-news').fadeIn(500);
    } else {
        $('.nasa-promotion-show').show();
    }
    
    $('body').on('click', '.nasa-promotion-close', function(){
        $.cookie('promotion', 'hide', {expires: 7, path: '/'});
        $('.nasa-promotion-show').show();
        $('.nasa-position-relative').animate({'height': '0px'}, 500);
        $('.nasa-promotion-news').fadeOut(500);
    });
    
    $('body').on('click', '.nasa-promotion-show', function(){
        $.cookie('promotion', 'show', {path: '/'});
        $('.nasa-promotion-show').hide();
        $('.nasa-position-relative').animate({'height': height + 'px'}, 500);
        $('.nasa-promotion-news').fadeIn(500);
    });
};

/* ===================== Filter by sidebar =============================== */
var min_price = 0, max_price = 0, hasPrice = '0';
if ($('.price_slider_wrapper').length){
    $('.price_slider_wrapper').find('input').attr('readonly', true);
    min_price = parseFloat($('.price_slider_wrapper').find('input[name="min_price"]').val()),
    max_price = parseFloat($('.price_slider_wrapper').find('input[name="max_price"]').val());
    hasPrice = ($('.nasa_hasPrice').length) ? $('.nasa_hasPrice').val() : '0';

    if (hasPrice === '1'){
        $('.reset_price').attr('data-has_price', "1").show();
        if ($('.price_slider_wrapper').find('button').length) {
            $('.price_slider_wrapper').find('button').show();
        }
    }
}

$('body').on('click', '.price_slider_wrapper button', function(e) {
    e.preventDefault();
    if (hasPrice === '1' && $('.nasa-has-filter-ajax').length < 1){
        var _obj = $(this).parents('form');
        $('input[name="nasa_hasPrice"]').remove();
        $(_obj).submit();
    }
});

// Filter by Price
$('body').on("slidestop", ".price_slider", function(){
    var _obj = $(this).parents('form');
    if ($('.nasa-has-filter-ajax').length < 1){
        if ($(_obj).find('button').length) {
            $(_obj).find('button').show();
            if ($(_obj).find('.nasa_hasPrice').length){
                $(_obj).find('.nasa_hasPrice').val('1');
                $(_obj).find('.reset_price').attr('data-has_price', "1").fadeIn(200);
            }
            
            $(_obj).find('button').click(function() {
                $('input[name="nasa_hasPrice"]').remove();
                $(_obj).submit();
            });
        } else {
            $(_obj).submit();
        }
    } else {
        if (!shop_load) {
            shop_load = true;
            $('.nasa-value-gets input[name="min_price"]').remove();
            $('.nasa-value-gets input[name="max_price"]').remove();

            var min = parseFloat($(_obj).find('input[name="min_price"]').val()),
                max = parseFloat($(_obj).find('input[name="max_price"]').val());
            if (min < 0){
                min = 0;
            }
            if (max < min){
                max = min;
            }

            if (min != min_price || max != max_price){
                if ($(_obj).find('button').length) {
                    $(_obj).find('button').show();
                }

                min_price = min;
                max_price = max;
                hasPrice = '1';
                if ($('.nasa_hasPrice').length){
                    $('.nasa_hasPrice').val('1');
                    $('.reset_price').attr('data-has_price', "1").fadeIn(200);
                }

                // Call filter by price
                var _this = $('.current-cat > .nasa-filter-by-cat'),
                    _order = $('select[name="orderby"]').val(),
                    _page = false,
                    _catid = null,
                    _taxonomy = '',
                    _url = $('#nasa_current-slug').length <= 0 ? '' : $('#nasa_current-slug').val();

                if ($('#nasa_current-slug').length <= 0 && $(_this).length){
                    _catid = $(_this).attr('data-id');
                    _taxonomy = $(_this).attr('data-taxonomy');
                    _url = $(_this).attr('href');
                }

                var _variations = nasa_setVariations($, [], []);
                var _hasSearch = ($('input#nasa_hasSearch').length && $('input#nasa_hasSearch').val() !== '') ? 1 : 0;
                var _s = (_hasSearch === 1) ? $('input#nasa_hasSearch').val() : '';

                if ($(_obj).find('button').length) {
                    $(_obj).find('button').click(function() {
                        nasa_Ajax_filter($, _url, _page, _catid, _order, _variations, hasPrice, min, max, _hasSearch, _s, _this, _taxonomy);
                    });
                } else {
                    nasa_Ajax_filter($, _url, _page, _catid, _order, _variations, hasPrice, min, max, _hasSearch, _s, _this, _taxonomy);
                }
            } else {
                shop_load = false;
            }
        }

        return false;
    }
});

// Reset filter price
$('body').on('click', '.reset_price', function(){
    if ($('.nasa_hasPrice').length && $('.nasa_hasPrice').val() === '1'){
        var _obj = $(this).parents('form');
        if ($('.nasa-has-filter-ajax').length < 1){
            $('#min_price').remove();
            $('#max_price').remove();
            $('input[name="nasa_hasPrice"]').remove();
            $(_obj).append('<input type="hidden" name="reset-price" value="true" />');
            $(_obj).submit();
        } else {
            if (!shop_load) {
                shop_load = true;
                
                $('.nasa-value-gets input[name="min_price"]').remove();
                $('.nasa-value-gets input[name="max_price"]').remove();
        
                var _min = $('#min_price').attr('data-min');
                var _max = $('#max_price').attr('data-max');
                $('.price_slider').slider('values', 0, _min);
                $('.price_slider').slider('values', 1, _max);
                $('#min_price').val(_min);
                $('#max_price').val(_max);

                var currency_pos = $('input[name="nasa_currency_pos"]').val(),
                    full_price_min = _min,
                    full_price_max = _max;
                switch (currency_pos) {
                    case 'left':
                        full_price_min = woocommerce_price_slider_params.currency_format_symbol + _min;
                        full_price_max = woocommerce_price_slider_params.currency_format_symbol + _max;
                        break;
                    case 'right':
                        full_price_min = _min + woocommerce_price_slider_params.currency_format_symbol;
                        full_price_max = _max + woocommerce_price_slider_params.currency_format_symbol;
                        break;
                    case 'left_space' :
                        full_price_min = woocommerce_price_slider_params.currency_format_symbol + ' ' + _min;
                        full_price_max = woocommerce_price_slider_params.currency_format_symbol + ' ' + _max;
                        break;
                    case 'right_space' :
                        full_price_min = _min + ' ' + woocommerce_price_slider_params.currency_format_symbol;
                        full_price_max = _max + ' ' + woocommerce_price_slider_params.currency_format_symbol;
                        break;
                }

                $('.price_slider_amount .price_label span.from').html(full_price_min);
                $('.price_slider_amount .price_label span.to').html(full_price_max);

                var min = 0,
                    max = 0;

                hasPrice = '0';
                if ($('.nasa_hasPrice').length){
                    $('.nasa_hasPrice').val('0');
                    $('.reset_price').attr('data-has_price', "0").fadeOut(200);
                }

                // Call filter by price
                var _this = $('.current-cat > .nasa-filter-by-cat'),
                    _order = $('select[name="orderby"]').val(),
                    _page = false,
                    _catid = null,
                    _taxonomy = '',
                    _url = $('#nasa_current-slug').length <= 0 ? '' : $('#nasa_current-slug').val();

                if ($('#nasa_current-slug').length <= 0 && $(_this).length) {
                    _catid = $(_this).attr('data-id');
                    _taxonomy = $(_this).attr('data-taxonomy');
                    _url = $(_this).attr('href');
                }

                var _variations = nasa_setVariations($, [], []);
                var _hasSearch = ($('input#nasa_hasSearch').length && $('input#nasa_hasSearch').val() !== '') ? 1 : 0;
                var _s = (_hasSearch === 1) ? $('input#nasa_hasSearch').val() : '';

                nasa_Ajax_filter($, _url, _page, _catid, _order, _variations, hasPrice, min, max, _hasSearch, _s, _this, _taxonomy);
            }
        }
    
        return false;
    }
});

/**
 * Filter price list
 */
$('body').on('click', '.nasa-filter-by-price-list', function() {
    if ($('.nasa-has-filter-ajax').length < 1) {
        return;
    } else {
        if (!shop_load) {
            shop_load = true;
            
            $('.nasa-value-gets input[name="min_price"]').remove();
            $('.nasa-value-gets input[name="max_price"]').remove();
        
            var _url = $(this).attr('href');
            var min = $(this).attr('data-min') ? $(this).attr('data-min') : null,
                max = $(this).attr('data-max') ? $(this).attr('data-max') : null;
                
            if (min < 0){
                min = 0;
            }
            if (max < min){
                max = min;
            }

            if (min != min_price || max != max_price){
                hasPrice = '1';
            }
            
            // Call filter by price
            var _this = $('.current-cat > .nasa-filter-by-cat'),
                _order = $('select[name="orderby"]').val(),
                _page = false,
                _catid = null,
                _taxonomy = '';

            if ($(_this).length){
                _catid = $(_this).attr('data-id');
                _taxonomy = $(_this).attr('data-taxonomy');
            }
            
            var _variations = [];
            
            var _s = $('input#nasa_hasSearch').val(),
                _hasSearch = _s ? 1 : 0;
            
            nasa_Ajax_filter($, _url, _page, _catid, _order, _variations, hasPrice, min, max, _hasSearch, _s, _this, _taxonomy, false, false, false);
        }
        
        return false;
    }
});

// Reset filter
$('body').on('click', '.nasa-reset-filters-btn', function() {
    if ($('.nasa-has-filter-ajax').length < 1) {
        return;
    } else {
        if (!shop_load) {
            shop_load = true;
            $('.nasa-value-gets input').remove();
            $('input[name="nasa_loadmore_style"]').remove();
            
            var _this = $(this),
            _catid = $(_this).attr('data-id'),
            _taxonomy = $(_this).attr('data-taxonomy'),
            _order = false,
            _url = $(_this).attr('href'),
            _page = false;
            
            var _variations = [];
            var min = null,
                max = null;
            $('input#nasa_hasSearch').val('');
            hasPrice = '0';
            nasa_Ajax_filter($, _url, _page, _catid, _order, _variations, hasPrice, min, max,  0, '', _this, _taxonomy, false, false, false, true);
        }
        
        return false;
    }
});

// Filter by Category
$('body').on('click', '.nasa-filter-by-cat', function(){
    if ($('.nasa-has-filter-ajax').length < 1) {
        return;
    } else {
        if (!shop_load) {
            if (!$(this).hasClass('nasa-disable') && !$(this).hasClass('nasa-active')){
                shop_load = true;
                // $('li.cat-item').removeClass('current-cat');
                var _this = $(this),
                    _catid = $(_this).attr('data-id'),
                    _taxonomy = $(_this).attr('data-taxonomy'),
                    _order = $('select[name="orderby"]').val(),
                    _url = $(_this).attr('href'),
                    _page = false;

                if (_catid){
                    var _variations = [];
                    $('.nasa-filter-by-variations').each(function(){
                        if ($(this).hasClass('nasa-filter-var-chosen')){
                            $(this).parent().removeClass('chosen nasa-chosen');
                            $(this).removeClass('nasa-filter-var-chosen');
                        }
                    });

                    var min = null,
                        max = null;
                    $('input#nasa_hasSearch').val('');
                    hasPrice = '0';
                    /**
                     * Fix filter cat push in mobile.
                     */
                    if ($('.black-window-mobile.nasa-push-cat-show').width()) {
                        $('.black-window-mobile.nasa-push-cat-show').trigger('click');
                    }
                    nasa_Ajax_filter($, _url, _page, _catid, _order, _variations, hasPrice, min, max,  0, '', _this, _taxonomy);

                    if (
                        $(_this).parents('.nasa-filter-cat-no-top-icon').length === 1 &&
                        $('.nasa-tab-filter-topbar-categories').length
                    ) {
                        $('.nasa-tab-filter-topbar-categories').trigger('click');
                    }
                }
            }
        }

        return false;
    }
});

if ($('.woocommerce-ordering').length && $('.nasa-has-filter-ajax').length){
    var _parent = $('.woocommerce-ordering').parent(),
        _order = $('.woocommerce-ordering').html();
    $(_parent).html(_order);
}

// Filter by ORDER BY
$('body').on('change', 'select[name="orderby"]', function(){
    if ($('.nasa-has-filter-ajax').length <= 0) {
        $(this).parents('form').submit();
        return;
    } else {
        if (!shop_load) {
            shop_load = true;
            $('.nasa-value-gets input[name="orderby"]').remove();
            var _this = $('.current-cat > .nasa-filter-by-cat'),
                _order = $(this).val(),
                _page = false,
                _catid = null,
                _taxonomy = '',
                _url = $('#nasa_current-slug').length <= 0 ? '' : $('#nasa_current-slug').val();

            if ($('#nasa_current-slug').length <= 0 && $(_this).length) {
                _catid = $(_this).attr('data-id');
                _taxonomy = $(_this).attr('data-taxonomy');
                _url = $(_this).attr('href');
            }

            var _variations = nasa_setVariations($, [], []);

            var min = null,
                max = null;
            if (hasPrice === '1'){
                var _obj = $(".price_slider").parents('form');
                if ($(_obj).length){
                    min = parseFloat($(_obj).find('input[name="min_price"]').val());
                    max = parseFloat($(_obj).find('input[name="max_price"]').val());
                    if (min < 0){
                        min = 0;
                    }
                    if (max < min){
                        max = min;
                    }
                }
            }

            var _hasSearch = ($('input#nasa_hasSearch').length && $('input#nasa_hasSearch').val() !== '') ? 1 : 0;
            var _s = (_hasSearch === 1) ? $('input#nasa_hasSearch').val() : '';
            
            nasa_Ajax_filter($, _url, _page, _catid, _order, _variations, hasPrice, min, max, _hasSearch, _s, _this, _taxonomy);
        }

        return false;
    }
});

// Filter by Paging
$('body').on('click', '.nasa-pagination-ajax .page-numbers', function(){
    if ($(this).hasClass('nasa-current')){
        return;
    } else {
        if (!shop_load) {
            shop_load = true;
            var _this = $('.current-cat > .nasa-filter-by-cat'),
                _order = $('select[name="orderby"]').val(),
                _page = $(this).attr('data-page'),
                _catid = null,
                _taxonomy = '',
                _url = $('#nasa_current-slug').length <= 0 ? '' : $('#nasa_current-slug').val();
            if (_page === '1'){
                _page = false;
            }
            if ($('#nasa_current-slug').length <= 0 && $(_this).length) {
                _catid = $(_this).attr('data-id');
                _taxonomy = $(_this).attr('data-taxonomy');
                _url = $(_this).attr('href');
            }

            var _variations = nasa_setVariations($, [], []);

            var min = null,
                max = null;
            if (hasPrice === '1'){
                var _obj = $(".price_slider").parents('form');
                if ($(_obj).length){
                    min = parseFloat($(_obj).find('input[name="min_price"]').val());
                    max = parseFloat($(_obj).find('input[name="max_price"]').val());
                    if (min < 0){
                        min = 0;
                    }
                    if (max < min){
                        max = min;
                    }
                }
            }

            var _hasSearch = ($('input#nasa_hasSearch').length  && $('input#nasa_hasSearch').val() !== '') ? 1 : 0;
            var _s = (_hasSearch === 1) ? $('input#nasa_hasSearch').val() : '';

            nasa_Ajax_filter($, _url, _page, _catid, _order, _variations, hasPrice, min, max, _hasSearch, _s, _this, _taxonomy, true);
        }

        return false;
    }
});

// Filter by Loadmore
$('body').on('click', '.nasa-archive-loadmore', function() {
    if ($('.nasa-has-filter-ajax').length < 1){
        return;
    } else {
        if (!shop_load) {
            shop_load = true;
            $(this).addClass('nasa-disabled');
            archive_page = archive_page + 1;
            var _this = $('.current-cat > .nasa-filter-by-cat'),
                _order = $('select[name="orderby"]').val(),
                _page = archive_page,
                _catid = null,
                _taxonomy = '',
                _url = $('#nasa_current-slug').length <= 0 ? '' : $('#nasa_current-slug').val();
            if (_page == 1){
                _page = false;
            }
            if ($('#nasa_current-slug').length <= 0 && $(_this).length){
                _catid = $(_this).attr('data-id');
                _taxonomy = $(_this).attr('data-taxonomy');
                _url = $(_this).attr('href');
            }

            var _variations = nasa_setVariations($, [], []);

            var min = null,
                max = null;
            if (hasPrice === '1'){
                var _obj = $(".price_slider").parents('form');
                if ($(_obj).length){
                    min = parseFloat($(_obj).find('input[name="min_price"]').val());
                    max = parseFloat($(_obj).find('input[name="max_price"]').val());
                    if (min < 0){
                        min = 0;
                    }
                    if (max < min){
                        max = min;
                    }
                }
            }

            var _hasSearch = ($('input#nasa_hasSearch').length  && $('input#nasa_hasSearch').val() !== '') ? 1 : 0;
            var _s = (_hasSearch === 1) ? $('input#nasa_hasSearch').val() : '';

            nasa_Ajax_filter($, _url, _page, _catid, _order, _variations, hasPrice, min, max, _hasSearch, _s, _this, _taxonomy, false, true);
        }

        return false;
    }
});

// Filter by variations
$('body').on('click', '.nasa-filter-by-variations', function() {
    if ($('.nasa-has-filter-ajax').length < 1){
        return;
    } else {
        if (!shop_load) {
            shop_load = true;
            
            $('.nasa-value-gets input[name^="filter_"]').remove();
            $('.nasa-value-gets input[name^="query_type_"]').remove();
            
            var _this = $(this);
            
            var _catObj = $('.current-cat > .nasa-filter-by-cat'),
                _current = $(this),
                _order = $('select[name="orderby"]').val(),
                _page = false,
                _catid = null,
                _taxonomy = '',
                _url = $('#nasa_current-slug').length <= 0 ? $(_this).attr('href') : $('#nasa_current-slug').val();

            if ($('#nasa_current-slug').length <= 0 && $(_catObj).length){
                _catid = $(_catObj).attr('data-id');
                _taxonomy = $(_catObj).attr('data-taxonomy');
                _url = $(_catObj).attr('href');
            }

            var _variations = nasa_setVariations($, [], [], _current);
            
            var min = null,
                max = null;
            var _obj = $(".price_slider").parents('form');
            if ($(_obj).length && hasPrice === '1'){
                min = parseFloat($(_obj).find('input[name="min_price"]').val());
                max = parseFloat($(_obj).find('input[name="max_price"]').val());
                if (min < 0){
                    min = 0;
                }
                if (max < min){
                    max = min;
                }
            }

            var _hasSearch = ($('input#nasa_hasSearch').length  && $('input#nasa_hasSearch').val() !== '') ? 1 : 0;
            var _s = (_hasSearch === 1) ? $('input#nasa_hasSearch').val() : '';

            nasa_Ajax_filter($, _url, _page, _catid, _order, _variations, hasPrice, min, max, _hasSearch, _s, _catObj, _taxonomy);
        }

        return false;
    }
    
});

/**
 * nasa-change-layout Change layout
 */
$('body').on('click', '.nasa-change-layout', function() {
    var _this = $(this);
    if ($(_this).hasClass('active')){
        return false;
    } else {
        changeLayoutShopPage($, _this);
    }
});

var _cookie_change_layout = $.cookie('gridcookie');
if (typeof _cookie_change_layout !== 'undefined' && $('.nasa-change-layout.' + _cookie_change_layout).length) {
    $('.nasa-change-layout.' + _cookie_change_layout).trigger('click');
}

// Logout click
$('body').on('click', '.nasa_logout_menu a', function(){
    if ($('input[name="nasa_logout_menu"]').length){
        window.location.href = $('input[name="nasa_logout_menu"]').val();
    }
});

// Show more | Show less
$('body').on('click', '.nasa_show_manual > a', function(){
    var _this = $(this),
        _val = $(_this).attr('data-show'),
        _li = $(_this).parent(),
        _delay = $(_li).attr('data-delay') ? parseInt($(_li).attr('data-delay')) : 100,
        _fade = $(_li).attr('data-fadein') === '1' ? true : false;

    if (_val === '1'){
        $(_li).parent().find('.nasa-show-less').each(function(){
            if (!_fade) {
                $(this).slideDown(_delay);
            } else {
                $(this).fadeIn(_delay);
            }
        });
        
        $(_this).fadeOut(350);
        $(_li).find('.nasa-hidden').fadeIn(350);
        
    } else {
        $(_li).parent().find('.nasa-show-less').each(function(){
            if (!$(this).hasClass('nasa-chosen') && !$(this).find('.nasa-active').length){
                if (!_fade) {
                    $(this).slideUp(_delay);
                } else {
                    $(this).fadeOut(_delay);
                }
            }
        });
        
        $(_this).fadeOut(350);
        $(_li).find('.nasa-show').fadeIn(350);
    }
    
    if ($('.nasa-top-sidebar-2.nasa-slider').length) {
        setTimeout(function() {
            $('.nasa-top-sidebar-2.nasa-slider').trigger('refresh.owl.carousel');
        }, 400);
    }
});

// Login Register Form
$('body').on('click', '.nasa-switch-register', function() {
    $('#nasa-login-register-form .nasa-message').html('');
    $('.nasa_register-form, .register-form').animate({'left': '0'}, 350);
    $('.nasa_login-form, .login-form').animate({'left': '-100%'}, 350);
    
    setTimeout(function (){
        $('.nasa_register-form, .register-form').css({'position': 'relative'});
        $('.nasa_login-form, .login-form').css({'position': 'absolute'});
    }, 350);
});

$('body').on('click', '.nasa-switch-login', function() {
    $('#nasa-login-register-form .nasa-message').html('');
    $('.nasa_register-form, .register-form').animate({'left': '100%'}, 350);
    $('.nasa_login-form, .login-form').animate({'left': '0'}, 350);
    
    setTimeout(function (){
        $('.nasa_register-form, .register-form').css({'position': 'absolute'});
        $('.nasa_login-form, .login-form').css({'position': 'relative'});
    }, 350);
});

if ($('.nasa-login-register-ajax').length && $('#nasa-login-register-form').length) {
    $('body').on('click', '.nasa-login-register-ajax', function() {
        if ($(this).attr('data-enable') === '1' && $('#customer_login').length <= 0) {
            
            $('#nasa-menu-sidebar-content').removeClass('nasa-active');
            $('#mobile-navigation').attr('data-show', '0');
            
            $('.black-window').fadeIn(200).removeClass('nasa-transparent').addClass('desk-window');
            if (!$('.nasa-login-register-warper').hasClass('nasa-active')) {
                $('.nasa-login-register-warper').addClass('nasa-active');
            }
            
            return false;
        }
    });
    
    // Login
    $('body').on('click', '.nasa_login-form .button[type="submit"][name="nasa_login"]', function(e) {
        e.preventDefault();
        
        if (typeof nasa_ajax_params !== 'undefined' && typeof nasa_ajax_params.ajax_url !== 'undefined') {
            var _form = $(this).parents('form.login');
            var _data = $(_form).serializeArray();
            
            $.ajax({
                url: nasa_ajax_params.ajax_url,
                type: 'post',
                dataType: 'json',
                cache: false,
                data: {
                    'action': 'nasa_process_login',
                    'data': _data,
                    'login': true
                },
                beforeSend: function(){
                    $('#nasa-login-register-form #nasa_customer_login').css({opacity: 0.3});
                    $('#nasa-login-register-form #nasa_customer_login').after('<div class="nasa-loader"></div>');
                },
                success: function(res){
                    $('#nasa-login-register-form #nasa_customer_login').css({opacity: 1});
                    $('#nasa-login-register-form').find('.nasa-loader, .please-wait').remove();
                    var _warning = (res.error === '0') ? 'nasa-success' : 'nasa-error';
                    $('#nasa-login-register-form .nasa-message').html('<h4 class="' + _warning + '">' + res.mess + '</h4>');

                    if (res.error === '0') {
                        $('#nasa-login-register-form .nasa-form-content').remove();
                        window.location.href = res.redirect;
                    } else {
                        if (res._wpnonce === 'error') {
                            setTimeout(function() {
                                window.location.reload();
                            }, 2000);
                        }
                    }
                }
            });
        }
        
        return false;
    });

    // Register
    $('body').on('click', '.nasa_register-form .button[type="submit"][name="nasa_register"]', function(e) {
        e.preventDefault();
        
        if (typeof nasa_ajax_params !== 'undefined' && typeof nasa_ajax_params.ajax_url !== 'undefined') {
            var _form = $(this).parents('form.register');
            var _data = $(_form).serializeArray();
            $.ajax({
                url: nasa_ajax_params.ajax_url,
                type: 'post',
                dataType: 'json',
                cache: false,
                data: {
                    'action': 'nasa_process_register',
                    'data': _data,
                    'register': true
                },
                beforeSend: function(){
                    $('#nasa-login-register-form #nasa_customer_login').css({opacity: 0.3});
                    $('#nasa-login-register-form #nasa_customer_login').after('<div class="nasa-loader"></div>');
                },
                success: function(res){
                    $('#nasa-login-register-form #nasa_customer_login').css({opacity: 1});
                    $('#nasa-login-register-form').find('.nasa-loader, .please-wait').remove();
                    var _warning = (res.error === '0') ? 'nasa-success' : 'nasa-error';
                    $('#nasa-login-register-form .nasa-message').html('<h4 class="' + _warning + '">' + res.mess + '</h4>');

                    if (res.error === '0') {
                        $('#nasa-login-register-form .nasa-form-content').remove();
                        window.location.href = res.redirect;
                    } else {
                        if (res._wpnonce === 'error') {
                            setTimeout(function() {
                                window.location.reload();
                            }, 2000);
                        }
                    }
                }
            });
        }
        
        return false;
    });
}

$('body').on('click', '.btn-combo-link', function(){
    var _width = $(window).outerWidth();
    var _this = $(this);
    var show_type = $(_this).attr('data-show_type');
    var wrap_item = $(_this).parents('.products.list');
    if (_width < 946 || $(wrap_item).length === 1) {
        show_type = 'popup';
    }
    
    switch (show_type) {
        default :
            loadComboPopup($, _this);
            break;
    }
    
    return false;
});

if ($('.nasa-upsell-product-detail').find('.nasa-upsell-slider').length) {
    $('.nasa-upsell-product-detail').find('.nasa-upsell-slider').owlCarousel({
        loop: true,
        nav: true,
        dots: false,
        autoplay: true,
        autoplaySpeed: 600,
        navSpeed: 600,
        autoplayHoverPause: true,
        navText: ["", ""],
        responsive:{
            0:{
                items: 1
            }
        }
    });
}

if ($('.nasa-active').length) {
    $('.nasa-active').each(function() {
        if ($(this).parents('.nasa-show-less').length === 1) {
            $(this).parents('.nasa-show-less').show();
        }
    });
}

/* 
 * custom widget top bar
 * 
 */
initNasaTopSidebar($);
$('body').on('click', '.nasa-tab-filter-topbar-categories', function() {
    var _this = $(this);
    $('.filter-cat-icon-mobile').trigger('click');

    if ($(_this).attr('data-top_icon') === '0') {
        var _obj = $(_this).attr('data-widget');
        var _wrap_content = $('.nasa-top-sidebar');

        var _act = $(_obj).hasClass('nasa-active') ? true : false;
        $(_this).parents('.nasa-top-row-filter').find('> li').removeClass('nasa-active');
        $(_wrap_content).find('.nasa-widget-wrap').removeClass('nasa-active').slideUp(300);

        if (!_act) {
            $(_obj).addClass('nasa-active').slideDown(300);
            $(_this).parents('li').addClass('nasa-active');
        }
    }

    else {
        $('.site-header').find('.filter-cat-icon').trigger('click');
        if ($('.nasa-header-sticky').length <= 0 || ($('.sticky-wrapper').length && !$('.sticky-wrapper').hasClass('fixed-already'))) {
            $('html, body').animate({scrollTop: 0}, 700);
        }
    }

    initTopCategoriesFilter($);
});

$('body').on('click', '.nasa-top-row-filter a.nasa-tab-filter-topbar', function() {
    var _this = $(this);
    topFilterClick($, _this, 'animate');
});

$('body').on('click', '.nasa-ignore-variation-item', function() {
    var term_id = $(this).attr('data-term_id');
    if ($('.nasa-filter-by-variations.nasa-filter-var-chosen[data-term_id="' + term_id + '"]').length) {
        if ($('.nasa-has-filter-ajax').length < 1){
            window.location.href = $('.nasa-filter-by-variations.nasa-filter-var-chosen[data-term_id="' + term_id + '"]').attr('href');
        } else {
            $('.nasa-filter-by-variations.nasa-filter-var-chosen[data-term_id="' + term_id + '"]').trigger('click');
        }
    }
});

initNasaTopSidebar2($);
$('body').on('click', '.nasa-toggle-top-bar-click', function() {
    var _this = $(this);
    topFilterClick2($, _this, 'animate');
});

// Next | Prev slider
if (typeof nasa_next_prev === 'undefined') {
    $('body').on('click', '.nasa-nav-icon-slider', function(){
        var _this = $(this);
        var _wrap = $(_this).parents('.nasa-slider-wrap');
        var _slider = $(_wrap).find('.nasa-slider');
        if ($(_slider).length) {
            var _do = $(_this).attr('data-do');
            switch (_do) {
                case 'next':
                    $(_slider).find('.owl-nav .owl-next').trigger('click');
                    break;
                case 'prev':
                    $(_slider).find('.owl-nav .owl-prev').trigger('click');
                    break;
                default: break;
            }
        }
    });
}
/*
 * Init nasa git featured
 */
initThemeNasaGiftFeatured($);

/*
 * Event nasa git featured
 */
$('body').on('click', '.nasa-gift-featured-event', function() {
    var _wrap = $(this).parents('.product-item');
    if ($(_wrap).find('.nasa-product-grid .btn-combo-link').length === 1) {
        $(_wrap).find('.nasa-product-grid .btn-combo-link').trigger('click');
    } else {
        if ($(_wrap).find('.nasa-product-list .btn-combo-link').length === 1) {
            $(_wrap).find('.nasa-product-list .btn-combo-link').trigger('click');
        }
    }
});

/**
 * Carousel combo gift product single summary
 */
if ($('.nasa-content-combo-gift .nasa-combo-slider').length) {
    var _carousel = $('.nasa-content-combo-gift .nasa-combo-slider');
    loadCarouselCombo($, _carousel, 4);
}

/**
 * static-block-wrapper => SUPPORT
 */
if ($('.site-header .static-block-wrapper').find('.support-show').length === 1) {
    $('body').on('click', '.site-header .static-block-wrapper .support-show', function() {
        if ($('.site-header .static-block-wrapper').find('.nasa-transparent-topbar').length <= 0) {
            $('.site-header .static-block-wrapper').append('<div class="nasa-transparent-topbar"></div>');
        }
        
        if ($('.site-header .static-block-wrapper').find('.support-hide').length === 1) {
            if (!$('.site-header .static-block-wrapper .support-hide').hasClass('active')) {
                $('.static-block-wrapper .support-hide').addClass('active').fadeIn(300);
                $('.site-header .static-block-wrapper .nasa-transparent-topbar').show();
            } else {
                $('.static-block-wrapper .support-hide').removeClass('active').fadeOut(300);
                $('.site-header .static-block-wrapper .nasa-transparent-topbar').hide();
            }
        }
    });
    
    $('body').on('click', '.site-header .static-block-wrapper .nasa-transparent-topbar', function() {
        $('.static-block-wrapper .support-hide').removeClass('active').fadeOut(300);
        $('.site-header .static-block-wrapper .nasa-transparent-topbar').hide();
    });
}

/**
 * Change language
 */
if ($('.nasa-current-lang').length) {
    $('body').on('click', '.nasa-current-lang', function() {
        var _wrap = $(this).parents('.nasa-select-languages');
        if ($(_wrap).length) {
            if ($(_wrap).parents('#nasa-menu-sidebar-content').length === 0) {
                if ($('.static-position').find('.transparent-desktop').length === 0) {
                    $('.static-position').append('<div class="transparent-desktop"></div>');
                }
                
                $('.transparent-desktop').fadeIn(200);
            }
            $(_wrap).toggleClass('nasa-active');
            $('.nasa-select-currencies').removeClass('nasa-active');
        }
        
        return false;
    });
}

/**
 * Change Currencies
 */
if ($('.wcml-cs-item-toggle').length) {
    $('body').on('click', '.wcml-cs-item-toggle', function() {
        var _wrap = $(this).parents('.nasa-select-currencies');
        if ($(_wrap).length) {
            if ($(_wrap).parents('#nasa-menu-sidebar-content').length === 0) {
                if ($('.static-position').find('.transparent-desktop').length === 0) {
                    $('.static-position').append('<div class="transparent-desktop"></div>');
                }
                
                $('.transparent-desktop').fadeIn(200);
            }
            $(_wrap).toggleClass('nasa-active');
            $('.nasa-select-languages').removeClass('nasa-active');
        }
        
        return false;
    });
}

/**
 * Tab reviewer
 */
$('body').on('click', '.nasa-product-details-page .woocommerce-review-link', function() {
    if ($('.nasa-product-details-page .product-details .nasa-tabs-content .reviews_tab > a').length === 1) {
        var _pos_top = $('.nasa-product-details-page .product-details .nasa-tabs-content .reviews_tab').offset().top;
        $('html, body').animate({scrollTop: (_pos_top - 100)}, 500);
        
        setTimeout(function () {
            $('.nasa-product-details-page .product-details .nasa-tabs-content .reviews_tab > a').trigger('click');
            $('.nasa-product-details-page .product-details .nasa-tabs-content .reviews_tab > a').mousemove();
        }, 500);
    }
    
    return false;
});

var _hash = location.hash || null;
if (_hash) {
    if ($('a[href="' + _hash + '"], a[data-id="' + _hash + '"], a[data-target="' + _hash + '"]').length) {
        setTimeout(function() {
            $('a[href="' + _hash + '"], a[data-id="' + _hash + '"], a[data-target="' + _hash + '"]').trigger('click');
        }, 500);
    }
    
    if ($(_hash).length) {
        setTimeout(function() {
            var _pos_top = $(_hash).offset().top;
            $('html, body').animate({scrollTop: (_pos_top - 100)}, 500);
        }, 1000);
    }
}

/**
 * Retina logo
 */
if ($('.nasa-logo-retina').length) {
    var pixelRatio = !!window.devicePixelRatio ? window.devicePixelRatio : 1;
    if (pixelRatio > 1) {
        var _image_width, _image_height;
        var _src_retina = '';
        
        var _init_retina = setInterval(function () {
            $('.nasa-logo-retina img').each(function() {
                var _this = $(this);
                
                if (!$(_this).hasClass('nasa-inited') && $(_this).width() && $(_this).height()) {
                    if (typeof _src_retina === 'undefined' || _src_retina === '') {
                        _src_retina = $(_this).attr('data-src-retina');
                    }

                    if (typeof _src_retina !== 'undefined' && _src_retina !== '') {
                        var _fix_size = $(_this).parents('.nasa-no-fix-size-retina').length === 1 ? false : true;
                        _image_width = _image_height = 'auto';

                        if (_fix_size) {
                            var _w = parseInt($(_this).attr('width'));
                            _image_width = _w ? _w : $(_this).width();

                            var _h = parseInt($(this).attr('height'));
                            _image_height = _h ? _h : $(_this).height();
                        }

                        if ((_image_width && _image_height) || _image_width === 'auto') {
                            $(_this).css("width", _image_width);
                            $(_this).css("height", _image_height);

                            $(_this).attr('src', _src_retina);
                            $(_this).removeAttr('srcset');
                        }
                        
                        $(_this).addClass('nasa-inited');
                    }
                }
                
                if ($('.nasa-logo-retina img').length === $('.nasa-logo-retina img.nasa-inited').length) {
                    clearInterval(_init_retina);
                }
            });
        }, 50);
    }
}

/**
 * nasa-top-cat-filter
 */
initTopCategoriesFilter($);
hoverTopCategoriesFilter($);
hoverChilrenTopCatogoriesFilter($);
$('body').on('click', '.filter-cat-icon', function() {
    var _this_click = $(this);
    
    if (!$(_this_click).hasClass('nasa-disable')) {
        $(_this_click).addClass('nasa-disable');
        $('.nasa-elements-wrap').addClass('nasa-invisible');
        $('#header-content .nasa-top-cat-filter-wrap').addClass('nasa-show');
        if ($('.nasa-has-filter-ajax').length <= 0) {
            $('.header-wrapper .nasa-top-cat-filter-wrap').before('<div class="nasa-tranparent-filter nasa-hide-for-mobile" />');
        }
        
        setTimeout(function() {
            $(_this_click).removeClass('nasa-disable');
        }, 600);
    }
});

$('body').on('click', '.filter-cat-icon-mobile', function() {
    var _this_click = $(this);
    var _mobileDetect = $('body').hasClass('nasa-in-mobile') || $('input[name="nasa_mobile_layout"]').length ? true : false;
    
    if (!$(_this_click).hasClass('nasa-disable')) {
        $(_this_click).addClass('nasa-disable');
        $('.nasa-top-cat-filter-wrap-mobile').addClass('nasa-show');
        $('.transparent-mobile').fadeIn(300);
        
        setTimeout(function() {
            $(_this_click).removeClass('nasa-disable');
        }, 600);
        
        var _mobileView = $('.nasa-check-reponsive.nasa-switch-check').length && $('.nasa-check-reponsive.nasa-switch-check').width() === 1 ? true : false;
        
        if ((_mobileView || _mobileDetect) && $('.nasa-top-cat-filter-wrap-mobile').find('.nasa-top-cat-filter').length <= 0) {
            if ($('#nasa-main-cat-filter').length && $('#nasa-mobile-cat-filter').length) {
                var _mobile_cats_filter = $('#nasa-main-cat-filter').clone().html();
                $('#nasa-mobile-cat-filter').html(_mobile_cats_filter);
                
                if (_mobileDetect) {
                    $('#nasa-main-cat-filter').remove();
                }
            }
        }
    }
});

$('body').on('click', '.nasa-close-filter-cat, .nasa-tranparent-filter', function(){
    $('.nasa-elements-wrap').removeClass('nasa-invisible');
    $('#header-content .nasa-top-cat-filter-wrap').removeClass('nasa-show');
    $('.nasa-tranparent-filter').remove();
});

/**
 * Show coupon in shopping cart
 */
$('body').on('click', '.nasa-show-coupon', function() {
    if ($('.nasa-coupon-wrap').length === 1) {
        $('.nasa-coupon-wrap').toggleClass('nasa-active');
        setTimeout(function() {
            $('.nasa-coupon-wrap.nasa-active input[name="coupon_code"]').focus();
        }, 100);
    }
});

/**
 * Clone group btn for list layout
 */
cloneGroupBtnsProductItem($);

/**
 * Scroll single product
 */
loadScrollSingleProduct($);

/**
 * nasa-products-masonry-isotope
 */
loadProductsMasonryIsotope($, false, true);

/**
 * nasa-posts-masonry-isotope
 */
loadPostsMasonryIsotope($);

/**
 * init Mini wishlist icon
 */
initMiniWishlist($);

/**
 * init wishlist icon
 */
initWishlistIcons($);

/**
 * init Compare icons
 */
initCompareIcons($, true);

/**
 * Topbar toggle
 */
if ($('.nasa-topbar-wrap.nasa-topbar-toggle').length) {
    $('body').on('click', '.nasa-topbar-wrap .nasa-icon-toggle', function() {
        var _wrap = $(this).parents('.nasa-topbar-wrap');
        $(_wrap).toggleClass('nasa-topbar-hide');
    });
}

$('body').on('click', '.black-window-mobile', function() {
    $(this).removeClass('nasa-push-cat-show');
    $('.nasa-push-cat-filter').removeClass('nasa-push-cat-show');
    $('.nasa-products-page-wrap').removeClass('nasa-push-cat-show');
});

$('body').on('click', '.nasa-widget-show-more a.nasa-widget-toggle-show', function() {
    var _showed = $(this).attr('data-show');
    var _text = '';
    
    if (_showed === '0') {
        _text = $('input[name="nasa-widget-show-less-text"]').length ? $('input[name="nasa-widget-show-less-text"]').val() : 'Less -';
        $(this).attr('data-show', '1');
        $('.nasa-widget-toggle.nasa-widget-show-less').addClass('nasa-widget-show');
    } else {
        _text = $('input[name="nasa-widget-show-more-text"]').length ? $('input[name="nasa-widget-show-more-text"]').val() : 'More +';
        $(this).attr('data-show', '0');
        $('.nasa-widget-toggle.nasa-widget-show-less').removeClass('nasa-widget-show');
    }
    
    $(this).html(_text);
});

$('body').on('click', '.nasa-mobile-icons-wrap .nasa-toggle-mobile_icons', function() {
    $(this).parents('.nasa-mobile-icons-wrap').toggleClass('nasa-hide-icons');
});

/* Product Gallery Popup */
loadGalleryPopup($);

/**
 * Default init Single galerry
 */
if ($('.nasa-product-details-page .nasa-gallery-variation-supported').length === 1) {
    _single_variations[0] = {
        'main_image': $('.nasa-main-image-default-wrap').html(),
        'thumb_image': $('.nasa-thumbnail-default-wrap').html()
    };
}

/**
 * Load single product image
 */
loadSlickSingleProduct($);

/**
 * Single Product
 * Variable change image
 */
$('.nasa-product-details-page form.variations_form').on('found_variation', function(e, variation) {
    var _form = $(this);
    if ($('.nasa-product-details-page .nasa-gallery-variation-supported').length === 1) {
        changeGalleryVariableSingleProduct($, _form, variation);
    } else {
        setTimeout(function() {
            changeImageVariableSingleProduct($, _form, variation);
        }, 10);
    }
});

$('.nasa-product-details-page form.variations_form').on('reset_data', function() {
    var _form = $(this);
    if ($('.nasa-product-details-page .nasa-gallery-variation-supported').length) {
        changeGalleryVariableSingleProduct($, _form, null);
    } else {
        setTimeout(function() {
            changeImageVariableSingleProduct($, _form, null);
        }, 10);
    }
});

/* Product Gallery Popup */
$('body').on('click', '.product-lightbox-btn', function(e){
    if ($('.nasa-single-product-slide').length) {
        $('.product-images-slider').find('.slick-current.slick-active a').trigger('click');
    }

    else if ($('.nasa-single-product-scroll').length) {
        $('#nasa-main-image-0 a').trigger('click');
    }

    e.preventDefault();
});

/* Product Video Popup */
$('body').on('click', "a.product-video-popup", function(e){
    if (! $('body').hasClass('nasa-disable-lightbox-image')) {
        $('.product-images-slider').find('.first a').trigger('click');
        var galeryPopup = $.magnificPopup.instance;
        galeryPopup.prev();
    }
    else {
        var productVideo = $(this).attr('href');
        $.magnificPopup.open({
            items: {
                src: productVideo
            },
            type: 'iframe',
            tLoading: '<div class="nasa-loader"></div>'
        }, 0);
    }
    
    e.preventDefault();
});

/**
 * Fixed Single form add to cart
 */
if ($('input[name="nasa_fixed_single_add_to_cart"]').length && $('.nasa-product-details-page').length) {
    var _mobile_fixed_addToCart = 'no';
    if ($('input[name="nasa_fixed_mobile_single_add_to_cart_layout"]').length) {
        _mobile_fixed_addToCart = $('input[name="nasa_fixed_mobile_single_add_to_cart_layout"]').val();
    }
    var _can_render = true;
    if (_nasa_in_mobile && (_mobile_fixed_addToCart === 'no' || _mobile_fixed_addToCart === 'btn')) {
        _can_render = false;
        $('body').addClass('nasa-cart-fixed-desktop');
    }
    if (_mobile_fixed_addToCart === 'btn') {
        $('body').addClass('nasa-cart-fixed-mobile-btn');
        
        if ($('.nasa-buy-now').length) {
            $('body').addClass('nasa-has-buy-now');
        }
    }
    
    /**
     * Render in desktop
     */
    if (_can_render && $('.nasa-add-to-cart-fixed').length <= 0) {
        $('body').append('<div class="nasa-add-to-cart-fixed"><div class="nasa-wrap-content-inner"><div class="nasa-wrap-content"></div></div></div>');

        if (_mobile_fixed_addToCart === 'no' || _mobile_fixed_addToCart === 'btn') {
            $('.nasa-add-to-cart-fixed').addClass('nasa-not-show-mobile');
            $('body').addClass('nasa-cart-fixed-desktop');
        }

        var _addToCartWrap = $('.nasa-add-to-cart-fixed .nasa-wrap-content');

        /**
         * Main Image clone
         */
        $(_addToCartWrap).append('<div class="nasa-fixed-product-info"></div>');

        if ($('.nasa-product-details-page .product-thumbnails').length) {
            var _src = $('.nasa-product-details-page .product-thumbnails .nasa-wrap-item-thumb:eq(0)').attr('data-thumb_org') || $('.nasa-product-details-page .product-thumbnails .nasa-wrap-item-thumb:eq(0) img').attr('src');

            $('.nasa-fixed-product-info').append('<div class="nasa-thumb-clone"><img src="' + _src + '" /></div>');
        }

        /**
         * Title clone
         */
        if ($('.nasa-product-details-page .product-info .product_title').length) {
            var _title = $('.nasa-product-details-page .product-info .product_title').html();

            $('.nasa-fixed-product-info').append('<div class="nasa-title-clone"><h3>' + _title +'</h3></div>');
        }

        /**
         * Price clone
         */
        if ($('.nasa-product-details-page .product-info .price').length) {
            var _price = $('.nasa-product-details-page .product-info .price').html();
            if ($('.nasa-title-clone').length) {
                $('.nasa-title-clone').append('<span class="price">' + _price + '</span>');
            }
            else {
                $('.nasa-fixed-product-info').append('<div class="nasa-title-clone"><span class="price">' + _price + '</span></div>');
            }
        }

        /**
         * Variations clone
         */
        if ($('.nasa-product-details-page .variations_form').length) {
            $(_addToCartWrap).append('<div class="nasa-fixed-product-variations-wrap"><div class="nasa-fixed-product-variations"></div><a class="nasa-close-wrap" href="javascript:void(0);"></a></div>');

            /**
             * Variations
             * 
             * @type type
             */
            var _k = 1,
                _item = 1;
            $('.nasa-product-details-page .variations_form .variations tr').each(function() {
                var _this = $(this);
                var _classWrap = 'nasa-attr-wrap-' + _k.toString();
                var _type = $(_this).find('select').attr('data-attribute_name') || $(_this).find('select').attr('name');

                if ($(_this).find('.nasa-attr-ux_wrap').length) {
                    $('.nasa-fixed-product-variations').append('<div class="nasa-attr-ux_wrap-clone ' + _classWrap + '"></div>');

                    $(_this).find('.nasa-attr-ux').each(function () {
                        var _obj = $(this);
                        var _classItem = 'nasa-attr-ux-' + _item.toString();
                        var _classItemClone = 'nasa-attr-ux-clone-' + _item.toString();
                        var _classItemClone_target = _classItemClone;

                        if ($(_obj).hasClass('nasa-attr-ux-image')) {
                            _classItemClone += ' nasa-attr-ux-image-clone';
                        }

                        if ($(_obj).hasClass('nasa-attr-ux-color')) {
                            _classItemClone += ' nasa-attr-ux-color-clone';
                        }

                        if ($(_obj).hasClass('nasa-attr-ux-label')) {
                            _classItemClone += ' nasa-attr-ux-label-clone';
                        }

                        var _selected = $(_obj).hasClass('selected') ? ' selected' : '';
                        var _contentItem = $(_obj).html();

                        $(_obj).addClass(_classItem);
                        $(_obj).attr('data-target', '.' + _classItemClone_target);

                        $('.nasa-attr-ux_wrap-clone.' + _classWrap).append('<a href="javascript:void(0);" class="nasa-attr-ux-clone' + _selected + ' ' + _classItemClone + ' nasa-' + _type + '" data-target=".' + _classItem + '">' + _contentItem + '</a>');

                        _item++;
                    });
                } else {
                    $('.nasa-fixed-product-variations').append('<div class="nasa-attr-select_wrap-clone ' + _classWrap + '"></div>');

                    var _obj = $(_this).find('select');

                    var _label = $(_this).find('.label').length ? $(_this).find('.label').html() : '';

                    var _classItem = 'nasa-attr-select-' + _item.toString();
                    var _classItemClone = 'nasa-attr-select-clone-' + _item.toString();

                    var _contentItem = $(_obj).html();

                    $(_obj).addClass(_classItem).addClass('nasa-attr-select');
                    $(_obj).attr('data-target', '.' + _classItemClone);

                    $('.nasa-attr-select_wrap-clone.' + _classWrap).append(_label + '<select name="' + _type + '" class="nasa-attr-select-clone ' + _classItemClone + ' nasa-' + _type + '" data-target=".' + _classItem + '">' + _contentItem + '</select>');

                    _item++;
                }

                _k++;
            });
        }
        /**
         * Class wrap simple product
         */
        else {
            $(_addToCartWrap).addClass('nasa-fixed-single-simple');
        }

        /**
         * Add to cart button
         */
        setTimeout(function() {
            var _button_wrap = nasa_clone_add_to_cart($);
            $(_addToCartWrap).append('<div class="nasa-fixed-product-btn"></div>');
            $('.nasa-fixed-product-btn').html(_button_wrap);
            var _val = $('.nasa-product-details-page form.cart input[name="quantity"]').val();
            $('.nasa-single-btn-clone input[name="quantity"]').val(_val);
        }, 250);

        setTimeout(function() {
            if ($('.nasa-attr-ux').length) {
                $('.nasa-attr-ux').each(function() {
                    var _this = $(this);
                    var _targetThis = $(_this).attr('data-target');

                    if ($(_targetThis).length) {
                        var _disable = $(_this).hasClass('nasa-disable') ? true : false;
                        if (_disable) {
                            if (!$(_targetThis).hasClass('nasa-disable')) {
                                $(_targetThis).addClass('nasa-disable');
                            }
                        } else {
                            $(_targetThis).removeClass('nasa-disable');
                        }
                    }
                });
            }
        }, 550);

        /**
         * Change Ux
         */
        $('body').on('click', '.nasa-attr-ux', function() {
            var _target = $(this).attr('data-target');
            if ($(_target).length) {
                var _wrap = $(_target).parents('.nasa-attr-ux_wrap-clone');
                $(_wrap).find('.nasa-attr-ux-clone').removeClass('selected');
                if ($(this).hasClass('selected')) {
                    $(_target).addClass('selected');
                }

                if ($('.nasa-fixed-product-btn').length) {
                    setTimeout(function() {
                        var _button_wrap = nasa_clone_add_to_cart($);
                        $('.nasa-fixed-product-btn').html(_button_wrap);
                        var _val = $('.nasa-product-details-page form.cart input[name="quantity"]').val();
                        $('.nasa-single-btn-clone input[name="quantity"]').val(_val);
                    }, 250);
                }

                setTimeout(function() {
                    if ($('.nasa-attr-ux').length) {
                        $('.nasa-attr-ux').each(function() {
                            var _this = $(this);
                            var _targetThis = $(_this).attr('data-target');

                            if ($(_targetThis).length) {
                                var _disable = $(_this).hasClass('nasa-disable') ? true : false;
                                if (_disable) {
                                    if (!$(_targetThis).hasClass('nasa-disable')) {
                                        $(_targetThis).addClass('nasa-disable');
                                    }
                                } else {
                                    $(_targetThis).removeClass('nasa-disable');
                                }
                            }
                        });
                    }
                }, 250);
            }
        });

        /**
         * Change Ux clone
         */
        $('body').on('click', '.nasa-attr-ux-clone', function() {
            var _target = $(this).attr('data-target');
            if ($(_target).length) {
                $(_target).trigger('click');
            }
        });

        /**
         * Change select
         */
        $('body').on('change', '.nasa-attr-select', function() {
            var _this = $(this);
            var _target = $(_this).attr('data-target');
            var _value = $(_this).val();

            if ($(_target).length) {
                setTimeout(function() {
                    var _html = $(_this).html();
                    $(_target).html(_html);
                    $(_target).val(_value);
                }, 100);

                setTimeout(function() {
                    var _button_wrap = nasa_clone_add_to_cart($);
                    $('.nasa-fixed-product-btn').html(_button_wrap);
                    var _val = $('.nasa-product-details-page form.cart input[name="quantity"]').val();
                    $('.nasa-single-btn-clone input[name="quantity"]').val(_val);

                    if ($('.nasa-attr-ux').length) {
                        $('.nasa-attr-ux').each(function() {
                            var _this = $(this);
                            var _targetThis = $(_this).attr('data-target');

                            if ($(_targetThis).length) {
                                var _disable = $(_this).hasClass('nasa-disable') ? true : false;
                                if (_disable) {
                                    if (!$(_targetThis).hasClass('nasa-disable')) {
                                        $(_targetThis).addClass('nasa-disable');
                                    }
                                } else {
                                    $(_targetThis).removeClass('nasa-disable');
                                }
                            }
                        });
                    }
                }, 250);
            }
        });

        /**
         * Change select clone
         */
        $('body').on('change', '.nasa-attr-select-clone', function() {
            var _target = $(this).attr('data-target');
            var _value = $(this).val();
            if ($(_target).length) {
                $(_target).val(_value).change();
            }
        });

        /**
         * Reset variations
         */
        $('body').on('click', '.reset_variations', function() {
            $(_addToCartWrap).find('.selected').removeClass('selected');

            setTimeout(function() {
                var _button_wrap = nasa_clone_add_to_cart($);
                $('.nasa-fixed-product-btn').html(_button_wrap);
                var _val = $('.nasa-product-details-page form.cart input[name="quantity"]').val();
                $('.nasa-single-btn-clone input[name="quantity"]').val(_val);

                if ($('.nasa-attr-ux').length) {
                    $('.nasa-attr-ux').each(function() {
                        var _this = $(this);
                        var _targetThis = $(_this).attr('data-target');

                        if ($(_targetThis).length) {
                            var _disable = $(_this).hasClass('nasa-disable') ? true : false;
                            if (_disable) {
                                if (!$(_targetThis).hasClass('nasa-disable')) {
                                    $(_targetThis).addClass('nasa-disable');
                                }
                            } else {
                                $(_targetThis).removeClass('nasa-disable');
                            }
                        }
                    });
                }
            }, 250);
        });

        /**
         * Plus, Minus button
         */
        $('body').on('click', '.nasa-product-details-page form.cart .quantity .plus, .nasa-product-details-page form.cart .quantity .minus', function() {
            if ($('.nasa-single-btn-clone input[name="quantity"]').length) {
                var _val = $('.nasa-product-details-page form.cart input[name="quantity"]').val();
                $('.nasa-single-btn-clone input[name="quantity"]').val(_val);
            }
        });

        /**
         * Plus clone button
         */
        $('body').on('click', '.nasa-single-btn-clone .plus', function() {
            if ($('.nasa-product-details-page form.cart .quantity .plus').length) {
                $('.nasa-product-details-page form.cart .quantity .plus').trigger('click');
            }
        });

        /**
         * Minus clone button
         */
        $('body').on('click', '.nasa-single-btn-clone .minus', function() {
            if ($('.nasa-product-details-page form.cart .quantity .minus').length) {
                $('.nasa-product-details-page form.cart .quantity .minus').trigger('click');
            }
        });

        /**
         * Quantily input
         */
        $('body').on('keyup', '.nasa-product-details-page form.cart input[name="quantity"]', function() {
            var _val = $(this).val();
            $('.nasa-single-btn-clone input[name="quantity"]').val(_val);
        });

        /**
         * Quantily input clone
         */
        $('body').on('keyup', '.nasa-single-btn-clone input[name="quantity"]', function() {
            var _val = $(this).val();
            $('.nasa-product-details-page form.cart input[name="quantity"]').val(_val);
        });

        /**
         * Add to cart click
         */
        $('body').on('click', '.nasa-single-btn-clone .single_add_to_cart_button', function(){
            if ($('.nasa-product-details-page form.cart .single_add_to_cart_button').length) {
                $('.nasa-product-details-page form.cart .single_add_to_cart_button').trigger('click');
            }
        });

        /**
         * Toggle Select Options
         */
        $('body').on('click', '.nasa-toggle-variation_wrap-clone', function() {
            if ($('.nasa-fixed-product-variations-wrap').length) {
                $('.nasa-fixed-product-variations-wrap').toggleClass('nasa-active');
            }
        });
        $('body').on('click', '.nasa-close-wrap', function() {
            if ($('.nasa-fixed-product-variations-wrap').length) {
                $('.nasa-fixed-product-variations-wrap').removeClass('nasa-active');
            }
        });
    }
}

/**
 * Buy Now
 */
$('body').on('click', '.nasa-buy-now', function() {
    if (!$(this).hasClass('nasa-waiting')) {
        $(this).addClass('nasa-waiting');
        
        var _form = $(this).parents('form.cart');
        if ($(_form).find('.single_add_to_cart_button.disabled').length) {
            $(_form).find('.single_add_to_cart_button.disabled').trigger('click');
            $(this).removeClass('nasa-waiting');
        } else {
            if ($(_form).find('input[name="nasa_buy_now"]').length) {
                if ($('input[name="nasa-enable-addtocart-ajax"]').length) {
                    $('input[name="nasa-enable-addtocart-ajax"]').val('0');
                }
                $(_form).find('input[name="nasa_buy_now"]').val('1');
                $(_form).find('.single_add_to_cart_button').trigger('click');
            }
        }
    }
    
    return false;
});

/**
 * Toggle Widget
 */
$('body').on('click', '.nasa-toggle-widget', function() {
    var _this = $(this);
    var _widget = $(_this).parents('.widget');
    var _key = $(_widget).attr('id');
    
    if ($(_widget).length && $(_widget).find('.nasa-open-toggle').length) {
        var _hide = $(_this).hasClass('nasa-hide');
        if (!_hide) {
            $(_this).addClass('nasa-hide');
            $(_widget).find('.nasa-open-toggle').slideUp(200);
            $.cookie(_key, 'hide', {expires: 7, path: '/'});
        } else {
            $(_this).removeClass('nasa-hide');
            $(_widget).find('.nasa-open-toggle').slideDown(200);
            $.cookie(_key, 'show', {expires: 7, path: '/'});
        }
    }
});

/**
 * init Widgets
 */
init_widgets($);

/**
 * Toggle Sidebar
 */
if ($('.nasa-with-sidebar-classic').length && $('.nasa-toogle-sidebar-classic').length) {
    var toggle_show = $.cookie('toggle_sidebar_classic');
    if (toggle_show === 'hide') {
        $('.nasa-toogle-sidebar-classic').addClass('nasa-hide');
        $('.nasa-with-sidebar-classic').addClass('nasa-with-sidebar-hide');
    } else {
        $('.nasa-toogle-sidebar-classic').removeClass('nasa-hide');
        $('.nasa-with-sidebar-classic').removeClass('nasa-with-sidebar-hide');
    }
    
    setTimeout(function() {
        $('.nasa-category-page-wrap').removeClass('nasa-invisible');
        loadProductsMasonryIsotope($, true);
    }, 500);
}

if ($('.nasa-category-page-wrap').length) {
    $('.nasa-category-page-wrap').removeClass('nasa-invisible');
}

$('body').on('click', '.nasa-toogle-sidebar-classic', function() {
    if ($('.nasa-with-sidebar-classic').length) {
        var _this = $(this);
        var _show = $(_this).hasClass('nasa-hide') ? 'show' : 'hide';
        
        /**
         * Set cookie in 7 days
         */
        $.cookie('toggle_sidebar_classic', _show, {expires: 7, path: '/'});
        
        /**
         * Show sidebar
         */
        if (_show === 'show') {
            $(_this).removeClass('nasa-hide');
            $('.nasa-with-sidebar-classic').removeClass('nasa-with-sidebar-hide');
        }
        
        /**
         * Hide sidebar
         */
        else {
            $(_this).addClass('nasa-hide');
            $('.nasa-with-sidebar-classic').addClass('nasa-with-sidebar-hide');
        }
        
        /**
         * Refresh Carousel
         */
        if (typeof _refresCarousel !== 'undefined') {
            clearTimeout(_refresCarousel);
        }
        
        var _refresCarousel = setTimeout(function() {
            loadProductsMasonryIsotope($, true);
            
            refreshCarousel($);
            
            init_product_quickview_addtocart($, true);
        }, 500);
    }
    
    return false;
});

/**
 * init Select2
 */
init_select2($);

/**
 * Hover product-item
 */
$('body').on('hover', '.product-item', function() {
    var _this = $(this);
    if ($(_this).parents('.nasa-slider-grid').length) {
        var _slide = $(_this).parents('.nasa-slider-grid');
        $(_slide).removeClass('nasa-processed');
        load_intival_fix_carousel($, 50);
    } 
});

/**
 * Init change view order by classic sidebar shop
 */
init_changeview_order_classic($);

/**
 * Next | Prev products
 */
init_product_arrow($);

/**
 * Quick view | Add to cart
 */
init_product_quickview_addtocart($);

/**
 * Init btns for list
 */
init_group_btn_list($);

/**
 * Check accessories product
 */
$('body').on('change', '.nasa-check-accessories-product', function () {
    var _urlAjax = null;
    if (
        typeof nasa_ajax_params !== 'undefined' &&
        typeof nasa_ajax_params.wc_ajax_url !== 'undefined'
    ) {
        _urlAjax = nasa_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', 'nasa_refresh_accessories_price');
    }
    
    if (_urlAjax) {
        var _this = $(this);
        
        var _wrap = $(_this).parents('.nasa-accessories-check');

        var _id = $(_this).val();
        var _isChecked = $(_this).is(':checked');
        
        var _price = $(_wrap).find('.nasa-check-main-product').length ? parseInt($(_wrap).find('.nasa-check-main-product').attr('data-price')) : 0;
        if ($(_wrap).find('.nasa-check-accessories-product').length) {
            $(_wrap).find('.nasa-check-accessories-product').each(function() {
                if ($(this).is(':checked')) {
                    _price += parseInt($(this).attr('data-price'));
                }
            });
        }
        
        $.ajax({
            url: _urlAjax,
            type: 'post',
            dataType: 'json',
            cache: false,
            data: {
                total_price: _price
            },
            beforeSend: function () {
                $(_wrap).append('<div class="nasa-disable-wrap"></div><div class="nasa-loader"></div>');
            },
            success: function (res) {
                if (typeof res.total_price !== 'undefined') {
                    $('.nasa-accessories-total-price .price').html(res.total_price);
                    
                    if (!_isChecked) {
                        $('.nasa-accessories-' + _id).fadeOut(200);
                    } else {
                        $('.nasa-accessories-' + _id).fadeIn(200);
                    }
                }

                $(_wrap).find('.nasa-loader, .nasa-disable-wrap').remove();
            },
            error: function () {

            }
        });
    }
});

/**
 * Add To cart accessories
 */
$('body').on('click', '.add_to_cart_accessories', function() {
    var _urlAjax = null;
    if (
        typeof nasa_ajax_params !== 'undefined' &&
        typeof nasa_ajax_params.wc_ajax_url !== 'undefined'
    ) {
        _urlAjax = nasa_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', 'nasa_add_to_cart_accessories');
    }
    
    if (_urlAjax) {
        var _this = $(this);
        
        var _wrap = $(_this).parents('#nasa-tab-accessories_content');
        var _wrapCheck = $(_wrap).find('.nasa-accessories-check');
        
        if ($(_wrapCheck).length) {
            var _pid = [];

            // nasa-check-main-product
            if ($(_wrapCheck).find('.nasa-check-main-product').length) {
                _pid.push($(_wrapCheck).find('.nasa-check-main-product').val());
            }

            // nasa-check-accessories-product
            if ($(_wrapCheck).find('.nasa-check-accessories-product').length) {
                $(_wrapCheck).find('.nasa-check-accessories-product').each(function() {
                    if ($(this).is(':checked')) {
                        _pid.push($(this).val());
                    }
                });
            }

            if (_pid.length) {
                $.ajax({
                    url: _urlAjax,
                    type: 'post',
                    dataType: 'json',
                    cache: false,
                    data: {
                        product_ids: _pid
                    },
                    beforeSend: function () {
                        $('.nasa-message-error').hide();
                        $(_wrap).append('<div class="nasa-disable-wrap"></div><div class="nasa-loader"></div>');
                    },
                    success: function (data) {
                        if (data && data.fragments) {
                            $.each(data.fragments, function(key, value) {
                                $(key).replaceWith(value);
                            });

                            $('.cart-link').trigger('click');
                        } else {
                            if (data && data.error) {
                                $('.nasa-message-error').html(data.message);
                                $('.nasa-message-error').show();
                            }
                        }

                        $(_wrap).find('.nasa-loader, .nasa-disable-wrap').remove();
                    },
                    error: function () {
                        $(_wrap).find('.nasa-loader, .nasa-disable-wrap').remove();
                    }
                });
            }
        }
    }
});

/**
 * Lightbox image Single product page
 */
$('body').on('click', '.easyzoom-flyout', function() {
    if (!$('body').hasClass('nasa-disable-lightbox-image')) {
        var _click = $(this).parents('.easyzoom');
        if ($(_click).length && $(_click).find('a.product-image').length) {
            $(_click).find('a.product-image').trigger('click');
        }
    }
});

/**
 * Disabled easyZoom in ipad
 */
if (!/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) && !iOS) {
    $('body').on('touchstart', '*', function() {
        if ($('.product-zoom .easyzoom').length > 0) {
            $('.product-zoom .easyzoom').each(function() {
                var _easyZoom = $(this);
                if (!$(_easyZoom).hasClass('nasa-disabled-touchstart')) {
                    var _easyZoom_init = $(_easyZoom).easyZoom();
                    var api_easyZoom = _easyZoom_init.data('easyZoom');
                    api_easyZoom.teardown();

                    $(_easyZoom).addClass('nasa-disabled-touchstart');
                }
            });
        }
    });
}

/**
 * Change text zoom | click lightbox main image
 */
if (!$('body').hasClass('nasa-in-mobile')) {
    var _intavalOver, _timeOutZoom;

    if ($('.nasa-suggested-mouse').length) {
        var _text_origin = $('.nasa-suggested-mouse').attr('data-text_org');

        if (typeof _text_origin === 'undefined' || _text_origin === '') {
            _text_origin = $('.nasa-suggested-mouse').text();
            $('.nasa-suggested-mouse').attr('data-text_org', _text_origin);
        }
    }

    $('body').on('mouseover', '.nasa-item-main-image-wrap', function() {
        var _this = $(this);

        _timeOutZoom = setTimeout(function() {
            if ($('.nasa-suggested-mouse').length) {
                var _text = $('.nasa-suggested-mouse').attr('data-text_change');
                $('.nasa-suggested-mouse').html(_text);
            }

            if ($(_this).find('.easyzoom-flyout').length) {
                if (typeof _intavalOver !== 'undefined') {
                    clearInterval(_intavalOver);
                }

                _intavalOver = setInterval(function() {
                    if ($(_this).find('.easyzoom-flyout').length <= 0) {
                        var _text_origin = $('.nasa-suggested-mouse').attr('data-text_org');
                        $('.nasa-suggested-mouse').html(_text_origin);

                        clearInterval(_intavalOver);
                    }
                }, 50);
            }
        }, 100);
    });

    $('body').on('mouseout', '.nasa-item-main-image-wrap', function() {
        if (typeof _timeOutZoom !== 'undefined') {
            clearTimeout(_timeOutZoom);
        }

        var _text_origin = $('.nasa-suggested-mouse').attr('data-text_org');
        $('.nasa-suggested-mouse').html(_text_origin);
    });
}

/**
 * Notice Woocommerce
 */
if (!$('body').hasClass('woocommerce-cart')) {
    $('.woocommerce-notices-wrapper').each(function() {
        var _this = $(this);
        setTimeout(function() {
            if ($(_this).find('a').length <= 0) {
                $(_this).html('');
            }
            
            if ($(_this).find('.woocommerce-message').length) {
                $(_this).find('.woocommerce-message').each(function() {
                    if ($(this).find('a').length <= 0) {
                        $(this).fadeOut(200);
                    }
                });
            }
        }, 3000);
    });
}

if ($('.woocommerce-notices-wrapper').length) {
    $('.woocommerce-notices-wrapper').each(function() {
        if ($(this).find('*').length) {
            $(this).append('<a class="nasa-close-notice" href="javascript:void(0);"></a>');
        }
    });
}

$('body').on('click', '.woocommerce-notices-wrapper .nasa-close-notice', function() {
    var _this = $(this).parents('.woocommerce-notices-wrapper');
    $(_this).html('');
});

/**
 * Bar icons bottom in mobile detect
 */
if ($('.nasa-bottom-bar-icons').length) {
    if ($('.top-bar-wrap-type-1').length) {
        $('body').addClass('nasa-top-bar-in-mobile');
    }
    
    if ($('.toggle-topbar-shop-mobile, .nasa-toggle-top-bar-click, .toggle-sidebar-shop, .toggle-sidebar').length) {
        $('.nasa-bot-item.nasa-bot-item-sidebar').removeClass('hidden-tag');
    } else {
        $('.nasa-bot-item.nasa-bot-item-search').removeClass('hidden-tag');
    }
    
    $('.nasa-bottom-bar-icons').addClass('nasa-active');
    
    $('body').css({'padding-bottom': $('.nasa-bottom-bar-icons').outerHeight()});
    
    $('body').on('click', '.nasa-bot-icon-sidebar', function() {
        $('.toggle-topbar-shop-mobile, .nasa-toggle-top-bar-click, .toggle-sidebar-shop, .toggle-sidebar').trigger('click');
    });
}

/**
 * Hover product-item in Mobile
 */
$('body').on("touchstart", '.product-item', function() {
    $('.product-item').removeClass('nasa-mobile-hover');
    if (!$(this).hasClass('nasa-mobile-hover')) {
        $(this).addClass('nasa-mobile-hover');
    }
});

/**
 * GDPR Notice
 */
// $.cookie('nasa_gdpr_notice', '0', {expires: 30, path: '/'});
if ($('.nasa-cookie-notice-container').length) {
    var nasa_gdpr_notice = $.cookie('nasa_gdpr_notice');
    if (typeof nasa_gdpr_notice === 'undefined' || !nasa_gdpr_notice || nasa_gdpr_notice === '0') {
        setTimeout(function() {
            $('.nasa-cookie-notice-container').addClass('nasa-active');
        }, 1000);
    }
    
    $('body').on('click', '.nasa-accept-cookie', function() {
        $.cookie('nasa_gdpr_notice', '1', {expires: 30, path: '/'});
        $('.nasa-cookie-notice-container').removeClass('nasa-active');
    });
}

/**
 * Remove title attribute of menu item
 */
$('body').on('mousemove', '.menu-item > a', function() {
    if ($(this).attr('title')) {
        $(this).removeAttr('title');
    }
});

/**
 * notification free shipping
 */
init_shipping_free_notification($);

/**
 * Compatible with FancyProductDesigner
 */
$('body').on('modalDesignerClose', function(ev) {
    setTimeout(function() {
        if ($('.nasa-single-product-thumbnails .nasa-wrap-item-thumb').length) {
            var _src = $('.woocommerce-product-gallery__image img').attr('src');
            $('.nasa-single-product-thumbnails .nasa-wrap-item-thumb:first-child img').attr('src', _src);
            $('.nasa-single-product-thumbnails .nasa-wrap-item-thumb:first-child img').removeAttr('srcset');
        }
    }, 100);
});

// Back url with Ajax Call
$(window).on('popstate', function() {
    if ($('.nasa-has-filter-ajax').length) {
        location.reload(true);
    }
});

/* End Document Ready */
});
