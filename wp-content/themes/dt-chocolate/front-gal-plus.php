<?php
$box_name = 'homeslider';
$images = array();
$options = get_post_meta( $post->ID, 'dt_'.$box_name.'_options', true );
$arr = $options['show_'. $box_name. '_'. $options['show']];
$args = array(
	'post_type' 		=>'attachment', 
	'post_mime_type'	=>'image',
	'post_status' 		=>'inherit',
	'orderby'			=>'menu_order',
	'posts_per_page'	=>-1
);
$query_str = sprintf( 'SELECT `ID` FROM %s WHERE `post_type`="%s"', $wpdb->posts, 'main_slider' );
if ( is_array($arr) ) {
	$query_str .= ' AND ID';
	if ( 'except' == $options['show'] ) {
		$query_str .= ' NOT';
	}
	$query_str .= sprintf( ' IN(%s)', implode( ',', $arr ) );
}
// send query to filter
dt_parent_where_query( $query_str );

add_filter( 'posts_where' , 'dt_posts_parents_where' );
$slides = new Wp_Query( $args );
remove_filter( 'posts_where' , 'dt_posts_parents_where' );

// process images
foreach( $slides->posts as $slide ) {
	$image = wp_get_attachment_image_src($slide->ID, 'large');
	$tmp_src = explode($_SERVER['SERVER_NAME'], $image[0]);
	$tmp_src = isset($tmp_src[1])?$tmp_src[1]:$image[0];
	$small_image = esc_attr(get_template_directory_uri()."/thumb.php?src={$tmp_src}&w=102&h=62zc=1");
	
	$images[] = array(
        "orig_image"		=> $image,
        "small_image"		=> esc_attr($small_image)
    );
}
?>


<!-- For the greate [justice] example -->
<script type="text/javascript">
	slideshow_timeout_sec = <?php echo intval($options['dt_interval']); ?>;
</script>

<ul id="big-image">
<?php
   $reverse = $images;
   $reverse = array_reverse($reverse);
   foreach ($reverse as $image)
   {
   ?>
      <li><img src="<?php echo $image['orig_image'][0]; ?>" alt="<?php echo $image['orig_image'][1]; ?>|<?php echo $image['orig_image'][2]; ?>" title="" /></li>
   <?php
   }
?>
</ul>

<?php if( !$options['dt_hide_over_mask'] ): ?>
<div id="big-mask-sl"></div>
<?php endif; ?>

<div id="big-mask-sl_b"></div>

<div id="slider">
  <div>
    <ul>
      <?php
         foreach ($images as $image)
         {
         ?>
            <li><a href="#"><img src="<?php echo $image['small_image']; ?>" width="102" height="62" alt="" /><i></i></a></li>
         <?php
         }
      ?>
    </ul>
  </div>
</div>

<div id="slider_controls">
  <div>
    <ul>
      <li><a href="#"><img src="<?php echo $images[0]['small_image']; ?>" alt="" width="102" height="62" /></a></li>
    </ul>
    <a href="#" id="control_play"></a>
    <a href="#" id="control_pause"></a>
    <a href="#" id="control_f"></a>
    <a href="#" id="control_b"></a>
  </div>
</div>