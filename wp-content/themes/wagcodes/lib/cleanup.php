<?php
function SM_head_cleanup() {
	remove_action('wp_head', 'feed_links', 2);
	remove_action('wp_head', 'feed_links_extra', 3);
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

	global $wp_widget_factory;
	remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));

	if (!class_exists('WPSEO_Frontend')) {
		remove_action('wp_head', 'rel_canonical');
		add_action('wp_head', 'SM_rel_canonical');
	}
}

function SM_rel_canonical() {
	global $wp_the_query;

	if (!is_singular()) {
		return;
	}

	if (!$id = $wp_the_query->get_queried_object_id()) {
		return;
	}

	$link = get_permalink($id);
	echo "\t<link rel=\"canonical\" href=\"$link\">\n";
}
add_action('init', 'SM_head_cleanup');

add_filter('the_generator', '__return_false');

function SM_language_attributes() {
	$attributes = array();
	$output = '';

	if (is_rtl()) {
		$attributes[] = 'dir="rtl"';
	}

	$lang = get_bloginfo('language');

	if ($lang) {
		$attributes[] = "lang=\"$lang\"";
	}

	$output = implode(' ', $attributes);
	$output = apply_filters('SM_language_attributes', $output);

	return $output;
}
add_filter('language_attributes', 'SM_language_attributes');

function SM_wp_title($title) {
	if (is_feed()) {
		return $title;
	}

	$title .= get_bloginfo('name');

	return $title;
}
add_filter('wp_title', 'SM_wp_title', 10);

function SM_clean_style_tag($input) {
	preg_match_all("!<link rel='stylesheet'\s?(id='[^']+')?\s+href='(.*)' type='text/css' media='(.*)' />!", $input, $matches);
	// Only display media if it is meaningful
	$media = $matches[3][0] !== '' && $matches[3][0] !== 'all' ? ' media="' . $matches[3][0] . '"' : '';
	return '<link rel="stylesheet" href="' . $matches[2][0] . '"' . $media . '>' . "\n";
}
add_filter('style_loader_tag', 'SM_clean_style_tag');

function SM_body_class($classes) {
	// Add post/page slug
	if (is_single() || is_page() && !is_front_page()) {
		$classes[] = basename(get_permalink());
	}

	// Remove unnecessary classes
	$home_id_class = 'page-id-' . get_option('page_on_front');
	$remove_classes = array(
		'page-template-default',
		$home_id_class
	);
	$classes = array_diff($classes, $remove_classes);

	return $classes;
}
add_filter('body_class', 'SM_body_class');

function SM_embed_wrap($cache, $url, $attr = '', $post_ID = '') {
	return '<div class="entry-content-asset">' . $cache . '</div>';
}
add_filter('embed_oembed_html', 'SM_embed_wrap', 10, 4);

function SM_caption($output, $attr, $content) {
	if (is_feed()) {
		return $output;
	}

	$defaults = array(
		'id'			=> '',
		'align'	 => 'alignnone',
		'width'	 => '',
		'caption' => ''
	);

	$attr = shortcode_atts($defaults, $attr);

	// If the width is less than 1 or there is no caption, return the content wrapped between the [caption] tags
	if ($attr['width'] < 1 || empty($attr['caption'])) {
		return $content;
	}

	// Set up the attributes for the caption <figure>
	$attributes	= (!empty($attr['id']) ? ' id="' . esc_attr($attr['id']) . '"' : '' );
	$attributes .= ' class="thumbnail wp-caption ' . esc_attr($attr['align']) . '"';
	$attributes .= ' style="width: ' . (esc_attr($attr['width']) + 10) . 'px"';

	$output	= '<figure' . $attributes .'>';
	$output .= do_shortcode($content);
	$output .= '<figcaption class="caption wp-caption-text">' . $attr['caption'] . '</figcaption>';
	$output .= '</figure>';

	return $output;
}
add_filter('img_caption_shortcode', 'SM_caption', 10, 3);

function SM_remove_dashboard_widgets() {
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
	remove_meta_box('dashboard_plugins', 'dashboard', 'normal');
	remove_meta_box('dashboard_primary', 'dashboard', 'normal');
	remove_meta_box('dashboard_secondary', 'dashboard', 'normal');
}
add_action('admin_init', 'SM_remove_dashboard_widgets');

function SM_excerpt_length($length) {
	return POST_EXCERPT_LENGTH;
}

function SM_excerpt_more($more) {
	return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'SM') . '</a>';
}
add_filter('excerpt_length', 'SM_excerpt_length');
add_filter('excerpt_more', 'SM_excerpt_more');

function SM_remove_self_closing_tags($input) {
	return str_replace(' />', '>', $input);
}
add_filter('get_avatar',					'SM_remove_self_closing_tags'); // <img />
add_filter('comment_id_fields',	 'SM_remove_self_closing_tags'); // <input />
add_filter('post_thumbnail_html', 'SM_remove_self_closing_tags'); // <img />

function SM_remove_default_description($bloginfo) {
	$default_tagline = 'Just another WordPress site';
	return ($bloginfo === $default_tagline) ? '' : $bloginfo;
}
add_filter('get_bloginfo_rss', 'SM_remove_default_description');

function SM_nice_search_redirect() {
	global $wp_rewrite;
	if (!isset($wp_rewrite) || !is_object($wp_rewrite) || !$wp_rewrite->using_permalinks()) {
		return;
	}

	$search_base = $wp_rewrite->search_base;
	if (is_search() && !is_admin() && strpos($_SERVER['REQUEST_URI'], "/{$search_base}/") === false) {
		wp_redirect(home_url("/{$search_base}/" . urlencode(get_query_var('s'))));
		exit();
	}
}
if (current_theme_supports('nice-search')) {
	add_action('template_redirect', 'SM_nice_search_redirect');
}

function SM_request_filter($query_vars) {
	if (isset($_GET['s']) && empty($_GET['s']) && !is_admin()) {
		$query_vars['s'] = ' ';
	}

	return $query_vars;
}
add_filter('request', 'SM_request_filter');

function SM_get_search_form($form) {
	$form = '';
	locate_template('/templates/searchform.php', true, false);
	return $form;
}
add_filter('get_search_form', 'SM_get_search_form');