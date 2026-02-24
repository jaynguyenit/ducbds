<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Duc_BDS
 */

get_header();
?>

<div class="py-12 bg-gray-50 min-h-screen">
	<?php get_template_part('template-parts/form-search-bds', null, array('is_compact' => true)); ?>
	
	<div class="max-w-7xl mx-auto px-4 md:px-6">
		
        <header class="mb-10">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 flex items-center justify-between gap-3">
                <span class="flex items-center gap-3">
                    <span class="w-1 h-6 bg-primary rounded-full"></span>
                    <?php
                    /* translators: %s: search query. */
                    printf( esc_html__( 'Kết quả tìm kiếm', 'duc-bds' ), '<span class="text-primary">' . get_search_query() . '</span>' );
                    ?>
                </span>
                <!-- Mobile/Tablet Filter Trigger -->
                <button type="button" class="open-filter-drawer xl:hidden flex items-center gap-1.5 px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-[13px] font-bold text-gray-700 shadow-sm active:scale-95 transition">
                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293-.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                    <span>Lọc</span>
                </button>
            </h1>
            <p class="text-gray-500 mt-2 italic">
                <?php 
                if ( have_posts() ) {
                    printf( 'Tìm thấy %d kết quả phù hợp.', $wp_query->found_posts );
                } else {
                    echo 'Không tìm thấy kết quả phù hợp với tiêu chí của bạn.';
                }
                ?>
            </p>
        </header>

		<?php if ( have_posts() ) : ?>
			<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
				<?php
				while ( have_posts() ) :
					the_post();

					if ( 'bds' === get_post_type() ) {
						get_template_part( 'template-parts/content-bds-card' );
					} else {
						get_template_part( 'template-parts/content', 'search' );
					}

				endwhile;
				?>
			</div>

			<div class="mt-12 text-center">
				<?php duc_bds_pagination(); ?>
			</div>

		<?php else : ?>
			<div class="bg-white rounded-2xl p-12 text-center shadow-sm max-w-2xl mx-auto">
				<div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
					<svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
					</svg>
				</div>
				<h2 class="text-2xl font-bold text-gray-800">Không tìm thấy bất động sản nào</h2>
				<p class="text-gray-500 mt-2">Vui lòng thử lại với các tiêu chí tìm kiếm khác hoặc sử dụng bộ lọc để thu hẹp phạm vi tìm kiếm.</p>
				<div class="mt-8">
					<?php get_search_form(); ?>
				</div>
			</div>
		<?php endif; ?>

	</div>
</div>
<?php
get_footer();
