<?php
function SM_setup() {
	load_theme_textdomain('SM', get_template_directory() . '/lang');
	
	add_theme_support('post-thumbnails');
	add_theme_support('menus');
	add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'));
	
	register_nav_menus(array(
		'primary_navigation' => __('Primary Navigation', 'SM'),
	));

	add_editor_style('/assets/css/editor-style.css');
}
add_action('after_setup_theme', 'SM_setup');