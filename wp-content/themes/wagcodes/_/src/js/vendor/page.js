/*eslint eqeqeq:0, one-var:0, vars-on-top:0, no-use-before-define:0, curly:0, no-shadow:0, no-ternary:0 */
(function() {
	"use strict";

	var dispatch = true;

	var base = '';

	var running;

	function page(path, fn) {
		// <callback>
		if ('function' == typeof path) {
			return page('*', path);
		}

		// route <path> to <callback ...>
		if ('function' == typeof fn) {
			var route = new Route(path);
			for (var i = 1; i < arguments.length; ++i) {
				page.callbacks.push(route.middleware(arguments[i]));
			}
			// show <path> with [state]
		} else if ('string' == typeof path) {
			page.show(path, fn);
			// start [options]
		} else {
			page.start(path);
		}
	}


	page.callbacks = [];

	page.base = function(path) {
		if (0 == arguments.length) return base;
		base = path;
	};

	page.start = function(options) {
		options = options || {};
		if (running) return;
		running = true;
		if (false === options.dispatch) dispatch = false;
		if (false !== options.popstate) window.addEventListener('popstate', onpopstate, false);
		if (false !== options.click) window.addEventListener('click', onclick, false);
		if (!dispatch) return;
		var url = location.pathname + location.search + location.hash;
		page.replace(url, null, true, dispatch);
	};

	page.stop = function() {
		running = false;
		removeEventListener('click', onclick, false);
		removeEventListener('popstate', onpopstate, false);
	};

	page.show = function(path, state, dispatch) {
		var ctx = new Context(path, state);
		if (false !== dispatch) page.dispatch(ctx);
		if (!ctx.unhandled) ctx.pushState();
		return ctx;
	};

	page.replace = function(path, state, init, dispatch) {
		var ctx = new Context(path, state);
		ctx.init = init;
		if (null == dispatch) dispatch = true;
		if (dispatch) page.dispatch(ctx);
		ctx.save();
		return ctx;
	};

	page.dispatch = function(ctx) {
		var i = 0;

		function next() {
			var fn = page.callbacks[i++];
			if (!fn) return unhandled(ctx);
			fn(ctx, next);
		}

		next();
	};

	function unhandled(ctx) {
		var current = window.location.pathname + window.location.search;
		if (current == ctx.canonicalPath) return;
		page.stop();
		ctx.unhandled = true;
		window.location = ctx.canonicalPath;
	}

	function Context(path, state) {
		if ('/' == path[0] && 0 != path.indexOf(base)) path = base + path;
		var i = path.indexOf('?');

		this.canonicalPath = path;
		this.path = path.replace(base, '') || '/';

		this.title = document.title;
		this.state = state || {};
		this.state.path = path;
		this.querystring = ~i ? path.slice(i + 1) : '';
		this.pathname = ~i ? path.slice(0, i) : path;
		this.params = [];

		// fragment
		this.hash = '';
		if (!~this.path.indexOf('#')) return;
		var parts = this.path.split('#');
		this.path = parts[0];
		this.hash = parts[1] || '';
		this.querystring = this.querystring.split('#')[0];
	}

	page.Context = Context;

	Context.prototype.pushState = function() {
		if (history.pushState) {
			history.pushState(this.state, this.title, this.canonicalPath);
		}
	};

	Context.prototype.save = function() {
		if (history.replaceState) {
			history.replaceState(this.state, this.title, this.canonicalPath);
		}
	};

	function Route(path, options) {
		options = options || {};
		this.path = path;
		this.method = 'GET';
		this.regexp = pathtoRegexp(path, this.keys = [], options.sensitive, options.strict);
	}

	page.Route = Route;

	Route.prototype.middleware = function(fn) {
		var self = this;
		return function(ctx, next) {
			if (self.match(ctx.path, ctx.params)) return fn(ctx, next);
			next();
		};
	};

	Route.prototype.match = function(path, params) {
		var keys = this.keys,
			qsIndex = path.indexOf('?'),
			pathname = ~qsIndex ? path.slice(0, qsIndex) : path,
			m = this.regexp.exec(decodeURIComponent(pathname));

		if (!m) return false;

		for (var i = 1, len = m.length; i < len; ++i) {
			var key = keys[i - 1];

			var val = 'string' == typeof m[i] ? decodeURIComponent(m[i]) : m[i];

			if (key) {
				params[key.name] = undefined !== params[key.name] ? params[key.name] : val;
			} else {
				params.push(val);
			}
		}

		return true;
	};

	function pathtoRegexp(path, keys, sensitive, strict) {
		if (path instanceof RegExp) return path;
		if (path instanceof Array) path = '(' + path.join('|') + ')';
		path = path
			.concat(strict ? '' : '/?')
			.replace(/\/\(/g, '(?:/')
			.replace(/(\/)?(\.)?:(\w+)(?:(\(.*?\)))?(\?)?/g, function(_, slash, format, key, capture, optional) {
				keys.push({
					name: key,
					optional: !! optional
				});
				slash = slash || '';
				return '' + (optional ? '' : slash) + '(?:' + (optional ? slash : '') + (format || '') + (capture || (format && '([^/.]+?)' || '([^/]+?)')) + ')' + (optional || '');
			})
			.replace(/([\/.])/g, '\\$1')
			.replace(/\*/g, '(.*)');
		return new RegExp('^' + path + '$', sensitive ? '' : 'i');
	}

	function onpopstate(e) {
		if (e.state) {
			var path = e.state.path;
			page.replace(path, e.state);
		}
	}

	function onclick(e) {
		if (1 != which(e)) return;
		if (e.metaKey || e.ctrlKey || e.shiftKey) return;
		if (e.defaultPrevented) return;

		// ensure link
		var el = e.target;
		while (el && 'A' != el.nodeName) el = el.parentNode;
		if (!el || 'A' != el.nodeName) return;

		// ensure non-hash for the same path
		var link = el.getAttribute('href');
		if (el.pathname == location.pathname && (el.hash || '#' == link)) return;

		// Check for mailto: in the href
		if (link.indexOf("mailto:") > -1) return;

		// check target
		if (el.target) return;

		// x-origin
		if (!sameOrigin(el.href)) return;

		// rebuild path
		var path = el.pathname + el.search + (el.hash || '');

		// same page
		var orig = path + el.hash;

		path = path.replace(base, '');
		if (base && orig == path) return;

		e.preventDefault();
		page.show(orig);
	}
	function which(e) {
		e = e || window.event;
		return null == e.which ? e.button : e.which;
	}

	function sameOrigin(href) {
		var origin = location.protocol + '//' + location.hostname;
		if (location.port) origin += ':' + location.port;
		return 0 == href.indexOf(origin);
	}

	if ('undefined' == typeof module) {
		window.page = page;
	} else {
		module.exports = page;
	}

})();
