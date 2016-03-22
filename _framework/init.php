<?php
    $path = get_template_directory();
    //---------------------------------------------------------------------------------
    //	Require Files for Houston (Load with hook to be able to use with child theme)
    //---------------------------------------------------------------------------------
        require_once(get_template_directory().'/_framework/_general.php');
        require_once(get_template_directory().'/_framework/_performance.php');
        require_once(get_template_directory().'/_framework/_images.php');
        require_once(get_template_directory().'/_framework/_extras.php');


    if(current_theme_supports( 'phpquery' )){
        require_once(get_template_directory().'/_framework/lib/phpQuery/phpQuery.php');
    }
