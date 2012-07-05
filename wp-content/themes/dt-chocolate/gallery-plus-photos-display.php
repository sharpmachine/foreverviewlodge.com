<div class="hidden post_<?php echo $post->ID; ?>">
<div class="big_gallery_bg hidden">
<div class="big_gallery">

  <a href="#" class="go_back">Back</a>
  <h1><?php the_title(); ?></h1>

  <div class="multipics">
    <?php    
	$args = array(
		'post_type'		=>'attachment',
		'numberposts' 	=>-1,
		'post_status' 	=>'inherit',
		'orderby'		=>'menu_order',
'order'	=>'ASC',
		'post_parent' 	=>$post->ID
	);
	
	$box_name = 'gallery_ct';
	$data = get_post_meta( $post->ID, 'dt_'.$box_name.'_options', true );
	$data = wp_parse_args($data, array('dt_exclude_from' =>false));
	if( $data['dt_exclude_from'] ) {
		$args['post__not_in'] = array( get_post_thumbnail_id($post->ID) );
	}
	$attachments = get_posts( $args );
	if($attachments):
		foreach ($attachments as $attachment):
		   //global $postoptions_photos;
		   $image = wp_get_attachment_image_src($attachment->ID, 'large');
		   $k = $image[1]/$image[2];
		   $w = 220;
		   $h = ceil($w / $k);
		   
//		   $orig_image = str_replace(site_url(), "", $image[0]);
		   $tmp_src = explode($_SERVER['SERVER_NAME'], $image[0]);
		   $tmp_src = isset($tmp_src[1])?$tmp_src[1]:$image[0];
		   $small_image = get_template_directory_uri()."/thumb.php?src={$tmp_src}&w={$w}&h={$h}&zc=1";
		   $big_image = $image[0];
	?>
		<a href="<?php echo esc_url($big_image); ?>" data-src="<?php echo esc_attr($small_image); ?>" data-width="<?php echo esc_attr($w); ?>" data-height="<?php echo esc_attr($h); ?>"><?php echo esc_attr($attachment->post_excerpt); ?></a>
	<?php
		endforeach;
	endif;
	?>
  </div>

  <a href="#" class="go_back">Back</a>
</div>
</div>
</div>
