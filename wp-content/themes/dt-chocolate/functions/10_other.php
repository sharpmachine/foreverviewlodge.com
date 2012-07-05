<?php
function dt_parent_where_query( $str = null ) {
	static $query = '';
	if( $str ) {
		$query = strip_tags( $str );
	}
	return $query;
}

// read more link
function new_excerpt_more($more) {
       global $post;
   
   if (isset($GLOBALS['is_portfolio']))
   if ($GLOBALS['is_portfolio'])       
      return '';

	return '
	<a href="'. get_permalink($post->ID) . '" class="go_more"><span><i></i>'.__("read more", LANGUAGE_ZONE).'</span></a>';
}

function the_content_more($c)
{
   $link = new_excerpt_more(1);
   //$c = preg_replace('/<a[^>]+class="more-link"><\/a>/');
   $c = preg_replace('/(<a[^>]+class="more-link">.*?<\/a>)/', '<br style="clear: both;" />\\1', $c);
   $c = str_replace('more-link', 'go_more', $c);
   return $c;
}

add_filter('excerpt_more', 'new_excerpt_more');
add_filter('the_content', 'the_content_more');

function default_attachment($att) {
   if ($att[0]) return $att;
   $file = "/images/noimage.jpg";
   $att[0] = get_template_directory_uri().$file;
   $fname = dirname(__FILE__)."/../".$file;
   $size = @getimagesize($fname);
   $att[1] = $size[0];
   $att[2] = $size[1];
   return $att;
}

?>
