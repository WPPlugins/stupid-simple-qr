<?php
/**
 * Use the old, no-object way to set up the options
 */
add_action( 'network_admin_menu', 'ssqr_network_menu_settings');
function ssqr_network_menu_settings(){
			add_submenu_page( 
				  	'settings.php',   // or 'options.php' 
					'Settings Admin', 
					'Stupid Simple QR', 
					'manage_options', 
					'ssqr-setting', 
					'create_admin_page'
			);
}

function create_admin_page() {
    if (is_multisite() && current_user_can('manage_network') ) {

    ?>

<div class="wrap">
  <h2>Stupid Simple QR: Network Settings</h2>
  
  <?php 

    if (isset($_POST['action']) && $_POST['action'] == 'update_ssqr_settings') {
    	check_admin_referer('save_network_settings', 'ssqr-plugin');
        $network_settings = $_POST['network_settings'];    																	//store option values in a variable
        $network_settings = array_map( 'sanitize_text_field', $network_settings );        									//use array map function to sanitize option values
        update_site_option( 'ssqr_network_options', $network_settings );        											//save option values
        echo '<div id="message" class="updated fade"><p><strong>Stupid Simple Settings Updated!</strong></p></div>';        //just assume it all went according to plan
	} //if POST

	?>

	<p>This allows you to add URL variables (or anything, really) for tracking purposes. <br />For instance: <em>&amp;medium=qr</em></p>
  	<form method="post">
    	<input type="hidden" name="action" value="update_ssqr_settings" />
    	<?php 
			$ssqr_network_options = get_site_option( 'ssqr_network_options' ); 
			$ssqr_append = $ssqr_network_options['ssqr_append']; 
			wp_nonce_field('save_network_settings', 'ssqr-plugin');
		?>
        <table class="form-table">
            <tr><th scope="row">Append to shortcode:</th><td><input type="text" name="network_settings[ssqr_append]" value="<?php echo $ssqr_append; ?>" /></td></tr>
            <tr><td></td><td> <input type="submit" class="button-primary" name="update_ssqr_settings" value="Save Settings" /></td></tr>
        </table>
  	</form>
 </div>
  	<?php

    } // end if multisite 

	?>

<?php

} // end function 

?>