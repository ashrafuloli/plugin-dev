<?php
/*
Plugin Name: Tiny Slider
Plugin URI: https://github.com/ganlanyuan/tiny-slider
Description: Tiny slider for all purposes, inspired by Owl Carousel.
Author: Author Name
Author URI: https://author.com/
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Version: 1.0.0
Text Domain: tiny-slider
Domain Path: /language
*/

// init tiny slider pl
function tinys_init(){
	add_image_size('tinys-slider',800,600,true);
}
add_action('init', 'tinys_init');

// load plugin text domain
function tinys_load_textdomain()
{
	load_plugin_textdomain("tiny-slider", false, dirname(__FILE__) . "/languages");
}

add_action("plugin_loaded", "tinys_load_textdomain");

function tinys_assets(){
	wp_enqueue_style('tiny-slider-css', plugin_dir_url(__FILE__) . "assets/css/tiny-slider.css", null, '1.0');
	wp_enqueue_script('tiny-slider-js', plugin_dir_url(__FILE__) . "assets/js/tiny-slider.js", array('jquery'), false, true);
	wp_enqueue_script('tiny-slider-main-js', plugin_dir_url(__FILE__) . "assets/js/tinys-main.js", array('jquery'), false, true);
}
add_action('wp_enqueue_scripts', 'tinys_assets');

// shotcode
function tinys_shortcode_tslider($arguments, $content){
	$defaults = [
		'width' => 800,
		'height' => 800,
		'id' => '',
	];

	$attributes = shortcode_atts($defaults, $arguments);
	$content = do_shortcode($content);

	$shortcode_output = <<<EOD
<div id="{$attributes['id']}" style="width:{$attributes['width']}px; height:{$attributes['height']}px;">
	<div class="slider">
		{$content}
	</div>
</div>
EOD;

	return $shortcode_output;

}
add_shortcode('tslider', 'tinys_shortcode_tslider');

function tinys_shortcode_tslide($arguments){
	$defaults = [
		'caption' => '',
		'id' => '',
		'size' => 'tinys-slider',
	];

	$attributes = shortcode_atts($defaults, $arguments);

	$image_src = wp_get_attachment_image_src($attributes['id'], $attributes['size']);

	$shortcode_output = <<<EOD
<div class="slide">
<p><img src="{$image_src[0]}" alt="{$attributes['caption']}"></p>
<p>{$attributes['caption']}</p>
</div>
EOD;

	return $shortcode_output;

}
add_shortcode('tslide', 'tinys_shortcode_tslide');


/**
 * use this shortcode
 * [tslider][tslide caption="Test Caption 1" id="9"] [tslide caption="Test Caption 2" id="11"] [/tslider]
 */