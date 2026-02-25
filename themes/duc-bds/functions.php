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
 * Register ACF Options Page
 */
if ( function_exists( 'acf_add_options_page' ) ) {
	acf_add_options_page(
		array(
			'page_title' => 'Quản lý chung',
			'menu_title' => 'Quản lý chung',
			'menu_slug'  => 'quan-ly-chung',
			'capability' => 'edit_posts',
			'redirect'   => false,
		)
	);
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
 * Extend WordPress search to include ACF field 'ma_bds' and filter by taxonomies
 */
function duc_bds_extend_search( $query ) {
    if ( ! is_admin() && $query->is_main_query() && ( $query->is_search() || $query->is_post_type_archive('bds') || $query->is_tax() ) ) {
        
        $meta_query = array( 'relation' => 'AND' );
        $tax_query  = array( 'relation' => 'AND' );
        $has_meta   = false;
        $has_tax    = false;

        // 1. Handle search empty string for BDS
        if ( $query->is_search() ) {
            $search_term = $query->get( 's' );
            if ( empty( $search_term ) ) {
                // If 's' is present but empty, we clear it to avoid WordPress empty search logic
                $query->set('s', ''); 
                // We also need to prevent it from acting as a search query if only taxonomies are present
                if (isset($_GET['post_type']) && $_GET['post_type'] === 'bds') {
                    $query->set('s', false);
                }
            }
        }

        // 2. Handle Taxonomies
        $taxonomies = array(
            'hinh-thuc-bds',
            'loai-bds',
            'phuong-xa',
            'loai-duong',
            'huong-nha',
            'tinh-trang',
            'khu-dan-cu'
        );

        foreach ( $taxonomies as $taxonomy ) {
            if ( isset( $_GET[$taxonomy] ) && ! empty( $_GET[$taxonomy] ) ) {
                $tax_query[] = array(
                    'taxonomy' => $taxonomy,
                    'field'    => 'slug',
                    'terms'    => sanitize_text_field( $_GET[$taxonomy] ),
                );
                $has_tax = true;
            }
        }

        // 3. Handle Price Range (khoang-gia)
        if ( isset( $_GET['khoang-gia'] ) && ! empty( $_GET['khoang-gia'] ) ) {
            $range = explode( '-', $_GET['khoang-gia'] );
            
            if ( count( $range ) === 2 ) {
                $min = intval( $range[0] ) * 1000000;
                $max = intval( $range[1] ) * 1000000;
                
                $meta_query[] = array(
                    'key'     => 'gia',
                    'value'   => array( $min, $max ),
                    'type'    => 'numeric',
                    'compare' => 'BETWEEN',
                );
                $has_meta = true;
            } elseif ( count( $range ) === 1 ) {
                // Handle cases like "500000" (Dưới 500 tỷ) or ">500000" (Trên 500 tỷ)
                $raw_val = $_GET['khoang-gia'];
                $val = intval( ltrim( $raw_val, '>' ) ) * 1000000;
                
                if ( strpos( $raw_val, '>' ) !== false ) {
                    $meta_query[] = array(
                        'key'     => 'gia',
                        'value'   => $val,
                        'type'    => 'numeric',
                        'compare' => '>',
                    );
                } else {
                    $meta_query[] = array(
                        'key'     => 'gia',
                        'value'   => $val,
                        'type'    => 'numeric',
                        'compare' => '<=',
                    );
                }
                $has_meta = true;
            }
        }

        if ( $has_meta ) {
            $query->set( 'meta_query', $meta_query );
        }
        if ( $has_tax ) {
            $query->set( 'tax_query', $tax_query );
        }

        // Ensure post type is only BDS when searching or filtering
        if ( $query->is_search() || $has_tax || $has_meta ) {
             $query->set( 'post_type', 'bds' );
        }
    }
}
add_action( 'pre_get_posts', 'duc_bds_extend_search' );


/**
 * Join postmeta table to the search query for BDS property code
 */
function duc_bds_search_join( $join, $wp_query ) {
    global $wpdb;
    if ( ! is_admin() && $wp_query->is_main_query() && $wp_query->is_search() ) {
        $post_type = $wp_query->get('post_type');
        if ( $post_type === 'bds' || (isset($_GET['post_type']) && $_GET['post_type'] === 'bds') ) {
            $join .= " LEFT JOIN {$wpdb->postmeta} AS bds_meta ON {$wpdb->posts}.ID = bds_meta.post_id AND bds_meta.meta_key = 'ma_bds' ";
        }
    }
    return $join;
}
add_filter( 'posts_join', 'duc_bds_search_join', 10, 2 );

/**
 * Modify search condition to include property code (ma_bds)
 */
function duc_bds_search_where( $where, $wp_query ) {
    global $wpdb;

    if ( ! is_admin() && $wp_query->is_main_query() && $wp_query->is_search() ) {
        $post_type = $wp_query->get('post_type');
        if ( $post_type === 'bds' || (isset($_GET['post_type']) && $_GET['post_type'] === 'bds') ) {
            $search_term = $wp_query->get('s');
            
            if ( ! empty($search_term) ) {
                $search_term_esc = esc_sql( $wpdb->esc_like( $search_term ) );
                
                // Matches (wp_posts.post_title LIKE '...') or (`wp_posts`.`post_title` LIKE '...')
                // We use a non-greedy catch-all (.*?) inside quotes to support WordPress placeholders (hashes)
                $table_name = preg_quote($wpdb->posts);
                $pattern = sprintf(
                    '/\(?((?:`?%s`?\.)?`?post_title`?)\s+LIKE\s+\'(.*?)\'\)?/i',
                    $table_name
                );
                
                // We extract the actual placeholder-wrapped term from the match to ensure consistency
                $where = preg_replace_callback($pattern, function($matches) use ($search_term_esc) {
                    $post_title_fragment = $matches[0];
                    $placeholder_wrapped_term = $matches[2];
                    
                    // Replace the inner term or just append our OR condition
                    return "($post_title_fragment OR bds_meta.meta_value LIKE '$placeholder_wrapped_term')";
                }, $where);
            }
        }
    }
    return $where;
}
add_filter( 'posts_where', 'duc_bds_search_where', 10, 2 );

/**
 * Ensure distinct results to avoid duplicates from join
 */
function duc_bds_search_distinct( $distinct, $wp_query ) {
    if ( ! is_admin() && $wp_query->is_main_query() && $wp_query->is_search() ) {
        $post_type = $wp_query->get('post_type');
        if ( $post_type === 'bds' || (isset($_GET['post_type']) && $_GET['post_type'] === 'bds') ) {
            return "DISTINCT";
        }
    }
    return $distinct;
}
add_filter( 'posts_distinct', 'duc_bds_search_distinct', 10, 2 );
