<?php
/**
 * The public-facing functionality of the Super Web Share plugin.
 *
 * @link       https://superwebshare.com
 * @since      1.0.0
 * @package    Super_Web_Share
 * @subpackage Super_Web_Share/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * @package    Super_Web_Share
 * @subpackage Super_Web_Share/public
 * @author     SuperWebShare <support@superwebshare.com>
 */
class Super_Web_Share_Public {
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;
	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param string $plugin_name       The name of the plugin.
	 * @param string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		add_action( 'wp_footer', 'superwebshare_floating_button_code' );
		add_action( 'wp_footer', 'superwebshare_frontend_inline_styles' );
		add_action( 'the_content', 'superwebshare_inline_button_code' );
		add_action( 'wp_head', 'superwebshare_add_js_settings', 50 ); // Added js configuration for frontend actions.

		add_action( 'wp_footer', array( $this, 'add_modal_if_class_name_found' ) );

		if ( function_exists( 'is_amp_endpoint' ) || function_exists( 'ampforwp_is_amp_endpoint' ) ) {

			add_action( 'the_content', 'superwebshare_inline_amp_button_code' );
			add_action( 'amp_post_template_footer', 'superwebshare_amp_floating_button_code' );

			add_action(
				'amp_post_template_css',
				function () {

					$style_path = plugin_dir_path( __FILE__ ) . 'css/super-web-share-public.min.css';
					if ( file_exists( $style_path ) ) {
						echo wp_remote_get( $style_path ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

					}

					$amp_style_path = plugin_dir_path( __FILE__ ) . 'css/super-web-share-amp-public.min.css';
					if ( file_exists( $amp_style_path ) ) {
						echo wp_remote_get( $amp_style_path ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						echo ".superwebshare_prompt::before { 
						background-image: url('" . esc_html( trim( plugin_dir_url( __FILE__ ), '/' ) ) . "/assets/android_share.svg');
					}";
					}
				}
			);
		}
	}

	/**
	 * Add the fallback modal if the page contain the class name
	 *
	 * @return void
	 */
	public function add_modal_if_class_name_found() {
		if ( $this->check_class_containing() ) {

			super_web_share_fallback_modal_for_shortcode();
		}
	}


	/**
	 * Hook the plugin function on 'init' event.
	 *
	 * @since    1.0.0
	 */
	public function init() {
		if ( superwebshare_is_amp() ) {
			add_action( 'wp_print_styles', 'frontend_amp_css' );
			add_action( 'amp_post_template_css', 'frontend_amp_css' );
		}
	}
	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_register_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/super-web-share-public.min.css', array(), $this->version, 'all' );

		wp_register_style( $this->plugin_name . '-amp', plugin_dir_url( __FILE__ ) . 'css/super-web-share-amp-public.min.css', array(), $this->version, 'all' );

		if ( can_display_button( 'inline' ) || can_display_button( 'floating' ) || $this->check_class_containing() ) {

			wp_enqueue_style( $this->plugin_name );

		}
		if ( superwebshare_is_amp() ) {

			wp_enqueue_style( $this->plugin_name . '-amp' );

		}
	}
	/**
	 * Register the JavaScript for the public-facing side of the site.
	 * The JavaScript file won't register on the AMP pages, as JS won't work within the AMP.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_register_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/super-web-share-public.min.js', array(), $this->version, true );

		if ( ! superwebshare_is_amp() ) {
			if ( can_display_button( 'inline' ) || can_display_button( 'floating' ) || $this->check_class_containing() ) {

				wp_enqueue_script( $this->plugin_name );
			}
		}
	}

	/**
	 * Check the page content have the class name.
	 *
	 * @return boolean
	 */
	private function check_class_containing() {

		$post_content = get_post_field( 'post_content', get_the_ID() );
		// Check if the superwebshare_trigger text is found in the post content.
		return strpos( $post_content, 'superwebshare_trigger' ) !== false;
	}
}
