<?php
/**
 * The template for displaying search forms in Blog
 *
 * @package Duc_BDS
 */
?>

<form role="search" method="get" class="search-form blog-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div class="relative group">
        <label>
            <span class="screen-reader-text"><?php echo _x( 'Search for:', 'label', 'duc-bds' ); ?></span>
            <input type="search" class="w-full bg-white border border-gray-200 rounded-2xl py-3.5 pl-12 pr-4 text-sm font-medium focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/5 transition shadow-sm placeholder:text-gray-400 group-hover:border-gray-300" placeholder="Tìm kiếm tin tức..." value="<?php echo get_search_query(); ?>" name="s" />
        </label>
        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-hover:text-primary transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>
        <button type="submit" class="hidden">Tìm kiếm</button>
    </div>
</form>
