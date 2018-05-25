<?php
/**
 *
 * Gutenberg Custom Block assets.
 *
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Hook: Editor assets.
add_action( 'enqueue_block_editor_assets', 'ase_block_reveal_editor_assets' );

function ase_block_reveal_editor_assets() {
	// Scripts.
	wp_enqueue_script(
		'ase-block-reveal', // Handle.
		plugins_url( 'reveal/block.js', __FILE__ ), // Block.js: We register the block here.
		array( 'wp-blocks', 'wp-i18n', 'wp-element' ), // Dependencies, defined above.
		filemtime( plugin_dir_path( __FILE__ ) . 'reveal/block.js' ) // filemtime — Gets file modification time.
	);
	
	// Styles.
	wp_enqueue_style(
		'ase-block-reveal-editor', // Handle.
		plugins_url( 'editor.css', __FILE__ ), // Block editor CSS.
		array( 'wp-edit-blocks' ), // Dependency to include the CSS after it.
		filemtime( plugin_dir_path( __FILE__ ) . 'editor.css' ) // filemtime — Gets file modification time.
	);
} 

