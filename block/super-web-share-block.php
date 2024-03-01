<?php
/**
 * Block main register file.
 *
 * @since 1.0.0
 * @package Super_Web_Share
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function super_web_share_block_super_web_share_block_block_init() {
	register_block_type( __DIR__ . '/build' );
}
add_action( 'init', 'super_web_share_block_super_web_share_block_block_init' );
