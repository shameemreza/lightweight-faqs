<?php
/*
 * Plugin Name: Lightweight FAQs
 * Plugin URI: ''
 * Description: Extremely simple FAQs plugin to add stylish FAQs to pages without affecting page load time. Works with Classic Editor via shortcode and Elementor Widget.
 * Tags: accordion, faqs, elementor faqs, stylish faq, lightweight, easy faq, ultimate faq
 * Version: 0.0.1
 * Author: OrixLab
 * Author URI: https://orixlab.net
 * Text Domain: lwfaqs
 * License: GPLv2 or later
 *
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

class Lightweight_FAQ
{
	function __construct()
	{
		/**
		 * Show errors or warnings
		 */
		error_reporting(E_ERROR | E_WARNING);

		if (!defined('ORIXLAB_DEBUG')) :
			/**
			 * Check to see if development mode is active.
			 * If set to false, the theme will load unminified assets.
			 */
			define('ORIXLAB_DEBUG', false);
		endif;

		if (!defined('ORIXLAB_ASSET_SUFFIX')) :
			/**
			 * If not set to true, serve minified .css and .js assets.
			 */
			if (ORIXLAB_DEBUG === true) {
				define('ORIXLAB_ASSET_SUFFIX', null);
			} else {
				define('ORIXLAB_ASSET_SUFFIX', '.min');
			}
		endif;

		if (!function_exists('is_plugin_active')) :
			/**
			 * Check if plugin function exists
			 */
			require_once(ABSPATH . '/wp-admin/includes/plugin.php');
		endif;

		/**
		 * Load shortcodes and functions
		 */
		require_once('includes/faq-posttype.php');
		require_once('includes/faq-shortcode.php');
		/**
		 * Load elementor functions if installed and active
		 */
		if (is_plugin_active('elementor/elementor.php')) {
			require_once('includes/faq-elementor.php');
		}
		/**
		 * Init hook
		 */
		add_action('init', array($this, 'lightweight_faq_functions'));
	}
	/**
	 * Pass back to the init hook
	 */
	function lightweight_faq_functions()
	{
		/**
		 * Add editor shortcode button
		 */
		function lightweight_add_faq_quicktag()
		{
			if (wp_script_is('quicktags')) :
?>
				<script>
					// QTags.addButton( id, display, arg1, arg2, access_key, title, priority, instance );
					QTags.addButton('lightweight-faq', 'faq', '[lightweight-faq cat="some-category" num="4"]', '', '', 'faq', 200);
				</script>
<?php
			endif;
		}
		add_action('admin_print_footer_scripts', 'lightweight_add_faq_quicktag');
		/**
		 * WordPress version of jQuery is insecure and has an XSS vulnerability.
		 * Let's dequeue and load the latest version.
		 */
		wp_deregister_script('jquery');
		wp_enqueue_script('jquery', plugins_url('assets/js/jquery.min.js', __FILE__), '', '3.6.0', false);
		/**
		 * Register front end styles & scripts
		 * ready for enqueuing in the shortcode
		 */
		if (!is_admin()) :
			wp_enqueue_style('lightweight-faqs', plugins_url('assets/css/lwfaq.min.css#asyncload', __FILE__), '', '1.0.0', 'screen');
			wp_enqueue_script('lightweight-faqs', plugins_url('assets/js/lwfaq' . ORIXLAB_ASSET_SUFFIX . '.js#deferload', __FILE__), array('jquery'), '1.0.0', true);
		endif;
	}
}
new Lightweight_FAQ();
