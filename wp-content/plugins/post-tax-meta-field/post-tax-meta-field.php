<?php
/*
Plugin Name: Post And Taxonomy Selector
Plugin URI: https://plugin.com/demo
Description: Demonstration of creating taxonomy mata field
Author: Author Name
Author URI: https://author.com/
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Version: 1.0.0
Text Domain: post-tax-metafield
Domain Path: /language
*/

// load plugin text domain
function ptmf_load_textdomain()
{
	load_plugin_textdomain("post-tax-metafield", false, dirname(__FILE__) . "/languages");
}

add_action("plugin_loaded", "ptmf_load_textdomain");

function ptmf_init(){
	add_action('admin_enqueue_scripts', 'ptmf_admin_assets');
}
add_action('admin_init','ptmf_init');

// security check fun
if(!function_exists('ptmf_is_secured')){
	function ptmf_is_secured($nonce_field, $action, $post_id)
	{
		$nonce = isset($_POST[$nonce_field]) ? $_POST[$nonce_field] : '';

		// check nonce
		if ($nonce == '') {
			return false;
		}

		// check nonce verify
		if (!wp_verify_nonce($nonce, $action)) {
			return false;
		}

		// check user have edit permeation
		if (!current_user_can('edit_post', $post_id)) {
			return false;
		}

		// check wp auto save
		if (wp_is_post_autosave($post_id)) {
			return false;
		}
		// check wp revision
		if (wp_is_post_revision($post_id)) {
			return false;
		}

		return true;

	}
}

function ptmf_admin_assets(){
	wp_enqueue_style('ptmf-admin-style', plugin_dir_url(__FILE__) . "assets/css/style.css", null , time(), 'all');
	wp_enqueue_script('ptmf-admin-js', plugin_dir_url(__FILE__) . "assets/js/main.js", array('jquery') , time(), true );
}



function ptmf_add_metabox(){
	add_meta_box(
		'ptmf_select_posts_mb',
		__('Select Posts', 'post-tax-metafield'),
		'ptmf_display_metabox',
		'post'
	);
}
add_action('admin_menu', 'ptmf_add_metabox');




function ptmf_display_metabox($post){
	$selected_post_id = get_post_meta($post->ID,'ptmf_selected_posts',true);
	$selected_term_id = get_post_meta($post->ID,'ptmf_selected_term',true);
//	print_r($selected_post_id);
	print_r($selected_term_id);

	wp_nonce_field('ptmf_posts', 'ptmf_posts_nonce');

	// post query
	$args = [
		'post_type' => 'post',
		'posts_per_page' => -1
	];
	$dropdown_list = '';
	$_posts = new wp_query($args);
	while ($_posts->have_posts()){
		$_posts->the_post();
		$extra = '';
//		single select
//		if(get_the_ID() == $selected_post_id){
//			$extra = 'selected';
//		}

		if(in_array(get_the_ID(), $selected_post_id)){
			$extra = 'selected';
		}
		$dropdown_list .= sprintf('<option value="%s" %s>%s</option>',get_the_ID(), $extra ,get_the_title());
	}
	wp_reset_query();

// taxonomy query
	$_terms = get_terms([
		'taxonomy' => array('category','genre'), // custom taxonomy
		'hide_empty' => false // if show un-used taxonomy
	]);
	$term_dropdown_list = '';
	foreach ($_terms as $_term){
		// selected value
		$extra = '';
		if($_term->term_id == $selected_term_id){
			$extra = 'selected';
		}

		// dropdown list
		$_term->term_id;
		$term_dropdown_list .= sprintf('<option value="%s" %s>%s</option>',$_term->term_id, $extra ,$_term->name);
	}



	$label = __('Select Posts', 'post-tax-metafield');
	$label2 = __('Select Term', 'post-tax-metafield');
	$metabox_html = <<<EOD
<div class="fields">
	<div class="field_c">
			<div class="label_c">
				<label>{$label}</label>
			</div>
			<div class="input_c">
				<select multiple="multiple" name="ptmf_posts[]" id="ptmf_posts">
					<option value="0">{$label}</option>
					{$dropdown_list}
				</select>
			</div>
			<div class="float_c"></div>
	</div>
	<div class="field_c">
			<div class="label_c">
				<label for="ptmf_term">{$label2}</label>
			</div>
			<div class="input_c">
				<select name="ptmf_term" id="ptmf_term">
					<option value="0">{$label2}</option>
					{$term_dropdown_list}
				</select>
			</div>
			<div class="float_c"></div>
	</div>
</div>
EOD;
	echo $metabox_html;
}


function ptmf_save_metabox($post_id){
	if (!ptmf_is_secured('ptmf_posts_nonce', 'ptmf_posts', $post_id)) {
		return $post_id;
	}

	$selected_post_id = isset($_POST['ptmf_posts']) ? $_POST['ptmf_posts'] : '';
	$selected_term_id = isset($_POST['ptmf_term']) ? $_POST['ptmf_term'] : '';
	update_post_meta($post_id, 'ptmf_selected_posts', $selected_post_id);
	update_post_meta($post_id, 'ptmf_selected_term', $selected_term_id);
	return $post_id;
}
add_action('save_post', 'ptmf_save_metabox');









