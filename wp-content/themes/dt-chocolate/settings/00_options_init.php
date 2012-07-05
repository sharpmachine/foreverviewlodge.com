<?php

   global $options, $theme_defaults;
   
   $options = get_option(LANGUAGE_ZONE.'_theme_options');
   
   $theme_defaults = array(
      "bg1_repeat_x" => 1,
      "bg1_repeat_y" => 1,
      "bg2_repeat_x" => 1,
      "bg2_repeat_y" => 1,
      "bgcolor1" => "#c7bfac",
      "bg1" => "/preset/bg1/default.png",
      "bg2" => "/preset/bg2/default.png",
      "font" => "crimson",
      "cufon_enabled" => 1,
      "menu_cl" => 1,
   );
   
   foreach ($theme_defaults as $k=>$v)
   {
      if ( !isset($options[$k]) )
         $options[$k] = $v;
   }
   
   //$options = array();
   
   update_option(LANGUAGE_ZONE.'_theme_options', $options);