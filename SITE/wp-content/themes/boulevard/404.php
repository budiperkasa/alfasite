<?php
get_header(); ?>

		<div id="main">
			
			<div id="post-wrapper">

				<div id="post-header">
					
					<h1><?php _e('Page Not Found', 'pyre'); ?></h1>
						
				</div>
			
				<div id="post">
					
					<div class="post-content">
					
						<p><?php _e('Sorry, the page you are looking for could not be found. Try using the search box below!', 'pyre'); ?></p>
						<?php get_search_form(); ?>
					
					</div>
				
				</div>
			
			</div>
			
		</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>