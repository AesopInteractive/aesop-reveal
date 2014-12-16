<?php

/**
*	Plugin Name: Aesop Reveal
*
*/

// check if aesop story engine is active
if ( class_exists('Aesop_Core') ) {
	new AesopReveal();
}

class AesopReveal {

	function __construct(){

		define('AESOP_REVEAL_VERSION', '0.1');
		define('AESOP_REVEAL_DIR', plugin_dir_path( __FILE__ ));
		define('AESOP_REVEAL_URL', plugins_url( '', __FILE__ ));

		add_shortcode('aesop_reveal', 			array($this, 'shortcode') );
		add_action('aesop_admin_styles', 		array($this, 'icon') );
		add_filter('aesop_avail_components',	array($this, 'options') );

		add_action('wp_enqueue_scripts', 		array($this,'scripts'));
	}

	function shortcode( $atts, $content = null ) {

		$defaults = array(
			'before' 	=> '',
			'after' 	=> '',
		);

		$atts 	= shortcode_atts( $defaults, $atts );

		// account for multiple instances of this component
		static $instance = 0;
		$instance++;
		$unique = sprintf('aesop-reveal-%s-%s', get_the_ID(), $instance );

		ob_start();

		?>
		<div class="aesop-component aesop-reveal">
			<script>
				jQuery(window).load(function() {
			  		jQuery('#<?php echo esc_attr( $unique );?>').twentytwenty();
				});
			</script>
			<div id="<?php echo $unique;?>" class="twentytwenty-container aesop-content">
				<img src="<?php echo esc_url( $atts['before'] );?>">
				<img src="<?php echo esc_url( $atts['after'] );?>">
			</div>
		</div>
		<?php

		return ob_get_clean();

	}

	function icon(){

		$icon = '\f169'; //css code for dashicon
		$slug = 'reveal'; // name of component

		wp_add_inline_style('ai-core-styles', '#aesop-generator-wrap li.'.$slug.' a:before {content: "'.$icon.'";}');
	}

	function options($shortcodes) {

		$custom = array(
			'reveal' 					=> array(
				'name' 					=> __('Aesop Reveal', 'aesop-reveal'), // name of the component
				'type' 					=> 'single', // single - wrap
				'atts' 					=> array(
					'before' 			=> array(
						'type'			=> 'media_upload', // a small text field
						'default' 		=> '',
						'tip'			=> __('This image will be used in the "before" area.', 'aesop-reveal'),
						'desc' 			=> __('Before Image','aesop-reveal')
					),
					'after' 				=> array(
						'type'			=> 'media_upload', // a large text field
						'default' 		=> '',
						'tip'			=> __('This image will be used in the "after" area.', 'aesop-reveal'),
						'desc' 			=> __('After Image','aesop-reveal')
					)
				)
			)
		);


		return array_merge( $shortcodes, $custom );

	}

	/**
	*
	*	Optional add js or css
	*/
	function scripts(){

		// this handy function checks a post or page to see if your component exists beore enqueueing assets
		if ( function_exists('aesop_component_exists') && aesop_component_exists('reveal') ) {

			wp_enqueue_style('reveal-style', 		AESOP_REVEAL_URL.'/css/twentytwenty.css', AESOP_REVEAL_VERSION );
			wp_enqueue_script('reveal-script', 		AESOP_REVEAL_URL.'/js/jquery.event.move.js', array('jquery'), AESOP_REVEAL_VERSION, true);
			wp_enqueue_script('reveal-script-more', AESOP_REVEAL_URL.'/js/jquery.twentytwenty.js', array('jquery'), AESOP_REVEAL_VERSION, true);

		}

	}

}


