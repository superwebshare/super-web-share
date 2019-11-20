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
	<input type="text" name="superwebshare_settings[floating_share_color]" id="superwebshare_settings[floating_share_color]" class="superwebshare-colorpicker" value="<?php echo isset( $settings['floating_share_color'] ) ? esc_attr( $settings['floating_share_color']) : '#D5E0EB'; ?>" data-default-color="#000000">
	
	<p class="description">
		<?php _e('Enter the hex code of the color that you would like to add to the Floating Share Button. The floating share button can be seen on browsers like <code>Chrome for Android</code>, <code>Edge for Android</code>, <code>Opera for Android</code> and <code>Brave Browser for Android</code>.', 'super-web-share'); ?>
	</p>

<tr valign="top">
    <th scope="row"><?php _e( 'Display', 'superwebshare' ); ?></th>
                        <td>
                           <p><label><input type="checkbox" id="superwebshare_settings[floating_display_page]" name="superwebshare_settings[floating_display_page]" value="1" <?php if ( isset($settings['floating_display_page']) ) checked( '1', $settings['floating_display_page'] ); ?>> <?php _e( "Display the floating button on pages", 'superwebshare' );?></label></p>
                            <p><label><input type="checkbox" id="superwebshare_settings[floating_display_archive]" name="superwebshare_settings[floating_display_archive]" value="1" <?php  if ( isset($settings['floating_display_archive']) ) checked( '1', $settings['floating_display_archive'] ); ?>> <?php _e( "Display the floating button on archive pages", 'superwebshare' );?></label></p>
                            <p><label><input type="checkbox" id="superwebshare_settings[floating_display_home]" name="superwebshare_settings[floating_display_home]" value="1" <?php  if ( isset($settings['floating_display_home']) ) checked( '1', $settings['floating_display_home'] ); ?>> <?php _e( "Display the floating button on posts listing page", 'superwebshare' );?></label></p>
                        </td>
</tr>


<tr>
    <th scope="row">
		<?php _e( 'Position of Floating Button', 'superwebshare' ); ?>
	</th>
                        <td scope="row">
                           from <label for="superwebshare_settings[floating_position]"><select id="superwebshare_settings[floating_position]" name="superwebshare_settings[floating_position]" style="width:150px" >
									<option value="right" <?php if ($settings['floating_position'] == 'right' ){?>selected<?php } ?> ><?php _e('Bottom - Right','superwebshare') ?></option>
									<option value="left" <?php if ($settings['floating_position'] == 'left' ){?>selected<?php } ?> ><?php _e('Bottom - Left','superwebshare') ?></option>
								</select>
							   </label> with 

                           <input type="number" min="0" step="any" style="width:50px" name="superwebshare_settings[floating_position_leftright]" id="superwebshare_settings[floating_position_leftright]" value="<?php echo isset( $settings['floating_position_leftright'] ) ? esc_attr( $settings['floating_position_leftright']) : '30'; ?>">px from left/right
	</td>
	
</tr>



<tr valign="top">
	<th scope="row"><?php _e( 'Position from Bottom', 'superwebshare' ); ?></th>
	                        <td>
                           <input type="number" min="0" step="any" style="width:50px" name="superwebshare_settings[floating_position_bottom]" id="superwebshare_settings[floating_position_bottom]" value="<?php echo isset( $settings['floating_position_bottom'] ) ? esc_attr( $settings['floating_position_bottom']) : '30'; ?>">px<p>
								
								</p>
	</td>
</tr>

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
		 <h3><?php _e( 'Floating Button Settings', 'superwebshare' ); ?></h3>
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