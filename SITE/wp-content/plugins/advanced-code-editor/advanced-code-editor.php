<?php
/*
Plugin Name: Advanced Code Editor
Plugin URI: http://en.bainternet.info
Description: Enables syntax highlighting in the integrated themes and plugins source code editors with line numbers, AutoComplete and much more. Supports PHP, HTML, CSS and JS.
Version: 1.4.1
Author: BaInternet
Author URI: http://en.bainternet.info
*/
/*
		* 	Copyright (C) 2011  Ohad Raz
		*	http://en.bainternet.info
		*	admin@bainternet.info

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
		Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/* Disallow direct access to the plugin file */
if (basename($_SERVER['PHP_SELF']) == basename (__FILE__)) {
	//die('Sorry, but you cannot access this page directly.');
}


/**
 * advanced_code_editor is the main class...
 * @author Bainternet
 *
 */
class advanced_code_editor{

	// Class Variables
	/**
	 * used as localiztion domain name
	 * @var string
	 */
	var $localization_domain = "baace";
	
	
	/**
	 * Class constarctor
	 */
	function advanced_code_editor(){
	   if( is_admin()){
		//create new file admin ajax
				add_action('wp_ajax_create_file', array($this,'ajax_create_file'));
		//delete file admin ajax
				add_action('wp_ajax_delete_file', array($this,'ajax_delete_file'));
		//create new directory admin ajax
				add_action('wp_ajax_create_directory', array($this,'ajax_create_directory'));
				
				
			if( strpos( strtolower( $_SERVER[ 'REQUEST_URI' ] ), 'plugin-editor.php' ) !== false || strpos( strtolower( $_SERVER[ 'REQUEST_URI' ] ), 'theme-editor.php' ) !== false ){
				add_filter( 'admin_footer', array($this,'do_edit' ));
				add_filter('admin_enqueue_scripts',array($this,'add_scripts'));
				//Language Setup
				$locale = get_locale();
				load_plugin_textdomain( $this->localization_domain, false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
			}
	    }
	}
	
	//ajax create directory
	/**
	 * function to handle ajax new directory creation
	 */
	function ajax_create_directory(){
		check_ajax_referer('create_directory');
		global $current_user;
		get_currentuserinfo();
		if (isset($_POST['di_name']) && isset($_POST['dir'])){
			if (current_user_can('manage_options')){
				$dir_name = '';
				$new_dir_name = strtolower( str_replace(' ', '-', $_POST['di_name']));
				if (isset($_POST['f_type'])){
					if ($_POST['f_type'] == "plugin" ){
						$dir_name = WP_PLUGIN_DIR . '/' . $_POST['dir'] . '/' . $new_dir_name;
					}
					if ($_POST['f_type'] == "theme" ){
						$dir_name = $_POST['dir'] . '/' . $new_dir_name;
					}
					
					//if(!is_dir($dir_name)){
						//echo __("Cannot create directory  Error code 9<br />".$dir_name,"baace");
					//}else{
						$umask = umask(0);
						if (@mkdir($dir_name, 0777)){
							echo __("New directory Created!!!","baace");
						}else{
							echo __("Cannot create directory Error code 8<br />".$dir_name,"baace");
						}
						umask($umask);
					//}
				}else{
					echo __('Error Code 7','baace');
				}
			}else{
				echo __('Error Code 5','baace');
			}
		}else{
			echo __('Error Code 6','baace');
		}
		die();
	}
	
	//ajax delete file
	/**
	 * function to handle ajax delete file
	 */
	function ajax_delete_file(){
		check_ajax_referer('delete_file');
		global $current_user;
		get_currentuserinfo();
		if(isset($_POST['F_T_D']) && $_POST['F_T_D'] != '' && isset($_POST['f_type'])){
			$f_name = '';
			if($_POST['f_type'] == "plugin" ){
				$f_name = WP_PLUGIN_DIR . '/' .$_POST['F_T_D'];
			}else{
				$f_name = $_POST['F_T_D'];
			}
				@unlink($f_name);
				echo __('File Deleted!!!','baace');
				die();
		}else{
			echo __('Error Code 4','baace');
			die();
		}
	}
	
	//ajax create file
	/**
	 * function to handle ajax file creation
	 */
	function ajax_create_file(){
		check_ajax_referer('create_new_file');
		global $current_user;
		get_currentuserinfo();
		if(isset($_POST)){
		$checks = false;
		$file_name = '';
			if (isset($_POST['file_name']) && $_POST['file_name'] != ''){
				if (isset($_POST['f_type']) && isset($_POST['dir'])){
					$f_name = strtolower( str_replace(' ', '-', $_POST['file_name']));
					if($_POST['f_type'] == "plugin" ){
						if (current_user_can( 'edit_plugins' )){
							$checks = true;
							$file_name = WP_PLUGIN_DIR . '/' . $_POST['dir'] . '/' . $f_name;
						}
					}elseif( $_POST['f_type'] == "theme" ){
						if (current_user_can( 'edit_themes' )){
							$checks = true;
							$file_name = $_POST['dir'] . '/' . $f_name;

						}
					}else{
						echo __('Error Code 3','baace');
						die();
					}
				}else{
					echo __('Error Code 2','baace');
					die();
				}
				if ($checks){
					
					if(file_exists( $file_name)){
						echo __("File already exists","baace");
						die();
					}else{
						$handle = fopen($file_name, 'w') or wp_die('Cannot open file for editing');
						
						$file_contents = '';
						fwrite($handle, $file_contents);
						fclose($handle);
						echo __('New File Created!','baace');
						die();
					}
				}
			}else{
				echo __('you must set a file name','baace');
			}
		}else{
			echo __('Error Code 1','baace');
			die();
		}
		die();
	}
	
	/**
	 * function to include jQuery form plugin for ajax save ...
	 */
	function add_scripts(){
	    wp_enqueue_script( 'jquery-form' );
	}

	function do_edit(){
		$url = plugins_url()."/advanced-code-editor/"; 
		/**/
		?>
		<script type="text/javascript" src="<?php echo $url; ?>js/codemirror.js"></script>
		<link rel="stylesheet" href="<?php echo $url; ?>css/codemirror.css">
		<script type="text/javascript" src="<?php echo $url; ?>js/xml.js"></script>
		<script type="text/javascript" src="<?php echo $url; ?>js/javascript.js"></script>
		<script type="text/javascript" src="<?php echo $url; ?>js/css.js"></script>
		<script type="text/javascript" src="<?php echo $url; ?>js/clike.js"></script>
		<script type="text/javascript" src="<?php echo $url; ?>js/php.js"></script>
		<script type="text/javascript" src="<?php echo $url; ?>js/complete.js"></script>
		<link rel="stylesheet" href="<?php echo $url; ?>themes/default.css">
		<link rel="stylesheet" href="<?php echo $url; ?>themes/night.css">
		<link rel="stylesheet" href="<?php echo $url; ?>themes/elegant.css">
		<link rel="stylesheet" href="<?php echo $url; ?>themes/neat.css">
		<link rel="stylesheet" href="<?php echo $url; ?>themes/raverStudio.css">
		<?php
		   /*jq todo use enquire_script*/
		   ?>
		<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/redmond/jquery-ui.css" rel="stylesheet" type="text/css"/>
		  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
		<?php
		   /*style todo move to external file*/
		   ?>
		<style>
		.ace_tool_bar{list-style: none;}
		.ace_tool_bar li{cursor: pointer;}
		.completions {position: absolute;z-index: 10;overflow: hidden;-webkit-box-shadow: 2px 3px 5px rgba(0,0,0,.2);-moz-box-shadow: 2px 3px 5px rgba(0,0,0,.2);box-shadow: 2px 3px 5px rgba(0,0,0,.2);}
		.completions select {background: #fafafa;outline: none;border: none;padding: 0;margin: 0;font-family: monospace;}
		   <?php if (!is_rtl()){?>
		.CodeMirror-scroll {height: 600px;overflow: auto; margin-right: 0 !important;}
		.CodeMirror-gutter{ width: 50px !important;}
		.fullscreen{background-color: #FFFFFF;height: 89%;left: 0;position: fixed;top: 80px;width: 100%;z-index: 100;}
		.ace_ToolBar{background-color: #FFFFFF;left: 0;min-height: 85px;position: fixed;top: 0;width: 100%;z-index: 100;}
		
		.CodeMirror {border: 1px solid #eee;} 
		/*toolbar*/
		#template div {margin-right: 105px;}
		.ace_tool_bar li{float: left; }
	    .clean_ace{clear:left;}

		<?php }else{ ?>
		 
		.CodeMirror {border: 1px solid #eee; margin-left: 190px !important;} 
		.CodeMirror-scroll {height: 600px;overflow: auto; margin-left: 0 !important;}
		.CodeMirror-gutter{ width: 50px !important;}
		 #template div {margin-left: 0px;}
		.fullscreen{background-color: #FFFFFF;height: 89%;right: 0;position: fixed;top: 80px;width: 100%;z-index: 100;}
		.ace_ToolBar{background-color: #FFFFFF;right: 0;min-height: 85px;position: fixed;top: 0;width: 100%;z-index: 100;}
		.ace_tool_bar li{float: right; }
		.clean_ace{clear:right;}
		.CodeMirror-lines{direction: ltr;}
		.completions{direction: ltr;}
		  <?php } ?>
		</style>
		<?php /*scripts todo move to external file*/ ?>
		<script>
		//ajax save
			$(document).ready(function() {
			   // attach handler to form's submit event 
				$('#template').submit(function(){
					// submit the form 
					// prepare Options Object 
					  var options = { 
						  beforeSubmit:  BeforeSave,
						  success:    showResponse 
					  };
					  $(this).ajaxSubmit(options); 
					  // return false to prevent normal browser submit and page navigation 
					  return false; 
				});
			});
			//add toolbar
			   jQuery("#newcontent").after("<div class=\"ace\"><h3><?php _e('Advanced Code Editor','baace');?></h3><div class=\"s_r\"></div></div><div class=\"clean_ace\"></div>");
			   jQuery('.s_r').append('<ul class=\"ace_tool_bar\"><li><a class=\"tb_se\" id=\"ace_tool_s\" title=\"<?php _e('Search','baace');?>\"><img src=\"http://i.imgur.com/z4Ulb.png\" alt=\"Search\"></a></li></ul>');
			   jQuery('.ace_tool_bar').append('<li><a class=\"tb_re\"  id=\"ace_tool_sr\" title=\"<?php _e('Replace','baace');?>\"><img src=\"http://i.imgur.com/1smMk.png\" alt=\"Replace\"></a><li>');
			   jQuery('.ace_tool_bar').append('<li><a class=\"tb_re\"  id=\"ace_tool_jmp\" title=\"<?php _e('Jump To Line','baace');?>\"><img src=\"http://i.imgur.com/rmic5.png\" alt=\"Jump To Line\"></a><li>');
			   jQuery('.ace_tool_bar').append('<li><a class=\"tb_re\"  id=\"ace_tool_full\" title=\"<?php _e('Full Screen Editor','baace');?>\"><img src=\"http://i.imgur.com/6NDPx.png\" alt=\"Full Screen Editor\"></a><li>');
			   jQuery('.ace_tool_bar').append('<li><a class=\"tb_re\"  id=\"ace_tool_save\" title=\"<?php _e('Save Changes','baace');?>\"><img src=\"http://i.imgur.com/suvnt.png\" alt=\"Save Changes\"></a><li>');
			   jQuery('.ace_tool_bar').append('<li><?php _e('Change editor theme:','baace');?><select id=\"editortheme\" onchange=\"selectTheme(this.value)\"></select></li>');
			   jQuery('.ace_tool_bar').append('<li><a class=\"tb_re\"  id=\"ace_tool_new_file\" title=\"<?php _e('Create New File','baace');?>\"><img src=\"http://i.imgur.com/ZjkC3.png" alt=\"Create New File\"></a><li>');
			   jQuery('.ace_tool_bar').append('<li><a class=\"tb_re\"  id=\"ace_tool_delete\" title=\"<?php _e('Delete Current File','baace');?>\"><img src=\"http://i.imgur.com/3b5nW.png" alt=\"Delete Current File\"></a><li>');
			   jQuery('.ace_tool_bar').append('<li><a class=\"tb_re\"  id=\"ace_tool_new_d\" title=\"<?php _e('Create New Directory','baace');?>\"><img src=\"http://i.imgur.com/iAW16.png" alt=\"Create New Directory\"></a><li>');
			   jQuery('.ace_tool_bar').append('<li><a class=\"tb_re\"  id=\"ace_tool_help\" title=\"<?php _e('Help','baace');?>\"><img src=\"http://i.imgur.com/Y1xXZ.png\" alt=\"Help\"></a><li>');
			   jQuery('.ace_tool_bar').append('<li><a class=\"tb_re\"  id=\"ace_tool_about\" title=\"<?php _e('About','baace');?>\"><img src=\"http://i.imgur.com/Wwa3Z.png\" alt=\"About\"></a><li>');

			//set theme changer
			var theme_coo = readCookie('adce_theme');
			if (theme_coo) {
			   var theme_names = ["default", "night", "neat", "elegant", "raverStudio"];
			   for(var i in theme_names){
				  if (theme_names[i] == theme_coo){
				 jQuery('#editortheme').append('<option selected=\"selected\">'+theme_names[i]+'</option>');
				  }else{
				 jQuery('#editortheme').append('<option>'+theme_names[i]+'</option>');	       
				  }
			   }
			}else{
			   jQuery('#editortheme').append('<option selected=\"selected\">default</option>');
			   jQuery('#editortheme').append('<option>night</option>');
			   jQuery('#editortheme').append('<option>neat</option>');
			   jQuery('#editortheme').append('<option>elegant</option>');
			   jQuery('#editortheme').append('<option>raverStudio</option>');
			}

		var lastPos = null, lastQuery = null, marked = [];
	//tool Bar
		
		//jump to lines
		jQuery('#ace_tool_jmp').bind('click', function() {
			jQuery("#jump_tbox").dialog({ focus: function(event, ui){jQuery('#jump_line_number').focus(); }, hide: 'slide',title: '<?php _e('Jump to Line','baace');?>', buttons: [
				{
					text: "<?php _e("Jump","baace");?>",
					click: function() { $(this).dialog("close"); Jump_to_Line(); },
				}] 
				});
		});
	
		// search toolbar
		jQuery('#ace_tool_s').bind('click', function() {
		   jQuery("#search").dialog({ focus: function(event, ui){jQuery('#query').focus(); }, hide: 'slide',title: '<?php _e('Search Box','baace');?>' });
		   // document.getElementById("query").focus();
		   
		});
		jQuery( "#search" ).bind( "dialogopen", function(event, ui) {
		     jQuery('#query').focus(); 
		 });
		 
		 jQuery('#query').live('keydown',function(e) {
		    if(e.keyCode == 13) {
			jQuery("#ace_se").click();
		    }
		  });
		//new directory
		jQuery('#ace_tool_new_d').bind('click', function() {
			jQuery("#add_new_file").html('<form action="" method="POST" id="new_d_create"><p>Directory Name: <input type="text" id="di_name" name="di_name" value=""><br /></p></form>');
			jQuery("#add_new_file").dialog({ show: 'slide',hide: 'slide',title: '<?php _e('Create Directory','baace');?>', buttons: [
				{
					text: "<?php _e("Cancel","baace");?>",
					click: function() { $(this).dialog("close"); },
				},
				{
					text: "<?php _e("Create","baace");?>",
					click: function() { ajax_create_directory(jQuery('#di_name').val()); }
				}
				] });
		});
			//new file toolbar
		jQuery('#ace_tool_new_file').bind('click', function() {
			jQuery("#add_new_file").html('<form action="" method="POST" id="new_F_create"><p> File Name: <input type="text" id="fi_name" name="fi_name" value=""></p></form>');
			jQuery("#add_new_file").dialog({ show: 'slide',hide: 'slide',title: '<?php _e('Create A new File','baace');?>' , buttons: [
				{
					text: "<?php _e("Cancel","baace");?>",
					click: function() { $(this).dialog("close"); },
				},
				{
					text: "<?php _e("Create","baace");?>",
					click: function() { create_new_file_callback(); }
				}
				] });
		});
			//delete file toolbar
		jQuery('#ace_tool_delete').bind('click', function() {
			var f_type1 = '';
			if (jQuery('input[name="plugin"]').length){
				file_to_delete = jQuery('input[name="plugin"]').val();
				f_type1 = 'plugin';
			}else{
			//theme file
				file_to_delete = jQuery('input[name="file"]').val();
				f_type1 = 'theme';
			}
			jQuery("#add_new_file").html('<p>are you sure you want to delete this file: ' + file_to_delete);
			jQuery("#add_new_file").dialog({ show: 'slide',hide: 'slide',title: '<?php _e('Delete File','baace');?>', buttons: [
				{
					text: "<?php _e("No","baace");?>",
					click: function() { $(this).dialog("close"); },
				},
				{
					text: "<?php _e("YES I'm Sure","baace");?>",
					click: function() { ajax_delete_file(file_to_delete,f_type1); }
				}
				] }); 
		});
			//replace toolbar
		jQuery('#ace_tool_sr').bind('click', function() {
		   jQuery("#searchR").dialog({ show: 'slide',hide: 'slide',title: '<?php _e('Search And Replace Box','baace');?>' });
		});
		   //fullscreen toolbar button
		jQuery('#ace_tool_full').bind('click', function() {
		   toggleFullscreenEditing();
		});
		   //save toolbar button
		jQuery('#ace_tool_save').live('click', function() {
		   jQuery('#submit').click();
		});

		   //help toolbar
		jQuery('#ace_tool_help').bind('click', function() {
		   jQuery("#ace_help").dialog({show: 'slide',hide: 'slide', title: '<?php _e('Help','baace');?>' });
		});

		   //about toolbar
		jQuery('#ace_tool_about').bind('click', function() {
		   jQuery("#ace_about").dialog({show: 'slide',hide: 'slide', title: '<?php _e('About WordPress Advanced Code Editor','baace');?>',width: 380 });
		});
	
	//action buttons
			//delete file
			function ajax_delete_file(file_to_delete,f_type1){
				jQuery('#add_new_file').html('<p style="text-align:center;">Deleting File ...<br/><img src="http://i.imgur.com/GRZ9W.gif"></p>');
				var data = {
				action: 'delete_file',
				f_type: f_type1,
				F_T_D: file_to_delete,
				_ajax_nonce: '<?php echo wp_create_nonce( 'delete_file' ); ?>'
			};
			jQuery.post(ajaxurl, data, function(response) {
				//alert('Got this from the server: ' + response);
				jQuery(".ui-dialog-content").dialog("close");
				jQuery('#add_new_file').dialog( "destroy" );
				jQuery('#update_Box').html('<div>' + response + '</div>');
				jQuery("#update_Box").dialog({ show: 'slide',hide: 'slide', title: '<?php _e('Create A new File','baace');?>', buttons: [
					{
						text: "Ok",
						click: function() { $(this).dialog("close"); }
					}
				] }); 
			});
			}
			//create new directory
			function ajax_create_directory(di_name){
				jQuery('#add_new_file').html('<p style="text-align:center;">Creating New Directory ...<br/><img src="http://i.imgur.com/GRZ9W.gif"></p>');
				var plugin_meta = new Array();
				var f_type2 = '';
				//plugin file
				if (jQuery('input[name="plugin"]').length){
					plugin_meta = jQuery('input[name="plugin"]').val().split('/');
					var plugin_dir = plugin_meta[0];
					var dirs = plugin_meta.length - 1;
					for(i=1; i < dirs; i++) { 
						plugin_dir = plugin_dir + '/' + plugin_meta[i];
					}
					f_type2 = 'plugin';
				}else{
					//theme file
					plugin_meta = jQuery('input[name="file"]').val().split('/');
					var plugin_dir = plugin_meta[0];
					var dirs = plugin_meta.length - 1;
					for(i=1; i < dirs; i++) { 
						plugin_dir = plugin_dir + '/' + plugin_meta[i];
					}
					f_type2 = 'theme';
				}

				var data = {
					action: 'create_directory',
					dir: plugin_dir,
					f_type: f_type2,
					di_name: di_name,
					_ajax_nonce: '<?php echo wp_create_nonce( 'create_directory' ); ?>'
				};
				jQuery.post(ajaxurl, data, function(response) {
					//alert('Got this from the server: ' + response);
					jQuery(".ui-dialog-content").dialog("close");
					jQuery('#add_new_file').dialog( "destroy" );
					jQuery('#update_Box').html('<div>' + response + '</div>');
					jQuery("#update_Box").dialog({ show: 'slide',hide: 'slide', title: '<?php _e('Create A new Directory','baace');?>', buttons: [
						{
							text: "Ok",
							click: function() { $(this).dialog("close"); }
						}
					] }); 
				});
			}
			
			//create new file
		function create_new_file_callback(){
			var file_name = jQuery("#fi_name").val();
			jQuery('#add_new_file').html('<p style="text-align:center;">Creating New File ...<br/><img src="http://i.imgur.com/GRZ9W.gif"></p>');
			var plugin_meta = new Array();
			//plugin file
			var f_type = '';
			if (jQuery('input[name="plugin"]').length){
				plugin_meta = jQuery('input[name="plugin"]').val().split('/');
				var plugin_dir = plugin_meta[0];
				var dirs = plugin_meta.length - 1;
				for(i=1; i < dirs; i++) { 
					plugin_dir = plugin_dir + '/' + plugin_meta[i];
				}
				f_type = 'plugin';
			}else{
			//theme file
				plugin_meta = jQuery('input[name="file"]').val().split('/');
				var plugin_dir = plugin_meta[0];
				var dirs = plugin_meta.length - 1;
				for(i=1; i < dirs; i++) { 
					plugin_dir = plugin_dir + '/' + plugin_meta[i];
				}
				f_type = 'theme';
			}

			var data = {
				action: 'create_file',
				dir: plugin_dir,
				f_type: f_type,
				file_name: file_name,
				_ajax_nonce: '<?php echo wp_create_nonce( 'create_new_file' ); ?>'
			};
			jQuery.post(ajaxurl, data, function(response) {
				//alert('Got this from the server: ' + response);
				jQuery(".ui-dialog-content").dialog("close");
				jQuery('#add_new_file').dialog( "destroy" );
				jQuery('#update_Box').html('<div>' + response + '</div>');
				jQuery("#update_Box").dialog({ show: 'slide',hide: 'slide', title: '<?php _e('Create A new File','baace');?>', buttons: [
					{
						text: "Ok",
						click: function() { $(this).dialog("close"); }
					}
				] }); 
			});
		}
			//replace
		jQuery('#ace_re').live('click', function() {
			 replace();
		});
			//search
		jQuery('#ace_se').live('click', function() {
		  search();
		});
			//replace all
		jQuery('#ace_res').live('click', function() {
		   replaceall();
		});
			//jump to line
		jQuery('#ace_jamp').live('click', function() {
		   Jump_to_Line();
		});
		
		jQuery('#jump_line_number').live('keydown',function(e) {
		    if(e.keyCode == 13) {
		       jQuery("#jump_tbox").dialog("close");
 		       Jump_to_Line();
		    }
		  });
		
	//functions
		//jump to line
		function Jump_to_Line(){
			var line = document.getElementById("jump_line_number").value -1;
			if (line && !isNaN(Number(line))) {
				editor.setCursor(Number(line),0);
				editor.setSelection({line:Number(line),ch:0},{line:Number(line)+1,ch:0});
				editor.focus();
			}
		}
		//search unmark
		function unmark() {
			for (var i = 0; i < marked.length; ++i) marked[i]();
				marked.length = 0;
		}
	   //change theme
		function selectTheme(theme) {
			var editorDiv = jQuery('.CodeMirror-scroll');
			if (editorDiv.hasClass('fullscreen')) {
				toggleFullscreenEditing();
				editor.setOption("theme", theme);
				createCookie('adce_theme',theme,365);
				toggleFullscreenEditing();
			}else{
				editor.setOption("theme", theme);
				createCookie('adce_theme',theme,365);
			}
		}
		//search
		function search() {
			unmark();
			var text = document.getElementById("query").value;
			if (!text) return;
			for (var cursor = editor.getSearchCursor(text); cursor.findNext();)
			marked.push(editor.markText(cursor.from(), cursor.to(), "searched"));
			if (lastQuery != text) lastPos = null;
			var cursor = editor.getSearchCursor(text, lastPos || editor.getCursor());
			if (!cursor.findNext()) {
				 cursor = editor.getSearchCursor(text);
			   if (!cursor.findNext()) return;
			}
			editor.setSelection(cursor.from(), cursor.to());
			lastQuery = text; lastPos = cursor.to();
		}

		//replace
		function replace() {
			unmark();
			var text = document.getElementById("query1").value,
			replace = document.getElementById("replace").value;
			if (!text) return;
			var cursor = editor.getSearchCursor(text);
			cursor.findNext();
			if (!cursor) return;
			editor.replaceRange(replace, cursor.from(), cursor.to());
			
		}
		//replaceall
		function replaceall() {
			unmark();
			var text = document.getElementById("query1").value,
			replace = document.getElementById("replace").value;
			if (!text) return;
			for (var cursor = editor.getSearchCursor(text); cursor.findNext();)
			   editor.replaceRange(replace, cursor.from(), cursor.to());
		}

		//before save
		function BeforeSave() {
		      jQuery("#SaveBox").html('<p style="text-align:center;">saving changes ...<br/><img src="http://i.imgur.com/GRZ9W.gif"></p>');
		      jQuery("#SaveBox").dialog({ show: 'slide',hide: 'slide',title: '<?php _e('Save Box','baace');?>' }); 
		      return true; 
		} 
		//save response
		function showResponse(responseText)  { 
			var htmlCode = jQuery('#message',jQuery(responseText)).html();
			jQuery(".ui-dialog-content").dialog("close");
			jQuery('#saveBox').dialog( "destroy" );
			jQuery('#update_Box').html('<div>' + htmlCode + '</div>');
			jQuery("#update_Box").dialog({ show: 'slide',hide: 'slide', title: '<?php _e('Save Box','baace');?>', buttons: [
				{
					text: "Ok",
					click: function() { $(this).dialog("close"); }
				}
			] }); 
		}  

		//fullscreen edit
		function toggleFullscreenEditing(){
			var editorDiv = jQuery('.CodeMirror-scroll');
			var toolbarDiv = jQuery('.ace');
			if (!editorDiv.hasClass('fullscreen')) {
				var bgcolor = editorDiv.css("background-color");
				toggleFullscreenEditing.beforeFullscreen = { height: editorDiv.height(), width: editorDiv.width(),bg: editorDiv.css("background-color") }
				editorDiv.addClass('fullscreen');
				jQuery(".fullscreen").css('background-color',bgcolor);
				editorDiv.height('89%');
				editorDiv.width('100%');
				toolbarDiv.addClass('ace_ToolBar');
				editor.refresh();
			}else {
				editorDiv.removeClass('fullscreen');
				toolbarDiv.removeClass('ace_ToolBar');
				editorDiv.height(toggleFullscreenEditing.beforeFullscreen.height);
				editorDiv.width(toggleFullscreenEditing.beforeFullscreen.width);
				editorDiv.css('background-color','');
				editor.refresh();
			}
		}
		
		//refresh editor
			 editor.refresh();
		</script>
		<div id="add_new_file" style="display:none;"></div>
		<div id="SaveBox" style="display:none;"></div>
		<div id="update_Box" style="display:none;"></div>
		<div id="search" style="display:none;"><?php _e('Search For: ','baace');?><input type="text" value="" id="query" style="width: 5em"><button class="button"  id="ace_se" type="button"><?php _e('Search','baace');?></button> </div> 
		<div id="jump_tbox" style="display:none;"><?php _e('Jump to Line: ','baace');?><input type="text" value="" id="jump_line_number" style="width: 5em"></div> 
		<div id="searchR" style="display:none;"><?php _e('Search For: ','baace');?><input type="text" value="" id="query1" style="width: 5em"><br/><?php _e('And Replace with:','baace');?><input type="text" id="replace" value="" style="width: 5em"><br /><button class="button"  id="ace_re" type="button"><?php _e('Replace','baace');?></button><?php _e('OR','baace');?> <button class="button"  id="ace_res" type="button"><?php _e('Replace all','baace');?></button> </div> 
		<div id="ace_help" style="display:none;"><h4><?php _e('Hot Keys:','baace');?></h4>
		   <ul>
			  <li><strong>CRTL + Space</strong> -  <?php _e('Triggers AutoComplete.','baace');?></li>
			  <li><strong>CRTL + Z</strong> -  <?php _e('Undo (remembers all changes, so you can use more then one)','baace');?></li>
			  <li><strong>CRTL + Y</strong> -  <?php _e('Redo (remembers all changes, so you can use more then one)','baace');?></li>
			  <li><strong>CRTL + F</strong> -  <?php _e('Search','baace');?></li>
			  <li><strong>CRTL + H</strong> -  <?php _e('Search and Replace','baace');?></li>
			  <li><strong>CRTL + G</strong> -  <?php _e('Jump to Line','baace');?></li>
			  <li><strong>CRTL + S</strong> -  <?php _e('Save Changes (When cruser is inside editor)','baace');?></li>			  
  			  <li><strong>F11</strong> -  <?php _e('FullScreen Editor (When cruser is inside editor)','baace');?></li>	
		   </ul>
		   <h4></h4>
		</div>
		<div id="ace_about" style="display:none;text-align:center;">
		   <h4><?php _e('WordPress Advanced Code Editor','baace');?></h4>
		   <ul style="list-style: square inside none; width: 300px; font-weight: bolder; padding: 20px; border: 2px solid; background-color: #FFFFE0; border-color: #E6DB55;">
			<li> Any feedback or suggestions are welcome at <a href="http://en.bainternet.info/">plugin homepage</a></li>
			<li> <a href="http://wordpress.org/tags/advanced-code-editor/?forum_id=10">Support forum</a> for help and bug submittion</li>
			<li> Also check out <a href="http://en.bainternet.info/category/plugins">my other plugins</a></li>
			<li> And if you like my work <a style="color: #FF0000;" href="http://en.bainternet.info/donations">make a donation</a> or atleast <a href="http://wordpress.org/extend/plugins/bainternet-user-ranks/">rank the plugin</a></li>
		   </ul>
		   <p><?php _e('WordPress Advanced Code Editor was uses:','baace');?> </p>
			  <ul>
			 <li><a href="http://codemirror.net" traget="_blank">CodeMirror2</a> by Marijn Haverbeke.</li>
			 <li>icons By:
				<ul>
				   <li><a href="http://www.icons-land.com" traget="_blank">Icons Land</a></li>
				   <li><a href="http://www.oxygen-icons.org/" traget="_blank">Oxygen Team</a></li>
					   <li><a href="http://www.oxygen-icons.org/" traget="_blank">Oliver Scholtz</a></li>
					   <li>Marco Martin</li>
					   <li><a href="http://sa-ki.deviantart.com/" traget="_blank">Alexandre Moore</a></li>
				</ul>
			  </li>
			  </ul>
		</div>
		<?php
	}
	
}//END Class

$ace = new advanced_code_editor();