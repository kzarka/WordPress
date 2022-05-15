"use strict";
/* Functions jquery ================================ */
function nasa_check_iOS() {
    var iDevices = [
        'iPad Simulator',
        'iPhone Simulator',
        'iPod Simulator',
        'iPad',
        'iPhone',
        'iPod'
    ];
    while (iDevices.length > 0) {
        if (navigator.platform === iDevices.pop()){
            return true;
        }
    }
    return false;
}

function nasa_load_ajax_funcs($) {
    loadingCarouselNasaCore($);
    loadingSCCaroselNasaCore($);
    loadingSlickSlidersNasaCore($);
    loadingSlickSliders_TitleNasaCore($);
    loadCountDownNasaCore($);
    responsiveBanners($);
    loadCorouselHasThumbs($);
    loadingSlickHasExtraVerticalNasaCore($);
    loadingSlickVerticalCategories($);
    nasa_loadTipTop($);
    
    initNasaGiftFeatured($);
    nasaRenderTagClouds($);
    
    nasaLoadHeightFullWidthToSide($);
    loadPinProductsBanner($);
    
    nasaCompatibleJetpack($);
    
    nasa_product_quickview_addtocart($, true);
    
    nasa_fix_carousel($);
    
    nasaRefreshProductsMasonryIsotope($);
}

/**
 * support jetpack-lazy-image
 * @type type
 */
function nasaCompatibleJetpack($) {
    if ($('.jetpack-lazy-image').length) {
        $('.jetpack-lazy-image')
        .removeAttr('srcset')
        .removeAttr('data-lazy-src')
        .removeClass('jetpack-lazy-image');
    }
}

/**
 * Responsive for Banners
 * 
 * @param {type} $
 * @returns {undefined}
 */
function responsiveBanners($) {
    if ($('.nasa-banner-image').length > 0) {
        $('.nasa-banner-image').each(function() {
            var _this = $(this);
            var _parent = $(_this).parent();
            if (!$(_parent).hasClass('nasa-not-responsive')) {
                var _defH = parseInt($(_this).attr('data-height'));
                var _defW = parseInt($(_this).attr('data-width'));
                var _realWidth = $(_this).outerWidth();
                var _ratio = _realWidth / _defW;
                var _realHeight = _defH * _ratio;

                if (_ratio !== 1) {
                    $(_parent).height(_realHeight);
                    $(_parent).find('.nasa-banner-content').css({
                        'font-size': (_ratio * 100).toString() + '%'
                    });
                } else {
                    $(_parent).height(_defH);
                    $(_parent).find('.nasa-banner-content').css({
                        'font-size': '100%'
                    });
                }
            }
        });
    }
}

/**
 * Loadmore Portfolio
 * 
 * @param {type} jq
 * @param {type} cat_id
 * @param {type} columns
 * @param {type} paged
 * @returns {Boolean}
 */
function loadMorePortfolio(jq, cat_id, columns, paged){
    if (typeof nasa_ajax_params !== 'undefined' && typeof nasa_ajax_params.ajax_url !== 'undefined') {
        jq.ajax({
            url : nasa_ajax_params.ajax_url,
            type: 'post',
            dataType: 'json',
            data: {
                action: 'get_more_portfolio',
                page: paged,
                category: cat_id,
                col: columns
            },
            beforeSend: function(){
                jq('.loadmore-portfolio').before('<div id="ajax-loading"></div>');
                jq('.loadmore-portfolio').hide();
                jq('.portfolio-list').css({'overflow': 'hidden'});
            },
            success: function(res){
                jq('#ajax-loading').remove();
                jq('.loadmore-portfolio').show();
                if (res.success){
                    jq('.portfolio-list').isotope('insert', jq(res.result)).isotope({itemSelector:'.portfolio-item'});
                    setTimeout(function () {
                        jq('.portfolio-list').isotope({itemSelector:'.portfolio-item'});
                    }, 800);

                    setTimeout(function() {
                        $(window).resize();
                    }, 1000);

                    if (paged >= res.max){
                        jq('.loadmore-portfolio').addClass('end-portfolio').html(res.alert).removeClass('loadmore-portfolio');
                    }
                } else {
                    jq('.loadmore-portfolio').addClass('end-portfolio').html(res.alert).removeClass('loadmore-portfolio');
                }
                portfolio_load_flag = false;
            }
        });
    }
    
    return false;
};

/**
 * Carousel
 * 
 * @param {type} $
 * @param {type} heightAuto
 * @param {type} minHeight
 * @returns {undefined}
 */
function loadingCarouselNasaCore($, heightAuto, minHeight){
    if ($('.nasa-slider').length) {
        nasaCompatibleJetpack($);
        heightAuto = heightAuto === undefined ? false : heightAuto;
        minHeight = minHeight === undefined ? true : minHeight;
        var _rtl = $('body').hasClass('nasa-rtl') ? true : false;
        $('.nasa-slider').each(function(){
            var _this = $(this);
            if (!$(_this).hasClass('owl-loaded')){
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

                if (!ap_speed){
                    ap_speed = 600;
                }

                if (!ap_delay){
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
                    navText: ["",""],
                    navSpeed: 600,
                    lazyLoad : true,
                    touchDrag: disable_drag,
                    mouseDrag: disable_drag,
                    responsive: {
                        0:{
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

                if (margin_px){
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

function loadingSCCaroselNasaCore($){
    if ($('.nasa-sc-carousel').length > 0){
        nasaCompatibleJetpack($);
        var _rtl = $('body').hasClass('nasa-rtl') ? true : false;
        
        $('.nasa-sc-carousel').each(function(){
            var _sc = $(this);
            if (!$(_sc).hasClass('owl-loaded')){
                var height = ($(_sc).find('.banner').length > 0) ? $(_sc).find('.banner').height() : 0;
                if (height){
                    var loading = '<div class="nasa-carousel-loadding" style="height: ' + height + 'px;"><div class="please-wait type2"></div></div>';
                    $(_sc).parent().append(loading);
                }

                var _nav = ($(_sc).attr('data-nav') === 'true') ? true : false,
                    _dots = ($(_sc).attr('data-dots') === 'true') ? true : false,
                    _autoplay = ($(_sc).attr('data-autoplay') === 'false') ? false : true,
                    _loop = ($(_sc).attr('data-loop') === 'true') ? true : false,
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
                    loop: _loop,
                    nav: _nav,
                    dots: _dots,
                    autoplay: _autoplay,
                    autoplaySpeed: _speed, // Speed when auto play
                    autoplayTimeout: 5000, //Delay for next slide
                    autoplayHoverPause : true,
                    navText: ["", ""],
                    navSpeed: _speed, //Speed when click to navigation arrow
                    dotsSpeed: _speed,
                    responsiveClass: true,
                    callbacks: true,
                    'responsive': {
                        0: {
                            items: _itemSmall,
                            margin: margin_small_px
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

                _sc.find('.owl-item').each(function(){
                    var _this = $(this);
                    if ($(_this).find('.banner .banner-inner').length > 0){
                        var _banner = $(_this).find('.banner .banner-inner');
                        $(_banner).removeAttr('class').removeAttr('style').addClass('banner-inner');
                        if ($(_this).hasClass('active')){
                            var animation = $(_banner).attr('data-animation');
                            setTimeout(function(){
                                $(_banner).show();
                                $(_banner).addClass('animated').addClass(animation).css({'visibility': 'visible', 'animation-duration': '1s', 'animation-delay': '0ms', 'animation-name': animation});
                            }, 200);
                        }
                    }
                });

                _sc.on('translated.owl.carousel', function(items) {
                    var warp = items.target;
                    if ($(warp).find('.owl-item').length > 0){
                        $(warp).find('.owl-item').each(function(){
                            var _this = $(this);
                            if ($(_this).find('.banner .banner-inner').length > 0){
                                var _banner = $(_this).find('.banner .banner-inner');
                                var animation = $(_banner).attr('data-animation');
                                $(_banner).removeClass('animated').removeClass(animation).removeAttr('style');
                                if ($(_this).hasClass('active')){
                                    setTimeout(function(){
                                        $(_banner).show();
                                        $(_banner).addClass('animated').addClass(animation).css({'visibility': 'visible', 'animation-duration': '1s', 'animation-delay': '0ms', 'animation-name': animation});;
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

function loadCountDownNasaCore($) {
    var countDownEnable = ($('input[name="nasa-count-down-enable"]').length === 1 && $('input[name="nasa-count-down-enable"]').val() === '1') ? true : false;
    if (countDownEnable && $('.countdown').length > 0) {
        $('.countdown').each(function() {
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

function loadCorouselMain(id, $){
    $('.main-images-' + id).owlCarousel({
        items: 1,
        nav: false,
        lazyLoad: true,
        autoplaySpeed: 600,
        dots: false,
        autoHeight: true,
        autoplay: false,
        loop: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        responsiveClass:true,
        navText: ["",""],
        navSpeed: 600
    });

    $('.main-images-' + id).on('change.owl.carousel', function(e) {
        var currentItem = e.relatedTarget.relative(e.property.value);
        var owlThumbs = $(".product-thumbnails-" + id + " .owl-item");
        $('.product-thumbnails-' + id + ' .active-thumbnail').removeClass('active-thumbnail')
        $(".product-thumbnails-" + id).find('.owl-item').eq(currentItem).addClass('active-thumbnail');
        owlThumbs.trigger('to.owl.carousel', [currentItem, 300, true]);
    }).data('owl.carousel');
    
    $('.product-thumbnails-' + id).owlCarousel({
        items: 4,
        loop: false,
        nav: false,
        autoplay: false,
        dots: false,
        autoHeight: false,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        responsiveClass: true,
        navText: ["", ""],
        navSpeed: 600,
        responsive:{
            "0": {
                items: 3,
                nav: false
            },
            "600": {
                items: 4,
                nav: false
            },
            "1000": {
                items: 4,
                nav: false
            }
        }
    }).on('click', '.owl-item', function () {
        var currentItem = $(this).index();
        $('.main-images-' + id).trigger('to.owl.carousel', [currentItem, 300, true]);
    });

    $('body').on('click', '.product-thumbnails-' + id + ' .owl-item a', function(e) {
        e.preventDefault();
    });
}

function loadCorouselHasThumbs($) {
    if ($('.nasa-sc-main-product').length > 0) {
        nasaCompatibleJetpack($);
        
        $('.nasa-sc-main-product').each(function() {
            var _this = $(this);
            var id = $(_this).attr('data-id');
            $('.nasa-product-img-slide-' + id).owlCarousel({
                items: 1,
                nav: false,
                lazyLoad: true,
                autoplaySpeed: 600,
                dots: false,
                autoHeight: true,
                autoplay: false,
                loop: false,
                autoplayTimeout: 5000,
                autoplayHoverPause: true,
                responsiveClass:true,
                navText: ["",""],
                navSpeed: 600
            });

            $('.nasa-product-img-slide-' + id).on('change.owl.carousel', function(e) {
                var currentItem = e.relatedTarget.relative(e.property.value);
                var owlThumbs = $(".product-thumbnails-" + id + " .owl-item");
                $('.product-thumbnails-' + id + ' .active-thumbnail').removeClass('active-thumbnail')
                $(".product-thumbnails-" + id).find('.owl-item').eq(currentItem).addClass('active-thumbnail');
                owlThumbs.trigger('to.owl.carousel', [currentItem, 300, true]);
            }).data('owl.carousel');

            $('.product-thumbnails-' + id).owlCarousel({
                items: 4,
                loop: false,
                nav: true,
                autoplay: false,
                dots: false,
                autoHeight: true,
                autoplayTimeout: 3000,
                autoplayHoverPause: true,
                responsiveClass: true,
                navText: ["", ""],
                navSpeed: 600,
                responsive:{
                    "0": {
                        items: 3
                    },
                    "600": {
                        items: 4
                    },
                    "1000": {
                        items: 4
                    }
                }
            }).on('click', '.owl-item', function () {
                var currentItem = $(this).index();
                $('.nasa-product-img-slide-' + id).trigger('to.owl.carousel', [currentItem, 300, true]);
            });
        });
    }
}

function nasa_loadTipTop($) {
    if ($('.tip-top').length > 0) {
        var tip, option;
        $('.tip-top').each(function() {
            option = {mode:"top"};
            tip = $(this);
            if ($(tip).parents('.nasa-group-btn-in-list') <= 0) {
                if (!$(tip).hasClass('nasa-tiped')) {
                    $(tip).addClass('nasa-tiped');
                    if ($(tip).attr('data-pos') === 'bot') {
                        option = {mode:"bottom"};
                    }

                    $(tip).tipr(option);
                }
            }
        });
    }
}

/*
 * Nasa gift featured
 */
function initNasaGiftFeatured($) {
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
function nasaRenderTagClouds($) {
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

/*
 * nasaLoadHeightMainProducts($)
 */
function nasaLoadHeightMainProducts($) {
    if ($('.nasa-main-content-warp').length > 0) {
        var bodyWidth = $('body').width();
        if (bodyWidth > changeDVnasa) {
            $('.nasa-main-content-warp').each(function() {
                var _this = $(this);
                var _sc = $(_this).parents('.nasa-sc-main-extra-product');
                var _side = $(_sc).find('.nasa-product-main-aside.first');
                if ($(_side).length === 1 && $(_side).find('.product-item').length === 2) {
                    var _height = $(_side).height();
                    $(_this).css({'min-height': _height});
                }
            });
        } else {
            $('.nasa-main-content-warp').css({'min-height': 'auto'});
        }
    }
}

/**
 * NasaLoadheightDealBlock
 */
function nasaLoadHeightDealBlock($) {
    if ($('.nasa-row-deal-3').length > 0) {
        var bodyWidth = $('body').width();
        
        if (bodyWidth > changeDVnasa) {
            $('.nasa-row-deal-3').each(function() {
                var _this = $(this);
                var _sc = $(_this).find('.main-deal-block .nasa-sc-pdeal-block');
                var _side = $(_this).find('.nasa-sc-product-deals-grid.nasa-deal-right');
                if ($(_side).length === 1) {
                    var _height = $(_side).height();
                    $(_sc).css({'min-height': _height - 30});
                }
            });
        } else {
            $('.nasa-row-deal-3 .main-deal-block .nasa-sc-pdeal-block').css({'min-height': 'auto'});
        }
    }
}

/**
 * Load height full to side
 */
function nasaLoadHeightFullWidthToSide($) {
    if ($('#main-content #content > .section-element > .row > .columns.nasa-full-to-left, #main-content #content > .section-element > .row > .columns.nasa-full-to-right').length > 0) {
        var _wwin = $(window).width();
        $('#main-content #content > .section-element > .row > .columns.nasa-full-to-left, #main-content #content > .section-element > .row > .columns.nasa-full-to-right').each(function() {
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
 * 
 * Slick slider
 */
function loadingSlickSlidersNasaCore($) {
    if ($('.nasa-slick-slider-wrap').length > 0) {
        nasaCompatibleJetpack($);
        $('.nasa-slick-slider-wrap').each(function(){
            var _this = $(this);
            
            if (!$(_this).hasClass('slick-initialized')) {
                var _autoplay = $(_this).attr('data-autoplay') === 'true' ? true : false,
                    _speed = parseInt($(_this).attr('data-speed')),
                    _delay = parseInt($(_this).attr('data-delay'));

                _speed = !_speed ? 600 : _speed;
                _delay = !_delay ? 3000 : _delay;
                
                var _itemSmall = parseInt($(_this).attr('data-itemSmall')),
                    _itemTablet = parseInt($(_this).attr('data-itemTablet')),
                    _items = parseInt($(_this).attr('data-items'));
                    
                _itemSmall = _itemSmall ? _itemSmall : 1;
                _itemTablet = _itemTablet ? _itemTablet : 1;
                _items = _items ? _items : 1;
                
                var _scroll = parseInt($(_this).attr('data-scroll'));
                _scroll = _scroll ? _scroll : 1;
                
                var _center = $(_this).attr('data-center_mode') === 'true' ? true : false,
                    _centerPadding = _center && $(_this).attr('data-center_padding') ? $(_this).attr('data-center_padding') : '0';
                    
                var _switchTablet = 848;
                var _switchDesktop = 1130;
                
                if ($(_this).attr('data-switch-tablet')) {
                    _switchTablet = parseInt($(_this).attr('data-switch-tablet'));
                }
                
                if ($(_this).attr('data-switch-desktop')) {
                    _switchDesktop = parseInt($(_this).attr('data-switch-desktop'));
                }
                
                var _setting = {
                    slidesToShow: _items,
                    slidesToScroll: _scroll,
                    autoplay: _autoplay,
                    autoplaySpeed: _delay,
                    speed: _speed,
                    arrows: true,
                    infinite: true,
                    pauseOnHover: true,
                    centerMode: _center,
                    focusOnSelect: true,
                    responsive: [{
                        breakpoint: _switchDesktop,
                        settings: {
                            slidesToShow: _itemTablet
                        }
                    }, {
                        breakpoint: _switchTablet,
                        settings: {
                            slidesToShow: _itemSmall
                        }
                    }]
                };
                
                if (_centerPadding != '0') {
                    _setting.centerPadding = _centerPadding;
                }
                
                $(_this).slick(_setting);
                $(_this).addClass('nasa-inited');
            }
        });
    }
}

/**
 * 
 * Slick multi (images - title.dot)
 */
function loadingSlickSliders_TitleNasaCore($, restart) {
    if ($('.nasa-slick-slider-title-wrap').length > 0) {
        var _rtl = $('body').hasClass('nasa-rtl') ? true : false;
        var _restart = typeof restart === 'undefined' ? false : restart;
        
        $('.nasa-slick-slider-title-wrap').each(function(){
            var _this = $(this);
            
            if (_restart) {
                if ($(_this).hasClass('slick-initialized')) {
                    $(_this).removeClass('nasa-inited').slick('unslick');
                }
            }
            
            if (!$(_this).hasClass('slick-initialized')) {
                var _autoplay = $(_this).attr('data-autoplay') === 'true' ? true : false,
                    _speed = parseInt($(_this).attr('data-speed')),
                    _delay = parseInt($(_this).attr('data-delay'));

                _speed = !_speed ? 600 : _speed;
                _delay = !_delay ? 3000 : _delay;
                
                var _itemSmall = parseInt($(_this).attr('data-itemSmall')),
                    _itemTablet = parseInt($(_this).attr('data-itemTablet')),
                    _items = parseInt($(_this).attr('data-items'));
                    
                _itemSmall = _itemSmall ? _itemSmall : 1;
                _itemTablet = _itemTablet ? _itemTablet : 1;
                _items = _items ? _items : 1;
                
                var _scroll = parseInt($(_this).attr('data-scroll'));
                _scroll = _scroll ? _scroll : 1;
                
                var _center = $(_this).attr('data-center_mode') === 'true' ? true : false,
                    _centerPadding = _center && $(_this).attr('data-center_padding') ? $(_this).attr('data-center_padding') : '0';
                    
                var _switchTablet = 848;
                var _switchDesktop = 1130;
                
                if ($(_this).attr('data-switch-tablet')) {
                    _switchTablet = parseInt($(_this).attr('data-switch-tablet'));
                }
                
                if ($(_this).attr('data-switch-desktop')) {
                    _switchDesktop = parseInt($(_this).attr('data-switch-desktop'));
                }
                
                var _setting = {
                    rtl: _rtl,
                    slidesToShow: _items,
                    slidesToScroll: _scroll,
                    autoplay: _autoplay,
                    autoplaySpeed: _delay,
                    speed: _speed,
                    arrows: true,
                    infinite: true,
                    pauseOnHover: true,
                    centerMode: _center,
                    focusOnSelect: true,
                    responsive: [{
                        breakpoint: _switchDesktop,
                        settings: {
                            slidesToShow: _itemTablet
                        }
                    }, {
                        breakpoint: _switchTablet,
                        settings: {
                            slidesToShow: _itemSmall
                        }
                    }]
                };
                
                if (_centerPadding !== '0') {
                    _setting.centerPadding = _centerPadding;
                }
                
                $(_this).slick(_setting); // Main
                $(_this).addClass('nasa-inited');
            }
        });
    }
}

function refreshNasaSlider($) {
    loadingSlickSliders_TitleNasaCore($, true);
    loadingSlickHasExtraVerticalNasaCore($, true);
}

/**
 * slick slide has extra vertical
 */
function loadingSlickHasExtraVerticalNasaCore($, restart){
    if ($('.nasa-slider-deal-has-vertical').length) {
        var _rtl = $('body').hasClass('nasa-rtl') ? true : false;
        var _restart = typeof restart === 'undefined' ? false : restart;
        
        nasaCompatibleJetpack($);

        $('.nasa-slider-deal-has-vertical').each(function(){
            var _this = $(this);
            
            if (_restart) {
                if ($(_this).hasClass('slick-initialized')) {
                    $(_this).removeClass('nasa-inited').slick('unslick');
                }
            }
            
            if (!$(_this).hasClass('slick-initialized')) {
                var id = $(_this).attr('data-id'),
                    _autoplay = $(_this).attr('data-autoplay') === 'true' ? true : false,
                    _speed = parseInt($(_this).attr('data-speed')),
                    _delay = parseInt($(_this).attr('data-delay')),
                    _nav_item = parseInt($(_this).attr('data-nav_items'));

                _speed = !_speed ? 600 : _speed;
                _delay = !_delay ? 3000 : _delay;
                
                if ($('.nasa-slider-deal-vertical-extra-' + id).hasClass('slick-initialized')) {
                    $('.nasa-slider-deal-vertical-extra-' + id).slick('unslick');
                }

                var _setting = {
                    vertical: true,
                    verticalSwiping: true,
                    slidesToShow: _nav_item,
                    dots: false,
                    arrows: false,
                    infinite: false
                };

                _setting.asNavFor = '#nasa-slider-slick-' + id;
                _setting.slidesToScroll = 1;
                _setting.centerMode = false;
                _setting.centerPadding = '0';
                _setting.focusOnSelect = true;
                _setting.responsive = [{
                    breakpoint: 500,
                    settings: {
                        slidesToShow: 1
                    }
                }];

                $(_this).slick({
                    rtl: _rtl,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: _autoplay,
                    autoplaySpeed: _delay,
                    speed: _speed,
                    arrows: true,
                    infinite: false,
                    pauseOnHover: true,
                    asNavFor: '.nasa-slider-deal-vertical-extra-' + id
                });

                $('.nasa-slider-deal-vertical-extra-' + id).slick(_setting);
                $('.nasa-slider-deal-vertical-extra-' + id).attr('data-speed', _speed);
                $(_this).addClass('nasa-inited');
            }

            if ($('.nasa-slider-deal-has-vertical.nasa-inited').length === $('.nasa-slider-deal-has-vertical').length) {
                $(window).resize();
            }
        });
    }
}

/**
 * Load categories vertical slide
 * Slick slider - Vertical slider
 */
function loadingSlickVerticalCategories($) {
    if ($('.nasa-vertical-slider').length > 0){
        nasaCompatibleJetpack($);
        
        $('.nasa-vertical-slider').each(function(){
            var _this = $(this);
            if (!$(_this).hasClass('slick-initialized')) {
                var _change = parseInt($(_this).attr('data-change'));
                var _speed = parseInt($(_this).attr('data-speed'));
                var _delay = parseInt($(_this).attr('data-delay'));

                var _show = $(_this).attr('data-show') ? $(_this).attr('data-show') : '1',
                    _autoplay = $(_this).attr('data-autoplay') === 'false' ? false : true,
                    _delay = _delay ? _delay : 3000,
                    _speed = _speed ? _speed : 1000,
                    _change = _change ? _change : false,
                    _dot = $(_this).attr('data-dot') === 'true' ? true : false,
                    _arrows = $(_this).attr('data-arrows') === 'true' ? true : false;

                var _setting = {
                    vertical: true,
                    verticalSwiping: true,
                    slidesToShow: _show,
                    autoplay: _autoplay,
                    autoplaySpeed: _delay,
                    speed: _speed,
                    dots: _dot,
                    arrows: _arrows
                };

                if (_change){
                    _setting.slidesToScroll = _change;
                }

                $(_this).slick(_setting);
                
                $(_this).addClass('slick-initialized');
            }
        });
    }
}

/**
 * Function Loop through variations.
 * 
 * @param {type} $
 * @param {type} _variations_warp
 * @param {type} _alert
 * @returns {undefined}
 */
function nasa_loop_through_variations($, _each_vars, currentAttributes, variationData) {
    // Loop through selects and disable/enable options based on selections.
    if (_each_vars !== null) {
        $(_each_vars).each(function () {
            var _this = $(this);
            var _prefix_attr = !$(_this).hasClass('nasa-attr_type_custom') ? 'attribute_pa_' : 'attribute_';
            var current_attr_name = _prefix_attr + $(_this).attr('data-pa_name');
            
            $(_this).find('.nasa-attr-ux-item').removeClass('nasa-disable');
            $(_this).find('.nasa-attr-ux-item').removeClass('nasa-unavailable');
            $(_this).find('.nasa-attr-ux-item').removeClass('attached');
            $(_this).find('.nasa-attr-ux-item').removeClass('enabled');
            
            var checkAttributes = $.extend(true, {}, currentAttributes);
            checkAttributes[current_attr_name] = '';
            var variations = nasa_matching_variations(variationData, checkAttributes);
            
            // Loop through variations init.
            for (var num in variations) {
                if (typeof (variations[num]) !== 'undefined') {
                    var variationAttributes = variations[num].attributes;

                    for (var attr_name in variationAttributes) {
                        if (variationAttributes.hasOwnProperty(attr_name)) {
                            var attr_val = variationAttributes[attr_name],
                                variation_active = '';
                            
                            // Decode entities.
                            attr_val = attr_val ? $('<div/>').html(attr_val).text() : false;
                            
                            if (attr_name === current_attr_name) {
                                if (variations[num].variation_is_active) {
                                    variation_active = ' enabled';
                                }
                                
                                if (attr_val) {
                                    // Attach to matching options by value. This is done to compare
                                    // TEXT values rather than any HTML entities.
                                    var $option_elements = $(_this).find('.nasa-attr-ux-item');
                                    
                                    if ($option_elements.length) {
                                        $option_elements.each(function () {
                                            var $option_element = $(this),
                                                option_value = $option_element.attr('data-value');

                                            if (attr_val === option_value) {
                                                $option_element.addClass('attached' + variation_active);
                                                return; // Break each.
                                            }
                                        });
                                    }
                                }
                                // attached all options
                                else {
                                    $(_this).find('.nasa-attr-ux-item').addClass('attached' + variation_active);
                                }
                            }
                        }
                    }
                }
            }
            
            // Disabled
            if ($(_this).find('.nasa-attr-ux-item:not(.attached)').length) {
                $(_this).find('.nasa-attr-ux-item:not(.attached)').addClass('nasa-disable');
            }
            
            // Unavailable
            if ($(_this).find('.nasa-attr-ux-item:not(.enabled)').length) {
                $(_this).find('.nasa-attr-ux-item:not(.enabled)').addClass('nasa-unavailable');
            }
        });
    }
}

/**
 * Change info content product
 * 
 * @param {type} $
 * @param {type} _variations_warp
 * @param {type} _alert
 * @returns {undefined}
 */
function change_image_content_product_variable($, _variations_warp, _alert) {
    _alert = (typeof _alert === 'undefined') ? false : _alert;
    
    var _count_attr = $(_variations_warp).find('.nasa-product-content-child').length,
        _selected_count = $(_variations_warp).find('.nasa-product-content-child .nasa-active').length,
        _product_item = $(_variations_warp).parents('.product-item'),
        _main_img = $(_product_item).find('.main-img img'),
        _main_src = $(_main_img).attr('data-org_img'),
        _back_img = $(_product_item).find('.back-img img'),
        _back_src = $(_back_img).length ? $(_back_img).attr('data-org_img') : '',
        _add_wrap = $(_product_item).find('.add-to-cart-btn a.add-to-cart-grid'),
        _each_vars = _count_attr ? $(_variations_warp).find('.nasa-product-content-child') : null;

    var _main_srcset = $(_main_img).attr('srcset'),
        _back_srcset = $(_back_img).length ? $(_back_img).attr('srcset') : '';

    var _main_data_srcset = $(_main_img).attr('data-srcset'),
        _back_data_srcset = $(_back_img).length ? $(_back_img).attr('data-srcset') : '';
    
    var _variations = JSON.parse($(_variations_warp).attr('data-product_variations'));
    
    var _choseAttrs = nasa_chosen_attrs($, _variations_warp),
        currentAttributes = _choseAttrs.data;
    
    /**
     * Refress attributes
     */
    nasa_loop_through_variations($, _each_vars, currentAttributes, _variations);
    
    /**
     * Old Price
     */
    if ($(_product_item).find('.nasa-org-price.hidden-tag').length <= 0) {
        $(_product_item).find('.price-wrap').after('<div class="nasa-org-price hidden-tag">' + $(_product_item).find('.price-wrap').html() + '</div>');
    }

    /**
     * Old Add to cart text
     */
    if (typeof $(_variations_warp).attr('data-select_text') === 'undefined') {
        $(_variations_warp).attr('data-select_text', $(_add_wrap).find('.add_to_cart_text').html());
    }

    var _select_text = $(_variations_warp).attr('data-select_text');

    /**
     * Not select full attributes
     */
    if (_count_attr !== _selected_count) {
        if (typeof _main_src !== 'undefined') {
            $(_main_img).attr('src', _main_src);
            
            if (_main_data_srcset) {
                $(_main_img).attr('srcset', _main_data_srcset);
            }
        }

        if ($(_back_img).length && typeof _back_src !== 'undefined') {
            $(_back_img).attr('src', _back_src);
            
            if (_back_data_srcset) {
                $(_back_img).attr('srcset', _back_data_srcset);
            }
        }

        $(_add_wrap).find('.add_to_cart_text').html(_select_text);
        $(_add_wrap).attr('title', _select_text);
        $(_add_wrap).attr('data-product_id', $(_variations_warp).attr('data-product_id')).addClass('product_type_variable').removeClass('product_type_variation').removeAttr('data-variation');
        $(_product_item).find('.price-wrap').html($(_product_item).find('.nasa-org-price').html());
        $(_product_item).find('.add-to-cart-btn').removeClass('nasa-active');
        
        /**
         * Deal time
         */
        if (!$(_product_item).find('.nasa-sc-pdeal-countdown').hasClass('hidden-tag')) {
            $(_product_item).find('.nasa-sc-pdeal-countdown').addClass('hidden-tag');
        }
        $(_product_item).find('.nasa-sc-pdeal-countdown').html('');

        return;
    }
    /**
     * Select full Attributes
     */
    else {
        var _selected_attr = [];
        var _variation = {};
        $(_variations_warp).find('.nasa-product-content-child .nasa-active').each(function(){
            var _attr = $(this),
                _prefix_attr = !$(_attr).parents('.nasa-product-content-child').hasClass('nasa-attr_type_custom') ? 'attribute_pa_' : 'attribute_',
                _attr_name = _prefix_attr + $(_attr).attr('data-pa'),
                _attr_val = $(_attr).attr('data-value'),
                _attr_selected = {
                    'key': _attr_name,
                    'value': _attr_val
                };

            _variation[_attr_name] = _attr_val;
            _selected_attr.push(_attr_selected);
        });
        
        var _finded = false;
        var _variation_finded = null;
        for (var k in _variations) {
            var _attrs = _variations[k].attributes,
                _total_attr = 0;
            for (var k_attr in _attrs) {
                _total_attr++;
            }

            if (_count_attr !== _total_attr) {
                break;
            }

            for (var k_select in _selected_attr) {
                if (_attrs[_selected_attr[k_select].key] === '' || _attrs[_selected_attr[k_select].key] === _selected_attr[k_select].value) {
                    _finded = true;
                } else {
                    _finded = false;
                    break;
                }
            }

            if (_finded) {
                _variation_finded = _variations[k];
                break;
            }
        }

        /**
         * Matching variation
         */
        if (_variation_finded) {
            /**
             * Change image show
             */
            var _org_img = _main_src ? _main_src : $(_main_img).attr('src');
            _org_img = _org_img.replace('https:', '');
            _org_img = _org_img.replace('http:', '');
            
            var _image_catalog = '';
            if (_variation_finded.image_catalog !== 'undefined') {
                _image_catalog = _variation_finded.image_catalog.replace('https:', '');
                _image_catalog = _image_catalog.replace('http:', '');
            }

            if (
                typeof _variation_finded.image_catalog !== 'undefined' &&
                _variation_finded.image_catalog !== '' &&
                _image_catalog !== _org_img
            ) {
                if (typeof _main_src === 'undefined') {
                    $(_main_img).attr('data-org_img', $(_main_img).attr('src'));
                }

                if ($(_back_img).length && typeof _back_src === 'undefined') {
                    $(_back_img).attr('data-org_img', $(_back_img).attr('src'));
                }

                $(_main_img).attr('src', _variation_finded.image_catalog);
                
                if ($(_back_img).length) {
                    if (typeof _variation_finded.nasa_variation_back_img !== 'undefined' && _variation_finded.nasa_variation_back_img !== '') {
                        $(_back_img).attr('src', _variation_finded.nasa_variation_back_img);
                    } else {
                        $(_back_img).attr('src', _variation_finded.image_catalog);
                    }
                }
                
                if (_main_srcset) {
                    $(_main_img).removeAttr('srcset');
                    $(_main_img).attr('data-srcset', _main_srcset);
                }
                
                if ($(_back_img).length && _back_srcset) {
                    $(_back_img).removeAttr('srcset');
                    $(_back_img).attr('data-srcset', _back_srcset);
                }
            }

            else {
                if (typeof _main_src !== 'undefined') {
                    $(_main_img).attr('src', _main_src);
                    
                    if (_main_data_srcset) {
                        $(_main_img).attr('srcset', _main_data_srcset);
                    }
                }

                if ($(_back_img).length && typeof _back_src !== 'undefined') {
                    $(_back_img).attr('src', _back_src);
                    
                    if (_back_data_srcset) {
                        $(_back_img).attr('srcset', _back_data_srcset);
                    }
                }
            }

            /**
             * Change price and add to cart button
             */
            if (_variation_finded.variation_id && _variation_finded.is_in_stock && _variation_finded.variation_is_visible && _variation_finded.is_purchasable) {
                var _add_text = $('input[name="add_to_cart_text"]').val();
                $(_add_wrap).find('.add_to_cart_text').html(_add_text);
                $(_add_wrap).attr('title', _add_text);
                if (!$(_product_item).find('.add-to-cart-btn').hasClass('nasa-active')) {
                    $(_product_item).find('.add-to-cart-btn').addClass('nasa-active');
                }
                
                if (
                    $(_product_item).find('.nasa-product-content-variable-warp').length &&
                    !$(_product_item).find('.nasa-product-content-variable-warp').hasClass('nasa-active')
                ) {
                    $(_product_item).find('.nasa-product-content-variable-warp').addClass('nasa-active')
                }
                
                var _variObj = {};
                for(var attr_pa in _variation_finded.attributes) {
                    _variObj[attr_pa] = _variation[attr_pa];
                }

                if (_variation_finded.price_html) {
                    $(_product_item).find('.price-wrap').html(_variation_finded.price_html);
                }

                $(_add_wrap)
                    .attr('data-product_id', _variation_finded.variation_id)
                    .removeClass('product_type_variable')
                    .addClass('product_type_variation')
                    .attr('data-variation', JSON.stringify(_variObj));
            
                /**
                 * Deal time
                 */
                if (typeof _variation_finded.deal_time !== 'undefined' && _variation_finded.deal_time) {
                    var _deal = true;
                    var _date = new Date();
                    var _now = _date.getTime();
                    if (typeof _variation_finded.deal_time.from !== 'undefined') {
                        if (_variation_finded.deal_time.from > _now) {
                            _deal = false;
                        }
                    }
                    
                    if (_deal) {
                        if (_variation_finded.deal_time.to < _now) {
                            _deal = false;
                        }
                    }
                    
                    if (_deal && typeof _variation_finded.deal_time.html !== 'undefined') {
                        $(_product_item).find('.nasa-sc-pdeal-countdown').html('');
                        $(_product_item).find('.nasa-sc-pdeal-countdown').html(_variation_finded.deal_time.html);
                        loadCountDownNasaCore($);
                        $(_product_item).find('.nasa-sc-pdeal-countdown').removeClass('hidden-tag');
                    }
                } else {
                    /**
                     * Deal time
                     */
                    if (!$(_product_item).find('.nasa-sc-pdeal-countdown').hasClass('hidden-tag')) {
                        $(_product_item).find('.nasa-sc-pdeal-countdown').addClass('hidden-tag');
                    }
                    $(_product_item).find('.nasa-sc-pdeal-countdown').html('');
                }
            }

            else {
                $(_add_wrap).find('.add_to_cart_text').html(_select_text);
                $(_add_wrap).attr('title', _select_text);
                $(_add_wrap)
                    .attr('data-product_id', $(_variations_warp).attr('data-product_id'))
                    .addClass('product_type_variable')
                    .removeClass('product_type_variation')
                    .removeAttr('data-variation');
                $(_product_item).find('.price-wrap').html($(_product_item).find('.nasa-org-price').html());
                $(_product_item).find('.add-to-cart-btn').removeClass('nasa-active');
                
                /**
                 * Deal time
                 */
                if (!$(_product_item).find('.nasa-sc-pdeal-countdown').hasClass('hidden-tag')) {
                    $(_product_item).find('.nasa-sc-pdeal-countdown').addClass('hidden-tag');
                }
                $(_product_item).find('.nasa-sc-pdeal-countdown').html('');
            }
        }
        
        /**
         * No match
         */
        else {
            if (typeof _main_src !== 'undefined') {
                $(_main_img).attr('src', _main_src);
                
                if (_main_data_srcset) {
                    $(_main_img).attr('srcset', _main_data_srcset);
                }
            }

            if ($(_back_img).length && typeof _back_src !== 'undefined') {
                $(_back_img).attr('src', _back_src);
                
                if (_back_data_srcset) {
                    $(_back_img).attr('srcset', _back_data_srcset);
                }
            }
            
            $(_add_wrap).find('.add_to_cart_text').html(_select_text);
            $(_add_wrap).attr('title', _select_text);
            $(_add_wrap).attr('data-product_id', $(_variations_warp).attr('data-product_id')).addClass('product_type_variable').removeClass('product_type_variation').removeAttr('data-variation');
            $(_product_item).find('.price-wrap').html($(_product_item).find('.nasa-org-price').html());
            $(_product_item).find('.add-to-cart-btn').removeClass('nasa-active');
            
            /**
             * Deal time
             */
            if (!$(_product_item).find('.nasa-sc-pdeal-countdown').hasClass('hidden-tag')) {
                $(_product_item).find('.nasa-sc-pdeal-countdown').addClass('hidden-tag');
            }
            $(_product_item).find('.nasa-sc-pdeal-countdown').html('');
            
            if (_alert) {
                var text_nomatch = (typeof wc_add_to_cart_variation_params !== 'undefined') ?
                    wc_add_to_cart_variation_params.i18n_no_matching_variations_text :
                    $('input[name="nasa_no_matching_variations"]').val();

                window.alert(text_nomatch);
            }
        }
    }
}

/**
 * Attributes selected
 * 
 * @param {type} $
 * @param {type} _variations_warp
 * @returns {}
 */
function nasa_chosen_attrs($, _variations_warp) {
    var data = {};
    var count = 0;
    var chosen = 0;

    $(_variations_warp).find('.nasa-product-content-child').each( function() {
        var name = !$(this).hasClass('nasa-attr_type_custom') ? 'attribute_pa_' : 'attribute_';
        var value = '';
        
        var k = 0;
        $(this).find('.nasa-attr-ux-item').each(function() {
            if (k === 0) {
                name += $(this).attr('data-pa');
            }
            
            if ($(this).hasClass('nasa-active')) {
                value = $(this).attr('data-value');
            }
            
            k++;
        });

        if (value.length > 0) {
            chosen ++;
        }

        count ++;
        data[name] = value;
    });

    return {
        'count': count,
        'chosenCount': chosen,
        'data': data
    };
}

/**
 * Is match variation
 * 
 * @param {type} variation_attributes
 * @param {type} attributes
 * @returns {Boolean}
 */
function nasa_isMatch_variation(variation_attributes, attributes) {
    var match = true;
    for (var attr_name in variation_attributes) {
        if (typeof variation_attributes[attr_name] !== 'undefined') {
            var val1 = variation_attributes[attr_name];
            var val2 = attributes[attr_name];
            if (
                val1 !== undefined &&
                val2 !== undefined &&
                val1.length !== 0 &&
                val2.length !== 0 &&
                val1 !== val2
            ) {
                match = false;
            }
        }
    }
    
    return match;
}

/**
 * Matching variation
 * 
 * @param {type} variations
 * @param {type} attributes
 * @returns {Array|nasa_matching_variations.matching}
 */
function nasa_matching_variations(variations, attributes) {
    var matching = [];
    for (var i = 0; i < variations.length; i++) {
        var variation = variations[i];

        if (nasa_isMatch_variation(variation.attributes, attributes)) {
            matching.push(variation);
        }
    }
    
    return matching;
}

/**
 * Init variations by ajax
 * @param {type} $
 * @returns {undefined}
 */
function initVariablesProducts($) {
    var _urlAjax = null;
    if (
        typeof nasa_ajax_params !== 'undefined' &&
        typeof nasa_ajax_params.wc_ajax_url !== 'undefined'
    ) {
        _urlAjax = nasa_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', 'nasa_render_variables');
    }

    if (_urlAjax) {
        if ($('.nasa-product-variable-call-ajax').length > 0) {

            var _pids = [];
            $('.nasa-product-variable-call-ajax').each(function() {
                if (!$(this).hasClass('nasa-process')) {
                    $(this).addClass('nasa-process');
                    if (_pids.indexOf($(this).attr('data-product_id')) === -1) {
                        _pids.push($(this).attr('data-product_id'));
                    }
                }
            });

            if (_pids.length > 0) {
                $.ajax({
                    url : _urlAjax,
                    type: 'post',
                    dataType: 'json',
                    data: {
                        'pids': _pids
                    },
                    beforeSend: function(){

                    },
                    success: function(res){
                        if (typeof res.empty !== 'undefined' && res.empty === '0') {
                            for (var pid in res.products) {
                                $('.nasa-product-variable-call-ajax.nasa-product-variable-' + pid).replaceWith(res.products[pid]);
                            }

                            if ($('.nasa-product-content-variable-warp').length) {
                                $('.nasa-product-content-variable-warp').each(function() {
                                    var _this = $(this);
                                    if (!$(_this).hasClass('nasa-inited')) {
                                        $(_this).addClass('nasa-inited');
                                        change_image_content_product_variable($, _this, false);
                                    }
                                });
                            }
                            
                            nasa_load_ajax_funcs($);
                        }
                    },
                    error: function() {
                        $('.nasa-product-variable-call-ajax').remove();
                    }
                });
            }
        }
    }
}

/**
 * Refresh variations single product
 * 
 * @param {type} $
 * @param {type} $form
 * @returns {undefined}
 */
function nasa_refresh_attrs($, $form) {
    $form.find('.nasa-attr-ux_wrap').each(function() {
        var _this = $(this);
        var _attr_name = $(_this).attr('data-attribute_name');
        if ($('select[name="' + _attr_name + '"]').length) {
            $(_this).find('.nasa-attr-ux').each(function() {
                var _item = $(this);
                var _value = $(_item).attr('data-value');
                if ($('select[name="' + _attr_name + '"]').find('option[value="' + _value + '"]').length <= 0) {
                    if (!$(_item).hasClass('nasa-disable')) {
                        $(_item).addClass('nasa-disable');
                    }
                }
                else {
                    var _option = $('select[name="' + _attr_name + '"]').find('option[value="' + _value + '"]').attr('disabled');
                    if (typeof _option !== 'undefined') {
                        $(_item).addClass('nasa-unavailable');
                    }
                    
                    $(_item).removeClass('nasa-disable');
                }
            });
        }
    });
}

/**
 * Fixed style carousel
 * 
 * @param {type} $
 * @returns {undefined}
 */
function nasa_fix_carousel($) {
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
function nasa_intival_fix_carousel ($, _time) {
    var time = typeof _time !== 'undefined' ? _time : 200;
    
    var _nasa_fix_carousel = setInterval(function() {
        if ($('.nasa-slider-grid').length) {
            nasa_fix_carousel($);
            
            if ($('.nasa-slider-grid').length === $('.nasa-slider-grid.nasa-processed').length) {
                clearInterval(_nasa_fix_carousel);
            }
        } else {
            clearInterval(_nasa_fix_carousel);
        }
    }, time);
}

/**
 * Pin Product banner
 * 
 * @param {type} $
 * @returns {undefined}
 */
function loadPinProductsBanner($) {
    if ($('.nasa-pin-banner-wrap').length > 0) {
        nasaCompatibleJetpack($);
        
        $('.nasa-pin-banner-wrap').each(function() {
            var _this = $(this);
            if (!$(_this).hasClass('nasa-inited')) {
                $(_this).addClass('nasa-inited');
                var _init = $(_this).attr('data-pin');
                var _img = $(_this).find('img.nasa_pin_pb_image');
                var _reponsive = $(_img).parents('columns').length === 1 ? true : false;
                
                if ($(_this).parents('.section-element').length && !$(_this).parents('.section-element').hasClass('nasa-unset-zindex')) {
                    $(_this).parents('.section-element').addClass('nasa-unset-zindex');
                }
                
                if (_init && $(_img).length >0) {
                    $(_img).easypinShow({
                        data: _init,
                        responsive: _reponsive,
                        popover: {
                            show: false,
                            animate: false
                        },
                        each: function(index, data) {
                            return data;
                        },
                        error: function() {
                            
                        },
                        success: function() {
                            if ($(_this).find('.nasa-product-pin .price.nasa-price-pin').length > 0){
                                $(_this).find('.nasa-product-pin .price.nasa-price-pin').each(function() {
                                    var _pid = $(this).attr('data-product_id');
                                    if (parseInt(_pid) && $(_this).find('.nasa-price-pin-' + _pid).length > 0) {
                                        $(this).html($(_this).find('.nasa-price-pin-' + _pid).html());
                                    }
                                });
                            }
                            
                            if ($(_this).hasClass('nasa-has-effect')) {
                                setInterval(function() {
                                    $(_this).find('.nasa-marker-icon-wrap').toggleClass('nasa-effect');
                                }, 2400);
                            }
                        }
                    });
                }
                
                $(_img).click(function() {
                    $(_this).find('.easypin-popover').hide();
                });
                
                $(document).on('keyup', function(e){
                    if (e.keyCode === 27){
                        $(_img).trigger('click');
                    }
                });
            }
        });
    }
}

/**
 * Pin Material Banner
 * 
 * @param {type} $
 * @returns {undefined}
 */
function loadPinMaterialBanner($) {
    if ($('.nasa-pin-material-banner-wrap').length > 0) {
        nasaCompatibleJetpack($);
        
        $('.nasa-pin-material-banner-wrap').each(function() {
            var _this = $(this);
            if (!$(_this).hasClass('nasa-inited')) {
                $(_this).addClass('nasa-inited');
                var _init = $(_this).attr('data-pin');
                var _img = $(_this).find('img.nasa_pin_mb_image');
                var _reponsive = $(_img).parents('columns').length === 1 ? true : false;
                
                if ($(_this).parents('.section-element').length && !$(_this).parents('.section-element').hasClass('nasa-unset-zindex')) {
                    $(_this).parents('.section-element').addClass('nasa-unset-zindex');
                }
                
                if (_init && $(_img).length >0) {
                    $(_img).easypinShow({
                        data: _init,
                        responsive: _reponsive,
                        popover: {
                            show: false,
                            animate: false
                        },
                        each: function(index, data) {
                            return data;
                        },
                        error: function() {
                            
                        },
                        success: function() {
                            if ($(_this).hasClass('nasa-has-effect')) {
                                setInterval(function() {
                                    $(_this).find('.nasa-marker-icon-wrap').toggleClass('nasa-effect');
                                }, 2400);
                            }
                        }
                    });
                }
                
                $(_img).click(function() {
                    $(_this).find('.easypin-popover').hide();
                });
                
                $(document).on('keyup', function(e){
                    if (e.keyCode === 27){
                        $(_img).trigger('click');
                    }
                });
            }
        });
    }
}

/**
 * init select2
 * 
 * @param {type} $
 * @returns {undefined}
 */
function nasa_init_select2($) {
    if ($('.nasa-select2').length && $('body').hasClass('nasa-woo-actived')) {
        $('.nasa-select2').each(function () {
            if (!$(this).hasClass('inited')) {
                $(this).addClass('inited');
                $(this).select2();
            }
        });
    }
}

/**
 * Init filter nasa categories
 * 
 * @param {type} $
 * @returns {undefined}
 */
function nasa_init_filter_nasa_categories($) {
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
 * Quick view | Add to cart
 */
function nasa_product_quickview_addtocart($, reset) {
    var _reset = typeof reset === 'undefined' ? false : reset;
    
    if (_reset) {
        $('.nasa-product-more-hover').removeClass('nasa-inited');
    }
    
    if ($('.nasa-product-more-hover .add-to-cart-grid, .nasa-product-more-hover .quick-view').length) {
        $('.nasa-product-more-hover .add-to-cart-grid, .nasa-product-more-hover .quick-view').each(function() {
            var _this = $(this);
            var _wrap = $(_this).parents('.nasa-product-more-hover');
            if (!$(_wrap).hasClass('nasa-inited')) {
                if ($(_this).width() < 95) {
                    // $(_wrap).find('.quick-view .nasa-icon').removeClass('hidden-tag');
                    $(_wrap).find('.quick-view .nasa-text').addClass('hidden-tag');
                    
                    // $(_wrap).find('.add-to-cart-btn .nasa-icon').show();
                    $(_wrap).find('.add-to-cart-btn .nasa-text').addClass('hidden-tag');
                } else {
                    // $(_wrap).find('.quick-view .nasa-icon').addClass('hidden-tag');
                    $(_wrap).find('.quick-view .nasa-text').removeClass('hidden-tag');
                    
                    // $(_wrap).find('.add-to-cart-btn .nasa-icon').hide();
                    $(_wrap).find('.add-to-cart-btn .nasa-text').removeClass('hidden-tag');
                }
                
                $(_wrap).addClass('nasa-inited');
            }
        });
    }
}

/**
 * Fix deal has nav type 2
 */
function nasa_fix_deal_nav_2($, _reset) {
    if ($('.nasa-products-special-deal-multi-2').length) {
        var reset = typeof _reset === 'undefined' ? false : _reset;
        if (reset) {
            $('.nasa-products-special-deal-multi-2').removeClass('nasa-inited');
        }
        
        var _intival = setInterval(function () {
            $('.nasa-products-special-deal-multi-2').each(function() {
                var _this = $(this);
                if (!$(_this).hasClass('nasa-inited')) {
                    var _main = $(_this).find('.nasa-main-special');
                    var _extra = $(_this).find('.nasa-slider-deal-vertical-extra-switcher');
                    
                    var _main_h = $(_main).attr('data-height_org');
                    if (!_main_h) {
                        _main_h = $(_main).height();
                        $(_main).attr('data-height_org', _main_h);
                    }
                    
                    $(_main).css({'height': 'auto'});
                    
                    if ($(_extra).hasClass('slick-initialized')) {
                        var _height = $(_extra).height();
                        if (_height - 30 > _main_h) {
                            $(_main).css({'height': _height - 30});
                        }
                        $(_this).addClass('nasa-inited');
                    }
                }
            });
            
            if ($('.nasa-products-special-deal-multi-2').length === $('.nasa-products-special-deal-multi-2.nasa-inited').length) {
                clearInterval(_intival);
            }
        }, 100);
    }
}

/**
 * Refresh Product Masonry Isotope
 * @param {type} $
 * @returns {undefined}
 */
function nasaRefreshProductsMasonryIsotope($) {
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

/**
 * 360 Degree Product viewer
 */
function nasa_360_degree($) {
    if ($('#nasa-360-degree').length) {
        var _imgArr = [];
        var _imgObj = JSON.parse($('#nasa-360-degree').attr('data-imgs'));
        if (_imgObj) {
            $.each(_imgObj, function(index, value) {
                _imgArr.push(value);
            });
        }
        
        if (_imgArr.length) {
            var _h = parseInt($('#nasa-360-degree').attr('data-height')),
                _w = parseInt($('#nasa-360-degree').attr('data-width'));
            if ($('.nasa-threesixty-wrap').length <= 0) {
                $('.nasa-product-360-degree').append(
                    '<div class="nasa-threesixty">' +
                        '<div class="spinner">' +
                            '<span>0%</span>' +
                        '</div>' +
                        '<ul class="nasa-threesixty_images"></ul>' +
                    '</div>'
                );
        
                $('.nasa-threesixty').ThreeSixty({
                    totalFrames:_imgArr.length,
                    endFrame:_imgArr.length,
                    currentFrame:1,
                    imgList:".nasa-threesixty_images",
                    progress:".spinner",
                    imgArray:_imgArr,
                    height:_h,
                    width:_w,
                    responsive:true,
                    navigation:true
                });
            }
        }
    }
}
