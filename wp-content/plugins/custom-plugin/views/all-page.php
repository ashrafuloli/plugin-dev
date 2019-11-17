<?php
global $wpdb;
echo "<h2>Custom Table Data</h2>";
$id = $_GET['pid'] ?? 0;

$id = sanitize_key($id);

if($id){
	$result = $wpdb->get_row("select * from {$wpdb->prefix}custom_table WHERE id='{$id}'");
	if($result){
		echo  "Name: {$result->name} <br>";
		echo  "email: {$result->email} <br>";
	}
}
?>
	<hr>
<form action="<?php echo admin_url('admin-post.php'); ?>" method="post">
	<?php
		wp_nonce_field('db_custom_nonce','nonce');
	?>
	<input type="hidden" name="action" value="db_custom_add_record">
	Name: <input type="text" name="name" value="<?php if($id) echo $result->name;?>"> <br>
	Email: <input type="text" name="email" value="<?php if($id) echo $result->email;?>"> <br>
<?php

	if($id){
		echo '<input type="hidden" name="id" value="'.$id.'">';
		submit_button("Update Record");
	}

	?>
	</form>

<?php

add_action('admin_post_db_custom_add_record', function (){
	global $wpdb;
	$nonce = sanitize_text_field($_POST['nonce']);
	if(wp_verify_nonce($nonce, 'db_custom_nonce')){
		$name = sanitize_text_field($_POST['name']);
		$email = sanitize_text_field($_POST['email']);

		$wpdb->insert("{$wpdb->prefix}custom_table", ['name' => $name, 'email' => $email]);
	}else{
		echo "you're not allowed do this";
	}
	wp_redirect( admin_url( 'admin.php?page=custom-plugin-2' ) );
});

