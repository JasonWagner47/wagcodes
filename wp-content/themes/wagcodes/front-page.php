

<section id="portfolio">


	<?php if(have_rows('portfolio')): ?>
		<?php while (have_rows('portfolio')) : the_row(); ?>
			<?php 
					$title = get_sub_field('title');
					$description = get_sub_field('description');
					$url = get_sub_field('url');
					$image = get_sub_field('image');
					$languages = get_sub_field('languages');
				?>

			<div class="work">
				
				<?php if($title):?>
					<h2><?php echo $title;?></h2>
				<?php endif;?>

				<img src ="<?php echo $image;?>" alt="<?php echo $title;?>"/>


				<?php if($languages):?>
						<span class="languages"> <?php include get_theme_root() . '/wagcodes/_/build/svg/icon-computer.svg'; ?><?php echo $languages;?></span>
				<?php endif;?>

				<div class="about-wrapper">
					<?php if($description):?>
						<p class="copy"><?php echo $description;?></p>
					<?php endif;?>

					<?php if($url):?>
						<a href="<?php echo $url;?>" class="portfolio-cta">Visit the Site</a>
					<?php endif;?>
				</div>

			</div>
		<?php endwhile; ?>
	<?php endif; ?>


</section>