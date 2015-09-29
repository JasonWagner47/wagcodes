<?php
function SM_scripts() {
	// load Stylesheet
	wp_enqueue_style('SM_main', '/wp-content/themes/wagcodes/_/build/css/main.css', false); 

	// deregester WP jQuery
	wp_deregister_script('jquery');

	// register jQuery
	// For IE8 support, change the version/url to 1.11.1
	wp_register_script('jquery', ("//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"), false, '2.1.1', true);
	wp_enqueue_script('jquery');

	// for IE8 support, uncomment the following two lines
	// wp_register_script('jquery-migrate', ("//cdnjs.cloudflare.com/ajax/libs/jquery-migrate/1.2.1/jquery-migrate.min.js"), false, '1.2.1', true);
	// wp_enqueue_script('jquery-migrate');

	if (is_single() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}

}
add_action('wp_enqueue_scripts', 'SM_scripts', -1);

function SM_base_url() { ?>
	<script>
		var theme_url = '<?php echo get_template_directory_uri(); ?>/';
	</script>
<?php }

add_action('wp_footer', 'SM_base_url', 0);


function SM_google_analytics() { ?>
<script>
    (function(b, o, i, l, e, r) {
    	b.GoogleAnalyticsObject = l;
    	b[l] || (b[l] =
    		function() {
    			(b[l].q = b[l].q || []).push(arguments)
    		});
    	b[l].l = +new Date;
    	e = o.createElement(i);
    	r = o.getElementsByTagName(i)[0];
    	e.src = '//www.google-analytics.com/analytics.js';
    	r.parentNode.insertBefore(e, r)
    }(window, document, 'script', 'ga'));
    ga('create', '<?php echo GOOGLE_ANALYTICS_ID; ?>', 'auto');
    ga('send', 'pageview');
</script>

<?php }
if (GOOGLE_ANALYTICS_ID) {
  add_action('wp_footer', 'SM_google_analytics', 100);
}