<?php
/**
 * The main plugin class
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Jay_Core {

	/**
	 * Singleton instance
	 */
	private static $instance = null;

	/**
	 * Get instance
	 */
	public static function get_instance() {
		if ( self::$instance === null ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor
	 */
	private function __construct() {
		$this->load_dependencies();
		$this->init_components();
	}

	/**
	 * Load required files from classes folder
	 */
	private function load_dependencies() {
		require_once JAY_CORE_PATH . 'includes/classes/class-jay-core-admin.php';
		require_once JAY_CORE_PATH . 'includes/classes/class-jay-core-media.php';
	}

	/**
	 * Initialize plugin components
	 */
	private function init_components() {
		new Jay_Core_Admin();
		new Jay_Core_Media();
	}
}
