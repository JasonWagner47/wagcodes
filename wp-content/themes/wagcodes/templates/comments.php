<?php
if (post_password_required()) {
	return;
}
if (have_comments()) : ?>
	<section id="comments">
		<h3><?php printf(_n('One Response to &ldquo;%2$s&rdquo;', '%1$s Responses to &ldquo;%2$s&rdquo;', get_comments_number(), 'SM'), number_format_i18n(get_comments_number()), get_the_title()); ?></h3>

		<ol>
			<?php wp_list_comments(array('walker' => new SM_Walker_Comment)); ?>
		</ol>

		<?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
			<nav>
				<?php if (get_previous_comments_link()) : ?>
					<div class="previous">
						<?php previous_comments_link(__('Older comments', 'SM')); ?>
					</div>
				<?php endif; ?>

				<?php if (get_next_comments_link()) : ?>
					<div class="next">
						<?php next_comments_link(__('Newer comments', 'SM')); ?>
					</div>
				<?php endif; ?>
			</nav>
		<?php endif; ?>

		<?php if (!comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments')) : ?>
			<div>
				<p>
					<?php _e('Comments are closed.', 'SM'); ?>
				</p>
			</div>
		<?php endif; ?>
	</section>
<?php endif; ?>

<?php if (!have_comments() && !comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments')) : ?>
	<section id="comments">
		<p>
			<?php _e('Comments are closed.', 'SM'); ?>
		</p>
	</section><!-- /#comments -->
<?php endif; ?>

<?php if (comments_open()) : ?>
	<section id="respond">
		<h3><?php comment_form_title(__('Leave a Reply', 'SM'), __('Leave a Reply to %s', 'SM')); ?></h3>
		<p><?php cancel_comment_reply_link(); ?></p>

		<?php if (get_option('comment_registration') && !is_user_logged_in()) : ?>
			<p><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.', 'SM'), wp_login_url(get_permalink())); ?></p>
		<?php else : ?>
			<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
				<?php if (is_user_logged_in()) : ?>
					<p>
						<?php printf(__('Logged in as <a href="%s/wp-admin/profile.php">%s</a>.', 'SM'), get_option('siteurl'), $user_identity); ?>
						<a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php __('Log out of this account', 'SM'); ?>"><?php _e('Log out &raquo;', 'SM'); ?></a>
					</p>
				<?php else : ?>
					<p>
						<label for="author"><?php _e('Name', 'SM'); if ($req) _e(' (required)', 'SM'); ?></label>
						<input type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" size="22" <?php if ($req) echo 'aria-required="true"'; ?>>
					</p>

					<p>
						<label for="email"><?php _e('Email (will not be published)', 'SM'); if ($req) _e(' (required)', 'SM'); ?></label>
						<input type="email" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="22" <?php if ($req) echo 'aria-required="true"'; ?>>
					</p>

					<p>
						<label for="url"><?php _e('Website', 'SM'); ?></label>
						<input type="url" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" size="22">
					</p>
				<?php endif; ?>

				<p>
					<label for="comment"><?php _e('Comment', 'SM'); ?></label>
					<textarea name="comment" id="comment" rows="5" aria-required="true"></textarea>
				</p>

				<p>
					<button name="submit" type="submit" id="submit" value="submit">
						<?php _e('Submit Comment', 'SM'); ?>
					</button>
				</p>

				<?php comment_id_fields(); ?>

				<?php do_action('comment_form', $post->ID); ?>
			</form>
		<?php endif; ?>
	</section>
<?php endif; ?>
