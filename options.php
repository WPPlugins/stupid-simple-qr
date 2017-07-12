<?php

class SSQRSettingsPage
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }
	
    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Settings Admin', 
            'Stupid Simple QR', 
            'manage_options', 
            'ssqr-setting', 
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'ssqr_options' );
        ?>
        <div class="wrap">
            <?php screen_icon(); ?>
            <h2>Stupid Simple QR Settings</h2>           
            <form action="options.php" method="post">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'ssqr_group' );   
                do_settings_sections( 'ssqr-setting' );
                submit_button(); 
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting(
            'ssqr_group', // Option group
            'ssqr_options', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            'Custom Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            'ssqr-setting' // Page
        );  
 
        add_settings_field(
            'ssqr_append', // ID
            'Append to shortcode:', // Title 
            array( $this, 'ssqr_append_callback' ), // Callback
            'ssqr-setting', // Page
            'setting_section_id' // Section           
        );   
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        if( !is_numeric( $input['id_number'] ) )
            $input['id_number'] = '';  

        if( !empty( $input['title'] ) )
            $input['title'] = sanitize_text_field( $input['title'] );

        return $input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'This allows you to add URL variables (or anything) for tracking purposes. <br />For instance: <em>&medium=qr</em>';
    }
	

    /** 
     * Get the settings option array and print one of its values
     */
    public function ssqr_append_callback()
    {
        printf(
            '<input type="text" id="ssqr_append" name="ssqr_options[ssqr_append]" value="%s" />',
            esc_attr( $this->options['ssqr_append'])
        );
    }
	
}

if( is_admin() ){
    $ssqr_settings_page = new SSQRSettingsPage();
}
	
?>