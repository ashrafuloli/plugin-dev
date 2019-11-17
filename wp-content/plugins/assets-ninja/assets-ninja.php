<?php
/*
Plugin Name: Assets Ninja
Plugin URI: https://plugin.com/demo
Description: Assets Management In Depth
Author: Ashraful Oli
Author URI: https://ashrafuloli.com/
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Version: 1.0.0
Text Domain: assets-ninja
Domain Path: /languages/
*/

define("ASN_ASSETS_DIR", plugin_dir_url(__FILE__) . "assets/");
define("ASN_ASSETS_PUBLIC_DIR", plugin_dir_url(__FILE__) . "assets/public/");
define("ASN_ASSETS_ADMIN_DIR", plugin_dir_url(__FILE__) . "assets/admin/");

class AssetsNinja
{
	private $version;

	function __construct()
	{
		$this->version = time();

		add_action('init', array($this, 'asn_init'), 20);

		add_action('plugin_loaded', array($this, 'load_textdomain'));
		add_action('wp_enqueue_scripts', array($this, 'load_front_assets'));
		add_action('admin_enqueue_scripts', array($this, 'load_admin_assets'));

		add_shortcode('bgmedia', array($this, 'bgmedia_shortcode'));
	}

	function asn_init(){
//		wp_deregister_script('tiny-slider-main-js');
//		wp_register_script('tiny-slider-main-js', '//cdn.jsdelivr.net/npm/tiny-slider@2.9.2/dist/tiny-slider.min.js' , array('jquery'), false, true);
	}

	function load_textdomain()
	{
		load_plugin_textdomain('assets-ninja', false, plugin_dir_url(__FILE__), '/languages');
	}

	function load_front_assets()
	{
		wp_enqueue_style('asn-main-css', ASN_ASSETS_PUBLIC_DIR . "css/main.css", null, $this->version, 'all');

		// add inline style
		$attachment_image_src = wp_get_attachment_image_src(11,'medium');
		$data = <<<EDO
#bgmedia{
	background-image: url($attachment_image_src[0]);
}
EDO;

		wp_add_inline_style('asn-main-css', $data);

//		wp_enqueue_script('asn-main-js', ASN_ASSETS_PUBLIC_DIR . "js/main.js", array(), $this->version, true);
//		wp_enqueue_script('asn-another-js', ASN_ASSETS_PUBLIC_DIR . "js/another.js", array('jquery', 'asn-more-js'), $this->version, true);
//		wp_enqueue_script('asn-more-js', ASN_ASSETS_PUBLIC_DIR . "js/more.js", array('jquery'), $this->version, true);

		$js_files = array(
			'asn-main-js' => array('path' => ASN_ASSETS_PUBLIC_DIR . "js/main.js", 'dep' => array('jquery', 'asn-another-js'),),
			'asn-another-js' => array('path' => ASN_ASSETS_PUBLIC_DIR . "js/another.js", 'dep' => array('jquery', 'asn-more-js'),),
			'asn-more-js' => array('path' => ASN_ASSETS_PUBLIC_DIR . "js/more.js", 'dep' => array('jquery'),),
		);

		foreach ($js_files as $handle => $fileinfo) {
			wp_enqueue_script($handle, $fileinfo['path'], $fileinfo['dep'], $this->version);
		}


		$data = [
			'name' => 'localhost',
			'url' => 'http://localhost/plugin-dev'
		];

		$more_data = [
			'name' => 'Ashraful Oli',
			'url' => 'https://ashrafuloli.com'
		];

		$translated_string = [
			'greetings' => __("hello World", "assets-ninja")
		];

		wp_localize_script('asn-more-js', 'site_data', $data);
		wp_localize_script('asn-more-js', 'more_data', $more_data);
		wp_localize_script('asn-more-js', 'translations', $translated_string);

		// add inline script
		$data = <<<EOD
alert("hello");
EOD;
		wp_add_inline_script('asn-more-js',$data);
	}

	function load_admin_assets($screen)
	{
		$_screen = get_current_screen();
		if ('edit.php' == $screen && ('page' == $_screen->post_type || 'post' == $_screen->post_type)) {
			wp_enqueue_script('asn-admin-js', ASN_ASSETS_ADMIN_DIR . "js/admin.js", array('jquery'), $this->version, true);
		}
//		if('edit-tags.php' == $screen && 'category' == $_screen->taxonomy){
//			wp_enqueue_script('asn-admin-js', ASN_ASSETS_ADMIN_DIR . "js/admin.js", array('jquery'), $this->version, true);
//		}
	}

	function bgmedia_shortcode($attributes){
		$attachment_image_src = wp_get_attachment_image_src($attributes['id'],'medium');
		$shotcode_output = <<<EOD
<div id="bgmedia"></div>
EOD;

		return $shotcode_output;

	}
}

new AssetsNinja();