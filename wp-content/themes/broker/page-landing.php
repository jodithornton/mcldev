<?php
/**
 * Template Name: Basic Landing
 * @package commercegurus
 */
?>

<!DOCTYPE html>
<!--[if IE 9 ]><html class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
		<?php
		if ( $cg_responsive_status == 'enabled' ) {
			?>
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<?php } ?>
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">        
        <link rel="shortcut icon" href="<?php
		if ( $cg_favicon ) {
			echo esc_url( $cg_favicon );
		} else {
			?><?php echo get_template_directory_uri(); ?>/favicon.png<?php } ?>"/>

        <link rel="apple-touch-icon-precomposed" href="<?php
		if ( $cg_retina_favicon ) {
			echo esc_url( $cg_retina_favicon );
		} else {
			?><?php echo get_template_directory_uri(); ?>/apple-touch-icon-precomposed.png<?php } ?>"/>
       <!--[if lte IE 9]><script src="http://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7/html5shiv.js"></script><![endif]-->
		<?php wp_head(); ?>
    </head>
    <body id="skrollr-body" <?php body_class(); ?>>

		<div id="main-wrapper" class="content-wrap">

			<div id="cg-page-wrap" class="hfeed site">
				
			    <div class="content">

			        <div class="row">
			            <div class="col-lg-12 col-md-12 col-sm-12">
			                <div id="primary" class="content-area">
			                    <main id="main" class="site-main" role="main">

									<?php while ( have_posts() ) : the_post(); ?>

										<?php get_template_part( 'content', 'page' ); ?>

									<?php endwhile; // end of the loop.  ?>

			                    </main><!-- #main -->
			                </div><!-- #primary -->
			            </div>
			            
			        </div><!--/row -->
			    </div><!--/content -->

			</div>
		</div><!--/page-container -->

	<?php wp_footer(); ?>
</body>
</html>