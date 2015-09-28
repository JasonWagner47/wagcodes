<?php //Pre-content custom field modules ?>
<?php get_template_part('modules/module-name'); ?>

<section class="wrapper">
	<article <?php post_class(); ?>>
		<?php the_content(); ?>
		<?php wp_link_pages(array('before' => '<nav>', 'after' => '</nav>')); ?>
	</article>
</section><!--/.wrapper-->

<?php //Post-content custom field modules ?>
<?php get_template_part('modules/module-name'); ?>