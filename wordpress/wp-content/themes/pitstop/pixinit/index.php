<?php

    /* Define library path */

    /* Load ADMIN main file */
    require_once(get_template_directory() . '/pixinit/admin/index.php');

    /* Load FUNCTIONS main file */
    require_once(get_template_directory() . '/pixinit/functions/index.php');
    
//    if ( did_action( 'elementor/loaded' ) ) {
//        //require_once get_template_directory() . '/pixinit/elementor/class-extension.php';
//        require_once(get_template_directory() . '/pixinit/classes/elementor.class.php');
//    }

    /* Load VC MAP files */
    require_once(get_template_directory() . '/vc_templates/vc_maps/index.php');
    

    /* Load Plugins */
    require_once(get_template_directory() . '/pixinit/import/index.php');

?>