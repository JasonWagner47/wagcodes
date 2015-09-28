<form role="search" method="get" action="<?php echo home_url('/'); ?>">
	<label for="search"><?php _e('Search for:', 'SM'); ?></label>
	<input id="search" type="search" value="<?php if (is_search()) { echo get_search_query(); } ?>" name="s" placeholder="<?php _e('Search', 'SM'); ?> <?php bloginfo('name'); ?>">
	<button type="submit"><?php _e('Search', 'SM'); ?></button>
</form>
