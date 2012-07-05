<?php
/* post type for main slider */
$labels = array(
	'name'					=>_x('Sliders', 'post type general name', 'dt'),
	'singular_name'			=>_x('Slider', 'post type singular name', 'dt'),
	'add_new'				=>_x('Add New', 'post type new', 'dt'),
	'add_new_item'			=>__('Add New Item', 'dt'),
	'edit_item'				=>__('Edit Item', 'dt'),
	'new_item'				=>__('New Item', 'dt'),
	'view_item'				=>__('View Item', 'dt'),
	'search_items'			=>__('Search Items', 'dt'),
	'not_found'				=>__('No Items found', 'dt'),
	'not_found_in_trash'	=>__('No Items found in Trash', 'dt'), 
	'parent_item_colon'		=>'',
	'menu_name'				=>'Sliders'
);
$args = array(
	'labels'				=>$labels,
	'public'				=>false,
	'publicly_queryable'	=>false,
	'show_ui'				=>true, 
	'show_in_menu'			=>true, 
	'query_var'				=>true,
	'rewrite'				=>false,
	'capability_type' 		=>'post',
	'has_archive'			=>false, 
	'hierarchical'			=>false,
	'menu_position'			=>30,
	'menu_icon'				=>get_template_directory_uri().'/images/admin_ico_slides.png',
	'supports'				=>array( 'thumbnail', 'title', 'editor' )
);
register_post_type( 'main_slider', $args);

/* Define the custom box */

// WP 3.0+
add_action( 'add_meta_boxes', 'slider_meta_box' );
//add_action( 'save_post', 'slider_save_postdata' );
add_action( 'save_post', 'dt_home_slider_save' );
add_action( 'save_post', 'dt_home_slider_new_save' );
add_action( 'save_post', 'dt_home_static_save' );
add_action( 'save_post', 'dt_home_video_save' );

/* Adds a box to the main column on the Post and Page edit screens */
function slider_meta_box() {
/*	add_meta_box ( 
		'Slider link',
		__( 'Slider options', 'dt' ),
		'slider_meta_block',
		'main_slider',
		'side'
	);
*/
		add_meta_box(
			'dt_page_box-homeslider',
			__( 'Options for Original Slider', 'dt' ),
			'dt_home_slider_options',
			'page',
			'side',
			'low'
		);
		
		add_meta_box(
			'dt_page_box-homeslider_new',
			__( 'Options for New Slider', 'dt' ),
			'dt_home_slider_new_options',
			'page',
			'side',
			'low'
		);

		add_meta_box( 
			'dt_page_box-homestatic',
			__( 'Options for Static', 'dt' ),
			'dt_home_slider_static_options',
			'page',
			'side'
		);

		add_meta_box(
			'dt_page_box-homevideo',
			__( 'Options for Video', 'dt' ),
			'dt_home_slider_video_options',
			'page',
			'side'
		);
		
		add_action('admin_enqueue_scripts', 'my_admin_scripts');
		add_action('admin_print_styles', 'my_admin_styles');
}

/* Prints the box content */
/*			function slider_meta_block( $post ) {
	// Use nonce for verification
	wp_nonce_field( plugin_basename( __FILE__ ), 'slider_noncename' );

	// serialized array returned and userialized...
	$value = get_post_meta( $post->ID, 'slider_meta', true );
	
	$s_link = isset( $value['link'] )?trim( $value['link'] ):'';
	$s_hide_text = '';
	if( isset( $value['hide_text'] ) )
		$s_hide_text = !empty( $value['hide_text'] )?' checked':'';
	
	echo '<input type="text" id="slider_link" name="slider_link" value="' . $s_link . '" size="43" />';
	echo '<label for="slider_link">'. __('Slider link', 'dt'). '</label>';
	echo '<p>';
	echo '<input type="checkbox" id="slider_hide_text" name="slider_hide_text"' . $s_hide_text . '/>' . __( 'Hide post text in the side box of slide', 'dt' );
	echo '</p>';
}
*/

/* When the post is saved, saves our custom data */
/*	function slider_save_postdata( $post_id ) {
	// verify if this is an auto save routine. 
	// If it is our form has not been submitted, so we dont want to do anything
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
		return;

	// verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times

	if ( !isset( $_POST['slider_noncename'] ) || !wp_verify_nonce( $_POST['slider_noncename'], plugin_basename( __FILE__ ) ) )
		return;

	// Check permissions
	if ( !current_user_can( 'edit_post', $post_id ) )
		return;

	// OK, we're authenticated: we need to find and save the data
	$mydata = array();
	$mydata['link'] = esc_url_raw( $_POST['slider_link'] );
	$mydata['hide_text'] = isset( $_POST['slider_hide_text'] );

	update_post_meta( $post_id, 'slider_meta', $mydata );
}
*/

// SLIDER METABOX
function dt_home_slider_options( $post ) {
	// NAME OF THE BOX !
	$box_name = 'homeslider';
	
	global $wpdb;
	$parents = $counts = array();
	$img_h = $img_w = 107;

	$filter = get_post_meta( $post->ID, 'dt_'.$box_name.'_options', true );
	$filter = wp_parse_args(
		$filter,
		array(
			'dt_hide_over_mask'		=>false,
			'dt_interval'			=>5000
		)
	);
	
	$query = new Wp_Query( 'post_type=main_slider&posts_per_page=-1&post_status=publish' );
	$posts = $query->posts;
	
	foreach( $posts as &$p ) {
		$parents[] = $p->ID;
		
		$img = wp_get_attachment_image_src( get_post_thumbnail_id($p->ID), 'thumbnail' );
		if(!$img) {
			// noimage
			$img[0] = get_template_directory_uri().'/images/noimage_thumbnail.jpg';
		}
		$p->dt_thumbnail = $img[0];
		// post info
		$p->dt_info = '';
/*		$p->dt_info = sprintf( "%s\n\n", apply_filters('the_title', $p->post_title) );
		if( $p->post_content ) {
			$p->dt_info .= sprintf( "%s\n\n", apply_filters('get_the_excerpt', $p->post_content) );
		}
*/	}
	unset($p);
	
	$res = $wpdb->get_results(
		"
			SELECT po.post_parent AS pp, COUNT(po.ID) AS count 
			FROM {$wpdb->posts} po
			WHERE po.post_parent IN (". implode(', ', $parents). ")
			GROUP BY po.post_parent						
		",
		ARRAY_A
	);
	// how many images there is
	foreach( $res as $r ) {
		$counts[$r['pp']] = sprintf('There is %d image%s', $r['count'], (($r['count'] > 1)?'s':''));
	}
	
	$sel = isset($filter['show'])?$filter['show']:'all';
	
	// Use nonce for verification
	wp_nonce_field( plugin_basename( __FILE__ ), $box_name.'_noncename' );

	// The actual fields for data entry
	?>
	<p>
		<input type="text" id="dt_interval_<?php echo $box_name; ?>" name="dt_interval_<?php echo $box_name; ?>" value="<?php echo esc_attr($filter['dt_interval']); ?>"/>
		<label for="dt_interval_<?php echo $box_name; ?>"><?php _e("Interval (msec)", LANGUAGE_ZONE ); ?></label>
	</p>
	<p>
		<input type="checkbox" id="dt_hide_over_mask_<?php echo $box_name; ?>" name="dt_hide_over_mask_<?php echo $box_name; ?>"<?php checked($filter['dt_hide_over_mask']); ?>/>
		<label for="dt_hide_over_mask_<?php echo $box_name; ?>"><?php _e("Hide overlay mask", LANGUAGE_ZONE ); ?></label>
	</p>
	<p>
		<?php _e( 'Show:', LANGUAGE_ZONE ); ?>
	</p>
	<div class="showhide">
		<label>
			<input name="show_type_<?php echo $box_name; ?>" value="all"<?php checked('all' == $sel); ?> type="radio">
			<?php _e( 'All', LANGUAGE_ZONE ); ?>
		</label>
		<br/>
	</div>
	<div class="showhide">
		<label>
			<input name="show_type_<?php echo $box_name; ?>"<?php checked('only' == $sel); ?> value="only" type="radio">
			<?php _e( 'Only...', LANGUAGE_ZONE ); ?>
		</label>
		<br/>
		<div style="margin-left: 20px; margin-bottom: 8px; display: none;" class="list">
		<?php if( $posts ):	foreach( $posts as $p ): ?>
			<label style="width: <?php echo $img_w; ?>px;display: inline-block;margin-bottom: 3px;">
				<img width="<?php echo $img_w; ?>" height="<?php echo $img_h; ?>" src="<?php echo esc_url($p->dt_thumbnail); ?>" title="<?php echo $p->dt_info; echo isset($counts[$p->ID])?$counts[$p->ID]:''; ?>"/><br/>
				<div style="height: 30px;overflow: hidden;background-color: #D7D7D7;">
					<input name="show_<?php echo $box_name; ?>_only[<?php echo $p->ID; ?>]" value="<?php echo $p->ID; ?>" type="checkbox"<?php checked(isset($filter['show_'. $box_name. '_only'][$p->ID])); ?>>
					<?php echo apply_filters('the_title', $p->post_title); ?>
				</div>
			</label>
		<?php endforeach; endif; ?>
		</div>
	</div>
	<div class="showhide">
		<label>
			<input name="show_type_<?php echo $box_name; ?>"<?php checked('except' == $sel); ?> value="except" type="radio">
			<?php _e( 'Except...', LANGUAGE_ZONE ); ?>
		</label>
		<br/>
		<div style="margin-left: 20px; margin-bottom: 8px; display: none;" class="list">
		<?php if( $posts ):	foreach( $posts as $p ): ?>
			<label style="width: <?php echo $img_w; ?>px;display: inline-block;">
				<img width="<?php echo $img_w; ?>" height="<?php echo $img_h; ?>" src="<?php echo $p->dt_thumbnail; ?>" title="<?php echo $p->dt_info; echo isset($counts[$p->ID])?$counts[$p->ID]:''; ?>"/><br/>
				<div style="height: 30px;overflow: hidden;background-color: #D7D7D7;">
					<input name="show_<?php echo $box_name; ?>_except[<?php echo $p->ID; ?>]" value="<?php echo $p->ID; ?>" type="checkbox"<?php checked(isset($filter['show_'. $box_name. '_except'][$p->ID])); ?>>
					<?php echo apply_filters('the_title', $p->post_title); ?>
				</div>
			</label>
		<?php endforeach; endif; ?>
		</div>
	</div>
<?php
}

// SLIDER SAVE
function dt_home_slider_save( $post_id ) {
	// NAME OF THE BOX !
	$box_name = 'homeslider';
	// verify if this is an auto save routine. 
	// If it is our form has not been submitted, so we dont want to do anything
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
		return;

	// verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times

	if ( !isset( $_POST[$box_name.'_noncename'] ) || !wp_verify_nonce( $_POST[$box_name.'_noncename'], plugin_basename( __FILE__ ) ) )
		return;

	if ( !current_user_can( 'edit_post', $post_id ) )
		return;
	
	// OK, we're authenticated: we need to find and save the data
	$mydata = array();
	$mydata['dt_hide_over_mask'] = isset($_POST['dt_hide_over_mask_'.$box_name]);
	$mydata['show'] = strip_tags($_POST['show_type_'.$box_name]);
	if( 'all' != $mydata['show'] && isset($_POST['show_'. $box_name. '_'. $mydata['show']]) ) {
		$mydata['show_'. $box_name. '_'. $mydata['show']] = $_POST['show_'. $box_name. '_'. $mydata['show']];
	}elseif( 'all' != $mydata['show'] ) {
		$mydata['show'] = 'all';
	}
	$mydata['dt_interval'] = intval($_POST['dt_interval_'.$box_name]);
//	$mydata['dt_autoplay'] = isset($_POST['dt_autoplay']);
	
	update_post_meta( $post_id, 'dt_'.$box_name.'_options', $mydata );
}


// NEW SLIDER METABOX
function dt_home_slider_new_options( $post ) {
	// NAME OF THE BOX !
	$box_name = 'homeslider_new';
	
	global $wpdb;
	$parents = $counts = array();
	$img_h = $img_w = 107;
	$transitions = array(
		0	=>'None',
		1	=>'Fade',
		2	=>'Slide Top',
		3	=>'Slide Right',
		4	=>'Slide Bottom',
		5	=>'Slide Left',
		6	=>'Carousel Right',
		7	=>'Carousel Left'
	);
	
	
	$filter = get_post_meta( $post->ID, 'dt_'.$box_name.'_options', true );
	$filter = wp_parse_args(
		$filter,
		array(
			'dt_hide_over_mask'		=>false,
			'dt_interval'			=>5000,
			'dt_autoplay'			=>true,
			'dt_transition'			=>3
		)
	);
	
	$query = new Wp_Query( 'post_type=main_slider&posts_per_page=-1&post_status=publish' );
	$posts = $query->posts;
	
	foreach( $posts as &$p ) {
		$parents[] = $p->ID;
		
		$img = wp_get_attachment_image_src( get_post_thumbnail_id($p->ID), 'thumbnail' );
		if(!$img) {
			// noimage
			$img[0] = get_template_directory_uri().'/images/noimage_thumbnail.jpg';
		}
		$p->dt_thumbnail = $img[0];
		// post info
		$p->dt_info = '';
	}
	unset($p);
	
	$res = $wpdb->get_results(
		"
			SELECT po.post_parent AS pp, COUNT(po.ID) AS count 
			FROM {$wpdb->posts} po
			WHERE po.post_parent IN (". implode(', ', $parents). ")
			GROUP BY po.post_parent						
		",
		ARRAY_A
	);
	// how many images there is
	foreach( $res as $r ) {
		$counts[$r['pp']] = sprintf('There is %d image%s', $r['count'], (($r['count'] > 1)?'s':''));
	}
	
	$sel = isset($filter['show'])?$filter['show']:'all';
	
	// Use nonce for verification
	wp_nonce_field( plugin_basename( __FILE__ ), $box_name.'_noncename' );

	// The actual fields for data entry
	?>
	<p>
		<?php _e("Transition", LANGUAGE_ZONE ); ?><br/>
		<select id="dt_transition_<?php echo $box_name; ?>" name="dt_transition_<?php echo $box_name; ?>">
			<?php foreach( $transitions as $val=>$name ): ?>
				<option value="<?php echo esc_attr($val); ?>"<?php selected($val, $filter['dt_transition']); ?>>
					<?php echo $name; ?>
				</option>
			<?php endforeach;?>
		</select>
	</p>
	<p>
		<input type="text" id="dt_interval_<?php echo $box_name; ?>" name="dt_interval_<?php echo $box_name; ?>" value="<?php echo esc_attr($filter['dt_interval']); ?>"/>
		<label for="dt_interval_<?php echo $box_name; ?>"><?php _e("Interval (msec)", LANGUAGE_ZONE ); ?></label>
	</p>
	<p>
		<input type="checkbox" id="dt_autoplay_<?php echo $box_name; ?>" name="dt_autoplay_<?php echo $box_name; ?>"<?php checked($filter['dt_autoplay']); ?>/>
		<label for="dt_autoplay_<?php echo $box_name; ?>"><?php _e("Autoplay", LANGUAGE_ZONE ); ?></label>
	</p>
	<p>
		<input type="checkbox" id="dt_hide_over_mask_<?php echo $box_name; ?>" name="dt_hide_over_mask_<?php echo $box_name; ?>"<?php checked($filter['dt_hide_over_mask']); ?>/>
		<label for="dt_hide_over_mask_<?php echo $box_name; ?>"><?php _e("Hide overlay mask", LANGUAGE_ZONE ); ?></label>
	</p>
	<p>
		<?php _e( 'Show:', LANGUAGE_ZONE ); ?>
	</p>
	<div class="showhide">
		<label>
			<input name="show_type_<?php echo $box_name; ?>" value="all"<?php checked('all' == $sel); ?> type="radio">
			<?php _e( 'All', LANGUAGE_ZONE ); ?>
		</label>
		<br/>
	</div>
	<div class="showhide">
		<label>
			<input name="show_type_<?php echo $box_name; ?>"<?php checked('only' == $sel); ?> value="only" type="radio">
			<?php _e( 'Only...', LANGUAGE_ZONE ); ?>
		</label>
		<br/>
		<div style="margin-left: 20px; margin-bottom: 8px; display: none;" class="list">
		<?php if( $posts ):	foreach( $posts as $p ): ?>
			<label style="width: <?php echo $img_w; ?>px;display: inline-block;margin-bottom: 3px;">
				<img width="<?php echo $img_w; ?>" height="<?php echo $img_h; ?>" src="<?php echo esc_url($p->dt_thumbnail); ?>" title="<?php echo $p->dt_info;echo isset($counts[$p->ID])?$counts[$p->ID]:''; ?>"/><br/>
				<div style="height: 30px;overflow: hidden;background-color: #D7D7D7;">
					<input name="show_<?php echo $box_name; ?>_only[<?php echo $p->ID; ?>]" value="<?php echo $p->ID; ?>" type="checkbox"<?php checked(isset($filter['show_'. $box_name. '_only'][$p->ID])); ?>>
					<?php echo apply_filters('the_title', $p->post_title); ?>
				</div>
			</label>
		<?php endforeach; endif; ?>
		</div>
	</div>
	<div class="showhide">
		<label>
			<input name="show_type_<?php echo $box_name; ?>"<?php checked('except' == $sel); ?> value="except" type="radio">
			<?php _e( 'Except...', LANGUAGE_ZONE ); ?>
		</label>
		<br/>
		<div style="margin-left: 20px; margin-bottom: 8px; display: none;" class="list">
		<?php if( $posts ):	foreach( $posts as $p ): ?>
			<label style="width: <?php echo $img_w; ?>px;display: inline-block;">
				<img width="<?php echo $img_w; ?>" height="<?php echo $img_h; ?>" src="<?php echo $p->dt_thumbnail; ?>" title="<?php echo $p->dt_info;echo isset($counts[$p->ID])?$counts[$p->ID]:''; ?>"/><br/>
				<div style="height: 30px;overflow: hidden;background-color: #D7D7D7;">
					<input name="show_<?php echo $box_name; ?>_except[<?php echo $p->ID; ?>]" value="<?php echo $p->ID; ?>" type="checkbox"<?php checked(isset($filter['show_'. $box_name. '_except'][$p->ID])); ?>>
					<?php echo apply_filters('the_title', $p->post_title); ?>
				</div>
			</label>
		<?php endforeach; endif; ?>
		</div>
	</div>
<?php
}

// NEW SLIDER SAVE
function dt_home_slider_new_save( $post_id ) {
	// NAME OF THE BOX !
	$box_name = 'homeslider_new';
	// verify if this is an auto save routine. 
	// If it is our form has not been submitted, so we dont want to do anything
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
		return;

	// verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times

	if ( !isset( $_POST[$box_name.'_noncename'] ) || !wp_verify_nonce( $_POST[$box_name.'_noncename'], plugin_basename( __FILE__ ) ) )
		return;

	if ( !current_user_can( 'edit_post', $post_id ) )
		return;
	
	// OK, we're authenticated: we need to find and save the data
	$mydata = array();
	$mydata['dt_hide_over_mask'] = isset($_POST['dt_hide_over_mask_'.$box_name]);
	$mydata['show'] = strip_tags($_POST['show_type_'.$box_name]);
	if( 'all' != $mydata['show'] && isset($_POST['show_'. $box_name. '_'. $mydata['show']]) ) {
		$mydata['show_'. $box_name. '_'. $mydata['show']] = $_POST['show_'. $box_name. '_'. $mydata['show']];
	}elseif( 'all' != $mydata['show'] ) {
		$mydata['show'] = 'all';
	}
	$mydata['dt_interval'] = intval($_POST['dt_interval_'.$box_name]);
	$mydata['dt_autoplay'] = isset($_POST['dt_autoplay_'.$box_name]);
	$mydata['dt_transition'] = intval($_POST['dt_transition_'.$box_name]);
	
	update_post_meta( $post_id, 'dt_'.$box_name.'_options', $mydata );
}

// VIDEO METABOX
function dt_home_slider_video_options( $post ) {
	// NAME OF THE BOX !
	$box_name = 'homevideo';
	
	$data = get_post_meta( $post->ID, 'dt_'. $box_name. '_options', true );
	$data = wp_parse_args(
		$data,
		array(
			'dt_vid_autoplay'	=>false,
			'dt_vid_loop'		=>false,
			'dt_hide_desc'		=>false,
			'dt_hide_over_mask'	=>false			
		)
	);
	$dt_video = isset( $data['dt_video'] )?$data['dt_video']:'';
	$dt_link = isset( $data['dt_link'] )?trim( $data['dt_link'] ):'';

	$u_href = get_admin_url();
	$u_href .= '/media-upload.php?post_id='. $post->ID;
	$u_href .= '&type=image&amp;TB_iframe=true';
	
	// Use nonce for verification
	wp_nonce_field( plugin_basename( __FILE__ ), $box_name.'_noncename' );

	// The actual fields for data entry
	?>
	<p>
		<label for="dt_video">
			<?php _e("Video url", LANGUAGE_ZONE ); ?>
		</label>
		<input id="dt_video" type="text" name="dt_video_<?php echo $box_name; ?>" value="<?php echo esc_attr($dt_video); ?>" size="46"/>
	</p>
		<a id="upload_image_button" class="upload_button button" href="<?php echo esc_url( $u_href ); ?>"><?php _e('Upload', LANGUAGE_ZONE); ?></a>
		<a id="remove_image_button" class="upload_button button" href="#"><?php _e( 'Remove', LANGUAGE_ZONE ); ?></a>
		<hr>
	<p>
		<label for="dt_vid_autoplay_<?php echo $box_name; ?>">
			<input type="checkbox" id="dt_vid_autoplay_<?php echo $box_name; ?>" name="dt_vid_autoplay_<?php echo $box_name; ?>"<?php checked($data['dt_vid_autoplay']); ?>/>
			<?php _e("Autoplay", LANGUAGE_ZONE ); ?>
		</label>
	</p>
	<p>
		<label for="dt_vid_loop_<?php echo $box_name; ?>">
			<input type="checkbox" id="dt_vid_loop_<?php echo $box_name; ?>" name="dt_vid_loop_<?php echo $box_name; ?>"<?php checked($data['dt_vid_loop']); ?>/>
			<?php _e("Repeat", LANGUAGE_ZONE ); ?>
		</label>
	</p>
	<p>
		<label for="dt_hide_desc_<?php echo $box_name; ?>">
			<input type="checkbox" id="dt_hide_desc_<?php echo $box_name; ?>" name="dt_hide_desc_<?php echo $box_name; ?>"<?php checked($data['dt_hide_desc']); ?>/>
			<?php _e("Hide description", LANGUAGE_ZONE ); ?>
		</label>
	</p>
	<p>
		<label for="dt_hide_over_mask_<?php echo $box_name; ?>">
			<input type="checkbox" id="dt_hide_over_mask_<?php echo $box_name; ?>" name="dt_hide_over_mask_<?php echo $box_name; ?>"<?php checked($data['dt_hide_over_mask']); ?>/>
			<?php _e("Hide overlay mask", LANGUAGE_ZONE ); ?>
		</label>
	</p>
	<p>
		<label for="dt_link_<?php echo $box_name; ?>"><?php _e('Details link', LANGUAGE_ZONE ); ?></label>
		<input type="text" id="dt_link_<?php echo $box_name; ?>" name="dt_link_<?php echo $box_name; ?>" value="<?php echo esc_attr($dt_link); ?>" size="46" />
	</p>
	<?php
}

// VIDEO SAVE FUNK
function dt_home_video_save( $post_id ) {
	// NAME OF THE BOX !
	$box_name = 'homevideo';
	
	// verify if this is an auto save routine. 
	// If it is our form has not been submitted, so we dont want to do anything
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
		return;

	// verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times

	if ( !isset( $_POST[$box_name.'_noncename'] ) || !wp_verify_nonce( $_POST[$box_name.'_noncename'], plugin_basename( __FILE__ ) ) )
		return;

	if ( !current_user_can( 'edit_post', $post_id ) )
		return;
	
	// OK, we're authenticated: we need to find and save the data
	$mydata = array();
	$mydata['dt_video'] = isset($_POST['dt_video_'.$box_name])?esc_url_raw($_POST['dt_video_'.$box_name]):null;
	$mydata['dt_hide_desc'] = isset($_POST['dt_hide_desc_'.$box_name]);
	$mydata['dt_hide_over_mask'] = isset($_POST['dt_hide_over_mask_'.$box_name]);
	$mydata['dt_vid_autoplay'] = isset($_POST['dt_vid_autoplay_'.$box_name]);
	$mydata['dt_vid_loop'] = isset($_POST['dt_vid_loop_'.$box_name]);
	$mydata['dt_link'] = esc_url_raw( $_POST['dt_link_'.$box_name] );
	
	update_post_meta( $post_id, 'dt_'. $box_name. '_options', $mydata );
}

// STATIC METABOX
function dt_home_slider_static_options( $post ) {
	// NAME OF THE BOX !
	$box_name = 'homestatic';

	$data = get_post_meta( $post->ID, 'dt_'. $box_name. '_options', true );
	
	$dt_link = isset( $data['dt_link'] )?trim( $data['dt_link'] ):'';
	
	// Use nonce for verification
	wp_nonce_field( plugin_basename( __FILE__ ), $box_name.'_noncename' );

	// The actual fields for data entry
	?>
	<p>
		<input type="checkbox" id="dt_hide_desc_<?php echo $box_name; ?>" name="dt_hide_desc_<?php echo $box_name; ?>"<?php checked($data['dt_hide_desc']); ?>/>
		<label for="dt_hide_desc_<?php echo $box_name; ?>"><?php _e("Hide description", LANGUAGE_ZONE ); ?></label>
	</p>
	<p>
		<input type="checkbox" id="dt_hide_over_mask_<?php echo $box_name; ?>" name="dt_hide_over_mask_<?php echo $box_name; ?>"<?php checked($data['dt_hide_over_mask']); ?>/>
		<label for="dt_hide_over_mask_<?php echo $box_name; ?>"><?php _e("Hide overlay mask", LANGUAGE_ZONE ); ?></label>
	</p>
	<p>
		<input type="text" id="dt_link_<?php echo $box_name; ?>" name="dt_link_<?php echo $box_name; ?>" value="<?php echo $dt_link ?>" size="43" />
		<label for="dt_link_<?php echo $box_name; ?>"><?php _e('Details link', LANGUAGE_ZONE); ?></label>
	</p>
	<?php
}

// STATIC SAVE FUNK
function dt_home_static_save( $post_id ) {
	// NAME OF THE BOX !
	$box_name = 'homestatic';
	
	// verify if this is an auto save routine. 
	// If it is our form has not been submitted, so we dont want to do anything
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
		return;

	// verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times

	if ( !isset( $_POST[$box_name.'_noncename'] ) || !wp_verify_nonce( $_POST[$box_name.'_noncename'], plugin_basename( __FILE__ ) ) )
		return;

	if ( !current_user_can( 'edit_post', $post_id ) )
		return;
	
	// OK, we're authenticated: we need to find and save the data
	$mydata = array();
	$mydata['dt_hide_desc'] = isset($_POST['dt_hide_desc_'.$box_name]);
	$mydata['dt_hide_over_mask'] = isset($_POST['dt_hide_over_mask_'.$box_name]);
	$mydata['dt_link'] = isset($_POST['dt_link_'.$box_name])?esc_url_raw( $_POST['dt_link_'.$box_name] ):'';
	
	update_post_meta( $post_id, 'dt_'. $box_name. '_options', $mydata );
}