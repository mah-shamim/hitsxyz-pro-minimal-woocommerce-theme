<?php
if( !isset($data) ){
	$data = hitsxyz_get_theme_options();
}

$default_options = array(
				'hits_layout_fullwidth'			=> 0
				,'hits_logo_width'				=> "160"
				,'hits_device_logo_width'			=> "120"
				,'hits_header_slide_notice_timing' => "15"
				,'hits_custom_font_ttf'			=> array( 'url' => '' )
		);
		
foreach( $default_options as $option_name => $value ){
	if( isset($data[$option_name]) ){
		$default_options[$option_name] = $data[$option_name];
	}
}

extract($default_options);
		
$default_colors = array(
				'hits_main_content_background_color'				=>	'#ffffff'
				,'hits_primary_color'								=>	'#d10202'
				,'hits_text_color_in_bg_primary'					=>	'#ffffff'
				,'hits_text_color'								=>	'#000000'
				,'hits_heading_color'								=>	'#000000'
				,'hits_gray_text_color'							=>	'#848484'
				,'hits_gray_bg_color'								=>	'#efefef'
				,'hits_text_in_gray_bg_color'						=>	'#000000'
				,'hits_dropdown_bg_color'							=>	'#ffffff'
				,'hits_dropdown_color'							=>	'#000000'
				,'hits_link_color'								=>	'#d10202'
				,'hits_link_color_hover'							=>	'#848484'
				,'hits_icon_hover_color'							=>	'#d10202'
				,'hits_tags_color'								=>	'#848484'
				,'hits_tags_background_color'						=>	'#ffffff'
				,'hits_tags_border_color'							=>	'#ebebeb'
				,'hits_blockquote_icon_color'						=>	'#959595'
				,'hits_blockquote_text_color'						=>	'#000000'
				,'hits_border_color'								=>	'#ebebeb'
				,'hits_input_text_color'							=>	'#000000'
				,'hits_input_background_color'					=>	'#ffffff'
				,'hits_input_border_color'						=>	'#ebebeb'
				,'hits_button_text_color'							=>	'#ffffff'
				,'hits_button_background_color'					=>	'#000000'
				,'hits_button_border_color'						=>	'#000000'
				,'hits_button_text_hover_color'					=>	'#ffffff'
				,'hits_button_background_hover_color'				=>	'#d10202'
				,'hits_button_border_hover_color'					=>	'#d10202'
				,'hits_button_thumbnail_text_color'				=>	'#000000'
				,'hits_button_thumbnail_bg_color'					=>	'#ffffff'
				,'hits_button_thumbnail_hover_text_color'			=>	'#ffffff'
				,'hits_button_thumbnail_hover_bg_color'			=>	'#d10202'
				,'hits_breadcrumb_background_color'				=>	'#ffffff'
				,'hits_breadcrumb_text_color'						=>	'#000000'
				,'hits_breadcrumb_link_color'						=>	'#848484'
				,'hits_header_top_background_color'				=>	'#000000'
				,'hits_header_top_text_color'						=>	'#ffffff'
				,'hits_header_top_border_color'					=>	'#000000'
				,'hits_header_top_link_hover_color'				=>	'#848484'
				,'hits_header_top_icon_count_background_color'	=>	'#ffffff'
				,'hits_header_top_icon_count_text_color'			=>	'#000000'
				,'hits_header_middle_background_color'			=>	'#ffffff'
				,'hits_header_middle_text_color'					=>	'#000000'
				,'hits_header_middle_border_color'				=>	'#d6d6d6'
				,'hits_header_middle_link_hover_color'			=>	'#848484'
				,'hits_header_icon_count_background_color'		=>	'#000000'
				,'hits_header_icon_count_text_color'				=>	'#ffffff'
				,'hits_header_bottom_background_color'			=>	'#ffffff'
				,'hits_header_bottom_text_color'					=>	'#000000'
				,'hits_header_bottom_border_color'				=>	'#d6d6d6'
				,'hits_header_bottom_link_hover_color'			=>	'#848484'
				,'hits_footer_background_color'					=>	'#ffffff'
				,'hits_footer_text_color'							=>	'#848484'
				,'hits_footer_link_hover_color'					=>	'#d10202'
				,'hits_footer_border_color'						=>	'#d6d6d6'
				,'hits_rating_color'								=>	'#000000'
				,'hits_product_price_color'						=>	'#000000'
				,'hits_product_sale_price_color'					=>	'#848484'
				,'hits_product_sale_label_text_color'				=>	'#ffffff'
				,'hits_product_sale_label_background_color'		=>	'#000000'
				,'hits_product_new_label_text_color'				=>	'#ffffff'
				,'hits_product_new_label_background_color'		=>	'#ffa632'
				,'hits_product_feature_label_text_color'			=>	'#ffffff'
				,'hits_product_feature_label_background_color'	=>	'#d10202'
				,'hits_product_outstock_label_text_color'			=>	'#ffffff'
				,'hits_product_outstock_label_background_color'	=>	'#919191'
				,'hits_product_meta_label_text_color'				=>	'#d10202'
);

$data = apply_filters('hitsxyz_custom_style_data', $data);

foreach( $default_colors as $option_name => $default_color ){
	if( isset($data[$option_name]['rgba']) ){
		$default_colors[$option_name] = $data[$option_name]['rgba'];
	}
	else if( isset($data[$option_name]['color']) ){
		$default_colors[$option_name] = $data[$option_name]['color'];
	}
}

extract( $default_colors );

/* Parse font option. Ex: if option name is hits_body_font, we will have variables below:
* hits_body_font (font-family)
* hits_body_font_weight
* hits_body_font_style
* hits_body_font_size
* hits_body_font_line_height
* hits_body_font_letter_spacing
*/
$font_option_names = array(
							'hits_body_font',
							'hits_body_font_medium',
							'hits_body_font_bold',
							'hits_heading_font',
							'hits_menu_font',
							'hits_sidebar_menu_font',
							'hits_mobile_menu_font',
							'hits_button_font',
							);
$font_size_option_names = array( 
							'hits_h1_font', 
							'hits_h2_font', 
							'hits_h3_font', 
							'hits_h4_font', 
							'hits_h5_font', 
							'hits_h6_font',
							'hits_sub_menu_font',
							'hits_sidebar_submenu_font',
							'hits_blockquote_font',
							'hits_single_product_price_font',
							'hits_single_product_sale_price_font',
							'hits_h1_ipad_font', 
							'hits_h2_ipad_font', 
							'hits_h3_ipad_font', 
							'hits_h4_ipad_font',
							'hits_h5_ipad_font',
							'hits_h6_ipad_font',
							'hits_sidebar_menu_ipad_font',
							'hits_sidebar_submenu_ipad_font',
							'hits_single_product_price_ipad_font',
							'hits_single_product_sale_price_ipad_font',
							'hits_h1_mobile_font',
							'hits_h2_mobile_font',
							'hits_h3_mobile_font',
							'hits_h4_mobile_font',
							'hits_h5_mobile_font',
							'hits_h6_mobile_font',
							);
$font_option_names = array_merge($font_option_names, $font_size_option_names);
foreach( $font_option_names as $option_name ){
	$default = array(
		$option_name 						=> 'inherit'
		,$option_name . '_weight' 			=> 'normal'
		,$option_name . '_style' 			=> 'normal'
		,$option_name . '_size' 			=> 'inherit'
		,$option_name . '_line_height' 		=> 'inherit'
		,$option_name . '_letter_spacing' 	=> 'inherit'
		,$option_name . '_transform' 		=> 'inherit'
	);
	if( is_array($data[$option_name]) ){
		if( !empty($data[$option_name]['font-family']) ){
			$default[$option_name] = $data[$option_name]['font-family'];
		}
		if( !empty($data[$option_name]['font-weight']) ){
			$default[$option_name . '_weight'] = $data[$option_name]['font-weight'];
		}
		if( !empty($data[$option_name]['font-style']) ){
			$default[$option_name . '_style'] = $data[$option_name]['font-style'];
		}
		if( !empty($data[$option_name]['font-size']) ){
			$default[$option_name . '_size'] = $data[$option_name]['font-size'];
		}
		if( !empty($data[$option_name]['line-height']) ){
			$default[$option_name . '_line_height'] = $data[$option_name]['line-height'];
		}
		if( !empty($data[$option_name]['letter-spacing']) ){
			$default[$option_name . '_letter_spacing'] = $data[$option_name]['letter-spacing'];
		}
		if( !empty($data[$option_name]['text-transform']) ){
			$default[$option_name . '_transform'] = $data[$option_name]['text-transform'];
		}
	}
	extract( $default );
}

/* Custom Font */
if( isset($hits_custom_font_ttf) && $hits_custom_font_ttf['url'] ): ?>
@font-face {
	font-family: <?php echo esc_html($ts_custom_font_ttf['name']); ?>;
	src:url('<?php echo esc_url($hits_custom_font_ttf['url']); ?>') format('truetype');
	font-weight: normal;
	font-style: normal;
}
<?php endif; ?>	
	
:root{
	--hitsxyz-logo-width: <?php echo absint($hits_logo_width); ?>px;
	--hitsxyz-logo-device-width: <?php echo absint($hits_device_logo_width); ?>px;
	
	<?php if( $hits_header_slide_notice_timing ): ?>
	--hitsxyz-marquee-timing: <?php echo esc_html($hits_header_slide_notice_timing); ?>s;
	<?php endif; ?>
	
	--hitsxyz-main-font-family: <?php echo esc_html($hits_body_font); ?>;
	--hitsxyz-main-font-style: <?php echo esc_html($hits_body_font_style); ?>;
	--hitsxyz-main-font-weight: <?php echo esc_html($hits_body_font_weight); ?>;
	--hitsxyz-main-font-medium-family: <?php echo esc_html($hits_body_font_medium); ?>;
	--hitsxyz-main-font-medium-style: <?php echo esc_html($hits_body_font_medium_style); ?>;
	--hitsxyz-main-font-medium-weight: <?php echo esc_html($hits_body_font_medium_weight); ?>;
	--hitsxyz-main-font-bold-family: <?php echo esc_html($hits_body_font_bold); ?>;
	--hitsxyz-main-font-bold-style: <?php echo esc_html($hits_body_font_bold_style); ?>;
	--hitsxyz-main-font-bold-weight: <?php echo esc_html($hits_body_font_bold_weight); ?>;
	--hitsxyz-body-font-size: <?php echo esc_html($hits_body_font_size); ?>;
	--hitsxyz-body-line-height: <?php echo esc_html($hits_body_font_line_height); ?>;
	--hitsxyz-body-letter-spacing: <?php echo esc_html($hits_body_font_letter_spacing); ?>;
	
	--hitsxyz-button-font-family: <?php echo esc_html($hits_button_font); ?>;
	--hitsxyz-button-font-style: <?php echo esc_html($hits_button_font_style); ?>;
	--hitsxyz-button-font-weight: <?php echo esc_html($hits_button_font_weight); ?>;
	--hitsxyz-button-transform: <?php echo esc_html($hits_button_font_transform); ?>;
	--hitsxyz-button-font-size: <?php echo esc_html($hits_button_font_size); ?>;
	--hitsxyz-button-letter-spacing: <?php echo esc_html($hits_button_font_letter_spacing); ?>;
	
	--hitsxyz-menu-font-family: <?php echo esc_html($hits_menu_font); ?>;
	--hitsxyz-menu-font-style: <?php echo esc_html($hits_menu_font_style); ?>;
	--hitsxyz-menu-font-weight: <?php echo esc_html($hits_menu_font_weight); ?>;
	--hitsxyz-menu-font-size: <?php echo esc_html($hits_menu_font_size); ?>;
	--hitsxyz-menu-line-height: <?php echo esc_html($hits_menu_font_line_height); ?>;
	--hitsxyz-submenu-font-size: <?php echo esc_html($hits_sub_menu_font_size); ?>;
	--hitsxyz-submenu-line-height: <?php echo esc_html($hits_sub_menu_font_line_height); ?>;
	
	--hitsxyz-sidebar-menu-font-family: <?php echo esc_html($hits_sidebar_menu_font); ?>;
	--hitsxyz-sidebar-menu-font-style: <?php echo esc_html($hits_sidebar_menu_font_style); ?>;
	--hitsxyz-sidebar-menu-font-weight: <?php echo esc_html($hits_sidebar_menu_font_weight); ?>;
	--hitsxyz-sidebar-menu-font-size: <?php echo esc_html($hits_sidebar_menu_font_size); ?>;
	--hitsxyz-sidebar-menu-line-height: <?php echo esc_html($hits_sidebar_menu_font_line_height); ?>;
	--hitsxyz-sidebar-submenu-font-size: <?php echo esc_html($hits_sidebar_submenu_font_size); ?>;
	--hitsxyz-sidebar-submenu-line-height: <?php echo esc_html($hits_sidebar_submenu_font_line_height); ?>;
	--hitsxyz-sidebar-menu-ipad-font-size: <?php echo esc_html($hits_sidebar_menu_ipad_font_size); ?>;
	--hitsxyz-sidebar-menu-ipad-line-height: <?php echo esc_html($hits_sidebar_menu_ipad_font_line_height); ?>;
	--hitsxyz-sidebar-submenu-ipad-font-size: <?php echo esc_html($hits_sidebar_submenu_ipad_font_size); ?>;
	--hitsxyz-sidebar-submenu-ipad-line-height: <?php echo esc_html($hits_sidebar_submenu_ipad_font_line_height); ?>;
	
	--hitsxyz-mobile-menu-font-family: <?php echo esc_html($hits_sidebar_menu_font); ?>;
	--hitsxyz-mobile-menu-font-style: <?php echo esc_html($hits_sidebar_menu_font_style); ?>;
	--hitsxyz-mobile-menu-font-weight: <?php echo esc_html($hits_sidebar_menu_font_weight); ?>;
	--hitsxyz-mobile-menu-font-size: <?php echo esc_html($hits_mobile_menu_font_size); ?>;
	--hitsxyz-mobile-menu-line-height: <?php echo esc_html($hits_mobile_menu_font_line_height); ?>;
	
	--hitsxyz-blockquote-font-size: <?php echo esc_html($hits_blockquote_font_size); ?>;
	--hitsxyz-single-product-price-font-size: <?php echo esc_html($hits_single_product_price_font_size); ?>;
	--hitsxyz-single-product-sale-price-font-size: <?php echo esc_html($hits_single_product_sale_price_font_size); ?>;
	--hitsxyz-single-product-price-ipad-font-size: <?php echo esc_html($hits_single_product_price_ipad_font_size); ?>;
	--hitsxyz-single-product-sale-price-ipad-font-size: <?php echo esc_html($hits_single_product_sale_price_ipad_font_size); ?>;
	
	--hitsxyz-heading-font-family: <?php echo esc_html($hits_heading_font); ?>;
	--hitsxyz-heading-font-style: <?php echo esc_html($hits_heading_font_style); ?>;
	--hitsxyz-heading-font-weight: <?php echo esc_html($hits_heading_font_weight); ?>;
	--hitsxyz-h1-font-size: <?php echo esc_html($hits_h1_font_size); ?>;
	--hitsxyz-h1-line-height: <?php echo esc_html($hits_h1_font_line_height); ?>;
	--hitsxyz-h1-letter-spacing: <?php echo esc_html($hits_h1_font_letter_spacing); ?>;
	--hitsxyz-h2-font-size: <?php echo esc_html($hits_h2_font_size); ?>;
	--hitsxyz-h2-line-height: <?php echo esc_html($hits_h2_font_line_height); ?>;
	--hitsxyz-h2-letter-spacing: <?php echo esc_html($hits_h2_font_letter_spacing); ?>;
	--hitsxyz-h3-font-size: <?php echo esc_html($hits_h3_font_size); ?>;
	--hitsxyz-h3-line-height: <?php echo esc_html($hits_h3_font_line_height); ?>;
	--hitsxyz-h3-letter-spacing: <?php echo esc_html($hits_h3_font_letter_spacing); ?>;
	--hitsxyz-h4-font-size: <?php echo esc_html($hits_h4_font_size); ?>;
	--hitsxyz-h4-line-height: <?php echo esc_html($hits_h4_font_line_height); ?>;
	--hitsxyz-h4-letter-spacing: <?php echo esc_html($hits_h4_font_letter_spacing); ?>;
	--hitsxyz-h5-font-size: <?php echo esc_html($hits_h5_font_size); ?>;
	--hitsxyz-h5-line-height: <?php echo esc_html($hits_h5_font_line_height); ?>;
	--hitsxyz-h5-letter-spacing: <?php echo esc_html($hits_h5_font_letter_spacing); ?>;
	--hitsxyz-h6-font-size: <?php echo esc_html($hits_h6_font_size); ?>;
	--hitsxyz-h6-line-height: <?php echo esc_html($hits_h6_font_line_height); ?>;
	--hitsxyz-h6-letter-spacing: <?php echo esc_html($hits_h6_font_letter_spacing); ?>;
	--hitsxyz-h1-ipad-font-size: <?php echo esc_html($hits_h1_ipad_font_size); ?>;
	--hitsxyz-h1-ipad-line-height: <?php echo esc_html($hits_h1_ipad_font_line_height); ?>;
	--hitsxyz-h1-ipad-letter-spacing: <?php echo esc_html($hits_h1_ipad_font_letter_spacing); ?>;
	--hitsxyz-h2-ipad-font-size: <?php echo esc_html($hits_h2_ipad_font_size); ?>;
	--hitsxyz-h2-ipad-line-height: <?php echo esc_html($hits_h2_ipad_font_line_height); ?>;
	--hitsxyz-h2-ipad-letter-spacing: <?php echo esc_html($hits_h2_ipad_font_letter_spacing); ?>;
	--hitsxyz-h3-ipad-font-size: <?php echo esc_html($hits_h3_ipad_font_size); ?>;
	--hitsxyz-h3-ipad-line-height: <?php echo esc_html($hits_h3_ipad_font_line_height); ?>;
	--hitsxyz-h3-ipad-letter-spacing: <?php echo esc_html($hits_h3_ipad_font_letter_spacing); ?>;
	--hitsxyz-h4-ipad-font-size: <?php echo esc_html($hits_h4_ipad_font_size); ?>;
	--hitsxyz-h4-ipad-line-height: <?php echo esc_html($hits_h4_ipad_font_line_height); ?>;
	--hitsxyz-h4-ipad-letter-spacing: <?php echo esc_html($hits_h4_ipad_font_letter_spacing); ?>;
	--hitsxyz-h5-ipad-font-size: <?php echo esc_html($hits_h5_ipad_font_size); ?>;
	--hitsxyz-h5-ipad-line-height: <?php echo esc_html($hits_h5_ipad_font_line_height); ?>;
	--hitsxyz-h5-ipad-letter-spacing: <?php echo esc_html($hits_h5_ipad_font_letter_spacing); ?>;
	--hitsxyz-h6-ipad-font-size: <?php echo esc_html($hits_h6_ipad_font_size); ?>;
	--hitsxyz-h6-ipad-line-height: <?php echo esc_html($hits_h6_ipad_font_line_height); ?>;
	--hitsxyz-h6-ipad-letter-spacing: <?php echo esc_html($hits_h6_ipad_font_letter_spacing); ?>;
	--hitsxyz-h1-mobile-font-size: <?php echo esc_html($hits_h1_mobile_font_size); ?>;
	--hitsxyz-h1-mobile-line-height: <?php echo esc_html($hits_h1_mobile_font_line_height); ?>;
	--hitsxyz-h1-mobile-letter-spacing: <?php echo esc_html($hits_h1_mobile_font_letter_spacing); ?>;
	--hitsxyz-h2-mobile-font-size: <?php echo esc_html($hits_h2_mobile_font_size); ?>;
	--hitsxyz-h2-mobile-line-height: <?php echo esc_html($hits_h2_mobile_font_line_height); ?>;
	--hitsxyz-h2-mobile-letter-spacing: <?php echo esc_html($hits_h2_mobile_font_letter_spacing); ?>;
	--hitsxyz-h3-mobile-font-size: <?php echo esc_html($hits_h3_mobile_font_size); ?>;
	--hitsxyz-h3-mobile-line-height: <?php echo esc_html($hits_h3_mobile_font_line_height); ?>;
	--hitsxyz-h3-mobile-letter-spacing: <?php echo esc_html($hits_h3_mobile_font_letter_spacing); ?>;
	--hitsxyz-h4-mobile-font-size: <?php echo esc_html($hits_h4_mobile_font_size); ?>;
	--hitsxyz-h4-mobile-line-height: <?php echo esc_html($hits_h4_mobile_font_line_height); ?>;
	--hitsxyz-h4-mobile-letter-spacing: <?php echo esc_html($hits_h4_mobile_font_letter_spacing); ?>;
	--hitsxyz-h5-mobile-font-size: <?php echo esc_html($hits_h5_mobile_font_size); ?>;
	--hitsxyz-h5-mobile-line-height: <?php echo esc_html($hits_h5_mobile_font_line_height); ?>;
	--hitsxyz-h5-mobile-letter-spacing: <?php echo esc_html($hits_h5_mobile_font_letter_spacing); ?>;
	--hitsxyz-h6-mobile-font-size: <?php echo esc_html($hits_h6_mobile_font_size); ?>;
	--hitsxyz-h6-mobile-line-height: <?php echo esc_html($hits_h6_mobile_font_line_height); ?>;
	--hitsxyz-h6-mobile-letter-spacing: <?php echo esc_html($hits_h6_mobile_font_letter_spacing); ?>;
	
	--hitsxyz-primary-color: <?php echo esc_html($hits_primary_color); ?>;
	--hitsxyz-text-in-primary-color: <?php echo esc_html($hits_text_color_in_bg_primary); ?>;
	<?php if( strpos($hits_primary_color, 'rgba') !== false ): ?>
	--hitsxyz-primary-loading-color: <?php echo esc_html(str_replace('1)', '0.5)', esc_html($hits_primary_color))); ?>;
	<?php endif; ?>
	--hitsxyz-main-bg: <?php echo esc_html($hits_main_content_background_color); ?>;
	--hitsxyz-text-color: <?php echo esc_html($hits_text_color); ?>;
	--hitsxyz-heading-color: <?php echo esc_html($hits_heading_color); ?>;
	--hitsxyz-gray-color: <?php echo esc_html($hits_gray_text_color); ?>;
	--hitsxyz-gray-bg: <?php echo esc_html($hits_gray_bg_color); ?>;
	--hitsxyz-text-in-gray-bg: <?php echo esc_html($hits_text_in_gray_bg_color); ?>;
	--hitsxyz-dropdown-bg: <?php echo esc_html($hits_dropdown_bg_color); ?>;
	--hitsxyz-dropdown-color: <?php echo esc_html($hits_dropdown_color); ?>;
	--hitsxyz-link-color: <?php echo esc_html($hits_link_color); ?>;
	--hitsxyz-link-hover-color: <?php echo esc_html($hits_link_color_hover); ?>;
	--hitsxyz-icon-hover-color: <?php echo esc_html($hits_icon_hover_color); ?>;
	--hitsxyz-tag-color: <?php echo esc_html($hits_tags_color); ?>;
	--hitsxyz-tag-bg: <?php echo esc_html($hits_tags_background_color); ?>;
	--hitsxyz-tag-border: <?php echo esc_html($hits_tags_border_color); ?>;
	--hitsxyz-blockquote-icon-color: <?php echo esc_html($hits_blockquote_icon_color); ?>;
	--hitsxyz-blockquote-text-color: <?php echo esc_html($hits_blockquote_text_color); ?>;
	--hitsxyz-border: <?php echo esc_html($hits_border_color); ?>;
	
	--hitsxyz-input-color: <?php echo esc_html($hits_input_text_color); ?>;
	--hitsxyz-input-background-color: <?php echo esc_html($hits_input_background_color); ?>;
	--hitsxyz-input-border: <?php echo esc_html($hits_input_border_color); ?>;
	
	--hitsxyz-button-color: <?php echo esc_html($hits_button_text_color); ?>;
	--hitsxyz-button-bg: <?php echo esc_html($hits_button_background_color); ?>;
	--hitsxyz-button-border: <?php echo esc_html($hits_button_border_color); ?>;
	--hitsxyz-button-hover-color: <?php echo esc_html($hits_button_text_hover_color); ?>;
	--hitsxyz-button-hover-bg: <?php echo esc_html($hits_button_background_hover_color); ?>;
	--hitsxyz-button-hover-border: <?php echo esc_html($hits_button_border_hover_color); ?>;
	<?php if( strpos($hits_button_text_color, 'rgba') !== false ): ?>
	--hitsxyz-button-loading-color: <?php echo esc_html(str_replace('1)', '0.5)', esc_html($hits_button_text_color))); ?>;
	<?php endif; ?>
	<?php if( strpos($hits_button_text_hover_color, 'rgba') !== false ): ?>
	--hitsxyz-button-loading-hover-color: <?php echo esc_html(str_replace('1)', '0.5)', esc_html($hits_button_text_hover_color))); ?>;
	<?php endif; ?>
	--hitsxyz-button-thumbnail-color: <?php echo esc_html($hits_button_thumbnail_text_color); ?>;
	--hitsxyz-button-thumbnail-bg: <?php echo esc_html($hits_button_thumbnail_bg_color); ?>;
	--hitsxyz-button-thumbnail-hover-color: <?php echo esc_html($hits_button_thumbnail_hover_text_color); ?>;
	--hitsxyz-button-thumbnail-hover-bg: <?php echo esc_html($hits_button_thumbnail_hover_bg_color); ?>;
	<?php if( strpos($hits_button_thumbnail_text_color, 'rgba') !== false ): ?>
	--hitsxyz-button-thumbnail-loading-color: <?php echo esc_html(str_replace('1)', '0.5)', esc_html($hits_button_thumbnail_text_color))); ?>;
	<?php endif; ?>
	<?php if( strpos($hits_button_thumbnail_hover_text_color, 'rgba') !== false ): ?>
	--hitsxyz-button-thumbnail-loading-hover-color: <?php echo esc_html(str_replace('1)', '0.5)', esc_html($hits_button_thumbnail_hover_text_color))); ?>;
	<?php endif; ?>
	
	--hitsxyz-breadcrumb-bg: <?php echo esc_html($hits_breadcrumb_background_color); ?>;
	--hitsxyz-breadcrumb-color: <?php echo esc_html($hits_breadcrumb_text_color); ?>;
	--hitsxyz-breadcrumb-link-color: <?php echo esc_html($hits_breadcrumb_link_color); ?>;
	
	--hitsxyz-top-bg: <?php echo esc_html($hits_header_top_background_color); ?>;
	--hitsxyz-top-color: <?php echo esc_html($hits_header_top_text_color); ?>;
	--hitsxyz-top-border: <?php echo esc_html($hits_header_top_border_color); ?>;
	--hitsxyz-top-link-hover-color: <?php echo esc_html($hits_header_top_link_hover_color); ?>;
	--hitsxyz-top-cart-number-bg: <?php echo esc_html($hits_header_top_icon_count_background_color); ?>;
	--hitsxyz-top-cart-number-color: <?php echo esc_html($hits_header_top_icon_count_text_color); ?>;
	--hitsxyz-middle-bg: <?php echo esc_html($hits_header_middle_background_color); ?>;
	--hitsxyz-middle-color: <?php echo esc_html($hits_header_middle_text_color); ?>;
	--hitsxyz-middle-border: <?php echo esc_html($hits_header_middle_border_color); ?>;
	--hitsxyz-middle-link-hover-color: <?php echo esc_html($hits_header_middle_link_hover_color); ?>;
	--hitsxyz-middle-cart-number-bg: <?php echo esc_html($hits_header_icon_count_background_color); ?>;
	--hitsxyz-middle-cart-number-color: <?php echo esc_html($hits_header_icon_count_text_color); ?>;
	--hitsxyz-bottom-bg: <?php echo esc_html($hits_header_bottom_background_color); ?>;
	--hitsxyz-bottom-color: <?php echo esc_html($hits_header_bottom_text_color); ?>;
	--hitsxyz-bottom-border: <?php echo esc_html($hits_header_bottom_border_color); ?>;
	--hitsxyz-bottom-link-hover-color: <?php echo esc_html($hits_header_bottom_link_hover_color); ?>;
	
	--hitsxyz-footer-bg: <?php echo esc_html($hits_footer_background_color); ?>;
	--hitsxyz-footer-color: <?php echo esc_html($hits_footer_text_color); ?>;
	--hitsxyz-footer-link-color: <?php echo esc_html($hits_footer_link_hover_color); ?>;
	--hitsxyz-footer-border: <?php echo esc_html($hits_footer_border_color); ?>;
	
	--hitsxyz-star-color: <?php echo esc_html($hits_rating_color); ?>;
	--hitsxyz-product-price-color: <?php echo esc_html($hits_product_price_color); ?>;
	--hitsxyz-product-sale-price-color: <?php echo esc_html($hits_product_sale_price_color); ?>;
	--hitsxyz-sale-label-color: <?php echo esc_html($hits_product_sale_label_text_color); ?>;
	--hitsxyz-sale-label-bg: <?php echo esc_html($hits_product_sale_label_background_color); ?>;
	--hitsxyz-new-label-color: <?php echo esc_html($hits_product_new_label_text_color); ?>;
	--hitsxyz-new-label-bg: <?php echo esc_html($hits_product_new_label_background_color); ?>;
	--hitsxyz-hot-label-color: <?php echo esc_html($hits_product_feature_label_text_color); ?>;
	--hitsxyz-hot-label-bg: <?php echo esc_html($hits_product_feature_label_background_color); ?>;
	--hitsxyz-soldout-label-color: <?php echo esc_html($hits_product_outstock_label_text_color); ?>;
	--hitsxyz-soldout-label-bg: <?php echo esc_html($hits_product_outstock_label_background_color); ?>;
	--hitsxyz-meta-label-color: <?php echo esc_html($hits_product_meta_label_text_color); ?>;
}