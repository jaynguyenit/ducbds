<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Duc_BDS
 */

get_header();
?>

<div class="py-12 md:py-16 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 md:px-6">
        <div class="lg:grid lg:grid-cols-12 gap-8 lg:gap-10">
            <!-- Left Content -->
            <main id="primary" class="lg:col-span-8 space-y-8">
                <?php
                while ( have_posts() ) :
                    the_post();
                    get_template_part( 'template-parts/content', get_post_type() );
                endwhile;
                ?>
            </main>

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
