var responsiveflag = false;

/* total storage */
(function($){var ls=window.localStorage;var supported;if(typeof ls=='undefined'||typeof window.JSON=='undefined'){supported=false;}else{supported=true;}
$.totalStorage=function(key,value,options){return $.totalStorage.impl.init(key,value);}
$.totalStorage.setItem=function(key,value){return $.totalStorage.impl.setItem(key,value);}
$.totalStorage.getItem=function(key){return $.totalStorage.impl.getItem(key);}
$.totalStorage.getAll=function(){return $.totalStorage.impl.getAll();}
$.totalStorage.deleteItem=function(key){return $.totalStorage.impl.deleteItem(key);}
$.totalStorage.impl={init:function(key,value){if(typeof value!='undefined'){return this.setItem(key,value);}else{return this.getItem(key);}},setItem:function(key,value){if(!supported){try{$.cookie(key,value);return value;}catch(e){console.log('Local Storage not supported by this browser. Install the cookie plugin on your site to take advantage of the same functionality. You can get it at https://github.com/carhartl/jquery-cookie');}}
var saver=JSON.stringify(value);ls.setItem(key,saver);return this.parseResult(saver);},getItem:function(key){if(!supported){try{return this.parseResult($.cookie(key));}catch(e){return null;}}
return this.parseResult(ls.getItem(key));},deleteItem:function(key){if(!supported){try{$.cookie(key,null);return true;}catch(e){return false;}}
ls.removeItem(key);return true;},getAll:function(){var items=new Array();if(!supported){try{var pairs=document.cookie.split(";");for(var i=0;i<pairs.length;i++){var pair=pairs[i].split('=');var key=pair[0];items.push({key:key,value:this.parseResult($.cookie(key))});}}catch(e){return null;}}else{for(var i in ls){if(i.length){items.push({key:i,value:this.parseResult(ls.getItem(i))});}}}
return items;},parseResult:function(res){var ret;try{ret=JSON.parse(res);if(ret=='true'){ret=true;}
if(ret=='false'){ret=false;}
if(parseFloat(ret)==ret&&typeof ret!="object"){ret=parseFloat(ret);}}catch(e){}
return ret;}}})(jQuery);

/* edit from here */
$(document).ready(function(){
	responsiveResize();
	$(window).resize(responsiveResize);
	
	// hide #back-top first
	$(".back-top").hide();
	
	// scroll body to 0px on click
	$(function () {
		$(window).scroll(function () {
			if ($(this).scrollTop() > 150) {
				$('.back-top').fadeIn();
			} else {
				$('.back-top').fadeOut();
			}
		});
		$('.back-top').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 1000);
			return false;
		});
	});
	
	var pagename = $('body').attr('id');
	
	//scroll menu
	var window_height = $(window).height();
	var body_height = $("main").height();
	var scroll_height = $("#header").height();
	if (window_height < (body_height - scroll_height)){
		if ($(window).width() >= 768){
			$(window).scroll(function() {    
			  var scroll = $(window).scrollTop();
			  if (scroll < scroll_height) {
			   $(".scroll_menu").removeClass("scroll-menu animated fadeInDown");
			   if ( pagename == "index"){				   
				   if($(".pt_vegamenu .pt_vegamenu_cate").is(':hidden')){
						$(".pt_vegamenu .pt_vegamenu_cate").slideDown();
					} else {
						// $(".pt_vegamenu .pt_vegamenu_cate").slideUp();
					}
			   }
			  }else{
			   $(".scroll_menu").addClass("scroll-menu animated fadeInDown");
			   if ( pagename == "index"){
				   if($(".pt_vegamenu .pt_vegamenu_cate").is(':hidden')){
						// vega.slideDown();
					} else {
						$(".pt_vegamenu .pt_vegamenu_cate").slideUp();
					}
				}
			  }
			});
		}
	}
	
	var accessories = $(".product_accessoriesslide");
		accessories.owlCarousel({
		items :4,
		itemsDesktop : [1199,4],
		itemsDesktopSmall : [991,3],
		itemsTablet: [767,2],
		itemsMobile : [480,1]
	});
	
	$(".product_accessories .navi .nexttab").click(function(){
		accessories.trigger('owl.next');
	})
	$(".product_accessories .navi .prevtab").click(function(){
		accessories.trigger('owl.prev');
	})  
	
	bindGrid();
});

function bindGrid()
{
	var view = $.totalStorage('display');

	if (view && view != 'grid')
		display(view);
	else
		$('.display').find('li#grid').addClass('selected');

	$(document).on('click', '#grid', function(e){
		e.preventDefault();
		display('grid');
	});

	$(document).on('click', '#list', function(e){
		e.preventDefault();
		display('list');
	});
}

function display(view)
{
	if (view == 'list')
	{
		$('#js-product-list .product_content').removeClass('grid').addClass('list');
		$('.product_content .item_list').removeClass('col-sm-6 col-md-6 col-lg-4');
		$('.product_content .item_list .js-product-miniature');
		$('.display').find('li#list').addClass('selected');
		$('.display').find('li#grid').removeAttr('class');
		$.totalStorage('display', 'list');
	}
	else
	{
		$('#js-product-list .product_content').removeClass('list').addClass('grid');
		$('.product_content .item_list').addClass('col-sm-6 col-md-6 col-lg-4');
		$('.product_content .item_list .js-product-miniature');
		$('.display').find('li#grid').addClass('selected');
		$('.display').find('li#list').removeAttr('class');
		$.totalStorage('display', 'grid');
	}
}

function scrollCompensate()
{
	var inner = document.createElement('p');
	inner.style.width = "100%";
	inner.style.height = "200px";

	var outer = document.createElement('div');
	outer.style.position = "absolute";
	outer.style.top = "0px";
	outer.style.left = "0px";
	outer.style.visibility = "hidden";
	outer.style.width = "200px";
	outer.style.height = "150px";
	outer.style.overflow = "hidden";
	outer.appendChild(inner);

	document.body.appendChild(outer);
	var w1 = inner.offsetWidth;
	outer.style.overflow = 'scroll';
	var w2 = inner.offsetWidth;
	if (w1 == w2) w2 = outer.clientWidth;

	document.body.removeChild(outer);

	return (w1 - w2);
}
	
function responsiveResize()
{
	compensante = scrollCompensate();
	if (($(window).width()+scrollCompensate()) <= 767 && responsiveflag == false)
	{
		accordionFooter('enable');
		responsiveflag = true;
	}
	else if (($(window).width()+scrollCompensate()) >= 768)
	{
		accordionFooter('disable');
		responsiveflag = false;
	}
}

function accordionFooter(status)
{
	if(status == 'enable')
	{
		$('#footer .footer_block h3').on('click', function(e){
			$(this).toggleClass('active').parent().find('.toggle-footer').stop().slideToggle('medium');
			e.preventDefault();
		})
		$('#footer').addClass('accordion').find('.toggle-footer').slideUp('fast');
	}
	else
	{
		$('.footer_block h3').removeClass('active').off().parent().find('.toggle-footer').removeAttr('style').slideDown('fast');
		$('#footer').removeClass('accordion');
	}
}