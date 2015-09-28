// define common paths
var vendor = 'build/js/vendor/',
	application = 'build/js/application/';

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
		home: application + 'site/index'
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
