define([] , function () {
	var Portfolio = function(){
		var app = angular.module('myPortfolio', []);

		app.controller('tabs', function($scope) {
				$scope.greeting = 'Welcome!';
		});

		angular.bootstrap(document, ['myPortfolio']);

		auto_height_factiod = function(e){
			$('.more').css({
				height: 'auto'
			});

			var h = 0;

			$('.more').each(function(){
				if( $(this).outerHeight(true) > h ){
					h = $(this).outerHeight(true);
				}
			});

			$('.more').css({
				height : h + 'px'
			});

		},

		current_activity = function(e){
			e.stopPropagation();
			var icon =$(e.target).closest('.icon'),
				_this = this;
				term = $(icon).attr('data-term');
			
			$('#bio span').removeClass('activity-highlight');
			$('.icon').removeClass('icon-highlight');
			$('.more').hide();
			$(icon).addClass('icon-highlight');
			$('#bio span[data-term="' + term + '"]').addClass('activity-highlight');
			$('.more[data-term="' + term + '"]').fadeIn();

		},

		hide_activity = function(e){
			$('.more').hide();
			$('#bio span').removeClass('activity-highlight');
			$('.icon').removeClass('icon-highlight');
		},

		scroll_to_portfolio = function(e){
			e.preventDefault();
			$("html, body").animate({ scrollTop: $('#portfolio').offset().top }, 1000);
		},

		fixed_nav = function(){
			var top = $('#portfolio').offset().top;
			var top_adj = top - 60;
			var st = $(window).scrollTop();

			if(st > top_adj){
				$('#fixed-nav').addClass('fixed-nav-bg');
			} else {
				$('#fixed-nav').removeClass('fixed-nav-bg');
			}

		},

		init_objects = function() {
			$('body').addClass('visible');
			auto_height_factiod();
		},

		init_listeners = function() {
			$(window).on('scroll', function(e) {
				fixed_nav(e);
			});
		};

		this.init = function () {
			init_objects();
			init_listeners();
		};
	};

	return Portfolio;
});
