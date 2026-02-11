<?php
/**
 * Template part for displaying breadcrumbs
 */

$breadcrumbs = duc_bds_get_breadcrumbs();

if ( empty( $breadcrumbs ) ) {
	return;
}
?>

<nav class="bg-white border-b border-gray-100 py-3 mb-6 md:mb-8" aria-label="Breadcrumb">
	<div class="max-w-7xl mx-auto px-4 md:px-6">
		<ol class="flex items-center gap-2 text-sm text-gray-500 list-none p-0 m-0 overflow-x-auto scrollbar-hide whitespace-nowrap pb-1 md:pb-0">
			<?php foreach ( $breadcrumbs as $index => $item ) : ?>
				<li class="flex items-center gap-2">
					<?php if ( $index > 0 ) : ?>
						<svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
							<path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
						</svg>
					<?php endif; ?>

					<?php if ( $index === count( $breadcrumbs ) - 1 || empty( $item['url'] ) ) : ?>
						<span class="font-medium text-gray-900 truncate max-w-[150px] md:max-w-md">
							<?php echo esc_html( $item['name'] ); ?>
						</span>
					<?php else : ?>
						<a href="<?php echo esc_url( $item['url'] ); ?>" class="hover:text-primary transition-colors duration-200 no-underline">
							<?php echo esc_html( $item['name'] ); ?>
						</a>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</nav>

<!-- Schema.org JSON-LD -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
	<?php 
	$list_items = array();
	foreach ( $breadcrumbs as $index => $item ) {
		$list_items[] = array(
			"@type" => "ListItem",
			"position" => $index + 1,
			"name" => $item['name'],
			"item" => !empty($item['url']) ? $item['url'] : home_url( add_query_arg( array(), $wp->request ) )
		);
	}
	echo json_encode($list_items, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
	?>
  ]
}
</script>
