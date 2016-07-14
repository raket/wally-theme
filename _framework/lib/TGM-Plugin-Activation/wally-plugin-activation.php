<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1 for parent theme Wally
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 *
 * Depending on your implementation, you may want to change the include call:
 *
 * Parent Theme:
 * require_once get_template_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Child Theme:
 * require_once get_stylesheet_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Plugin:
 * require_once dirname( __FILE__ ) . '/path/to/class-tgm-plugin-activation.php';
 */
require_once get_template_directory() . '/_framework/lib/TGM-Plugin-Activation/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'wally_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variables passed to the `tgmpa()` function should be:
 * - an array of plugin arrays;
 * - optionally a configuration array.
 * If you are not changing anything in the configuration array, you can remove the array and remove the
 * variable from the function call: `tgmpa( $plugins );`.
 * In that case, the TGMPA default settings will be used.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function wally_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		// This is an example of how to include a plugin from a GitHub repository in your theme.
		// This presumes that the plugin code is based in the root of the GitHub repository
		// and not in a subdirectory ('/src') of the repository.
		array(
			'name'      => 'Wally Plugin',
			'slug'      => 'wally-plugin',
			'source'    => 'https://github.com/raket/wally-plugin/archive/master.zip',
			'required'           => true, // If false, the plugin is only 'recommended' instead of required.
			'force_activation'   => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
		),


	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'wally',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => false,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.



		'strings'      => array(
			'page_title'                       => __( 'Installera obligatoriska tillägg', 'wally' ),
			'menu_title'                      => __( 'Installera tillägg', 'wally' ),
			'installing'                      => __( 'Installerar tillägg: %s', 'wally' ),
			'updating'                        => __( 'Uppdaterar tillägg: %s', 'wally' ),
			'oops'                            => __( 'Någonting gick fel med.', 'wally' ),
			'notice_can_install_required'     => _n_noop(
				'Temat kräver att följande tillägg är installerade: %1$s.',
				'Temat kräver att följande tillägg är installerade: %1$s.',
				'wally'
			),
			'notice_can_install_recommended'  => _n_noop(
				'Temat rekommenderar att följande tillägg är installerade: %1$s.',
				'Temat rekommenderar att följande tillägg är installerade: %1$s.',
				'wally'
			),
			'notice_ask_to_update'            => _n_noop(
				'Följande tillägget behöver uppdateras till den senaste versionen för att säkerställa maximal kompatibilitet med detta tema: %1$s.',
				'Följande tillägget behöver uppdateras till den senaste versionen för att säkerställa maximal kompatibilitet med detta tema: %1$s.',
				'wally'
			),
			'notice_ask_to_update_maybe'      => _n_noop(
				'Det finns en uppdatering tillgänglig för: %1$s.',
				'Det finns uppdateringar tillgängliga för de följande tillägg: %1$s.',
				'wally'
			),
			'notice_can_activate_required'    => _n_noop(
				'Följande obligatoriska tillägg är för närvarande inaktivt: %1$s.',
				'Följande obligatoriska tillägg är för närvarande inaktiva: %1$s.',
				'wally'
			),
			'notice_can_activate_recommended' => _n_noop(
				'Följande rekommenderade tillägg är för närvarande inaktivt: %1$s.',
				'Följande rekommenderade tillägg är för närvarande inaktivt: %1$s.',
				'wally'
			),
			'install_link'                    => _n_noop(
				'Installera tillägg',
				'Installera tillägg',
				'wally'
			),
			'update_link' 					  => _n_noop(
				'Uppdaterar tillägg',
				'Uppdaterar tillägg',
				'wally'
			),
			'activate_link'                   => _n_noop(
				'Aktiverar tillägg',
				'Aktiverar tillägg',
				'wally'
			),
			'return'                          => __( 'Return to Required Plugins Installer', 'wally' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'wally' ),
			'activated_successfully'          => __( 'The following plugin was activated successfully:', 'wally' ),
			'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'wally' ),
			'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'wally' ),
			'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'wally' ),
			'dismiss'                         => __( 'Dismiss this notice', 'wally' ),
			'notice_cannot_install_activate'  => __( 'There are one or more required or recommended plugins to install, update or activate.', 'wally' ),
			'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'wally' ),

			'nag_type'                        => '', // Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
		),
	);

	tgmpa( $plugins, $config );
}
