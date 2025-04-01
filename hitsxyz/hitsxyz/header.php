<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1" />

	<link rel="profile" href="//gmpg.org/xfn/11" />
	<?php 
	hitsxyz_theme_favicon();
	wp_head(); 
	?>
</head>
<body <?php body_class(); ?>>
<?php
if( function_exists('wp_body_open') ){
	wp_body_open();
}
?>

<div id="page" class="hfeed site">

	<?php if( !is_page_template('page-templates/blank-page-template.php') ): ?>
			
		<!-- Page Slider -->
		<?php if( is_page() ): ?>
			<?php if( hitsxyz_get_page_options('hits_page_slider') && hitsxyz_get_page_options('hits_page_slider_position') == 'before_header' ): ?>
			<div class="top-slideshow">
				<div class="top-slideshow-wrapper">
					<?php hitsxyz_show_page_slider(); ?>
				</div>
			</div>
			<?php endif; ?>
		<?php endif; ?>
		
		<?php hitsxyz_get_header_template(); ?>
		
	<?php endif; ?>
	
	<?php do_action('hitsxyz_before_main_content'); ?>

	<div id="main" class="wrapper">