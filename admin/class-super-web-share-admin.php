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
		$this->version = SUPERWEBSHARE_VERSION;

		add_action( 'save_post',      array( $this, 'save_meta_data') );
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
	}
	
	function register() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_enqueue_styles', array( $this, 'enqueue_styles' ) );
	}
	
	public function enqueue_styles() {
		wp_enqueue_style( "superwebshare-admin", plugin_dir_url( __FILE__ ) . 'css/super-web-share-admin.css', array(), $this->version, 'all' );
		if( ! empty( $_GET[ 'page' ] ) && $_GET[ 'page' ] == 'superwebshare-appearance' ){
			wp_enqueue_style( "superwebshare-public", SUPERWEBSHARE_PLUGIN_DIR_URI . '/public/css/super-web-share-public.css', array(), $this->version, 'all' );
		}
	}
	public function enqueue_scripts($hook) {
	
    // Load only on SuperWebShare plugin pages
		if ( strpos( $hook, 'superwebshare' ) === false ) {
			return;
		}

		// Color picker CSS
		wp_enqueue_style( 'wp-color-picker' );

		// Main JS
		wp_enqueue_script(  'superwebshare-main-js', plugin_dir_url( __FILE__ ) . 'js/super-web-share-admin.js', array( 'wp-color-picker' ), $this->version, true );
	}
	
	public function add_meta_box( $post_type ){
		// if ( in_array( $post_type, $post_types ) ) {

        // }
		add_meta_box(
			'super_web_share_meta',
			__( 'Super Web Share', 'super-web-share' ),
			array( $this, 'render_meta_box_content' ),
			array_keys( superwebshare_get_pages() ), //allowed pages
			'advanced',
			'high'
		);
	}

	public function save_meta_data( $post_id ){
		/*
         * If this is an autosave, SuperWebShare settings won't be saved.
		 * Condition: when post value not exists
         */
        if ( empty($_POST) || empty(  $_POST['post_type'] )  || ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) ) {
            return $post_id;
        }

        // Check the user's permissions.
        if ( 'page' == $_POST['post_type'] ) {
            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return $post_id;
            }
        } else {
            if ( ! current_user_can( 'edit_post', $post_id ) ) {
                return $post_id;
            }
        }

		// Sanitize the user input.
		$inline_data = empty(  $_POST[ 'superwebshare_post_inline_active' ]  ) ? "disabled" :  $_POST[ 'superwebshare_post_inline_active' ] ;
		$floating_data =  empty(  $_POST[ 'superwebshare_post_floating_active' ]  ) ? "disabled" :  $_POST[ 'superwebshare_post_floating_active' ] ;
		$is_enable_general = sanitize_text_field( $inline_data );
		$is_enable_floating = sanitize_text_field( $floating_data );

		 // Create/Update the meta field.
		 update_post_meta( $post_id, '_superwebshare_post_inline_active', $is_enable_general );
		 update_post_meta( $post_id, '_superwebshare_post_floating_active', $is_enable_floating );
	}

	public function render_meta_box_content( $post ){

		$is_active_floating = isset($post->_superwebshare_post_floating_active)? $post->_superwebshare_post_floating_active : "enable";
		$is_active_general = isset($post->_superwebshare_post_inline_active)? $post->_superwebshare_post_inline_active : "enable";
		?>
		<div class="sws-flex sws-max-500">
			<h4>
				<?php _e('Show Inline share button?', 'super-web-share'); ?>
			</h4>
			<?php superwebshare_input_toggle("superwebshare_post_inline_active", "enable", $is_active_general ); ?>
		</div>
		<div class="sws-flex sws-max-500">
			<h4>
				<?php _e('Show Floating share button?', 'super-web-share'); ?>
			</h4>
			<?php superwebshare_input_toggle("superwebshare_post_floating_active", "enable", $is_active_floating); ?>
		</div>
		<div>
			<p class="description">
				<?php _e('If the share button is not showing on the page, kindly please make sure that the Floating amd Inline Content settings are enabled and the respective page type is selected', 'super-web-share'); ?>
			</p>
		</div>
		<?php
	}
}


/**
 * Version check to update the values to the latest version 
 *
 * @since 2.1
 */
function superwebshare_version_update(){
	$superWebShareAdmin = new Super_Web_Share_Admin();
	$superWebShareAdmin->register();

	$current_ver = get_option( 'superwebshare_version' );

	// Return if we have already done this todo
	if ( version_compare( $current_ver, SUPERWEBSHARE_VERSION, '==' ) ) {
		return;
	}

	if ( $current_ver === false ) {
		// Save SuperWebShare version to database.
		add_option( 'superwebshare_version', SUPERWEBSHARE_VERSION );

		if( get_option('superwebshare_settings' ) == false ){
			return;
		}
		
		$settings_floating = get_option( 'superwebshare_floatingsettings' );

		$array_of_post_types = [];

		if( isset( $settings_floating[ 'floating_display_page' ] ) && ( empty( $settings_floating[ 'floating_display_page' ] ) || $settings_floating[ 'floating_display_page' ] == 1 ) ){
			$array_of_post_types[] = 'page';
		}
		if( isset( $settings_floating[ 'floating_display_home' ] ) && ( empty( $settings_floating[ 'floating_display_home' ] ) || $settings_floating[ 'floating_display_home' ] == 1 ) ){
			$array_of_post_types[] = 'home';
		}
		$array_of_post_types[] = 'post';

		update_option( 'superwebshare_floating_settings', [
			'superwebshare_floating_enable' => empty( $settings_floating[ 'superwebshare_floating_enable' ] ) ? 'enable' : $settings_floating[ 'superwebshare_floating_enable' ],
			'floating_share_color' => empty( $settings_floating[ 'floating_share_color' ] ) ? '#BD3854' : $settings_floating[ 'floating_share_color' ],
			'floating_position' => empty( $settings_floating[ 'floating_position' ] ) ? 'right' : $settings_floating[ 'floating_position' ],
			'floating_position_leftright' => empty( $settings_floating[ 'floating_position_leftright' ] ) ? '5' : $settings_floating[ 'floating_position_leftright' ],
			'floating_position_bottom' => empty( $settings_floating[ 'floating_position_bottom' ] ) ? '5' : $settings_floating[ 'floating_position_bottom' ],
			'floating_amp_enable' => empty( $settings_floating[ 'superwebshare_floating_amp_enable' ] ) ? 'enable' : $settings_floating[ 'superwebshare_floating_amp_enable' ],
			'floating_button_text' => 'Share',
			'floating_display_pages' => $array_of_post_types
		] );

		delete_option( 'superwebshare_floatingsettings' ); 


		$settings_inline = get_option( 'superwebshare_settings' );

		$array_of_post_types = [];

		if( isset( $settings_inline[ 'normal_display_page' ] ) && ( empty( $settings_inline[ 'normal_display_page' ] ) || $settings_inline[ 'normal_display_page' ] == 1 ) ){
			$array_of_post_types[] = 'page';
		}

		if( isset( $settings_inline[ 'normal_display_home' ] ) && ( empty( $settings_inline[ 'normal_display_home' ] ) || $settings_inline[ 'normal_display_home' ] == 1 ) ){
			$array_of_post_types[] = 'home';
		}
		$array_of_post_types[] = 'post';

		update_option( 'superwebshare_inline_settings', [
			'inline_button_share_text' => empty( $settings_inline[ 'normal_share_button_text' ] ) ? 'Share' : $settings_inline[ 'normal_share_button_text' ],
			'inline_amp_enable' =>  empty( $settings_inline[ 'superwebshare_normal_amp_enable' ] ) ? 'enable' : $settings_inline[ 'superwebshare_normal_amp_enable' ],
			'inline_button_share_color' =>  empty( $settings_inline[ 'normal_share_color' ] ) ? '#BD3854' : $settings_inline[ 'normal_share_color' ],
			'inline_position' =>  empty( $settings_inline[ 'position' ] ) ? 'before' : $settings_inline[ 'position' ],
			'inline_display_pages' => $array_of_post_types,
			'superwebshare_inline_enable' =>  empty( $settings_inline[ 'superwebshare_normal_enable' ] ) ? 'disable' : $settings_inline[ 'superwebshare_normal_enable' ],
		] );
		delete_option( 'superwebshare_settings' ); 
		
		return;
	}else{

		update_option( 'superwebshare_version', SUPERWEBSHARE_VERSION );

		return;
	}
}
add_action( "admin_init", 'superwebshare_version_update');

/**
 * Get all allowed post types or kind of pages
 *
 * @since 2.1
 */
function superwebshare_get_pages(){

	$post_types_obj = get_post_types( array( 'public' => true, '_builtin' => false ), 'object' );
	$post_types = [];
	foreach( $post_types_obj as $obj ){
		$post_types[ $obj->name ] =  $obj->labels->name ;
	}

	$post_types = array_diff_key ( $post_types, [ 'web-story' => "web", "e-landing-page" => "elementorlandingpage", "elementor_library" => "elementorlibrary" ] ); // exclude post type - web stories, elementor landing page and elementor library

	return  array_merge ( [ 'home' => "Home", 'post' => "Post", 'page' => "Page" ], $post_types );
}

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
    // Floating button Settings page - since 1.4.2
    add_submenu_page( 'superwebshare', __( 'Floating Button - Super Web Share', 'super-web-share' ), __( 'Floating Button', 'super-web-share' ), 'manage_options', 'superwebshare', 'superwebshare_admin_interface_render' );
    // Inline Settings page - Same as main menu page
	add_submenu_page( 'superwebshare', __( 'Inline Content - Super Web Share', 'super-web-share' ), __( 'Inline Content', 'super-web-share' ), 'manage_options', 'superwebshare-inline', 'superwebshare_admin_interface_render' );
	// Fallback Settings page - since 2.0
    add_submenu_page( 'superwebshare', __( 'Fallback - Super Web Share', 'super-web-share' ), __( 'Fallback', 'super-web-share' ), 'manage_options', 'superwebshare-fallback', 'superwebshare_admin_interface_render' );
	//Support - submenu not needed to show
	add_submenu_page( 'superwebshare',  __( 'Appearance', 'super-web-share' ), 'Appearance', 'manage_options', 'superwebshare-appearance', 'superwebshare_admin_interface_render' );
	//Status - submenu
    add_submenu_page( 'superwebshare', __( 'Status - Super Web Share', 'super-web-share' ), __( 'Status', 'super-web-share' ), 'manage_options', 'superwebshare-status', 'superwebshare_status_interface_render' );
	//Support - submenu not needed to show
	add_submenu_page( 'superwebshare',  __( 'Support - Super Web Share', 'super-web-share' ), 'Support', 'manage_options', 'superwebshare-support', 'superwebshare_admin_interface_render',9999 );
	
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
			'settings' => '<a href="' . admin_url( 'admin.php?page=superwebshare' ) . '">' . __( 'Settings', 'super-web-share' ) . '</a>'
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
				'demo' 	=> '<a href="https://superwebshare.com/?utm_source=wordpress-plugin&utm_medium=wordpress-demo" target="_blank">' . __( 'Demo', 'super-web-share' ) . '</a>',
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
 
	// Admin notice for plugin activation
	if ( get_transient( 'superwebshare_admin_notice_activation' ) ) {

	// Admin notice on plugin activation
	// Do not display link to the settings page, if already within the Settings Page
	$screen = get_current_screen();
	$superwebshare_link_text = ( strpos( $screen->id, 'superwebshare' ) === false ) ? sprintf( __( '<a href="%s">Customize your share button settings &rarr;</a>', 'super-web-share' ), admin_url( 'admin.php?page=superwebshare' ) ) : '';
	
	echo '<div class="updated notice is-dismissible"><p>' . __( 'Thank you for installing <strong>Super Web Share</strong> ', 'super-web-share' ) . esc_html( $superwebshare_link_text ) . '</p></div>';
		
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
 * Will redirect to SuperWebShare settings page when plugin is activated.
 * Will not redirect if multiple plugins are activated at the same time.
 * Will not redirect when activated network wide on multisite. Network admins know their way.
 * 
 * @since 1.3
 */
function superwebshare_activation_redirect( $plugin, $network_wide ) {
	// Return if not SuperWebShare or if plugin is activated network wide.
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
	exit( wp_redirect( admin_url( 'admin.php?page=superwebshare' ) ) );
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
		<h1>Status - Super Web Share</h1>
		<?php
			//printf( '<h5>Status</h5>' );
			if ( is_ssl() ) {
				
				printf( '<p><span class="dashicons dashicons-yes" style="color: #46b460;"></span> ' . __( 'Awesome! The website uses HTTPS. SuperWebShare will work perfectly upon your website if you test it over Chrome for Android, Edge for Android, Samsung Internet for Android, Safari for iOS, and Brave for Android, as those are browsers that currently support native web share. Please test out over these browsers and devices once after activating the button you would like to feature.', 'super-web-share' ) . '</p>' );
			} else {
				
				printf( '<p><span class="dashicons dashicons-no-alt" style="color: #dc3235;"></span> ' . __( 'It looks like the website is not served fully via HTTPS. As for supporting the SuperWebShare native share button, your website should be served fully over HTTPS and needs a green padlock upon the address bar. </br>
				 By default, our fallback social share buttons will show the share buttons on the browsers which are not yet supported by native', 'super-web-share' ) . '</p>' );
			}
		?>
	</div>
	<?php
}

/**
 * Inline Settings Register
 *
 * @since 1.0
 */
function superwebshare_register_settings_inline() {
	// Register Setting
	register_setting( 
		'superwebshare_settings_inline_group', 		// Group name
		'superwebshare_inline_settings', 			// Setting name = html form <input> name on settings form
		'superwebshare_validater_and_sanitizer'		// Input sanitizer
	);
	// Above & Below Post Share Settings Options
    add_settings_section(
        'superwebshare_inline_settings_section',				// ID
        __('Inline Content Settings', 'super-web-share'),	// Title
        '__return_false',										// Callback Function
        'superwebshare_inline_settings_section'					// Page slug
	);
			// Description
			add_settings_field(
				'superwebshare_inline_description_share',						// ID
				__('', 'super-web-share'),										// Title
				'superwebshare_inline_description_cb',							// CB
				'superwebshare_inline_settings_section',						// Page slug
				'superwebshare_inline_settings_section'							// Settings Section ID
			);
			// Show Inline Content Share button
			add_settings_field(
				'superwebshare_inline_enable_share',							// ID
				__('Show Inline Content share button', 'super-web-share'),		// Title
				'superwebshare_inline_enable_cb',								// CB
				'superwebshare_inline_settings_section',						// Page slug
				'superwebshare_inline_settings_section'							// Settings Section ID
			);
			// Display settings of Share Button (Inline) Above and Below Post/Page Content
			add_settings_field(
				'superwebshare_inline_display_share',							// ID
				__('Post Types to show Inline share', 'super-web-share'),		// Title
				'superwebshare_inline_display_cb',								// CB
				'superwebshare_inline_settings_section',						// Page slug
				'superwebshare_inline_settings_section'							// Settings Section ID
			);
			// Position of Share Button (Inline)
			add_settings_field(
				'superwebshare_inline_position_share',							// ID
				__('Position of the button', 'super-web-share'),				// Title
				'superwebshare_inline_button_position_cb',						// CB
				'superwebshare_inline_settings_section',						// Page slug
				'superwebshare_inline_settings_section'							// Settings Section ID
			);
			// Text for share button
			add_settings_field(
				'superwebshare_inline_text_share',								// ID
				__('Button text', 'super-web-share'),							// Title
				'superwebshare_inline_button_text_cb',							// CB
				'superwebshare_inline_settings_section',						// Page slug
				'superwebshare_inline_settings_section'							// Settings Section ID
			);
			// Inline Button Color
			add_settings_field(
				'superwebshare_inline_color_share',								// ID
				__('Button color', 'super-web-share'),							// Title
				'superwebshare_inline_button_color_cb',							// CB
				'superwebshare_inline_settings_section',						// Page slug
				'superwebshare_inline_settings_section'							// Settings Section ID
			);

			// Enable/Disable Share Button - AMP (1.4.4)
			add_settings_field(
				'superwebshare_inline_enable_amp_share',						// ID
				__('Show Inline on AMP Pages', 'super-web-share'),				// Title
				'inline_amp_enable_cb',											// CB
				'superwebshare_inline_settings_section',						// Page slug
				'superwebshare_inline_settings_section'							// Settings Section ID
			);
}
add_action( 'admin_init', 'superwebshare_register_settings_inline' );

/** filter with save data
 * @return array
 * Since 2.1
*/
function sws_option_save_with_defaults( $value, $old, $settings ){
	$default = [];
	switch ($settings){
		case "superwebshare_floating_settings":
			$default = superwebshare_settings_default( 'floating' );
			break;
		case "superwebshare_fallback_settings":
			$default = superwebshare_settings_default( 'fallback' );
			break;
		case "superwebshare_inline_settings":
			$default = superwebshare_settings_default( 'inline' );
			break;
	}
	foreach( $default as $key => $val ){
		if( !isset( $value[ $key ] ) ){
			$value[ $key ] = "false";
		}
	}

	return  $value;
}
add_filter( 'pre_update_option_superwebshare_floating_settings', 'sws_option_save_with_defaults',10, 3 );
add_filter( 'pre_update_option_superwebshare_fallback_settings', 'sws_option_save_with_defaults',10, 3 );
add_filter( 'pre_update_option_superwebshare_inline_settings', 'sws_option_save_with_defaults',10, 3 );

function superwebshare_register_settings_floating() {
	// Register Setting
	register_setting( 
		'superwebshare_settings_floating_group', 			// Group name
		'superwebshare_floating_settings', 					// Setting name = html form <input> name on settings form
		'superwebshare_validater_and_sanitizer_floating'	// Input sanitizer
	);
	// Floating Button Settings
    add_settings_section(
        'superwebshare_floating_settings_section',				// ID
        __('Floating Button Settings', 'super-web-share'),	// Title
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
				__('Show Floating share button', 'super-web-share'),			// Title
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
				__('Post Types for Floating button', 'super-web-share'),		// Title
				'superwebshare_floating_display_cb',							// CB
				'superwebshare_floating_settings_section',						// Page slug
				'superwebshare_floating_settings_section'						// Settings Section ID
			);
			// Position of Floating Button
			add_settings_field(
				'superwebshare_floating_position_share',						// ID
				__('Button Position', 'super-web-share'),						// Title
				'superwebshare_floating_position_cb',							// CB
				'superwebshare_floating_settings_section',						// Page slug
				'superwebshare_floating_settings_section'						// Settings Section ID
			);
			// Position from Bottom
			add_settings_field(
				'superwebshare_floating_position_bottom_share',					// ID
				__('Position from bottom', 'super-web-share'),					// Title
				'superwebshare_floating_position_bottom_cb',					// CB
				'superwebshare_floating_settings_section',						// Page slug
				'superwebshare_floating_settings_section'						// Settings Section ID
			);
			// Text for Floating Button (2.1)
			add_settings_field(
				'floating_button_text',											// ID
				__('Button text for Floating button', 'super-web-share'),		// Title
				'superwebshare_floating_button_text_cb',						// CB
				'superwebshare_floating_settings_section',						// Page slug
				'superwebshare_floating_settings_section'						// Settings Section ID
			);
			// Enable/Disable Share Button - AMP (1.4.4)
			add_settings_field(
				'superwebshare_floating_enable_amp_share',						// ID
				__('Show floating on AMP Pages', 'super-web-share'),			// Title
				'floating_amp_enable_cb',										// CB
				'superwebshare_floating_settings_section',						// Page slug
				'superwebshare_floating_settings_section'						// Settings Section ID
			);
}
add_action( 'admin_init', 'superwebshare_register_settings_floating' );

/**
 * Fallback Settings Register
 *
 * @since 2.0
 */
function superwebshare_register_settings_fallback(){
	// Register Setting
	register_setting( 
		'superwebshare_settings_fallback_group', 					// Group name
		'superwebshare_fallback_settings', 							// Setting name = html form <input> name on settings form
		'superwebshare_validater_and_sanitizer_fallback'			// Input sanitizer
	);

	// Floating Button Settings
	add_settings_section(
        'superwebshare_fallback_settings_section',					// ID
        __('Fallback Settings', 'super-web-share'),					// Title
        '__return_false',											// Callback Function
        'superwebshare_fallback_settings_section'					// Page slug
	);

	// Description
	add_settings_field(
		'superwebshare_inline_description_share',					// ID
		__('', 'super-web-share'),									// Title
		'superwebshare_fallback_description_cb',					// CB
		'superwebshare_fallback_settings_section',					// Page slug
		'superwebshare_fallback_settings_section'					// Settings Section ID
	);

	// Since 2.0
	add_settings_field(
		'superwebshare_fallback_enable',							// ID
		__('Show fallback share buttons', 'super-web-share'),	// Title
		'superwebshare_fallback_enable_cb',							// CB
		'superwebshare_fallback_settings_section',					// Page slug
		'superwebshare_fallback_settings_section'					// Settings Section ID
	);

	//Since 2.1  for fallback modal color
	add_settings_field(
		'fallback_modal_background',								// ID
		__('Background color for fallback', 'super-web-share'),		// Title
		'superwebshare_fallback_modal_background_color_cb',			// CB
		'superwebshare_fallback_settings_section',					// Page slug
		'superwebshare_fallback_settings_section'					// Settings Section ID
	);

	//Since 2.1 for layout selection for fallback
	add_settings_field(
		'superwebshare_fallback_modal_layout',						// ID
		__('Fallback layout', 'super-web-share'),					// Title
		'superwebshare_fallback_modal_layout_cb',					// CB
		'superwebshare_fallback_settings_section',					// Page slug
		'superwebshare_fallback_settings_section'					// Settings Section ID
	);

	/**
	 * Since 2.3 for twitter via url parameter
	 * @see https://developer.twitter.com/en/docs/twitter-for-websites/tweet-button/guides/parameter-reference1
	 */

	add_settings_field(
		'fallback_twitter_via',										// ID
		__('Twitter username', 'super-web-share'),					// Title
		'fallback_twitter_via_cb',									// CB
		'superwebshare_fallback_settings_section',					// Page slug
		'superwebshare_fallback_settings_section'					// Settings Section ID
	);

}
add_action( 'admin_init', 'superwebshare_register_settings_fallback' );

/**
 * Appearance Settings Register
 *
 * @since 2.3
 */
function superwebshare_register_settings_appearance(){
	// Register Setting
	register_setting( 
		'superwebshare_settings_appearance_group', 					// Group name
		'superwebshare_appearance_settings', 						// Setting name = html form <input> name on settings form
		'superwebshare_validator_and_sanitizer_appearance'			// Input sanitizer
	);

	// Appearance Settings Section
	add_settings_section(
        'superwebshare_appearance_settings_section',				// ID
        __('Appearance Settings', 'super-web-share'),				// Title
        '__return_false',											// Callback Function
        'superwebshare_appearance_settings_section'					// Page slug
	);

	
	//Since 2.3 for share button icon.
	add_settings_field(
		'superwebshare_appearance_button_icon',						// ID
		__('Button icon', 'super-web-share'),						// Title
		'superwebshare_appearance_icon_cb',							// CB
		'superwebshare_appearance_settings_section',				// Page slug
		'superwebshare_appearance_settings_section'					// Settings Section ID
	);

	//Since 2.3 for share button Style.
	add_settings_field(
		'superwebshare_appearance_button_style',					// ID
		__('Style for share button', 'super-web-share'),			// Title
		'superwebshare_appearance_button_style_cb',					// CB
		'superwebshare_appearance_settings_section',				// Page slug
		'superwebshare_appearance_settings_section'					// Settings Section ID
	);

	//Since 2.3 for share button Size.
	add_settings_field(
		'superwebshare_appearance_button_size',						// ID
		__('Button Size', 'super-web-share'),						// Title
		'superwebshare_appearance_button_size_cb',					// CB
		'superwebshare_appearance_settings_section',				// Page slug
		'superwebshare_appearance_settings_section'					// Settings Section ID
	);

}
add_action( 'admin_init', 'superwebshare_register_settings_appearance' );


/**
 * Inline - Validate and sanitize user input before its saved to database
 *
 * @since 1.0 
 */
function superwebshare_validater_and_sanitizer( $settings ) {
	// Sanitize hex color input for theme_color
	$default = superwebshare_settings_default( 'inline' );
	$settings['inline_button_share_color'] = preg_match( '/#([a-f0-9]{3}){1,2}\b/i', $settings['inline_button_share_color'], $mt ) ? $mt[0] : $default[ 'inline_button_share_color' ];
	$settings['inline_button_share_text'] = ! empty ( sanitize_text_field( $settings['inline_button_share_text'] ) ) ? sanitize_text_field( $settings['inline_button_share_text'] ) : 'Share';
	return $settings;
}

/**
 * Floating - Validate and sanitize user input before its saved to database
 *
 * @since 1.3 
 */
function superwebshare_validater_and_sanitizer_floating( $settings_floating ) {
	// Sanitize hex color input for floating theme_color
	$default = superwebshare_settings_default( 'floating' );
	$settings_floating['floating_share_color'] = preg_match( '/#([a-f0-9]{3}){1,2}\b/', $settings_floating['floating_share_color'], $mt ) ? $mt[0]  : $default[ 'floating_share_color' ];
	$settings_floating[ 'floating_position_button'] = preg_match( '/^[0-9]$/i', isset($settings_floating['floating_position_button']) ) ? sanitize_text_field( $settings_floating['floating_position_button'] ) : '30';
	$settings_floating[ 'floating_button_text' ] = ! empty( sanitize_text_field( $settings_floating[ 'floating_button_text' ] ) )  ? sanitize_text_field( $settings_floating[ 'floating_button_text' ] ) : 'Share';
	return $settings_floating;
}

/**
 * Fallback - Validate and sanitize user input before its saved to database
 *
 * @since 2.0
 */
function superwebshare_validater_and_sanitizer_fallback( $settings_fallback ) {
	// Sanitize hex color input for fallback theme_color
	$default = superwebshare_settings_default( 'fallback' );
	$settings_fallback[ 'fallback_twitter_via' ] = preg_replace('/[^0-9a-zA-Z_]/', '', $settings_fallback[ 'fallback_twitter_via' ] );
	$settings_fallback[ 'fallback_modal_background' ] = preg_match( '/#([a-f0-9]{3}){1,2}\b/i', $settings_fallback['fallback_modal_background'], $mt ) ? $mt[0] : $default['fallback_modal_background'];
	return $settings_fallback;
}

/**
 * Appearance - Validate and sanitize user input before its saved to database
 *
 * @since 2.3
 */
function superwebshare_validator_and_sanitizer_appearance( $settings_appearance ) {
	// Sanitize hex color input for appearance theme_color

	$settings_appearance[ 'superwebshare_appearance_button_icon' ] = sanitize_text_field( $settings_appearance[ 'superwebshare_appearance_button_icon' ] );
	return $settings_appearance;
}

/**
 * Default values for each values
 *
 * @since 	1.0
 * @return	Array	Associative array of default key and values;
 */

function superwebshare_settings_default( $name ){
	$default = [
		"inline" => array(
			'inline_display_pages'			=>	[], 		// allowed post types. is empty allow all
			'inline_position'				=>	'before',   // both = Top and Bottom of the content
			'inline_button_share_text'		=>	'Share',	// content for share button
			'inline_button_share_color'		=>	'#BD3854',	// default color for Inline share button
			'superwebshare_inline_enable'	=>	'disable',	// disabled by default
			'inline_amp_enable' 			=> 'enable' 	// default enable - 1.4.4 amp settings

		),
		"floating" => array(
			'floating_share_color' 			=> '#BD3854', 		// defautlt color
			'floating_display_pages'    	=>  [], 			// allowed post types. is empty allow all
			'floating_position'				=>	'right', 		// left or right
			'floating_position_leftright'	=>	'5', 			// in pixel
			'floating_position_bottom'		=>	'5', 			// in pixel
			'superwebshare_floating_enable'	=>	'enable',		// enable by default
			'floating_amp_enable'			=>	'enable',		// enable by default - 1.4.4
			'floating_button_text'			=> 'Share'   		// default share text - 2.1

		),
		"fallback" => array(
			'superwebshare_fallback_enable' => 'enable', 	// default value - 2.0
			'fallback_modal_background' 	=> '#BD3854',	// default color for fallback modal - 2.1
			'fallback_layout'				=> '1',			// Fallback layout color - 2.1
			'fallback_twitter_via'			=> ''
		),
		"appearance" => array(
			'superwebshare_appearance_button_icon' => 'share-icon-1', 	// default value "share-icon-1"
			'superwebshare_appearance_button_size' => 'lg', 			// default value "lg"
			'superwebshare_appearance_button_style' => 'style-1', 		// default value "style-1"

		),
	];
	return $default[ $name ];
}

/**
 * Get Inline settings from database
 *
 * @since 	1.0.0
 * @return	Array	A merged array of default and settings saved in database.
 */
function superwebshare_get_settings_inline() {
	$defaults = superwebshare_settings_default( 'inline' );
	$settings = get_option( 'superwebshare_inline_settings', $defaults );

	return $settings;
}

/**
 * Get floating settings from database
 *
 * @since 	1.3
 * @return	Array	A merged array of default and settings saved in database.
 */
function superwebshare_get_settings_floating() {
	$defaults = superwebshare_settings_default( 'floating' );
	
	$settings_floating = get_option( 'superwebshare_floating_settings', $defaults );

	return $settings_floating;
}

/**
 * Get Fallback settings from database
 *
 * @since 	2.0
 * @return	Array	A merged array of default and settings saved in database.
 */
function superwebshare_get_settings_fallback() {
	$defaults = superwebshare_settings_default( 'fallback' );
	return get_option( 'superwebshare_fallback_settings', $defaults );
}

/**
 * Get Inline settings from database
 *
 * @since 	2.3
 * @return	Array	A merged array of default and settings saved in database.
 */
function superwebshare_get_settings_appearance() {
	$defaults = superwebshare_settings_default( 'appearance' );
	$settings = get_option( 'superwebshare_appearance_settings', $defaults );

	return $settings;
}