<?php
/**
 * Property Listing Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview, false during render.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'property-listing-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'property-listing-block';
if ( ! empty( $block['className'] ) ) {
	$className .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$className .= ' align' . $block['align'];
}

// Load values and assign defaults.
$title          = get_field( 'title' ) ?: 'Bất động sản nổi bật';
$posts_per_page = get_field( 'posts_per_page' ) ?: 5;

// Taxonomies to check
$taxonomies = array(
	'loai-bds',
	'hinh-thuc-bds',
	'phuong-xa',
	'loai-duong',
	'huong-nha',
	'tinh-trang',
);

// Build Query
$args = array(
	'post_type'      => 'bds',
	'posts_per_page' => $posts_per_page,
	'tax_query'      => array(
		'relation' => 'AND',
	),
);

foreach ( $taxonomies as $taxonomy ) {
	$terms = get_field( 'terms_' . $taxonomy );
	if ( ! empty( $terms ) ) {
		$args['tax_query'][] = array(
			'taxonomy' => $taxonomy,
			'field'    => 'term_id',
			'terms'    => $terms,
		);
	}
}

// If no taxonomies are selected, remove tax_query to show all properties
if ( count( $args['tax_query'] ) === 1 ) {
	unset( $args['tax_query'] );
}

$query = new WP_Query( $args );
?>

<section id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $className ); ?> py-12">
    <div class="container">
        <div class="flex justify-between items-end mb-5">
            <h2 class="section-title mb-0"><?php echo esc_html( $title ); ?></h2>
            <!-- <a class="h-fit leading-normal no-underline bg-primary hover:bg-black text-white font-semibold py-2 px-5 rounded-xl transition" href="<?php echo esc_url( home_url( '/bds' ) ); ?>">Xem toàn bộ</a> -->
        </div>

        <?php if ( $query->have_posts() ) : ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-5">
                <?php
                while ( $query->have_posts() ) :
                    $query->the_post();
                    get_template_part( 'template-parts/content-bds-card' );
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
        <?php else : ?>
            <p class="text-gray-500 italic">Không tìm thấy bất động sản nào trong danh mục này.</p>
        <?php endif; ?>
    </div>
</section>
