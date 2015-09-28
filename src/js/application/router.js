/*eslint no-shadow:0 */
/*global define page*/
define(['page'], function () {
	"use strict";

	var Router = function () {
		// ADD ROUTE FUNCTIONS HERE
		var home = function() {
			require(['home'], function(Home) {
				this.current_view = new Home();
			});
		},
		search = function(n) {
			if (n) {
				// console.log(n.params.query);
			}
		},

		globals = function() {
			// load global views here
			require(['select_styler'], function(SelectStyler) {
				var select_styler = new SelectStyler();
				select_styler.init();
			});
		};
		this.current_view = null;
		this.init = function() {
			// global
			globals();

			// add your routes here
			page('', home);
			page('/', home);
			page('/search/:query', search);
			page.start({
				click: false,
				popstate: false
			});
		};
	};
	return Router;
});
