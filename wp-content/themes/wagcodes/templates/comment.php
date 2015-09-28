<?php echo get_avatar($comment, $size = '64'); ?>
<h4><?php echo get_comment_author_link(); ?></h4>
<time datetime="<?php echo comment_date('c'); ?>">
	<a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)); ?>">
		<?php printf(__('%1$s', 'SM'), get_comment_date(),  get_comment_time()); ?>
	</a>
</time>
<?php edit_comment_link(__('(Edit)', 'SM'), '', ''); ?>

<?php if ($comment->comment_approved == '0') : ?>
	<div>
		<?php _e('Your comment is awaiting moderation.', 'SM'); ?>
	</div>
<?php endif; ?>

<?php comment_text(); ?>

<?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
