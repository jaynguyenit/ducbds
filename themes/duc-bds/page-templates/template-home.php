<?php
/*
* Template Name: Home
*/
get_header(); ?>

<section style="background-image: url('https://trannghia.net/wp-content/uploads/2021/07/7-quy-tac-vang-dau-tu-dat-nen.jpg');" class="bg-cover bg-center py-10">
	<div class="container mx-auto">
		<?php get_template_part('template-parts/form-search-bds'); ?>
	</div>
</section>

<?php the_content(); ?>

<?php get_footer();