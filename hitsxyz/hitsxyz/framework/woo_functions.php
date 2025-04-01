<?php 
/*** Tiny account ***/
if( !function_exists('hitsxyz_tiny_account') ){
	function hitsxyz_tiny_account( $show_dropdown = true ){
		$login_url = '#';
		$register_url = '#';
		$profile_url = '#';
		$logout_url = wp_logout_url(get_permalink());
		
		if( class_exists('WooCommerce') ){
			$myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' );
			if ( $myaccount_page_id ) {
			  $login_url = get_permalink( $myaccount_page_id );
			  $register_url = $login_url;
			  $profile_url = $login_url;
			}		
		}
		else{
			$login_url = wp_login_url();
			$register_url = wp_registration_url();
			$profile_url = admin_url( 'profile.php' );
		}
		
		$_user_logged = is_user_logged_in();
		ob_start();
		
		?>
		<div class="hits-tiny-account-wrapper">
			<div class="account-control">
			
				<?php if( !$_user_logged ): ?>
					<a class="login" href="<?php echo esc_url($login_url); ?>" title="<?php esc_attr_e('My Account', 'hitsxyz'); ?>"><?php echo esc_html__( 'Login/Register', 'hitsxyz' ); ?></a>
				<?php else: ?>
					<a class="my-account" href="<?php echo esc_url($profile_url); ?>" title="<?php esc_attr_e('My Account', 'hitsxyz'); ?>"><?php echo esc_html__( 'My Account', 'hitsxyz' ); ?></a>
				<?php endif; ?>
				
				<?php if( $show_dropdown ): ?>
				<div class="account-dropdown-form dropdown-container">
					<div class="form-content">
						
						<?php if( !$_user_logged ): ?>
							<?php wp_login_form( array(
								'form_id' 			=> 'hits-login-form',
								'label_username' 	=> '',
								'label_password'	=> '',
								'label_log_in'		=> esc_html__( 'Sign in', 'hitsxyz')
							) ); ?>
						<?php else: ?>
							<ul>
								<?php do_action('hitsxyz_before_my_account_dropdown_list'); ?>
								<li><a class="my-account" href="<?php echo esc_url($profile_url); ?>"><?php esc_html_e( 'My Account', 'hitsxyz' ); ?></a></li>
								<li><a class="log-out" href="<?php echo esc_url($logout_url); ?>"><?php esc_html_e( 'Logout', 'hitsxyz' ); ?></a></li>
							</ul>
						<?php endif; ?>
						
					</div>
				</div>
				<?php endif; ?>
				
			</div>
		</div>
		
		<?php
		return ob_get_clean();
	}
}

/*** Tiny Cart ***/
if( !function_exists('hitsxyz_tiny_cart') ){
	function hitsxyz_tiny_cart( $show_cart_control = true, $show_cart_dropdown = true ){
		if( !class_exists('WooCommerce') ){
			return '';
		}
		$cart_empty = WC()->cart->is_empty();
		$cart_url = wc_get_cart_url();
		$checkout_url = wc_get_checkout_url();
		$cart_number = WC()->cart->get_cart_contents_count();
		ob_start();
		?>
			<div class="hits-tiny-cart-wrapper">
				<?php if( $show_cart_control ): ?>
				<div class="cart-icon">
					<a class="cart-control" href="<?php echo esc_url($cart_url); ?>" title="<?php esc_attr_e('View your shopping cart', 'hitsxyz'); ?>">
						<span class="ic-cart"></span>
						<span class="cart-number"><?php echo esc_html($cart_number) ?></span>
						<span class="cart-total"><?php echo WC()->cart->get_cart_subtotal(); ?></span>
					</a>
				</div>
				<?php endif; ?>
				
				<?php if( $show_cart_dropdown ): ?>
				<div class="cart-dropdown-form dropdown-container woocommerce">
					<div class="form-content">
						<?php if( $cart_empty ): ?>
							<label><svg width="150" height="150" viewBox="0 0 150 150" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M150 0H0V150H150V0Z" fill="white"/>
							<path d="M34.5824 74.3272L33.4081 68.3582C32.1926 62.179 36.9225 56.428 43.2201 56.428H131.802C138.025 56.428 142.737 62.0523 141.647 68.1798L130.534 130.633C129.685 135.406 125.536 138.882 120.689 138.882H56.6221C51.9655 138.882 47.9253 135.668 46.8782 131.13L45.1458 123.623" stroke="#808080" stroke-width="3" stroke-linecap="round"/>
							<path d="M83.5444 17.835C84.4678 16.4594 84.1013 14.5956 82.7257 13.6721C81.35 12.7486 79.4862 13.1152 78.5628 14.4908L47.3503 60.9858C46.4268 62.3614 46.7934 64.2252 48.169 65.1487C49.5446 66.0721 51.4084 65.7056 52.3319 64.33L83.5444 17.835Z" fill="#808080"/>
							<path d="M122.755 64.0173C124.189 64.8469 126.024 64.3569 126.854 62.9227C127.683 61.4885 127.193 59.6533 125.759 58.8237L87.6729 36.7911C86.2387 35.9614 84.4035 36.4515 83.5739 37.8857C82.7442 39.3198 83.2343 41.155 84.6684 41.9847L122.755 64.0173Z" fill="#808080"/>
							<path d="M34.9955 126.991C49.3524 126.991 60.991 115.352 60.991 100.995C60.991 86.6386 49.3524 75 34.9955 75C20.6386 75 9 86.6386 9 100.995C9 115.352 20.6386 126.991 34.9955 126.991Z" stroke="#808080" stroke-width="2" stroke-linejoin="round" stroke-dasharray="5 5"/>
							<path d="M30.7 100.2C30.7 99.3867 30.78 98.64 30.94 97.96C31.1 97.2667 31.3333 96.6734 31.64 96.18C31.9467 95.6734 32.3133 95.2867 32.74 95.02C33.18 94.74 33.6667 94.6 34.2 94.6C34.7467 94.6 35.2333 94.74 35.66 95.02C36.0867 95.2867 36.4533 95.6734 36.76 96.18C37.0667 96.6734 37.3 97.2667 37.46 97.96C37.62 98.64 37.7 99.3867 37.7 100.2C37.7 101.013 37.62 101.767 37.46 102.46C37.3 103.14 37.0667 103.733 36.76 104.24C36.4533 104.733 36.0867 105.12 35.66 105.4C35.2333 105.667 34.7467 105.8 34.2 105.8C33.6667 105.8 33.18 105.667 32.74 105.4C32.3133 105.12 31.9467 104.733 31.64 104.24C31.3333 103.733 31.1 103.14 30.94 102.46C30.78 101.767 30.7 101.013 30.7 100.2ZM29 100.2C29 101.6 29.22 102.84 29.66 103.92C30.1 105 30.7067 105.853 31.48 106.48C32.2667 107.093 33.1733 107.4 34.2 107.4C35.2267 107.4 36.1267 107.093 36.9 106.48C37.6867 105.853 38.3 105 38.74 103.92C39.18 102.84 39.4 101.6 39.4 100.2C39.4 98.8 39.18 97.56 38.74 96.48C38.3 95.4 37.6867 94.5534 36.9 93.94C36.1267 93.3134 35.2267 93 34.2 93C33.1733 93 32.2667 93.3134 31.48 93.94C30.7067 94.5534 30.1 95.4 29.66 96.48C29.22 97.56 29 98.8 29 100.2Z" fill="#808080"/>
							<path d="M84.6121 101.029C85.8347 99.6106 88.8961 97.625 91.3609 101.029" stroke="#808080" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M74.1953 92.2265C75.8158 92.2265 77.1296 90.9128 77.1296 89.2922C77.1296 87.6716 75.8158 86.3579 74.1953 86.3579C72.5747 86.3579 71.261 87.6716 71.261 89.2922C71.261 90.9128 72.5747 92.2265 74.1953 92.2265Z" fill="#808080"/>
							<path d="M103.538 92.226C105.159 92.226 106.472 90.9123 106.472 89.2917C106.472 87.6711 105.159 86.3574 103.538 86.3574C101.917 86.3574 100.604 87.6711 100.604 89.2917C100.604 90.9123 101.917 92.226 103.538 92.226Z" fill="#808080"/>
							</svg>
							<span><?php esc_html_e('Your cart is currently empty', 'hitsxyz'); ?></span></label>
						<?php 
							else: 
								$cart_number = ($cart_number < 10) ? '0'.$cart_number : $cart_number;
						?>
							<h3 class="theme-title"><?php echo sprintf( '%s (%s)', esc_html__('Cart', 'hitsxyz'), $cart_number ) ?></h3>
							<div class="cart-wrapper">
								<div class="cart-content">
									<ul class="cart_list">
										<?php 
										foreach( WC()->cart->get_cart() as $cart_item_key => $cart_item ):
											$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
											if ( !( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) ){
												continue;
											}
											$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
										?>
											<li class="woocommerce-mini-cart-item">
												<a class="thumbnail" href="<?php echo esc_url($product_permalink); ?>">
													<?php echo apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key ); ?>
												</a>
												<div class="cart-item-wrapper">	
													<h3 class="product-name">
														<a href="<?php echo esc_url($product_permalink); ?>">
															<?php echo apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key); ?>
														</a>
													</h3>
													
													<span class="price"><?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); ?></span>
													
													<?php 
													if( $_product->is_sold_individually() ){
														$product_quantity = '<span class="quantity">1</span>';
													}else{
														$product_quantity = woocommerce_quantity_input( array(
															'input_name'  	=> "cart[{$cart_item_key}][qty]",
															'input_value' 	=> $cart_item['quantity'],
															'max_value'   	=> $_product->get_max_purchase_quantity(),
															'min_value'   	=> '0',
															'product_name'  => $_product->get_name()
														), $_product, false );
													}

													echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
													
													echo '<div class="subtotal">'. apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ) . '</div>';
													?>
													
													<?php echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="remove remove_from_cart_button" aria-label="%s" data-cart_item_key="%s">&times;</a>', esc_url( wc_get_cart_remove_url( $cart_item_key ) ), esc_html__( 'Remove this item', 'hitsxyz' ), $cart_item_key ), $cart_item_key ); ?>
												</div>
											</li>
										
										<?php endforeach; ?>
									</ul>
									<div class="dropdown-footer">
										<div class="total"><span class="total-title primary-text"><?php esc_html_e('Subtotal', 'hitsxyz');?></span><?php echo WC()->cart->get_cart_subtotal(); ?></div>
										
										<a href="<?php echo esc_url($cart_url); ?>" class="button view-cart"><?php esc_html_e('View Cart', 'hitsxyz'); ?></a>
										<a href="<?php echo esc_url($checkout_url); ?>" class="button checkout-button"><?php esc_html_e('Checkout', 'hitsxyz'); ?></a>
									</div>
								</div>
							</div>
						<?php endif; ?>
					</div>
				</div>
				<?php endif; ?>
			</div>
		<?php
		return ob_get_clean();
	}
}
add_filter('woocommerce_add_to_cart_fragments', 'hitsxyz_tiny_cart_filter');
function hitsxyz_tiny_cart_filter($fragments){
	$cart_sidebar = hitsxyz_get_theme_options('hits_shopping_cart_sidebar');
	$fragments['.hits-tiny-cart-wrapper'] = hitsxyz_tiny_cart(true, !$cart_sidebar);
	if( $cart_sidebar ){
		$fragments['#hits-shopping-cart-sidebar .hits-tiny-cart-wrapper'] = hitsxyz_tiny_cart(false, true);
	}
	return $fragments;
}

add_action('wp_ajax_hitsxyz_update_cart_quantity', 'hitsxyz_update_cart_quantity');
add_action('wp_ajax_nopriv_hitsxyz_update_cart_quantity', 'hitsxyz_update_cart_quantity');
function hitsxyz_update_cart_quantity(){
	if( isset($_POST['cart_item_key'], $_POST['qty']) ){
		$cart_item_key = $_POST['cart_item_key'];
		$qty = $_POST['qty'];
		$cart =  WC()->cart->get_cart();
		if( isset($cart[$cart_item_key]) ){
			$qty = apply_filters( 'woocommerce_stock_amount_cart_item', wc_stock_amount( preg_replace( '/[^0-9\.]/', '', $qty ) ), $cart_item_key );
			if( !($qty === '' || $qty === $cart[$cart_item_key]['quantity']) ){
				if( !($cart[$cart_item_key]['data']->is_sold_individually() && $qty > 1) ){
					WC()->cart->set_quantity( $cart_item_key, $qty, false );
					$cart_updated = apply_filters( 'woocommerce_update_cart_action_cart_updated', true );
					if( $cart_updated ){
						WC()->cart->calculate_totals();
					}
				}
			}
		}
		WC_AJAX::get_refreshed_fragments();
	}
}

/** Tini wishlist **/
function hitsxyz_tini_wishlist(){
	if( !(class_exists('WooCommerce') && class_exists('YITH_WCWL')) ){
		return;
	}
	
	ob_start();
	
	$wishlist_page_id = get_option( 'yith_wcwl_wishlist_page_id' );
	if( function_exists( 'wpml_object_id_filter' ) ){
		$wishlist_page_id = wpml_object_id_filter( $wishlist_page_id, 'page', true );
	}
	$wishlist_page = get_permalink( $wishlist_page_id );
	
	?>
	<a title="<?php esc_attr_e('Wishlist', 'hitsxyz'); ?>" href="<?php echo esc_url($wishlist_page); ?>" class="tini-wishlist">
		<span class="count-number"><?php echo yith_wcwl_count_products(); ?></span>
	</a>
	<?php
	return ob_get_clean();
}

function hitsxyz_update_tini_wishlist() {
	die(hitsxyz_tini_wishlist());
}

add_action('wp_ajax_hitsxyz_update_tini_wishlist', 'hitsxyz_update_tini_wishlist');
add_action('wp_ajax_nopriv_hitsxyz_update_tini_wishlist', 'hitsxyz_update_tini_wishlist');

if( !function_exists('hitsxyz_woocommerce_multilingual_currency_switcher') ){
	function hitsxyz_woocommerce_multilingual_currency_switcher(){
		if( class_exists('woocommerce_wpml') && class_exists('WooCommerce') && class_exists('SitePress') ){
			global $sitepress, $woocommerce_wpml;
			
			if( !isset($woocommerce_wpml->multi_currency) ){
				return;
			}
			
			$settings = $woocommerce_wpml->get_settings();
			
			$format = isset($settings['wcml_curr_template']) && $settings['wcml_curr_template'] != '' ? $settings['wcml_curr_template']:'%code%';
			$wc_currencies = get_woocommerce_currencies();
			if( !isset($settings['currencies_order']) ){
				$currencies = $woocommerce_wpml->multi_currency->get_currency_codes();
			}else{
				$currencies = $settings['currencies_order'];
			}
			
			$selected_html = '';
			foreach( $currencies as $currency ){
				if($woocommerce_wpml->settings['currency_options'][$currency]['languages'][$sitepress->get_current_language()] == 1 ){
					$currency_format = preg_replace(array('#%name%#', '#%symbol%#', '#%code%#'),
													array($wc_currencies[$currency], get_woocommerce_currency_symbol($currency), $currency), $format);
						
					if( $currency == $woocommerce_wpml->multi_currency->get_client_currency() ){
						$selected_html = '<a href="javascript: void(0)" class="wcml-cs-active-currency">'.$currency_format.'</a>';
						break;
					}
				}
			}
			
			echo '<div class="wcml_currency_switcher">';
				echo wp_kses( $selected_html, 'hitsxyz_link' );
				echo '<ul>';
			
				foreach( $currencies as $currency ){
					if($woocommerce_wpml->settings['currency_options'][$currency]['languages'][$sitepress->get_current_language()] == 1 ){
						$currency_format = preg_replace(array('#%name%#', '#%symbol%#', '#%code%#'),
														array($wc_currencies[$currency], get_woocommerce_currency_symbol($currency), $currency), $format);
						echo '<li><a rel="' . $currency . '">' . $currency_format . '</a></li>';
					}
				}
				
				echo '</ul>';
			echo '</div>';
		}
		else if( class_exists('WOOCS') && class_exists('WooCommerce') ){ /* Support WooCommerce Currency Switcher */
			global $WOOCS;
			$currencies = $WOOCS->get_currencies();
			if( !is_array($currencies) ){
				return;
			}
			?>
			<div class="wcml_currency_switcher">
				<a href="javascript: void(0)" class="wcml-cs-active-currency"><?php echo esc_html($WOOCS->current_currency); ?></a>
				<ul>
					<?php 
					foreach( $currencies as $key => $currency ){
						$link = add_query_arg('currency', $currency['name']);
						echo '<li rel="'.$currency['name'].'"><a href="'.esc_url($link).'">'.esc_html($currency['name']).'</a></li>';
					}
					?>
				</ul>
			</div>
			<?php
		}else{
			do_action('hitsxyz_header_currency_switcher'); /* Allow use another currency switcher */
		}
	}
}

add_filter( 'wcml_multi_currency_ajax_actions', 'hitsxyz_wcml_multi_currency_ajax_actions_filter' );
if( !function_exists('hitsxyz_wcml_multi_currency_ajax_actions_filter') ){
	function hitsxyz_wcml_multi_currency_ajax_actions_filter( $actions ){
		$actions[] = 'remove_from_wishlist';
		$actions[] = 'hitsxyz_ajax_search';
		$actions[] = 'hitsxyz_load_quickshop_content';
		$actions[] = 'hitsxyz_update_cart_quantity';
		$actions[] = 'hitsxyz_load_product_added_to_cart';
		$actions[] = 'hits_get_product_content_in_category_tab';
		return $actions;
	}
}

if( !function_exists('hitsxyz_wpml_language_selector') ){
	function hitsxyz_wpml_language_selector(){
		if( class_exists('SitePress') ){
			do_action('wpml_add_language_selector');
		}
		else{
			do_action('hitsxyz_header_language_switcher'); /* Allow use another language switcher */
		}
	}
}