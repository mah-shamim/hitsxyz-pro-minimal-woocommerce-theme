<?php
get_header();

$theme_options = hitsxyz_get_theme_options();

$page_column_class = hitsxyz_page_layout_columns_class($theme_options['hits_blog_layout'], $theme_options['hits_blog_left_sidebar'], $theme_options['hits_blog_right_sidebar']);

if( is_search() ){
	hitsxyz_breadcrumbs_title(true, true, esc_html__( 'Search Results for: ', 'hitsxyz' ) . get_search_query());
}
?>
<div class="page-template blog-template index-template page-container <?php echo esc_attr($page_column_class['main_class']); ?>">
	<!-- Left Sidebar -->
	<?php if( $page_column_class['left_sidebar'] ): ?>
		<aside id="left-sidebar" class="hits-sidebar">
			<?php dynamic_sidebar( $theme_options['hits_blog_left_sidebar'] ); ?>
		</aside>
	<?php endif; ?>			
	
	<div id="main-content">	
		<div id="primary" class="site-content">
			
			<?php	
				if( have_posts() ):
					echo '<div class="list-posts ' . hitsxyz_get_theme_options('hits_blog_item_layout') . '">';
					while( have_posts() ) : the_post();
						get_template_part( 'content', get_post_format() ); 
					endwhile;
					echo '</div>';
				else:
					echo '<div class="alert alert-error">';
						echo '<h3>'.esc_html__('Sorry. There are no posts to display!', 'hitsxyz').'</h3>';
						echo '<p>'.esc_html__('Try researching for something else.', 'hitsxyz').'</p>';
					echo '</div>';
					echo '<div class="search-wrapper">';
						get_search_form();
					echo '</div>';
				endif;
				
				hitsxyz_pagination();
			?>

		</div>
	</div>
	
	
	<!-- Right Sidebar -->
	<?php if( $page_column_class['right_sidebar'] ): ?>
		<aside id="right-sidebar" class="hits-sidebar">
			<?php dynamic_sidebar( $theme_options['hits_blog_right_sidebar'] ); ?>
		</aside>
	<?php endif; ?>	
		
</div>
<?php get_footer(); ?>