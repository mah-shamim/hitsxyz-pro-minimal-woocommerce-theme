<?php 
if( class_exists('WooCommerce') && !class_exists('Platrxyz_Quickshop') && !wp_is_mobile() ){
		
	class Platrxyz_Quickshop{
	
		public $id;
		
		function __construct(){
			add_action('init', array($this, 'init'));
			add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'), 2000);
		}
		
		function init(){
			$theme_options = hitsxyz_get_theme_options();
			if( empty($theme_options['hits_enable_quickshop']) ){
				return;
			}
			
			add_action('wp_footer', array($this, 'add_quickshop_modal'), 999);
			
			add_action('woocommerce_after_shop_loop_item_title', array($this, 'add_quickshop_button'), 10004);
			
			/* Register ajax */
			add_action('wp_ajax_hitsxyz_load_quickshop_content', array($this, 'load_quickshop_content_callback') );
			add_action('wp_ajax_nopriv_hitsxyz_load_quickshop_content', array($this, 'load_quickshop_content_callback') );
		}
		
		function add_quickshop_button(){
			global $product;
			echo '<div class="button-in quickshop">';
			echo '<a class="quickshop" href="#" data-product_id="'.$product->get_id().'"><span class="hits-tooltip button-tooltip">'.esc_html__('Quick view', 'hitsxyz').'</span></a>';
			echo '</div>';
		}
		
		function add_hooks(){
			$theme_options = hitsxyz_get_theme_options();

			if( $theme_options['hits_prod_title'] ){
				add_action('hitsxyz_quickshop_single_product_title', array($this, 'product_title'), 10);
			}

			add_action('hitsxyz_quickshop_single_product_summary', 'hitsxyz_single_product_ratings_stock_start', 14);
			
			if( $theme_options['hits_prod_rating'] ){
				add_action('hitsxyz_quickshop_single_product_summary', 'hitsxyz_template_star_rating', 15);
			}
			
			if( $theme_options['hits_prod_availability'] ){
				add_action('hitsxyz_quickshop_single_product_summary', 'hitsxyz_template_single_availability', 20);
			}
			
			add_action('hitsxyz_quickshop_single_product_summary', 'hitsxyz_single_product_ratings_stock_end', 21);

			if( $theme_options['hits_prod_price'] ){
				add_action('hitsxyz_quickshop_single_product_summary', 'woocommerce_template_single_price', 25);
				add_action('hitsxyz_quickshop_single_product_summary', 'hitsxyz_template_single_variation_price', 26);
				add_action('hitsxyz_quickshop_single_product_summary', 'hitsxyz_single_product_calc_discount', 27);
			}
			else{
				remove_action('woocommerce_single_variation', 'woocommerce_single_variation', 10);
			}

			if( $theme_options['hits_prod_short_desc'] ){
				add_action('hitsxyz_quickshop_single_product_summary', 'woocommerce_template_single_excerpt', 24);
			}

			if( $theme_options['hits_prod_add_to_cart'] && !$theme_options['hits_enable_catalog_mode'] ){
				add_action('hitsxyz_quickshop_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
			}

			if( $theme_options['hits_prod_buy_now'] ){
				add_action('hitsxyz_quickshop_single_product_summary', 'hitsxyz_single_product_buy_now_button', 31);
			}

			add_action('hitsxyz_quickshop_single_product_summary', 'hitsxyz_template_single_meta', 72);
		}
		
		function enqueue_scripts(){
			$theme_options = hitsxyz_get_theme_options();
			if( !empty($theme_options['hits_enable_quickshop']) ){
				wp_enqueue_script( 'flexslider' );
				wp_enqueue_script( 'wc-add-to-cart-variation' );
				if( $theme_options['hits_prod_cloudzoom'] ){
					wp_enqueue_script( 'zoom' );
				}
			}
		}
		
		function add_quickshop_modal(){
		?>
		<div id="hits-quickshop-modal" class="hits-popup-modal">
			<div class="overlay"></div>
			<div class="quickshop-container popup-container">
				<span class="close"></span>
				<div class="quickshop-content"></div>
			</div>
		</div>
		<?php
		}
		
		function product_title(){
			?>
			<h1 itemprop="name" class="product_title entry-title">
				<a href="<?php the_permalink(); ?>">
					<?php the_title(); ?>
				</a>
			</h1>
			<?php
		}
		
		function filter_add_to_cart_url(){
			$ref_url = wp_get_referer();
			$ref_url = remove_query_arg( array('added-to-cart','add-to-cart'), $ref_url );
			$ref_url = add_query_arg( array( 'add-to-cart' => $this->id ), $ref_url );
			return esc_url( $ref_url );
		}
		
		function load_quickshop_content_callback(){
			global $post, $product;

			$theme_options = hitsxyz_get_theme_options();
			$prod_id = absint($_POST['product_id']);
			$post = get_post( $prod_id );
			$product = wc_get_product( $prod_id );

			if( $prod_id <= 0 ){
				die( esc_html__('Invalid Product', 'hitsxyz') );
			}
			if( !isset($post->post_type) || $post->post_type != 'product' ){
				die( esc_html__('Invalid Product', 'hitsxyz') );
			}
			
			$this->id = $prod_id;
			
			$this->add_hooks();
			
			hitsxyz_change_theme_options('hits_prod_sharing', 0);
			
			add_filter( 'woocommerce_add_to_cart_url', array($this, 'filter_add_to_cart_url'), 10 );
			
			$classes = array('hits-quickshop-wrapper product');
			
			if( in_array( $theme_options['hits_prod_gallery_layout'], array('grid') ) ){
				$theme_options['hits_prod_gallery_layout'] = 'horizontal';
			}

			$classes[] = 'gallery-layout-' . $theme_options['hits_prod_gallery_layout'];

			if( $theme_options['hits_prod_attr_color_variation_thumbnail'] ){
				$classes[] = 'color-variation-thumbnail';
			}

			if( $theme_options['hits_prod_gallery_layout'] == 'vertical' && !empty( $product->get_gallery_image_ids() ) ){
				$classes[] = 'has-gallery';
			}

			ob_start();	
			?>
			<div class="woocommerce">
				<div itemscope itemtype="http://schema.org/Product" <?php post_class( implode(' ', $classes) ); ?>>
					
					<?php woocommerce_show_product_images(); ?>
					
					<!-- Product summary -->
					<div class="summary entry-summary">
						<?php do_action('hitsxyz_quickshop_single_product_title'); ?>
						<?php do_action('hitsxyz_quickshop_single_product_summary'); ?>
					</div>
				
				</div>
			</div>
			<?php

			wp_reset_postdata();
			die( ob_get_clean() );
		}
	}
	new Platrxyz_Quickshop();
}
?>