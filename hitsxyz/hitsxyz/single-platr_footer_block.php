<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1" />
	<link rel="profile" href="//gmpg.org/xfn/11" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

	<footer id="colophon" class="footer-container footer-area">
		<?php
			while( have_posts() ){
				the_post();
				the_content();
			}
		?>
	</footer>
	
<?php wp_footer(); ?>	
</body>
</html>