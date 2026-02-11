<?php
/**
 * The template for displaying archive-bds pages
 *
 * @package Duc_BDS
 */

get_header();
?>

<div class="py-12 bg-gray-50 min-h-screen">
	<div class="max-w-7xl mx-auto px-4 md:px-6">
		
		<!-- Search Form Section -->
		<div class="mb-0">
			<?php get_template_part('template-parts/form-search-bds', null, array('is_compact' => true)); ?>
		</div>

		<div class="flex flex-row items-center justify-between gap-4 mb-8">
			<div>
				<h1 class="text-2xl md:text-3xl font-bold text-gray-900 flex items-center gap-3">
					<span class="w-1 h-6 bg-primary rounded-full"></span>
                    <span>
                        <?php 
                        if(is_tax()) {
                            echo 'Bất động sản ' . single_term_title('', false);
                        } else {
                            echo 'Tất cả Bất động sản';
                        }
                        ?>
                    </span>
					<!-- Mobile/Tablet Filter Trigger -->
					<button type="button" class="open-filter-drawer xl:hidden flex items-center gap-1.5 px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-[13px] font-bold text-gray-700 shadow-sm active:scale-95 transition">
                        <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                        Lọc
                    </button>
				</h1>
				<?php if(is_tax()): ?>
					<p class="text-gray-500 mt-1"><?php echo strip_tags(get_the_archive_description()); ?></p>
				<?php endif; ?>
			</div>
			
			<div class="text-sm text-gray-500 hidden md:block">
				Hiển thị <?php echo $wp_query->post_count; ?> trên tổng số <?php echo $wp_query->found_posts; ?> bản tin
			</div>
		</div>

		<?php if ( have_posts() ) : ?>
			<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-6">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content-bds-card' );
				endwhile;
				?>
			</div>

			<div class="mt-12">
				<?php duc_bds_pagination(); ?>
			</div>

		<?php else : ?>
			<div class="bg-white rounded-2xl p-12 text-center shadow-sm">
				<div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
					<svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
					</svg>
				</div>
				<h3 class="text-xl font-bold text-gray-800">Không tìm thấy bất động sản nào</h3>
				<p class="text-gray-500 mt-2">Vui lòng thử lại với các tiêu chí tìm kiếm khác hoặc quay lại sau.</p>
				<a href="<?php echo get_post_type_archive_link('bds'); ?>" class="mt-6 inline-block bg-primary text-white font-semibold py-2 px-6 rounded-xl hover:bg-black transition">Xem tất cả BĐS</a>
			</div>
		<?php endif; ?>

	</div>
</div>

<?php
get_footer();
