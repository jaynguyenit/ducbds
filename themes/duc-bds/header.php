<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Duc_BDS
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<header id="masthead" class="sticky top-0 z-50 w-full bg-white/70 backdrop-blur-xl border-b border-gray-100/50 transition-all duration-300">
		<div class="max-w-7xl mx-auto px-4 md:px-6">
			<div class="flex justify-between items-center h-20">
				<!-- Logo -->
				<div class="flex-shrink-0 flex items-center">
					<?php if ( has_custom_logo() ) : ?>
						<div class="h-10 w-auto">
							<?php the_custom_logo(); ?>
						</div>
					<?php else : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-2 group no-underline">
							<div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center shadow-lg shadow-primary/20 group-hover:scale-105 transition-transform duration-300">
								<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
								</svg>
							</div>
							<span class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-gray-900 to-gray-600">
								<?php bloginfo( 'name' ); ?>
							</span>
						</a>
					<?php endif; ?>
				</div>

				<!-- Navigation Desktop -->
				<div class="hidden md:flex items-center gap-8">
					<nav id="site-navigation" class="
						[&_ul]:!list-none 
						[&_li]:py-2 md:[&_ul]:flex [&_ul]:items-center [&_ul]:gap-x-8 [&_ul]:!m-0
						[&_a]:no-underline
					">
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'menu-1',
								'menu_id'        => 'primary-menu',
								'container'      => false,
								//'items_wrap'     => '%3$s',
								'add_li_class'   => 'text-base font-medium text-gray-600 hover:text-primary transition-colors duration-200 !m-0',
								'link_before'    => '<span class="pb-1 hover:border-b-2 hover:border-primary transition-all duration-200">',
								'link_after'     => '</span>',
							)
						);
						?>
					</nav>

					<?php 
					$hotline = get_field('hotline', 'option');
					if($hotline) : ?>
						<a href="tel:<?php echo esc_attr($hotline); ?>" class="flex items-center gap-2 px-4 py-2 bg-primary/5 hover:bg-primary text-primary hover:text-white border border-primary/20 rounded-full transition-all duration-300 group no-underline">
							<div class="w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center group-hover:bg-white group-hover:text-primary transition-colors">
								<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
							</div>
							<div class="flex flex-col pr-1">
								<span class="text-[10px] uppercase font-bold leading-none opacity-70">Hotline 24/7</span>
								<span class="text-sm font-bold leading-tight"><?php echo esc_html($hotline); ?></span>
							</div>
						</a>
					<?php endif; ?>
				</div>

				<!-- Mobile menu button -->
				<div class="md:hidden flex items-center gap-3">
					<button type="button" class="mobile-menu-button inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-primary hover:bg-gray-100 focus:outline-none transition-all" aria-controls="mobile-menu" aria-expanded="false">
						<span class="sr-only">Open main menu</span>
						<svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
						</svg>
					</button>

					<?php if($hotline) : ?>
						<a href="tel:<?php echo esc_attr($hotline); ?>" class="flex items-center justify-center w-10 h-10 bg-primary text-white rounded-xl shadow-lg shadow-primary/20 active:scale-95 transition-transform">
							<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
						</a>
					<?php endif; ?>
				</div>


			</div>
		</div>

		<!-- Mobile menu, show/hide based on menu state. -->
		<div class="mobile-menu hidden md:hidden bg-white border-t border-gray-100 animate-fade-in-down">
			<div class="px-4 pt-2 pb-3 space-y-1">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-1',
						'container'      => false,
						'items_wrap'     => '%3$s',
						'add_li_class'   => 'block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-primary hover:bg-gray-50 transition-all',
					)
				);
				?>
			</div>
		</div>
	</header><!-- #masthead -->

	<?php
	// Breadcrumbs - Show on all pages except front page
	if ( ! is_front_page() && ! is_home() ) {
		get_template_part( 'template-parts/breadcrumbs' );
	}
	?>

	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const btn = document.querySelector('button.mobile-menu-button');
			const menu = document.querySelector('.mobile-menu');

			btn.addEventListener('click', () => {
				menu.classList.toggle('hidden');
			});
		});
	</script>
