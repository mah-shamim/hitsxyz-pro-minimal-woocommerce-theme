<?php 
	$hitsxyz_theme_options = hitsxyz_get_theme_options();
	$has_vertical_menu = in_array($hitsxyz_theme_options['hits_header_layout'], array('v1','v4')); 
?>
</div><!-- #main .wrapper -->
	<?php if( !is_page_template('page-templates/blank-page-template.php') && $hitsxyz_theme_options['hits_footer_block'] ): ?>
	<footer id="colophon" class="footer-container footer-area loading">
		<?php hitsxyz_get_footer_content( $hitsxyz_theme_options['hits_footer_block'] ); ?>
	</footer>
	<?php endif; ?>
</div><!-- #page -->

<?php if( !is_page_template('page-templates/blank-page-template.php') ): ?>

	<?php if( $has_vertical_menu ): ?>
		<div id="vertical-menu-sidebar" class="vertical-menu-sidebar hidden-phone">
			<div class="overlay"></div>
			<div class="hits-sidebar-content">
				<span class="close"></span>
				<div class="vertical-menu-wrapper">
					<?php
						if( has_nav_menu( 'vertical' ) ){
							wp_nav_menu( array( 'container' => 'nav', 'container_class' => 'vertical-menu', 'theme_location' => 'vertical', 'walker' => new Platrxyz_Walker_Nav_Menu() ) );
						}elseif( has_nav_menu( 'primary' ) ){
							wp_nav_menu( array( 'container' => 'nav', 'container_class' => 'main-menu', 'theme_location' => 'primary', 'walker' => new Platrxyz_Walker_Nav_Menu() ) );
						}
						else{
							wp_nav_menu( array( 'container' => 'nav', 'container_class' => 'main-menu' ) );
						}
					?>
				</div>
			</div>
		</div>
	<?php endif; ?>
		
	<!-- Group Header Button -->
	<div id="group-icon-header" class="hits-floating-sidebar">
		<div class="overlay"></div>
		<div class="hits-sidebar-content <?php echo esc_attr( ( $hitsxyz_theme_options['hits_header_layout'] == 'v4' && has_nav_menu( 'vertical' ) ) ? '' : 'no-tab' ); ?>">
		
			<div class="sidebar-content">
				<?php 
					$logo_mobile_menu = is_array($hitsxyz_theme_options['hits_logo_menu_mobile'])?$hitsxyz_theme_options['hits_logo_menu_mobile']['url']:$hitsxyz_theme_options['hits_logo_menu_mobile'];
					$logo_text = $hitsxyz_theme_options['hits_text_logo'] ? $hitsxyz_theme_options['hits_text_logo'] : get_bloginfo('name');
					
					if( !$logo_mobile_menu ){
						$logo_mobile_menu = is_array($hitsxyz_theme_options['hits_logo'])?$hitsxyz_theme_options['hits_logo']['url']:$hitsxyz_theme_options['hits_logo'];
					}
					if( $logo_mobile_menu ){
				?>
				<div class="logo-wrapper">
					<div class="logo">
						<a href="<?php echo esc_url( home_url('/') ); ?>">
							<img src="<?php echo esc_url($logo_mobile_menu); ?>" loading="lazy" alt="<?php echo esc_attr($logo_text); ?>" class="menu-mobile-logo" />
						</a>
					</div>
				</div>
				<?php } ?>
				
				<ul class="tab-mobile-menu">
					<li id="main-menu" class="active"><span><?php esc_html_e('Menu', 'hitsxyz'); ?></span></li>
					<?php if( $has_vertical_menu && has_nav_menu( 'vertical' ) ): ?>
						<li id="vertical-menu"><span><?php esc_html_e('Categories', 'hitsxyz'); ?></span></li>
					<?php endif; ?>
				</ul>
				
				<h6 class="menu-title"><span><?php esc_html_e('Menu', 'hitsxyz'); ?></span></h6>
				
				<div class="mobile-menu-wrapper hits-menu tab-menu-mobile">
					<div class="menu-main-mobile">
						<?php 
						if( has_nav_menu( 'mobile' ) ){
							wp_nav_menu( array( 'container' => 'nav', 'container_class' => 'mobile-menu', 'theme_location' => 'mobile', 'walker' => new Platrxyz_Walker_Nav_Menu() ) );
						}else{
							if( $has_vertical_menu && has_nav_menu( 'vertical' ) ){
								wp_nav_menu( array( 'container' => 'nav', 'container_class' => 'vertical-menu', 'theme_location' => 'vertical', 'walker' => new Platrxyz_Walker_Nav_Menu() ) );
							}else{
								if( has_nav_menu( 'primary' ) ){
									wp_nav_menu( array( 'container' => 'nav', 'container_class' => 'mobile-menu', 'theme_location' => 'primary', 'walker' => new Platrxyz_Walker_Nav_Menu() ) );
								}else{
									wp_nav_menu( array( 'container' => 'nav', 'container_class' => 'mobile-menu' ) );
								}
							}
						}
						?>
					</div>
				</div>
				
				<?php if( $hitsxyz_theme_options['hits_header_layout'] == 'v4' ): ?>
					<div class="mobile-menu-wrapper hits-menu tab-vertical-menu">
						<div class="vertical-menu-wrapper">			
							<?php
								if( has_nav_menu( 'primary' ) ){
									wp_nav_menu( array( 'container' => 'nav', 'container_class' => 'mobile-menu', 'theme_location' => 'primary', 'walker' => new Platrxyz_Walker_Nav_Menu() ) );
								}else{
									wp_nav_menu( array( 'container' => 'nav', 'container_class' => 'mobile-menu' ) );
								}
							?>
						</div>
					</div>
				<?php endif; ?>
				
				<div class="group-button-header">
					<?php if( $hitsxyz_theme_options['hits_enable_tiny_account'] || $hitsxyz_theme_options['hits_header_currency'] || $hitsxyz_theme_options['hits_header_language'] ): ?>
					<div class="meta-bottom">
					
						<?php if( $hitsxyz_theme_options['hits_header_layout'] != 'v5' && ( $hitsxyz_theme_options['hits_header_currency'] || $hitsxyz_theme_options['hits_header_language'] ) ): ?>
						<div class="language-currency">
							
							<?php if( $hitsxyz_theme_options['hits_header_language'] ): ?>
							<div class="header-language"><?php hitsxyz_wpml_language_selector(); ?></div>
							<?php endif; ?>
							
							<?php if( $hitsxyz_theme_options['hits_header_currency'] ): ?>
							<div class="header-currency"><?php hitsxyz_woocommerce_multilingual_currency_switcher(); ?></div>
							<?php endif; ?>
							
						</div>
						<?php endif; ?>
						
						<?php if( $hitsxyz_theme_options['hits_enable_tiny_account'] ): ?>
						<div class="my-account-wrapper">
							<?php echo hitsxyz_tiny_account(false); ?>
						</div>	
						<?php endif; ?>
						
					</div>
					<?php endif; ?>
				</div>
				
			</div>	
		</div>
	</div>
		
<?php endif; ?>

<!-- Search Sidebar -->
<?php if( $hitsxyz_theme_options['hits_enable_search'] ): ?>
	
	<div id="hits-search-sidebar" class="hits-floating-sidebar">
		<div class="overlay"></div>
		<div class="hits-sidebar-content">
			<div class="hits-search-by-category woocommerce">
				<div class="search--header">
					<h2 class="title"><?php esc_html_e('Search for products', 'hitsxyz'); ?> (<span class="count">0</span>)</h2>
					<span class="close"></span>
				</div>
				
				<div class="search--form">
					<?php get_search_form(); ?>
				</div>
				
				<div class="hits-search-result-container"></div>
			</div>
		</div>
	</div>

<?php endif; ?>

<!-- Shopping Cart Floating Sidebar -->
<?php if( class_exists('WooCommerce') && $hitsxyz_theme_options['hits_enable_tiny_shopping_cart'] && $hitsxyz_theme_options['hits_shopping_cart_sidebar'] && !is_cart() && !is_checkout() ): ?>
<div id="hits-shopping-cart-sidebar" class="hits-floating-sidebar">
	<div class="overlay"></div>
	<div class="hits-sidebar-content">
		<span class="close"></span>
		<div class="hits-tiny-cart-wrapper"></div>
	</div>
</div>
<?php endif; ?>

<?php 
if( ( !wp_is_mobile() && $hitsxyz_theme_options['hits_back_to_top_button'] ) || ( wp_is_mobile() && $hitsxyz_theme_options['hits_back_to_top_button_on_mobile'] ) ): 
?>
<div id="to-top" class="scroll-button">
	<a class="scroll-button" href="javascript:void(0)" title="<?php esc_attr_e('Back to Top', 'hitsxyz'); ?>"><?php esc_html_e('Back to Top', 'hitsxyz'); ?></a>
</div>
<?php endif; ?>

<?php 
wp_footer(); ?>
</body>
</html>