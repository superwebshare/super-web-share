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
delete_option( 'superwebshare_settings' );
delete_option( 'superwebshare_floatingsettings');