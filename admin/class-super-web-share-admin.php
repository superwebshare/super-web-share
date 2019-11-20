<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://superwebshare.com
 * @since      1.0.0
 *
 * @package    Super_Web_Share
 * @subpackage Super_Web_Share/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Super_Web_Share
 * @subpackage Super_Web_Share/admin
 * @author     SuperWebShare
 */
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class Super_Web_Share_Admin extends Super_Web_Share
  {

	public $plugin;
	
		function __construct() {
			$this->plugin = plugin_basename( __FILE__ );
		}
	
			function register() {
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_action( 'admin_enqueue_styles', array( $this, 'enqueue_styles' ) );
			}

	
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . '/css/super-web-share-admin.css', array(), $this->version, 'all' );
	}

	public function enqueue_scripts($hook) {
	
    // Load only on SuperPWA plugin pages
	if ( strpos( $hook, 'superwebshare' ) === false ) {
		return;
	}
	
	// Color picker CSS

    wp_enqueue_style( 'wp-color-picker' );
	
	// Main JS
    wp_enqueue_script(  'superwebshare-main-js', plugin_dir_url( __FILE__ ) . 'js/super-web-share-admin.js', array( 'wp-color-picker' ), $this->version, true );

	}
}
	
	$superWebShareAdmin = new Super_Web_Share_Admin();
	$superWebShareAdmin->register();

function superwebshare_admin_interface() {
			require_once plugin_dir_path( __FILE__ ) . 'partials/super-web-share-admin-display.php';
	}
add_action( 'admin_menu', 'superwebshare_admin_interface' );

/**
 * Add Menu and links of Plugin on Dashboard menu
 *
 * @since 1.0
 */

function superwebshare_add_menu_links() {
	
	// Main menu page --  superwebshare_options_page earlier
	add_options_page( __( 'Super Web Share', 'super-web-share' ), __( 'Super Web Share', 'super-web-share' ), 'manage_options', 'superwebshare','superwebshare_admin_interface_render', 'dashicons-share', 100 );
}
add_action( 'admin_menu', 'superwebshare_add_menu_links' );

/**
 * Add Settings link to Plugin Page's Row
 *
 * @since 1.0.0
 */
function superwebshare_plugin_row_settings_link( $links ) {
	
	return array_merge(
		array(
			'settings' => '<a href="' . admin_url( 'options-general.php?page=superwebshare' ) . '">' . __( 'Settings', 'super-web-share' ) . '</a>'
		),
		$links
	);
}
add_filter( 'plugin_action_links_super-web-share/super-web-share.php', 'superwebshare_plugin_row_settings_link' );

/**
 * Add Demo link to Plugin Page's Row
 *
 * @since 1.0.0
 */

function superwebshare_plugin_row_meta( $links, $file ) {
	
	if ( strpos( $file, 'super-web-share.php' ) !== false ) {
		$new_links = array(
				'demo' 	=> '<a href="https://www.josevarghese.com" target="_blank">' . __( 'Demo', 'super-web-share' ) . '</a>',
				);
		$links = array_merge( $links, $new_links );
	}
	
	return $links;
}
add_filter( 'plugin_row_meta', 'superwebshare_plugin_row_meta', 10, 2 );

/**
 * Admin footer text
 *
 * @since	1.0.0
 */
function superwebshare_footer_text( $default ) { 
	// Retun default on non-plugin pages
	$screen = get_current_screen();
	if ( strpos( $screen->id, 'superwebshare' ) === false ) {
		return $default;
	}
    $superwebshare_footer_text = sprintf( __( 'If you like Super Web Share, please <a href="https://www.paypal.me/PayJoseVarghese" target="_blank">make a donation</a> via PayPal or leave <a href="https://wordpress.org/support/plugin/super-web-share/reviews/?rate=5#new-post" target="_blank">a ★★★★★ rating to support us</a>.Thanks a bunch!', 'super-web-share' ), 
	'https://superwebshare.com'
	);
	return $superwebshare_footer_text;
}
add_filter( 'admin_footer_text', 'superwebshare_footer_text' );

/**
 * Admin footer version
 *
 * @since	1.0.0
 */
function superwebshare_footer_version( $default ) {
	// Retun default on non-plugin pages
	$screen = get_current_screen();
	if ( strpos( $screen->id, 'superwebshare' ) === false ) {
		return $default;
	}
	return 'SuperWebShare ' . SUPERWEBSHARE_VERSION;
}
add_filter( 'update_footer', 'superwebshare_footer_version', 11 );


/**
 * HTTPS Status Checker
 *
 * @since 1.0.0
 */
function superwebshare_https_status() {
	printf( '<h1>Status</h1>' );
	if ( is_ssl() ) {
		
		printf( '<p><span class="dashicons dashicons-yes" style="color: #46b460;"></span> ' . __( 'Awesome! Your website is served over HTTPS. SuperWebShare will work perfectly upon your website.', 'super-web-share' ) . '</p>' );
	} else {
		
		printf( '<p><span class="dashicons dashicons-no-alt" style="color: #dc3235;"></span> ' . __( 'As for supporting SuperWebShare your website should be served fully over HTTPS. Need help contact via our website', 'super-web-share' ) . '</p>' );
	}
}


function superwebshare_register_settings() {
	// Register Setting
	register_setting( 
		'superwebshare_settings_group', 		// Group name
		'superwebshare_settings', 				// Setting name = html form <input> name on settings form
		'superwebshare_validater_and_sanitizer'	// Input sanitizer
	);
	
	// Basic Application Settings
    add_settings_section(
        'superwebshare_basic_settings_section',				// ID
        __return_false(),									// Title
        '__return_false',									// Callback Function
        'superwebshare_basic_settings_section'				// Page slug
    );
		// Floating Share Color
		add_settings_field(
			'superwebshare_floating_share',									// ID
			__('Floating Share Color', 'super-web-share'),							// Title
			'superwebshare_floating_share_cb',									// CB
			'superwebshare_basic_settings_section',							// Page slug
			'superwebshare_basic_settings_section'							// Settings Section ID
		);
}
add_action( 'admin_init', 'superwebshare_register_settings' );

/**
 * Validate and sanitize user input before its saved to database
 *
 * @since 1.0 
 */
function superwebshare_validater_and_sanitizer( $settings ) {
	// Sanitize hex color input for theme_color
	$settings['floating_share_color'] = preg_match( '/#([a-f0-9]{3}){1,2}\b/i', $settings['floating_share_color'] ) ? sanitize_text_field( $settings['floating_share_color'] ) : '#0DC152';
//	$settings['floating_position_button'] = preg_match( '/^[0-9]$/i', $settings['floating_position_button'] ) ? sanitize_text_field( $settings['floating_position_button'] ) : '30';
	return $settings;
}
			
/**
 * Get settings from database
 *
 * @since 	1.0.0
 * @return	Array	A merged array of default and settings saved in database.
 */
function superwebshare_get_settings() {
	$defaults = array(
				'floating_share_color' 			=> '#0DC152', 	// defautlt color
				'floating_display_page'    	 	=>  '1', 		// 1 as active
				'floating_display_archive'  	=>  '1',
				'floating_display_home'     	=>  '1',
				'floating_position'				=>	'right', 	// left or right
				'floating_position_leftright'	=>	'30', 		//in pixel
				'floating_position_bottom'		=>	'30', 		//in pixel
		
			);
	$settings = get_option( 'superwebshare_settings', $defaults );
	
	return $settings;
}
