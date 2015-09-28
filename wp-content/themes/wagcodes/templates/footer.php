	<footer role="contentinfo">
		<div>
			<?php dynamic_sidebar('sidebar-footer'); ?>
			<p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?></p>
		</div>
	</footer>
	
	<?php wp_footer(); ?>
	<script src="<?php echo get_template_directory_uri(); ?>/_/bower_components/requirejs/require.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/_/assets/js/main.min.js"></script>
