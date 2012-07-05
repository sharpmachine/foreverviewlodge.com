  <div id="content">
    <div id="multicol">

<?php

global $postportfolio;
$posts_pp = $postportfolio->get_post_option('portf_3p');
$show = $postportfolio->get_post_option('show');
$arr = $postportfolio->get_post_option('show_'.$show);
$arr = explode(",", $arr);
$arr = (array)$arr;

//$myterms = get_terms('dt_portfolio_cat');

global $term, $h;

$paged = intval(get_query_var('paged'));

$args = array(
	"post_type"		=>"dt_portfolio",
	"paged"			=>$paged
);

if( !empty($posts_pp) ) {
	$args['posts_per_page'] = $posts_pp;
}

if( !empty($arr) ) {
	$args['tax_query'] = array(	
		array(
			'taxonomy'	=>'dt_portfolio_cat',
			'field'		=>'id',
			'terms'		=>$arr,
			'operator' 	=> ( 'only' == $show )?'IN':'NOT IN',
		)
	);
}

//query_posts("post_type=dt_portfolio&dt_portfolio_cat=".implode(",", $slugs).'&paged='.$paged.'&orderby=date&order=DESC'.$posts_pp);
query_posts( $args );
get_template_part('portfolio-album-display');

?>

   </div>
   
   <?php
   
   ?>
   
<?php if ( 1 ) : ?>
<?php if (function_exists('dt_pagenavi') ) { ?>
	<?php dt_pagenavi(); ?>
	<?php } else { ?>
        
    <ul class="paginator">
      <li class="larr"><?php next_posts_link( __( 'Older posts', 'dt' ) ); ?></div>
      <div class="rarr"><?php previous_posts_link( __( 'Newer posts', 'dt' ) ); ?></div>
    </ul>
    
    <?php } ?>
<?php endif; ?>
   
  </div>
