<?php
// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="no-comments"><?php _e('This post is password protected. Enter the password to view comments.', 'pyre'); ?></p>
	<?php
		return;
	}
?>
	
<!-- You can start editing here. -->

<?php if ( have_comments() ) : ?>

	<h5><?php comments_number(__('No Comments', 'pyre'), __('One Comment', 'pyre'), __('% Comments', 'pyre'));?></h5>
	
	<ol class="commentlist">
		<?php wp_list_comments('callback=boulevard_comment'); ?>
	</ol>
	
	<div class="comments-navigation">
	    <div class="alignleft"><?php previous_comments_link(); ?></div>
	    <div class="alignright"><?php next_comments_link(); ?></div>
	</div>

<?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="no-comments"><?php _e('Comments are closed.', 'pyre'); ?></p>

	<?php endif; ?>
<?php endif; ?>

<?php if ( comments_open() ) : ?>

<div id="respond">

	<h5><?php comment_form_title(__('Leave A Response', 'pyre'), __('Leave A Response', 'pyre')); ?></h5>

	<p class="cancel-comment-reply"><?php cancel_comment_reply_link(); ?></p>

	<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
	<p><?php _e('You must be', 'pyre'); ?> <a href="<?php echo wp_login_url( get_permalink() ); ?>"><?php _e('logged in', 'pyre'); ?></a> <?php _e('to post a comment', 'pyre'); ?>.</p>
	<?php else : ?>

	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post">

		<?php if ( is_user_logged_in() ) : ?>

		<p><?php _e('Logged in as', 'pyre'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account"><?php _e('Logout', 'pyre'); ?> &raquo;</a></p>

		<div id="comment-textarea-admin">
			
			<label for="comment"><?php _e('Comment', 'pyre'); ?></label>
			<textarea name="comment" id="comment" cols="39" rows="4" tabindex="4" class="textarea-comment"></textarea>
		
		</div>
		
		<div id="comment-submit-admin">
		
			<p><input name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Post Comment', 'pyre'); ?>" class="comment-submit" /></p>
			<?php comment_id_fields(); ?>
			<?php do_action('comment_form', $post->ID); ?>
			
		</div>
		
		<?php else : ?>

		<div id="comment-input">
		
			<label for="author"><?php _e('Name', 'pyre'); ?> <span class="req"><?php if ($req) echo __("(required)", 'pyre'); ?></span></label>
			<input type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> class="input-name" />

			<label for="email"><?php _e('Email', 'pyre'); ?> <span class="req"><?php if ($req) echo __("(required)", 'pyre'); ?></span></label>
			<input type="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> class="input-email"  />
		
			<label for="url"><?php _e('Website', 'pyre'); ?></label>
			<input type="text" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" size="22" tabindex="3" class="input-website" />
			
		</div>
		
		<div id="comment-textarea">
			
			<label for="comment"><?php _e('Comment', 'pyre'); ?></label>
			<textarea name="comment" id="comment" cols="39" rows="4" tabindex="4" class="textarea-comment"></textarea>
		
		</div>
		
		<div id="comment-submit">
		
			<p><input name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Post Comment', 'pyre'); ?>" class="comment-submit" /></p>
			<?php comment_id_fields(); ?>
			<?php do_action('comment_form', $post->ID); ?>
			
		</div>

		<?php endif; ?>

	</form>

	<?php endif; // If registration required and not logged in ?>
	
</div>

<?php endif; // if you delete this the sky will fall on your head ?>