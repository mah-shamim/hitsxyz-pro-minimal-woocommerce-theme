<?php 
get_header();

global $post;
setup_postdata($post);

$theme_options = hitsxyz_get_theme_options();

$post_format = get_post_format(); /* Video, Audio, Gallery, Quote */

$show_blog_thumbnail = $theme_options['hits_blog_details_thumbnail'];
if( ( $post_format == 'gallery' || $post_format === false || $post_format == 'standard' ) && !has_post_thumbnail() ){
	$show_blog_thumbnail = 0;
}

if( !$show_blog_thumbnail ){
	$theme_options['hits_blog_details_thumbnail_style'] = 'thumbnail-default';
}

$blog_thumb_size = 'full';

$extra_classes = array();

$page_column_class = hitsxyz_page_layout_columns_class($theme_options['hits_blog_details_layout'], $theme_options['hits_blog_details_left_sidebar'], $theme_options['hits_blog_details_right_sidebar']);

$show_breadcrumb = apply_filters('hitsxyz_show_breadcrumb_on_single_post', true);
$show_page_title = false;

$extra_classes[] = $theme_options['hits_blog_details_thumbnail_style'];

hitsxyz_breadcrumbs_title($show_breadcrumb, $show_page_title, get_the_title());
if( $show_breadcrumb || $show_page_title ){
	$extra_classes[] = 'show_breadcrumb_'.$theme_options['hits_breadcrumb_layout'];
}
?>
<div id="content" class="page-container container-post <?php echo esc_attr(implode(' ', $extra_classes)) ?> <?php echo esc_attr($page_column_class['main_class']); ?>">
	
	<?php if( $theme_options['hits_blog_details_thumbnail_style'] == 'thumbnail-parallax' ):
		hitsxyz_entry_header_template( $post, $post_format, $show_blog_thumbnail, $blog_thumb_size );
	endif; ?>
	
	<!-- Left Sidebar -->
	<?php if( $page_column_class['left_sidebar'] ): ?>
		<div id="left-sidebar" class="hits-sidebar">
			<aside>
				<?php dynamic_sidebar( $theme_options['hits_blog_details_left_sidebar'] ); ?>
			</aside>
		</div>
	<?php endif; ?>	
	<!-- end left sidebar -->

	<!-- main-content -->
	<div id="main-content">		
		<article class="single single-post <?php echo esc_attr($post_format); ?> <?php echo !$show_blog_thumbnail?'no-featured-image':''; ?>">
		
			<?php if( $theme_options['hits_blog_details_thumbnail_style'] != 'thumbnail-parallax' ):
				hitsxyz_entry_header_template( $post, $post_format, $show_blog_thumbnail, $blog_thumb_size );
			endif; ?>
			
			<header>
				<?php if( $theme_options['hits_blog_details_date'] || $theme_options['hits_blog_details_author'] || $theme_options['hits_blog_details_comment'] || $theme_options['hits_blog_details_categories'] ) : ?>
					<div class="entry-meta-top">
						<?php 
						$categories_list = get_the_category_list(', ');
						if( !$categories_list ){
							$theme_options['hits_blog_details_categories'] = false;
						}
						?>
						<?php if( $theme_options['hits_blog_details_categories'] ): ?>
						<div class="cats-link">
							<?php echo trim($categories_list); ?>
						</div>
						<?php endif; ?>
						
						<?php if( $theme_options['hits_blog_details_date'] ) : ?>
						<span class="date-time">
							<?php echo get_the_time( get_option('date_format') ); ?>
						</span>
						<?php endif; ?>
						
						<?php if( $theme_options['hits_blog_details_author'] ): ?>
						<span class="vcard author">
							<span><?php esc_html_e('BY', 'hitsxyz'); ?></span>
							<?php the_author_posts_link(); ?>
						</span>
						<?php endif; ?>
						
						<?php if( $theme_options['hits_blog_details_comment'] ): ?>
						<span class="comment-count">
							<?php
							$comment_count = hitsxyz_get_post_comment_count();
							echo sprintf( _n('%d comment', '%d comments', $comment_count, 'hitsxyz'), $comment_count );
							?>
						</span>
						<?php endif; ?>
						
					</div>
				<?php endif; ?>
					
				<!-- Blog Title -->
				<?php if( $theme_options['hits_blog_details_title'] ): ?>
				<h3 class="entry-title"><?php the_title(); ?></h3>
				<?php endif; ?>
			</header>

			<div class="entry-content">
				<!-- Blog Content -->
				<?php if( $theme_options['hits_blog_details_content'] ): ?>
				<div class="content-wrapper">
					<?php the_content(); ?>
					<?php wp_link_pages(); ?>
				</div>
				<?php endif; ?>
			</div>
			
			<?php 
			$tags_list = get_the_tag_list('', '');
			if( !$tags_list ){
				$theme_options['hits_blog_details_tags'] = false;
			}
			?>
			<?php if( $theme_options['hits_blog_details_tags'] || ( function_exists('hits_template_social_sharing') && $theme_options['hits_blog_details_sharing'] ) ): ?>
			<div class="meta-bottom-1">
				
				<?php if( $theme_options['hits_blog_details_tags'] ): ?>
					<!-- Blog Tags -->
					<div class="tags-link"><?php echo trim($tags_list); ?></div>
				<?php endif; ?>
				
				<?php if( function_exists('hits_template_social_sharing') && $theme_options['hits_blog_details_sharing'] ): ?>
					<!-- Blog Sharing -->
					<div class="social-sharing"><?php hits_template_social_sharing(); ?></div>
				<?php endif; ?>
				
			</div>
			<?php endif; ?>
				
			<?php if( $theme_options['hits_blog_details_navigation'] ): ?>
			<div class="meta-bottom-2">
				<!-- Next Prev Blog -->
				<div class="single-navigation prev"><?php previous_post_link('%link'); ?></div>
				<!-- Next Prev Blog -->
				<div class="single-navigation next"><?php next_post_link('%link'); ?></div>
			</div>
			<?php endif; ?>
			
			<!-- Blog Author -->
			<?php if( $theme_options['hits_blog_details_author_box'] && get_the_author_meta('description') ) : ?>
			<div class="entry-author-wrapper">
				<div class="entry-author">
					<div class="author-avatar">
						<?php echo get_avatar( get_the_author_meta( 'user_email' ), 150, 'mystery' ); ?>
					</div>	
					<div class="author-info">		
						<span class="author"><?php the_author_posts_link();?></span>
						<span class="role"><?php echo hitsxyz_get_user_role( get_the_author_meta('ID') ); ?></span>
						<p><?php the_author_meta( 'description' ); ?></p>
					</div>
				</div>
			</div>
			<?php endif; ?>	
			
			<?php
			if( !is_singular('hits_feature') && $theme_options['hits_blog_details_related_posts'] ){
			?>
			<div class="single-related-wrapper">
				<!-- Related Posts-->
				<?php get_template_part('templates/related-posts'); ?>
			</div>
			<?php } ?>

			<!-- Comment Form -->
			<?php
			if( $theme_options['hits_blog_details_comment_form'] && ( comments_open() || get_comments_number() ) ){
				comments_template( '', true );
			}
			?>
			
		</article>
	</div><!-- end main-content -->
	
	<!-- Right Sidebar -->
	<?php if( $page_column_class['right_sidebar'] ): ?>
		<div id="right-sidebar" class="hits-sidebar">
			<aside>
				<?php dynamic_sidebar( $theme_options['hits_blog_details_right_sidebar'] ); ?>
			</aside>
		</div>
	<?php endif; ?>
	<!-- end right sidebar -->	

</div>
<?php get_footer(); ?>