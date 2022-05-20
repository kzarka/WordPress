(function($) {
	"use strict";

	// Accordion Shop Filter

	$('.jet-list-tree__children ').each(function(i) {
		$(this).attr('id', 'checkboxes_children_filter'+(i+1));
		$(this ).append( "<button class='pull-right less-more'><span></span></button>" );
	});

	$('.jet-list-tree__children').each(function(i){
		var id = $(this).attr("id");
		$('#' + id + ' >button').on('click', function(e){
			
			if( $('#' + id ).hasClass("open") ){
				$('#' + id).removeClass("open");
			}else{
				$('.jet-list-tree__children').removeClass('open');
				$('#' + id).toggleClass("open");
			}
			e.preventDefault();
        });
	});


	$(".header-style13 .mega-left-title").each(function(){
			$(this).on('click', function(){
				$(this).parent().find(".vertical_megamenu").slideToggle();
			});
		});
	/* 
	** Add Click On Ipad 
	*/
	$(window).resize(function(){
		var $width = $(this).width();
		if( $width < 1199 ){
			$( '.primary-menu .nav .dropdown-toggle'  ).each(function(){
				$(this).attr('data-toggle', 'dropdown');
			});
		}
	});
	
	/* Check variable if has swatches variation */
	if( $('body').hasClass( 'sw-wooswatches' ) ){
		$( '.sw-wooswatches .product-type-variable' ).each(function(){
			var h_swatches = $(this).find( '.sw-variation-wrapper' ).height() + 20;
			$(this).find( '.item-bottom' ).css( 'bottom', h_swatches );
		});
	}
	
	/*
	** Blog Masonry
	*/
	$(window).load(function() {
		if( $.isFunction( $.isotope ) ){
			$('body').find('.blog-content-grid').isotope({ 
				layoutMode : 'masonry'
			});
		}
	});
	 
	

	
	
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip(); 
		
		$('#myTabs a').hover( function(e) {
			 e.preventDefault();
			$(this).tab('show');
			 $("li.autusin-mega-menu").removeClass("active");
			 //removing active class from other selected/default tab
			$("#myTabs .active").removeClass("active");

			//adding active class to current clicked tab
			$(this).parent().addClass("active");
		});


		$('.header-bottom-elementor22 .icon-sidebar').on('click', function(){
		$('.header-sibar-home22').toggleClass('open');
		$('body').toggleClass('open');
		});
		
		$('.header-sibar-home22 .close-sidebar').on('click', function(){
			$('.header-sibar-home22').toggleClass('open');
			$('body').toggleClass('open');
		});


		
		/*
		** Search on click
		*/
		$(".icon-search").on('click', function(){
			$(".top-form.top-search ").toggleClass("open");
			$('.icon-search').toggleClass("closex");
		});
		$('.header-right .menu-confirmation .text-confirmation').on('click', function(){
			$('.header-right .menu-confirmation').toggleClass("open");
		});
		
		$('.main-menu .header-close').on('click', function(){
			$('.main-menu').removeClass("open");
		});
		$('.header-open').on('click', function(){
			$('.main-menu').toggleClass("open");
		});
		/*
		**  show menu mobile
		*/	
		$( ".header-mobile-style1 .mobile-search .icon-seach" ).on('click', function() {
		  $( ".header-mobile-style1 .mobile-search .top-form.top-search" ).slideToggle( "slow", function() {
		  });
		});
		$( ".header-mobile-style2 .mobile-search .icon-seach" ).on('click', function() {
		  $( ".header-mobile-style2 .mobile-search .top-form.top-search" ).slideToggle( "slow", function() {
		  });
		});
		$('.header-menu-categories .open-menu').on('click', function(){
			$('.main-menu').toggleClass("open");
		});
		
		$('.footer-mstyle1 .footer-menu .footer-search a').on('click', function(){
			$('.top-form.top-search').toggleClass("open");
		});
		
		$('.footer-mstyle1 .footer-menu .footer-more a').on('click', function(){
			$('.menu-item-hidden').toggleClass("open");
		});
		
		/*
		** js mobile
		*/
		$('.single-product.mobile-layout .social-share .title-share').on('click', function(){
			$('.single-product.mobile-layout .social-share').toggleClass("open");
		});
		$('.single-post.mobile-layout .social-share .title-share').on('click', function(){
			$('.single-post.mobile-layout .social-share').toggleClass("open");
		});

		$('.single-post.mobile-layout .social-share.open .title-share').on('click', function(){
			$('.single-post.mobile-layout .social-share').removeClass("open");
		});
		
		$('.products-nav .filter-product').on('click', function(){
			$('.products-wrapper .filter-mobile').toggleClass("open");
			$('.products-wrapper').toggleClass('show-modal');
		});
		
		$('.products-nav .filter-product').on('click', function(){
			if( $( ".products-wrapper .products-nav .filter-product" ).not( ".filter-mobile" ) ){
				$('.products-wrapper').removeClass('show-modal');
			}	
		});
		
		$('.mobile-layout .back-history').on('click', function(){
			window.history.back();
		});

		/*add title to button*/
		$("a.compare").attr('title', custom_text.compare_text);
		$(".yith-wcwl-add-button a").attr('title', custom_text.wishlist_text);
		$("a.fancybox").attr('title', custom_text.quickview_text);
		$("a.add_to_cart_button").attr('title', custom_text.cart_text);
		
		/*
		** Product listing select box
		*/
		$('.catalog-ordering .orderby .current-li a').html($('.catalog-ordering .orderby ul li.current a').html());
		$('.catalog-ordering .sort-count .current-li a').html($('.catalog-ordering .sort-count ul li.current a').html());

		});

	
	/*
	** Quickview and single product slider
	*/
	$(document).ready(function(){
		/* 
		** Slider single product image
		*/
		$( '.woocommerce-product-gallery__trigger' ).remove();
		$( '.product-images' ).each(function(){
			var $rtl 			= $('body').hasClass( 'rtl' );
			var $vertical		= $(this).data('vertical');
			var $img_slider 	= $(this).find('.product-responsive');
			var video_link 		= $(this).data('video');
			var $thumb_slider 	= $(this).find('.product-responsive-thumbnail' );
			var number_slider	= ( $vertical ) ? 4: 5;
			var number_mobile 	= ( $vertical ) ? 2: 4;
			
			$img_slider.slick({
				slidesToShow: 1,
				slidesToScroll: 1,
				fade: true,
				arrows: false,
				rtl: $rtl,
				asNavFor: $thumb_slider,
				infinite: false
			});
			$thumb_slider.slick({
				slidesToShow: number_slider,
				slidesToScroll: 1,
				asNavFor: $img_slider,
				arrows: true,
				rtl: $rtl,
				infinite: false,
				vertical: $vertical,
				verticalSwiping: $vertical,
				focusOnSelect: true,
				responsive: [
				{
					breakpoint: 480,
					settings: {
						slidesToShow: number_mobile    
					}
				},
				{
					breakpoint: 360,
					settings: {
						slidesToShow: 2    
					}
				}
				]
			});

			var el = $(this);
			setTimeout(function(){
				el.removeClass("loading");
				var height = el.find('.product-responsive').outerHeight();
				var target = el.find( ' .item-video' );
				target.css({'height': height,'padding-top': (height - target.outerHeight())/2 });

				var thumb_height = el.find('.product-responsive-thumbnail' ).outerHeight();
				var thumb_target = el.find( '.item-video-thumb' );
				thumb_target.css({ height: thumb_height,'padding-top':( thumb_height - thumb_target.outerHeight() )/2 });
			}, 1000);
						
			if( custom_text.zoom == 1 ){
				$( '.product-images .product-responsive' ).prepend( '<a href="#" class="woocommerce-product-gallery__trigger">ðŸ”</a>' );
			}
			if( video_link != '' ) {
				$img_slider.append( '<button data-type="popup" class="featured-video-button fa fa-video-camera" data-video="'+ video_link +'"></button>' );
			}
		});
	});

	/*
	** Hover on mobile and tablet
	*/
	var mobileHover = function () {
		$('*').on('touchstart', function () {
			$(this).trigger('hover');
		}).on('touchend', function () {
			$(this).trigger('hover');
		});
	};
	mobileHover();

	
	/*
	** Menu hidden
	*/
	$('.product-categories').each(function(){
		var number	 = $(this).data( 'number' ) - 1;
		var lesstext = $(this).data( 'lesstext' );
		var moretext = $(this).data( 'moretext' );
		if( number > 0 ) {
			$(this).find( '> li:gt('+ number +')' ).hide().end();		
			if( $(this).children('li').length > number ){ 
				$(this).append(
					$('<li><a>'+ moretext +'   +</a></li>')
					.addClass('showMore')
					.on('click',function(){
						if($(this).siblings(':hidden').length > 0){
							$(this).html( '<a>'+ lesstext +'   -</a>' ).siblings(':hidden').show(400);
						}else{
							$(this).html( '<a>'+ moretext +'   +</a>' ).show().siblings( ':gt('+ number +')' ).hide(400);
						}
					})
				);
			}
		}
		if( $(this).hasClass( 'accordion-categories' ) ){
			$(this).find( '> li.cat-parent' ).append( '<span class="child-category-more"></span>' );
		}
	});
	
	$(document).on( 'click', '.child-category-more', function(){
		$(this).parent().toggleClass( 'active' );
		$(this).parent().find( '> ul.children' ).toggle(200);
	});
	
	// click filter
	$(document).on( 'click', '.view-mode .button-filter', function(){
		$(".box-content-archive ").toggleClass( 'active_filters' );
		$(".button-filter ").toggleClass("closex");
	});

	var w_width = $(window).width(); 
	if( w_width <= 480){
		jQuery('.mobile-layout .header-mobile-style5 .autusin_resmenu')
		.find(' > li:gt(6) ') 
		.hide()
		.end()
		.each(function(){
			if($(this).children('li').length > 6){ 
				$(this).append(
					$('<li><a class="open-more-cat">More Categories</a></li>')
					.addClass('showMore')
					.on('click', function(){
						if($(this).siblings(':hidden').length > 0){
							$(this).html('<a class="close-more-cat">Close Categories</a>').siblings(':hidden').show(400);
						}else{
							$(this).html('<a class="open-more-cat">More Categories</a>').show().siblings('li:gt(6)').hide(400);
						}
					})
					);
			}
		});
	}
	/* 
	** Fix accordion heading state 
	*/
	$('.accordion-heading').each(function(){
		var $this = $(this), $body = $this.siblings('.accordion-body');
		if (!$body.hasClass('in')){
			$this.find('.accordion-toggle').addClass('collapsed');
		}
	});	
	
	/*
	** Footer accordion
	*/
	if ($(window).width() < 768) {	
		$('.cusom-menu-mobile h5').append('<span class="icon-footer"></span>');

		$(".cusom-menu-mobile h5").each(function(){
			$(this).on('click', function(){
				$(this).parent().find("ul.menu").slideToggle();
			});
		});
		$('.mobile-layout .cusom-menu-mobile .widget_nav_menu h2.widgettitle').append('<span class="icon-footer"></span>');

		$(".mobile-layout .cusom-menu-mobile .widget_nav_menu h2.widgettitle").each(function(){
			$(this).on('click', function(){
				$(this).parent().find("ul.menu").slideToggle();
			});
		});

		$('.footer .widget_nav_menu h2.widgettitle').append('<span class="icon-footer"></span>');
		$('.footer .wpb_content_element .info-footer h3').append('<span class="icon-footer"></span>');

		$(".footer .widget_nav_menu h2.widgettitle").each(function(){
			$(this).on('click', function(){
				$(this).parent().find("ul.menu").slideToggle();
			});
		});
		
		$(".footer .wpb_content_element .info-footer h3").each(function(){
			$(this).on('click', function(){
				$(this).parent().find("ul").slideToggle();
			});
		});	
		
	}
	



		
	
	/*
	** Back to top
	**/

	$("#autusin-totop").hide();
	var wh = $(window).height();
	var whtml = $(document).height();
	var $scrolltop = jQuery('#autusin-totop');
	$(window).scroll(function () {
		if ($(this).scrollTop() > whtml/10) {
			$scrolltop.fadeIn();
			$scrolltop.addClass("show-car");
		} else {
			$scrolltop.fadeOut();
			$scrolltop.removeClass('show-car');
		}
	});
		
	$('#autusin-totop').on('click', function() {
		
		$('body,html').animate({
			scrollTop: 0
		}, 1200);
		$scrolltop.addClass("car-run");
		setTimeout(function(){
			$scrolltop.removeClass('car-run');
		},500);
		return!1;
	});

	/* end back to top */

 /*
 ** Fix js 
 */
 $('.wpb_map_wraper').on('click', function () {
 	$('.wpb_map_wraper iframe').css("pointer-events", "auto");
 });

 $( ".wpb_map_wraper" ).on('mouseleave', function() {
 	$('.wpb_map_wraper iframe').css("pointer-events", "none"); 
 });


	/*
	** Change Layout 
	*/
	$( window ).load(function() {	

		if( $( 'body' ).hasClass( 'tax-product_cat' ) || $( 'body' ).hasClass( 'post-type-archive-product' ) || $( 'body' ).hasClass( 'tax-dc_vendor_shop' ) ) {
			$(document).on('click','.view-mode .grid-view' ,function(){
				$('.list-view').removeClass('active');
				$('.grid-view').addClass('active');
				jQuery("ul.products-loop").fadeOut(300, function() {
					$(this).removeClass("list").fadeIn(300).addClass( 'grid' );			
				});
			});
			
			$(document).on('click','.list-view',function(){
				$( '.grid-view' ).removeClass('active');
				$( '.list-view' ).addClass('active');
				$("ul.products-loop").fadeOut(300, function() {
					jQuery(this).addClass("list").fadeIn(300).removeClass( 'grid' );
				});
			});
			/* End Change Layout */
		} 
	});
	$(window).scroll(function() {    
		var whtop = $(window).scrollTop(); 
		if (whtop > 0) {
			$(".header-style4").addClass("header-ontop");
		} else {
			$(".header-style4").removeClass("header-ontop");
		} 
	});
	
	/*remove loading*/
	$(".sw-woo-tab").fadeIn(300, function() {
		var el = $(this);
		setTimeout(function(){
			el.removeClass("loading");
		}, 1000);
	});
	$(".responsive-slider").fadeIn(300, function() {
		var el = $(this);
		setTimeout(function(){
			el.removeClass("loading");
		}, 1000);
	});

	/*
	** Check comment form
	*/
	function submitform(){
		if(document.commentform.comment.value=='' || document.commentform.author.value=='' || document.commentform.email.value==''){
			alert('Please fill the required field.');
			return false;
		} else return true;
	}
	
	$(window).on( 'change', function(){
		var element = $( '.variations_form' );
		var bt_addcart = element.find( '.single_add_to_cart_button' );
		var variation  = element.find( '.variation_id' ).val();
		var bt_buynow  = element.find( '.button-buynow' );
		var url = bt_buynow.data( 'url' );
		if( bt_addcart.hasClass( 'disabled' ) ){
			bt_buynow.addClass( 'disabled' );
		}else{
			bt_buynow.removeClass( 'disabled' );
		}
		if( variation != '' ){
			bt_buynow.attr( 'href', url + '='+variation );
		}else{
			bt_buynow.attr( 'href', url );
		}
	});

}(jQuery));


(function($){
	
	/*Verticle Menu*/
	if( !( $('#header').hasClass( 'header-style7' ) ) ) {
		$('.vertical-megamenu').each(function(){
			var number	 = $(this).parent().data( 'number' ) - 1;
			var lesstext = $(this).parent().data( 'lesstext' );
			var moretext = $(this).parent().data( 'moretext' );
			$(this).find(	' > li:gt('+ number +')' ).hide().end();		
			if($(this).children('li').length > number ){ 
				$(this).append(
					$('<li><a class="open-more-cat">'+ moretext +'</a></li>')
					.addClass('showMore')
					.on('click', function(){
						if($(this).siblings(':hidden').length > 0){
							$(this).html('<a class="close-more-cat">'+ lesstext +'</a>').siblings(':hidden').show(400);
						}else{
							$(this).html('<a class="open-more-cat">'+ moretext +'</a>').show().siblings( ':gt('+ number +')' ).hide(400);
						}
					})
					);
			}
		});
	}


	$(".widget_nav_menu li.menu-compare a").on('hover', function() {
		$(this).css('cursor','pointer').attr('title', custom_text.compare_text);
	}, function() {
		$(this).css('cursor','auto');
	});
	$(".widget_nav_menu li.menu-wishlist a").on('hover', function() {
		$(this).css('cursor','pointer').attr('title', custom_text.wishlist_text);
	}, function() {
		$(this).css('cursor','auto');
	});
	

	$(window).scroll(function() {   
		if( $( 'body' ).hasClass( 'mobile-layout' ) ) {
			var target = $( '.mobile-layout #header-page' );
			var sticky_nav_mobile_offset = $(".mobile-layout #header-page").offset();
			if( sticky_nav_mobile_offset != null ){
				var sticky_nav_mobile_offset_top = sticky_nav_mobile_offset.top;
				var scroll_top = $(window).scrollTop();
				if ( scroll_top > sticky_nav_mobile_offset_top ) {
					$(".mobile-layout #header-page").addClass('sticky-mobile');
				}else{
					$(".mobile-layout #header-page").removeClass('sticky-mobile');
				}
			}
		}
	});


	/*
	** Ajax login
	*/
	$('form#login_ajax').on('submit', function(e){
		var target = $(this);		
		var usename = target.find( '#username').val();
		var pass 	= target.find( '#password').val();
		if( usename.length == 0 || pass.length == 0 ){
			target.find( '#login_message' ).addClass( 'error' ).html( custom_text.message );
			return false;
		}
		target.addClass( 'loading' );
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: custom_text.ajax_url,
			headers: { 'api-key':target.find( '#woocommerce-login-nonce').val() },
			data: { 
				'action': 'autusin_custom_login_user', //calls wp_ajax_nopriv_ajaxlogin
				'username': target.find( '#username').val(), 
				'password': target.find( '#password').val(), 
				'security': target.find( '#woocommerce-login-nonce').val() 
			},
			success: function(data){
				target.removeClass( 'loading' );
				target.find( '#login_message' ).html( data.message );
				if (data.loggedin == false){
					target.find( '#username').css( 'border-color', 'red' );
					target.find( '#password').css( 'border-color', 'red' );
					target.find( '#login_message' ).addClass( 'error' );
				}
				if (data.loggedin == true){
					target.find( '#username').removeAttr( 'style' );
					target.find( '#password').removeAttr( 'style' );
					document.location.href = data.redirect;
					target.find( '#login_message' ).removeClass( 'error' );
				}
			}
		});
		e.preventDefault();
	});
	
	/*
	** Responsive Menu
	*/
	$( '.resmenu-container-sidebar .more-menu > a' ).on( 'click', function(e){
		$(this).parent().find( '>ul' ).toggle();
		e.preventDefault();
	});



	$('.header-elementor15 select').each(function(){
	    var $this = $(this), numberOfOptions = $(this).children('option').length;
	  
	    $this.addClass('select-hidden'); 
	    $this.wrap('<div class="select"></div>');
	    $this.after('<div class="select-styled"></div>');

	    var $styledSelect = $this.next('div.select-styled');
	    $styledSelect.text($this.children('option').eq(0).text());
	  
	    var $list = $('<ul />', {
	        'class': 'select-options'
	    }).insertAfter($styledSelect);
	  
	    for (var i = 0; i < numberOfOptions; i++) {
	        $('<li />', {
	            text: $this.children('option').eq(i).text(),
	            rel: $this.children('option').eq(i).val()
	        }).appendTo($list);
	    }
	  
	    var $listItems = $list.children('li');
	  
	    $styledSelect.click(function(e) {
	        e.stopPropagation();
	        $('div.select-styled.active').not(this).each(function(){
	            $(this).removeClass('active').next('ul.select-options').hide();
	        });
	        $(this).toggleClass('active').next('ul.select-options').toggle();
	    });
	  
	    $listItems.click(function(e) {
	        e.stopPropagation();
	        $styledSelect.text($(this).text()).removeClass('active');
	        $this.val($(this).attr('rel'));
	        $list.hide();
	        //console.log($this.val());
	    });
	  
	    $(document).click(function() {
	        $styledSelect.removeClass('active');
	        $list.hide();
	    });

	});

	$('.header-elementor15 .select-styled').on('click', function(){
		$('.header-elementor15 .select-options').toggleClass("open");
	});

	$('.header-elementor15 .select-options li').on('click', function(){
		$('.header-elementor15 .select-options').removeClass("open");
	});








	
	/*
	** Scroll Element
	*/
	
	var sticky_navigation_offset = $(".bg-image-home13").offset();
	var sticky_navigation_offset2 = $("#footer").offset();
		if( typeof sticky_navigation_offset != "undefined" ) {
			var sticky_navigation_offset_top = sticky_navigation_offset.top;
			var sticky_navigation_offset_bottom = sticky_navigation_offset2.top;
			var sticky_navigation = function(){
			var scroll_top = $(window).scrollTop();
			if (scroll_top > sticky_navigation_offset_top && scroll_top < sticky_navigation_offset_bottom ) {
				$(".bg-image-home13").addClass("fixed");
				$(".bg-image-home13").removeClass("fixed2");
			}
			else if( scroll_top  > sticky_navigation_offset_bottom ){
				$(".bg-image-home13").addClass("fixed2");
				$(".bg-image-home13").removeClass("fixed");
			}
			else {
					$(".bg-image-home13").removeClass("fixed");
					$(".bg-image-home13").removeClass("fixed2");
				}
			}
			sticky_navigation();
			$(window).scroll(function() {
				sticky_navigation();
			});
		}
					
		var sticky_navigation_offset_elementor = $(".bg-image-home13_elementor").offset();
		var sticky_navigation_offset2_elementor = $(".elementor-location-footer").offset();
		if( typeof sticky_navigation_offset_elementor != "undefined" ) {
			var sticky_navigation_offset_top_elementor = sticky_navigation_offset_elementor.top;
			var sticky_navigation_offset_bottom_elementor = sticky_navigation_offset2_elementor.top;
			var sticky_navigation = function(){
			var scroll_top = $(window).scrollTop();
			if (scroll_top > sticky_navigation_offset_top_elementor && scroll_top < sticky_navigation_offset_bottom_elementor ) {
				$(".bg-image-home13_elementor").addClass("fixed");
				$(".bg-image-home13_elementor").removeClass("fixed2");
			}
			else if( scroll_top  > sticky_navigation_offset_bottom_elementor ){
				$(".bg-image-home13_elementor").addClass("fixed2");
				$(".bg-image-home13_elementor").removeClass("fixed");
			}
			else {
					$(".bg-image-home13_elementor").removeClass("fixed");
					$(".bg-image-home13_elementor").removeClass("fixed2");
				}
			}
			sticky_navigation();
			$(window).scroll(function() {
				sticky_navigation();
			});
		}
})(jQuery);
