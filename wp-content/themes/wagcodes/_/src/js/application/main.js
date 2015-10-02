// define common paths
var wp = '/wp-content/themes/wagcodes',
	vendor = wp + '/_/build/js/vendor/',
	application = wp + '/_/build/js/application/';

require.config({
	paths: {
		// dependencies
		backbone: vendor + 'backbone',
		jquery: vendor + 'jquery',
		page: vendor + 'page',
		underscore: vendor + 'underscore',

		// globals
		select_styler: application + 'global/select_styler',

		// router
		router: application + 'router',

		// application
		home: application + 'site/home/home'
	},
	shim: {
		'backbone': {
			deps: ['underscore', 'jquery'],
			exports: 'Backbone'
		},
		'jquery': {
			exports: '$'
		},
		'underscore': {
			exports: '_'
		}
	}
});

require(['jquery', 'backbone', 'underscore', 'router'], function($, Backbone, _, Router) {
	"use strict";

	window.Backbone = Backbone;
	window.$ = $;
	window._ = _;
	window.router = new Router();
	window.router.init();
});
