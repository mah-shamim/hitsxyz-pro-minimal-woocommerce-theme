jQuery(function($){
	"use strict";
	
	var load_more_class = 'hits-shop-load-more';
	var selector = {
		pagination: '.woocommerce-pagination'
		,pagination_button: '.woocommerce-pagination a'
		,next_button: '.woocommerce-pagination a.next'
		,products_container: '#main-content .main-products div.products'
		,product_item: 'section.product'
		,breadcrumb_container: '.breadcrumbs-container'
		,result_count: '.hits-shop-result-count'
		,woo_result_count: '.woocommerce-result-count'
		,load_more_wrapper: '.' + load_more_class
		,load_more_button: '.' + load_more_class + ' .load-more'
	};
	
	var product_is_loading = false;
	var loading_type = typeof hitsxyz_params != 'undefined'?hitsxyz_params.shop_loading_type:'default';
	
	if( loading_type != 'ajax-pagination' ){
		if( $(selector.next_button).length == 0 ){
			return;
		}
		/* Hide pagination */
		$(selector.pagination).hide();
	}
	
	if( 'scrollRestoration' in history ){
		history.scrollRestoration = 'manual';
	}
	
	switch( loading_type ){
		case 'infinity-scroll':
			$(window).on('scroll', function(){
				if( product_is_loading ){
					return;
				}
				var product_bottom = $(selector.products_container).offset().top + $(selector.products_container).height() - 100;
				var window_bottom = $(window).scrollTop() + $(window).height();
				if( product_bottom < window_bottom ){
					hits_load_next_page();
				}
			});
		break;
		case 'load-more-button':
			$(document).on('click', selector.load_more_button, function(){
				if( product_is_loading ){
					return;
				}
				hits_load_next_page();
			});
		break;
		default: /* Ajax Pagination */
			$(document).on('click', selector.pagination_button, function(e){
				e.preventDefault();
				if( product_is_loading ){
					return;
				}
				var href = $(this).attr('href');
				var speed = Math.round( $(selector.products_container).height() / 4 );
				$('html, body').animate({scrollTop: hits_get_scroll_top_position()}, speed).promise().done(function(){
					if( history.pushState ){
						history.pushState(null, null, href);
					}
					hits_load_next_page('replace', href);
				});
			});
			
			$(window).on('popstate', function(){
				setTimeout(function(){
					$('html, body').animate({scrollTop: hits_get_scroll_top_position()}, 500).promise().done(function(){
						hits_load_next_page('replace', location.href);
					});
				});
			});
	}
	
	function hits_get_scroll_top_position(){
		var scroll_top = $('.woocommerce.main-products').offset().top - $('.before-loop-wrapper').outerHeight(true);
		scroll_top -= $('#wpadminbar').length > 0?$('#wpadminbar').height():0;
		scroll_top -= $('.is-sticky .header-sticky').length > 0?$('.is-sticky .header-sticky').height():0;
		return scroll_top;
	}
	
	function hits_load_next_page( action, next_page_href ){
		if( typeof action == 'undefined' ){
			var action = 'append';
		}
		if( typeof next_page_href == 'undefined' ){
			var next_page_href = hits_get_next_page_href();
		}
		if( !next_page_href ){
			return;
		}
		
		product_is_loading = true;
		
		/* Add loading */
		$(selector.load_more_button).addClass('loading');
		$(selector.products_container).addClass('loading');
		
		$.get(next_page_href, function(data){
			var new_page = $('<div>' + data + '</div>');
			new_page.find(selector.product_item).addClass('hidden-item').hide();
			var products = new_page.find(selector.products_container).html();
			if( action == 'append' ){
				$(selector.products_container).append(products);
			}
			else{
				$(selector.products_container).html(products);
				$(selector.breadcrumb_container).html( new_page.find(selector.breadcrumb_container).html() );
				document.title = new_page.find('title').html();
			}
			$(selector.product_item + '.hidden-item').removeClass('hidden-item').fadeIn(1000);
			
			$(selector.result_count).html( new_page.find(selector.result_count).html() );
			$(selector.woo_result_count).html( new_page.find(selector.woo_result_count).html() );
			
			/* Lazy Load */
			$(window).trigger('hits_lazy_load');
			
			$(selector.pagination).replaceWith( new_page.find(selector.pagination) );
			if( action == 'append' ){
				$(selector.pagination).hide();
				if( !hits_get_next_page_href() ){
					$(selector.load_more_wrapper).remove();
				}
			}
			
			product_is_loading = false;
			$(selector.load_more_button).removeClass('loading');
			$(selector.products_container).removeClass('loading');
			
			$(document).trigger('hits_shop_load_more_end', [loading_type]);
		});
	}
	
	function hits_get_next_page_href(){
		if( $(selector.next_button).length > 0 ){
			return $(selector.next_button).attr('href');
		}
		return '';
	}
});