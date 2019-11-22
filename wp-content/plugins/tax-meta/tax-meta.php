<?php
/*
Plugin Name: Tax Meta
Plugin URI: https://plugin.com/demo
Description: Demonstration of creating taxonomy mata field
Author: Author Name
Author URI: https://author.com/
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Version: 1.0.0
Text Domain: tax-meta
Domain Path: /language
*/

// load plugin text domain
function taxm_load_textdomain()
{
	load_plugin_textdomain("tax-meta", false, dirname(__FILE__) . "/languages");
}

add_action("plugin_loaded", "taxm_load_textdomain");

function taxm_bootstrap(){
	$arguments = [
		'type' => 'string',
		'sanitize_callback' => 'sanitize_taxt_field',
		'single' => true,
		'description' => 'Sample meta field for category tax',
		'show_in_rest' => true,
	];
	register_meta('term', 'taxm_extra_info', $arguments);
}
add_action('init', 'taxm_bootstrap');

function taxm_category_form_fields(){
	?>
	<div class="form-field form-required term-name-wrap">
		<label for="tag-name"><?php _e('Extra Info', 'tax-meta'); ?></label>
		<input name="extra-info" id="extra-info" type="text" value="" size="40" aria-required="true">
		<p><?php _e('Some help Text', 'tax-meta'); ?></p>
	</div>
	<?php
}
add_action('category_add_form_fields', 'taxm_category_form_fields'); // category page
add_action('post_tag_add_form_fields', 'taxm_category_form_fields'); // tag page
add_action('genre_add_form_fields', 'taxm_category_form_fields'); // {custom-taxonomy-name}_add_form_fields page

function taxm_category_edit_form_fields($term){
	$extra_info = get_term_meta($term->term_id, 'taxm_extra_info', true);
	?>
	<tr class="form-field form-required term-name-wrap">
		<th scope="row"><label for="name"><?php _e('Extra Info', 'tax-meta'); ?></label></th>
		<td>
			<input name="extra-info" id="extra-info" type="text" value="<?php echo esc_attr($extra_info); ?>" size="40" aria-required="true">
			<p class="description"><?php _e('Some help Text', 'tax-meta'); ?></p>
		</td>
	</tr>
	<?php
}
add_action('category_edit_form_fields', 'taxm_category_edit_form_fields'); // category page
add_action('post_tag_edit_form_fields', 'taxm_category_edit_form_fields'); // tag page
add_action('genre_edit_form_fields', 'taxm_category_edit_form_fields');  // {custom-taxonomy-name}_edit_form_fields

function taxm_save_category_meta($term_id){
	if(wp_verify_nonce($_POST['_wpnonce_add-tag'], 'add-tag')){
		$extra_info = sanitize_text_field($_POST['extra-info']);
		update_term_meta($term_id , 'taxm_extra_info', $extra_info);
	}
}

add_action('create_category', 'taxm_save_category_meta'); // category page
add_action('create_post_tag', 'taxm_save_category_meta'); // tag page
add_action('create_genre', 'taxm_save_category_meta'); // create_{custom-taxonomy-name}

function taxm_update_category_meta($term_id){
	if(wp_verify_nonce($_POST["_wpnonce"], "update-tag_{$term_id}")){
		$extra_info = sanitize_text_field($_POST['extra-info']);
		update_term_meta($term_id , 'taxm_extra_info', $extra_info);
	}
}

add_action('edit_category', 'taxm_update_category_meta'); // category page
add_action('edit_post_tag', 'taxm_update_category_meta'); // tag page
add_action('edit_genre', 'taxm_update_category_meta'); // edit_{custom-taxonomy-name}