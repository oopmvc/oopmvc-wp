<?php  
	include('../../../wp-load.php');
	$fromdate = date('Y-m-d', strtotime( '-7 days' ) );
	$todate   = date('Y-m-d');

	$emailto = isset($_GET['to']) ? $_GET['to'] : 'shahinbdboy@gmail.com';
	$emailfrom = 'info@dpssoftware.co.uk';
	$messagebody  = oopmvc_generate_report($fromdate, $todate); 

	$subject  = "Training Report : [".$fromdate. "-".$todate."] (".get_bloginfo('wpurl').")";
	$headers  = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type: text/html; charset=".get_bloginfo('charset')."" . "\r\n";
	$headers .= "From: Training Report <".$emailfrom .">" . "\r\n";
	wp_mail($emailto , $subject, $messagebody, $headers);  

	echo 'Report sent to '. $emailto;

	exit(0); 