<div class="wrap">
  <h2><img src="<?php echo $this->ucan_images_url.'admin_submissions.png'; ?>" style="vertical-align:middle;" /> <?php echo __('uCan Post -- Submissions', 'ucan-post'); ?></h2>

  <table class="widefat">
    <thead>
      <tr>
        <th width="50%"><?php echo __('Submissions', 'ucan-post'); ?></th>
        <th width="20%"><?php echo __('Submitter Name', 'ucan-post'); ?></th>
        <th width="20%"><?php echo __('Submitter Email', 'ucan-post'); ?></th>
        <th width="10%"><?php echo __('Type', 'ucan-post'); ?></th>
      </tr>
    </thead>
    <tbody>
  <?php
        if(!empty($submissions))
          foreach($submissions as $submission)
          {
            $post_info = get_post($submission->postid);
            $link = get_permalink($submission->postid);

            if(!empty($link))
            {
  ?>
            <tr>
              <td>
                <strong><a href="<?php echo $link; ?>" target="_blank"><?php echo $post_info->post_title; ?></strong></a> (<?php echo $post_info->post_status; ?>)
                <div class="row-actions">
                  <a href="<?php echo $link; ?>"><?php echo __('View', 'ucan-post'); ?></a> |
                  <a href="<?php echo $ucan_wp_admin_url.'post.php?post='.$submission->postid.'&action=edit'; ?>"><?php echo __('Edit', 'ucan-post'); ?></a>
  <?php
                  if($post_info->post_status == 'pending')
                    echo ' | <a href="'.'admin.php?page=ucansubmissions&ucanaction=publish&pid='.$submission->postid.'&tomail='.urlencode($submission->email).'">'.__('Publish', 'ucan-post').'</a>';
  ?>
                </div>
              </td>
              <td><?php echo $submission->name; ?></td>
              <td><a href="mailto:<?php echo $submission->email; ?>"><?php echo $submission->email; ?></a></td>
              <td><?php echo $submission->type; ?></td>
            </tr>
  <?php
            }
            else
              $this->uCan_Delete_Submission($submission->postid);
          }
        else
        {
          echo '<tr><td colspan="4"><strong>'.__('No submissions have been made', 'ucan-post').'</strong></td></tr>';
        }
  ?>
    </tbody>
  </table>
</div>