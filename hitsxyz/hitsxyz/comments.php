<?php
if( post_password_required() ){
	return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
	
		<header class="heading-wrapper comments-title">
			<h2 class="heading-title">
			<?php 
				echo '<span>' . get_comments_number() . '</span>';
				echo _n('Comment', 'Comments', get_comments_number(), 'hitsxyz');
			?>
			</h2>
		</header>

		<ol class="commentlist">
			<?php wp_list_comments( array( 'callback' => 'hitsxyz_list_comments', 'style' => 'ol' ) ); ?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<nav id="comment-nav-below" class="navigation" role="navigation">
			<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'hitsxyz' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'hitsxyz' ) ); ?></div>
		</nav>
		<?php endif; ?>

		<?php
		if ( ! comments_open() && get_comments_number() ) : ?>
			<p class="nocomments"><?php esc_html_e( 'Comments are closed.' , 'hitsxyz' ); ?></p>
		<?php endif; ?>

	<?php endif; ?>
	
	<?php hitsxyz_comment_form(); ?>

</div>