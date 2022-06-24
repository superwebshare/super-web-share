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
 * Description for Normal Share buttton
 *
 * @since 1.3
 */ 
function superwebshare_normal_description_cb() {
	$settings = superwebshare_get_settings();
	?>
		<tr valign="top">
			<p>Settings to show native share button on Inline posts/pages</p>
			<p><b>Please Note:</b> Super Web Share button can be seen on browsers like <code>Chrome for Android</code>, <code>Edge for Android</code>, <code>Opera for Android</code>, <code>Samsung Internet for Android</code>, <code>Safari for iOS,</code> and <code>Brave for Android</code>. Those are the browsers that currently support native web share. Please test out the pages on these browsers and devices once after activation.</p>
		</tr>
	<?php
}

/**
 * Inline share button : Enable/Disable share button (normal) : Above and Below Post/Page Content
 *
 * @since 1.3
 */ 
function superwebshare_normal_enable_cb() {
	$settings = superwebshare_get_settings();
	?>
		<p><label><input type="radio" name="superwebshare_settings[superwebshare_normal_enable]" value="enable" <?php checked( "enable", $settings['superwebshare_normal_enable'] ); ?> /> <?php _e( "Enable", 'super-web-share' );?></label></p>
    	<p><label><input type="radio" name="superwebshare_settings[superwebshare_normal_enable]" value="disable" <?php checked( "disable", $settings['superwebshare_normal_enable'] ); ?> /> <?php _e( "Disable", 'super-web-share' );?></label></p>
	<?php
}

/**
 * Inline : Display settings of Share Button (normal) on page or archive pages or home
 *
 * @since 1.3
 */
function superwebshare_normal_display_cb() {
	$settings = superwebshare_get_settings();
	?>
		<p><label><input type="checkbox" id="superwebshare_settings[display_page]" name="superwebshare_settings[normal_display_page]" value="1" <?php if ( isset($settings['normal_display_page']) ) checked( '1', $settings['normal_display_page'] ); ?>> <?php _e( "Display the share button on pages", 'superwebshare' );?></label></p>
        <p><label><input type="checkbox" id="superwebshare_settings[display_archive]" name="superwebshare_settings[normal_display_archive]" value="1" <?php  if ( isset($settings['normal_display_archive']) ) checked( '1', $settings['normal_display_archive'] ); ?>> <?php _e( "Display the share button on archive pages", 'superwebshare' );?></label></p>
        <p><label><input type="checkbox" id="superwebshare_settings[display_home]" name="superwebshare_settings[normal_display_home]" value="1" <?php  if ( isset($settings['normal_display_home']) ) checked( '1', $settings['normal_display_home'] ); ?>> <?php _e( "Display the share button on posts listing page", 'superwebshare' );?></label></p>
    <?php
}

/**
 * Position of Share Button (normal)
 *
 * @since 1.3
 */ 
function superwebshare_normal_position_cb() {
	$settings = superwebshare_get_settings();
	?>
		<p><label><input type="radio" name="superwebshare_settings[position]" value="before" <?php checked( "before", $settings['position'] ); ?> /> <?php _e( "Before the content of your post", 'super-web-share' );?></label></p>
    	<p><label><input type="radio" name="superwebshare_settings[position]" value="after" <?php checked( "after", $settings['position'] ); ?> /> <?php _e( "After the content of your post", 'super-web-share' );?></label></p>
        <p><label><input type="radio" name="superwebshare_settings[position]" value="both" <?php checked( "both", $settings['position'] ); ?> /> <?php _e( "Before AND After the content of your post", 'super-web-share' );?></label></p>
    <?php
}

/**
 * Text for share button (normal)
 *
 * @since 1.3
 */ 
function superwebshare_normal_text_cb() {
	$settings = superwebshare_get_settings();
	?>
		<p><label><input type="text" id="superwebsharebuttontext" name="superwebshare_settings[normal_share_button_text]" title="Share" value="<?php echo $settings['normal_share_button_text']; ?>" /></label></p>
        <p><?php _e( "This text will be displayed within the button", 'super-web-share' );?></p>
    <?php
}

/**
 * Normal Button color (normal)
 *
 * @since 1.3
 */ 
function superwebshare_normal_color_cb() {
	$settings = superwebshare_get_settings();
	?>
	<input type="text" name="superwebshare_settings[normal_share_color]" id="superwebshare_settings[normal_share_color]" class="superwebshare-colorpicker" value="<?php echo isset( $settings['normal_share_color'] ) ? esc_attr( $settings['normal_share_color']) : '#D5E0EB'; ?>" data-default-color="#000000">
    <?php
}

/**
 * Enable/Disable share button (normal) : Above and Below Post/Page Content
 *
 * @since 1.4.4
 */ 
function superwebshare_normal_amp_enable_cb() {
	$settings = superwebshare_get_settings();
	if(isset($settings['superwebshare_normal_amp_enable']) == '') {
		$settings['superwebshare_normal_amp_enable'] =  isset( $settings['superwebshare_normal_amp_enable'] ) ? esc_attr( $settings['superwebshare_normal_amp_enable']) : 'enable';
	}
	?>
		<p><label><input type="radio" name="superwebshare_settings[superwebshare_normal_amp_enable]" value="enable" <?php checked( "enable", $settings['superwebshare_normal_amp_enable'] ); ?> /> <?php _e( "Enable", 'super-web-share' );?></label></p>
    	<p><label><input type="radio" name="superwebshare_settings[superwebshare_normal_amp_enable]" value="disable" <?php checked( "disable", $settings['superwebshare_normal_amp_enable'] ); ?> /> <?php _e( "Disable", 'super-web-share' );?></label></p>
	<?php
}

/**
 * Description for Floating Share buttton
 *
 * @since 1.3
 */ 
function superwebshare_floating_description_cb() {
	$settings_floating = superwebshare_get_settings_floating();
	?>
		<tr valign="top">
			<p>Settings to show floating share button on pages/posts.</p>
			<p><b>Please Note: </b>Super Web Share button can be seen on browsers like <code>Chrome for Android</code>, <code>Edge for Android</code>, <code>Opera for Android</code>, <code>Samsung Internet for Android</code>, <code>Safari for iOS</code> and <code>Brave for Android</code> as those are browsers which currently supports native web share. Please test out over these browsers + devices once after activation.</p>
		</tr>
	<?php
}

/**
 * Enable / Disable the Share Button (floating)
 *
 * @since 1.3
 */ 
function superwebshare_floating_enable_cb() {
	$settings_floating = superwebshare_get_settings_floating();
	?>
		<p><label><input type="radio" name="superwebshare_floatingsettings[superwebshare_floating_enable]" value="enable" <?php checked( "enable", $settings_floating['superwebshare_floating_enable'] ); ?> /> <?php _e( "Enable", 'super-web-share' );?></label></p>
        <p><label><input type="radio" name="superwebshare_floatingsettings[superwebshare_floating_enable]" value="disable" <?php checked( "disable", $settings_floating['superwebshare_floating_enable'] ); ?> /> <?php _e( "Disable", 'super-web-share' );?></label></p>
    <?php
}

/**
 * Floating Button color
 *
 * @since 1.3
 */ 
function superwebshare_floating_color_cb() {
	$settings_floating = superwebshare_get_settings_floating();
	?>
		<input type="text" name="superwebshare_floatingsettings[floating_share_color]" id="superwebshare_floatingsettings[floating_share_color]" class="superwebshare-colorpicker" value="<?php echo isset( $settings_floating['floating_share_color'] ) ? esc_attr( $settings_floating['floating_share_color']) : '#D5E0EB'; ?>" data-default-color="#000000">
			<p class="description">
				<?php _e('Select the color that you would like to add to the floating share button.', 'super-web-share'); ?>
			</p>
    <?php
}

/**
 * Floating Display
 *
 * @since 1.3
 */ 
function superwebshare_floating_display_cb() {
	$settings_floating = superwebshare_get_settings_floating();
	?>
		<p><label><input type="checkbox" id="superwebshare_floatingsettings[floating_display_page]" name="superwebshare_floatingsettings[floating_display_page]" value="1" <?php if ( isset($settings_floating['floating_display_page']) ) checked( '1', $settings_floating['floating_display_page'] ); ?>> <?php _e( "Display the floating button on pages", 'superwebshare' );?></label></p>
        <p><label><input type="checkbox" id="superwebshare_floatingsettings[floating_display_archive]" name="superwebshare_floatingsettings[floating_display_archive]" value="1" <?php  if ( isset($settings_floating['floating_display_archive']) ) checked( '1', $settings_floating['floating_display_archive'] ); ?>> <?php _e( "Display the floating button on archive pages", 'superwebshare' );?></label></p>
        <p><label><input type="checkbox" id="superwebshare_floatingsettings[floating_display_home]" name="superwebshare_floatingsettings[floating_display_home]" value="1" <?php  if ( isset($settings_floating['floating_display_home']) ) checked( '1', $settings_floating['floating_display_home'] ); ?>> <?php _e( "Display the floating button on posts listing page", 'superwebshare' );?></label></p>
    <?php
}

/**
 * Position of Floating Button
 *
 * @since 1.3
 */ 
function superwebshare_floating_position_cb() {
	$settings_floating = superwebshare_get_settings_floating();
	?>
		from <label for="superwebshare_floatingsettings[floating_position]">
					<select id="superwebshare_floatingsettings[floating_position]" name="superwebshare_floatingsettings[floating_position]" style="width:150px" >
						<option value="right" <?php if ($settings_floating['floating_position'] == 'right' ){?>selected<?php } ?> ><?php _e('Bottom - Right','superwebshare') ?></option>
						<option value="left" <?php if ($settings_floating['floating_position'] == 'left' ){?>selected<?php } ?> ><?php _e('Bottom - Left','superwebshare') ?></option>
					</select>
			</label> with 

            <input type="number" min="0" step="any" style="width:50px" name="superwebshare_floatingsettings[floating_position_leftright]" id="superwebshare_floatingsettings[floating_position_leftright]" value="<?php echo isset( $settings_floating['floating_position_leftright'] ) ? esc_attr( $settings_floating['floating_position_leftright']) : '30'; ?>">px from left/right
	<?php
}

/**
 * Position from Bottom
 *
 * @since 1.3
 */ 
function superwebshare_floating_position_bottom_cb() {
	$settings_floating = superwebshare_get_settings_floating();
	?>
		<input type="number" min="0" step="any" style="width:50px" name="superwebshare_floatingsettings[floating_position_bottom]" id="superwebshare_floatingsettings[floating_position_bottom]" value="<?php echo isset( $settings_floating['floating_position_bottom'] ) ? esc_attr( $settings_floating['floating_position_bottom']) : '30'; ?>">px<p>
	<?php
}

/**
 * Enable/Disable share button for Floating Button
 *
 * @since 1.4.4
 */ 
function superwebshare_floating_amp_enable_cb() {
	$settings_floating = superwebshare_get_settings_floating();
	if(isset($settings_floating['superwebshare_floating_amp_enable']) == '') {
		$settings_floating['superwebshare_floating_amp_enable'] =  isset( $settings_floating['superwebshare_floating_amp_enable'] ) ? esc_attr( $settings_floating['superwebshare_floating_amp_enable']) : 'enable';
	}
	
	?>
		<p><label><input type="radio" name="superwebshare_floatingsettings[superwebshare_floating_amp_enable]" value="enable" <?php checked( "enable", $settings_floating['superwebshare_floating_amp_enable'] ); ?> /> <?php _e( "Enable", 'super-web-share' );?></label></p>
    	<p><label><input type="radio" name="superwebshare_floatingsettings[superwebshare_floating_amp_enable]" value="disable" <?php checked( "disable", $settings_floating['superwebshare_floating_amp_enable'] ); ?> /> <?php _e( "Disable", 'super-web-share' );?></label></p>
	<?php
}


/**
 * Enable/Disable the Fallback
 *
 * @since 2.0
 */ 
function superwebshare_fallback_enable_cb() {
	$settings_floating = superwebshare_get_settings_fallback();
	$settings_floating = empty( $settings_floating ) ? array() : $settings_floating;
	$settings_floating['superwebshare_fallback_enable'] =  isset( $settings_floating['superwebshare_fallback_enable'] ) ? esc_attr( $settings_floating['superwebshare_fallback_enable']) : 'enable';
	
	?>
		<p><label><input type="radio" name="superwebshare_fallback_settings[superwebshare_fallback_enable]" value="enable" <?php checked( "enable", $settings_floating['superwebshare_fallback_enable'] ); ?> /> <?php _e( "Enable", 'super-web-share' );?></label></p>
    	<p><label><input type="radio" name="superwebshare_fallback_settings[superwebshare_fallback_enable]" value="disable" <?php checked( "disable", $settings_floating['superwebshare_fallback_enable'] ); ?> /> <?php _e( "Disable", 'super-web-share' );?></label></p>
	<?php
}

/**
 * Fallback description
 *
 * @since 2.0
 */ 
function superwebshare_fallback_description_cb() {
	?>
	<tr valign="top">
		<p><b>Fallback option</b> will help to show the the social icons when the native share is not supported on the browser from which your users visit the website.</p>
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
	$active_tab = isset($_GET['page']) ? $_GET['page']: 'superwebshare';
	$tabs = [ 'General' => 'superwebshare', 'Floating' => 'superwebshare-floating', 'Fallback' => 'superwebshare-fallback' ];
	if ( isset( $_GET['settings-updated'] ) ) {
		
		if( $active_tab == 'superwebshare') {
		// Add settings
		add_settings_error( 'superwebshare_settings_group', 'superwebshare_settings_saved_message', __( 'Settings saved.', 'super-web-share' ), 'updated' );
		
		// Show Settings Saved Message
			settings_errors( 'superwebshare_settings_group' );
		} else if( $active_tab == 'superwebshare-floating' ){
		// Add settings floating
			add_settings_error( 'superwebshare_settings_floating_group', 'superwebshare_settings_saved_message', __( 'Floating Settings saved.', 'super-web-share' ), 'updated' );
		
		// Show Settings Saved Message
		settings_errors( 'superwebshare_settings_floating_group' );
		}  else if( $active_tab == 'superwebshare-fallback' ){
			// Add settings fallback
				add_settings_error( 'superwebshare_settings_fallback_group', 'superwebshare_settings_saved_message', __( 'Fallback Settings saved.', 'super-web-share' ), 'updated' );
			
			// Show Settings Saved Message
			settings_errors( 'superwebshare_settings_fallback_group' );
			}
	}
	
	?>
	
	<div class="wrap">	
		<h1>Super Web Share <sup><?php echo SUPERWEBSHARE_VERSION; ?></sup></h1>
         
        <h2 class="nav-tab-wrapper">
			<?php foreach( $tabs as $name => $page ){
				?>
					 <a href="?page=<?php echo $page ?>" class="nav-tab <?php echo $active_tab == $page ? 'nav-tab-active' : ''; ?>"><?php echo $name ?></a>
				<?php
			}?>
        </h2>

		<form action="options.php" method="post" enctype="multipart/form-data">		
			<?php
			if( $active_tab == 'superwebshare' || isset($active_tab) == '0' ) {
				// Above & Below Settings

				// Output nonce, action, and option_page fields for a settings page.
				settings_fields( 'superwebshare_settings_group' );
				do_settings_sections( 'superwebshare_basic_settings_section' ); 	// Normal Above and Below Button slug
				// Output save settings button
			submit_button( __('Save Settings', 'super-web-share') );
			} else  if($active_tab == 'superwebshare-floating'){
				// Floating Button Settings

				// Output nonce, action, and option_page fields for a settings page.
				settings_fields( 'superwebshare_settings_floating_group' );
				do_settings_sections( 'superwebshare_floating_settings_section' );	// Floating Button slug
				// Output save settings button
				submit_button( __('Save Settings', 'super-web-share') );
			} elseif( $active_tab == 'superwebshare-fallback' ){
				// Fallback Settings

				// Output nonce, action, and option_page fields for a settings page.
				settings_fields( 'superwebshare_settings_fallback_group' );
				do_settings_sections( 'superwebshare_fallback_settings_section' );	// Fallback Button slug

				// Output save settings button
				submit_button( __('Save Settings', 'super-web-share') );
			}

// 
			?>
		</form>
	</div>
	<?php
}