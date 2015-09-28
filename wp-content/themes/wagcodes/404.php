<?php get_template_part('templates/page', 'header'); ?>

<div>
  <?php _e('Sorry, but the page you were trying to view does not exist.', 'SM'); ?>
</div>

<p><?php _e('It looks like this was the result of either:', 'SM'); ?></p>

<ul>
	<li><?php _e('a mistyped address', 'SM'); ?></li>
	<li><?php _e('an out-of-date link', 'SM'); ?></li>
</ul>

<?php get_search_form(); ?>
