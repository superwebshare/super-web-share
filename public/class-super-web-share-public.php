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
			add_action( 'amp_post_template_head', 'superwebshare_amp_add_social_share_head', 0 );
			add_action('the_content', 'superwebshare_inline_amp_button_code');
			add_action('amp_post_template_footer', 'superwebshare_amp_floating_button_code');

			add_action( 'amp_post_template_css', function() {
				
				$style_path = plugin_dir_path( __FILE__ ) . 'css/super-web-share-public.css' ;
				if( file_exists( $style_path ) ){
					echo file_get_contents( $style_path );
					
				}

				$amp_style_path = plugin_dir_path( __FILE__ ) . 'css/super-web-share-amp-public.css' ;
				if( file_exists( $amp_style_path ) ){
					echo file_get_contents( $amp_style_path );
					echo ".superwebshare_prompt::before { 
						background-image: url('" . trim( plugin_dir_url( __FILE__ ), "/" ) . "/assets/android_share.svg');
					}";
				}

		   } );
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
		if ( superwebshare_is_amp() ) {
			wp_enqueue_style( $this->plugin_name . "-amp", plugin_dir_url( __FILE__ ) . 'css/super-web-share-amp-public.css', array(), $this->version, 'all' );
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

			if( ! can_display_button_page_wise( ) ){
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
				
				// We won't add button to page if the button prevent in page settings OR the page is single product page.

				if( ! can_display_button_page_wise( 'inline' ) ){
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

		if( ! can_display_button( 'inline' ) ){
			return false;
		}
		
	}
 	if( is_home() ){
		 return false;
	 }

	$button = '<div class="sws_supernormalaction"><button  on="tap:superwebshare-lightbox" class="superwebshare_normal_button1 superwebshare_prompt" style="background-color: '. $color .';";>'.'<span>'. $text .'</span></button></div>';

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
			$fallback_enabled = empty( $settings_fallback[ 'superwebshare_fallback_enable' ] ) ? 'enable' : $settings_fallback[ 'superwebshare_fallback_enable' ];
			
			if( $fallback_enabled != 'enable'  ){
				return false;
			}

			$layout =  empty( $settings_fallback[ 'fallback_layout' ] ) ? 1 : $settings_fallback[ 'fallback_layout' ] ;
    		if ( can_display_button( 'inline' ) ||  can_display_button( 'floating' ) ) {
				$page_url = is_home() ? urlencode( home_url() ) : urlencode( get_the_permalink() );
				$copy_url = is_home() ? home_url() : get_the_permalink();

				$default_bg =  superwebshare_settings_default( 'fallback' )[ 'fallback_modal_background' ];

				echo '
				<div class="sws-modal-bg sws-layout-' . $layout . '">
				<div class="modal-container" style="background-color: ' . ( empty( $settings_fallback['fallback_modal_background'] )  ? $default_bg : $settings_fallback['fallback_modal_background'] ) . '" >
						<div class="modal-title">
							Share
						</div>
						
						<div class="sws-modal-content">
							<div class="sws-links">
								<a  target="_blank" class="sws-open-in-tab" href="https://www.facebook.com/sharer/sharer.php?u=' . $page_url . '" rel="nofollow noreferrer"><i class="sws-icon sws-icon-facebook"></i><p>Facebook</p></a>
								<a  target="_blank" class="sws-open-in-tab" href="http://twitter.com/share?text=' . urlencode( get_the_title() ) . '&url=' . $page_url . '" rel="nofollow noreferrer"> <i  class="sws-icon sws-icon-twitter"></i><p> Twitter</p></a>
								<a  target="_blank" class="sws-open-in-tab" href="https://www.linkedin.com/sharing/share-offsite/?url=' . $page_url . '" rel="nofollow noreferrer"> <i  class="sws-icon sws-icon-linked-in"></i> <p>LinkedIn</p></a>
								<a  target="_blank" href="https://api.whatsapp.com/send/?text=' . $page_url . '" rel="nofollow noreferrer"> <i  class="sws-icon sws-icon-whatsapp"></i> <p>WhatsApp</p></a>
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
	
		superwebshare_add_amp_js_settings();
	}
	
}

/**
* AMP social share JS script
*
* @return string Icon for Share Button
 * @since 2.2
*/
function superwebshare_add_amp_js_settings(){

	if( ! can_display_button_page_wise( ) || ! can_display_button_page_wise( 'inline' ) ){
		return;
	}
	
	$settings_inline = superwebshare_get_settings_inline();
	$settings_floating = superwebshare_get_settings_floating();
	$settings_fallback = superwebshare_get_settings_fallback();

	$floating_on_amp =  empty( $settings_floating[ 'floating_amp_enable' ] ) ? 'enable' : $settings_floating[ 'floating_amp_enable' ];
	$inline_on_amb = empty( $settings_inline[ 'inline_amp_enable' ] ) ? 'enable' : $settings_inline[ 'inline_amp_enable' ];
	$fallback_on_amp = empty( $settings_fallback[ 'superwebshare_fallback_enable' ] ) ? 'enable' : $settings_fallback[ 'superwebshare_fallback_enable' ];

	if ( $settings_inline[ 'inline_amp_enable' ] == 'enable' || $settings_floating[ 'floating_amp_enable' ] == 'enable' ){

		$tags = '';
		if( can_display_button( 'inline', $settings_inline ) || can_display_button( 'floating', $settings_floating )  ){
			
			$tags .= '<script async custom-element="amp-social-share" src="https://cdn.ampproject.org/v0/amp-social-share-0.1.js"></script>';

			if( ( ( can_display_button( 'inline', $settings_inline ) && $inline_on_amb == 'enable' ) || ( can_display_button( 'floating', $settings_floating ) &&$floating_on_amp == 'enable' ) ) && $fallback_on_amp == "enable"  ){
				$tags .= '<script async custom-element="amp-lightbox" src="https://cdn.ampproject.org/v0/amp-lightbox-0.1.js"></script>';
				$tags .= '<script async custom-element="amp-bind" src="https://cdn.ampproject.org/v0/amp-bind-0.1.js"></script>';

			}
			
			echo $tags ;

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

	if( ! can_display_button_page_wise( 'inline' ) ){
		return $content;
	}
	if( is_home() ){
		return false;
	}

	if ( superwebshare_is_amp() ) {
		$settings = superwebshare_get_settings_inline();
		$settings_fallback = superwebshare_get_settings_fallback();
		$fallback_on_amp = empty( $settings_fallback[ 'superwebshare_fallback_enable' ] ) ? 'enable' : $settings_fallback[ 'superwebshare_fallback_enable' ];
		if ( can_display_button( 'inline', $settings ) ) {

			$pos = $settings['inline_position'];
			$button_text = empty( $settings[ 'inline_button_share_text' ] ) ? 'Share' : $settings[ 'inline_button_share_text' ];
			$bg_color = empty( $settings[ 'inline_button_share_color' ] ) ? "#BD3854" : $settings[ 'inline_button_share_color' ];
			if ($settings['inline_amp_enable'] == 'enable'){
				ob_start();
				?>
				
				<div class="sws_supernormalaction">
					<?php 
					if( $fallback_on_amp == "enable" ){ 
						superwebshare_inline_button( $button_text, $bg_color );
						?>
					<?php }else{  ?>
						<amp-social-share type="system" width="48" height="48" class="superwebshare_amp_native_button superwebshare_amp_native_button_inline" style="background-color: <?= $bg_color ?>"></amp-social-share>
					<?php } ?>
				</div> 
				<?php
				$html = ob_get_clean();
				switch ( $pos ) {
					case 'before':
						$content =$html . $content;
						break;
					case 'after':
						$content = $content .$html;
						break;
					case 'both':
						$content =$html . $content .$html;
						break;
					case 'manual':
						break;
					default:
						$content = $content .$html;
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

	if( ! can_display_button_page_wise( ) ){
		return ;
	}

	if ( superwebshare_is_amp() ) {
		$settings_floating = superwebshare_get_settings_floating();
		$settings_inline = superwebshare_get_settings_inline();
		$settings_fallback = superwebshare_get_settings_fallback();

		$floating_on_amp =  empty( $settings_floating[ 'floating_amp_enable' ] ) ? 'enable' : $settings_floating[ 'floating_amp_enable' ];
		$inline_on_amb = empty( $settings_inline[ 'inline_amp_enable' ] ) ? 'enable' : $settings_inline[ 'inline_amp_enable' ];
		$fallback_on_amp = empty( $settings_fallback[ 'superwebshare_fallback_enable' ] ) ? 'enable' : $settings_fallback[ 'superwebshare_fallback_enable' ];

		if ( can_display_button( 'floating', $settings_floating ) && $floating_on_amp == 'enable' ) {

			$default_pos_value = 24;
			$button_text = $settings_floating[ 'floating_button_text' ];
			$bg_color = empty( $settings_floating[ 'floating_share_color' ] ) ? "#BD3854" : $settings_floating[ 'floating_share_color' ];
			$left_right = empty( $settings_floating[ 'floating_position_leftright' ] ) ? $default_pos_value : (int) $settings_floating['floating_position_leftright'] + $default_pos_value;
			$bottom = empty ( $settings_floating[ 'floating_position_bottom' ] ) ? $default_pos_value : (int) $settings_floating[ 'floating_position_bottom' ] + $default_pos_value;

			if ( $settings_floating[ 'floating_amp_enable' ] == 'enable'){
				?>
				<!-- Floating Button by SuperWebShare - Native Share Plugin for WordPress -->
				
				<div class="sws_superaction superwebshare_amp_floating_button_box" style="<?= $settings_floating[ 'floating_position' ] . ':' . $left_right . 'px; bottom: ' . $bottom . 'px' ?>" >
				<?php 
				if( $fallback_on_amp == "enable" ){
					?>
						<button  type="button" class="superwebshare_tada rounded superwebshare_button superwebshare_prompt superwebshare_amp_fallback_button" on="tap:superwebshare-lightbox" style="background-color: <?= $bg_color ?>">
							<span> <?php _e( $button_text, 'superwebshare' ) ?></span>
						</button>
					<?php
				}else{
					?>
						<amp-social-share type="system" width="48" height="48" style="background-color:<?= $settings_floating[ 'floating_share_color' ] ?>" class="superwebshare_amp_native_button superwebshare_amp_native_button_floating"></amp-social-share>
					<?php
				}
				?>
					
				</div>
				<?php
			}
		}
		
		
		if( ( ( can_display_button( 'inline', $settings_inline ) && $inline_on_amb == 'enable' ) || ( can_display_button( 'floating', $settings_floating ) &&$floating_on_amp == 'enable' ) ) && $fallback_on_amp == "enable" ){
			
			?>
			<amp-lightbox id="superwebshare-lightbox" layout="nodisplay">
				<div class="superwebshare-lightbox" on="tap:superwebshare-lightbox.close" role="button" tabindex="0">
					<div class="">

						<!-- <amp-social-share class="rounded" aria-label="Share on Facebook" type="facebook" data-param-app_id="254325784911610" width="48" height="48"></amp-social-share> -->

						<!-- <amp-social-share class="rounded" aria-label="Share on Pinterest" type="pinterest" data-param-media="https://amp.dev/static/samples/img/amp.jpg" width="48" height="48"></amp-social-share> -->
						<?php 
						if( $fallback_on_amp == 'enable' ){
							?>
								<amp-social-share class="rounded" aria-label="Share on Twitter" type="twitter" width="48" height="48"></amp-social-share>
								<amp-social-share type="linkedin" aria-label="Share on LinkedIn" width="48" height="48"></amp-social-share>
								<amp-social-share class="rounded" aria-label="Share on WhatsApp" type="whatsapp" width="48" height="48"></amp-social-share>
							<?php
						}
						?>
						<amp-social-share type="system" width="48" height="48" class="superwebshare_amp_native_button"></amp-social-share>
						
					</div>
					
				</div>
			</amp-lightbox>
			<?php
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

	if( is_404() || is_archive() ){
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

	$allowed_pages = isset( $settings[ "{$type}_display_pages" ] ) && is_array( $settings[ "{$type}_display_pages" ] ) ? $settings[ "{$type}_display_pages" ] : [] ;
	$current_post_type = (string)get_post_type();

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

	if( in_array( $current_post_type, $allowed_pages )  ){
		return true;
	}else{
		return false;
	}

} 

function can_display_button_page_wise( $type = 'floating' ){
	$post = get_post();

	if( ! empty( $post ) ){
		if( 
			( isset( $post->{"_superwebshare_post_{$type}_active"} ) && empty( $post->{"_superwebshare_post_{$type}_active"} ) ) || 
			( ! empty( $post->{"_superwebshare_post_{$type}_active"} ) && $post->{"_superwebshare_post_{$type}_active"} != 'enable' ) || 
			get_post_type() === "product"  
			){
				return false;
		}else{
			return true;
		}
	}else{
		return false;
	}
}
