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
						<?php echo get_field('mo_ta_footer','option'); ?>
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

					<?php echo get_field('lien_he','option'); ?>

				</div>

			</div>

			<!-- Bottom -->
			<div class="border-t border-gray-800 mt-12 py-6 text-center text-sm text-gray-500">
				©<?php echo date('Y'); ?> Kho Nhà Tốt. All rights reserved.
			</div>

		</div>
	</footer>

</div><!-- #page -->

<?php 
$hotline = get_field('hotline', 'options');
if ( $hotline ) : 
    $phone_url = 'tel:' . str_replace( array(' ', '.', '-', '(', ')'), '', $hotline );
?>
<a href="<?php echo esc_url($phone_url); ?>" class="fixed bottom-6 right-6 z-50 flex items-center justify-center w-14 h-14 bg-primary text-white rounded-full shadow-lg hover:scale-110 active:scale-95 transition-all duration-300 group phone-no-print" title="Gọi ngay cho chúng tôi">
    <div class="absolute inset-0 bg-primary rounded-full animate-ping opacity-20 group-hover:opacity-40"></div>
    <div class="relative z-10">
        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
    </div>
</a>

<style>
@media print {
    .phone-no-print { display: none !important; }
}
</style>
<?php endif; ?>

<?php wp_footer(); ?>

</body>
</html>
