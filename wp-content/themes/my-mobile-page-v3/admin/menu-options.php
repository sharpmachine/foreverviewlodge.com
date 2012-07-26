<?php
/*---------------------MENU SETTINGS--------------------*/
function com_save_metaa($postId)
{
	
	if(isset($_POST['menu_item_url']) )
    {
    	update_post_meta($postId, 'menu_item_url', $_POST['menu_item_url']);  
    }
}
add_action('save_post', 'com_save_metaa');

function com_post_metaa()
{
    if(isset($_REQUEST['post']) && is_numeric($_REQUEST['post']))
    {
        $post = (int)$_REQUEST['post'];
        $post = get_post($post);
		
		$menu_item_url = get_post_meta($post->ID, 'menu_item_url', true);		
    }

?>
    <div style="padding:10px;float:left;">
         <label style="width:200px; float: left; padding-top:6px;">Link URL</label>
         <div style="float:left;">
         <input type="text" name="menu_item_url" style="width:300px" value="<?php echo $menu_item_url; ?>" />
         <em style="padding:5px 0px; display:block;">Link URL</em>
         </div>
    </div>
    <div class="clear"></div> 
    
<?php
}
function com_register_meta_boxx()
{
    add_meta_box('custom_metaa', __('Menu Options'), 'com_post_metaa', 'icons_menu', 'normal', 'high');
}
add_action('admin_init', 'com_register_meta_boxx');

?>