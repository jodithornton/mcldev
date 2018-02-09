<?php
/**
 * The Template for displaying all single posts.
 *
 * @package commercegurus
 */
global $cg_options;
$cg_post_sidebar = '';
if ( isset( $cg_options['cg_post_sidebar'] ) ) {
	$cg_post_sidebar = $cg_options['cg_post_sidebar'];
}

get_header();
?>

<?php cg_get_page_title(); ?>

<div class="container">
    <div class="content">
        <div class="row">
			<?php if ( ( $cg_post_sidebar == 'default' ) || ( $cg_post_sidebar == '' ) ) { ?>
				<div class="col-lg-9 col-md-9 col-md-push-3 col-lg-push-3">
					<div id="primary" class="content-area">
						<main id="main" class="site-main" role="main">
							
							<?php while ( have_posts() ) : the_post(); ?>
								<?php get_template_part( 'content', 'single' ); ?>
								<?php //cg_content_nav( 'nav-below' ); ?>

								<?php
								// If comments are open or we have at least one comment, load up the comment template
								if ( comments_open() || '0' != get_comments_number() )
									comments_template();
								?>
							<?php endwhile; // end of the loop.  ?>
						</main><!-- #main -->
					</div><!-- #primary -->
				</div>
				<div class="col-lg-3 col-md-3 col-md-pull-9 col-lg-pull-9 sidebar">
					<?php get_sidebar(); ?>
				</div>
			<?php } else if ( $cg_post_sidebar == 'right' ) { ?>
				<div class="col-lg-9 col-md-9">
					<div id="primary" class="content-area">
						<main id="main" class="site-main" role="main">
							
							<?php while ( have_posts() ) : the_post(); ?>
								<?php get_template_part( 'content', 'single' ); ?>
								<?php //cg_content_nav( 'nav-below' ); ?>

								<?php
								// If comments are open or we have at least one comment, load up the comment template
								if ( comments_open() || '0' != get_comments_number() )
									comments_template();
								?>
							<?php endwhile; // end of the loop.  ?>
						</main><!-- #main -->
					</div><!-- #primary -->
				</div>
				<div class="col-lg-3 col-md-3 sidebar right">
					<?php get_sidebar(); ?>
				</div>
			<?php } else if ( $cg_post_sidebar == 'none' ) { ?>
				<div class="col-lg-12 col-md-12">
					<div id="primary" class="content-area">
						<main id="main" class="site-main" role="main">
							
							<?php while ( have_posts() ) : the_post(); ?>
								<?php get_template_part( 'content', 'single' ); ?>
								
												
								<?php //cg_content_nav( 'nav-below' ); ?>
								
								<?php
								// If comments are open or we have at least one comment, load up the comment template
								if ( comments_open() || '0' != get_comments_number() )
									comments_template();
								?>
							<?php endwhile; // end of the loop.  ?>
							
							
							
						</main><!-- #main -->
					</div><!-- #primary -->
				</div>
			<?php } ?>
        </div><!--/row -->
		
								<!-- Customised addition: related tags posts-->
								<?php $orig_post = $post;
									global $post;
									$tags = wp_get_post_tags($post->ID);
									if ($tags) {
									$tag_ids = array();
									foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
									$args=array(
									'tag__in' => $tag_ids,
									'post__not_in' => array($post->ID),
									'posts_per_page'=>4, // Number of related posts that will be shown.
									'caller_get_posts'=>1
									);
									$my_query = new wp_query( $args );
									if( $my_query->have_posts() ) {

									echo '<div id="relatedposts"><h4>Related article</h4>';
									
									echo '<div class="row">';
									
								
									
									while( $my_query->have_posts() ) {
									$my_query->the_post(); ?>

									<div class="col-sm-3"><div class="relatedthumb"><a href="<? the_permalink()?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_post_thumbnail(); ?></a></div>
									<div class="relatedcontent">
									<h4><a href="<? the_permalink()?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h4>
									
									</div>
									</div>
									<? }
									echo '</div>';
									}
									}
									$post = $orig_post;
									wp_reset_query(); 
								?>
    </div><!--/content -->
</div><!--/container -->
	
								

<?php get_footer(); ?>