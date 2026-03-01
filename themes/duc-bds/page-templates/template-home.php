<?php
/*
* Template Name: Home
*/
get_header(); 
$bg = get_field('background');
?>

<section style="background-image: url('<?php echo $bg; ?>');" class="bg-cover bg-center py-10">
	<div class="container mx-auto">
		<?php get_template_part('template-parts/form-search-bds'); ?>
	</div>
</section>

<?php the_content(); ?>

<?php get_footer();