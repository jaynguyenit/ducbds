<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Duc_BDS
 */

?>

	<footer class="bg-gray-900 text-gray-300 pt-10">
		<div class="max-w-7xl mx-auto px-4 md:px-6">

			<div class="grid grid-cols-1 md:grid-cols-3 gap-10">

				<!-- Column 1: About -->
				<div>
					<h3 class="text-lg font-semibold text-white mb-4">
						Về chúng tôi
					</h3>
					<p class="text-sm leading-relaxed text-gray-400">
						Website chuyên cung cấp thông tin bất động sản, cập nhật giá cả,
						xu hướng thị trường và các dự án nổi bật trên toàn quốc.
					</p>
				</div>

				<!-- Column 2: Menu -->
				<div>
					<h3 class="text-lg font-semibold text-white mb-4">
						Liên kết nhanh
					</h3>
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'menu-footer',
							'menu_id'        => 'footer-menu',
							'container'      => false,
							'menu_class'     => 'space-y-2 text-sm list-none p-0 m-0',
							'add_li_class'   => '',
							'link_class'     => 'text-gray-400 hover:text-white transition no-underline',
							'fallback_cb'    => false,
						)
					);
					?>
				</div>

				<!-- Column 3: Contact -->
				<div>
					<h3 class="text-lg font-semibold text-white mb-4">
						Liên hệ
					</h3>

					<ul class="text-sm space-y-2 text-gray-400">
						<li>📍 Đà Nẵng, Việt Nam</li>
						<li>📞 0909 000 888</li>
						<li>✉️ contact@batdongsan.vn</li>
					</ul>

					<!-- Social -->
					<div class="flex gap-4 mt-5">
						<a href="#" class="hover:text-white transition">Facebook</a>
						<a href="#" class="hover:text-white transition">Zalo</a>
						<a href="#" class="hover:text-white transition">LinkedIn</a>
					</div>
				</div>

			</div>

			<!-- Bottom -->
			<div class="border-t border-gray-800 mt-12 py-6 text-center text-sm text-gray-500">
				© 2026 Bất Động Sản. All rights reserved.
			</div>

		</div>
	</footer>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
