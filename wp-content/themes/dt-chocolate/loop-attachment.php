<?php
/**
 * @package WordPress
 * @subpackage Chocolate
 */
?>

  <div id="content">

    <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

    <div class="article_box">
      <div class="article_t"></div>
      <div class="article">

        <span class="post_type <?php echo the_post_class(); ?>"></span>
        <h1 class="entry-title _cf"><?php the_title(); ?></h1>
        
        <?php if (!$GLOBALS['is_contacts'] && !$GLOBALS['nostrip']) { ?>
        
        <div class="hd entry_meta"<?php
        
           $large = $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
           if ( ( $large[1] >= 700 && the_post_class() == "photo" ) || in_array(the_post_class(), explode(" ", "video audio")))
            echo ' style="border-bottom: 0; margin-bottom: 0;"';
        
        ?>>
          <?php
			  printf( __( '<a class="ico_link date" href="%1$s" rel="bookmark">%3$s</a> <a class="ico_link author" href="%4$s" title="%5$s">%6$s</a>', 'dt' ),
			  get_permalink(),
			  get_the_date( 'c' ),
			  get_the_date(),
			  get_author_posts_url( get_the_author_meta( 'ID' ) ),
			  sprintf( esc_attr__( 'View all posts by %s', 'dt' ), get_the_author() ),
			  get_the_author()
			  );
          ?>
          <?php 
            global $post;
            if ($post->comment_status!='closed')
               comments_popup_link( __( 'Leave a comment', 'dt' ), __( '1 Comment', 'dt' ), __( '% Comments', 'dt' ), 'ico_link comments' );
          ?>
          <span class="ico_link categories"><?php the_category( ', ' ); ?></span>
          <?php the_tags( '<span class="ico_link tags">', ', ', '</span>' ); ?>
          <?php edit_post_link( __( 'Edit', 'dt' ), '<span class="ico_link edit-link">', '</span>' ); ?> 
        </div>
        
        <?php } ?>

        <?php 
          if ( has_post_thumbnail() ) {
          $large = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
//          $large[0] = str_replace(site_url(), "", $large[0]);
		  $tmp_src = explode($_SERVER['SERVER_NAME'], $large[0]);
		  $tmp_src = isset($tmp_src[1])?$tmp_src[1]:$large[0];
          $large_image_url = $large[0];
          
          $is_large = 0;
          $w = 0;
          $h = 0;
          
          if ($large[1] >= 700)
          {
             $w = 700;
             $h = $large[2] * ($w / $large[1]);
             $is_large = 1;
          }
          elseif ($large[1] < 700 && $large[1] >= 350)
          {
             $w = 350;
             $h = $large[2] * ($w / $large[1]);
          }
          else
          {
             $w = $large[1];
             $h = $large[2];
          }
          
          $h = intval($h); $w = intval($w);
          
          $thumb = get_template_directory_uri().'/thumb.php?src='.$tmp_src.'&amp;w='.$w.'&amp;h='.$h.'&amp;zc=1';       
          
        ?>
        <?php if ($is_large) { ?>
          <a href="<?php echo $large_image_url; ?>" title="<?php echo the_title_attribute('echo=0') ?>" class="prettyPhoto">
             <img src="<?php echo $thumb; ?>" width="<?php echo $w; ?>" height="<?php echo $h; ?>" alt="<?php the_title(); ?>" class="hd" /> 
          </a>
          <div class="hr_w bot"><i></i></div>
        <?php } else { ?>
          <a href="<?php echo $large_image_url; ?>" title="<?php echo the_title_attribute('echo=0') ?>" class="prettyPhoto">
             <img src="<?php echo $thumb; ?>" width="<?php echo $w; ?>" height="<?php echo $h; ?>" alt="<?php the_title(); ?>" class="alignleft" /> 
          </a>
        <?php } ?>
        <?php } ?>
       
   
   <?php the_post_before(); ?>    
   
   
<?php if ( wp_attachment_is_image() ) :
	$attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
	foreach ( $attachments as $k => $attachment ) {
		if ( $attachment->ID == $post->ID )
			break;
	}
	$k++;
	// If there is more than 1 image attachment in a gallery
	if ( count( $attachments ) > 1 ) {
		if ( isset( $attachments[ $k ] ) )
			// get the URL of the next image attachment
			$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
		else
			// or get the URL of the first image attachment
			$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
	} else {
		// or, if there's only 1 image attachment, get the URL of the image
		$next_attachment_url = wp_get_attachment_url();
	}
?>
	<p class="attachment"><a href="<?php echo $next_attachment_url; ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="attachment"><?php
		$attachment_width  = apply_filters( 'twentyten_attachment_size', 900 );
		$attachment_height = apply_filters( 'twentyten_attachment_height', 900 );
		
		ob_start();
		echo wp_get_attachment_image( $post->ID, array( $attachment_width, $attachment_height ) );
		$ret = ob_get_clean();
		
		if ( preg_match('/src="([^"]+)"/', $ret, $m) )
		{
		   echo '<img src="'.get_template_directory_uri().'/thumb.php?src='.$tmp_src.'&amp;w=660&amp;h=&amp;zc=1&amp;nores=1" >';
		}
	?></a></p>
	
<?php endif; ?>

   
	<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'portfoliopress' ), 'after' => '</div>' ) ); ?>
      </div>
      <div class="article_b"></div>
	  <?php comments_template(); ?>
	  
	  <?php if ($GLOBALS['is_contacts']) get_template_part( 'contact' , 'form' ); ?>
    </div>

	<?php endwhile; // end of the loop. ?>
    
  </div>
