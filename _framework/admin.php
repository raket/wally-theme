<?php

//---------------------------------------------------------------------------------
//	Disable standard widgets
//---------------------------------------------------------------------------------

function stella_disable_default_dashboard_widgets() {

    // remove_meta_box('dashboard_right_now', 'dashboard', 'core');    // Right Now Widget
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'core'); // Comments Widget
    remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');  // Incoming Links Widget
    remove_meta_box('dashboard_plugins', 'dashboard', 'core');         // Plugins Widget

    // remove_meta_box('dashboard_quick_press', 'dashboard', 'core');  // Quick Press Widget
    remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');   // Recent Drafts Widget
    remove_meta_box('dashboard_primary', 'dashboard', 'core');         //
    remove_meta_box('dashboard_secondary', 'dashboard', 'core');       //

    // removing plugin dashboard boxes
    remove_meta_box('yoast_db_widget', 'dashboard', 'normal');         // Yoast's SEO Plugin Widget
}

// removing the dashboard widgets
add_action('admin_menu', 'stella_disable_default_dashboard_widgets');



//---------------------------------------------------------------------------------
//	Only show update notifications for Admins
//---------------------------------------------------------------------------------
function hide_plugin_updates(){
    global $user_login;
    if (!current_user_can('update_plugins')) { // checks to see if current user can update plugins
        add_action( 'init', create_function( '$a', "remove_action( 'init', 'wp_version_check' );" ), 2 );
        add_filter( 'pre_option_update_core', create_function( '$a', "return null;" ) );
    }
}
// Hide update notifications
add_action('admin_init', 'hide_plugin_updates');


// Custom Backend Footer
function stella_custom_admin_footer() {
    _e('<span class="wally__byline"><img src="'.esc_url( home_url() ).'/wp-content/plugins/wally-plugin/static/img/logo.svg" alt="">Läs mer om Wally på <a href="http://www.wally-wp.se" target="_blank">Wallys webbplats</a>.</span>', 'wally-theme');
}
add_filter('admin_footer_text', 'stella_custom_admin_footer');

// changing the logo link from wordpress.org to your site
function stella_modify_login_url() {  return home_url(); }
add_filter('login_headerurl', 'stella_modify_login_url');

// Hide login errors
function no_wordpress_errors(){
	return 'Your credentials are invalid (This is a simplified notice to prevent security breaches)';
}
add_filter( 'login_errors', 'no_wordpress_errors' );


//---------------------------------------------------------------------------------
//	Add RSS-feed from wally-wp.se to dashboard
//---------------------------------------------------------------------------------
function wally_dashboard_widgets() {
	add_meta_box( 'id', __( 'Nyheter från Wally-teamet' ), 'dashboard_custom_feed_output', 'dashboard', 'side', 'high' );
}
function dashboard_custom_feed_output() {
	echo '<div class="rss-widget">';
	wp_widget_rss_output( array (
		'url' => 'https://wally-wp.se/feed',
		'title' => 'Wally-nytt',
		'items' => 3,
		'show_summary' => 1,
		'show_author' => 0,
		'show_date' => 0
	));
	echo "</div>";
}
add_action('wp_dashboard_setup', 'wally_dashboard_widgets');


//---------------------------------------------------------------------------------
//	Add Wally theme update notification to dashboard if version is lower than 1.0.12
//---------------------------------------------------------------------------------

function admin_notice__theme_update() {
	require_once 'lib/theme-update-checker.php';
	$current_theme = wp_get_theme();
	$current_theme_version = $current_theme->get( 'Version' );
	?>
	<?php if( version_compare( $current_theme_version, '1.0.12', '<') && current_user_can('update_plugins') ) : ?>
        <div class="notice notice-info is-dismissible">
            <p><?php _e( 'Det finns en ny uppdatering för Wally Tema! <a href="/wp-admin/update-core.php">Vänligen uppdatera snarast</a>. ', 'wally-theme' ); ?></p>
        </div>
	<?php endif;
}
add_action( 'admin_notices', 'admin_notice__theme_update' );