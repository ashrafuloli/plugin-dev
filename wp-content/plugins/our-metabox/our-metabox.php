<?php
/*
Plugin Name: Our Metabox
Plugin URI: https://plugin.com/demo
Description: Metabox API Demo
Author: Author Name
Author URI: https://author.com/
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Version: 1.0.0
Text Domain: our-metabox
Domain Path: /language
*/

Class OurMetabox
{
	public function __construct()
	{
		add_action('plugin_loaded', array($this, 'omb_load_textdomain'));
		add_action('admin_menu', array($this, 'omb_add_metabox'));
		add_action('save_post', array($this, 'omb_save_metabox'));
		add_action('save_post', array($this, 'omb_save_image'));
		add_action('save_post', array($this, 'omb_save_gallery'));

		add_action('admin_enqueue_scripts', array($this, 'omb_admin_assets'));
		// user contact methods
		add_filter('user_contactmethods', array($this, 'omb_user_contact_methods'));
	}

	// security check fun
	private function is_secured($nonce_field, $action, $post_id)
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

	public function omb_load_textdomain()
	{
		load_plugin_textdomain('our-metabox', false, dirname(__FILE__) . "/languages");
	}


	// create post meta
	public function omb_add_metabox()
	{
		add_meta_box(
			'omb_post_location',
			__('title', 'our-metabox'),
			array($this, 'omb_display_metabox'),
			array('post', 'page'),
			'normal', // side
			'default' // high
		);

		add_meta_box(
			'omb_book_info',
			__('Book Info', 'our-metabox'),
			array($this, 'omb_book_info'),
			'book',
		);

		add_meta_box(
			'omb_image_info',
			__('Image Info', 'our-metabox'),
			array($this, 'omb_image_info'),
			'post'
		);

		add_meta_box(
			'omb_gallery_info',
			__('Gallery Info', 'our-metabox'),
			array($this, 'omb_gallery_info'),
			'post'
		);
	}

	// create post meta form
	public function omb_display_metabox($post)
	{
		$location = get_post_meta($post->ID, 'omb_location', true);
		$country = get_post_meta($post->ID, 'omb_country', true);

		$is_favorite = get_post_meta($post->ID, 'omb_is_favorite', true);
		$checked = $is_favorite == 1 ? 'checked' : '';


		$label1 = __('Location ', 'our-metabox');
		$label2 = __('Country ', 'our-metabox');
		$label3 = __('Is Favorite ', 'our-metabox');
		$label4 = __('Colors ', 'our-metabox');
		$label5 = __('Color ', 'our-metabox');
		$label6 = __('Select Color ', 'our-metabox');

		$saved_colors = get_post_meta($post->ID, 'omb_clr', true);
		$colors = ['red','green','blue','yellow','pink','black','magenta'];

		$saved_color = get_post_meta($post->ID, 'omb_color', true);
		$saved_select_color = get_post_meta($post->ID, 'omb_select_color', true);

		wp_nonce_field('omb_location', 'omb_location_field');
		$metabox_html = <<<EOD
<p>
<label for="omb_location">{$label1}</label>
<input type="text" name="omb_location" id="omb_location" value="{$location}">
</p>
<p>
<label for="omb_country">{$label2}</label>
<input type="text" name="omb_country" id="omb_country" value="{$country}">
</p>
<p>
<label for="omb_is_favorite">{$label3}</label>
<input type="checkbox" name="omb_is_favorite" id="omb_is_favorite" value="1" {$checked}>
</p>

<p>
<label>{$label4}</label>
EOD;
		foreach ($colors as $color){
			$_color = ucwords($color);
			$checked = in_array($color, $saved_colors) ? 'checked' : '';
			$metabox_html .= <<<EOD
<input type="checkbox" name="omb_clr[]" id="omb_clr_{$color}" value="{$color}" {$checked}>
<label for="omb_clr_{$color}"> {$_color} </label>
EOD;

		}
		$metabox_html .= "</p>";

		$metabox_html .= <<<EOD
<p>
<label>{$label5}</label>
EOD;
		foreach ($colors as $color){
			$_color = ucwords($color);
			$checked = ($color == $saved_color) ? 'checked="checked"' : '';
			$metabox_html .= <<<EOD
<input type="radio" name="omb_color" id="omb_color_{$color}" value="{$color}" {$checked}>
<label for="omb_color_{$color}"> {$_color} </label>
EOD;
		}
		$metabox_html .= "</p>";


		$metabox_html .= <<<EOD
<p>
<label>{$label6}</label>
<select name="omb_select_color" id="omb_select_color">
	<option value="" >Select</option>
EOD;
		foreach ($colors as $color){
			$selected = ($color == $saved_select_color) ? 'selected' : '';
			$metabox_html .= sprintf('<option value="%s" %s>%s</option>', $color , $selected , ucwords($color));
		}
		$metabox_html .= "</select></p>";


		echo $metabox_html;
	}

	// save post meta data
	public function omb_save_metabox($post_id)
	{
		// security check
		if (!$this->is_secured('omb_location_field', 'omb_location', $post_id)) {
			return $post_id;
		}

		$location = isset($_POST['omb_location']) ? $_POST['omb_location'] : '';
		$country = isset($_POST['omb_country']) ? $_POST['omb_country'] : '';
		$is_favorite = isset($_POST['omb_is_favorite']) ? $_POST['omb_is_favorite'] : '';
		$colors = isset($_POST['omb_clr']) ? $_POST['omb_clr'] : '';
		$color2 = isset($_POST['omb_color']) ? $_POST['omb_color'] : '';
		$select_color = isset($_POST['omb_select_color']) ? $_POST['omb_select_color'] : '';

		// check location
		if ($location == '' || $country == '') {
			return $post_id;
		}

		// security check
		$location = sanitize_text_field($location);
		$country = sanitize_text_field($country);

		// add_post_meta($post_id, 'omb_location', $location);
		update_post_meta($post_id, 'omb_location', $location);
		update_post_meta($post_id, 'omb_country', $country);
		update_post_meta($post_id, 'omb_is_favorite', $is_favorite);
		update_post_meta($post_id, 'omb_clr', $colors);
		update_post_meta($post_id, 'omb_color', $color2);
		update_post_meta($post_id, 'omb_select_color', $select_color);

	}

	function omb_book_info(){
		wp_nonce_field('omb_book', 'omb_book_nonce');

		$metabox_html = <<<EOD
<div class="fields">
	<div class="field_c">
		<div class="label_c">
			<label for="book_author">Book Author</label>
		</div>
		<div class="input_c">
			<input type="text" class="widefat" id="book_author">
		</div>
		<div class="float_c"></div>
	</div>
	
	<div class="field_c">
		<div class="label_c">
			<label for="book_isbn">Book ISBN</label>
		</div>
		<div class="input_c">
			<input type="text" id="book_isbn">
		</div>
		<div class="float_c"></div>
	</div>
	
	<div class="field_c">
		<div class="label_c">
			<label for="book_year">Publish Year</label>
		</div>
		<div class="input_c">
			<input type="text" class="omb_dp" id="book_year">
		</div>
		<div class="float_c"></div>
	</div>
</div>
</div>
EOD;
		echo $metabox_html;
	}

	function omb_image_info($post){
		$image_id = esc_attr(get_post_meta($post->ID,'omb_image_id', true));
		$image_url = esc_attr(get_post_meta($post->ID,'omb_image_url', true));
		wp_nonce_field('omb_image', 'omb_image_nonce');

		$metabox_html = <<<EOD
<div class="fields">
	<div class="field_c">
		<div class="label_c">
			<label>Image</label>
		</div>
		<div class="input_c">
			<button class="button" id="upload_image">Upload Image</button>
			<input type="hidden" name="omb_image_id" id="omb_image_id" value="{$image_id}">
			<input type="hidden" name="omb_image_url" id="omb_image_url" value="{$image_url}">
			<div id="image_container"></div>
		</div>
		<div class="float_c"></div>
	</div>
</div>
</div>
EOD;
		echo $metabox_html;
	}

	function omb_save_image($post_id){
		if (!$this->is_secured('omb_image_nonce', 'omb_image', $post_id)) {
			return $post_id;
		}

		$image_id = isset($_POST['omb_image_id']) ? $_POST['omb_image_id'] : '';
		$image_url = isset($_POST['omb_image_url']) ? $_POST['omb_image_url'] : '';

		update_post_meta($post_id, 'omb_image_id', $image_id);
		update_post_meta($post_id, 'omb_image_url', $image_url);


	}

	function omb_gallery_info($post){
		$images_id = esc_attr(get_post_meta($post->ID,'omb_images_id', true));
		$images_url = esc_attr(get_post_meta($post->ID,'omb_images_url', true));
		wp_nonce_field('omb_gallery', 'omb_gallery_nonce');

		$label = __('Gallery', 'our-metabox');
		$button_label = __('Upload Images', 'our-metabox');
		$metabox_html = <<<EOD
<div class="fields">
	<div class="field_c">
		<div class="label_c">
			<label>{$label}</label>
		</div>
		<div class="input_c">
			<button class="button" id="upload_images">{$button_label}</button>
			<input type="hidden" name="omb_images_id" id="omb_images_id" value="{$images_id}">
			<input type="hidden" name="omb_images_url" id="omb_images_url" value="{$images_url}">
			<div id="images_container"></div>
		</div>
		<div class="float_c"></div>
	</div>
</div>
</div>
EOD;
		echo $metabox_html;
	}

	function omb_save_gallery($post_id){
		if (!$this->is_secured('omb_gallery_nonce', 'omb_gallery', $post_id)) {
			return $post_id;
		}

		$images_id = isset($_POST['omb_images_id']) ? $_POST['omb_images_id'] : '';
		$images_url = isset($_POST['omb_images_url']) ? $_POST['omb_images_url'] : '';

		update_post_meta($post_id, 'omb_images_id', $images_id);
		update_post_meta($post_id, 'omb_images_url', $images_url);


	}

	function omb_admin_assets(){
		wp_enqueue_style('omb-admin-style', plugin_dir_url(__FILE__) . "assets/admin/css/style.css", null , time(), 'all');
		wp_enqueue_style('jquery-ui-css', "//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css", null , time(), 'all');
		wp_enqueue_script('omb-admin-js', plugin_dir_url(__FILE__) . "assets/admin/js/main.js", array('jquery','jquery-ui-datepicker') , time(), true );
	}

	function omb_user_contact_methods($methods){
		$methods['facebook'] = __('Facebook','our-metabox');
		$methods['linkedin'] = __('Linked In','our-metabox');
		$methods['twitter'] = __('Twitter','our-metabox');

		return $methods;
	}

}

new OurMetabox();