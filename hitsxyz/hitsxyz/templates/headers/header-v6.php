<?php
$hitsxyz_theme_options = hitsxyz_get_theme_options();

$header_classes = array();
if( $hitsxyz_theme_options['hits_enable_sticky_header'] ){
	$header_classes[] = 'has-sticky';
}

if( !$hitsxyz_theme_options['hits_enable_tiny_shopping_cart'] ){
	$header_classes[] = 'hidden-cart';
}

if( !$hitsxyz_theme_options['hits_enable_tiny_wishlist'] || !class_exists('WooCommerce') || !class_exists('YITH_WCWL') ){
	$header_classes[] = 'hidden-wishlist';
}

if( !$hitsxyz_theme_options['hits_header_currency'] ){
	$header_classes[] = 'hidden-currency';
}

if( !$hitsxyz_theme_options['hits_header_language'] ){
	$header_classes[] = 'hidden-language';
}

if( !$hitsxyz_theme_options['hits_enable_search'] ){
	$header_classes[] = 'hidden-search';
}
?>

<header class="hits-header <?php echo esc_attr(implode(' ', $header_classes)); ?>">
	<div class="header-container">
		<div class="header-template">
		
			<div class="header-top">
				<div class="container">	
					<div class="header-left">
						<?php hitsxyz_store_notices(); ?>					
					</div>
					
					<div class="header-right hidden-phone">
						<?php if( $hitsxyz_theme_options['hits_header_currency'] || $hitsxyz_theme_options['hits_header_language'] ): ?>
						<div class="language-currency">
							<?php if( $hitsxyz_theme_options['hits_header_language'] ): ?>
							<div class="header-language"><?php hitsxyz_wpml_language_selector(); ?></div>
							<?php endif; ?>
							
							<?php if( $hitsxyz_theme_options['hits_header_currency'] ): ?>
							<div class="header-currency"><?php hitsxyz_woocommerce_multilingual_currency_switcher(); ?></div>
							<?php endif; ?>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
			
			<div class="header-sticky">
				<div class="header-middle">
					<div class="container">
					
						<div class="header-left hidden-phone">
							<?php if( $hitsxyz_theme_options['hits_enable_search'] ): ?>
								<div class="hits-search-by-category">
									<div>
										<?php get_search_form(); ?>
									</div>
								</div>
							<?php endif; ?>
						</div>
						
						<div class="header-center">
							<div class="logo-wrapper"><?php hitsxyz_theme_logo(); ?></div>
						</div>
						
						<div class="header-right">
							
							<div class="hits-mobile-icon-toggle visible-phone">
								<span class="icon"></span>
							</div>
							
							<?php if( $hitsxyz_theme_options['hits_enable_search'] ): ?>
							<div class="search-button search-icon visible-phone">
								<span class="icon"></span>
							</div>
							<?php endif; ?>
							
							<?php if( $hitsxyz_theme_options['hits_enable_tiny_account'] ): ?>
							<div class="my-account-wrapper hidden-phone">							
								<?php echo hitsxyz_tiny_account(); ?>
							</div>
							<?php endif; ?>
							
							<?php if( class_exists('YITH_WCWL') && $hitsxyz_theme_options['hits_enable_tiny_wishlist'] ): ?>
								<div class="my-wishlist-wrapper"><?php echo hitsxyz_tini_wishlist(); ?></div>
							<?php endif; ?>
							
							<?php if( $hitsxyz_theme_options['hits_enable_tiny_shopping_cart'] ): ?>
							<div class="shopping-cart-wrapper">
								<?php echo hitsxyz_tiny_cart(); ?>
							</div>
							<?php endif; ?>
						</div>
						
						<div class="menu-wrapper menu-fullwidth hidden-phone">
							<div class="hits-menu">
								<?php 
									if ( has_nav_menu( 'primary' ) ) {
										wp_nav_menu( array( 'container' => 'nav', 'container_class' => 'main-menu pc-menu hits-mega-menu-wrapper','theme_location' => 'primary','walker' => new Platrxyz_Walker_Nav_Menu() ) );
									}
									else{
										wp_nav_menu( array( 'container' => 'nav', 'container_class' => 'main-menu pc-menu hits-mega-menu-wrapper' ) );
									}
								?>
							</div>
						</div>
					</div>					
				</div>
			</div>		
		</div>	
	</div>
</header>