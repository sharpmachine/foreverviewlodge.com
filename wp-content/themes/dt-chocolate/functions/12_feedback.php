<?php
if(isset($_POST['send_contacts'])) {
	if( "send_f" !== $_POST["send_f"] ) {
		$ret='are you real?';
	}else {
		$em=get_settings('admin_email');
		//$em="josh@foreverviewlodge.com";
		wp_mail($em, 'Feedback', "Someone wrote this to you:
Name: ".$_POST["f_name"]."
Email: ".$_POST["f_email"]."
Comment:
".$_POST["f_comment"]."
");
		$ret="Your email has been sent to the Forever View Lodge Staff.  Thank you!";
	}
	echo $ret; exit;
}
