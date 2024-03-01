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

use WpOrg\Requests\Response\Headers;

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

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The Admin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Super_Web_Share
 * @subpackage Super_Web_Share/includes
 * @author     SuperWebShare <info@superwebshare.com>
 */
class Super_Web_Share_Admin extends Super_Web_Share {

	/**
	 * The Admin class.
	 *
	 * @var $plugin
	 */
	public $plugin;

	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct() {
		$this->plugin  = plugin_basename( __FILE__ );
		$this->version = SUPERWEBSHARE_VERSION;

		add_action( 'save_post', array( $this, 'save_meta_data' ) );
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
	}

	/**
	 * Function register.
	 *
	 * @return void
	 */
	public function register() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_enqueue_styles', array( $this, 'enqueue_styles' ) );
	}

	/**
	 * Function enqueue_styles.
	 *
	 * @return void
	 */
	public function enqueue_styles() {
		wp_enqueue_style( 'superwebshare-admin', plugin_dir_url( __FILE__ ) . 'css/super-web-share-admin.min.css', array(), $this->version, 'all' );
		if ( ! empty( $_GET['page'] ) && 'superwebshare-appearance' === $_GET['page'] ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			wp_enqueue_style( 'superwebshare-public', SUPERWEBSHARE_PLUGIN_DIR_URI . '/public/css/super-web-share-public.min.css', array(), $this->version, 'all' );
		}
	}

	/**
	 * Function enqueue_scripts.
	 *
	 * @param  mixed $hook The hook of WordPress.
	 * @return void
	 */
	public function enqueue_scripts( $hook ) {

		// Load only on SuperWebShare plugin pages.
		if ( strpos( $hook, 'superwebshare' ) === false ) {
			return;
		}

		// Color picker CSS.
		wp_enqueue_style( 'wp-color-picker' );

		// Main JS.
		wp_enqueue_script( 'superwebshare-main-js', plugin_dir_url( __FILE__ ) . 'js/super-web-share-admin.min.js', array( 'wp-color-picker' ), $this->version, true );
	}

	/**
	 * Functiono add_meta_box.
	 *
	 * @param  mixed $post_type Type of the post which WordPress supports.
	 * @return void
	 */
	public function add_meta_box( $post_type ) {

		add_meta_box(
			'super_web_share_meta',
			__( 'Super Web Share', 'super-web-share' ),
			array( $this, 'render_meta_box_content' ),
			array_keys( superwebshare_get_pages() ), // allowed pages.
			'advanced',
			'high'
		);
	}


	/**
	 * Function save_meta_data.
	 *
	 * @param  int $post_id WordPress Post ID.
	 * @return void|int
	 */
	public function save_meta_data( $post_id ) {
		/*
		 * If this is an autosave, SuperWebShare settings won't be saved.
		 * Condition: when post value not exists.
		 */
		if ( empty( $_POST ) || empty( $_POST['post_type'] ) || // phpcs:ignore WordPress.Security.NonceVerification.Missing
			( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		) {
			return $post_id;
		}

		// Check the user's permissions.
		if ( 'page' === $_POST['post_type'] ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return $post_id;
			}
		} elseif ( ! current_user_can( 'edit_post', $post_id ) ) {
				return $post_id;
		}

		// Sanitize the user input.
		$inline_data        = empty( $_POST['superwebshare_post_inline_active'] ) ? 'disabled' : $_POST['superwebshare_post_inline_active']; // phpcs:ignore WordPress.Security.NonceVerification.Missing,WordPress.Security.ValidatedSanitizedInput.MissingUnslash,WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		$floating_data      = empty( $_POST['superwebshare_post_floating_active'] ) ? 'disabled' : $_POST['superwebshare_post_floating_active']; // phpcs:ignore WordPress.Security.NonceVerification.Missing,WordPress.Security.ValidatedSanitizedInput.MissingUnslash,WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		$is_enable_general  = sanitize_text_field( $inline_data );
		$is_enable_floating = sanitize_text_field( $floating_data );

		// Create/Update the meta field.
		update_post_meta( $post_id, '_superwebshare_post_inline_active', $is_enable_general );
		update_post_meta( $post_id, '_superwebshare_post_floating_active', $is_enable_floating );
	}

	/**
	 * The function to render the meta box content on each pages.
	 *
	 * @param  WP_Post $post WordPress post object.
	 * @return void
	 */
	public function render_meta_box_content( $post ) {

		$is_active_floating = isset( $post->_superwebshare_post_floating_active ) ? $post->_superwebshare_post_floating_active : 'enable';
		$is_active_general  = isset( $post->_superwebshare_post_inline_active ) ? $post->_superwebshare_post_inline_active : 'enable';
		?>
		<div class="sws-flex sws-max-500">
			<h4>
				<?php esc_html_e( 'Show Inline share button?', 'super-web-share' ); ?>
			</h4>
			<?php superwebshare_input_toggle( 'superwebshare_post_inline_active', 'enable', $is_active_general ); ?>
		</div>
		<div class="sws-flex sws-max-500">
			<h4>
				<?php esc_html_e( 'Show Floating share button?', 'super-web-share' ); ?>
			</h4>
			<?php superwebshare_input_toggle( 'superwebshare_post_floating_active', 'enable', $is_active_floating ); ?>
		</div>
		<div>
			<p class="description">
				<?php esc_html_e( 'If the share button is not showing on the page, kindly please make sure that the Floating and Inline Content settings are enabled and the respective page type is selected', 'super-web-share' ); ?>
			</p>
		</div>
		<?php
	}
}