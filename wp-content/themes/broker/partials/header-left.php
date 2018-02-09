<?php
// Logo to the left with the menu below

global $cg_options;
$cg_protocol = ( is_ssl() ) ? "https:" : "http:";

$cg_responsive_status = '';

if ( isset( $cg_options['cg_responsive'] ) ) {
	$cg_responsive_status = $cg_options['cg_responsive'];
}

$cg_logo = '';

$cg_favicon = '';

if ( isset( $cg_options['cg_favicon']['url'] ) ) {
	$cg_options['cg_favicon']['url'] = $cg_protocol . str_replace( array( 'http:', 'https:' ), '', $cg_options['cg_favicon']['url'] );
	$cg_favicon						 = $cg_options['cg_favicon']['url'];
}

$cg_retina_favicon = '';

if ( isset( $cg_options['cg_retina_favicon']['url'] ) ) {
	$cg_options['cg_retina_favicon']['url']	 = $cg_protocol . str_replace( array( 'http:', 'https:' ), '', $cg_options['cg_retina_favicon']['url'] );
	$cg_retina_favicon						 = $cg_options['cg_retina_favicon']['url'];
}

$cg_display_cart = '';

if ( isset( $cg_options['cg_show_cart'] ) ) {
	$cg_display_cart = $cg_options['cg_show_cart'];
}

$cg_display_search = '';

if ( isset( $cg_options['cg_show_search'] ) ) {
	$cg_display_search = $cg_options['cg_show_search'];
}

$cg_catalog = '';

if ( isset( $cg_options['cg_catalog_mode'] ) ) {
	$cg_catalog = $cg_options['cg_catalog_mode'];
}

$cg_primary_menu_layout = '';

if ( isset( $cg_options['cg_primary_menu_layout'] ) ) {
	$cg_primary_menu_layout = $cg_options['cg_primary_menu_layout'];
}

$cg_sticky_menu = '';

if ( isset( $cg_options['cg_sticky_menu'] ) ) {
	$cg_sticky_menu = $cg_options['cg_sticky_menu'];
}

if ( !empty( $_SESSION['cg_header_top'] ) ) {
	$cg_topbar_display = $_SESSION['cg_header_top'];
}

$cg_topbar = '';

if ( isset( $cg_options['cg_topbar'] ) ) {
	$cg_topbar = $cg_options['cg_topbar'];
}

$cg_mobile_visible_header_details = '';

if ( isset( $cg_options['cg_mobile_visible_header_details'] ) ) {
	$cg_mobile_visible_header_details = $cg_options['cg_mobile_visible_header_details'];
}

$cg_shop_announcements = '';

if ( isset( $cg_options['cg_shop_announcements'] ) ) {
	$cg_shop_announcements = $cg_options['cg_shop_announcements'];
}

$cg_logo_position = '';

if ( isset( $cg_options['cg_logo_position'] ) ) {
	$cg_logo_position = $cg_options['cg_logo_position'];
}

$cg_cta_sticky = '';

if ( isset( $cg_options['cg_cta_sticky'] ) ) {
	$cg_cta_sticky = $cg_options['cg_cta_sticky'];
}

?>

<?php if ( $cg_mobile_visible_header_details == '1' ) { ?>
	<div class="mobile-header-details">
		<?php dynamic_sidebar( 'header-details' ); ?>
	</div>
<?php } ?>

<!-- Load Top Bar -->
<?php if ( $cg_topbar == '1' ) { ?>
	<div class="cg-announcements">
		<div class="container">
			<div class="row">
				<div class="col-sm-8 col-md-9 col-lg-9 top-bar-left">
					<?php if ( $cg_shop_announcements == '1' ) { ?>
						<ul class="cg-show-announcements">
							<?php cg_get_announcements(); ?>
						</ul>
					<?php } else { ?>
						<?php if ( is_active_sidebar( 'top-bar-left' ) ) : ?>
							<?php dynamic_sidebar( 'top-bar-left' ); ?>
						<?php endif; ?>
					<?php } ?>
				</div>
				<div class="col-sm-4 col-md-3 col-lg-3 top-bar-right">
					<?php if ( is_active_sidebar( 'top-bar-right' ) ) : ?>
						<?php dynamic_sidebar( 'top-bar-right' ); ?>
					<?php endif; ?>
				</div>		
			</div>
		</div>
	</div>
<?php } ?>	
<!--/ End Top Bar -->

<!-- Only load if Mobile Search Widget Area is Enabled -->
<?php if ( is_active_sidebar( 'mobile-search' ) ) : ?>

	<script>

	    ( function ( $ ) {
	        "use strict";

	        $( document ).ready( function () {
	            $( ".activate-mobile-search" ).click( function () {
	                $( ".mobile-search-reveal" ).slideToggle( "fast" );
	            } );
	        } );

	    }( jQuery ) );
	</script>

	<div class="mobile-search-reveal">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12">
					<div class="activate-mobile-search close"><i class="ion-close-round"></i></div>
					<?php dynamic_sidebar( 'mobile-search' ); ?>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>
<!--/ End Mobile Search -->

<div id="wrapper">
	<!-- Left Logo with menu below -->
	<div class="cg-menu-below cg-logo-left cg-menu-left">
		<div class="container">
			<div class="cg-logo-cart-wrap">
				<div class="cg-logo-inner-cart-wrap">
					<div class="row">
						<div class="container width-auto">
							<div class="cg-wp-menu-wrapper">
								<div id="load-mobile-menu">
								</div>

								<?php if ( is_active_sidebar( 'mobile-search' ) ) : ?>
									<div class="activate-mobile-search"><i class="ion-android-search mobile-search-icon"></i></div>
								<?php endif; ?>

								<div class="rightnav">
									<div class="cg-extras">
															
										<?php if ( $cg_display_search == '1' ) { ?>
										<div class="extra"><?php echo cg_search(); ?></div>
										<?php } ?> 
										<div class="extra"><?php dynamic_sidebar( 'header-details' ); ?></div>


									</div><!--/cg-extras --> 
								</div><!--/rightnav -->

								<?php
								$cg_main_logo	 = '';
								$cg_main_logo	 = cg_get_logo( 'main' );

								if ( $cg_main_logo ) {
									?>

									<div class="leftnav logo image dynamic-logo-width">
										<a class="cg-main-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
											<span class="helper"></span><img src="<?php echo esc_url( $cg_main_logo ); ?>" alt="<?php bloginfo( 'name' ); ?>"/></a>
									</div>

								<?php } else { ?>
									<div class="leftnav text-logo dynamic-logo-width">
										<span><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></span>
									</div>
								<?php } ?>

							</div>
						</div><!--/container -->
					</div><!--/row -->
				</div><!--/cg-logo-inner-cart-wrap -->
			</div><!--/cg-logo-cart-wrap -->
		</div><!--/container -->
	</div><!--/cg-menu-below -->
	<div class="cg-primary-menu cg-wp-menu-wrapper cg-primary-menu-below-wrapper cg-primary-menu-left">
		<div class="container">
			<div class="row margin-auto">
			
					<?php if ( has_nav_menu( 'primary' ) ) { ?>
						<?php
						wp_nav_menu( array(
							'theme_location'	 => 'primary',
							'before'			 => '',
							'after'				 => '',
							'link_before'		 => '',
							'link_after'		 => '',
							'depth'				 => 4,
							'container'			 => 'div',
							'container_class'	 => 'cg-main-menu',
							'fallback_cb'		 => false,
							'walker'			 => new cg_primary_menu() )
						);
						?>
					<?php } else { ?>
						<p class="setup-message"><?php echo esc_html__( 'You can set your main menu in Appearance &rarr; Menus', 'broker' ); ?></p>
					<?php } ?>
					
			</div>
		</div>
	</div>




	<?php
	if ( $cg_sticky_menu == '1' ) {
		?>
		<!--FIXED -->
		<?php
		$cg_fixed_beside_style = '';

		if ( isset( $_GET['logo_position'] ) ) {
			$cg_logo_position = $_GET['logo_position'];
		}

		if ( $cg_logo_position == 'beside' ) {
			$cg_fixed_beside_style = 'cg-fixed-beside';
		}
		?>
		<div class="cg-header-fixed-wrapper <?php echo esc_attr( $cg_fixed_beside_style ); ?>">
			<div class="cg-header-fixed">
				<div class="container">
					<div class="cg-wp-menu-wrapper">
						<div class="cg-primary-menu">
							<div class="row">
								<div class="container width-auto">
									<div class="cg-wp-menu-wrapper">
										<div class="rightnav">
											
											<?php 
											if ( $cg_cta_sticky == 'yes' ) {
												cg_get_cta_button(); 
											}
											?>

										</div><!--/rightnav -->

										<?php
										$cg_sticky_logo	 = '';
										$cg_sticky_logo	 = cg_get_logo( 'sticky' );

										if ( $cg_sticky_logo ) {
											?>

											<div class="leftnav logo image">
												<a class="cg-sticky-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
													<span class="helper"></span><img src="<?php echo esc_url( $cg_sticky_logo ); ?>" alt="<?php bloginfo( 'name' ); ?>"/></a>
											</div>
										<?php } else { ?>
											<div class="leftnav text-logo">
												<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
											</div>
										<?php } ?>
										<?php if ( has_nav_menu( 'primary' ) ) { ?>
											<?php
											wp_nav_menu( array(
												'theme_location' => 'primary',
												'before'		 => '',
												'after'			 => '',
												'link_before'	 => '',
												'link_after'	 => '',
												'depth'			 => 4,
												'fallback_cb'	 => false,
												'walker'		 => new cg_primary_menu() )
											);
											?>
										<?php } else { ?>
											<p class="setup-message"><?php echo esc_html__( 'You can set your main menu in Appearance -> Menus', 'broker' ); ?></p>
										<?php } ?>
									</div><!--/cg-wp-menu-wrapper -->
								</div><!--/container -->
							</div><!--/row -->
						</div><!--/cg-primary-menu -->
					</div><!--/cg-wp-menu-wrapper -->
				</div><!--/container -->
			</div><!--/cg-header-fixed -->
		</div><!--/cg-header-fixed-wrapper. -->
	<?php }
	?>

	<div class="page-container">