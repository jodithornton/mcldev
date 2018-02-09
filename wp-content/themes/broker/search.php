<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package commercegurus
 */
global $cg_options;
$cg_blog_sidebar = '';
$cg_cta_heading  = '';
if ( isset( $cg_options['cg_blog_sidebar'] ) ) {
	$cg_blog_sidebar = $cg_options['cg_blog_sidebar'];
}
if ( isset( $cg_options['cg_cta_heading'] ) ) {
	$cg_cta_heading = $cg_options['cg_cta_heading'];
}
get_header();
?>
<?php if ( have_posts() ) { ?>

<div class="header-wrapper">
			<div class="cg-hero-bg"></div>
			<div class="overlay"></div> 
			<div class="container">
				<div class="row vertical-align">
					<div class="col-xs-12 col-lg-9 col-md-9">
						<header class="entry-header">
							<h1 class="cg-page-title"><?php printf( esc_html__( 'Search Results for: %s', 'broker' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
						</header>
					</div>
					<div class="col-xs-12 col-lg-3 col-md-3">
						<?php 
						if ( $cg_cta_heading == 'yes' ) {
							cg_get_cta_button(); 
						}
						?>
					</div>
				</div>
			</div>
		</div>
		<div class="breadcrumbs-wrapper">
			<div class="container">
				<div class="row">
					<div class="col-lg-9 col-md-9">
					<?php
						if ( function_exists( 'yoast_breadcrumb' ) && (!is_front_page() ) ) {
								yoast_breadcrumb( '<p class="sub-title">', '</p>' );
						}
					?>
					</div>
					<div class="col-lg-3 col-md-3">
						<p class="cg-share"><span id="cg-share-toggle"><?php esc_html_e( 'Share', 'broker' ); ?></span></p>
					</div>
				</div>
			</div>
		</div>

		<div class="share-wrapper">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 col-md-12">
						<div class="cg-share-tools">
					        <a target="_blank" href="https://facebook.com/sharer.php?u=<?php echo get_permalink(); ?>"><i class="fa fa-facebook"></i></a>            
					        <a target="_blank" href="https://twitter.com/intent/tweet?url=<?php echo get_permalink(); ?>&text=<?php echo get_the_title(); ?>"><i class="fa fa-twitter"></i></a>            
					        <a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo get_permalink(); ?>&title=Projects&summary=&source="><i class="fa fa-linkedin"></i></a>            
					        <a target="_blank" href="https://plus.google.com/share?url=<?php echo get_permalink(); ?>"><i class="fa fa-google-plus"></i></a>              
					        <a href="javascript:window.print()"><i class="ion-printer"></i></a>            
					        <a href="mailto:?body=<?php echo get_permalink(); ?>"><i class="fa fa-envelope-o"></i></a>
					</div>
				</div>
			</div>
		</div>
		</div>

		<script type="text/javascript">
		( function ( $ ) {
    	"use strict";
			$(function() {
				$('#cg-share-toggle').click(function() {
					$('.share-wrapper').slideToggle('fast', function() {
						$('#cg-share-toggle').toggleClass('opened', $(this).is(':visible'));
						return false;
					});
				});
			});
		}( jQuery ) );

		</script>


<?php } else { ?>
	<div class="header-wrapper">
			<div class="cg-hero-bg"></div>
			<div class="overlay"></div> 
			<div class="container">
				<div class="row vertical-align">
					<div class="col-xs-12 col-lg-9 col-md-9">
						<header class="entry-header">
							<h1 class="cg-page-title"><?php printf( __( 'Search Results for: %s', 'broker' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
						</header>
					</div>
					<div class="col-xs-12 col-lg-3 col-md-3">
						<?php 
						if ( $cg_cta_heading == 'yes' ) {
							cg_get_cta_button(); 
						}
						?>
					</div>
				</div>
			</div>
		</div>
		<div class="breadcrumbs-wrapper">
			<div class="container">
				<div class="row">
					<div class="col-lg-9 col-md-9">
					<?php
						if ( function_exists( 'yoast_breadcrumb' ) && (!is_front_page() ) ) {
								yoast_breadcrumb( '<p class="sub-title">', '</p>' );
						}
					?>
					</div>
					<div class="col-lg-3 col-md-3">
						<p class="cg-share"><span id="cg-share-toggle"><?php esc_html_e( 'Share', 'broker' ); ?></span></p>
					</div>
				</div>
			</div>
		</div>

		<div class="share-wrapper">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 col-md-12">
						<div class="cg-share-tools">
					        <a target="_blank" href="https://facebook.com/sharer.php?u=<?php echo get_permalink(); ?>"><i class="fa fa-facebook"></i></a>            
					        <a target="_blank" href="https://twitter.com/intent/tweet?url=<?php echo get_permalink(); ?>&text=<?php echo get_the_title(); ?>"><i class="fa fa-twitter"></i></a>            
					        <a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo get_permalink(); ?>&title=Projects&summary=&source="><i class="fa fa-linkedin"></i></a>            
					        <a target="_blank" href="https://plus.google.com/share?url=<?php echo get_permalink(); ?>"><i class="fa fa-google-plus"></i></a>              
					        <a href="javascript:window.print()"><i class="ion-printer"></i></a>            
					        <a href="mailto:?body=<?php echo get_permalink(); ?>"><i class="fa fa-envelope-o"></i></a>
					</div>
				</div>
			</div>
		</div>
		</div>
<?php } ?>

<div class="container">
    <div class="content">
        <div class="row">
			<?php if ( ( $cg_blog_sidebar == 'default' ) || ( $cg_blog_sidebar == '' ) ) { ?>
				<div class="col-lg-9 col-md-9 col-md-push-3 col-lg-push-3">
					<div id="primary" class="content-area cg-blog-layout">
						<main id="main" class="site-main" role="main">
							<div>
								<?php if ( have_posts() ) : ?>
									<?php /* Start the Loop */ ?>
									<?php while ( have_posts() ) : the_post(); ?>
										<?php get_template_part( 'content', 'search' ); ?>
									<?php endwhile; ?>
									<?php cg_numeric_posts_nav(); ?>
								<?php else : ?>
									<?php get_template_part( 'no-results', 'search' ); ?>
								<?php endif; ?>
							</div>
						</main><!-- #main -->
					</div><!-- #primary -->
				</div><!-- /9 -->
				<div class="col-lg-3 col-md-3 col-md-pull-9 col-lg-pull-9 sidebar">
					<div id="secondary">
					<?php get_sidebar(); ?>
					</div>
				</div>
			<?php } else if ( $cg_blog_sidebar == 'right' ) { ?>
				<div class="col-lg-9 col-md-9">
					<div id="primary" class="content-area cg-blog-layout">
						<main id="main" class="site-main" role="main">
							<div>
								<?php if ( have_posts() ) : ?>
									<?php /* Start the Loop */ ?>
									<?php while ( have_posts() ) : the_post(); ?>
										<?php get_template_part( 'content', 'search' ); ?>
									<?php endwhile; ?>
									<?php cg_numeric_posts_nav(); ?>
								<?php else : ?>
									<?php get_template_part( 'no-results', 'search' ); ?>
								<?php endif; ?>
							</div>
						</main><!-- #main -->
					</div><!-- #primary -->
				</div> <!-- /9 -->
				<div class="col-lg-3 col-md-3 sidebar right">
					<div id="secondary">
					<?php get_sidebar(); ?>
					</div>
				</div>
			<?php } else if ( $cg_blog_sidebar == 'none' ) { ?>
				<div class="col-lg-12 col-md-12">
					<div id="primary" class="content-area cg-blog-layout">
						<main id="main" class="site-main" role="main">
							<div>
								<?php if ( have_posts() ) : ?>
									<?php /* Start the Loop */ ?>
									<?php while ( have_posts() ) : the_post(); ?>
										<?php get_template_part( 'content', 'search' ); ?>
									<?php endwhile; ?>
									<?php cg_numeric_posts_nav(); ?>
								<?php else : ?>
									<?php get_template_part( 'no-results', 'search' ); ?>
								<?php endif; ?>
							</div>
						</main><!-- #main -->
					</div><!-- #primary -->
				</div><!--/12 -->
			<?php } ?>
        </div><!--/row -->
    </div><!--/content -->
</div><!--/container -->

<?php get_footer(); ?>
