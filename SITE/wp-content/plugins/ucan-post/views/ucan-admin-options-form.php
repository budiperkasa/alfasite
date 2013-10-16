<div class="wrap">
  <h2><img src="<?php echo $this->ucan_images_url.'admin_options.png'; ?>" style="vertical-align:middle;" /> <?php echo __('uCan Post -- Admin Options', 'ucan-post'); ?></h2>
  <form method='post' action=''>
    <table class='widefat'>
      <thead>
        <tr>
          <th width='50%'><?php echo __('Setting', 'ucan-post'); ?></th>
          <th width='50%'><?php echo __('Value', 'ucan-post'); ?></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><?php echo __('User Level required to create posts:', 'ucan-post'); ?></td>
          <td>
            <select name="ucan_post_level">
              <option value="guest" <?php if($this->ucan_options['uCan_Post_Level'] == 'guest'){echo 'selected="selected"';} ?>><?php echo __('Guest', 'ucan-post'); ?>&nbsp;&nbsp;</option>
              <option value="0" <?php if($this->ucan_options['uCan_Post_Level'] == '0'){echo 'selected="selected"';} ?>><?php echo __('Subscriber', 'ucan-post'); ?>&nbsp;&nbsp;</option>
              <option value="1" <?php if($this->ucan_options['uCan_Post_Level'] == '1'){echo 'selected="selected"';} ?>><?php echo __('Contributor', 'ucan-post'); ?>&nbsp;&nbsp;</option>
              <option value="2" <?php if($this->ucan_options['uCan_Post_Level'] == '2'){echo 'selected="selected"';} ?>><?php echo __('Author', 'ucan-post'); ?>&nbsp;&nbsp;</option>
              <option value="5" <?php if($this->ucan_options['uCan_Post_Level'] == '5'){echo 'selected="selected"';} ?>><?php echo __('Editor', 'ucan-post'); ?>&nbsp;&nbsp;</option>
              <option value="8" <?php if($this->ucan_options['uCan_Post_Level'] == '8'){echo 'selected="selected"';} ?>><?php echo __('Administrator', 'ucan-post'); ?>&nbsp;&nbsp;</option>
            </select>
            <em><?php echo __('(Default = Subscriber)', 'ucan-post'); ?></em>
          </td>
        </tr>

        <tr>
          <td><?php echo __('Use WYSIWYG Editor:', 'ucan-post'); ?><br/>
            <small><?php echo __('Disabling the editor also disables media uploads', 'ucan-post'); ?></small>
          </td>
          <td>
            <input type="checkbox" name="ucan_use_wysiwyg" value="true" <?php if($this->ucan_options['uCan_Use_WYSIWYG']){echo 'checked="checked"';} ?> />
            <em><?php echo __('(Default = True)', 'ucan-post'); ?></em>
          </td>
        </tr>

        <tr>
          <td><?php echo __('Allow submitter to select the post category:', 'ucan-post'); ?></td>
          <td>
            <input type="checkbox" name="ucan_show_categories" value="true" <?php if($this->ucan_options['uCan_Show_Categories']){echo 'checked="checked"';} ?> />
            <em><?php echo __('(Default = False)', 'ucan-post'); ?></em>
          </td>
        </tr>

        <tr>
          <td><?php echo __('Default Category for submitted posts:', 'ucan-post'); ?></td>
          <td>
            <select name="ucan_default_category">
              <?php
                foreach($categories as $category)
                  if($category->cat_ID == $this->ucan_options['uCan_Default_Category'])
                    echo '<option value="'.$category->cat_ID.'" selected="selected">'.$category->name.'&nbsp;&nbsp;</option>';
                  else
                    echo '<option value="'.$category->cat_ID.'"">'.$category->name.'&nbsp;&nbsp;</option>';
              ?>
            </select>
            <em><?php echo __('(Default = Uncategorized)', 'ucan-post'); ?></em>
          </td>
        </tr>

        <tr>
          <td><?php echo __('Category ID\'s to exclude from users:', 'ucan-post'); ?><br/>
            <small><?php echo __('Use a comma separated list of ID\'s (EX: 0, 5, 9, ...)', 'ucan-post'); ?></small>
          </td>
          <td>
            <input type="text" name="ucan_exclude_categories" value="<?php echo $this->ucan_options['uCan_Exclude_Categories']; ?>" />
            <em><?php echo __('(Default = None)', 'ucan-post'); ?></em>
          </td>
        </tr>

        <tr>
          <td><?php echo __('Set the Post Author to the name of the User who submitted it:', 'ucan-post'); ?></td>
          <td>
            <input type="checkbox" name="ucan_allow_author" value="true" <?php if($this->ucan_options['uCan_Allow_Author']){echo 'checked="checked"';} ?> />
            <em><?php echo __('(Default = True)', 'ucan-post'); ?></em>
          </td>
        </tr>

        <tr>
          <td><?php echo __('Default Author for submitted posts:', 'ucan-post'); ?><br/>
            <small><?php echo __('If the above option is selected this option will only be used for guest submissions', 'ucan-post'); ?></small>
          </td>
          <td>
            <select name="ucan_default_author">
              <?php
                foreach($users as $user)
                  if($user->ID == $this->ucan_options['uCan_Default_Author'])
                    echo '<option value="'.$user->ID.'" selected="selected">'.$user->user_login.'&nbsp;&nbsp;</option>';
                  else
                    echo '<option value="'.$user->ID.'"">'.$user->user_login.'&nbsp;&nbsp;</option>';
              ?>
            </select>
            <em><?php echo __('(Default = admin)', 'ucan-post'); ?></em>
          </td>
        </tr>

        <tr>
          <td><?php echo __('Allow users to edit their own posts:', 'ucan-post'); ?><br/>
            <small><?php echo __('Above option must be enabled for this to work', 'ucan-post'); ?></small>
          </td>
          <td>
            <input type="checkbox" name="ucan_allow_author_edits" value="true" <?php if($this->ucan_options['uCan_Allow_Author_Edits']){echo 'checked="checked"';} ?> />
            <em><?php echo __('(Default = False)', 'ucan-post'); ?></em>
          </td>
        </tr>

        <tr>
          <td><?php echo __('Append Guest name to post:', 'ucan-post'); ?><br/>
            <small><?php echo __('Adds guests name to the bottom of the submission', 'ucan-post'); ?></small>
          </td>
          <td>
            <input type="checkbox" name="ucan_append_guest_name" value="true" <?php if($this->ucan_options['uCan_Append_Guest_Name']){echo 'checked="checked"';} ?> />
            <em><?php echo __('(Default = True)', 'ucan-post'); ?></em>
          </td>
        </tr>

        <tr>
          <td><?php echo __('Allow submitter to enter post tags:', 'ucan-post'); ?></td>
          <td>
            <input type="checkbox" name="ucan_allow_tags" value="true" <?php if($this->ucan_options['uCan_Allow_Tags']){echo 'checked="checked"';} ?> />
            <em><?php echo __('(Default = False)', 'ucan-post'); ?></em>
          </td>
        </tr>

        <tr>
          <td><?php echo __('Default tags to use for submissions:', 'ucan-post'); ?><br/>
            <small><?php echo __('Use a comma separated list (EX: pizza, rice, olives, ...)', 'ucan-post'); ?></small>
          </td>
          <td>
            <input type="text" name="ucan_default_tags" value="<?php echo $this->ucan_options['uCan_Default_Tags']; ?>" />
            <em><?php echo __('(Default = None)', 'ucan-post'); ?></em>
          </td>
        </tr>

        <tr>
          <td><?php echo __('Allow submitter to create a post excerpt:', 'ucan-post'); ?></td>
          <td>
            <input type="checkbox" name="ucan_show_excerpt" value="true" <?php if($this->ucan_options['uCan_Show_Excerpt']){echo 'checked="checked"';} ?> />
            <em><?php echo __('(Default = False)', 'ucan-post'); ?></em>
          </td>
        </tr>

        <tr>
          <td><?php echo __('Allow comments on submitted posts:', 'ucan-post'); ?></td>
          <td>
            <input type="checkbox" name="ucan_allow_comments" value="true" <?php if($this->ucan_options['uCan_Allow_Comments']){echo 'checked="checked"';} ?> />
            <em><?php echo __('(Default = True)', 'ucan-post'); ?></em>
          </td>
        </tr>

        <tr>
          <td><?php echo __('Allow Trackbacks/Pingbacks on submitted posts:', 'ucan-post'); ?></td>
          <td>
            <input type="checkbox" name="ucan_allow_pings" value="true" <?php if($this->ucan_options['uCan_Allow_Pings']){echo 'checked="checked"';} ?> />
            <em><?php echo __('(Default = True)', 'ucan-post'); ?></em>
          </td>
        </tr>

        <tr>
          <td><?php echo __('Moderate new posts:', 'ucan-post'); ?></td>
          <td>
            <input type="checkbox" name="ucan_moderate_posts" value="true" <?php if($this->ucan_options['uCan_Moderate_Posts']){echo 'checked="checked"';} ?> />
            <em><?php echo __('(Default = True)', 'ucan-post'); ?></em>
          </td>
        </tr>

        <tr>
          <td><?php echo __('Allow uploads on sumbission:', 'ucan-post'); ?><br/>
            <small><?php echo __('NOTE: For security reasons, only registered members can upload files', 'ucan-post'); ?></small>
          </td>
          <td>
            <input type="checkbox" name="ucan_allow_uploads" value="true" <?php if($this->ucan_options['uCan_Allow_Uploads']){echo 'checked="checked"';} ?> />
            <em><?php echo __('(Default = True)', 'ucan-post'); ?></em>
          </td>
        </tr>

        <tr>
          <td><?php echo __('Force uploads javascript:', 'ucan-post'); ?><br/>
            <small><?php echo __('NOTE: Leave this off unless you have problems with the media uploader', 'ucan-post'); ?></small>
          </td>
          <td>
            <input type="checkbox" name="ucan_force_js" value="true" <?php if($this->ucan_options['uCan_Force_JS']){echo 'checked="checked"';} ?> />
            <em><?php echo __('(Default = False)', 'ucan-post'); ?></em>
          </td>
        </tr>

        <tr>
          <td><?php echo __('Show CAPTCHA image:', 'ucan-post'); ?><br/>
            <small><?php echo __('If you are allowing guests to post, it is recommended that you enable this', 'ucan-post'); ?></small>
          </td>
          <td>
            <input type="checkbox" name="ucan_show_captcha" value="true" <?php if($this->ucan_options['uCan_Show_Captcha']){echo 'checked="checked"';} ?> />
            <em><?php echo __('(Default = False)', 'ucan-post'); ?></em>
          </td>
        </tr>

        <tr>
          <td><?php echo __('Recieve an Email when a new post is submitted:', 'ucan-post'); ?></td>
          <td>
            <input type="checkbox" name="ucan_email_admin" value="true" <?php if($this->ucan_options['uCan_Email_Admin']){echo 'checked="checked"';} ?> />
            <em><?php echo __('(Default = True)', 'ucan-post'); ?></em>
          </td>
        </tr>

        <tr>
          <td><?php echo __('Email User When Their Submission Is Approved:', 'ucan-post'); ?><br/>
            <small><?php echo __('For this to work you must approve the post through the submissions area of this plugin', 'ucan-post'); ?></small>
          </td>
          <td>
            <input type="checkbox" name="ucan_email_user" value="true" <?php if($this->ucan_options['uCan_Email_User']){echo 'checked="checked"';} ?> />
            <em><?php echo __('(Default = False)', 'ucan-post'); ?></em>
          </td>
        </tr>

        <tr>
          <td colspan="2">
            <span>
              <input class="button" type="submit" name="ucan_save_admin_options" value="<?php echo __('Save Options', 'ucan-post'); ?>" />
            </span>
          </td>
        </tr>
      </tbody>
    </table>
  </form>
  <p><strong><?php echo __('uCan Post -- Setup Instructions', 'ucan-post'); ?>:</strong></p>
  <p>
    <ul>
      <li><?php echo __('Create a new page (this is the page where your users will submit posts from)', 'ucan-post'); ?></li>
      <li><?php echo __('Paste', 'ucan-post')."<font color='blue'> [uCan-Post] </font>".__('under the HTML tab of the page editor', 'ucan-post'); ?></li>
      <li><?php echo __('Publish the page', 'ucan-post'); ?></li>
      <li><?php echo __('Setup your admin settings the way you wish and save', 'ucan-post'); ?></li>
      <li><?php echo __('Done! Pretty easy eh?', 'ucan-post'); ?></li>
    </ul>
  </p>
</div>