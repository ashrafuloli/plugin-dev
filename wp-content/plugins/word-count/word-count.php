<?php
/*
Plugin Name: Word Count
Plugin URI: https://plugin.com/demo
Description: Count word from any wordpress post
Author: Ashraful Oli
Author URI: https://ashrafuloli.com/
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Version: 1.0.0
Text Domain: word-count
Domain Path: /languages/
*/

// if plugin active run this fun
function wordcount_activation_hook(){

}
register_activation_hook( __FILE__, "wordcount_activation_hook");

// if plugin deactivate run this fun
function wordcount_deactivation_hook(){

}
register_deactivation_hook( __FILE__, "wordcount_deactivation_hook");

// load plugin text domain
function wordcount_load_textdomain(){
	load_plugin_textdomain("word-count", false, dirname(__FILE__). "/languages");
}
add_action("plugin_loaded", "wordcount_load_textdomain");

// count word from the_content
function wordcount_count_words($content){
	$stripped_content = strip_tags($content); // remove html tags
	$wordcount = str_word_count($stripped_content); // count word
	$label = __("Total Number of Words", "word-count");

	$label = apply_filters("word_count_heading", $label); // make apply_filter for user
	$tag = apply_filters("word_count_tag", "h2"); // make apply_filter for user

	$content .= sprintf("<%s>%s: %s </%s>", $tag, $label, $wordcount, $tag);
	return $content;
}
add_filter("the_content", "wordcount_count_words");




/*
 * use theme options apply_filter
 *
function twentynineteen_word_count_heading($heading){
	$heading = "Total Words";
	return $heading;
}
add_filter('word_count_heading', "twentynineteen_word_count_heading");

function twentynineteen_word_count_tag($tag){
	$tag = "h2";
	return $tag;
}
add_filter('word_count_tag', "twentynineteen_word_count_tag");

*/


function wordcount_reading_time($content){
	$stripped_content = strip_tags($content); // remove html tags
	$wordcount = str_word_count($stripped_content); // count word

	$reading_minute = floor($wordcount / 200 );
	$reading_seconds = floor($wordcount % 200 / ( 200 / 60 ) );
	$is_visible = apply_filters("wordcount_display_reading_time", 1);

	if($is_visible){
		$label = __("Total Reading Time", "word-count");
		$label = apply_filters("word_count_reading_time_heading", $label); // make apply_filter for user
		$tag = apply_filters("word_count_reading_time_tag", "h2"); // make apply_filter for user
		$content .= sprintf("<%s>%s: %s minutes %s seconds</%s>", $tag, $label, $reading_minute, $reading_seconds, $tag);
	}

	return $content;
}
add_filter("the_content", "wordcount_reading_time");

/*
 * use theme options apply_filter
 *
function twentynineteen_word_count_reading_time_heading($heading){
	$heading = "Total Words Reading Time";
	return $heading;
}
add_filter('word_count_reading_time_heading', "twentynineteen_word_count_reading_time_heading");

function twentynineteen_word_count_reading_time_tag($tag){
	$tag = "h2";
	return $tag;
}
add_filter('word_count_reading_time_tag', "twentynineteen_word_count_reading_time_tag");

*/