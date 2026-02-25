<?php
/**
 * Plugin Name: Jay Core
 * Description: Modular OOP plugin for enhancing and optimizing website features.
 * Version: 1.1.0
 * Author: Jay
 * Text Domain: jay-core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define plugin constants
define( 'JAY_CORE_VERSION', '1.1.0' );
define( 'JAY_CORE_PATH', plugin_dir_path( __FILE__ ) );
define( 'JAY_CORE_URL', plugin_dir_url( __FILE__ ) );

// Include the main Jay Core class from classes folder
require_once JAY_CORE_PATH . 'includes/classes/class-jay-core.php';

/**
 * Initialize the plugin
 */
function jay_core_init() {
	return Jay_Core::get_instance();
}

// Start the plugin
jay_core_init();
