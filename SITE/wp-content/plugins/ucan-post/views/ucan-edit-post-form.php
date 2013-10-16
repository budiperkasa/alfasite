<div id="ucan_stylized">
<form method="post" name="ucan_update_post_form" action="<?php echo $this->ucan_action_url.'updatepost&eid='.$post->ID; ?>">

  <!-- START TITLE -->
  <label>
    <?php echo __('Post Title', 'ucan-post'); ?>:
    <span class="small"><?php echo __('(required)', 'ucan-post'); ?></span>
  </label>
  <input type="text" name="ucan_submission_title" value="<?php echo $post->post_title; ?>" />
  <!-- END TITLE -->

  <!-- START EXCERPT -->
  <?php
    if($this->ucan_options['uCan_Show_Excerpt'])
    {
  ?>
      <label>
        <?php echo __('Post Excerpt', 'ucan-post'); ?>:
      </label>
      <textarea name="ucan_submission_excerpt" rows="3"><?php echo $post->post_excerpt; ?></textarea>
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
  <textarea name="ucan_submission_content" class="theEditor" rows="15"><?php echo $post->post_content; ?></textarea>
  <!-- END CONTENT -->

  <!-- START SUBMIT -->
  <label>
    <?php echo __('Click Update below to submit your changes', 'ucan-post'); ?>
  </label>
  <!--<input type="submit" name="ucan_submission" onClick="document.ucan_submission_form.action='<?php //echo $this->ucan_action_url.'ucanpreview'; ?>';this.disabled=true;this.form.submit();" value="<?php //echo __('Preview', 'ucan-post'); ?>" />-->

  <input type="submit" name="ucan_update_post" onClick="this.disabled=true;this.form.submit();" value="<?php echo __('Update', 'ucan-post'); ?>" />
  <!-- END SUBMIT  -->

</form>
</div>