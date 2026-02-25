<?php
/**
 * Admin settings class
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Jay_Core_Admin {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'acf/init', array( $this, 'register_options_page' ) );
        add_action( 'acf/init', array( $this, 'register_settings_fields' ) );
	}

	/**
	 * Register ACF Options Page
	 */
	public function register_options_page() {
		if ( function_exists( 'acf_add_options_page' ) ) {
			acf_add_options_page(
				array(
					'page_title' => 'Jay Core Settings',
					'menu_title' => 'Jay Core',
					'menu_slug'  => 'jay-core-settings',
					'capability' => 'edit_posts',
					'redirect'   => false,
                    'icon_url'   => 'dashicons-admin-generic',
				)
			);
		}
	}

    /**
     * Register settings fields via PHP to keep plugin self-contained
     */
    public function register_settings_fields() {
        if ( function_exists( 'acf_add_local_field_group' ) ) {
            acf_add_local_field_group( array(
                'key' => 'group_jay_core_settings',
                'title' => 'Jay Core Settings',
                'fields' => array(
                    array(
                        'key' => 'field_jay_core_tab_media',
                        'label' => 'Media Optimization',
                        'type' => 'tab',
                        'placement' => 'top',
                        'endpoint' => 0,
                    ),
                    array(
                        'key' => 'field_jay_core_optimize_media',
                        'label' => 'Enable Image Optimization',
                        'name' => 'jay_core_optimize_media',
                        'instructions' => 'Only generate Original and 600x400px thumbnail to save server resources.',
                        'type' => 'true_false',
                        'default_value' => 1,
                        'ui' => 1,
                        'ui_on_text' => 'Enabled',
                        'ui_off_text' => 'Disabled',
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'options_page',
                            'operator' => '==',
                            'value' => 'jay-core-settings',
                        ),
                    ),
                ),
            ) );
        }
    }
}
