<?php
if (!class_exists("uCanPost"))
{
  class uCanPost
  {
/***************************SETUP***************************/
    //Constructor
    function uCanPost()
    {
      $this->uCan_Set_Admin_Options(); //Init the admin options
      $this->uCan_Set_DB_Table_Names();
    }

    //Define some variables
    var $ucan_options_name    = "uCan_Post_Options";
    var $ucan_options         = array();

    var $ucan_plugin_dir      = "";
    var $ucan_plugin_url      = "";

    var $ucan_page_url        = "";
    var $ucan_action_url      = "";

    var $ucan_js_url          = "";
    var $ucan_views_dir       = "";
    var $ucan_images_url      = "";
    var $ucan_wp_admin_url    = "";
    var $ucan_wp_includes_url = "";

    var $ucan_db_submissions  = "";

    function uCan_Set_DB_Table_Names()
    {
      global $wpdb;

      $this->ucan_db_submissions = $wpdb->prefix.'ucan_post_submissions';
    }

    //This function is called on Plugin Activation -- it just allows subscribers access to uploads
    function uCan_Activate()
    {
      global $wpdb;

      $charset_collate = '';
      if($wpdb->has_cap('collation'))
      {
        if(!empty($wpdb->charset))
          $charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
        if(!empty($wpdb->collate))
          $charset_collate .= " COLLATE $wpdb->collate";
      }

      $ucan_submissions_sql = "CREATE TABLE ".$this->ucan_db_submissions."(
      `id` int(11) NOT NULL auto_increment,
      `name` varchar(120) NOT NULL,
      `email` varchar(120) NOT NULL,
      `postid` int(11) NOT NULL default '0',
      `type` varchar(60) NOT NULL,
      PRIMARY KEY (`id`))
      {$charset_collate};";

      require_once(ABSPATH.'wp-admin/includes/upgrade.php');

      dbDelta($ucan_submissions_sql);

      $role = get_role('contributor');
      $role->add_cap('upload_files');
      $role = get_role('subscriber');
      $role->add_cap('upload_files');
      $role->add_cap('unfiltered_html');
    }

    //Initialize all the above variables
    function uCan_Set_Links()
    {
      $this->ucan_plugin_dir      = ABSPATH."wp-content/plugins/ucan-post/";
      $this->ucan_plugin_url      = WP_CONTENT_URL."/plugins/ucan-post/";
      $this->ucan_page_url        = get_permalink($this->uCan_Page_ID());
      $this->ucan_action_url      = $this->ucan_page_url.$this->uCan_Get_Delim()."ucanaction=";
      $this->ucan_views_dir       = $this->ucan_plugin_dir."views/";
      $this->ucan_js_url          = $this->ucan_plugin_url."js/";
      $this->ucan_images_url      = $this->ucan_plugin_url."images/";
      $this->ucan_wp_admin_url    = get_option('siteurl')."/wp-admin/";
      $this->ucan_wp_includes_url = get_option('siteurl')."/wp-includes/";
    }

    //Get the dilim for use in the action url's
    function uCan_Get_Delim()
    {
      global $wp_rewrite;
      if($wp_rewrite->using_permalinks())
        return "?";
      else
        return "&";
    }

    //Get the page id where the [uCan-Post] shortcode is
    function uCan_Page_ID()
    {
      global $wpdb;
      return $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_content LIKE '%[uCan-Post]%' AND post_status = 'publish' AND post_type = 'page'");
    }

    //Enque the scripts needed for the media uploader
    function uCan_Enqueue_Scripts()
    {
      if($this->ucan_options['uCan_Use_WYSIWYG'] && $this->ucan_options['uCan_Allow_Uploads'] && !$this->ucan_options['uCan_Force_JS'])
      {
        wp_enqueue_script('jquery');
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
      }
    }

    //Add styles and scripts to the <head>
    function uCan_Add_To_WP_Head()
    {
      $this->uCan_Set_Links();
      if(is_page($this->uCan_Page_ID()))
      {
        ?>
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo $this->ucan_plugin_url.'niceforms/niceforms-default.css'; ?>" />
        <?php
        if($this->ucan_options['uCan_Use_WYSIWYG']) //Saves js code from being loaded when not needed - preventing more conflicts
        {
          if($this->ucan_options['uCan_Force_JS'])
            echo '<script type="text/javascript" src="'.$this->ucan_wp_admin_url.'load-scripts.php?c=1&amp;load=jquery,utils,thickbox,media-upload"></script>';
        ?>
          <link rel="stylesheet" id="thickbox-css"  href="<?php echo $this->ucan_wp_includes_url.'js/thickbox/thickbox.css'; ?>" type="text/css" media="all" />
          <script type="text/javascript" src="<?php echo $this->ucan_js_url.'tinymce/tiny_mce.js'; ?>" ></script>
          <script type="text/javascript">
            tinyMCE.init({
              mode : "specific_textareas",
              theme : "advanced",
              skin : "o2k7",
              editor_selector:"theEditor",
              remove_script_host : false,
              convert_urls : false,
              width:"80%",
              theme_advanced_buttons1 : "bold,italic,underline,|,justifyleft,justifycenter,justifyright,fontsizeselect,formatselect",
              theme_advanced_buttons2 : "cut,copy,paste,|,bullist,numlist,|,outdent,indent,|,undo,redo,|,link,unlink,image,media",
              theme_advanced_buttons3 : "blockquote,|,forecolor,backcolor,|,emotions,charmap,spellchecker,|,code,preview,|,help",
              theme_advanced_toolbar_location : "top",
              theme_advanced_toolbar_align : "left",
              plugins : "emotions,preview,safari,spellchecker,media"
            });
          </script>
          <script type="text/javascript">
            /* <![CDATA[ */
            var thickboxL10n = {
              next: "Next &gt;",
              prev: "&lt; Prev",
              image: "Image",
              of: "of",
              close: "Close",
              noiframes: "This feature requires inline frames. You have iframes disabled or your browser does not support them."
            };
            try{convertEntities(thickboxL10n);}catch(e){};
            /* ]]> */
          </script>
        <?php
        }
      }
    }


/************************ADMIN SETUP************************/
    //Add the admin settings page
    function uCan_Add_Admin_Page()
    {
      $this->uCan_Set_Links();
      add_menu_page(__('uCan Post - Options', 'ucan-post'), 'uCan Post', 'administrator', 'ucanmain', array(&$this, 'uCan_Display_Admin_Options_Page'), $this->ucan_images_url.'menu_icon.png');
      add_submenu_page( 'ucanmain', __('uCan Post - Options', 'ucan-post'), __('Options', 'ucan-post'), 'administrator', 'ucanmain', array(&$this, 'uCan_Display_Admin_Options_Page'));
      add_submenu_page( 'ucanmain', __('uCan Post - Submissions', 'ucan-post'), __('Submissions', 'ucan-post'), 'administrator', 'ucansubmissions', array(&$this, 'uCan_Display_Admin_Submissions_Page'));
    }

    //Sets up variables and displays the admin page
    function uCan_Display_Admin_Options_Page()
    {
      $categories = $this->uCan_Get_Categories();
      $users = $this->uCan_Get_All_Users();

      if($this->uCan_Save_Admin_Options())
        require($this->ucan_views_dir.'ucan-admin-options-saved.php');

      require($this->ucan_views_dir.'ucan-admin-options-form.php');
    }

    function uCan_Display_Admin_Submissions_Page()
    {
      if(isset($_GET['ucanaction']) && $_GET['ucanaction'] == 'publish')
      {
        $pid = $_GET['pid'];
        $tomail = stripslashes(urldecode($_GET['tomail']));
        $post = array();
        $post['ID'] = $pid;
        $post['post_status'] = "publish";

        if($pid)
        {
          wp_update_post($post);
          $this->uCan_Maybe_Email_User($pid, $tomail);
          require($this->ucan_views_dir.'ucan-admin-post-published.php');
        }
      }
      $submissions = $this->uCan_Get_All_Submissions();
      require($this->ucan_views_dir.'ucan-admin-submissions-page.php');
    }

    //Get/Set the admin options
    function uCan_Set_Admin_Options()
    {
      $ucan_old_options = get_option($this->ucan_options_name); //Get any existing options
 
      $this->ucan_options = array('uCan_Post_Level'             => '0',
                                  'uCan_Post_Type'              => 'post', /*TODO*/
                                  'uCan_Show_Categories'        => false,
                                  'uCan_Default_Category'       => 1,
                                  'uCan_Exclude_Categories'     => '',
                                  'uCan_Allow_Author'           => true,
                                  'uCan_Allow_Author_Edits'     => false,
                                  'uCan_Append_Guest_Name'      => true,
                                  'uCan_Default_Author'         => 1,
                                  'uCan_Allow_Tags'             => false,
                                  'uCan_Default_Tags'           => '',
                                  'uCan_Show_Excerpt'           => false,
                                  'uCan_Allow_Comments'         => true,
                                  'uCan_Allow_Pings'            => true,
                                  'uCan_Email_Admin'            => true,
                                  'uCan_Email_User'             => false,
                                  'uCan_Moderate_Posts'         => true,
                                  'uCan_Allow_Uploads'          => true,
                                  'uCan_Show_Captcha'           => false,
                                  'uCan_Use_WYSIWYG'            => true,
                                  'uCan_Force_JS'               => false
      );

      if(!empty($ucan_old_options))
        foreach($ucan_old_options as $key => $value)
          $this->ucan_options[$key] = $value;

      update_option($this->ucan_options_name, $this->ucan_options);
    }

    //Check if we're saving -- if so save to the wp_options table
    function uCan_Save_Admin_Options()
    {
      if(isset($_POST['ucan_save_admin_options']) && !empty($_POST['ucan_save_admin_options']))
      {
        $ucan_save_options = array( 'uCan_Post_Level'             => $_POST['ucan_post_level'],
                                    'uCan_Post_Type'              => 'post', /*TODO*/
                                    'uCan_Show_Categories'        => $_POST['ucan_show_categories'],
                                    'uCan_Default_Category'       => $_POST['ucan_default_category'],
                                    'uCan_Exclude_Categories'     => $_POST['ucan_exclude_categories'],
                                    'uCan_Allow_Author'           => $_POST['ucan_allow_author'],
                                    'uCan_Allow_Author_Edits'     => $_POST['ucan_allow_author_edits'],
                                    'uCan_Default_Author'         => $_POST['ucan_default_author'],
                                    'uCan_Append_Guest_Name'      => $_POST['ucan_append_guest_name'],
                                    'uCan_Allow_Tags'             => $_POST['ucan_allow_tags'],
                                    'uCan_Default_Tags'           => $_POST['ucan_default_tags'],
                                    'uCan_Show_Excerpt'           => $_POST['ucan_show_excerpt'],
                                    'uCan_Allow_Comments'         => $_POST['ucan_allow_comments'],
                                    'uCan_Allow_Pings'            => $_POST['ucan_allow_pings'],
                                    'uCan_Email_Admin'            => $_POST['ucan_email_admin'],
                                    'uCan_Email_User'             => $_POST['ucan_email_user'],
                                    'uCan_Moderate_Posts'         => $_POST['ucan_moderate_posts'],
                                    'uCan_Allow_Uploads'          => $_POST['ucan_allow_uploads'],
                                    'uCan_Show_Captcha'           => $_POST['ucan_show_captcha'],
                                    'uCan_Use_WYSIWYG'            => $_POST['ucan_use_wysiwyg'],
                                    'uCan_Force_JS'              => $_POST['ucan_force_js']
        );
        update_option($this->ucan_options_name, $ucan_save_options);
        $this->uCan_Set_Admin_Options(); //Make sure new options are updated in the class instance
        return true;
      }
      return false;
    }


/***********************VALIDATE FORM***********************/
    //Validate post submission before committing it to the DB
    function uCan_Validate_Submission()
    {
      global $user_ID;

      $errors = array();
      if($this->ucan_options['uCan_Show_Captcha'])
      {
        include_once($this->ucan_plugin_dir.'captcha/shared.php');
        $code = ucan_str_decrypt($_POST['ucan_security_check']);
      }

      if(empty($_POST['ucan_submission_title']))
        $errors[] = __('You must enter a title!', 'ucan-post');
      if(empty($_POST['ucan_submission_content']))
        $errors[] = __('You must enter some content!', 'ucan-post');
      if($this->ucan_options['uCan_Show_Captcha'])
        if($code != $_POST['ucan_show_captcha'] && !empty($code))
          $errors[] = __('Image verification did not match!','ucan-post');
      if(empty($_POST['ucan_submission_guest_name']) && !$user_ID)
        $errors[] = __('You must enter your name!', 'ucan-post');
      if((empty($_POST['ucan_submission_guest_email']) || !$this->uCan_Validate_Email_Address(stripslashes($_POST['ucan_submission_guest_email']))) && !$user_ID)
        $errors[] = __('You must enter a valid email address!', 'ucan-post');

      return $errors;
    }


/***********************PUBLISH POST************************/
    //If validation checks out - Publish this PIG
    function uCan_Display_Publish()
    {
      global $user_ID;

      $categories = $this->uCan_Get_Categories();
      $errors = $this->uCan_Validate_Submission();
      $new_post_id = 0;
      $maybe_view_new_post = "";
      $new_post_permalink = "";

      if(empty($errors))
      {
        $new_post_id = wp_insert_post($this->uCan_Publish_Submission()); //See next function down
        if ($new_post_id)
        {
          $new_post_permalink = get_permalink($new_post_id);
          $this->uCan_Maybe_Email_Admin($new_post_permalink);
          $this->uCan_Add_DB_Submission($new_post_id);
          require($this->ucan_views_dir.'ucan-publish.php');
        }
        else
          require($this->ucan_views_dir.'ucan-unknown-error.php');
      }
      else
      {
        require($this->ucan_views_dir.'ucan-errors.php');
        require($this->ucan_views_dir.'ucan-submission-form.php');
      }
    }

    //Does all the checks and prepares the array for post insertion
    function uCan_Publish_Submission()
    {
      global $user_ID;

      $append_name = "";
      if($this->ucan_options['uCan_Append_Guest_Name'] && $this->ucan_options['uCan_Post_Level'] == 'guest' && !$user_ID)
        $append_name = '<br/>'.__('By:', 'ucan-post').' '.stripslashes($_POST['ucan_submission_guest_name']);

      $ucan_new_post = array();
      $ucan_new_post['post_type'] = $this->ucan_options['uCan_Post_Type']; //TODO
      $ucan_new_post['post_title'] = stripslashes($_POST['ucan_submission_title']);
      $ucan_new_post['post_content'] = stripslashes($_POST['ucan_submission_content']).$append_name;

      if($this->ucan_options['uCan_Show_Excerpt'])
        $ucan_new_post['post_excerpt'] = stripslashes($_POST['ucan_submission_excerpt']);

      if($this->ucan_options['uCan_Show_Categories'])
        $ucan_new_post['post_category'] = array($this->ucan_options['uCan_Default_Category'], $_POST['ucan_submission_category']);
      else
        $ucan_new_post['post_category'] = array($this->ucan_options['uCan_Default_Category']);

      if($this->ucan_options['uCan_Allow_Author'] && $user_ID)
        $ucan_new_post['post_author'] = $user_ID;
      else
        $ucan_new_post['post_author'] = $this->ucan_options['uCan_Default_Author'];

      if($this->ucan_options['uCan_Allow_Tags'])
        $ucan_new_post['tags_input'] = $this->ucan_options['uCan_Default_Tags'].', '.stripslashes($_POST['ucan_submission_tags']);
      else
        $ucan_new_post['tags_input'] = $this->ucan_options['uCan_Default_Tags'];
  
      if($this->ucan_options['uCan_Allow_Comments'])
        $ucan_new_post['comment_status'] = 'open';
      else
        $ucan_new_post['comment_status'] = 'closed';
  
      if($this->ucan_options['uCan_Allow_Pings'])
        $ucan_new_post['ping_status'] = 'open';
      else
        $ucan_new_post['ping_status'] = 'closed';

      if($this->ucan_options['uCan_Moderate_Posts'])
        $ucan_new_post['post_status'] = 'pending';
      else
        $ucan_new_post['post_status'] = 'publish';

      return $ucan_new_post;
    }

    function uCan_Add_DB_Submission($postid)
    {
      global $wpdb, $user_ID;

      if($user_ID)
        $user_info = get_userdata($user_ID);

      $type = 'guest';
      if($user_ID)
        $type = 'member';

      $name = $wpdb->escape(stripslashes($_POST['ucan_submission_guest_name']));
      if($user_ID)
        if(!empty($user_info->first_name) || !empty($user_info->last_name))
          $name = $user_info->first_name.' '.$user_info->last_name;
        else
          $name = $user_info->user_login;

      $email = $wpdb->escape(stripslashes($_POST['ucan_submission_guest_email']));
      if($user_ID)
        $email = $user_info->user_email;

      $wpdb->query($wpdb->prepare("INSERT INTO {$this->ucan_db_submissions} (`type`, `name`, `email`, `postid`) VALUES ('{$type}', '{$name}', '{$email}', '{$postid}')"));
    }

    function uCan_Get_All_Submissions()
    {
      global $wpdb;

      return $wpdb->get_results($wpdb->prepare("SELECT * FROM {$this->ucan_db_submissions} ORDER BY `id` DESC"));
    }

    function uCan_Delete_Submission($id)
    {
      global $wpdb;

      $wpdb->query($wpdb->prepare("DELETE FROM {$this->ucan_db_submissions} WHERE `postid` = {$id}"));
    }


/************************UPDATE POST************************/
    //Shows the edit post form
    function uCan_Display_Edit_Post()
    {
      global $user_ID;
      $pid = $_GET['pid'];
      if($pid && $user_ID && $this->ucan_options['uCan_Allow_Author_Edits']) //$user_ID and options check here makes sure guest hackers cannot edit posts
      {
        $post = get_post($pid);
          require($this->ucan_views_dir.'ucan-edit-post-form.php');
      }
      else
      {
        require($this->ucan_views_dir.'ucan-unknown-error.php');
      }
    }

    //Updates the post if all checks out ok and notifies user if successful
    function uCan_Display_Update_Post()
    {
      $post = array();
      $postid = 0;
      $post['ID'] = $_GET['eid'];
      $post['post_title'] = stripslashes($_POST['ucan_submission_title']);
      $post['post_content'] = stripslashes($_POST['ucan_submission_content']);
      $post['post_excerpt'] = stripslashes($_POST['ucan_submission_excerpt']);

      if(!empty($post['post_title']) && !empty($post['post_content'])) //Make sure title and content aren't left blank
        $postid = wp_update_post($post);

      if($postid)
        require($this->ucan_views_dir.'ucan-updated-post.php');
      else
        require($this->ucan_views_dir.'ucan-unknown-error.php');
    }

    //Displays an edit link at the bottom of the posts if the user is the same as the author
    function uCan_Add_Edit_Post_Link($text)
    {
      global $user_ID;
      $this->uCan_Set_Links();

      $pid = get_the_ID();
      $puid = get_the_author_ID();
      $edit = "<a href='".$this->ucan_action_url."editpost&pid=".$pid."'>".__('Edit your submission', 'ucan-post')."</a>";

      if(!$this->ucan_options['uCan_Allow_Author_Edits'] || $user_ID != $puid || is_page())
        return $text;

      return $text."<br/>".$edit;
    }


/************************FORM DISPLAY***********************/
    //Display the post submission form
    function uCan_Display_Form()
    {
      global $user_ID;

      $categories = $this->uCan_Get_Categories();
      require($this->ucan_views_dir.'ucan-submission-form.php');
    }


/**********************PREVIEW DISPLAY**********************
    //Display a preview of the post before submitting it
    function uCan_Display_Preview()
    {
      $categories = $this->uCan_Get_Categories();
      $errors = $this->uCan_Validate_Submission();

      if(empty($errors))
      {
        require($this->ucan_views_dir.'ucan-preview.php');
        require($this->ucan_views_dir.'ucan-submission-form.php');
      }
      else
      {
        require($this->ucan_views_dir.'ucan-errors.php');
        require($this->ucan_views_dir.'ucan-submission-form.php');
      }
    }
*/


/********************MAIN DISPLAY CONTROL*******************/
    //Display the proper page content
    function uCan_Display()
    {
      global $user_level;
      $out = "";
      $logorreg = ' <a href="'.get_option('siteurl').'/wp-login.php?action=login'.'">'.__('login', 'ucan-post').'</a> '.__('or', 'ucan-post').' <a href="'.get_option('siteurl').'/wp-login.php?action=register'.'">'.__('register', 'ucan-post').'</a>.';
      
      $this->uCan_Set_Links(); //This pretty much sets all the links/directories up
      ob_start();

      if(current_user_can('level_'.$this->ucan_options['uCan_Post_Level']) || $this->ucan_options['uCan_Post_Level'] == 'guest')
        switch($_GET['ucanaction'])
        {
          /*case 'ucanpreview':
            $this->uCan_Display_Preview();
            break;*/
          case 'ucanpublish':
            $this->uCan_Display_Publish();
            break;
          /*case 'ucannojs':
            $out .= "<strong>".__('Your browser does not support JavaScript', 'ucan-post')."</strong>";
            break;*/
          case 'editpost':
            $this->uCan_Display_Edit_Post();
            break;
          case 'updatepost':
            $this->uCan_Display_Update_Post();
            break;
          default:
            $this->uCan_Display_Form();
            break;
        }
      else
        echo "<p><strong>".__('Only registered users have permission to view this form. Please', 'ucan-post').$logorreg."</strong></p>";
        
      $out = ob_get_contents();
      ob_end_clean();

      return $out;
    }


/***********************MISC FUNCTIONS**********************/
    //Get all user ID's and user login's
    function uCan_Get_All_Users()
    {
      global $wpdb;
      return $wpdb->get_results($wpdb->prepare("SELECT user_login, ID FROM {$wpdb->users} ORDER BY user_login ASC"));
    }

    //Get all post categories whether empty or not
    function uCan_Get_Categories()
    {
      $args = array('type'          => $this->ucan_options['uCan_Post_Type'], /*TODO*/
                    'hide_empty'    => 0,
                    'exclude'       => $this->ucan_options['uCan_Exclude_Categories']
      );
      return get_categories($args);
    }

    //Email the admin when a new post is submitted -- maybe
    function uCan_Maybe_Email_Admin($link)
    {
      if ($this->ucan_options['uCan_Email_Admin'])
      {
        $sendername = get_option('blogname');
        $sendermail = get_option('admin_email'); //Both to and from
        $headers = "MIME-Version: 1.0\r\n" .
          "From: ".$sendername." "."<".$sendermail.">\n" . 
          "Content-Type: text/HTML; charset=\"" . get_settings('blog_charset') . "\"\r\n";
        $mailMessage = '<p>'.__('A new post has been submitted on your site. Follow the link below to view it. Do not forget to Publish the post if you are moderating new submissions.', 'ucan-post').'<br/><a href="'.$link.'"><strong>'.__('View Submission', 'ucan-post').'</strong></a></p>';
        if(!empty($sendermail))
          wp_mail($sendermail, __('New Post Submission', 'ucan-post'), $mailMessage, $headers);
			}
		}

    //Email the user when their post is published
    function uCan_Maybe_Email_User($pid, $tomail)
    {
      if ($this->ucan_options['uCan_Email_User'])
      {
        $link = get_permalink($pid);
        $sendername = get_option('blogname');
        $frommail = get_option('admin_email');
        $headers = "MIME-Version: 1.0\r\n" .
          "From: ".$sendername." "."<".$frommail.">\n" . 
          "Content-Type: text/HTML; charset=\"" . get_settings('blog_charset') . "\"\r\n";
        $mailMessage = '<p>'.__('Your post was published. Follow the link below to view it.', 'ucan-post').'<br/><a href="'.$link.'"><strong>'.__('View Submission', 'ucan-post').'</strong></a></p>';
        if(!empty($tomail) && !empty($frommail))
          wp_mail($tomail, __('Post Published', 'ucan-post'), $mailMessage, $headers);
			}
		}

    //Validates the guests email address to make sure it's semi-valid
    function uCan_Validate_Email_Address($input)
    {
      $atom = '[a-zA-Z0-9!#$%&\'*+\-\/=?^_`{|}~]+';
      $quoted_string = '"([\x1-\x9\xB\xC\xE-\x21\x23-\x5B\x5D-\x7F]|\x5C[\x1-\x9\xB\xC\xE-\x7F])*"';
      $word = "$atom(\.$atom)*";
      $domain = "$atom(\.$atom)+";
      return strlen($input) < 256 && preg_match("/^($word|$quoted_string)@${domain}\$/", $input);
    }

    /*This will autoembed things like Youtube videos into the posts
    function uCan_Auto_Embed($string)
    {
      global $wp_embed;

      if (is_object($wp_embed))
        return $wp_embed->autoembed($string);
      else
        return $string;
    }*/

  } //END CLASS
} //END IF
?>