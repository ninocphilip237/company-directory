<?php
include './PhpMailerClass/class.smtp.php';
include_once './PhpMailerClass/class.phpmailer.php';
require_once 'connection.php';
date_default_timezone_set('Asia/Kolkata');



				$mail          = new PHPMailer;
                $mail->CharSet = "UTF-8";
                $mail->IsSMTP(); // enable SMTP
                //$mail->SMTPDebug = 2; // debugging: 1 = errors and messages, 2 = messages only
                $mail->SMTPAuth   = true; // authentication enabled
                $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
                $mail->Host       = "smtp.gmail.com";
                $mail->Port       = 465; // or 587
                $mail->IsHTML(true);
                $mail->Username = 'test@gmail.com'; // SMTP username
                $mail->Password = '12345'; // SMTP password
                $mail->setFrom('kilamailtest@gmail.com', 'TEST');
                $mail->addReplyTo('kilamailtest@gmail.com', 'TEST');
				$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
	
                
                // $to = '';
				// $mail->ClearAddresses();  // each AddAddress add to list
				// $mail->ClearCCs();
				// $mail->ClearBCCs();
       
                //Mail Text
                    $mailtext = $mailtext . '<p> This is test </p>';
                
                    $mail->addReplyTo($user_p_mail, $user_name); // sends Reply to the User Logined
                       
                    $mail->addCC($addrcc); // Add cc
                    $mail->addBCC($addrbcc); // Add Bcc
                    $mail->addAddress('example@mail.com'); // mail address
                    //adding attachment
                    //$mail->addAttachment('./dayreport_formail/attendancereport.pdf');    // Optional name
                    //setting email subject
                    $mail->Subject = $subject;
                    //setting email body content 
                    $mail->Body    = $mailtext;
                    if (!$mail->send()) {
                        echo 'Message could not be sent.';
                        echo 'Mailer Error: ' . $mail->ErrorInfo;
                    }
  
?>
