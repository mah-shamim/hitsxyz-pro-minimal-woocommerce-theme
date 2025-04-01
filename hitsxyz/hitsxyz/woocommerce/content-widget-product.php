<?php
/**
 * The template for displaying product widget entries.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-widget-product.php.
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.5
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

if ( ! is_a( $product, 'WC_Product' ) ) {
	return;
}

?>
<li>
	<?php do_action( 'woocommerce_widget_product_item_start', $args ); ?>
	
	<a class="hits-wg-thumbnail" href="<?php echo esc_url( $product->get_permalink() ); ?>">
		<?php echo wp_kses( $product->get_image(), 'hitsxyz_product_image' ); ?>
	</a>
	<div class="hits-wg-meta">
		<a href="<?php echo esc_url( $product->get_permalink() ); ?>">
			<?php echo wp_kses( $product->get_name(), 'hitsxyz_product_name' ); ?>
		</a>
		<?php
		if ( ! empty( $show_rating ) ){
			echo wc_get_rating_html( $product->get_average_rating() );
		}
		?>
		<span class="price"><?php echo wp_kses( $product->get_price_html(), 'hitsxyz_product_price' ); ?></span>
	</div>
	
	<?php do_action( 'woocommerce_widget_product_item_end', $args ); ?>
</li>