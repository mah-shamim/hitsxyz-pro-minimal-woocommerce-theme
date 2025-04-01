<?php 
/**
 *	Template Name: Blank Page Template
 */	
?>
<?php get_header(); ?>
<div class="page-template blank-page-template">
	<div id="main-content">	
		<div id="primary" class="site-content">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php 
					if( have_posts() ){ 
						the_post();
						the_content();
					}
				?>
			</article>
		</div>
	</div>
</div>
<?php get_footer(); ?>