<?php
if ( ! defined('ABSPATH') ) exit;
/**
* Plugin Name: WooThemes Shortcodes
* Plugin URI: https://github.com/anandamd/woo-framework-shortcodes
* Description: Easily switch to a non WooThemes theme but retain the framework shortcodes. Use shortcodes from WooFramework in another theme. 
* Author: Riaan Knoetze
* License: GPLv2
* Version: 1.0.0
* */


// Add hooks for checking if Canvas is active
register_activation_hook(__FILE__, 'plugin_activation_check');
add_action ('init', 'plugin_activation_check');

// Check if Canvas is active
function plugin_activation_check() {

	$retired_themes = array(
	    'canvas',
	    'Definition',
	    'forthecause',
	    'function',
	    'hub',
	    'hustle',
	    'memorable',
	    'peddlar',
	    'resort',
	    'scrollider',
	    'sentient',
	    'superstore',
	    'theonepager',
	    'upstart',
	    'mystile',
	    'wootique',
	    'woostore',
	    'artificer',
	);

	if ( ! in_array( get_template(), $retired_themes ) ) {

		$functions_path = plugin_dir_path( __FILE__ ) . 'functions/';			
		require_once ( $functions_path . 'admin-shortcodes.php' );	// Woo Shortcodes
		
		// Load certain files only in the WordPress admin.
		if ( is_admin() ) {
			require_once( $functions_path . 'admin-shortcode-generator.php' );
		}

		add_action( 'wp_head', 'wfs_wp_head' );	

	} else {
		//deactivate_plugins('woothemes-shortcodes/woo-framework-shortcodes.php');
		add_action( 'admin_notices', 'plugin_activation_error_notice' );
		//wp_die( 'Please deactivate Canvas.' );
	}
}

// Display error notice if Canvas is active
function plugin_activation_error_notice() {
	?>
		<div class="notice-error notice">
		    <p><?php _e( 'Please switch to a different theme - this is required for the WooThemes Shortcodes plugin to work.', 'woothemes-shortcodes' ); ?></p>
		</div>
 	<?php
}


function wfs_wp_head() {

		woo_shortcode_stylesheet();
} 