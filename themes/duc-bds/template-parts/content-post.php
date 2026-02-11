<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Duc_BDS
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden'); ?>>
    <!-- Featured image -->
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="aspect-[21/9] w-full overflow-hidden">
            <?php the_post_thumbnail('full', array('class' => 'w-full h-full object-cover hover:scale-105 transition-transform duration-700')); ?>
        </div>
    <?php endif; ?>

    <div class="p-6 md:p-10">
        <!-- Title & Meta -->
        <header class="mb-8 space-y-4">
            <div class="flex flex-wrap items-center gap-3">
                <?php
                $categories = get_the_category();
                if ( ! empty( $categories ) ) {
                    foreach ( $categories as $category ) {
                        echo '<a href="' . esc_url( get_term_link( $category ) ) . '" class="px-3 py-1 bg-primary/10 text-primary text-xs font-bold rounded-full hover:bg-primary hover:text-white transition-all">';
                        echo esc_html( $category->name );
                        echo '</a>';
                    }
                }
                ?>
                <span class="text-gray-400 text-xs flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <?php echo get_the_date(); ?>
                </span>
            </div>

            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight">
                <?php the_title(); ?>
            </h1>
        </header>

        <!-- Content -->
        <div class="prose prose-lg max-w-none text-gray-700 
            prose-headings:text-gray-900 prose-headings:font-bold 
            prose-p:leading-relaxed prose-p:mb-5
            prose-a:text-primary prose-a:no-underline hover:prose-a:underline
            prose-img:rounded-2xl prose-img:shadow-lg
            prose-strong:text-gray-900
            prose-ul:list-disc prose-ol:list-decimal
        ">
            <?php
            the_content();

            wp_link_pages(
                array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'duc-bds' ),
                    'after'  => '</div>',
                )
            );
            ?>
        </div>

        <!-- Footer / Share -->
        <footer class="mt-12 pt-8 border-t border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-3">
                <span class="text-sm font-bold text-gray-900">Chia sẻ bài viết:</span>
                <div class="flex items-center gap-2">
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="w-9 h-9 flex items-center justify-center rounded-full bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.77,7.46H14.5v-1.9c0-.9.6-1.1,1-1.1h3V1h-4.33C10.24,1,9.5,3.44,9.5,5.32v2.15h-3v4h3v12h5v-12h3.85Z"/></svg>
                    </a>
                    <a href="https://social-plugins.itworks.vn/share?url=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="w-9 h-9 flex items-center justify-center rounded-full bg-blue-50 text-blue-500 hover:bg-blue-500 hover:text-white transition-all shadow-sm">
                        <span class="font-bold text-xs">Zalo</span>
                    </a>
                </div>
            </div>
            
            <div class="flex flex-wrap gap-2 text-xs">
                <?php the_tags('<span class="text-gray-400">Thẻ:</span> ', ' ', ''); ?>
            </div>
        </footer>
    </div>
</article>

<!-- Related Posts -->
<div class="mt-12">
    <h2 class="text-2xl font-bold text-gray-900 mb-8 flex items-center gap-3">
        <span class="w-1 h-6 bg-primary rounded-full"></span>
        Bài viết liên quan
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <?php
        $related = new WP_Query( array(
            'category__in'   => wp_get_post_categories($post->ID),
            'posts_per_page' => 2,
            'post__not_in'   => array($post->ID)
        ) );

        if( $related->have_posts() ) {
            while( $related->have_posts() ) {
                $related->the_post();
                get_template_part( 'template-parts/content-post-card' );
            }
            wp_reset_postdata();
        }
        ?>
    </div>
</div>
