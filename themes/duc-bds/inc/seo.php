<?php
/**
 * SEO & Meta Tags Functions
 */

function duc_bds_add_meta_tags() {
    $title       = get_bloginfo('name');
    $description = get_field('seo_default_description', 'options') ?: get_bloginfo('description');
    $image       = get_field('seo_default_image', 'options');
    $url         = home_url(add_query_arg(null, null));
    $type        = 'website';

    if (is_singular()) {
        $post_id     = get_the_ID();
        $title       = get_the_title($post_id) . ' - ' . get_bloginfo('name');
        
        // Description logic
        $excerpt = get_the_excerpt($post_id);
        if (!$excerpt) {
            $excerpt = mb_strimwidth(wp_strip_all_tags(get_post($post_id)->post_content), 0, 160, '...');
        }
        $description = $excerpt ?: $description;

        // Image logic
        $post_thumbnail_id = get_post_thumbnail_id($post_id);
        if ($post_thumbnail_id) {
            $image = wp_get_attachment_image_url($post_thumbnail_id, 'large');
        }

        $url  = get_permalink($post_id);
        $type = 'article';
    } 
    elseif (is_tax() || is_category() || is_tag()) {
        $term        = get_queried_object();
        $title       = $term->name . ' - ' . get_bloginfo('name');
        $description = term_description() ?: $description;
        $url         = get_term_link($term);
    }
    elseif (is_post_type_archive('bds')) {
        $title = 'Danh sách Bất động sản - ' . get_bloginfo('name');
    }

    // Clean up title/description
    $title       = esc_attr($title);
    $description = esc_attr(wp_strip_all_tags($description));

    // Output tags
    ?>
    <!-- SEO Meta Tags -->
    <meta name="description" content="<?php echo $description; ?>">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="<?php echo $type; ?>">
    <meta property="og:url" content="<?php echo esc_url($url); ?>">
    <meta property="og:title" content="<?php echo $title; ?>">
    <meta property="og:description" content="<?php echo $description; ?>">
    <?php if ($image) : ?>
    <meta property="og:image" content="<?php echo esc_url($image); ?>">
    <?php endif; ?>

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo esc_url($url); ?>">
    <meta property="twitter:title" content="<?php echo $title; ?>">
    <meta property="twitter:description" content="<?php echo $description; ?>">
    <?php if ($image) : ?>
    <meta property="twitter:image" content="<?php echo esc_url($image); ?>">
    <?php endif; ?>
    <?php
}
add_action('wp_head', 'duc_bds_add_meta_tags', 1);
