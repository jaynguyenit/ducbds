<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Duc_BDS
 */

$categories = get_the_category();
$category_name = ! empty( $categories ) ? $categories[0]->name : 'Tin tức';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition flex flex-col h-full'); ?>>
    
    <a href="<?php the_permalink(); ?>" class="block aspect-[16/10] overflow-hidden">
        <?php if ( has_post_thumbnail() ) : ?>
            <?php the_post_thumbnail( 'jay_core_thumb', array( 'class' => 'w-full h-full object-cover hover:scale-105 transition duration-500' ) ); ?>
        <?php else : ?>
            <img src="https://placehold.co/800x500" class="w-full h-full object-cover" alt="<?php the_title_attribute(); ?>">
        <?php endif; ?>
    </a>

    <div class="p-5 md:p-6 space-y-3 flex-grow flex flex-col">
        <span class="text-[11px] md:text-xs text-primary font-bold tracking-wider uppercase">
            <?php echo esc_html( $category_name ); ?>
        </span>

        <h3 class="text-base md:text-lg font-bold text-gray-900 leading-snug line-clamp-2 min-h-[44px] md:min-h-[56px]">
            <a href="<?php the_permalink(); ?>" class="hover:text-primary transition">
                <?php the_title(); ?>
            </a>
        </h3>

        <div class="text-[13px] md:text-sm text-gray-500 line-clamp-3 mb-4">
            <?php echo wp_trim_words( get_the_excerpt(), 25 ); ?>
        </div>

        <div class="flex items-center justify-between text-[11px] md:text-xs text-gray-400 pt-4 mt-auto border-t border-gray-100">
            <span class="flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <?php echo get_the_date( 'd/m/Y' ); ?>
            </span>
            <a href="<?php the_permalink(); ?>" class="text-primary font-bold hover:underline flex items-center gap-1 group">
                Đọc tiếp 
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="9 5l7 7-7 7" /></svg>
            </a>
        </div>

    </div>
</article>
