<?php
/**
 * General functions used to integrate this theme with WooCommerce.
 *
 * @package broker
 */

/**
 * Before Content
 * Wraps all WooCommerce content in wrappers which match the theme markup
 * @since   1.0.0
 * @return  void
 */

if ( ! function_exists( 'broker_header_before_content' ) ) {
	function broker_header_before_content() {
		?>
		
		<?php do_action( 'cg_woo_title' ); ?>
	    	<?php
	}
}

if ( ! function_exists( 'broker_before_content' ) ) {
	function broker_before_content() {
		?>
		<div class="container cg-shop-main">
			<div class="row">
				<div class="col-lg-9 col-md-9 col-sm-12 col-md-push-3 col-lg-push-3">
	    	<?php
	}
}



/**
 * After Content
 * Closes the wrapping divs
 * @since   1.0.0
 * @return  void
 */
if ( ! function_exists( 'broker_after_content' ) ) {
	function broker_after_content() {
		?>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-12 col-md-pull-9 col-lg-pull-9 sidebar">
            		<div id="secondary">
						<?php dynamic_sidebar( 'shop-sidebar' ); ?>
					</div>	
            	</div>

			</div>
		</div>
	<?php }
}

/**
 * Removes page titles
 * @since   1.0.0
 * @return  void
 */
function broker_override_page_title() {
return false;
}
add_filter('woocommerce_show_page_title', 'broker_override_page_title');

// Change number or products per row to 3
add_filter('loop_shop_columns', 'loop_columns');
if (!function_exists('loop_columns')) {
	function loop_columns() {
		return 3; // 3 products per row
	}
}

// Change number of related products per row to 3
add_filter( 'woocommerce_output_related_products_args', 'cg_related_products_count' );
 
function cg_related_products_count( $args ) {
     $args['posts_per_page'] = 3;
     $args['columns'] = 3;
 
     return $args;
}

// Change number of upsell products per row to 3
add_filter( 'woocommerce_output_upsells_args', 'cg_upsell_products_count' );
 
function cg_upsell_products_count( $args ) {
     $args['posts_per_page'] = 3;
     $args['columns'] = 3;
 
     return $args;
}

// Change number of products per page to 9
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 9;' ), 20 );

?>