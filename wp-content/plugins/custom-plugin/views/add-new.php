<h2>Add Data</h2>
<div class="notice notice-error is-dismissible">
	<p>Some Error INformation</p>
</div>
<form action="" method="post">
	<?php
		wp_nonce_field('db_custom_nonce','nonce');
	?>
	Name: <input type="text" name="name"> <br>
	Email: <input type="text" name="email"> <br>
	<?php

	submit_button("Add Record");
	
	?>
</form>

<?php
global $wpdb;
if (isset($_POST['submit'])) {

	$nonce = sanitize_text_field($_POST['nonce']);
	if(wp_verify_nonce($nonce, 'db_custom_nonce')){
		$name = sanitize_text_field($_POST['name']);
		$email = sanitize_text_field($_POST['email']);

		$wpdb->insert("{$wpdb->prefix}custom_table", ['name' => $name, 'email' => $email]);
	}else{
		echo "you're not allowed do this";
	}

}


