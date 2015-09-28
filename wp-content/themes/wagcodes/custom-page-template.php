<?php /* Template Name: Custom Page Template */ ?>

<?php get_template_part('templates/page', 'header');

if (have_posts()) : 
	while (have_posts()) : the_post();
		get_template_part('templates/content', get_post_format());
	endwhile; 
endif; ?>