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
 * Updating the version on options when install the plugin.
 *
 * @return void
 * @since 2.1
 */
function superwebshare_version_update() {

	$super_web_share_admin = new Super_Web_Share_Admin();
	$super_web_share_admin->register();

	$current_ver = get_option( 'superwebshare_version' );

	// Return if we have already done this todo.
	if ( version_compare( $current_ver, SUPERWEBSHARE_VERSION, '==' ) ) {
		return;
	}

	if ( false === $current_ver ) {
		// Save SuperWebShare version to database.
		add_option( 'superwebshare_version', SUPERWEBSHARE_VERSION );

		if ( get_option( 'superwebshare_settings' ) === false ) {
			return;
		}

		$settings_floating = get_option( 'superwebshare_floatingsettings' );

		$array_of_post_types = array();

		if ( isset( $settings_floating['floating_display_page'] ) && ( empty( $settings_floating['floating_display_page'] ) || 1 === $settings_floating['floating_display_page'] ) ) {
			$array_of_post_types[] = 'page';
		}
		if ( isset( $settings_floating['floating_display_home'] ) && ( empty( $settings_floating['floating_display_home'] ) || 1 === $settings_floating['floating_display_home'] ) ) {
			$array_of_post_types[] = 'home';
		}
		$array_of_post_types[] = 'post';

		update_option(
			'superwebshare_floating_settings',
			array(
				'superwebshare_floating_enable' => empty( $settings_floating['superwebshare_floating_enable'] ) ? 'enable' : $settings_floating['superwebshare_floating_enable'],
				'floating_share_color'          => empty( $settings_floating['floating_share_color'] ) ? '#BD3854' : $settings_floating['floating_share_color'],
				'floating_position'             => empty( $settings_floating['floating_position'] ) ? 'right' : $settings_floating['floating_position'],
				'floating_position_leftright'   => empty( $settings_floating['floating_position_leftright'] ) ? '5' : $settings_floating['floating_position_leftright'],
				'floating_position_bottom'      => empty( $settings_floating['floating_position_bottom'] ) ? '5' : $settings_floating['floating_position_bottom'],
				'floating_amp_enable'           => empty( $settings_floating['superwebshare_floating_amp_enable'] ) ? 'enable' : $settings_floating['superwebshare_floating_amp_enable'],
				'floating_button_text'          => 'Share',
				'floating_display_pages'        => $array_of_post_types,
			)
		);

		delete_option( 'superwebshare_floatingsettings' );

		$settings_inline = get_option( 'superwebshare_settings' );

		$array_of_post_types = array();

		if ( isset( $settings_inline['normal_display_page'] ) && ( empty( $settings_inline['normal_display_page'] ) || 1 === $settings_inline['normal_display_page'] ) ) {
			$array_of_post_types[] = 'page';
		}

		if ( isset( $settings_inline['normal_display_home'] ) && ( empty( $settings_inline['normal_display_home'] ) || 1 === $settings_inline['normal_display_home'] ) ) {
			$array_of_post_types[] = 'home';
		}
		$array_of_post_types[] = 'post';

		update_option(
			'superwebshare_inline_settings',
			array(
				'inline_button_share_text'    => empty( $settings_inline['normal_share_button_text'] ) ? 'Share' : $settings_inline['normal_share_button_text'],
				'inline_amp_enable'           => empty( $settings_inline['superwebshare_normal_amp_enable'] ) ? 'enable' : $settings_inline['superwebshare_normal_amp_enable'],
				'inline_button_share_color'   => empty( $settings_inline['normal_share_color'] ) ? '#BD3854' : $settings_inline['normal_share_color'],
				'inline_position'             => empty( $settings_inline['position'] ) ? 'before' : $settings_inline['position'],
				'inline_display_pages'        => $array_of_post_types,
				'superwebshare_inline_enable' => empty( $settings_inline['superwebshare_normal_enable'] ) ? 'disable' : $settings_inline['superwebshare_normal_enable'],
			)
		);
		delete_option( 'superwebshare_settings' );

		return;
	} else {

		update_option( 'superwebshare_version', SUPERWEBSHARE_VERSION );

		return;
	}
}
add_action( 'admin_init', 'superwebshare_version_update' );

/**
 * Get all allowed post types or kind of pages
 *
 * @since 2.1
 */
function superwebshare_get_pages() {

	$post_types_obj = get_post_types(
		array(
			'public'   => true,
			'_builtin' => false,
		),
		'object'
	);
	$post_types     = array();
	foreach ( $post_types_obj as $obj ) {
		$post_types[ $obj->name ] = $obj->labels->name;
	}

	$post_types = array_diff_key(
		$post_types,
		array(
			'web-story'         => 'web',
			'e-landing-page'    => 'elementorlandingpage',
			'elementor_library' => 'elementorlibrary',
		)
	); // exclude post type - web stories, elementor landing page and elementor library.

	return array_merge(
		array(
			'home' => 'Home',
			'post' => 'Post',
			'page' => 'Page',
		),
		$post_types
	);
}

/**
 * Admin page file addition.
 *
 * @return void
 */
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

	// Main menu page --  superwebshare_options_page earlier.
	add_menu_page( __( 'Super Web Share', 'super-web-share' ), __( 'Super Web Share', 'super-web-share' ), 'manage_options', 'superwebshare', 'superwebshare_admin_interface_render', 'dashicons-share', 100 );
	// Floating button Settings page - since 1.4.2.
	add_submenu_page( 'superwebshare', __( 'Floating Button - Super Web Share', 'super-web-share' ), __( 'Floating Button', 'super-web-share' ), 'manage_options', 'superwebshare', 'superwebshare_admin_interface_render' );
	// Inline Settings page - Same as main menu page.
	add_submenu_page( 'superwebshare', __( 'Inline Content - Super Web Share', 'super-web-share' ), __( 'Inline Content', 'super-web-share' ), 'manage_options', 'superwebshare-inline', 'superwebshare_admin_interface_render' );
	// Fallback Settings page - since 2.0.
	add_submenu_page( 'superwebshare', __( 'Fallback - Super Web Share', 'super-web-share' ), __( 'Fallback', 'super-web-share' ), 'manage_options', 'superwebshare-fallback', 'superwebshare_admin_interface_render' );
	// Support - submenu not needed to show.
	add_submenu_page( 'superwebshare', __( 'Appearance', 'super-web-share' ), 'Appearance', 'manage_options', 'superwebshare-appearance', 'superwebshare_admin_interface_render' );
	// Status - submenu.
	add_submenu_page( 'superwebshare', __( 'Status - Super Web Share', 'super-web-share' ), __( 'Status', 'super-web-share' ), 'manage_options', 'superwebshare-status', 'superwebshare_status_interface_render' );
	// Support - submenu not needed to show.
	add_submenu_page( 'superwebshare', __( 'Support - Super Web Share', 'super-web-share' ), 'Support', 'manage_options', 'superwebshare-support', 'superwebshare_admin_interface_render', 9999 );
}
add_action( 'admin_menu', 'superwebshare_add_menu_links' );

/**
 * Add Settings link to Plugin Page's Row.
 *
 * @param  array $links links of array.
 * @since 1.0.0
 */
function superwebshare_plugin_row_settings_link( $links ) {

	return array_merge(
		array(
			'settings' => '<a href="' . admin_url( 'admin.php?page=superwebshare' ) . '">' . __( 'Settings', 'super-web-share' ) . '</a>',
		),
		$links
	);
}
add_filter( 'plugin_action_links_super-web-share/super-web-share.php', 'superwebshare_plugin_row_settings_link' );

/**
 * Add Demo link on to WordPress Plugin page row.
 *
 * @param  mixed $links Link tag of demo.
 * @param  mixed $file Plugin file name.
 * @return array
 * @since 1.0.0
 */
function superwebshare_plugin_row_meta( $links, $file ) {

	if ( strpos( $file, 'super-web-share.php' ) !== false ) {
		$new_links = array(
			'demo' => '<a href="https://superwebshare.com/?utm_source=wordpress-plugin&utm_medium=wordpress-demo" target="_blank">' . __( 'Demo', 'super-web-share' ) . '</a>',
		);
		$links     = array_merge( $links, $new_links );
	}

	return $links;
}
add_filter( 'plugin_row_meta', 'superwebshare_plugin_row_meta', 10, 2 );

/**
 * Show notices in admin area.
 *
 * @since    1.4.2
 * @return void
 */
function superwebshare_admin_notice_activation() {

	// Admin notice for plugin activation.
	if ( get_transient( 'superwebshare_admin_notice_activation' ) ) {

		// Admin notice on plugin activation
		// Do not display link to the settings page, if already within the Settings Page.
		$screen                  = get_current_screen();
		$superwebshare_link_text = ( strpos( $screen->id, 'superwebshare' ) === false ) ? sprintf( __( '<a href="%s">Customize your share button settings &rarr;</a>', 'super-web-share' ), admin_url( 'admin.php?page=superwebshare' ) ) : ''; // phpcs:ignore WordPress.WP.I18n.MissingTranslatorsComment

		echo '<div class="updated notice is-dismissible"><p>' . __( 'Thank you for installing <strong>Super Web Share</strong> ', 'super-web-share' ) . esc_html( $superwebshare_link_text ) . '</p></div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		// Delete transient.
		delete_transient( 'superwebshare_admin_notice_activation' );
	}
	if ( get_transient( 'superwebshare_admin_notice_upgrade_complete' ) ) {

		echo '<div class="updated notice is-dismissible"><p>' . sprintf( __( '<strong>Super Web Share</strong>: Successfully updated to the latest version.' ), 'super-web-share' ) . '</p></div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		// Delete transient.
		delete_transient( 'superwebshare_admin_notice_upgrade_complete' );
	}
}
add_action( 'admin_notices', 'superwebshare_admin_notice_activation' );

/**
 * Admin footer text.
 *
 * @since   1.0.0
 * @param  string $default_text Default value of WordPress admin footer.
 * @return string
 */
function superwebshare_footer_text( $default_text ) {
	// Retun default on non-plugin pages.
	$screen = get_current_screen();
	if ( strpos( $screen->id, 'superwebshare' ) === false ) {
		return $default_text;
	}
	$superwebshare_footer_text = sprintf(
		__(
			'Thank you for using Super Web Share :) If you like it, please leave <a href="https://wordpress.org/support/plugin/super-web-share/reviews/?rate=5#new-post" target="_blank">a ★★★★★ rating </a> to support us on WordPress.org to help us spread the word to the community. Thanks a lot!  
		</li>',
			'super-web-share'
		),
		'https://superwebshare.com'
	);
	return $superwebshare_footer_text;
}
add_filter( 'admin_footer_text', 'superwebshare_footer_text' );

/**
 * Admin footer version.
 *
 * @since   1.0.0
 * @param  string $default_text The text of footer.
 * @return string
 */
function superwebshare_footer_version( $default_text ) {
	// Return default on non-plugin pages.
	$screen = get_current_screen();
	if ( strpos( $screen->id, 'superwebshare' ) === false ) {
		return $default_text;
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
 * @param  mixed $plugin plugin object.
 * @param  mixed $network_wide the flag for network wide.
 * @return void|boolean
 *
 * @since 1.3
 */
function superwebshare_activation_redirect( $plugin, $network_wide ) {
	// Return if not SuperWebShare or if plugin is activated network wide.
	if ( plugin_basename( SUPERWEBSHARE_PLUGIN_FILE ) !== $plugin || true === $network_wide ) {
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
	if ( 'activate' !== $current_action ) {
		return false;
	}
	// Redirect to Super Web Share settings page.
	$url = admin_url( 'admin.php?page=superwebshare' );
	wp_safe_redirect( $url );
	exit();
}
add_action( 'activated_plugin', 'superwebshare_activation_redirect', PHP_INT_MAX, 2 );

/**
 * HTTPS Status Checker
 *
 * @since 1.0
 */
function superwebshare_status_interface_render() {
	// Check permission.
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	?>
	
	<div class="wrap">	
		<h1>Status - Super Web Share</h1>
		<?php
		if ( is_ssl() ) {

			printf( '<p><span class="dashicons dashicons-yes" style="color: #46b460;"></span> ' . esc_html__( 'Awesome! The website uses HTTPS. SuperWebShare will work perfectly upon your website if you test it over Chrome for Android, Edge for Android, Samsung Internet for Android, Safari for iOS, and Brave for Android, as those are browsers that currently support native web share. Please test out over these browsers and devices once after activating the button you would like to feature.', 'super-web-share' ) . '</p>' );
		} else {

			printf(
				'<p><span class="dashicons dashicons-no-alt" style="color: #dc3235;"></span> ' . __( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					'It looks like the website is not served fully via HTTPS. As for supporting the SuperWebShare native share button, your website should be served fully over HTTPS and needs a green padlock upon the address bar. </br>
				 By default, our fallback social share buttons will show the share buttons on the browsers which are not yet supported by native',
					'super-web-share'
				) . '</p>'
			);
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
	// Register Setting.
	register_setting(
		'superwebshare_settings_inline_group',                                  // Group name.
		'superwebshare_inline_settings',                                        // Setting name = html form <input> name on settings form.
		'superwebshare_validater_and_sanitizer'                                 // Input sanitizer.
	);
	// Above & Below Post Share Settings Options.
	add_settings_section(
		'superwebshare_inline_settings_section',                                // ID.
		__( 'Inline Content Settings', 'super-web-share' ),                     // Title.
		'__return_false',                                                       // Callback Function.
		'superwebshare_inline_settings_section'                                 // Page slug.
	);
			// Description.
			add_settings_field(
				'superwebshare_inline_description_share',                       // ID.
				'',                                                             // Title.
				'superwebshare_inline_description_cb',                          // CB.
				'superwebshare_inline_settings_section',                        // Page slug.
				'superwebshare_inline_settings_section'                         // Settings Section ID.
			);
			// Show Inline Content Share button.
			add_settings_field(
				'superwebshare_inline_enable_share',                            // ID.
				__( 'Show Inline Content share button', 'super-web-share' ),    // Title.
				'superwebshare_inline_enable_cb',                               // CB.
				'superwebshare_inline_settings_section',                        // Page slug.
				'superwebshare_inline_settings_section'                         // Settings Section ID.
			);
			// Display settings of Share Button (Inline) Above and Below Post/Page Content.
			add_settings_field(
				'superwebshare_inline_display_share',                           // ID.
				__( 'Post Types to show Inline share', 'super-web-share' ),     // Title.
				'superwebshare_inline_display_cb',                              // CB.
				'superwebshare_inline_settings_section',                        // Page slug.
				'superwebshare_inline_settings_section'                         // Settings Section ID.
			);
			// Position of Share Button (Inline).
			add_settings_field(
				'superwebshare_inline_position_share',                          // ID.
				__( 'Position of the button', 'super-web-share' ),              // Title.
				'superwebshare_inline_button_position_cb',                      // CB.
				'superwebshare_inline_settings_section',                        // Page slug.
				'superwebshare_inline_settings_section'                         // Settings Section ID.
			);
			// Text for share button.
			add_settings_field(
				'superwebshare_inline_text_share',                              // ID.
				__( 'Button text', 'super-web-share' ),                         // Title.
				'superwebshare_inline_button_text_cb',                          // CB.
				'superwebshare_inline_settings_section',                        // Page slug.
				'superwebshare_inline_settings_section'                         // Settings Section ID.
			);
			// Inline Button Color.
			add_settings_field(
				'superwebshare_inline_color_share',                             // ID.
				__( 'Button color', 'super-web-share' ),                        // Title.
				'superwebshare_inline_button_color_cb',                         // CB.
				'superwebshare_inline_settings_section',                        // Page slug.
				'superwebshare_inline_settings_section'                         // Settings Section ID.
			);

			// Enable/Disable Share Button - AMP (1.4.4).
			add_settings_field(
				'superwebshare_inline_enable_amp_share',                        // ID.
				__( 'Show Inline on AMP Pages', 'super-web-share' ),            // Title.
				'inline_amp_enable_cb',                                         // CB.
				'superwebshare_inline_settings_section',                        // Page slug.
				'superwebshare_inline_settings_section'                         // Settings Section ID.
			);
}
add_action( 'admin_init', 'superwebshare_register_settings_inline' );

/**
 * Filter with save data.
 *
 * @param  array $value The Default value.
 * @param  mixed $old the old vale of option.
 * @param  mixed $settings WordPress settings.
 * @return array
 */
function sws_option_save_with_defaults( $value, $old, $settings ) {
	$default = array();
	switch ( $settings ) {
		case 'superwebshare_floating_settings':
			$default = superwebshare_settings_default( 'floating' );
			break;
		case 'superwebshare_fallback_settings':
			$default = superwebshare_settings_default( 'fallback' );
			break;
		case 'superwebshare_inline_settings':
			$default = superwebshare_settings_default( 'inline' );
			break;
	}
	foreach ( $default as $key => $val ) {
		if ( ! isset( $value[ $key ] ) ) {
			$value[ $key ] = 'false';
		}
	}

	return $value;
}
add_filter( 'pre_update_option_superwebshare_floating_settings', 'sws_option_save_with_defaults', 10, 3 );
add_filter( 'pre_update_option_superwebshare_fallback_settings', 'sws_option_save_with_defaults', 10, 3 );
add_filter( 'pre_update_option_superwebshare_inline_settings', 'sws_option_save_with_defaults', 10, 3 );

/**
 * Register the settings for floating.
 *
 * @return void
 */
function superwebshare_register_settings_floating() {
	// Register Setting.
	register_setting(
		'superwebshare_settings_floating_group',                                // Group name.
		'superwebshare_floating_settings',                                      // Setting name = html form <input> name on settings form.
		'superwebshare_validater_and_sanitizer_floating'                        // Input sanitizer.
	);
	// Floating Button Settings.
	add_settings_section(
		'superwebshare_floating_settings_section',                              // ID.
		__( 'Floating Button Settings', 'super-web-share' ),                    // Title.
		'__return_false',                                                       // Callback Function.
		'superwebshare_floating_settings_section'                               // Page slug.
	);
			// Description.
			add_settings_field(
				'superwebshare_floating_description_share',                     // ID.
				'',                                                             // Title.
				'superwebshare_floating_description_cb',                        // CB.
				'superwebshare_floating_settings_section',                      // Page slug.
				'superwebshare_floating_settings_section'                       // Settings Section ID.
			);
			// Enable/Disable the floating share button.
			add_settings_field(
				'superwebshare_floating_enable_share',                          // ID.
				__( 'Show Floating share button', 'super-web-share' ),          // Title.
				'superwebshare_floating_enable_cb',                             // CB.
				'superwebshare_floating_settings_section',                      // Page slug.
				'superwebshare_floating_settings_section'                       // Settings Section ID.
			);
			// Floating Button color.
			add_settings_field(
				'superwebshare_floating_color_share',                           // ID.
				__( 'Button color', 'super-web-share' ),                        // Title.
				'superwebshare_floating_color_cb',                              // CB.
				'superwebshare_floating_settings_section',                      // Page slug.
				'superwebshare_floating_settings_section'                       // Settings Section ID.
			);
			// Floating Display Pages.
			add_settings_field(
				'superwebshare_floating_display_share',                         // ID.
				__( 'Post Types for Floating button', 'super-web-share' ),      // Title.
				'superwebshare_floating_display_cb',                            // CB.
				'superwebshare_floating_settings_section',                      // Page slug.
				'superwebshare_floating_settings_section'                       // Settings Section ID.
			);
			// Position of Floating Button.
			add_settings_field(
				'superwebshare_floating_position_share',                        // ID.
				__( 'Button Position', 'super-web-share' ),                     // Title.
				'superwebshare_floating_position_cb',                           // CB.
				'superwebshare_floating_settings_section',                      // Page slug.
				'superwebshare_floating_settings_section'                       // Settings Section ID.
			);
			// Text for Floating Button (2.1).
			add_settings_field(
				'floating_button_text',                                         // ID.
				__( 'Button text for Floating button', 'super-web-share' ),     // Title.
				'superwebshare_floating_button_text_cb',                        // CB.
				'superwebshare_floating_settings_section',                      // Page slug.
				'superwebshare_floating_settings_section'                       // Settings Section ID.
			);
			// Enable/Disable Share Button - AMP (1.4.4).
			add_settings_field(
				'superwebshare_floating_enable_amp_share',                      // ID.
				__( 'Show floating on AMP Pages', 'super-web-share' ),          // Title.
				'floating_amp_enable_cb',                                       // CB.
				'superwebshare_floating_settings_section',                      // Page slug.
				'superwebshare_floating_settings_section'                       // Settings Section ID.
			);
}
add_action( 'admin_init', 'superwebshare_register_settings_floating' );

/**
 * Fallback Settings Register
 *
 * @since 2.0
 */
function superwebshare_register_settings_fallback() {
	// Register Setting.
	register_setting(
		'superwebshare_settings_fallback_group',                                // Group name.
		'superwebshare_fallback_settings',                                      // Setting name = html form <input> name on settings form.
		'superwebshare_validater_and_sanitizer_fallback'                        // Input sanitizer.
	);

	// Floating Button Settings.
	add_settings_section(
		'superwebshare_fallback_settings_section',                              // ID.
		__( 'Fallback Settings', 'super-web-share' ),                           // Title.
		'__return_false',                                                       // Callback Function.
		'superwebshare_fallback_settings_section'                               // Page slug.
	);

	// Fall-back social media icons.
	add_settings_field(
		'fallback_social_networks',                               // ID.
		__( 'Choose Social Platforms', 'super-web-share' ),                     // Title.
		'superwebshare_fallback_social_networks_cb',                            // CB.
		'superwebshare_fallback_settings_section',                              // Page slug.
		'superwebshare_fallback_settings_section'                               // Settings Section ID.
	);

	// Description.
	add_settings_field(
		'superwebshare_inline_description_share',                               // ID.
		'',                                                                     // Title.
		'superwebshare_fallback_description_cb',                                // CB.
		'superwebshare_fallback_settings_section',                              // Page slug.
		'superwebshare_fallback_settings_section'                               // Settings Section ID.
	);

	// Since 2.0.
	add_settings_field(
		'superwebshare_fallback_enable',                                        // ID.
		__( 'Show fallback share buttons', 'super-web-share' ),                 // Title.
		'superwebshare_fallback_enable_cb',                                     // CB.
		'superwebshare_fallback_settings_section',                              // Page slug.
		'superwebshare_fallback_settings_section'                               // Settings Section ID.
	);

	// Option to change the fallback popup title - Since 2.4.
	add_settings_field(
		'superwebshare_fallback_title',                                         // ID.
		__( 'Title for fallback modal', 'super-web-share' ),                    // Title.
		'superwebshare_fallback_title_cb',                                      // CB.
		'superwebshare_fallback_settings_section',                              // Page slug.
		'superwebshare_fallback_settings_section'                               // Settings Section ID.
	);

	// Since 2.1  for fallback modal color.
	add_settings_field(
		'fallback_modal_background',                                            // ID.
		__( 'Background color for fallback', 'super-web-share' ),               // Title.
		'superwebshare_fallback_modal_background_color_cb',                     // CB.
		'superwebshare_fallback_settings_section',                              // Page slug.
		'superwebshare_fallback_settings_section'                               // Settings Section ID.
	);

	// Since 2.1 for layout selection for fallback.
	add_settings_field(
		'superwebshare_fallback_modal_layout',                                  // ID.
		__( 'Fallback layout', 'super-web-share' ),                             // Title.
		'superwebshare_fallback_modal_layout_cb',                               // CB.
		'superwebshare_fallback_settings_section',                              // Page slug.
		'superwebshare_fallback_settings_section'                               // Settings Section ID.
	);

	// Since 2.4 - Color settings for the Fallback text.
	add_settings_field(
		'superwebshare_fallback_text_color',                                    // ID.
		__( 'Fallback text color', 'super-web-share' ),                         // Title.
		'superwebshare_fallback_text_color_cb',                                 // CB.
		'superwebshare_fallback_settings_section',                              // Page slug.
		'superwebshare_fallback_settings_section'                               // Settings Section ID.
	);

	// Since 2.4 - Disable native share on desktop to forcefully show the fallback.
	add_settings_field(
		'superwebshare_fallback_show_fallback',                                 // ID.
		__( 'Show the fallback modal on the desktop devices?', 'super-web-share' ),           // Title.
		'superwebshare_fallback_show_fallback_cb',                              // CB.
		'superwebshare_fallback_settings_section',                              // Page slug.
		'superwebshare_fallback_settings_section'                               // Settings Section ID.
	);

	/**
	 * Since 2.3 for twitter via url parameter.
	 *
	 * @see https://developer.twitter.com/en/docs/twitter-for-websites/tweet-button/guides/parameter-reference1
	 */

	add_settings_field(
		'fallback_twitter_via',                                                 // ID.
		__( 'X.com (Twitter) username', 'super-web-share' ),                    // Title.
		'fallback_twitter_via_cb',                                              // CB.
		'superwebshare_fallback_settings_section',                              // Page slug.
		'superwebshare_fallback_settings_section'                               // Settings Section ID.
	);
}
add_action( 'admin_init', 'superwebshare_register_settings_fallback' );

/**
 * Appearance Settings Register
 *
 * @since 2.3
 */
function superwebshare_register_settings_appearance() {
	// Register Setting.
	register_setting(
		'superwebshare_settings_appearance_group',                              // Group name.
		'superwebshare_appearance_settings',                                    // Setting name = html form <input> name on settings form.
		'superwebshare_validator_and_sanitizer_appearance'                      // Input sanitizer.
	);

	// Appearance Settings Section.
	add_settings_section(
		'superwebshare_appearance_settings_section',                            // ID.
		__( 'Appearance Settings', 'super-web-share' ),                         // Title.
		'__return_false',                                                       // Callback Function.
		'superwebshare_appearance_settings_section'                             // Page slug.
	);

	// Description.
	add_settings_field(
		'superwebshare_appearance_description_share',                           // ID.
		'',                                                                     // Title.
		'superwebshare_appearance_description_cb',                              // CB.
		'superwebshare_appearance_settings_section',                            // Page slug.
		'superwebshare_appearance_settings_section'                             // Settings Section ID.
	);

	// Since 2.3 for share button icon.
	add_settings_field(
		'superwebshare_appearance_button_icon',                                 // ID.
		__( 'Button icon', 'super-web-share' ),                                 // Title.
		'superwebshare_appearance_icon_cb',                                     // CB.
		'superwebshare_appearance_settings_section',                            // Page slug.
		'superwebshare_appearance_settings_section'                             // Settings Section ID.
	);

	// Since 2.3 for share button Style.
	add_settings_field(
		'superwebshare_appearance_button_style',                                // ID.
		__( 'Style for share button', 'super-web-share' ),                      // Title.
		'superwebshare_appearance_button_style_cb',                             // CB.
		'superwebshare_appearance_settings_section',                            // Page slug.
		'superwebshare_appearance_settings_section'                             // Settings Section ID.
	);

	// Since 2.4 for Share button text and icon color.
	add_settings_field(
		'superwebshare_appearance_button_text_color',                           // ID.
		__( 'Text color for the button', 'super-web-share' ),                   // Title.
		'superwebshare_appearance_button_text_color_cb',                        // CB.
		'superwebshare_appearance_settings_section',                            // Page slug.
		'superwebshare_appearance_settings_section'                             // Settings Section ID.
	);

	// Since 2.3 for share button Size.
	add_settings_field(
		'superwebshare_appearance_button_size',                                 // ID.
		__( 'Button Size', 'super-web-share' ),                                 // Title.
		'superwebshare_appearance_button_size_cb',                              // CB.
		'superwebshare_appearance_settings_section',                            // Page slug.
		'superwebshare_appearance_settings_section'                             // Settings Section ID.
	);
}
add_action( 'admin_init', 'superwebshare_register_settings_appearance' );


/**
 * Inline - Validate and sanitize user input before its saved to database.
 *
 * @since 1.0
 * @param  array $settings controlls settings.
 * @return array
 */
function superwebshare_validater_and_sanitizer( $settings ) {
	// Sanitize hex color input for theme_color.
	$default                               = superwebshare_settings_default( 'inline' );
	$settings['inline_button_share_color'] = preg_match( '/#([a-f0-9]{3}){1,2}\b/i', $settings['inline_button_share_color'], $mt ) ? $mt[0] : $default['inline_button_share_color'];
	$settings['inline_button_share_text']  = ! empty( sanitize_text_field( $settings['inline_button_share_text'] ) ) ? sanitize_text_field( $settings['inline_button_share_text'] ) : 'Share';

	foreach ( $settings as $key => $value ) {

		if ( is_array( $value ) ) {
			$settings[ $key ] = array_map( 'sanitize_text_field', $value );
			continue;
		}

		$settings[ $key ] = sanitize_text_field( $value );
	}

	return $settings;
}

/**
 * Floating - Validate and sanitize user input before its saved to database.
 *
 * @since 1.3
 * @param  array $settings_floating controls settings.
 * @return array
 */
function superwebshare_validater_and_sanitizer_floating( $settings_floating ) {
	// Sanitize hex color input for floating theme_color.
	$default                                       = superwebshare_settings_default( 'floating' );
	$settings_floating['floating_share_color']     = preg_match( '/#([a-f0-9]{3}){1,2}\b/', $settings_floating['floating_share_color'], $mt ) ? $mt[0] : $default['floating_share_color'];
	$settings_floating['floating_position_button'] = preg_match( '/^[0-9]$/i', isset( $settings_floating['floating_position_button'] ) ) ? sanitize_text_field( $settings_floating['floating_position_button'] ) : '30';
	$settings_floating['floating_button_text']     = ! empty( sanitize_text_field( $settings_floating['floating_button_text'] ) ) ? sanitize_text_field( $settings_floating['floating_button_text'] ) : 'Share';

	foreach ( $settings_floating as $key => $value ) {

		if ( is_array( $value ) ) {
			$settings_floating[ $key ] = array_map( 'sanitize_text_field', $value );
			continue;
		}

		$settings_floating[ $key ] = sanitize_text_field( $value );
	}

	return $settings_floating;
}

/**
 * Fallback - Validate and sanitize user input before its saved to database.
 *
 * @since 2.0
 * @param  array $settings_fallback settings array.
 * @return array
 */
function superwebshare_validater_and_sanitizer_fallback( $settings_fallback ) {
	// Sanitize hex color input for fallback theme_color.
	$default                                        = superwebshare_settings_default( 'fallback' );
	$settings_fallback['fallback_twitter_via']      = preg_replace( '/[^0-9a-zA-Z_]/', '', $settings_fallback['fallback_twitter_via'] );
	$settings_fallback['fallback_modal_background'] = preg_match( '/#([a-f0-9]{3}){1,2}\b/i', $settings_fallback['fallback_modal_background'], $mt ) ? $mt[0] : $default['fallback_modal_background'];
	$settings_fallback['fallback_title']            = ! empty( sanitize_text_field( $settings_fallback['fallback_title'] ) ) ? sanitize_text_field( $settings_fallback['fallback_title'] ) : 'Share';
	$settings_fallback['fallback_text_color']       = preg_match( '/#([a-f0-9]{3}){1,2}\b/i', $settings_fallback['fallback_text_color'], $mt ) ? $mt[0] : $default['fallback_text_color'];
	$settings_fallback['fallback_social_networks']  = empty( $settings_fallback['fallback_social_networks'] ) ? $default['fallback_social_networks'] : $settings_fallback['fallback_social_networks'];

	foreach ( $settings_fallback as $key => $value ) {

		if ( is_array( $value ) ) {
			$settings_fallback[ $key ] = array_map( 'sanitize_text_field', $value );
			continue;
		}

		$settings_fallback[ $key ] = sanitize_text_field( $value );
	}

	return $settings_fallback;
}

/**
 * Appearance - Validate and sanitize user input before its saved to database.
 *
 * @since 2.3
 * @param  array $settings_appearance controls settings.
 * @return array
 */
function superwebshare_validator_and_sanitizer_appearance( $settings_appearance ) {
	// Sanitize hex color input for appearance theme_color.
	$default = superwebshare_settings_default( 'appearance' );

	$settings_appearance['superwebshare_appearance_button_text_color'] = preg_match( '/#([a-f0-9]{3}){1,2}\b/i', $settings_appearance['superwebshare_appearance_button_text_color'], $mt ) ? $mt[0] : $default['superwebshare_appearance_button_text_color'];

	foreach ( $settings_appearance as $key => $value ) {

		if ( is_array( $value ) ) {
			$settings_appearance[ $key ] = array_map( 'sanitize_text_field', $value );
			continue;
		}

		$settings_appearance[ $key ] = sanitize_text_field( $value );
	}

	return $settings_appearance;
}

/**
 * Default values for each values.
 *
 * @since   1.0
 * @param  mixed $name name of settings.
 * @return array
 */
function superwebshare_settings_default( $name ) {
	$default = array(
		'inline'     => array(
			'inline_display_pages'        => array(),           // allowed post types. is empty allow all.
			'inline_position'             => 'before',          // both = Top and Bottom of the content.
			'inline_button_share_text'    => 'Share',           // content for share button.
			'inline_button_share_color'   => '#BD3854',         // default color for Inline share button.
			'superwebshare_inline_enable' => 'disable',         // disabled by default.
			'inline_amp_enable'           => 'enable',          // default enable - 1.4.4 amp settings.

		),
		'floating'   => array(
			'floating_share_color'          => '#BD3854',       // default color.
			'floating_display_pages'        => array(),         // allowed post types. is empty allow all.
			'floating_position'             => 'right',         // left or right.
			'floating_position_leftright'   => '5',             // in pixel.
			'floating_position_bottom'      => '5',             // in pixel.
			'superwebshare_floating_enable' => 'enable',        // enable by default.
			'floating_amp_enable'           => 'enable',        // enable by default - 1.4.4.
			'floating_button_text'          => 'Share',         // default share text - 2.1.

		),
		'fallback'   => array(
			'superwebshare_fallback_enable' => 'enable',        // default value - 2.0.
			'fallback_title'                => 'Share',         // default value - Share for the popup title.
			'fallback_modal_background'     => '#BD3854',       // default color for fallback modal - 2.1.
			'fallback_layout'               => '1',             // fallback layout color - 2.1.
			'fallback_twitter_via'          => '',              // default value none.
			'fallback_text_color'           => '#ffffff',       // default color #fff.
			'fallback_show_in_desktop'      => 'disable',       // default value as disable to trigger based on API support - 2.4.
			'fallback_social_networks'      => array( 'facebook', 'twitter', 'linkedin', 'whatsapp' ),
		),
		'appearance' => array(
			'superwebshare_appearance_button_icon'       => 'share-icon-1',     // default value "share-icon-1".
			'superwebshare_appearance_button_size'       => 'lg',               // default value "lg".
			'superwebshare_appearance_button_style'      => 'default',          // default value "default", which is style 1.
			'superwebshare_appearance_button_text_color' => '#ffffff',          // default value as #ffffff, as we output the text color as white.

		),
	);
	return $default[ $name ];
}

/**
 * Get Inline settings from database
 *
 * @since   1.0.0
 * @return  Array   A merged array of default and settings saved in database.
 */
function superwebshare_get_settings_inline() {
	$defaults = superwebshare_settings_default( 'inline' );
	$settings = get_option( 'superwebshare_inline_settings', $defaults );

	return $settings;
}

/**
 * Get floating settings from database
 *
 * @since   1.3
 * @return  Array   A merged array of default and settings saved in database.
 */
function superwebshare_get_settings_floating() {
	$defaults = superwebshare_settings_default( 'floating' );

	$settings_floating = get_option( 'superwebshare_floating_settings', $defaults );

	return $settings_floating;
}

/**
 * Get Fallback settings from database
 *
 * @since   2.0
 * @return  Array   A merged array of default and settings saved in database.
 */
function superwebshare_get_settings_fallback() {
	$defaults = superwebshare_settings_default( 'fallback' );
	$data     = get_option( 'superwebshare_fallback_settings', $defaults );
	return wp_parse_args( $data, $defaults );
}

/**
 * Get Inline settings from database
 *
 * @since   2.3
 * @return  Array   A merged array of default and settings saved in database.
 */
function superwebshare_get_settings_appearance() {
	$defaults = superwebshare_settings_default( 'appearance' );
	$settings = get_option( 'superwebshare_appearance_settings', $defaults );

	return $settings;
}



/**
 * The admin Ajax function to get the SVG icons. it return the SVGs as JSON on the request.
 *
 * @return void
 */
function api_get_icons() {

	header( 'Content-Type: application/json' );

	$icons = new Super_Web_Share_Icons();

	echo wp_json_encode( $icons->get_icons( 'share' ) );

	wp_die();
}

add_action( 'wp_ajax_sws_get_icons', 'api_get_icons' );

/**
 * The admin Ajax function to get the SVG icons. it return the SVGs as JSON on the request.
 *
 * The link parameter in each network supports placeholders and it will replaced on JavaScript at the time when user clicks the social icon on the pop-up. supported placeholders are following.
 * {url} : the current URL or other which added on Short-code.
 * {title} : The Title of share or the Website title.
 * {nl} : New Line, help we can add new line if required.
 *
 * @return array
 */
function sws_get_social_networks() {

	$networks = array(
		'facebook'  => array(
			'name'  => __( 'Facebook', 'super-web-share' ),
			'icon'  => 'icon-facebook',
			'link'  => 'https://www.facebook.com/sharer/sharer.php?u={url}',
			'color' => '#3a579a',
		),
		'twitter'   => array(
			'name'  => __( 'Twitter', 'super-web-share' ),
			'icon'  => 'icon-twitter',
			'link'  => 'http://twitter.com/share?text={title}&url={url}',
			'color' => '#000',
		),
		'whatsapp'  => array(
			'name'  => __( 'WhatsApp', 'super-web-share' ),
			'icon'  => 'icon-whatsapp',
			'link'  => 'https://api.whatsapp.com/send?text={title}{nl}{nl}{url}',
			'color' => '#25d366',
		),
		'linkedin'  => array(
			'name'  => __( 'LinkedIn', 'super-web-share' ),
			'icon'  => 'icon-linkedin',
			'link'  => 'https://www.linkedin.com/sharing/share-offsite?url={url}',
			'color' => '#0077b5',
		),
		'pinterest' => array(
			'name'  => __( 'Pinterest', 'super-web-share' ),
			'icon'  => 'icon-pinterest',
			'link'  => 'https://www.pinterest.com/pin/create/bookmarklet/?url={url}&pinFave=1&color=%238fbfb3&h=237&w=237&description={title}',
			'color' => '#c92228',
		),
		'telegram'  => array(
			'name'  => __( 'Telegram', 'super-web-share' ),
			'icon'  => 'icon-telegram',
			'link'  => 'https://t.me/share/url?url={url}&text={title}',
			'color' => '#29b7f6',
		),
		'mail'      => array(
			'name'  => __( 'Mail', 'super-web-share' ),
			'icon'  => 'icon-mail',
			'link'  => 'mailto:?subject={title}&body={url}',
			'color' => '#000',
		),
	);
	return apply_filters( 'sws_social_networks', $networks );
}