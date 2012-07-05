<?php

   global $current_user;
   get_currentuserinfo();
   
   ob_start();
   comment_form();
   ob_get_clean();

?>    

      <div id="share_com_top"></div>

      <div class="share_com">
        <div class="article_footer_t"></div>
        <div class="article_footer">

      <!-- start -->
 
      <div id="form_prev_holder"> 
      <div id="form_holder"> 
   
  <div id="respond">
    <div class="header">Share a comment:</div>
    
    <?php if (is_user_logged_in()) { ?>
      <small>You are currently logged in as <a href="<?php echo home_url('/').'author/'.$current_user->user_login.'/'; ?>"><?php echo $current_user->user_login; ?></a></small>
    <?php } else { ?>
    <small>Your email address will not be published. Required fields are marked <span class="required">*</span></small>
    <?php } ?>
    
    <form action="http://www.foreverviewlodge.com/cgi-sys/formmail.pl" method="post" id="commentform" class="uniform">
    
      <?php if (!is_user_logged_in()) { ?>
      
        <div class="i_h"><div class="l">
           <input id="author" name="author" type="text" aria-required='true' placeholder="<?php echo __('Name', LANGUAGE_ZONE); ?>*" class="validate[required]" value="<?php if ( isset($current_user->user_login) ) echo $current_user->user_login; ?>" />
        </div></div>
        <div class="i_h"><div class="r">
           <input id="email22" name="email" type="text" placeholder="Email*" aria-required='true' class="validate[required,custom[email]]" value="<?php  if ( isset($current_user->user_email) ) echo $current_user->user_email; ?>" />
        </div></div>
        <input type="hidden" id="url" name="url" value="<?php if ( isset($current_user->user_url) ) echo $current_user->user_url; ?>" />
        
      <?php } ?>
      
      <div class="t_h"><textarea id="comment" name="comment" class="validate[required]" aria-required="true" placeholder="<?php echo __('Comment', LANGUAGE_ZONE); ?>*"></textarea></div> 
      
     <a href="#" id="submit" class="go_button do_add_comment subm_comm go_add_comment" title="">
      <span>
         <i></i>
         <?php echo __('Add comment', LANGUAGE_ZONE); ?>
      </span>
     </a>
     <a rel="nofollow" id="cancel-comment-reply-link" href="#respond" class="do_clear"><?php echo __('Cancel', LANGUAGE_ZONE); ?></a>
     
     <?php comment_id_fields(); ?>
      
      <?php do_action('comment_form', $post->ID); ?>
      
    </form>

  </div>

   </div></div>
   
   <!-- end -->
   
        
        </div>
        <div class="article_footer_b"></div>
      </div>
