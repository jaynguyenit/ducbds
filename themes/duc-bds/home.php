<?php
/**
 * The template for displaying the blog posts page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Duc_BDS
 */

get_header();
?>

<div class="py-12 md:py-16 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 md:px-6"> 
        
        <div class="lg:grid lg:grid-cols-12 gap-8 lg:gap-10">
            <!-- Left Content -->
            <div class="lg:col-span-8">
                <?php if ( have_posts() ) : ?>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 md:gap-8 mb-12">
                        <?php
                        while ( have_posts() ) :
                            the_post();
                            get_template_part( 'template-parts/content-post-card' );
                        endwhile;
                        ?>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-16 flex justify-center">
                        <?php
                        the_posts_pagination( array(
                            'mid_size'  => 2,
                            'prev_text' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>',
                            'next_text' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>',
                            'class'     => 'pagination-modern'
                        ) );
                        ?>
                    </div>

                <?php else : ?>
                    <div class="bg-white rounded-3xl p-12 text-center shadow-sm">
                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v12a2 2 0 01-2 2z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v10m4-4H8"/></svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900 mb-2">Chưa có bài viết nào</h2>
                        <p class="text-gray-500">Chúng tôi sẽ sớm cập nhật những tin tức mới nhất. Vui lòng quay lại sau.</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Right Sidebar -->
            <aside class="lg:col-span-4 mt-12 lg:mt-0 space-y-10">
                <!-- Property Search -->
                <div class="p-6 bg-white rounded-2xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="w-1 h-6 bg-primary rounded-full"></span>
                        Tìm kiếm Bất động sản
                    </h3>
                    <?php get_template_part('template-parts/form-search-bds', null, array('is_sidebar' => true)); ?>
                </div>

                <?php get_sidebar(); ?>
            </aside>
        </div>

    </div>
</div>

<style>
/* Modern Pagination & Sidebar Styling - Plain CSS for maximum compatibility */
.pagination-modern .nav-links {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.pagination-modern .page-numbers {
    width: 2.5rem;
    height: 2.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 0.75rem;
    background-color: white;
    border: 1px solid #e5e7eb;
    font-size: 0.875rem;
    font-weight: 700;
    color: #374151;
    transition: all 0.2s;
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    text-decoration: none;
}
@media (min-width: 768px) {
    .pagination-modern .page-numbers {
        width: 2.75rem;
        height: 2.75rem;
    }
}
.pagination-modern .page-numbers:hover {
    border-color: var(--color-primary);
    color: var(--color-primary);
}
.pagination-modern .page-numbers.current {
    background-color: var(--color-primary);
    border-color: var(--color-primary);
    color: white;
    box-shadow: 0 10px 15px -3px rgba(var(--primary-rgb, 0, 0, 0), 0.2);
}
.pagination-modern .page-numbers.dots {
    border-color: transparent;
    background-color: transparent;
    box-shadow: none;
}
.pagination-modern .page-numbers.dots:hover {
    color: #374151;
}

/* Sidebar Widget Styling */
.widget {
    padding: 1.5rem;
    background: white;
    border-radius: 1rem;
    border: 1px solid #f3f4f6;
    margin-bottom: 2rem;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
}
.widget-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: #111827;
    margin-bottom: 1.25rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.widget-title::before {
    content: "";
    display: block;
    width: 0.375rem;
    height: 1.5rem;
    background-color: var(--color-primary, #f05a28);
    border-radius: 9999px;
}
.widget ul {
    list-style: none;
    padding: 0;
    margin: 0;
}
.widget ul li {
    padding: 0.75rem 0;
    border-bottom: 1px solid #f3f4f6;
}
.widget ul li:last-child {
    border-bottom: none;
    padding-bottom: 0;
}
.widget ul li a {
    font-size: 0.875rem;
    color: #4b5563;
    text-decoration: none;
    transition: color 0.2s;
}
.widget ul li a:hover {
    color: var(--color-primary, #f05a28);
}
</style>

<?php
get_footer();
