<?php get_header(); ?>

		<div id="main">
			
			<?php if(get_option('pyre_featured_slider') == 'On' && get_option('pyre_featured_tag')): ?>
			<?php
			$featured_posts = new WP_Query(array(
				'showposts' => get_option('pyre_featured_posts'),
				'tag' => get_option('pyre_featured_tag')
			));
			?>
			<div id="featured-wrapper">
			
				<div class="slider-item">
				
					<?php while($featured_posts->have_posts()): $featured_posts->the_post(); ?>
					<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'slider-image'); ?>
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" title="#htmlcaption_<?php echo $post->ID; ?>"/></a>
					<?php endwhile; ?>
				
				</div>
				
				<?php while($featured_posts->have_posts()): $featured_posts->the_post(); ?>
				<div id="htmlcaption_<?php echo $post->ID; ?>" class="slider-text nivo-html-caption">
				
					<span class="category"><?php the_category(', '); ?></span>
					<span class="date"><?php the_time('F d, Y'); ?></span>
					
					<div class="slider-heading">
					
						<h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
						<p><?php echo string_limit_words(get_the_excerpt(), 40); ?></p>
						
					</div>
				
				</div>
				<?php endwhile; ?>
			
			</div>
			<?php endif; ?>
			
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