<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 * Template Name: Mobile Homepage
 */

get_header(); ?>
<div id="container">


	<?php if ($theme->display('logo')) { ?> 
        <div class="logo-image"><img src="<?php $theme->option('logo'); ?>" alt="<?php bloginfo('name'); ?>" title="<?php bloginfo('name'); ?>" /></div>
    <?php } elseif ($theme->display('maintitle')) { ?> 
        <div class="logo-title"><?php $theme->option('maintitle'); ?></div>
    <?php } ?> 

    <div id="main_panels">
        <div class="panels_slider">
        <ul class="slides">
			<?php query_posts(array( 'post_type' => 'slider', 'showposts' => '9999'));?>
            <?php if (have_posts()) : ?>
            

                    <?php while (have_posts()) : the_post(); ?>
    
                    <?php if (has_post_thumbnail( $post->ID ) ): ?>
                    <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?>
                    <li>
                    <a href="<?php echo get_post_meta($post->ID, "slider_item_url", $single = true); ?>" class="icon">
                    <img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
                    </a>
                    </li>
                    <?php endif; ?>
                          
                    <?php endwhile; ?>                          

            <?php endif; ?>
        </ul>
        </div>
    </div>

    <div id="bottom_nav">
        <div class="icons_nav">
           <?php if($theme->get_option('icons_arrows') == 'enable') { ?> <div class="paginated"> <?php } ?> 
            <ul class="slides">
                
					<?php
					$count = 1;
					query_posts(array( 'post_type' => 'icons_menu', 'orderby' => 'menu_order', 'order' => 'ASC', 'showposts' => '999')); ?>
                    <?php $postsnr = $wp_query->found_posts; ?>
                    <?php if (have_posts()) : ?>
                    <li>
                    <?php while (have_posts()) : the_post(); ?>
                    <a href="<?php echo get_post_meta($post->ID, "menu_item_url", $single = true); ?>"><?php the_post_thumbnail('menu-icon-size'); ?><span><?php the_title(); ?></span></a>
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
    </div>
    
</div>
<?php $theme->option('analytics_code'); ?>
</body>
</html>


