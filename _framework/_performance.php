<?php

    //---------------------------------------------------------------------------------
    //	Unregister core widgets to minimize DB requests
    //---------------------------------------------------------------------------------
    add_action( 'widgets_init', 'remove_unneeded_widgets' );
    function remove_unneeded_widgets() {
        unregister_widget('WP_Widget_Pages');
        unregister_widget('WP_Widget_Calendar');
        unregister_widget('WP_Widget_Tag_Cloud');
        unregister_widget('WP_Nav_Menu_Widget');
    }

    //---------------------------------------------------------------------------------
    //	Add HTML5 Boilerplate's .htaccess via WordPress
    //---------------------------------------------------------------------------------
	if(current_theme_supports( 'better-htaccess' )){
	    function stella_htaccess_writable() {
	        if (!is_writable( dirname(ABSPATH) . '/' . '.htaccess')) {
	            if (current_user_can('administrator')) {
	                add_action('admin_notices', create_function('', "echo '<div class=\"error\"><p>" . sprintf(__('Please make sure your <a href="%s">.htaccess</a> file is writable ', 'stella'), admin_url('options-permalink.php')) . "</p></div>';"));
	            }
	        }
	    }
	    add_action('admin_init', 'stella_htaccess_writable');


	    function add_h5bp_htaccess($content) {
	        global $wp_rewrite;
	        $home_path = dirname(ABSPATH).'/';
	        $htaccess_file = $home_path . '.htaccess';
	        $mod_rewrite_enabled = function_exists('got_mod_rewrite') ? got_mod_rewrite() : false;

	        if ((!file_exists($htaccess_file) && is_writable($home_path) && $wp_rewrite->using_mod_rewrite_permalinks()) || is_writable($htaccess_file)) {
	            if ($mod_rewrite_enabled) {
	                $h5bp_rules = extract_from_markers($htaccess_file, 'HTML5 Boilerplate');
	                if ($h5bp_rules === array()) {
	                    $filename = dirname(__FILE__) . '/h5bp-htaccess';
	                    return insert_with_markers($htaccess_file, 'HTML5 Boilerplate', extract_from_markers($filename, 'HTML5 Boilerplate'));
	                }
	            }
	        }

	        return $content;
	    }
	    add_action('generate_rewrite_rules', 'add_h5bp_htaccess');
	}