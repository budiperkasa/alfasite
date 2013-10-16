<?php
// Template Name: Contact Form
get_header(); ?>

		<div id="main">
		
			<?php while(have_posts()): the_post(); ?>
			
			<div id="post-wrapper">

				<div id="page-header">
					
					<h1><?php the_title(); ?></h1>
						
				</div>
			
				<div id="post">
					
					<div class="post-content">
					
						<?php the_content(); ?>
						
						<form action='' method='post' class='postForm' id='contactForm'>
							<p class='email_sent'><?php _e('Email sent!', 'pyre'); ?></p>
							
							<div>
								<label for='pyre_name'><?php _e('Name', 'pyre'); ?> <span><?php _e('(required)', 'pyre'); ?></span></label>
								<input class='text' type='text' name='pyre_name' id='pyre_name' value='' />
								<p class='error_msg'><?php _e('Please enter a name.', 'pyre'); ?></p>
							</div>
							<div>
								<label for='pyre_email'><?php _e('Email', 'pyre'); ?> <span><?php _e('(required)', 'pyre'); ?></span></label>
								<input class='text' type='text' name='pyre_email' id='pyre_email' value='' />
								<p class='error_msg'><?php _e('Please enter a valid email address.', 'pyre'); ?></p>
							</div>
							<div>
								<label for='pyre_message'><?php _e('Your Message', 'pyre'); ?> <span><?php _e('(required)', 'pyre'); ?></span></label>
								<textarea name='pyre_message' id='pyre_message'></textarea>
								<p class='error_msg'><?php _e('Please enter a message.', 'pyre'); ?></p>
							</div>
							<input type='submit' name='submit' class='comment-submit' value='<?php _e('Send Email', 'pyre'); ?>' />
						</form>
				
						<?php wp_link_pages(); ?>
					
					</div>
				
				</div>
			
			</div>
			
			<?php endwhile; ?>
			
		</div>
		
<?php get_sidebar(); ?>
<?php get_footer(); ?>