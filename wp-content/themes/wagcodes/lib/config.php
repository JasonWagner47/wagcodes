<?php
add_theme_support('root-relative-urls');    // Enable relative URLs
add_theme_support('nice-search');           // Enable /?s= to /search/ redirect

define('GOOGLE_ANALYTICS_ID', ''); // UA-XXXXX-Y (Note: Universal Analytics only, not Classic Analytics)
define('POST_EXCERPT_LENGTH', 40); // Length in words for excerpt_length filter (http://codex.wordpress.org/Plugin_API/Filter_Reference/excerpt_length)

function SM_display_sidebar() {
	$sidebar_config = new SM_Sidebar(
		array(
			'is_404',
			'is_front_page'
		),

		array( // add pages that don't need sidebar here.
			'template-custom.php'
		)
	);

	return apply_filters('SM_display_sidebar', $sidebar_config->display);
}