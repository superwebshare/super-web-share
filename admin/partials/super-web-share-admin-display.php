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
 * Above & Below Post Settings Section
 *
 * @since 1.2
 */ 
function superwebshare_above_below_post_cb() {
	$settings = superwebshare_get_settings();
	?>

	<!-- Enable / Disable the Share Button (normal) -->
	<tr valign="top">
  	  <th scope="row"><?php _e( 'Enable/Disable the share button', 'superwebshare' ); ?></th>
                        <td>
							<p><label><input type="radio" name="superwebshare_settings[superwebshare_normal_enable]" value="enable" <?php checked( "enable", $settings['superwebshare_normal_enable'] ); ?> /> <?php _e( "Enable", 'super-web-share' );?></label></p>
                            <p><label><input type="radio" name="superwebshare_settings[superwebshare_normal_enable]" value="disable" <?php checked( "disable", $settings['superwebshare_normal_enable'] ); ?> /> <?php _e( "Disable", 'super-web-share' );?></label></p>
                        </td>
	</tr>

	<!-- Display settings of Share Button (normal) -->
	<tr valign="top">
  	  <th scope="row"><?php _e( 'Display', 'superwebshare' ); ?></th>
                        <td>
                        	<p><label><input type="checkbox" id="superwebshare_settings[display_page]" name="superwebshare_settings[normal_display_page]" value="1" <?php if ( isset($settings['normal_display_page']) ) checked( '1', $settings['normal_display_page'] ); ?>> <?php _e( "Display the share button on pages", 'superwebshare' );?></label></p>
                        	<p><label><input type="checkbox" id="superwebshare_settings[display_archive]" name="superwebshare_settings[normal_display_archive]" value="1" <?php  if ( isset($settings['normal_display_archive']) ) checked( '1', $settings['normal_display_archive'] ); ?>> <?php _e( "Display the share button on archive pages", 'superwebshare' );?></label></p>
                            <p><label><input type="checkbox" id="superwebshare_settings[display_home]" name="superwebshare_settings[normal_display_home]" value="1" <?php  if ( isset($settings['normal_display_home']) ) checked( '1', $settings['normal_display_home'] ); ?>> <?php _e( "Display the share button on posts listing page", 'superwebshare' );?></label></p>
                        </td>
	</tr>

	<!-- Position settings of Share Button (normal) -->
	<tr valign="top">
  	  <th scope="row"><?php _e( 'Position of Share Button', 'superwebshare' ); ?></th>
                        <td>
							<p><label><input type="radio" name="superwebshare_settings[position]" value="before" <?php checked( "before", $settings['position'] ); ?> /> <?php _e( "Before the content of your post", 'super-web-share' );?></label></p>
                            <p><label><input type="radio" name="superwebshare_settings[position]" value="after" <?php checked( "after", $settings['position'] ); ?> /> <?php _e( "After the content of your post", 'super-web-share' );?></label></p>
                            <p><label><input type="radio" name="superwebshare_settings[position]" value="both" <?php checked( "both", $settings['position'] ); ?> /> <?php _e( "Before AND After the content of your post", 'super-web-share' );?></label></p>
                        </td>
	</tr>

	<!-- Text content for share button -->
	<tr valign="top">
  	  <th scope="row"><?php _e( 'Content for share button', 'superwebshare' ); ?></th>
                        <td>
							<p><label><input type="text" id="superwebsharebuttontext" name="superwebshare_settings[normal_share_button_text]" title="Share" value="<?php echo $settings['normal_share_button_text']; ?>" /></label></p>
                            <p><?php _e( "This text will be displayed within the button", 'super-web-share' );?></p>
                        </td>
	</tr>

	<!-- Floating Button color -->
	<tr valign="top">
  	  <th scope="row"><?php _e( 'Button Color', 'superwebshare' ); ?></th>
        <td>
	<input type="text" name="superwebshare_settings[normal_share_color]" id="superwebshare_settings[normal_share_color]" class="superwebshare-colorpicker" value="<?php echo isset( $settings['normal_share_color'] ) ? esc_attr( $settings['normal_share_color']) : '#D5E0EB'; ?>" data-default-color="#000000">
		</td>
	</tr>
<?php
}


/**
 * Floating Share
 *
 * @since 1.0.0
 */
function superwebshare_floating_share_cb() {
	// Get Settings
	$settings = superwebshare_get_settings(); ?>

	<!-- Enable / Disable the Share Button (floating) -->
	<tr valign="top">
  	  <th scope="row"><?php _e( 'Enable/Disable the floating share button', 'superwebshare' ); ?></th>
                        <td>
							<p><label><input type="radio" name="superwebshare_settings[superwebshare_floating_enable]" value="enable" <?php checked( "enable", $settings['superwebshare_floating_enable'] ); ?> /> <?php _e( "Enable", 'super-web-share' );?></label></p>
                            <p><label><input type="radio" name="superwebshare_settings[superwebshare_floating_enable]" value="disable" <?php checked( "disable", $settings['superwebshare_floating_enable'] ); ?> /> <?php _e( "Disable", 'super-web-share' );?></label></p>
                        </td>
	</tr>
	
	<!-- Floating Button color -->
	<tr valign="top">
  	  <th scope="row"><?php _e( 'Color of floating share button', 'superwebshare' ); ?></th>
        <td>
			<input type="text" name="superwebshare_settings[floating_share_color]" id="superwebshare_settings[floating_share_color]" class="superwebshare-colorpicker" value="<?php echo isset( $settings['floating_share_color'] ) ? esc_attr( $settings['floating_share_color']) : '#D5E0EB'; ?>" data-default-color="#000000">
	
			<p class="description">
				<?php _e('Select the color that you would like to add to the floating share button. The floating share button can be seen on browsers like <code>Chrome for Android</code>, <code>Edge for Android</code>, <code>Opera for Android</code>, <code>Samsung Internet for Android</code>, <code>Safari for iOS</code> and <code>Brave Browser for Android</code>.', 'super-web-share'); ?>
			</p>
			</td>
	</tr>

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
                from <label for="superwebshare_settings[floating_position]">
					<select id="superwebshare_settings[floating_position]" name="superwebshare_settings[floating_position]" style="width:150px" >
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

		<form action="options.php" method="post" enctype="multipart/form-data">		
			<?php
			// Output nonce, action, and option_page fields for a settings page.
			settings_fields( 'superwebshare_settings_group' );

			// Above & Below Settings
			do_settings_sections( 'superwebshare_above_below_post_settings_section' );	// Normal Above and Below Button slug
			
			// Floating Button Settings
			do_settings_sections( 'superwebshare_basic_settings_section' );	// Floating Button slug
			
			// Output save settings button
			submit_button( __('Save Settings', 'super-web-share') );
			?>
		</form>
	</div>
	<?php
}