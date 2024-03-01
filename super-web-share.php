<?php
/**
 *
 * Plugin Name:       Super Web Share
 * Plugin URI:        https://www.superwebshare.com
 * Description:       Super Web Share helps to quickly add the Native Share option to your WordPress website
 * Version:           2.4
 * Author:            Super Web Share
 * Author URI:        https://www.superwebshare.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       super-web-share
 * Domain Path:       /languages
 *
 * @link              https://www.superwebshare.com
 * @since             1.0.0
 * @package           Super_Web_Share
 * @wordpress-plugin
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Current plugin version.
 *
 * @since 1.0
 */
define( 'SUPERWEBSHARE_VERSION', '2.4' );

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
 * Full URI to the plugin file.
 * eg - https://www.example.com/wp-content/plugins/super-web-share/
 *
 * @since 2.3
 */
if ( ! defined( 'SUPERWEBSHARE_PLUGIN_DIR_URI' ) ) {
	define( 'SUPERWEBSHARE_PLUGIN_DIR_URI', plugin_dir_url( __FILE__ ) );
}

/**
 * Full DIR PATH to the plugin file.
 *
 * @since 2.3
 */
if ( ! defined( 'SUPERWEBSHARE_PLUGIN_DIR_PATH' ) ) {
	define( 'SUPERWEBSHARE_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
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

// Icons loading.
require plugin_dir_path( __FILE__ ) . 'includes/class-super-web-share-icons.php';

/**
 * Plugin activation function
 *
 * @since 1.4.2
 * @param Object $network_wide The network wide network.
 */
function superwebshare_activate_plugin( $network_wide = false ) {
	$network_wide;
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
	require_once plugin_dir_path( __FILE__ ) . 'block/super-web-share-block.php';
	$plugin = new Super_Web_Share();
	$plugin->run();
}

run_super_web_share();
