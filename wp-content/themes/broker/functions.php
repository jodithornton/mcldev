<?php

/**
 * CommerceGurus functions and definitions
 * Maybe your best course would be to tread lightly.
 *
 * @package commercegurus
 */

global $cg_options;

/**
 * Global Paths
 */
define( 'CG_FILEPATH', get_template_directory() );
define( 'CG_THEMEURI', get_template_directory_uri() );
define( 'CG_BOOTSTRAP_JS', get_template_directory_uri() . '/inc/core/bootstrap/dist/js' );
define( 'CG_JS', get_template_directory_uri() . '/js' );
define( 'CG_CORE', get_template_directory() . '/inc/core' );


/**
 * Constants for Plugins
 */
define( 'ULTIMATE_USE_BUILTIN', true );


/**
 * Load Globals
 */
require_once( CG_CORE . '/functions/javascript.php' );
require_once( CG_CORE . '/functions/get-the-image.php' );
require_once( CG_CORE . '/menus/wp_bootstrap_navwalker.php' );
require_once( CG_CORE . '/menus/megadropdown.php' );


/**
 * TGM Plugin Activation
 */
require_once( CG_CORE . '/functions/class-tgm-plugin-activation.php' );
add_action( 'tgmpa_register', 'cg_register_required_plugins' );

function cg_register_required_plugins() {

	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
		array(
			'name'		 => 'One Click Demo Import', // The plugin name
			'slug'		 => 'one-click-demo-import', // The plugin slug (typically the folder name)
			'required'	 => false, // If false, the plugin is only 'recommended' instead of required
		),
		array(
			'name'		 => 'Advanced Custom Fields', // The plugin name
			'slug'		 => 'advanced-custom-fields', // The plugin slug (typically the folder name)
			'required'	 => true, // If false, the plugin is only 'recommended' instead of required
		),
		array(
			'name'		 => 'Advanced Sidebar Menu', // The plugin name
			'slug'		 => 'advanced-sidebar-menu', // The plugin slug (typically the folder name)
			'required'	 => false, // If false, the plugin is only 'recommended' instead of required
		),
		array(
			'name'		 => 'Redux Framework', // The plugin name
			'slug'		 => 'redux-framework', // The plugin slug (typically the folder name)
			'required'	 => true, // If false, the plugin is only 'recommended' instead of required
		),
		array(
			'name'               => 'Layer Slider', // The plugin name
			'slug'               => 'LayerSlider', // The plugin slug (typically the folder name)
			'source'             => 'http://files.commercegurus.com/layersliderwp-6.5.7.installable.zip', // The plugin source
			'required'           => false, // If false, the plugin is only 'recommended' instead of required
			'version'            => '6.5.7', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation'	 => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url'		 => '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'               => 'WPBakery Visual Composer', // The plugin name
			'slug'               => 'js_composer', // The plugin slug (typically the folder name)
			'source'             => 'http://files.commercegurus.com/js_composer_5.2.1/js_composer.zip', // The plugin source
			'required'           => false, // If false, the plugin is only 'recommended' instead of required
			'version'            => '5.2.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation'	 => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url'		 => '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'				 => 'CommerceGurus Toolkit', // The plugin name
			'slug'				 => 'commercegurus-toolkit', // The plugin slug (typically the folder name)
			'source'			 => get_template_directory_uri() . '/inc/plugins/commercegurus-toolkit.zip', // The plugin source
			'required'			 => true, // If false, the plugin is only 'recommended' instead of required
			'version'			 => '1.5', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation'	 => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url'		 => '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'		 => 'Contact Form 7', // The plugin name
			'slug'		 => 'contact-form-7', // The plugin slug (typically the folder name)
			'required'	 => false, // If false, the plugin is only 'recommended' instead of required
		),
		array(
			'name' => 'MailChimp for WordPress', // The plugin name
			'slug' => 'mailchimp-for-wp', // The plugin slug (typically the folder name)
			'required' => false, // If false, the plugin is only 'recommended' instead of required
		),
		array(
			'name' => 'Yoast SEO', // The plugin name
			'slug' => 'wordpress-seo', // The plugin slug (typically the folder name)
			'required' => false, // If false, the plugin is only 'recommended' instead of required
		),
		array(
			'name' => 'Widget CSS Classes', // The plugin name
			'slug' => 'widget-css-classes', // The plugin slug (typically the folder name)
			'required' => false, // If false, the plugin is only 'recommended' instead of required
		),
	);

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'domain'			 => 'broker', // Text domain - likely want to be the same as your theme.
		'default_path'		 => '', // Default absolute path to pre-packaged plugins
		'parent_slug'	 => 'themes.php', // Default parent menu slug
		'menu'				 => 'install-required-plugins', // Menu slug
		'has_notices'		 => true, // Show admin notices or not
		'is_automatic'		 => false, // Automatically activate plugins after installation or not
		'message'			 => '', // Message to output right before the plugins table
		'strings'			 => array(
			'page_title'						 => esc_html__( 'Install Required Plugins', 'broker' ),
			'menu_title'						 => esc_html__( 'Install Plugins', 'broker' ),
			'installing'						 => esc_html__( 'Installing Plugin: %s', 'broker' ), // %1$s = plugin name
			'oops'								 => esc_html__( 'Something went wrong with the plugin API.', 'broker' ),
			'notice_can_install_required'		 => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_install_recommended'	 => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_install'				 => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
			'notice_can_activate_required'		 => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended'	 => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_activate'			 => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
			'notice_ask_to_update'				 => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_update'				 => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
			'install_link'						 => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
			'activate_link'						 => _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
			'return'							 => esc_html__( 'Return to Required Plugins Installer', 'broker' ),
			'plugin_activated'					 => esc_html__( 'Plugin activated successfully.', 'broker' ),
			'complete'							 => esc_html__( 'All plugins installed and activated successfully. %s', 'broker' ), // %1$s = dashboard link
			'nag_type'							 => 'updated',// Determines admin notice type - can only be 'updated' or 'error'
		),
	);

	tgmpa( $plugins, $config );
}

/**
 * Live Preview
 */
if ( ! defined( 'CG_LIVEDEMO' ) ) {
	define( 'CG_LIVEDEMO', false );
}

if ( CG_LIVEDEMO ) {
	$cg_live_preview = true;
}

if ( isset( $cg_live_preview ) ) {

	add_action( 'after_setup_theme', 'cg_start_live_session', 1 );
	add_action( 'wp_logout', 'cg_end_live_session' );
	add_action( 'wp_login', 'cg_end_live_session' );

	// start live session
	if ( ! function_exists( 'cg_start_live_session' ) ) {

		function cg_start_live_session() {
			if ( ! session_id() ) {
				session_start();
			}
		}
	}

	// end live session
	if ( ! function_exists( 'cg_end_live_session' ) ) {

		function cg_end_live_session() {
			session_destroy();
		}
	}
}

/**
 * Load CSS
 */
function cg_load_styles() {
	global $cg_live_preview, $cg_options;

	$cg_responsive_status = '';

	if ( isset( $cg_options['cg_responsive'] ) ) {
		$cg_responsive_status = $cg_options['cg_responsive'];
	}

	wp_register_style( 'cg-bootstrap', get_template_directory_uri() . '/inc/core/bootstrap/dist/css/bootstrap.min.css' );
	wp_register_style( 'cg-commercegurus', get_template_directory_uri() . '/css/commercegurus.css' );

	if ( $cg_responsive_status !== 'disabled' ) {
		wp_register_style( 'cg-responsive', get_template_directory_uri() . '/css/responsive.css' );
	}

	if ( $cg_responsive_status == 'disabled' ) {
		wp_register_style( 'cg-non-responsive', get_template_directory_uri() . '/css/non-responsive.css' );
	}

	wp_enqueue_style( 'cg-style', get_stylesheet_uri() );
	wp_enqueue_style( 'cg-font-awesome', get_template_directory_uri() . '/css/font-awesome/font-awesome.min.css' );
	wp_enqueue_style( 'cg-ionicons', get_template_directory_uri() . '/css/ionicons.css' );
	wp_enqueue_style( 'cg-animate', get_template_directory_uri() . '/css/animate.css' );
	wp_enqueue_style( 'cg-bootstrap' );
	wp_enqueue_style( 'cg-commercegurus' );

	if ( $cg_responsive_status !== 'disabled' ) {
		wp_enqueue_style( 'cg-responsive' );
	}

	if ( $cg_responsive_status == 'disabled' ) {
		wp_enqueue_style( 'cg-non-responsive' );
	}

	if ( isset( $cg_live_preview ) ) {
		wp_enqueue_style( 'cg-livepreviewcss', get_template_directory_uri() . '/css/livepreview.css' );
	}

	// skins
	$cg_skin_color 			 = '';
	$cg_skin_color			 = $cg_options['cg_skin_color'];

	if ( ! empty( $_SESSION['cg_skin_color'] ) ) {
		$cg_skin_color = $_SESSION['cg_skin_color'];
	}

	if ( isset( $cg_skin_color ) ) {
		if ( $cg_skin_color !== 'none' ) {
			wp_enqueue_style( 'cg-cssskin', get_template_directory_uri() . '/css/skins/' . $cg_skin_color . '.css' );
		}
	}

	$vc_plugin_version = get_plugin_version( 'WPBakery Visual Composer' );

	if ( version_compare( $vc_plugin_version , '4.8.1', '>' ) ) {
		wp_enqueue_style( 'cg-vccss', get_template_directory_uri() . '/css/vc.css' );
	}

}

add_action( 'wp_enqueue_scripts', 'cg_load_styles' );

// Load css from theme options.
require_once( CG_CORE . '/css/custom-css.php' );

/**
 * Maybe load js
 */
function cg_maybe_load_scripts() {
	global $cg_live_preview, $cg_options;

	$cg_sticky_menu			 = '';
	$cg_display_search		 = '';

	if ( isset( $cg_options['cg_sticky_menu'] ) ) {
		$cg_sticky_menu = $cg_options['cg_sticky_menu'];
	}

	if ( $cg_sticky_menu == '1' ) {
		wp_enqueue_script( 'cg_scrollfix', CG_JS . '/src/cond/scrollfix.js', array( 'jquery' ), '', false );
	}

	if ( isset( $cg_options['cg_show_search'] ) ) {
		$cg_display_search = $cg_options['cg_show_search'];
	}

}
add_action( 'wp_enqueue_scripts', 'cg_maybe_load_scripts' );


/**
 * Force Visual Composer to initialize as "built into the theme". This will hide certain tabs under the Settings->Visual Composer page
 */
if ( function_exists( 'vc_set_as_theme' ) ) {
	vc_set_as_theme( $disable_updater = true );

	// Disable frontend editor by default - to re-enable just comment out the next line
	vc_disable_frontend();
}

// Initialising Shortcodes
if ( class_exists( 'WPBakeryVisualComposerAbstract' ) ) {

	function cg_requireVcExtend() {
		require_once locate_template( '/customvc/vc_extend.php' );
	}

	add_action( 'init', 'cg_requireVcExtend', 2 );

	// Set VC tpl override directory
	$vcdir = get_stylesheet_directory() . '/customvc/vc_templates/';
	vc_set_shortcodes_templates_dir( $vcdir );

	// Remove VC nag looking for key - CommerceGurus has an extended lic.
	if ( is_admin() ) {
		function cg_remove_vc_nag() {
			setcookie( 'vchideactivationmsg_vc11', ( defined( 'WPB_VC_VERSION' ) ? WPB_VC_VERSION : '1' ), strtotime( '+3 years' ), '/' );
		}
		add_action( 'init', 'cg_remove_vc_nag' );
	}
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
if ( ! function_exists( 'cg_setup' ) ) :

	function cg_setup() {

		/**
		 * Translations can be filed in the /languages/ directory
		 * If you're building a theme based on a commercegurus theme, use a find and replace
		 * to change 'broker' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'broker', get_template_directory() . '/languages' );

		/**
		 * Add default posts and comments RSS feed links to head
		 */
		add_theme_support( 'automatic-feed-links' );

		/**
		 * This theme uses wp_nav_menu() in one location.
		 */
		register_nav_menus( array(
			'primary'	 => esc_html__( 'Primary Menu', 'broker' ),
			'mobile'	 => esc_html__( 'Mobile Menu', 'broker' ),
		) );

		/**
		 * Custom Thumbnails
		 */
		if ( function_exists( 'add_theme_support' ) ) {
			add_theme_support( 'post-thumbnails' );
			add_image_size( 'hp-latest-posts', 380, 250, true );
		}

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/**
		 * Enable support for Post Formats
		 */
		add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'audio', 'quote', 'link' ) );

		/**
		 * Setup the WordPress core custom background feature.
		 */
		// add_theme_support( 'custom-background', apply_filters( 'cg_custom_background_args', array(
		// 'default-color' => 'ffffff',
		// 'default-image' => '',
		// ) ) );
	}

endif; // cg_setup
add_action( 'after_setup_theme', 'cg_setup' );

/**
 * Add Redux Framework
 */
require get_template_directory() . '/admin/admin-init.php';


/**
 * CMB2
 */
if ( file_exists( dirname( __FILE__ ) . '/admin/cmb2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/admin/cmb2/init.php';
} elseif ( file_exists( dirname( __FILE__ ) . '/admin/CMB2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/admin/CMB2/init.php';
}

// Load CMB options
require get_template_directory() . '/admin/cmb-options.php';


// Add Excerpts to Pages
add_action( 'init', 'cg_add_excerpts_to_pages' );
function cg_add_excerpts_to_pages() {
	 add_post_type_support( 'page', 'excerpt' );
}


// One Click Demo Data
function cg_import_files() {
	return array(
	array(
	  'import_file_name'           => 'Broker Demo Data',
	  'categories'                 => array( 'Main Demo Data' ),
	  'import_file_url'		 	   => 'http://files.commercegurus.com/broker-demodata/broker-demodata.xml',
	  'import_widget_file_url' 	   => 'http://files.commercegurus.com/broker-demodata/broker-widgets.wie',
	  'import_preview_image_url'   => 'http://broker.commercegurus.com/wp-content/uploads/2017/09/home-original-landing.jpg',
	  'import_notice'              => __( 'After you import this demo, you will have to setup the slider separately.', 'broker' ),
	  'preview_url'                => 'http://broker.commercegurus.com/',
	),
	array(
	  'import_file_name'           => 'Home 2 - "London"',
	  'categories'                 => array( 'Individual Homepages' ),
	  'import_file_url'            => 'http://files.commercegurus.com/broker-demodata/broker-home-two.xml',
	  'import_preview_image_url'   => 'http://broker.commercegurus.com/wp-content/uploads/2017/09/home-2-landing_a.jpg',
	  'import_notice'              => __( 'This import will only add a single homepage. Import the Broker Demo Data file for everything.', 'broker' ),
	  'preview_url'                => 'http://broker.commercegurus.com/home-two/',
	),
	array(
	  'import_file_name'           => 'Home 3 - "Berlin"',
	  'categories'                 => array( 'Individual Homepages' ),
	  'import_file_url'            => 'http://files.commercegurus.com/broker-demodata/broker-home-three.xml',
	  'import_preview_image_url'   => 'http://broker.commercegurus.com/wp-content/uploads/2017/09/home-3-landing_a.jpg',
	  'import_notice'              => __( 'This import will only add a single homepage. Import the Broker Demo Data file for everything.', 'broker' ),
	  'preview_url'                => 'http://broker.commercegurus.com/home-three/',
	),
	array(
	  'import_file_name'           => 'Home 4 - "Florence"',
	  'categories'                 => array( 'Individual Homepages' ),
	  'import_file_url'            => 'http://files.commercegurus.com/broker-demodata/broker-home-four.xml',
	  'import_preview_image_url'   => 'http://broker.commercegurus.com/wp-content/uploads/2017/09/home-4-landing.jpg',
	  'import_notice'              => __( 'This import will only add a single homepage. Import the Broker Demo Data file for everything.', 'broker' ),
	  'preview_url'                => 'http://broker.commercegurus.com/home-four/',
	),
	array(
	  'import_file_name'           => 'Home 5 - "Porto"',
	  'categories'                 => array( 'Individual Homepages' ),
	  'import_file_url'            => 'http://files.commercegurus.com/broker-demodata/broker-home-five.xml',
	  'import_preview_image_url'   => 'http://broker.commercegurus.com/wp-content/uploads/2017/09/home-5-landing.jpg',
	  'import_notice'              => __( 'This import will only add a single homepage. Import the Broker Demo Data file for everything.', 'broker' ),
	  'preview_url'                => 'http://broker.commercegurus.com/home-five/',
	),
	array(
	  'import_file_name'           => 'Home 6 - "Copenhagen"',
	  'categories'                 => array( 'Individual Homepages' ),
	  'import_file_url'            => 'http://files.commercegurus.com/broker-demodata/broker-home-six.xml',
	  'import_preview_image_url'   => 'http://broker.commercegurus.com/wp-content/uploads/2017/09/home-6-landing.jpg',
	  'import_notice'              => __( 'This import will only add a single homepage. Import the Broker Demo Data file for everything.', 'broker' ),
	  'preview_url'                => 'http://broker.commercegurus.com/home-six/',
	),
	);
}
add_filter( 'pt-ocdi/import_files', 'cg_import_files' );
add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

function cg_after_import_setup() {

	// Menus to Import and assign.
	$main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );

	set_theme_mod( 'nav_menu_locations', array(
			'primary' => $main_menu->term_id,
		)
	);

	// Assign front page and posts page (blog page).
	$front_page_id = get_page_by_title( 'Home' );
	$blog_page_id  = get_page_by_title( 'News' );

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $front_page_id->ID );
	update_option( 'page_for_posts', $blog_page_id->ID );
	esc_html_e( 'After import setup ended!', 'broker' );

}
add_action( 'pt-ocdi/after_import', 'cg_after_import_setup' );


/**
 * Set WooCommerce image dimensions upon activation
 */
global $pagenow;
if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' ) {
	add_action( 'init', 'cg_woocommerce_image_dimensions', 1 );
}

/**
 * Define image sizes
 */
function cg_woocommerce_image_dimensions() {
	$catalog = array(
		'width'	 => '300', // px
		'height' => '390', // px
		'crop'	 => 1,// true
	);

	$single = array(
		'width'	 => '500', // px
		'height' => '650', // px
		'crop'	 => 1,// true
	);

	$thumbnail = array(
		'width'	 => '120', // px
		'height' => '155', // px
		'crop'	 => 1,// false
	);

	// Image sizes
	update_option( 'shop_catalog_image_size', $catalog );	// Product category thumbs
	update_option( 'shop_single_image_size', $single );   // Single product image
	update_option( 'shop_thumbnail_image_size', $thumbnail );   // Image gallery thumbs
}

/**
 * Register widgetized area and update sidebar with default widgets
 */
function cg_widgets_init() {

	register_sidebar( array(
		'name'			 => esc_html__( 'Sidebar', 'broker' ),
		'id' 			 => 'sidebar-1',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h4 class="widget-title"><span>',
		'after_title'	 => '</span></h4>',
	) );

	register_sidebar( array(
		'name'			 => esc_html__( 'Pages Sidebar', 'broker' ),
		'id'			 => 'sidebar-pages',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h4 class="widget-title"><span>',
		'after_title'	 => '</span></h4>',
	) );

	register_sidebar( array(
		'name' => esc_html__( 'Shop Sidebar', 'commercegurus' ),
		'id' => 'shop-sidebar',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widget-title"><span>',
		'after_title' => '</span></h4>',
	) );

	register_sidebar( array(
		'name'			 => esc_html__( 'Top Toolbar - Left', 'broker' ),
		'id'			 => 'top-bar-left',
		'before_widget'	 => '<div id="%1$s" class="%2$s">',
		'after_widget'	 => '</div>',
		'before_title'	 => '<h4 class="widget-title"><span>',
		'after_title'	 => '</span></h4>',
	) );

	register_sidebar( array(
		'name'			 => esc_html__( 'Top Toolbar - Right', 'broker' ),
		'id'			 => 'top-bar-right',
		'before_widget'	 => '<div id="%1$s" class="%2$s">',
		'after_widget'	 => '</div>',
		'before_title'	 => '<h4 class="widget-title"><span>',
		'after_title'	 => '</span></h4>',
	) );

	register_sidebar( array(
		'name'			 => esc_html__( 'Mobile Search', 'broker' ),
		'id'			 => 'mobile-search',
		'before_widget'	 => '<div id="%1$s" class="%2$s">',
		'after_widget'	 => '</div>',
		'before_title'	 => '<h4 class="widget-title"><span>',
		'after_title'	 => '</span></h4>',
	) );

	register_sidebar( array(
		'name'			 => esc_html__( 'Header Details', 'broker' ),
		'id'			 => 'header-details',
		'before_widget'	 => '<div id="%1$s" class="cg-header-details %2$s">',
		'after_widget'	 => '</div>',
		'before_title'	 => '<h4 class="widget-title"><span>',
		'after_title'	 => '</span></h4>',
	) );

	register_sidebar( array(
		'name'			 => esc_html__( 'First Footer', 'broker' ),
		'id'			 => 'first-footer',
		'before_widget'	 => '<div id="%1$s" class="col-lg-3 col-md-3 col-sm-12 col-xs-12 col-nr-3 %2$s"><div class="inner-widget-wrap">',
		'after_widget'	 => '</div></div>',
		'before_title'	 => '<h4 class="widget-title"><span>',
		'after_title'	 => '</span></h4>',
	) );

	register_sidebar( array(
		'name'			 => esc_html__( 'Second Footer', 'broker' ),
		'id'			 => 'second-footer',
		'before_widget'	 => '<div id="%1$s" class="col-lg-6 col-md-6 col-sm-12 col-xs-12 %2$s">',
		'after_widget'	 => '</div>',
		'before_title'	 => '<h4 class="widget-title"><span>',
		'after_title'	 => '</span></h4>',
	) );
}

add_action( 'widgets_init', 'cg_widgets_init' );


// Remove certain custom post types from the CG Toolkit
if ( ! function_exists( 'cg_unregister_announcements' ) ) :
	function cg_unregister_announcements() {
		global $wp_post_types;
		if ( isset( $wp_post_types['shopannouncements'] ) ) {
			unset( $wp_post_types['shopannouncements'] );
			return true;
		}
		return false;
	}
endif;

if ( ! function_exists( 'cg_unregister_testimonials' ) ) :
	function cg_unregister_testimonials() {
		global $wp_post_types;
		if ( isset( $wp_post_types['testimonials'] ) ) {
			unset( $wp_post_types['testimonials'] );
			return true;
		}
		return false;
	}
endif;

if ( ! function_exists( 'cg_unregister_topreviews' ) ) :
	function cg_unregister_topreviews() {
		global $wp_post_types;
		if ( isset( $wp_post_types['topreviews'] ) ) {
			unset( $wp_post_types['topreviews'] );
			return true;
		}
		return false;
	}
endif;

if ( ! function_exists( 'cg_unregister_showcases' ) ) :
	function cg_unregister_showcases() {
		global $wp_post_types;
		if ( isset( $wp_post_types['showcases'] ) ) {
			unset( $wp_post_types['showcases'] );
			return true;
		}
		return false;
	}
endif;

add_action( 'init', 'cg_unregister_announcements', 100 );
add_action( 'init', 'cg_unregister_testimonials', 100 );
add_action( 'init', 'cg_unregister_topreviews', 100 );
add_action( 'init', 'cg_unregister_showcases', 100 );


/**
 * Layerslider, VC Update Styling
 */
function cg_layerslider_vc_admin_css() {
	echo '<style type="text/css">
	#js_composer-update .plugin-update {display:none !important;}
	#LayerSlider-update .plugin-update {display:none !important;}
	 </style>';
}
add_action( 'admin_head', 'cg_layerslider_vc_admin_css' );

/**
 * CommerceGurus Date Shortcode
 */
function cg_displaydate() {
	return date( get_option( 'date_format' ) );
}
add_shortcode( 'date', 'cg_displaydate' );

/**
 * Convert Yoast breadcrumbs to use Microdata
 *
 * @params string $breadcrumbs Breadcrumb HTML
 * @return string
 * @author Jaik Dean
 **/
function convertBreadcrumbsToMicrodata( $breadcrumbs ) {
	// remove the XML namespace
	$breadcrumbs = str_replace( ' xmlns:v="http://rdf.data-vocabulary.org/#"', '', $breadcrumbs );

	// convert each breadcrumb
	$breadcrumbs = preg_replace(
		'/<span typeof="v:Breadcrumb"><a href="([^"]+)" rel="v:url" property="v:title">([^<]+)<\\/a><\\/span>/',
		'<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="$1" itemprop="url"><span itemprop="title">$2</span></a></span>',
		$breadcrumbs
	);

	$breadcrumbs = preg_replace(
		'/<span typeof="v:Breadcrumb"><span class="breadcrumb_last" property="v:title">([^<]+)<\\/span><\\/span>/',
		'<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span class="breadcrumb_last" itemprop="title">$1</span></span>',
		$breadcrumbs
	);

	return $breadcrumbs;
}

add_filter( 'wpseo_breadcrumb_output', 'convertBreadcrumbsToMicrodata' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';


/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Adds a body class if a featured image is present
 */
function cg_featured_image_body_class( $classes ) {
	global $post;

	if ( isset( $post->ID ) && get_the_post_thumbnail( $post->ID ) ) {
		$classes[] = 'has-featured-image';
	}

	return $classes;
}

add_filter( 'body_class', 'cg_featured_image_body_class' );

/* WooCommerce */

/*
 ----------------------------------------------------------------------------------- */
/*
 Start WooThemes Functions - Please refrain from editing this section */
/* ----------------------------------------------------------------------------------- */

// Custom function to check if WooCommerce is active - support for WPMU
if ( ! function_exists( 'is_wc_active' ) ) {

	function is_wc_active() {
		if ( class_exists( 'woocommerce' ) ) {
			return true;
		} else {
			return false;
		}
	}
}

/**
 * Load WooCommerce Config.
 */
if ( is_wc_active() ) {
	require get_template_directory() . '/inc/woocommerce/hooks.php';
	require get_template_directory() . '/inc/woocommerce/functions.php';
}

// Custom function to check if WooCommerce is active and is the shop page
if ( ! function_exists( 'is_wc_shop' ) ) {

	function is_wc_shop() {
		if ( class_exists( 'woocommerce' ) ) {
			if ( is_shop() ) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}


// Register Support
add_theme_support( 'woocommerce' );
add_theme_support( 'wc-product-gallery-zoom' );
add_theme_support( 'wc-product-gallery-lightbox' );
add_theme_support( 'wc-product-gallery-slider' );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640;
} // End if().



// get plugin version
function get_plugin_version( $plugin_name ) {
	require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
	$plugins = get_plugins();
	foreach ( $plugins as $plugin_info ) {
		if ( $plugin_info['Name'] == $plugin_name ) { return $plugin_info['Version'];
		}
	}
	return null;
}

// End of core functions.







