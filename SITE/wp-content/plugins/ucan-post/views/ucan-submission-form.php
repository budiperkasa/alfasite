<div id="ucan_stylized">
<form method="post" name="ucan_submission_form" action="<?php echo $this->ucan_action_url.'ucanpublish'; ?>">

  <!-- START GUEST INFO -->
  <?php
    if($this->ucan_options['uCan_Post_Level'] == 'guest' && !$user_ID)
    {
  ?>
      <label>
        <?php echo __('Name', 'ucan-post'); ?>:
        <span class="small"><?php echo __('(required - not shown publicly)', 'ucan-post'); ?></span>
      </label>
      <input type="text" name="ucan_submission_guest_name" value="<?php echo stripslashes($_POST['ucan_submission_guest_name']); ?>" />

      <label>
        <?php echo __('Email', 'ucan-post'); ?>:
        <span class="small"><?php echo __('(required - not shown publicly)', 'ucan-post'); ?></span>
      </label>
      <input type="text" name="ucan_submission_guest_email" value="<?php echo stripslashes($_POST['ucan_submission_guest_email']); ?>" />
  <?php
    }
  ?>
  <!-- END GUEST INFO -->

  <!-- START TITLE -->
  <label>
    <?php echo __('Post Title', 'ucan-post'); ?>:
    <span class="small"><?php echo __('(required)', 'ucan-post'); ?></span>
  </label>
  <input type="text" name="ucan_submission_title" value="<?php echo stripslashes($_POST['ucan_submission_title']); ?>" />
  <!-- END TITLE -->

  <!-- START EXCERPT -->
  <?php
    if($this->ucan_options['uCan_Show_Excerpt'])
    {
  ?>
      <label>
        <?php echo __('Post Excerpt', 'ucan-post'); ?>:
      </label>
      <textarea name="ucan_submission_excerpt" rows="3"><?php echo stripslashes($_POST['ucan_submission_excerpt']); ?></textarea>
  <?php
    }
  ?>
  <!-- END EXCERPT -->

  <!-- START CONTENT -->
  <label>
    <?php echo __('Post Content', 'ucan-post'); ?>:
    <span class="small"><?php echo __('(required)', 'ucan-post'); ?></span>
  </label>
  <?php
    global $user_ID;
    if($user_ID && $this->ucan_options['uCan_Allow_Uploads'] && $this->ucan_options['uCan_Use_WYSIWYG'])
    {
      require($this->ucan_views_dir.'ucan-upload-buttons.php');
    }
  ?>
  <textarea name="ucan_submission_content" class="theEditor" rows="15"><?php echo stripslashes($_POST['ucan_submission_content']); ?></textarea>
  <!-- END CONTENT -->

  <!-- START CATEGORIES -->
  <?php
    if($this->ucan_options['uCan_Show_Categories'])
    {
  ?>
      <label>
        <?php echo __('Post Category', 'ucan-post'); ?>:
      </label>
      <select name="ucan_submission_category">
        <?php
          foreach($categories as $category)
            if($category->cat_ID == $_POST['ucan_submission_category'])
              echo '<option value="'.$category->cat_ID.'" selected="selected">'.$category->name.'&nbsp;&nbsp;</option>';
            else
              echo '<option value="'.$category->cat_ID.'"">'.$category->name.'&nbsp;&nbsp;</option>';
        ?>
      </select>
  <?php
    }
  ?>
  <!-- END CATEGORIES -->

  <!-- START TAGS -->
  <?php
    if($this->ucan_options['uCan_Allow_Tags'])
    {
  ?>
      <label>
        <?php echo __('Post Tags', 'ucan-post'); ?>:
        <span class="small"><?php echo __('(separate tags by comma)', 'ucan-post'); ?></span>
      </label>
      <input type="text" name="ucan_submission_tags" value="<?php echo stripslashes($_POST['ucan_submission_tags']); ?>" />
  <?php
    }
  ?>
  <!-- END TAGS  -->
  
  <!-- START CAPTCHA -->
  <?php
    if($this->ucan_options['uCan_Show_Captcha'])
    {
      include_once($this->ucan_plugin_dir."captcha/shared.php");
      include_once($this->ucan_plugin_dir."captcha/captcha_code.php");
      $captcha = new CaptchaCode();
      $code = ucan_str_encrypt($captcha->generateCode(6));
  ?>
      <label>
        <?php echo __('Image Verification', 'ucan-post'); ?>:
        <span class="small"><?php echo __('(required)', 'ucan-post'); ?></span>
      </label>
      <img src="<?php echo $this->ucan_plugin_url.'captcha/captcha_images.php?width=120&height=40&code='.$code; ?>" /><br/>
      <input type="text" name="ucan_show_captcha" />
      <input type="hidden" name="ucan_security_check" value="<?php echo $code; ?>">
  <?php
    }
  ?>
  <!-- END CAPTCHA -->

  <!-- START SUBMIT -->
  <label>
    <?php echo __('Click Publish below to submit your post', 'ucan-post'); ?>
  </label>
  <!--<input type="submit" name="ucan_submission" onClick="document.ucan_submission_form.action='<?php //echo $this->ucan_action_url.'ucanpreview'; ?>';this.disabled=true;this.form.submit();" value="<?php //echo __('Preview', 'ucan-post'); ?>" />-->

  <input type="submit" name="ucan_submission" onClick="this.disabled=true;this.form.submit();" value="<?php echo __('Publish', 'ucan-post'); ?>" />
  <!-- END SUBMIT  -->

</form>
</div>