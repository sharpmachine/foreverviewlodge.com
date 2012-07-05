<?php /* Template Name: Blog
*/

?>
<?php get_header(); ?>
<?php get_sidebar(); ?>
<?php
/*   global $query_string, $paged;
   parse_str( $query_string, $args );
   $args['post_type'] = array( 'post' );
   
   if( !$paged ) {
		$paged = get_query_var('page');
   }
   
   unset($args['pagename']);
   unset($args['page_id']);
   unset($args['p']);
*/   
	global $paged, $page;
	query_posts( array('post_type' =>'post', 'paged' =>($paged?$paged:get_query_var('page'))) );
	get_template_part( 'loop' , 'blog' );
?>
<?php get_footer(); ?>
