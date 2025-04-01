<?php 
global $post;
$blog_thumb_size = 'hitsxyz_blog_thumb';

$cat_list = get_the_category($post->ID);
$cat_ids = array();
foreach( $cat_list as $cat ){
	$cat_ids[] = $cat->term_id;
}
$cat_ids = implode(',', $cat_ids);

if( strlen($cat_ids) > 0 ){
	$args = array(
		'post_type' => $post->post_type
		,'cat' => $cat_ids
		,'post__not_in' => array($post->ID)
		,'posts_per_page'	=> 5
	);
}
else{
	$args = array(
		'post_type' => $post->post_type
		,'post__not_in' => array($post->ID)
		,'posts_per_page'	=> 5
	);
}

/* Remove the quote post format */
$args['tax_query'] = array(
	array(
		'taxonomy'	=> 'post_format'
		,'field'	=> 'slug'
		,'terms'    => array( 'post-format-quote' )
		,'operator'	=> 'NOT IN'
	)
);

$related_posts = new WP_Query($args);
	
if( $related_posts->have_posts() ){
	$is_slider = true;
	if( isset($related_posts->post_count) && $related_posts->post_count <= 1 ){
		$is_slider = false;
	}
?>
	<div class="hits-blogs hits-shortcode related-posts related columns-2 hits-slider <?php echo esc_attr($is_slider?'loading':''); ?>">
		<header class="theme-title">
			<h3 class="heading-title"><?php esc_html_e('Related posts', 'hitsxyz'); ?></h3>
		</header>
		<div class="content-wrapper">
			<div class="blogs items">
				<?php 
				while( $related_posts->have_posts() ): $related_posts->the_post();
				$post_format = get_post_format(); /* Video, Audio, Gallery, Quote */
				if( $is_slider && $post_format == 'gallery' ){ /* Remove Slider in Slider */
					$post_format = false;
				}
				$show_thumbnail = in_array($post_format, array('gallery', 'standard', 'video', 'audio', 'quote', false));
				?>
				<article class="item <?php echo esc_attr($post_format); ?> <?php echo has_post_thumbnail()?'has-post-thumbnail':'';?>">
					<div class="article-content">
						<?php if( $show_thumbnail ): ?>
						<div class="thumbnail-content">
						
							<?php if( $post_format == 'gallery' || $post_format === false || $post_format == 'standard' ){ ?>
								<a class="thumbnail <?php echo esc_attr($post_format); ?> <?php echo ('gallery' == $post_format)?'loading':''; ?>" href="<?php echo ('gallery' == $post_format)?'javascript: void(0)':get_permalink() ?>">
									<figure>
									<?php 
									
									if( $post_format == 'gallery' ){
										$gallery = get_post_meta($post->ID, 'hits_gallery', true);
										$gallery_ids = explode(',', $gallery);
										if( is_array($gallery_ids) && has_post_thumbnail() ){
											array_unshift($gallery_ids, get_post_thumbnail_id());
										}
										foreach( $gallery_ids as $gallery_id ){
											echo wp_get_attachment_image( $gallery_id, $blog_thumb_size );
										}
										if( empty($gallery_ids) ){
											$show_thumbnail = false;
										}
									}
									
									if( $post_format === false || $post_format == 'standard' ){
										if( has_post_thumbnail() ){
											the_post_thumbnail($blog_thumb_size); 
										}
										else{
											$show_thumbnail = false;
										}
									}
											
									?>
									</figure>
								</a>
							<?php 
							}
							
							if( $post_format == 'video' ){
								$video_url = get_post_meta($post->ID, 'hits_video_url', true);
								if( $video_url ){
									echo do_shortcode('[hits_video src="'.$video_url.'"]');
								}
								else{
									$show_thumbnail = false;
								}
							}
							
							if( $post_format == 'audio' ){
								$audio_url = get_post_meta($post->ID, 'hits_audio_url', true);
								if( strlen($audio_url) > 4 ){
									$file_format = substr($audio_url, -3, 3);
									if( in_array($file_format, array('mp3', 'ogg', 'wav')) ){
										echo do_shortcode('[audio '.$file_format.'="'.$audio_url.'"]');
									}
									else{
										echo do_shortcode('[hits_soundcloud url="'.$audio_url.'" width="100%" height="122"]');
									}
								}
								else{
									$show_thumbnail = false;
								}
							}
							?>
							
							<span class="vcard author">
								<a class="vcard author" href="<?php echo get_author_posts_url(get_current_user_id()); ?>">
									<?php echo get_avatar( get_the_author_meta( 'user_email' ), 150, 'mystery' ); ?>
								</a>
							</span>
							
							<span class="date-time">
								<?php echo get_the_time( get_option('date_format') ); ?>
							</span>
						</div>
						<?php endif; ?>
						
						<div class="entry-content">
							<div class="entry-meta-top">
								<div class="cats-link">
									<?php echo get_the_category_list(', '); ?>
								</div>
							</div>
							
							<header>
								<h4 class="heading-title entry-title">
									<a class="post-title" href="<?php the_permalink() ; ?>"><?php the_title(); ?></a>
								</h4>
							</header>
						</div>
					</div>
				</article>
				<?php endwhile; ?>
			</div>
		</div>
	</div>
	
<?php 
}
wp_reset_postdata();
?>