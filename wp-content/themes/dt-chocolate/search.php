<?php
/**
 * @package WordPress
 * @subpackage Chocolate
 */
?>
<?php get_header(); ?>
<?php get_sidebar(); ?>
<?php
   global $wp_query;
   //print_r($wp_query->query);
   $wp_query->query['post_type'] = array('post');
   query_posts( $wp_query->query );
?>
<?php if ( have_posts() ) : ?>

    <div class="article_box col_l">
      <div class="article_t"></div>
      <div class="article search_title">
 
        <h1 class="page-title search_title"><?php printf( __( 'Search Results for: %s', LANGUAGE_ZONE ), '<span>' . get_search_query() . '</span>' ); ?></h1>

      </div>
      <div class="article_b"></div>
    </div>

	<?php
	   get_template_part( 'loop', 'search' );
	?>
<?php else : ?>

    <div class="article_box col_l">
      <div class="article_t"></div>
      <div class="article search_title">
        <h1 class="page-title"><?php _e( 'Nothing Found', LANGUAGE_ZONE ); ?></h1>
      </div>
      <div class="article_b"></div>
    </div>

<?php endif; ?>
<?php get_footer(); ?>
