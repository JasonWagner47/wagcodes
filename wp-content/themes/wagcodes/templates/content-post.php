<?php //Pre-content custom field modules ?>
<?php get_template_part('modules/module-name'); ?>

<section class="wrapper">
	<article <?php post_class(); ?>>
		<header>
			<h1><?php the_title(); ?></h1>
			<?php get_template_part('templates/entry-meta'); ?>
		</header>
	
		<section>
			<?php the_content(); ?>
		</section>
	
		<footer>
			<?php wp_link_pages(array('before' => '<nav class="page-nav"><p>' . __('Pages:', 'SM'), 'after' => '</p></nav>')); ?>
		</footer>
	</article>
	<?php comments_template('/templates/comments.php'); ?>
</section><!--/.wrapper-->

<?php //Post-content custom field modules ?>
<?php get_template_part('modules/module-name'); ?>