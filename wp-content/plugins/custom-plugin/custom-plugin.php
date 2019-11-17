<?php
/*
 * Plugin Name: Custom Plugin
 * Plugin URI: http://www.ashrafuloli.com/custom-plugin
 * Description: The very first plugin that I have ever created.
 * Version: 1.2
 * Author: Ashraful Oli
 * Author URI: http://www.ashrafuloli.com
 */

define('PLUGIN_DIR_PATH', plugin_dir_path(__FILE__));
define('PLUGINS_URL', plugins_url());
define('CUSTOM_PL_DB_VERSION', '1.2');

function add_custom_pl_menu()
{
	add_menu_page(
		'Custom Plugin',
		'Custom Plugin',
		'manage_options',
		'customplugin',
		'custom_plugin_callback',
		'dashicons-share-alt',
		'99'
	);

	add_submenu_page(
		'customplugin',
		'My Custom Page',
		'Add New',
		'manage_options',
		'custom-plugin',
		'custom_plugin_callback'
	);

	add_submenu_page(
		'customplugin',
		'My Custom Page',
		'All Page',
		'manage_options',
		'custom-plugin-2',
		'custom_plugin_callback_submenu'
	);
}

add_action('admin_menu', 'add_custom_pl_menu');

function custom_plugin_callback()
{
	include_once PLUGIN_DIR_PATH . '/views/add-new.php';
}

function custom_plugin_callback_submenu()
{
	include_once PLUGIN_DIR_PATH . '/views/all-page.php';
}


function custom_pl_assets()
{
	wp_enqueue_style('custom-pl-style', PLUGINS_URL . '/custom-plugin/assets/css/style.css', array(), '1.0.0', 'all');
	wp_enqueue_script('custom-pl-style', PLUGINS_URL . '/custom-plugin/assets/js/script.js', array('jquery'), '1.0.0', true);
}

add_action('admin_enqueue_scripts', 'custom_pl_assets');

function custom_pl_init()
{
	global $wpdb;

	// fint table prefix from wp-config.php
	$table_name = $wpdb->prefix.'custom_table';

	// create table sql
	$sql = "CREATE TABLE {$table_name} (
    		id INT NOT NULL AUTO_INCREMENT,
    		name VARCHAR(250),
    		email VARCHAR(250),
    		PRIMARY KEY(id)
	)";

	require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
	// use $wpdb ->  require upgrade.php
	dbDelta($sql);

	// add option table plugin version
	add_option("custom_pl_db_version", CUSTOM_PL_DB_VERSION);

	if(get_option("custom_pl_db_version") != CUSTOM_PL_DB_VERSION){
		$sql = "CREATE TABLE {$table_name} (
            id INT NOT NULL AUTO_INCREMENT,
            name VARCHAR(250),
            email VARCHAR(250),
            age INT,
            PRIMARY KEY(id)
		)";
		dbDelta($sql);

		update_option("custom_pl_db_version", CUSTOM_PL_DB_VERSION);
	}
}

register_activation_hook(__FILE__, 'custom_pl_init');

// delete table data
function custom_pl_drop_column(){
	global $wpdb;
	$table_name = $wpdb->prefix.'custom_table';
	require_once (ABSPATH . 'wp-admin/includes/upgrade.php');

	if(get_option("custom_pl_db_version") != CUSTOM_PL_DB_VERSION){
		$query = "ALTER TABLE {$table_name} DROP  COLUMN age";
		$wpdb->query($query);
		update_option("custom_pl_db_version", CUSTOM_PL_DB_VERSION);
	}
}
add_action("plugin_loaded", "custom_pl_drop_column");

// table data insert
function custom_pl_load_data(){
	global $wpdb;
	$table_name = $wpdb->prefix.'custom_table';
	$wpdb->insert($table_name,[
		'name'=>"Ashraful Oli",
		'email'=> 'ashrafuloli@gmail.com'
	]);
	$wpdb->insert($table_name,[
		'name'=>"Nuran",
		'email'=> 'nuran@gmail.com'
	]);
}
register_activation_hook( __FILE__, "custom_pl_load_data");

// table data flush
function custom_pl_flush_data(){
	global $wpdb;
	$table_name = $wpdb->prefix.'custom_table';
	$query = "TRUNCATE TABLE {$table_name}";
	$wpdb->query($query);
}
register_deactivation_hook(__FILE__, "custom_pl_flush_data");

