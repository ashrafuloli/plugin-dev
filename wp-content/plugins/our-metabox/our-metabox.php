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
		add_action('save_post', array($this, 'omb_save_location'));
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
			array($this, 'omb_display_post_location'),
			array('post','page'),
			'normal', // side
			'default' // high
		);
	}

	// create post meta form
	public function omb_display_post_location($post)
	{
		$location = get_post_meta($post->ID, 'omb_location', true);
		$country = get_post_meta($post->ID, 'omb_country', true);
		$label1 = __('Location', 'omb_post_location');
		$label2 = __('Country', 'omb_post_location');
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
EOD;
		echo $metabox_html;
	}

	// save post meta data
	public function omb_save_location($post_id)
	{
		// security check
		if(!$this->is_secured('omb_location_field','omb_location', $post_id)){
			return $post_id;
		}

		$location = isset($_POST['omb_location']) ? $_POST['omb_location'] : '';
		$country = isset($_POST['omb_country']) ? $_POST['omb_country'] : '';

		// check location
		if ($location == '' || $country == '') {
			return $post_id;
		}

		// security check
		$location = sanitize_text_field($location);
		$country = sanitize_text_field($country);

//		add_post_meta($post_id, 'omb_location', $location);
		update_post_meta($post_id, 'omb_location', $location);
		update_post_meta($post_id, 'omb_country', $country);

	}

}

new OurMetabox();