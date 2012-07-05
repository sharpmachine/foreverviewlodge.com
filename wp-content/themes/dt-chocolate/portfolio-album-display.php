<?php global $term, $h; ?>
    <?php while ( have_posts() ) : the_post();
       global $postoptions_portfolio;
       
       $orig_image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'large' );
       
       $orig_image = default_attachment($orig_image);
       
       if ($orig_image[2] <= 0) continue;
       
       $k = $orig_image[1] / $orig_image[2];
       $orig_image = $orig_image[0];
       
       $postoptions_portfolio->post = get_the_ID();
       $size = $postoptions_portfolio->get_post_option('post_size');
       
       
       $size = the_post_size();
       
       //echo $size.", ";
       
      if ($size == "s")
         $w = 220;
      if ($size == "m")
         $w = 460;
      if ($size == "l")
         $w = 700;
       
       //$w = 220;
       
       $h = ceil($w / $k);
       
//       $orig_image = str_replace(site_url(), "", $orig_image);
	   $tmp_src = explode($_SERVER['SERVER_NAME'], $orig_image);
	   $tmp_src = isset($tmp_src[1])?$tmp_src[1]:$orig_image;
       $small_image = get_template_directory_uri().'/thumb.php?src='.$tmp_src.'&amp;w='.$w.'&amp;h='.$h.'&amp;zc=1';
    ?>
       
<div class="with_href portfolio folio_box col_<?php echo $size; ?>" title="<?php the_title(); ?>">

   <a style="display: none;" href="<?php the_permalink(); ?>"></a>

  <div class="folio" style="background: url(<?php echo $small_image; ?>) 0 0; height: <?php echo $h; ?>px; width: <?php echo $w; ?>px;">  
          <div class="folio_mask">

            <div class="folio_caption">
              <div>
                <div>
                  <a href="#"><?php the_title(); ?></a>
                </div>
              </div>
            </div>
            <div class="folio_desc">

              <div class="desc_body">
                <?php
                //global $more; $more = 0;
                the_excerpt();
                ?>
              </div>
              <div class="goto_post"><a href="#" class="go_more"><span><i></i>Details</span></a> <!-- <span class="ico_link date">1 day ago</span> --></div>
            </div>
          </div>
  
          <div class="folio_just_caption">
            <div>

              <div>
                <a href="#"><?php the_title(); ?></a>
              </div>
            </div>
          </div>
  </div>
</div>
       
    <?php endwhile; ?>
