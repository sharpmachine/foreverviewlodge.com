<?php
/**
 * @package WordPress
 * @subpackage Chocolate
 */
 
  $GLOBALS['nostrip'] = 1;
 
?>
<?php get_header(); ?>
<?php get_sidebar(); ?>
<?php if (have_posts()) : ?>
               <?php while (have_posts()) : the_post(); ?>    
              <?php the_content(); ?>
               <?php endwhile; ?>
     <?php endif; ?>

<?php get_footer(); ?>
