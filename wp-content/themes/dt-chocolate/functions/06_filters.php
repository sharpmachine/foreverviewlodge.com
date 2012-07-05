<?php

function dt_posts_parents_where( $where ) {
	global $wpdb;
	$query = dt_parent_where_query();
	if( $query ) { 
		$where .= sprintf( " AND %s.post_parent IN(%s)", $wpdb->posts, $query );
	}
	return $where;
}

function the_category_filter($thelist,$separator=' ') {
   $thelist = str_replace(' rel="category"', '', $thelist);
   return $thelist;
}
add_filter('the_category','the_category_filter', 10, 2);

//Image with caption filter
function fb_img_caption_shortcode($attr, $content = null) {
	// Allow plugins/themes to override the default caption template.
	$output = apply_filters('img_caption_shortcode', '', $attr, $content);
	if ( $output != '' )
		return $output;
	extract(shortcode_atts(array(
		'id'	=> '',
		'align'	=> 'alignnone',
		'width'	=> '',
		'caption' => ''
	), $attr));
 $id = 'id="' . $id . '" ';
	return '<div ' . $id . 'class="wp-caption ' . $align . '" style="width: ' . ((int) $width) . 'px">'
	. do_shortcode( $content ) . '<p class="wp-caption-text">' . $caption . '</p></div>';
}
add_shortcode('wp_caption', 'fb_img_caption_shortcode');
add_shortcode('caption', 'fb_img_caption_shortcode');
add_shortcode('img_caption_shortcode', 'fb_img_caption_shortcode');

// Change what's hidden by default
add_filter('default_hidden_meta_boxes', 'be_hidden_meta_boxes', 10, 2);
function be_hidden_meta_boxes($hidden, $screen) {
	if ( 'post' == $screen->base || 'page' == $screen->base )
		$hidden = array(
			'slugdiv',
			'trackbacksdiv',
			'authordiv',
			'revisionsdiv',
			'dt_page_box-gallery',
			'dt_page_box-homeslider',
			'dt_page_box-portfolio',
			'dt_page_box-homevideo'
		);
		// removed 'postcustom',
	return $hidden;
}