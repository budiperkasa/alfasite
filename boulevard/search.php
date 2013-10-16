<?php get_header(); ?>

		<div id="main">
			
			<div id="archive-title">
				
				<span><?php _e('Search results for', 'pyre'); ?></span>
				<h1><?php echo get_search_query(); ?></h1>
				
			</div>
			
			<div id="items-wrapper">
			
				<?php $count = 1; ?>
				<?php while(have_posts()): the_post(); ?>
				<?php if($count == 3): $count = 1; endif; if($count == 2): $class = 'last'; else: $class = ''; endif; ?>
				<div class="item <?php echo $class; ?>">
					
					<?php if(has_post_thumbnail()): ?>
					<div class="item-thumb">
						<?php
						if(has_post_format('video') || has_post_format('audio') || has_post_format('gallery')) {
							$icon = '<span class="thumb-icon ' . get_post_format($post->ID) . '"></span>';
						} else {
							$icon = '';
						}
						echo $icon;
						?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail('archive-image'); ?></a>
						<span class="comments"><?php comments_popup_link('0', '1', '%'); ?></span>
						<?php if(get_post_meta($post->ID, 'pyre_overall_score', true)): ?>
						<span class="item-review"><img src="<?php echo get_template_directory_uri(); ?>/images/stars/<?php echo get_post_meta($post->ID, 'pyre_overall_score', true); ?>.png" alt="<?php the_title(); ?> Overall Score" /></span>
						<?php endif; ?>
					</div>
					<?php endif; ?>
					
					<h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
					<p><?php echo string_limit_words(get_the_excerpt(), 25); ?></p>
					
					<div class="item-meta">
						<span class="date"><?php the_time('F d, Y'); ?></span>
						<span class="category"><?php the_category(', '); ?></span>
					</div>
				
				</div>
				<?php $count++; endwhile; ?>
				
			</div>
			
			<?php kriesi_pagination($pages = '', $range = 2); ?>

		</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>