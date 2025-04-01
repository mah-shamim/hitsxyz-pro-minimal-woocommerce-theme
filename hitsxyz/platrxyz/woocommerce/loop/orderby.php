<?php
/**
 * Show options for ordering
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/orderby.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$current_option = isset($catalog_orderby_options[$orderby])?$catalog_orderby_options[$orderby]:current($catalog_orderby_options);
?>
<form class="woocommerce-ordering" method="get">
	<select name="orderby" class="orderby" aria-label="<?php esc_attr_e( 'Shop order', 'hitsxyz' ); ?>">
		<?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
			<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
		<?php endforeach; ?>
	</select>
	<span class="orderby-label"><?php esc_html_e('Sort by', 'hitsxyz'); ?></span>
	<ul class="orderby">
		<li><span class="orderby-current"><?php echo esc_html( $current_option ); ?></span>
			<ul class="dropdown">
				<?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
				<li><a href="#" data-orderby="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr($orderby == $id?'current':''); ?>"><?php echo esc_html( $name ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</li>
	</ul>
	<input type="hidden" name="paged" value="1" />
	<?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page' ) ); ?>
</form>
