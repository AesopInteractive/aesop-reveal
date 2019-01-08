<?php

/**
*	Plugin Name: Aesop Reveal
*	Plugin URI: https://github.com/AesopInteractive/aesop-reveal
*	Description: Based on the TwentyTwenty script, shows a before and after image with draggable handlebars.
*	Author: Aesopinteractive
*	Author URI: http://aesopstoryengine.com
*	Version: 1.2.1
*/

define('AESOP_REVEAL_URL', plugins_url( '', __FILE__ ));
define('AESOP_REVEAL_DIR', plugin_dir_path( __FILE__ ));

class AesopReveal {

	function __construct(){

		define('AESOP_REVEAL_VERSION', '1.2.2');
		
		

		add_shortcode('aesop_reveal', 			array($this, 'shortcode') );
		
		// Gutenberg registration
		add_action( 'wp', array( $this, 'gutenberg' ), 10 );
		
		add_action('aesop_admin_styles', 		array($this, 'icon') );
		add_filter('aesop_avail_components',	array($this, 'options') );

		add_action('wp_enqueue_scripts', 		array($this,'scripts'));
	}

	function shortcode( $atts ) {
	
		$defaults = array(
		    'width'  => '100%',
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
		<div class="aesop-component aesop-reveal" style="max-width:<?php echo $atts['width'];?>;">
			<script>
				jQuery(window).load(function() {
			  		jQuery('#<?php echo esc_attr( $unique );?>').twentytwenty();
				});
			</script>
			<div id="<?php echo $unique;?>" class="twentytwenty-container" style="background-image:url(<?php echo esc_url( $atts['before'] );?>);background-repeat: no-repeat;background-position: center center;background-size: cover;">
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
					'width'    => array(
						'type'  => 'text_small',
						'default'  => '',
						'desc'   => __( 'Width', 'aesop-core' ),
						'tip'  => __( 'Width of the reveal component. Default is 100%. You can enter the size using percentage or pixel units like <code>40%</code> or <code>500px</code>.', 'aesop-reveal' )
					),
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
	
	function gutenberg()
	{
		if (  function_exists( 'register_block_type' ) ) {
			register_block_type( 'ase/reveal', array(
					'render_callback' => array($this, 'shortcode')
			) );
		}
	}

}
new AesopReveal();

/**
 * BLOCK: Aesop Gutenberg Support.
 */
require_once( AESOP_REVEAL_DIR.'block/index.php' );

