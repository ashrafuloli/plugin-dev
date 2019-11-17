<?php
/*
Plugin Name: Posts to QR Code
Plugin URI: https://plugin.com/demo
Description: Display QR Code under ever posts
Author: Ashraful Oli
Author URI: https://ashrafuloli.com/
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Version: 1.0.0
Text Domain: post-to-qrcode
Domain Path: /languages/
*/

// if plugin active run this fun
function qrcode_activation_hook()
{

}

register_activation_hook(__FILE__, "qrcode_activation_hook");

// if plugin deactivate run this fun
function qrcode_deactivation_hook()
{

}

register_deactivation_hook(__FILE__, "qrcode_deactivation_hook");

// load plugin text domain
function qrcode_load_textdomain()
{
	load_plugin_textdomain("post-to-qrcode", false, dirname(__FILE__) . "/languages");
}

add_action("plugin_loaded", "qrcode_load_textdomain");

function qrcode_display_qr_code($content){
	$current_post_id = get_the_ID();
	$current_post_title = get_the_title($current_post_id);
	$current_post_url = urlencode(get_the_permalink($current_post_id));
	$current_post_type = get_post_type($current_post_id);

	//	Post Type Check
	$excluded_post_types = apply_filters("qrcode_excluded_post_types", []);
	if(in_array($current_post_type, $excluded_post_types)){
		return $content;
	}

	//	Dimension Check
	// setting page
	$width = get_option('qrcode_width');
	$height = get_option('qrcode_height');

	$width = $width ? $width : 180;
	$height = $height ? $height : 180;

	$dimension = apply_filters("qrcode_dimension", "{$width}x{$height}");

	//	Image Attributes
	$image_attributes = apply_filters("qrcode_image_attributes", null);


	$image_src = sprintf("https://api.qrserver.com/v1/create-qr-code/?size=%s&data=%s", $dimension, $current_post_url);
	$content .= sprintf("<div class='qrcode'><img %s src='%s' alt='%s' /></div>", $image_attributes, $image_src, $current_post_title);
	return $content;
}
add_filter("the_content", "qrcode_display_qr_code");

/**
*   Post Type apply filter

	function twentynineteen_qrcode_excluded_post_types($post_types){
		$post_types[] = 'page';
		// array_push($post_types, 'page');
		return $post_types;
	}
	add_filter('qrcode_excluded_post_types', "twentynineteen_qrcode_excluded_post_types");

*   Dimension apply filter

	function twentynineteen_qrcode_dimension($dimension){
		$dimension = "100x100";
		return $dimension;
	}
	add_filter('qrcode_dimension', "twentynineteen_qrcode_dimension");

*/


/**
 * settings page
 */
function qrcode_settings_init(){
	// add settings section
	add_settings_section(
		"qrcode_section",
		__("Posts to QR Code", "post-to-qrcode"),
		"qrcode_section_callback",
		"general"
	);

	// add settings
	add_settings_field(
		"qrcode_width",
		__("QR Code Width", "post-to-qrcode"),
		"qrcode_display_field",
		"general",
		"qrcode_section",
		array("qrcode_width")
	);
	add_settings_field(
		"qrcode_height",
		__("QR Code Height", "post-to-qrcode"),
		"qrcode_display_field",
		"general",
		"qrcode_section",
		array("qrcode_height")
	);
	add_settings_field(
		"qrcode_select",
		__("Dropdown", "post-to-qrcode"),
		"qrcode_display_select_field",
		"general",
		"qrcode_section"
	);
	add_settings_field(
		"qrcode_checkbox",
		__("Select Countries", "post-to-qrcode"),
		"qrcode_display_checkboxgroup_field",
		"general",
		"qrcode_section"
	);
	add_settings_field(
		"qrcode_radio",
		__("Select Gender", "post-to-qrcode"),
		"qrcode_display_radio_field",
		"general",
		"qrcode_section"
	);
	add_settings_field(
		"qrcode_toogle",
		__("Toogle Field", "post-to-qrcode"),
		"qrcode_display_toogle_field",
		"general",
		"qrcode_section"
	);

	// register settings
	register_setting("general", "qrcode_width", ["sanitize_callback" => "esc_attr"]);
	register_setting("general", "qrcode_height", ["sanitize_callback" => "esc_attr"]);
	register_setting("general", "qrcode_select", ["sanitize_callback" => "esc_attr"]);
	register_setting("general", "qrcode_checkbox");
	register_setting("general", "qrcode_radio", ["sanitize_callback" => "esc_attr"]);
	register_setting("general", "qrcode_toogle", ["sanitize_callback" => "esc_attr"]);
}
add_action("admin_init", "qrcode_settings_init");

// add input fields
function qrcode_section_callback(){
	echo "<p>".__("Settings for Post to QR Plugin","post-to-qrcode")."</p>";
}

// add input fields
function qrcode_display_width(){
	$width = get_option("qrcode_width");
	printf("<input type='text' id='%s' name='%s' value='%s' />", "qrcode_width", "qrcode_width", $width);
}

// add input fields
function qrcode_display_height(){
	$height = get_option("qrcode_height");
	printf("<input type='text' id='%s' name='%s' value='%s' />", "qrcode_height", "qrcode_height", $height);
}

// callback simplify
function qrcode_display_field($arg){
	$option = get_option($arg[0]);
	printf("<input type='text' id='%s' name='%s' value='%s' />", $arg[0], $arg[0], $option);
}

// global array
$qrcode_countries = [
	__('Afghanistan', 'post-to-qrcode'),
	__('Bangladesh', 'post-to-qrcode'),
	__('Bhutan', 'post-to-qrcode'),
	__('India', 'post-to-qrcode'),
	__('Maldives', 'post-to-qrcode'),
	__('Nepal', 'post-to-qrcode'),
	__('Pakistan', 'post-to-qrcode'),
	__('Sri Lenka', 'post-to-qrcode'),
];

// fix multiple apply_filters
function qrcode_init(){
	global $qrcode_countries;
	$qrcode_countries = apply_filters('qrcode_countries', $qrcode_countries);
}
add_action('init','qrcode_init');

// callback simplify
function qrcode_display_select_field(){
	global $qrcode_countries; // fix undefined array
	$option = get_option("qrcode_select");
	printf('<select id="%s" name="%s">', 'qrcode_select', 'qrcode_select');

	foreach ($qrcode_countries as $country) {
		$selected = "";
		if ($option == $country) {
			$selected = 'selected';
		}

		printf('<option value="%s" %s>%s</option>', $country, $selected, $country);
	}
	echo "</select>";
}

function qrcode_display_checkboxgroup_field(){
	global $qrcode_countries; // fix undefined array
	$option = get_option("qrcode_checkbox");

	foreach ($qrcode_countries as $country) {
		$selected = "";
		if (is_array($option) && in_array($country, $option)) {
			$selected = 'checked';
		}

		printf('<input type="checkbox" name="qrcode_checkbox[]" value="%s" %s> %s <br>', $country, $selected, $country);
	}
}

function qrcode_display_radio_field(){
	$option = get_option("qrcode_radio");
	printf('<input type="radio" name="%s" value="male" %s> %s <br>', 'qrcode_radio', checked('male', $option, false), __('Male', 'post-to-qrcode'));
	printf('<input type="radio" name="%s" value="female" %s> %s', 'qrcode_radio', checked('female', $option, false), __('Female', 'post-to-qrcode'));
}

function qrcode_display_toogle_field(){
	$option = get_option('qrcode_toogle');
	echo '<div id="toggle"></div>';
	echo '<input type="hidden" name="qrcode_toogle" id="qrcode_toogle" value="'.$option.'"/>';
}

function qrcode_assets($screen){
	// fix all page load js
	if ('options-general.php' == $screen) {
		wp_enqueue_style('qrcode-minitoggle-css', plugin_dir_url(__FILE__) . "assets/css/minitoggle.css");
		wp_enqueue_script('qrcode-minitoggle-js', plugin_dir_url(__FILE__) . "assets/js/minitoggle.js", array('jquery'), false, true);
		wp_enqueue_script('qrcode-main-js', plugin_dir_url(__FILE__) . "assets/js/qrcode-main.js", array('jquery'), time(), true);
	}
}
add_action("admin_enqueue_scripts","qrcode_assets");