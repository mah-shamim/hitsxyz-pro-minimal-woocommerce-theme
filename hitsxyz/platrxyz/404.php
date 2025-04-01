<?php 
get_header();

$theme_options = hitsxyz_get_theme_options();
$classes = array();
$classes[] = 'show_breadcrumb_' . $theme_options['hits_breadcrumb_layout'];

$image_404 = is_array($theme_options['hits_404_page_image'])?$theme_options['hits_404_page_image']['url']:$theme_options['hits_404_page_image'];

hitsxyz_breadcrumbs_title(false, false, '');
?>
	<div class="page-container <?php echo esc_attr(implode(' ', $classes)); ?>">
		<div id="main-content">	
			<div id="primary" class="site-content">
				<article>
					<div class="not-found">
						<div class="image-404">
							<div class="text-clipping"><?php esc_html_e('404', 'hitsxyz') ?></div>
							<?php if( $image_404 ): ?>
								<img loading="lazy" src="<?php echo esc_url($image_404); ?>" alt="<?php esc_attr_e('404 image', 'hitsxyz'); ?>">
							<?php endif; ?>
						</div>
						<h1><?php esc_html_e('The page you\'re looking for doesn\'t exist or probably moved somewhere...', 'hitsxyz'); ?></h1>
						<p><?php esc_html_e('Please back to homepage or check our offer', 'hitsxyz'); ?></p>
						<a href="<?php echo esc_url( home_url('/') ) ?>" class="button"><?php esc_html_e('Back to homepage', 'hitsxyz'); ?></a>
					</div>
				</article>
			</div>
		</div>
	</div>
<?php
get_footer();