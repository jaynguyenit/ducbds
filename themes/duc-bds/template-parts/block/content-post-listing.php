<?php
/**
 * Post Listing Block Template.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'post-listing-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'post-listing-block';
if ( ! empty( $block['className'] ) ) {
	$className .= ' ' . $block['className'];
}

// Load values and assign defaults.
$title          = get_field( 'title' ) ?: 'Tin tức Bất Động Sản';
$subtitle       = get_field( 'subtitle' );
$mode           = get_field( 'mode' ) ?: 'latest';
$selected_posts = get_field( 'selected_posts' );
$posts_per_page = get_field( 'posts_per_page' ) ?: 3;

// Build Query
$args = array(
	'post_type'           => 'post',
	'post_status'         => 'publish',
	'ignore_sticky_posts' => true,
);

if ( 'manual' === $mode && ! empty( $selected_posts ) ) {
	$args['post__in'] = $selected_posts;
	$args['orderby']  = 'post__in';
} else {
	$args['posts_per_page'] = $posts_per_page;
	$args['orderby']        = 'date';
	$args['order']          = 'DESC';
}

$query = new WP_Query( $args );
?>

<section id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $className ); ?> bg-gray-50 py-16">
    <div class="container">

        <!-- Header -->
        <div class="mb-10 text-center">
            <h2 class="text-3xl font-semibold text-gray-800">
                <?php echo esc_html( $title ); ?>
            </h2>
            <?php if ( $subtitle ) : ?>
                <p class="mt-2 text-gray-500 max-w-2xl mx-auto">
                    <?php echo esc_html( $subtitle ); ?>
                </p>
            <?php endif; ?>
        </div>

        <?php if ( $query->have_posts() ) : ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
                while ( $query->have_posts() ) :
                    $query->the_post();
                    get_template_part( 'template-parts/content-post-card' );
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
        <?php else : ?>
            <p class="text-center text-gray-500 italic">Hiện đang cập nhật tin tức...</p>
        <?php endif; ?>

    </div>
</section>
