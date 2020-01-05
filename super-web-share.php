<?php
/**
 *
 * @link              https://www.josevarghese.com
 * @since             1.0.0
 * @package           Super_Web_Share
 *
 * @wordpress-plugin
 * Plugin Name:       Super Web Share
 * Plugin URI:        https://www.josevarghese.com
 * Description:       Super Web Share helps to quickly add the Native Share option to your WordPress website
 * Version:           1.4.4
 * Author:            Super Web Share
 * Author URI:        https://www.josevarghese.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       super-web-share
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Current plugin version.
 *
 * @since 1.0
 */
define( 'SUPERWEBSHARE_VERSION', '1.4.4' );

/**
 * Full path to the plugin file. 
 * eg - /var/www/html/wp-content/plugins/super-web-share/superwebshare.php
 *
 * @since 1.2
 */
if ( ! defined( 'SUPERWEBSHARE_PLUGIN_FILE' ) ) {
	define( 'SUPERWEBSHARE_PLUGIN_FILE', __FILE__ ); 
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-super-web-share-activator.php
 */
function activate_super_web_share() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-super-web-share-activator.php';
	Super_Web_Share_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-super-web-share-deactivator.php
 */
function deactivate_super_web_share() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-super-web-share-deactivator.php';
	Super_Web_Share_Deactivator::deactivate();
}
register_activation_hook( __FILE__, 'activate_super_web_share' );
register_deactivation_hook( __FILE__, 'deactivate_super_web_share' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-super-web-share.php';

/**
 * Plugin activation function
 * @since 1.4.2
 */
function superwebshare_activate_plugin( $network_wide ) {
	if ( ! current_user_can( 'activate_plugins' ) ) {
        return;
    }
	set_transient( 'superwebshare_admin_notice_activation', true, 5 );
}
register_activation_hook( __FILE__, 'superwebshare_activate_plugin' );

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_super_web_share() {
	$plugin = new Super_Web_Share();
	$plugin->run();
}
run_super_web_share();