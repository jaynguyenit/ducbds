<?php
/**
 * Duc BDS functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Duc_BDS
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function duc_bds_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Duc BDS, use a find and replace
		* to change 'duc-bds' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'duc-bds', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Menu Chính', 'duc-bds' ),
			'menu-footer' => esc_html__( 'Menu Footer', 'duc-bds' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'duc_bds_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'duc_bds_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function duc_bds_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'duc_bds_content_width', 640 );
}
add_action( 'after_setup_theme', 'duc_bds_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function duc_bds_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'duc-bds' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'duc-bds' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title flex items-center gap-2"><span class="w-1 h-6 bg-primary rounded-full"></span>',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'duc_bds_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function duc_bds_scripts() {
	wp_enqueue_style( 'duc-bds-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'duc-bds-style', 'rtl', 'replace' );

	if(is_singular('bds')){
		wp_enqueue_style( 'swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(), '11.0.0' );
		wp_enqueue_script( 'swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), '11.0.0', true );
	}
	
	wp_enqueue_script( 'duc-bds-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'duc-bds-scripts', get_template_directory_uri() . '/js/scripts.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'duc_bds_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Register ACF Blocks
 */
require get_template_directory() . '/inc/blocks.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Register custom taxonomies.
 */
function duc_bds_register_taxonomies() {
	register_taxonomy( 'khu-dan-cu', array( 'bds' ), array(
		'labels'            => array(
			'name'              => __( 'Khu dân cư', 'duc-bds' ),
			'singular_name'     => __( 'Khu dân cư', 'duc-bds' ),
			'search_items'      => __( 'Tìm Khu dân cư', 'duc-bds' ),
			'all_items'         => __( 'Tất cả Khu dân cư', 'duc-bds' ),
			'parent_item'       => __( 'Khu dân cư cha', 'duc-bds' ),
			'parent_item_colon' => __( 'Khu dân cư cha:', 'duc-bds' ),
			'edit_item'         => __( 'Sửa Khu dân cư', 'duc-bds' ),
			'update_item'       => __( 'Cập nhật Khu dân cư', 'duc-bds' ),
			'add_new_item'      => __( 'Thêm Khu dân cư mới', 'duc-bds' ),
			'new_item_name'     => __( 'Tên Khu dân cư mới', 'duc-bds' ),
			'menu_name'         => __( 'Khu dân cư', 'duc-bds' ),
		),
		'hierarchical'      => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'khu-dan-cu' ),
		'show_in_rest'      => true,
	) );
}
add_action( 'init', 'duc_bds_register_taxonomies' );

/**
 * Add custom class to li elements in wp_nav_menu
 */
function duc_bds_add_li_class( $classes, $item, $args ) {
	if ( isset( $args->add_li_class ) ) {
		$classes[] = $args->add_li_class;
	}
	return $classes;
}
add_filter( 'nav_menu_css_class', 'duc_bds_add_li_class', 10, 3 );

/**
 * Get cached taxonomy terms using transients.
 *
 * @param string $taxonomy Taxonomy slug.
 * @return array|WP_Error Array of terms or WP_Error.
 */
function duc_bds_get_cached_terms( $taxonomy ) {
	$transient_key = 'duc_bds_terms_' . $taxonomy;
	$terms         = get_transient( $transient_key );

	if ( false === $terms ) {
		$terms = get_terms(
			array(
				'taxonomy'   => $taxonomy,
				'hide_empty' => false,
			)
		);

		if ( ! is_wp_error( $terms ) ) {
			set_transient( $transient_key, $terms, 12 * HOUR_IN_SECONDS );
		}
	}

	return $terms;
}

/**
 * Clear taxonomy transients when terms are updated.
 *
 * @param int    $term_id  Term ID.
 * @param int    $tt_id    Term taxonomy ID.
 * @param string $taxonomy Taxonomy slug.
 */
function duc_bds_clear_taxonomy_transients( $term_id, $tt_id, $taxonomy ) {
	$taxonomies_to_clear = array(
		'loai-bds',
		'hinh-thuc-bds',
		'phuong-xa',
		'loai-duong',
		'huong-nha',
		'tinh-trang',
		'khu-dan-cu',
	);

	if ( in_array( $taxonomy, $taxonomies_to_clear, true ) ) {
		delete_transient( 'duc_bds_terms_' . $taxonomy );
	}
}

// Hooks to clear transients on taxonomy changes.
add_action( 'created_term', 'duc_bds_clear_taxonomy_transients', 10, 3 );
add_action( 'edited_term', 'duc_bds_clear_taxonomy_transients', 10, 3 );
add_action( 'delete_term', 'duc_bds_clear_taxonomy_transients', 10, 3 );

/**
 * Extend WordPress search to include ACF field 'ma_bds'
 */
function duc_bds_extend_search( $query ) {
    if ( ! is_admin() && $query->is_main_query() && $query->is_search() && 'bds' === $query->get( 'post_type' ) ) {
        $search_term = $query->get( 's' );
        
        if ( ! empty( $search_term ) ) {
            $meta_query = array(
                'relation' => 'OR',
                array(
                    'key'     => 'ma_bds',
                    'value'   => $search_term,
                    'compare' => 'LIKE',
                ),
            );
            
            // Note: WordPress default search also runs. 
            // Setting meta_query with OR will find posts matching EVERYTHING or just the meta.
            $query->set( 'meta_query', $meta_query );
        }
    }
}
add_action( 'pre_get_posts', 'duc_bds_extend_search' );
