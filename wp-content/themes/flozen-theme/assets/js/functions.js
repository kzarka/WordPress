"use strict";
var _isotope;
var _isotope_init = false;
var _eventMore = false;
/* =========== Functions base ==================== */
function afterLoadAjaxList($) {
    if ($('.nasa-top-sidebar').length > 0) {
        var _act_variations = getTopFilterActiveVatiations($);
        $('.nasa-top-sidebar-variations-active').replaceWith(_act_variations);
    }
    
    loadingCarousel($);
    loadingSCCarosel($);
    loadTipTop($);
    initThemeNasaGiftFeatured($);
    loadActiveTopBar($);
    cloneGroupBtnsProductItem($);
    loadProductsMasonryIsotope($, false);
    
    initTopCategoriesFilter($);
    
    /**
     * Render tags cloud
     */
    renderTagClouds($);
    
    /**
     * Init widgets
     */
    init_widgets($);
    
    /**
     * Init btns for list
     */
    init_group_btn_list($);
    
    /*
     * Parallax Breadcrumb
     */
    // if (!_eventMore) {
    //     $(window).stellar('refresh');
    // }
    /**
     * Load countdonw
     */
    loadCountDown($);
    
    /**
     * init wishlist icons
     */
    initWishlistIcons($);
    
    /**
     * init Compare icons
     */
    initCompareIcons($);
    
    /**
     * init Select2
     */
    init_select2($);
    
    init_filter_nasa_categories($);
    
    /**
     * Init change view order by classic sidebar shop
     */
    init_changeview_order_classic($);
    
    init_product_quickview_addtocart($, true);
    
    refreshProductsMasonryIsotope($);
    
    /**
     * Compatible Jetpack
     */
    compatibleJetpack($);
    
    _eventMore = false;
    
    if ($('.nasa-category-page-wrap').length) {
        $('.nasa-category-page-wrap').removeClass('nasa-invisible');
    }
    
    $('body').trigger('nasa_after_load_ajax');
}

/**
 * jetpack-lazy-image
 * @type type
 */
function compatibleJetpack($) {
    if ($('.jetpack-lazy-image').length) {
        $('.jetpack-lazy-image')
        .removeAttr('srcset')
        .removeAttr('data-lazy-src')
        .removeClass('jetpack-lazy-image');
    }
}

/**
 * Active Topbar
 * @param {type} $
 * @returns {undefined}
 */
function loadActiveTopBar($) {
    if ($('.nasa-tab-filter-topbar').length > 0) {
        $('.nasa-tab-filter-topbar').each(function() {
            var _this = $(this);
            var _widget = $(_this).attr('data-widget');
            if ($(_widget).length > 0) {
                if (
                    $(_widget).find('.nasa-filter-var-chosen').length > 0 ||
                    ($(_widget).find('input[name="nasa_hasPrice"]').length > 0 && $(_widget).find('input[name="nasa_hasPrice"]').val() === '1')
                ) {
                    if (!$(_this).hasClass('nasa-active')) {
                        $(_this).addClass('nasa-active');
                    }
                } else {
                    $(_this).removeClass('nasa-active');
                }
            }
        });
    }
    
    $('.nasa-tranparent-filter').trigger('click');
    $('.transparent-mobile').trigger('click');
}

/**
 * Check iOS
 * @returns {Boolean}
 */
function check_iOS() {
    var iDevices = [
        'iPad Simulator',
        'iPhone Simulator',
        'iPod Simulator',
        'iPad',
        'iPhone',
        'iPod'
    ];
    while (iDevices.length > 0) {
        if (navigator.platform === iDevices.pop()) {
            return true;
        }
    }
    return false;
}

/**
 * Shop Ajax
 * 
 * @param {type} $
 * @param {type} _url
 * @param {type} _page
 * @param {type} _catid
 * @param {type} _order
 * @param {type} _variations
 * @param {type} _hasPrice
 * @param {type} _min
 * @param {type} _max
 * @param {type} _hasSearch
 * @param {type} _s
 * @param {type} _this
 * @param {type} _taxonomy
 * @param {type} _totop
 * @param {type} loadMore
 * @returns {undefined}
 */
function nasa_Ajax_filter($, _url, _page, _catid, _order, _variations, _hasPrice, _min, _max, _hasSearch, _s, _this, _taxonomy, _totop, loadMore, buildUrl, reset) {
    var _reset = typeof reset === 'undefined' ? false : reset;
    var _more = typeof loadMore === 'undefined' ? false : loadMore;
    var _style_loadmore = $('#nasa-wrap-archive-loadmore').length ? true : false;
    var _scroll_loadmore = false;
    if (_style_loadmore && $('#nasa-wrap-archive-loadmore').hasClass('nasa-infinite-shop')) {
        _scroll_loadmore = true;
    }
    
    var _push_cat_show = $('.nasa-push-cat-show').length > 0 ? '1' : '0';
    var _data = _push_cat_show === '1' ? {
        'push_cat_filter': _push_cat_show
    } : {};
    
    var _paging_style = false;
    if (_more || _style_loadmore || $('input[name="nasa_loadmore_style"]').length) {
        _paging_style = $('input[name="nasa_loadmore_style"]').length ? $('input[name="nasa_loadmore_style"]').val() : '';
    }
    
    var _top_filter = $('#header-content .nasa-top-cat-filter').length > 0 ? true : false;
    
    /**
     * Built URL
     */
    if (_url === '' && $('input[name="nasa_current-slug"]').length) {
        _url = $('input[name="nasa_current-slug"]').val();
    }
    $('#nasa-hidden-current-cat').attr({
        'href': _url,
        'data-id': _catid,
        'data-taxonomy': _taxonomy
    });
    
    buildUrl = typeof buildUrl === 'undefined' ? true : buildUrl;
    var _h = false;
    var pagestring = '';
    
    if (buildUrl) {
        if (_url === '') {
            if (_hasSearch === 0) {
                _url = $('.static-position input[name="nasa-shop-page-url"]').val();
            } else if (_hasSearch === 1) {
                _url = $('.static-position input[name="nasa-base-url"]').val();
            }
        }

        if (_hasSearch != 1) {
            var patt = /\?/g;
            _h = patt.test(_url);
        }
        
        var _friendly = $('.static-position input[name="nasa-friendly-url"]').length === 1 && $('.static-position input[name="nasa-friendly-url"]').val() === '1' ? true : false;
        if (_page) {
            if (_hasSearch == 1 || !_friendly) {
                pagestring = 'paged=' + _page;
            } else {
                // Paging change (friendly Url)
                var lenUrl = _url.length;
                _url += (_url.length > 0 && _url.substring(lenUrl - 1, lenUrl) !== '/') ? '/' : '';
                _url += 'page/' + _page + '/';
            }
        }
        
        /**
         * Nasa Custom Categories
         */
        if (!_reset) {
            var _custom_cat = null;
            if ($('input.nasa-custom-cat').length && $('input.nasa-custom-cat').val()) {
                _custom_cat = $('input.nasa-custom-cat').attr('name');
                var _val = encodeURI($('input.nasa-custom-cat').val());
                _url = _url.replace('&' + _custom_cat + '=' + _val, '');
                _url = _url.replace('&' + _custom_cat + '=' + _val, '');
                _url += _h ? '&' : '?';
                _url += _custom_cat + '=' + _val;
                _h = true;

                if ($('.nasa-value-gets').length && $('.nasa-value-gets').find('input[name="' + _custom_cat + '"]').length) {
                    $('.nasa-value-gets').find('input[name="' + _custom_cat + '"]').remove();
                }
            }
        }

        // Search change
        if (_hasSearch == 1) {
            _url += _h ? '&' : '?';
            _url += 's=' + encodeURI(_s) + '&page=search&post_type=product';
            _h = true;
        } else {
            if ($('.nasa-results-blog-search').length > 0) {
                $('.nasa-results-blog-search').remove();
            }
            if ($('input[name="hasSearch"]').length > 0) {
                $('input[name="hasSearch"]').remove();
            }
        }

        // Variations change
        if (_variations.length > 0) {
            var l = _variations.length;
            
            $('.nasa-value-gets input[name^="filter_"]').remove();
            $('.nasa-value-gets input[name^="query_type_"]').remove();
            
            for (var i = 0; i < l; i++) {
                var _qtype = (_variations[i].type === 'or') ? '&query_type_' + _variations[i].taxonomy + '=' + _variations[i].type : '';
                _url += _h ? '&' : '?';
                _url += 'filter_' + _variations[i].taxonomy + '=' + (_variations[i].slug).toString() + _qtype;
                
                _h = true;
            }
        }

        // Price change
        if (_hasPrice == 1 && _max) {
            _url += _h ? '&' : '?';
            _min = _min ? _min : 0;
            _url += 'min_price=' + _min + '&max_price=' + _max;
            _h = true;
        }

        // Order change
        if (_order) {
            var _dfSort = $('select[name="orderby"]').attr('data-default');
            if (_order !== _dfSort) {
                _url += _h ? '&' : '?';
                _url += 'orderby=' + _order;
                _h = true;
            }
        }

        // Get Sidebar
        if ($('input[name="nasa_getSidebar"]').length === 1) {
            var _sidebar = $('input[name="nasa_getSidebar"]').val();
            _url += _h ? '&' : '?';
            _url += 'sidebar=' + _sidebar;
            _h = true;
        }
    }
    
    if (_paging_style && _paging_style !== '') {
        if (!_h && _url) {
            var patt2 = /\?/g;
            _h = patt2.test(_url);
        }
        
        _url += _h ? '&' : '?';
        _url += 'paging-style=' + _paging_style;
        _h = true;
        
        if ($('.nasa-value-gets').find('input[name="paging-style"]').length) {
            $('.nasa-value-gets').find('input[name="paging-style"]').remove();
        }
    }
    
    if (pagestring !== '') {
        _url += _h ? '&' : '?';
        _url += pagestring;
        _h = true;
    }
    
    if ($('.nasa-value-gets').length && $('.nasa-value-gets').find('input').length) {
        $('.nasa-value-gets').find('input').each(function() {
            var _key = $(this).attr('name');
            var _val = $(this).val();
            _data[_key] = _val;
        });
    }
    
    $.ajax({
        url: _url,
        type: 'get',
        dataType: 'html',
        data: _data,
        cache: true,
        beforeSend: function () {
            if (!_scroll_loadmore) {
                $('.nasa-content-page-products').append('<div class="opacity-3" />');
            } else {
                $('#nasa-wrap-archive-loadmore').append('<div class="nasa-loader"></div>');
            }
            
            if ($('.nasa-progress-bar-load-shop').length === 1) {
                $('.nasa-progress-bar-load-shop .nasa-progress-per').removeClass('nasa-loaded');
                $('.nasa-progress-bar-load-shop').addClass('nasa-loading');
            }
            
            if ($('.col-sidebar').length) {
                $('.col-sidebar').append('<div class="opacity-2"></div>');
                $('.black-window').trigger('click');
            }

            $('.nasa-filter-by-cat').addClass('nasa-disable').removeClass('nasa-active');

            if ($(_this).parents('ul.children').length > 0) {
                $(_this).parents('ul.children').show();
            }
        },
        success: function (res) {
            var _act_widget = $('.nasa-top-row-filter li.nasa-active > a');
            
            var _act_widget_2 = false;
            if ($('.nasa-toggle-top-bar-click').length) {
                _act_widget_2 = $('.nasa-toggle-top-bar-click').hasClass('nasa-active') ? true : false;
            }
            
            var $html = $.parseHTML(res);
            
            var $mainContent = $('#main-content', $html);
            
            _top_filter = _top_filter ? $('#nasa-main-cat-filter', $html).html() : _top_filter;
            
            if (_top_filter) {
                $('#header-content .nasa-top-cat-filter').replaceWith(_top_filter);
                if ($('.nasa-top-cat-filter-wrap-mobile .nasa-top-cat-filter').length) {
                    $('.nasa-top-cat-filter-wrap-mobile .nasa-top-cat-filter').replaceWith(_top_filter);
                }
            }
            
            /**
             * 
             * @type Load Paging
             */
            if (!_more) {
                var $breadcrumb = $('#nasa-breadcrumb-site', $html);
                $('#nasa-breadcrumb-site').replaceWith($breadcrumb);
                $('#main-content').replaceWith($mainContent);
                archive_page = 1;
            }
            
            /**
             * 
             * @type Load More
             */
            else {
                _eventMore = true;
                var _append_content = $($mainContent).find('.nasa-content-page-products ul.products').html();
                
                if ($('#main-content').find('.nasa-products-masonry-isotope').length && $('.nasa-products-masonry-isotope ul.products.grid').length) {
                    $('#main-content').find('.nasa-products-masonry-isotope ul.products.grid').isotope('insert', $(_append_content));
                } else {
                    $('#main-content').find('.nasa-content-page-products ul.products').append(_append_content);
                }
                
                var $moreBtn = $('#nasa-wrap-archive-loadmore', $html);
                $('#nasa-wrap-archive-loadmore').replaceWith($moreBtn);
                
                if ($('.nasa-content-page-products').find('.opacity-3').length) {
                    $('.nasa-content-page-products').find('.opacity-3').remove();
                }
                
                if ($('.col-sidebar').length && $('.col-sidebar').find('.opacity-2').length) {
                    $('.col-sidebar').find('.opacity-2').remove();
                }
                
                if ($('.nasa-progress-bar-load-shop').length) {
                    $('.nasa-progress-bar-load-shop').removeClass('nasa-loading');
                }
                
                if ($('#nasa-wrap-archive-loadmore').length && $('#nasa-wrap-archive-loadmore').find('.nasa-loader').length) {
                    $('#nasa-wrap-archive-loadmore').find('.nasa-loader').remove();
                }
            }
            
            var _cookie_change_layout = $.cookie('gridcookie');
            if (typeof _cookie_change_layout !== 'undefined' && $('.nasa-change-layout.' + _cookie_change_layout).length) {
                $('.nasa-change-layout.' + _cookie_change_layout).trigger('click');
            }

            $('.nasa-filter-by-cat').removeClass('nasa-disable');

            _totop = typeof _totop === 'undefined' ? false : _totop;
            if (_totop && ($('.category-page').length || $('.nasa-content-page-products').length)) {
                var _pos_top = $('.category-page').length ? $('.category-page').offset().top : $('.nasa-content-page-products').offset().top;
                $('html, body').animate({scrollTop: (_pos_top - 125)}, 700);
            }
            
            if (_more && $('.woocommerce-result-count').length) {
                $('.woocommerce-result-count').html($(res).find('.woocommerce-result-count').html());
            }

            if ($('.nasa-top-sidebar').length > 0 && !_more) {
                initNasaTopSidebar($);
                
                if ($(_act_widget).length === 1) {
                    var _old_id = $(_act_widget).attr('data-old_id');
                    if ($('.nasa-top-row-filter li > a[data-old_id="' + _old_id + '"]').length === 1) {
                        var _click = $('.nasa-top-row-filter li > a[data-old_id="' + _old_id + '"]');
                        topFilterClick($, _click, 'showhide');
                    } else {
                        var _key = $(_act_widget).attr('data-key');
                        if ($('.nasa-top-row-filter li > a[data-key="' + _key + '"]').length === 1) {
                            var _click = $('.nasa-top-row-filter li > a[data-key="' + _key + '"]');
                            topFilterClick($, _click, 'showhide');
                        }
                    }
                }
            }
            
            if ($('.nasa-top-sidebar-2').length > 0 && !_more) {
                // initNasaTopSidebar2($);
                
                if (_act_widget_2) {
                    var _click = $('.nasa-toggle-top-bar-click');
                    $('.nasa-top-bar-2-content').hide();
                    topFilterClick2($, _click, 'showhide');
                }
            }

            if ($('.price_slider').length === 1 && !_more) {
                var min_price = $('.price_slider_amount #min_price').data('min'),
                    max_price = $('.price_slider_amount #max_price').data('max'),
                    current_min_price = parseInt(min_price, 10),
                    current_max_price = parseInt(max_price, 10);
                    if (_hasPrice == 1 && _max) {
                        current_min_price = _min ? _min : 0;
                        current_max_price = _max;
                    }
                $('.price_slider').slider({
                    range: true,
                    animate: true,
                    min: min_price,
                    max: max_price,
                    values: [current_min_price, current_max_price],
                    create: function() {
                        $('.price_slider_amount #min_price').val(current_min_price);
                        $('.price_slider_amount #max_price').val(current_max_price);
                        $(document.body).trigger('price_slider_create', [current_min_price, current_max_price]);
                    },
                    slide: function(event, ui) {
                        $('input#min_price').val(ui.values[0]);
                        $('input#max_price').val(ui.values[1]);

                        $(document.body).trigger('price_slider_slide', [ui.values[0], ui.values[1]]);
                    },
                    change: function(event, ui) {
                        $(document.body).trigger('price_slider_change', [ui.values[0], ui.values[1]]);
                    }
                });

                if (_hasPrice == 1 && _max) {
                    $('.reset_price').attr('data-has_price', "1").show();
                    if ($('.price_slider_wrapper').find('button').length) {
                        $('.price_slider_wrapper').find('button').show();
                    }
                }
                $('.price_slider, .price_label').show();
            }

            afterLoadAjaxList($);
            shop_load = false;
            infinitiAjax = false;
            
            var matches = res.match(/<title>(.*?)<\/title>/);
            var _title = typeof matches[1] !== 'undefined' ? matches[1] : '';
            if (_title) {
                $('title').html(_title);
            }
        },
        error: function () {
            $('.opacity-2').remove();
            $('.opacity-3').remove();
            $('.nasa-filter-by-cat').removeClass('nasa-disable');
            
            shop_load = false;
            infinitiAjax = false;
        }
    });
    
    if (!_more) {
        window.history.pushState(_url, '', _url);
    }
}

/**
 * Set variaions
 * 
 * @param {type} $
 * @param {type} variations
 * @param {type} keys
 * @returns {unresolved}
 */
function nasa_setVariations($, variations, keys, current) {
    var _current = typeof current !== 'undefined' ? current : null;
    
    if (_current) {
        var _tax = $(_current).attr('data-attr');
        var _slug = $(_current).attr('data-term_slug');
        
        if ($(_current).hasClass('nasa-filter-var-chosen')){
            $('.nasa-filter-by-variations[data-attr="' + _tax + '"][data-term_slug="' + _slug + '"]').parent().removeClass('chosen nasa-chosen').show();
            $('.nasa-filter-by-variations[data-attr="' + _tax + '"][data-term_slug="' + _slug + '"]').removeClass('nasa-filter-var-chosen');
        } else {
            $('.nasa-filter-by-variations[data-attr="' + _tax + '"][data-term_slug="' + _slug + '"]').parent().addClass('chosen nasa-chosen');
            $('.nasa-filter-by-variations[data-attr="' + _tax + '"][data-term_slug="' + _slug + '"]').addClass('nasa-filter-var-chosen');
        }
    }
    
    $('.nasa-filter-var-chosen').each(function () {
        var _attr = $(this).attr('data-attr'),
            _attrVal = $(this).attr('data-term_id'),
            _attrSlug = $(this).attr('data-term_slug'),
            _attrType = $(this).attr('data-type');
        var l = variations.length;
        if (keys.indexOf(_attr) === -1) {
            variations.push({
                taxonomy: _attr,
                values: [_attrVal],
                slug: [_attrSlug],
                type: _attrType
            });
            keys.push(_attr);
        } else {
            for (var i = 0; i < l; i++) {
                if (variations[i].taxonomy.length > 0 && variations[i].taxonomy === _attr) {
                    if ((variations[i].slug).indexOf(_attrSlug) === -1) {
                        variations[i].values.push(_attrVal);
                        variations[i].slug.push(_attrSlug);
                        break;
                    }
                }
            }
        }
    });

    return variations;
}

/**
 * Load Carousel
 * 
 * @param {type} $
 * @param {type} heightAuto
 * @param {type} minHeight
 * @returns {undefined}
 */
function loadingCarousel($, heightAuto, minHeight) {
    if ($('.nasa-slider').length) {
        compatibleJetpack($);
        heightAuto = heightAuto === undefined ? false : heightAuto;
        minHeight = minHeight === undefined ? true : minHeight;
        var _rtl = $('body').hasClass('nasa-rtl') ? true : false;
        $('.nasa-slider').each(function () {
            var _this = $(this);
            if (!$(_this).hasClass('owl-loaded')) {
                var cols = $(_this).attr('data-columns'),
                    cols_small = $(_this).attr('data-columns-small'),
                    cols_tablet = $(_this).attr('data-columns-tablet'),
                    autoplay_enable = ($(_this).attr('data-autoplay') === 'true') ? true : false,
                    loop_enable = ($(_this).attr('data-loop') === 'true') ? true : false,
                    dot_enable = ($(_this).attr('data-dot') === 'true') ? true : false,
                    nav_disable = ($(_this).attr('data-disable-nav') === 'true') ? false : true,
                    nav_mobile = ($(_this).attr('data-mobile-nav') === 'true') ? true : false,
                    height_auto = ($(_this).attr('data-height-auto') === 'true') ? true : false,
                    margin_px = parseInt($(_this).attr('data-margin')),
                    margin_small_px = parseInt($(_this).attr('data-margin-small')),
                    margin_medium_px = parseInt($(_this).attr('data-margin-medium')),
                    padding_px = parseInt($(_this).attr('data-padding')),
                    ap_speed = parseInt($(_this).attr('data-speed')),
                    ap_delay = parseInt($(_this).attr('data-delay')),
                    disable_drag = ($(_this).attr('data-disable-drag') === 'true') ? false : true;
                
                if (!margin_px && margin_px !== 0) {
                    margin_px = 10;
                } 
                
                if (!margin_small_px && margin_small_px !== 0) {
                    margin_small_px = margin_px;
                }
                
                if (!margin_medium_px && margin_medium_px !== 0) {
                    margin_medium_px = margin_px;
                }

                if (!ap_speed) {
                    ap_speed = 600;
                }

                if (!ap_delay) {
                    ap_delay = 3000;
                }

                if ($(_this).find('.countdown').length > 0) {
                    loop_enable = autoplay_enable = false;
                }

                var nasa_slider_params = {
                    rtl: _rtl,
                    nav: nav_disable,
                    autoplay: autoplay_enable,
                    autoplaySpeed: ap_speed,
                    loop: loop_enable,
                    dots: dot_enable,
                    autoplayTimeout: ap_delay,
                    autoplayHoverPause: true,
                    responsiveClass: true,
                    navText: ["", ""],
                    navSpeed: 600,
                    lazyLoad: true,
                    touchDrag: disable_drag,
                    mouseDrag: disable_drag,
                    responsive: {
                        0: {
                            items: cols_small,
                            margin: margin_small_px,
                            nav: nav_mobile
                        }
                    }
                };
                
                var _switchTablet = 848;
                var _switchDesktop = 1130;
                
                if ($(_this).attr('data-switch-tablet')) {
                    _switchTablet = parseInt($(_this).attr('data-switch-tablet'));
                }
                
                if ($(_this).attr('data-switch-desktop')) {
                    _switchDesktop = parseInt($(_this).attr('data-switch-desktop'));
                }
                
                nasa_slider_params['responsive'][_switchTablet] = {
                    items: cols_tablet,
                    margin: margin_medium_px
                };
                
                nasa_slider_params['responsive'][_switchDesktop] = {
                    items: cols
                };

                if (margin_px) {
                    nasa_slider_params.margin = margin_px;
                }
                
                if (padding_px){
                    nasa_slider_params.stagePadding = padding_px;
                }

                if (height_auto) {
                    nasa_slider_params.autoHeight = true;
                }

                $(_this).owlCarousel(nasa_slider_params);

                if (heightAuto === true) {
                    $(_this).find('> .owl-stage-outer').css({'height': 'auto'});
                }

                // Fix height tabable content slide
                if (minHeight === true) {
                    var _height = $(_this).height();
                    if (_height > 0 && $(_this).parents('.nasa-panels').length > 0) {
                        $(_this).parents('.nasa-panels').css({'min-height': _height});
                        setTimeout(function() {
                            $(_this).parents('.nasa-panels').css({'min-height': 'auto'});
                        }, 500);
                    }
                }
            }
        });
    }
}

/**
 * Shortcode Carousel
 * 
 * @param {type} $
 * @returns {undefined}
 */
function loadingSCCarosel($) {
    if ($('.nasa-sc-carousel').length > 0) {
        compatibleJetpack($);
        var _rtl = $('body').hasClass('nasa-rtl') ? true : false;
        $('.nasa-sc-carousel').each(function () {
            var _sc = $(this);
            if (!$(_sc).hasClass('owl-loaded')) {
                var height = ($(_sc).find('.banner').length > 0) ? $(_sc).find('.banner').height() : 0;
                if (height) {
                    var loading = '<div class="nasa-carousel-loadding" style="height: ' + height + 'px"><div class="please-wait type2"></div></div>';
                    $(_sc).parent().append(loading);
                }

                var _nav = ($(_sc).attr('data-nav') === 'true') ? true : false,
                    _dots = ($(_sc).attr('data-dots') === 'true') ? true : false,
                    _autoplay = ($(_sc).attr('data-autoplay') === 'false') ? false : true,
                    _speed = parseInt($(_sc).attr('data-speed')),
                    _itemSmall = parseInt($(_sc).attr('data-itemSmall')),
                    _itemTablet = parseInt($(_sc).attr('data-itemTablet')),
                    _items = parseInt($(_sc).attr('data-items')),
                    margin_px = parseInt($(_sc).attr('data-margin')),
                    margin_small_px = parseInt($(_sc).attr('data-margin-small')),
                    margin_medium_px = parseInt($(_sc).attr('data-margin-medium'));
                
                _speed = _speed ? _speed : 3000;
                _itemSmall = _itemSmall ? _itemSmall : 1;
                _itemTablet = _itemTablet ? _itemTablet : 1;
                _items = _items ? _items : 1;
                
                if (!margin_px && margin_px !== 0) {
                    margin_px = 10;
                } 
                
                if (!margin_small_px && margin_small_px !== 0) {
                    margin_small_px = margin_px;
                }
                
                if (!margin_medium_px && margin_medium_px !== 0) {
                    margin_medium_px = margin_px;
                }
                
                var _setting = {
                    rtl: _rtl,
                    loop: true,
                    nav: _nav,
                    dots: _dots,
                    autoplay: _autoplay,
                    autoplaySpeed: _speed, // Speed when auto play
                    autoplayTimeout: 5000, //Delay for next slide
                    autoplayHoverPause: true,
                    navText: ["", ""],
                    navSpeed: _speed, //Speed when click to navigation arrow
                    dotsSpeed: _speed,
                    responsiveClass: true,
                    callbacks: true,
                    responsive: {
                        0: {
                            items: _itemSmall,
                            nav: false
                        },
                        640: {
                            items: _itemTablet,
                            nav: false
                        },
                        848: {
                            items: _items
                        }
                    }
                };
                
                var _switchTablet = 848;
                var _switchDesktop = 1130;
                
                if ($(_sc).attr('data-switch-tablet')) {
                    _switchTablet = parseInt($(_sc).attr('data-switch-tablet'));
                }
                
                if ($(_sc).attr('data-switch-desktop')) {
                    _switchDesktop = parseInt($(_sc).attr('data-switch-desktop'));
                }
                
                _setting['responsive'][_switchTablet] = {
                    items: _itemTablet,
                    margin: margin_medium_px
                };
                
                _setting['responsive'][_switchDesktop] = {
                    items: _items
                };
                
                if (margin_px) {
                    _setting.margin = margin_px;
                }
                
                _sc.owlCarousel(_setting);

                _sc.find('.owl-item').each(function () {
                    var _this = $(this);
                    if ($(_this).find('.banner .banner-inner').length) {
                        var _banner = $(_this).find('.banner .banner-inner');
                        $(_banner).removeAttr('class').removeAttr('style').addClass('banner-inner');
                        if ($(_this).hasClass('active')) {
                            var animation = $(_banner).attr('data-animation');
                            setTimeout(function () {
                                $(_banner).show();
                                $(_banner).addClass('animated').addClass(animation).css({'visibility': 'visible', 'animation-duration': '1s', 'animation-delay': '0ms', 'animation-name': animation});
                            }, 200);
                        }
                    }
                });

                _sc.on('translated.owl.carousel', function (items) {
                    var warp = items.target;
                    if ($(warp).find('.owl-item').length) {
                        $(warp).find('.owl-item').each(function () {
                            var _this = $(this);
                            if ($(_this).find('.banner .banner-inner').length) {
                                var _banner = $(_this).find('.banner .banner-inner');
                                var animation = $(_banner).attr('data-animation');
                                $(_banner).removeClass('animated').removeClass(animation).removeAttr('style');
                                if ($(_this).hasClass('active')) {
                                    setTimeout(function () {
                                        $(_banner).show();
                                        $(_banner).addClass('animated').addClass(animation).css({'visibility': 'visible', 'animation-duration': '1s', 'animation-delay': '0ms', 'animation-name': animation});
                                    }, 200);
                                }
                            }
                        });
                    }
                });

                $(_sc).parent().find('.nasa-carousel-loadding').remove();
            }
        });
    }
}

/**
 * Refresh carousel
 * @param {type} $
 * @returns {undefined}
 */
function refreshCarousel($) {
    if ($('.nasa-slider.owl-loaded').length) {
        $('.nasa-slider.owl-loaded').trigger('destroy.owl.carousel');
        loadingCarousel($);
    }
    
    if ($('.nasa-sc-carousel').length) {
        $('.nasa-sc-carousel.owl-loaded').trigger('destroy.owl.carousel');
        loadingSCCarosel($);
    }
    
    if ($('.main-image-slider').length) {
        $('.main-image-slider.owl-loaded').trigger('destroy.owl.carousel');
        loadLightboxCarousel($);
    }
    
    loadSlickSingleProduct($, true);
}

/**
 * Tabs slide
 * 
 * @param {type} $
 * @param {type} _this
 * @param {type} exttime
 * @returns {undefined}
 */
function nasa_tab_slide_style($, _this, exttime) {
    exttime = !exttime ? 500 : exttime;
    var _tab = $(_this).find('.nasa-slide-tab');
    var _act = $(_this).find('.nasa-tab.active');
    if ($(_this).find('.nasa-tab-icon').length > 0) {
        $(_this).find('.nasa-tab > a').css({'padding': '15px 30px'});
    }
    
    var _width_border = parseInt($(_this).find('.nasa-tabs').css("border-top-width"));
    _width_border = !_width_border ? 0 : _width_border;
    
    var _pos = $(_act).position();
    $(_tab).show().animate({'height': $(_act).height() + (2*_width_border), 'width': $(_act).width() + (2*_width_border), 'top': _pos.top - _width_border, 'left': _pos.left - _width_border}, exttime);
}

/**
 * Countdown
 * 
 * @param {type} $
 * @returns {undefined}
 */
function loadCountDown($) {
    var countDownEnable = ($('input[name="nasa-count-down-enable"]').length === 1 && $('input[name="nasa-count-down-enable"]').val() === '1') ? true : false;
    if (countDownEnable && $('.countdown').length > 0) {
        $('.countdown').each(function () {
            var count = $(this);
            if (!$(count).hasClass('countdown-loaded')) {
                var austDay = new Date(count.data('countdown'));
                $(count).countdown({
                    until: austDay,
                    padZeroes: true
                });
                
                if ($(count).hasClass('pause')) {
                    $(count).countdown('pause');
                }
                
                $(count).addClass('countdown-loaded');
            }
        });
    }
}

/**
 * Load Compare
 * 
 * @param {type} $
 * @returns {undefined}
 */
var _compare_init = false;
function loadCompare($) {
    if ($('#nasa-compare-sidebar-content').length && !_compare_init) {
        _compare_init = true;
        
        if (
            typeof nasa_ajax_params !== 'undefined' &&
            typeof nasa_ajax_params.wc_ajax_url !== 'undefined'
        ) {
            var _urlAjax = nasa_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', 'nasa_load_compare');

            var _compare_table = $('.nasa-wrap-table-compare').length ? true : false;
            $.ajax({
                url: _urlAjax,
                type: 'post',
                dataType: 'json',
                cache: false,
                data: {
                    compare_table: _compare_table
                },
                beforeSend: function () {
                    
                },
                success: function (res) {
                    if (typeof res.success !== 'undefined' && res.success === '1') {
                        $('#nasa-compare-sidebar-content').replaceWith(res.content);
                    }

                    $('.nasa-compare-list-bottom').find('.nasa-loader').remove();
                },
                error: function () {

                }
            });
        }
    }
}

/**
 * Add Compare
 * 
 * @param {type} _id
 * @param {type} $
 * @returns {undefined}
 */
function add_compare_product(_id, $) {
    var _urlAjax = null;
    if (
        typeof nasa_ajax_params !== 'undefined' &&
        typeof nasa_ajax_params.wc_ajax_url !== 'undefined'
    ) {
        _urlAjax = nasa_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', 'nasa_add_compare_product');
        
        var _compare_table = $('.nasa-wrap-table-compare').length ? true : false;

        $.ajax({
            url: _urlAjax,
            type: 'post',
            dataType: 'json',
            cache: false,
            data: {
                pid: _id,
                compare_table: _compare_table
            },
            beforeSend: function () {
                showCompare($);
                
                if ($('.nasa-compare-list-bottom').find('.nasa-loader').length <= 0) {
                    $('.nasa-compare-list-bottom').append('<div class="nasa-loader"></div>');
                }
            },
            success: function (res) {
                if (typeof res.result_compare !== 'undefined' && res.result_compare === 'success') {
                    if ($('#nasa-compare-sidebar-content').length) {
                        if (res.mini_compare === 'no-change') {
                            loadCompare($);
                        } else {
                            $('#nasa-compare-sidebar-content').replaceWith(res.mini_compare);
                        }
                    } else {
                        if (res.mini_compare !== 'no-change' && $('.nasa-compare-list').length) {
                            $('.nasa-compare-list').replaceWith(res.mini_compare);
                        }
                    }
                    
                    if (res.mini_compare !== 'no-change') {
                        if ($('.compare-number .nasa-sl').length) {
                            
                            $('.compare-number .nasa-sl').html(convert_count_items($, res.count_compare));
                            if (res.count_compare === 0) {
                                if (!$('.compare-number').hasClass('nasa-product-empty')) {
                                    $('.compare-number').addClass('nasa-product-empty');
                                }
                            } else {
                                if ($('.compare-number').hasClass('nasa-product-empty')) {
                                    $('.compare-number').removeClass('nasa-product-empty');
                                }
                            }
                        }

                        $('.nasa-compare-success').html(res.mess_compare);
                        $('.nasa-compare-success').fadeIn(200);

                        if (_compare_table) {
                            $('.nasa-wrap-table-compare').replaceWith(res.result_table);
                        }
                        
                    } else {
                        $('.nasa-compare-exists').html(res.mess_compare);
                        $('.nasa-compare-exists').fadeIn(200);
                    }

                    if (!$('.nasa-compare[data-prod="' + _id + '"]').hasClass('added')) {
                        $('.nasa-compare[data-prod="' + _id + '"]').addClass('added');
                    }

                    if (!$('.nasa-compare[data-prod="' + _id + '"]').hasClass('nasa-added')) {
                        $('.nasa-compare[data-prod="' + _id + '"]').addClass('nasa-added');
                    }

                    setTimeout(function () {
                        $('.nasa-compare-success').fadeOut(200);
                        $('.nasa-compare-exists').fadeOut(200);
                    }, 2000);
                }

                $('.nasa-compare-list-bottom').find('.nasa-loader').remove();
            },
            error: function () {

            }
        });
    }
}

/**
 * Remove Compare
 * 
 * @param {type} _id
 * @param {type} $
 * @returns {undefined}
 */
function remove_compare_product(_id, $) {
    var _urlAjax = null;
    if (
        typeof nasa_ajax_params !== 'undefined' &&
        typeof nasa_ajax_params.wc_ajax_url !== 'undefined'
    ) {
        _urlAjax = nasa_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', 'nasa_remove_compare_product');
        
        var _compare_table = $('.nasa-wrap-table-compare').length ? true : false;

        $.ajax({
            url: _urlAjax,
            type: 'post',
            dataType: 'json',
            cache: false,
            data: {
                pid: _id,
                compare_table: _compare_table
            },
            beforeSend: function () {
                if ($('.nasa-compare-list-bottom').find('.nasa-loader').length <= 0) {
                    $('.nasa-compare-list-bottom').append('<div class="nasa-loader"></div>');
                }
                
                if ($('table.nasa-table-compare tr.remove-item td.nasa-compare-view-product_' + _id).length) {
                    $('table.nasa-table-compare').css('opacity', '0.3').prepend('<div class="nasa-loader"></div>');
                }
            },
            success: function (res) {
                if (typeof res.result_compare !== 'undefined' && res.result_compare === 'success') {
                    if (res.mini_compare !== 'no-change' && $('#nasa-compare-sidebar-content').length) {
                        $('#nasa-compare-sidebar-content').replaceWith(res.mini_compare);
                    } else {
                        if (res.mini_compare !== 'no-change' && $('.nasa-compare-list').length) {
                            $('.nasa-compare-list').replaceWith(res.mini_compare);
                        }
                    }
                    
                    if (res.mini_compare !== 'no-change' && $('.nasa-compare-list').length) {
                        $('.nasa-compare[data-prod="' + _id + '"]').removeClass('added');
                        $('.nasa-compare[data-prod="' + _id + '"]').removeClass('nasa-added');
                        if ($('.compare-number .nasa-sl').length) {
                            
                            $('.compare-number .nasa-sl').html(convert_count_items($, res.count_compare));
                            if (res.count_compare === 0) {
                                if (!$('.compare-number').hasClass('nasa-product-empty')) {
                                    $('.compare-number').addClass('nasa-product-empty');
                                }
                            } else {
                                if ($('.compare-number').hasClass('nasa-product-empty')) {
                                    $('.compare-number').removeClass('nasa-product-empty');
                                }
                            }
                        }

                        $('.nasa-compare-success').html(res.mess_compare);
                        $('.nasa-compare-success').fadeIn(200);

                        if (_compare_table) {
                            $('.nasa-wrap-table-compare').replaceWith(res.result_table);
                        }
                    } else {
                        $('.nasa-compare-exists').html(res.mess_compare);
                        $('.nasa-compare-exists').fadeIn(200);
                    }

                    setTimeout(function () {
                        $('.nasa-compare-success').fadeOut(200);
                        $('.nasa-compare-exists').fadeOut(200);
                        if (res.count_compare === 0) {
                            $('.nasa-close-mini-compare').trigger('click');
                        }
                    }, 2000);
                }

                $('table.nasa-table-compare').find('.nasa-loader').remove();
                $('.nasa-compare-list-bottom').find('.nasa-loader').remove();
            },
            error: function() {

            }
        });
    }
}

/**
 * Remove All Compare
 * 
 * @param {type} $
 * @returns {undefined}
 */
function removeAll_compare_product($) {
    var _urlAjax = null;
    if (
        typeof nasa_ajax_params !== 'undefined' &&
        typeof nasa_ajax_params.wc_ajax_url !== 'undefined'
    ) {
        _urlAjax = nasa_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', 'nasa_remove_all_compare');
        
        var _compare_table = $('.nasa-wrap-table-compare').length ? true : false;
        $.ajax({
            url: _urlAjax,
            type: 'post',
            dataType: 'json',
            cache: false,
            data: {
                compare_table: _compare_table
            },
            beforeSend: function () {
                if ($('.nasa-compare-list-bottom').find('.nasa-loader').length <= 0) {
                    $('.nasa-compare-list-bottom').append('<div class="nasa-loader"></div>');
                }
            },
            success: function (res) {
                if (res.result_compare === 'success') {
                    if (res.mini_compare !== 'no-change' && $('.nasa-compare-list').length) {
                        $('.nasa-compare-list').replaceWith(res.mini_compare);
                        
                        $('.nasa-compare').removeClass('added');
                        $('.nasa-compare').removeClass('nasa-added');
                        
                        if ($('.compare-number .nasa-sl').length) {
                            $('.compare-number .nasa-sl').html('0');
                            if (!$('.compare-number').hasClass('nasa-product-empty')) {
                                $('.compare-number').addClass('nasa-product-empty');
                            }
                        }

                        $('.nasa-compare-success').html(res.mess_compare);
                        $('.nasa-compare-success').fadeIn(200);

                        if (_compare_table) {
                            $('.nasa-wrap-table-compare').replaceWith(res.result_table);
                        }
                    } else {
                        $('.nasa-compare-exists').html(res.mess_compare);
                        $('.nasa-compare-exists').fadeIn(200);
                    }

                    setTimeout(function () {
                        $('.nasa-compare-success').fadeOut(200);
                        $('.nasa-compare-exists').fadeOut(200);
                        $('.nasa-close-mini-compare').trigger('click');
                    }, 1000);
                }

                $('.nasa-compare-list-bottom').find('.nasa-loader').remove();
            },
            error: function() {

            }
        });
    }
}

/**
 * Show compare
 * 
 * @param {type} $
 * @returns {undefined}
 */
function showCompare($) {
    if ($('.nasa-compare-list-bottom').length) {
        $('.transparent-window').show();
        
        if ($('.nasa-show-compare').length && !$('.nasa-show-compare').hasClass('nasa-showed')) {
            $('.nasa-show-compare').addClass('nasa-showed');
        }
        
        if (!$('.nasa-compare-list-bottom').hasClass('nasa-active')) {
            $('.nasa-compare-list-bottom').addClass('nasa-active');
        }
    }
}

/**
 * Hide compare
 * 
 * @param {type} $
 * @returns {undefined}
 */
function hideCompare($) {
    if ($('.nasa-compare-list-bottom').length) {
        $('.transparent-window').fadeOut(550);
        
        if ($('.nasa-show-compare').length && $('.nasa-show-compare').hasClass('nasa-showed')) {
            $('.nasa-show-compare').removeClass('nasa-showed');
        }
        
        $('.nasa-compare-list-bottom').removeClass('nasa-active');
    }
}

/**
 * Tiptop
 * 
 * @param {type} $
 * @returns {undefined}
 */
function loadTipTop($) {
    var _inMobile = $('.nasa-check-reponsive.nasa-switch-check').length && $('.nasa-check-reponsive.nasa-switch-check').width() === 1 ? true : false;
    _inMobile = true;
    if ($('.tip-top').length > 0 && !_inMobile) {
        var tip, option;
        $('.tip-top').each(function () {
            option = {mode: "top", 'fix': true};
            tip = $(this);
            if (!$(tip).hasClass('nasa-tiped') && $(tip).parents('.group-btn-in-list').length <= 0) {
                $(tip).addClass('nasa-tiped');
                if ($(tip).attr('data-pos') === 'bot') {
                    option = {mode: "bottom"};
                }

                $(tip).tipr(option);
            }
        });
    }
}

/**
 * Change layout Grid | List shop page
 * 
 * @param {type} $
 * @param {type} _this
 * @returns {undefined}
 */
function changeLayoutShopPage($, _this) {
    var value_cookie, item_row, class_items;

    if ($(_this).hasClass('productList')) {
        value_cookie = 'list';
        $('.nasa-content-page-products .products').removeClass('grid').addClass('list');
        
        /**
         * Init btns for list
         */
        init_group_btn_list($);
    } else {
        var columns = $(_this).attr('data-columns');
        class_items = 'products grid';
        
        if ($('input[name="nasa-data-sidebar"]').length === 1) {
            columns = columns === '5' ? '4' : columns;
        }

        switch (columns) {
            case '3' :
                item_row = 3;
                value_cookie = 'grid-3';
                class_items += ' large-block-grid-3';
                break;
            case '4' :
                item_row = 4;
                value_cookie = 'grid-4';
                class_items += ' large-block-grid-4';
                break;
            case '5' :
            default :
                item_row = 5;
                value_cookie = 'grid-5';
                class_items += ' large-block-grid-5';
                break;
        }

        var count = $('.nasa-content-page-products .products').find('.product-warp-item').length;
        if (count > 0) {
            var _wrap_all = $('.nasa-content-page-products .products');
            var _col_small = $(_wrap_all).attr('data-columns_small');
            var _col_medium = $(_wrap_all).attr('data-columns_medium');
            
            switch (_col_small) {
                case '2' :
                    class_items += ' small-block-grid-2';
                    break;
                case '1' :
                default :
                    class_items += ' small-block-grid-1';
                    break;
            }
            
            switch (_col_medium) {
                case '3' :
                    class_items += ' medium-block-grid-3';
                    break;
                case '4' :
                    class_items += ' medium-block-grid-4';
                    break;
                case '2' :
                default :
                    class_items += ' medium-block-grid-2';
                    break;
            }
            
            $('.nasa-content-page-products .products').attr('class', class_items);
        }
    }

    $(".nasa-change-layout").removeClass("active");
    $(_this).addClass("active");
    $.cookie('gridcookie', value_cookie, {path: '/'});
    loadTipTop($);
    initThemeNasaGiftFeatured($);
    
    setTimeout(function() {
        loadProductsMasonryIsotope($, true);
        init_product_quickview_addtocart($, true);
        refreshCarousel($);
    }, 500);
}

/**
 * Single add to cart
 * 
 * @param {type} $
 * @param {type} _this
 * @param {type} _id
 * @param {type} _quantity
 * @param {type} _type
 * @param {type} _variation_id
 * @param {type} _variation
 * @param {type} _data_wishlist
 * @returns {undefined|Boolean}
 */
function nasa_single_add_to_cart($, _this, _id, _quantity, _type, _variation_id, _variation, _data_wishlist) {
    var _form = $(_this).parents('form.cart');
    
    if (_type === 'grouped') {
        if ($(_form).length) {
            if ($(_form).find('.nasa-custom-fields input[name="nasa_cart_sidebar"]').length) {
                $(_form).find('.nasa-custom-fields input[name="nasa_cart_sidebar"]').val('1');
            } else {
                $(_form).find('.nasa-custom-fields').append('<input type="hidden" name="nasa_cart_sidebar" value="1" />');
            }
            
            $(_form).submit();
        }
        
        return;
    }
    // Ajax add to cart
    else {
        var _urlAjax = null;
        if (
            typeof nasa_ajax_params !== 'undefined' &&
            typeof nasa_ajax_params.wc_ajax_url !== 'undefined'
        ) {
            _urlAjax = nasa_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', 'nasa_single_add_to_cart');
        }

        if (_urlAjax) {
            
            var _data = {
                product_id: _id,
                quantity: _quantity,
                product_type: _type,
                variation_id: _variation_id,
                variation: _variation,
                data_wislist: _data_wishlist
            };
            
            if ($(_form).length) {
                if (_type === 'simple') {
                    $(_form).find('.nasa-custom-fields').append('<input type="hidden" name="add-to-cart" value="' + _id + '" />');
                }
                
                _data = $(_form).serializeArray();
                $(_form).find('.nasa-custom-fields [name="add-to-cart"]').remove();
            }
            
            $.ajax({
                url: _urlAjax,
                type: 'post',
                dataType: 'json',
                cache: false,
                data: _data,
                beforeSend: function () {
                    $(_this).removeClass('added');
                    $(_this).removeClass('nasa-added');
                    $(_this).addClass('loading');
                },
                success: function (res) {
                    if (res.error) {
                        if ($(_this).hasClass('add-to-cart-grid')) {
                            var _href = $(_this).attr('href');
                            window.location.href = _href;
                        } else {
                            setNotice($, res.message);
                            $(_this).removeClass('loading');
                        }
                    } else {
                        var fragments = res.fragments;
                        if (fragments) {
                            $.each(fragments, function (key, value) {
                                $(key).addClass('updating');
                                $(key).replaceWith(value);
                            });

                            if (!$(_this).hasClass('added')) {
                                $(_this).addClass('added');
                            }

                            if (!$(_this).hasClass('nasa-added')) {
                                $(_this).addClass('nasa-added');
                            }
                        }

                        if ($('.wishlist_sidebar').length > 0) {
                            if (typeof res.wishlist !== 'undefined') {
                                $('.wishlist_sidebar').replaceWith(res.wishlist);
                                
                                setTimeout(function() {
                                    initWishlistIcons($, true);
                                }, 350);

                                if ($('.wishlist-number .nasa-sl').length > 0) {
                                    var sl_wislist = parseInt(res.wishlistcount);
                                    $('.wishlist-number .nasa-sl').html(sl_wislist);
                                    if (sl_wislist > 0) {
                                        $('.wishlist-number').removeClass('nasa-product-empty');
                                    }
                                    else if (sl_wislist === 0 && !$('.wishlist-number').hasClass('nasa-product-empty')) {
                                        $('.wishlist-number').addClass('nasa-product-empty');
                                    }
                                }

                                if ($('.add-to-wishlist-' + _id).length > 0) {
                                    $('.add-to-wishlist-' + _id).find('.yith-wcwl-add-button').show();
                                    $('.add-to-wishlist-' + _id).find('.yith-wcwl-wishlistaddedbrowse').hide();
                                    $('.add-to-wishlist-' + _id).find('.yith-wcwl-wishlistexistsbrowse').hide();
                                }
                            }
                        }

                        if ($('.page-shopping-cart').length === 1) {
                            $.ajax({
                                url: window.location.href,
                                type: 'get',
                                dataType: 'html',
                                cache: false,
                                data: {},
                                success: function (res) {
                                    var $html = $.parseHTML(res);

                                    if ($('.nasa-shopping-cart-form').length === 1) {
                                        var $new_form   = $('.nasa-shopping-cart-form', $html);
                                        var $new_totals = $('.cart_totals', $html);
                                        var $notices    = $('.woocommerce-error, .woocommerce-message, .woocommerce-info', $html);
                                        $('.nasa-shopping-cart-form').replaceWith($new_form);

                                        if ($notices.length > 0) {
                                            $('.nasa-shopping-cart-form').before($notices);
                                        }
                                        $('.cart_totals').replaceWith($new_totals);

                                    } else {
                                        var $new_content = $('.page-shopping-cart', $html);
                                        $('.page-shopping-cart').replaceWith($new_content);
                                    }

                                    $(document.body).trigger('updated_cart_totals');
                                    $(document.body).trigger('updated_wc_div');
                                    $('.nasa-shopping-cart-form').find('input[name="update_cart"]').prop('disabled', true);
                                }
                            });
                        }
                        
                        $(document.body).trigger('added_to_cart', [res.fragments, res.cart_hash, _this]);
                    }
                }
            });
        }
    }
    
    return false;
}

/**
 * Bundle Yith popup
 * 
 * @param {type} $
 * @param {type} _this
 * @returns {undefined}
 */
function loadComboPopup($, _this) {
    var _urlAjax = null;
    if (
        typeof nasa_ajax_params !== 'undefined' &&
        typeof nasa_ajax_params.wc_ajax_url !== 'undefined'
    ) {
        _urlAjax = nasa_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', 'nasa_combo_products');
    }
    
    if (_urlAjax) {
        var item = $(_this).parents('.product-item');
        if (!$(_this).hasClass('nasaing')) {
            $('.btn-combo-link').addClass('nasaing');
            var pid = $(_this).attr('data-prod');
            if (pid) {
                $.ajax({
                    url: _urlAjax,
                    type: 'post',
                    dataType: 'json',
                    cache: false,
                    data: {
                        id: pid,
                        'title_columns': 2
                    },
                    beforeSend: function () {
                        $(item).append('<div class="nasa-loader" style="top:50%"></div>');
                        $(item).find('.product-inner').css('opacity', '0.3');
                    },
                    success: function (res) {
                        $.magnificPopup.open({
                            mainClass: 'my-mfp-slide-bottom nasa-combo-popup-wrap',
                            items: {
                                src: '<div class="row nasa-combo-popup nasa-combo-row comboed-row zoom-anim-dialog" data-prod="' + pid + '">' + res.content + '</div>',
                                type: 'inline'
                            },
                            removalDelay: 300,
                            callbacks: {
                                afterClose: function() {

                                }
                            }
                        });

                        var _carousel = $('.nasa-combo-popup').find('.nasa-combo-slider');
                        loadCarouselCombo($, _carousel, 4);

                        setTimeout(function () {
                            $('.btn-combo-link').removeClass('nasaing');
                            $(item).find('.please-wait, .nasa-loader').remove();
                            $(item).find('.product-inner').css('opacity', '1');
                            if (!wow_enable) {
                                $('.nasa-combo-popup').find('.product-item').css({'visibility': 'visible'});
                            } else {
                                var _data_animate, _delay;
                                $('.nasa-combo-popup').find('.product-item').each(function() {
                                    var _this = $(this);
                                    _data_animate = $(_this).attr('data-wow');
                                    _delay = parseInt($(_this).attr('data-wow-delay'));
                                    $(_this).css({
                                        'visibility': 'visible',
                                        'animation-delay': _delay + 'ms',
                                        'animation-name': _data_animate
                                    }).addClass('animated');
                                });
                            }
                            var _height = $('.nasa-combo-popup').find('.owl-height').height();
                            var _real_height = $('.nasa-combo-popup').find('.owl-stage').height();
                            if (_height < _real_height) {
                                $('.nasa-combo-popup').find('.owl-height').removeAttr('style').css({'min-height': _real_height});
                            }
                        }, 500);
                    },
                    error: function () {
                        $('.btn-combo-link').removeClass('nasaing');
                    }
                });
            }
        }
    }
}

/**
 * Bundle Yith carousel
 * 
 * @param {type} $
 * @param {type} _this
 * @returns {undefined}
 */
function loadCarouselCombo($, _carousel, max_columns) {
    $(_carousel).owlCarousel({
        nav: false,
        loop: false,
        autoHeight: true,
        dots: false,
        autoplay: false,
        autoplaySpeed: 600,
        navSpeed: 600,
        autoplayHoverPause: true,
        navText: ["", ""],
        responsive: {
            "0": {
                items: 1,
                nav: false
            },
            "600": {
                items: 3,
                nav: false
            },
            "1000": {
                items: max_columns,
                nav: false
            }
        }
    });
    
    _carousel.find('.owl-item.active:first').addClass('first');
    _carousel.on('translated.owl.carousel', function(items) {
        var warp = items.target;
        if ($(warp).find('.owl-item').length > 0){
            $(warp).find('.owl-item').removeClass('first');
            $(warp).find('.owl-item.active:first').addClass('first');
        }
    });
}

/**
 * Nasa gift featured
 */
function initThemeNasaGiftFeatured($) {
    var _enable = ($('input[name="nasa-enable-gift-effect"]').length === 1 && $('input[name="nasa-enable-gift-effect"]').val() === '1') ? true : false;
    
    if (_enable && $('.nasa-gift-featured-event').length > 0) {
        var _delay = 0;
        $('.nasa-gift-featured-event').each(function(){
            var _this = $(this);
            if (!$(_this).hasClass('nasa-inited')) {
                $(_this).addClass('nasa-inited');
                var _wrap = $(_this).parents('.nasa-gift-featured-wrap');
                setTimeout(function() {
                    setInterval(function() {
                        $(_wrap).animate({'font-size': '250%'}, 300);
                        setTimeout(function() {
                            $(_wrap).animate({'font-size': '180%'}, 300);
                        }, 300);
                        setTimeout(function() {
                            $(_wrap).animate({'font-size': '250%'}, 300);
                        }, 600);
                        setTimeout(function() {
                            $(_wrap).animate({'font-size': '100%'}, 300);
                        }, 900);
                    }, 4000);
                }, _delay);
                
                _delay += 900;
            }
        });
    }
}

/**
 * Tags cloud
 * 
 * @param {type} $
 * @returns {undefined}
 */
function renderTagClouds($) {
    if ($('.nasa-tag-cloud').length > 0) {
        var _cat_act = parseInt($('.nasa-has-filter-ajax').find('.current-cat a').attr('data-id'));
        var re = /(tag-link-\d+)/g;
        $('.nasa-tag-cloud').each(function (){
            var _this = $(this),
                _taxonomy = $(_this).attr('data-taxonomy');
            
            if (!$(_this).hasClass('nasa-taged')) {
                var _term_id;
                $(_this).find('a').each(function(){
                    var _class = $(this).attr('class');
                    var m = _class.match(re);
                    _term_id = m !== null ? parseInt(m[0].replace("tag-link-", "")) : false;
                    if (_term_id){
                        $(this).addClass('nasa-filter-by-cat').attr('data-id', _term_id).attr('data-taxonomy', _taxonomy).removeAttr('style');
                        if (_term_id === _cat_act){
                            $(this).addClass('nasa-active');
                        }
                    }
                });
                
                $(_this).addClass('nasa-taged');
            }
        });
    }
}

/**
 * Reload Height deal
 * 
 * @param {type} $
 * @returns {undefined}
 */
function loadHeightDeal($) {
    if ($('.nasa-row-deal-3').length > 0) {
        var _inMobile = $('.nasa-check-reponsive.nasa-switch-check').length && $('.nasa-check-reponsive.nasa-switch-check').width() === 1 ? true : false;
        
        if (!_inMobile) {
            $('.nasa-row-deal-3').each(function() {
                var _this = $(this);
                var _sc = $(_this).find('.main-deal-block .nasa-sc-pdeal-block');
                var _side = $(_this).find('.nasa-sc-product-deals-grid');
                if ($(_side).length === 1) {
                    var _height = $(_side).height();
                    $(_sc).css({'min-height': _height - 30});
                }
            });
        } else {
            $('.nasa-row-deal-3 .main-deal-block .nasa-sc-pdeal-block').css({'height': 'auto'});
        }
    }
}

/**
 * Load height full to side
 */
function loadHeightFullWidthToSide($) {
    if ($('#main-content > .section-element > .row > .columns.nasa-full-to-left, #main-content > .section-element > .row > .columns.nasa-full-to-right').length > 0) {
        var _wwin = $(window).width();
        
        $('#main-content > .section-element > .row > .columns.nasa-full-to-left, #main-content > .section-element > .row > .columns.nasa-full-to-right').each(function() {
            var _this = $(this);
            if (_wwin > 1200) {
                var _hElement = $(_this).outerHeight();
                var _hWrap = $(_this).parent().height();
                if (_hWrap <= _hElement) {
                    $(_this).parent().css({'min-height': _hElement});
                } else {
                    $(_this).parent().css({'min-height': 'auto'});
                }
            } else {
                $(_this).parent().css({'min-height': 'auto'});
            }
        });
    }
}

/**
 * Main menu Reponsive
 */
function loadResponsiveMainMenu($) {
    if (!$('body').hasClass('nasa-core-deactived') && $('.nasa-menus-wrapper-reponsive').length > 0) {
        var _wwin = $(window).width();
        
        $('.nasa-menus-wrapper-reponsive').each(function() {
            var _this = $(this);
            
            var _wrap = $(_this).parents('.wide-nav');
            var _tl = _wwin/1200;
            if (_tl < 1) {
                var _x = $(_this).attr('data-padding_x');
                var _y = $(_this).attr('data-padding_y');
                var _params = {'font-size': (100*_tl).toString() + '%'};
                
                _params.padding = ($(_wrap).hasClass('nasa-nav-style-1')) ? (_tl*_y).toString() + 'px ' + (_tl*_x*2).toString() + 'px ' + (_tl*_y).toString() + 'px 0' : (_tl*_y).toString() + 'px ' + (_tl*_x).toString() + 'px';

                $(_this).find('.header-nav > li > a').css(_params);

                $(_this).find('.nasa-title-vertical-menu').css({
                    'padding': (_tl*_y - 1).toString() + 'px ' + (_tl*_x + 10).toString() + 'px ' + (_tl*_y - 1).toString() + 'px 15px'
                });

                $(_this).find('.title-inner').css({
                    'font-size': (100*_tl).toString() + '%'
                });
            } else {
                $(_this).find('.header-nav > li > a').removeAttr('style');
                $(_this).find('.nasa-title-vertical-menu').removeAttr('style');
                $(_this).find('.title-inner').removeAttr('style');
            }

            if (_wwin < 1200) {
                var _w_wrap = $(_this).parents('.nasa-wrap-width-main-menu').outerWidth();
                $(_this).find('.header-nav .nasa-megamenu > .nav-dropdown').css({'max-width': _w_wrap + 21, 'left': 0});
            } else {
                $(_this).find('.header-nav .nasa-megamenu > .nav-dropdown').removeAttr('style');
            }
        });
    }
}

/**
 * 
 * @type initMainMenuVertical.mini_acc|initMainMenuVertical.head_menu|StringMain menu
 */
function initMainMenuVertical($) {
    if ($('#nasa-menu-sidebar-content .nasa-menu-for-mobile').length <= 0) {
        var _mobileDetect = $('input[name="nasa_mobile_layout"]').length ? true : false;
        
        var _mobile_menu = '';

        if ($('#site-navigation').length === 1) {
            _mobile_menu += $('#site-navigation').html();
            if (_mobileDetect) {
                $('#site-navigation').remove();
            }
        }

        else if ($('.nasa-header-content-builder .header-nav').length) {
            $('.nasa-header-content-builder .header-nav').each(function() {
                _mobile_menu += $(this).html();
            });
        }

        /**
         * Vertical menu
         */
        if ($('.nasa-vertical-header .vertical-menu-wrapper').length > 0){
            var ver_menu = $('.nasa-vertical-header .vertical-menu-wrapper').html();
            var ver_menu_title = $('.nasa-vertical-header .nasa-title-vertical-menu').html();
            var ver_menu_warp = '<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-parent-item default-menu root-item li_accordion"><a href="javascript:void(0);">' + ver_menu_title + '</a><div class="nav-dropdown-mobile"><ul class="sub-menu">' + ver_menu + '</ul></div></li>';
            _mobile_menu += ver_menu_warp;
            
            if (_mobileDetect) {
                $('.nasa-vertical-header').remove();
            }
        }

        /**
         * Heading
         */
        if ($('#heading-menu-mobile').length === 1) {
            _mobile_menu = '<li class="menu-item root-item menu-item-heading">' + $('#heading-menu-mobile').html() + '</li>' + _mobile_menu;
            
            if (_mobileDetect) {
                $('#heading-menu-mobile').remove();
            }
        }

        /**
         * Vertical menu
         */
        if ($('.nasa-shortcode-menu.vertical-menu').length > 0) {
            $('.nasa-shortcode-menu.vertical-menu').each(function() {
                var _this = $(this);
                var ver_menu_sc = $(_this).find('.vertical-menu-wrapper').html();
                var ver_menu_title_sc = $(_this).find('.section-title').html();
                var ver_menu_warp_sc = '<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-parent-item default-menu root-item nasa-sc-menu-vertical li_accordion"><h5 class="menu-item-heading margin-top-35 margin-bottom-10">' + ver_menu_title_sc + '</h5><div class="nav-dropdown-mobile"><ul class="sub-menu">' + ver_menu_sc + '</ul></div></li>';
                _mobile_menu += ver_menu_warp_sc;
                
                if (_mobileDetect) {
                    $(_this).remove();
                }
            });
        }
        
        /**
         * Topbar menu
         */
        if ($('.nasa-topbar-menu').length) {
            _mobile_menu += $('.nasa-topbar-menu').html();
            
            if (_mobileDetect) {
                $('.nasa-topbar-menu').remove();
            }
        }

        /**
         * Mobile account
         */
        if ($('#mobile-account').length === 1) {
            if ($('#nasa-menu-sidebar-content').hasClass('nasa-light-new') && $('#mobile-account').find('.nasa-menu-item-account').length) {
                var _class_menu_acc = 'menu-item root-item menu-item-account root-item';
                _class_menu_acc += $('#mobile-account').find('.sub-menu').length ? ' menu-item-has-children' : '';
                _mobile_menu += '<li class="' + _class_menu_acc + '">' + $('#mobile-account').find('.nasa-menu-item-account').html() + '</li>';
            } else {
                _mobile_menu += '<li class="menu-item root-item menu-item-account">' + $('#mobile-account').html() + '</li>';
            }
            
            if (_mobileDetect) {
                $('#mobile-account').remove();
            }
        }

        /**
         * Switch language
         */
        var switch_lang = '';
        if ($('.topbar-menu-container .header-switch-languages').length === 1) {
            switch_lang = $('.topbar-menu-container .header-switch-languages').html();
            if (_mobileDetect) {
                $('.topbar-menu-container .header-switch-languages').remove();
            }
        }

        if ($('.topbar-menu-container .header-multi-languages').length) {
            switch_lang = $('.topbar-menu-container .header-multi-languages').html();
            if (_mobileDetect) {
                $('.topbar-menu-container .header-multi-languages').remove();
            }
        }

        if ($('#nasa-menu-sidebar-content').hasClass('nasa-light-new')) {
            _mobile_menu = '<ul id="mobile-navigation" class="header-nav nasa-menu-accordion nasa-menu-for-mobile">' + _mobile_menu + switch_lang + '</ul>';
        } else {
            _mobile_menu = '<ul id="mobile-navigation" class="header-nav nasa-menu-accordion nasa-menu-for-mobile">' + switch_lang + _mobile_menu + '</ul>';
        }

        if ($('#nasa-menu-sidebar-content #mobile-navigation').length) {
            $('#nasa-menu-sidebar-content #mobile-navigation').replaceWith(_mobile_menu);
        } else {
            $('#nasa-menu-sidebar-content .nasa-mobile-nav-wrap').html(_mobile_menu);
        }
        
        var _nav = $('#nasa-menu-sidebar-content').find('#mobile-navigation');
        
        if ($(_nav).find('.nasa-select-currencies').length) {
            var _currency = $(_nav).find('.nasa-select-currencies');
            var _class = $(_currency).find('.wcml_currency_switcher').attr('class');
            _class += ' menu-item-has-children root-item li_accordion';
            var _currencyObj = $(_currency).find('.wcml-cs-active-currency').clone();
            $(_currencyObj).addClass(_class);
            $(_currencyObj).find('.wcml-cs-submenu').addClass('sub-menu');
            
            $(_nav).find('.nasa-select-currencies').replaceWith(_currencyObj);
        }

        $(_nav).find('.root-item > a').removeAttr('style');
        $(_nav).find('.nav-dropdown').attr('class', 'nav-dropdown-mobile').removeAttr('style');
        $(_nav).find('.nav-column-links').addClass('nav-dropdown-mobile');

        /**
         * Fix for nasa-core not active.
         */
        $(_nav).find('.sub-menu').each(function() {
            if (!$(this).parent('.nav-dropdown-mobile').length) {
                $(this).wrap('<div class="nav-dropdown-mobile"></div>');
            }
        });

        $(_nav).find('.nav-dropdown-mobile').find('.sub-menu').removeAttr('style');
        $(_nav).find('hr.hr-nasa-megamenu').remove();
        $(_nav).find('li').each(function(){
            if ($(this).hasClass('menu-item-has-children')){
                $(this).addClass('li_accordion');
                if ($(this).hasClass('current-menu-ancestor') || $(this).hasClass('current-menu-parent')){
                    $(this).addClass('active');
                    $(this).prepend('<a href="javascript:void(0);" class="accordion"></a>');
                } else {
                    $(this).prepend('<a href="javascript:void(0);" class="accordion"></a>').find('>.nav-dropdown-mobile').hide();
                }
            }
        });
        
        $(_nav).find('a').removeAttr('style');
    }
}

/**
 * position Mobile menu
 * 
 * @param {type} $
 * @returns {undefined}
 */
function positionMenuMobile($) {
    if ($('#nasa-menu-sidebar-content').length) {
        if ($('#mobile-navigation').length && $('#mobile-navigation').attr('data-show') !== '1') {
            $('#nasa-menu-sidebar-content').removeClass('nasa-active');

            var _h_adminbar = $('#wpadminbar').length > 0 ? $('#wpadminbar').height() : 0;
            if (_h_adminbar > 0) {
                $('#nasa-menu-sidebar-content').css({'top': _h_adminbar});
            }
        }
    }
}

/**
 * Top categories filter
 * 
 * @param {type} $
 * @returns {undefined}
 */
function initTopCategoriesFilter($) {
    if ($('.nasa-top-cat-filter').length > 0) {
        var _act;
        var _obj;

        $('.nasa-top-cat-filter').each(function() {
            var _this_filter = $(this);
            var _root_item = $(_this_filter).find('.root-item');
            _act = false;
            _obj = null;
            if ($(_root_item).length > 0) {

                $(_root_item).each(function() {
                    var _this = $(this);
                    if ($(_this).hasClass('active')) {
                        $(_this).addClass('nasa-current-top');
                        _obj =  $(_this);
                        _act = true;
                    }
                    
                    $(_this).find('.children .nasa-current-note').remove();
                });

                if (!_act) {
                    $(_root_item).each(function() {
                        var _this = $(this);
                        if ($(_this).hasClass('cat-parent') && !_act) {
                            $(_this).addClass('nasa-current-top');
                            _obj =  $(_this);
                            _act = true;
                        }
                    });
                }

                if (_obj !== null) {
                    var init_width = $(_obj).width();
                    if (init_width) {
                        var _pos = $(_obj).position();
                        var _note_act = $(_obj).parents('.nasa-top-cat-filter').find('.nasa-current-note');
                        $(_note_act).css({'visibility': 'visible', 'width': init_width, 'left': _pos.left, top: ($(_obj).height() - 1)});
                    }
                }
            }
        });
    }
}

/**
 * hover top categories filter
 * @param {type} $
 * @returns {undefined}
 */
function hoverTopCategoriesFilter($) {
    $('body').on('mouseover', '.nasa-top-cat-filter .root-item', function() {
        var _obj = $(this),
            _wrap = $(_obj).parents('.nasa-top-cat-filter');
        $(_wrap).find('.root-item').removeClass('nasa-current-top');
        $(_obj).addClass('nasa-current-top');

        var _pos = $(_obj).position();
        var _note_act = $(_wrap).find('> .nasa-current-note');
        $(_note_act).css({'visibility': 'visible', 'width': $(_obj).width(), 'left': _pos.left, top: ($(_obj).height() - 1)});
        
        return false;
    });
}

/**
 * hover top child categories filter
 * @param {type} $
 * @returns {undefined}
 */
function hoverChilrenTopCatogoriesFilter($) {
    $('body').on('mouseover', '.nasa-top-cat-filter .children .cat-item', function() {
        var _obj = $(this),
            _wrap = $(_obj).parent('.children');
        var _note_act = $(_wrap).find('>.nasa-current-note');
        
        if ($(_note_act).length <= 0) {
            $(_wrap).prepend('<li class="nasa-current-note" />');
            _note_act = $(_wrap).find('>.nasa-current-note');
        }
        
        $(_wrap).find('.cat-item').removeClass('nasa-current-child');
        $(_obj).addClass('nasa-current-child');

        var _pos = $(_obj).position();
        $(_note_act).css({'visibility': 'visible', 'width': $(_obj).width(), 'left': _pos.left, top: ($(_obj).height() - 1)});
        
        return false;
    });
}

/**
 * clone group btn loop products
 * 
 * @param {type} $
 * @returns {undefined}
 */
function cloneGroupBtnsProductItem($) {
    if ($('.nasa-content-page-products .nasa-btns-product-item').length > 0) {
       $('.nasa-content-page-products .nasa-btns-product-item').each(function() {
           var _this = $(this);
           var _wrap = $(_this).parents('.product-item');
           var _place = $(_wrap).find('.group-btn-in-list');
           var _btns = $(_this).html();
           var _price = $(_wrap).find('.price-wrap').html();
           var _stock = $(_wrap).find('.nasa-list-stock-wrap').html();
           
           if ($(_place).length > 0) {
               $(_place).html('<div class="price-wrap">' + _price + '</div>' + _stock + _btns);
           }
       }); 
    }
}

/**
 * Single slick images
 * 
 * @param {type} $
 * @param {type} restart
 * @returns {undefined}
 */
function loadSlickSingleProduct($, restart) {
    if ($('.nasa-single-product-slide .nasa-single-product-main-image').length === 1) {
        var _restart = typeof restart === 'undefined' ? false : true;
        var _rtl = $('body').hasClass('nasa-rtl') ? true : false;
        
        var _root_wrap = $('.nasa-single-product-slide');
        var _main = $(_root_wrap).find('.nasa-single-product-main-image'),
            _thumb = $(_root_wrap).find('.nasa-single-product-thumbnails').length === 1 ? $(_root_wrap).find('.nasa-single-product-thumbnails') : null,
            
            _autoplay = $(_root_wrap).attr('data-autoplay') === 'true' ? true : false,
            _speed = parseInt($(_root_wrap).attr('data-speed')),
            _delay = parseInt($(_root_wrap).attr('data-delay')),
            _num_main = parseInt($(_root_wrap).attr('data-num_main'));

        _speed = !_speed ? 600 : _speed;
        _delay = !_delay ? 3000 : _delay;
        _num_main = !_num_main ? 1 : _num_main;
        
        if (_restart) {
            if ($(_main).length && $(_main).hasClass('slick-initialized')) {
                $(_main).slick('unslick');
            }
            
            if ($(_thumb).length && $(_thumb).hasClass('slick-initialized')) {
                $(_thumb).slick('unslick');
            }
        }
        
        var _interval = setInterval(function() {
            if ($(_main).find('#nasa-main-image-0 img').height()) {
                $(_main).slick({
                    rtl: _rtl,
                    slidesToShow: _num_main,
                    autoplay: _autoplay,
                    autoplaySpeed: _delay,
                    speed: _speed,
                    arrows: true,
                    infinite: false,
                    asNavFor: _thumb,
                    adaptiveHeight: true,
                    responsive: [
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 1
                            }
                        }
                    ]
                });

                if (_thumb) {
                    var _num_ver = parseInt($(_root_wrap).attr('data-num_thumb'));
                    _num_ver = !_num_ver ? 4 : _num_ver;

                    var _vertical = true;
                    var wrapThumb = $(_thumb).parents('.nasa-thumb-wrap');

                    if ($(wrapThumb).length && $(wrapThumb).hasClass('nasa-thumbnail-hoz')) {
                        _vertical = false;
                        _num_ver = 5;
                    }

                    var _setting = {
                        vertical: _vertical,
                        slidesToShow: _num_ver,
                        swipeToSlide: true,
                        dots: false,
                        arrows: false,
                        infinite: false
                    };

                    if (!_vertical) {
                        _setting.rtl = _rtl;
                    } else {
                        _setting.verticalSwiping = true;
                    }

                    _setting.asNavFor = _main;
                    _setting.centerMode = false;
                    _setting.centerPadding = '0';
                    _setting.focusOnSelect = true;

                    $(_thumb).slick(_setting);
                    $(_thumb).attr('data-speed', _speed);
                    
                    if (_vertical && $('.nasa-suggested-mouse').length && $('.nasa-suggested-mouse').hasClass('hidden-tag')) {
                        $('.nasa-suggested-mouse').removeClass('hidden-tag');
                    }
                }
                
                clearInterval(_interval);
            }
        }, 100);
        
        $('body').on('click', '.nasa-single-product-slide .nasa-single-product-thumbnails .slick-slide', function() {
            var _wrap = $(this).parents('.nasa-single-product-thumbnails');
            var _speed = parseInt($(_wrap).attr('data-speed'));
            _speed = !_speed ? 600 : _speed;
            $(_wrap).append('<div class="nasa-slick-fog"></div>');

            setTimeout(function(){
                $(_wrap).find('.nasa-slick-fog').remove();
            }, _speed);
        });
    }
}

/**
 * loadScrollSingleProduct
 */
function loadScrollSingleProduct($) {
    if ($('.nasa-single-product-scroll').length === 1) {
        if ($('.nasa-single-product-thumbnails').hasClass('nasa-single-fixed')) {
            var _thumb_wrap = $('.nasa-single-product-thumbnails').parents('.nasa-thumb-wrap');
            var _pos_thumb = $(_thumb_wrap).offset();
            $('.nasa-single-product-thumbnails').css({
                'left': _pos_thumb.left,
                'width': $(_thumb_wrap).width()
            });
        }
        
        if ($('.nasa-product-info-scroll').hasClass('nasa-single-fixed')) {
            var _scroll_wrap = $('.nasa-product-info-scroll').parents('.nasa-product-info-wrap');
            var _pos_wrap = $(_scroll_wrap).offset();
            $('.nasa-product-info-scroll').css({
                'left': _pos_wrap.left,
                'width': $(_scroll_wrap).width()
            });
        }
        
        var _col_main = parseInt($('.nasa-single-product-scroll').attr('data-num_main'));
        var _main_images = [];
        $('.nasa-item-main-image-wrap').each(function() {
            var p = {
                id: '#' + $(this).attr('id'),
                pos: $(this).offset().top
            };
            
            _main_images.push(p);
        });
        
        $('body').on('click', '.nasa-thumb-wrap .nasa-wrap-item-thumb', function() {
            var _main = $(this).attr('data-main');
            
            var _topfix = 0;
            if ($('.fixed-already').length === 1) {
                _topfix += $('.fixed-already').outerHeight();
            }

            if ($('#wpadminbar').length === 1) {
                _topfix += $('#wpadminbar').outerHeight();
            }
            
            var _pos_top = $(_main).offset().top - _topfix;
            $('html, body').animate({scrollTop: _pos_top - 10}, 300);
        });
        
        $(window).scroll(function(){
            var scrollTop = $(this).scrollTop();
            var bodyHeight = $(window).height();
            var _inMobile = $('.nasa-check-reponsive.nasa-switch-check').length && $('.nasa-check-reponsive.nasa-switch-check').width() === 1 ? true : false;
            if (!_inMobile) {
                var _pos = $('.nasa-main-wrap').offset();
                var _pos_end = $('.nasa-end-scroll').offset();

                var _topfix = 0;
                if ($('.fixed-already').length === 1) {
                    _topfix += $('.fixed-already').outerHeight();
                }

                if ($('#wpadminbar').length === 1) {
                    _topfix += $('#wpadminbar').outerHeight();
                }
                
                if ($('.nasa-product-info-scroll').outerHeight() > (bodyHeight - _topfix)) {
                    $('.nasa-product-info-scroll').css('max-height', (bodyHeight - _topfix - 50));
                }

                if ($('.nasa-single-product-thumbnails').outerHeight() > (bodyHeight - _topfix)) {
                    $('.nasa-single-product-thumbnails').css('max-height', (bodyHeight - _topfix - 50));
                }
                
                var _start_top = _pos.top - _topfix;
                var _info_height = $('.nasa-product-info-scroll').height();
                var _thumb_height = $('.nasa-single-product-thumbnails').height();
                
                var _moc_end_info = scrollTop + bodyHeight - (bodyHeight - _info_height) + _topfix + 10;
                var _moc_end_thumb = scrollTop + bodyHeight - (bodyHeight - _thumb_height) + _topfix + 10;
                var _topbar = scrollTop - _start_top;
                
                if (_pos_end.top > _moc_end_info) {
                    if (_topbar >= 0){
                        var _scroll_wrap = $('.nasa-product-info-scroll').parents('.nasa-product-info-wrap');
                        var _pos_wrap = $(_scroll_wrap).offset();
                        if (!$('.nasa-product-info-scroll').hasClass('nasa-single-fixed')) {
                            $('.nasa-product-info-scroll').addClass('nasa-single-fixed');
                        }
                        $('.nasa-product-info-scroll').css({
                            'transform': 'translate3d(0, 0, 0)',
                            'top': _topfix + 10,
                            'left': _pos_wrap.left,
                            'width': $(_scroll_wrap).width()
                        });
                        $('.nasa-product-info-scroll').css({'margin-top': _topbar + 10});
                        $('.nasa-product-info-scroll').css({'overflow-y': 'auto'});
                        
                    } else {
                        if ($('.nasa-product-info-scroll').hasClass('nasa-single-fixed')) {
                            $('.nasa-product-info-scroll').removeClass('nasa-single-fixed');
                        }
                        $('.nasa-product-info-scroll').css({'margin-top': 0});
                        $('.nasa-product-info-scroll').css({'overflow-y': 'inherit'});
                    }
                } else {
                    if ($('.nasa-product-info-scroll').hasClass('nasa-single-fixed')) {
                        $('.nasa-product-info-scroll').removeClass('nasa-single-fixed');
                    }
                }
                
                if (_pos_end.top > _moc_end_thumb) {
                    if (_topbar >= 0){
                        var _thumb_wrap = $('.nasa-single-product-thumbnails').parents('.nasa-thumb-wrap');
                        var _pos_thumb = $(_thumb_wrap).offset();
                        if (!$('.nasa-single-product-thumbnails').hasClass('nasa-single-fixed')) {
                            $('.nasa-single-product-thumbnails').addClass('nasa-single-fixed');
                        }
                        $('.nasa-single-product-thumbnails').css({
                            'transform': 'translate3d(0, 0, 0)',
                            'top': _topfix + 10,
                            'left': _pos_thumb.left,
                            'width': $(_thumb_wrap).width()
                        });
                        $('.nasa-single-product-thumbnails').css({'margin-top': _topbar  + 10});
                    } else {
                        if ($('.nasa-single-product-thumbnails').hasClass('nasa-single-fixed')) {
                            $('.nasa-single-product-thumbnails').removeClass('nasa-single-fixed');
                        }
                        $('.nasa-single-product-thumbnails').css({'margin-top': 0});
                    }
                } else {
                    if ($('.nasa-single-product-thumbnails').hasClass('nasa-single-fixed')) {
                        $('.nasa-single-product-thumbnails').removeClass('nasa-single-fixed');
                    }
                }

                // Active image scroll
                var i = _main_images.length;
                if (i) {
                    for(i; i>0; i--) {
                        if (_main_images[i-1].pos <= scrollTop + _topfix + 50){
                            var _key = $(_main_images[i-1].id).attr('data-key');
                            $('.nasa-thumb-wrap .nasa-wrap-item-thumb').removeClass('nasa-active');
                            $('.nasa-thumb-wrap .nasa-wrap-item-thumb[data-key="' + _key + '"]').addClass('nasa-active');
                            if (_col_main % 2 === 0) {
                                var _before_key = (parseInt(_key) - 1).toString();
                                if ($('.nasa-thumb-wrap .nasa-wrap-item-thumb[data-key="' + _before_key + '"]').length) {
                                    $('.nasa-thumb-wrap .nasa-wrap-item-thumb[data-key="' + _before_key + '"]').addClass('nasa-active');
                                }
                            }
                            
                            break;
                        }
                    }
                }
            } else {
                $('.nasa-product-info-scroll').css({'margin-top': 0});
                $('.nasa-single-product-thumbnails').css({'margin-top': 0});
                $('.nasa-thumb-wrap .nasa-wrap-item-thumb').removeClass('nasa-active');
                $('.nasa-thumb-wrap .nasa-wrap-item-thumb[data-key="0"]').addClass('nasa-active');
            }
        });
    }
}

/**
 * Render top bar shop page
 * 
 * @param {type} $
 * @returns {undefined}
 */
function initNasaTopSidebar($) {
    if ($('.nasa-top-sidebar').length) {
        var wk = 0;

        var top_row = '<ul class="nasa-top-row-filter">';

        if ($('input[name="nasa-labels-filter-text"]').length && $('input[name="nasa-labels-filter-text"]').val() !== '') {
            top_row += '<li><span class="nasa-labels-filter-text">' + $('input[name="nasa-labels-filter-text"]').val() + '</span></li>';
        }

        var rows = '<div class="row nasa-show">';
        var _title, _rss;
        var _stt = 1;
        var _limit = parseInt($('input[name="nasa-limit-widgets-show-more"]').val());
        _limit = (!_limit || _limit < 0) ? 999999 : _limit;
        var _show_more = false;
        $('.nasa-top-sidebar').find('>.widget').each(function() {
            var _this = $(this);

            var _widget_act = $(_this).find('.nasa-filter-var-chosen').length > 0 ? true : false;
            if ($(_this).find('input[name="nasa_hasPrice"]').length > 0 && $(_this).find('input[name="nasa_hasPrice"]').val() === '1') {
                _widget_act = true;
            }
            var _class_act = _widget_act ? ' nasa-active' : '';
            if ($(_this).find('.widgettitle').length) {
                _title = $(_this).find('.widgettitle').html();
                _rss = '';
                if ($(_this).find('.widgettitle').find('a').length > 0) {
                    _title = '';
                    $(_this).find('.widgettitle').find('a').each(function() {
                        if ($(this).find('img').length > 0) {
                            _rss += $(this).html();
                        } else {
                            _title += $(this).html();
                        }
                    });
                }
            } else {
                _title = '...';
            }
            var _widget_key = 'nasa-widget-key-' + wk.toString();
            var _old_id = $(_this).attr('id');
            var _class_row = '';
            var _filter_push_cat = false;
            if ($(_this).find('.nasa-widget-filter-cats-topbar').length > 0) {
                if ($('.nasa-push-cat-filter').length === 1) {
                    _filter_push_cat = true;
                    _class_act += ' nasa-tab-push-cats';
                    $('.nasa-push-cat-filter').html($(_this).wrap('<div>').parent().html());
                } else {
                    _class_act += ' nasa-tab-filter-cats';
                    _class_row += ' nasa-widget-cat-wrap';
                }
            }

            var _icon_before = _filter_push_cat ? '<i class="pe-7s-note2"></i>' : '';
            var _icon_after = !_filter_push_cat ? '<i class="pe-7s-angle-down"></i>' : '';

            var _li_class = _stt <= _limit ? ' nasa-widget-show' : ' nasa-widget-show-less';
            if (_stt > _limit) {
                _show_more = true;
            }

            top_row += '<li class="nasa-widget-toggle' + _li_class + '">';
            if ($(_this).find('.nasa-reset-filters-btn').length <= 0) {
                top_row += '<a class="nasa-tab-filter-topbar' + _class_act + '" href="javascript:void(0);" title="' + _title + '" data-widget="#' + _widget_key + '" data-key="' + wk + '" data-old_id="' + _old_id + '">' + _icon_before + _rss + _title + _icon_after + '</a>';
            }
            else {
                top_row += $(_this).find('.nasa-reset-filters-btn').wrap('<div>').parent().html();
            }
            top_row += '</li>';

            if (!_filter_push_cat && $(_this).find('.nasa-reset-filters-btn').length <= 0) {
                rows += '<div class="large-12 columns nasa-widget-wrap' + _class_row + '" id="' + _widget_key + '" data-old_id="' + _old_id + '">';
                rows += $(_this).wrap('<div>').parent().html();
                rows += '</div>';
            }

            wk++;
            _stt++;
        });

        if (_show_more) {
            top_row += '<li class="nasa-widget-show-more">';
            top_row += '<a class="nasa-widget-toggle-show" href="javascript:void(0);" data-show="0">' + $('input[name="nasa-widget-show-more-text"]').val() + '</a>';
            top_row += '</li>';
        }

        if ($('.showing_info_top').length > 0) {
            top_row += '<li class="last"><input type="hidden" name="nasa-pos-showing-info" value="1" />';
            top_row += '<div class="showing_info_top">';
            top_row += $('.showing_info_top').html();
            top_row += '</div></li>';
        }

        top_row += '</ul>';
        rows += '</div>';

        $('.nasa-top-sidebar').html(rows).removeClass('hidden-tag');
        $('.nasa-labels-filter-accordion').html(top_row).removeClass('hidden-tag');

        var _act_variations = getTopFilterActiveVatiations($);
        $('.nasa-top-sidebar').append(_act_variations);

        /**
         * Show | Hide price filter
         */
        if ($('.nasa-top-sidebar .nasa-filter-price-widget-wrap').length > 0) {
            var _tabtop = $('.nasa-top-sidebar .nasa-filter-price-widget-wrap').parents('.nasa-widget-wrap').attr('id');
            if (typeof _tabtop !== 'undefined' && $('.nasa-tab-filter-topbar[data-widget="#' + _tabtop + '"]').length > 0) {
                if ($('.nasa-top-sidebar .nasa-filter-price-widget-wrap').hasClass('nasa-hide-price')) {
                    $('.nasa-tab-filter-topbar[data-widget="#' + _tabtop + '"]').parents('li').hide();
                } else {
                    $('.nasa-tab-filter-topbar[data-widget="#' + _tabtop + '"]').parents('li').fadeIn(200);
                }
            }
        }
    }
}

/**
 * Render top bar 2 shop page
 * 
 * @param {type} $
 * @returns {undefined}
 */
function initNasaTopSidebar2($) {
    if ($('.nasa-top-sidebar-2').length) {
        var _wrap = $('.nasa-top-sidebar-2');
        if (!$(_wrap).hasClass('nasa-slider')) {
            $(_wrap).addClass('nasa-slider');
            $(_wrap).addClass('owl-carousel');
            $(_wrap).attr('data-margin', '40');
            $(_wrap).attr('data-columns', '4');
            $(_wrap).attr('data-columns-small', '1');
            $(_wrap).attr('data-columns-tablet', '2');
            $(_wrap).attr('data-autoplay', 'false');
            $(_wrap).attr('data-loop', 'false');
            $(_wrap).attr('data-dot', 'false');
            $(_wrap).attr('data-height-auto', 'true');
            $(_wrap).attr('data-disable-nav', 'true');

            loadingCarousel($);
        }
    }
}

/**
 * Toggle Top Side bar type 2
 * 
 * @param {type} $
 * @param {type} _this
 * @param {type} type
 * @returns {undefined}
 */
function topFilterClick2($, _this, type) {
    if ($('.nasa-top-bar-2-content').length) {
        var _act = $(_this).hasClass('nasa-active') ? true : false;
        
        if (!_act) {
            if (type === 'animate') {
                $('.nasa-top-bar-2-content').addClass('nasa-active').slideDown(350);
                setTimeout(function() {
                    initNasaTopSidebar2($);
                }, 350);
            } else {
                $('.nasa-top-bar-2-content').addClass('nasa-active').show();
                initNasaTopSidebar2($);
            }
            $(_this).addClass('nasa-active');
        } else {
            if (type === 'animate') {
                $('.nasa-top-bar-2-content').removeClass('nasa-active').slideUp(350);
            } else {
                $('.nasa-top-bar-2-content').removeClass('nasa-active').hide();
            }
            $(_this).removeClass('nasa-active');
        }
    }
}

/**
 * _act_variations
 * @param {type} $
 * @returns {String}
 */
function getTopFilterActiveVatiations($) {
    var _act_variations = '<div class="nasa-top-sidebar-variations-active"><div class="row"><div class="large-12 columns">';
    if ($('.nasa-top-sidebar').length > 0) {
        $('.nasa-top-sidebar').find('.nasa-widget-wrap').each(function() {
            var _this = $(this);
            var _title = $(_this).find('.widgettitle').html();
            
            // variations
            var _widget_act = $(_this).find('.nasa-filter-var-chosen').length > 0 ? true : false;
            if (_widget_act) {
                _act_variations += '<div class="nasa-variations-active-top">';
                _act_variations += '<span class="nasa-variations-active-title">' + _title + ': </span>';
                $(_this).find('.nasa-filter-var-chosen').each(function() {
                    var term_id = $(this).attr('data-term_id');
                    var term_slug = $(this).attr('data-term_slug');
                    var _attr = $(this).attr('data-attr');
                    var _type = $(this).attr('data-type');

                    var _item = '<a href="javascript:void(0);" class="nasa-ignore-variation-item" data-term_id="' + term_id + '" data-term_slug="' + term_slug + '" data-attr="' + _attr + '" data-type="' + _type + '">' + $(this).html() + '</a>';

                    _act_variations += '<span class="nasa-variations-active-item">' + _item + '</span>';
                });
                _act_variations += '</div>';
            }
        });
    }
    _act_variations += '</div></div></div>';
    
    return _act_variations;
}

/**
 * Click top filter
 * 
 * @param {type} $
 * @param {type} _this
 * @param {type} type
 * @returns {undefined}
 */
function topFilterClick($, _this, type) {
    if (!$(_this).hasClass('nasa-tab-push-cats')) {
        var _obj = $(_this).attr('data-widget');
        var _wrap_content = $('.nasa-top-sidebar');

        var _act = $(_obj).hasClass('nasa-active') ? true : false;
        $(_this).parents('.nasa-top-row-filter').find('> li').removeClass('nasa-active');
        $(_wrap_content).find('.nasa-widget-wrap').removeClass('nasa-active').slideUp(350);
        if (type === 'animate') {
            $(_wrap_content).find('.nasa-widget-wrap').removeClass('nasa-active').slideUp(350);
        } else {
            $(_wrap_content).find('.nasa-widget-wrap').removeClass('nasa-active').hide();
        }

        if (!_act) {
            if (type === 'animate') {
                $(_obj).addClass('nasa-active').slideDown(350);
            } else {
                $(_obj).addClass('nasa-active').show();
            }
            $(_this).parents('li').addClass('nasa-active');
        }

        if ($(_this).hasClass('nasa-tab-filter-cats')) {
            initTopCategoriesFilter($);
        }
    } else {
        $('.nasa-push-cat-filter').toggleClass('nasa-push-cat-show');
        $('.nasa-products-page-wrap').toggleClass('nasa-push-cat-show');
        $('.black-window-mobile').toggleClass('nasa-push-cat-show');
        loadProductsMasonryIsotope($, true);
        
        setTimeout(function() {
            init_product_quickview_addtocart($, true);
            refreshCarousel($);
        }, 1000);
    }
}

/*
 * loadProductsMasonryIsotope
 */
function loadProductsMasonryIsotope($, hasDestroy, _init_ltr) {
    if ($('.nasa-products-masonry-isotope').length) {
        if (_isotope_init && hasDestroy) {
            $('.nasa-products-masonry-isotope .products').isotope('destroy');
            _isotope_init = false;
        }
        
        var init_ltr = typeof _init_ltr === 'undefined' ? false : _init_ltr;
        var _data = {
            itemSelector: '.product-warp-item',
            layoutMode: 'masonry'
        };
        if (init_ltr) {
            var _ltr = $('body').hasClass('nasa-rtl') ? false : true;
            _data.isOriginLeft = _ltr;
        }

        if ($('.nasa-products-masonry-isotope .products.grid').length) {
            var interval = setInterval(function() {
                var _main = $('.nasa-products-masonry-isotope .products.grid');
                $(_main).find('.product-item').each(function(){
                    var _item = $(this);
                    if (!$(_item).hasClass('nasa-loaded') && $(_item).find('.main-img img').height()) {
                        $(_item).addClass('nasa-loaded');
                    }
                });

                if ($(_main).find('.product-item.nasa-loaded').length === $(_main).find('.product-item').length) {
                    $(_main).isotope(_data);
                    
                    _isotope_init = true;
                    
                    clearInterval(interval);
                }
            }, 100);
        }
    }
}

/*
 * loadProductsMasonryIsotope
 */
function refreshProductsMasonryIsotope($) {
    if ($('.nasa-products-masonry-isotope').length) {
       if ($('.nasa-products-masonry-isotope .products.grid').length) {
            var interval = setInterval(function() {
                var _main = $('.nasa-products-masonry-isotope .products.grid');
                $(_main).find('.product-item').each(function(){
                    var _item = $(this);
                    if (!$(_item).hasClass('nasa-loaded') && $(_item).find('.main-img img').height()) {
                        $(_item).addClass('nasa-loaded');
                    }
                });

                if ($(_main).find('.product-item.nasa-loaded').length === $(_main).find('.product-item').length) {
                    setTimeout(function() {
                        $(_main).isotope('layout');
                    }, 500);
                    
                    clearInterval(interval);
                }
            }, 100);
        }
    }
}

/*
 * loadPostsMasonryIsotope
 */
function loadPostsMasonryIsotope($, hasDestroy) {
    if ($('.nasa-posts-masonry-isotope').length > 0) {
        if (_isotope_init && hasDestroy) {
            _isotope = $('.nasa-posts-masonry-isotope').isotope('destroy');
            _isotope_init = false;
        }
        
        if ($('.nasa-posts-masonry-isotope').length > 0) {
            setTimeout(function () {
                _isotope = $('.nasa-posts-masonry-isotope').isotope({
                    percentPosition: true,
                    itemSelector: '.nasa-posts-masonry-isotope-item'
                });

                _isotope_init = true;
            }, 800);
            
            setTimeout(function() {
                $(window).resize();
            }, 1000);
        }
    }
}

/**
 * Init Mini Wishlist Icon
 * 
 * @param {type} $
 * @returns {undefined}
 */
function initMiniWishlist($) {
    if ($('input[name="nasa_wishlist_cookie_name"]').length) {
        var _wishlistArr = get_wishlist_ids($);
        if (_wishlistArr.length) {
            if ($('.wishlist-number .nasa-sl').length) {
                var sl_wislist = _wishlistArr.length;
                $('.wishlist-number .nasa-sl').html(convert_count_items($, sl_wislist));
                if (sl_wislist > 0) {
                    $('.wishlist-number').removeClass('nasa-product-empty');
                }
                if (sl_wislist === 0 && !$('.wishlist-number').hasClass('nasa-product-empty')) {
                    $('.wishlist-number').addClass('nasa-product-empty');
                }
            }
        }
    }
}

/**
 * init Wishlist icons
 */
function initWishlistIcons($, init) {
    var _init = typeof init === 'undefined' ? false : init;
    
    /**
     * NasaTheme Wishlist
     */
    if ($('input[name="nasa_wishlist_cookie_name"]').length) {
        var _wishlistArr = get_wishlist_ids($);
        if (_wishlistArr.length) {
            $('.btn-wishlist').each(function() {
                var _this = $(this);
                var _prod = $(_this).attr('data-prod');

                if (_wishlistArr.indexOf(_prod) !== -1) {
                    if (!$(_this).hasClass('nasa-added')) {
                        $(_this).addClass('nasa-added');
                    }

                    if (!$(_this).find('.wishlist-icon').hasClass('added')) {
                        $(_this).find('.wishlist-icon').addClass('added');
                    }
                }

                else if (_init) {
                    if ($(_this).hasClass('nasa-added')) {
                        $(_this).removeClass('nasa-added');
                    }

                    if ($(_this).find('.wishlist-icon').hasClass('added')) {
                        $(_this).find('.wishlist-icon').removeClass('added');
                    }
                }
            });
        }
    }
    
    /**
     * support Yith WooCommerce Wishlist
     */
    else {
    
        if (
            $('.wishlist_sidebar .wishlist_table').length ||
            $('.wishlist_sidebar .nasa_yith_wishlist_premium-wrap .wishlist_table').length
        ) {
            var _wishlistArr = [];
            if ($('.wishlist_sidebar .wishlist_table .nasa-tr-wishlist-item').length) {
                $('.wishlist_sidebar .wishlist_table .nasa-tr-wishlist-item').each(function() {
                    _wishlistArr.push($(this).attr('data-row-id'));
                });
            }

            if ($('.wishlist_sidebar .nasa_yith_wishlist_premium-wrap .wishlist_table tbody tr').length) {
                $('.wishlist_sidebar .nasa_yith_wishlist_premium-wrap .wishlist_table tbody tr').each(function() {
                    _wishlistArr.push($(this).attr('data-row-id'));
                });
            }

            $('.btn-wishlist').each(function() {
                var _this = $(this);
                var _prod = $(_this).attr('data-prod');

                if (_wishlistArr.indexOf(_prod) !== -1) {
                    if (!$(_this).hasClass('nasa-added')) {
                        $(_this).addClass('nasa-added');
                    }

                    if (!$(_this).find('.wishlist-icon').hasClass('added')) {
                        $(_this).find('.wishlist-icon').addClass('added');
                    }
                }

                else if (_init) {
                    if ($(_this).hasClass('nasa-added')) {
                        $(_this).removeClass('nasa-added');
                    }

                    if ($(_this).find('.wishlist-icon').hasClass('added')) {
                        $(_this).find('.wishlist-icon').removeClass('added');
                    }
                }
            });
        }
    }
}

/**
 * init Compare icons
 */
function initCompareIcons($, _init) {
    var init = typeof _init !== 'undefined' ? _init : false;
    var _comparetArr = get_compare_ids($);
    
    if (init && $('.nasa-compare-count.compare-number .nasa-sl').length) {
        var _slCompare = _comparetArr.length;
        $('.nasa-compare-count.compare-number .nasa-sl').html(convert_count_items($, _slCompare));
        $('.nasa-compare-count.compare-number .nasa-sl').removeClass('hidden-tag');
        
        if (_slCompare <= 0) {
            if (!$('.compare-number').hasClass('nasa-product-empty')) {
                $('.compare-number').addClass('nasa-product-empty');
            }
        } else {
            $('.compare-number').removeClass('nasa-product-empty');
        }
    }

    if (_comparetArr.length && $('.btn-compare').length) {
        $('.btn-compare').each(function() {
            var _this = $(this);
            var _prod = $(_this).attr('data-prod');

            if (_comparetArr.indexOf(_prod) !== -1) {
                if (!$(_this).hasClass('added')) {
                    $(_this).addClass('added');
                }
                if (!$(_this).hasClass('nasa-added')) {
                    $(_this).addClass('nasa-added');
                }
            } else {
                $(_this).removeClass('added');
                $(_this).removeClass('nasa-added');
            }
        });
    }
}

/**
 * Equal Height Columns
 * 
 * @param {type} $
 * @param {type} _scrollTo
 * @returns {undefined}
 */
function row_equal_height_columns($, _scrollTo) {
    if ($('.nasa-row-cols-equal-height').length) {
        var _scroll = typeof _scrollTo === 'undefined' ? false : _scrollTo;
        
        var _mobileView = $('.nasa-check-reponsive.nasa-switch-check').length && $('.nasa-check-reponsive.nasa-switch-check').width() === 1 ? true : false;
        
        $('.nasa-row-cols-equal-height').each(function() {
            var _this = $(this);
            
            var _offset = false;
            
            if (_scroll) {
                _offset = $(_this).offset();
            }
            
            if ($(_this).find('> .row > .columns').length || $(_this).find('> .nasa-row > .columns').length) {
                var _childs = $(_this).find('> .row').length ?
                    $(_this).find('> .row > .columns') : $(_this).find('> .nasa-row > .columns');
                
                var _placement = $(_this).attr('data-content_placement');
                var _h = 0;
                
                if (typeof _offset.top !== 'undefined') {
                    var _scrollTop = $(window).scrollTop();
                    if (_scrollTop >= _offset.top + 10 && !$(_this).hasClass('nasa-height-scroll')) {
                        $(_this).addClass('nasa-height-scroll');
                        $(_childs).removeAttr('style');
                        if (!_mobileView) {
                            $(_childs).each(function() {
                                var _col = $(this);
                                var _h_col = $(_col).outerHeight();
                                _h = _h < (_h_col-1) ? _h_col-1 : _h;
                            });

                            $(_childs).each(function() {
                                var _col2 = $(this);
                                var _h_col2 = $(_col2).outerHeight();
                                if (_h_col2 < _h) {
                                    if (_placement === 'middle') {
                                        $(_col2).css({
                                            'height': _h,
                                            'padding-top': (_h - _h_col2) / 2
                                        });
                                    }

                                    else if (_placement === 'bottom') {
                                        $(_col2).css({
                                            'height': _h,
                                            'padding-top': _h - _h_col2
                                        });
                                    }

                                    else {
                                        $(_col2).css({
                                            'height': _h
                                        });
                                    }
                                }
                            });
                        }
                    }
                } else {
                    $(_this).removeClass('nasa-height-scroll');
                    $(_childs).removeAttr('style');
                    if (!_mobileView) {
                        $(_childs).each(function() {
                            var _col = $(this);
                            var _h_col = $(_col).outerHeight();
                            _h = _h < (_h_col-1) ? _h_col-1 : _h;
                        });

                        $(_childs).each(function() {
                            var _col2 = $(this);
                            var _h_col2 = $(_col2).outerHeight();
                            if (_h_col2 < _h) {
                                if (_placement === 'middle') {
                                    $(_col2).css({
                                        'height': _h,
                                        'padding-top': (_h - _h_col2) / 2
                                    });
                                }

                                else if (_placement === 'bottom') {
                                    $(_col2).css({
                                        'height': _h,
                                        'padding-top': _h - _h_col2
                                    });
                                }

                                else {
                                    $(_col2).css({
                                        'height': _h
                                    });
                                }
                            }
                        });
                    }
                }
            }
        });
    }
}

/**
 * load carousel lightbox images
 */
function loadLightboxCarousel($) {
    if ($('.main-image-slider').length) {
        if (!$('.main-image-slider').hasClass('owl-loaded')) {
            var _items = $('.main-image-slider').attr('data-items');
            var _rtl = $('body').hasClass('nasa-rtl') ? true : false;
            $('.main-image-slider').owlCarousel({
                items: _items ? _items : 1,
                rtl: _rtl,
                loop: false,
                nav: true,
                autoplay: false,
                autoplaySpeed: 500,
                dots: true,
                autoplayTimeout: 3000,
                autoplayHoverPause: true,
                responsiveClass: true,
                navText: ["", ""],
                navSpeed: 500
            });
        }
    }
}

/**
 * Change image variable Single product
 */
function changeImageVariableSingleProduct($, $form, variation) {
    var _zoom = $('body').hasClass('product-zoom') ? true : false;
    var _api_easyZoom = false;
    
    if (!/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) && $('.product-zoom .easyzoom .nasa-disabled-touchstart').length <= 0) {
        if (_zoom) {
            var _easyZoom = $('.product-zoom .easyzoom').easyZoom({loadingNotice: ''});
            var _api_easyZoom = _easyZoom.data('easyZoom');
        }
    }
        
    if (variation && variation.image && variation.image.src && variation.image.src.length > 1) {
        var _countSelect = $form.find('.variations .value select').length;
        var _selected = 0;
        if (_countSelect) {
            $form.find('.variations .value select').each(function() {
                if ($(this).val() !== '') {
                    _selected++;
                }
            });
        }

        if (_countSelect && _selected === _countSelect) {
            var src_thumb = false;

            /**
             * Support Bundle product
             */
            if ($('.nasa-product-details-page .woosb-product').length) {
                if (variation.image.thumb_src !== 'undefined' || variation.image.gallery_thumbnail_src !== 'undefined') {
                    src_thumb = variation.image.gallery_thumbnail_src ? variation.image.gallery_thumbnail_src :  variation.image.thumb_src;
                }

                if (src_thumb) {
                    $form.parents('.woosb-product').find('.woosb-thumb-new').html('<img src="' + src_thumb + '" />');
                    $form.parents('.woosb-product').find('.woosb-thumb-ori').hide();
                    $form.parents('.woosb-product').find('.woosb-thumb-new').show();
                }
            } else {
                var _src_large = typeof variation.image_single_page !== 'undefined' ?
                variation.image_single_page : variation.image.url;

                $('.main-images .nasa-item-main-image-wrap:eq(0) img').attr('src', _src_large);
                $('.main-images .nasa-item-main-image-wrap:eq(0) a').attr('href', variation.image.url);
                if (_api_easyZoom) {
                    _api_easyZoom.swap(_src_large, variation.image.url);
                    var _imgChange = $('.main-images .nasa-item-main-image-wrap:eq(0) img');
                    if ($(_imgChange).hasClass('jetpack-lazy-image')) {
                        $(_imgChange).attr('src', _src_large);
                    }
                }
                $('.main-images .nasa-item-main-image-wrap:eq(0) img').removeAttr('srcset');

                if (variation.image.thumb_src !== 'undefined') {
                    src_thumb = variation.image.thumb_src;
                } else {
                    var thumb_wrap = $('.product-thumbnails .nasa-wrap-item-thumb:eq(0)');
                    if (typeof $(thumb_wrap).attr('data-thumb_org') === 'undefined') {
                        $(thumb_wrap).attr('data-thumb_org', $(thumb_wrap).find('img').attr('src'));
                    }

                    src_thumb = $(thumb_wrap).attr('data-thumb_org');
                }

                if (src_thumb) {
                    $('.product-thumbnails .nasa-wrap-item-thumb:eq(0) img').attr('src', src_thumb).removeAttr('srcset');
                    if ($('input[name="nasa-enable-focus-main-image"]').length && $('input[name="nasa-enable-focus-main-image"]').val() === '1') {
                        $('.product-thumbnails .nasa-wrap-item-thumb:eq(0) a').trigger('click');
                    }

                    if ($('.nasa-thumb-clone img').length) {
                        $('.nasa-thumb-clone img').attr('src', src_thumb);
                    }
                }
            }
        }
    } else {
        /**
         * Support Bundle product
         */
        if ($('.nasa-product-details-page .woosb-product').length) {
            $form.parents('.woosb-product').find('.woosb-thumb-ori').show();
            $form.parents('.woosb-product').find('.woosb-thumb-new').hide();
        } else {
            var image_link = typeof $('.nasa-product-details-page .woocommerce-main-image').attr('data-full_href') !== 'undefined' ?
                $('.nasa-product-details-page .woocommerce-main-image').attr('data-full_href') :
                $('.nasa-product-details-page .woocommerce-main-image').attr('data-o_href');
            var image_large = $('.nasa-product-details-page .woocommerce-main-image').attr('data-o_href');

            $('.main-images .nasa-item-main-image-wrap:eq(0) img').attr('src', image_large).removeAttr('srcset');
            $('.main-images .nasa-item-main-image-wrap:eq(0) a').attr('href', image_link);
            if (_api_easyZoom) {
                _api_easyZoom.swap(image_large, image_link);
                var _imgChange = $('.main-images .nasa-item-main-image-wrap:eq(0) img');
                if ($(_imgChange).hasClass('jetpack-lazy-image')) {
                    $(_imgChange).attr('src', image_large);
                }
            }

            var thumb_wrap = $('.product-thumbnails .nasa-wrap-item-thumb:eq(0)');
            if (typeof $(thumb_wrap).attr('data-thumb_org') === 'undefined') {
                $(thumb_wrap).attr('data-thumb_org', $(thumb_wrap).find('img').attr('src'));
            }

            var src_thumb = $(thumb_wrap).attr('data-thumb_org');
            if (src_thumb) {
                $('.product-thumbnails .nasa-wrap-item-thumb:eq(0) img').attr('src', src_thumb);
                if ($('input[name="nasa-enable-focus-main-image"]').length && $('input[name="nasa-enable-focus-main-image"]').val() === '1') {
                    $('.product-thumbnails .nasa-wrap-item-thumb:eq(0) a').trigger('click');
                }

                if ($('.nasa-thumb-clone img').length) {
                    $('.nasa-thumb-clone img').attr('src', src_thumb);
                }
            }
        }
    }

    /**
     * deal time
     */
    if ($('.nasa-detail-product-deal-countdown').length) {
        if (
            variation && variation.variation_id &&
            variation.is_in_stock && variation.is_purchasable
        ) {
            if (typeof _single_variations[variation.variation_id] === 'undefined') {
                var _urlAjax = null;
                if (
                    typeof nasa_ajax_params !== 'undefined' &&
                    typeof nasa_ajax_params.wc_ajax_url !== 'undefined'
                ) {
                    _urlAjax = nasa_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', 'nasa_get_deal_variation');
                }

                if (_urlAjax) {
                    $.ajax({
                        url: _urlAjax,
                        type: 'post',
                        dataType: 'json',
                        cache: false,
                        data: {
                            pid: variation.variation_id
                        },
                        beforeSend: function () {
                            $('.nasa-detail-product-deal-countdown').html('');
                            $('.nasa-detail-product-deal-countdown').removeClass('nasa-show');

                            if ($('.nasa-single-product-countdown').length && !$('.nasa-single-product-countdown').hasClass('hidden-tag')) {
                                $('.nasa-single-product-countdown').addClass('hidden-tag');
                            }
                        },
                        success: function (res) {
                            if (typeof res.success !== 'undefined' && res.success === '1') {
                                _single_variations[variation.variation_id] = res.content;
                            } else {
                                _single_variations[variation.variation_id] = '';
                            }
                            $('.nasa-detail-product-deal-countdown').html(_single_variations[variation.variation_id]);
                            if (_single_variations[variation.variation_id] !== '') {
                                loadCountDown($);
                                if (!$('.nasa-detail-product-deal-countdown').hasClass('nasa-show')) {
                                    $('.nasa-detail-product-deal-countdown').addClass('nasa-show');
                                }

                                $('.nasa-single-product-countdown').removeClass('hidden-tag');
                            } else {
                                $('.nasa-detail-product-deal-countdown').removeClass('nasa-show');

                                if ($('.nasa-single-product-countdown').length && !$('.nasa-single-product-countdown').hasClass('hidden-tag')) {
                                    $('.nasa-single-product-countdown').addClass('hidden-tag');
                                }
                            }
                        }
                    });
                }
            } else {
                setTimeout(function() {
                    $('.nasa-detail-product-deal-countdown').html(_single_variations[variation.variation_id]);
                    if (_single_variations[variation.variation_id] !== '') {
                        loadCountDown($);
                        if (!$('.nasa-detail-product-deal-countdown').hasClass('nasa-show')) {
                            $('.nasa-detail-product-deal-countdown').addClass('nasa-show');
                        }

                        $('.nasa-single-product-countdown').removeClass('hidden-tag');
                    } else {
                        $('.nasa-detail-product-deal-countdown').removeClass('nasa-show');

                        if ($('.nasa-single-product-countdown').length && !$('.nasa-single-product-countdown').hasClass('hidden-tag')) {
                            $('.nasa-single-product-countdown').addClass('hidden-tag');
                        }
                    }
                }, 100);
            }
        } else {
            $('.nasa-detail-product-deal-countdown').html('');
            $('.nasa-detail-product-deal-countdown').removeClass('nasa-show');

            if ($('.nasa-single-product-countdown').length && !$('.nasa-single-product-countdown').hasClass('hidden-tag')) {
                $('.nasa-single-product-countdown').addClass('hidden-tag');
            }
        }
    }
}

/**
 * Reset Zoom
 * 
 * @param {type} $
 * @returns {undefined}
 */
function resetZoom($) {
    var _zoom = $('body').hasClass('product-zoom') ? true : false;
    if (!/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) && $('.product-zoom .easyzoom .nasa-disabled-touchstart').length <= 0) {
        if (_zoom) {
            var _easyZoom = $('.product-zoom .easyzoom').easyZoom({loadingNotice: ''});
            _easyZoom.data('easyZoom');
        }
    }
}

var _inited_gallery = false;
var _inited_gallery_key = 0;
function changeGalleryVariableSingleProduct($, $form, variation) {
    if (variation && variation.image && variation.image.src && variation.image.src.length > 1) {
        var _countSelect = $form.find('.variations .value select').length;
        var _selected = 0;
        if (_countSelect) {
            $form.find('.variations .value select').each(function() {
                if ($(this).val() !== '') {
                    _selected++;
                }
            });
        }

        if (_countSelect && _selected === _countSelect) {
            _inited_gallery = false;
            _inited_gallery_key = 1;

            var _data = {
                'variation_id': variation.variation_id,
                'main_id': (variation.image_id ? variation.image_id : 0),
                'gallery': variation.nasa_gallery_variation
            };

            if (
                $('.nasa-detail-product-deal-countdown').length &&
                variation.is_in_stock && variation.is_purchasable
            ) {
                _data.deal_variation = '1';
            }

            if (typeof _single_variations[variation.variation_id] === 'undefined') {
                var _urlAjax = null;
                if (
                    typeof nasa_ajax_params !== 'undefined' &&
                    typeof nasa_ajax_params.wc_ajax_url !== 'undefined'
                ) {
                    _urlAjax = nasa_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', 'nasa_get_gallery_variation');
                }

                if (_urlAjax) {
                    $.ajax({
                        url: _urlAjax,
                        type: 'post',
                        dataType: 'json',
                        cache: false,
                        data: {
                            data: _data
                        },
                        beforeSend: function () {
                            $('.nasa-detail-product-deal-countdown').html('');
                            $('.nasa-detail-product-deal-countdown').removeClass('nasa-show');
                            if ($('.nasa-single-product-countdown').length && !$('.nasa-single-product-countdown').hasClass('hidden-tag')) {
                                $('.nasa-single-product-countdown').addClass('hidden-tag');
                            }

                            $('.nasa-product-details-page').find('.product-gallery').append('<div class="nasa-loading"></div>');
                            $('.nasa-product-details-page').find('.product-gallery').append('<div class="nasa-loader" style="top:45%"></div>');
                            $('.product-gallery').css({'min-height': $('.product-gallery').outerHeight()});
                        },
                        success: function (result) {
                            $('.nasa-product-details-page').find('.product-gallery .nasa-loading').remove();
                            $('.nasa-product-details-page').find('.product-gallery .nasa-loader').remove();

                            _single_variations[variation.variation_id] = result;

                            /**
                             * Deal
                             */
                            if (typeof result.deal_variation !== 'undefined') {
                                $('.nasa-detail-product-deal-countdown').html(result.deal_variation);

                                if (result.deal_variation !== '') {
                                    loadCountDown($);
                                    if (!$('.nasa-detail-product-deal-countdown').hasClass('nasa-show')) {
                                        $('.nasa-detail-product-deal-countdown').addClass('nasa-show');
                                    }

                                    $('.nasa-single-product-countdown').removeClass('hidden-tag');
                                }

                                else {
                                    $('.nasa-detail-product-deal-countdown').removeClass('nasa-show');
                                    if ($('.nasa-single-product-countdown').length && !$('.nasa-single-product-countdown').hasClass('hidden-tag')) {
                                        $('.nasa-single-product-countdown').addClass('hidden-tag');
                                    }
                                }
                            } else {
                                $('.nasa-detail-product-deal-countdown').removeClass('nasa-show');
                                if ($('.nasa-single-product-countdown').length && !$('.nasa-single-product-countdown').hasClass('hidden-tag')) {
                                    $('.nasa-single-product-countdown').addClass('hidden-tag');
                                }
                            } 

                            /**
                             * Main image
                             */
                            if (typeof result.main_image !== 'undefined') {
                                $('.nasa-main-image-default').replaceWith(result.main_image);
                            }

                            /**
                             * Thumb image
                             */
                            if (typeof result.thumb_image !== 'undefined') {
                                $('.nasa-thumbnail-default').replaceWith(result.thumb_image);

                                if ($('.nasa-thumb-clone img').length && $('.product-thumbnails .nasa-wrap-item-thumb:eq(0) img').length) {
                                    $('.nasa-thumb-clone img').attr('src', $('.product-thumbnails .nasa-wrap-item-thumb:eq(0) img').attr('src'));
                                }
                            }

                            loadSlickSingleProduct($, true);
                            resetZoom($);
                            loadGalleryPopup($);
                            compatibleJetpack($);

                            setTimeout(function (){
                                $('.product-gallery').css({'min-height': 'auto'});
                                $(window).resize();
                            }, 100);
                        }
                    });
                }
            } else {
                setTimeout(function() {
                    var result = _single_variations[variation.variation_id];

                    /**
                     * Deal
                     */
                    if (typeof result.deal_variation !== 'undefined') {
                        $('.nasa-detail-product-deal-countdown').html(result.deal_variation);

                        if (result.deal_variation !== '') {
                            loadCountDown($);
                            if (!$('.nasa-detail-product-deal-countdown').hasClass('nasa-show')) {
                                $('.nasa-detail-product-deal-countdown').addClass('nasa-show');
                            }

                            $('.nasa-single-product-countdown').removeClass('hidden-tag');
                        }

                        else {
                            $('.nasa-detail-product-deal-countdown').removeClass('nasa-show');
                            if ($('.nasa-single-product-countdown').length && !$('.nasa-single-product-countdown').hasClass('hidden-tag')) {
                                $('.nasa-single-product-countdown').addClass('hidden-tag');
                            }
                        }
                    } else {
                        $('.nasa-detail-product-deal-countdown').removeClass('nasa-show');
                        if ($('.nasa-single-product-countdown').length && !$('.nasa-single-product-countdown').hasClass('hidden-tag')) {
                            $('.nasa-single-product-countdown').addClass('hidden-tag');
                        }
                    }

                    /**
                     * Main image
                     */
                    if (typeof result.main_image !== 'undefined') {
                        $('.nasa-main-image-default').replaceWith(result.main_image);
                    }

                    /**
                     * Thumb image
                     */
                    if (typeof result.thumb_image !== 'undefined') {
                        $('.nasa-thumbnail-default').replaceWith(result.thumb_image);

                        if ($('.nasa-thumb-clone img').length && $('.product-thumbnails .nasa-wrap-item-thumb:eq(0) img').length) {
                            $('.nasa-thumb-clone img').attr('src', $('.product-thumbnails .nasa-wrap-item-thumb:eq(0) img').attr('src'));
                        }
                    }

                    loadSlickSingleProduct($, true);
                    resetZoom($);
                    loadGalleryPopup($);
                    compatibleJetpack($);
                }, 100);


                setTimeout(function (){
                    $(window).resize();
                }, 200);
            }
        }
    }

    /**
     * Default
     */
    else {
        if (!_inited_gallery) {

            _inited_gallery = true;

            var result = _single_variations[0];
            if ($('.nasa-detail-product-deal-countdown').length) {
                $('.nasa-detail-product-deal-countdown').removeClass('nasa-show').html('');
            }

            /**
             * Main image
             */
            if (typeof result.main_image !== 'undefined') {
                $('.nasa-main-image-default').replaceWith(result.main_image);
            }

            /**
             * Thumb image
             */
            if (typeof result.thumb_image !== 'undefined') {
                $('.nasa-thumbnail-default').replaceWith(result.thumb_image);

                if ($('.nasa-thumb-clone img').length && $('.product-thumbnails .nasa-wrap-item-thumb:eq(0) img').length) {
                    $('.nasa-thumb-clone img').attr('src', $('.product-thumbnails .nasa-wrap-item-thumb:eq(0) img').attr('src'));
                }
            }

            loadSlickSingleProduct($, true);
            resetZoom($);
            loadGalleryPopup($);
            compatibleJetpack($);

            setTimeout(function (){
                $(window).resize();
            }, 100);
        }
    }
}

function loadGalleryPopup($) {
    if ($('.main-images').length) {
        if (!$('body').hasClass('nasa-disable-lightbox-image')) {
            $('.main-images').magnificPopup({
                delegate: 'a',
                type: 'image',
                tLoading: '<div class="nasa-loader"></div>',
                removalDelay: 300,
                closeOnContentClick: true,
                tClose: $('input[name="nasa-close-string"]').val(),
                gallery: {
                    enabled: true,
                    navigateByImgClick: false,
                    preload: [0,1]
                },
                image: {
                    verticalFit: false,
                    tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
                },
                callbacks: {
                    beforeOpen: function() {
                        var productVideo = $('.product-video-popup').attr('href');

                        if (productVideo){
                            // Add product video to gallery popup
                            this.st.mainClass = 'has-product-video';
                            var galeryPopup = $.magnificPopup.instance;
                            galeryPopup.items.push({
                                src: productVideo,
                                type: 'iframe'
                            });

                            galeryPopup.updateItemHTML();
                        }
                    },
                    open: function() {

                    }
                }
            });
        }
        
        /**
         * Disable lightbox image
         */
        else {
            $('body').on('click', '.main-images a.woocommerce-additional-image', function() {
                return false;
            });
        }
    }
}

/**
 * Support for Quick-view
 */
function changeGalleryVariableQuickviewProduct($, _data) {
    _quicked_gallery = false;
    
    if (typeof _lightbox_variations[_data.variation_id] === 'undefined') {
        var _urlAjax = null;
        if (
            typeof nasa_ajax_params !== 'undefined' &&
            typeof nasa_ajax_params.wc_ajax_url !== 'undefined'
        ) {
            _urlAjax = nasa_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', 'nasa_quickview_gallery_variation');
        }

        if (_urlAjax) {
            $.ajax({
                url: _urlAjax,
                type: 'post',
                dataType: 'json',
                cache: false,
                data: {
                    data: _data
                },
                beforeSend: function () {
                    $('.nasa-quickview-product-deal-countdown').html('');
                    $('.nasa-quickview-product-deal-countdown').removeClass('nasa-show');
                    
                    if ($('.nasa-quickview-product-countdown').length && !$('.nasa-quickview-product-countdown').hasClass('hidden-tag')) {
                        $('.nasa-quickview-product-countdown').addClass('hidden-tag');
                    }

                    $('.nasa-product-gallery-lightbox').append('<div class="nasa-loading"></div>');
                    $('.nasa-product-gallery-lightbox').append('<div class="nasa-loader" style="top:45%"></div>');
                    $('.nasa-product-gallery-lightbox').css({'min-height': $('.nasa-product-gallery-lightbox').outerHeight()});
                },
                success: function (result) {
                    $('.nasa-product-gallery-lightbox').find('.nasa-loading').remove();
                    $('.nasa-product-gallery-lightbox').find('.nasa-loader').remove();

                    _lightbox_variations[_data.variation_id] = result;

                    /**
                     * Deal
                     */
                    if (typeof result.deal_variation !== 'undefined') {
                        $('.nasa-quickview-product-deal-countdown').html(result.deal_variation);

                        if (result.deal_variation !== '') {
                            loadCountDown($);
                            if (!$('.nasa-quickview-product-deal-countdown').hasClass('nasa-show')) {
                                $('.nasa-quickview-product-deal-countdown').addClass('nasa-show');
                            }
                            
                            $('.nasa-quickview-product-countdown').removeClass('hidden-tag');
                        }

                        else {
                            $('.nasa-quickview-product-deal-countdown').removeClass('nasa-show');
                            
                            if ($('.nasa-quickview-product-countdown').length && !$('.nasa-quickview-product-countdown').hasClass('hidden-tag')) {
                                $('.nasa-quickview-product-countdown').addClass('hidden-tag');
                            }
                        }
                    } else {
                        $('.nasa-quickview-product-deal-countdown').removeClass('nasa-show');
                        
                        if ($('.nasa-quickview-product-countdown').length && !$('.nasa-quickview-product-countdown').hasClass('hidden-tag')) {
                            $('.nasa-quickview-product-countdown').addClass('hidden-tag');
                        }
                    }

                    /**
                     * Main image
                     */
                    if (typeof result.quickview_gallery !== 'undefined') {
                        $('.nasa-product-gallery-lightbox').find('.main-image-slider').replaceWith(result.quickview_gallery);
                    }

                    setTimeout(function (){
                        $('.nasa-product-gallery-lightbox').css({'min-height': 'auto'});
                    }, 100);

                    loadLightboxCarousel($);
                }
            });
        }
    } else {
        setTimeout(function() {
            var result = _lightbox_variations[_data.variation_id];
            /**
             * Deal
             */
            if (typeof result.deal_variation !== 'undefined') {
                $('.nasa-quickview-product-deal-countdown').html(result.deal_variation);

                if (result.deal_variation !== '') {
                    loadCountDown($);
                    if (!$('.nasa-quickview-product-deal-countdown').hasClass('nasa-show')) {
                        $('.nasa-quickview-product-deal-countdown').addClass('nasa-show');
                    }

                    $('.nasa-quickview-product-countdown').removeClass('hidden-tag');
                }

                else {
                    $('.nasa-quickview-product-deal-countdown').removeClass('nasa-show');

                    if ($('.nasa-quickview-product-countdown').length && !$('.nasa-quickview-product-countdown').hasClass('hidden-tag')) {
                        $('.nasa-quickview-product-countdown').addClass('hidden-tag');
                    }
                }
            } else {
                $('.nasa-quickview-product-deal-countdown').removeClass('nasa-show');

                if ($('.nasa-quickview-product-countdown').length && !$('.nasa-quickview-product-countdown').hasClass('hidden-tag')) {
                    $('.nasa-quickview-product-countdown').addClass('hidden-tag');
                }
            }
            
            /**
             * Main image
             */
            if (typeof result.quickview_gallery !== 'undefined') {
                $('.nasa-product-gallery-lightbox').find('.main-image-slider').replaceWith(result.quickview_gallery);
            }

            loadLightboxCarousel($);
        }, 100);
    }
}

/**
 * clone add to cart button fixed
 * 
 * @param {type} $
 * @returns {String}
 */
function nasa_clone_add_to_cart($) {
    var _ressult = '';
    
    if ($('.nasa-product-details-page').length) {
        var _wrap = $('.nasa-product-details-page');
        
        /**
         * Variations
         */
        if ($(_wrap).find('.single_variation_wrap').length) {
            var _price = $(_wrap).find('.single_variation_wrap .woocommerce-variation .woocommerce-variation-price').length && $(_wrap).find('.single_variation_wrap .woocommerce-variation').css('display') !== 'none' ?
                $(_wrap).find('.single_variation_wrap').find('.woocommerce-variation-price').html() : '';
            var _addToCart = $(_wrap).find('.single_variation_wrap').find('.woocommerce-variation-add-to-cart').clone();
            $(_addToCart).find('*').removeAttr('id');
            if ($(_addToCart).find('.single_add_to_cart_button').length) {
                $(_addToCart).find('.single_add_to_cart_button').removeAttr('style');
            }
            if ($(_addToCart).find('.nasa-buy-now').length) {
                $(_addToCart).find('.nasa-buy-now').remove();
            }
            var _btn = $(_addToCart).html();
            
            var _disable = $(_wrap).find('.single_variation_wrap').find('.woocommerce-variation-add-to-cart-disabled').length ? ' nasa-clone-disable' : '';

            _ressult = '<div class="nasa-single-btn-clone single_variation_wrap-clone' + _disable + '">' + _price + '<div class="woocommerce-variation-add-to-cart-clone">' + _btn + '</div></div>';
        }

        /**
         * Simple
         */
        else if ($(_wrap).find('.cart').length){
            var _addToCart = $(_wrap).find('.cart').clone();
            $(_addToCart).find('*').removeAttr('id');
            if ($(_addToCart).find('.single_add_to_cart_button').length) {
                $(_addToCart).find('.single_add_to_cart_button').removeAttr('style');
            }
            if ($(_addToCart).find('.nasa-buy-now').length) {
                $(_addToCart).find('.nasa-buy-now').remove();
            }
            var _btn = $(_addToCart).html();
            
            _ressult = '<div class="nasa-single-btn-clone">' + _btn + '</div>';
        }
    }
    
    return _ressult;
}

/**
 * Fixed style carousel
 * 
 * @param {type} $
 * @returns {undefined}
 */
function load_fix_carousel($) {
    var _max_height = 0;
    
    $('.nasa-slider-grid').each(function() {
        var _this = $(this);
        if (!$(_this).hasClass('nasa-processed')) {
            $(_this).addClass('nasa-processed');
            
            _max_height = _max_height === 0 ? _max_height : 0;
            
            if ($(_this).hasClass('nasa-slide-double-row')) {
                $(_this).find('.nasa-wrap-column').each(function() {
                    var _col = $(this);
                    var _item = $(_col).find('.product-item:eq(1)');
                    var _wrap_hover = $(_item).find('.nasa-product-more-wrap-hover');
                    var _h = $(_wrap_hover).height();
                    if (_max_height < _h) {
                        _max_height = _h;
                    }
                });
            } else {
                $(_this).find('.product-item').each(function() {
                    var _item = $(this);
var _wrap_hover = $(_item).find('.nasa-product-more-wrap-hover');
                    var _h = $(_wrap_hover).height();
                    if (_max_height < _h) {
                        _max_height = _h;
                    }
                });
            }

            if (_max_height) {
                $(_this).find('> .owl-stage-outer').css({'padding-bottom': _max_height + 10, 'margin-bottom': _max_height - 2*_max_height});
            }
        }
    });
}

/**
 * intival fix height carousel
 * @param {type} $
 * @returns {undefined}
 */
function load_intival_fix_carousel($, _time) {
    var time = typeof _time !== 'undefined' ? _time : 200;
    
    var _fix_carousel = setInterval(function() {
        if ($('.nasa-slider-grid').length) {
            load_fix_carousel($);
            
            if ($('.nasa-slider-grid').length === $('.nasa-slider-grid.nasa-processed').length) {
                clearInterval(_fix_carousel);
            }
        } else {
            clearInterval(_fix_carousel);
        }
    }, time);
}

/**
 * Init Widgets Toggle
 */
function init_widgets($) {
    if ($('.widget').length) {
        if ($('body').hasClass('nasa-disable-toggle-widgets')) {
            $('.widget').find('.nasa-toggle-widget').remove();
        }
        else {
            $('.widget').each(function() {
                var _this = $(this);

                if (!$(_this).hasClass('nasa-inited')) {
                    var _openToggle = $(_this).find('.nasa-open-toggle');
                    var _key = $(_this).attr('id');
                    if (_key && $(_openToggle).length) {
                        
                        var _toggle = true;
                        if ($(_openToggle).find('.widgettitle').length && !$(_this).hasClass('nasa-no-toggle')) {
                            var _title = $(_openToggle).find('.widgettitle').clone();
                            $(_openToggle).find('.widgettitle').remove();
                            $(_this).prepend(_title);
                        } else {
                            _toggle = false;
                            if ($(_this).find('.nasa-toggle-widget').length) {
                                $(_this).find('.nasa-toggle-widget').remove();
                            }
                        }

                        if (_toggle) {
                            var _cookie = $.cookie(_key);
                            if (_cookie === 'hide') {
                                if (!$(_this).find('.nasa-toggle-widget').hasClass('nasa-hide')) {
                                    $(_this).find('.nasa-toggle-widget').addClass('nasa-hide');
                                }

                                if (!$(_this).find('.nasa-open-toggle').hasClass('widget-hidden')) {
                                    $(_this).find('.nasa-open-toggle').addClass('widget-hidden');
                                }
                            } else {
                                $(_this).find('.nasa-toggle-widget').removeClass('nasa-hide');
                                $(_this).find('.nasa-open-toggle').removeClass('widget-hidden');
                            }
                        } else {
                            $(_this).addClass('nasa-no-toggle');
                        }
                    }

                    $(_this).addClass('nasa-inited');
                }
            });
        }
    }
}

/**
 * init Notices
 * 
 * @param {type} $
 * @returns {undefined}
 */
function initNotices($) {
    if ($('.woocommerce-notices-wrapper').length) {
        $('.woocommerce-notices-wrapper').each(function() {
            if ($(this).find('*').length && $(this).find('.nasa-close-notice').length <= 0) {
                $(this).append('<a class="nasa-close-notice" href="javascript:void(0);"></a>');
            }
        });
    }
}

/**
 * set Notice
 * 
 * @param {type} $
 * @param {type} content
 * @returns {undefined}
 */
function setNotice($, content) {
    if ($('.woocommerce-notices-wrapper').length <= 0) {
        $('body').append('<div class="woocommerce-notices-wrapper"></div>');
    }

    $('.woocommerce-notices-wrapper').html(content);
    initNotices($);
}

function init_select2($) {
    if ($('.nasa-select2').length && $('body').hasClass('nasa-woo-actived')) {
        $('.nasa-select2').each(function () {
            if (!$(this).hasClass('inited')) {
                $(this).addClass('inited');
                $(this).select2();
            }
        });
    }
}

function init_changeview_order_classic($) {
    if ($('.order-change-view-wrap-classic').length) {
        if ($('.breadcrumb-row').length) {
            if ($('.breadcrumb-row').hasClass('text-center')) {
                $('.breadcrumb-row').removeClass('text-center');
                $('.breadcrumb-row').addClass('text-left');
            }
            
            var bottomValue = $('#nasa-breadcrumb-site').outerHeight(true) - $('#nasa-breadcrumb-site').innerHeight();
            
            var _hBread = $('.breadcrumb-row').outerHeight();
            var _hF = $('.order-change-view-wrap-classic').height();
            var _top = (_hBread + _hF) / 2;
            _top = _top - 2*_top - bottomValue;
            $('.order-change-view-wrap-classic').css({'margin-top': _top});
            var _side = $('.breadcrumb-row').hasClass('text-right') ? 'left' : 'right';
            $('.order-change-view-wrap-classic').css({'float': _side});
        } else {
            $('.order-change-view-wrap-classic').css({'margin-top': '20px'});
        }
        
        $('.order-change-view-wrap-classic').show();
    }
}

function init_product_arrow($) {
    if ($('.nasa-product-details-page .products-arrow').length) {
        if ($('.breadcrumb-row').length) {
            if ($('.breadcrumb-row').hasClass('text-center')) {
                $('.breadcrumb-row').removeClass('text-center');
                $('.breadcrumb-row').addClass('text-left');
            }
            
            var bottomValue = $('#nasa-breadcrumb-site').outerHeight(true) - $('#nasa-breadcrumb-site').innerHeight();
            
            var _hBread = $('.breadcrumb-row').outerHeight();
            var _hF = 25;
            var _top = (_hBread + _hF) / 2;
            _top = _top - 2*_top - bottomValue;
            $('.nasa-product-details-page .products-arrow').css({'margin-top': _top, 'top': 0});
            var _side = $('.breadcrumb-row').hasClass('text-right') ? 'left' : 'right';
            if (_side === 'left') {
                $('.nasa-product-details-page .products-arrow').css({'left': '10px', 'right': 'auto'});
                $('.nasa-product-details-page .products-arrow').addClass('nasa-pos-left');
            }
        }
        
        $('.nasa-product-details-page .products-arrow .icon-next-prev').show();
    }
}

/**
 * Init btns for list
 */
function init_group_btn_list($) {
    if ($('.products.list .product-item .nasa-product-list').length) {
        $('.products.list .product-item .nasa-product-list').each(function() {
            var _this = $(this);
            var _clone = $(_this).parents('.product-item').find('.nasa-product-btn-clone');
            if (!$(_this).hasClass('nasa-inited') && $(_clone).length) {
                var _html = $(_clone).html();
                $(_this).html(_html);
                $(_this).addClass('nasa-inited');
            }
        });
    }
}

/**
 * Quick view | Add to cart
 */
function init_product_quickview_addtocart($, reset) {
    var _reset = typeof reset === 'undefined' ? false : reset;
    
    if (_reset) {
        $('.nasa-product-more-hover').removeClass('nasa-inited');
    }
    
    if ($('.nasa-product-more-hover .add-to-cart-grid, .nasa-product-more-hover .quick-view').length) {
        var toggleWidth = $('input[name="nasa-toggle-width-add-to-cart"]').length ? parseInt($('input[name="nasa-toggle-width-add-to-cart"]').val()) : 100;
        if (!toggleWidth) {
            toggleWidth = 100;
        }
        
        $('.nasa-product-more-hover .add-to-cart-grid, .nasa-product-more-hover .quick-view').each(function() {
            var _this = $(this);
            var _wrap = $(_this).parents('.nasa-product-more-hover');
            if (!$(_wrap).hasClass('nasa-inited')) {
                if ($(_this).width() < toggleWidth) {
                    // $(_wrap).find('.quick-view .nasa-icon').removeClass('hidden-tag');
                    $(_wrap).find('.quick-view .nasa-text').addClass('hidden-tag');
                    
                    // $(_wrap).find('.add-to-cart-btn .nasa-icon').show();
                    $(_wrap).find('.add-to-cart-btn .nasa-text').hide();
                } else {
                    // $(_wrap).find('.quick-view .nasa-icon').addClass('hidden-tag');
                    $(_wrap).find('.quick-view .nasa-text').removeClass('hidden-tag');
                    
                    // $(_wrap).find('.add-to-cart-btn .nasa-icon').hide();
                    $(_wrap).find('.add-to-cart-btn .nasa-text').show();
                }
                
                $(_wrap).addClass('nasa-inited');
            }
        });
    }
}

/**
 * Auto fill text to input
 * 
 * @param {type} $
 * @param {type} _input
 * @param {type} _from
 * @param {type} index
 * @returns {undefined}
 */
function autoFillInputPlaceHolder($, _input, _from, index) {
    var _index = typeof index !== 'undefined' ? index : 0;
    if (_index === 0) {
        $(_input).trigger('focus');
    }
    
    if (!$(_input).hasClass('nasa-placeholder')) {
        $(_input).addClass('nasa-placeholder');
        var _place = $(_input).attr('placeholder');
        $(_input).attr('data-placeholder', _place);
    }
    
    var str = $(_from).text();
    
    if (_index <= str.length) {
        if (!$(_from).hasClass('nasa-filling')) {
            $(_from).addClass('nasa-filling');
        }
        
        $(_input).attr('placeholder', str.substr(0, _index++));
        
        setTimeout(function() {
            autoFillInputPlaceHolder($, _input, _from, _index);
        }, 90);
    } else {
        if (!$(_from).hasClass('nasa-done')) {
            $(_from).addClass('nasa-done');
        }
        
        $(_from).removeClass('nasa-filling');
    }
}

function reverseFillInputPlaceHolder($, _input, str, index) {
    var _str = typeof str !== 'undefined' ? str : $(_input).val();
    var _index = typeof index !== 'undefined' ? index : (_str ? _str.length : 0);
    if (_index > 0) {
        $(_input).attr('placeholder', _str.substr(0, _index--));
        
        setTimeout(function() {
            reverseFillInputPlaceHolder($, _input, _str, _index);
        }, 40);
    } else {
        var _place = $(_input).attr('data-placeholder');
        $(_input).attr('placeholder', _place);
    }
}

/**
 * Init filter nasa categories
 * 
 * @param {type} $
 * @returns {undefined}
 */
function init_filter_nasa_categories($) {
    if ($('.nasa-filter-nasa-categories').length) {
        $('.nasa-filter-nasa-categories').each(function() {
            var _this = $(this);
            var _key = $(_this).attr('data-key');
            if (_key !== '0' && $(_this).find('option').length === 1) {
                $(_this).attr('disabled', true);
            } else {
                $(_this).attr('disabled', false);
            }
        });
    }
}

/**
 * Event after added to cart
 * 
 * @param {type} $
 * @returns {undefined}
 */
function after_added_to_cart($) {
    var _urlAjax = null;
    if (
        typeof nasa_ajax_params !== 'undefined' &&
        typeof nasa_ajax_params.wc_ajax_url !== 'undefined'
    ) {
        _urlAjax = nasa_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', 'nasa_after_add_to_cart');
    }

    if (_urlAjax) {
        $.ajax({
            url: _urlAjax,
            type: 'post',
            dataType: 'json',
            cache: false,
            data: {
                'nasa_action': 'nasa_after_add_to_cart'
            },
            beforeSend: function () {
                
            },
            success: function (response) {
                if (response.success === '1') {
                    if ($('.nasa-after-add-to-cart-popup').length) {
                        $('.nasa-after-add-to-cart-popup .nasa-after-add-to-cart-wrap').html(response.content);
                        if ($('.nasa-after-add-to-cart-popup .related-product').length) {
                            afterLoadAjaxList($);
                        }
                    }
                    else {
                        $.magnificPopup.open({
                            items: {
                                src: '<div class="nasa-after-add-to-cart-popup nasa-bot-to-top"><div class="nasa-after-add-to-cart-wrap">' + response.content + '</div></div>',
                                type: 'inline'
                            },
                            tClose: $('input[name="nasa-close-string"]').val(),
                            callbacks: {
                                open: function() {
                                    if ($('.nasa-after-add-to-cart-popup .related-product').length) {
                                        afterLoadAjaxList($);
                                    }
                                },
                                beforeClose: function() {
                                    this.st.removalDelay = 350;
                                }
                            }
                        });
                    }

                    setTimeout(function() {
                        $('.after-add-to-cart-shop_table').addClass('shop_table');
                        $('.nasa-table-wrap').addClass('nasa-active');
                    }, 100);
                    
                    $('.black-window').trigger('click');
                } else {
                    $.magnificPopup.close();
                }
                
                $('.nasa-after-add-to-cart-wrap').removeAttr('style');
                $('.nasa-after-add-to-cart-wrap').removeClass('processing');
                
                setTimeout(function() {
                    init_shipping_free_notification($);
                }, 300);
            },
            error: function () {
                $.magnificPopup.close();
            }
        });
    }
}

/**
 * Reload MiniCart
 * 
 * @param {type} $
 * @returns {undefined}
 */
function reloadMiniCart($) {
    var _urlAjax = null;
    if (
        typeof nasa_ajax_params !== 'undefined' &&
        typeof nasa_ajax_params.wc_ajax_url !== 'undefined'
    ) {
        _urlAjax = nasa_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', 'nasa_reload_fragments');
    }

    if (_urlAjax) {
        $.ajax({
            url: _urlAjax,
            type: 'post',
            dataType: 'json',
            cache: false,
            data: {
                time: new Date().getTime()
            },
            success: function (data) {
                if (data && data.fragments) {

                    $.each(data.fragments, function(key, value) {
                        $(key).replaceWith(value);
                    });

                    if (typeof $supports_html5_storage !== 'undefined' && $supports_html5_storage) {
                        sessionStorage.setItem(
                            wc_cart_fragments_params.fragment_name,
                            JSON.stringify(data.fragments)
                        );
                        set_cart_hash(data.cart_hash);

                        if (data.cart_hash) {
                            set_cart_creation_timestamp();
                        }
                    }

                    $(document.body).trigger('wc_fragments_refreshed');
                    
                    /**
                     * notification free shipping
                     */
                    setTimeout(function() {
                        init_shipping_free_notification($);
                    }, 500);
                }

                $('#cart-sidebar').find('.nasa-loader').remove();
            },
            error: function () {
                $(document.body).trigger('wc_fragments_ajax_error');
                $('#cart-sidebar').find('.nasa-loader').remove();
            }
        });
    }
}

/**
 * Init Shipping free notification
 * 
 * @param {type} $
 * @returns {undefined}
 */
function init_shipping_free_notification($) {
    if ($('.nasa-total-condition').length) {
        $('.nasa-total-condition').each(function() {
            if (!$(this).hasClass('nasa-active')) {
                $(this).addClass('nasa-active');
                var _per = $(this).attr('data-per');
                $(this).find('.nasa-total-condition-hin, .nasa-subtotal-condition').css({'width': _per + '%'});
            }
        });
    }
}

/**
 * Pop-up Newsletter
 */
function init_popup_newsletter($) {
    var et_popup_closed = $.cookie('nasatheme_popup_closed');

    if (et_popup_closed !== 'do-not-show' && $('.nasa-popup').length > 0 && $('body').hasClass('open-popup')) {
        var _delayremoVal = parseInt($('.nasa-popup').attr('data-delay'));
        _delayremoVal = !_delayremoVal ? 300 : _delayremoVal * 1000;
        var _disableMobile = $('.nasa-popup').attr('data-disable_mobile') === 'true' ? true : false;

        $('.nasa-popup').magnificPopup({
            items: {
                src: '#nasa-popup',
                type: 'inline'
            },
            tClose: $('input[name="nasa-close-string"]').val(),
            removalDelay: 300, //delay removal by X to allow out-animation
            fixedContentPos: true,
            callbacks: {
                beforeOpen: function() {
                    this.st.mainClass = 'my-mfp-slide-bottom';
                },
                beforeClose: function() {
                    var showagain = $('#showagain:checked').val();
                    if (showagain === 'do-not-show'){
                        $.cookie('nasatheme_popup_closed', 'do-not-show', {expires: 7, path: '/'});
                    }
                }
            },
            disableOn: function() {
                if (_disableMobile && $(window).width() <= 640) {
                    return false;
                }

                return true;
            }
            // (optionally) other options
        });

        setTimeout(function() {
            $('.nasa-popup').magnificPopup('open');
        }, _delayremoVal);

        $('body').on('click', '#nasa-popup input[type="submit"]', function() {
            $(this).ajaxSuccess(function(event, request, settings) {
                if (typeof request === 'object' && request.responseJSON.status === 'mail_sent') {
                    $('body').append('<div id="nasa-newsletter-alert" class="hidden-tag"><div class="wpcf7-response-output wpcf7-mail-sent-ok">' + request.responseJSON.message + '</div></div>');

                    $.cookie('nasatheme_popup_closed', 'do-not-show', {expires: 7, path: '/'});
                    $.magnificPopup.close();

                    setTimeout(function() {
                        $('#nasa-newsletter-alert').fadeIn(300);

                        setTimeout(function() {
                            $('#nasa-newsletter-alert').fadeOut(500);
                        }, 2000);
                    }, 300);
                }
            });
        });
    }
}

/**
 * 
 * @param {type} $
 * @returns {undefined}get Compare ids
 */
function get_compare_ids($) {
    if ($('input[name="nasa_woocompare_cookie_name"]').length) {
        var _cookie_compare = $('input[name="nasa_woocompare_cookie_name"]').val();
        var _pids = $.cookie(_cookie_compare);
        if (_pids) {
            _pids = _pids.replace('[','').replace(']','').split(",").map(String);
            
            if (_pids.length === 1 && !_pids[0]) {
                return [];
            }
        }
        
        return typeof _pids !== 'undefined' && _pids.length ? _pids : [];
    } else {
        return [];
    }
}

/**
 * 
 * @param {type} $
 * @returns {undefined}get Compare ids
 */
function get_wishlist_ids($) {
    if ($('input[name="nasa_wishlist_cookie_name"]').length) {
        var _cookie_wishlist = $('input[name="nasa_wishlist_cookie_name"]').val();
        var _pids = $.cookie(_cookie_wishlist);
        if (_pids) {
            _pids = _pids.replace('[', '').replace(']', '').split(",").map(String);
            
            if (_pids.length === 1 && !_pids[0]) {
                return [];
            }
        }
        
        return typeof _pids !== 'undefined' && _pids.length ? _pids : [];
    } else {
        return [];
    }
}

/**
 * Load Wishlist
 */
var _wishlist_init = false;
function loadWishlist($) {
    if ($('#nasa-wishlist-sidebar-content').length && !_wishlist_init) {
        _wishlist_init = true;
        
        if (
            typeof nasa_ajax_params !== 'undefined' &&
            typeof nasa_ajax_params.wc_ajax_url !== 'undefined'
        ) {
            var _urlAjax = nasa_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', 'nasa_load_wishlist');
            $.ajax({
                url: _urlAjax,
                type: 'post',
                dataType: 'json',
                cache: false,
                data: {},
                beforeSend: function () {
                    
                },
                success: function (res) {
                    if (typeof res.success !== 'undefined' && res.success === '1') {
                        $('#nasa-wishlist-sidebar-content').replaceWith(res.content);
                        
                        if ($('.nasa-tr-wishlist-item.item-invisible').length) {
                            var _remove = [];
                            $('.nasa-tr-wishlist-item.item-invisible').each(function() {
                                var product_id = $(this).attr('data-row-id');
                                if (product_id) {
                                    _remove.push(product_id);
                                }
                                
                                $(this).remove();
                            });
                            
                            _urlAjax = nasa_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', 'nasa_remove_wishlist_hidden');
                            
                            $.ajax({
                                url: _urlAjax,
                                type: 'post',
                                dataType: 'json',
                                cache: false,
                                data: {
                                    product_ids: _remove
                                },
                                beforeSend: function () {

                                },
                                success: function (response) {
                                    if (typeof response.success !== 'undefined' && response.success === '1') {
                                        var sl_wislist = parseInt(response.count);
                                        $('.wishlist-number .nasa-sl').html(convert_count_items($, sl_wislist));
                                        if (sl_wislist > 0) {
                                            $('.wishlist-number').removeClass('nasa-product-empty');
                                        }
                                        else if (sl_wislist === 0 && !$('.wishlist-number').hasClass('nasa-product-empty')) {
                                            $('.wishlist-number').addClass('nasa-product-empty');
                                        }
                                    }
                                },
                                error: function () {

                                }
                            });
                        }
                    }
                },
                error: function () {

                }
            });
        }
    }
}

/**
 * Add wishlist item NasaTheme Wishlist
 * @param {type} $
 * @param {type} _pid
 * @returns {undefined}
 */
var _nasa_clear_notice_wishlist;
function nasa_process_wishlist($, _pid, _action) {
    if (
        typeof nasa_ajax_params !== 'undefined' &&
        typeof nasa_ajax_params.wc_ajax_url !== 'undefined'
    ) {
        var _urlAjax = nasa_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', _action);
        var _data = {
            product_id: _pid
        };
        if ($('.widget_shopping_wishlist_content').length) {
            _data['show_content'] = '1';
        }
        $.ajax({
            url: _urlAjax,
            type: 'post',
            dataType: 'json',
            cache: false,
            data: _data,
            beforeSend: function () {
                if ($('.nasa-close-notice').length) {
                    $('.nasa-close-notice').trigger('click');
                }
                
                if (typeof _nasa_clear_notice_wishlist !== 'undefined') {
                    clearTimeout(_nasa_clear_notice_wishlist);
                }
            },
            success: function (res) {
                if (typeof res.success !== 'undefined' && res.success === '1') {
                    var sl_wislist = parseInt(res.count);
                    $('.wishlist-number .nasa-sl').html(convert_count_items($, sl_wislist));
                    if (sl_wislist > 0) {
                        $('.wishlist-number').removeClass('nasa-product-empty');
                    }
                    else if (sl_wislist === 0 && !$('.wishlist-number').hasClass('nasa-product-empty')) {
                        $('.wishlist-number').addClass('nasa-product-empty');
                    }
                    
                    if (_action === 'nasa_add_to_wishlist') {
                        $('.btn-wishlist[data-prod="' + _pid + '"]').each(function() {
                            if (!$(this).hasClass('nasa-added')) {
                                $(this).addClass('nasa-added');
                            }
                        });
                    }
                    
                    if (_action === 'nasa_remove_from_wishlist') {
                        $('.btn-wishlist[data-prod="' + _pid + '"]').removeClass('nasa-added');
                    }
                    
                    if ($('.widget_shopping_wishlist_content').length && typeof res.content !== 'undefined' && res.content) {
                        $('.widget_shopping_wishlist_content').replaceWith(res.content);
                    }

                    setNotice($, res.mess);

                    _nasa_clear_notice_wishlist = setTimeout(function() {
                        if ($('.nasa-close-notice').length) {
                            $('.nasa-close-notice').trigger('click');
                        }
                    }, 5000);
                    
                    $('body').trigger('nasa_processed_wishlish', [_pid, _action]);
                }
                
                $('.btn-wishlist').removeClass('nasa-disabled');
            },
            error: function () {
                $('.btn-wishlist').removeClass('nasa-disabled');
            }
        });
    }
}

/**
 * Convert Count Items
 * 
 * @param {type} number
 * @returns {String}
 */
function convert_count_items($, number) {
    var _number = parseInt(number);
    if ($('input[name="nasa_less_total_items"]').length && $('input[name="nasa_less_total_items"]').val() === '1') {
        return _number > 9 ? '9+' : _number.toString();
    } else {
        return _number.toString();
    }
}
