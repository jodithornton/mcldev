<?php

/**
 * ReduxFramework Config
 * */
if ( !class_exists( 'Cg_Redux_Framework_config' ) ) {

	class Cg_Redux_Framework_config {

		public $args	 = array();
		public $sections = array();
		public $theme;
		public $ReduxFramework;

		public function __construct() {

			if ( !class_exists( 'ReduxFramework' ) ) {
				return;
			}

			// This is needed. Bah WordPress bugs.  ;)
			if ( true == Redux_Helpers::isTheme( __FILE__ ) ) {
				$this->initSettings();
			} else {
				add_action( 'plugins_loaded', array( $this, 'initSettings' ), 10 );
			}
		}

		public function initSettings() {

			// Just for demo purposes. Not needed per say.
			$this->theme = wp_get_theme();

			// Set the default arguments
			$this->setArguments();

			// Set a few help tabs so you can see how it's done
			$this->setHelpTabs();

			// Create the sections and fields
			$this->setSections();

			if ( !isset( $this->args['opt_name'] ) ) { // No errors please
				return;
			}

			// If Redux is running as a plugin, this will remove the demo notice and links
			add_action( 'redux/loaded', array( $this, 'remove_demo' ) );

			// Function to test the compiler hook and demo CSS output.
			// Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
			//add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 2);
			// Change the arguments after they've been declared, but before the panel is created
			//add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
			// Change the default value of a field after it's been set, but before it's been useds
			//add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
			// Dynamically add a section. Can be also used to modify sections/fields
			//add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

			$this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
		}

		/**
		 * This is a test function that will let you see when the compiler hook occurs.
		 * It only runs if a field   set with compiler=>true is changed.
		 * */
		function compiler_action( $options, $css ) {

			//echo '<h1>The compiler hook has run!';
			//print_r($options); //Option values
			//print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )

			/*
			  // Demo of how to use the dynamic CSS and write your own static CSS file
			  $filename = dirname(__FILE__) . '/style' . '.css';
			  global $wp_filesystem;
			  if( empty( $wp_filesystem ) ) {
			  require_once( ABSPATH .'/wp-admin/includes/file.php' );
			  WP_Filesystem();
			  }

			  if( $wp_filesystem ) {
			  $wp_filesystem->put_contents(
			  $filename,
			  $css,
			  FS_CHMOD_FILE // predefined mode settings for WP files
			  );
			  }
			 */
		}

		/**
		 * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
		 * Simply include this function in the child themes functions.php file.
		 * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
		 * so you must use get_template_directory_uri() if you want to use any of the built in icons
		 * */
		function dynamic_section( $sections ) {
			//$sections = array();
			$sections[] = array(
				'title'	 => esc_html__( 'Section via hook', 'redux-framework-demo' ),
				'desc'	 => esc_html__( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'redux-framework-demo' ),
				'icon'	 => 'el-icon-paper-clip',
				// Leave this as a blank section, no options just some intro text set above.
				'fields' => array()
			);

			return $sections;
		}

		/**
		 * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
		 * */
		function change_arguments( $args ) {
			//$args['dev_mode'] = true;

			return $args;
		}

		/**
		 * Filter hook for filtering the default value of any given field. Very useful in development mode.
		 * */
		function change_defaults( $defaults ) {
			$defaults['str_replace'] = 'Testing filter hook!';

			return $defaults;
		}

		// Remove the demo link and the notice of integrated demo from the redux-framework plugin
		function remove_demo() {

			// Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
			if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
				remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::instance(), 'plugin_metalinks' ), null, 2 );

				// Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
				remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
			}
		}

		public function setSections() {

			/**
			 * Theme Options sections
			 * */
			$this->sections[] = array(
				'title'	 => esc_html__( 'Global Settings', 'broker' ),
				'desc'	 => esc_html__( 'Changes to major global elements.', 'broker' ),
				'icon'	 => 'el-icon-home',
				'fields' => array(
					array(
						'desc'		 => esc_html__( 'Select a container layout style', 'broker' ),
						'id'		 => 'container_style',
						'type'		 => 'select',
						'options'	 => array(
							'full-width' => esc_html__( 'Full Width Layout', 'broker' ),
							'boxed'		 => esc_html__( 'Boxed Layout', 'broker' ),
						),
						'title'		 => esc_html__( 'Container layout style', 'broker' ),
						'default'	 => 'full-width',
					),
					array(
						'desc'		 => esc_html__( 'Enable or disable responsiveness on smartphones', 'broker' ),
						'id'		 => 'cg_responsive',
						'type'		 => 'select',
						'options'	 => array(
							'enabled'	 => esc_html__( 'Enabled', 'broker' ),
							'disabled'	 => esc_html__( 'Disabled', 'broker' ),
						),
						'title'		 => esc_html__( 'Responsive', 'broker' ),
						'default'	 => 'enabled',
					),

					array(
                        'desc' => __( 'Enable or disable the Page preloader', 'broker' ),
                        'id' => 'cg_preloader',
                        'type' => 'select',
                        'options' => array(
                            'enabled' => __( 'Enabled', 'broker' ),
                            'disabled' => __( 'Disabled', 'broker' ),
                        ),
                        'title' => __( 'Page Preloader', 'broker' ),
                        'default' => 'enabled',
                    ),

					array(
						'id'					 => 'cg_background',
						'type'					 => 'background',
						'title'					 => esc_html__( 'Body Background - Color and image', 'broker' ),
						'subtitle'				 => esc_html__( 'Configure your theme background.', 'broker' ),
						'background-position'	 => false,
						'background-size'		 => false,
						'background-attachment'	 => false,
						'default'				 => array(
							'background-color' => '#f8f8f8',
						),
					),
					array(
						'id'					 => 'cg_pattern_background',
						'type'					 => 'background',
						'title'					 => esc_html__( 'Body Background - Pattern', 'broker' ),
						'subtitle'				 => esc_html__( 'Use this option if you want to use a repeating pattern for your background. Note: Do not try to use both a pattern background and a full size image background! ', 'broker' ),
						'background-position'	 => false,
						'background-size'		 => false,
						'background-attachment'	 => false,
						'default'				 => array(
							'background-color' => '#efefef',
						),
					),
					array(
						'id'		 => 'cg_page_wrapper_color',
						'type'		 => 'color',
						'title'		 => esc_html__( 'Main body wrapper color', 'broker' ),
						'subtitle'	 => esc_html__( 'Configure your theme wrapper.', 'broker' ),
						'default'	 => '#ffffff',
					),
				),
			);

			$this->sections[] = array(
				'title'	 => esc_html__( 'Colors', 'broker' ),
				'desc'	 => esc_html__( 'Customize your theme color palette.', 'broker' ),
				'icon'	 => 'el-icon-tint',
				'fields' => array(
					array(
						'desc'		 => esc_html__( 'Select from one of the predefined color skins, or have your own colors by selecting "No Skin" and choosing colors below.', 'broker' ),
						'id'		 => 'cg_skin_color',
						'type'		 => 'select',
						'options'	 => array(
							'none'		 => esc_html__( 'No skin - use custom', 'broker' ),
							'red'	 => esc_html__( 'Red', 'broker' ),
							'green'	 => esc_html__( 'Green', 'broker' ),
							'purple' => esc_html__( 'Purple', 'broker' ),
						),
						'title'		 => esc_html__( 'Color Skin', 'broker' ),
						'default'	 => 'none',
					),
					array(
						'id'		 => 'cg_primary_color',
						'type'		 => 'color',
						'title'		 => esc_html__( 'Primary theme color', 'broker' ),
						'subtitle'	 => esc_html__( 'This should be something unique about your site.', 'broker' ),
						'default'	 => '#24a3d8',
					),
					array(
						'id'		 => 'link-colors-start',
						'type'		 => 'section',
						'title'		 => esc_html__( 'Link Colors', 'broker' ),
						'subtitle'	 => esc_html__( 'Define your link colors.', 'broker' ),
						'indent'	 => true
					),
					array(
						'id'		 => 'cg_active_link_color',
						'type'		 => 'color',
						'title'		 => esc_html__( 'Active link color', 'broker' ),
						'subtitle'	 => esc_html__( 'The color of active links.', 'broker' ),
						'default'	 => '#24a3d8',
					),
					array(
						'id'		 => 'cg_link_hover_color',
						'type'		 => 'color',
						'title'		 => esc_html__( 'Link hover color', 'broker' ),
						'subtitle'	 => esc_html__( 'The color of your links in the hover state.', 'broker' ),
						'default'	 => '#000000',
					),
					array(
						'id'	 => 'link-colors-end',
						'type'	 => 'section',
						'indent' => false,
					),
					array(
						'id'		 => 'header-colors-start',
						'type'		 => 'section',
						'title'		 => esc_html__( 'Header Colors', 'broker' ),
						'subtitle'	 => esc_html__( 'Define your header colors. Note: not all color options apply to all header styles.', 'broker' ),
						'indent'	 => true
					),
					array(
						'id'		 => 'cg_header_bg_color',
						'type'		 => 'color',
						'title'		 => esc_html__( 'Header Background Color', 'broker' ),
						'indent'	 => true,
						'subtitle'	 => esc_html__( 'The Color of the Header Background.', 'broker' ),
						'default'	 => '#ffffff',
						'output'	 => array( 'background-color' => '.cg-logo-center, .cg-logo-left' )
					),
					array(
						'id'		 => 'cg_header_text_color',
						'type'		 => 'color',
						'title'		 => esc_html__( 'Header Text Color', 'broker' ),
						'subtitle'	 => esc_html__( 'The color of the Header Text.', 'broker' ),
						'default'	 => '#444444',
					),
					array(
						'id'		 => 'cg_navigation_bg_color',
						'type'		 => 'color',
						'title'		 => esc_html__( 'Navigation Background Color', 'broker' ),
						'indent'	 => true,
						'subtitle'	 => esc_html__( 'The Color of the Navigation Background.', 'broker' ),
						'default'	 => '#323946',
						'output'	 => array( 'background-color' => '.cg-primary-menu-center, .cg-primary-menu-left' )
					),
					array(
						'id'		 => 'cg_navigation_text_color',
						'type'		 => 'color',
						'title'		 => esc_html__( 'Navigation Text Color', 'broker' ),
						'subtitle'	 => esc_html__( 'The color of the Navigation', 'broker' ),
						'default'	 => '#ffffff',
					),
					array(
						'id'		 => 'cg_navigation_divider_color',
						'type'		 => 'color',
						'title'		 => esc_html__( 'Navigation Dividers Color', 'broker' ),
						'subtitle'	 => esc_html__( 'The color of the Navigation Dividers', 'broker' ),
						'default'	 => '#ffffff',
						'output'	 => array( 'background-color' => '.cg-primary-menu .menu > li a:before' )
					),
					array(
						'id'		 => 'cg_navigation_border_color',
						'type'		 => 'color',
						'title'		 => esc_html__( 'Navigation Top Border Color', 'broker' ),
						'subtitle'	 => esc_html__( 'The color of the Navigation Top Border', 'broker' ),
						'default'	 => '#ffffff',
						'output'	 => array( 'border-top-color' => '.cg-primary-menu-below-wrapper' )
					),
					array(
						'id'		 => 'cg_header_fixed_bg_color',
						'type'		 => 'color',
						'title'		 => esc_html__( 'Sticky Header Background Color', 'broker' ),
						'subtitle'	 => esc_html__( 'The color of the Sticky Header Background.', 'broker' ),
						'default'	 => '#ffffff',
						'output'	 => array( 'background-color' => '.scroller, body.transparent-light .scroller, body.transparent-dark .scroller' )
					),
					array(
						'id'		 => 'cg_header_fixed_text_color',
						'type'		 => 'color',
						'title'		 => esc_html__( 'Sticky Header Text Color', 'broker' ),
						'subtitle'	 => esc_html__( 'The color of the Sticky Header Text.', 'broker' ),
						'default'	 => '#222222',
					),
					array(
						'id'		 => 'cg_mobile_header_bg_color',
						'type'		 => 'color',
						'title'		 => esc_html__( 'Mobile Header Background Color', 'broker' ),
						'subtitle'	 => esc_html__( 'The color of the Mobile Header Background.', 'broker' ),
						'default'	 => '#ffffff',
					),
					array(
						'id'		 => 'cg_mobile_header_elements_color',
						'type'		 => 'color',
						'title'		 => esc_html__( 'Mobile Header Elements Color', 'broker' ),
						'indent'	 => true,
						'subtitle'	 => esc_html__( 'The color of the Mobile search and hamburger menu.', 'economist' ),
						'default'	 => '#000',
						'output'	 => array( 'background-color' => '.mean-container a.meanmenu-reveal span', 'color' => '.mobile-search i' )
					),
					array(
						'id'	 => 'header-colors-end',
						'type'	 => 'section',
						'indent' => false,
					),
					
					array(
						'id'		 => 'footer-colors-start',
						'type'		 => 'section',
						'title'		 => esc_html__( 'Footer Colors', 'broker' ),
						'subtitle'	 => esc_html__( 'Define your footer colors.', 'broker' ),
						'indent'	 => true
					),
					array(
						'id'		 => 'cg_first_footer_bg',
						'type'		 => 'color',
						'title'		 => esc_html__( 'First footer background color', 'broker' ),
						'subtitle'	 => esc_html__( 'The background color of the first (top) footer.', 'broker' ),
						'default'	 => '#45474e',
					),
					array(
						'id'		 => 'cg_first_footer_text',
						'type'		 => 'color',
						'title'		 => esc_html__( 'First footer text color', 'broker' ),
						'subtitle'	 => esc_html__( 'The text color of the first (top) footer.', 'broker' ),
						'default'	 => '#ffffff',
					),
					array(
						'id'		 => 'cg_first_footer_link',
						'type'		 => 'color',
						'title'		 => esc_html__( 'First footer link color', 'broker' ),
						'subtitle'	 => esc_html__( 'The link color of the first (top) footer.', 'broker' ),
						'default'	 => '#d0d0d2',
					),
					array(
						'id'		 => 'cg_second_footer_bg',
						'type'		 => 'color',
						'title'		 => esc_html__( 'Second footer background color', 'broker' ),
						'subtitle'	 => esc_html__( 'The background color of the second (bottom) footer.', 'broker' ),
						'default'	 => '#45474e',
					),
					array(
						'id'		 => 'cg_second_footer_text',
						'type'		 => 'color',
						'title'		 => esc_html__( 'Second footer text color', 'broker' ),
						'subtitle'	 => esc_html__( 'The text color of the second (bottom) footer.', 'broker' ),
						'default'	 => '#fff',
					),
					array(
						'id'		 => 'cg_last_footer_bg',
						'type'		 => 'color',
						'title'		 => esc_html__( 'Last footer background color', 'broker' ),
						'subtitle'	 => esc_html__( 'The background color of the last footer (where the copyright notice normally appears).', 'broker' ),
						'default'	 => '#45474e',
					),
					array(
						'id'		 => 'cg_last_footer_text',
						'type'		 => 'color',
						'title'		 => esc_html__( 'Last footer text color', 'broker' ),
						'subtitle'	 => esc_html__( 'The text color of the last footer (where the copyright notice normally appears).', 'broker' ),
						'default'	 => '#abacaf',
					),
					array(
						'id'	 => 'footer-colors-end',
						'type'	 => 'section',
						'indent' => false,
					),
				),
			);

			$this->sections[] = array(
				'title'	 => esc_html__( 'Logos and Favicons', 'broker' ),
				'desc'	 => esc_html__( 'Update your Logos and Favicons.', 'broker' ),
				'icon'	 => 'el-icon-photo',
				'fields' => array(
					array(
						'id'		 => 'standard-logo-start',
						'type'		 => 'section',
						'title'		 => esc_html__( 'Logos', 'broker' ),
						'subtitle'	 => esc_html__( 'Set your Logo', 'broker' ),
						'indent'	 => true
					),
					array(
						'desc'	 => esc_html__( 'Upload your Logo.', 'broker' ),
						'id'	 => 'site_logo',
						'type'	 => 'media',
						'title'	 => esc_html__( 'Logo', 'broker' ),
						'url'	 => true,
					),
					array(
						'title'			 => esc_html__( 'Logo Height', 'broker' ),
						'subtitle'		 => esc_html__( 'Set your Logo Height in pixels', 'broker' ),
						'id'			 => 'cg_logo_height',
						'type'			 => 'slider',
						"default"		 => 48,
						"min"			 => 0,
						"step"			 => 1,
						"max"			 => 200,
						'display_value'	 => 'text',
					),
					array(
						'title'			 => esc_html__( 'Padding around Logo', 'broker' ),
						'subtitle'		 => esc_html__( 'Set some padding around your logo', 'broker' ),
						'id'			 => 'cg_padding_below_logo',
						'type'			 => 'slider',
						"default"		 => 70,
						"min"			 => 0,
						"step"			 => 1,
						"max"			 => 200,
						'display_value'	 => 'text',
					),
					array(
						'id'	 => 'standard-logo-end',
						'type'	 => 'section',
						'indent' => false,
					),
					array(
						'id'		 => 'sticky-logo-start',
						'type'		 => 'section',
						'title'		 => esc_html__( 'Sticky Logo', 'broker' ),
						'subtitle'	 => esc_html__( 'Set your Sticky Logo', 'broker' ),
						'indent'	 => true
					),
					array(
						'desc'	 => esc_html__( 'Upload a Logo which appears within a Sticky Header.', 'broker' ),
						'id'	 => 'cg_alt_site_logo',
						'type'	 => 'media',
						'title'	 => esc_html__( 'Sticky Logo (optional)', 'broker' ),
						'url'	 => true,
					),
					array(
						'id'	 => 'sticky-logo-end',
						'type'	 => 'section',
						'indent' => false,
					),
					array(
						'id'		 => 'dynamic-width-logo-start',
						'type'		 => 'section',
						'title'		 => esc_html__( 'Logo Container Width', 'broker' ),
						'subtitle'	 => esc_html__( 'Set the Container width of the Logo - the default is 20%. Unless you have a very wide logo you should not need to adjust this.', 'broker' ),
						'indent'	 => true
					),
					array(
						'title'			 => esc_html__( 'Logo Container Width', 'broker' ),
						'subtitle'	 	 => esc_html__( 'Set in %', 'broker' ),
						'desc'		 	 => esc_html__( 'You may need to remove or adjust your Header Details Widgets if you increase this.', 'broker' ),
						'id'			 => 'cg_dynamic_logo_width',
						'type'			 => 'slider',
						"default"		 => 20,
						"min"			 => 10,
						"step"			 => 1,
						"max"			 => 50,
						'display_value'	 => 'text',
					),
					array(
						'id'	 => 'dynamic-width-logo-end',
						'type'	 => 'section',
						'indent' => false,
					),
					array(
						'id'		 => 'mobile-header-start',
						'type'		 => 'section',
						'title'		 => esc_html__( 'Mobile Header Height', 'broker' ),
						'subtitle'	 => esc_html__( 'Set the mobile header height', 'broker' ),
						'indent'	 => true
					),
					array(
						'title'			 => esc_html__( 'Mobile Header Height', 'broker' ),
						'subtitle'	 	 => esc_html__( 'Set in px', 'broker' ),
						'desc'		 	 => esc_html__( 'Increase the Mobile Header Height if you wish (Default is 60px)', 'broker' ),
						'id'			 => 'cg_mobile_header_height',
						'type'			 => 'slider',
						"default"		 => 60,
						"min"			 => 60,
						"step"			 => 1,
						"max"			 => 150,
						'display_value'	 => 'text',
					),
					array(
						'title'			 => esc_html__( 'Mobile Logo Height', 'broker' ),
						'subtitle'	 	 => esc_html__( 'Set in px', 'broker' ),
						'desc'		 	 => esc_html__( 'This should be set to be roughly half the Mobile Header Height. A little whitespace is good. (Default is 35px)', 'broker' ),
						'id'			 => 'cg_mobile_logo_height',
						'type'			 => 'slider',
						"default"		 => 35,
						"min"			 => 25,
						"step"			 => 1,
						"max"			 => 150,
						'display_value'	 => 'text',
					),
					array(
						'id'	 => 'mobile-header-end',
						'type'	 => 'section',
						'indent' => false,
					),
					array(
						'id'		 => 'favicon-start',
						'type'		 => 'section',
						'title'		 => esc_html__( 'Favicon', 'broker' ),
						'subtitle'	 => esc_html__( 'Set your favicons', 'broker' ),
						'indent'	 => true
					),
					array(
						'desc'	 => esc_html__( 'Add your custom Favicon image. 16x16px .ico or .png.', 'broker' ),
						'id'	 => 'cg_favicon',
						'type'	 => 'media',
						'title'	 => esc_html__( 'Favicon', 'broker' ),
						'url'	 => true,
					),
					array(
						'desc'	 => esc_html__( 'The Retina/iOS version of your Favicon. 144x144px .png.', 'broker' ),
						'id'	 => 'cg_retina_favicon',
						'type'	 => 'media',
						'title'	 => esc_html__( 'Favicon retina', 'broker' ),
						'url'	 => true,
					),
					array(
						'id'	 => 'favicon-end',
						'type'	 => 'section',
						'indent' => false,
					),
				),
			);

			$this->sections[] = array(
				'title'	 => esc_html__( 'Header Settings', 'broker' ),
				'desc'	 => esc_html__( 'Manage your header.', 'broker' ),
				'icon'	 => 'el-icon-hand-up',
				'fields' => array(
					array(
						'id'		 => 'cg_logo_position',
						'type'		 => 'image_select',
						'compiler'	 => true,
						'title'		 => esc_html__( 'Header Layout', 'broker' ),
						'subtitle'	 => esc_html__( 'Select the Header Layout.', 'broker' ),
						'options'	 => array(

							'left'						 => array(
								'alt'	 => 'Layout 4',
								'img'	 => get_template_directory_uri() . '/images/theme_options/header_4.png'
							),
						),
						'default'	 => 'left'
					),

					array(
						'id'		 => 'cg_topbar',
						'type'		 => 'switch',
						'title'		 => esc_html__( 'Top Bar', 'broker' ),
						'subtitle'	 => esc_html__( 'Enable the Top Bar?', 'broker' ),
						'on'		 => esc_html__( 'Enable', 'broker' ),
						'off'		 => esc_html__( 'Disable', 'broker' ),
						'default'	 => 1,
					),
					array(
						'id'		 => 'cg_mobile_visible_header_details',
						'type'		 => 'switch',
						'title'		 => esc_html__( 'Header Details Mobile Visibility', 'broker' ),
						'subtitle'	 => esc_html__( 'Display Header Details on mobile?', 'broker' ),
						'on'		 => esc_html__( 'Enable', 'broker' ),
						'off'		 => esc_html__( 'Disable', 'broker' ),
						'default'	 => 1,
					),
					array(
						'title'		 => esc_html__( 'Sticky Menu', 'broker' ),
						'desc'		 => esc_html__( 'A sticky menu is a menu which fixes itself to the top as you scroll.', 'broker' ),
						'id'		 => 'cg_sticky_menu',
						'type'		 => 'switch',
						'subtitle'	 => esc_html__( 'Enable Sticky Menu?', 'broker' ),
						'on'		 => esc_html__( 'Enable', 'broker' ),
						'off'		 => esc_html__( 'Disable', 'broker' ),
						'default'	 => 1,
					),
					
					array(
						'id'		 => 'cg_show_search',
						'type'		 => 'switch',
						'title'		 => esc_html__( 'Search', 'broker' ),
						'subtitle'	 => esc_html__( 'Show Search?', 'broker' ),
						'on'		 => esc_html__( 'Enable', 'broker' ),
						'off'		 => esc_html__( 'Disable', 'broker' ),
						'default'	 => 1,
					),
					array(
						'id'		 => 'cg_announcements_bg',
						'type'		 => 'color',
						'title'		 => esc_html__( 'Top Bar Background Color', 'broker' ),
						'subtitle'	 => esc_html__( 'The color of the Top Bar background.', 'broker' ),
						'default'	 => '#f6f6f6',
					),
					array(
						'id'		 => 'cg_announcements_text',
						'type'		 => 'color',
						'title'		 => esc_html__( 'Top Bar Text Color', 'broker' ),
						'subtitle'	 => esc_html__( 'The color of the Top Bar text.', 'broker' ),
						'default'	 => '#303030',
					),
					array(
						'id'		 => 'cg_announcements_border',
						'type'		 => 'color_rgba',
						'title'		 => esc_html__( 'Top Bar Border Color.', 'broker' ),
						'subtitle'	 => esc_html__( 'The color of the Top Bar border.', 'broker' ),
						'default'	 => array(
							'color'	 => '#eee',
							'alpha'	 => '1.0',
						),
						'output'	 => array(
							'.cg-announcements'
						),
						'mode'		 => 'border-color',
					),
				),
			);

			$this->sections[] = array(
				'title'	 => esc_html__( 'Main Menu Settings', 'broker' ),
				'desc'	 => esc_html__( 'Manage your main menu.', 'broker' ),
				'icon'	 => 'el-icon-cog-alt',
				'fields' => array(
					array(
						'id'			 => 'cg_level1_font',
						'type'			 => 'typography',
						'title'			 => esc_html__( 'Level 1 Typeface', 'broker' ),
						'text-transform' => true,
						'google'		 => true, // Disable google fonts. Won't work if you haven't defined your google api key
						'font-backup'	 => true, // Select a backup non-google font in addition to a google font
						'line-height'	 => false,
						'letter-spacing' => true, // Defaults to false
						'all_styles'	 => true, // Enable all Google Font style/weight variations to be added to the page
						'output'		 => array( '.cg-primary-menu .menu > li > a', 'ul.tiny-cart > li > a', '.rightnav .cart_subtotal' ), // An array of CSS selectors to apply this font style to dynamically
						'units'			 => 'px', // Defaults to px
						'subtitle'		 => esc_html__( 'Each property can be called individually.', 'broker' ),
						'default'		 => array(
							'font-weight'	 => '400',
							'font-family'	 => 'Source Sans Pro',
							'google'		 => true,
							'font-size'		 => '17px',
						),
					),
					array(
						'id'			 => 'cg_level2_heading_font',
						'type'			 => 'typography',
						'title'			 => esc_html__( 'Level 2 Heading Typeface', 'broker' ),
						'text-transform' => true,
						'google'		 => true, // Disable google fonts. Won't work if you haven't defined your google api key
						'font-backup'	 => true, // Select a backup non-google font in addition to a google font
						'line-height'	 => false,
						'letter-spacing' => true, // Defaults to false
						'all_styles'	 => true, // Enable all Google Font style/weight variations to be added to the page
						'output'		 => array( '.cg-header-fixed .menu > li.menu-full-width .cg-submenu-ddown .container > ul > li > a, .cg-primary-menu .menu > li.menu-full-width .cg-submenu-ddown .container > ul > li > a, .menu-full-width .cg-menu-title, .cg-header-fixed .menu > li.menu-full-width .cg-submenu-ddown .container > ul .menu-item-has-children > a, .cg-primary-menu .menu > li .cg-submenu-ddown ul li.image-item-title a, .cg-primary-menu .menu > li .cg-submenu-ddown ul li.image-item-title ul a,
.cg-primary-menu .menu > li.menu-full-width .cg-submenu-ddown .container > ul .menu-item-has-children > a, .cg-header-fixed .menu > li.menu-full-width .cg-submenu-ddown .container > ul > li .cg-submenu ul li.title a, .cg-primary-menu .menu > li.menu-full-width .cg-submenu-ddown .container > ul > li .cg-submenu ul li.title a, .cg-primary-menu .menu > li.menu-full-width .cg-submenu-ddown .container > ul > li > a:hover' ), // An array of CSS selectors to apply this font style to dynamically
						'units'			 => 'px', // Defaults to px
						'subtitle'		 => esc_html__( 'Typography option with each property can be called individually.', 'broker' ),
						'default'		 => array(
							'color'			 => '#ffffff',
							'font-weight'	 => '300',
							'font-family'	 => 'Source Sans Pro',
							'google'		 => true,
							'font-size'		 => '17px',
						),
					),
					array(
						'id'			 => 'cg_level2_font',
						'type'			 => 'typography',
						'title'			 => esc_html__( 'Level 2 Typeface', 'broker' ),
						'text-transform' => true,
						//'compiler'      => true,  // Use if you want to hook in your own CSS compiler
						'google'		 => true, // Disable google fonts. Won't work if you haven't defined your google api key
						'font-backup'	 => true, // Select a backup non-google font in addition to a google font
						//'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
						//'subsets'       => false, // Only appears if google is true and subsets not set to false
						//'font-size'     => false,
						'line-height'	 => false,
						//'word-spacing'  => true,  // Defaults to false
						'letter-spacing' => true, // Defaults to false
						//'color'         => false,
						//'preview'       => false, // Disable the previewer
						'all_styles'	 => true, // Enable all Google Font style/weight variations to be added to the page
						'output'		 => array( '.cg-primary-menu .menu > li .cg-submenu-ddown .container > ul > li a, .cg-submenu-ddown .container > ul > li > a, .cg-header-fixed .menu > li.menu-full-width .cg-submenu-ddown .container > ul > li .cg-submenu ul li ul li a, .cg-primary-menu .menu > li.menu-full-width .cg-submenu-ddown .container > ul > li .cg-submenu ul li ul li a, body .cg-primary-menu .menu > li .cg-submenu-ddown .container > ul > li a:hover' ), // An array of CSS selectors to apply this font style to dynamically
						'units'			 => 'px', // Defaults to px
						'subtitle'		 => esc_html__( 'Typography option with each property can be called individually.', 'broker' ),
						'default'		 => array(
							'color'			 => '#ffffff',
							'font-weight'	 => '300',
							'font-family'	 => 'Source Sans Pro',
							'google'		 => true,
							'font-size'		 => '15px',
							'text-transform' => 'none',
						),
					),
					array(
						'id'		 => 'cg_main_menu_dropdown_bg',
						'type'		 => 'color_rgba',
						'title'		 => esc_html__( 'Dropdown menu background color.', 'broker' ),
						'default'	 => array(
							'color'	 => '#24a3d8',
							'alpha'	 => '1.0',
						),
						'output'	 => array(
							'.cg-header-fixed .menu > li .cg-submenu-ddown, ul.tiny-cart li ul.cart_list, .cg-primary-menu .menu > li .cg-submenu-ddown, .cg-header-fixed .menu > li.menu-full-width .cg-submenu-ddown, .cg-primary-menu .menu > li.menu-full-width .cg-submenu-ddown, .cg-header-fixed .menu > li .cg-submenu-ddown .container > ul .menu-item-has-children .cg-submenu li, .cg-primary-menu .menu > li .cg-submenu-ddown .container > ul .menu-item-has-children .cg-submenu li,.cg-header-fixed .menu > li.menu-full-width .cg-submenu-ddown,.cg-primary-menu .menu > li.menu-full-width .cg-submenu-ddown, .cg-header-fixed .menu > li .cg-submenu-ddown .container > ul .menu-item-has-children .cg-submenu,
.cg-primary-menu .menu > li .cg-submenu-ddown .container > ul .menu-item-has-children .cg-submenu, .cg-header-fixed .menu > li .cg-submenu-ddown .container > ul .menu-item-has-children .cg-submenu,
.cg-primary-menu .menu > li .cg-submenu-ddown .container > ul .menu-item-has-children .cg-submenu, .cg-primary-menu .menu > li .cg-submenu-ddown .container > ul > li a'
						),
						'mode'		 => 'background',
					),
					array(
						'id'		 => 'cg_main_menu_dropdown_bg_hover',
						'type'		 => 'color',
						'title'		 => esc_html__( 'Border color and Dropdown menu background hover color', 'broker' ),
						'default'	 => '#1592c6',
					),
				),
			);


			// Page Settings
			$this->sections[] = array(
				'title'	 => esc_html__( 'Page Options', 'broker' ),
				'desc'	 => esc_html__( 'Extra Page options', 'broker' ),
				'icon'	 => 'el-icon-list-alt',
				'fields' => array(

					array(
						'id'		 => 'pageheading-header-start',
						'type'		 => 'section',
						'title'		 => esc_html__( 'Page Heading Options', 'broker' ),
						'subtitle'	 => esc_html__( 'Change the page heading style if you wish', 'broker' ),
						'indent'	 => true
					),

					array(
						'id'		 => 'cg_pageheading_bg_color',
						'type'		 => 'color',
						'title'		 => esc_html__( 'Page Heading Background Color', 'broker' ),
						'desc'	 => esc_html__( 'If you want to change the color of the text on this background you can do so in Typography > Heading 1 Style', 'broker' ),
						'default'	 => '#f5f5f5',
						'output'	 => array( 'background-color' => '.header-wrapper .overlay' )
					),

					array(
						'title'			 => esc_html__( 'Page Heading Opacity', 'broker' ),
						'subtitle'	 	 => esc_html__( 'Set in %', 'broker' ),
						'desc'		 	 => esc_html__( 'Default is 95%', 'broker' ),
						'id'			 => 'cg_pageheading_opacity',
						'type'			 => 'slider',
						"default"		 => 95,
						"min"			 => 0,
						"step"			 => 1,
						"max"			 => 99,
						'display_value'	 => 'text',
					),

					array(
						'id'	 => 'pageheading-header-end',
						'type'	 => 'section',
						'indent' => false,
					),

					array(
						'id'		 => 'cta-header-start',
						'type'		 => 'section',
						'title'		 => esc_html__( 'Call to Action Button Options', 'broker' ),
						'subtitle'	 => esc_html__( 'Set up the call to action button', 'broker' ),
						'indent'	 => true
					),

					array(
						'desc'		 => esc_html__( 'Show Call to Action button within Sticky Header?', 'broker' ),
						'id'		 => 'cg_cta_sticky',
						'type'		 => 'select',
						'title'		 => esc_html__( 'Show button in sticky header', 'broker' ),
						'options'	 => array(
							'yes'	 => esc_html__( 'Yes', 'broker' ),
							'no'	 => esc_html__( 'No', 'broker' ),
						),
						'default'	 => 'no',
					),

					array(
						'desc'		 => esc_html__( 'Show Call to Action button within Page Heading?', 'broker' ),
						'id'		 => 'cg_cta_heading',
						'type'		 => 'select',
						'title'		 => esc_html__( 'Show button in page heading', 'broker' ),
						'options'	 => array(
							'yes'	 => esc_html__( 'Yes', 'broker' ),
							'no'	 => esc_html__( 'No', 'broker' ),
						),
						'default'	 => 'no',
					),

					array(
						'desc'		 => esc_html__( 'Your Button text', 'broker' ),
						'id'		 => 'cg_cta_message',
						'type'		 => 'text',
						'title'		 => esc_html__( 'Call to Action Button Text', 'broker' ),
						'default'	 => esc_html__( 'Get in Touch', 'broker' ),
					),

					array(
						'desc'		 => esc_html__( 'Your Button link - make sure to include http://', 'broker' ),
						'id'		 => 'cg_cta_link',
						'type'		 => 'text',
						'title'		 => esc_html__( 'Call to Action Button Link', 'broker' ),
						'default'	 => esc_html__( '#', 'broker' ),
					),

					array(
						'id'		 => 'cg_cta_message_bg',
						'type'		 => 'color',
						'title'		 => esc_html__( 'Call to Action Background Color', 'broker' ),
						'subtitle'	 => esc_html__( 'The Background Color of the Call to Action Button', 'broker' ),
						'default'	 => '#6FC400',
					),

					array(
						'id'		 => 'cg_cta_message_bg_hover',
						'type'		 => 'color',
						'title'		 => esc_html__( 'Call to Action Background Hover Color', 'broker' ),
						'subtitle'	 => esc_html__( 'The Hover Background Color of the Call to Action Button', 'broker' ),
						'default'	 => '#64b001',
					),

					array(
						'id'		 => 'cg_cta_message_color',
						'type'		 => 'color',
						'title'		 => esc_html__( 'Call to Action Text Color', 'broker' ),
						'subtitle'	 => esc_html__( 'The text color of the call to action button', 'broker' ),
						'default'	 => '#ffffff',
					),

					array(
						'id'	 => 'cta-header-end',
						'type'	 => 'section',
						'indent' => false,
					),

					array(
						'id'		 => 'share-header-start',
						'type'		 => 'section',
						'title'		 => esc_html__( 'Sharing Options', 'broker' ),
						'indent'	 => true
					),
					
					array(
						'desc'		 => esc_html__( 'Display share buttons below page heading?', 'broker' ),
						'id'		 => 'cg_share_options',
						'type'		 => 'select',
						'title'		 => esc_html__( 'Show Share Buttons', 'broker' ),
						'options'	 => array(
							'yes'	 => esc_html__( 'Yes', 'broker' ),
							'no'	 => esc_html__( 'No', 'broker' ),
						),
						'default'	 => 'yes',
					),

					array(
						'id'	 => 'share-header-end',
						'type'	 => 'section',
						'indent' => false,
					),

					array(
						'id'		 => 'projects-header-start',
						'type'		 => 'section',
						'title'		 => esc_html__( 'Projects Layout', 'broker' ),
						'indent'	 => true
					),

					array(
						'desc'		 => esc_html__( 'Choose the number of columns', 'broker' ),
						'id'		 => 'cg_portfolio_columns',
						'type'		 => 'select',
						'title'		 => esc_html__( 'Projects Columns', 'broker' ),
						'options'	 => array(
							'two'	 => esc_html__( '2', 'broker' ),
							'three'	 => esc_html__( '3', 'broker' ),
							'four'	 => esc_html__( '4', 'broker' ),
						),
						'default'	 => 'three',
					),

					array(
						'id'	 => 'projects-header-end',
						'type'	 => 'section',
						'indent' => false,
					),

				),
			);


			// End Main/Primary menu image uploads
			$this->sections[] = array(
				'title'	 => esc_html__( 'Footer Settings', 'broker' ),
				'desc'	 => esc_html__( 'Manage your footer.', 'broker' ),
				'icon'	 => 'el-icon-hand-down',
				'fields' => array(
					array(
						'id'		 => 'cg_footer_message',
						'type'		 => 'text',
						'title'		 => esc_html__( 'Left Side Footer text', 'broker' ),
						'default'	 => esc_html__( '&copy; 2017 Your Site Name', 'broker' ),
					),
					array(
						'desc'		 => esc_html__( 'Show top footer?', 'broker' ),
						'id'		 => 'cg_footer_top_active',
						'type'		 => 'select',
						'title'		 => esc_html__( 'Show top footer', 'broker' ),
						'options'	 => array(
							'yes'	 => esc_html__( 'Yes', 'broker' ),
							'no'	 => esc_html__( 'No', 'broker' ),
						),
						'default'	 => 'yes',
					),
					array(
						'desc'		 => esc_html__( 'Show bottom footer?', 'broker' ),
						'id'		 => 'cg_footer_bottom_active',
						'type'		 => 'select',
						'title'		 => esc_html__( 'Show bottom footer', 'broker' ),
						'options'	 => array(
							'yes'	 => esc_html__( 'Yes', 'broker' ),
							'no'	 => esc_html__( 'No', 'broker' ),
						),
						'default'	 => 'yes',
					),
					array(
						'desc'		 => esc_html__( 'Show back to top?', 'broker' ),
						'id'		 => 'cg_back_to_top',
						'type'		 => 'select',
						'title'		 => esc_html__( 'Show back to top?', 'broker' ),
						'options'	 => array(
							'yes'	 => esc_html__( 'Yes', 'broker' ),
							'no'	 => esc_html__( 'No', 'broker' ),
						),
						'default'	 => 'yes',
					),
				),
			);

			$this->sections[] = array(
				'title'	 => esc_html__( 'Typography', 'broker' ),
				'desc'	 => esc_html__( 'Manage your fonts and typefaces.', 'broker' ),
				'icon'	 => 'el-icon-fontsize',
				'fields' => array(
					array(
						'id'			 => 'opt-typography-body',
						'type'			 => 'typography',
						'title'			 => esc_html__( 'Body/Main text font', 'broker' ),
						'google'		 => true, // Disable google fonts. Won't work if you haven't defined your google api key
						'font-backup'	 => true, // Select a backup non-google font in addition to a google font
						'letter-spacing' => true, // Defaults to false
						'all_styles'	 => true, // Enable all Google Font style/weight variations to be added to the page
						'output'		 => array( 'body', 'select', 'input', 'textarea', 'button', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', ), // An array of CSS selectors to apply this font style to dynamically
						'units'			 => 'px', // Defaults to px
						'subtitle'		 => esc_html__( 'Each property can be called individually.', 'broker' ),
						'default'		 => array(
							'color'			 => '#333333',
							'font-weight'	 => '300',
							'font-family'	 => 'Source Sans Pro',
							'google'		 => true,
							'font-size'		 => '17px',
							'line-height'	 => '27px'
						),
					),
					array(
						'id'			 => 'opt-typography-secondary',
						'type'			 => 'typography',
						'title'			 => esc_html__( 'Secondary font', 'broker' ),
						'google'		 => true, // Disable google fonts. Won't work if you haven't defined your google api key
						'font-backup'	 => true, // Select a backup non-google font in addition to a google font
						'letter-spacing' => true, // Defaults to false
						'all_styles'	 => true, // Enable all Google Font style/weight variations to be added to the page
						'output'		 => array(
							'.content-area .entry-content blockquote',
							'.content-area .entry-content blockquote p',
							'.breadcrumbs-wrapper p',
							'.cg-blog-article footer',
							'body.single footer.entry-meta',
							'.blog-meta',
							'body.woocommerce nav.woocommerce-pagination ul li',
							'.content-area .blog-pagination ul li',
							'.woocommerce .quantity .qty',
							'.woocommerce table.shop_table .quantity input.qty',
							
						),
						'compiler'		 => array( 'h2.site-description-compiler' ), // An array of CSS selectors to apply this font style to dynamically
						'units'			 => 'px', // Defaults to px
						'subtitle'		 => esc_html__( 'Each property can be called individually.', 'broker' ),
						'default'		 => array(
							'font-weight'	 => '400',
							'font-family'	 => 'Lora',
							'google'		 => true,
						),
					),
					array(
						'id'			 => 'opt-typography-p',
						'type'			 => 'typography',
						'title'			 => esc_html__( 'Paragraph Style', 'broker' ),
						'google'		 => true, // Disable google fonts. Won't work if you haven't defined your google api key
						'font-backup'	 => true, // Select a backup non-google font in addition to a google font
						'text-transform' => true,
						'letter-spacing' => true, // Defaults to false
						'all_styles'	 => true, // Enable all Google Font style/weight variations to be added to the page
						'output'		 => array( '.content-area .entry-content p', '.product p', '.content-area .vc_toggle_title h4', '.content-area ul', '.content-area ol', '.vc_figure-caption', '.authordescription p', 'body.page-template-template-home-default .wpb_text_column p' ), // An array of CSS selectors to apply this font style to dynamically
						'units'			 => 'px', // Defaults to px
						'subtitle'		 => esc_html__( 'Typography option with each property can be called individually.', 'broker' ),
						'default'		 => array(
							'color'			 => '#343e47',
							'font-weight'	 => '300',
							'font-family'	 => 'Source Sans Pro',
							'google'		 => true,
							'font-size'		 => '17px',
							'line-height'	 => '27px',
						),
					),
					array(
						'id'			 => 'opt-typography-h1',
						'type'			 => 'typography',
						'title'			 => esc_html__( 'Heading 1 Style', 'broker' ),
						'google'		 => true, // Disable google fonts. Won't work if you haven't defined your google api key
						'font-backup'	 => true, // Select a backup non-google font in addition to a google font
						'text-transform' => true,
						'letter-spacing' => true, // Defaults to false
						'all_styles'	 => true, // Enable all Google Font style/weight variations to be added to the page
						'output'		 => array( 'h1', '.content-area h1', 'h1.cg-page-title', '.summary h1', '.content-area .summary h1', ), // An array of CSS selectors to apply this font style to dynamically
						'units'			 => 'px', // Defaults to px
						'subtitle'		 => esc_html__( 'Typography option with each property can be called individually.', 'broker' ),
						'default'		 => array(
							'color'			 => '#111',
							'font-weight'	 => '400',
							'font-family'	 => 'Lora',
							'google'		 => true,
							'font-size'		 => '40px',
							'line-height'	 => '54px',
						),
					),
					array(
						'id'			 => 'opt-typography-h2',
						'type'			 => 'typography',
						'title'			 => esc_html__( 'Heading 2 Style', 'broker' ),
						'google'		 => true, // Disable google fonts. Won't work if you haven't defined your google api key
						'font-backup'	 => true, // Select a backup non-google font in addition to a google font
						'text-transform' => true,
						'letter-spacing' => true, // Defaults to false
						'all_styles'	 => true, // Enable all Google Font style/weight variations to be added to the page
						'output'		 => array( 'h2', '.content-area h2' ), // An array of CSS selectors to apply this font style to dynamically
						'units'			 => 'px', // Defaults to px
						'subtitle'		 => esc_html__( 'Each property can be called individually.', 'broker' ),
						'default'		 => array(
							'color'			 => '#222',
							'font-weight'	 => '400',
							'font-family'	 => 'Lora',
							'google'		 => true,
							'font-size'		 => '32px',
							'line-height'	 => '46px'
						),
					),
					array(
						'id'			 => 'opt-typography-h3',
						'type'			 => 'typography',
						'title'			 => esc_html__( 'Heading 3 Style', 'broker' ),
						'google'		 => true, // Disable google fonts. Won't work if you haven't defined your google api key
						'font-backup'	 => true, // Select a backup non-google font in addition to a google font
						'text-transform' => true,
						'letter-spacing' => true, // Defaults to false
						'all_styles'	 => true, // Enable all Google Font style/weight variations to be added to the page
						'output'		 => array( 'h3', '.content-area h3' ), // An array of CSS selectors to apply this font style to dynamically
						'units'			 => 'px', // Defaults to px
						'subtitle'		 => esc_html__( 'Each property can be called individually.', 'broker' ),
						'default'		 => array(
							'color'			 => '#222',
							'font-weight'	 => '400',
							'font-family'	 => 'Lora',
							'google'		 => true,
							'font-size'		 => '28px',
							'line-height'	 => '36px'
						),
					),
					array(
						'id'			 => 'opt-typography-h4',
						'type'			 => 'typography',
						'title'			 => esc_html__( 'Heading 4 Style', 'broker' ),
						'google'		 => true, // Disable google fonts. Won't work if you haven't defined your google api key
						'font-backup'	 => true, // Select a backup non-google font in addition to a google font
						'text-transform' => true,
						'letter-spacing' => true, // Defaults to false
						'all_styles'	 => true, // Enable all Google Font style/weight variations to be added to the page
						'output'		 => array( 'h4', '.content-area h4', 'body .vc_separator h4' ), // An array of CSS selectors to apply this font style to dynamically
						'units'			 => 'px', // Defaults to px
						'subtitle'		 => esc_html__( 'Each property can be called individually.', 'broker' ),
						'default'		 => array(
							'color'			 => '#222',
							'font-weight'	 => '400',
							'font-family'	 => 'Lora',
							'google'		 => true,
							'font-size'		 => '22px',
							'line-height'	 => '32px'
						),
					),
					array(
						'id'			 => 'opt-typography-h5',
						'type'			 => 'typography',
						'title'			 => esc_html__( 'Heading 5 Style', 'broker' ),
						'google'		 => true, // Disable google fonts. Won't work if you haven't defined your google api key
						'font-backup'	 => true, // Select a backup non-google font in addition to a google font
						'text-transform' => true,
						'letter-spacing' => true, // Defaults to false
						'all_styles'	 => true, // Enable all Google Font style/weight variations to be added to the page
						'output'		 => array( 'h5', '.content-area h5' ), // An array of CSS selectors to apply this font style to dynamically
						'units'			 => 'px', // Defaults to px
						'subtitle'		 => esc_html__( 'Each property can be called individually.', 'broker' ),
						'default'		 => array(
							'color'			 => '#222',
							'font-weight'	 => '400',
							'font-family'	 => 'Lora',
							'google'		 => true,
							'font-size'		 => '17px',
							'line-height'	 => '26px'
						),
					),
					array(
						'id'			 => 'opt-typography-h6',
						'type'			 => 'typography',
						'title'			 => esc_html__( 'Heading 6 Style', 'broker' ),
						'google'		 => true, // Disable google fonts. Won't work if you haven't defined your google api key
						'font-backup'	 => true, // Select a backup non-google font in addition to a google font
						'text-transform' => true,
						'letter-spacing' => true, // Defaults to false
						'all_styles'	 => true, // Enable all Google Font style/weight variations to be added to the page
						'output'		 => array( 'h6', '.content-area h6' ), // An array of CSS selectors to apply this font style to dynamically
						'units'			 => 'px',
						'subtitle'		 => esc_html__( 'Each property can be called individually.', 'broker' ),
						'default'		 => array(
							'color'			 => '#343e47',
							'font-weight'	 => '300',
							'font-family'	 => 'Source Sans Pro',
							'google'		 => true,
							'font-size'		 => '15px',
							'line-height'	 => '23px'
						),
					),
					array(
						'id'			 => 'cg-type-widget-title',
						'type'			 => 'typography',
						'title'			 => esc_html__( 'Widget Title Typeface', 'broker' ),
						'google'		 => true, // Disable google fonts. Won't work if you haven't defined your google api key
						'font-backup'	 => true, // Select a backup non-google font in addition to a google font
						'text-transform' => true,
						'letter-spacing' => true, // Defaults to false
						'all_styles'	 => true, // Enable all Google Font style/weight variations to be added to the page
						'output'		 => array( 'h4.widget-title', '.subfooter h4', ), // An array of CSS selectors to apply this font style to dynamically
						'units'			 => 'px',
						'subtitle'		 => esc_html__( 'Each property can be called individually.', 'broker' ),
						'default'		 => array(
							'color'			 => '#222',
							'font-weight'	 => '400',
							'font-family'	 => 'Source Sans Pro',
							'google'		 => true,
							'font-size'		 => '18px',
							'line-height'	 => '26px',
						),
					),
				),
			);

			$this->sections[] = array(
				'title'	 => esc_html__( 'News Settings', 'broker' ),
				'desc'	 => esc_html__( 'Manage your news settings.', 'broker' ),
				'icon'	 => 'el-icon-file-edit',
				'fields' => array(
					array(
						'id'		 => 'cg_blog_page_title',
						'type'		 => 'text',
						'title'		 => esc_html__( 'News Page Title', 'broker' ),
						'default'	 => esc_html__( 'News', 'broker' ),
					),
					array(
                        'id' 		 => 'cg_news_layout',
                        'type' 		 => 'select',
                        'options' 	 => array(
                            'default-news' 		=> esc_html__( 'Default', 'broker' ),
                            'grid-news' 		=> esc_html__( 'Grid (3 columns)', 'broker' ),
                            'grid-news-two' 	=> esc_html__( 'Grid (2 columns)', 'broker' ),
                        ),
                        'title' => esc_html__( 'News Layout', 'broker' ),
                        'default' => 'default-news',
                    ),
					array(
						'id'		 => 'cg_blog_sidebar',
						'type'		 => 'select',
						'options'	 => array(
							'default'	 => esc_html__( 'Left Sidebar', 'broker' ),
							'right'		 => esc_html__( 'Right Sidebar', 'broker' ),
							'none'		 => esc_html__( 'No Sidebar', 'broker' ),
						),
						'title'		 => esc_html__( 'News Landing Page Sidebar', 'broker' ),
						'default'	 => 'right',
					),
					array(
						'id'		 => 'cg_post_sidebar',
						'type'		 => 'select',
						'options'	 => array(
							'default'	 => esc_html__( 'Left Sidebar', 'broker' ),
							'right'		 => esc_html__( 'Right Sidebar', 'broker' ),
							'none'		 => esc_html__( 'No Sidebar', 'broker' ),
						),
						'title'		 => esc_html__( 'Individual Post Sidebar', 'broker' ),
						'default'	 => 'right',
					),

				),
			);
			

			$this->sections[] = array(
				'title'	 => esc_html__( 'Custom Code', 'broker' ),
				'desc'	 => esc_html__( 'Add some custom code.', 'broker' ),
				'fields' => array(
					array(
						'title'	 => esc_html__( 'Custom CSS', 'broker' ),
						'desc'	 => esc_html__( 'Add some custom css to your site?', 'broker' ),
						'id'	 => 'cg_custom_css',
						'type'	 => 'ace_editor',
						'mode'	 => 'css',
						'theme'	 => 'monokai'
					),
				),
			);
		}

		public function setHelpTabs() {

			// Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
			$this->args['help_tabs'][] = array(
				'id'		 => 'redux-help-tab-1',
				'title'		 => esc_html__( 'Theme Information 1', 'redux-framework-demo' ),
				'content'	 => esc_html__( '<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo' )
			);

			$this->args['help_tabs'][] = array(
				'id'		 => 'redux-help-tab-2',
				'title'		 => esc_html__( 'Theme Information 2', 'redux-framework-demo' ),
				'content'	 => esc_html__( '<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo' )
			);

			// Set the help sidebar
			$this->args['help_sidebar'] = esc_html__( '<p>This is the sidebar content, HTML is allowed.</p>', 'redux-framework-demo' );
		}

		/**
		 * Redux config
		 * */
		public function setArguments() {

			$theme = wp_get_theme(); // For use with some settings. Not necessary.

			$this->args = array(
				// TYPICAL -> Change these values as you need/desire

				'opt_name'				 => 'cg_reduxopt', // This is where your data is stored in the database and also becomes your global variable name.
				'display_name'			 => $theme->get( 'Name' ), // Name that appears at the top of your panel
				'display_version'		 => $theme->get( 'Version' ), // Version that appears at the top of your panel
				'menu_type'				 => 'menu', //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
				'allow_sub_menu'		 => true, // Show the sections below the admin menu item or not
				'menu_title'			 => esc_html__( 'Theme Options', 'broker' ),
				'page_title'			 => esc_html__( 'Theme Options', 'broker' ),
				// You will need to generate a Google API key to use this feature.
				// Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
				'google_api_key'		 => 'AIzaSyB9TDy0IOriQpR8gt2TmoaZ070oWgIhvcs', // Must be defined to add google fonts to the typography module
				'google_update_weekly'	 => true,
				'async_typography'		 => false, // Use a asynchronous font on the front end or font string
				'admin_bar'				 => true, // Show the panel pages on the admin bar
				'global_variable'		 => 'cg_options', // Set a different name for your global variable other than the opt_name
				'dev_mode'				 => false, // Show the time the page took to load, etc
				'customizer'			 => true, // Enable basic customizer support
				//'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
				//'disable_save_warn' => true,                    // Disable the save warning when a user changes a field
				// OPTIONAL -> Give you extra features
				'page_priority'			 => null, // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
				'page_parent'			 => 'themes.php', // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
				'page_permissions'		 => 'manage_options', // Permissions needed to access the options panel.
				'menu_icon'				 => '', // Specify a custom URL to an icon
				'last_tab'				 => '', // Force your panel to always open to a specific tab (by id)
				'page_icon'				 => 'icon-themes', // Icon displayed in the admin panel next to your menu_title
				'page_slug'				 => 'cg_reduxopt', // Page slug used to denote the panel
				'save_defaults'			 => true, // On load save the defaults to DB before user clicks save or not
				'default_show'			 => false, // If true, shows the default value next to each field that is not the default value.
				'default_mark'			 => '*', // What to print by the field's title if the value shown is default. Suggested: *
				'show_import_export'	 => true, // Shows the Import/Export panel when not used as a field.
				// CAREFUL -> These options are for advanced use only
				'transient_time'		 => 60 * MINUTE_IN_SECONDS,
				'output'				 => true, // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
				'output_tag'			 => true, // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
				'footer_credit'			 => false, // Disable the footer credit of Redux. Please leave if you can help it.
				// FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
				'database'				 => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
				'system_info'			 => false, // REMOVE
				// HINTS
				'hints'					 => array(
					'icon'			 => 'icon-question-sign',
					'icon_position'	 => 'right',
					'icon_color'	 => 'lightgray',
					'icon_size'		 => 'normal',
					'tip_style'		 => array(
						'color'		 => 'light',
						'shadow'	 => true,
						'rounded'	 => false,
						'style'		 => '',
					),
					'tip_position'	 => array(
						'my' => 'top left',
						'at' => 'bottom right',
					),
					'tip_effect'	 => array(
						'show'	 => array(
							'effect'	 => 'slide',
							'duration'	 => '500',
							'event'		 => 'mouseover',
						),
						'hide'	 => array(
							'effect'	 => 'slide',
							'duration'	 => '500',
							'event'		 => 'click mouseleave',
						),
					),
				)
			);


			// SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
			//$this->args[ 'share_icons' ][] = array(
			//    'url' => 'https://github.com/ReduxFramework/ReduxFramework',
			//    'title' => 'Visit us on GitHub',
			//    'icon' => 'el-icon-github'
			//    //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
			//);
			$this->args[ 'share_icons' ][] = array(
			    'url' => 'https://www.facebook.com/CommerceGurus-1687149888185740',
			    'title' => 'Like us on Facebook',
			    'icon' => 'el-icon-facebook'
			);
			$this->args['share_icons'][] = array(
				'url'	 => esc_html__( 'http://twitter.com/commercegurus', 'broker' ),
				'title'	 => esc_html__( 'Follow us on Twitter', 'broker' ),
				'icon'	 => 'el-icon-twitter'
			);
			//$this->args[ 'share_icons' ][] = array(
			//    'url' => 'http://www.linkedin.com/company/redux-framework',
			//    'title' => 'Find us on LinkedIn',
			//    'icon' => 'el-icon-linkedin'
			//);
			// Panel Intro text -> before the form
			if ( !isset( $this->args['global_variable'] ) || $this->args['global_variable'] !== false ) {
				if ( !empty( $this->args['global_variable'] ) ) {
					$v = $this->args['global_variable'];
				} else {
					$v = str_replace( '-', '_', $this->args['opt_name'] );
				}
				//$this->args[ 'intro_text' ] = sprintf( esc_html__( '<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'redux-framework-demo' ), $v );
			} else {
				//$this->args[ 'intro_text' ] = esc_html__( '<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'redux-framework-demo' );
			}

			// Add content after the form.
			//$this->args[ 'footer_text' ] = esc_html__( '<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'redux-framework-demo' );
		}

	}

	global $reduxConfig;
	$reduxConfig = new Cg_Redux_Framework_config();
}

/**
 * Custom function for the callback referenced above
 */
if ( !function_exists( 'redux_theme_my_custom_field' ) ):

	function redux_theme_my_custom_field( $field, $value ) {
		print_r( $field );
		echo '<br/>';
		print_r( $value );
	}

endif;

/**
 * Custom function for the callback validation referenced above
 * */
if ( !function_exists( 'redux_theme_validate_callback_function' ) ):

	function redux_theme_validate_callback_function( $field, $value, $existing_value ) {
		$error	 = false;
		$value	 = 'just testing';

		/*
		  do your validation

		  if(something) {
		  $value = $value;
		  } elseif(something else) {
		  $error = true;
		  $value = $existing_value;
		  $field['msg'] = 'your custom error message';
		  }
		 */

		$return['value'] = $value;
		if ( $error == true ) {
			$return['error'] = $field;
		}
		return $return;
	}











endif;