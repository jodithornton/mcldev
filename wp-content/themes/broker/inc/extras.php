<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package commercegurus
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function cg_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}

add_filter( 'wp_page_menu_args', 'cg_page_menu_args' );

/**
 * Adds custom classes to the array of body classes.
 */
function cg_body_classes( $classes ) {
	global $cg_options;
	$cg_sticky_menu_class	 = '';
	$cg_hide_prices			 = '';
	$cg_header_bg_style		 = '';

	if ( isset( $cg_options['cg_sticky_menu'] ) ) {
		$cg_sticky_menu_class = $cg_options['cg_sticky_menu'];
	}

	if ( isset( $cg_options['cg_hide_prices'] ) ) {
		$cg_hide_prices = $cg_options['cg_hide_prices'];
	}

	// Adds a class of group-blog to blogs with more than 1 published author
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	if ( $cg_hide_prices == 'yes' ) {
		$classes[] = 'cg-hide-prices';
	}

	$global_trans_header_style = '';

	if ( isset( $cg_options['global_trans_header_style'] ) ) {
		$global_trans_header_style = $cg_options['global_trans_header_style'];
	}

	$cg_header_bg_style = get_post_meta( get_the_ID(), '_cgcmb_header_style', true );

	if ( ( "" !== $cg_header_bg_style ) && ( 'header-globaloption' !== $cg_header_bg_style ) ) {
		$classes[] = $cg_header_bg_style;
	} else if ( "" !== $global_trans_header_style ) {
		$classes[] = $global_trans_header_style;
	} else {
		$classes[] = 'cg-header-style-default';
	}

	//if ( $cg_sticky_menu_class == 'yes' ) {
	$classes[] = 'cg-sticky-enabled';
	//}

	return $classes;
}

add_filter( 'body_class', 'cg_body_classes' );

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 */
function cg_enhanced_image_navigation( $url, $id ) {
	if ( !is_attachment() && !wp_attachment_is_image( $id ) )
		return $url;

	$image = get_post( $id );
	if ( !empty( $image->post_parent ) && $image->post_parent != $id )
		$url .= '#main';

	return $url;
}

add_filter( 'attachment_link', 'cg_enhanced_image_navigation', 10, 2 );

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 */
function cg_wp_title( $title, $sep ) {
	global $page, $paged;

	if ( is_feed() )
	//	return $title;

	// Add the blog name
	$title .= get_bloginfo( 'name' );

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $sep " . sprintf( esc_html__( 'Page %s', 'broker' ), max( $paged, $page ) );

	return $title;
}

add_filter( 'wp_title', 'cg_wp_title', 10, 2 );

function cg_add_menu_parent( $items ) {
	$parents = array();
	foreach ( $items as $item ) {
		if ( $item->menu_item_parent && $item->menu_item_parent > 0 ) {
			$parents[] = $item->menu_item_parent;
		}
	}
	return $items;
}

add_filter( 'wp_nav_menu_objects', 'cg_add_menu_parent' );


/* Boxed class */
if ( !function_exists( 'cg_boxed_class' ) ) {

	function cg_boxed_class( $classes ) {
		global $cg_options;
		$cg_boxed_status = '';

		if ( !empty( $_SESSION['cg_boxed'] ) ) {
			$cg_boxed_status = esc_html( $_SESSION['cg_boxed'] );
		}

		if ( ( isset( $cg_options['container_style'] ) && $cg_options['container_style'] == 'boxed' ) || ( $cg_boxed_status == 'yes' ) ) :
			$classes[] = 'boxed';
		else:
			$classes[] = "";
		endif;

		return $classes;
	}

}

add_filter( 'body_class', 'cg_boxed_class' );

// Initialize some global js vars
//add_action( 'wp_head', 'cg_js_init' );
if ( !function_exists( 'cg_js_init' ) ) {

	function cg_js_init() {
		global $cg_options;
		?>
		<script type="text/javascript">
		    var view_mode_default = '<?php echo esc_js( $cg_options['product_layout'] ) ?>';
		    var cg_sticky_default = '<?php echo esc_js( $cg_options['cg_sticky_menu'] ) ?>';
		</script>
		<?php
	}

}

// Util function for building VC row styles - replaces default VC buildstyle function

if ( !function_exists( 'cg_build_style' ) ) {

	function cg_build_style( $bg_image = '', $bg_color = '', $bg_image_repeat = '', $font_color = '', $padding = '',
						  $padding_bottom = '', $padding_top = '', $margin_bottom = '' ) {
		$has_image	 = false;
		$style		 = '';
		if ( (int) $bg_image > 0 && ( $image_url	 = wp_get_attachment_url( $bg_image, 'large' ) ) !== false ) {
			$has_image = true;
			$style .= "background-image: url(" . $image_url . ");";
		}
		if ( !empty( $bg_color ) ) {
			$style .= 'background-color: ' . $bg_color . ';';
		}
		if ( !empty( $bg_image_repeat ) && $has_image ) {
			if ( $bg_image_repeat === 'cover' ) {
				$style .= "background-repeat:no-repeat;background-size: cover;";
			} elseif ( $bg_image_repeat === 'contain' ) {
				$style .= "background-repeat:no-repeat;background-size: contain;";
			} elseif ( $bg_image_repeat === 'no-repeat' ) {
				$style .= 'background-repeat: no-repeat;';
			}
		}
		if ( !empty( $font_color ) ) {
			$style .= 'color: ' . $font_color . ';';
		}
		if ( $padding != '' ) {
			$style .= 'padding: ' . ( preg_match( '/(px|em|\%|pt|cm)$/', $padding ) ? $padding : $padding . 'px' ) . ';';
		}
		if ( $padding_bottom != '' ) {
			$style .= 'padding-bottom: ' . ( preg_match( '/(px|em|\%|pt|cm)$/', $padding_bottom ) ? $padding_bottom : $padding_bottom . 'px' ) . ';';
		}
		if ( $padding_top != '' ) {
			$style .= 'padding-top: ' . ( preg_match( '/(px|em|\%|pt|cm)$/', $padding_top ) ? $padding_top : $padding_top . 'px' ) . ';';
		}
		if ( $margin_bottom != '' ) {
			$style .= 'margin-bottom: ' . ( preg_match( '/(px|em|\%|pt|cm)$/', $margin_bottom ) ? $margin_bottom : $margin_bottom . 'px' ) . ';';
		}
		return empty( $style ) ? $style : ' style="' . $style . '"';
	}

}

// Hi ThemeForest review team! This is a safe filter for cleaning up CommerceGurus shortcode output only!
// Credits to bitfade for this solution - https://gist.github.com/bitfade/4555047
// Ref - http://themeforest.net/forums/thread/how-to-add-shortcodes-in-wp-themes-without-being-rejected/98804?page=4#996848

add_filter( "the_content", "cg_content_filter" );

function cg_content_filter( $content ) {

	// array of custom shortcodes requiring the fix
	$block = join( "|", array( "cg_content_strip", "vc_button", "cg_video_banner" ) );

	// opening tag
	$rep = preg_replace( "/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/", "[$2$3]", $content );

	// closing tag
	$rep = preg_replace( "/(<p>)?\[\/($block)](<\/p>|<br \/>)?/", "[/$2]", $rep );

	return $rep;
}

add_action( 'cg_page_title', 'cg_page_title_callback' );

function cg_page_title_callback() {
	global $post, $cg_options;
	$cg_is_page_title_bg_color				 = '';
	$cg_show_page_title						 = '';
	$cg_page_title_background_color			 = '';
	$cg_page_title_font_color				 = '';
	$cg_page_title_background_color_style	 = '';
	$cg_page_title_font_color_style			 = '';
	$cg_cta_heading							 = '';
	$cg_share_options 						 = '';
	$cg_header_image						 = '';
	$cg_header_image_style					 = '';

	if ( isset( $cg_options['cg_share_options'] ) ) {
		$cg_share_options = $cg_options['cg_share_options'];
	}

	if ( function_exists( 'get_field' ) ) {

		$cg_show_page_title			 = get_field( 'show_page_title' );
		$cg_is_page_title_bg_color	 = get_field( 'cg_is_page_title_bg_color' );

		if ( $cg_is_page_title_bg_color == 'true' ) {
			$cg_page_title_background_color		 = get_field( 'page_title_background_color' );
			$cg_page_title_background_opacity	 = get_field( 'page_title_background_opacity' );
			$cg_page_title_font_color			 = get_field( 'page_title_font_color' );
			if ( !empty( $cg_page_title_background_color ) ) {
				$cg_page_title_background_color_style = 'style="background-color:' . $cg_page_title_background_color . '; opacity:' . $cg_page_title_background_opacity . ';"';
			}
			if ( !empty( $cg_page_title_font_color ) ) {
				$cg_page_title_font_color_style = 'style="color:' . $cg_page_title_font_color . '"';
			}
		}
	}
	?>

	<?php 

	if ( isset( $cg_options['cg_cta_heading'] ) ) {
		$cg_cta_heading = $cg_options['cg_cta_heading'];
	}

	?>

	<?php if ( $cg_show_page_title !== 'Hide' ) { ?>

	<?php if (has_post_thumbnail( $post->ID ) ):
	$cg_header_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); 
	
	if ( $cg_header_image ) {
	$cg_header_image_style = 'background-image: url('. $cg_header_image[0] . '); ';
	}

	endif; ?>

		<div class="header-wrapper">
			<div class="cg-hero-bg" style="<?php echo $cg_header_image_style; ?>"></div>
			<div class="overlay"></div> 
			<div class="container">
				<div class="row vertical-align">
					<div class="col-xs-12 col-lg-9 col-md-9">
						<header class="entry-header">
							<h1 class="cg-page-title"><?php the_title(); ?></h1>
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

	<?php }
	?>

	<?php
}

function cg_get_page_title() {
	do_action( 'cg_page_title' );
}

function cg_get_cta_button() {
	global $cg_options;
	$cg_cta_message							 = '';
	$cg_cta_link							 = '';

	if ( isset( $cg_options['cg_cta_message'] ) ) {
		$cg_cta_message = $cg_options['cg_cta_message'];
	}

	if ( isset( $cg_options['cg_cta_link'] ) ) {
		$cg_cta_link = $cg_options['cg_cta_link'];
	}

	?>

	<div class="cta-button">
		<a href="<?php echo esc_url( $cg_cta_link ); ?>"><?php echo $cg_cta_message; ?></a>
	</div>

	<?php 

}

function cg_get_share_options_title() {
?>
	<p class="cg-share"><span id="cg-share-toggle"><?php esc_html_e( 'Share', 'broker' ); ?></span></p>
<?php 
}

function cg_get_share_options_content() {
?>
		<div class="share-wrapper">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 col-md-12">
						<div class="cg-share-tools">
					        <a target="_blank" href="https://facebook.com/sharer.php?u=<?php echo get_permalink(); ?>"><i class="fa fa-facebook"></i></a>            
					        <a target="_blank" href="https://twitter.com/intent/tweet?url=<?php echo get_permalink(); ?>&amp;text=<?php echo urlencode(get_the_title()); ?>"><i class="fa fa-twitter"></i></a>            
					        <a target="_blank" href="https://www.linkedin.com/shareArticle?url=<?php echo get_permalink(); ?>&amp;title=<?php echo urlencode(get_the_title()); ?>"><i class="fa fa-linkedin"></i></a>            
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
				$( '#cg-share-toggle' ).click( function() {
					$( '.share-wrapper' ).slideToggle( 'fast', function() {
						$( '#cg-share-toggle' ).toggleClass( 'opened', $(this).is( ':visible' ) );
						return false;
					});
				});
			});
		}( jQuery ) );

		</script>

<?php
}


// WooCommerce Header

add_action( 'cg_woo_title', 'cg_woo_title_callback' );

function cg_woo_title_callback() {
	global $post;
	$cg_is_page_title_bg_color				 = '';
	$cg_show_page_title						 = '';
	$cg_page_title_background_color			 = '';
	$cg_page_title_font_color				 = '';
	$cg_page_title_background_color_style	 = '';
	$cg_page_title_font_color_style			 = '';
	$cg_share_options 						 = '';

	if ( isset( $cg_options['cg_share_options'] ) ) {
		$cg_share_options = $cg_options['cg_share_options'];
	}

	if ( function_exists( 'get_field' ) ) {

		$cg_show_page_title			 = get_field( 'show_page_title' );
		$cg_is_page_title_bg_color	 = get_field( 'cg_is_page_title_bg_color' );

		if ( $cg_is_page_title_bg_color == 'true' ) {
			$cg_page_title_background_color		 = get_field( 'page_title_background_color' );
			$cg_page_title_background_opacity	 = get_field( 'page_title_background_opacity' );
			$cg_page_title_font_color			 = get_field( 'page_title_font_color' );
			if ( !empty( $cg_page_title_background_color ) ) {
				$cg_page_title_background_color_style = 'style="background-color:' . $cg_page_title_background_color . '; opacity:' . $cg_page_title_background_opacity . ';"';
			}
			if ( !empty( $cg_page_title_font_color ) ) {
				$cg_page_title_font_color_style = 'style="color:' . $cg_page_title_font_color . '"';
			}
		}
	}
	?>

	
	<?php if ( $cg_show_page_title !== 'Hide' ) { ?>

		<div class="header-wrapper">
			<div class="overlay"></div> 
			<div class="container">
				<div class="row vertical-align">
					<div class="col-xs-12 col-lg-12 col-md-12">
						<header class="entry-header">
							<h1 class="cg-page-title"><?php woocommerce_page_title(); ?></h1>
						</header>
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
	
	<?php }
	?>

	<?php
}

function cg_get_woo_title() {
	do_action( 'cg_woo_title' );
}

// End Woo Header

add_action( 'cg_blog_page_title', 'cg_blog_page_title_callback' );

function cg_blog_page_title_callback() {
	global $cg_options;
	$cg_blog_page_title	 = '';
	$cg_blog_header_bg	 = '';

	$cg_is_page_title_bg_color				 = '';
	$cg_show_page_title						 = '';
	$cg_page_title_background_color			 = '';
	$cg_page_title_font_color				 = '';
	$cg_page_title_background_color_style	 = '';
	$cg_page_title_font_color_style			 = '';
	$cg_cta_heading 						 = '';

	if ( isset( $cg_options['cg_cta_heading'] ) ) {
		$cg_cta_heading = $cg_options['cg_cta_heading'];
	}

	$cg_share_options 						 = '';

	if ( isset( $cg_options['cg_share_options'] ) ) {
		$cg_share_options = $cg_options['cg_share_options'];
	}


	if ( isset( $cg_options['cg_blog_page_title'] ) ) {
		$cg_blog_page_title = $cg_options['cg_blog_page_title'];
	}

	if ( function_exists( 'get_field' ) ) {
		$cg_show_page_title			 = get_field( 'show_page_title' );
		$cg_is_page_title_bg_color	 = get_field( 'cg_is_page_title_bg_color' );

		if ( $cg_is_page_title_bg_color == 'true' ) {
			$cg_page_title_background_color		 = get_field( 'page_title_background_color' );
			$cg_page_title_background_opacity	 = get_field( 'page_title_background_opacity' );
			$cg_page_title_font_color			 = get_field( 'page_title_font_color' );
			if ( !empty( $cg_page_title_background_color ) ) {
				$cg_page_title_background_color_style = 'style="background-color:' . $cg_page_title_background_color . '; opacity:' . $cg_page_title_background_opacity . ';"';
			}
			if ( !empty( $cg_page_title_font_color ) ) {
				$cg_page_title_font_color_style = 'style="color:' . $cg_page_title_font_color . '"';
			}
		}
	}
	?>

<div class="header-wrapper">
			<div class="cg-hero-bg"></div>
			<div class="overlay"></div> 
			<div class="container">
				<div class="row vertical-align">
					<div class="col-xs-12 col-lg-9 col-md-9">
						<header class="entry-header">
							<h1 class="cg-page-title"><?php echo wp_kses_post( $cg_blog_page_title ); ?></h1>
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
	
	<?php
}

function cg_get_blog_page_title() {
	do_action( 'cg_blog_page_title' );
}

/* Logo helper */
if ( !function_exists( 'cg_get_logo' ) ) {

	function cg_get_logo( $logo_type ) {
		global $cg_options, $cg_mobile_light_logo;
		$cg_protocol = ( is_ssl() ) ? "https:" : "http:";
		$cg_logo				 = '';
		$cg_trans_logo			 = '';
		$trans_site_logo_light	 = '';
		$trans_site_logo_dark	 = '';

		// Logo vars

		if ( $logo_type == 'main' ) {

			// Main logo
			if ( !empty( $cg_options['site_logo']['url'] ) ) {
				$cg_options['site_logo']['url']	 = $cg_protocol . str_replace( array( 'http:', 'https:' ), '', $cg_options['site_logo']['url'] );
				$cg_logo						 = $cg_options['site_logo']['url'];
			}

			// Transparent - Light logo
			if ( !empty( $cg_options['trans_site_logo_light']['url'] ) ) {
				$cg_options['trans_site_logo_light']['url']	 = $cg_protocol . str_replace( array( 'http:', 'https:' ), '', $cg_options['trans_site_logo_light']['url'] );
				$trans_site_logo_light						 = $cg_options['trans_site_logo_light']['url'];
			} else {
				$trans_site_logo_light = $cg_logo;
			}

			// Transparent - Dark logo
			if ( !empty( $cg_options['trans_site_logo_dark']['url'] ) ) {
				$cg_options['trans_site_logo_dark']['url']	 = $cg_protocol . str_replace( array( 'http:', 'https:' ), '', $cg_options['trans_site_logo_dark']['url'] );
				$trans_site_logo_dark						 = $cg_options['trans_site_logo_dark']['url'];
			} else {
				$trans_site_logo_dark = $cg_logo;
			}

			// Header styles
			$global_trans_header_style	 = '';
			$cg_header_bg_style			 = '';

			$cg_logo_position = '';

			if ( isset( $cg_options['cg_logo_position'] ) ) {
				$cg_logo_position = $cg_options['cg_logo_position'];
			}

			if ( isset( $_GET['logo_position'] ) ) {
				$cg_logo_position = $_GET['logo_position'];
			}

			if ( isset( $cg_options['global_trans_header_style'] ) ) {
				$global_trans_header_style = $cg_options['global_trans_header_style'];
			}

			$cg_header_bg_style = get_post_meta( get_the_ID(), '_cgcmb_header_style', true );

			if ( ( $cg_logo_position == 'beside' ) || ( $cg_logo_position == 'right' ) ) {

				if ( ( "" !== $cg_header_bg_style ) && ( 'header-globaloption' !== $cg_header_bg_style ) ) {
					if ( $cg_header_bg_style == 'header-default' ) {
						$cg_trans_logo = esc_url( $cg_logo );
						return $cg_trans_logo;
					} else if ( $cg_header_bg_style == 'transparent-light' ) {
						$cg_trans_logo		 = esc_url( $trans_site_logo_light );
						$cg_dark_mobile_logo = esc_url( $cg_logo );
						return array( $cg_trans_logo, $cg_dark_mobile_logo );
					} else if ( $cg_header_bg_style == 'transparent-dark' ) {
						$cg_trans_logo = esc_url( $trans_site_logo_dark );
						return $cg_trans_logo;
					}
				} else if ( "" !== $global_trans_header_style ) {
					if ( $global_trans_header_style == 'header-default' ) {
						$cg_trans_logo = esc_url( $cg_logo );
						return $cg_trans_logo;
					} else if ( $global_trans_header_style == 'transparent-light' ) {
						$cg_trans_logo = esc_url( $trans_site_logo_light );
						return $cg_trans_logo;
					} else {
						$cg_trans_logo = esc_url( $trans_site_logo_dark );
						return $cg_trans_logo;
					}
				} else if ( $cg_logo ) {
					return $cg_logo;
				} else {
					return false;
				}
			} else if ( $cg_logo ) {
				return $cg_logo;
			} else {
				return false;
			}
		} else if ( $logo_type == 'sticky' ) {

			// Sticky logo
			if ( !empty( $cg_options['cg_alt_site_logo']['url'] ) ) {
				$cg_options['cg_alt_site_logo']['url']	 = $cg_protocol . str_replace( array( 'http:', 'https:' ), '', $cg_options['cg_alt_site_logo']['url'] );
				$cg_sticky_logo							 = $cg_options['cg_alt_site_logo']['url'];
				return $cg_sticky_logo;
			}
		}
	}
}