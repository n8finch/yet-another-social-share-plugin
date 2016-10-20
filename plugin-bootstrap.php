<?php
/**
 * Yet Another Social Share Plugin
 *
 * @package     Yet Another Social Share
 * @author      n8finch
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: Yet Another Social Share
 * Plugin URI:  https://github.com/n8finch/yet-another-social-share-plugin.git
 * Description: Yet another social sharing plugin with an admin interface that rocks!
 * Version:     1.0.0
 * Author:      Nate Finch
 * Author URI:  https://n8finch.com
 * Text Domain: ya-social-share
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

namespace YetAnotherSocialShare;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Cheatin&#8217; uh?' );
}

/**
 * Setup the plugin's constants.
 *
 * @since 1.0.0
 *
 * @return void
 */
function yass_init_constants() {
	$plugin_url = plugin_dir_url( __FILE__ );
	if ( is_ssl() ) {
		$plugin_url = str_replace( 'http://', 'https://', $plugin_url );
	}

	define( 'YASS_URL', $plugin_url );
	define( 'YASS_DIR', plugin_dir_path( __DIR__ ) );
}

/**
 * Initialize the plugin hooks
 *
 * @since 1.0.0
 *
 * @return void
 */
function yass_init_hooks() {
	register_activation_hook( __FILE__, __NAMESPACE__ . '\yass_flush_rewrites' );
	register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );
}

/**
 * Flush the rewrites.
 *
 * @since 1.0.0
 *
 * @return void
 */
function yass_flush_rewrites() {
	yass_init_autoloader();

	flush_rewrite_rules();
}

/**
 * Kick off the plugin by initializing the plugin files.
 *
 * @since 1.0.0
 *
 * @return void
 */


function yass_init_autoloader() {

	require_once( 'src/support/autoloader.php' );

	Support\yass_autoload_files( __DIR__ . '/src/' );
}

/**
 * Enqueue jQuery UI and our scripts and styles
 *
 * @since 1.0.0
 *
 * @return void
 */
function yass_add_these_plugin_styles_and_scripts() {
	//enqueue main styles and scripts
	wp_enqueue_style( 'included-styles', YASS_URL . 'css/included_styles.css' );
}

add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\yass_add_these_plugin_styles_and_scripts' );

/**
 * Enqueue jQuery UI and our scripts and styles in admin
 *
 * @since 1.0.0
 *
 * @return void
 */
function yass_add_these_plugin_styles_and_scripts_to_admin( $hook ) {

	if ( 'toplevel_page_yass' !== $hook ) {
		return;
	}
	wp_enqueue_style( 'included-styles-admin', YASS_URL . 'css/included_styles_admin.css' );
	wp_enqueue_script( 'included-js-admin', YASS_URL . 'js/included_js_admin.js', array(
		'jquery',
		'jquery-ui-draggable',
		'jquery-ui-droppable',
		'jquery-ui-sortable',
		'iris'
	), false, false );

}

add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\yass_add_these_plugin_styles_and_scripts_to_admin' );


function dad_save_order() {

	$dad_list = get_option( 'dad_list' );

	$list      = $dad_list;
	$new_order = $_POST['list_items'];
	$new_list  = array();

	// update order
	foreach ( $new_order as $v ) {
		if ( isset( $list[ $v ] ) ) {
			$new_list[ $v ] = $list[ $v ];
		}
	}

	// save the new order
	update_option( 'dad_list', $new_list );

	die();
}

add_action( 'wp_ajax_dad_update_order', __NAMESPACE__ . '\dad_save_order' );

/**
 * Launch the plugin
 *
 * @since 1.0.0
 *
 * @return void
 */
function yass_launch() {
	yass_init_autoloader();
}


add_action( 'init', __NAMESPACE__ . '\yass_init_plugin_files', 999 );

function yass_init_plugin_files() {

	yass_init_constants();
	yass_init_hooks();
	yass_launch();

}