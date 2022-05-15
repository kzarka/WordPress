var product_load_flag = false;
var portfolio_load_flag = false;
var portfolio_page = 1;
var nasa_ajax_setup = true;
var nasa_iOS = nasa_check_iOS(),
    _event = (nasa_iOS) ? 'click, mousemove' : 'click';
var nasa_next_prev = true;
var nasa_countdown_init = '0';
var changeDVnasa = 848;

/* =========== Document nasa-core ready ==================== */
jQuery(document).ready(function ($) {
    "use strict";

    loadCorouselHasThumbs($);
    loadingSlickHasExtraVerticalNasaCore($);
    loadingSlickVerticalCategories($);
    loadingSlickSlidersNasaCore($);
    loadingSlickSliders_TitleNasaCore($);
    initVariablesProducts($);
    nasa_intival_fix_carousel($);
    nasa_fix_deal_nav_2($);
    
    /**
     * Tag clouds
     */
    nasaRenderTagClouds($);
    
    $('body').on('nasa_after_load_ajax', function(){
        setTimeout(function () {
            initVariablesProducts($);
            
            if ($('.nasa-product-content-variable-warp').length) {
                $('.nasa-product-content-variable-warp').each(function() {
                    var _this = $(this);
                    if (!$(_this).hasClass('nasa-inited')) {
                        $(_this).addClass('nasa-inited');
                        change_image_content_product_variable($, _this, false);
                    }
                });
            }
        }, 100);
        
        /**
         * Reload Select 2
         */
        nasa_init_select2($);
        nasa_init_filter_nasa_categories($);
    });
    
    /**
     * Btn add to cart select option to quick view
     */
    $('body').on('click', '.ajax_add_to_cart_variable', function(){
        if ($('input[name="nasa-disable-quickview-ux"]').length <= 0 || $('input[name="nasa-disable-quickview-ux"]').val() === '0') {
            $(this).parent().find('.quick-view').trigger('click');
            return false;
        } else {
            return;
        }
    });

    /* AJAX PRODUCT */
    $('body').on('click', '.load-more-btn', function () {
        var _urlAjax = null;
        if (
            typeof nasa_ajax_params !== 'undefined' &&
            typeof nasa_ajax_params.wc_ajax_url !== 'undefined'
        ) {
            _urlAjax = nasa_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', 'nasa_more_product');
        }

        if (_urlAjax) {
            if (product_load_flag) {
                return;
            } else {
                product_load_flag = true;
                var _this = $(this),
                    _wrap = $(_this).parents('.nasa-products-infinite-wrap'),
                    _infinite = $(_wrap).find('.nasa-products-infinite'),
                    _type = $(_infinite).attr('data-product-type'),
                    _page = parseInt($(_infinite).attr('data-next-page')),
                    _cat = $(_infinite).attr('data-cat'),
                    _post_per_page = parseInt($(_infinite).attr('data-post-per-page')),
                    _post_per_row = parseInt($(_infinite).attr('data-post-per-row')),
                    _post_per_row_medium = parseInt($(_infinite).attr('data-post-per-row-medium')),
                    _post_per_row_small = parseInt($(_infinite).attr('data-post-per-row-small')),
                    _max_pages = parseInt($(_infinite).attr('data-max-pages'));
                _cat = !_cat ? null : _cat;
                $.ajax({
                    url: _urlAjax,
                    type: 'post',
                    cache: false,
                    data: {
                        page: _page,
                        type: _type,
                        cat: _cat,
                        post_per_page: _post_per_page,
                        columns_number: _post_per_row,
                        columns_number_medium: _post_per_row_medium,
                        columns_number_small: _post_per_row_small,
                        nasa_load_ajax: '1'
                    },
                    beforeSend: function () {
                        $(_this).before('<div class="nasa-loader" id="nasa-loader-product-infinite"></div>');
                        if (!$(_this).find('.load-more-text').hasClass('nasa-loadding')) {
                            $(_this).find('.load-more-text').addClass('nasa-loadding');
                        }
                    },
                    success: function (res) {
                        if (typeof res.success !== 'undefined' && res.success === '1') {
                            var _content = res.content;

                            $(_infinite).find('.nasa-row-child-clear-none').append(_content).fadeIn(1000);
                            $(_infinite).attr('data-next-page', _page + 1);
                            $('#nasa-loader-product-infinite').remove();
                            $(_this).find('.load-more-text').removeClass('nasa-loadding');
                            if (_page == _max_pages) {
                                $(_this).addClass('end-product');
                                $(_this).html('<span class="nasa-end-content">' + $(_this).attr('data-nodata') + '</span>').removeClass('load-more-btn');
                            }

                            setTimeout(function(){
                                nasa_load_ajax_funcs($);
                            }, 1000);
                            
                            product_load_flag = false;
                            
                            $('body').trigger('nasa_after_load_ajax');
                        }
                    }
                });

                return false;
            }
        }
    });

    // **********************************************************************// 
    // ! Portfolio
    // **********************************************************************//
    if ($('.portfolio-list').length > 0 && $('input[name="nasa-enable-portfolio"]').length === 1 && $('input[name="nasa-enable-portfolio"]').val() === '1') {
        var _ltr = $('body').hasClass('nasa-rtl') ? false : true;
        var _columns = $('.portfolio-list').attr('data-columns');
        var portfolioGrid = $('.portfolio-list');

        $(portfolioGrid).isotope({
            itemSelector: '.portfolio-item',
            layoutMode: 'masonry',
            filter: '*',
            isOriginLeft: _ltr
        });

        if ($(portfolioGrid).parents('.nasa-portfolio-wrap').find('.portfolio-tabs li a').length) {
            $(portfolioGrid).parents('.nasa-portfolio-wrap').find('.portfolio-tabs li a').on('click', function () {
                var selector = $(this).attr('data-filter');
                $(portfolioGrid).parents('.nasa-portfolio-wrap').find('.portfolio-tabs li').removeClass('active');
                if (!$(this).parents('li').hasClass('active')) {
                    $(this).parents('li').addClass('active');
                }
                $(portfolioGrid).isotope({filter: selector});
                return false;
            });
        }

        var _cat_id = $('.loadmore-portfolio').attr('data-category');
        portfolio_load_flag = true;
        loadMorePortfolio($, _cat_id, _columns, portfolio_page, ajaxurl);

        // loadMore Portfolio
        $('body').on('click', '.loadmore-portfolio', function () {
            var button = $(this);
            if (portfolio_load_flag) {
                return;
            } else {
                portfolio_load_flag = true;
                var _cat_id = $(button).attr('data-category');
                portfolio_page++;
                loadMorePortfolio($, _cat_id, _columns, portfolio_page);
                return false;
            }
        });
    }

    $('body').on('click', '.portfolio-image-view', function (e) {
        var _src = $(this).attr('data-src');
        $.magnificPopup.open({
            closeOnContentClick: true,
            items: {
                src: '<div class="portfolio-lightbox"><img src="' + _src + '" /></div>',
                type: 'inline'
            }
        });
        $('.please-wait, .color-overlay').remove();
        e.preventDefault();
    });

    /**
     * Reponsive Banners
     * 
     * @type type
     */
    var reponsiveMobile = setTimeout(function() {
        responsiveBanners($);
    }, 50);
    
    $(window).resize(function () {
        clearTimeout(reponsiveMobile);
        reponsiveMobile = setTimeout(function() {
            responsiveBanners($);
        }, 1000);
    });
    
    // Next | Prev slider
    if (nasa_next_prev) {
        
        /**
         * Carousel
         */
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
        
        /**
         * Slick
         */
        $('body').on('click', '.nasa-nav-icon-slick', function(){
            var _this = $(this);
            var _wrap = $(_this).parents('.nasa-slider-wrap');
            var _slider = $(_wrap).find('.nasa-slick-slider-body');
            
            if ($(_slider).length) {
                var _do = $(_this).attr('data-do');
                switch (_do) {
                    case 'next':
                        $(_slider).find('.slick-arrow.slick-next').trigger('click');
                        break;
                    case 'prev':
                        $(_slider).find('.slick-arrow.slick-prev').trigger('click');
                        break;
                    default: break;
                }
            }
        });
    }
    
    $('body').on('click', '.nasa-slider-deal-vertical-extra-switcher .item-slick', function() {
        var _wrap = $(this).parents('.nasa-slider-deal-vertical-extra-switcher');
        var _speed = parseInt($(_wrap).attr('data-speed'));
        _speed = !_speed ? 600 : _speed;
        $(_wrap).append('<div class="nasa-slick-fog"></div>');
        
        setTimeout(function(){
            $(_wrap).find('.nasa-slick-fog').remove();
        }, _speed);
    });
    
    /*
     * nasa-gift-featured-event
     */
    initNasaGiftFeatured($);
    
    /**
     * Countdown
     */
    if (typeof nasa_countdown_l10n !== 'undefined' && (typeof nasa_countdown_init === 'undefined' || nasa_countdown_init === '0')) {
        nasa_countdown_init = '1';
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
        loadCountDownNasaCore($);
    }
    
    /**
     * Scroll window
     */
    $(window).scroll(function(){
        nasaLoadHeightMainProducts($);
    });
    
    /**
     * Color | Label | Image variations products
     */
    $.fn.nasa_attr_ux_variation_form = function() {
        var clicked, selected;
        
        return this.each(function() {
            var $form = $(this);
            
            clicked = null;
            selected = [];
            
            $form.addClass('nasa-attr-ux-form').on('click', '.nasa-attr-ux', function(e) {
                e.preventDefault();
                var $el = $(this),
                    $select = $el.closest('.variation').length ?
                        $el.closest('.variation').find('select') : $el.closest('.value').find('select'),
                    attribute_name = $select.data('attribute_name') || $select.attr('name'),
                    value = $el.data('value');
                    
                if ($el.hasClass('nasa-disable')) {
                    return false;
                }
                
                else {
                    $select.trigger('focusin');

                    // Check if this combination is available
                    if (!$select.find('option[value="' + value + '"]').length) {
                        $el.siblings('.nasa-attr-ux').removeClass('selected');
                        $select.val('').change();
                        $form.trigger('nasa-attr-ux_no_matching_variations', [$el]);
                        return;
                    }

                    clicked = attribute_name;

                    if (selected.indexOf(attribute_name) === -1 ) {
                        selected.push(attribute_name);
                    }

                    if ($el.hasClass('selected')) {
                        $select.val('');
                        $el.removeClass('selected');

                        delete selected[selected.indexOf(attribute_name)];
                    } else {
                        $el.addClass('selected').siblings('.selected').removeClass('selected');
                        $select.val(value);
                    }

                    $select.change();
                }
                
            }).on('click', '.reset_variations', function() {
                $(this).closest('.variations_form').find('.nasa-attr-ux.selected').removeClass('selected');
                selected = [];
                nasa_refresh_attrs($, $form);
            }).on('nasa-attr-ux_no_matching_variations', function() {
                var text_nomatch = (typeof wc_add_to_cart_variation_params !== 'undefined') ?
                    wc_add_to_cart_variation_params.i18n_no_matching_variations_text :
                    $('input[name="nasa_no_matching_variations"]').val();
                window.alert(text_nomatch);
                
                nasa_refresh_attrs($, $form);
            });
        });
    };
    
    $('body').on('change', '.variations select', function() {
        var _this = $(this);
        setTimeout(function() {
            nasa_refresh_attrs($, $(_this).parents('form.variations_form'));
        }, 500);
    });

    $(function () {
        $('.nasa-product-details-page .variations_form').nasa_attr_ux_variation_form();
    });
    
    if ($('.nasa-product-content-variable-warp').length) {
        $('.nasa-product-content-variable-warp').each(function() {
            var _this = $(this);
            if (!$(_this).hasClass('nasa-inited')) {
                $(_this).addClass('nasa-inited');
                change_image_content_product_variable($, _this, false);
            }
        });
    }
    
    $('body').on('click', '.nasa-attr-ux-item', function() {
        var _this = $(this),
            _wrap = $(_this).parents('.nasa-product-content-child'),
            _act = $(_this).attr('data-act');
            
        if (!$(_this).hasClass('nasa-disable')) {
            $(_wrap).find('.nasa-attr-ux-item').removeClass('nasa-active').attr('data-act', '0');
            if (_act === '0') {
                $(_this).addClass('nasa-active').attr('data-act', '1');
            }

            var _variations_warp = $(_this).parents('.nasa-product-content-variable-warp');
            if (!$(_variations_warp).hasClass('nasa-inited')) {
                $(_variations_warp).addClass('nasa-inited');
            }
            
            change_image_content_product_variable($, _variations_warp, true);
        }
    });
    
    $('body').on('click', '.nasa-attr-ux-item-clone', function () {
        var _this = $(this),
            _key = $(_this).attr('data-key'),
            _product_item = $(_this).parents('.product-item');
            
        if (!$(_this).hasClass('nasa-disable')) {
            if (_key && $(_product_item).length && $(_product_item).find('.nasa-main-' + _key).length) {
                $(_product_item).find('.nasa-main-' + _key).trigger('click');
            }
            
            if ($(_product_item).find('.nasa-product-content-variable-warp').length && !$(_product_item).find('.nasa-product-content-variable-warp').hasClass('nasa-active')) {
                $(_product_item).find('.nasa-product-content-variable-warp').addClass('nasa-active');
            }
        }
    });
    
    /**
     * Pin init
     */
    loadPinProductsBanner($);
    loadPinMaterialBanner($);
    $('body').on('click', '.easypin-marker .nasa-marker-icon-wrap', function() {
        var _this = $(this);
        var _act = $(_this).parents('.easypin-marker').hasClass('nasa-active');
        var _wrap = $(_this).parents('.nasa-pin-wrap');
        $(_wrap).find('.easypin-marker').removeClass('nasa-active');
        
        if (!_act) {
            $(_this).parents('.easypin-marker').addClass('nasa-active');
        }
    });
    
    /**
     * Size Guide Popup
     */
    $('body').on('click', '.nasa-size-guide-popup', function (e) {
        var _src = $(this).attr('data-src');
        var _close = $(this).attr('data-close');
        $.magnificPopup.open({
            tClose: _close,
            removalDelay: 300, //delay removal by X to allow out-animation
            fixedContentPos: true,
            items: {
                src: '<div class="nasa-size-guide-lightbox white-popup-block mfp-with-anim zoom-anim-dialog"><img src="' + _src + '" /></div>',
                type: 'inline'
            },
            callbacks: {
                beforeOpen: function() {
                    this.st.mainClass = 'my-mfp-slide-bottom';
                }
            }
        });
        $('.please-wait, .color-overlay').remove();
        e.preventDefault();
    });
    
    /**
     * Change nasa Categories
     */
    $('body').on('change', '.nasa-filter-nasa-categories', function () {
        var _urlAjax = null;
        if (
            typeof nasa_ajax_params !== 'undefined' &&
            typeof nasa_ajax_params.wc_ajax_url !== 'undefined'
        ) {
            _urlAjax = nasa_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', 'nasa_custom_taxomomies_child');
        }

        if (_urlAjax) {
            var _this = $(this);
            var _form = $(_this).parents('form');
            $(_form).find('.nasa-filter-nasa-categories').attr('disabled', true);
            var _taget = $(_this).attr('data-target');
            if ($(_form).find(_taget).length) {
                var _affected = $(_form).find(_taget);
                var _slug = $(_this).val();
                var _key = $(_affected).attr('data-key');
                var _hide_empty = $(_form).attr('data-hide_empty');
                var _show_count = $(_form).attr('data-show_count');
                var _active = $(_affected).parents('.nasa-wrap-select').attr('data-active');
                var _select_text = $(_affected).attr('data-text_select');

                $.ajax({
                    url : _urlAjax,
                    type: 'post',
                    dataType: 'json',
                    data: {
                        slug: _slug,
                        key: _key,
                        hide_empty: _hide_empty,
                        show_count: _show_count,
                        actived: _active,
                        select_text: _select_text
                    },
                    beforeSend: function(){

                    },
                    success: function(res){
                        if (res.success){
                            $(_affected).html(res.content);
                            if (res.empty) {
                                $(_affected).val('').change();
                            } else {
                                if (_active && res.has_active) {
                                    $(_affected).val(_active).change();
                                } else {
                                    $(_affected).val('').change();
                                }
                            }
                        }

                        $(_form).find('.nasa-filter-nasa-categories').attr('disabled', false);
                        
                        nasa_init_filter_nasa_categories($);
                    }
                });
            } else {
                $(_form).find('.nasa-filter-nasa-categories').attr('disabled', false);
            }
        }
    });
    
    $('body').on('click', '.nasa-submit-form', function() {
        var _form = $(this).parents('form');
        var _changed = false;
        var max_deep = $(_form).find('select.nasa-filter-nasa-categories').length - 1;
        for (var _key = max_deep; _key >= 0; _key--) {
            if ($(_form).find('.nasa-filter-nasa-categories.nasa-select-' + _key).length && $(_form).find('.nasa-filter-nasa-categories.nasa-select-' + _key).val() !== '') {
                var _val = $(_form).find('.nasa-filter-nasa-categories.nasa-select-' + _key).val();
                $(_form).find('input.nasa-input-main').val(_val);
                _changed = true;
                
                break;
            }
        }
        
        if (!_changed) {
            $(_form).find('input.nasa-input-main').remove();
        }
        
        setTimeout(function() {
            $(_form).submit();
        }, 10);
        
        
        return false;
    });
    
    nasa_init_filter_nasa_categories($);
    
    nasa_init_select2($);
    
    /**
     * 360 Degree Popup
     */
    $('body').on('click', '.nasa-360-degree-popup', function() {
        $.magnificPopup.close();
        
        $.magnificPopup.open({
            mainClass: 'my-mfp-zoom-in',
            items: {
                src: '<div class="nasa-product-360-degree"></div>',
                type: 'inline'
            },
            tClose: $('input[name="nasa-close-string"]').val(),
            callbacks: {
                beforeClose: function() {
                    this.st.removalDelay = 350;
                },
                afterClose: function() {

                }
            }
        });
        
        nasa_360_degree($);
    });
    
    /**
     * Show viewed sidebar
     */
    var _viewed_init = false;
    $('body').on('click', '#nasa-init-viewed', function() {
        if (
            !_viewed_init &&
            $('#nasa-viewed-sidebar-content').length &&
            typeof nasa_ajax_params !== 'undefined' &&
            typeof nasa_ajax_params.wc_ajax_url !== 'undefined'
        ) {
            _viewed_init = true;
            
            var _urlAjax = nasa_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', 'nasa_viewed_sidebar_content');
            
            $.ajax({
                url : _urlAjax,
                type: 'post',
                dataType: 'json',
                cache: false,
                data: {},
                success: function(res){
                    if (typeof res.success !== 'undefined' && res.success === '1') {
                        $('#nasa-viewed-sidebar-content').replaceWith(res.content);
                        
                        if ($('#nasa-viewed-sidebar').find('.item-product-widget').length) {
                            $('#nasa-viewed-sidebar').find('.nasa-sidebar-tit').removeClass('text-center');
                        }
                    }
                },
                error: function() {
                    
                }
            });
        }
    });
    
    /* =========== End Document nasa-core ready ==================== */
});
