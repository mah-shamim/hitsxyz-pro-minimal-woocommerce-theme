<?php
add_action('init', 'hitsxyz_get_default_theme_options');
function hitsxyz_get_default_theme_options(){
	global $hitsxyz_theme_options;
	if( empty( $hitsxyz_theme_options ) ){
		include get_template_directory() . '/admin/options.php';
		foreach( $option_fields as $fields ){
			foreach( $fields as $field ){
				if( in_array($field['type'], array('section', 'info')) ){
					continue;
				}
				if( isset($field['default']) ){
					$hitsxyz_theme_options[ $field['id'] ] = $field['default'];
				}
			}
		}
	}
}

function hitsxyz_get_theme_options( $key = '', $default = '' ){
	global $hitsxyz_theme_options;
	
	if( !$key ){
		return $hitsxyz_theme_options;
	}
	else if( isset($hitsxyz_theme_options[$key]) ){
		return $hitsxyz_theme_options[$key];
	}
	else{
		return $default;
	}
}

function hitsxyz_change_theme_options( $key, $value ){
	global $hitsxyz_theme_options;
	if( isset( $hitsxyz_theme_options[$key] ) ){
		$hitsxyz_theme_options[$key] = $value;
	}
}

add_filter('redux/validate/hitsxyz_theme_options/defaults', 'hitsxyz_set_default_color_options_on_reset');
add_filter('redux/validate/hitsxyz_theme_options/defaults_section', 'hitsxyz_set_default_color_options_on_reset');
function hitsxyz_set_default_color_options_on_reset( $options_defaults ){
	if( !isset($options_defaults['redux-section']) || ( isset($options_defaults['redux-section']) && $options_defaults['redux-section'] == 2 ) ){
		if( isset($options_defaults['hits_color_scheme']) ){
			$preset_colors = array();
			include get_template_directory() . '/admin/preset-colors/' . $options_defaults['hits_color_scheme'] . '.php';
			foreach( $preset_colors as $key => $value ){
				if( isset($options_defaults[$key]) ){
					$options_defaults[$key] = $value;
				}
			}
		}
	}
	return $options_defaults;
}

function hitsxyz_get_preset_color_options( $color ){
	$preset_colors = array();
	include get_template_directory() . '/admin/preset-colors/' . $color . '.php';
	return $preset_colors;
}

add_action('add_option_hitsxyz_theme_options', 'hitsxyz_create_dynamic_css', 10, 2);
function hitsxyz_create_dynamic_css( $option, $value ){
	hitsxyz_update_dynamic_css($value, $value, $option);
}

add_action('update_option_hitsxyz_theme_options', 'hitsxyz_update_dynamic_css', 10, 3);
function hitsxyz_update_dynamic_css( $old_value, $value, $option ){
	if( is_array($value) ){
		$data = $value;
		$upload_dir = wp_get_upload_dir();
		$filename_dir = trailingslashit($upload_dir['basedir']) . strtolower(str_replace(' ', '', wp_get_theme()->get('Name'))) . '.css';
		ob_start();
		include get_template_directory() . '/framework/dynamic_style.php';
		$dynamic_css = ob_get_contents();
		ob_end_clean();
		
		global $wp_filesystem;
		if( empty( $wp_filesystem ) ) {
			require_once ABSPATH .'/wp-admin/includes/file.php';
			WP_Filesystem();
		}
		
		$creds = request_filesystem_credentials($filename_dir, '', false, false, array());
		if( ! WP_Filesystem($creds) ){
			return false;
		}

		if( $wp_filesystem ) {
			$wp_filesystem->put_contents(
				$filename_dir,
				$dynamic_css,
				FS_CHMOD_FILE
			);
		}
	}
}

add_filter('redux/hitsxyz_theme_options/localize', 'hitsxyz_remove_redux_ads', 99);
function hitsxyz_remove_redux_ads( $localize_data ){
	if( isset($localize_data['rAds']) ){
		$localize_data['rAds'] = '';
	}
	return $localize_data;
}

if( is_admin() && isset($_GET['page']) && $_GET['page'] == 'themeoptions' ){
	add_filter('upload_mimes', 'hitsxyz_allow_upload_font_files');
	function hitsxyz_allow_upload_font_files( $existing_mimes = array() ){
		$existing_mimes['ttf'] = 'font/ttf';
		return $existing_mimes;
	}
}

function hitsxyz_get_footer_block_options(){
	$footer_blocks = array('0' => esc_html__('No Footer', 'hitsxyz'));
	$args = array(
		'post_type'			=> 'hits_footer_block'
		,'post_status'	 	=> 'publish'
		,'posts_per_page' 	=> -1
	);

	$posts = new WP_Query($args);

	if( !empty( $posts->posts ) && is_array( $posts->posts ) ){
		foreach( $posts->posts as $p ){
			$footer_blocks[$p->ID] = $p->post_title;
		}
	}

	wp_reset_postdata();
	
	return $footer_blocks;
}