<?php

	// Include widgets/*.php
   include_files_in_dir("/widgets/");
   
   // Setup widgets output, wrapping HTML code
   
   function dt_widgets_init() {
	   global $left_block_args;
	   register_sidebar( $left_block_args=array(
		   'name' => __( 'Widget area', LANGUAGE_ZONE ),
		   'id' => 'primary-widget-area',
		   'description' => __( 'Left block', LANGUAGE_ZONE ),
		   'before_widget' => '<div class="widget">',
		   'after_widget' => '</div><div class="widget_b"></div>',
		   'before_title' => '<div class="header">',
		   'after_title' => '</div>',
	   ) );
   }
   
   add_action( 'widgets_init', 'dt_widgets_init' );

?>
