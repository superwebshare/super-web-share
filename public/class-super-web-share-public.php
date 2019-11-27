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
 * @author     SuperWebShare <info@superwebshare.com>
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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		$settings_floating = superwebshare_get_settings_floating();
		$settings = superwebshare_get_settings();
		if (( $settings_floating['superwebshare_floating_enable'] == 'enable') || ( $settings['superwebshare_normal_enable'] == 'enable')) {
			if ( is_single()
					|| ( isset($settings_floating['floating_display_page']) == '1' && is_page() )
					|| ( isset($settings_floating['floating_display_archive']) == '1' && is_archive() )
					|| ( isset($settings_floating['floating_display_home']) == '1' && is_home() ) 
					|| ( isset($settings['normal_display_page']) == '1' && is_page() )
					|| ( isset($settings['normal_display_archive']) == '1' && is_archive() )
					|| ( isset($settings['normal_display_home']) == '1' && is_home() ) ) {
						wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/super-web-share-public.css', array(), $this->version, 'all' );
					}
		}
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		$settings_floating = superwebshare_get_settings_floating();
		$settings = superwebshare_get_settings();
		if (( $settings_floating['superwebshare_floating_enable'] == 'enable') || ( $settings['superwebshare_normal_enable'] == 'enable')) {
			if ( is_single()
					|| ( isset($settings_floating['floating_display_page']) == '1' && is_page() )
					|| ( isset($settings_floating['floating_display_archive']) == '1' && is_archive() )
					|| ( isset($settings_floating['floating_display_home']) == '1' && is_home() ) 
					|| ( isset($settings['normal_display_page']) == '1' && is_page() )
					|| ( isset($settings['normal_display_archive']) == '1' && is_archive() )
					|| ( isset($settings['normal_display_home']) == '1' && is_home() ) ) {
						wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/super-web-share-public.js', array( 'jquery' ), $this->version, false );
					}
		}
	}
}

/**
	 * Floating Share Button
	 *
	 * @since 1.0
*/
function superwebshare_floating_button_code() {
	$settings_floating = superwebshare_get_settings_floating();
	if ( $settings_floating['superwebshare_floating_enable'] == 'enable') {
	if ( is_single()
				|| ( isset($settings_floating['floating_display_page']) == '1' && is_page() )
				|| ( isset($settings_floating['floating_display_archive']) == '1' && is_archive() )
				|| ( isset($settings_floating['floating_display_home']) == '1' && is_home() ) ) {
		
					$tags  = '<!-- Floating Button by SuperWebShare - Native Share Plugin for WordPress -->' . PHP_EOL;
    				echo '<div class="sws_superaction"><button class="superwebshare_prompt superwebshare_tada superwebshare_button" style="background-color: '. $settings_floating['floating_share_color'] .'; '.$settings_floating['floating_position'].':'.$settings_floating['floating_position_leftright'].'px; bottom:'.$settings_floating['floating_position_bottom'].'px;";><span> Share </span></button></div>' . PHP_EOL;
					echo $tags;
			}
		}
	}
add_action('wp_footer', 'superwebshare_floating_button_code');



/**
	 * Normal Share Button
	 *
	 * @param string $content The post content
	 * @param string $position Position of the button
	 * @return string Modifiyed content
	 * @since 1.2
*/
function superwebshare_normal_button_code($content) {

	$settings = superwebshare_get_settings();

	if ( $settings['superwebshare_normal_enable'] == 'enable') {
		if ( is_single()
				|| ( isset($settings['normal_display_page']) == '1' && is_page() )
				|| ( isset($settings['normal_display_archive']) == '1' && is_archive() )
				|| ( isset($settings['normal_display_home']) == '1' && is_home() ) ) {

		$pos = $settings['position'];
		$button = '<div class="sws_supernormalaction"><button class="superwebshare_normal_button1 superwebshare_prompt" style="background-color: '. $settings['normal_share_color'] .';";>'.'<span>'. $settings['normal_share_button_text'] .'</span></button></div>';
		switch ( $pos ) {
			case 'before':
				$content = $button . $content;
				break;
			case 'after':
				$content = $content . $button;
				break;
			case 'both':
				$content = $button . $content . $button;
				break;
			case 'manual':
				break;
			default:
				$content = $content . $button;
				break;
			}
		}
	}
	return $content;
}
add_action('the_content', 'superwebshare_normal_button_code');


/**
	 * @since 1.4.1
*/
function superwebshare_frontent_inline_styles($content)
{
    $settings_floating = superwebshare_get_settings_floating();
    $settings = superwebshare_get_settings();
    if (($settings_floating['superwebshare_floating_enable'] == 'enable') || ($settings['superwebshare_normal_enable'] == 'enable')) {
        if (is_single()
            || (isset($settings_floating['floating_display_page']) == '1' && is_page())
            || (isset($settings_floating['floating_display_archive']) == '1' && is_archive())
            || (isset($settings_floating['floating_display_home']) == '1' && is_home())
            || (isset($settings['normal_display_page']) == '1' && is_page())
            || (isset($settings['normal_display_archive']) == '1' && is_archive())
            || (isset($settings['normal_display_home']) == '1' && is_home())
        ) {
            echo '<style type="text/css"> .superwebshare_prompt::before { background-image: url(' . plugin_dir_url (__FILE__) . 'assets/android_share.svg);
                } 
            </style>' . PHP_EOL;
        }
    }
}
add_action('wp_footer', 'superwebshare_frontent_inline_styles');