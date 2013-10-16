<p>
  <strong style="font-size:18px;color:blue;">
    <?php echo __('Congratulations, your post was successfully updated', 'ucan-post'); ?>
  </strong>
</p>

<?php
    $maybe_view_new_post = '<a href="'.get_permalink($postid).'">'.__('View The Post', 'ucan-post').'</a> | ';
?>

<p>
  <?php echo __('What would you like to do next?', 'ucan-post'); ?><br/>
  <?php echo $maybe_view_new_post; ?><a href="<?php echo get_option('home'); ?>"><?php echo __('Visit Home Page', 'ucan-post'); ?></a> | <a href="<?php echo $this->ucan_page_url; ?>"><?php echo __('Create A New Post', 'ucan-post'); ?></a>
</p>