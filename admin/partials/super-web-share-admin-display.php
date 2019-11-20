<?php
/**
 * Main Admin UI
 *
 * @since 1.0.0
 * 
 */
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Floating Share
 *
 * @since 1.0.0
 */
function superwebshare_floating_share_cb() {
	// Get Settings
	$settings = superwebshare_get_settings(); ?>
	
	<!-- Floating Button color -->
	<input type="text" name="superwebshare_settings[floating_share_color]" id="superwebshare_settings[floating_share_color]" class="superwebshare-colorpicker" value="<?php echo isset( $settings['floating_share_color'] ) ? esc_attr( $settings['floating_share_color']) : '#D5E0EB'; ?>" data-default-color="#D5E0EB">
	
	<p class="description">
		<?php _e('Enter the hex code of the color that you would like to add to the Floating Share Button. The floating share button can be seen on browsers like <code>Chrome for Android, Edge for Android, Opera for Android and Brave Browser for Android</code>.', 'super-web-share'); ?>
	</p>

	<?php
}
/**
 * Admin interface renderer
 *
 * @since 1.0
 */ 
function superwebshare_admin_interface_render() {
	
	// Check persmission
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	if ( isset( $_GET['settings-updated'] ) ) {
		
		// Add settings
		add_settings_error( 'superwebshare_settings_group', 'superwebshare_settings_saved_message', __( 'Settings saved.', 'super-web-share' ), 'updated' );
		
		// Show Settings Saved Message
		settings_errors( 'superwebshare_settings_group' );
	}
	
	?>
	
	<div class="wrap">	
		<h1>Super Web Share</h1>
		
		<form action="options.php" method="post" enctype="multipart/form-data">		
			<?php
			// Output nonce, action, and option_page fields for a settings page.
			settings_fields( 'superwebshare_settings_group' );
			
			// Basic Settings
			do_settings_sections( 'superwebshare_basic_settings_section' );	// Page slug
			
			// Output save settings button
			submit_button( __('Save Settings', 'super-web-share') );
			?>
		</form>
	</div>
	<?php
}