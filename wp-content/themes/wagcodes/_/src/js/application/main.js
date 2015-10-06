// define common paths
var wp = '/wp-content/themes/wagcodes',
	vendor = wp + '/_/build/js/vendor/',
	application = wp + '/_/build/js/application/';

require.config({
	paths: {
		// dependencies
		jquery: vendor + 'jquery',
		page: vendor + 'page',
		angular: vendor + 'angular',

		// globals
		select_styler: application + 'global/select_styler',

		// router
		router: application + 'router',

		// application
		home: application + 'site/home/home'
	},

	shim: {
		'jquery': {
			exports: '$'
		}
	}
});

require(['jquery', 'angular', 'router'], function($, Angular, Router) {
	"use strict";

	window.$ = $;
	window.router = new Router();
	window.router.init();
});
