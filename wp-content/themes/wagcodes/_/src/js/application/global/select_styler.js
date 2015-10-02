define([], function () {
	/*
		this module assumes your selects are inside of a wrapper along with a label and span:

		WRAPPER
		- LABEL
		- SELECT
		- SPAN
	*/

	"use strict";
	var SelectStyler = function () {
		var
		on_change = function(e) {
			var option_text = $('option[value="' + $(e.target).val() + '"]', e.target).text();
			$(e.target).parent().find('span').text(option_text);
		},
		init_listeners = function() {
			$('select').on('change', on_change);
		};
		this.init = function () {
			init_listeners();
		};
	};
	return SelectStyler;
});
