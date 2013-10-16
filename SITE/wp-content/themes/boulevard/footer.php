
	</div>
	
	<div id="footer-wrapper">
	
		<div id="footer">
	
			<?php
			if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Widget 1')): 
			endif;
			?>
			
			<?php
			if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Widget 2')): 
			endif;
			?>
			
			<?php
			if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Widget 3')): 
			endif;
			?>
			
			<?php
			if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Widget 4')): 
			endif;
			?>
	
		</div>
	
	</div>
	
	<div id="bottom-wrapper">
		
		<div id="bottom">
		
			<span class="totop"><a href="#"><?php _e('Back to Top', 'pyre'); ?></a></span>
			<?php if(get_option('pyre_footer_left')): ?>
			<span class="left"><?php echo get_option('pyre_footer_left'); ?></span>
			<?php endif; ?>
			<?php if(get_option('pyre_footer_right')): ?>
			<span class="right"><?php echo get_option('pyre_footer_right'); ?></span>
			<?php endif; ?>
			
		</div>
	
	</div>
	
	<?php
	if(get_option('pyre_analytics')) {
		echo get_option('pyre_analytics');
	}
	?>
	
	<?php wp_footer(); ?>

</body>

</html>