<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @link       https://www.josevarghese.com
 * @since      1.0.0
 * @package    Super_Web_Share
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

/**
 * Delete database settings
 *
 * @since 1.0.0
 */
delete_option( 'superwebshare_inline_settings' );
delete_option( 'superwebshare_floating_settings' );
delete_option( 'superwebshare_fallback_settings' );
delete_option( 'superwebshare_appearance_settings' );
delete_option( 'superwebshare_version' );
delete_metadata( 'post', false, '_superwebshare_post_inline_active', null, true );
delete_metadata( 'post', false, '_superwebshare_post_floating_active', null, true );
