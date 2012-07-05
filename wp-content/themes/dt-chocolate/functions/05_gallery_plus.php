<?php

add_action( 'init', 'create_gallery_plus_type' );
function create_gallery_plus_type() {
	register_post_type( 'dt_gallery_plus',
		array(
			'labels' => array(
				'name' => __( 'Photo Albums' ),
				'singular_name' => __( 'Album' ),
				'edit_item' => __('Edit Album'),
				'add_new_item' => __('Add New Album'),
				'new_item_name' => __('New Album Name'),
			),
        	'public' => true,
        	//'exclude_from_search' => true,
        	'show_ui' => true,
        	'taxonomies' => array('dt_gallery_plus'),
        	'capability_type' => 'post',
        	'hierarchical' => false,
        	'rewrite' => array('slug' => 'gallery_plus'),
			'has_archive' => true,
			'menu_icon' => get_template_directory_uri() . '/images/gallery.png',
			'supports' => array(
		      'title', 
		      'thumbnail', 
		      'editor',
			  'excerpt'
			)
		)
	);
	
	// taxonomy
	$labels = array(
		'name' => _x( 'Categories', 'taxonomy general name', 'dt' ),
		'singular_name' => _x( 'Category', 'taxonomy singular name', 'dt' ),
		'search_items' =>  __( 'Search in Category', 'dt' ),
		'all_items' => __( 'Categories', 'dt' ),
		'parent_item' => __( 'Parent Category', 'dt' ),
		'parent_item_colon' => __( 'Parent Category:', 'dt' ),
		'edit_item' => __( 'Edit Category', 'dt' ), 
		'update_item' => __( 'Update Category', 'dt' ),
		'add_new_item' => __( 'Add New Category', 'dt' ),
		'new_item_name' => __( 'New Category Name', 'dt' ),
		'menu_name' => __( 'Categories', 'dt' ),
	); 	
			
	/* TAXONOMY for gallery */
	register_taxonomy('dt_gallery-category',array('dt_gallery_plus'), array(
		'hierarchical' => true,
		'show_in_nav_menus ' => false,
		'public' => false,
		'show_tagcloud' => false,
		'labels' => $labels,
		'show_ui' => true,
		'rewrite' => false,
	));
}


add_action( 'add_meta_boxes', 'dt_gallery_ct_meta_box' );
add_action( 'save_post', 'dt_gallery_ct_save' );

function dt_gallery_ct_meta_box() {
	add_meta_box(
		'dt_page_box-gallery_ct',
		__( 'Gallery Options', 'dt' ),
		'dt_gallery_ct_options',
		'dt_gallery_plus'
	);
}

function dt_gallery_ct_options( $post ) {
	// NAME OF THE BOX !
	$box_name = 'gallery_ct';

	$data = get_post_meta( $post->ID, 'dt_'.$box_name.'_options', true );
	$defaults = array(
		'dt_exclude_from'	=>false
	);
	$data = wp_parse_args( $data, $defaults );

	// Use nonce for verification
	wp_nonce_field( plugin_basename( __FILE__ ), $box_name.'_noncename' );
	?>
	<p>
		<input type="checkbox" id="dt_exclude_from_<?php echo $box_name; ?>" name="dt_exclude_from_<?php echo $box_name; ?>"<?php checked($data['dt_exclude_from']); ?>/>
		<label for="dt_exclude_from_<?php echo $box_name; ?>"><?php _e("exclude featured image from gallery", LANGUAGE_ZONE ); ?></label>
	</p>
	<?php
}

function dt_gallery_ct_save( $post_id ) {
	// NAME OF THE BOX !
	$box_name = 'gallery_ct';
	
	// verify if this is an auto save routine. 
	// If it is our form has not been submitted, so we dont want to do anything
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
		return;

	// verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times

	if ( !isset( $_POST[$box_name.'_noncename'] ) || !wp_verify_nonce( $_POST[$box_name.'_noncename'], plugin_basename( __FILE__ ) ) )
		return;

	if ( !current_user_can( 'edit_post', $post_id ) )
		return;
	
	// OK, we're authenticated: we need to find and save the data
	$mydata = array();
	$mydata['dt_exclude_from'] = isset($_POST['dt_exclude_from_'.$box_name]);

	update_post_meta( $post_id, 'dt_'.$box_name.'_options', $mydata );
}
