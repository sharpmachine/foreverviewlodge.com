<?php
define('GAL_HOME', 1);
global $dt_options;
$box_name = 'homeslider_new';
$images = array();
$options = get_post_meta( $post->ID, 'dt_'.$box_name.'_options', true );
$dt_options = $options;
$arr = isset($options['show_'. $box_name. '_'. $options['show']])?$options['show_'. $box_name. '_'. $options['show']]:'all';
$args = array(
	'post_type' 		=>'attachment', 
	'post_mime_type'	=>'image',
	'post_status' 		=>'inherit',
	'orderby'			=>'menu_order',
	'order'				=>'ASC',
	'posts_per_page'	=>-1
);
$query_str = sprintf( 'SELECT `ID` FROM %s WHERE `post_type`="%s" AND post_status="publish"', $wpdb->posts, 'main_slider' );
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
	$title = apply_filters('the_title', $slide->post_excerpt);
	
    $images[] = <<<HDOCK
	{image : '{$image[0]}', title : '{$title}', thumb : '{$small_image}', url : ''}
HDOCK;
}
?>
<script type="text/javascript">
	jQuery(function($){
		$.supersized({

					// Functionality
					slideshow               :   1,			// Slideshow on/off
					autoplay				:	<?php echo intval($options['dt_autoplay']); ?>,			// Slideshow starts playing automatically
					start_slide             :   1,			// Start slide (0 is random)
					stop_loop				:	0,			// Pauses slideshow on last slide
					random					: 	0,			// Randomize slide order (Ignores start slide)
					slide_interval          :   <?php echo intval($options['dt_interval']); ?>,		// Length between transitions
					transition              :   <?php echo $options['dt_transition']; ?>, 			// 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
					transition_speed		:	700,		// Speed of transition
					new_window				:	1,			// Image links open in new window/tab
					pause_hover             :   0,			// Pause slideshow on hover
					keyboard_nav            :   1,			// Keyboard navigation on/off
					performance				:	1,			// 0-Normal, 1-Hybrid speed/quality, 2-Optimizes image quality, 3-Optimizes transition speed // (Only works for Firefox/IE, not Webkit)
					image_protect			:	1,			// Disables image dragging and right click with Javascript
															   
					// Size & Position						   
					min_width		        :   0,			// Min width allowed (in pixels)
					min_height		        :   0,			// Min height allowed (in pixels)
					vertical_center         :   1,			// Vertically center background
					horizontal_center       :   1,			// Horizontally center background
					fit_always				:	0,			// Image will never exceed browser width or height (Ignores min. dimensions)
					fit_portrait         	:   1,			// Portrait images will not exceed browser height
					fit_landscape			:   0,			// Landscape images will not exceed browser width
															   
					// Components							
					thumb_links				:	1,			// Individual thumb links for each slide
					thumbnail_navigation    :   0,			// Thumbnail navigation
													   
			// Components							
			slide_links				:	'blank',	// Individual links for each slide (Options: false, 'num', 'name', 'blank')
			slides 					:  	[			// Slideshow Images
											<?php echo implode(', ', $images); ?>
										]
			
		});

	});
	Cufon('#slidecounter > span', {
		color: '-linear-gradient(#4a443c, #7a6d5c)', textShadow: '1px 1px #000'
	});
	Cufon('#slidecaption', {
		color: '-linear-gradient(#bfbcb7, #f5f2eb)', textShadow: '1px 1px #000'
	});
</script>