jQuery(function($){
	"use strict";
	var on_touch = !$('body').hasClass('hits_desktop');

	setTimeout(function(){
		$('.footer-container.loading').removeClass('loading');
	}, 30);
	
	/** CSS Global scrollbarWidth Variable **/
	if( typeof $.position != 'undefined' && typeof $.position.scrollbarWidth != 'undefined' ){
		document.documentElement.style.setProperty('--scrollbarWidth',$.position.scrollbarWidth() + 'px');
	}
	
	/** Middle Navigation **/
	$(window).on('hits_slider_middle_navigation_position', function(e, swiper){
		if( swiper.parents('.hits-slider.rows-1').length || swiper.parents('.related').length || swiper.parents('.upsells').length || swiper.parents('.cross-sells').length ){
			var thumbnail = swiper.find('.swiper-slide-active').first().find('.product-wrapper .thumbnail-wrapper, .product-wrapper > a, .article-content .thumbnail-content > a.thumbnail');
			var top = thumbnail.length ? thumbnail.height() / 2 : 0;
			if( top ){
				swiper.find('.swiper-button-prev, .swiper-button-next').css('top', top);
			}
		}
	});

	/** Mega menu **/
	hits_mega_menu_change_state();
	$('.elementor-widget-wp-widget-nav_menu .menu-item-has-children .sub-menu').before('<span class="hits-menu-drop-icon"></span>');

	/*** Sidebar menu (header v1) ***/
	if( $('.vertical-menu-sidebar').length && $('.hits-sidebar-menu-icon .icon').length ){	
		/*** Click header icon ***/
		$('.hits-sidebar-menu-icon .icon').on('click', function(){
			
			$(this).toggleClass('active');
			
			if( $(window).width() > 767 ){
				$('.vertical-menu-sidebar').toggleClass('active');
			}else{
				$('#group-icon-header').toggleClass('active');
			}
		});

		/*** Click close/overlay ***/
		$(document).on('click', '.vertical-menu-sidebar .close, .vertical-menu-sidebar .overlay', function(){
			$('.vertical-menu-sidebar, .hits-sidebar-menu-icon .icon').removeClass('active');
		});

		/*** Click menu dropdown icon ***/
		if( $('.vertical-menu-sidebar .hits-menu-drop-icon').length ){
			$('.vertical-menu-sidebar .sub-menu').hide();
		}
		
		$('.vertical-menu-sidebar .hits-menu-drop-icon').on('click', function(){
			var is_active = $(this).hasClass('active');
			var sub_menu = $(this).siblings('.sub-menu');

			if (is_active) {
				sub_menu.hide();
				sub_menu.find('.sub-menu').hide();
				sub_menu.find('.hits-menu-drop-icon').removeClass('active');
			}
			else {
				sub_menu.show();
			}
			$(this).toggleClass('active');
		});
	}

	/** Menu on IPAD **/
	if (on_touch || $(window).width() < 768) {
		hits_mobile_ipad_menu_handle();
	}

	/** Sticky Menu **/
	if (typeof hitsxyz_params != 'undefined' && hitsxyz_params.sticky_header == 1) {
		hits_sticky_menu();
	}

	/** Menu Overlay **/
	if (typeof hitsxyz_params != 'undefined' && hitsxyz_params.menu_overlay == 1) {
		$('.hits-header .hits-menu').on('mouseenter', function(){
			$('.hits-header').addClass('menu-background-overlay');
		}).on('mouseleave', function(){
			$('.hits-header').removeClass('menu-background-overlay');
		});
	}

	$('.icon-menu-sticky-header .icon').on('click', function(){
		if ($(this).hasClass('active')) {
			$('header .header-bottom').css('display', '');
		} else {
			$('header .header-bottom').fadeIn('fast');
		}
		$(this).toggleClass('active');
		hits_mega_menu_change_state();
	});

	/** Device - Resize action **/
	$(window).on('resize orientationchange', function(){
		hits_mega_menu_change_state();
	});

	/* Tab Mobile Menu */
	$('.tab-mobile-menu li').on('click', function(){
		$('#group-icon-header li.parent, #group-icon-header .hits-menu-drop-icon').removeClass('active');
		$('#group-icon-header ul.sub-menu, #group-icon-header .mobile-menu-wrapper').css('overflow', '');
		$('#group-icon-header ul.sub-menu').css('z-index', '');
		if ($(this).attr('id') == 'main-menu') {
			$('.tab-vertical-menu').css('display', 'none');
			$('.tab-menu-mobile').css('display', 'block');
			$('#main-menu').addClass('active');
			$('#vertical-menu').removeClass('active');
		}
		else if ($(this).attr('id') == 'vertical-menu') {
			$('.tab-menu-mobile').css('display', 'none');
			$('.tab-vertical-menu').css('display', 'block');
			$('#vertical-menu').addClass('active');
			$('#main-menu').removeClass('active');
		}
		$('#group-icon-header .menu-title span').text($(this).text());
	});

	/** To Top button **/
	$(window).on('scroll', function(){
		if ($(this).scrollTop() > 100) {
			$('#to-top').addClass('on');
		} else {
			$('#to-top').removeClass('on');
		}
	});

	$('#to-top .scroll-button').on('click', function(){
		$('body,html').animate({
			scrollTop: '0px'
		}, 1000);
		return false;
	});

	/** Quickshop **/
	$(document).on('click', 'a.quickshop', function(e){
		e.preventDefault();

		var product_id = $(this).data('product_id');
		if (product_id === undefined) {
			return;
		}

		var container = $('#hits-quickshop-modal');
		container.addClass('loading');
		container.find('.quickshop-content').html('');
		$.ajax({
			type: 'POST'
			, url: hitsxyz_params.ajax_url
			, data: { action: 'hitsxyz_load_quickshop_content', product_id: product_id }
			, success: function(response){
				container.find('.quickshop-content').html(response);

				setTimeout(function(){
					container.removeClass('loading').addClass('show');
					$('body').addClass('opening-quickshop');
				}, container.find('.product-type-variable').length ? 500 : 100);

				var $target = container.find('.woocommerce-product-gallery.images');

				if (typeof $.fn.flexslider == 'function') {
					var options = $.extend({
						selector: '.woocommerce-product-gallery__wrapper > .woocommerce-product-gallery__image', /* in target */
						start: function(){
							$target.css('opacity', 1);
						},
						after: function(slider){
							quickshop_init_zoom(container.find('.woocommerce-product-gallery__image').eq(slider.currentSlide), $target);
						}
					}, hitsxyz_params.flexslider);

					$target.flexslider(options);

					container.find('.woocommerce-product-gallery__wrapper .woocommerce-product-gallery__image:eq(0) .wp-post-image').one('load', function(){
						var $image = $(this);

						if ($image) {
							setTimeout(function(){
								var setHeight = $image.closest('.woocommerce-product-gallery__image').height();
								var $viewport = $image.closest('.flex-viewport');

								if (setHeight && $viewport) {
									$viewport.height(setHeight);
								}
							}, 100);
						}
					}).each(function(){
						if (this.complete) {
							$(this).trigger('load');
						}
					});
				}
				else {
					$target.css('opacity', 1);
				}

				quickshop_init_zoom(container.find('.woocommerce-product-gallery__image').eq(0), $target);

				$target.on('woocommerce_gallery_reset_slide_position', function(){
					if (typeof $.fn.flexslider == 'function') {
						$target.flexslider(0);
					}
				});

				$target.on('woocommerce_gallery_init_zoom', function(){
					quickshop_init_zoom(container.find('.woocommerce-product-gallery__image').eq(0), $target);
				});

				container.find('form.variations_form').wc_variation_form();
				container.find('form.variations_form .variations select').change();
				$('body').trigger('wc_fragments_loaded');

				container.find('form.variations_form').on('click', '.reset_variations', function(){
					$(this).parents('.variations').find('.hits-product-attribute .option').removeClass('selected');
				});
			}
		});
	});

	function quickshop_init_zoom(zoomTarget, $target) {
		if (typeof $.fn.zoom != 'function') {
			return;
		}

		var galleryWidth = $target.width(), zoomEnabled = false;

		$(zoomTarget).each(function(index, target){
			var image = $(target).find('img');

			if (image.attr('data-large_image_width') > galleryWidth) {
				zoomEnabled = true;
				return false;
			}
		});

		/* But only zoom if the img is larger than its container. */
		if (zoomEnabled) {
			var zoom_options = $.extend({
				touch: false
			}, hitsxyz_params.zoom_options);

			if ('ontouchstart' in document.documentElement) {
				zoom_options.on = 'click';
			}

			zoomTarget.trigger('zoom.destroy');
			zoomTarget.zoom(zoom_options);

			setTimeout(function(){
				if (zoomTarget.find(':hover').length) {
					zoomTarget.trigger('mouseover');
				}
			}, 100);
		}
	}

	if ($('a.quickshop').length && typeof $.position != 'undefined' && typeof $.position.scrollbarWidth != 'undefined') {
		var quickshop_css = '<style type="text/css">';
		quickshop_css += 'body.opening-quickshop{padding-right: ' + $.position.scrollbarWidth() + 'px;}';
		quickshop_css += 'body.opening-quickshop .is-sticky .header-sticky{width: calc(100% - ' + $.position.scrollbarWidth() + 'px);}';
		quickshop_css += '</style>';
		$('head').append(quickshop_css);
	}

	$(document).on('click', '.hits-popup-modal .close, .hits-popup-modal .overlay', function(){
		$('.hits-popup-modal').removeClass('show');
		$('.hits-popup-modal .quickshop-content').html(''); /* prevent conflict with lightbox on single product */
		$('body').removeClass('opening-quickshop');
	});

	/** Wishlist **/
	$(document).on('click', '.add_to_wishlist, .product a.compare:not(.added)', function(){
		$(this).addClass('loading');
	});

	$('body').on('added_to_wishlist', function(){
		hits_update_tini_wishlist();
		$('.add_to_wishlist').removeClass('loading');
		$('.yith-wcwl-wishlistaddedbrowse.show, .yith-wcwl-wishlistexistsbrowse.show').parent('.button-in.wishlist').addClass('added');
	});

	$('body').on('removed_from_wishlist added_to_cart', function(){
		if ($('.wishlist_table').length) {
			hits_update_tini_wishlist();
		}
	});

	/** Compare **/
	$('body').on('yith_woocompare_open_popup', function(){
		$('.product a.compare').removeClass('loading');
	});

	/*** Color Swatch ***/
	$(document).on('click', '.products .product .color-swatch > div', function(){
		$(this).siblings().removeClass('active');
		$(this).addClass('active');
		/* Change thumbnail */
		var image_src = $(this).data('thumb');
		$(this).closest('.product').find('figure img:first').attr('src', image_src).removeAttr('srcset sizes');
		/* Change price */
		var term_id = $(this).data('term_id');
		var variable_prices = $(this).parent().siblings('.variable-prices');
		var price_html = variable_prices.find('[data-term_id="' + term_id + '"]').html();
		$(this).closest('.product').find('.meta-wrapper .price').html(price_html).addClass('variation-price');
	});

	/*** Product Stock - Variable Product ***/
	function single_variable_product_reset_stock(wrapper) {
		var stock_html = wrapper.find('.availability').data('original');
		var classes = wrapper.find('.availability').data('class');
		if (classes == '') {
			classes = 'in-stock';
		}
		wrapper.find('.availability .availability-text').html(stock_html);
		wrapper.find('.availability').removeClass('in-stock out-of-stock').addClass(classes);
	}

	$(document).on('found_variation', 'form.variations_form', function(e, variation){
		var wrapper = $(this).parents('.summary');
		if (wrapper.find('.single_variation .stock').length > 0) {
			var stock_html = wrapper.find('.single_variation .stock').html();
			var classes = wrapper.find('.single_variation .stock').hasClass('out-of-stock') ? 'out-of-stock' : 'in-stock';
			wrapper.find('.availability .availability-text').html(stock_html);
			wrapper.find('.availability').removeClass('in-stock out-of-stock').addClass(classes);
		}
		else {
			single_variable_product_reset_stock(wrapper);
		}
		
		if( typeof variation.discount_percent != 'undefined' && variation.discount_percent ){
			wrapper.find('.hits-discount-percent').removeClass('hidden');
			wrapper.find('.hits-discount-percent span').html(variation.discount_percent);
		}
		else{
			wrapper.find('.hits-discount-percent').addClass('hidden');
		}
	});

	$(document).on('reset_image', 'form.variations_form', function(){
		var wrapper = $(this).parents('.summary');
		single_variable_product_reset_stock(wrapper);
		
		wrapper.find('.hits-discount-percent').addClass('hidden');
	});

	/*** Variation attribute ***/
	$(document).on('change', '.product form.variations_form .variations select', function(){
		var data = $(this).val();
		var dataAttr = (data.length > 0) ? $(this).find('option[value="' + data + '"]').text() : '';
		var attributes = $(this).parents('tr');
		var html = $('<span class="hits-value"></span>').text(dataAttr);

		attributes.find('> .label .hits-value').remove();
		attributes.find('> .label').append(html);
	});

	$('.product form.variations_form .variations select').trigger('change');


	/*** Variation price ***/
	$(document).on('found_variation', 'form.variations_form', function(e, variation){
		var summary = $(this).parents('.summary');
		if (variation.price_html) {
			summary.find('.hits-variation-price').html(variation.price_html).removeClass('hidden');
			summary.find('p.price').addClass('hidden');
		}
	});

	$(document).on('reset_image', 'form.variations_form', function(){
		var summary = $(this).parents('.summary');
		summary.find('p.price').removeClass('hidden');
		summary.find('.hits-variation-price').addClass('hidden');
	});

	/*** Hide product attribute if not available ***/
	$(document).on('update_variation_values', 'form.variations_form', function(){
		if ($(this).find('.hits-product-attribute').length > 0) {
			$(this).find('.hits-product-attribute').each(function(){
				var attr = $(this);
				var values = [];
				attr.siblings('select').find('option').each(function(){
					if ($(this).attr('value')) {
						values.push($(this).attr('value'));
					}
				});
				attr.find('.option').removeClass('hidden');
				attr.find('.option').each(function(){
					if ($.inArray($(this).attr('data-value'), values) == -1) {
						$(this).addClass('hidden');
					}
				});
			});
		}
	});

	/*** Single ajax add to cart ***/
	if (typeof hitsxyz_params != 'undefined' && hitsxyz_params.ajax_add_to_cart == 1 && !$('body').hasClass('woocommerce-cart')) {
		$(document).on('submit', '.product:not(.product-type-external) .summary form.cart', function(e){
			e.preventDefault();

			var form = $(this);
			var product_url = form.attr('action');
			var data = form.serialize();
			if (!form.hasClass('variations_form') && !form.hasClass('grouped_form')) {
				data += '&add-to-cart=' + form.find('[name="add-to-cart"]').val()
			}
			form.find('.single_add_to_cart_button').removeClass('added').addClass('loading');
			$.post(product_url, data, function(result){
				$(document.body).trigger('wc_fragment_refresh');
				var message_wrapper = $('#hits-ajax-add-to-cart-message');
				var error = '';
				result = $('<div>' + result + '</div>');
				if (result.find('.woocommerce-error').length) { /* WooCommerce < 8.5 */
					error = result.find('.woocommerce-error li:first').html();
				}
				if( result.find('.woocommerce-notices-wrapper .is-error').length ){
					error = result.find('.woocommerce-notices-wrapper .wc-block-components-notice-banner__content:first').html();
				}
				form.find('.single_add_to_cart_button').removeClass('loading').addClass('added');
				message_wrapper.removeClass('error');
				if (error) {
					message_wrapper.addClass('error');
					message_wrapper.find('.error-message').html(error);
					form.find('.single_add_to_cart_button').removeClass('added');
				}

				message_wrapper.addClass('show');
				setTimeout(function(){
					message_wrapper.removeClass('show');
				}, 2000);
			});
		});
	}

	/*** Buy Now ***/
	$(document).on('click', '.hits-buy-now-button', function(e){
		e.preventDefault();
		var cart_form = $(this).parents('.summary').find('form.cart');
		if( cart_form.length ){
			if( !$(this).hasClass('disabled') ){
				$(document).off('submit', '.product:not(.product-type-external) .summary form.cart'); /* disable ajax add to cart */
				cart_form.append('<input type="hidden" name="hits_buy_now" value="1" />');
			}
			cart_form.find('.single_add_to_cart_button').trigger('click');
		}
	});
	
	$(document).on('found_variation', 'form.variations_form', function(){
		$(this).parents('.summary').find('.hits-buy-now-button').removeClass('disabled');
	});
	
	$(document).on('reset_image', 'form.variations_form', function(){
		$(this).parents('.summary').find('.hits-buy-now-button').addClass('disabled');
	});

	/*** Custom Orderby on Product Page ***/
	$('form.woocommerce-ordering ul.orderby ul a').on('click', function(e){
		e.preventDefault();
		if ($(this).hasClass('current')) {
			return;
		}
		var form = $('form.woocommerce-ordering');
		var data = $(this).attr('data-orderby');
		form.find('select.orderby').val(data).trigger('change');
	});

	/*** Per page on Product page ***/
	$('form.product-per-page-form ul.perpage ul a').on('click', function(e){
		e.preventDefault();

		if ($(this).hasClass('current')) {
			return;
		}
		var form = $(this).parents('form.product-per-page-form');
		var data = $(this).attr('data-perpage');

		form.find('select.perpage').val(data);
		form.submit();
	});
	
	/* Grid/List Toggle */
	$('.gridlist-toggle span').on('click', function(){
		var style = $(this).data('style');
		$(this).addClass('active').siblings().removeClass('active');
		$('.woocommerce.main-products').removeClass('grid list').addClass( style );
	});

	/*** Quantity on shop page ***/
	$(document).on('change', '.products .product input[name="quantity"]', function(){
		var add_to_cart_button = $(this).parents('.product').find('.add_to_cart_button');
		var quantity = parseInt($(this).val());
		add_to_cart_button.attr('data-quantity', quantity);
		/* For non ajax */
		var href = '?add-to-cart=' + add_to_cart_button.eq(0).attr('data-product_id') + '&quantity=' + quantity;
		add_to_cart_button.attr('href', href);
	});

	/*** Widget toggle ***/
	$('.widget-title-wrapper a.block-control').on('click', function(e){
		e.preventDefault();
		$(this).toggleClass('active');
		$(this).parent().siblings(':not(script)').fadeToggle(200);
	});

	hits_widget_toggle();
	if (!on_touch) {
		$(window).on('resize', function(){
			hits_widget_toggle();
		});
	}
	
	/*** Set Top Shop Elements ***/
	$(window).on('resize hits_set_top_shop_elements', function(){
		var top = 0;
		top += $('.is-sticky .header-sticky').length ? $('.is-sticky .header-sticky').height() : 0;
		top += $('#wpadminbar').length ? $('#wpadminbar').height() : 0;
		
		if( $('.before-loop-wrapper').length ){
			$('.before-loop-wrapper').css( 'top', $(window).width() < 768 ? top : '' );
			
			if( $('.collapse-scroll-sidebar').length ){
				var padding_top = $(window).width() > 767 ? ( $('.before-loop-wrapper').height() + parseInt( $('.before-loop-wrapper').css('margin-bottom') ) ) + 'px' : '';
				$('.collapse-scroll-sidebar').css( 'padding-top', padding_top );
			}
		}

		if( $('.collapse-scroll-sidebar .hits-sidebar > aside').length ){
			top += 30;
			$('.hits-sidebar > aside').css( 'top', top );
		}
		
		/* Product Detail - Grid Scrolling */
		if( $('div.product.gallery-layout-grid div.summary').length ){
			top += 30;
			$('div.product.gallery-layout-grid div.summary').css( 'top', top );
		}
	});
	
	$(window).trigger('hits_set_top_shop_elements');
	
	/*** Sort by toggle ***/
	$('.woocommerce-ordering li .orderby-current, .product-per-page-form li .perpage-current').on('click', function(e){
		$(this).siblings('.dropdown').fadeToggle(200);
		$(this).toggleClass('active');
		$(this).parent().parent().toggleClass('active');
		var type = $(this).hasClass('orderby-current') ? 'perpage' : 'orderby';
		hide_orderby_per_page_dropdown(type);
	});

	function hide_orderby_per_page_dropdown(type) {
		if (type == 'orderby') {
			var selector = $('.woocommerce-ordering li .orderby-current');
		}
		else if (type == 'perpage') {
			var selector = $('.product-per-page-form li .perpage-current');
		}
		else {
			var selector = $('.woocommerce-ordering li .orderby-current, .product-per-page-form li .perpage-current');
		}
		selector.siblings('.dropdown').fadeOut(200);
		selector.removeClass('active');
		selector.parent().parent().removeClass('active');
	}

	/* Image Lazy Load */
	function lazyload_slider_middle_navigation_position( img ){
		if( img.parents('.swiper').length && !img.parents('.swiper.lazy-recalc-nav-pos').length && img.parents('.swiper-slide-active').length ){
			img.parents('.swiper').addClass('lazy-recalc-nav-pos');
			$(window).trigger('hits_slider_middle_navigation_position', [img.parents('.swiper')]);
			img.on('load', function(){ /* recalc if image is not loaded */
				$(window).trigger('hits_slider_middle_navigation_position', [img.parents('.swiper')]);
			});
		}
	}
	
	if ($('img.hits-lazy-load').length) {
		$(window).on('scroll hits_lazy_load', function(){
			var scroll_top = $(this).scrollTop();
			var window_height = $(this).height();
			$('img.hits-lazy-load:not(.loaded)').each(function(){
				if ($(this).data('src') && $(this).offset().top < scroll_top + window_height + 900) {
					$(this).attr('src', $(this).data('src')).addClass('loaded');
					lazyload_slider_middle_navigation_position( $(this) );
				}
			});
		});

		setTimeout(function(){
			if ($('img.hits-lazy-load:first').offset().top < $(window).scrollTop() + $(window).height() + 200) {
				$(window).trigger('hits_lazy_load');
			}
		}, 100);
	}

	/* WooCommerce Quantity Increment */
	$(document).on('click', '.plus, .minus', function(){
		var $qty = $(this).closest('.quantity').find('.qty'),
			currentVal = parseFloat($qty.val()),
			max = parseFloat($qty.attr('max')),
			min = parseFloat($qty.attr('min')),
			step = $qty.attr('step');

		if (!currentVal || currentVal === '' || currentVal === 'NaN') currentVal = 0;
		if (max === '' || max === 'NaN') max = '';
		if (min === '' || min === 'NaN') min = 0;
		if (step === 'any' || step === '' || step === undefined || parseFloat(step) === 'NaN') step = 1;

		if ($(this).is('.plus')) {
			if (max && (max == currentVal || currentVal > max)) {
				$qty.val(max);
			} else {
				$qty.val(currentVal + parseFloat(step));
			}
		} else {
			if (min && (min == currentVal || currentVal < min)) {
				$qty.val(min);
			} else if (currentVal > 0) {
				$qty.val(currentVal - parseFloat(step));
			}
		}

		$qty.trigger('change');
	});

	/* Ajax Search */
	if (typeof hitsxyz_params != 'undefined' && hitsxyz_params.ajax_search == 1) {
		hits_ajax_search();
	}
	/* Shopping Cart Sidebar */
	$(document).on('click', '.search-button .icon, .shopping-cart-wrapper .cart-control', function(e){
		$('.hits-floating-sidebar .close').trigger('click');
		var is_cart = $(this).is('.cart-control');
		if (is_cart) {
			if ($('#hits-shopping-cart-sidebar').length) {
				e.preventDefault();
				$('#hits-shopping-cart-sidebar').addClass('active');
				$('body').addClass('floating-sidebar-active');
			}
		}
		else if ($('#hits-search-sidebar').length) {
			$('#hits-search-sidebar').addClass('active');
			$('body').addClass('floating-sidebar-active');
			setTimeout(function(){
				$('#hits-search-sidebar input[name="s"]').focus();
			}, 600);

			/* Reset search header */
			$('body').removeClass('search-active');
		}
		else if ($('.header-template .hits-search-by-category').length) {
			$('body').toggleClass('search-active');
			setTimeout(function(){
				$('.header-template .hits-search-by-category input[name="s"]').focus();
			}, 600);
		}
	});

	$(document).on('click', '.hits-search-by-category .close', function(e){
		/* Reset search header */
		$('body').removeClass('search-active');
	});

	$('.hits-floating-sidebar .overlay, .hits-floating-sidebar .close').on('click', function(){
		$('.hits-floating-sidebar').removeClass('active');
		$('body').removeClass('floating-sidebar-active');

		$('body').removeClass('menu-mobile-active');
		$('.hits-mobile-icon-toggle .icon').removeClass('active');

		$('.filter-widget-area-button').removeClass('active');
		
		setTimeout(function(){
			$('#main-content').removeClass('show-filter-sidebar');
		}, 400);
		
		update_filter_area_main_content_height();
	});

	/* Add To Cart Effect */
	if (!$('body').hasClass('woocommerce-cart')) {
		$(document.body).on('adding_to_cart', function(e, $button, data){
			if (wc_add_to_cart_params.cart_redirect_after_add == 'no') {
				if (typeof hitsxyz_params != 'undefined' && hitsxyz_params.add_to_cart_effect == 'show_popup' && typeof $button != 'undefined') {
					var product_id = $button.attr('data-product_id');
					var container = $('#hits-add-to-cart-popup-modal');
					container.addClass('adding');
					$.ajax({
						type: 'POST'
						, url: hitsxyz_params.ajax_url
						, data: { action: 'hitsxyz_load_product_added_to_cart', product_id: product_id }
						, success: function(response){
							container.find('.add-to-cart-popup-content').html(response);
							if (container.hasClass('loading')) {
								container.removeClass('loading').addClass('show');
							}
							container.removeClass('adding');
						}
					});
				}
			}
		});

		$(document.body).on('added_to_cart', function(e, fragments, cart_hash, $button){
			/* Show Cart Sidebar */
			if (typeof hitsxyz_params != 'undefined' && hitsxyz_params.show_cart_after_adding == 1) {
				$('.shopping-cart-wrapper .cart-control').trigger('click');
				return;
			}
			/* Cart Fly Effect */
			if (typeof hitsxyz_params != 'undefined' && typeof $button != 'undefined') {
				if (hitsxyz_params.add_to_cart_effect == 'fly_to_cart') {
					var cart = $('.shopping-cart-wrapper');
					if (cart.length == 2) {
						if ($(window).width() > 767) {
							cart = $('.shopping-cart-wrapper.hidden-phone');
						}
						else {
							cart = $('.shopping-cart-wrapper.mobile-cart');
						}
					}
					if (cart.length == 1) {
						var product_img = $button.closest('section.product').find('figure img').eq(0);
						if (product_img.length == 1) {
							var effect_time = 800;
							var cart_in_sticky = $('.is-sticky .shopping-cart-wrapper').length;
							if (cart_in_sticky) {
								effect_time = 500;
							}

							var imgclone_height = product_img.width() ? 150 * product_img.height() / product_img.width() : 150;
							var imgclone_small_height = product_img.width() ? 60 * product_img.height() / product_img.width() : 60;

							var imgclone = product_img.clone().offset({ top: product_img.offset().top, left: product_img.offset().left })
								.css({ 'opacity': '0.6', 'position': 'absolute', 'height': imgclone_height + 'px', 'width': '150px', 'z-index': '99999999' })
								.appendTo($('body'))
								.animate({ 'top': cart.offset().top + cart.height() / 2, 'left': cart.offset().left + cart.width() / 2, 'width': 60, 'height': imgclone_small_height }, effect_time, 'linear');

							if (!cart_in_sticky) {
								$('body,html').animate({
									scrollTop: '0px'
								}, effect_time);
							}

							imgclone.animate({
								'width': 0
								, 'height': 0
							}, function(){
								$(this).detach()
							});
						}
					}
				}
				if (hitsxyz_params.add_to_cart_effect == 'show_popup') {
					var container = $('#hits-add-to-cart-popup-modal');
					if (container.hasClass('adding')) {
						container.addClass('loading');
					}
					else {
						container.addClass('show');
					}
				}
			}
		});
	}

	/* Show cart after removing item */
	$(document.body).on('click', '.shopping-cart-wrapper .remove_from_cart_button', function(){
		$(this).parents('.shopping-cart-wrapper').addClass('updating');
	});
	$(document.body).on('removed_from_cart', function(){
		if ($('.shopping-cart-wrapper.updating').length && !$('.shopping-cart-wrapper.updating').is(':hover')) {
			$('.shopping-cart-wrapper').removeClass('updating');
		}
	});

	/* Change cart item quantity */
	$(document).on('change', '.hits-tiny-cart-wrapper .qty', function(){
		var qty = parseFloat($(this).val());
		var max = parseFloat($(this).attr('max'));
		if (max !== 'NaN' && max < qty) {
			qty = max;
			$(this).val(max);
		}
		var cart_item_key = $(this).attr('name').replace('cart[', '').replace('][qty]', '');
		$(this).parents('.woocommerce-mini-cart-item').addClass('loading');
		$(this).parents('.shopping-cart-wrapper').addClass('updating');
		$('.woocommerce-message').remove();
		$.ajax({
			type: 'POST'
			, url: hitsxyz_params.ajax_url
			, data: { action: 'hitsxyz_update_cart_quantity', qty: qty, cart_item_key: cart_item_key }
			, success: function(response){
				if (!response) {
					return;
				}
				$(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash]);
				if ($('.shopping-cart-wrapper.updating').length && !$('.shopping-cart-wrapper.updating').is(':hover')) {
					$('.shopping-cart-wrapper').removeClass('updating');
				}
			}
		});
	});

	$(document).on('mouseleave', '.shopping-cart-wrapper.updating', function(){
		$(this).removeClass('updating');
	});

	/* Filter Widget Area */
	var filter_sidebar_interval = 0;
	function update_filter_area_main_content_height() {
		if (!$('#hits-filter-widget-area').length || $('#main-content').hasClass('style-dropdown') || $('#main-content').hasClass('style-floating-sidebar')) {
			return;
		}

		if ($('#hits-filter-widget-area').hasClass('active')) {
			filter_sidebar_interval = setInterval(function(){
				$('#main-content').css('min-height', $('#hits-filter-widget-area .filter-widget-area').height() + ( $('.before-loop-wrapper').length ? $('.before-loop-wrapper').outerHeight(true) : 0 ) + 20);
			}, 1000);
		}
		else {
			clearInterval(filter_sidebar_interval);
			$('#main-content').css('min-height', '');
		}
	}

	update_filter_area_main_content_height();

	$('.filter-widget-area-button a, .filter-widget-area-button + .overlay').on('click', function(){
		var is_overlay = $(this).hasClass('overlay');
		var is_active = $('.filter-widget-area-button').hasClass('active');
		
		$('#hits-filter-widget-area, .hits-sidebar').toggleClass('active');
		
		setTimeout(function(){
			$('#main-content').toggleClass('show-filter-sidebar');
		}, is_overlay ? 400 : 0);
		
		setTimeout(function(){
			$('.filter-widget-area-button').toggleClass('active');
		}, is_active ? 0 : 400);
		
		update_filter_area_main_content_height();

		hide_orderby_per_page_dropdown('both');
		return false;
	});

	/* Product On Sale Checkbox */
	$('.product-on-sale-form input[type="checkbox"]').on('change', function(){
		$(this).parents('form').submit();
	});

	/* Single post - Related posts - Gallery slider */
	hits_single_related_post_gallery_slider();

	/* Single Product - Variable Product options */
	$(document).on('click', '.variations_form .hits-product-attribute .option a', function(){
		var _this = $(this);
		var val = _this.closest('.option').data('value');
		var selector = _this.closest('.hits-product-attribute').siblings('select');
		if (selector.length > 0) {
			if (selector.find('option[value="' + val + '"]').length > 0) {
				selector.val(val).change();
				_this.closest('.hits-product-attribute').find('.option').removeClass('selected');
				_this.closest('.option').addClass('selected');
			}
		}
		return false;
	});

	$('.variations_form').on('click', '.reset_variations', function(){
		$(this).closest('.variations').find('.hits-product-attribute .option').removeClass('selected');
	});

	/* Related - Upsell - Crosssell products slider */
	$('.single-product .related .products, .single-product .upsells .products, .woocommerce .cross-sells .products').each(function(index, element){
		if ($(element).find('> *').length > 1) {
			var _this = $(this);
			var unique_class = 'swiper-theme-' + Math.floor(Math.random() * 10000) + '-' + index;

			_this.addClass('swiper ' + unique_class);
			_this.find('> *').addClass('swiper-slide');
			_this.wrapInner('<div class="swiper-wrapper"></div>');
			_this.append('<div class="swiper-button-prev"></div><div class="swiper-button-next"></div>');

			if ($('body').hasClass('rtl')) {
				_this.attr('dir', 'rtl');
			}

			new Swiper('.' + unique_class, {
				loop: true
				, navigation: {
					nextEl: '.swiper-button-next'
					, prevEl: '.swiper-button-prev'
				}
				, breakpointsBase: 'container'
				, breakpoints: {
					0: {
						slidesPerView: 1
					},
					305: {
						slidesPerView: 2
					},
					650: {
						slidesPerView: 3
					},
					960: {
						slidesPerView: 4
					}
				}
				,on: {
					init: function(){
						$(window).trigger('hits_slider_middle_navigation_position', [_this]);
					}
					,resize: function(){
						$(window).trigger('hits_slider_middle_navigation_position', [_this]);
					}
				}
			});
		}
	});

	/** Widget woocommerce nav link */
	$(document).on('click', '.woocommerce-widget-layered-nav-list .woocommerce-widget-layered-nav-list__item span.count', function(){
		$(this).prev('a')[0].click();
	});

	/** Add placeholder for login form */
	$('#hits-login-form #user_login').attr('placeholder', hitsxyz_params.placeholder_form.usernamePlaceholder);
	$('#hits-login-form #user_pass').attr('placeholder', hitsxyz_params.placeholder_form.passwordPlaceholder);

});

/*** Mega menu ***/
var hits_mega_menu_timeout = 0;
function hits_mega_menu_change_state() {
	if (Math.max(window.outerWidth, jQuery(window).width()) > 767) {

		var padding_left = 0, container_width = 0;
		var container = jQuery('.header-sticky .container:first');
		var container_stretch = jQuery('.header-sticky');
		if (container.length <= 0) {
			container = jQuery('.header-sticky');
			if (container.length <= 0) {
				return;
			}
			container_width = container.outerWidth();
		}
		else {
			container_width = container.width();
			padding_left = parseInt(container.css('padding-left'));
		}
		var container_offset = container.offset();

		var container_stretch_width = container_stretch.outerWidth();
		var container_stretch_offset = container_stretch.offset();

		clearTimeout(hits_mega_menu_timeout);

		hits_mega_menu_timeout = setTimeout(function(){
			jQuery('.hits-menu nav.main-menu > ul.menu > .hits-megamenu-fullwidth').each(function(index, element){
				
				if( jQuery('body.header-v4.header-transparent').length ){
					if( jQuery('.sticky-wrapper').hasClass('is-sticky') ){
						if( !jQuery(element).hasClass('hits-megamenu-fullwidth-stretch') ){
							jQuery(element).addClass('hits-megamenu-fullwidth-stretch no-stretch-content flag-fullwidth-stretch');
						}
					}
					else{
						if( jQuery(element).hasClass('flag-fullwidth-stretch') ){
							jQuery(element).removeClass('hits-megamenu-fullwidth-stretch no-stretch-content flag-fullwidth-stretch');
						}
					}
				}
				
				var current_offset = jQuery(element).offset();
				if (jQuery(element).hasClass('hits-megamenu-fullwidth-stretch')) {
					var left = current_offset.left - container_stretch_offset.left;
					jQuery(element).children('ul.sub-menu').css({ 'width': container_stretch_width + 'px', 'left': -left + 'px', 'right': 'auto' });
				}
				else {
					var left = current_offset.left - container_offset.left - padding_left;
					jQuery(element).children('ul.sub-menu').css({ 'width': container_width + 'px', 'left': -left + 'px', 'right': 'auto' });
				}
			});

			jQuery('.hits-menu nav.main-menu > ul.menu').children('.hits-megamenu-columns-1, .hits-megamenu-columns-2, .hits-megamenu-columns-3, .hits-megamenu-columns-4').each(function(index, element){
				jQuery(element).children('ul.sub-menu').css({ 'max-width': container_width + 'px' });
				var sub_menu_width = jQuery(element).children('ul.sub-menu').outerWidth();
				var item_width = jQuery(element).outerWidth();
				jQuery(element).children('ul.sub-menu').css({ 'left': '-' + (sub_menu_width / 2 - item_width / 2) + 'px', 'right': 'auto' });

				var container_left = container_offset.left;
				var container_right = container_left + container_width;
				var item_left = jQuery(element).offset().left;

				var overflow_left = (sub_menu_width / 2 > (item_left + item_width / 2 - container_left));
				var overflow_right = ((sub_menu_width / 2 + item_left + item_width / 2) > container_right);
				if (overflow_left) {
					var left = item_left - container_left - padding_left;
					jQuery(element).children('ul.sub-menu').css({ 'left': -left + 'px', 'right': 'auto' });
				}
				if (overflow_right && !overflow_left) {
					var left = item_left - container_left - padding_left;
					left = left - (container_width - sub_menu_width);
					jQuery(element).children('ul.sub-menu').css({ 'left': -left + 'px', 'right': 'auto' });
				}
			});

			/* Remove hide class after loading */
			jQuery('ul.menu li.menu-item').removeClass('hide');

		}, 500);
	}
	else { /* Mobile menu action */
		jQuery('#wpadminbar').css('position', 'fixed');

		/* Remove hide class after loading */
		jQuery('ul.menu li.menu-item').removeClass('hide');
	}
}

function hits_mobile_ipad_menu_handle() {
	/* Mobile Menu One Page */
	jQuery('.hits-mobile-icon-toggle .icon').on('click', function(){
		jQuery(this).toggleClass('active');
		jQuery('#group-icon-header').toggleClass('active');
		jQuery('body').toggleClass('menu-mobile-active');

		var position_bottom = jQuery('#group-icon-header .group-button-header').outerHeight();
		jQuery('#group-icon-header .mobile-menu-wrapper').css('margin-bottom', position_bottom);
	});

	/* Main Menu Drop Icon */
	jQuery('.hits-menu nav.main-menu .hits-menu-drop-icon').on('click', function(){

		var is_active = jQuery(this).hasClass('active');
		var sub_menu = jQuery(this).siblings('.sub-menu');

		jQuery('.hits-menu nav.main-menu .hits-menu-drop-icon').removeClass('active');
		jQuery('.hits-menu nav.main-menu .sub-menu').hide();

		jQuery(this).parents('.sub-menu').show();
		jQuery(this).parents('.sub-menu').siblings('.hits-menu-drop-icon').addClass('active');

		/* Reset Dropdown Cart */
		jQuery('header .shopping-cart-wrapper').removeClass('active');

		if (sub_menu.length > 0) {
			if (is_active) {
				sub_menu.fadeOut(250);
				jQuery(this).removeClass('active');
			}
			else {
				sub_menu.fadeIn(250);
				jQuery(this).addClass('active');
			}
		}
	});

	/* Mobile Menu Drop Icon */
	if (jQuery('.hits-menu nav.mobile-menu .hits-menu-drop-icon').length > 0) {
		jQuery('.hits-menu nav.mobile-menu .sub-menu').hide();
	}

	jQuery('.hits-menu.mobile-menu-wrapper .hits-menu-drop-icon').on('click', function(){
		var is_active = jQuery(this).hasClass('active');
		var sub_menu = jQuery(this).siblings('.sub-menu');
		var li_parent = jQuery(this).parent();
		var ul_submenu = jQuery(this).closest('.sub-menu');
		jQuery('#group-icon-header').addClass('not-first-level');

		if (is_active) {
			if (ul_submenu.length) {
				var z_index = ul_submenu.css('z-index');
				z_index = parseInt(z_index) - 1;
				ul_submenu.css('z-index', z_index);
				ul_submenu.css('overflow', 'scroll');
				ul_submenu.css('bottom', '0');
			}
			else {
				jQuery('#group-icon-header .mobile-menu-wrapper').css('overflow', 'auto');
			}

			sub_menu.find('.hits-menu-drop-icon').removeClass('active');
			li_parent.removeClass('active');
			jQuery(this).removeClass('active');

			if (ul_submenu.length == 0) { /* First level */
				var menu_title_back = jQuery('.tab-mobile-menu li.active span').text();
				jQuery('#group-icon-header').removeClass('not-first-level');
			}
			else {
				if (ul_submenu.siblings('a').find('.menu-label').length) {
					var menu_title_back = ul_submenu.siblings('a').find('.menu-label').text();
				}
				else {
					var menu_title_back = ul_submenu.siblings('a').text();
				}
			}
			jQuery('#group-icon-header .menu-title span').text(menu_title_back);
		}
		else {
			if (ul_submenu.length) {
				var z_index = ul_submenu.css('z-index');
				z_index = parseInt(z_index) + 1;
				ul_submenu.css('z-index', z_index);
				ul_submenu.css('overflow', 'hidden');
				ul_submenu.css('bottom', 'auto');
			}
			else {
				jQuery('#group-icon-header .mobile-menu-wrapper').scrollTop(0);
				jQuery('#group-icon-header .mobile-menu-wrapper').css('overflow', 'hidden');
			}
			li_parent.addClass('active');
			jQuery(this).addClass('active');

			if (li_parent.find('> a .menu-label').length) {
				var menu_title = li_parent.find('> a .menu-label').text();
			}
			else {
				var menu_title = li_parent.find('> a').text();
			}

			jQuery('#group-icon-header .menu-title span').text(menu_title);
		}
	});

}

/*** Sticky Menu ***/
function hits_sticky_menu() {
	var top_begin = jQuery('header.hits-header').height() + 300;
	var sub_menu = jQuery('header .main-menu > ul > li > ul.sub-menu');

	setTimeout(function(){
		jQuery('.header-sticky').mysticky({
			topBegin: top_begin
			, scrollOnTop: function(){
				hits_mega_menu_change_state();

				/* RESET MENU STICKY */
				jQuery('header .header-bottom').css('display', '');
				jQuery('.icon-menu-sticky-header .icon').removeClass('active');

				sub_menu.css('display', 'none');
				setTimeout(function(){
					sub_menu.css('display', '');
				}, 500);
				
				jQuery(window).trigger('hits_set_top_shop_elements');
			}
			, scrollOnBottom: function(){
				hits_mega_menu_change_state();

				sub_menu.css('display', 'none');
				setTimeout(function(){
					sub_menu.css('display', '');
				}, 500);
				
				jQuery(window).trigger('hits_set_top_shop_elements');
			}
		});
	}, 200);
}

/*** Custom Wishlist ***/
function hits_update_tini_wishlist() {
	if (typeof hitsxyz_params == 'undefined') {
		return;
	}

	var wishlist_wrapper = jQuery('.my-wishlist-wrapper');
	if (wishlist_wrapper.length == 0) {
		return;
	}

	wishlist_wrapper.addClass('loading');

	jQuery.ajax({
		type: 'POST'
		, url: hitsxyz_params.ajax_url
		, data: { action: 'hitsxyz_update_tini_wishlist' }
		, success: function(response){
			var first_icon = wishlist_wrapper.children('i.fa:first');
			wishlist_wrapper.html(response);
			if (first_icon.length > 0) {
				wishlist_wrapper.prepend(first_icon);
			}
			wishlist_wrapper.removeClass('loading');
		}
	});
}

/*** End Custom Wishlist***/

/*** Widget toggle ***/
function hits_widget_toggle() {
	jQuery('.footer-container .widget-title-wrapper a.block-control').remove();

	if (Math.max(window.outerWidth, jQuery(window).width()) >= 768) {
		jQuery('.widget-title-wrapper a.block-control').removeClass('active').hide();
		jQuery('.widget-title-wrapper a.block-control').parent().siblings(':not(script)').show();
		jQuery('.collapse-scroll-sidebar .widget-title-wrapper').siblings().css('display', '');
	}
	else {
		jQuery('.widget-title-wrapper a.block-control').removeClass('active').show();
		jQuery('.widget-title-wrapper a.block-control').parent().siblings(':not(script)').hide();
		jQuery('.footer-container .widget-title-wrapper').siblings(':not(script)').show();
	}
}

/*** Ajax search ***/
function hits_ajax_search() {
	var search_string = '';
	var search_previous_string = '';
	var search_timeout;
	var search_delay = 700;
	var search_input;
	var search_cache_data = {};
	jQuery('body').append('<div id="hits-search-result-container" class="hits-search-result-container woocommerce"></div>');
	var search_result_container = jQuery('#hits-search-result-container');
	var search_result_container_sidebar = jQuery('#hits-search-sidebar .hits-search-result-container');
	var search_count = jQuery('#hits-search-sidebar .search--header .count');
	var is_sidebar = false;

	jQuery('.hits-header .search-content input[name="s"], #hits-search-sidebar input[name="s"]').on('keyup', function(e){
		is_sidebar = jQuery(this).parents('#hits-search-sidebar').length > 0;
		search_input = jQuery(this);
		search_result_container.hide();

		search_string = jQuery(this).val().trim();
		if (search_string.length < 2) {
			search_input.parents('.search-content').removeClass('loading');
			return;
		}

		if (search_cache_data[search_string]) {
			if (!is_sidebar) {
				search_result_container.html(search_cache_data[search_string][0]);
				search_result_container.fadeIn(200);
			}
			else {
				search_result_container_sidebar.html(search_cache_data[search_string][0]);
				search_count.html(search_cache_data[search_string][1]);
			}
			search_previous_string = '';
			search_input.parents('.search-content').removeClass('loading');

			return;
		}

		clearTimeout(search_timeout);
		search_timeout = setTimeout(function(){
			if (search_string == search_previous_string || search_string.length < 2) {
				return;
			}

			search_previous_string = search_string;

			search_input.parents('.search-content').addClass('loading');

			/* check category */
			var category = '';
			var select_category = search_input.parents('.search-table').siblings('.select-category');
			if (select_category.length > 0) {
				category = select_category.find(':selected').val();
			}

			jQuery.ajax({
				type: 'POST'
				, url: hitsxyz_params.ajax_url
				, data: { action: 'hitsxyz_ajax_search', search_string: search_string, category: category }
				, error: function(xhr, err){
					search_input.parents('.search-content').removeClass('loading');
				}
				, success: function(response){
					if (response != '') {
						response = JSON.parse(response);

						if (response.search_string == search_string) {
							search_cache_data[search_string] = [response.html, response.count];
							if (!is_sidebar) {
								search_result_container.html(response.html);

								var top = search_input.offset().top + search_input.outerHeight(true);

								search_result_container.css({
									'position': 'absolute'
									, 'top': top
								}).fadeIn(200);
							}
							else {
								search_result_container_sidebar.html(response.html);
								search_count.html(response.count);
							}

							search_input.parents('.search-content').removeClass('loading');
						}
					}
					else {
						search_input.parents('.search-content').removeClass('loading');
					}
				}
			});
		}, search_delay);
	});

	jQuery(document).on('click', '.search-content .view-all-wrapper a', function(e){
		e.preventDefault();
		search_input.parents('form').submit();
	});

	search_result_container.on('mouseleave', function(){
		search_result_container.hide();
	});

	jQuery('body').on('click', function(){
		search_result_container.hide();
	});

	jQuery(window).on('orientationchange', function(){
		search_previous_string = '';
		search_cache_data = {};
		search_result_container.hide();
	});

	jQuery('.hits-search-by-category select.select-category').on('change', function(){
		search_previous_string = '';
		search_cache_data = {};
		jQuery(this).parents('.hits-search-by-category').find('.search-content input[name="s"]').trigger('keyup');
	});
}

/*** Single post - Related posts - Gallery slider ***/
function hits_single_related_post_gallery_slider() {
	if (jQuery('.single-post figure.gallery, .list-posts .post-item .gallery figure, .hits-blogs-widget .thumbnail.gallery figure').length > 0) {
		var _this = jQuery('.single-post figure.gallery, .list-posts .post-item .gallery figure, .hits-blogs-widget .thumbnail.gallery figure');

		_this.each(function(index, element){
			if (jQuery(element).find('img').length > 1) {
				var unique_class = 'swiper-theme-' + Math.floor(Math.random() * 10000) + '-' + index;

				jQuery(element).addClass('swiper ' + unique_class);
				jQuery(element).find('> *').addClass('swiper-slide');
				jQuery(element).wrapInner('<div class="swiper-wrapper"></div>');

				jQuery(element).append('<div class="swiper-pagination"></div>');

				/* Right to left */
				if (jQuery('body').hasClass('rtl')) {
					jQuery(element).attr('dir', 'rtl');
				}

				var slider_options = {
					slidesPerView: 1
					, loop: true
					, autoplay: {
						delay: 4000
						, disableOnInteraction: false
						, pauseOnMouseEnter: true
					}
					, pagination: {
						el: ".swiper-pagination"
						, clickable: true
					}
					, effect: 'fade'
					, fadeEffect: {
						crossFade: true
					}
					, breakpointsBase: 'container'
					, spaceBetween: 0
					, simulateTouch: false
					, on: {
						init: function(){
							jQuery(element).removeClass('loading');
							jQuery(element).parent('.gallery').addClass('loaded').removeClass('loading');
						}
					}
				};

				new Swiper('.' + unique_class, slider_options);
			} else {
				jQuery(element).removeClass('loading');
				jQuery(element).parent('.gallery').addClass('loaded').removeClass('loading');
			}
		});
	}

	if (jQuery('.single-post .related-posts.loading').length > 0) {
		var wrapper = jQuery('.single-post .related-posts.loading');
		var blogs = wrapper.find('.blogs');

		if (blogs.find('> *').length <= 1) {
			wrapper.addClass('loaded').removeClass('loading');
			return;
		}

		blogs.addClass('swiper');
		blogs.find('> *').addClass('swiper-slide');
		blogs.wrapInner('<div class="swiper-wrapper"></div>');
		blogs.append('<div class="swiper-button-prev"></div><div class="swiper-button-next"></div>');

		/* Right to left */
		if (jQuery('body').hasClass('rtl')) {
			blogs.attr('dir', 'rtl');
		}

		new Swiper('.single-post .related-posts.loading .swiper', {
			loop: true
			, slidesPerView: 3
			, autoplay: {
				delay: 4000
				, disableOnInteraction: false
				, pauseOnMouseEnter: true
			}
			, navigation: {
				nextEl: '.swiper-button-next'
				, prevEl: '.swiper-button-prev'
			}
			, breakpointsBase: 'container'
			, breakpoints: {
				0: { slidesPerView: 1 }
				, 700: { slidesPerView: 2 }
				, 1200: { slidesPerView: 3 }
			}
			, on: {
				init: function(){
					wrapper.addClass('loaded').removeClass('loading');
				}
			}
		});
	}
}