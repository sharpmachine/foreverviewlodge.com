<?php

$area = basename(__FILE__);
$area = str_replace(".php", "", $area);

ob_start();
dynamic_sidebar( $area );
$ret=ob_get_clean();

if (!$ret)
{
   ob_start();
   $ret=array(
      // default plugins go here
      'widget_sakura_PostTypes',
      'widget_sakura_Cats',
      'widget_sakura_Twidget',
      'widget_sakura_Popular',
      'sakura_widget_quickflickr',
      'widget_sakura_Feedback'
   );
   
   global $left_block_args;
   foreach ($ret as $v)
   {
      $v($left_block_args);
      //echo '<break />';
   }
   
   $ret=ob_get_clean();
}

echo $ret;

?>
