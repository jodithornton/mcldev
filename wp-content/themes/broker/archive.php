<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package commercegurus
 */
global $cg_options;

$cg_blog_sidebar = '';

$cg_news_layout		 = '';
$cg_islayout		 = '';
$cg_isdefaultnews	 = '';

if ( isset( $cg_options['cg_blog_sidebar'] ) ) {
	$cg_blog_sidebar = $cg_options['cg_blog_sidebar'];
}

$cg_cta_heading = '';

if ( isset( $cg_options['cg_cta_heading'] ) ) {
	$cg_cta_heading = $cg_options['cg_cta_heading'];
}

$cg_share_options = '';

if ( isset( $cg_options['cg_share_options'] ) ) {
	$cg_share_options = $cg_options['cg_share_options'];
}

if ( isset( $cg_options['cg_news_layout'] ) ) {
	$cg_news_layout = $cg_options['cg_news_layout'];

	if ( $cg_news_layout == 'grid-news' ) {
		$cg_islayout = 'grid-news';
	}
	if ( $cg_news_layout == 'grid-news-two' ) {
		$cg_islayout = 'grid-news';
	} else {
		$cg_isdefaultnews = ' default-news';
	}

} else {
	$cg_isdefaultnews = ' default-news';
}

get_header();
?>
<?php if ( have_posts() ) : ?>


		<div class="header-wrapper">
			<div class="cg-hero-bg" style="background-image: url('<?php echo esc_url( $cg_header_image[0] ); ?>')"></div>
			<div class="overlay"></div> 
			<div class="container">
				<div class="row vertical-align">
					<div class="col-lg-9 col-md-9">
						<header class="entry-header">
							<h1 class="cg-page-title">
							<?php
							if ( is_category() ) :
								single_cat_title();

							elseif ( is_tag() ) :
								single_tag_title();

							elseif ( is_author() ) :
								/* Queue the first post, that way we know
								 * what author we're dealing with (if that is the case).
								 */
								the_post();
								printf( esc_html__( 'Author: %s', 'broker' ), '<span class="vcard">' . get_the_author() . '</span>' );
								/* Since we called the_post() above, we need to
								 * rewind the loop back to the beginning that way
								 * we can run the loop properly, in full.
								 */
								rewind_posts();

							elseif ( is_day() ) :
								printf( esc_html__( 'Day: %s', 'broker' ), '<span>' . get_the_date() . '</span>' );

							elseif ( is_month() ) :
								printf( esc_html__( 'Month: %s', 'broker' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

							elseif ( is_year() ) :
								printf( esc_html__( 'Year: %s', 'broker' ), '<span>' . get_the_date( 'Y' ) . '</span>' );

							elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
								esc_html_e( 'Asides', 'broker' );

							elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
								esc_html_e( 'Images', 'broker' );

							elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
								esc_html_e( 'Videos', 'broker' );

							elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
								esc_html_e( 'Quotes', 'broker' );

							elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
								esc_html_e( 'Links', 'broker' );

							else :
								esc_html_e( 'Archives', 'broker' );

							endif;
							?>                            
						</h1>
						</header>
					</div>
					<div class="col-lg-3 col-md-3">
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
					<div class="col-lg-9 col-md-9 col-sm-9">
					<?php
						if ( function_exists( 'yoast_breadcrumb' ) && (!is_front_page() ) ) {
								yoast_breadcrumb( '<p class="sub-title">', '</p>' );
						}
					?>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-3">
						<?php 
						if ( $cg_share_options == 'yes' ) {
							cg_get_share_options_title();
						}
						?>
					</div>
				</div>
			</div>
		</div>

		<?php 
		if ( $cg_share_options == 'yes' ) {
			cg_get_share_options_content();
		}
		?>

	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				
			</div>
		</div>
	</div>

<?php endif; ?>

<div class="container">
    <div class="content">
        <div class="row">
<?php if ( ( $cg_blog_sidebar == 'default' ) || ( $cg_blog_sidebar == '' ) ) { ?>

				<div class="col-lg-9 col-md-9 col-sm-12 col-md-push-3 col-lg-push-3">
					<section id="primary" class="content-area cg-blog-layout">
						<main id="main" class="site-main <?php echo $cg_islayout ?>" role="main">
								<?php if ( have_posts() ) : ?>
								<div>
									<?php /* Start the Loop */ ?>
									<?php while ( have_posts() ) : the_post(); ?>
										<?php
										/* Include the Post-Format-specific template for the content.
										 * If you want to override this in a child theme, then include a file
										 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
										 */
										get_template_part( 'content', get_post_format() );
										?>
									<?php endwhile; ?>
									<?php cg_content_nav( 'nav-below' ); ?>
								<?php else : ?>
									<?php get_template_part( 'no-results', 'archive' ); ?>
	<?php endif; ?>
							</div>
						</main><!-- #main -->
					</section><!-- #primary -->
				</div><!--/9 -->
				<div class="col-lg-3 col-md-3 col-sm-12 col-md-pull-9 col-lg-pull-9 sidebar">
	<?php get_sidebar(); ?>
				</div>

<?php } else if ( $cg_blog_sidebar == 'right' ) { ?>

				<div class="col-lg-9 col-md-9 col-sm-12">
					<section id="primary" class="content-area cg-blog-layout">
						<main id="main" class="site-main <?php echo $cg_islayout ?>" role="main">
								<?php if ( have_posts() ) : ?>
								<div>
									<?php /* Start the Loop */ ?>
									<?php while ( have_posts() ) : the_post(); ?>
										<?php
										/* Include the Post-Format-specific template for the content.
										 * If you want to override this in a child theme, then include a file
										 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
										 */
										get_template_part( 'content', get_post_format() );
										?>
									<?php endwhile; ?>
									<?php cg_content_nav( 'nav-below' ); ?>
								<?php else : ?>
									<?php get_template_part( 'no-results', 'archive' ); ?>
	<?php endif; ?>
							</div>
						</main><!-- #main -->
					</section><!-- #primary -->
				</div><!--/9 -->
				<div class="col-lg-3 col-md-3 col-sm-12 sidebar right">
	<?php get_sidebar(); ?>
				</div>

<?php } else if ( $cg_blog_sidebar == 'none' ) { ?>
				<div class="col-lg-12 col-md-12 col-sm-12">
					<section id="primary" class="content-area cg-blog-layout">
						<main id="main" class="site-main <?php echo $cg_islayout ?>" role="main">
								<?php if ( have_posts() ) : ?>
								<div>
									<?php /* Start the Loop */ ?>
									<?php while ( have_posts() ) : the_post(); ?>
										<?php
										/* Include the Post-Format-specific template for the content.
										 * If you want to override this in a child theme, then include a file
										 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
										 */
										get_template_part( 'content', get_post_format() );
										?>
									<?php endwhile; ?>
									<?php cg_content_nav( 'nav-below' ); ?>
								<?php else : ?>
									<?php get_template_part( 'no-results', 'archive' ); ?>
	<?php endif; ?>
							</div>
						</main><!-- #main -->
					</section><!-- #primary -->
				</div><!--/12 -->
<?php } ?>
        </div><!--/row -->
    </div><!--/content -->
</div><!--/container -->

<?php get_footer(); ?>