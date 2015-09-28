## Wordpress Starter Theme

### Requirements

*	Advanced Custom Fields - <http://www.advancedcustomfields.com/>
*	Grunt Starter Submodule - <https://github.com/nailliK/project-starter/>

### Extras

This theme comes with ACF Repeater and ACF Options Page. To use these plugins, move them from the Extras folder to wp-content/plugins.

### Configuration

Please review lib/config.php file for theme customizations.

### Purchased Plugins

*	ACF Repeater : QJF7-L4IX-UCNP-RF2W
*	ACF Options Page : OPN8-FA4J-Y2LW-81LS
*	Gravity Forms : 1d37dc72e938546d58196ceaddd5ae0a

### Pull the global project starter Submodule

In the terminal, CD into the theme directory and type:
	git submodule init;
	git submodule update;
	git submodule foreach git pull origin master;


### Wordpress Tips & Helpful Modifications

#### Root Relative URLS
Add the following lines to your wp-config.php file:

	$isSecure = false;
	if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
	    $isSecure = true;
	}
	elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
	    $isSecure = true;
	}
	$REQUEST_PROTOCOL = $isSecure ? 'https' : 'http';

	define('WP_HOME', $REQUEST_PROTOCOL . "://" . $_SERVER['HTTP_HOST']);
	define('WP_SITEURL', $REQUEST_PROTOCOL . "://" . $_SERVER['HTTP_HOST']);

#### Environmental Database Settings
Modify the code below with your database settings use it as a replacement for the standard wp-config database settings:

	$host = $_SERVER['HTTP_HOST'];

	// local settings
	$db_name = 'db_name';
	$db_user = 'user';
	$db_pass = 'pass';

	// staging
	if (strpos($host,'stage') > -1) {
		$db_name = 'db_name';
		$db_user = 'user';
		$db_pass = 'pass';
	}

	// production
	if (strpos($host,'.com') > -1) {
		$db_name = 'db_name';
		$db_user = 'user';
		$db_pass = 'pass';
	}

	define('DB_NAME', $db_name);
	define('DB_USER', $db_user);
	define('DB_PASSWORD', $db_pass);
