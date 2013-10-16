<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />
 
<title><?php bloginfo('name'); ?> <?php wp_title(' - ', true, 'left'); ?></title>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" />
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/js/colorbox/colorbox.css" type="text/css" />

<?php if(get_option('pyre_feedburner')): ?>
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php echo get_option('pyre_feedburner'); ?>" /> 
<?php endif; ?>

<?php if(get_option('pyre_favicon')): ?>
<link rel="shortcut icon" href="<?php echo get_option('pyre_favicon'); ?>" />
<?php endif; ?>

<?php if(is_singular()) wp_enqueue_script('comment-reply'); ?>
<?php wp_deregister_script('jquery'); ?>
<?php wp_enqueue_script('jquery', get_template_directory_uri() . '/js/jquery-1.6.4.min.js'); ?>
<?php wp_enqueue_script('jtwt', get_template_directory_uri() . '/js/jtwt.js'); ?>
<?php wp_enqueue_script('jquery.nivo.slider', get_template_directory_uri() . '/js/jquery.nivo.slider.pack.js'); ?>
<?php wp_enqueue_script('jquery.colorbox', get_bloginfo('template_directory'). '/js/colorbox/jquery.colorbox-min.js'); ?>
<?php wp_head(); ?>

<?php if(get_option('pyre_custom_css')): ?>
<?php echo '<style type="text/css">'; ?>
<?php echo get_option('pyre_custom_css'); ?>
<?php echo '</style>'; ?>
<?php endif; ?>

<?php if(get_option('pyre_custom_js')): ?>
<?php echo '<script type="text/javascript">'; ?>
<?php echo get_option('pyre_custom_js'); ?>
<?php echo '</script>'; ?>
<?php endif; ?>
	
<?php echo "<style type='text/css'>"; ?>
body { background-color:#<?php echo get_option('pyre_bg_color'); ?>; }
#header-top-wrapper { background-color:#<?php echo get_option('pyre_top_nav_color'); ?>; }
#navigation-wrapper { background-color:#<?php echo get_option('pyre_main_nav_color'); ?>; }
.item .item-meta .category a, .post-content a, #sidebar .widget-item .comments a, .post-meta .category a { color: #<?php echo get_option('pyre_link_color'); ?>; }
.item-thumb .comments, .nivo-caption .category, .post-comment-box { background-color: #<?php echo get_option('pyre_link_color'); ?>; } 
</style>

<script type="text/javascript">
jQuery(document).ready(function($) {
	(function ($) {
		// VERTICALLY ALIGN FUNCTION
		$.fn.vAlign = function() {
			return this.each(function(i){
			var ah = $(this).height();
			var ph = $(this).parent().height();
			var mh = Math.ceil((ph-ah) / 2);
			$(this).css('margin-top', mh);
			});
		};
		})(jQuery);

	$('#logo').vAlign();
	
	$('.slider-item').nivoSlider({
		directionNav: false,
		effect: '<?php echo get_option('pyre_slider_effect'); ?>',
		pauseTime: '<?php echo get_option('pyre_slider_speed'); ?>',
		captionOpacity: 1
	});

	// Tabs
	//When page loads...
	$('.tabs-wrapper').each(function() {
		$(this).find(".tab_content").hide(); //Hide all content
		$(this).find("ul.tabs li:first").addClass("active").show(); //Activate first tab
		$(this).find(".tab_content:first").show(); //Show first tab content
	});
	
	//On Click Event
	$("ul.tabs li").click(function(e) {
		$(this).parents('.tabs-wrapper').find("ul.tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(this).parents('.tabs-wrapper').find(".tab_content").hide(); //Hide all tab content

		var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
		$(this).parents('.tabs-wrapper').find(activeTab).fadeIn(); //Fade in the active ID content
		
		e.preventDefault();
	});
	
	$("ul.tabs li a").click(function(e) {
		e.preventDefault();
	})

	$(".toggle-content").hide(); 

	$("h5.toggle").toggle(function(){
		$(this).addClass("active");
		}, function () {
		$(this).removeClass("active");
	});

	$("h5.toggle").click(function(){
		$(this).next(".toggle-content").slideToggle();
	});
	
	// Add colorbox to gallery
	$('.gallery').each(function(index, obj){
		var galleryid = Math.floor(Math.random()*10000);
		$(obj).find('a').colorbox({rel:galleryid, maxWidth:'95%', maxHeight:'95%'});
	});
	$("a.lightbox").colorbox({maxWidth:'95%', maxHeight:'95%'});

	// Contact form
	$('#contactForm').live('submit', function(e) {
		var form = $(this);
		var name = $(this).find('[name=pyre_name]').val();
		var email = $(this).find('[name=pyre_email]').val();
		var message = $(this).find('[name=pyre_message]').val();
		
		if(name == '') {
			$(this).find('[name=pyre_name]').addClass('error');
			$(this).find('[name=pyre_name]').parent().find('.error_msg').fadeIn();
			
			return false;
		} else {
			$(this).find('[name=pyre_name]').removeClass('error');
			$(this).find('[name=pyre_name]').parent().find('.error_msg').fadeOut();
		}
		
		var email_regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
		if(email == ''  || !email_regex.test(email)) {
			$(this).find('[name=pyre_email]').addClass('error');
			$(this).find('[name=pyre_email]').parent().find('.error_msg').fadeIn();
			
			return false;
		} else {
			$(this).find('[name=pyre_email]').removeClass('error');
			$(this).find('[name=pyre_email]').parent().find('.error_msg').fadeOut();
		}
		
		if(message == '') {
			$(this).find('[name=pyre_message]').addClass('error');
			$(this).find('[name=pyre_message]').parent().find('.error_msg').fadeIn();
			
			return false;
		} else {
			$(this).find('[name=pyre_message]').removeClass('error');
			$(this).find('[name=pyre_message]').parent().find('.error_msg').fadeOut();
		}
		
		$.ajax({
			url: '<?php echo admin_url('admin-ajax.php'); ?>',
			data: jQuery(form).serialize()+'&action=pyre_contact_form',
			type: 'POST',
			success: function() {
				$('.email_sent').fadeIn(400).delay(5000).fadeOut(400);
			}
		});
		
		e.preventDefault();
	});
});
</script>

</head>

<body <?php body_class($class); ?>>

	<?php
	$top_nav = wp_nav_menu(array('theme_location' => 'top_navigation', 'depth' => 3, 'container' => false, 'fallback_cb' => false, 'echo' => false));
	if($top_nav):
	?>
	<div id="header-top-wrapper">
	
		<div id="header-top">
		
			<?php echo $top_nav; ?>
		
		</div>
	
	</div>
	<?php endif; ?>
	
	<div id="wrapper">
	
		<div id="header">
		
			<div id="logo">
				<?php
				if(get_option('pyre_logo')) {
					$logo = get_option('pyre_logo');
				} else {
					$logo = get_template_directory_uri() . '/images/logo2.png';
				}
				?>
				<a href='<?php bloginfo('wpurl'); ?>'><img src="<?php echo $logo; ?>" alt="<?php bloginfo('name'); ?>" /></a> 
			</div>
			
			<?php if(get_option('pyre_header_banner')): ?>
			<div id="header-banner">
				<?php echo get_option('pyre_header_banner'); ?>
			</div>
			<?php endif; ?>
		
		</div>
		
		<div id="navigation-wrapper">
		
			<div id='navigation'>
				<?php wp_nav_menu(array('theme_location' => 'main_navigation', 'depth' => 3, 'container' => false)); ?>
			</div>
			
		</div>