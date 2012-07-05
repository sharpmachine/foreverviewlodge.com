<?php

/*

Plugin Name: WebReserv Embedded Booking Calendar

Plugin URI: http://blog.webreserv.eu/webreserv-booking-plugins-for-wordpress/

Description: The WebReserv Embedded Booking Calendar plugin lets you embed the WebReserv booking component directly in any PAGE or POST. The installation includes the code for a demo account so you can see how it works without a WebReserv account. Works for nearly any type of business, RV or Car Rentals, property rentals, B&B, meeting rooms etc. Remember to create a free WebReserv account to try it out with your bookable product. 

Version: 3

Author: Mishel Naguib

Author URI: http://applicationsbook.com

 */

/*  Copyright 2011 Mishel Naguib (email : admin@applicationsbook.com)
 */

register_activation_hook(__FILE__,'WebReserv_install'); 
register_deactivation_hook( __FILE__, 'WebReserv_remove' );
add_filter('the_content','webreserv_insert');

$url =  'wp-content/plugins/WebReserv/';
 		  
//////////////////////////////////

function webreserv_insert($content)
{
  if (preg_match('{WEBRESERV}',$content))
    {
    $content = str_replace('{WEBRESERV}',webreserv(),$content);
    }
  return $content;
}
function webreserv()
{
   global  $userdata, $table_prefix, $wpdb, $webreserv_installed;
   get_currentuserinfo();
   $str='';
 $webreserv_code = get_option('webreserv_code');
    $str.='<div class="wrap">';

$str.='<center>';
$str.='<div id="CalendarDiv">';
$str.=  $webreserv_code;
$str.='</div>';
$str.='</center>';
$str.='</div>';
return $str;
}
////////////////////////

if ( is_admin() ){

/* Call the html code */
add_action('admin_menu', 'WebReserv_admin');

function WebReserv_admin() {
add_options_page('WebReserv', 'WebReserv', 'administrator',
'WebReserv', 'WebReserv_html_page');
}
}

function WebReserv_html_page() {
$url =  '../wp-content/plugins/WebReserv';
?>
<h2>WebReserv Options</h2>

<form method="post" action="options.php">
<?php wp_nonce_field('update-options'); ?>
<table width="95%" border="0" cellspacing="5" cellpadding="5">
  <tr>
    <td valign="top"><textarea name="webreserv_code" id="webreserv_code" cols="35" rows="6"><?php echo get_option('webreserv_code'); ?></textarea><br /><input type="submit" value="<?php _e('Save Changes') ?>" />
<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="webreserv_code" /></td>
    <td width="25%" valign="top"><b>1 -Enter your WebReserv Calendar Code</b><br>
      Paste the code in from the WebReserv Back Office.<br>
        <a href="http://www.webreserv.com/adding-the-booking-calendar-to-your-website.do" target="_new">How to create the WebReserv code in the WebReserv Back Office for the WebReserv Embedded Booking Calendar.</a><br>
        <i>Remember to press SAVE.</i><p></p><a href ="http://www.webreserv.eu/login.do" target="_blank" class="button">&nbsp;&nbsp;Log Into WebReserv.EU Back Office&nbsp;&nbsp;</a><p></p><a href ="http://www.webreserv.com/login.do" target="_blank" class="button">&nbsp;&nbsp;Log Into WebReserv.COM Back Office&nbsp;&nbsp;</a></td>
    <td width="25%" valign="top"><b>2 - Add the {WEBRESERV} code.<br>
    </b>Now insert the code <b>{WEBRESERV}</b> on any POST or PAGE.<br>
        Remember you can set the height and width in the code above.</td>
    <td width="25%" rowspan="3" valign="top"><b>3 -Now use the Back Office to Manage Bookings</b><br />      Your Wordpress website is now configured with the WebReserv Booking Component.<br>
        Log into the WebReserv Back Office to :<br>
        - Configure bookable Products<br>
        - Set-up rates<br>
        - Manage Bookings (Both online and manual)<br>
        - See Reports<br>
        - Etc</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
    </tr>
</table>
</form>

<div style="margin-bottom:20px;"><h2>WebReserv Embedded Booking Calendar</h2></div>

	<div>

	<div style="float:left;">
	<b>Example Booking Component Screenshots</b><br>
	<a href="http://tasks.webreserv.eu/webreserv_screenshots/show_large_screenshot.html?image=accomodation_9_large.PNG" target="_blank"><img src="<?php echo $url; ?>/accomodation_9_small.PNG" border="0" /></a>&nbsp;&nbsp;
     	<a href="http://tasks.webreserv.eu/webreserv_screenshots/show_large_screenshot.html?image=accomodation_5_large.PNG" target="_blank"><img src="<?php echo $url; ?>/accomodation_5_small.PNG" border="0" /></a>&nbsp;&nbsp;
	<a href="http://tasks.webreserv.eu/webreserv_screenshots/show_large_screenshot.html?image=boat_hire_3_large.PNG" target="_blank"><img src="<?php echo $url; ?>/boat_hire_3_small.PNG" border="0" /></a><br>
	<br>
	<b>Back-Office Screenshots</b><br>
	<a href="http://tasks.webreserv.eu/webreserv_screenshots/show_large_screenshot.html?image=navigation_1_large.PNG" target="_blank"><img src="<?php echo $url; ?>/navigation_1_small.PNG" border="0" /></a>&nbsp;&nbsp;
     	<a href="http://tasks.webreserv.eu/webreserv_screenshots/show_large_screenshot.html?image=bookings_overview_1_large.PNG" target="_blank"><img src="<?php echo $url; ?>/bookings_overview_1_small.PNG" border="0" /></a>&nbsp;&nbsp;
	<a href="http://tasks.webreserv.eu/webreserv_screenshots/show_large_screenshot.html?image=bookings_overview_2_large.PNG" target="_blank"><img src="<?php echo $url; ?>/bookings_overview_2_small.PNG" border="0" /></a><br>
	<br>
	<a href="http://tasks.webreserv.eu/webreserv_screenshots/show_large_screenshot.html?image=reports_1_large.PNG" target="_blank"><img src="<?php echo $url; ?>/reports_1_small.PNG" border="0" /></a>&nbsp;&nbsp;
     	<a href="http://tasks.webreserv.eu/webreserv_screenshots/show_large_screenshot.html?image=widget_1_large.PNG" target="_blank"><img src="<?php echo $url; ?>/widget_1_small.PNG" border="0" /></a>&nbsp;&nbsp;
	<a href="http://tasks.webreserv.eu/webreserv_screenshots/show_large_screenshot.html?image=help_1_large.PNG" target="_blank"><img src="<?php echo $url; ?>/help_1_small.PNG" border="0" /></a>


	<br />


	<span style="float:left;width:400px;padding-left:0px;">
<hr>
<strong>Sign Up for a WebReserv Account</strong><br>
<p style="font-size:10px;">Create a FREE account on either WebReserv .EU or .COM</p>
<b>Sign Up for a WebReserv.EU Account</b><br>
<p style="font-size:10px;">If your business is located in Europe (Not just EU, but any country in Europe), then you can sign up for a WebReserv.EU account.<br>
<a href ="http://www.webreserv.eu/signup.do" target="_new">Click here to create a <b>.EU</b> account</a></p>
<b>Sign Up for a WebReserv.COM Account</b><br>
<p style="font-size:10px;">If your business is located in any other country in the world, then you can sign up for a WebReserv.COM account.<br>
<a href ="http://www.webreserv.com/signup.do?referralID=x1013" target="_new">Click here to create a <b>.COM</b> account</a></p>

	<br />

	</span>
</div>	
<?php
}
function WebReserv_install() {
/* Creates new database field */
add_option("webreserv_code", '<iframe src=http://www.webreserv.eu/services/bookonline.do?businessid=bobsboatdemogb&embedded=y&list=n width=700px height=500px scrolling=auto frameborder=0></iframe>', '', 'yes');
}

function WebReserv_remove() {
/* Deletes the database field */
delete_option("webreserv_code");
}

