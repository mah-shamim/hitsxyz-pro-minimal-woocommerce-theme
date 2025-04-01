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

	<div class="hits-megamenu">
		<div class="hits-megamenu-widgets-container hits-megamenu-container">
			<?php
				while( have_posts() ){
					the_post();
					the_content();
				}
			?>
		</div>
	</div>
	
<?php wp_footer(); ?>	
</body>
</html>