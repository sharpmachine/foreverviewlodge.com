<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 * Template Name: Mobile Homepage
 */

get_header(); ?>
<div id="pagecontainer">
        
      <?php wp_reset_query(); ?>
   	 
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
		<?php if(!is_front_page()): ?>
			<h1><?php the_title(); ?></h1>
		<?php endif; ?>
        
			<div class="entry">
				<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
			</div>

		<?php endwhile; endif; ?> 
        
	 <?php if($theme->get_option('show_widget_area_2') == 'enable') {
     if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Archive widget area') ) : ?>
     <h2>You can add widgets here from Admin->Appearance->Widgets <br /> Enable or Disable this widget area from Theme Options -> Widgets</h2>
    <?php endif; } else {}?>  
        
      <div class="clear"></div>  
      
		<div class="icons_nav home_nav">
      <?php if($theme->get_option('icons_arrows') == 'enable') { ?> <div class="paginated"> <?php } ?> 
          <ul class="slides">
				<?php
				$count = 1;
				query_posts(array( 'post_type' => 'icons_menu', 'orderby' => 'menu_order', 'order' => 'ASC', 'showposts' => '999')); ?>
              <?php $postsnr = $wp_query->found_posts; ?>
              <?php if (have_posts()) : ?>
              <li>
              <?php while (have_posts()) : the_post(); ?>
              <a href="<?php echo get_post_meta($post->ID, "menu_item_url", $single = true); ?>" class="icon"><?php the_post_thumbnail('menu-icon-size'); ?><span><?php the_title(); ?></span></a>
              <?php if ($postsnr > 4 && $count == 4){ ?>
              </li><li>
              <?php } if ($postsnr > 8 && $count == 8){ ?>
              </li><li>
              <?php } ?>
              <?php $count++; endwhile; ?>
				</li>
              <?php if ($postsnr < 4 || $postsnr == 4){ ?>
              <li></li>
              <?php } ?>
				<?php endif; ?>
          </ul>
       <?php if($theme->get_option('icons_arrows') == 'enable') { ?> </div> <?php } ?>  
    </div>
<?php get_footer(); ?>  

</div>


