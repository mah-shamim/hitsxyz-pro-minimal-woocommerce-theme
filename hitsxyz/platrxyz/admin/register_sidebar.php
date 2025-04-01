<?php 
function hitsxyz_get_list_sidebars(){
	$default_sidebars = array(
						array(
							'name' => esc_html__( 'Home Sidebar', 'hitsxyz' ),
							'id' => 'home-sidebar',
							'before_widget' => '<section id="%1$s" class="widget-container %2$s">',
							'after_widget' => '</section>',
							'before_title' => '<div class="widget-title-wrapper"><a class="block-control" href="javascript:void(0)"></a><h3 class="widget-title heading-title">',
							'after_title' => '</h3></div>',
						)
						,array(
							'name' => esc_html__( 'Blog Sidebar', 'hitsxyz' ),
							'id' => 'blog-sidebar',
							'before_widget' => '<section id="%1$s" class="widget-container %2$s">',
							'after_widget' => '</section>',
							'before_title' => '<div class="widget-title-wrapper"><a class="block-control" href="javascript:void(0)"></a><h3 class="widget-title heading-title">',
							'after_title' => '</h3></div>',
						)
						,array(
							'name' => esc_html__( 'Blog Detail Sidebar', 'hitsxyz' ),
							'id' => 'blog-detail-sidebar',
							'before_widget' => '<section id="%1$s" class="widget-container %2$s">',
							'after_widget' => '</section>',
							'before_title' => '<div class="widget-title-wrapper"><a class="block-control" href="javascript:void(0)"></a><h3 class="widget-title heading-title">',
							'after_title' => '</h3></div>',
						)
						,array(
							'name' => esc_html__( 'Product Category Sidebar', 'hitsxyz' ),
							'id' => 'product-category-sidebar',
							'before_widget' => '<section id="%1$s" class="widget-container %2$s">',
							'after_widget' => '</section>',
							'before_title' => '<div class="widget-title-wrapper"><a class="block-control" href="javascript:void(0)"></a><h3 class="widget-title heading-title">',
							'after_title' => '</h3></div>',
						)
						,array(
							'name' => esc_html__( 'Filter Widget Area', 'hitsxyz' ),
							'id' => 'filter-widget-area',
							'before_widget' => '<section id="%1$s" class="widget-container %2$s">',
							'after_widget' => '</section>',
							'before_title' => '<div class="widget-title-wrapper"><a class="block-control" href="javascript:void(0)"></a><h3 class="widget-title heading-title">',
							'after_title' => '</h3></div>',
						)
						,array(
							'name' => esc_html__( 'Product Detail Sidebar', 'hitsxyz' ),
							'id' => 'product-detail-sidebar',
							'before_widget' => '<section id="%1$s" class="widget-container %2$s">',
							'after_widget' => '</section>',
							'before_title' => '<div class="widget-title-wrapper"><a class="block-control" href="javascript:void(0)"></a><h3 class="widget-title heading-title">',
							'after_title' => '</h3></div>',
						)
					);
					
	$custom_sidebars = hitsxyz_get_custom_sidebars();
	if( is_array($custom_sidebars) && !empty($custom_sidebars) ){
		foreach( $custom_sidebars as $name ){
			$default_sidebars[] = array(
								'name' => ''.$name.'',
								'id' => sanitize_title($name),
								'description' => '',
								'class'			=> 'hits-custom-sidebar',
								'before_widget' => '<section id="%1$s" class="widget-container %2$s">',
								'after_widget' => '</section>',
								'before_title' => '<div class="widget-title-wrapper"><a class="block-control" href="javascript:void(0)"></a><h3 class="widget-title heading-title">',
								'after_title' => '</h3></div>',
							);
		}
	}
	
	return $default_sidebars;
}

function hitsxyz_register_widget_area(){
	$default_sidebars = hitsxyz_get_list_sidebars();
	foreach( $default_sidebars as $sidebar ){
		register_sidebar($sidebar);
	}
}
add_action( 'widgets_init', 'hitsxyz_register_widget_area' );

/* Custom Sidebar */
add_action( 'sidebar_admin_page', 'hitsxyz_custom_sidebar_form' );
function hitsxyz_custom_sidebar_form(){
?>
	<form action="<?php echo admin_url( 'widgets.php' ); ?>" method="post" id="hits-form-add-sidebar">
        <input type="text" name="sidebar_name" id="sidebar_name" placeholder="<?php esc_attr_e('Custom Sidebar Name', 'hitsxyz'); ?>" />
		<input type="hidden" id="hits_custom_sidebar_nonce" value="<?php echo wp_create_nonce('hits-custom-sidebar'); ?>" />
        <button class="button-primary" id="hits-add-sidebar"><?php esc_html_e('Add Sidebar', 'hitsxyz'); ?></button>
    </form>
<?php
}

function hitsxyz_get_custom_sidebars(){
	$option_name = 'hits_custom_sidebars';
	$custom_sidebars = get_option($option_name);
    return is_array($custom_sidebars)?$custom_sidebars:array();
}

add_action('wp_ajax_hitsxyz_add_custom_sidebar', 'hitsxyz_add_custom_sidebar');
function hitsxyz_add_custom_sidebar(){
	if( isset($_POST['sidebar_name']) ){
		check_ajax_referer('hits-custom-sidebar', 'sidebar_nonce');
		
		$option_name = 'hits_custom_sidebars';
		if( !get_option($option_name) || get_option($option_name) == '' ){
			delete_option($option_name);
		}
		
		$sidebar_name = $_POST['sidebar_name'];
		
		if( get_option($option_name) ){
			$custom_sidebars = hitsxyz_get_custom_sidebars();
			if( !in_array($sidebar_name, $custom_sidebars) ){
				$custom_sidebars[] = $sidebar_name;
			}
			$result = update_option($option_name, $custom_sidebars);
		}
		else{
			$custom_sidebars = array();
			$custom_sidebars[] = $sidebar_name;
			$result = add_option($option_name, $custom_sidebars);
		}
		
		if( $result ){
			die( esc_html__('Successfully added the sidebar', 'hitsxyz') );
		}
		else{
			die( esc_html__('Error! It seems that the sidebar exists. Please try again!', 'hitsxyz') );
		}
	}
	die('');
}

add_action('wp_ajax_hitsxyz_delete_custom_sidebar', 'hitsxyz_delete_custom_sidebar');
function hitsxyz_delete_custom_sidebar(){
	if( isset($_POST['sidebar_name']) ){
		check_ajax_referer('hits-custom-sidebar', 'sidebar_nonce');
		
		$option_name = 'hits_custom_sidebars';
		$del_sidebar = trim($_POST['sidebar_name']);
		$custom_sidebars = hitsxyz_get_custom_sidebars();
		foreach( $custom_sidebars as $key => $value ){
			if( $value == $del_sidebar ){
				unset($custom_sidebars[$key]);
				break;
			}
		}
		$custom_sidebars = array_values($custom_sidebars);
		update_option($option_name, $custom_sidebars);
		die( esc_html__('Successfully deleted the sidebar', 'hitsxyz') );
	}
	die('');
}
?>