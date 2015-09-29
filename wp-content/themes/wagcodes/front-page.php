

<section id="portfolio">
	<h1>Portfolio</h1>

	<?php if(have_rows('portfolio')): ?>
		<?php while (have_rows('portfolio')) : the_row(); ?>
			<div>
				<?php 
					$title = get_sub_field('title');
					$description = get_sub_field('description');
					$url = get_sub_field('url');
					$image = get_sub_field('image');
				?>
				<?php if($title):?>
					<h2><?php echo $title;?></h2>
				<?php endif;?>

				<?php if($description):?>
					<p><?php echo $description;?></p>
				<?php endif;?>

				<?php if($image):?>
					<img src="<?php echo $image;?>" alt="<?php echo $title;?>"/>
				<?php endif;?>

				<?php if($url):?>
					<a href="<?php echo $url;?>">Visit the Site</a>
				<?php endif;?>

			</div>
		<?php endwhile; ?>
	<?php endif; ?>


</section>