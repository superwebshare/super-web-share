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
		add_action('wp_footer', 'superwebshare_floating_button_code');
		add_action('wp_footer', 'superwebshare_frontend_inline_styles');
		add_action('the_content', 'superwebshare_inline_button_code');
		add_action( 'wp_head', 'superwebshare_add_js_settings', 50 ); // Added js configuration for frontend actions
		if ( function_exists( 'is_amp_endpoint' ) || function_exists( 'ampforwp_is_amp_endpoint' ) ) {
			add_action( 'wp_head', 'superwebshare_amp_add_social_share_head', 0 );
			add_action('the_content', 'superwebshare_inline_amp_button_code');
			//add_action('wp_footer', 'superwebshare_amp_floating_button_code');
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
		
		if ( can_display_button( 'inline' ) || can_display_button( 'floating' ) ) {

			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/super-web-share-public.css', array(), $this->version, 'all' );
		
		}
	}
	/**
	 * Register the JavaScript for the public-facing side of the site.
	 * The JavaScript file won't register on the AMP pages, as JS won't work within the AMP.
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		if ( ! superwebshare_is_amp() ) {
			if ( can_display_button( 'inline' ) || can_display_button( 'floating' )  ) {

				wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/super-web-share-public.js', array(), $this->version, true );
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
	if ( ! superwebshare_is_amp() ) {
		$settings_floating = superwebshare_get_settings_floating();

		if ( can_display_button( 'floating', $settings_floating ) ) {

			$post = get_post();
			if( 
				( isset( $post->_superwebshare_post_floating_active ) && empty( $post->_superwebshare_post_floating_active ) ) || 
				( ! empty( $post->_superwebshare_post_floating_active ) && $post->_superwebshare_post_floating_active != 'enable' ) 
			){
				return;
			}

			$floatingbuttontext = empty( $settings_floating[ 'floating_button_text' ] ) ? 'Share' : $settings_floating[ 'floating_button_text' ];

			$tags  = '<!-- Floating Button by SuperWebShare - Native Share Plugin for WordPress -->' . PHP_EOL;
			echo '<div class="sws_superaction" style="'.$settings_floating['floating_position'].':24px"><button class="superwebshare_tada superwebshare_button superwebshare_prompt" style="background-color: '. $settings_floating['floating_share_color'] .'; '.$settings_floating['floating_position'].':'.$settings_floating['floating_position_leftright'].'px; bottom:'.$settings_floating['floating_position_bottom'].'px;";><span> ' . $floatingbuttontext . ' </span></button></div>' . PHP_EOL;
			echo $tags;
		}
	}
}

function superwebshare_wp_init(){

	add_action( 'woocommerce_product_meta_end', 'superwebshare_inline_button' );

}
add_action( 'init', 'superwebshare_wp_init' );

/**
 * Inline Share Button for all posts except woocommerce products
*
* @param string $content The post content
* @param string $position Position of the button
 * @return string Modifiyed content
* @since 1.2
*/
	function superwebshare_inline_button_code($content) {
		if ( ! superwebshare_is_amp() ) {
			$settings = superwebshare_get_settings_inline();
			if (  can_display_button( 'inline', $settings )) {

				$pos = $settings['inline_position'];

				$post = get_post();
				
				// We won't add button to page if the button prevent in page settings OR the page is single product page.
				if( 
					( isset( $post->_superwebshare_post_inline_active ) && empty( $post->_superwebshare_post_inline_active ) ) || 
					( ! empty( $post->_superwebshare_post_inline_active ) && $post->_superwebshare_post_inline_active != 'enable' ) || 
					get_post_type() === "product"  
					){
					return $content;
				}

				$button = superwebshare_inline_button( $settings['inline_button_share_text'],  $settings['inline_button_share_color'], false );
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

/**
 * Inline Share Button
 *
 * @param string $button text
 * @param string $color Default #BD3854
 * @param boolean $echo make it false if you won't echo by function self
 * @since 2.2
*/
function superwebshare_inline_button( $text = '', $color = '' , $echo = true ){

	if( empty( $text ) ){

		//Reding the settings if function called by empty $text

		$settings = superwebshare_get_settings_inline();
		$text = $settings['inline_button_share_text'];
		$color =  $settings['inline_button_share_color'];

		if( !can_display_button( 'inline' ) ){
			return false;
		}
	}

	$button = '<div class="sws_supernormalaction"><button class="superwebshare_normal_button1 superwebshare_prompt" style="background-color: '. $color .';";>'.'<span>'. $text .'</span></button></div>';

	if( $echo ){
		echo apply_filters( 'superwebshare_inline_button', $button );
	}else{
		return apply_filters( 'superwebshare_inline_button', $button );
	}


}	

/**
	 * Inline Styles for Share Button (Icon)
	 *
	 * @param string $content The post content
	 * @return string Icon for Share Button
	 * @since 1.4.1
*/
	function superwebshare_frontend_inline_styles( $content ) {
		if ( ! superwebshare_is_amp() ) {
			$settings_fallback = superwebshare_get_settings_fallback();

			$layout =  empty( $settings_fallback[ 'fallback_layout' ] ) ? 1 : $settings_fallback[ 'fallback_layout' ] ;
    		if ( can_display_button( 'inline' ) ||  can_display_button( 'floating' ) ) {
				$page_url = is_home() ? urlencode( home_url() ) : urlencode( get_the_permalink() );
				$copy_url = is_home() ? home_url() : get_the_permalink();

				$default_bg =  superwebshare_settings_default( 'fallback' )[ 'fallback_modal_background' ];

            	echo '<style type="text/css"> .superwebshare_prompt::before { background-image: url(' . plugin_dir_url (__FILE__) . 'assets/android_share.svg);
				} 
				</style>
				<div class="sws-modal-bg sws-layout-' . $layout . '">
				<div class="modal-container" style="background-color: ' . ( empty( $settings_fallback['fallback_modal_background'] )  ? $default_bg : $settings_fallback['fallback_modal_background'] ) . '" >
						<div class="modal-title">
							Share
						</div>
						
						<div class="sws-modal-content">
							<div class="sws-links">
								<a  target="_blank" class="sws-open-in-tab" href="https://www.facebook.com/sharer/sharer.php?u=' . $page_url . '"  ><i class="sws-icon sws-icon-facebook"></i><p>Facebook</p></a>
								<a  target="_blank" class="sws-open-in-tab" href="http://twitter.com/share?text=' . urlencode( get_the_title() ) . '&url=' . $page_url . '" > <i  class="sws-icon sws-icon-twitter"></i><p> Twitter</p></a>
								<a  target="_blank" class="sws-open-in-tab" href="https://www.linkedin.com/sharing/share-offsite/?url=' . $page_url . '"> <i  class="sws-icon sws-icon-linked-in"></i> <p>LinkedIn</p></a>
								<a  target="_blank" href="https://api.whatsapp.com/send/?text=' . $page_url . '"> <i  class="sws-icon sws-icon-whatsapp"></i> <p>WhatsApp</p></a>
							</div>
							<div class="sws-copy">
								<a href="#" data-url="' . $copy_url . '"> <i  class="sws-icon sws-icon-copy"></i><span>Copy Link</span></a>
							</div>

						</div>
						<a href="#" class="sws-modal-close">×</a>
					</div>
				</div>
				
				';

			}
		}
	}


/**
	 * AMP social share JS script
	 *
	 * @return string Icon for Share Button
	 * @since 1.4.4
*/
function superwebshare_amp_add_social_share_head(){
	if ( superwebshare_is_amp() ) {
		$settings = superwebshare_get_settings_inline();
		if ($settings['inline_amp_enable'] == 'enable'){
			$tags = '<script async custom-element="amp-social-share" src="https://cdn.ampproject.org/v0/amp-social-share-0.1.js"></script>' . PHP_EOL;
			echo $tags;
		}	
	}
	
}

/**
	 * Fallback settings to register whether the settings is enabled or not on the browser
	 *
	 * @return code Fallback
	 * @since 2.0
*/
function superwebshare_add_js_settings(){
	if ( ! superwebshare_is_amp() ){
	$settings = json_encode( superwebshare_get_settings_fallback() );
	echo "<script type='text/javascript'>window.superWebShareFallback = $settings </script>";
	}
}

/**
	 * AMP social share normal button code
	 *
	 * @return code normal amp
	 * @since 1.4.4
*/
function superwebshare_inline_amp_button_code($content) {
	if ( superwebshare_is_amp() ) {
		$settings = superwebshare_get_settings_inline();
		if ( can_display_button( 'inline', $settings ) ) {
			$pos = $settings['inline_position'];
			if ($settings['inline_amp_enable'] == 'enable'){
				$button = '<div id="swsamp"><amp-social-share type="system" style="background-color: '. $settings['inline_button_share_color'] .';border-radius:28px;padding:0 24px 0 52px;text-indent:0;width:auto;align-items:center;box-shadow:0 2px 4px -1px rgba(0,0,0,.2),0 4px 5px 0 rgba(0,0,0,.14),0 1px 10px 0 rgba(0,0,0,.12);position:relative" class="rounded superwebshare_normal_button1 superwebshare_prompt"></amp-social-share></span></div>';
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
	}
	return $content;
}

/**
	 * AMP social floating button code
	 *
	 * @return string Icon for Share Button
	 * @since 1.4.4
*/
function superwebshare_amp_floating_button_code() {
	if ( superwebshare_is_amp() ) {
		$settings_floating = superwebshare_get_settings_floating();
		if ( can_display_button( 'floating', $settings_floating ) ) {

			if ( $settings_floating['floating_amp_enable'] == 'enable'){

				$tags  = '<!-- Floating Button by SuperWebShare - Native Share Plugin for WordPress -->' . PHP_EOL;
				echo '<div class="sws_superaction" style="' . $settings_floating['floating_position'] . ':' . $settings_floating['floating_position_leftright'] . 'px; bottom: ' . $settings_floating['floating_position_leftright'] . 'px" ><amp-social-share type="system" width="48px" height="48px" style="background-color: '. $settings_floating['floating_share_color'] .';background-size:30px; border-radius:28px;padding:10px;text-indent:0;align-items:center;box-shadow:0 2px 4px -1px rgba(0,0,0,.2),0 4px 5px 0 rgba(0,0,0,.14),0 1px 10px 0 rgba(0,0,0,.12);position:relative" class="round superwebshare_prompt superwebshare_button amp-wp-ce4be5a"></amp-social-share></span></div>' . PHP_EOL;
				echo $tags;
			}
		}
	}
}
add_action('wp_footer', 'superwebshare_amp_floating_button_code');

/**
* Function to check this is AMP page/request 
 *
 * @since 2.1
 * @return bool
*/
function superwebshare_is_amp(){
	return ( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ) || // In plugin AMP, 2.0 Renamed to AMP-prefixed version, amp_is_request().
	( function_exists( 'ampforwp_is_amp_endpoint' ) && ampforwp_is_amp_endpoint() ) ||
	( function_exists( 'amp_is_request' ) && amp_is_request() );
}

/**
	 * Checking to display the button 
	 *
	 * $type normal | floating
	 * @return string Icon for Share Button
	 * @since 2.1
*/
function can_display_button( $type,  $settings = [] ){
	if( is_404() ){
		return false;
	}

	//Settings reload if General(normal) settings is empty;
	if( $type == 'inline' && empty( $settings ) ){
		$settings = superwebshare_get_settings_inline();
	}

	//Settings reload if Floating settings is empty;
	if( $type == 'floating' && empty( $settings ) ){
		$settings = superwebshare_get_settings_floating();
	}

	if( ! isset( $settings[ "superwebshare_{$type}_enable" ] ) ){
		return true;
	}

	if( isset( $settings[ "superwebshare_{$type}_enable" ] ) && $settings[ "superwebshare_{$type}_enable" ] != 'enable' ){
		return false;
	}

	$allowed_pages = isset( $settings[ "${type}_display_pages" ] ) ? $settings[ "${type}_display_pages" ] : [] ;
	$current_post_type = get_post_type();

	if( is_home() || is_front_page() ){

		if( in_array( 'home', $allowed_pages ) || empty(  $allowed_pages ) ){
			return true;
		}else{
			return false;
		}
	}

	//if empty it will be new plugin installation and allow to display all pages.
	$option_key = $type == "inline" ? 'superwebshare_inline_settings' : 'superwebshare_floating_settings';
	if( empty( $allowed_pages ) && !get_option( $option_key ) ){

		$post_types = superwebshare_get_pages();
		// Some pages wont allow to show the display in our side.
		if( key_exists( $current_post_type, $post_types ) && !is_archive() ){

			return true;
		}else{
			return false;
		}

	}

	if( in_array( $current_post_type, $allowed_pages ) ){
		return true;
	}else{
		return false;
	}

} 