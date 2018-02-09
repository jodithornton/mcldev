<?php
/**
 * Broker WooCommerce hooks
 *
 * @package broker
 */

remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 	10 );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
remove_filter( 'woocommerce_show_page_title', 'filter_woocommerce_show_page_title', 10, 1 );

//add_action( 'broker_header_before_content', 'woocommerce_breadcrumb', 10 );
add_action( 'woocommerce_before_main_content', 'broker_header_before_content', 10 );
add_action( 'woocommerce_before_main_content', 'broker_before_content', 10 );
add_action( 'woocommerce_after_main_content',  'broker_after_content', 10 );
