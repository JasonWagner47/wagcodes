<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<?php get_template_part('templates/head'); ?>

	<body <?php body_class(); ?>>
	<?php get_template_part('templates/header'); ?>

		<main role="document">
		<?php include SM_template_path(); ?>

		<?php if (SM_display_sidebar()) : ?>
			<aside>
				<?php include SM_sidebar_path(); ?>
			</aside>
		<?php endif; ?>
		</main>

	<?php get_template_part('templates/footer'); ?>
	</body>
</html>