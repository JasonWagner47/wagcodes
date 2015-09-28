	<header role="banner">
		<h1>
			<a href="<?php echo home_url('/') ?>"><?php bloginfo('name'); ?></a>
		</h1>
	
		<label class="menu_toggle" for="menu_toggle">☰</label>
		<input type="checkbox" id="menu_toggle" />
	
		<nav role="navigation">
			<?php
			if (has_nav_menu('primary_navigation')) :
				$menu = wp_nav_menu(array(
					'theme_location'	=> 'primary_navigation',
					'container'			=> FALSE,
					'container_id'		=> FALSE,
					'menu_class'		=> '',
					'menu_id'			=> FALSE,
					'items_wrap'		=> '%3$s',
					'echo'				=> FALSE
				));
				echo str_replace( array('li', 'ul'), array('div', 'div'), $menu );
			endif;
			?>
		</nav>
	</header>