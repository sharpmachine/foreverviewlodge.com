<div class="share_com">
   <div class="article_footer_t"></div>
   <div class="article_footer">
      <div id="form_prev_holder">
         <div id="form_holder"> 

<!-- -->

            <div class="header"><?php echo __('', LANGUAGE_ZONE); ?></div>

            <?php
               if (isset($_POST['send_contacts']) && $_POST['send_contacts'])
                  echo __('Your message has been sent.', LANGUAGE_ZONE);
               else
               {
            ?>

            <form method="post" action="<?php echo htmlspecialchars("http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]); ?>" name="order_form" id="order_form" class="uniform ajax"> 
            <script>document.write('<'+'in'+'pu'+'t na'+'me="se'+'nd_'+'f" ty'+'pe="hi'+'dden'+'" id="se'+'nd_f" v'+'alu'+'e="'+'send_f" /'+'>');</script> 
            <input type="hidden" name="send_contacts" value="1" />
            <div class="i_h"><div class="l"><input type="text" name="f_name" placeholder="Your name" id="name" class="validate[required]" title="Your name"></div></div> 
            <div class="i_h"><div class="r"><input type="text" name="f_email" placeholder="E-mail" id="f_email2" class="validate[required,custom[email]]" title="E-mail"></div></div>
            <div class="t_h"><textarea placeholder="Message" cols="40" rows="8"  name="f_comment" id="comment" class="validate[required]"></textarea></div>
            <a href="#" class="cont_butt go_submit go_button">
               <span>
                  <i></i>
                  <?php echo __('Submit', LANGUAGE_ZONE); ?>
               </span>
            </a>                 
            <a href="#" class="do_clear"><?php echo __('Clear', LANGUAGE_ZONE); ?></a> 
            </form> 
            
            <?php
               }
            ?>
        
<!-- -->

         </div>
      </div>
   </div>            
   <div class="article_footer_b"></div>
</div> 

