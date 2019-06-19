<?php
namespace sv_100;

/**
 * @version         1.00
 * @author			straightvisions GmbH
 * @package			sv_100
 * @copyright		2017 straightvisions GmbH
 * @link			https://straightvisions.com
 * @since			1.0
 * @license			See license.txt or https://straightvisions.com
 */

class sv_svg_support extends init {
	public function __construct() {

	}

	public function init() {
		// Translates the module
		load_theme_textdomain( $this->get_module_name(), $this->get_path( 'languages' ) );

		// Module Info
		$this->set_module_title( 'SV SVG Support' );
		$this->set_module_desc( __( 'This module loads styles of plugin <a href="https://de.wordpress.org/plugins/svg-support/" target="_blank">SVG Support</a> inline to improve Pagespeed.', $this->get_module_name() ) );
		
		// WP Styles
		add_action( 'wp_print_styles', array($this, 'wp_print_styles'), 100 );
		add_action('wp', array($this, 'load'));
		
		$this->register_scripts();
	}
	public function wp_print_styles() {
		if(defined('BODHI_SVGS_PLUGIN_PATH')) {
			// Gutenberg: load Styles inline for Pagespeed purposes
			wp_dequeue_style('bodhi-svgs-attachment');
		}
	}
	protected function register_scripts(): sv_svg_support {
		$this->scripts_queue['bodhi-svgs-attachment'] =
			static::$scripts->create( $this )
							->set_ID( 'bodhi-svgs-attachment' )
							->set_path( BODHI_SVGS_PLUGIN_PATH . 'css/svgs-attachment.css', true)
							->set_inline( true );
		
		return $this;
	}
	public function load() : sv_svg_support{
		if(defined('BODHI_SVGS_PLUGIN_PATH')) {
			$this->scripts_queue['bodhi-svgs-attachment']->set_is_enqueued( true );
		}
		
		return $this;
	}
}