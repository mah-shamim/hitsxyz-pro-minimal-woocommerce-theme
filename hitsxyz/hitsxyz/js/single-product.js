jQuery(function($){
	"use strict";
	var on_touch = !$('body').hasClass('hits_desktop');
	
	/*** Product Video ***/
	$('a.hits-product-video-button').on('click', function(e){
		e.preventDefault();
		var product_id = $(this).data('product_id');
		var container = $('#hits-product-video-modal');
		if( container.find('.product-video-content').html() ){
			container.addClass('show');
		}
		else{
			container.addClass('loading');
			$.ajax({
				type : 'POST'
				,url : hitsxyz_params.ajax_url
				,data : {action : 'hitsxyz_load_product_video', product_id: product_id}
				,success : function(response){
					container.find('.product-video-content').html( response );
					container.removeClass('loading').addClass('show');
				}
			});
		}
	});
	
	/*** Product 360 ***/
	if( typeof $.fn.ThreeSixty == 'function' ){
		if( $('.hits-product-360-button').length == 0 ){
			setTimeout(function(){
				generate_product_360();
			}, 1000);
		}
		
		$('.hits-product-360-button').on('click', function(){
			$('#hits-product-360-modal').addClass('loading');
			generate_product_360();
			return false;
		});
	}
	
	function generate_product_360(){
		if( !$('.hits-product-360').hasClass('loaded') ){
			$('.hits-product-360').ThreeSixty({
				currentFrame: 1
				,imgList: '.threesixty_images'
				,imgArray: _hits_product_360_image_array
				,totalFrames: _hits_product_360_image_array.length
				,endFrame: _hits_product_360_image_array.length
				,progress: '.spinner'
				,navigation: true
				,responsive: true
				,onReady: function(){
					$('#hits-product-360-modal').removeClass('loading').addClass('show');
					$('.hits-product-360').addClass('loaded');
				}
			});
		}
		else{
			$('#hits-product-360-modal').removeClass('loading').addClass('show');
		}
	}
	
	/*** Size Chart ***/
	$('.hits-product-size-chart-button').on('click', function(e){
		e.preventDefault();
		$('#hits-product-size-chart-modal').addClass('show');
	});

	/*** Show more/less product content ***/
	if( $('.single-product .more-less-buttons').length > 0 ){
		var product_content = $('.single-product .more-less-buttons').siblings('.product-content');
		if( product_content.outerHeight() < 500 ){
			$('.single-product .more-less-buttons').remove();
			product_content.removeClass('closed show-more-less');
		}
		else{
			var timeout = 200 + ( product_content.find('img').length * 200 );
			setTimeout(function(){
				var scrollheight = product_content.get(0).scrollHeight;
				var speed = scrollheight / 1500;
				var style = '<style>'
							+ '.product-content.show-more-less{transition:'+speed+'s ease;}'
							+ '.product-content.opened{max-height:'+scrollheight+'px;}'
							+ '</style>';
				$('head').append( style );
			}, timeout);
		}
	}
	
	$('.single-product .more-less-buttons a').on('click', function(e){
		e.preventDefault();
		$(this).hide();
		$(this).siblings('a').show();
		var action = $(this).data('action');
		$(this).parent().siblings('.product-content').removeClass('opened closed').addClass(action);
		
		if( action == 'closed' ){
			var top = $(this).parents('.woocommerce-tabs').offset().top - get_fixed_header_height() - 10;
			$('body, html').animate({
				scrollTop: top
			}, 1000);
		}
	});

	function get_fixed_header_height(){
		var admin_bar_height = $('#wpadminbar').length > 0?$('#wpadminbar').outerHeight():0;
		var sticky_height = $('.is-sticky .header-sticky').length > 0?$('.is-sticky .header-sticky').outerHeight():0;
		return admin_bar_height + sticky_height;
	}
	
	/*** Review ***/
	$('#reviews .woocommerce-review-link').on('click', function(e){
		e.preventDefault();
		
		var element_top = $('#review_form_wrapper').offset().top - 40;
		element_top -= $('.is-sticky .header-sticky').length ? $('.is-sticky .header-sticky').outerHeight() : 0;

		$('html, body').animate({
			scrollTop: element_top
		}, 1000);
	});
	
	/*** Next/Prev ***/
	if( $('.single-navigation').length > 0 ){
		var image_wrapper = $('.woocommerce-product-gallery');
		var image_top = image_wrapper.offset().top;
		$(window).on('scroll', function(){
			if( $(this).scrollTop() > image_top && $(this).scrollTop() < image_top + image_wrapper.height() ){
				$('.single-navigation').addClass('visible');
			}
			else{
				$('.single-navigation').removeClass('visible');
			}
		});
	}
	
	/*** Tabs Accordion ***/
	if( $('.product.tabs-accordion').length ){
		$('.woocommerce-Tabs-panel > h2, .woocommerce-Tabs-panel #reviews > h2').on('click', function(){
			$(this).toggleClass('active');
			$(this).siblings().slideToggle();
		});
	}
});