<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Duc_BDS
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function duc_bds_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'duc_bds_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function duc_bds_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'duc_bds_pingback_header' );


/**
 * @param array $providers The collection of providers that will be used to scan the design payload
 * @return array
 */
function register_my_theme_provider(array $providers): array {
    $providers[] = [
        'id' => 'duc_bds', // The id of this custom provider. It should be unique across all providers
        'name' => 'Duc BDS Theme Scanner',
        'description' => 'Scans the current active theme and child theme',
        'callback' => 'scanner_cb_my_theme_provider', // The function that will be called to get the data. Please see the next step for the implementation
        'enabled' => \WindPress\WindPress\Utils\Config::get(sprintf(
            'integration.%s.enabled',
            'duc_bds' // The id of this custom provider
        ), true),
    ];

    return $providers;
}
add_filter('f!windpress/core/cache:compile.providers', 'register_my_theme_provider');


function scanner_cb_my_theme_provider(): array {
    // The file with this extension will be scanned, you can add more extensions if needed
    $file_extensions = [
        'php',
        'js',
        'html',
    ];

    $contents = [];
    $finder = new \WindPressDeps\Symfony\Component\Finder\Finder();

    // The current active theme
    $wpTheme = wp_get_theme();
    $themeDir = $wpTheme->get_stylesheet_directory();

    // Check if the current theme is a child theme and get the parent theme directory
    $has_parent = $wpTheme->parent() ? true : false;
    $parentThemeDir = $has_parent ? $wpTheme->parent()->get_stylesheet_directory() : null;

    // Scan the theme directory according to the file extensions
    foreach ($file_extensions as $extension) {
        $finder->files()->in($themeDir)->name('*.' . $extension);
        if ($has_parent) {
            $finder->files()->in($parentThemeDir)->name('*.' . $extension);
        }
    }

    // Get the file contents and send to the compiler
    foreach ($finder as $file) {
        $contents[] = [
            'name' => $file->getRelativePathname(),
            'content' => $file->getContents(),
        ];
    }

    return $contents;
}

// Disable Gutenberg on the back end
//add_filter( 'use_block_editor_for_post', '__return_false' );

// Disable Gutenberg for widgets
//add_filter( 'use_widgets_block_editor', '__return_false' );

// Remove Gutenberg CSS on the front end
// add_action( 'wp_enqueue_scripts', function() {
//     wp_dequeue_style( 'wp-block-library' ); // Core block CSS
//     wp_dequeue_style( 'wp-block-library-theme' ); // Theme block CSS
//     wp_dequeue_style( 'global-styles' ); // Inline CSS
//     wp_dequeue_style( 'classic-theme-styles' ); // Classic theme CSS
// }, 20 );

function my_acf_json_save_point( $path ) {
    return get_stylesheet_directory() . '/acf-jsons';
}
add_filter( 'acf/settings/save_json', 'my_acf_json_save_point' );

/**
 * Get the property thumbnail URL with fallback logic
 * 
 * Order: Featured Image > First image in ACF Gallery > Placeholder
 * 
 * @param int $post_id The post ID
 * @param string $size The image size (thumbnail, medium, large, full)
 * @return string The image URL
 */
function duc_bds_get_thumbnail_url($post_id, $size = 'medium') {
    // 1. Check for Featured Image
    if (has_post_thumbnail($post_id)) {
        return get_the_post_thumbnail_url($post_id, $size);
    }

    // 2. Check for ACF Gallery
    $hinh_anh = get_field('hinh_anh', $post_id);
    if ($hinh_anh && is_array($hinh_anh) && !empty($hinh_anh)) {
        $first_image = $hinh_anh[0];
        if (isset($first_image['sizes'][$size])) {
            return $first_image['sizes'][$size];
        }
        return $first_image['url'];
    }

    // 3. Fallback to Placeholder
    return 'https://placehold.co/800x600?text=DucBDS';
}

/**
 * Breadcrumbs logic for Duc BDS
 * Returns an array of breadcrumb items
 */
function duc_bds_get_breadcrumbs() {
	$breadcrumbs = array();
	
	// Home
	$breadcrumbs[] = array(
		'name' => 'Trang chủ',
		'url'  => home_url( '/' ),
	);

	if ( is_archive() || is_single() ) {
		if ( is_post_type_archive( 'bds' ) || is_singular( 'bds' ) || is_tax( array( 'loai-bds', 'hinh-thuc-bds', 'phuong-xa', 'loai-duong', 'huong-nha', 'tinh-trang' ) ) ) {
			
			// Custom path for Real Estate
			$breadcrumbs[] = array(
				'name' => 'Bất động sản',
				'url'  => get_post_type_archive_link( 'bds' ),
			);

			if ( is_singular( 'bds' ) ) {
				$terms = get_the_terms( get_the_ID(), 'loai-bds' );
				if ( $terms && ! is_wp_error( $terms ) ) {
					$breadcrumbs[] = array(
						'name' => $terms[0]->name,
						'url'  => get_term_link( $terms[0] ),
					);
				}
				$breadcrumbs[] = array(
					'name' => get_the_title(),
					'url'  => get_permalink(),
				);
			} elseif ( is_tax() ) {
				$queried_object = get_queried_object();
				$breadcrumbs[] = array(
					'name' => $queried_object->name,
					'url'  => get_term_link( $queried_object ),
				);
			}
		} elseif ( is_category() || is_tag() || is_singular( 'post' ) ) {
			// Blog path
			if ( is_singular( 'post' ) ) {
				$cats = get_the_category();
				if ( $cats ) {
					$breadcrumbs[] = array(
						'name' => $cats[0]->name,
						'url'  => get_category_link( $cats[0] ),
					);
				}
				$breadcrumbs[] = array(
					'name' => get_the_title(),
					'url'  => get_permalink(),
				);
			} else {
				$queried_object = get_queried_object();
				$breadcrumbs[] = array(
					'name' => $queried_object->name,
					'url'  => get_term_link( $queried_object ),
				);
			}
		}
	} elseif ( is_page() ) {
		global $post;
		if ( $post->post_parent ) {
			$parent_id  = $post->post_parent;
			$parents = array();
			while ( $parent_id ) {
				$page = get_post( $parent_id );
				$parents[] = array(
					'name' => get_the_title( $page->ID ),
					'url'  => get_permalink( $page->ID ),
				);
				$parent_id = $page->post_parent;
			}
			$breadcrumbs = array_merge( $breadcrumbs, array_reverse( $parents ) );
		}
		$breadcrumbs[] = array(
			'name' => get_the_title(),
			'url'  => get_permalink(),
		);
	} elseif ( is_search() ) {
		$breadcrumbs[] = array(
			'name' => 'Tìm kiếm: ' . get_search_query(),
			'url'  => '',
		);
	} elseif ( is_404() ) {
		$breadcrumbs[] = array(
			'name' => 'Lỗi 404',
			'url'  => '',
		);
	}

	return $breadcrumbs;
}

/**
 * Display pagination with Tailwind CSS
 */
function duc_bds_pagination() {
    global $wp_query;

    $total_pages = $wp_query->max_num_pages;

    if ($total_pages <= 1) {
        return;
    }

    $current_page = max(1, get_query_var('paged'));

    $links = paginate_links(array(
        'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
        'format' => '?paged=%#%',
        'current' => $current_page,
        'total' => $total_pages,
        'type' => 'array',
        'prev_next' => true,
        'prev_text' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>',
        'next_text' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>',
    ));

    if (is_array($links)) {
        echo '<nav class="flex justify-center" aria-label="Pagination">';
        echo '<ul class="flex items-center gap-2 list-none p-0 m-0">';

        foreach ($links as $link) {
            $class = "inline-flex items-center justify-center w-10 h-10 rounded-xl text-sm font-semibold transition-all duration-200 border no-underline";
            
            if (strpos($link, 'current') !== false) {
                $class .= " bg-primary border-primary text-white shadow-lg shadow-indigo-100";
            } else {
                $class .= " bg-white border-gray-200 text-gray-600 hover:border-primary hover:text-primary hover:shadow-sm";
            }

            echo '<li>' . str_replace('page-numbers', $class, $link) . '</li>';
        }

        echo '</ul>';
        echo '</nav>';
    }
}

/**
 * Customize the archive title prefix
 */
function duc_bds_archive_title( $title ) {
    if ( is_category() ) {
        $title = 'Danh mục: ' . single_cat_title( '', false );
    } elseif ( is_tag() ) {
        $title = 'Thẻ: ' . single_tag_title( '', false );
    } elseif ( is_author() ) {
        $title = 'Tác giả: ' . get_the_author();
    } elseif ( is_post_type_archive() ) {
        $title = post_type_archive_title( '', false );
    } elseif ( is_tax() ) {
        $title = single_term_title( '', false );
    }

    return $title;
}
add_filter( 'get_the_archive_title', 'duc_bds_archive_title' );
