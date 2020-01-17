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
	add_menu_page( __( 'Super Web Share', 'super-web-share' ), __( 'Super Web Share', 'super-web-share' ), 'manage_options', 'superwebshare','superwebshare_admin_interface_render', 'dashicons-share', 100 );
    // General Settings page - Same as main menu page
	add_submenu_page( 'superwebshare', __( 'Super Web Share', 'super-web-share' ), __( ' General Settings', 'super-web-share' ), 'manage_options', 'superwebshare', 'superwebshare_admin_interface_render' );
    // Floating button Settings page - since 1.4.2
    add_submenu_page( 'superwebshare', __( 'Super Web Share', 'super-web-share' ), __( 'Floating Button', 'super-web-share' ), 'manage_options', 'superwebshare&tab=floating', 'superwebshare_admin_interface_render' );
    add_submenu_page( 'superwebshare', __( 'Super Web Share', 'super-web-share' ), __( 'Status', 'super-web-share' ), 'manage_options', 'superwebshare-status', 'superwebshare_status_interface_render' );
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
			'settings' => '<a href="' . admin_url( 'admin.php?page=superwebshare&tab=general' ) . '">' . __( 'Settings', 'super-web-share' ) . '</a>'
		),
		$links
	);
}
add_filter( 'plugin_action_links_super-web-share/super-web-share.php', 'superwebshare_plugin_row_settings_link' );

/**
 * Add Demo link on to WordPress Plugin page row
 *
 * @since 1.0.0
 */
function superwebshare_plugin_row_meta( $links, $file ) {
	
	if ( strpos( $file, 'super-web-share.php' ) !== false ) {
		$new_links = array(
				'demo' 	=> '<a href="https://www.josevarghese.com/?utm_source=WordPress-Demo" target="_blank">' . __( 'Demo', 'super-web-share' ) . '</a>',
				);
		$links = array_merge( $links, $new_links );
	}
	
	return $links;
}
add_filter( 'plugin_row_meta', 'superwebshare_plugin_row_meta', 10, 2 );

/**
* Show notices in admin area
*
* @since    1.4.2
*/
function superwebshare_admin_notice_activation() {

	// Notices only for admins
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
 
	// Return if transient is not set
	if ( ! get_transient( 'superwebshare_admin_notice_activation' ) ) {
		return;

	// Admin notice on plugin activation
	// Do not display link to the settings page, if already within the Settings Page
	$screen = get_current_screen();
	$superwebshare_link_text = ( strpos( $screen->id, 'superwebshare' ) === false ) ? sprintf( __( '<a href="%s">Customize your share button settings &rarr;</a>', 'super-web-share' ), admin_url( 'admin.php?page=superwebshare&tab=general' ) ) : '';
	
	echo '<div class="updated notice is-dismissible"><p>' . __( 'Thank you for installing <strong>Super Web Share</strong> ', 'super-web-share' ) . $superwebshare_link_text . '</p></div>';
		
	// Delete transient
	delete_transient( 'superwebshare_admin_notice_activation' );
	}
	if ( get_transient( 'superwebshare_admin_notice_upgrade_complete' ) ) {
		
		echo '<div class="updated notice is-dismissible"><p>' . sprintf( __( '<strong>Super Web Share</strong>: Successfully updated to the latest version.' ), 'super-web-share' ) . '</p></div>';
		
		// Delete transient
		delete_transient( 'superwebshare_admin_notice_upgrade_complete' );
	}
}
add_action( 'admin_notices', 'superwebshare_admin_notice_activation' );

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
    $superwebshare_footer_text = sprintf( __( 'Thank you for using Super Web Share :) If you like it, please leave <a href="https://wordpress.org/support/plugin/super-web-share/reviews/?rate=5#new-post" target="_blank">a ★★★★★ rating </a> to support us on WordPress.org to help us spread the word to the community. Thanks a lot!  
		</li>', 'super-web-share'), 
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
 * Redirect to SuperWebShare UI on plugin activation.
 *
 * Will redirect to SuperPWA settings page when plugin is activated.
 * Will not redirect if multiple plugins are activated at the same time.
 * Will not redirect when activated network wide on multisite. Network admins know their way.
 * Credits: SuperPWA Plugin Github @link https://github.com/SuperPWA/Super-Progressive-Web-Apps/
 * 
 * @since 1.3
 */
function superwebshare_activation_redirect( $plugin, $network_wide ) {
	// Return if not SuperPWA or if plugin is activated network wide.
	if ( $plugin !== plugin_basename( SUPERWEBSHARE_PLUGIN_FILE ) || $network_wide === true ) {
		return false;
	}
	/**
	 * An instance of the WP_Plugins_List_Table class.
	 *
	 * @link https://core.trac.wordpress.org/browser/tags/4.9.8/src/wp-admin/plugins.php#L15
	 */
	$wp_list_table_instance = new WP_Plugins_List_Table();
	$current_action         = $wp_list_table_instance->current_action();
	// When only one plugin is activated, the current_action() method will return activate.
	if ( $current_action !== 'activate' ) {
		return false;
	}
	// Redirect to Super Web Share settings page. 
	exit( wp_redirect( admin_url( 'admin.php?page=superwebshare&tab=general' ) ) );
}
add_action( 'activated_plugin', 'superwebshare_activation_redirect', PHP_INT_MAX, 2 );

/**
 * HTTPS Status Checker
 *
 * @since 1.0
 */
function superwebshare_status_interface_render() {
	// Check permission
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	?>
	
	<div class="wrap">	
		<h1>Super Web Share - Status</h1>
		<?php
			printf( '<h5>Status</h5>' );
			if ( is_ssl() ) {
				
				printf( '<p><span class="dashicons dashicons-yes" style="color: #46b460;"></span> ' . __( 'Wow!!! Your website is served over HTTPS. SuperWebShare will work perfectly upon your website.', 'super-web-share' ) . '</p>' );
			} else {
				
				printf( '<p><span class="dashicons dashicons-no-alt" style="color: #dc3235;"></span> ' . __( 'Looks like the website is not served fully via HTTPS. As for supporting SuperWebShare, your website should be served fully over HTTPS and green padlock should be there upon the address bar. ', 'super-web-share' ) . '</p>' );
			}
		?>
	</div>
	<?php
}

/**
 * Normal Settings Register
 *
 * @since 1.0
 */
function superwebshare_register_settings_normal() {
	// Register Setting
	register_setting( 
		'superwebshare_settings_group', 		// Group name
		'superwebshare_settings', 				// Setting name = html form <input> name on settings form
		'superwebshare_validater_and_sanitizer'	// Input sanitizer
	);
	// Above & Below Post Share Settings Options
    add_settings_section(
        'superwebshare_basic_settings_section',			// ID
        __('<br>General Settings', 'super-web-share'),	// Title
        '__return_false',								// Callback Function
        'superwebshare_basic_settings_section'			// Page slug
	);
			// Description
			add_settings_field(
				'superwebshare_description_share',								// ID
				__('', 'super-web-share'),										// Title
				'superwebshare_normal_description_cb',							// CB
				'superwebshare_basic_settings_section',							// Page slug
				'superwebshare_basic_settings_section'							// Settings Section ID
			);
			// Enable/Disable Share Button - Above & Below Post Content
			add_settings_field(
				'superwebshare_enable_share',									// ID
				__('Enable/Disable the share button', 'super-web-share'),		// Title
				'superwebshare_normal_enable_cb',								// CB
				'superwebshare_basic_settings_section',							// Page slug
				'superwebshare_basic_settings_section'							// Settings Section ID
			);
			// Display settings of Share Button (normal) Above and Below Post/Page Content
			add_settings_field(
				'superwebshare_display_share',									// ID
				__('Display settings of Share Button', 'super-web-share'),		// Title
				'superwebshare_normal_display_cb',								// CB
				'superwebshare_basic_settings_section',							// Page slug
				'superwebshare_basic_settings_section'							// Settings Section ID
			);
			// Position of Share Button (normal)
			add_settings_field(
				'superwebshare_position_share',									// ID
				__('Position of Share Button', 'super-web-share'),				// Title
				'superwebshare_normal_position_cb',								// CB
				'superwebshare_basic_settings_section',							// Page slug
				'superwebshare_basic_settings_section'							// Settings Section ID
			);
			// Text for share button
			add_settings_field(
				'superwebshare_text_share',										// ID
				__('Text for share button', 'super-web-share'),					// Title
				'superwebshare_normal_text_cb',									// CB
				'superwebshare_basic_settings_section',							// Page slug
				'superwebshare_basic_settings_section'							// Settings Section ID
			);
			// Normal Button Color
			add_settings_field(
				'superwebshare_color_share',									// ID
				__('Button Color', 'super-web-share'),		// Title
				'superwebshare_normal_color_cb',								// CB
				'superwebshare_basic_settings_section',							// Page slug
				'superwebshare_basic_settings_section'							// Settings Section ID
			);
			// Enable/Disable Share Button - AMP (1.4.4)
			add_settings_field(
				'superwebshare_enable_amp_share',									// ID
				__('Enable/Disable the share button over AMP Pages', 'super-web-share'),		// Title
				'superwebshare_normal_amp_enable_cb',								// CB
				'superwebshare_basic_settings_section',							// Page slug
				'superwebshare_basic_settings_section'							// Settings Section ID
			);
}
add_action( 'admin_init', 'superwebshare_register_settings_normal' );

function superwebshare_register_settings_floating() {
	// Register Setting
	register_setting( 
		'superwebshare_settings_floating_group', 		// Group name
		'superwebshare_floatingsettings', 				// Setting name = html form <input> name on settings form
		'superwebshare_validater_and_sanitizer_floating'	// Input sanitizer
	);
	// Floating Button Settings
    add_settings_section(
        'superwebshare_floating_settings_section',				// ID
        __('<br>Floating Button Settings', 'super-web-share'),	// Title
        '__return_false',										// Callback Function
        'superwebshare_floating_settings_section'				// Page slug
	);
			// Description
			add_settings_field(
				'superwebshare_floating_description_share',						// ID
				__('', 'super-web-share'),										// Title
				'superwebshare_floating_description_cb',						// CB
				'superwebshare_floating_settings_section',						// Page slug
				'superwebshare_floating_settings_section'						// Settings Section ID
			);
			// Enable/Disable the floating share button
			add_settings_field(
				'superwebshare_floating_enable_share',							// ID
				__('Enable/Disable the floating share button', 'super-web-share'),	// Title
				'superwebshare_floating_enable_cb',								// CB
				'superwebshare_floating_settings_section',						// Page slug
				'superwebshare_floating_settings_section'						// Settings Section ID
			);
			// Floating Button color
			add_settings_field(
				'superwebshare_floating_color_share',							// ID
				__('Button color', 'super-web-share'),							// Title
				'superwebshare_floating_color_cb',								// CB
				'superwebshare_floating_settings_section',						// Page slug
				'superwebshare_floating_settings_section'						// Settings Section ID
			);
			// Floating Display Pages
			add_settings_field(
				'superwebshare_floating_display_share',							// ID
				__(' Display floating button', 'super-web-share'),				// Title
				'superwebshare_floating_display_cb',							// CB
				'superwebshare_floating_settings_section',						// Page slug
				'superwebshare_floating_settings_section'						// Settings Section ID
			);
			// Position of Floating Button
			add_settings_field(
				'superwebshare_floating_position_share',						// ID
				__('Position of the floating button', 'super-web-share'),		// Title
				'superwebshare_floating_position_cb',							// CB
				'superwebshare_floating_settings_section',						// Page slug
				'superwebshare_floating_settings_section'						// Settings Section ID
			);
			// Position from Bottom
			add_settings_field(
				'superwebshare_floating_position_bottom_share',					// ID
				__('Position from Bottom', 'super-web-share'),					// Title
				'superwebshare_floating_position_bottom_cb',					// CB
				'superwebshare_floating_settings_section',						// Page slug
				'superwebshare_floating_settings_section'						// Settings Section ID
			);
			// Enable/Disable Share Button - AMP (1.4.4)
			add_settings_field(
				'superwebshare_floating_enable_amp_share',									// ID
				__('Enable/Disable the floating share button over AMP Pages', 'super-web-share'),		// Title
				'superwebshare_floating_amp_enable_cb',								// CB
				'superwebshare_floating_settings_section',							// Page slug
				'superwebshare_floating_settings_section'							// Settings Section ID
			);
}
add_action( 'admin_init', 'superwebshare_register_settings_floating' );

/**
 * Validate and sanitize user input before its saved to database
 *
 * @since 1.0 
 */
function superwebshare_validater_and_sanitizer( $settings ) {
	// Sanitize hex color input for theme_color
	$settings['normal_share_color'] = preg_match( '/#([a-f0-9]{3}){1,2}\b/i', $settings['normal_share_color'] ) ? sanitize_text_field( $settings['normal_share_color'] ) : '#0DC152';
	$settings['normal_share_button_text'] = sanitize_text_field( isset($settings['normal_share_button_text']) ) ? sanitize_text_field( $settings['normal_share_button_text'] ) : 'Share';
	return $settings;
}

/**
 * Floating - Validate and sanitize user input before its saved to database
 *
 * @since 1.3 
 */
function superwebshare_validater_and_sanitizer_floating( $settings_floating ) {
	// Sanitize hex color input for floating theme_color
	$settings_floating['floating_position_button'] = preg_match( '/^[0-9]$/i', isset($settings_floating['floating_position_button']) ) ? sanitize_text_field( $settings_floating['floating_position_button'] ) : '30';
	return $settings_floating;
}
			
/**
 * Get settings from database
 *
 * @since 	1.0.0
 * @return	Array	A merged array of default and settings saved in database.
 */
function superwebshare_get_settings() {
	$defaults = array(
				'normal_display_page'			=>	'1', 		// 1 as active
				'normal_display_archive'		=>	'1', 		// 1 as active
				'normal_display_home'			=>  '1',    	// 1 as active
				'position'						=>	'before',     // both = Top and Bottom of the content
				'normal_share_button_text'		=>	'Share',	// content for share button
				'normal_share_color'			=>	'#BD3854',	// default color for normal share button
				'superwebshare_normal_enable'	=>	'disable',	// enable by default
				'superwebshare_normal_amp_enable' => 'enable' //1.4.4 amp settings
		
			);
	$settings = get_option( 'superwebshare_settings', $defaults );
	
	return $settings;
}

/**
 * Get floating settings from database
 *
 * @since 	1.3
 * @return	Array	A merged array of default and settings saved in database.
 */
function superwebshare_get_settings_floating() {
	$defaults = array(
				'floating_share_color' 			=> '#BD3854', 	// defautlt color
				'floating_display_page'    	 	=>  '1', 		// 1 as active
				'floating_display_archive'  	=>  '1',
				'floating_display_home'     	=>  '1',
				'floating_position'				=>	'right', 	// left or right
				'floating_position_leftright'	=>	'5', 		// in pixel
				'floating_position_bottom'		=>	'5', 		// in pixel
				'superwebshare_floating_enable'	=>	'enable',	// enable by default
				'superwebshare_floating_amp_enable'	=>	'enable'	// enable by default - 1.4.4
		
			);
	$settings_floating = get_option( 'superwebshare_floatingsettings', $defaults );
	
	return $settings_floating;
}