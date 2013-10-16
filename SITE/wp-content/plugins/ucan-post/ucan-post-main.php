<?php
/*
Plugin Name: uCan Post
Plugin URI: http://cartpauj.com/projects/ucan-post-plugin
Description: uCan Post is the easiest way to allow your users to post content to your blog without having to use the WordPress Dashboard.
Version: 1.0.09
Author: Cartpauj
Author URI: http://cartpauj.com
Text Domain: ucan-post
Copyright: 2009-2011, cartpauj

GNU General Public License, Free Software Foundation <http://creativecommons.org/licenses/GPL/2.0/>
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

//INCLUDE THE CLASS FILES
include_once("ucan-post-class.php");

//DECLARE AN INSTANCE OF THE uCanPost CLASS
if (class_exists("uCanPost"))
  $uCan_Post = new uCanPost();

//HOOKS
if (isset($uCan_Post))
{
  //ACTIVATE PLUGIN
  register_activation_hook(__FILE__ , array(&$uCan_Post, "uCan_Activate"));

  //SETUP TEXT DOMAIN FOR TRANSLATIONS
  $plugin_dir = basename(dirname(__FILE__));
  load_plugin_textdomain('ucan-post', false, $plugin_dir.'/i18n/');

  //ADD SHORTCODES
  add_shortcode('uCan-Post', array(&$uCan_Post, "uCan_Display"));

  //ADD ACTIONS
  add_action('init', array(&$uCan_Post, "uCan_Enqueue_Scripts"));
  add_action('wp_head', array(&$uCan_Post, "uCan_Add_To_WP_Head"));
  add_action('admin_menu', array(&$uCan_Post, "uCan_Add_Admin_Page"));

  //ADD FILTERS
  add_filter('the_content', array(&$uCan_Post, "uCan_Add_Edit_Post_Link"));
}
?>