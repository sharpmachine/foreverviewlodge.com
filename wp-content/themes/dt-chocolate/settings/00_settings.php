<?php

add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' );

function theme_options_init()
{
	register_setting( LANGUAGE_ZONE.'_options', LANGUAGE_ZONE.'_theme_options', 'theme_options_validate' );
}

function theme_options_add_page()
{	
   $slug = LANGUAGE_ZONE;
   add_menu_page(THEME_TITLE, THEME_TITLE, 'manage_options', $slug, 'theme_menu_options', get_template_directory_uri().'/images/theme_icon.png', 1000);
   add_submenu_page($slug, "Appearance", "Appearance", 'manage_options', $slug, 'theme_menu_options');
   add_submenu_page($slug, "Social links", "Social links", 'manage_options', $slug.'_social', 'theme_social_options');
   add_submenu_page($slug, "Analytics", "Analytics", 'manage_options', $slug.'_analytics', 'theme_analytics_options');
}

function theme_header()
{
	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;
/*		
<script src="<?php echo get_template_directory_uri(); ?>/js/colorpicker/js/jquery.js"></script>
*/
   ?>
<script src="<?php echo get_template_directory_uri(); ?>/js/colorpicker/js/colorpicker.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/colorpicker/js/eye.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/colorpicker/js/utils.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/admin.js"></script>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/js/colorpicker/css/colorpicker.css" type="text/css" />	
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/js/colorpicker/css/style.css" type="text/css" />	
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/admin.css" type="text/css" />	

<div class="wrap">

	<?php screen_icon(); echo "<h2>" . __( THEME_TITLE.' &mdash; '.get_admin_page_title() ) . "</h2>"; ?>

	<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
	<div class="updated fade"><p><strong><?php echo __( 'Options saved', LANGUAGE_ZONE ); ?></strong></p></div>
	<?php endif; ?>

	<form method="post" action="options.php" enctype="multipart/form-data" id="f_1">
		<?php settings_fields( LANGUAGE_ZONE.'_options' ); ?>
   <?php
}

function theme_footer()
{
   ?>
	   <p class="submit">
		   <input type="submit" class="button-primary" value="<?php echo ( 'Save Options' ); ?>" />
	   </p>
   </form>
</div>
   <?php
}

function echo_u($opt)
{
	global $options;
	$up_dir = wp_upload_dir();
	$dir = $up_dir['baseurl'].'/dt_uploads/';
				 foreach ($opt as $id=>$title) {
				?>
				<tr valign="top"><th scope="row"><?php _e( $title ); ?></th>
					<td>
					   <div id="<?php echo LANGUAGE_ZONE; ?>_theme_options[<?php echo $id; ?>]_upl"<?php if ($options[$id]) echo ' style="display: none;"' ?> class="upload">
						<input id="<?php echo LANGUAGE_ZONE; ?>_theme_options[<?php echo $id; ?>]" class="regular-text" type="file" name="<?php echo LANGUAGE_ZONE; ?>_theme_options[<?php echo $id; ?>]" />
						<input id="<?php echo LANGUAGE_ZONE; ?>_theme_options[<?php echo $id; ?>]_del" type="hidden" name="<?php echo LANGUAGE_ZONE; ?>_theme_options[del_<?php echo $id; ?>]" value="0" />
						<input id="<?php echo LANGUAGE_ZONE; ?>_theme_options[<?php echo $id; ?>]_prev" type="hidden" name="<?php echo LANGUAGE_ZONE; ?>_theme_options[prev_<?php echo $id; ?>]" value="<?php echo $options[$id]; ?>" />
						<a href="#" id="<?php echo LANGUAGE_ZONE; ?>_theme_options[<?php echo $id; ?>]_cancel"<?php if (!$options[$id]) echo ' style="display: none;"' ?>>Cancel</a>
						<label class="description" for="<?php echo LANGUAGE_ZONE; ?>_theme_options[<?php echo $id; ?>]"></label>
						</div>
						<div id="<?php echo LANGUAGE_ZONE; ?>_theme_options[<?php echo $id; ?>]_ok"<?php if (!$options[$id]) echo ' style="display: none;"' ?>>
						   <a href="<?php echo $dir.$options[$id]; ?>" target="_blank">View</a> | <a href="#" id="<?php echo LANGUAGE_ZONE; ?>_theme_options[<?php echo $id; ?>]_new">Upload</a> | <a href="#" id="<?php echo LANGUAGE_ZONE; ?>_theme_options[<?php echo $id; ?>]_del">Delete</a>
						</div>
					</td>
				</tr>
				<?php }
				//echo get_template_directory_uri().'/cache/'.$options[$id];
}

function theme_options_validate( $input ) {
	
	//$dir = dirname(__FILE__).'/../cache/';
	$up_dir = wp_upload_dir();
	$dir = $up_dir['basedir'].'/dt_uploads';
	if( !file_exists($dir)) {
		@mkdir($dir);
	}
	
	foreach (array('logo', 'custom_bg1', 'custom_bg2', 'favicon') as $id)
	{
	
	   $im   = $_FILES[LANGUAGE_ZONE.'_theme_options']['tmp_name'][$id];
	   $type = $_FILES[LANGUAGE_ZONE.'_theme_options']['type'][$id];
	   
	   if ($im)
	   {
	      $type=str_replace("image/", "", $type);
	      $fname=time()."_".$id.".".$type;
	      if ( $id == "favicon" )
	         $fname = "favicon.ico";
	      $input[$id]=$fname;
	      move_uploaded_file($im, $dir.'/'.$fname);
	   }
	   else
	   {
	      if ($input['del_'.$id]) $input[$id]="";
	      else $input[$id]=$input['prev_'.$id];
	   }	   
	
	}

	if ($_POST["save_chkboxes"])
	foreach ( array(
	      'bg1_repeat_x', 'bg1_repeat_y', 'bg1_center', 'bg1_fixed',
	      'bg2_repeat_x', 'bg2_repeat_y', 'bg2_center', 'bg2_fixed',
	      'cufon_enabled', 'menu_cl', 'show_credits',
   	) as $opt )
	{
	   $input[ $opt ] = ( isset($input[ $opt ]) && $input[ $opt ] == "on" ? 1 : 0);
	}
	
   $options = get_option( LANGUAGE_ZONE.'_theme_options' );
   foreach ($options as $k=>$v)
   {
      if ( !isset($input[$k]) )
         $input[ $k ] = $v;
   }
	//var_dump($input);
	return $input;
}

//print_r( get_option(LANGUAGE_ZONE.'_theme_options') );

?>
