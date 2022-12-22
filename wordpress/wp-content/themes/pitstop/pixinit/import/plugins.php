<?php

	/******* TGM Plugin ********/
add_action('tgmpa_register', 'pixtheme_register_required_plugins');

function pixtheme_register_required_plugins() {
    
    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(
        
        
          
		/*************************************
		--------  Wordpress Plugins   --------
		*************************************/

		array(
            'name' => esc_html__( 'WooCommerce', 'pitstop'), // The plugin name
            'slug' => 'woocommerce', // The plugin slug (typically the folder name)
            'required' => true, // If false, the plugin is only 'recommended' instead of required
        ),
		
		array(
            'name' => esc_html__( 'YITH WooCommerce Wishlist', 'pitstop'), // The plugin name
            'slug' => 'yith-woocommerce-wishlist', // The plugin slug (typically the folder name)
            'required' => true, // If false, the plugin is only 'recommended' instead of required
        ),
		
		array(
            'name' => esc_html__( 'YITH WooCommerce Compare', 'pitstop'), // The plugin name
            'slug' => 'yith-woocommerce-compare', // The plugin slug (typically the folder name)
            'required' => true, // If false, the plugin is only 'recommended' instead of required
        ),

        array(
			'name' => esc_html__( 'Contact Form 7', 'pitstop'), // The plugin name
			'slug' => 'contact-form-7', // The plugin slug (typically the folder name)
			'required' => true, // If false, the plugin is only 'recommended' instead of required
		) ,

        array(
			'name' => esc_html__('Mailchimp', 'pitstop'), // The plugin name
			'slug' => 'mailchimp-for-wp', // The plugin slug (typically the folder name)
			'required' => true, // If false, the plugin is only 'recommended' instead of required
		),

        array(
			'name' => esc_html__( 'Regenerate Thumbnails', 'pitstop'), // The plugin name
			'slug' => 'regenerate-thumbnails', // The plugin slug (typically the folder name)
			'required' => true, // If false, the plugin is only 'recommended' instead of required
		) ,

		array(
            'name' => esc_html__( 'Wordpress Importer', 'pitstop'), // The plugin name
            'slug' => 'wordpress-importer', // The plugin slug (typically the folder name)
            'required' => true, // If false, the plugin is only 'recommended' instead of required
        ),
        
		array(
			'name' => esc_html__( 'One Click Demo Import', 'pitstop'), // The plugin name
			'slug' => 'one-click-demo-import', // The plugin slug (typically the folder name)
			'required' => false, // If false, the plugin is only 'recommended' instead of required
		) ,
      
        array(
            'name' => esc_html__( 'SVG Support', 'pitstop'), // The plugin name
            'slug' => 'svg-support', // The plugin slug (typically the folder name)
            'required' => true, // If false, the plugin is only 'recommended' instead of required
        ),

        array(
            'name' => esc_html__( 'Simple Page Ordering', 'pitstop'), // The plugin name
            'slug' => 'simple-page-ordering', // The plugin slug (typically the folder name)
            'required' => false, // If false, the plugin is only 'recommended' instead of required
        ),

        array(
            'name' => esc_html__( 'Category Order and Taxonomy Terms Order', 'pitstop'), // The plugin name
            'slug' => 'taxonomy-terms-order', // The plugin slug (typically the folder name)
            'required' => false, // If false, the plugin is only 'recommended' instead of required
        ),
       
		/*************************************
		--------  PixTheme Plugins  --------
		*************************************/
        
     	array(
			'name' => esc_html__( 'Revolution Slider', 'pitstop'),
			'slug' => 'revslider',
			'source' => esc_url('https://data.true-emotions.studio/themes/_plugins/revslider.zip'),
			'required' => true,
		) ,

     	array(
			'name' => esc_html__( 'WPBakery Visual Composer', 'pitstop'),
			'slug' => 'js_composer',
			'source' => esc_url('https://data.true-emotions.studio/themes/_plugins/js_composer.zip'),
			'required' => true,
		) ,

        array(
            'name' => esc_html__( 'Pix-Settings', 'pitstop'),
            'slug' => 'pix-settings',
            'source' => esc_url('https://data.true-emotions.studio/themes/_plugins/pix-settings/pitstop/pix-settings.zip'), // The plugin source
            'required' => true,
	        'version' => '1.1.0',
        ),

        array(
            'name' => esc_html__('Envato Market', 'pitstop'),
            'slug' => 'envato-market',
            'source' => esc_url('https://data.true-emotions.studio/themes/_plugins/envato-market.zip'),
            'required' => false,
        ),
        
        array(
			'name' => esc_html__( 'WOOCS - WooCommerce Currency Switcher', 'pitstop' ),
			'slug' => 'woocommerce-currency-switcher',
			'source' => esc_url('https://data.true-emotions.studio/themes/_plugins/woocommerce-currency-switcher.zip'),
			'required' => false,
		) ,
        
        array(
			'name' => esc_html__( 'WOOBE - WooCommerce Bulk Editor and Products Manager', 'pitstop' ),
			'slug' => 'woocommerce-bulk-editor',
			'source' => esc_url('https://data.true-emotions.studio/themes/_plugins/woocommerce-bulk-editor.zip'),
			'required' => false,
		) ,
        
        array(
			'name' => esc_html__( 'Booked Appointments', 'pitstop' ),
			'slug' => 'booked',
			'source' => esc_url('https://data.true-emotions.studio/themes/_plugins/booked.zip'),
			'required' => true,
		) ,

    );
    
    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'id' => 'tgmpa', // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '', // Default absolute path to pre-packaged plugins.
        'menu' => 'tgmpa-install-plugins', // Menu slug.
        'has_notices' => true, // Show admin notices or not.
        'dismissable' => true, // If false, a user cannot dismiss the nag message.
        'dismiss_msg' => '', // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false, // Automatically activate plugins after installation or not.
        'message' => '', // Message to output right before the plugins table.
        'strings' => array(
            'page_title' => esc_html__('Install Required Plugins', 'pitstop'),
            'menu_title' => esc_html__('Install Plugins', 'pitstop'),
            'installing' => esc_html__('Installing Plugin: %s', 'pitstop'), // %s = plugin name.
            'oops' => esc_html__('Something went wrong with the plugin API.', 'pitstop'),
            'notice_can_install_required' => _n_noop('This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'pitstop'), // %1$s = plugin name(s).
            'notice_can_install_recommended' => _n_noop('This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'pitstop'), // %1$s = plugin name(s).
            'notice_cannot_install' => _n_noop('Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'pitstop'), // %1$s = plugin name(s).
            'notice_can_activate_required' => _n_noop('The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'pitstop'), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop('The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'pitstop'), // %1$s = plugin name(s).
            'notice_cannot_activate' => _n_noop('Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'pitstop'), // %1$s = plugin name(s).
            'notice_ask_to_update' => _n_noop('The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'pitstop'), // %1$s = plugin name(s).
            'notice_cannot_update' => _n_noop('Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'pitstop'), // %1$s = plugin name(s).
            'install_link' => _n_noop('Begin installing plugin', 'Begin installing plugins', 'pitstop'),
            'activate_link' => _n_noop('Begin activating plugin', 'Begin activating plugins', 'pitstop'),
            'return' => esc_html__('Return to Required Plugins Installer', 'pitstop'),
            'plugin_activated' => esc_html__('Plugin activated successfully.', 'pitstop'),
            'complete' => esc_html__('All plugins installed and activated successfully. %s', 'pitstop'), // %s = dashboard link.
            'nag_type' => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );
    
    tgmpa($plugins, $config);
    
}
	
?>