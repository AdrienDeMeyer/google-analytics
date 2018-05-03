<?php
/*
Plugin Name: ADM Google Analytics
Plugin URI: https://www.adriendemeyer.com/
Description: Adds Google Analytics
Author: Adrien De Meyer
Author URI: https://www.adriendemeyer.com
Version: 1.0
*/

add_action( 'admin_menu', 'admga_add_admin_menu' );
function admga_add_admin_menu() {
	add_options_page( 'Google Analytics', 'Google Analytics', 'manage_options', 'google-analytics', 'admga_settings_page');
}

function admga_settings_page() { ?>

	<div class="wrap">

	<h2>Google Analytics</h2>

	<?php
	if ( isset( $_POST['submit_data'] ) ) {
		if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'nonce_admga' ) ) {
		   echo 'Sorry, your nonce did not verify.';
		   exit;
		} else {
			update_option('_ga_script',$_POST["ga_script"]);
			echo '<div id="message" class="updated">'.__( "Settings saved." ).'</div>';
		}
	}
	?>


	<form method="post">

	<?php if ( function_exists( 'wp_nonce_field' ) ) wp_nonce_field( 'nonce_admga' ); ?>

	<div id="google-analytics-script">

		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row">copy and paste your script</th>
					<td>
					<?php $ga_script = stripslashes(get_option('_ga_script')); ?>

								<textarea rows="10" cols="50" name="ga_script" class="large-text code"><?php echo $ga_script; ?></textarea>

					</td>
				</tr>
			</tbody>
		</table>

	</div>
	<hr>


	<p class="submit">
		<input type="hidden" value="Y" name="submit_data">
		<input type="submit" class="button-primary" name="admga_submit" value="<?php _e( 'Update' ); ?>">
	</p>

	</form>

	</div>
<?php

}

add_action( 'wp_head', 'add_ga_script' );
function add_ga_script()
{
?>
  <?php $ga_script = stripslashes(get_option('_ga_script')); ?>
  <?php echo $ga_script; ?>

<?php
}
