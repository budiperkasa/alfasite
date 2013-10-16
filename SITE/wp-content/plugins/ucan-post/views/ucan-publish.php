<p>
  <strong style="font-size:18px;color:blue;">
    <?php echo __('Congratulations, your post was submitted successfully!', 'ucan-post'); ?>
  </strong>
</p>

<?php
  if($this->ucan_options['uCan_Moderate_Posts'])
  {
?>
    <p>
      <strong>
        <?php echo __('Your post is awaiting moderation and should be available soon.', 'ucan-post'); ?><br/>
      </strong>
    </p>
<?php
  }
  else
    $maybe_view_new_post = '<a href="'.$new_post_permalink.'">'.__('View My Submission', 'ucan-post').'</a> | ';
?>

<p>
  <?php echo __('What would you like to do next?', 'ucan-post'); ?><br/>
  <?php echo $maybe_view_new_post; ?><a href="<?php echo get_option('home'); ?>"><?php echo __('Visit Home Page', 'ucan-post'); ?></a> | <a href="<?php echo $this->ucan_page_url; ?>"><?php echo __('Create Another Post', 'ucan-post'); ?></a>
</p>