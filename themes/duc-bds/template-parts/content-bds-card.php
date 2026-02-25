<?php
/**
 * Template part for displaying a property card
 */

$post_id = get_the_ID();

// Lấy dữ liệu từ ACF
$gia = get_field('gia', $post_id);
$thumb_url = duc_bds_get_thumbnail_url($post_id);
$phuong_xa = get_the_terms($post_id, 'phuong-xa');
$hinh_thuc = get_the_terms($post_id, 'hinh-thuc-bds');

// Format giá
$gia_display = 'Liên hệ';
if($gia) {
	if($gia >= 1000) {
		$gia_display = ($gia / 1000) . ' tỷ';
	} else {
		$gia_display = $gia . ' triệu';
	}
}
?>

<article class="bg-white rounded-2xl overflow-hidden shadow hover:shadow-xl transition flex flex-col h-full border border-gray-100">
	<!-- Thumbnail -->
	<div class="relative aspect-[4/3] min-h-[180px] overflow-hidden bg-gray-50">
		<a href="<?php the_permalink(); ?>" class="block h-full">
			<img
				src="<?php echo esc_url($thumb_url); ?>"
				alt="<?php the_title_attribute(); ?>"
				class="w-full h-full object-cover hover:scale-105 transition duration-500"
				loading="lazy"
			>
		</a>

		<!-- Badge Hình thức -->
		<?php if($hinh_thuc && !is_wp_error($hinh_thuc)): ?>
			<span class="absolute top-3 left-3 bg-primary text-white text-xs font-semibold px-3 py-1 rounded-full shadow-sm">
				<?php echo esc_html($hinh_thuc[0]->name); ?>
			</span>
		<?php endif; ?>
	</div>

	<!-- Content -->
	<div class="p-4 space-y-2 flex-grow flex flex-col justify-between">
		<div>
			<h3 class="text-sm font-bold text-gray-800 line-clamp-2 min-h-[40px]">
				<a href="<?php the_permalink(); ?>" class="hover:text-primary transition no-underline">
					<?php the_title(); ?>
				</a>
			</h3>

			<p class="text-xs text-gray-500 mt-2 flex items-center gap-1">
				<span>📍</span> <?php echo ($phuong_xa && !is_wp_error($phuong_xa)) ? esc_html($phuong_xa[0]->name) . ', TP.HCM' : 'TP.HCM'; ?>
			</p>
		</div>

		<div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-50">
			<p class="text-primary font-bold text-base m-0">
				<?php echo esc_html($gia_display); ?>
			</p>
			<a href="<?php the_permalink(); ?>" class="text-xs font-semibold text-gray-400 hover:text-primary transition no-underline">
				Chi tiết →
			</a>
		</div>
	</div>
</article>
