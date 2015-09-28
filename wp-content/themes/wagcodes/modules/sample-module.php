<?php /* Sample Custom Field Module */

$variable = get_field('the_most_important_field');
if ($variable) : ?>
	<section class="wrapper">
	
	<?php // Code goes here ?>
	
	</section><!--/.wrapper-->
<?php endif; ?>