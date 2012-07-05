<?php
/**
 * @package WordPress
 * @subpackage Chocolate
 */ 
global $options;
?><!DOCTYPE html>
<html <?php language_attributes(); ?> style="<?php
	$img = get_template_directory_uri().get_demo_option('bg1');
	if(!DEMO && $options['custom_bg1']) {
		//$img = '/cache/'.$options['custom_bg1'];
		$up_dir = wp_upload_dir();
		$dir = $up_dir['baseurl'].'/dt_uploads/';
		$img = $dir.$options['custom_bg1'];
	}
	
   echo 'background-color: '.get_demo_option('bgcolor1').'; ';
   //echo 'background-image: url('.get_template_directory_uri().$img.'); ';
   echo 'background-image: url('.$img.'); ';
   if (get_demo_option('bg1_repeat_x') && get_demo_option('bg1_repeat_y')) 
      echo 'background-repeat: repeat; ';
   elseif (get_demo_option('bg1_repeat_x')) 
      echo 'background-repeat: repeat-x; ';
   elseif (get_demo_option('bg1_repeat_y')) 
      echo 'background-repeat: repeat-y; ';
   else
      echo 'background-repeat: no-repeat; ';
   if (get_demo_option('bg1_fixed')) 
      echo 'background-attachment: fixed; ';
   if (get_demo_option('bg1_center')) 
      echo 'background-position: center 0; ';
?>">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php bloginfo('name'); ?> <?php wp_title( '|', true, 'left' ); ?></title>
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php
   get_template_part( 'header' , 'dt' );
?>

<?php wp_head(); ?>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.easing.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/cufon-yui.js"></script>

<?php if ($options['cufon_enabled']): ?>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/fonts/<?php echo get_demo_option('font'); ?>.font.js"></script>
<script type="text/javascript">
Cufon('#nav > li > a', {
  color: '-linear-gradient(#f5f2eb, 0.5=#f5f2eb, 0.8=#acaaa4, #acaaa4)', textShadow: '-1px -1px #000'/*,
  hover: {
	color: '-linear-gradient(#aba197, 0.5=#aba197, 0.8=#887d72, #887d72)', textShadow: '-1px -1px #000'
  }*/
});
Cufon('#nav > li.current_page_item > a, #nav > li.current-menu-item > a', {
  color: '-linear-gradient(#aba197, 0.5=#aba197, 0.8=#887d72, #887d72)', textShadow: '-1px -1px #000'
});

$(document).ready(function () {
   var _n = 0;
   $('.nav > ul > li > a').each(function () {
      _n++;
      var idd = "a"+_n;
      var ee = $(this);
      ee.attr("id", idd);
      ee.hover(function () {
         Cufon.replace( "#"+idd , {
            color: '-linear-gradient(#aba197, 0.5=#aba197, 0.8=#887d72, #887d72)', textShadow: '-1px -1px #000'
         });
         Cufon.now();
      }, function () {
         if (
            $(this).parent().hasClass('current_page_item') ||
            $(this).parent().hasClass('current-menu-item')
         )
            return;
         Cufon.replace( "#"+idd , {
            color: '-linear-gradient(#f5f2eb, 0.5=#f5f2eb, 0.8=#acaaa4, #acaaa4)', textShadow: '-1px -1px #000'
         });
         Cufon.now();
      });
   });
});

Cufon('.widget .header, .folio_caption, .folio_just_caption', {
  fontWeight: 'bold',
  color: '-linear-gradient(#f5f2eb, 0.5=#f5f2eb, 0.8=#acaaa4, #acaaa4)', textShadow: '-1px -1px #000'
});
Cufon('._cf, .article h1, .article h2, .article h3, .article h4, .article h5, .article h6', {
  fontWeight: 'bold',
  color: '-linear-gradient(#473e2b, 0.4=#473e2b, #1c1a19)', textShadow: '0 1px #fff',
  hover: {
	color: '-linear-gradient(#60543a, 0.4=#60543a, #433e3c)', textShadow: '0 1px #fff'
  }
});
Cufon('.quote_author', {
  fontWeight: 'bold',
  color: '#221f1c', textShadow: '1px 1px #fff'
});
Cufon('.paginator li', {
  fontWeight: 'bold',
  color: '-linear-gradient(#f5f2eb, #bfbcb7)', textShadow: '-1px -1px #000'
});
Cufon('.paginator li.act', {
  fontWeight: 'bold',
  color: '#857d74', textShadow: '-1px -1px #000'
});
Cufon('.go_up', {
  fontWeight: 'bold',
  color: '-linear-gradient(#f5f2eb, #bfbcb7)', textShadow: '-1px -1px #000'
});
Cufon('.article_footer .header', {
  fontWeight: 'bold',
  color: '-linear-gradient(#f5f2eb, 0.5=#f5f2eb, 0.8=#acaaa4, #acaaa4)', textShadow: '-1px -1px #000'
});
</script>
<?php endif; ?>

<script type="text/javascript">
<?php $options = get_option(LANGUAGE_ZONE."_theme_options"); ?>
	var menu_cl=<?php echo intval($options['menu_cl']); ?>;
</script>

<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.masonry.min.js"></script>

<!-- CUSTOM -->
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/scripts.js"></script>

<?php if( defined('GAL_HOME') ): ?>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/gallery.js"></script>
<?php endif; ?>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/css/custom.css" />
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/plugins/placeholder/jquery.placeholder.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/plugins/validator/jquery.validationEngine.js"></script> 
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/plugins/validator/z.trans.en.js"></script> 
<link href="<?php echo get_template_directory_uri(); ?>/js/plugins/validator/validationEngine.jquery.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/plugins/highslide/highslide-full.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/plugins/highslide/highslide.config.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/js/plugins/highslide/highslide.css" />

<?php if( is_page_template('home-video.php') ): ?>

	<?php
	global $jwplayer_flag; 
	$jwplayer_flag = file_exists( get_template_directory().'/js/jwplayer/jwplayer.js' );
	?>

	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/home.css" />
	<?php if($jwplayer_flag): ?>
		<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jwplayer/jwplayer.js" charset="utf-8"></script>
	<?php else: ?>
		<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jplayer/jquery.jplayer.min.js" charset="utf-8"></script>
	<?php endif; ?>
	
	
<?php elseif( is_page_template('home-slider.php') ): ?>

	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/supersized.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/supersized.shutter.css" type="text/css" media="screen" />
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/supersized.3.2.5.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/supersized.shutter.js"></script>
	<?php get_template_part('home-slider_header'); ?>
	
	
<?php elseif( is_page_template('home-static.php') ): ?>

	<?php
	if( has_post_thumbnail() ) {
		$img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
	}else {
		$img[0] = get_template_directory_uri().'/images/noimage.jpg';
	}
	?>
	
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/supersized.core.3.2.1.js"></script>
	<script type="text/javascript">
		jQuery(function($){
			$.supersized({
				slides  :  	[ {image : '<?php echo $img[0]; ?>', title : '<?php the_title(); ?>'} ]
			});
		});
	</script>
	
<?php endif; ?>


<script>
	// DO NOT REMOVE!
	// b21add52a799de0d40073fd36f7d1f89
	hs.graphicsDir = '<?php echo get_template_directory_uri(); ?>/js/plugins/highslide/graphics/';
</script>
<!-- END CUSTOM -->

<!--[if lte IE 7]>
<link rel="stylesheet" type="text/css" media="all" href="css/old_ie.css" />
<![endif]-->

</head>
<?php
$class = '';
if( is_page_template('home-slider.php') ) {
	$class = 'home';
}
?>
<body <?php body_class($class); ?> style="<?php
	$img = get_template_directory_uri().get_demo_option('bg2');
	if(!DEMO && $options['custom_bg2']) {
		//$img = get_template_directory_uri().'/cache/'.$options['custom_bg2'];
		$up_dir = wp_upload_dir();
		$dir = $up_dir['baseurl'].'/dt_uploads/';
		$img = $dir.$options['custom_bg2'];
	}
	
   echo 'background-image: url('.$img.'); ';
   if (get_demo_option('bg2_repeat_x') && get_demo_option('bg2_repeat_y')) 
      echo 'background-repeat: repeat; ';
   elseif (get_demo_option('bg2_repeat_x')) 
      echo 'background-repeat: repeat-x; ';
   elseif (get_demo_option('bg2_repeat_y')) 
      echo 'background-repeat: repeat-y; ';
   else
      echo 'background-repeat: no-repeat; ';
   if (get_demo_option('bg2_fixed')) 
      echo 'background-attachment: fixed; ';
   if (get_demo_option('bg2_center')) 
      echo 'background-position: center 0; ';
?>">
<?php if(!is_page_template('home-static.php')) : ?>
	<div id="bg">
<?php endif; ?>
<?php get_template_part( 'top' ); ?>
<?php
$class = '';
if( is_page_template('home-video.php') ) {
	if( $jwplayer_flag ) {
		$class = ' class="video jw"';
	}else {
		$class = ' class="video"';
	}
}elseif( is_page_template('home-slider.php') ) {
	$class = ' class="slide"';
}elseif( is_page_template('home-static.php') ) {
	$class = ' class="static"';
}
?>
<div id="holder"<?php echo $class; ?>>