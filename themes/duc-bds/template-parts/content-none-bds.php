<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @package Duc_BDS
 */
?>

<div class="bg-white rounded-2xl p-12 text-center shadow-sm mx-auto w-full max-w-4xl">
    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
        </svg>
    </div>
    <h3 class="text-xl font-bold text-gray-800">Không tìm thấy bất động sản nào</h3>
    <p class="text-gray-500 mt-2">Vui lòng thử lại với các tiêu chí tìm kiếm khác hoặc quay lại sau.</p>
    <a href="<?php echo get_field('trang_bds','option'); ?>" class="mt-6 inline-block bg-primary text-white font-semibold py-2 px-6 rounded-xl hover:bg-black transition">Xem tất cả BĐS</a>
</div>
