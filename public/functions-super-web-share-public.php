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
 * Floating Share Button
 *
 * @since 1.0
 */
function superwebshare_floating_button_code() {
	if ( ! superwebshare_is_amp() ) {
		$settings_floating = superwebshare_get_settings_floating();

		$settings_appearance = superwebshare_get_settings_appearance();
		$icon_name           = empty( $settings_appearance['superwebshare_appearance_button_icon'] ) ? 'share-icon-1' : $settings_appearance['superwebshare_appearance_button_icon'];
		$button_size         = empty( $settings_appearance['superwebshare_appearance_button_size'] ) ? 'large' : $settings_appearance['superwebshare_appearance_button_size'];
		$button_style        = empty( $settings_appearance['superwebshare_appearance_button_style'] ) ? 'style-1' : $settings_appearance['superwebshare_appearance_button_style'];
		$text_color          = empty( $settings_appearance['superwebshare_appearance_button_text_color'] ) ? '#fff' : $settings_appearance['superwebshare_appearance_button_text_color'];

		$icon_class = new Super_Web_Share_Icons();
		$icon       = $icon_class->get_icon( $icon_name );

		if ( can_display_button( 'floating', $settings_floating ) ) {

			if ( ! can_display_button_page_wise() ) {
				return;
			}

			$floatingbuttontext = empty( $settings_floating['floating_button_text'] ) ? 'Share' : $settings_floating['floating_button_text'];

			$tags = '<!-- Floating Button by SuperWebShare - Native Share Plugin for WordPress -->' . PHP_EOL;
			echo '<div class="sws_superaction" style="' . esc_html( $settings_floating['floating_position'] ) . ':24px">
			<button class="superwebshare_tada superwebshare_button superwebshare_button_svg superwebshare_prompt superwebshare-button-' . esc_html( $button_size ) . ' superwebshare-button-' . esc_html( $button_style ) . ' " style="background-color: ' . esc_html( $settings_floating['floating_share_color'] ) . '; ' . esc_html( $settings_floating['floating_position'] ) . ':' . esc_html( $settings_floating['floating_position_leftright'] ) . 'px; bottom:' . esc_html( $settings_floating['floating_position_bottom'] ) . 'px;color: ' . esc_html( $text_color ) . ' " aria-label="Share">'
			. $icon . // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			'  <span> ' . esc_html( $floatingbuttontext ) . ' </span></button></div>' . PHP_EOL;
			echo $tags; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}
}

/**
 * The hook function  to initiate the super web share.
 *
 * @return void
 */
function superwebshare_wp_init() {

	add_action( 'woocommerce_product_meta_end', 'superwebshare_inline_button' );
}
add_action( 'init', 'superwebshare_wp_init' );

/**
 * Inline Share Button for all posts except Woocommerce products
 *
 * @param string $content The post content.
 * @return string Modified content
 * @since 1.2
 */
function superwebshare_inline_button_code( $content ) {
	if ( ! superwebshare_is_amp() ) {
		$settings = superwebshare_get_settings_inline();
		if ( can_display_button( 'inline', $settings ) && get_post_type() !== 'product' ) {

			$pos = $settings['inline_position'];

			$button = superwebshare_inline_button( $settings['inline_button_share_text'], $settings['inline_button_share_color'], false );
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
 * Inline Share Button.
 *
 * @param string  $text text.
 * @param string  $color default is #BD3854.
 * @param boolean $echo make it false if you won't echo by function self.
 * @since 2.2
 */
function superwebshare_inline_button( $text = '', $color = '', $echo = true ) {

	// We won't add button to page if the button prevent in page settings OR the page is single product page.

	if ( ! can_display_button_page_wise( 'inline' ) ) {
		return '';
	}

	if ( empty( $text ) ) {

		// Reding the settings if function called by empty $text.

		$settings = superwebshare_get_settings_inline();
		$text     = $settings['inline_button_share_text'];
		$color    = $settings['inline_button_share_color'];

		if ( ! can_display_button( 'inline' ) ) {
			return false;
		}
	}
	if ( is_home() ) {
		return false;
	}

	$settings_appearance = superwebshare_get_settings_appearance();
	$icon_name           = empty( $settings_appearance['superwebshare_appearance_button_icon'] ) ? 'share-icon-1' : $settings_appearance['superwebshare_appearance_button_icon'];
	$button_size         = empty( $settings_appearance['superwebshare_appearance_button_size'] ) ? 'large' : $settings_appearance['superwebshare_appearance_button_size'];
	$button_style        = empty( $settings_appearance['superwebshare_appearance_button_style'] ) ? 'style-1' : $settings_appearance['superwebshare_appearance_button_style'];
	$text_color          = empty( $settings_appearance['superwebshare_appearance_button_text_color'] ) ? '#ffffff' : $settings_appearance['superwebshare_appearance_button_text_color'];

	$icon_class = new Super_Web_Share_Icons();
	$icon       = $icon_class->get_icon( $icon_name );

	$button = '<div class="sws_supernormalaction"><button on="tap:superwebshare-lightbox" class="superwebshare_normal_button1 superwebshare-button-' . esc_html( $button_size ) . ' superwebshare-button-' . esc_html( $button_style ) . ' superwebshare_prompt superwebshare_button_svg" style="color:' . esc_html( $text_color ) . ';background-color: ' . esc_html( $color ) . ';" >' . $icon . '<span>' . esc_html( $text ) . '</span></button></div>';

	if ( $echo ) {
		echo apply_filters( 'superwebshare_inline_button', $button ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	} else {
		return apply_filters( 'superwebshare_inline_button', $button );
	}
}

/**
 * Inline Styles for Share Button (Icon).
 *
 * @param string $content The post content.
 * @return string Icon for Share Button.
 * @since 1.4.1
 */
function superwebshare_frontend_inline_styles( $content ) {

	if ( ! superwebshare_is_amp() ) {

		$settings_fallback = superwebshare_get_settings_fallback();
		$fallback_enabled  = empty( $settings_fallback['superwebshare_fallback_enable'] ) ? 'enable' : $settings_fallback['superwebshare_fallback_enable'];

		if ( 'enable' !== $fallback_enabled ) {
			return false;
		}

		if ( can_display_button( 'inline' ) || can_display_button( 'floating' ) ) {
			$twitter_via = empty( $settings_fallback['fallback_twitter_via'] ) ? '' : $settings_fallback['fallback_twitter_via'];
			$layout      = empty( $settings_fallback['fallback_layout'] ) ? 1 : $settings_fallback['fallback_layout'];
			$default_bg  = superwebshare_settings_default( 'fallback' )['fallback_modal_background'];
			$bg          = empty( $settings_fallback['fallback_modal_background'] ) ? $default_bg : $settings_fallback['fallback_modal_background'];

			superwebshare_fallback_modal(
				array(
					'layout'      => $layout,
					'bg'          => $bg,
					'twitter_via' => $twitter_via,
					'text_color'  => empty( $settings_fallback['fallback_text_color'] ) ? '#ffffff' : $settings_fallback['fallback_text_color'],
					'title'       => empty( $settings_fallback['fallback_title'] ) ? 'Share' : $settings_fallback['fallback_title'],
				)
			);

		}
	}
}

/**
 * The function for generate the fallback modal.
 *
 * @since 2.3
 * @param array   $args The arguments for the modal.
 * @param boolean $_echo make the function echo it self.
 * @return void|string
 */
function superwebshare_fallback_modal( $args, $_echo = true ) {

	// Just blocking multiple render HTML.
	static $fallback_modal_called = false;
	if ( $fallback_modal_called ) {
		return false;
	}
	$fallback_modal_called = true;

	$args = wp_parse_args(
		$args,
		array(
			'layout'      => 1,
			'bg'          => '#BD3854',
			'twitter_via' => '',
			'text_color'  => '#fff',
			'title'       => 'Share',
		)
	);

	$args['twitter_via'] = empty( $args['twitter_via'] ) ? '' : '&via=' . $args['twitter_via'];
	$settings_fallback   = superwebshare_get_settings_fallback();
	$networks            = sws_get_social_networks();
	$icon_class          = new Super_Web_Share_Icons();
	$text_color          = esc_html( $args['text_color'] );

		ob_start();

	?>
			<div class="sws-modal-bg sws-layout-<?php echo esc_attr( $args['layout'] ); ?>">
				<div class="modal-container" style="background-color: <?php echo esc_attr( $args['bg'] ); ?>;color:<?php echo esc_attr( $text_color ); ?>" >
						<div class="modal-title">
							<?php echo esc_html( $args['title'] ); ?>
						</div>
						
						<div class="sws-modal-content">
							<div class="sws-links" >
								<?php
								foreach ( $settings_fallback['fallback_social_networks'] as $social_network ) {
									$network = $networks[ $social_network ];
									?>
										<a  target="_blank" href="#" data-link="<?php echo esc_attr( $network['link'] ); ?>" data-params='<?php echo esc_html( $args['twitter_via'] ); ?>' style="color:<?php echo esc_attr( $text_color ); ?>" class="sws-open-in-tab sws-social-facebook" data-type='<?php echo esc_attr( $social_network ); ?>' rel="nofollow noreferrer noopener">
										<?php
											echo $icon_class->get_icon( $network['icon'], array( 'fill' => 3 === (int) $args['layout'] ? $network['color'] : esc_attr( $text_color ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
										?>
											<p> <?php echo esc_html( $network['name'] ); ?></p>
										</a> 
									<?php
								}
								?>
								
							</div>
							<div class="sws-copy">
								<a href="#" class="sws-copy-link" >
									<?php
										echo $icon_class->get_icon( 'icon-copy' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									?>
									<span data-copied-text="<?php echo esc_attr__( 'Link Copied ✔', 'super-web-share' ); ?>">
										<?php echo esc_html_e( 'Copy Link', 'super-web-share' ); ?>
									</span>
								</a>
							</div>

						</div>
						<a href="#" style="color:<?php echo esc_attr( $text_color ); ?>" class="sws-modal-close">×</a>
					</div>
				</div>
				
	<?php
	$html = ob_get_clean();
	if ( $_echo ) {
		echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	} else {
		return $html;
	}
}

/**
 * Fallback settings to register whether the settings is enabled or not on the browser.
 *
 * @return void Fallback
 * @since 2.0
 */
function superwebshare_add_js_settings() {
	if ( ! superwebshare_is_amp() ) {
		$settings = wp_json_encode( superwebshare_get_settings_fallback() );
		echo "<script type='text/javascript'>window.superWebShareFallback = $settings </script>"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

/**
 * AMP social share normal button code.
 *
 * @since 1.4.4
 * @param  string $content WordPress context text.
 * @return void|string normal amp
 */
function superwebshare_inline_amp_button_code( $content ) {

	if ( ! can_display_button_page_wise( 'inline' ) ) {
		return $content;
	}
	if ( is_home() ) {
		return false;
	}

	if ( superwebshare_is_amp() ) {
		$settings            = superwebshare_get_settings_inline();
		$settings_fallback   = superwebshare_get_settings_fallback();
		$settings_appearance = superwebshare_get_settings_appearance();
		$fallback_on_amp     = empty( $settings_fallback['superwebshare_fallback_enable'] ) ? 'enable' : $settings_fallback['superwebshare_fallback_enable'];
		if ( can_display_button( 'inline', $settings ) ) {

			$pos         = $settings['inline_position'];
			$button_text = empty( $settings['inline_button_share_text'] ) ? 'Share' : $settings['inline_button_share_text'];
			$bg_color    = empty( $settings['inline_button_share_color'] ) ? '#BD3854' : $settings['inline_button_share_color'];
			$text_color  = empty( $settings_appearance['superwebshare_appearance_button_text_color'] ) ? '#ffffff' : $settings_appearance['superwebshare_appearance_button_text_color'];
			if ( 'enable' === $settings['inline_amp_enable'] ) {
				ob_start();
				?>
				
				<div class="sws_supernormalaction">
					<?php
					if ( 'enable' === $fallback_on_amp ) {
						superwebshare_inline_button( $button_text, $bg_color );
						?>
					<?php } else { ?>
						<amp-social-share type="system" width="48" height="48" class="superwebshare_amp_native_button superwebshare_amp_native_button_inline" style="background-color: <?php echo esc_html( $bg_color ); ?>; color: <?php echo esc_html( $text_color ); ?>"></amp-social-share>
					<?php } ?>
				</div> 
				<?php
				$html = ob_get_clean();
				switch ( $pos ) {
					case 'before':
						$content = $html . $content;
						break;
					case 'after':
						$content = $content . $html;
						break;
					case 'both':
						$content = $html . $content . $html;
						break;
					case 'manual':
						break;
					default:
						$content = $content . $html;
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

	if ( superwebshare_is_amp() && ( can_display_button_page_wise() || can_display_button_page_wise( 'inline' ) ) ) {
		superwebshare_amp_modal();
	}

	if ( ! can_display_button_page_wise() ) {
		return;
	}

	if ( superwebshare_is_amp() ) {
		$settings_floating = superwebshare_get_settings_floating();

		$settings_fallback = superwebshare_get_settings_fallback();

		$floating_on_amp = empty( $settings_floating['floating_amp_enable'] ) ? 'enable' : $settings_floating['floating_amp_enable'];

		$fallback_on_amp = empty( $settings_fallback['superwebshare_fallback_enable'] ) ? 'enable' : $settings_fallback['superwebshare_fallback_enable'];

		if ( can_display_button( 'floating', $settings_floating ) && 'enable' === $floating_on_amp ) {

			$settings_appearance = superwebshare_get_settings_appearance();
			$icon_name           = empty( $settings_appearance['superwebshare_appearance_button_icon'] ) ? 'share-icon-1' : $settings_appearance['superwebshare_appearance_button_icon'];
			$button_size         = empty( $settings_appearance['superwebshare_appearance_button_size'] ) ? 'large' : $settings_appearance['superwebshare_appearance_button_size'];
			$button_style        = empty( $settings_appearance['superwebshare_appearance_button_style'] ) ? 'style-1' : $settings_appearance['superwebshare_appearance_button_style'];
			$text_color          = empty( $settings_appearance['superwebshare_appearance_button_text_color'] ) ? '#ffffff' : $settings_appearance['superwebshare_appearance_button_text_color'];

			$icon_class = new Super_Web_Share_Icons();
			$icon       = $icon_class->get_icon( $icon_name );

			$default_pos_value = 24;
			$button_text       = (string) $settings_floating['floating_button_text'];
			$bg_color          = empty( $settings_floating['floating_share_color'] ) ? '#BD3854' : $settings_floating['floating_share_color'];
			$left_right        = empty( $settings_floating['floating_position_leftright'] ) ? $default_pos_value : (int) $settings_floating['floating_position_leftright'] + $default_pos_value;
			$bottom            = empty( $settings_floating['floating_position_bottom'] ) ? $default_pos_value : (int) $settings_floating['floating_position_bottom'] + $default_pos_value;

			if ( 'enable' === $settings_floating['floating_amp_enable'] ) {
				?>
				<!-- Floating Button by SuperWebShare - Native Share Plugin for WordPress -->
				
				<div class="sws_superaction superwebshare_amp_floating_button_box" style="<?php echo esc_html( $settings_floating['floating_position'] ) . ':' . esc_html( $left_right ) . 'px; bottom: ' . esc_html( $bottom ) . 'px'; ?>" >
				<?php
				if ( 'enable' === $fallback_on_amp ) {
					?>
						<button  type="button" class="superwebshare_tada superwebshare_button  superwebshare_button_svg superwebshare_prompt superwebshare_amp_fallback_button superwebshare-button-<?php echo esc_html( $button_size ); ?> superwebshare-button-<?php echo esc_html( $button_style ); ?> "  on="tap:superwebshare-lightbox"  style="background-color: <?php echo esc_html( $settings_floating['floating_share_color'] ); ?>;">
						<?php
							echo $icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						?>
							<span>
								<?php esc_html( $button_text ); ?>
							</span>
						</button>
					<?php
				} else {
					?>
						<amp-social-share type="system" width="48" height="48" style="background-color:<?php echo esc_html( $settings_floating['floating_share_color'] ); ?>; color: <?php echo esc_html( $text_color ); ?>" class="superwebshare_amp_native_button superwebshare_amp_native_button_floating"></amp-social-share>
					<?php
				}
				?>
					
				</div>
				<?php
			}
		}
	}
}
add_action( 'wp_footer', 'superwebshare_amp_floating_button_code' );

/**
 * Function to display AMP Modal.
 *
 * @since 2.3
 * @param  boolean $force_display Forcefully show the fallback no matter the what user saved on admin dashboard.
 * @return boolean|void
 */
function superwebshare_amp_modal( $force_display = false ) {

	// Just blocking multiple render html.
	static $superwebshare_amp_called = false;
	if ( $superwebshare_amp_called ) {
		return false;
	}
	$superwebshare_amp_called = true;

	$settings_floating = superwebshare_get_settings_floating();
	$settings_inline   = superwebshare_get_settings_inline();
	$settings_fallback = superwebshare_get_settings_fallback();

	$floating_on_amp = empty( $settings_floating['floating_amp_enable'] ) ? 'enable' : $settings_floating['floating_amp_enable'];
	$inline_on_amp   = empty( $settings_inline['inline_amp_enable'] ) ? 'enable' : $settings_inline['inline_amp_enable'];
	$fallback_on_amp = empty( $settings_fallback['superwebshare_fallback_enable'] ) ? 'enable' : $settings_fallback['superwebshare_fallback_enable'];

	if ( ( ( ( can_display_button( 'inline', $settings_inline ) && 'enable' === $inline_on_amp ) || ( can_display_button( 'floating', $settings_floating ) && 'enable' === $floating_on_amp ) ) && 'enable' === $fallback_on_amp ) || $force_display ) {

		?>
		<amp-lightbox id="superwebshare-lightbox" layout="nodisplay">
			<div class="superwebshare-lightbox" on="tap:superwebshare-lightbox.close" role="button" tabindex="0" aria-hidden="true">
				<div class="">
					<?php
					if ( 'enable' === $fallback_on_amp || $force_display ) {
						?>
							<amp-social-share class="rounded" aria-hidden="true" type="twitter" width="48" height="48"></amp-social-share>
							<amp-social-share class="rounded" aria-hidden="true" type="linkedin" width="48" height="48"></amp-social-share>
							<amp-social-share class="rounded" aria-hidden="true" type="whatsapp" width="48" height="48"></amp-social-share>
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
function superwebshare_is_amp() {
	return ( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ) || // In plugin AMP, 2.0 Renamed to AMP-prefixed version, amp_is_request().
	( function_exists( 'ampforwp_is_amp_endpoint' ) && ampforwp_is_amp_endpoint() ) ||
	( function_exists( 'amp_is_request' ) && amp_is_request() );
}

/**
 * Checking to display the button.
 *
 * @since 2.1
 * @param  mixed $type normal | floating.
 * @param  array $settings the settings what saved on Database.
 * @return string Icon for Share Button
 */
function can_display_button( $type, $settings = array() ) {

	if ( is_404() || is_archive() || is_search() ) {
		return false;
	}

	// Settings reload if General(normal) settings is empty;.
	if ( 'inline' === $type && empty( $settings ) ) {
		$settings = superwebshare_get_settings_inline();
	}

	// Settings reload if Floating settings is empty;.
	if ( 'floating' === $type && empty( $settings ) ) {
		$settings = superwebshare_get_settings_floating();
	}

	if ( ! isset( $settings[ "superwebshare_{$type}_enable" ] ) ) {
		return true;
	}

	if ( isset( $settings[ "superwebshare_{$type}_enable" ] ) && 'enable' !== $settings[ "superwebshare_{$type}_enable" ] ) {
		return false;
	}

	$allowed_pages     = isset( $settings[ "{$type}_display_pages" ] ) && is_array( $settings[ "{$type}_display_pages" ] ) ? $settings[ "{$type}_display_pages" ] : array();
	$current_post_type = (string) get_post_type();

	if ( is_home() || is_front_page() ) {

		if ( in_array( 'home', $allowed_pages, true ) || empty( $allowed_pages ) ) {
			return true;
		} else {
			return false;
		}
	}

	// if empty it will be new plugin installation and allow to display all pages.
	$option_key = 'inline' === $type ? 'superwebshare_inline_settings' : 'superwebshare_floating_settings';
	if ( empty( $allowed_pages ) && ! get_option( $option_key ) ) {

		$post_types = superwebshare_get_pages();
		// Some pages wont allow to show the display in our side.
		if ( key_exists( $current_post_type, $post_types ) && ! is_archive() ) {

			return true;
		} else {
			return false;
		}
	}

	if ( in_array( $current_post_type, $allowed_pages, true ) ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Check whether the button can show according to the setting of each page.
 *
 * @param  string $type The type of button. Default floating.
 * @return boolean
 */
function can_display_button_page_wise( $type = 'floating' ) {

	$post = get_post();

	if ( ! empty( $post ) ) {
		if ( ( isset( $post->{"_superwebshare_post_{$type}_active"} ) && empty( $post->{"_superwebshare_post_{$type}_active"} ) ) ||
			( ! empty( $post->{"_superwebshare_post_{$type}_active"} ) && 'enable' === $post->{"_superwebshare_post_{$type}_active"} )
			) {
				return false;
		} else {
			return true;
		}
	} else {
		return false;
	}
}

/**
 * Shortocde
 *
 * @since 2.3
 */

if ( ! function_exists( 'super_web_share_shortcode' ) ) {

	/**
	 * The function handling the shortcode of WordPress.
	 *
	 * @param  array $attr the attributes which supported by the Shortcode.
	 * @return string as button HTML.
	 */
	function super_web_share_shortcode( $attr ) {

		if ( is_archive() ) {
			return;
		}

		$container_class = 'sws_supernormalaction';
		$floating_class  = '';
		$parent_style    = '';
		wp_enqueue_style( 'super-web-share' );

		if ( ! superwebshare_is_amp() ) {

			wp_enqueue_script( 'super-web-share' );
			add_action( 'wp_footer', 'super_web_share_fallback_modal_for_shortcode' );

		}

		$attr = shortcode_atts(
			array(
				'type'                 => 'inline',    // inline, floating.
				'color'                => '#BD3854',
				'text'                 => 'Share',
				'style'                => 'default',   // default, curved, square, circle.
				'size'                 => 'large',     // large, medium, small.
				'icon'                 => 'share-icon-1',
				'align'                => 'start',
				'fallback'             => 'yes',       // yes, no.
				'floating-position'    => 'right',     // right, left.
				'floating-from-side'   => '5px',       // Pix value.
				'floating-from-bottom' => '5px',       // Pix value.
				'title'                => null,
				'link'                 => null,
				'description'          => null,
			),
			$attr,
			'super_web_share'
		);

		$pos = in_array( $attr['floating-position'], array( 'right', 'left' ) ) ? $attr['floating-position'] : 'right';

		if ( 'floating' === $attr['type'] ) {
			$container_class = 'sws_superaction';
			$parent_style    = $pos . ': 24px;';
		}
		$parent_style = 'text-align:' . $attr['align'] . ';';

		$icon_class      = new Super_Web_Share_Icons();
		$icon            = $icon_class->get_icon( $attr['icon'] );
		$floating_class .= 'yes' !== $attr['fallback'] ? ' sws-fallback-off' : '';

		$button_classes = array(
			$floating_class,
			'superwebshare_tada',
			'superwebshare_normal_button1',
			'shortcode-button',
			'superwebshare-button-' . $attr['size'],
			'superwebshare-button-' . $attr['style'],
			'superwebshare_prompt',
			'superwebshare_button_svg',
		);

		$button_attrs = array(
			'data-share-title'       => $attr['title'],
			'data-share-link'        => $attr['link'],
			'data-share-description' => $attr['description'],
			'type'                   => 'button',
			'on'                     => 'tap:superwebshare-lightbox',
			'class'                  => implode( ' ', $button_classes ),
			'style'                  => 'background-color:' . $attr['color'] . ';' . esc_attr( $pos ) . ':' . esc_html( $attr['floating-from-side'] ) . ';bottom:' . esc_html( $attr['floating-from-bottom'] ),
		);

		ob_start();
		?>
		<div class="<?php echo esc_html( $container_class ); ?>" style="<?php echo esc_attr( $parent_style ); ?>" >
			<?php
			if ( superwebshare_is_amp() && 'yes' !== $attr['fallback'] ) {
				?>
					<amp-social-share type="system" width="48" height="48" style="background-color:<?php echo esc_html( $attr['color'] ); ?>" class="superwebshare_amp_native_button superwebshare_amp_native_button_floating"></amp-social-share>
				<?php
			} else {
				if ( superwebshare_is_amp() && 'yes' === $attr['fallback'] ) {
					superwebshare_amp_modal( true );
				}
				?>
				<button <?php echo array_to_attributes( $button_attrs );  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> >
				<?php echo $icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<span> <?php echo esc_html( $attr['text'] ); ?></span></button>
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
 *
 * @since 2.3
 */
function super_web_share_fallback_modal_for_shortcode() {

	$settings_fallback = superwebshare_get_settings_fallback();

	$twitter_via = empty( $settings_fallback['fallback_twitter_via'] ) ? '' : $settings_fallback['fallback_twitter_via'];
	$layout      = empty( $settings_fallback['fallback_layout'] ) ? 1 : $settings_fallback['fallback_layout'];
	$default_bg  = superwebshare_settings_default( 'fallback' )['fallback_modal_background'];
	$bg          = empty( $settings_fallback['fallback_modal_background'] ) ? $default_bg : $settings_fallback['fallback_modal_background'];

	superwebshare_fallback_modal(
		array(
			'layout'      => $layout,
			'bg'          => $bg,
			'twitter_via' => $twitter_via,
			'text_color'  => empty( $settings_fallback['fallback_text_color'] ) ? '#ffffff' : $settings_fallback['fallback_text_color'],
			'title'       => empty( $settings_fallback['fallback_title'] ) ? 'Share' : $settings_fallback['fallback_title'],

		)
	);
}


/**
 * To Add async attributes to Script tag.
 *
 * @param string $tag The tag name of HTML.
 * @param string $handle Name of script.
 * @return string|string[]
 *
 * @since 2.3.1
 */
function super_web_share_add_async_attribute( $tag, $handle ) {
	if ( substr( $handle, 0, strlen( 'super-web-share' ) ) === 'super-web-share' ) {
		$tag = str_replace( ' src', ' async src', $tag );
	}

	return $tag;
}
add_filter( 'script_loader_tag', 'super_web_share_add_async_attribute', 10, 2 );

/**
 * A array to HTML attribute.
 *
 * @param  array $attrs key and value paired array of attributes.
 * @return string
 */
function array_to_attributes( $attrs ) {
	$str = array();
	foreach ( $attrs as $key => $val ) {
		if ( empty( $val ) ) {
			continue;
		}
		$str[] = esc_attr( $key ) . '="' . esc_attr( $val ) . '"';
	}
	return implode( ' ', $str );
}
