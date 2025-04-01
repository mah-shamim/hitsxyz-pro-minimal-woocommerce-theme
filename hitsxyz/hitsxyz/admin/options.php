<?php
$redux_url = '';
if( class_exists('ReduxFramework') ){
	$redux_url = ReduxFramework::$_url;
}

$logo_url 					= get_template_directory_uri() . '/images/logo.png'; 
$favicon_url 				= get_template_directory_uri() . '/images/favicon.ico';

$color_image_folder = get_template_directory_uri() . '/admin/assets/images/colors/';
$list_colors = array('default','red');
$preset_colors_options = array();
foreach( $list_colors as $color ){
	$preset_colors_options[$color] = array(
					'alt'      => $color
					,'img'     => $color_image_folder . $color . '.jpg'
					,'presets' => hitsxyz_get_preset_color_options( $color )
	);
}

$family_fonts = array(
	"Arial, Helvetica, sans-serif"                          => "Arial, Helvetica, sans-serif"
	,"'Arial Black', Gadget, sans-serif"                    => "'Arial Black', Gadget, sans-serif"
	,"'Bookman Old Style', serif"                           => "'Bookman Old Style', serif"
	,"'Comic Sans MS', cursive"                             => "'Comic Sans MS', cursive"
	,"Courier, monospace"                                   => "Courier, monospace"
	,"Garamond, serif"                                      => "Garamond, serif"
	,"Georgia, serif"                                       => "Georgia, serif"
	,"Impact, Charcoal, sans-serif"                         => "Impact, Charcoal, sans-serif"
	,"'Lucida Console', Monaco, monospace"                  => "'Lucida Console', Monaco, monospace"
	,"'Lucida Sans Unicode', 'Lucida Grande', sans-serif"   => "'Lucida Sans Unicode', 'Lucida Grande', sans-serif"
	,"'MS Sans Serif', Geneva, sans-serif"                  => "'MS Sans Serif', Geneva, sans-serif"
	,"'MS Serif', 'New York', sans-serif"                   => "'MS Serif', 'New York', sans-serif"
	,"'Palatino Linotype', 'Book Antiqua', Palatino, serif" => "'Palatino Linotype', 'Book Antiqua', Palatino, serif"
	,"Tahoma,Geneva, sans-serif"                            => "Tahoma, Geneva, sans-serif"
	,"'Times New Roman', Times,serif"                       => "'Times New Roman', Times, serif"
	,"'Trebuchet MS', Helvetica, sans-serif"                => "'Trebuchet MS', Helvetica, sans-serif"
	,"Verdana, Geneva, sans-serif"                          => "Verdana, Geneva, sans-serif"
	,"CustomFont"                          					=> "CustomFont"
);

$header_layout_options = array();
$header_image_folder = get_template_directory_uri() . '/admin/assets/images/headers/';
for( $i = 1; $i <= 6; $i++ ){
	$header_layout_options['v' . $i] = array(
		'alt'  => sprintf(esc_html__('Header Layout %s', 'hitsxyz'), $i)
		,'img' => $header_image_folder . 'header_v'.$i.'.jpg'
	);
}

$loading_screen_options = array();
$loading_image_folder = get_template_directory_uri() . '/images/loading/';
for( $i = 1; $i <= 10; $i++ ){
	$loading_screen_options[$i] = array(
		'alt'  => sprintf(esc_html__('Loading Image %s', 'hitsxyz'), $i)
		,'img' => $loading_image_folder . 'loading_'.$i.'.svg'
	);
}

$footer_block_options = hitsxyz_get_footer_block_options();

$breadcrumb_layout_options = array();
$breadcrumb_image_folder = get_template_directory_uri() . '/admin/assets/images/breadcrumbs/';
for( $i = 1; $i <= 3; $i++ ){
	$breadcrumb_layout_options['v' . $i] = array(
		'alt'  => sprintf(esc_html__('Breadcrumb Layout %s', 'hitsxyz'), $i)
		,'img' => $breadcrumb_image_folder . 'breadcrumb_v'.$i.'.jpg'
	);
}

$sidebar_options = array();
$default_sidebars = hitsxyz_get_list_sidebars();
if( is_array($default_sidebars) ){
	foreach( $default_sidebars as $key => $_sidebar ){
		$sidebar_options[$_sidebar['id']] = $_sidebar['name'];
	}
}

$product_loading_image = get_template_directory_uri() . '/images/prod_loading.gif';

$mailchimp_forms = array();
$args = array(
	'post_type'			=> 'mc4wp-form'
	,'post_status'		=> 'publish'
	,'posts_per_page'	=> -1
);
$forms = new WP_Query( $args );
if( !empty( $forms->posts ) && is_array( $forms->posts ) ) {
	foreach( $forms->posts as $p ) {
		$mailchimp_forms[$p->ID] = $p->post_title;
	}
}

$option_fields = array();

/*** General Tab ***/
$option_fields['general'] = array(
	array(
		'id'        => 'section-logo-favicon'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Logo - Favicon', 'hitsxyz' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'        => 'hits_logo'
		,'type'     => 'media'
		,'url'      => true
		,'title'    => esc_html__( 'Logo', 'hitsxyz' )
		,'desc'     => ''
		,'subtitle' => esc_html__( 'Select an image file for the main logo', 'hitsxyz' )
		,'readonly' => false
		,'default'  => array( 'url' => $logo_url )
	)
	,array(
		'id'        => 'hits_logo_mobile'
		,'type'     => 'media'
		,'url'      => true
		,'title'    => esc_html__( 'Mobile Logo', 'hitsxyz' )
		,'desc'     => ''
		,'subtitle' => esc_html__( 'Display this logo on mobile', 'hitsxyz' )
		,'readonly' => false
		,'default'  => array( 'url' => '' )
	)
	,array(
		'id'        => 'hits_logo_sticky'
		,'type'     => 'media'
		,'url'      => true
		,'title'    => esc_html__( 'Sticky Logo', 'hitsxyz' )
		,'desc'     => ''
		,'subtitle' => esc_html__( 'Display this logo on sticky header', 'hitsxyz' )
		,'readonly' => false
		,'default'  => array( 'url' => '' )
	)
	,array(
		'id'        => 'hits_logo_menu_mobile'
		,'type'     => 'media'
		,'url'      => true
		,'title'    => esc_html__( 'Mobile Menu Logo', 'hitsxyz' )
		,'desc'     => ''
		,'subtitle' => esc_html__( 'Display this logo on mobile menu', 'hitsxyz' )
		,'readonly' => false
		,'default'  => array( 'url' => '' )
	)
	,array(
		'id'        => 'hits_logo_width'
		,'type'     => 'text'
		,'url'      => true
		,'title'    => esc_html__( 'Logo Width', 'hitsxyz' )
		,'desc'     => ''
		,'subtitle' => esc_html__( 'Set width for logo (in pixels)', 'hitsxyz' )
		,'default'  => '160'
	)
	,array(
		'id'        => 'hits_device_logo_width'
		,'type'     => 'text'
		,'url'      => true
		,'title'    => esc_html__( 'Logo Width on Device', 'hitsxyz' )
		,'desc'     => ''
		,'subtitle' => esc_html__( 'Set width for logo (in pixels)', 'hitsxyz' )
		,'default'  => '120'
	)
	,array(
		'id'        => 'hits_favicon'
		,'type'     => 'media'
		,'url'      => true
		,'title'    => esc_html__( 'Favicon', 'hitsxyz' )
		,'desc'     => ''
		,'subtitle' => esc_html__( 'Select a PNG, GIF or ICO image', 'hitsxyz' )
		,'readonly' => false
		,'default'  => array( 'url' => $favicon_url )
	)
	,array(
		'id'        => 'hits_text_logo'
		,'type'     => 'text'
		,'title'    => esc_html__( 'Text Logo', 'hitsxyz' )
		,'subtitle' => ''
		,'desc'     => ''
		,'default'  => 'Hitsxyz'
	)

	,array(
		'id'        => 'section-layout-style'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Layout Style', 'hitsxyz' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'        => 'hits_layout_fullwidth'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Layout Fullwidth', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => false
	)
	,array(
		'id'        => 'hits_header_layout_fullwidth'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Header Layout Fullwidth', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => false
		,'required'	=> array( 'hits_layout_fullwidth', 'equals', '1' )
	)
	,array(
		'id'        => 'hits_main_content_layout_fullwidth'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Main Content Layout Fullwidth', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => false
		,'required'	=> array( 'hits_layout_fullwidth', 'equals', '1' )
	)
	,array(
		'id'        => 'hits_footer_layout_fullwidth'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Footer Layout Fullwidth', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => false
		,'required'	=> array( 'hits_layout_fullwidth', 'equals', '1' )
	)
	,array(
		'id'       	=> 'hits_layout_style'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Layout Style', 'hitsxyz' )
		,'subtitle' => esc_html__( 'You can override this option for the individual page', 'hitsxyz' )
		,'desc'     => ''
		,'options'  => array(
			'boxed' 	=> 'Boxed'
			,'wide' 	=> 'Wide'
		)
		,'default'  => 'wide'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
		,'required'	=> array( 'hits_layout_fullwidth', 'equals', '0' )
	)
	
	,array(
		'id'        => 'section-rtl'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Right To Left', 'hitsxyz' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'        => 'hits_enable_rtl'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Enable Right To Left', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => false
	)
	
	,array(
		'id'        => 'section-smooth-scroll'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Smooth Scroll', 'hitsxyz' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'        => 'hits_smooth_scroll'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Enable Smooth Scroll', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => false
	)
	
	,array(
		'id'        => 'section-back-to-top-button'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Back To Top Button', 'hitsxyz' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'        => 'hits_back_to_top_button'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Enable Back To Top Button', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => true
	)
	,array(
		'id'        => 'hits_back_to_top_button_on_mobile'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Enable Back To Top Button On Mobile', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => true
	)
	,array(
		'id'        => 'section-page-not-found'
		,'type'     => 'section'
		,'title'    => esc_html__( '404 Page', 'hitsxyz' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'        => 'hits_404_page_image'
		,'type'     => 'media'
		,'url'      => true
		,'title'    => esc_html__( '404 Image', 'hitsxyz' )
		,'desc'     => ''
		,'subtitle' => esc_html__( 'Choose image background for 404 text', 'hitsxyz' )
		,'readonly' => false
		,'default'  => array( 'url' => '' )
	)
	,array( 
		'id'       	=> 'hits_404_page' 
		,'type'     => 'select' 
		,'title'    => esc_html__( '404 Page', 'hitsxyz' ) 
		,'subtitle' => esc_html__( 'Select the page which displays the 404 page', 'hitsxyz' ) 
		,'desc'     => ''
		,'data'     => 'pages'
		,'default'	=> ''
	)
	,array(
		'id'        => 'section-loading-screen'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Loading Screen', 'hitsxyz' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'        => 'hits_loading_screen'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Loading Screen', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => false
	)
	,array(
		'id'        => 'hits_loading_image'
		,'type'     => 'image_select'
		,'title'    => esc_html__( 'Loading Image', 'hitsxyz' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => $loading_screen_options
		,'default'  => '1'
	)
	,array(
		'id'        => 'hits_custom_loading_image'
		,'type'     => 'media'
		,'url'      => true
		,'title'    => esc_html__( 'Custom Loading Image', 'hitsxyz' )
		,'desc'     => ''
		,'subtitle' => ''
		,'readonly' => false
		,'default'  => array( 'url' => '' )
	)
	,array(
		'id'       	=> 'hits_display_loading_screen_in'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Display Loading Screen In', 'hitsxyz' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => array(
			'all-pages' 		=> esc_html__( 'All Pages', 'hitsxyz' )
			,'homepage-only' 	=> esc_html__( 'Homepage Only', 'hitsxyz' )
			,'specific-pages' 	=> esc_html__( 'Specific Pages', 'hitsxyz' )
		)
		,'default'  => 'all-pages'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
	)
	,array(
		'id'       	=> 'hits_loading_screen_exclude_pages'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Exclude Pages', 'hitsxyz' )
		,'subtitle' => ''
		,'desc'     => ''
		,'data'     => 'pages'
		,'multi'    => true
		,'default'	=> ''
		,'required'	=> array( 'hits_display_loading_screen_in', 'equals', 'all-pages' )
	)
	,array(
		'id'       	=> 'hits_loading_screen_specific_pages'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Specific Pages', 'hitsxyz' )
		,'subtitle' => ''
		,'desc'     => ''
		,'data'     => 'pages'
		,'multi'    => true
		,'default'	=> ''
		,'required'	=> array( 'hits_display_loading_screen_in', 'equals', 'specific-pages' )
	)
);

/*** Color Scheme Tab ***/
$option_fields['color-scheme'] = array(
	array(
		'id'          => 'hits_color_scheme'
		,'type'       => 'image_select'
		,'presets'    => true
		,'full_width' => false
		,'title'      => esc_html__( 'Select Color Scheme of Theme', 'hitsxyz' )
		,'subtitle'   => ''
		,'desc'       => ''
		,'options'    => $preset_colors_options
		,'default'    => 'default'
		,'class'      => ''
	)
	,array(
		'id'        => 'section-general-colors'
		,'type'     => 'section'
		,'title'    => esc_html__( 'General Colors', 'hitsxyz' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'      => 'info-primary-colors'
		,'type'   => 'info'
		,'notice' => false
		,'title'  => esc_html__( 'Primary Colors', 'hitsxyz' )
		,'desc'   => ''
	)
	,array(
		'id'       => 'hits_primary_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Primary Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#d10202'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_text_color_in_bg_primary'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Text Color In Background Primary Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'      => 'info-secondary-colors'
		,'type'   => 'info'
		,'notice' => false
		,'title'  => esc_html__( 'Secondary Colors', 'hitsxyz' )
		,'desc'   => ''
	)
	,array(
		'id'       => 'hits_gray_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Gray Text Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#848484'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_gray_bg_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Gray Background Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#efefef'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_text_in_gray_bg_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Text In Gray Background Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#000000'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'      => 'info-main-content-colors'
		,'type'   => 'info'
		,'notice' => false
		,'title'  => esc_html__( 'Main Content Colors', 'hitsxyz' )
		,'desc'   => ''
	)
	,array(
		'id'       => 'hits_main_content_background_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Main Content Background Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Text Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#000000'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_heading_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Heading Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#000000'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_dropdown_bg_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Dropdown/Sidebar Background Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_dropdown_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Dropdown/Sidebar Text Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#000000'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_border_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Border Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ebebeb'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_link_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Link Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#d10202'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_link_color_hover'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Link Color Hover', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#848484'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_icon_hover_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Icon Hover Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#d10202'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_blockquote_icon_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Blockquote Icon Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#959595'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'      => 'info-tags-colors'
		,'type'   => 'info'
		,'notice' => false
		,'title'  => esc_html__( 'Tags Colors', 'hitsxyz' )
		,'desc'   => ''
	)
	,array(
		'id'       => 'hits_tags_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Tags Text Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#848484'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_tags_background_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Tags Background Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_tags_border_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Tags Border Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ebebeb'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'      => 'info-input-colors'
		,'type'   => 'info'
		,'notice' => false
		,'title'  => esc_html__( 'Input Colors', 'hitsxyz' )
		,'desc'   => ''
	)
	,array(
		'id'       => 'hits_input_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Input Text Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#000000'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_input_background_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Input Background Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_input_border_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Input Border Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ebebeb'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'        => 'section-buttons-color'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Buttons Color', 'hitsxyz' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'      => 'info-default-button'
		,'type'   => 'info'
		,'notice' => false
		,'title'  => esc_html__( 'Default Button', 'hitsxyz' )
		,'desc'   => ''
	)
	,array(
		'id'       => 'hits_button_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Button Text Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_button_background_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Button Background Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#000000'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_button_border_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Button Border Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#000000'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_button_text_hover_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Button Text Hover Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_button_background_hover_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Button Background Hover Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#d10202'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_button_border_hover_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Button Border Hover Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#d10202'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'      => 'info-button-thumbnails-colors'
		,'type'   => 'info'
		,'notice' => false
		,'title'  => esc_html__( 'Icon/Buttons On Product Thumbnail Color (quickview, wishlist, compare...)', 'hitsxyz' )
		,'desc'   => ''
	)
	,array(
		'id'       => 'hits_button_thumbnail_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Button Text Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#000000'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_button_thumbnail_bg_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Button Background Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_button_thumbnail_hover_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Button Text Hover Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_button_thumbnail_hover_bg_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Button Background Hover Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#d10202'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'      => 'info-breadcrumb-colors'
		,'type'   => 'info'
		,'notice' => false
		,'title'  => esc_html__( 'Breadcrumb Colors', 'hitsxyz' )
		,'desc'   => ''
	)
	,array(
		'id'       => 'hits_breadcrumb_background_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Breadcrumb Background Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_breadcrumb_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Breadcrumb Text Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#000000'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_breadcrumb_link_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Breadcrumb Link Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#848484'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'        => 'section-header-colors'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Header Colors', 'hitsxyz' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'      => 'info-header-top'
		,'type'   => 'info'
		,'notice' => false
		,'title'  => esc_html__( 'Header Top', 'hitsxyz' )
		,'desc'   => ''
	)
	,array(
		'id'       => 'hits_header_top_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Header Top Text Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_header_top_background_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Header Top Background Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#000000'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_header_top_border_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Header Top Border Color', 'hitsxyz' )
		,'subtitle' => esc_html__( 'Only available on some header layouts', 'hitsxyz' )
		,'default'  => array(
			'color' 	=> '#000000'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_header_top_link_hover_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Header Top Link Hover Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#848484'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_header_top_icon_count_background_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Header Top Cart/Wishlist Count Number Background Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#000000'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_header_top_icon_count_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Header Top Cart/Wishlist Count Number Text Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'      => 'info-header-middle'
		,'type'   => 'info'
		,'notice' => false
		,'title'  => esc_html__( 'Header Middle', 'hitsxyz' )
		,'desc'   => ''
	)
	,array(
		'id'       => 'hits_header_middle_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Header Middle Text Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#000000'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_header_middle_background_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Header Middle Background Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_header_middle_border_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Header Middle Border Color', 'hitsxyz' )
		,'subtitle' => esc_html__( 'Only available on some header layouts', 'hitsxyz' )
		,'default'  => array(
			'color' 	=> '#ebebeb'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_header_middle_link_hover_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Header Middle Link Hover Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#d10202'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_header_icon_count_background_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Header Middle Cart/Wishlist Count Number Background Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#000000'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_header_icon_count_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Header Middle Cart/Wishlist Count Number Text Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'      => 'info-header-bottom'
		,'type'   => 'info'
		,'notice' => false
		,'title'  => esc_html__( 'Header Bottom', 'hitsxyz' )
		,'desc'   => ''
	)
	,array(
		'id'       => 'hits_header_bottom_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Header Bottom Text Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#000000'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_header_bottom_background_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Header Bottom Background Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_header_bottom_border_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Header Bottom Border Color', 'hitsxyz' )
		,'subtitle' => esc_html__( 'Only available on some header layouts', 'hitsxyz' )
		,'default'  => array(
			'color' 	=> '#ebebeb'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_header_bottom_link_hover_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Header Bottom Link Hover Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#d10202'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'        => 'section-footer-colors'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Footer Colors', 'hitsxyz' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'       => 'hits_footer_background_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Footer Background Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_footer_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Footer Text Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#848484'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_footer_link_hover_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Footer Link Hover Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#d10202'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_footer_border_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Footer Border Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#d6d6d6'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'        => 'section-product-colors'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Product Colors', 'hitsxyz' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'       => 'hits_product_price_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Product Price Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#000000'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_product_sale_price_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Product Sale Price Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#959595'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_rating_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Product Rating Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#000000'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'      => 'info-product-label-colors'
		,'type'   => 'info'
		,'notice' => false
		,'title'  => esc_html__( 'Product Label Colors (Style on Product Thumbnail)', 'hitsxyz' )
		,'desc'   => ''
	)
	,array(
		'id'       => 'hits_product_sale_label_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Sale Label Text Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_product_sale_label_background_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Sale Label Background Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#000000'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_product_new_label_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'New Label Text Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_product_new_label_background_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'New Label Background Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffa632'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_product_feature_label_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Feature Label Text Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_product_feature_label_background_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Feature Label Background Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#d10202'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_product_outstock_label_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'OutStock Label Text Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#ffffff'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'       => 'hits_product_outstock_label_background_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'OutStock Label Background Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#919191'
			,'alpha'	=> 1
		)
	)
	,array(
		'id'      => 'info-product-label-meta-colors'
		,'type'   => 'info'
		,'notice' => false
		,'title'  => esc_html__( 'Product Label Colors (Style Label After Product Thumbnail)', 'hitsxyz' )
		,'desc'   => ''
	)
	,array(
		'id'       => 'hits_product_meta_label_text_color'
		,'type'     => 'color_rgba'
		,'title'    => esc_html__( 'Label Text Color', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => array(
			'color' 	=> '#d10202'
			,'alpha'	=> 1
		)
	)
);

/*** Typography Tab ***/
$option_fields['typography'] = array(
	array(
		'id'        => 'section-fonts'
		,'type'     => 'section'
		,'title'    => esc_html__( 'GENERAL FONT', 'hitsxyz' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'       			=> 'hits_body_font'
		,'type'     		=> 'typography'
		,'title'    		=> esc_html__( 'Body Font', 'hitsxyz' )
		,'subtitle' 		=> ''
		,'google'   		=> true
		,'font-style'   	=> false
		,'text-align'   	=> false
		,'color'   			=> false
		,'letter-spacing' 	=> true
		,'preview'			=> array('always_display' => true)
		,'default'  		=> array(
			'font-family'  		=> 'Inter'
			,'font-weight' 		=> '400'
			,'font-size'   		=> '15px'
			,'line-height' 		=> '24px'
			,'letter-spacing' 	=> '0.375px'
			,'google'	   		=> true
		)
		,'fonts'	=> $family_fonts
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 20)
	)
	,array(
		'id'       			=> 'hits_body_font_medium'
		,'type'     		=> 'typography'
		,'title'    		=> esc_html__( 'Body Font Medium', 'hitsxyz' )
		,'subtitle' 		=> ''
		,'google'   		=> true
		,'font-style'   	=> false
		,'text-align'   	=> false
		,'line-height'  	=> false
		,'font-size'  		=> false
		,'letter-spacing' 	=> false
		,'color'   			=> false
		,'preview'			=> array('always_display' => true)
		,'default'  		=> array(
			'font-family'  		=> 'Inter'
			,'font-weight' 		=> '500'
			,'google'	   		=> true
		)
		,'fonts'	=> $family_fonts
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 20)
	)
	,array(
		'id'       			=> 'hits_body_font_bold'
		,'type'     		=> 'typography'
		,'title'    		=> esc_html__( 'Body Font Bold', 'hitsxyz' )
		,'subtitle' 		=> ''
		,'google'   		=> true
		,'font-style'   	=> false
		,'text-align'   	=> false
		,'line-height'  	=> false
		,'font-size'  		=> false
		,'letter-spacing' 	=> false
		,'color'   			=> false
		,'preview'			=> array('always_display' => true)
		,'default'  		=> array(
			'font-family'  		=> 'Inter'
			,'font-weight' 		=> '700'
			,'google'	   		=> true
		)
		,'fonts'	=> $family_fonts
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 20)
	)
	,array(
		'id'       			=> 'hits_button_font'
		,'type'     		=> 'typography'
		,'title'    		=> esc_html__( 'Button Font', 'hitsxyz' )
		,'subtitle' 		=> ''
		,'google'   		=> true
		,'font-style'   	=> false
		,'text-align'   	=> false
		,'color'   			=> false
		,'line-height' 		=> false
		,'letter-spacing' 	=> true
		,'text-transform' 	=> true
		,'preview'			=> array('always_display' => true)
		,'default'  			=> array(
			'font-family'  		=> 'Inter'
			,'font-weight' 		=> '700'
			,'font-size'   		=> '14px'
			,'letter-spacing'   => '1.05px'
			,'text-transform'   => 'uppercase'
			,'google'	   		=> true
		)
		,'fonts'	=> $family_fonts
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 20)
	)
	,array(
		'id'       		=> 'hits_blockquote_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'Blockquote Font Size', 'hitsxyz' )
		,'subtitle' 	=> ''
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'letter-spacing' 	=> false
		,'text-align'  	 	=> false
		,'color'   			=> false
		,'preview'			=> array('always_display' => false)
		,'default'  		=> array(
			'font-family'  		=> ''
			,'font-weight' 		=> ''
			,'font-size'   		=> '30px'
			,'line-height' 		=> '48px'
			,'google'	   		=> false
		)
	)
	,array(
		'id'      => 'info-product-price-fonts'
		,'type'   => 'info'
		,'notice' => false
		,'title'  => esc_html__( 'PRODUCT PRICE FONT SIZE', 'hitsxyz' )
		,'desc'   => ''
	)
	,array(
		'id'       		=> 'hits_single_product_price_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'Single Product Price Font Size', 'hitsxyz' )
		,'subtitle' 	=> esc_html__( 'Font size of price in product detail page', 'hitsxyz' )
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'letter-spacing' 	=> false
		,'line-height' 		=> false
		,'text-align'  	 	=> false
		,'color'   			=> false
		,'preview'			=> array('always_display' => false)
		,'default'  		=> array(
			'font-family'  		=> ''
			,'font-weight' 		=> ''
			,'font-size'   		=> '36px'
			,'google'	   		=> false
		)
	)
	,array(
		'id'       		=> 'hits_single_product_sale_price_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'Single Product Sale Price Font Size', 'hitsxyz' )
		,'subtitle' 	=> esc_html__( 'Font size of discount price in product detail page', 'hitsxyz' )
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'letter-spacing' 	=> false
		,'line-height' 		=> false
		,'text-align'  	 	=> false
		,'color'   			=> false
		,'preview'			=> array('always_display' => false)
		,'default'  		=> array(
			'font-family'  		=> ''
			,'font-weight' 		=> ''
			,'font-size'   		=> '20px'
			,'google'	   		=> false
		)
	)
	,array(
		'id'      => 'info-menu-fonts'
		,'type'   => 'info'
		,'notice' => false
		,'title'  => esc_html__( 'MAIN MENU FONT', 'hitsxyz' )
		,'desc'   => ''
	)
	,array(
		'id'       			=> 'hits_menu_font'
		,'type'     		=> 'typography'
		,'title'    		=> esc_html__( 'Main Menu Font', 'hitsxyz' )
		,'subtitle' 		=> ''
		,'google'   		=> true
		,'font-style'   	=> false
		,'text-align'   	=> false
		,'color'   			=> false
		,'letter-spacing' 	=> false
		,'preview'			=> array('always_display' => true)
		,'default'  			=> array(
			'font-family'  		=> 'Inter'
			,'font-weight' 		=> '400'
			,'font-size'   		=> '16px'
			,'line-height'   	=> '24px'
			,'google'	   		=> true
		)
		,'fonts'	=> $family_fonts
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 20)
	)
	,array(
		'id'       		=> 'hits_sub_menu_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'Main Menu - Sub Menu Font Size', 'hitsxyz' )
		,'subtitle' 	=> ''
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'letter-spacing' 	=> false
		,'text-align'  	 	=> false
		,'color'   			=> false
		,'preview'			=> array('always_display' => false)
		,'default'  		=> array(
			'font-family'  		=> ''
			,'font-weight' 		=> ''
			,'font-size'   		=> '14px'
			,'line-height' 		=> '24px'
			,'google'	   		=> false
		)
	)
	,array(
		'id'      => 'info-sidebar-menu-fonts'
		,'type'   => 'info'
		,'notice' => false
		,'title'  => esc_html__( 'SIDEBAR MENU FONT', 'hitsxyz' )
		,'desc'   => ''
	)
	,array(
		'id'       			=> 'hits_sidebar_menu_font'
		,'type'     		=> 'typography'
		,'title'    		=> esc_html__( 'Sidebar Menu Font', 'hitsxyz' )
		,'subtitle' 		=> ''
		,'google'   		=> true
		,'font-style'   	=> false
		,'text-align'   	=> false
		,'color'   			=> false
		,'line-height' 		=> true
		,'letter-spacing' 	=> false
		,'preview'			=> array('always_display' => true)
		,'default'  			=> array(
			'font-family'  		=> 'Inter'
			,'font-weight' 		=> '400'
			,'font-size'   		=> '24px'
			,'line-height'   	=> '28px'
			,'google'	   		=> true
		)
		,'fonts'	=> $family_fonts
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 20)
	)
	,array(
		'id'       		=> 'hits_sidebar_submenu_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'Sidebar Menu - Sub Menu Font Size', 'hitsxyz' )
		,'subtitle' 	=> ''
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'letter-spacing' 	=> false
		,'text-align'  	 	=> false
		,'color'   			=> false
		,'preview'			=> array('always_display' => false)
		,'default'  		=> array(
			'font-family'  		=> ''
			,'font-weight' 		=> ''
			,'font-size'   		=> '18px'
			,'line-height' 		=> '24px'
			,'google'	   		=> false
		)
	)
	,array(
		'id'      => 'info-mobile-menu-fonts'
		,'type'   => 'info'
		,'notice' => false
		,'title'  => esc_html__( 'MOBILE MENU FONT', 'hitsxyz' )
		,'desc'   => ''
	)
	,array(
		'id'       			=> 'hits_mobile_menu_font'
		,'type'     		=> 'typography'
		,'title'    		=> esc_html__( 'Mobile Menu Font', 'hitsxyz' )
		,'subtitle' 		=> ''
		,'google'   		=> true
		,'font-style'   	=> false
		,'text-align'   	=> false
		,'color'   			=> false
		,'line-height' 		=> true
		,'letter-spacing' 	=> false
		,'preview'			=> array('always_display' => true)
		,'default'  			=> array(
			'font-family'  		=> 'Inter'
			,'font-weight' 		=> '400'
			,'font-size'   		=> '16px'
			,'line-height'   	=> '24px'
			,'google'	   		=> true
		)
		,'fonts'	=> $family_fonts
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 20)
	)
	,array(
		'id'      => 'info-heading-fonts'
		,'type'   => 'info'
		,'notice' => false
		,'title'  => esc_html__( 'HEADING FONT', 'hitsxyz' )
		,'desc'   => ''
	)
	,array(
		'id'       			=> 'hits_heading_font'
		,'type'     		=> 'typography'
		,'title'    		=> esc_html__( 'Heading Font', 'hitsxyz' )
		,'subtitle' 		=> ''
		,'google'   		=> true
		,'font-style'   	=> false
		,'text-align'   	=> false
		,'line-height'  	=> false
		,'font-size'  		=> false
		,'letter-spacing' 	=> false
		,'color'   			=> false
		,'preview'			=> array('always_display' => true)
		,'default'  		=> array(
			'font-family'  		=> 'Inter'
			,'font-weight' 		=> '700'
			,'google'	   		=> true
		)
		,'fonts'	=> $family_fonts
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 20)
	)
	,array(
		'id'       			=> 'hits_h1_font'
		,'type'     		=> 'typography'
		,'title'    		=> esc_html__( 'Font Size H1', 'hitsxyz' )
		,'subtitle' 		=> ''
		,'class' 			=> 'typography-no-preview'
		,'google'   		=> false
		,'font-family'  	=> false
		,'font-weight'  	=> false
		,'font-style'   	=> false
		,'letter-spacing' 	=> true
		,'text-align'  	 	=> false
		,'color'   			=> false
		,'preview'			=> array('always_display' => false)
		,'default'  		=> array(
			'font-family'  		=> ''
			,'font-weight' 		=> ''
			,'font-size'   		=> '48px'
			,'line-height' 		=> '54px'
			,'letter-spacing' 	=> '3.6px'
			,'google'	   		=> false
		)
	)
	,array(
		'id'       		=> 'hits_h2_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'Font Size H2', 'hitsxyz' )
		,'subtitle' 	=> ''
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'letter-spacing' 	=> true
		,'text-align'  	 	=> false
		,'color'   			=> false
		,'preview'			=> array('always_display' => false)
		,'default'  		=> array(
			'font-family'  		=> ''
			,'font-weight' 		=> ''
			,'font-size'   		=> '36px'
			,'line-height' 		=> '40px'
			,'letter-spacing' 	=> '2.5px'
			,'google'	   		=> false
		)
	)
	,array(
		'id'       		=> 'hits_h3_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'Font Size H3', 'hitsxyz' )
		,'subtitle' 	=> ''
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'letter-spacing' 	=> true
		,'text-align'  	 	=> false
		,'color'   			=> false
		,'preview'			=> array('always_display' => false)
		,'default'  		=> array(
			'font-family'  		=> ''
			,'font-weight' 		=> ''
			,'font-size'   		=> '30px'
			,'line-height' 		=> '36px'
			,'letter-spacing' 	=> '2px'
			,'google'	   		=> false
		)
	)
	,array(
		'id'       		=> 'hits_h4_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'Font Size H4', 'hitsxyz' )
		,'subtitle' 	=> ''
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'letter-spacing' 	=> true
		,'text-align'  	 	=> false
		,'color'   			=> false
		,'preview'			=> array('always_display' => false)
		,'default'  		=> array(
			'font-family'  		=> ''
			,'font-weight' 		=> ''
			,'font-size'   		=> '25px'
			,'line-height' 		=> '30px'
			,'letter-spacing' 	=> '1.2px'
			,'google'	   		=> false
		)
	)
	,array(
		'id'       		=> 'hits_h5_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'Font Size H5', 'hitsxyz' )
		,'subtitle' 	=> ''
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'letter-spacing' 	=> true
		,'text-align'  	 	=> false
		,'color'   			=> false
		,'preview'			=> array('always_display' => false)
		,'default'  		=> array(
			'font-family'  		=> ''
			,'font-weight' 		=> ''
			,'font-size'   		=> '20px'
			,'line-height' 		=> '28px'
			,'letter-spacing' 	=> '1px'
			,'google'	   		=> false
		)
	)
	,array(
		'id'       		=> 'hits_h6_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'Font Size H6', 'hitsxyz' )
		,'subtitle' 	=> ''
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'letter-spacing' 	=> true
		,'text-align'  	 	=> false
		,'color'   			=> false
		,'preview'			=> array('always_display' => false)
		,'default'  		=> array(
			'font-family'  		=> ''
			,'font-weight' 		=> ''
			,'font-size'   		=> '18px'
			,'line-height' 		=> '24px'
			,'letter-spacing' 	=> '0.9px'
			,'google'	   		=> false
		)
	)
	,array(
		'id'        => 'section-font-sizes-responsive'
		,'type'     => 'section'
		,'title'    => esc_html__( 'RESPONSIVE FONT SIZE', 'hitsxyz' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'      => 'info-font-size-tablet'
		,'type'   => 'info'
		,'notice' => false
		,'title'  => esc_html__( 'Tablet', 'hitsxyz' )
		,'desc'   => ''
	)
	,array(
		'id'       		=> 'hits_h1_ipad_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'H1 Font Size', 'hitsxyz' )
		,'subtitle' 	=> ''
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'letter-spacing' 	=> true
		,'text-align'  	 	=> false
		,'color'   			=> false
		,'preview'			=> array('always_display' => false)
		,'default'  		=> array(
			'font-family'  		=> ''
			,'font-weight' 		=> ''
			,'font-size'   		=> '36px'
			,'line-height' 		=> '40px'
			,'letter-spacing' 	=> '2px'
			,'google'	   		=> false
		)
	)
	,array(
		'id'       		=> 'hits_h2_ipad_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'H2 Font Size', 'hitsxyz' )
		,'subtitle' 	=> ''
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'letter-spacing' 	=> true
		,'text-align'  	 	=> false
		,'color'   			=> false
		,'preview'			=> array('always_display' => false)
		,'default'  		=> array(
			'font-family'  		=> ''
			,'font-weight' 		=> ''
			,'font-size'   		=> '30px'
			,'line-height' 		=> '36px'
			,'letter-spacing' 	=> '1.7px'
			,'google'	   		=> false
		)
	)
	,array(
		'id'       		=> 'hits_h3_ipad_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'H3 Font Size', 'hitsxyz' )
		,'subtitle' 	=> ''
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'letter-spacing' 	=> true
		,'text-align'  	 	=> false
		,'color'   			=> false
		,'preview'			=> array('always_display' => false)
		,'default'  		=> array(
			'font-family'  		=> ''
			,'font-weight' 		=> ''
			,'font-size'   		=> '25px'
			,'line-height' 		=> '30px'
			,'letter-spacing' 	=> '1.2px'
			,'google'	   		=> false
		)
	)
	,array(
		'id'       		=> 'hits_h4_ipad_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'H4 Font Size', 'hitsxyz' )
		,'subtitle' 	=> ''
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'letter-spacing' 	=> true
		,'text-align'  	 	=> false
		,'color'   			=> false
		,'preview'			=> array('always_display' => false)
		,'default'  		=> array(
			'font-family'  		=> ''
			,'font-weight' 		=> ''
			,'font-size'   		=> '20px'
			,'line-height' 		=> '28px'
			,'letter-spacing' 	=> '0.9px'
			,'google'	   		=> false
		)
	)
	,array(
		'id'       		=> 'hits_h5_ipad_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'H5 Font Size', 'hitsxyz' )
		,'subtitle' 	=> ''
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'letter-spacing' 	=> true
		,'text-align'  	 	=> false
		,'color'   			=> false
		,'preview'			=> array('always_display' => false)
		,'default'  		=> array(
			'font-family'  		=> ''
			,'font-weight' 		=> ''
			,'font-size'   		=> '18px'
			,'line-height' 		=> '24px'
			,'letter-spacing' 	=> '0.75px'
			,'google'	   		=> false
		)
	)
	,array(
		'id'       		=> 'hits_h6_ipad_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'H6 Font Size', 'hitsxyz' )
		,'subtitle' 	=> ''
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'letter-spacing' 	=> true
		,'text-align'  	 	=> false
		,'color'   			=> false
		,'preview'			=> array('always_display' => false)
		,'default'  		=> array(
			'font-family'  		=> ''
			,'font-weight' 		=> ''
			,'font-size'   		=> '16px'
			,'line-height' 		=> '24px'
			,'letter-spacing' 	=> '0.75px'
			,'google'	   		=> false
		)
	)
	,array(
		'id'       		=> 'hits_sidebar_menu_ipad_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'Sidebar Menu Font Size', 'hitsxyz' )
		,'subtitle' 	=> ''
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'letter-spacing' 	=> false
		,'text-align'  	 	=> false
		,'color'   			=> false
		,'preview'			=> array('always_display' => false)
		,'default'  		=> array(
			'font-family'  		=> ''
			,'font-weight' 		=> ''
			,'font-size'   		=> '18px'
			,'line-height' 		=> '26px'
			,'google'	   		=> false
		)
	)
	,array(
		'id'       		=> 'hits_sidebar_submenu_ipad_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'Sidebar Sub Menu Font Size', 'hitsxyz' )
		,'subtitle' 	=> ''
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'letter-spacing' 	=> false
		,'text-align'  	 	=> false
		,'color'   			=> false
		,'preview'			=> array('always_display' => false)
		,'default'  		=> array(
			'font-family'  		=> ''
			,'font-weight' 		=> ''
			,'font-size'   		=> '15px'
			,'line-height' 		=> '24px'
			,'google'	   		=> false
		)
	)
	,array(
		'id'       		=> 'hits_single_product_price_ipad_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'Single Product Price Font Size', 'hitsxyz' )
		,'subtitle' 	=> esc_html__( 'Font size of price in product detail page', 'hitsxyz' )
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'letter-spacing' 	=> false
		,'line-height' 		=> false
		,'text-align'  	 	=> false
		,'color'   			=> false
		,'preview'			=> array('always_display' => false)
		,'default'  		=> array(
			'font-family'  		=> ''
			,'font-weight' 		=> ''
			,'font-size'   		=> '25px'
			,'google'	   		=> false
		)
	)
	,array(
		'id'       		=> 'hits_single_product_sale_price_ipad_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'Single Product Sale Price Font Size', 'hitsxyz' )
		,'subtitle' 	=> esc_html__( 'Font size of discount price in product detail page', 'hitsxyz' )
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'letter-spacing' 	=> false
		,'line-height' 		=> false
		,'text-align'  	 	=> false
		,'color'   			=> false
		,'preview'			=> array('always_display' => false)
		,'default'  		=> array(
			'font-family'  		=> ''
			,'font-weight' 		=> ''
			,'font-size'   		=> '18px'
			,'google'	   		=> false
		)
	)
	,array(
		'id'      => 'info-font-size-mobile'
		,'type'   => 'info'
		,'notice' => false
		,'title'  => esc_html__( 'Mobile', 'hitsxyz' )
		,'desc'   => ''
	)
	,array(
		'id'       		=> 'hits_h1_mobile_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'H1 Font Size', 'hitsxyz' )
		,'subtitle' 	=> ''
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'letter-spacing' 	=> true
		,'text-align'  	 	=> false
		,'color'   			=> false
		,'preview'			=> array('always_display' => false)
		,'default'  		=> array(
			'font-family'  		=> ''
			,'font-weight' 		=> ''
			,'font-size'   		=> '30px'
			,'line-height' 		=> '36px'
			,'letter-spacing' 	=> '1.2px'
			,'google'	   		=> false
		)
	)
	,array(
		'id'       		=> 'hits_h2_mobile_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'H2 Font Size', 'hitsxyz' )
		,'subtitle' 	=> ''
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'letter-spacing' 	=> true
		,'text-align'  	 	=> false
		,'color'   			=> false
		,'preview'			=> array('always_display' => false)
		,'default'  		=> array(
			'font-family'  		=> ''
			,'font-weight' 		=> ''
			,'font-size'   		=> '25px'
			,'line-height' 		=> '30px'
			,'letter-spacing' 	=> '1px'
			,'google'	   		=> false
		)
	)
	,array(
		'id'       		=> 'hits_h3_mobile_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'H3 Font Size', 'hitsxyz' )
		,'subtitle' 	=> ''
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'letter-spacing' 	=> true
		,'text-align'  	 	=> false
		,'color'   			=> false
		,'preview'			=> array('always_display' => false)
		,'default'  		=> array(
			'font-family'  		=> ''
			,'font-weight' 		=> ''
			,'font-size'   		=> '20px'
			,'line-height' 		=> '28px'
			,'letter-spacing' 	=> '0.9px'
			,'google'	   		=> false
		)
	)
	,array(
		'id'       		=> 'hits_h4_mobile_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'H4 Font Size', 'hitsxyz' )
		,'subtitle' 	=> ''
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'letter-spacing' 	=> true
		,'text-align'  	 	=> false
		,'color'   			=> false
		,'preview'			=> array('always_display' => false)
		,'default'  		=> array(
			'font-family'  		=> ''
			,'font-weight' 		=> ''
			,'font-size'   		=> '18px'
			,'line-height' 		=> '24px'
			,'letter-spacing' 	=> '0.75px'
			,'google'	   		=> false
		)
	)
	,array(
		'id'       		=> 'hits_h5_mobile_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'H5 Font Size', 'hitsxyz' )
		,'subtitle' 	=> ''
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'letter-spacing' 	=> true
		,'text-align'  	 	=> false
		,'color'   			=> false
		,'preview'			=> array('always_display' => false)
		,'default'  		=> array(
			'font-family'  		=> ''
			,'font-weight' 		=> ''
			,'font-size'   		=> '16px'
			,'line-height' 		=> '24px'
			,'letter-spacing' 	=> '0.75px'
			,'google'	   		=> false
		)
	)
	,array(
		'id'       		=> 'hits_h6_mobile_font'
		,'type'     	=> 'typography'
		,'title'    	=> esc_html__( 'H6 Font Size', 'hitsxyz' )
		,'subtitle' 	=> ''
		,'class' 		=> 'typography-no-preview'
		,'google'   	=> false
		,'font-family'  => false
		,'font-weight'  => false
		,'font-style'   => false
		,'letter-spacing' 	=> true
		,'text-align'  	 	=> false
		,'color'   			=> false
		,'preview'			=> array('always_display' => false)
		,'default'  		=> array(
			'font-family'  		=> ''
			,'font-weight' 		=> ''
			,'font-size'   		=> '15px'
			,'line-height' 		=> '24px'
			,'letter-spacing' 	=> '0.75px'
			,'google'	   		=> false
		)
	)
	,array(
		'id'        => 'section-custom-font'
		,'type'     => 'section'
		,'title'    => esc_html__( 'CUSTOM FONT', 'hitsxyz' )
		,'subtitle' => esc_html__( 'If you get the error message \'Sorry, this file type is not permitted for security reasons\', you can add this line define(\'ALLOW_UNFILTERED_UPLOADS\', true); to the wp-config.php file', 'hitsxyz' )
		,'indent'   => false
	)
	,array(
		'id'        => 'hits_custom_font_ttf'
		,'type'     => 'custom_field'
		,'url'      => false
		,'preview'  => false
		,'readonly' => true
		,'title'    => esc_html__( 'Custom Font ttf', 'hitsxyz' )
		,'desc'     => ''
		,'subtitle' => esc_html__( 'Upload the .ttf font file and save changes', 'hitsxyz' )
		,'default'  => array( 'url' => '' )
		,'library_filter'		=> array('ttf')
	)
);

/*** Header Tab ***/
$option_fields['header'] = array(
	array(
		'id'        => 'section-header-options'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Header Options', 'hitsxyz' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'        => 'hits_header_layout'
		,'type'     => 'image_select'
		,'title'    => esc_html__( 'Header Layout', 'hitsxyz' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => $header_layout_options
		,'default'  => 'v1'
	)
	,array(
		'id'        => 'hits_header_store_notice'
		,'type'     => 'textarea'
		,'title'    => esc_html__( 'Header Notice', 'hitsxyz' )
		,'subtitle' => esc_html__( 'Not available in header layout 5', 'hitsxyz' )
		,'validate'	=> 'html'
		,'desc'     => ''
		,'default'  => ''
	)
	,array(
		'id'        => 'hits_header_slide_notice'
		,'type'     => 'multi_text'
		,'title'    => esc_html__( 'Header Notices', 'hitsxyz' )
		,'subtitle' => esc_html__( 'Only available in header layout 5. Show multiple notices as slider', 'hitsxyz' )
		,'desc'     => ''
		,'default'  => array('')
	)
	,array(
		'id'        => 'hits_header_slide_notice_timing'
		,'type'     => 'text'
		,'title'    => esc_html__( 'Notice Animation Timing', 'hitsxyz' )
		,'subtitle' => esc_html__( 'The Timing is in seconds. Please put the number only in this field. Default is 30', 'hitsxyz' )
		,'desc'     => ''
		,'default'  => ''
	)
	,array(
		'id'        => 'hits_enable_sticky_header'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Sticky Header', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Enable', 'hitsxyz' )
		,'off'		=> esc_html__( 'Disable', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_enable_search'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Search', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Enable', 'hitsxyz' )
		,'off'		=> esc_html__( 'Disable', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_enable_tiny_wishlist'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Wishlist', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Enable', 'hitsxyz' )
		,'off'		=> esc_html__( 'Disable', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_header_currency'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Header Currency', 'hitsxyz' )
		,'subtitle' => esc_html__( 'Only available on some header layouts. If you don\'t install WooCommerce Multilingual plugin, it may display demo html', 'hitsxyz' )
		,'default'  => false
		,'on'		=> esc_html__( 'Enable', 'hitsxyz' )
		,'off'		=> esc_html__( 'Disable', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_header_language'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Header Language', 'hitsxyz' )
		,'subtitle' => esc_html__( 'Only available on some header layouts. If you don\'t install WPML plugin, it may display demo html', 'hitsxyz' )
		,'default'  => false
		,'on'		=> esc_html__( 'Enable', 'hitsxyz' )
		,'off'		=> esc_html__( 'Disable', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_enable_tiny_account'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'My Account', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Enable', 'hitsxyz' )
		,'off'		=> esc_html__( 'Disable', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_enable_tiny_shopping_cart'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Shopping Cart', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Enable', 'hitsxyz' )
		,'off'		=> esc_html__( 'Disable', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_shopping_cart_sidebar'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Shopping Cart Sidebar', 'hitsxyz' )
		,'subtitle' => esc_html__( 'Show shopping cart in sidebar instead of dropdown. You need to update cart after changing', 'hitsxyz' )
		,'default'  => false
		,'on'		=> esc_html__( 'Enable', 'hitsxyz' )
		,'off'		=> esc_html__( 'Disable', 'hitsxyz' )
		,'required'	=> array( 'hits_enable_tiny_shopping_cart', 'equals', '1' )
	)
	,array(
		'id'        => 'hits_show_shopping_cart_after_adding'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Show Shopping Cart After Adding Product To Cart', 'hitsxyz' )
		,'subtitle' => esc_html__( 'You need to enable Ajax add to cart in WooCommerce > Settings > Products', 'hitsxyz' )
		,'default'  => false
		,'on'		=> esc_html__( 'Enable', 'hitsxyz' )
		,'off'		=> esc_html__( 'Disable', 'hitsxyz' )
		,'required'	=> array( 'hits_shopping_cart_sidebar', 'equals', '1' )
	)
	,array(
		'id'        => 'hits_add_to_cart_effect'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Add To Cart Effect', 'hitsxyz' )
		,'subtitle' => esc_html__( 'You need to enable Ajax add to cart in WooCommerce > Settings > Products. If "Show Shopping Cart After Adding Product To Cart" is enabled, this option will be disabled', 'hitsxyz' )
		,'options'  => array(
			'0'				=> esc_html__( 'None', 'hitsxyz' )
			,'fly_to_cart'	=> esc_html__( 'Fly To Cart', 'hitsxyz' )
			,'show_popup'	=> esc_html__( 'Show Popup', 'hitsxyz' )
		)
		,'default'  => '0'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
	)
	
	,array(
		'id'        => 'hits_enable_header_social_icons'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Header Social Icons', 'hitsxyz' )
		,'subtitle' => esc_html__( 'Only available in header layout 5. For other layout please contact our support team.', 'hitsxyz' )
		,'default'  => true
		,'on'		=> esc_html__( 'Enable', 'hitsxyz' )
		,'off'		=> esc_html__( 'Disable', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_facebook_url'
		,'type'     => 'text'
		,'title'    => esc_html__( 'Facebook URL', 'hitsxyz' )
		,'subtitle' => ''
		,'desc'     => ''
		,'default'  => '#'
		,'required'	=> array( 'hits_enable_header_social_icons', 'equals', '1' )
	)
	,array(
		'id'        => 'hits_x_url'
		,'type'     => 'text'
		,'title'    => esc_html__( 'X URL', 'hitsxyz' )
		,'subtitle' => ''
		,'desc'     => ''
		,'default'  => '#'
		,'required'	=> array( 'hits_enable_header_social_icons', 'equals', '1' )
	)
	,array(
		'id'        => 'hits_instagram_url'
		,'type'     => 'text'
		,'title'    => esc_html__( 'Instagram URL', 'hitsxyz' )
		,'subtitle' => ''
		,'desc'     => ''
		,'default'  => '#'
		,'required'	=> array( 'hits_enable_header_social_icons', 'equals', '1' )
	)
	,array(
		'id'        => 'hits_pinterest_url'
		,'type'     => 'text'
		,'title'    => esc_html__( 'Pinterest URL', 'hitsxyz' )
		,'subtitle' => ''
		,'desc'     => ''
		,'default'  => '#'
		,'required'	=> array( 'hits_enable_header_social_icons', 'equals', '1' )
	)
	,array(
		'id'        => 'hits_youtube_url'
		,'type'     => 'text'
		,'title'    => esc_html__( 'Youtube URL', 'hitsxyz' )
		,'subtitle' => ''
		,'desc'     => ''
		,'default'  => ''
		,'required'	=> array( 'hits_enable_header_social_icons', 'equals', '1' )
	)
	,array(
		'id'        => 'hits_linkedin_url'
		,'type'     => 'text'
		,'title'    => esc_html__( 'LinkedIn URL', 'hitsxyz' )
		,'subtitle' => ''
		,'desc'     => ''
		,'default'  => ''
		,'required'	=> array( 'hits_enable_header_social_icons', 'equals', '1' )
	)
	,array(
		'id'        => 'hits_custom_social_url'
		,'type'     => 'text'
		,'title'    => esc_html__( 'Custom Social URL', 'hitsxyz' )
		,'subtitle' => ''
		,'desc'     => ''
		,'default'  => ''
		,'required'	=> array( 'hits_enable_header_social_icons', 'equals', '1' )
	)
	,array(
		'id'        => 'hits_custom_social_class'
		,'type'     => 'text'
		,'title'    => esc_html__( 'Custom Social Icon', 'hitsxyz' )
		,'subtitle' => esc_html__( 'Put the class of icon. Hitsxyz support our custom font with prefix tb-icon-brand- + social name. Ex: tb-icon-brand-facebook. Or you can use font awesome 5. Ex: fab fa-facebook-f', 'hitsxyz' )
		,'desc'     => ''
		,'default'  => ''
		,'required'	=> array( 'hits_enable_header_social_icons', 'equals', '1' )
	)
	
	,array(
		'id'        => 'section-breadcrumb-options'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Breadcrumb Options', 'hitsxyz' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'        => 'hits_breadcrumb_layout'
		,'type'     => 'image_select'
		,'title'    => esc_html__( 'Breadcrumb Layout', 'hitsxyz' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => $breadcrumb_layout_options
		,'default'  => 'v1'
	)
	,array(
		'id'        => 'hits_enable_breadcrumb_background_image'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Enable Breadcrumbs Background Image', 'hitsxyz' )
		,'subtitle' => esc_html__( 'You can set background color by going to Color Scheme tab > Breadcrumb Colors section', 'hitsxyz' )
		,'default'  => true
	)
	,array(
		'id'        => 'hits_bg_breadcrumbs'
		,'type'     => 'media'
		,'url'      => true
		,'title'    => esc_html__( 'Breadcrumbs Background Image', 'hitsxyz' )
		,'desc'     => ''
		,'subtitle' => esc_html__( 'Select a new image to override the default background image', 'hitsxyz' )
		,'readonly' => false
		,'default'  => array( 'url' => '' )
	)
	,array(
		'id'        => 'hits_breadcrumb_bg_parallax'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Enable Breadcrumbs Background Parallax', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => false
	)
	,array(
		'id'        => 'hits_breadcrumb_product_taxonomy_description'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Taxonomy Description In Breadcrumbs', 'hitsxyz' )
		,'subtitle' => esc_html__( 'Show product taxonomy description (category, tags, ...) in breadcrumbs area on the product taxonomy page', 'hitsxyz' )
		,'default'  => false
	)
);

/*** Footer Tab ***/
$option_fields['footer'] = array(
	array(
		'id'       	=> 'hits_footer_block'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Footer Block', 'hitsxyz' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => $footer_block_options
		,'default'  => '0'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
	)
);

/*** Menu Tab ***/
$option_fields['menu'] = array(
	array(
		'id'             => 'hits_menu_thumb_width'
		,'type'          => 'slider'
		,'title'         => esc_html__( 'Menu Thumbnail Width', 'hitsxyz' )
		,'subtitle'      => ''
		,'desc'          => esc_html__( 'Min: 5, max: 60, step: 1, default value: 54', 'hitsxyz' )
		,'default'       => 54
		,'min'           => 5
		,'step'          => 1
		,'max'           => 60
		,'display_value' => 'text'
	)
	,array(
		'id'             => 'hits_menu_thumb_height'
		,'type'          => 'slider'
		,'title'         => esc_html__( 'Menu Thumbnail Height', 'hitsxyz' )
		,'subtitle'      => ''
		,'desc'          => esc_html__( 'Min: 5, max: 60, step: 1, default value: 54', 'hitsxyz' )
		,'default'       => 54
		,'min'           => 5
		,'step'          => 1
		,'max'           => 60
		,'display_value' => 'text'
	)
	,array(
		'id'        => 'hits_enable_menu_overlay'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Menu Background Overlay', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => false
		,'on'		=> esc_html__( 'Enable', 'hitsxyz' )
		,'off'		=> esc_html__( 'Disable', 'hitsxyz' )
	)
);

/*** Blog Tab ***/
$option_fields['blog'] = array(
	array(
		'id'        => 'section-blog'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Blog', 'hitsxyz' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'        => 'hits_blog_layout'
		,'type'     => 'image_select'
		,'title'    => esc_html__( 'Blog Layout', 'hitsxyz' )
		,'subtitle' => esc_html__( 'This option is available when Front page displays the latest posts', 'hitsxyz' )
		,'desc'     => ''
		,'options'  => array(
			'0-1-0' => array(
				'alt'  => esc_html__('Fullwidth', 'hitsxyz')
				,'img' => $redux_url . 'assets/img/1col.png'
			)
			,'1-1-0' => array(
				'alt'  => esc_html__('Left Sidebar', 'hitsxyz')
				,'img' => $redux_url . 'assets/img/2cl.png'
			)
			,'0-1-1' => array(
				'alt'  => esc_html__('Right Sidebar', 'hitsxyz')
				,'img' => $redux_url . 'assets/img/2cr.png'
			)
			,'1-1-1' => array(
				'alt'  => esc_html__('Left & Right Sidebar', 'hitsxyz')
				,'img' => $redux_url . 'assets/img/3cm.png'
			)
		)
		,'default'  => '0-1-1'
	)
	,array(
		'id'       	=> 'hits_blog_left_sidebar'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Left Sidebar', 'hitsxyz' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => $sidebar_options
		,'default'  => 'blog-sidebar'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
	)
	,array(
		'id'       	=> 'hits_blog_right_sidebar'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Right Sidebar', 'hitsxyz' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => $sidebar_options
		,'default'  => 'blog-sidebar'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
	)
	,array(
		'id'       	=> 'hits_blog_columns'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Blog Columns', 'hitsxyz' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => array(
			1	=> 1
			,2	=> 2
			,3	=> 3
		)
		,'default'  => '1'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
	)
	,array(
		'id'       	=> 'hits_blog_item_layout'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Blog Item Layout', 'hitsxyz' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => array(
			'item-grid'		=> esc_html__( 'Grid', 'hitsxyz' )
			,'item-list'	=> esc_html__( 'List', 'hitsxyz' )
		)
		,'default'	=> 'item-grid'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
	)
	,array(
		'id'        => 'hits_blog_thumbnail'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Thumbnail', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_blog_date'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Date', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_blog_title'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Title', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_blog_author'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Author', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_blog_comment'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Comment', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => false
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_blog_read_more'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Read More Button', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => false
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_blog_categories'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Categories', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => false
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_blog_excerpt'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Excerpt', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_blog_excerpt_strip_tags'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Excerpt Strip All Tags', 'hitsxyz' )
		,'subtitle' => esc_html__( 'Strip all html tags in Excerpt', 'hitsxyz' )
		,'default'  => false
	)
	,array(
		'id'        => 'hits_blog_excerpt_max_words'
		,'type'     => 'text'
		,'title'    => esc_html__( 'Blog Excerpt Max Words', 'hitsxyz' )
		,'subtitle' => esc_html__( 'Input -1 to show full excerpt', 'hitsxyz' )
		,'desc'     => ''
		,'default'  => '-1'
	)

	,array(
		'id'        => 'section-blog-details'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Blog Details', 'hitsxyz' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'        => 'hits_blog_details_layout'
		,'type'     => 'image_select'
		,'title'    => esc_html__( 'Blog Details Layout', 'hitsxyz' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => array(
			'0-1-0' => array(
				'alt'  => esc_html__('Fullwidth', 'hitsxyz')
				,'img' => $redux_url . 'assets/img/1col.png'
			)
			,'1-1-0' => array(
				'alt'  => esc_html__('Left Sidebar', 'hitsxyz')
				,'img' => $redux_url . 'assets/img/2cl.png'
			)
			,'0-1-1' => array(
				'alt'  => esc_html__('Right Sidebar', 'hitsxyz')
				,'img' => $redux_url . 'assets/img/2cr.png'
			)
			,'1-1-1' => array(
				'alt'  => esc_html__('Left & Right Sidebar', 'hitsxyz')
				,'img' => $redux_url . 'assets/img/3cm.png'
			)
		)
		,'default'  => '0-1-0'
	)
	,array(
		'id'       	=> 'hits_blog_details_left_sidebar'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Left Sidebar', 'hitsxyz' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => $sidebar_options
		,'default'  => 'blog-detail-sidebar'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
	)
	,array(
		'id'       	=> 'hits_blog_details_right_sidebar'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Right Sidebar', 'hitsxyz' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => $sidebar_options
		,'default'  => 'blog-detail-sidebar'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
	)
	,array(
		'id'        => 'hits_blog_details_thumbnail'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Thumbnail', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'       	=> 'hits_blog_details_thumbnail_style'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Blog Thumbnail Style', 'hitsxyz' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => array(
			'thumbnail-default'		=> esc_html__( 'Default', 'hitsxyz' )
			,'thumbnail-parallax'	=> esc_html__( 'Parallax', 'hitsxyz' )
		)
		,'default'	=> 'thumbnail-default'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
	)
	,array(
		'id'        => 'hits_blog_details_date'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Date', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_blog_details_title'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Title', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_blog_details_author'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Author', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_blog_details_comment'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Comment', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => false
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_blog_details_content'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Content', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_blog_details_tags'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Tags', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => false
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_blog_details_categories'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Categories', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => false
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_blog_details_sharing'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Sharing', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => false
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_blog_details_sharing_sharethis'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Sharing - Use ShareThis', 'hitsxyz' )
		,'subtitle' => esc_html__( 'Use share buttons from sharethis.com. You need to add key below', 'hitsxyz')
		,'default'  => true
		,'required'	=> array( 'hits_blog_details_sharing', 'equals', '1' )
	)
	,array(
		'id'        => 'hits_blog_details_sharing_sharethis_key'
		,'type'     => 'text'
		,'title'    => esc_html__( 'Blog Sharing - ShareThis Key', 'hitsxyz' )
		,'subtitle' => esc_html__( 'You get it from script code. It is the value of "property" attribute', 'hitsxyz' )
		,'desc'     => ''
		,'default'  => ''
		,'required'	=> array( 'hits_blog_details_sharing', 'equals', '1' )
	)
	,array(
		'id'        => 'hits_blog_details_author_box'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Author Box', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => false
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_blog_details_navigation'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Navigation', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => false
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_blog_details_related_posts'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Related Posts', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => false
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_blog_details_comment_form'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Blog Comment Form', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
);

/*** WooCommerce Tab ***/
$option_fields['woocommerce'] = array(
	array(
		'id'        => 'section-product-label'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Product Label', 'hitsxyz' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'       	=> 'hits_product_label_style'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Product Label Style', 'hitsxyz' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => array(
			'rectangle' 	=> esc_html__( 'Rectangle', 'hitsxyz' )
			,'square' 		=> esc_html__( 'Square', 'hitsxyz' )
			,'circle' 		=> esc_html__( 'Circle', 'hitsxyz' )
		)
		,'default'  => 'rectangle'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
	)
	,array(
		'id'       	=> 'hits_product_label_pos'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Product Label Position', 'hitsxyz' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => array(
			'on-thumbnail' 		=> esc_html__( 'On Thumbnail', 'hitsxyz' )
			,'after-thumbnail' 	=> esc_html__( 'After Thumbnail', 'hitsxyz' )
		)
		,'default'  => 'on-thumbnail'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
	)
	,array(
		'id'        => 'hits_product_show_new_label'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product New Label', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => false
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_product_new_label_text'
		,'type'     => 'text'
		,'title'    => esc_html__( 'Product New Label Text', 'hitsxyz' )
		,'subtitle' => ''
		,'desc'     => ''
		,'default'  => 'New'
		,'required'	=> array( 'hits_product_show_new_label', 'equals', '1' )
	)
	,array(
		'id'        => 'hits_product_show_new_label_time'
		,'type'     => 'text'
		,'title'    => esc_html__( 'Product New Label Time', 'hitsxyz' )
		,'subtitle' => esc_html__( 'Number of days which you want to show New label since product is published', 'hitsxyz' )
		,'desc'     => ''
		,'default'  => '30'
		,'required'	=> array( 'hits_product_show_new_label', 'equals', '1' )
	)
	,array(
		'id'        => 'hits_product_feature_label_text'
		,'type'     => 'text'
		,'title'    => esc_html__( 'Product Feature Label Text', 'hitsxyz' )
		,'subtitle' => ''
		,'desc'     => ''
		,'default'  => 'Hot'
	)
	,array(
		'id'        => 'hits_product_out_of_stock_label_text'
		,'type'     => 'text'
		,'title'    => esc_html__( 'Product Out Of Stock Label Text', 'hitsxyz' )
		,'subtitle' => ''
		,'desc'     => ''
		,'default'  => 'Sold out'
	)
	,array(
		'id'       	=> 'hits_show_sale_label_as'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Show Sale Label As', 'hitsxyz' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => array(
			'text' 		=> esc_html__( 'Text', 'hitsxyz' )
			,'number' 	=> esc_html__( 'Number', 'hitsxyz' )
			,'percent' 	=> esc_html__( 'Percent', 'hitsxyz' )
		)
		,'default'  => 'percent'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
	)
	,array(
		'id'        => 'hits_product_sale_label_text'
		,'type'     => 'text'
		,'title'    => esc_html__( 'Product Sale Label Text', 'hitsxyz' )
		,'subtitle' => ''
		,'desc'     => ''
		,'default'  => 'Sale'
	)
	,array(
		'id'        => 'hits_product_sale_percent_prefix'
		,'type'     => 'text'
		,'title'    => esc_html__( 'Product Sale Label Prefix', 'hitsxyz' )
		,'subtitle' => esc_html__( 'This text will be shown before amount discount in the After Thumbnail style', 'hitsxyz' )
		,'desc'     => ''
		,'default'  => 'Sale off'
		,'required'	=> array( array('hits_product_label_pos', 'equals', 'after-thumbnail'), array('hits_show_sale_label_as', '!=', 'text') )
	)
	
	,array(
		'id'        => 'section-product-hover'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Product Hover', 'hitsxyz' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'       	=> 'hits_product_hover_style'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Hover Style', 'hitsxyz' )
		,'subtitle' => esc_html__( 'Select the style of buttons/icons when hovering on product', 'hitsxyz' )
		,'desc'     => ''
		,'options'  => array(
			'hover-horizontal-style' 			=> esc_html__( 'Horizontal Style', 'hitsxyz' )
			,'hover-vertical-style' 		=> esc_html__( 'Vertical Style', 'hitsxyz' )
		)
		,'default'  => 'hover-vertical-style'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
	)
	,array(
		'id'        => 'hits_effect_product'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Back Product Image', 'hitsxyz' )
		,'subtitle' => esc_html__( 'Show another product image on hover. It will show an image from Product Gallery', 'hitsxyz' )
		,'default'  => false
	)
	,array(
		'id'        => 'hits_product_tooltip'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Tooltip', 'hitsxyz' )
		,'subtitle' => esc_html__( 'Show tooltip when hovering on buttons/icons on product', 'hitsxyz' )
		,'default'  => true
	)
	
	,array(
		'id'        => 'section-lazy-load'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Lazy Load', 'hitsxyz' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'        => 'hits_prod_lazy_load'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Activate Lazy Load', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => false
	)
	,array(
		'id'        => 'hits_prod_placeholder_img'
		,'type'     => 'media'
		,'url'      => true
		,'title'    => esc_html__( 'Placeholder Image', 'hitsxyz' )
		,'desc'     => ''
		,'subtitle' => ''
		,'readonly' => false
		,'default'  => array( 'url' => $product_loading_image )
	)
	
	,array(
		'id'        => 'section-quickshop'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Quickshop', 'hitsxyz' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'        => 'hits_enable_quickshop'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Activate Quickshop', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => true
	)

	,array(
		'id'        => 'section-catalog-mode'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Catalog Mode', 'hitsxyz' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'        => 'hits_enable_catalog_mode'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Enable Catalog Mode', 'hitsxyz' )
		,'subtitle' => esc_html__( 'Hide all Add To Cart buttons on your site. You can also hide Shopping cart by going to Header tab > turn Shopping Cart option off', 'hitsxyz' )
		,'default'  => false
	)
	
	,array(
		'id'        => 'section-ajax-search'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Ajax Search', 'hitsxyz' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'        => 'hits_ajax_search'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Enable Ajax Search', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => true
	)
	,array(
		'id'        => 'hits_ajax_search_number_result'
		,'type'     => 'text'
		,'title'    => esc_html__( 'Number Of Results', 'hitsxyz' )
		,'subtitle' => esc_html__( 'Input -1 to show all results', 'hitsxyz' )
		,'desc'     => ''
		,'default'  => '6'
	)
);

/*** Shop/Product Category Tab ***/
$option_fields['shop-product-category'] = array(
	array(
		'id'        => 'hits_prod_cat_layout'
		,'type'     => 'image_select'
		,'title'    => esc_html__( 'Shop/Product Category Layout', 'hitsxyz' )
		,'subtitle' => esc_html__( 'Sidebar is only available if Filter Widget Area is disabled', 'hitsxyz' )
		,'desc'     => ''
		,'options'  => array(
			'0-1-0' => array(
				'alt'  => esc_html__('Fullwidth', 'hitsxyz')
				,'img' => $redux_url . 'assets/img/1col.png'
			)
			,'1-1-0' => array(
				'alt'  => esc_html__('Left Sidebar', 'hitsxyz')
				,'img' => $redux_url . 'assets/img/2cl.png'
			)
			,'0-1-1' => array(
				'alt'  => esc_html__('Right Sidebar', 'hitsxyz')
				,'img' => $redux_url . 'assets/img/2cr.png'
			)
			,'1-1-1' => array(
				'alt'  => esc_html__('Left & Right Sidebar', 'hitsxyz')
				,'img' => $redux_url . 'assets/img/3cm.png'
			)
		)
		,'default'  => '0-1-0'
	)
	,array(
		'id'       	=> 'hits_prod_cat_left_sidebar'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Left Sidebar', 'hitsxyz' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => $sidebar_options
		,'default'  => 'product-category-sidebar'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
	)
	,array(
		'id'       	=> 'hits_prod_cat_right_sidebar'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Right Sidebar', 'hitsxyz' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => $sidebar_options
		,'default'  => 'product-category-sidebar'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
	)
	,array(
		'id'        => 'hits_prod_cat_grid_list_toggle'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Grid/List Toggle', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'       	=> 'hits_prod_grid_list_toggle_default'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Grid/List Toggle Default', 'hitsxyz' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => array(
			'grid'		=> esc_html__( 'Grid', 'hitsxyz' ),
			'list'		=> esc_html__( 'List', 'hitsxyz' )
		)
		,'default'  => 'grid'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
		,'required'	=> array('hits_prod_cat_grid_list_toggle', 'equals', '1')
	)
	,array(
		'id'       	=> 'hits_prod_cat_columns'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Product Columns', 'hitsxyz' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => array(
			'3'			=> '3'
			,'4'		=> '4'
			,'5'		=> '5'
			,'6'		=> '6'
		)
		,'default'  => '4'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
	)
	,array(
		'id'        => 'hits_prod_cat_per_page'
		,'type'     => 'text'
		,'title'    => esc_html__( 'Products Per Page', 'hitsxyz' )
		,'subtitle' => esc_html__( 'Number of products per page', 'hitsxyz' )
		,'desc'     => ''
		,'default'  => '12'
	)
	,array(
		'id'       	=> 'hits_prod_cat_loading_type'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Product Loading Type', 'hitsxyz' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => array(
			'default'			=> esc_html__( 'Default', 'hitsxyz' )
			,'infinity-scroll'	=> esc_html__( 'Infinity Scroll', 'hitsxyz' )
			,'load-more-button'	=> esc_html__( 'Load More Button', 'hitsxyz' )
			,'ajax-pagination'	=> esc_html__( 'Ajax Pagination', 'hitsxyz' )
		)
		,'default'  => 'ajax-pagination'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
	)
	,array(
		'id'        => 'hits_prod_cat_collapse_scroll_sidebar'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Collapse And Scroll Widgets In Sidebar', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => true
	)
	,array(
		'id'        => 'hits_prod_cat_per_page_dropdown'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Products Per Page Dropdown', 'hitsxyz' )
		,'subtitle' => esc_html__( 'Allow users to select number of products per page', 'hitsxyz' )
		,'default'  => false
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_prod_cat_onsale_checkbox'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Products On Sale Checkbox', 'hitsxyz' )
		,'subtitle' => esc_html__( 'Allow users to view only the discounted products', 'hitsxyz' )
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_filter_widget_area'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Filter Widget Area', 'hitsxyz' )
		,'subtitle' => esc_html__( 'Display Filter Widget Area on the Shop/Product Category page. If enabled, sidebar will be removed', 'hitsxyz' )
		,'default'  => false
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'		=> 'hits_filter_widget_area_style'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Filter Widget Area Style', 'hitsxyz' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => array(
			'dropdown'			=> esc_html__( 'Dropdown', 'hitsxyz' )
			,'sidebar'			=> esc_html__( 'Sidebar', 'hitsxyz' )
			,'floating-sidebar'	=> esc_html__( 'Floating Sidebar', 'hitsxyz' )
		)
		,'default'  => 'dropdown'
		,'select2'	=> array( 'allowClear' => false, 'minimumResultsForSearch' => 'Infinity' )
		,'required'	=> array( 'hits_filter_widget_area', 'equals', '1' )
	)
	,array(
		'id'        => 'hits_prod_cat_filter_heading'
		,'type'     => 'text'
		,'title'    => esc_html__( 'Filter Sidebar Heading', 'hitsxyz' )
		,'subtitle' => esc_html__( 'Used in Floating Sidebar', 'hitsxyz' )
		,'desc'     => ''
		,'default'  => 'Filter Products'
	)
	,array(
		'id'		=> 'hits_show_filter_widget_area_by_default'
		,'type'		=> 'switch'
		,'title'	=> esc_html__( 'Show Filter Widget Area By Default', 'hitsxyz' )
		,'subtitle'	=> ''
		,'desc'		=> ''
		,'default'	=> false
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
		,'required'	=> array( 'hits_filter_widget_area_style', 'equals', 'sidebar' )	
	)
	,array(
		'id'        => 'hits_prod_cat_thumbnail'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Thumbnail', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_prod_cat_label'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Label', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_prod_cat_brand'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Brands', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => false
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_prod_cat_cat'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Categories', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => false
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_prod_cat_title'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Title', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_prod_cat_sku'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product SKU', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => false
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_prod_cat_rating'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Rating', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => false
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_prod_cat_price'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Price', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_prod_cat_add_to_cart'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Add To Cart Button', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_prod_cat_desc'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Short Description - Grid View', 'hitsxyz' )
		,'subtitle' => esc_html__( 'Show product description on grid view', 'hitsxyz' )
		,'default'  => false
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_prod_cat_desc_words'
		,'type'     => 'text'
		,'title'    => esc_html__( 'Product Short Description - Grid View - Limit Words', 'hitsxyz' )
		,'subtitle' => esc_html__( 'Number of words to show product description on grid view. It is also used for product elements', 'hitsxyz' )
		,'desc'     => ''
		,'default'  => '10'
	)
	,array(
		'id'        => 'hits_prod_cat_list_desc'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Short Description - List View', 'hitsxyz' )
		,'subtitle' => esc_html__( 'Show product description on list view', 'hitsxyz' )
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_prod_cat_list_desc_words'
		,'type'     => 'text'
		,'title'    => esc_html__( 'Product Short Description - List View - Limit Words', 'hitsxyz' )
		,'subtitle' => esc_html__( 'Number of words to show product description on list view', 'hitsxyz' )
		,'desc'     => ''
		,'default'  => '50'
	)
	,array(
		'id'        => 'hits_prod_cat_color_swatch'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Color Swatches', 'hitsxyz' )
		,'subtitle' => esc_html__( 'Show the color attribute of variations. The slug of the color attribute has to be "color"', 'hitsxyz' )
		,'default'  => false
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'       	=> 'hits_prod_cat_number_color_swatch'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Number Of Color Swatches', 'hitsxyz' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => array(
			2	=> 2
			,3	=> 3
			,4	=> 4
			,5	=> 5
			,6	=> 6
		)
		,'default'  => '3'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
		,'required'	=> array( 'hits_prod_cat_color_swatch', 'equals', '1' )
	)
);

/*** Product Details Tab ***/
$option_fields['product-details'] = array(
	array(
		'id'        => 'hits_prod_layout'
		,'type'     => 'image_select'
		,'title'    => esc_html__( 'Product Layout', 'hitsxyz' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => array(
			'0-1-0' => array(
				'alt'  => esc_html__('Fullwidth', 'hitsxyz')
				,'img' => $redux_url . 'assets/img/1col.png'
			)
			,'1-1-0' => array(
				'alt'  => esc_html__('Left Sidebar', 'hitsxyz')
				,'img' => $redux_url . 'assets/img/2cl.png'
			)
			,'0-1-1' => array(
				'alt'  => esc_html__('Right Sidebar', 'hitsxyz')
				,'img' => $redux_url . 'assets/img/2cr.png'
			)
			,'1-1-1' => array(
				'alt'  => esc_html__('Left & Right Sidebar', 'hitsxyz')
				,'img' => $redux_url . 'assets/img/3cm.png'
			)
		)
		,'default'  => '0-1-0'
	)
	,array(
		'id'       	=> 'hits_prod_left_sidebar'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Left Sidebar', 'hitsxyz' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => $sidebar_options
		,'default'  => 'product-detail-sidebar'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
	)
	,array(
		'id'       	=> 'hits_prod_right_sidebar'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Right Sidebar', 'hitsxyz' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => $sidebar_options
		,'default'  => 'product-detail-sidebar'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
	)
	,array(
		'id'       	=> 'hits_prod_layout_fullwidth'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Product Layout Fullwidth', 'hitsxyz' )
		,'subtitle' => esc_html__( 'Override the Layout Fullwidth option in the General tab', 'hitsxyz' )
		,'desc'     => ''
		,'options'  => array(
			'default'	=> esc_html__( 'Default', 'hitsxyz' )
			,'0'		=> esc_html__( 'No', 'hitsxyz' )
			,'1'		=> esc_html__( 'Yes', 'hitsxyz' )
		)
		,'default'  => 'default'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
	)
	,array(
		'id'        => 'hits_prod_header_layout_fullwidth'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Header Layout Fullwidth', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => true
		,'required'	=> array( 'hits_prod_layout_fullwidth', 'equals', '1' )
	)
	,array(
		'id'        => 'hits_prod_main_content_layout_fullwidth'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Main Content Layout Fullwidth', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => false
		,'required'	=> array( 'hits_prod_layout_fullwidth', 'equals', '1' )
	)
	,array(
		'id'        => 'hits_prod_footer_layout_fullwidth'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Footer Layout Fullwidth', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => false
		,'required'	=> array( 'hits_prod_layout_fullwidth', 'equals', '1' )
	)
	,array(
		'id'        => 'hits_prod_breadcrumb'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Breadcrumb', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => true
	)
	,array(
		'id'        => 'hits_prod_cloudzoom'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Cloud Zoom', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => true
	)
	,array(
		'id'        => 'hits_prod_lightbox'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Lightbox', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => true
	)
	,array(
		'id'        => 'hits_prod_attr_dropdown'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Attribute Dropdown', 'hitsxyz' )
		,'subtitle' => esc_html__( 'If you turn it off, the dropdown will be replaced by image or text label', 'hitsxyz' )
		,'default'  => true
	)
	,array(
		'id'        => 'hits_prod_attr_color_text'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Color Attribute Text', 'hitsxyz' )
		,'subtitle' => esc_html__( 'Show text for the Color attribute instead of color/color image', 'hitsxyz' )
		,'default'  => false
		,'required'	=> array( 'hits_prod_attr_dropdown', 'equals', '0' )
	)
	,array(
		'id'        => 'hits_prod_attr_color_variation_thumbnail'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Color Attribute Variation Thumbnail', 'hitsxyz' )
		,'subtitle' => esc_html__( 'Use the variation thumbnail for the Color attribute. The Color slug has to be "color". You need to specify Color for variation (not any)', 'hitsxyz' )
		,'default'  => true
		,'required'	=> array( 'hits_prod_attr_color_text', 'equals', '0' )
	)
	,array(
		'id'        => 'hits_prod_next_prev_navigation'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Next/Prev Product Navigation', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => false
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_prod_thumbnail'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Thumbnail', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'       	=> 'hits_prod_gallery_layout'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Product Gallery Layout', 'hitsxyz' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => array(
			'vertical'		=> esc_html__( 'Vertical', 'hitsxyz' )
			,'horizontal'	=> esc_html__( 'Horizontal', 'hitsxyz' )
			,'grid'			=> esc_html__( 'Grid', 'hitsxyz' )
		)
		,'default'  => 'vertical'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
	)
	,array(
		'id'        => 'hits_prod_thumbnails_slider_mobile'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Thumbnails Slider On Mobile', 'hitsxyz' )
		,'subtitle' => esc_html__( 'If enabled, it will change all thumbnail/gallery layouts to slider on mobile', 'hitsxyz' )
		,'default'  => true
		,'required'	=> array('hits_prod_gallery_layout', 'equals', 'grid')
	)
	,array(
		'id'        => 'hits_prod_group_heading'
		,'type'     => 'text'
		,'title'    => esc_html__( 'Heading For Grouped Product', 'hitsxyz' )
		,'subtitle' => esc_html__( 'Show this heading above list of grouped products', 'hitsxyz' )
		,'desc'     => ''
		,'default'  => 'Part Of This Collection'
	)
	,array(
		'id'        => 'hits_prod_wfbt_in_summary'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Frequently Bought Together In Summary', 'hitsxyz' )
		,'subtitle' => esc_html__( 'Move Frequently Bought Together to product summary in laptop screen & larger', 'hitsxyz' )
		,'default'  => true
	)
	,array(
		'id'        => 'hits_prod_label'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Label', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_prod_title'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Title', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_prod_title_in_content'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Title In Content', 'hitsxyz' )
		,'subtitle' => esc_html__( 'Display the product title in the page content instead of above the breadcrumbs', 'hitsxyz' )
		,'default'  => true
	)
	,array(
		'id'        => 'hits_prod_rating'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Rating', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_prod_sku'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product SKU', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_prod_availability'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Availability', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_prod_short_desc'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Short Description', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => false
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_prod_count_down'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Count Down', 'hitsxyz' )
		,'subtitle' => esc_html__( 'You have to activate PlaT plugin', 'hitsxyz' )
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_prod_price'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Price', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_prod_discount_percent'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Discount Percent', 'hitsxyz' )
		,'subtitle' => esc_html__( 'Show discount percent next to the price', 'hitsxyz' )
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
		,'required'	=> array( 'hits_prod_price', 'equals', '1' )
	)
	,array(
		'id'        => 'hits_prod_add_to_cart'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Add To Cart Button', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_prod_ajax_add_to_cart'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Ajax Add To Cart', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => true
		,'required'	=> array( 'hits_prod_add_to_cart', 'equals', '1' )
	)
	,array(
		'id'        => 'hits_prod_buy_now'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Buy Now Button', 'hitsxyz' )
		,'subtitle' => esc_html__( 'Only support the simple and variable products', 'hitsxyz' )
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_prod_brand'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Brands', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_prod_cat'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Categories', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => false
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_prod_tag'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Tags', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_prod_size_chart'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Size Chart', 'hitsxyz' )
		,'subtitle' => esc_html__( 'Size Chart Popup is only available if Attribute Dropdown is disabled and the slug of the Size attribute contain "size". Ex: taille-size', 'hitsxyz' )
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_prod_more_less_content'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product More/Less Content', 'hitsxyz' )
		,'subtitle' => esc_html__( 'Show more/less content in the Description tab', 'hitsxyz' )
		,'default'  => false
	)
	,array(
		'id'        => 'hits_prod_sharing'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Sharing', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_prod_sharing_sharethis'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Sharing - Use ShareThis', 'hitsxyz' )
		,'subtitle' => esc_html__( 'Use share buttons from sharethis.com. You need to add key below', 'hitsxyz' )
		,'default'  => false
		,'required'	=> array( 'hits_prod_sharing', 'equals', '1' )
	)
	,array(
		'id'        => 'hits_prod_sharing_sharethis_key'
		,'type'     => 'text'
		,'title'    => esc_html__( 'Product Sharing - ShareThis Key', 'hitsxyz' )
		,'subtitle' => esc_html__( 'You get it from script code. It is the value of "property" attribute', 'hitsxyz' )
		,'desc'     => ''
		,'default'  => ''
		,'required'	=> array( 'hits_prod_sharing', 'equals', '1' )
	)

	,array(
		'id'        => 'section-product-tabs'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Product Tabs', 'hitsxyz' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'        => 'hits_prod_tabs'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Tabs', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'       	=> 'hits_prod_tabs_position'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Product Tabs Position', 'hitsxyz' )
		,'subtitle' => ''
		,'desc'     => ''
		,'options'  => array(
			'after_summary'				=> esc_html__( 'After Summary', 'hitsxyz' )
			,'inside_summary'			=> esc_html__( 'Inside Summary', 'hitsxyz' )
		)
		,'default'  => 'after_summary'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
	)
	,array(
		'id'       	=> 'hits_prod_tabs_accordion'
		,'type'     => 'select'
		,'title'    => esc_html__( 'Product Tabs Accordion', 'hitsxyz' )
		,'subtitle' => esc_html__( 'Show tabs as accordion. If you add more custom tabs, please make sure that your tab content has heading (h2) at the top', 'hitsxyz' )
		,'desc'     => ''
		,'options'  => array(
			'0'				=> esc_html__( 'None', 'hitsxyz' )
			,'desktop'		=> esc_html__( 'On Desktop', 'hitsxyz' )
			,'mobile'		=> esc_html__( 'On Mobile', 'hitsxyz' )
			,'both'			=> esc_html__( 'On All Screens', 'hitsxyz' )
		)
		,'default'  => 'mobile'
		,'select2'	=> array('allowClear' => false, 'minimumResultsForSearch' => 'Infinity')
	)
	,array(
		'id'        => 'hits_prod_custom_tab'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Product Custom Tab', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => false
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_prod_custom_tab_title'
		,'type'     => 'text'
		,'title'    => esc_html__( 'Product Custom Tab Title', 'hitsxyz' )
		,'subtitle' => ''
		,'desc'     => ''
		,'default'  => 'Custom tab'
	)
	,array(
		'id'        => 'hits_prod_custom_tab_content'
		,'type'     => 'editor'
		,'title'    => esc_html__( 'Product Custom Tab Content', 'hitsxyz' )
		,'subtitle' => ''
		,'desc'     => ''
		,'default'  => esc_html__( 'Your custom content goes here. You can add the content for individual product', 'hitsxyz' )
		,'args'     => array(
			'wpautop'        => false
			,'media_buttons' => true
			,'textarea_rows' => 5
			,'teeny'         => false
			,'quicktags'     => true
		)
	)
	
	,array(
		'id'        => 'section-ads-banner'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Ads Banner', 'hitsxyz' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'        => 'hits_prod_ads_banner'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Ads Banner', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => false
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_prod_ads_banner_content'
		,'type'     => 'editor'
		,'title'    => esc_html__( 'Ads Banner Content', 'hitsxyz' )
		,'subtitle' => ''
		,'desc'     => ''
		,'default'  => ''
		,'args'     => array(
			'wpautop'        => false
			,'media_buttons' => true
			,'textarea_rows' => 5
			,'teeny'         => false
			,'quicktags'     => true
		)
	)
	
	,array(
		'id'        => 'section-related-up-sell-products'
		,'type'     => 'section'
		,'title'    => esc_html__( 'Related - Up-Sell', 'hitsxyz' )
		,'subtitle' => ''
		,'indent'   => false
	)
	,array(
		'id'        => 'hits_prod_related'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Related Products', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => true
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
	,array(
		'id'        => 'hits_prod_upsells'
		,'type'     => 'switch'
		,'title'    => esc_html__( 'Up-Sell Products', 'hitsxyz' )
		,'subtitle' => ''
		,'default'  => false
		,'on'		=> esc_html__( 'Show', 'hitsxyz' )
		,'off'		=> esc_html__( 'Hide', 'hitsxyz' )
	)
);

/*** Custom Code Tab ***/
$option_fields['custom-code'] = array(
	array(
		'id'        => 'hits_custom_css_code'
		,'type'     => 'ace_editor'
		,'title'    => esc_html__( 'Custom CSS Code', 'hitsxyz' )
		,'subtitle' => ''
		,'mode'     => 'css'
		,'theme'    => 'monokai'
		,'desc'     => ''
		,'default'  => ''
	)
	,array(
		'id'        => 'hits_custom_javascript_code'
		,'type'     => 'ace_editor'
		,'title'    => esc_html__( 'Custom Javascript Code', 'hitsxyz' )
		,'subtitle' => ''
		,'mode'     => 'javascript'
		,'theme'    => 'monokai'
		,'desc'     => ''
		,'default'  => ''
	)
);