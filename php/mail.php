<?php

// only if our POST values are set
if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message'])){
	
	/**
	 * Store results to DB
	 */
	
	$name = mysql_real_escape_string($_POST['name']);
	$email = mysql_real_escape_string($_POST['email']);
	$message = mysql_real_escape_string($_POST['message']);
	$now = date('Y-m-d g:ia');

	$link = mysql_connect('localhost', 'root', 'root');
	if($link){
		mysql_select_db('sw_portfolio', $link);
		$query = "INSERT INTO contact_messages (name, email, message) VALUES ('$name', '$email', '$message')";
		if(mysql_query($query, $link)){
			echo 'success';
		}else{
			echo mysql_error();
		}
	}
	
	/**
	 * Send the email
	 */

	require('class.phpmailer.php');

	$mail = new PHPMailer();
	
	$mail->IsSMTP();
	$mail->Host = "smtp.gmail.com";
	$mail->SMTPSecure = 'ssl';
	$mail->SMTPAuth = true;
	$mail->Port = 465;
	$mail->Username = "mail@bxcreative.com";
	$mail->Password = "mail!2012";

	// $mail->From = "from@example.com";
	$mail->FromName = "Steven Wanderski";
	$mail->AddAddress("steven@bxcreative.com", "Steven Wanderski");
	$mail->IsHTML(true);

	$mail->Subject = "New message from stevenwanderski.com";
	$mail->Body    = "
<h2>New message from stevenwanderski.com!</h2>
<p><b>Message</b>:<br/>$message</p>
<p><b>Name</b>: $name</p>
<p><b>Email</b>: $email</p>
<p><b>Date</b>: $now</p>
===============================================<br><br>
<small>Rock n roll.</small>
";

	$mail->Send();

}

?>