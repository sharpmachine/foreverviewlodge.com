<?php
/**
 * @package WordPress
 * @subpackage Chocolate
 */

/* Set the content width based on the theme's design and stylesheet. */
if ( ! isset( $content_width ) )
	$content_width = 700;

/* Set up theme defaults and registers support for various WordPress features. */
if ( ! function_exists( 'dt_setup' ) ):

   function include_files_in_dir($dir, $no_more=FALSE)
   {
      $dir_init = $dir;
      $dir = dirname(__FILE__).$dir;
      
      if (!file_exists($dir))
         throw new Exception("Folder $dir does not exist");
         
      $files = array();
         
      if ($handle = opendir( $dir )) {
          while (false !== ($file = @readdir($handle))) {
              if ( is_dir( $dir.$file ) && !preg_match('/^\./', $file) && !$no_more )
              {
                 include_files_in_dir($dir_init.$file."/", TRUE);
              }
              else
              {
                 if ( preg_match('/^[^~]{1}.*\.php$/', $file) ) {
                     $files[] = $dir.$file;
                 }
              }
          }
          @closedir($handle);
      }      
      
      sort($files);
      
      foreach ($files as $file)
         include_once $file;
   }

   function dt_setup() {
	   // This theme uses post thumbnails
	   add_theme_support( 'post-thumbnails' );
	   set_post_thumbnail_size( 180, 180 ); // default Post Thumbnail dimensions   
	   add_image_size( 'dt-l-thumb', 700, 9999, false ); // Large Post Thumbnail
	   add_image_size( 'dt-m-thumb', 460, 9999, false ); // Medium Post Thumbnail
	   add_image_size( 'dt-s-thumb', 220, 9999, false ); // Small Post Thumbnail

	   // This theme styles the visual editor with editor-style.css to match the theme style.
	   add_editor_style();

	   // Add default posts and comments RSS feed links to head
	   add_theme_support( 'automatic-feed-links' );

	   // Make theme available for translation
	   // Translations can be filed in the /languages/ directory
	   load_theme_textdomain( 'dt', TEMPLATEPATH . '/languages' );
	   $locale = get_locale();
	   $locale_file = TEMPLATEPATH . "/languages/$locale.php";
	   if ( is_readable( $locale_file ) )
		   require_once( $locale_file );

	   // This theme uses wp_nav_menu() in one location.
	   add_theme_support('nav_menus');
	   register_nav_menus( array(
		   'primary' => __( 'Primary Navigation', 'dt' ),
	   ) );
	
	   // Include functions/*.php
	   include_files_in_dir("/functions/");

	   // Include settings/*.php
	   include_files_in_dir("/settings/");
	   
	   // Include plugins/*/*.php
	   include_files_in_dir("/plugins/");
   }
   
endif;

add_action( 'init', 'dt_setup' );
add_action( 'after_setup_theme', 'dt_setup' );

function dt_register_jquery() {
	if( !is_admin() ){
		wp_deregister_script('jquery');
		wp_register_script('jquery', ("https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"), false, '1.6.1');
		wp_enqueue_script('jquery');
	}
}
add_action('wp_enqueue_scripts', 'dt_register_jquery');

include( TEMPLATEPATH . '/dt-pagenavi.php')
?>
