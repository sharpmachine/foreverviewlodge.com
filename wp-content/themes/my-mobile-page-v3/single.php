<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */

get_header();?>
<div id="pagecontainer">
    
    	<div id="header" class="black_gradient">
            <a href="<?php echo home_url(); ?>" class="back_button black_button"><?php $theme->option('home_button'); ?></a>
            <div class="page_title"><?php $theme->option('header_text'); ?></div>
            <a href="#" id="menu_open" class="black_button"><?php $theme->option('menu_button'); ?></a>
            <a href="#" id="menu_close" class="black_button"><?php $theme->option('close_button'); ?></a>
            <div class="clear"></div>
        </div>
        
    	<div id="pages_nav">
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
      </div>
        
      <?php wp_reset_query(); ?>
      
      <div class="content">


		<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
        <h1><?php the_title(); ?></h1>
        	<div class="post">
			<?php 
			if (has_post_thumbnail()) {
			
				$image_id = get_post_thumbnail_id();
				$image_url = wp_get_attachment_image_src($image_id,'large', true);
				?>
				
			
				<div class="post_thumb_single">
				<img src="<?php echo $image_url[0]; ?>" alt="" title="" border="0" class="rounded" />
				<img src="<?php echo get_template_directory_uri(); ?>/images/shadow.png" alt="" title="" border="0" class="shadow" />
				</div>
            
            <?php } else {?>            
            <?php } ?>
            <div class="post_content_single">

            <?php echo the_content(); ?>

            </div>
            <div class="clear"><?php the_tags( '<p>Tags: ', ', ', '</p>'); ?></div>
            <span class="post_detail date"><?php the_time('d.m') ?></span>
            <span class="post_detail category"><?php the_category(', ') ?></span>
            <span class="post_detail comments"><?php comments_popup_link('0', '1', '%'); ?></span>
        </div>
        
        <?php comments_template(); ?>
		<div id="tab3" class="tabcontent">
			<h3>Social</h3>
            <ul class="singlesocial">
<?php if ($theme->display('icon_rss')) { ?><li><a target="_blank" href="<?php $theme->option('url_rss'); ?>"><img src="<?php $theme->option('icon_rss'); ?>" alt="" title="" class="rounded-half"/></a></li><?php } ?>
<?php if ($theme->display('icon_twitter')) { ?><li><a target="_blank" href="<?php $theme->option('url_twitter'); ?>"><img src="<?php $theme->option('icon_twitter'); ?>" alt="" title="" class="rounded-half"/></a></li><?php } ?>
<?php if ($theme->display('icon_facebook')) { ?><li><a target="_blank" href="<?php $theme->option('url_facebook'); ?>"><img src="<?php $theme->option('icon_facebook'); ?>" alt="" title="" class="rounded-half"/></a></li><?php } ?>
<?php if ($theme->display('icon_digg')) { ?><li class="right"><a target="_blank" href="<?php $theme->option('url_digg'); ?>"><img src="<?php $theme->option('icon_digg'); ?>" alt="" title="" class="rounded-half"/></a></li><?php } ?>

<?php if ($theme->display('icon_google')) { ?><li><a target="_blank" href="<?php $theme->option('url_google'); ?>"><img src="<?php $theme->option('icon_google'); ?>" alt="" title="" class="rounded-half"/></a></li><?php } ?>
<?php if ($theme->display('icon_reddit')) { ?><li><a target="_blank" href="<?php $theme->option('url_reddit'); ?>"><img src="<?php $theme->option('icon_reddit'); ?>" alt="" title="" class="rounded-half"/></a></li><?php } ?>

<?php if ($theme->display('icon_flickr')) { ?><li><a target="_blank" href="<?php $theme->option('url_flickr'); ?>"><img src="<?php $theme->option('icon_flickr'); ?>" alt="" title="" class="rounded-half"/></a></li><?php } ?>
<?php if ($theme->display('icon_vimeo')) { ?><li class="right"><a target="_blank" href="<?php $theme->option('url_vimeo'); ?>"><img src="<?php $theme->option('icon_vimeo'); ?>" alt="" title="" class="rounded-half"/></a></li><?php } ?>
            
            </ul>
			<div class="clear"></div>
		</div>   
            
		<?php endwhile; ?>
		<?php else : ?>
        <h2>Sorry, no posts matched your criteria.</h2>
        <?php endif; ?>

      <div class="clear"></div>  
      </div>
	


<?php get_footer(); ?>
</div>