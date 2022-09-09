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

			add_action('the_content', 'superwebshare_inline_amp_button_code');
			add_action('amp_post_template_footer', 'superwebshare_amp_floating_button_code');

			add_action( 'amp_post_template_css', function() {
				
				$style_path = plugin_dir_path( __FILE__ ) . 'css/super-web-share-public.min.css' ;
				if( file_exists( $style_path ) ){
					echo file_get_contents( $style_path );
					
				}

				$amp_style_path = plugin_dir_path( __FILE__ ) . 'css/super-web-share-amp-public.min.css' ;
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
		
		wp_register_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/super-web-share-public.min.css', array(), $this->version, 'all'  );

		wp_register_style( $this->plugin_name . "-amp", plugin_dir_url( __FILE__ ) . 'css/super-web-share-amp-public.min.css', array(), $this->version, 'all' );

		if ( can_display_button( 'inline' ) || can_display_button( 'floating' ) ) {

			wp_enqueue_style( $this->plugin_name );
		
		}
		if ( superwebshare_is_amp() ) {

			wp_enqueue_style( $this->plugin_name . "-amp" );
			
		}
	}
	/**
	 * Register the JavaScript for the public-facing side of the site.
	 * The JavaScript file won't register on the AMP pages, as JS won't work within the AMP.
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		
		wp_register_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/super-web-share-public.min.js', array(), $this->version, true );

		if ( ! superwebshare_is_amp() ) {
			if ( can_display_button( 'inline' ) || can_display_button( 'floating' )  ) {

				wp_enqueue_script( $this->plugin_name );
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

		$settings_appearance = superwebshare_get_settings_appearance(); 
		$icon_name = empty( $settings_appearance[ 'superwebshare_appearance_button_icon' ] ) ? "share-icon-1" : $settings_appearance[ 'superwebshare_appearance_button_icon' ];
		$button_size = empty( $settings_appearance[ 'superwebshare_appearance_button_size' ] ) ? "large" : $settings_appearance[ 'superwebshare_appearance_button_size' ];
		$button_style = empty( $settings_appearance[ 'superwebshare_appearance_button_style' ] ) ? "style-1" : $settings_appearance[ 'superwebshare_appearance_button_style' ];

		$icon_class = new Super_Web_Share_Icons();
		$icon = $icon_class->get_icon( $icon_name );

		if ( can_display_button( 'floating', $settings_floating ) ) {

			if( ! can_display_button_page_wise( ) ){
				return;
			}

			$floatingbuttontext = empty( $settings_floating[ 'floating_button_text' ] ) ? 'Share' : $settings_floating[ 'floating_button_text' ];

			$tags  = '<!-- Floating Button by SuperWebShare - Native Share Plugin for WordPress -->' . PHP_EOL;
			echo '<div class="sws_superaction" style="'. esc_html( $settings_floating['floating_position'] ) .':24px"><button class="superwebshare_tada superwebshare_button superwebshare_button_svg superwebshare_prompt superwebshare-button-' . esc_html( $button_size ) . ' superwebshare-button-' . esc_html( $button_style ) . ' " style="background-color: '. esc_html( $settings_floating['floating_share_color'] ) .'; '. esc_html( $settings_floating['floating_position'] ) .':'. esc_html( $settings_floating['floating_position_leftright'] ) .'px; bottom:'. esc_html( $settings_floating['floating_position_bottom'] ) .'px;";> ' . $icon . '  <span> ' .  esc_html( $floatingbuttontext ) . ' </span></button></div>' . PHP_EOL;
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
			if (  can_display_button( 'inline', $settings ) && get_post_type() != "product" ) {

				$pos = $settings['inline_position'];

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

	// We won't add button to page if the button prevent in page settings OR the page is single product page.

	if( ! can_display_button_page_wise( 'inline' ) ){
		return "";
	}

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

	$settings_appearance = superwebshare_get_settings_appearance(); 
	$icon_name = empty( $settings_appearance[ 'superwebshare_appearance_button_icon' ] ) ? "share-icon-1" : $settings_appearance[ 'superwebshare_appearance_button_icon' ];
	$button_size = empty( $settings_appearance[ 'superwebshare_appearance_button_size' ] ) ? "large" : $settings_appearance[ 'superwebshare_appearance_button_size' ];
	$button_style = empty( $settings_appearance[ 'superwebshare_appearance_button_style' ] ) ? "style-1" : $settings_appearance[ 'superwebshare_appearance_button_style' ];

	$icon_class = new Super_Web_Share_Icons();
	$icon = $icon_class->get_icon( $icon_name );

	$button = '<div class="sws_supernormalaction"><button on="tap:superwebshare-lightbox" class="superwebshare_normal_button1 superwebshare-button-' . esc_html( $button_size ) . ' superwebshare-button-' . esc_html( $button_style ) . ' superwebshare_prompt superwebshare_button_svg" style="background-color: '. esc_html( $color ) .';" >'. $icon .'<span>'. esc_html( $text ) .'</span></button></div>';

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

			
    		if ( can_display_button( 'inline' ) ||  can_display_button( 'floating' ) ) {
				$twitter_via =  empty( $settings_fallback[ 'fallback_twitter_via' ] ) ? "" : $settings_fallback[ 'fallback_twitter_via' ];
				$layout =  empty( $settings_fallback[ 'fallback_layout' ] ) ? 1 : $settings_fallback[ 'fallback_layout' ] ;
				$default_bg =  superwebshare_settings_default( 'fallback' )[ 'fallback_modal_background' ];
				$bg =  empty( $settings_fallback['fallback_modal_background'] )  ? $default_bg : $settings_fallback['fallback_modal_background'] ;

				superwebshare_fallback_modal( array(
					'layout' => $layout,
					'bg' => $bg,
					'twitter_via' => $twitter_via

				) );

			}
		}
	}

/**
 * @since 2.3
 */
function superwebshare_fallback_modal( $args, $echo = true ){

	// Just blocking multiple render html.
    static $fallback_modal_called = false;
    if ( $fallback_modal_called ) return false;
	$fallback_modal_called = true;

	$args = wp_parse_args( $args, array(
		'layout' 		=> 1,
		'bg'			=> '#BD3854',
		'twitter_via'	=> ""
	 ) );

	 $args[ 'twitter_via' ] = empty( $args[ 'twitter_via' ] ) ? "" : "&via=" . $args[ 'twitter_via' ];

	  ob_start();

	 ?>
			<div class="sws-modal-bg sws-layout-<?= $args[ 'layout' ] ?>">
				<div class="modal-container" style="background-color: <?= $args[ 'bg' ] ?>" >
						<div class="modal-title">
							<?= _e( 'Share', 'super-web-share' ) ?>
						</div>
						
						<div class="sws-modal-content">
							<div class="sws-links">
								<a  target="_blank" href="#" class="sws-open-in-tab" data-type='facebook' rel="nofollow noreferrer"> <i class="sws-icon sws-icon-facebook"></i><p> <?= _e( 'Facebook', 'super-web-share' ) ?></p></a>
								<a  target="_blank" href="#" class="sws-open-in-tab" data-type='twitter' data-params='<?=$args[ 'twitter_via' ]?>' rel="nofollow noreferrer"> <i  class="sws-icon sws-icon-twitter"></i><p> <?= _e( 'Twitter', 'super-web-share' ) ?></p></a>
								<a  target="_blank" href="#" class="sws-open-in-tab" data-type='linkedin' rel="nofollow noreferrer"> <i  class="sws-icon sws-icon-linked-in"></i> <p> <?= _e( 'LinkedIn', 'super-web-share' ) ?> </p></a>
								<a  target="_blank" href="#" class="sws-open-in-tab" data-type='whatsapp' rel="nofollow noreferrer"> <i  class="sws-icon sws-icon-whatsapp"></i> <p><?= _e( 'WhatsApp', 'super-web-share' ) ?></p></a>
							</div>
							<div class="sws-copy">
								<a href="#" > <i  class="sws-icon sws-icon-copy"></i><span><?= _e( 'Copy Link', 'super-web-share' ) ?></span></a>
							</div>

						</div>
						<a href="#" class="sws-modal-close">×</a>
					</div>
				</div>
				
	<?php
	 $html = ob_get_clean();
	if( $echo ){
		echo $html;
	}else{
		return $html ;
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

	if( can_display_button_page_wise( ) || can_display_button_page_wise( 'inline' ) ){
		superwebshare_amp_modal();
	}

	if( ! can_display_button_page_wise( ) ){
		return ;
	}

	if ( superwebshare_is_amp() ) {
		$settings_floating = superwebshare_get_settings_floating();
		
		$settings_fallback = superwebshare_get_settings_fallback();

		$floating_on_amp =  empty( $settings_floating[ 'floating_amp_enable' ] ) ? 'enable' : $settings_floating[ 'floating_amp_enable' ];

		$fallback_on_amp = empty( $settings_fallback[ 'superwebshare_fallback_enable' ] ) ? 'enable' : $settings_fallback[ 'superwebshare_fallback_enable' ];

		if ( can_display_button( 'floating', $settings_floating ) && $floating_on_amp == 'enable' ) {

			$settings_appearance = superwebshare_get_settings_appearance(); 
			$icon_name = empty( $settings_appearance[ 'superwebshare_appearance_button_icon' ] ) ? "share-icon-1" : $settings_appearance[ 'superwebshare_appearance_button_icon' ];
			$button_size = empty( $settings_appearance[ 'superwebshare_appearance_button_size' ] ) ? "large" : $settings_appearance[ 'superwebshare_appearance_button_size' ];
			$button_style = empty( $settings_appearance[ 'superwebshare_appearance_button_style' ] ) ? "style-1" : $settings_appearance[ 'superwebshare_appearance_button_style' ];

			$icon_class = new Super_Web_Share_Icons();
			$icon = $icon_class->get_icon( $icon_name );

			$default_pos_value = 24;
			$button_text = $settings_floating[ 'floating_button_text' ];
			$bg_color = empty( $settings_floating[ 'floating_share_color' ] ) ? "#BD3854" : $settings_floating[ 'floating_share_color' ];
			$left_right = empty( $settings_floating[ 'floating_position_leftright' ] ) ? $default_pos_value : (int) $settings_floating['floating_position_leftright'] + $default_pos_value;
			$bottom = empty ( $settings_floating[ 'floating_position_bottom' ] ) ? $default_pos_value : (int) $settings_floating[ 'floating_position_bottom' ] + $default_pos_value;

			if ( $settings_floating[ 'floating_amp_enable' ] == 'enable'){
				?>
				<!-- Floating Button by SuperWebShare - Native Share Plugin for WordPress -->
				
				<div class="sws_superaction superwebshare_amp_floating_button_box" style="<?= esc_html( $settings_floating[ 'floating_position' ] ) . ':' . esc_html( $left_right ) . 'px; bottom: ' . esc_html( $bottom ) . 'px' ?>" >
				<?php 
				if( $fallback_on_amp == "enable" ){
					?>
						<button  type="button" class="superwebshare_tada superwebshare_button  superwebshare_button_svg superwebshare_prompt superwebshare_amp_fallback_button superwebshare-button-<?= esc_html( $button_size ) ?> superwebshare-button-<?= esc_html( $button_style ) ?> "  on="tap:superwebshare-lightbox"  style="background-color: <?= esc_html( $settings_floating['floating_share_color'] ) ?>;"> <?= $icon ?>
							<span>
								<?php esc_html_e( $button_text, 'superwebshare' ) ?>
							</span>
						</button>
						<!-- <button  type="button" class="superwebshare_tada rounded superwebshare_button superwebshare_prompt superwebshare_amp_fallback_button" on="tap:superwebshare-lightbox" style="background-color: <?= esc_html( $bg_color ) ?>">
							<span> <?php esc_html_e( $button_text, 'superwebshare' ) ?></span>
						</button> -->
					<?php
				}else{
					?>
						<amp-social-share type="system" width="48" height="48" style="background-color:<?= esc_html( $settings_floating[ 'floating_share_color' ] ) ?>" class="superwebshare_amp_native_button superwebshare_amp_native_button_floating"></amp-social-share>
					<?php
				}
				?>
					
				</div>
				<?php
			}
		}
		
	}
}
add_action('wp_footer', 'superwebshare_amp_floating_button_code');

/**
 * Function to display AMP Modal
 * @since 2.3
 */

function superwebshare_amp_modal( $force_display = false  ){

	// Just blocking multiple render html.
    static $superwebshare_amp_called = false;
    if ( $superwebshare_amp_called ) return false;
	$superwebshare_amp_called = true;

	$settings_floating = superwebshare_get_settings_floating();
	$settings_inline = superwebshare_get_settings_inline();
	$settings_fallback = superwebshare_get_settings_fallback();

	$floating_on_amp =  empty( $settings_floating[ 'floating_amp_enable' ] ) ? 'enable' : $settings_floating[ 'floating_amp_enable' ];
	$inline_on_amp = empty( $settings_inline[ 'inline_amp_enable' ] ) ? 'enable' : $settings_inline[ 'inline_amp_enable' ];
	$fallback_on_amp = empty( $settings_fallback[ 'superwebshare_fallback_enable' ] ) ? 'enable' : $settings_fallback[ 'superwebshare_fallback_enable' ];
	
	if( ( ( ( can_display_button( 'inline', $settings_inline ) && $inline_on_amp == 'enable' ) || ( can_display_button( 'floating', $settings_floating ) && $floating_on_amp == 'enable' ) ) && $fallback_on_amp == "enable" ) || $force_display ){
	
		?>
		<amp-lightbox id="superwebshare-lightbox" layout="nodisplay">
			<div class="superwebshare-lightbox" on="tap:superwebshare-lightbox.close" role="button" tabindex="0">
				<div class="">
					<?php 
					if( $fallback_on_amp == 'enable' || $force_display ){
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

	if( is_404() || is_archive() || is_search() ){
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
			( ! empty( $post->{"_superwebshare_post_{$type}_active"} ) && $post->{"_superwebshare_post_{$type}_active"} != 'enable' ) 
			){
				return false;
		}else{
			return true;
		}
	}else{
		return false;
	}
}

/**
 * Shortocde
 * @since 2.3
 */

if ( ! function_exists( 'super_web_share_shortcode' ) ) {

    function super_web_share_shortcode( $attr ) {

		if( is_archive() ) return;
		
		$container_class = "sws_supernormalaction"; $floating_class = "";$floating_parent_style="";
        wp_enqueue_style( 'super-web-share' );
		
		if( ! superwebshare_is_amp() ){

			wp_enqueue_script( 'super-web-share' );
			add_action( 'wp_footer', 'super_web_share_fallback_modal_for_shortcode' );

		}

		$attr = shortcode_atts( array(
			'type'					=> 'inline', 	// inline, floating
			'color'					=> '#BD3854',
			'text'					=> 'Share',
			'style' 				=> 'default', 	// default, curved, square, circle
			'size'					=> 'large', 	// large, medium, small
			'icon' 					=> 'share-icon-1',
			'fallback'				=> 'yes',		// yes, no
			'floating-position' 	=> 'right',		// right, left
			'floating-from-side' 	=> '5px',		// Pix value
			'floating-from-bottom'	=> '5px',		// Pix value
		),
		$attr,
		'super_web_share' );

		$pos = in_array( $attr[ 'floating-position' ], [ 'right', 'left' ] ) ?  $attr[ 'floating-position' ] : 'right';
		
		if( $attr[ 'type' ] == 'floating' ){
			$floating_class = 'superwebshare_tada';
			$container_class = "sws_superaction";
			
			$floating_parent_style = 'style="'. $pos .': 24px;"';
		}

		$icon_class = new Super_Web_Share_Icons();
		$icon = $icon_class -> get_icon( $attr[ 'icon' ] );
		$floating_class .= $attr[ 'fallback' ] != "yes" ? " sws-fallback-off" : "";

		ob_start();
		?>
		<div class="<?= esc_html( $container_class )  ?>" <?= $floating_parent_style ?> >
			<?php
			if( superwebshare_is_amp() &&  $attr[ 'fallback' ] != "yes" ){
				?>
					<amp-social-share type="system" width="48" height="48" style="background-color:<?= esc_html( $attr[ 'color' ] ) ?>" class="superwebshare_amp_native_button superwebshare_amp_native_button_floating"></amp-social-share>
				<?php
			}else{
				if( superwebshare_is_amp() &&  $attr[ 'fallback' ] == "yes" ){
					superwebshare_amp_modal( true );
				}
				?>
				<button on="tap:superwebshare-lightbox" class=" <?= esc_html( $floating_class ) ?> superwebshare_normal_button1 shortcode-button superwebshare-button-<?= esc_html( $attr[ 'size' ] ) ?> superwebshare-button-<?= esc_html( $attr[ 'style' ] ) ?> superwebshare_prompt superwebshare_button_svg"
				style="background-color: <?= esc_html( $attr[ 'color' ] ) .';' . $pos . ':'. esc_html( $attr[ 'floating-from-side' ] ) .';bottom:'. esc_html( $attr[ 'floating-from-bottom' ] )  ?>" >
				<?= $icon ?> <span> <?= esc_html( $attr[ 'text' ] ) ?></span></button>
				<?php
			}
			?>
		</div>
		<?php

		return ob_get_clean();
    }

    add_shortcode( 'super_web_share', 'super_web_share_shortcode' );

}

/**
 * To show the fallback modal
 * @since 2.3
 */

function super_web_share_fallback_modal_for_shortcode(){

	$settings_fallback = superwebshare_get_settings_fallback();

	$twitter_via =  empty( $settings_fallback[ 'fallback_twitter_via' ] ) ? "" : $settings_fallback[ 'fallback_twitter_via' ];
	$layout =  empty( $settings_fallback[ 'fallback_layout' ] ) ? 1 : $settings_fallback[ 'fallback_layout' ] ;
	$default_bg =  superwebshare_settings_default( 'fallback' )[ 'fallback_modal_background' ];
	$bg =  empty( $settings_fallback['fallback_modal_background'] )  ? $default_bg : $settings_fallback['fallback_modal_background'] ;

	superwebshare_fallback_modal( 
		array(
		'layout' => $layout,
		'bg' => $bg,
		'twitter_via' => $twitter_via

	) );
}
