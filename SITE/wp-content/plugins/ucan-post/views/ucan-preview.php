<br/>
<p style="margin-bottom:0;padding-bottom:0;">
  <strong style="font-size:24px;color:#333;"><?php echo __('Post Preview Area' , 'ucan-post'); ?></strong><br/>
  <small style="color:#333;"><?php echo __('You can continue editing below the preview area', 'ucan-post'); ?></small>
</p>
<div style="border:1px solid #333;width:98%;padding:3px;">
  <?php
    echo '<h2>'.stripslashes($_POST['ucan_submission_title']).'</h2>';
    echo stripslashes($_POST['ucan_submission_content']);
  ?>
</div>
<br/>