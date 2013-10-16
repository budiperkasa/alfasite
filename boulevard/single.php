<?php get_header(); ?>

		<div id="main">
		
			<?php while(have_posts()): the_post(); ?>
		
			<?php if(get_option('pyre_posts_navigation') == 'On'): ?>
			<div class="post-navigation">
				<div class="alignleft"><?php previous_post_link('%link', '&larr; ' . __('Previous Post', 'pyre'), 'no'); ?></div>
				<div class="alignright"><?php next_post_link('%link', __('Next Post', 'pyre') . ' &rarr;', 'no'); ?></div>
				
				<div class="clear"></div>
			</div>
			<?php endif; ?>
				
			<div id="post-wrapper" <?php post_class(); ?>>

				<div id="post-header">
					
					<h1><?php the_title(); ?></h1>
					
					<span class="post-comment-box"><?php comments_popup_link('0', '1', '%'); ?></span>
						
					<div class="post-meta">
						<span class="author"><?php the_author_posts_link() ?></span>
						<span class="date"><?php the_date('F d, Y'); ?></span>
						<?php if(get_option('pyre_categories') == 'On'): ?> 
						<span class="category"><?php the_category(', '); ?></span>
						<?php endif; ?>
					</div>
						
				</div>
			
				<div id="post">
					
					<?php if(has_post_thumbnail() && get_option('pyre_posts_featured') == 'On'): ?>
					<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'featured-image'); ?>
					<img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" class="featured-image" width="600" />
					<?php endif; ?>
					
					<div class="post-content">
						
						<?php if(
						(
							get_post_meta($post->ID, 'pyre_overall_score', true) ||
							(get_post_meta($post->ID, 'pyre_critera_1', true) && get_post_meta($post->ID, 'pyre_critera_1_score', true)) ||
							(get_post_meta($post->ID, 'pyre_critera_2', true) && get_post_meta($post->ID, 'pyre_critera_2_score', true)) ||
							(get_post_meta($post->ID, 'pyre_critera_3', true) && get_post_meta($post->ID, 'pyre_critera_3_score', true)) ||
							(get_post_meta($post->ID, 'pyre_critera_4', true) && get_post_meta($post->ID, 'pyre_critera_4_score', true)) ||
							(get_post_meta($post->ID, 'pyre_critera_5', true) && get_post_meta($post->ID, 'pyre_critera_5_score', true))
						)
						): ?>
						<div class="post-review">
							<?php if(get_post_meta($post->ID, 'pyre_overall_score', true)): ?>
							<div class="overall-score"><img src="<?php bloginfo('template_directory'); ?>/images/stars/big_<?php echo get_post_meta($post->ID, 'pyre_overall_score', true); ?>.png" alt="" /></div>
							<?php endif; ?>
							<ul>
								<?php if(get_post_meta($post->ID, 'pyre_critera_1', true)): ?>
								<li><?php echo get_post_meta($post->ID, 'pyre_critera_1', true); ?> <span class="score"><img src="<?php bloginfo('template_directory'); ?>/images/stars/<?php echo get_post_meta($post->ID, 'pyre_critera_1_score', true); ?>.png" alt="" /></span></li>
								<?php endif; ?>
								<?php if(get_post_meta($post->ID, 'pyre_critera_2', true)): ?>
								<li><?php echo get_post_meta($post->ID, 'pyre_critera_2', true); ?> <span class="score"><img src="<?php bloginfo('template_directory'); ?>/images/stars/<?php echo get_post_meta($post->ID, 'pyre_critera_2_score', true); ?>.png" alt="" /></span></li>
								<?php endif; ?>
								<?php if(get_post_meta($post->ID, 'pyre_critera_3', true)): ?>
								<li><?php echo get_post_meta($post->ID, 'pyre_critera_3', true); ?> <span class="score"><img src="<?php bloginfo('template_directory'); ?>/images/stars/<?php echo get_post_meta($post->ID, 'pyre_critera_3_score', true); ?>.png" alt="" /></span></li>
								<?php endif; ?>
								<?php if(get_post_meta($post->ID, 'pyre_critera_4', true)): ?>
								<li><?php echo get_post_meta($post->ID, 'pyre_critera_4', true); ?> <span class="score"><img src="<?php bloginfo('template_directory'); ?>/images/stars/<?php echo get_post_meta($post->ID, 'pyre_critera_4_score', true); ?>.png" alt="" /></span></li>
								<?php endif; ?>
								<?php if(get_post_meta($post->ID, 'pyre_critera_5', true)): ?>
								<li><?php echo get_post_meta($post->ID, 'pyre_critera_5', true); ?> <span class="score"><img src="<?php bloginfo('template_directory'); ?>/images/stars/<?php echo get_post_meta($post->ID, 'pyre_critera_5_score', true); ?>.png" alt="" /></span></li>
								<?php endif; ?>
							</ul>
						</div>
						<?php endif; ?>
						
						<?php the_content(); ?>
						
						<div class="clear"></div>
						
						<?php wp_link_pages(); ?>
					
					</div>
					
					<?php if(get_option('pyre_tags') == 'On'): ?> 
					<div class="post-tags">
						<?php the_tags('', ''); ?>
					</div>
					<?php endif; ?>
				
				</div>
				
				<?php if(get_option('pyre_author') == 'On'): ?> 
				<div class="post-box-wrapper first">
				
					<div class="post-box">
					
						<h5>About the Author</h5>
						<?php echo get_avatar(get_the_author_meta('email'), '75'); ?>
						<p><?php the_author_meta("description"); ?></p>
						<?php if(get_the_author_meta('twitter') || get_the_author_meta('facebook')): ?>
						<p>
							<?php if(get_the_author_meta('twitter')): ?>
							<a href='http://twitter.com/<?php echo get_the_author_meta('twitter'); ?>'>Twitter</a>
							<?php endif; ?>
							
							<?php if(get_the_author_meta('twitter') || get_the_author_meta('facebook')): ?>
							-
							<?php endif; ?>
							
							<?php if(get_the_author_meta('facebook')): ?>
							<a href='http://facebook.com/<?php echo get_the_author_meta('facebook'); ?>'>Facebook</a>
							<?php endif; ?>
						</p>
						<?php endif; ?>
					</div>
				
				</div>
				<?php endif; ?>
				
				<?php $tags = get_the_tags(); ?>
				<?php if($tags): ?>
				<?php $related = get_related_posts($post->ID, $tags); ?>
				<?php if($related->have_posts() && get_option('pyre_related') == 'On'): ?>
				<?php $count = 1; ?>
				<div class="post-box-wrapper">
				
					<div class="post-box">
					
						<h5>Related Posts</h5>
						
						<?php while($related->have_posts()): $related->the_post(); ?>
						<?php if($count == 4): $count = 1; endif; if($count == 3): $class = 'last'; else: $class = ''; endif; ?>
						<?php if(has_post_thumbnail()): ?>
						<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'related-posts-image'); ?>
						<div class="related-item <?php echo $class; ?>">
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" /></a>
						</div>
						<?php endif; ?>
						<?php $count++; endwhile; ?>
					
					</div>
				
				</div>
				<?php endif; ?>
				<?php endif; ?>
				<?php wp_reset_query(); ?>
				
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
				
				<div id="comments" class="post-box-wrapper">
					
					<div class="post-box">
					
						<?php comments_template(); ?>
					
					</div>
					
				</div>
			
			</div>
			
			<?php endwhile; ?>
			
		</div>
		
<?php get_sidebar('post'); ?>
<?php get_footer(); ?>