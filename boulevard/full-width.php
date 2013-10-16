<?php
// Template Name: Full Width
get_header(); ?>

		<div id="main" style="width: 100%;">
		
			<?php while(have_posts()): the_post(); ?>
			
			<div id="post-wrapper">

				<div id="page-header">
					
					<h1><?php the_title(); ?></h1>
						
				</div>
			
				<div id="post">
					
					<div class="post-content">
					
						<?php the_content(); ?>
						<?php wp_link_pages(); ?>
					
					</div>
				
				</div>
				
				<?php if(
					get_option('pyre_twitter') == 'On' ||
					get_option('pyre_facebook') == 'On' ||
					get_option('pyre_digg') == 'On' ||
					get_option('pyre_stumbleupon') == 'On' ||
					get_option('pyre_reddit') == 'On' ||
					get_option('pyre_tumblr') == 'On' ||
					get_option('pyre_email') == 'On' ||
					get_option('pyre_google') == 'On'
				): ?>
				<div class='post-share'>
					<?php if(get_option('pyre_twitter') == 'On'): ?>
					<div class='twitter-share share-widget'>
						<a href="http://twitter.com/share" class="twitter-share-button" data-text='<?php the_title(); ?>' data-count="vertical">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
					</div>
					<?php endif; ?>
					<?php if(get_option('pyre_facebook') == 'On'): ?>
					<div class='facebook-share share-widget'>
						<iframe src="//www.facebook.com/plugins/like.php?href=<?php echo urlencode(get_permalink($post->ID)); ?>&amp;send=false&amp;layout=box_count&amp;width=46&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font=arial&amp;height=65" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:46px; height:65px;" allowTransparency="true"></iframe>
					</div>
					<?php endif; ?>
					<?php if(get_option('pyre_digg') == 'On'): ?>
					<div class='digg-share share-widget'>
						<script type="text/javascript">
						(function() {
						var s = document.createElement('SCRIPT'), s1 = document.getElementsByTagName('SCRIPT')[0];
						s.type = 'text/javascript';
						s.async = true;
						s.src = 'http://widgets.digg.com/buttons.js';
						s1.parentNode.insertBefore(s, s1);
						})();
						</script>
						<a class="DiggThisButton DiggMedium" href="http://digg.com/submit?url=<?php echo urlencode(get_permalink($post->ID)); ?>&amp;title=<?php echo urlencode(get_the_title()); ?>"></a>
					</div>
					<?php endif; ?>
					<?php if(get_option('pyre_stumbleupon') == 'On'): ?>
					<div class='stumbleupon-share share-widget'>
						<script src="http://www.stumbleupon.com/hostedbadge.php?s=5"></script>
					</div>
					<?php endif; ?>
					<?php if(get_option('pyre_reddit') == 'On'): ?>
					<div class='reddit-share share-widget'>
						<script type="text/javascript" src="http://www.reddit.com/static/button/button2.js"></script>
					</div>
					<?php endif; ?>
					<?php if(get_option('pyre_tumblr') == 'On'): ?>
					<div class='tumblr-share share-widget'>
						<a href="http://www.tumblr.com/share" title="Share on Tumblr" style="display:inline-block; text-indent:-9999px; overflow:hidden; width:62px; height:20px; background:url('http://platform.tumblr.com/v1/share_2.png') top left no-repeat transparent;">Share on Tumblr</a>
					</div>
					<?php endif; ?>
					<?php if(get_option('pyre_email') == 'On'): ?>
					<div class='email-share share-widget'>
						<a href="mailto:?subject=<?php the_title(); ?>&amp;body=<?php the_permalink(); ?>"><img src='<?php bloginfo('template_url'); ?>/images/email-share.png' alt='Email Share' /></a>
					</div>
					<?php endif; ?>
					<?php if(get_option('pyre_google') == 'On'): ?>
					<div class='google-share share-widget'>
						<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
						<g:plusone size="tall"></g:plusone>
					</div>
					<?php endif; ?>
				</div>
				<?php endif; ?>
			
			</div>
			
			<?php endwhile; ?>
			
		</div>
		
<?php get_footer(); ?>