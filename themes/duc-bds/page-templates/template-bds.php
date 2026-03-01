<?php
/**
 * Template Name: BDS Listing Fullwidth
 *
 * @package Duc_BDS
 */

get_header();

// Setup pagination
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

// Base query arguments
$args = array(
    'post_type'      => 'bds',
    'posts_per_page' => 12,
    'paged'          => $paged,
);

// Get the main search query if exists
$query = new WP_Query( $args );
?>

<div class="py-12 bg-gray-50 min-h-screen">
    <!-- Full-width container with large horizontal padding and centered content -->
    <div class="max-w-7xl mx-auto px-4">
        
        <!-- Search Form Section -->
        <div class="mb-8">
            <?php get_template_part('template-parts/form-search-bds', null, array('is_compact' => true)); ?>
        </div>

        <div class="flex flex-row items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 flex items-center gap-3">
                    <span class="w-1 h-6 bg-primary rounded-full"></span>
                    <span>Tất cả Bất động sản</span>
                </h1>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="text-sm text-gray-500 hidden md:block">
                    Hiển thị <?php echo $query->post_count; ?> trên tổng số <?php echo $query->found_posts; ?> bản tin
                </div>

                <!-- Mobile/Tablet Filter Trigger -->
                <button type="button" class="open-filter-drawer xl:hidden flex items-center gap-1.5 px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-[13px] font-bold text-gray-700 shadow-sm active:scale-95 transition whitespace-nowrap">
                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                    Lọc
                </button>
            </div>
        </div>

        <?php if ( $query->have_posts() ) : ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                <?php
                while ( $query->have_posts() ) :
                    $query->the_post();
                    get_template_part( 'template-parts/content-bds-card' );
                endwhile;
                ?>
            </div>

            <div class="mt-12">
                <?php 
                $big = 999999999;
                echo paginate_links( array(
                    'base'    => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                    'format'  => '?paged=%#%',
                    'current' => max( 1, $paged ),
                    'total'   => $query->max_num_pages,
                    'type'    => 'list',
                    'prev_text' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>',
                    'next_text' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>',
                ) );
                ?>
            </div>
            <?php wp_reset_postdata(); ?>

        <?php else : ?>
            <?php get_template_part('template-parts/content-none-bds'); ?>
        <?php endif; ?>

    </div>
</div>

<?php
get_footer();
