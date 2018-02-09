<?php

/*
  Plugin Name: CommerceGurus Visual Composer Extensions
  Plugin URI: http://commercegurus.com
  Description: Extensions to Visual Composer for the CommerceGurus themes.
  Version: 1.0
  Author: CommerceGurus
  Author URI: http://commercegurus.com
  License: GPLv2 or later
 */

// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/*
  Display notice if Visual Composer is not installed or activated.
 */
if ( !defined( 'WPB_VC_VERSION' ) ) {
	add_action( 'admin_notices', 'cg_vc_extend_notice' );
	return;
}

function cg_vc_extend_notice() {
	$cg_plugin_data = get_plugin_data( __FILE__ );
	echo '
  <div class="updated">
    <p>' . sprintf( esc_html__( '<strong>%s</strong> requires <strong><a href="http://bit.ly/vcomposer" target="_blank">Visual Composer</a></strong> plugin to be installed and activated on your site.', 'broker' ), $cg_plugin_data['Name'] ) . '</p>
  </div>';
}

//Removing shortcodes
vc_remove_element( "vc_widget_sidebar" );
vc_remove_element( "vc_wp_search" );
vc_remove_element( "vc_wp_meta" );
vc_remove_element( "vc_wp_recentcomments" );
vc_remove_element( "vc_wp_calendar" );
vc_remove_element( "vc_wp_tagcloud" );
vc_remove_element( "vc_wp_custommenu" );
vc_remove_element( "vc_wp_text" );
vc_remove_element( "vc_wp_posts" );
vc_remove_element( "vc_wp_links" );
vc_remove_element( "vc_wp_categories" );
vc_remove_element( "vc_wp_archives" );
vc_remove_element( "vc_wp_rss" );
vc_remove_param( 'vc_separator', 'accent_color' );
vc_remove_param( 'vc_separator', 'style' );
vc_remove_param( 'vc_separator', 'el_width' );


vc_add_param( "vc_row", array(
	"type"		 => "dropdown",
	"class"		 => "",
	"heading"	 => esc_html__( "Type", 'broker' ),
	"param_name" => "type",
	"save_always" 	 => true,
	"value"		 => array(
		esc_html__( "Fixed Page Width", 'broker' )					 => "container",
		esc_html__( "Full Page Width - No Container", 'broker ' )	 => "full_page_width",
		esc_html__( "Full Page Width - Inner Container", 'broker' )	 => "full_page_width_inner_container",
	),
) );

vc_add_param( "vc_row", array(
	"type"			 => "textfield",
	"class"			 => "",
	"heading"		 => esc_html__( "Padding Top", 'broker' ),
	"value"			 => "",
	"param_name"	 => "padding_top",
	"save_always" 	 => true,
	"description"	 => "",
) );

vc_add_param( "vc_row", array(
	"type"			 => "textfield",
	"class"			 => "",
	"heading"		 => esc_html__( "Padding Bottom", 'broker' ),
	"value"			 => "",
	"param_name"	 => "padding_bottom",
	"save_always" 	 => true,
	"description"	 => "",
) );


// Separator
$cg_separator_setting = array(
	'show_settings_on_create'	 => true,
	"controls"					 => '',
);
vc_map_update( 'vc_separator', $cg_separator_setting );

vc_add_param( "vc_separator", array(
	"type"			 => "dropdown",
	"class"			 => "",
	"heading"		 => esc_html__( "Type", 'broker' ),
	"param_name"	 => "type",
	"value"			 => array(
		"Normal"		 => "normal",
		"Transparent"	 => "transparent",
		"Full width"	 => "full_width",
		"Small"			 => "small"
	),
	"save_always" 	 => true,
	"description"	 => ""
) );

vc_add_param( "vc_separator", array(
	"type"			 => "dropdown",
	"class"			 => "",
	"heading"		 => esc_html__( "Position", 'broker' ),
	"param_name"	 => "position",
	"value"			 => array(
		"Center" => "center",
		"Left"	 => "left",
		"Right"	 => "right"
	),
	"dependency"	 => array( "element" => "type", "value" => array( "small" ) ),
	"save_always" 	 => true,
	"description"	 => ""
) );

vc_add_param( "vc_separator", array(
	"type"			 => "colorpicker",
	"class"			 => "",
	"heading"		 => esc_html__("Color", 'broker' ),
	"param_name"	 => "color",
	"value"			 => "",
	"save_always" 	 => true,
	"description"	 => ""
) );

vc_add_param( "vc_separator", array(
	"type"			 => "textfield",
	"class"			 => "",
	"heading"		 => esc_html__( "Thickness", 'broker' ),
	"param_name"	 => "thickness",
	"value"			 => "",
	"save_always" 	 => true,
	"description"	 => ""
) );
vc_add_param( "vc_separator", array(
	"type"			 => "textfield",
	"class"			 => "",
	"heading"		 => esc_html__( "Top Margin", 'broker' ),
	"param_name"	 => "up",
	"value"			 => "",
	"save_always" 	 => true,
	"description"	 => ""
) );
vc_add_param( "vc_separator", array(
	"type"			 => "textfield",
	"class"			 => "",
	"heading"		 => esc_html__( "Bottom Margin", 'broker' ),
	"param_name"	 => "down",
	"value"			 => "",
	"save_always" 	 => true,
	"description"	 => ""
) );


/*
  Lets call vc_map  function to "register" our custom shortcode within Visual Composer interface.
 */

vc_map ( array(
	"name"		 => esc_html__( "CommerceGurus Logos", 'broker' ),
	"base"		 => "cg_logos",
	"class"		 => "",
	"controls"	 => "full",
	"icon"		 => "icon-wpb-cg_vc_extend",
	"category"	 => esc_html__( 'CommerceGurus Shortcodes', 'broker' ),
	"params"	 => array(
		array(
			"type"			 => "textfield",
			"holder"		 => "div",
			"class"			 => "",
			"heading"		 => esc_html__( "Number of Logos", 'broker' ),
			"param_name"	 => "posts",
			"value"			 => "10",
			"save_always" 	 => true,
			"description"	 => esc_html__( "Enter the total number of logos you wish to display in the carousel.", 'broker' )
		),
	)
) );
