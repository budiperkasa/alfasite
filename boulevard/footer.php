

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