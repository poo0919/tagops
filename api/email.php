<?php
require_once('vendor/autoload.php');

function send_email($to,$cc,$subject,$body){
	//$mail->SMTPDebug = 3;                               // Enable verbose debug output
	$mail = new PHPMailer;

	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'smtp.eazespot.com';  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = 'noreply@tagbin.in';                 // SMTP username
	$mail->Password = 'db3d81c1-d047-4f28-8349-a5a1788909a3';                           // SMTP password
	$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = 587;                                    // TCP port to connect to

	$mail->setFrom('noreply@tagbin.in', 'TagOps');
	$mail->addAddress($to);
	//$mail->addAddress($cc);
	//$mail->addAddress($to, 'Tagbin');
	// Add a recipient
	// $mail->addAddress('ellen@example.com');               // Name is optional
	// $mail->addReplyTo('info@example.com', 'Information');
	 $mail->addCC($cc);
	// $mail->addCC('cc@example.com');
	// $mail->addBCC('bcc@example.com');

	//$mail->addAttachment('composer.json');         // Add attachments
	//$mail->addAttachment($attachmentURL, 'final.gif');    // Optional name
	$mail->isHTML(true);                                  // Set email format to HTML

	$mail->Subject = $subject;
	$mail->Body    = $body;
	$mail->AltBody = $body;

	if(!$mail->send()) {
		//header('Content-Type: application/json');
		$dataArray =array( 
	        "success" => false,
	        "message" => "Message could not be sent.",
	        "error" => "Mailer Error: " . $mail->ErrorInfo,
	    );
	    	//echo json_encode($dataArray);

	    	return $dataArray;

	    //echo 'Message could not be sent.';
	    //echo 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
	    //echo 'Message has been sent';
	    //header('Content-Type: application/json');
		$dataArray =array( 
	        "success" => true,
	        "message" => "Message has been sent.",
	        "error" => "Mailer Error: " . $mail->ErrorInfo,
	    );
	    	//echo json_encode($dataArray);
	    	return $dataArray;
	}
}
?>