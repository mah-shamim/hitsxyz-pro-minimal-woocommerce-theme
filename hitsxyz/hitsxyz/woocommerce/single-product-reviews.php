<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.3.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! comments_open() ) {
	return;
}
?>
<div id="reviews" class="woocommerce-Reviews">
	<h2 class="woocommerce-Reviews-title">
		<?php esc_html_e( 'Customers Reviews', 'hitsxyz' ); ?>
	</h2>
	
	<?php woocommerce_template_single_rating(); ?>
	
	<div id="comments">
		<?php if ( have_comments() ) : ?>
			<ol class="commentlist">
				<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
			</ol>

			<?php
			if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
				echo '<nav class="woocommerce-pagination">';
				paginate_comments_links(
					apply_filters(
						'woocommerce_comment_pagination_args',
						array(
							'prev_text' => esc_html__( 'Previous page', 'hitsxyz' ),
							'next_text' => esc_html__( 'Next page' , 'hitsxyz' ),
							'type'      => 'list',
						)
					)
				);
				echo '</nav>';
			endif;
			?>
		<?php else : ?>
			<p class="woocommerce-noreviews"><?php esc_html_e( 'There are no reviews yet.', 'hitsxyz' ); ?></p>
		<?php endif; ?>
	</div>

	<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>
		<div id="review_form_wrapper">
			<div id="review_form">
				<?php
				$commenter    = wp_get_current_commenter();
				$comment_form = array(
					/* translators: %s is product title */
					'title_reply'         => have_comments() ? esc_html__( 'Add a review', 'hitsxyz' ) : sprintf( esc_html__( 'Be the first to review &ldquo;%s&rdquo;', 'hitsxyz' ), get_the_title() ),
					/* translators: %s is product title */
					'title_reply_to'      => esc_html__( 'Leave a Reply to %s', 'hitsxyz' ),
					'title_reply_before'  => '<span id="reply-title" class="comment-reply-title">',
					'title_reply_after'   => '</span>',
					'comment_notes_after' => '',
					'label_submit'        => esc_html__( 'Submit', 'hitsxyz' ),
					'logged_in_as'        => '',
					'comment_field'       => '',
				);

				$name_email_required = (bool) get_option( 'require_name_email', 1 );
				$fields              = array(
					'author' => array(
						'placeholder'   => $name_email_required ? __( 'Name *', 'hitsxyz' ) : __( 'Name', 'hitsxyz' ),
						'type'     		=> 'text',
						'value'    		=> $commenter['comment_author'],
					),
					'email'  => array(
						'placeholder'   => $name_email_required ? __( 'Email *', 'hitsxyz' ) : __( 'Email', 'hitsxyz' ),
						'type'     		=> 'email',
						'value'    		=> $commenter['comment_author_email'],
					),
				);

				$comment_form['fields'] = array();
				foreach ( $fields as $key => $field ) {
					$field_html  = '<p class="comment-form-' . esc_attr( $key ) . '">';

					$field_html .= '<input id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" placeholder="'. esc_attr( $field['placeholder']  ) .'" type="' . esc_attr( $field['type'] ) . '" value="' . esc_attr( $field['value'] ) . '" size="30" ' . ( $name_email_required ? 'required' : '' ) . ' /></p>';

					$comment_form['fields'][ $key ] = $field_html;
				}

				$account_page_url = wc_get_page_permalink( 'myaccount' );
				if ( $account_page_url ) {
					/* translators: %s opening and closing link tags respectively */
					$comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( esc_html__( 'You must be %1$slogged in%2$s to post a review.', 'hitsxyz' ), '<a href="' . esc_url( $account_page_url ) . '">', '</a>' ) . '</p>';
				}

				if ( wc_review_ratings_enabled() ) {
					$comment_form['comment_field'] = '<div class="comment-form-rating"><label for="rating">' . esc_html__( 'Your rating', 'hitsxyz' ) . ( wc_review_ratings_required() ? '&nbsp;<span class="required">*</span>' : '' ) . '</label><select name="rating" id="rating" required>
						<option value="">' . esc_html__( 'Rate&hellip;', 'hitsxyz' ) . '</option>
						<option value="5">' . esc_html__( 'Perfect', 'hitsxyz' ) . '</option>
						<option value="4">' . esc_html__( 'Good', 'hitsxyz' ) . '</option>
						<option value="3">' . esc_html__( 'Average', 'hitsxyz' ) . '</option>
						<option value="2">' . esc_html__( 'Not that bad', 'hitsxyz' ) . '</option>
						<option value="1">' . esc_html__( 'Very poor', 'hitsxyz' ) . '</option>
					</select></div>';
				}

				$comment_form['comment_field'] .= '<p class="comment-form-comment"><textarea placeholder="'. esc_attr__( 'Your review *', 'hitsxyz' ) .'" id="comment" name="comment" cols="45" rows="8" required></textarea></p>';

				comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
				?>
			</div>
		</div>
	<?php else : ?>
		<p class="woocommerce-verification-required"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'hitsxyz' ); ?></p>
	<?php endif; ?>

	<div class="clear"></div>
</div>
