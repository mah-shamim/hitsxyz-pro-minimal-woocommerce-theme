<?php 
/*** Activate Theme ***/
function hitsxyz_theme_activation(){
	global $pagenow;
	if( is_admin() && 'themes.php' == $pagenow && isset($_GET['activated']) )
	{
		if( get_option( 'woocommerce_single_image_width' ) === false ){
			/* Single Image */
			update_option('woocommerce_single_image_width', 1000);
			
			/* Thumbnail Image */
			update_option('woocommerce_thumbnail_image_width', 450);
			update_option('woocommerce_thumbnail_cropping', 'custom');
			update_option('woocommerce_thumbnail_cropping_custom_width', 450);
			update_option('woocommerce_thumbnail_cropping_custom_height', 572);
		}
		
		if( get_option( 'yith_woocompare_image_size' ) === false ){
			update_option( 'yith_woocompare_image_size', array( 'width' => '450', 'height' => '572', 'crop' => 1 ) );
		}
		
		$elementor_cpt_support = get_option( 'elementor_cpt_support', array( 'page', 'post' ) );
		if( !in_array( 'hits_footer_block', $elementor_cpt_support ) ){
			$elementor_cpt_support[] = 'hits_footer_block';
		}
		if( !in_array( 'hits_mega_menu', $elementor_cpt_support ) ){
			$elementor_cpt_support[] = 'hits_mega_menu';
		}
		update_option( 'elementor_cpt_support', $elementor_cpt_support );
	}
}
add_action('admin_init', 'hitsxyz_theme_activation');

/*** Theme Setup ***/
function hitsxyz_theme_setup(){
	/* Add editor-style.css file*/
	add_editor_style();
	
	/* Add Theme Support */
	add_theme_support( 'post-formats', array( 'audio', 'gallery', 'quote', 'video' ) );		
	
	add_theme_support( 'post-thumbnails' );
	
	add_theme_support( 'automatic-feed-links' );
	
	add_theme_support( 'title-tag' );
	
	add_theme_support( 'custom-header' );
	
	$defaults = array(
		'default-color'         => ''
		,'default-image'        => ''
	);
	add_theme_support( 'custom-background', $defaults );
	
	add_theme_support( 'woocommerce' );
	
	add_theme_support( 'wc-product-gallery-slider' );

	remove_theme_support( 'widgets-block-editor' );
	
	if ( ! isset( $content_width ) ){ $content_width = 1200; }
	
	/* Translation */
	load_theme_textdomain( 'hitsxyz', get_template_directory() . '/languages' );
	
	/* Register Menu Location */
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Navigation', 'hitsxyz' ),
	) );
	register_nav_menus( array(
		'vertical' => esc_html__( 'Vertical Navigation', 'hitsxyz' ),
	) );
	register_nav_menus( array(
		'mobile' => esc_html__( 'Mobile Navigation', 'hitsxyz' ),
	) );
	register_nav_menus( array(
		'top_header' => esc_html__( 'Top Header Navigation', 'hitsxyz' ),
	) );
}
add_action( 'after_setup_theme', 'hitsxyz_theme_setup');

add_action('init', 'hitsxyz_support_wc_product_gallery_lightbox', 20);
function hitsxyz_support_wc_product_gallery_lightbox(){
	$theme_options = hitsxyz_get_theme_options();
	
	if( $theme_options['hits_prod_cloudzoom'] ){
		add_theme_support( 'wc-product-gallery-zoom' );
	}
	if( $theme_options['hits_prod_lightbox'] ){
		add_theme_support( 'wc-product-gallery-lightbox' );
	}

	$enable_slider_on_mobile = $theme_options['hits_prod_thumbnails_slider_mobile'] && wp_is_mobile();
	if( $theme_options['hits_prod_gallery_layout'] == 'grid' && !$enable_slider_on_mobile ){
		remove_theme_support( 'wc-product-gallery-slider' );
	}
}

/*** Add Image Size ***/
function hitsxyz_add_image_size(){
	add_image_size('hitsxyz_menu_icon_thumb', (int) hitsxyz_get_theme_options('hits_menu_thumb_width'), (int) hitsxyz_get_theme_options('hits_menu_thumb_height'), true);
	
	add_image_size('hitsxyz_blog_thumb', 1174, 862, true);
	
	add_image_size('hitsxyz_product_cat', 310, 310, true);

	add_image_size('hitsxyz_product_cat_icon', 80, 80, true);
}
add_action('init', 'hitsxyz_add_image_size');

add_filter('subcategory_archive_thumbnail_size', 'hitsxyz_product_categories_thumbnail_size');
function hitsxyz_product_categories_thumbnail_size(){
	return 'hitsxyz_product_cat';
}

/*** Get Theme Version ***/
function hitsxyz_get_theme_version(){
	$theme = wp_get_theme();
	if( $theme->parent() ){
		return $theme->parent()->get('Version');
	}
	else{
		return $theme->get('Version');
	}
}

/*** Register Front End Scripts  ***/
function hitsxyz_register_scripts(){
	$theme_version = hitsxyz_get_theme_version();

	wp_enqueue_style( 'font-awesome-5', get_template_directory_uri() . '/css/fontawesome.min.css', array(), $theme_version );
	
	wp_enqueue_style( 'font-tb-icons', get_template_directory_uri() . '/css/tb-icons.min.css', array(), $theme_version );
	
	wp_enqueue_style( 'hitsxyz-reset', get_template_directory_uri() . '/css/reset.css', array(), $theme_version );
	
	wp_enqueue_style( 'hitsxyz-style', get_stylesheet_uri(), array(), $theme_version );
	
	if( hitsxyz_load_dokan_style() ){
		wp_enqueue_style( 'hitsxyz-dokan', get_template_directory_uri() . '/css/dokan.css', array(), $theme_version );
	}
	
	wp_enqueue_style( 'hitsxyz-responsive', get_template_directory_uri() . '/css/responsive.css', array(), $theme_version );
	
	wp_enqueue_style( 'swiper', get_template_directory_uri() . '/css/swiper-bundle.min.css', array(), $theme_version );
	
	if( hitsxyz_get_theme_options('hits_enable_rtl') ){
		wp_enqueue_style( 'hitsxyz-rtl', get_template_directory_uri() . '/css/rtl.css', array(), $theme_version );
		wp_enqueue_style( 'hitsxyz-rtl-responsive', get_template_directory_uri() . '/css/rtl-responsive.css', array(), $theme_version );
	}
	
	if( hitsxyz_enable_loading_screen() ){
		wp_enqueue_script( 'hitsxyz-loading-screen', get_template_directory_uri() . '/js/loading-screen.js', array('jquery'), $theme_version, false );
		wp_localize_script( 'hitsxyz-loading-screen', 'hits_loading_screen_opt', array('loading_image' => hitsxyz_get_loading_screen_image()) );
	}
	
	wp_enqueue_script( 'wc-cart-fragments' );
	
	wp_enqueue_script( 'swiper', get_template_directory_uri() . '/js/swiper-bundle.min.js', array(), $theme_version, true );
		
	wp_enqueue_script( 'hitsxyz-script', get_template_directory_uri() . '/js/main.js', array('jquery'), $theme_version, true );
	
	if( wp_is_mobile() && hitsxyz_get_theme_options('hits_add_to_cart_effect') == 'fly_to_cart' ){
		hitsxyz_change_theme_options('hits_add_to_cart_effect', '');
	}
	
	if( defined('ICL_LANGUAGE_CODE') ){
		$ajax_url = admin_url('admin-ajax.php?lang='.ICL_LANGUAGE_CODE, 'relative');
	}
	else{
		$ajax_url = admin_url('admin-ajax.php', 'relative');
	}
	
	$script_params = array(
		'ajax_url'					=> $ajax_url
		,'sticky_header'			=> (int)hitsxyz_get_theme_options('hits_enable_sticky_header')
		,'menu_overlay'				=> (int)hitsxyz_get_theme_options('hits_enable_menu_overlay')
		,'ajax_search'				=> (int)hitsxyz_get_theme_options('hits_ajax_search')
		,'show_cart_after_adding'	=> (int)( hitsxyz_get_theme_options('hits_show_shopping_cart_after_adding') && hitsxyz_get_theme_options('hits_shopping_cart_sidebar') )
		,'ajax_add_to_cart'			=> (int)hitsxyz_get_theme_options('hits_prod_ajax_add_to_cart')
		,'add_to_cart_effect'		=> hitsxyz_get_theme_options('hits_add_to_cart_effect')
		,'shop_loading_type'		=> hitsxyz_get_theme_options('hits_prod_cat_loading_type')
		,'flexslider' 				=> apply_filters(
						'hitsxyz_quickshop_product_carousel_options',
						array(
							'rtl'             => is_rtl()
							,'animation'      => 'slide'
							,'smoothHeight'   => true
							,'directionNav'   => false
							,'controlNav'     => 'thumbnails'
							,'slideshow'      => false
							,'animationSpeed' => 500
							,'animationLoop'  => false // Breaks photoswipe pagination if true.
							,'allowOneSlide'  => false
						)
					)
		,'zoom_options'				=> apply_filters( 'hitsxyz_quickshop_product_zoom_options', array() )
		,'placeholder_form'			=> array(
								'usernamePlaceholder'	=> esc_html__( 'Username or email address*', 'hitsxyz' )
								,'passwordPlaceholder'	=> esc_html__( 'Password*', 'hitsxyz' )
		)
	);
	
	wp_localize_script( 'hitsxyz-script', 'hitsxyz_params', $script_params );
	
	if( is_singular('product') ){
		wp_enqueue_script( 'hitsxyz-single-product', get_template_directory_uri() . '/js/single-product.js', array('jquery'), $theme_version, true );
	}
	
	wp_register_script( 'threesixty', get_template_directory_uri() . '/js/threesixty.js', array(), $theme_version, true );
	
	if( !wp_is_mobile() && hitsxyz_get_theme_options('hits_smooth_scroll') ){
		wp_enqueue_script( 'smooth-scroll', get_template_directory_uri() . '/js/SmoothScroll.min.js', array(), $theme_version, true );
	}
	
	if( hitsxyz_get_theme_options('hits_enable_sticky_header') ){
		wp_enqueue_script( 'jquery-sticky', get_template_directory_uri() . '/js/jquery.sticky.js', array(), $theme_version, true );
	}
	
	if( ( is_tax( get_object_taxonomies( 'product' ) ) || is_post_type_archive('product') ) && hitsxyz_get_theme_options('hits_prod_cat_loading_type') != 'default' ){
		wp_enqueue_script( 'hitsxyz-shop-load-more', get_template_directory_uri() . '/js/shop-load-more.js', array(), $theme_version, true );
	}
	
	if( is_singular() && comments_open() && get_option( 'thread_comments' ) ){ 	
		wp_enqueue_script( 'comment-reply' );
	}
	
	/* Load default google fonts */
	if( !class_exists('ReduxFramework') ){
		wp_enqueue_style( 'hitsxyz-google-fonts', '//fonts.googleapis.com/css?family=Inter:400,700' );
	}
	
	/* Custom JS */
	if( $custom_js = hitsxyz_get_theme_options('hits_custom_javascript_code') ){
		wp_add_inline_script( 'hitsxyz-script', trim( $custom_js ) );
	}
}
add_action('wp_enqueue_scripts', 'hitsxyz_register_scripts', 1000);

/* Loading Screen */
function hitsxyz_enable_loading_screen(){
	global $post;
	$theme_options = hitsxyz_get_theme_options();
	if( empty($theme_options['hits_loading_screen']) ){
		return false;
	}
	
	$enabled = false;
	
	$loading_screen_in = $theme_options['hits_display_loading_screen_in'];
	switch( $loading_screen_in ){
		case 'all-pages':
			if( is_page() ){
				$exclude_pages = !empty($theme_options['hits_loading_screen_exclude_pages'])?$theme_options['hits_loading_screen_exclude_pages']:array();
				if( isset($post->ID) && !in_array($post->ID, $exclude_pages) ){
					$enabled = true;
				}
			}
			else{
				$enabled = true;
			}
		break;
		case 'homepage-only':
			if( is_home() || is_front_page() ){
				$enabled = true;
			}
		break;
		case 'specific-pages':
			if( is_page() ){
				$specific_pages = !empty($theme_options['hits_loading_screen_specific_pages'])?$theme_options['hits_loading_screen_specific_pages']:array();
				if( isset($post->ID) && in_array($post->ID, $specific_pages) ){
					$enabled = true;
				}
			}
		break;
	}

	return apply_filters('hitsxyz_enable_loading_screen', $enabled);
}

function hitsxyz_get_loading_screen_image(){
	$theme_options = hitsxyz_get_theme_options();
	$loading_image = $theme_options['hits_custom_loading_image']['url'];
	if( !$loading_image ){
		$loading_image = get_template_directory_uri() . '/images/loading/loading_' . $theme_options['hits_loading_image'] . '.svg';
	}
	return $loading_image;
}

function hitsxyz_get_last_save_theme_options(){
	$transients = get_option('hitsxyz_theme_options-transients', array());
	if( isset($transients['last_save']) ){
		return $transients['last_save'];
	}
	return time();
}

function hitsxyz_register_custom_style(){
	$upload_dir = wp_get_upload_dir();
	$theme_name = strtolower(str_replace(' ', '', wp_get_theme()->get('Name')));
	$filename = trailingslashit($upload_dir['baseurl']) . $theme_name . '.css';
	$filename_dir = trailingslashit($upload_dir['basedir']) . $theme_name . '.css';

	$custom_css = hitsxyz_get_theme_options('hits_custom_css_code');
	if( file_exists( $filename_dir ) ){ 
		wp_enqueue_style( 'hitsxyz-dynamic-css', $filename, array(), hitsxyz_get_last_save_theme_options() );
		if( $custom_css ){
			wp_add_inline_style( 'hitsxyz-dynamic-css', $custom_css );
		}
	}
	else{
		ob_start();
		include_once get_template_directory() . '/framework/dynamic_style.php';
		$dynamic_css = ob_get_contents();
		ob_end_clean();
		wp_add_inline_style( 'hitsxyz-style', $dynamic_css );
		if( $custom_css ){
			wp_add_inline_style( 'hitsxyz-style', $custom_css );
		}
	}
}
add_action('wp_enqueue_scripts', 'hitsxyz_register_custom_style', 9999);

/* Add font style to compare popup - can not use wp_enqueue_scripts hook */
if( isset($_GET['action']) && $_GET['action'] == 'yith-woocompare-view-table' ){
	add_action('wp_print_styles', 'hitsxyz_add_font_style_to_compare_popup', 1000);
}
function hitsxyz_add_font_style_to_compare_popup(){
	wp_enqueue_style( 'redux-google-fonts-hitsxyz_theme_options' ); /* hitsxyz_theme_options is the variable/key of theme options, so it has to use _ */
	wp_enqueue_style( 'hitsxyz-reset' );
	wp_enqueue_style( 'hitsxyz-style' );
	wp_enqueue_style( 'font-awesome-5' );
	wp_enqueue_style( 'font-tb-icons' );
	if( hitsxyz_get_theme_options('hits_enable_rtl') ){
		wp_enqueue_style( 'hitsxyz-rtl' );
	}
	wp_enqueue_style( 'hitsxyz-dynamic-css' );
}

/*** Register Back End Scripts ***/
function hitsxyz_register_admin_scripts(){
	$theme_version = hitsxyz_get_theme_version();
	
	wp_enqueue_media();
	
	wp_enqueue_style( 'font-awesome-5', get_template_directory_uri() . '/css/fontawesome.min.css', array(), $theme_version );
	
	wp_enqueue_style( 'hitsxyz-admin-style', get_template_directory_uri() . '/css/admin_style.css', array(), $theme_version );
	
	wp_enqueue_script( 'hitsxyz-admin-script', get_template_directory_uri() . '/js/admin_main.js', array('jquery'), $theme_version, true );
	
	$admin_texts = array(
		'select_images' 			=> esc_html__('Select Images', 'hitsxyz')
		,'use_images' 				=> esc_html__('Use images', 'hitsxyz')
		,'choose_an_image' 			=> esc_html__('Choose an image', 'hitsxyz')
		,'use_image' 				=> esc_html__('Use image', 'hitsxyz')
		,'delete_sidebar_confirm' 	=> esc_html__('Do you want to delete this sidebar?', 'hitsxyz')
		,'delete_sidebar_failed' 	=> esc_html__('Cant delete the sidebar. Please try again!', 'hitsxyz')
	);
	wp_localize_script('hitsxyz-admin-script', 'hitsxyz_admin_texts', $admin_texts);
}
add_action('admin_enqueue_scripts', 'hitsxyz_register_admin_scripts');

/*** Global Page Options ***/
if( !function_exists('hitsxyz_set_global_page_options') ){
	function hitsxyz_set_global_page_options( $page_id = 0 ){
		global $hitsxyz_page_options;
		$post_custom = get_post_custom( $page_id );
		if( !is_array($post_custom) ){
			$post_custom = array();
		}
		foreach( $post_custom as $key => $value ){
			if( isset($value[0]) ){
				$hitsxyz_page_options[$key] = $value[0];
			}
		}
		
		$default_options = array(
							'hits_layout_fullwidth'					=> 'default'
							,'hits_header_layout_fullwidth'			=> 1
							,'hits_main_content_layout_fullwidth'		=> 1
							,'hits_footer_layout_fullwidth'			=> 1
							,'hits_layout_style'						=> 'default'
							,'hits_page_layout'						=> '0-1-0'
							,'hits_left_sidebar'						=> ''
							,'hits_right_sidebar'						=> ''
							,'hits_header_layout'						=> 'default'
							,'hits_header_transparent'				=> 0
							,'hits_header_text_color'					=> 'default'
							,'hits_menu_id'							=> 0
							,'hits_breadcrumb_layout'					=> 'default'
							,'hits_breadcrumb_bg_parallax'			=> 'default'
							,'hits_bg_breadcrumbs'					=> ''
							,'hits_logo'								=> ''
							,'hits_logo_mobile'						=> ''
							,'hits_logo_sticky'						=> ''
							,'hits_show_breadcrumb'					=> 1
							,'hits_show_page_title'					=> 1
							,'hits_page_slider'						=> 0
							,'hits_page_slider_position'				=> 'before_main_content'
							,'hits_rev_slider'						=> 0
							,'hits_footer_block'						=> 0
						);
		$hitsxyz_page_options = array_merge($default_options, (array) $hitsxyz_page_options);
		return $hitsxyz_page_options;
	}
}

if( !function_exists('hitsxyz_get_page_options') ){
	function hitsxyz_get_page_options( $key = '', $default = '' ){
		global $hitsxyz_page_options;
		if( !$key ){
			return $hitsxyz_page_options;
		}
		else if( isset($hitsxyz_page_options[$key]) ){
			return $hitsxyz_page_options[$key];
		}
		else{
			return $default;
		}
	}
}

/*** Top Header Menu ***/
if( !function_exists('hitsxyz_top_header_menu') ){
	function hitsxyz_top_header_menu(){
		if( has_nav_menu( 'top_header' ) ){
			do_action('hitsxyz_before_top_header_menu');
			wp_nav_menu( array( 'container' => 'nav', 'container_class' => 'top-header-menu', 'theme_location' => 'top_header', 'depth' => 1 ) );
			do_action('hitsxyz_after_top_header_menu');
		}
	}
}

/*** Get excerpt ***/
if( !function_exists ('hitsxyz_string_limit_words') ){
	function hitsxyz_string_limit_words($string, $word_limit){
		$words = explode(' ', $string, ($word_limit + 1));
		if( count($words) > $word_limit ){
			array_pop($words);
		}
		return implode(' ', $words);
	}
}

if( !function_exists ('hitsxyz_the_excerpt_max_words') ){
	function hitsxyz_the_excerpt_max_words( $word_limit = -1, $post = '', $strip_tags = true, $extra_str = '', $echo = true ) {
		if( $post ){
			$excerpt = hitsxyz_get_the_excerpt_by_id($post->ID);
		}
		else{
			$excerpt = get_the_excerpt();
		}
			
		if( !is_array($strip_tags) && $strip_tags ){
			$excerpt = wp_strip_all_tags($excerpt);
			$excerpt = strip_shortcodes($excerpt);
		}
		
		if( is_array($strip_tags) ){
			$excerpt = wp_kses($excerpt, $strip_tags); // allow, not strip
		}
			
		if( $word_limit != -1 ){
			$result = hitsxyz_string_limit_words($excerpt, $word_limit);
			if( $result != $excerpt ){
				$result .= $extra_str;
			}
		}	
		else{
			$result = $excerpt;
		}
			
		if( $echo ){
			echo do_shortcode($result);
		}
		return $result;
	}
}

if( !function_exists('hitsxyz_get_the_excerpt_by_id') ){
	function hitsxyz_get_the_excerpt_by_id( $post_id = 0 )
	{
		global $wpdb;
		$query = "SELECT post_excerpt, post_content FROM $wpdb->posts WHERE ID = %d LIMIT 1";
		$result = $wpdb->get_results( $wpdb->prepare($query, $post_id), ARRAY_A );
		if( $result[0]['post_excerpt'] ){
			return $result[0]['post_excerpt'];
		}
		else{
			$content = $result[0]['post_content'];
			if( false !== strpos( $content, '<!--nextpage-->' ) ){
				$pages = explode( '<!--nextpage-->', $content );
				return $pages[0];
			}
			return $content;
		}
	}
}

/* Get User Role */
if( !function_exists('hitsxyz_get_user_role') ){
	function hitsxyz_get_user_role( $user_id ){
		global $wpdb;
		$user = get_userdata( $user_id );
		$capabilities = $user->{$wpdb->prefix . 'capabilities'};
		if( empty($capabilities) ){
			return '';
		}
		if ( !isset( $wp_roles ) ){
			$wp_roles = new WP_Roles();
		}
		foreach ( $wp_roles->role_names as $role => $name ) {
			if ( array_key_exists( $role, $capabilities ) ) {
				return $role;
			}
		}
		return '';
	}
}

/*** Page Layout Columns Class ***/
if( !function_exists('hitsxyz_page_layout_columns_class') ){
	function hitsxyz_page_layout_columns_class($page_column, $left_sidebar_name = '', $right_sidebar_name = ''){
		$data = array();
		
		if( empty($page_column) ){
			$page_column = '0-1-0';
		}
		
		$layout_config = explode('-', $page_column);
		$left_sidebar = (int)$layout_config[0];
		$right_sidebar = (int)$layout_config[2];
		
		if( $left_sidebar_name && !is_active_sidebar( $left_sidebar_name ) ){
			$left_sidebar = 0;
		}
		
		if( $right_sidebar_name && !is_active_sidebar( $right_sidebar_name ) ){
			$right_sidebar = 0;
		}
		
		$main_class = ($left_sidebar + $right_sidebar) == 2 ?'has-2-sidebar':( ($left_sidebar + $right_sidebar) == 1 ?'has-1-sidebar':'no-sidebar' );			
		
		$data['left_sidebar'] = $left_sidebar;
		$data['right_sidebar'] = $right_sidebar;
		$data['main_class'] = $main_class;
		
		return $data;
	}
}

/*** Show Page Slider ***/
function hitsxyz_show_page_slider(){
	$page_options = hitsxyz_get_page_options();
	switch( $page_options['hits_page_slider'] ){
		case 'revslider':
			if( class_exists('RevSliderSlider') && $page_options['hits_rev_slider'] ){
				echo do_shortcode('[rev_slider alias="'.$page_options['hits_rev_slider'].'"]');
			}
		break;
		default:
		break;
	}
}

/*** Breadcrumbs ***/
if( !function_exists('hitsxyz_breadcrumbs') ){
	function hitsxyz_breadcrumbs(){
		$delimiter_char = '&#47;';
		if( class_exists('WooCommerce') ){
			if( function_exists('woocommerce_breadcrumb') && function_exists('is_woocommerce') && is_woocommerce() ){
				woocommerce_breadcrumb(array('wrap_before'=>'<div class="breadcrumbs"><div class="breadcrumbs-container">','delimiter'=>'<span>'.$delimiter_char.'</span>','wrap_after'=>'</div></div>'));
				return;
			}
		}

		$allowed_html = array(
			'a'		=> array('href' => array(), 'title' => array())
			,'span'	=> array('class' => array())
			,'div'	=> array('class' => array())
		);
		$output = '';

		$delimiter = '<span class="brn_arrow">'.$delimiter_char.'</span>';
		
		$ar_title = array(
					'home'			=> __('Home', 'hitsxyz')
					,'search' 		=> __('Search results for ', 'hitsxyz')
					,'404' 			=> __('Error 404', 'hitsxyz')
					,'tagged' 		=> __('Tagged ', 'hitsxyz')
					,'author' 		=> __('Articles posted by ', 'hitsxyz')
					,'page' 		=> __('Page', 'hitsxyz')
					);
	  
		$before = '<span class="current">'; /* tag before the current crumb */
		$after = '</span>'; /* tag after the current crumb */
		global $wp_rewrite, $post;
		$rewriteUrl = $wp_rewrite->using_permalinks();
		if( !is_home() && !is_front_page() || is_paged() ){
			$output .= '<div class="breadcrumbs"><div class="breadcrumbs-container">';
	 
			$homeLink = esc_url( home_url('/') ); 
			$output .= '<a href="' . $homeLink . '">' . $ar_title['home'] . '</a> ' . $delimiter . ' ';
	 
			if( is_category() ){
				global $wp_query;
				$cat_obj = $wp_query->get_queried_object();
				$thisCat = $cat_obj->term_id;
				$thisCat = get_category($thisCat);
				$parentCat = get_category($thisCat->parent);
				if( $thisCat->parent != 0 ){ 
					$output .= get_category_parents($parentCat, true, ' ' . $delimiter . ' ');
				}
				$output .= $before . single_cat_title('', false) . $after;
			}
			elseif( is_search() ){
				$output .= $before . $ar_title['search'] . '"' . get_search_query() . '"' . $after;
			}elseif( is_day() ){
				$output .= '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
				$output .= '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
				$output .= $before . get_the_time('d') . $after;
			}elseif( is_month() ){
				$output .= '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
				$output .= $before . get_the_time('F') . $after;
			}elseif( is_year() ){
				$output .= $before . get_the_time('Y') . $after;
			}elseif( is_single() && !is_attachment() ){
				if( get_post_type() != 'post' ){
					$post_type = get_post_type_object(get_post_type());
					$slug = $post_type->rewrite;
					$post_type_name = $post_type->labels->singular_name;
					if( $rewriteUrl ){
						$output .= '<a href="' . $homeLink . $slug['slug'] . '/' . '">' . $post_type_name . '</a> ' . $delimiter . ' ';
					}else{
						$output .= '<a href="' . $homeLink . '?post_type=' . get_post_type() . '">' . $post_type_name . '</a> ' . $delimiter . ' ';
					}
					$output .= $before . get_the_title() . $after;
			    }else{
					$cat = get_the_category(); $cat = $cat[0];
					$output .= get_category_parents($cat, true, ' ' . $delimiter . ' ');
					$output .= $before . get_the_title() . $after;
			    }
			}elseif( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ){
				$post_type = get_post_type_object(get_post_type());
				$slug = $post_type->rewrite;
				$post_type_name = $post_type->labels->singular_name;
				if( is_tag() ){
					$output .= $before . $ar_title['tagged'] . '"' . single_tag_title('', false) . '"' . $after;
				}
				elseif( is_taxonomy_hierarchical(get_query_var('taxonomy')) ){			
					if( $rewriteUrl ){
						$output .= '<a href="' . $homeLink . $slug['slug'] . '/' . '">' . $post_type_name . '</a> ' . $delimiter . ' ';
					}else{
						$output .= '<a href="' . $homeLink . '?post_type=' . get_post_type() . '">' . $post_type_name . '</a> ' . $delimiter . ' ';
					}			
					
					$curTaxanomy = get_query_var('taxonomy');
					$curTerm = get_query_var( 'term' );
					$termNow = get_term_by( 'name', $curTerm, $curTaxanomy );
					$pushPrintArr = array();
					if( $termNow !== false ){
						while( (int)$termNow->parent != 0 ){
							$parentTerm = get_term((int)$termNow->parent,get_query_var('taxonomy'));
							array_push($pushPrintArr,'<a href="' . get_term_link((int)$parentTerm->term_id,$curTaxanomy) . '">' . $parentTerm->name . '</a> ' . $delimiter . ' ');
							$curTerm = $parentTerm->name;
							$termNow = get_term_by( 'name', $curTerm, $curTaxanomy );
						}
					}
					$pushPrintArr = array_reverse($pushPrintArr);
					array_push($pushPrintArr,$before  . get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) )->name  . $after);
					$output .= implode($pushPrintArr);
				}else{
					$output .= $before . $post_type_name . $after;
				}
			}elseif( is_attachment() ){
				if( (int)$post->post_parent > 0 ){
					$parent = get_post($post->post_parent);
					$cat = get_the_category($parent->ID);
					if( count($cat) > 0 ){
						$cat = $cat[0];
						$output .= get_category_parents($cat, true, ' ' . $delimiter . ' ');
					}
					$output .= '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
				}
				$output .= $before . get_the_title() . $after;
			}elseif( is_page() && !$post->post_parent ){
				$output .= $before . get_the_title() . $after;
			}elseif( is_page() && $post->post_parent ){
				$parent_id  = $post->post_parent;
				$breadcrumbs = array();
				while( $parent_id ){
					$page = get_post($parent_id);
					$breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
					$parent_id  = $page->post_parent;
			    }
				$breadcrumbs = array_reverse($breadcrumbs);
				foreach( $breadcrumbs as $crumb ){
					$output .= $crumb . ' ' . $delimiter . ' ';
				}
				$output .= $before . get_the_title() . $after;
			}elseif( is_tag() ){
				$output .= $before . $ar_title['tagged'] . '"' . single_tag_title('', false) . '"' . $after;
			}elseif( is_author() ){
				global $author;
				$userdata = get_userdata($author);
				$output .= $before . $ar_title['author'] . $userdata->display_name . $after;
			}elseif( is_404() ){
				$output .= $before . $ar_title['404'] . $after;
			}
			if( get_query_var('paged') || get_query_var('page') ){
				if( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() || is_page_template() ||  is_post_type_archive() || is_archive() ){ 
					$output .= $before .' ('; 
				}
				$output .= $ar_title['page'] . ' ' . ( get_query_var('paged')?get_query_var('paged'):get_query_var('page') );
				if( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() || is_page_template() ||  is_post_type_archive() || is_archive() ){ 
					$output .= ')'. $after; 
				}
			}
			$output .= '</div></div>';
	    }
		
		echo wp_kses($output, $allowed_html);
		
		wp_reset_postdata();
	}
}

if( !function_exists('hitsxyz_breadcrumbs_title') ){
	function hitsxyz_breadcrumbs_title( $show_breadcrumb = false, $show_page_title = false, $page_title = '', $extra_class_title = '' ){
		$theme_options = hitsxyz_get_theme_options();
		if( $show_breadcrumb || $show_page_title ){
			$breadcrumb_bg_option = is_array($theme_options['hits_bg_breadcrumbs'])?$theme_options['hits_bg_breadcrumbs']['url']:$theme_options['hits_bg_breadcrumbs'];
			$breadcrumb_bg = '';
			$classes = array();
			$classes[] = 'breadcrumb-title-wrapper breadcrumb-' . $theme_options['hits_breadcrumb_layout'];
			$classes[] = $show_breadcrumb?'':'no-breadcrumb';
			$classes[] = $show_page_title?'':'no-title';
			if( $theme_options['hits_enable_breadcrumb_background_image'] && in_array( $theme_options['hits_breadcrumb_layout'], array('v3') ) ){
				if( $breadcrumb_bg_option == '' ){ /* No Override */
					$breadcrumb_bg = get_template_directory_uri() . '/images/bg_breadcrumb_'.$theme_options['hits_breadcrumb_layout'].'.jpg';
				}	
				else{
					$breadcrumb_bg = $breadcrumb_bg_option;
				}
			}
			
			$style = '';
			if( $breadcrumb_bg != '' ){
				$style = 'style="background-image: url('. esc_url($breadcrumb_bg) .')"';
				if( $theme_options['hits_breadcrumb_bg_parallax'] ){
					$classes[] = 'hits-breadcrumb-parallax';
				}
			}
			echo '<div class="'.esc_attr(implode(' ', array_filter($classes))).'" '.$style.'><div class="breadcrumb-content"><div class="breadcrumb-title">';
			
			if( $show_page_title ){
				echo '<h1 class="heading-title page-title entry-title ' . $extra_class_title . '">' . $page_title . '</h1>';
			}

			if( $show_breadcrumb ){
				hitsxyz_breadcrumbs();
			}
			
			if( $theme_options['hits_breadcrumb_product_taxonomy_description'] && function_exists('woocommerce_taxonomy_archive_description') ){
				woocommerce_taxonomy_archive_description();
				remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
			}
			
			echo '</div></div></div>';
		}
	}
}

/*** Pagination ***/
if( !function_exists('hitsxyz_pagination') ){
	function hitsxyz_pagination( $query = null, $args = array() ){
		global $wp_query;

		$default_args = array(
			'format'		        =>	''
			,'add_args'		        =>	false
			,'prev_text'	        =>	esc_html__( 'Previous page', 'hitsxyz' )
			,'next_text'	        =>  esc_html__( 'Next page', 'hitsxyz' )
			,'end_size'		        =>	3
			,'mid_size'		        =>	3
			,'prev_next'	        =>	true
			,'paged'		        =>	''
		);

		$args = wp_parse_args( $args, $default_args );

		$max_num_pages = $wp_query->max_num_pages;
		$paged = $wp_query->get( 'paged' );
		if( $query != null ){
			$max_num_pages = $query->max_num_pages;
			$paged = $query->get( 'paged' );
		}
		if( !$paged ){
			$paged = 1;
		}
		?>
		<nav class="hits-pagination">
			<?php
			echo paginate_links( array(
				'base'         	        => esc_url_raw( str_replace( 999999999, '%#%', get_pagenum_link( 999999999, false ) ) )
				,'format'               => $args['format']
				,'add_args'             => $args['add_args']
				,'current'              => $args['paged'] ? $args['paged'] : max( 1, $paged ) 
				,'total'                => $max_num_pages
				,'prev_text'            => $args['prev_text']
				,'next_text'            => $args['next_text']
				,'type'                 => 'list'
				,'end_size'             => $args['end_size']
				,'mid_size'             => $args['mid_size']
				,'prev_next' 	        => $args['prev_next']
			) );
			?>
		</nav>
		<?php
	}
}

/*** Logo ***/
if( !function_exists('hitsxyz_theme_logo') ){
	function hitsxyz_theme_logo(){
		$theme_options = hitsxyz_get_theme_options();
		$logo_image = is_array($theme_options['hits_logo'])?$theme_options['hits_logo']['url']:$theme_options['hits_logo'];
		$logo_image_mobile = is_array($theme_options['hits_logo_mobile'])?$theme_options['hits_logo_mobile']['url']:$theme_options['hits_logo_mobile'];
		$logo_image_sticky = is_array($theme_options['hits_logo_sticky'])?$theme_options['hits_logo_sticky']['url']:$theme_options['hits_logo_sticky'];
		$logo_text = $theme_options['hits_text_logo'];
		
		if( !$logo_image_mobile ){
			$logo_image_mobile = $logo_image;
		}
		if( !$logo_image_sticky ){
			$logo_image_sticky = $logo_image;
		}
		if( !$logo_text ){
			$logo_text = get_bloginfo('name');
		}
		?>
		<div class="logo">
			<a href="<?php echo esc_url( home_url('/') ); ?>">
			<?php if( $logo_image ): ?>
				<img src="<?php echo esc_url($logo_image); ?>" alt="<?php echo esc_attr($logo_text); ?>" title="<?php echo esc_attr($logo_text); ?>" class="normal-logo" />
			<?php endif; ?>
			
			<?php if( $logo_image_mobile ): ?>
				<img src="<?php echo esc_url($logo_image_mobile); ?>" alt="<?php echo esc_attr($logo_text); ?>" title="<?php echo esc_attr($logo_text); ?>" class="mobile-logo" />
			<?php endif; ?>
			
			<?php if( $logo_image_sticky ): ?>
				<img src="<?php echo esc_url($logo_image_sticky); ?>" alt="<?php echo esc_attr($logo_text); ?>" title="<?php echo esc_attr($logo_text); ?>" class="sticky-logo" />
			<?php endif; ?>

			<?php if( !$logo_image ):
				echo esc_html($logo_text);
			endif; ?>
			</a>
		</div>
		<?php
	}
}

/*** Pingback URL ***/
add_action('wp_head', 'hitsxyz_pingback_header');
if( !function_exists('hitsxyz_pingback_header') ){
	function hitsxyz_pingback_header(){
		if( is_singular() && pings_open() ){
		?>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<?php
		}
	}
}

/*** Favicon ***/
if( !function_exists('hitsxyz_theme_favicon') ){
	function hitsxyz_theme_favicon(){
		if( function_exists('wp_site_icon') && function_exists('has_site_icon') && has_site_icon() ){
			return;
		}
		$favicon_option = hitsxyz_get_theme_options('hits_favicon');
		$favicon = is_array($favicon_option)?$favicon_option['url']:$favicon_option;
		if( $favicon ):
		?>
			<link rel="shortcut icon" href="<?php echo esc_url($favicon); ?>" />
		<?php
		endif;
	}
}

/*** Header Template ***/
if( !function_exists('hitsxyz_get_header_template') ){
	function hitsxyz_get_header_template(){
		get_template_part('templates/headers/header', hitsxyz_get_theme_options('hits_header_layout'));
	}
}

if( !function_exists('hitsxyz_get_footer_content') ){
	function hitsxyz_get_footer_content( $footer_block_id = 0 ){
		if( class_exists('Elementor\Plugin') && in_array( 'hits_footer_block', get_option( 'elementor_cpt_support', array() ) ) ){
			echo Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $footer_block_id );
		}
		else{
			$post = get_post( $footer_block_id );
			if( is_object( $post ) ){
				echo do_shortcode( $post->post_content );
			}
		}
	}
}

if( !function_exists('hitsxyz_entry_header_template') ){
	function hitsxyz_entry_header_template( $post, $post_format, $show_blog_thumbnail, $blog_thumb_size ){
		$theme_options = hitsxyz_get_theme_options();
		?>
		<div class="entry-header">
			<?php if( $show_blog_thumbnail ): ?>
				<div class="entry-format">
					<!-- Blog Thumbnail -->
					<?php if( $post_format == 'gallery' || $post_format === false || $post_format == 'standard' ){ ?>
						<figure class="<?php echo ('gallery' == $post_format)?'gallery loading items thumbnail':'thumbnail' ?>">
							<?php 
							
							if( $post_format == 'gallery' ){
								$gallery = get_post_meta($post->ID, 'hits_gallery', true);
								$gallery_ids = explode(',', $gallery);
								if( is_array($gallery_ids) ){
									array_unshift($gallery_ids, get_post_thumbnail_id());
								}
								foreach( $gallery_ids as $gallery_id ){
									echo wp_get_attachment_image( $gallery_id, $blog_thumb_size, 0, array('class' => 'thumbnail-blog') );
								}
							}
						
							if( ($post_format === false || $post_format == 'standard') && !is_singular('hits_feature') ){
								the_post_thumbnail($blog_thumb_size, array('class' => 'thumbnail-blog'));
							}
							
							?>
						</figure>
					<?php 
					}
					
					if( $post_format == 'video' ){
						$video_url = get_post_meta($post->ID, 'hits_video_url', true);
						if( $video_url != '' ){
							echo do_shortcode('[hits_video src="'.esc_url($video_url).'"]');
						}
					}
					
					if( $post_format == 'audio' ){
						$audio_url = get_post_meta($post->ID, 'hits_audio_url', true);
						if( strlen($audio_url) > 4 ){
							$file_format = substr($audio_url, -3, 3);
							if( in_array($file_format, array('mp3', 'ogg', 'wav')) ){
								echo do_shortcode('[audio '.$file_format.'="'.esc_url($audio_url).'"]');
							}
							else{
								echo do_shortcode('[hits_soundcloud url="'.esc_url($audio_url).'" width="100%" height="166"]');
							}
						}
					}
					?>
				</div>
			<?php endif; ?>

		</div>
		<?php
	}
}

/* Ajax search */
add_action( 'wp_ajax_hitsxyz_ajax_search', 'hitsxyz_ajax_search' );
add_action( 'wp_ajax_nopriv_hitsxyz_ajax_search', 'hitsxyz_ajax_search' );
if( !function_exists('hitsxyz_ajax_search') ){
	function hitsxyz_ajax_search(){
		global $wpdb, $post;
		
		$search_for_product = class_exists('WooCommerce');
		if( $search_for_product ){
			$taxonomy = 'product_cat';
			$post_type = 'product';
		}
		else{
			$taxonomy = 'category';
			$post_type = 'post';
		}
		
		$num_result = (int)hitsxyz_get_theme_options('hits_ajax_search_number_result');
		$desc_limit_words = (int)hitsxyz_get_theme_options('hits_prod_cat_desc_words');
		
		$allowed_html = array(
			'ul' => array(
				'class' => array()
			)
			,'ol' => array(
				'class' => array()
			)
			,'li'=> array(
				'class' => array()
			)
		);
		
		$search_string = stripslashes($_POST['search_string']);
		$category = isset($_POST['category'])? $_POST['category']: '';
		
		$args = array(
			'post_type'			=> $post_type
			,'post_status'		=> 'publish'
			,'s'				=> $search_string
			,'posts_per_page'	=> $num_result
			,'tax_query'		=> array()
		);
		
		if( $search_for_product ){
			$args['meta_query'] = WC()->query->get_meta_query();
			$args['tax_query'] = WC()->query->get_tax_query();
		}
		
		if( $category != '' ){
			$args['tax_query'][] = array(
					'taxonomy'  => $taxonomy
					,'terms'	=> $category
					,'field'	=> 'slug'
				);
		}
		
		$results = new WP_Query($args);
		
		if( $results->have_posts() ){
			$extra_class = '';
			
			if( isset($results->post_count, $results->found_posts) && $results->found_posts > $results->post_count ){
				$extra_class = 'has-view-all';
			}
			
			$html = '<ul class="product_list_widget '.$extra_class.'">';
			while( $results->have_posts() ){
				$results->the_post();
				$link = get_permalink($post->ID);
				
				$image = '';
				if( $post_type == 'product' ){
					$product = wc_get_product($post->ID);
					$image = $product->get_image();
					$rating = $product->get_average_rating();
					$count   = $product->get_rating_count();
				}
				else if( has_post_thumbnail($post->ID) ){
					$image = get_the_post_thumbnail($post->ID, 'thumbnail');
				}
				
				$html .= '<li>';
					$html .= '<div class="hits-wg-thumbnail">';
						$html .= '<a href="'.esc_url($link).'">'. $image .'</a>';
					$html .= '</div>';
					$html .= '<div class="hits-wg-meta">';
						$html .= '<a href="'.esc_url($link).'" class="title">'. hitsxyz_search_highlight_string($post->post_title, $search_string) .'</a>';
						$html .= '<div class="description">'. hitsxyz_the_excerpt_max_words($desc_limit_words, '', $allowed_html, '', false) .'</div>';
						if( $post_type == 'product' ){
							if( $price_html = $product->get_price_html() ){
								$html .= '<span class="price">'. $price_html .'</span>';
							}
							if( $rating ){
								$html .= '<span class="rating">'. wc_get_rating_html( $rating, $count ) .'</span>';
							}
						}
					$html .= '</div>';
				$html .= '</li>';
			}
			$html .= '</ul>';
			
			if( isset($results->post_count, $results->found_posts) && $results->found_posts > $results->post_count ){
				$view_all_text = sprintf( esc_html__('View all %d results', 'hitsxyz'), $results->found_posts );
				
				$html .= '<div class="view-all-wrapper">';
					$html .= '<a href="#">'. $view_all_text .'</a>';
				$html .= '</div>';
			}
			
			wp_reset_postdata();
			
			$return = array();
			$html = '<div class="search-content">'.$html.'</div>';
			$return['html'] = $html;
			$return['search_string'] = $search_string;
			$return['count'] = $results->found_posts;
			die( json_encode($return) );
		}
		
		$return = array();
		$return['html'] = '<p>'.esc_html__('No products were found', 'hitsxyz').'</p>';
		$return['search_string'] = $search_string;
		$return['count'] = 0;
		die( json_encode($return) );
	}
}

if( !function_exists('hitsxyz_search_highlight_string') ){
	function hitsxyz_search_highlight_string($string, $search_string){
		$new_string = '';
		$pos_left = stripos($string, $search_string);
		if( $pos_left !== false ){
			$pos_right = $pos_left + strlen($search_string);
			$new_string_right = substr($string, $pos_right);
			$search_string_insensitive = substr($string, $pos_left, strlen($search_string));
			$new_string_left = stristr($string, $search_string, true);
			$new_string = $new_string_left . '<span class="hightlight">' . $search_string_insensitive . '</span>' . $new_string_right;
		}
		else{
			$new_string = $string;
		}
		return $new_string;
	}
}

/* Get post comment count */
if( !function_exists('hitsxyz_get_post_comment_count') ){
	function hitsxyz_get_post_comment_count( $post_id = 0 ){
		global $post;
		if( !$post_id ){
			$post_id = $post->ID;
		}
		
		$comments_count = wp_count_comments($post_id); 
		return $comments_count->approved;
	}
}

/*** Store Notice ***/
if( !function_exists('hitsxyz_store_notices') ){
	function hitsxyz_store_notices(){
		$theme_options = hitsxyz_get_theme_options();
		
		if( $theme_options['hits_header_layout'] != 'v5' ){
			$notices = $theme_options['hits_header_store_notice'];
		}
		else{
			$notices = is_array( $theme_options['hits_header_slide_notice'] ) ? array_filter( $theme_options['hits_header_slide_notice'] ) : array();
		}
		
		if( empty($notices) ){
			return;
		}
		
		echo '<div class="header-store-notice">';
		
		if( is_string($notices) ){
			echo wp_kses($notices, 'hitsxyz_header_text');
		}
		else{
			echo '<div class="noticeMarquee"><div>';
				foreach( $notices as $notice ){
					echo '<p>' . wp_kses($notice, 'hitsxyz_header_text') . '</p>'; 
				}
			echo '</div></div>';
		}
		
		echo '</div>';
	}
}

/* Match with ajax search results */
add_filter('woocommerce_get_catalog_ordering_args', 'hitsxyz_woocommerce_get_catalog_ordering_args_filter');
if( !function_exists('hitsxyz_woocommerce_get_catalog_ordering_args_filter') ){
	function hitsxyz_woocommerce_get_catalog_ordering_args_filter( $args ){
		if( is_search() && !isset($_GET['orderby']) && get_option( 'woocommerce_default_catalog_orderby' ) == 'menu_order' 
			&& hitsxyz_get_theme_options('hits_ajax_search') ){
			$args['orderby'] = '';
			$args['order'] = '';
		}
		return $args;
	}
}

/* Add to cart popup */
add_action('wp_footer', 'hitsxyz_add_to_cart_popup_modal');
function hitsxyz_add_to_cart_popup_modal(){
	if( hitsxyz_get_theme_options('hits_add_to_cart_effect') == 'show_popup' ){
	?>
	<div id="hits-add-to-cart-popup-modal" class="hits-popup-modal">
		<div class="overlay"></div>
		<div class="add-to-cart-popup-container popup-container">
			<span class="close"></span>
			<div class="add-to-cart-popup-content"></div>
		</div>
	</div>
	<?php
	}
}

add_action('wp_ajax_hitsxyz_load_product_added_to_cart', 'hitsxyz_load_product_added_to_cart' );
add_action('wp_ajax_nopriv_hitsxyz_load_product_added_to_cart', 'hitsxyz_load_product_added_to_cart' );
function hitsxyz_load_product_added_to_cart(){
	if( isset($_POST['product_id']) ){
		$product_id = absint($_POST['product_id']);
		$product = wc_get_product( $product_id );
		if( !is_object($product) ){
			die( esc_html__('Invalid Product', 'hitsxyz') );
		}
		ob_start();
		?>
		<div class="heading">
			<h5 class="theme-title"><?php esc_html_e('Product is added to cart', 'hitsxyz'); ?></h5>
		</div>
		<div class="item">
			<div class="product-image">
				<?php echo wp_kses( $product->get_image(), 'hitsxyz_product_image' ); ?>
			</div>
			<div class="product-meta">
				<h3 class="heading-title product-name"><a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="product-name">
					<?php echo esc_html( $product->get_title() ); ?>
				</a></h3>
				<span class="price"><?php echo wp_kses( $product->get_price_html(), 'hitsxyz_product_price' ); ?></span>
			</div>
		</div>
		<div class="action">
			<a href="<?php echo wc_get_cart_url(); ?>" class="button view-cart"><?php esc_html_e('View Cart', 'hitsxyz'); ?></a>
			<a href="<?php echo wc_get_checkout_url(); ?>" class="button checkout"><?php esc_html_e('Checkout', 'hitsxyz'); ?></a>
		</div>
		<?php
		die( ob_get_clean() );
	}
}

/* Single product - Ajax add to cart message */
add_action('wp_footer', 'hitsxyz_ajax_add_to_cart_message');
function hitsxyz_ajax_add_to_cart_message(){
	if( hitsxyz_get_theme_options('hits_prod_ajax_add_to_cart') ){
	?>
		<div id="hits-ajax-add-to-cart-message">
			<span><?php esc_html_e('Product has been added to your cart', 'hitsxyz'); ?></span>
			<span class="error-message"></span>
		</div>
	<?php
	}
}

/* Support Dokan */
function hitsxyz_load_dokan_style(){
	if( !class_exists('WeDevs_Dokan') ){
		return false;
	}
	if( ( function_exists('dokan_is_store_page') && dokan_is_store_page() ) 
		|| ( function_exists('dokan_is_product_edit_page') && dokan_is_product_edit_page() )
		|| ( function_exists('dokan_is_seller_dashboard') && dokan_is_seller_dashboard() )
		|| ( function_exists('dokan_is_store_review_page') && dokan_is_store_review_page() )
		|| ( function_exists('dokan_is_store_listing') && dokan_is_store_listing() )
		|| apply_filters( 'hitsxyz_forced_load_dokan_style', false ) ){
		return true;	
	}
	return false;
}

add_action('dokan_dashboard_wrap_before', 'hitsxyz_dokan_dashboard_wrap_before', 10, 2);
add_action('dokan_edit_product_wrap_before', 'hitsxyz_dokan_dashboard_wrap_before', 10, 2);
function hitsxyz_dokan_dashboard_wrap_before( $post, $post_id ){
	if( isset( $_GET['product_id'] ) ){
		return;
	}
	hitsxyz_breadcrumbs_title(true, true, get_the_title());
	?>
	<div class="page-container show_breadcrumb_<?php echo hitsxyz_get_theme_options('hits_breadcrumb_layout') ?>">
		<div id="main-content">
	<?php
}

add_action('dokan_dashboard_wrap_after', 'hitsxyz_dokan_dashboard_wrap_after', 10, 2);
add_action('dokan_edit_product_wrap_after', 'hitsxyz_dokan_dashboard_wrap_after', 10, 2);
function hitsxyz_dokan_dashboard_wrap_after( $post, $post_id ){
	if( isset( $_GET['product_id'] ) ){
		return;
	}
	?>
		</div>
	</div>
	<?php
}

/* Install Required Plugins */
add_action( 'tgmpa_register', 'hitsxyz_register_required_plugins' );
function hitsxyz_register_required_plugins(){
	$plugin_dir_path = get_template_directory() . '/framework/plugins/';
    $plugins = array(

        array(
            'name'                => 'PlaT'
            ,'slug'               => 'plat'
            ,'source'             => $plugin_dir_path . 'plat.zip'
            ,'required'           => true
            ,'version'            => '1.0.4'
        )
        ,array(
            'name'                => 'Slider Revolution'
            ,'slug'               => 'revslider'
            ,'source'             => 'https://kovatz.com/plugin/revslider.zip'
            ,'required'           => true
        )
		,array(
            'name'                => 'One Click Demo Import'
            ,'slug'               => 'one-click-demo-import'
            ,'required'           => false
        )
		,array(
            'name'                => 'Redux Framework'
            ,'slug'               => 'redux-framework'
            ,'required'           => true
        )
		,array(
            'name'                => 'WooCommerce'
            ,'slug'               => 'woocommerce'
            ,'required'           => true
        )
		,array(
            'name'                => 'Elementor'
            ,'slug'               => 'elementor'
            ,'required'           => true
        )
		,array(
            'name'                => 'Contact Form 7'
            ,'slug'               => 'contact-form-7'
            ,'required'           => true
        )
		,array(
            'name'                => 'MailChimp for WordPress'
            ,'slug'               => 'mailchimp-for-wp'
            ,'required'           => false
        )
		,array(
            'name'                => 'YITH WooCommerce Wishlist'
            ,'slug'               => 'yith-woocommerce-wishlist'
            ,'required'           => true
        )
		,array(
            'name'                => 'YITH WooCommerce Compare'
            ,'slug'               => 'yith-woocommerce-compare'
            ,'required'           => true
        )

    );

    $config = array(
		'id'           	=> 'tgmpa'
		,'default_path' => ''
		,'menu'         => 'tgmpa-install-plugins'
		,'parent_slug'  => 'themes.php'
		,'capability'   => 'edit_theme_options'
		,'has_notices'  => true
		,'dismissable'  => true
		,'dismiss_msg'  => ''
		,'is_automatic' => false
		,'message'      => ''
	);

    tgmpa( $plugins, $config );
}


?>