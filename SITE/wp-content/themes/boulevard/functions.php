<?php
// Adds RSS feeds link
if(!get_option('pyre_feedburner')) {
	add_theme_support('automatic-feed-links');
}

// Register Navigations
register_nav_menu('top_navigation', 'Top Navigation'); 
register_nav_menu('main_navigation', 'Main Navigation');

// Add post thumbnail functionality
add_theme_support('post-thumbnails', array('post'));
add_image_size('archive-image', 293, 150, true);
add_image_size('recent-posts-image', 50, 50, true);
add_image_size('featured-image', 600, 0, true);
add_image_size('related-posts-image', 180, 110, true);
add_image_size('slider-image', 650, 400, true);

// Register Widgetized Areas
if(function_exists('register_sidebar')) {
	register_sidebar(array(
		'name' => 'Sidebar',
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));
	
	register_sidebar(array(
		'name' => 'Footer Widget 1',
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));
	
	register_sidebar(array(
		'name' => 'Footer Widget 2',
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));
	
	register_sidebar(array(
		'name' => 'Footer Widget 3',
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));
	
	register_sidebar(array(
		'name' => 'Footer Widget 4',
		'before_widget' => '<div class="widget last">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));
}

// Include boostrap file for the pyre theme framework
include_once('framework/bootstrap.php');

// Shortcodes
include_once('shortcodes.php');

// Custom Functions
include_once('framework/functions.php');

// Profile Metaboxes
include_once('framework/profile.php');

// Updates Notifier
include_once('update-notifier.php');

// Translation
load_theme_textdomain('pyre', get_template_directory() . '/languages');
$locale = get_locale();
$locale_file = TEMPLATEPATH . '/languages/' . $locale . '.php';
if(is_readable($locale_file)) {
	require_once($locale_file);
}
	
// How comments are displayed
function boulevard_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
	
		<div class="the-comment">
		
			<?php echo get_avatar($comment,$size='60'); ?>
			
			<div class="comment-arrow"></div>
			
			<div class="comment-box">
			
				<div class="comment-author">
					<strong><?php echo get_comment_author_link() ?></strong>
					<small><?php printf(__('%1$s at %2$s', 'pyre'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('Edit', 'pyre'),'  ','') ?> - <?php comment_reply_link(array_merge( $args, array('reply_text' => __('Reply', 'pyre'), 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?></small>
				</div>
			
				<div class="comment-text">
					<?php if ($comment->comment_approved == '0') : ?>
					<em><?php _e('Your comment is awaiting moderation.', 'pyre') ?></em>
					<br />
					<?php endif; ?>
					<?php comment_text() ?>
				</div>
			
			</div>
			
		</div>

<?php }

// Trim end of excerpt
function pyre_trim_excerpt($text) {
	return rtrim($text, '[...]');
}
add_filter('get_the_excerpt', 'pyre_trim_excerpt');

function insert_image_src_rel_in_head() {
	global $post;
	if ( !is_singular()) //if it is not a post or a page
		return;
	if(has_post_thumbnail( $post->ID )) { //the post does not have featured image, use a default image
		$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
		echo '<meta property="og:image" content="' . esc_attr( $thumbnail_src[0] ) . '"/>';
	}
	echo "\n";
}
add_action( 'wp_head', 'insert_image_src_rel_in_head', 5 );