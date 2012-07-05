<?php
/**
 * @package WordPress
 * @subpackage @subpackage Chocolate
 */

function sakura_page_menu_args( $args ) {
	$args['show_home']	= true;
	$args['menu_class']		= 'nav';
	return $args;
}
add_filter( 'wp_page_menu_args', 'sakura_page_menu_args' );

wp_nav_menu( array( 'theme_location' => 'primary' , 'container' => 'div' , 'container_class' => 'nav' , 'depth' => '3' , 'fallback_cb' => 'wp_page_menu' ) );

?>
